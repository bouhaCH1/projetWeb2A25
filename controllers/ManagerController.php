<?php
require_once __DIR__ . '/../models/repositories/FormationRepository.php';
require_once __DIR__ . '/../models/repositories/TacheRepository.php';
require_once __DIR__ . '/../models/repositories/ParticipantRepository.php';
require_once __DIR__ . '/../models/repositories/CommentaireRepository.php';
require_once __DIR__ . '/../models/services/EmailService.php';
require_once __DIR__ . '/../models/services/TranslationService.php';
require_once __DIR__ . '/../models/services/WeatherService.php';
require_once __DIR__ . '/../models/services/Paginator.php';
require_once __DIR__ . '/../models/services/GeminiService.php';
require_once __DIR__ . '/../models/services/OpenAIService.php';
require_once __DIR__ . '/../models/services/BadWordsService.php';

class ManagerController {
    private FormationRepository $fm;
    private TacheRepository $tm;
    private ParticipantRepository $pm;
    private CommentaireRepository $cm;
    private EmailService $mailer;
    private TranslationService $translator;
    private int $uid;

    public function __construct() {
        $this->fm         = new FormationRepository();
        $this->tm         = new TacheRepository();
        $this->pm         = new ParticipantRepository();
        $this->cm         = new CommentaireRepository();
        $this->mailer     = new EmailService();
        $this->translator = new TranslationService();
        $this->uid        = (int)$_SESSION['user_id'];
    }

    public function handle(string $action): void {
        match($action) {
            'dashboard'          => $this->dashboard(),
            'formations'         => $this->formations(),
            'formation_add'      => $this->formationAdd(),
            'formation_edit'     => $this->formationEdit(),
            'formation_delete'   => $this->formationDelete(),
            'participants'       => $this->participants(),
            'participant_add'    => $this->participantAdd(),
            'participant_remove' => $this->participantRemove(),
            'taches'             => $this->taches(),
            'tache_add'          => $this->tacheAdd(),
            'tache_edit'         => $this->tacheEdit(),
            'tache_delete'       => $this->tacheDelete(),
            'comment_add'        => $this->commentAdd(),
            'comment_delete'     => $this->commentDelete(),
            'translate'          => $this->translateAction(),
            'ai_describe'        => $this->aiDescribe(),
            default              => $this->dashboard(),
        };
    }

    // ─── Dashboard ────────────────────────────────────────────────────────
    private function dashboard(): void {
        $formations      = $this->fm->getByManager($this->uid);
        $nbFormations    = count($formations);
        $nbParticipants  = array_sum(array_column($formations, 'nb_participants'));
        $nbTaches        = array_sum(array_column($formations, 'nb_taches'));
        $statsNiveau     = $this->fm->statsByNiveau($this->uid);
        $statsStatut     = $this->tm->statsByStatut($this->uid);
        $weather         = (new WeatherService())->current();
        $this->render('manager/dashboard', compact('formations','nbFormations','nbParticipants','nbTaches','statsNiveau','statsStatut','weather'));
    }

    // ─── Formations (paginee) ─────────────────────────────────────────────
    private function formations(): void {
        $filters = [
            'q'      => trim((string)($_GET['q'] ?? '')),
            'niveau' => trim((string)($_GET['niveau'] ?? '')),
            'lieu'   => trim((string)($_GET['lieu'] ?? '')),
        ];
        $page      = max(1, (int)($_GET['page'] ?? 1));
        $perPage   = 4;
        $total     = $this->fm->countByManagerFiltered($this->uid, $filters);
        $paginator = new Paginator($total, $perPage, $page);
        $formations = $this->fm->getByManagerPagedFiltered($this->uid, $paginator->getLimit(), $paginator->getOffset(), $filters);
        $this->render('manager/formations_list', compact('formations','paginator','filters'));
    }

    // ─── IA (Gemini / OpenAI) : generation de description ───────────────
    private function aiDescribe(): void {
        header('Content-Type: application/json; charset=utf-8');
        try {
            $titre  = trim($_POST['titre']  ?? '');
            $niveau = $_POST['niveau']      ?? 'debutant';
            $lieu   = trim($_POST['lieu']   ?? '');
            if (!$titre) { echo json_encode(['error'=>'Titre requis']); exit; }

            $cfg      = is_file(__DIR__ . '/../config/api.php') ? require __DIR__ . '/../config/api.php' : [];
            $pref     = $cfg['ai']['provider'] ?? 'auto';
            $gemini   = new GeminiService();
            $openai   = new OpenAIService();
            $desc     = '';
            $provider = null;
            $iaError   = '';

            if ($pref === 'gemini') {
                $desc = $gemini->genererDescriptionFormation($titre, $niveau, $lieu);
                $provider = $gemini->isConfigured() ? 'gemini' : null;
                if ($provider && $gemini->getLastError() !== '') {
                    $iaError = $gemini->getLastError();
                }
            } elseif ($pref === 'openai') {
                $desc = $openai->genererDescriptionFormation($titre, $niveau, $lieu);
                $provider = $openai->isConfigured() ? 'openai' : null;
            } else {
                if ($gemini->isConfigured()) {
                    $desc     = $gemini->genererDescriptionFormation($titre, $niveau, $lieu);
                    $provider = 'gemini';
                    if ($gemini->getLastError() !== '') {
                        $iaError = $gemini->getLastError();
                    }
                } elseif ($openai->isConfigured()) {
                    $desc     = $openai->genererDescriptionFormation($titre, $niveau, $lieu);
                    $provider = 'openai';
                } else {
                    $desc = $openai->genererDescriptionFormation($titre, $niveau, $lieu);
                }
            }

            $configured = $provider !== null;
            echo json_encode([
                'description' => $desc,
                'configured'    => $configured,
                'provider'      => $provider,
                'ia_error'      => $iaError !== '' ? $iaError : null,
            ], JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $e) {
            echo json_encode(['error' => 'Serveur: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }

    private function formationAdd(): void {
        $errors = [];
        $d = ['titre'=>'','description'=>'','lieu'=>'','niveau'=>'debutant','capacite_max'=>'','dateDebut'=>'','dateFin'=>''];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $d = [
                'titre'       => trim($_POST['titre']        ?? ''),
                'description' => trim($_POST['description']  ?? ''),
                'lieu'        => trim($_POST['lieu']         ?? ''),
                'niveau'      => $_POST['niveau']            ?? 'debutant',
                'capacite_max'=> trim($_POST['capacite_max'] ?? ''),
                'dateDebut'   => $_POST['date_debut']        ?? '',
                'dateFin'     => $_POST['date_fin']          ?? '',
            ];
            $errors = $this->validateFormation($d);
            if (!$errors) {
                $cap       = ($d['capacite_max'] === '') ? 0 : (int)$d['capacite_max'];
                if (!array_key_exists($d['niveau'], Formation::NIVEAUX)) $d['niveau'] = 'debutant';
                $imagePath = $this->handleUpload('image', 'formations');
                $videoPath = $this->handleVideoUpload('video', 'formations');
                $id = $this->fm->create(
                    $d['titre'],$d['description'],$d['lieu'],$d['niveau'],
                    $cap,$d['dateDebut'],$d['dateFin'],$this->uid,
                    $imagePath, $videoPath
                );
                // Envoyer email notification
                $formation = $this->fm->getById($id);
                if ($formation) {
                    $this->mailer->sendFormationCreee(
                        $formation,
                        $formation['mgr_email'],
                        $formation['mgr_prenom'] . ' ' . $formation['mgr_nom']
                    );
                }
                $this->redirect('formations', 'Formation creee avec succes.');
                return;
            }
        }
        $this->render('manager/formation_form', ['errors'=>$errors,'edit'=>false] + $d);
    }

    private function formationEdit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $f  = $this->fm->getById($id);
        if (!$f || (int)$f['manager_id'] !== $this->uid) { $this->redirect('formations', null, 'Acces refuse.'); return; }
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $d = [
                'titre'       => trim($_POST['titre']        ?? ''),
                'description' => trim($_POST['description']  ?? ''),
                'lieu'        => trim($_POST['lieu']         ?? ''),
                'niveau'      => $_POST['niveau']            ?? 'debutant',
                'capacite_max'=> trim($_POST['capacite_max'] ?? ''),
                'dateDebut'   => $_POST['date_debut']        ?? '',
                'dateFin'     => $_POST['date_fin']          ?? '',
            ];
            $errors = $this->validateFormation($d);
            if (!$errors) {
                $cap       = ($d['capacite_max'] === '') ? 0 : (int)$d['capacite_max'];
                $imagePath = $this->handleUpload('image', 'formations');
                $videoPath = $this->handleVideoUpload('video', 'formations');
                $this->fm->update(
                    $id,$d['titre'],$d['description'],$d['lieu'],$d['niveau'],
                    $cap,$d['dateDebut'],$d['dateFin'],
                    $imagePath, $videoPath
                );
                $this->redirect('formations', 'Formation mise a jour.');
                return;
            }
        } else {
            $d = [
                'titre'=>$f['titre'],'description'=>$f['description'],'lieu'=>$f['lieu'],
                'niveau'=>$f['niveau'],'capacite_max'=>$f['capacite_max'],
                'dateDebut'=>$f['date_debut'],'dateFin'=>$f['date_fin'],
                'video_path'=>$f['video_url'] ?? '',
            ];
        }
        $this->render('manager/formation_form', ['errors'=>$errors,'edit'=>true,'formation_id'=>$id,'formation'=>$f] + $d);
    }

    private function formationDelete(): void {
        $id = (int)($_GET['id'] ?? 0);
        $f  = $this->fm->getById($id);
        if ($f && (int)$f['manager_id'] === $this->uid) {
            if ($f['image_path']) @unlink(__DIR__ . '/../vues/public/' . $f['image_path']);
            if ($f['video_url'])  @unlink(__DIR__ . '/../vues/public/' . $f['video_url']);
            $this->fm->delete($id);
            $this->redirect('formations','Formation supprimee.');
        } else {
            $this->redirect('formations', null, 'Acces refuse.');
        }
    }

    private function validateFormation(array $d): array {
        $e = [];
        if (!$d['titre'])     $e[] = 'Le titre est obligatoire.';
        if (!$d['dateDebut']) $e[] = 'La date de debut est obligatoire.';
        if (!$d['dateFin'])   $e[] = 'La date de fin est obligatoire.';
        if ($d['dateDebut'] && $d['dateFin'] && $d['dateFin'] < $d['dateDebut'])
            $e[] = 'La date de fin doit etre apres la date de debut.';
        if ($d['capacite_max'] !== '' && (!is_numeric($d['capacite_max']) || (int)$d['capacite_max'] < 0))
            $e[] = 'La capacite doit etre un nombre positif (0 = illimite).';
        return $e;
    }

    // ─── Participants ─────────────────────────────────────────────────────
    private function participants(): void {
        $fid = (int)($_GET['formation_id'] ?? 0);
        $f   = $this->fm->getById($fid);
        if (!$f || (int)$f['manager_id'] !== $this->uid) { $this->redirect('formations', null, 'Acces refuse.'); return; }
        $participants = $this->pm->getByFormation($fid);
        $allClients   = $this->pm->getAllClients();
        $formationId  = $fid;
        $errors       = [];
        $this->render('manager/participants', compact('participants','allClients','formationId','errors') + ['formation'=>$f]);
    }

    private function participantAdd(): void {
        $fid = (int)($_GET['formation_id'] ?? 0);
        $f   = $this->fm->getById($fid);
        if (!$f || (int)$f['manager_id'] !== $this->uid) { $this->redirect('formations'); return; }
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $type = $_POST['type'] ?? 'id';
            if ($type === 'id') {
                $cid = (int)($_POST['client_id'] ?? 0);
                if (!$cid) $errors[] = 'Veuillez selectionner un client.';
                elseif (!$this->pm->addById($fid, $cid)) $errors[] = 'Ce client est deja inscrit.';
            } else {
                $nom    = trim($_POST['nom']      ?? '');
                $prenom = trim($_POST['prenom']   ?? '');
                $email  = trim($_POST['email']    ?? '');
                $pass   = trim($_POST['password'] ?? '');
                if (!$nom)    $errors[] = 'Le nom est obligatoire.';
                if (!$prenom) $errors[] = 'Le prenom est obligatoire.';
                if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email invalide.';
                if (!$pass || strlen($pass) < 6) $errors[] = 'Mot de passe minimum 6 caracteres.';
                if (!$errors) $this->pm->addManual($fid, $nom, $prenom, $email, $pass);
            }
        }
        if ($errors) {
            $participants = $this->pm->getByFormation($fid);
            $allClients   = $this->pm->getAllClients();
            $formationId  = $fid;
            $this->render('manager/participants', compact('participants','allClients','formationId','errors') + ['formation'=>$f]);
            return;
        }
        $this->redirect('participants', 'Participant ajoute.', null, ['formation_id'=>$fid]);
    }

    private function participantRemove(): void {
        $pid = (int)($_GET['id']           ?? 0);
        $fid = (int)($_GET['formation_id'] ?? 0);
        $this->pm->remove($pid);
        $this->redirect('participants', 'Participant retire.', null, ['formation_id'=>$fid]);
    }

    // ─── Taches ───────────────────────────────────────────────────────────
    private function taches(): void {
        $fid = (int)($_GET['formation_id'] ?? 0);
        $f   = $this->fm->getById($fid);
        if (!$f || (int)$f['manager_id'] !== $this->uid) { $this->redirect('formations', null, 'Acces refuse.'); return; }
        $taches      = $this->tm->getByFormationWithStatuts($fid);
        $formationId = $fid;
        $this->render('manager/taches_list', compact('taches','formationId') + ['formation'=>$f]);
    }

    private function tacheAdd(): void {
        $fid = (int)($_GET['formation_id'] ?? 0);
        $f   = $this->fm->getById($fid);
        if (!$f || (int)$f['manager_id'] !== $this->uid) { $this->redirect('formations'); return; }
        $errors = [];
        $d = ['titre'=>'','description'=>'','duree'=>'','dateDebut'=>'','dateFin'=>''];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $d = [
                'titre'       => trim($_POST['titre']       ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'duree'       => trim($_POST['duree']       ?? ''),
                'dateDebut'   => $_POST['date_debut']       ?? '',
                'dateFin'     => $_POST['date_fin']         ?? '',
            ];
            $errors = $this->validateTache($d);
            if (!$errors) {
                $imagePath = $this->handleUpload('image', 'taches');
                $videoPath = $this->handleVideoUpload('video', 'taches');
                $tid = $this->tm->create(
                    $fid, $d['titre'], $d['description'], (int)$d['duree'],
                    $d['dateDebut'], $d['dateFin'],
                    $imagePath, $videoPath
                );
                // Notification email aux participants
                $tache    = $this->tm->getById($tid);
                $clients  = $this->pm->getByFormation($fid);
                foreach ($clients as $c) {
                    $this->mailer->sendTacheAjoutee($tache, $f, $c['email'], $c['prenom'].' '.$c['nom']);
                }
                $this->redirect('taches', 'Tache ajoutee avec succes.', null, ['formation_id'=>$fid]);
                return;
            }
        }
        $this->render('manager/tache_form', ['errors'=>$errors,'edit'=>false,'formationId'=>$fid,'formation'=>$f] + $d);
    }

    private function tacheEdit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $t  = $this->tm->getById($id);
        if (!$t) { $this->redirect('formations'); return; }
        $fid = (int)$t['formation_id'];
        $f   = $this->fm->getById($fid);
        if (!$f || (int)$f['manager_id'] !== $this->uid) { $this->redirect('formations', null, 'Acces refuse.'); return; }
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $d = [
                'titre'       => trim($_POST['titre']       ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'duree'       => trim($_POST['duree']       ?? ''),
                'dateDebut'   => $_POST['date_debut']       ?? '',
                'dateFin'     => $_POST['date_fin']         ?? '',
            ];
            $errors = $this->validateTache($d);
            if (!$errors) {
                $imagePath = $this->handleUpload('image', 'taches');
                $videoPath = $this->handleVideoUpload('video', 'taches');
                $this->tm->update(
                    $id, $d['titre'], $d['description'], (int)$d['duree'],
                    $d['dateDebut'], $d['dateFin'],
                    $imagePath, $videoPath
                );
                $this->redirect('taches', 'Tache mise a jour.', null, ['formation_id'=>$fid]);
                return;
            }
        } else {
            $d = [
                'titre'=>$t['titre'],'description'=>$t['description'],'duree'=>$t['duree'],
                'dateDebut'=>$t['date_debut'],'dateFin'=>$t['date_fin'],
                'video_path'=>$t['video_url'] ?? '',
            ];
        }
        $this->render('manager/tache_form', ['errors'=>$errors,'edit'=>true,'tache_id'=>$id,'formationId'=>$fid,'formation'=>$f,'tache'=>$t] + $d);
    }

    private function tacheDelete(): void {
        $id  = (int)($_GET['id'] ?? 0);
        $t   = $this->tm->getById($id);
        $fid = $t ? (int)$t['formation_id'] : 0;
        $f   = $fid ? $this->fm->getById($fid) : null;
        if ($t && $f && (int)$f['manager_id'] === $this->uid) {
            if ($t['image_path']) @unlink(__DIR__ . '/../vues/public/' . $t['image_path']);
            if ($t['video_url'])  @unlink(__DIR__ . '/../vues/public/' . $t['video_url']);
            $this->tm->delete($id);
            $this->redirect('taches', 'Tache supprimee.', null, ['formation_id'=>$fid]);
        } else {
            $this->redirect('formations', null, 'Acces refuse.');
        }
    }

    private function validateTache(array $d): array {
        $e = [];
        if (!$d['titre'])       $e[] = 'Le titre est obligatoire.';
        if ($d['duree'] === '')  $e[] = 'La duree est obligatoire.';
        elseif (!is_numeric($d['duree']) || (int)$d['duree'] <= 0) $e[] = 'La duree doit etre un entier positif.';
        if (!$d['dateDebut'])   $e[] = 'La date de debut est obligatoire.';
        if (!$d['dateFin'])     $e[] = 'La date de fin est obligatoire.';
        if ($d['dateDebut'] && $d['dateFin'] && $d['dateFin'] < $d['dateDebut'])
            $e[] = 'La date de fin doit etre apres la date de debut.';
        return $e;
    }

    // ─── Commentaires ─────────────────────────────────────────────────────
    private function commentAdd(): void {
        $tacheId     = (int)($_POST['tache_id']     ?? 0);
        $formationId = (int)($_POST['formation_id'] ?? 0);
        $contenu     = trim($_POST['contenu']        ?? '');

        if (!$tacheId || !$contenu) {
            $this->redirect('taches', null, 'Commentaire invalide.', ['formation_id'=>$formationId]);
            return;
        }
        $bw      = new BadWordsService();
        $contenu = $bw->filter($contenu);

        $this->cm->add($tacheId, $this->uid, 'manager', $contenu);
        $this->redirect('taches', 'Commentaire ajoute.', null, ['formation_id'=>$formationId]);
    }

    private function commentDelete(): void {
        $id          = (int)($_GET['id']           ?? 0);
        $formationId = (int)($_GET['formation_id'] ?? 0);
        $this->cm->delete($id, $this->uid, 'manager');
        $this->redirect('taches', 'Commentaire supprime.', null, ['formation_id'=>$formationId]);
    }

    // ─── Traduction ───────────────────────────────────────────────────────
    private function translateAction(): void {
        header('Content-Type: application/json; charset=utf-8');
        $text   = trim($_POST['text']        ?? '');
        $target = trim($_POST['target_lang'] ?? 'en');
        $langs  = $this->translator->getSupportedLanguages();
        if (!array_key_exists($target, $langs)) $target = 'en';
        if (!$text) { echo json_encode(['error' => 'Texte vide']); exit; }

        $translated = $this->translator->translate($text, $target);
        echo json_encode(['translated' => $translated, 'lang' => $target], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // ─── Helpers ──────────────────────────────────────────────────────────
    private function handleUpload(string $field, string $subdir): ?string {
        if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) return null;
        $file    = $_FILES[$field];
        $ext     = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];
        if (!in_array($ext, $allowed)) return null;
        if ($file['size'] > 5 * 1024 * 1024) return null;

        $filename = uniqid() . '.' . $ext;
        $destDir  = __DIR__ . "/../vues/public/uploads/{$subdir}/";
        if (!is_dir($destDir)) mkdir($destDir, 0755, true);
        $dest = $destDir . $filename;
        if (move_uploaded_file($file['tmp_name'], $dest)) {
            return "uploads/{$subdir}/{$filename}";
        }
        return null;
    }

    private function handleVideoUpload(string $field, string $subdir): ?string {
        if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) return null;
        $file    = $_FILES[$field];
        $ext     = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['mp4','webm','mov','avi','mkv'];
        if (!in_array($ext, $allowed)) return null;
        if ($file['size'] > 100 * 1024 * 1024) return null;

        $filename = uniqid() . '.' . $ext;
        $destDir  = __DIR__ . "/../vues/public/uploads/{$subdir}/";
        if (!is_dir($destDir)) mkdir($destDir, 0755, true);
        $dest = $destDir . $filename;
        if (move_uploaded_file($file['tmp_name'], $dest)) {
            return "uploads/{$subdir}/{$filename}";
        }
        return null;
    }

    private function render(string $view, array $data = []): void {
        extract($data);
        $role    = 'manager';
        $userId  = $this->uid;
        $success = $_SESSION['flash_success'] ?? null;
        $error   = $_SESSION['flash_error']   ?? null;
        $langs   = $this->translator->getSupportedLanguages();
        unset($_SESSION['flash_success'], $_SESSION['flash_error']);
        require __DIR__ . '/../vues/backoffice/' . $view . '.php';
    }

    private function redirect(string $action, ?string $success = null, ?string $error = null, array $extra = []): void {
        if ($success) $_SESSION['flash_success'] = $success;
        if ($error)   $_SESSION['flash_error']   = $error;
        header('Location: index.php?' . http_build_query(array_merge(['role'=>'manager','action'=>$action], $extra)));
        exit;
    }
}
