<?php
require_once __DIR__ . '/../models/Formation.php';
require_once __DIR__ . '/../models/Tache.php';
require_once __DIR__ . '/../models/Participant.php';

class EnseignantController {
    private Formation $fm;
    private Tache $tm;
    private Participant $pm;
    private int $uid;

    public function __construct() {
        $this->fm  = new Formation();
        $this->tm  = new Tache();
        $this->pm  = new Participant();
        $this->uid = (int)$_SESSION['user_id'];
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
            default              => $this->dashboard(),
        };
    }

    // ─── Dashboard ────────────────────────────────────────────────────────
    private function dashboard(): void {
        $formations     = $this->fm->getByEnseignant($this->uid);
        $nbFormations   = count($formations);
        $nbParticipants = array_sum(array_column($formations, 'nb_participants'));
        $nbTaches       = array_sum(array_column($formations, 'nb_taches'));
        $this->render('enseignant/dashboard', compact('formations','nbFormations','nbParticipants','nbTaches'));
    }

    // ─── Formations ───────────────────────────────────────────────────────
    private function formations(): void {
        $formations = $this->fm->getByEnseignant($this->uid);
        $this->render('enseignant/formations_list', compact('formations'));
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
                $cap = ($d['capacite_max'] === '') ? 0 : (int)$d['capacite_max'];
                if (!array_key_exists($d['niveau'], Formation::NIVEAUX)) $d['niveau'] = 'debutant';
                $this->fm->create($d['titre'],$d['description'],$d['lieu'],$d['niveau'],$cap,$d['dateDebut'],$d['dateFin'],$this->uid);
                $this->redirect('formations', 'Formation creee avec succes.');
                return;
            }
        }
        $this->render('enseignant/formation_form', ['errors'=>$errors,'edit'=>false] + $d);
    }

    private function formationEdit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $f  = $this->fm->getById($id);
        if (!$f || (int)$f['enseignant_id'] !== $this->uid) { $this->redirect('formations', null, 'Acces refuse.'); return; }
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
                $cap = ($d['capacite_max'] === '') ? 0 : (int)$d['capacite_max'];
                $this->fm->update($id,$d['titre'],$d['description'],$d['lieu'],$d['niveau'],$cap,$d['dateDebut'],$d['dateFin']);
                $this->redirect('formations', 'Formation mise a jour.');
                return;
            }
        } else {
            $d = ['titre'=>$f['titre'],'description'=>$f['description'],'lieu'=>$f['lieu'],'niveau'=>$f['niveau'],
                  'capacite_max'=>$f['capacite_max'],'dateDebut'=>$f['date_debut'],'dateFin'=>$f['date_fin']];
        }
        $this->render('enseignant/formation_form', ['errors'=>$errors,'edit'=>true,'formation_id'=>$id] + $d);
    }

    private function validateFormation(array $d): array {
        $e = [];
        if (!$d['titre'])    $e[] = 'Le titre est obligatoire.';
        if (!$d['dateDebut']) $e[] = 'La date de debut est obligatoire.';
        if (!$d['dateFin'])   $e[] = 'La date de fin est obligatoire.';
        if ($d['dateDebut'] && $d['dateFin'] && $d['dateFin'] < $d['dateDebut'])
            $e[] = 'La date de fin doit etre apres la date de debut.';
        if ($d['capacite_max'] !== '' && (!is_numeric($d['capacite_max']) || (int)$d['capacite_max'] < 0))
            $e[] = 'La capacite doit etre un nombre positif (0 = illimite).';
        return $e;
    }

    private function formationDelete(): void {
        $id = (int)($_GET['id'] ?? 0);
        $f  = $this->fm->getById($id);
        if ($f && (int)$f['enseignant_id'] === $this->uid) { $this->fm->delete($id); $this->redirect('formations','Formation supprimee.'); }
        else $this->redirect('formations', null, 'Acces refuse.');
    }

    // ─── Participants ─────────────────────────────────────────────────────
    private function participants(): void {
        $fid = (int)($_GET['formation_id'] ?? 0);
        $f   = $this->fm->getById($fid);
        if (!$f || (int)$f['enseignant_id'] !== $this->uid) { $this->redirect('formations', null, 'Acces refuse.'); return; }
        $participants = $this->pm->getByFormation($fid);
        $allEtudiants = $this->pm->getAllEtudiants();
        $formationId  = $fid;
        $errors = [];
        $this->render('enseignant/participants', compact('participants','allEtudiants','formationId','errors') + ['formation'=>$f]);
    }

    private function participantAdd(): void {
        $fid = (int)($_GET['formation_id'] ?? 0);
        $f   = $this->fm->getById($fid);
        if (!$f || (int)$f['enseignant_id'] !== $this->uid) { $this->redirect('formations'); return; }
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $type = $_POST['type'] ?? 'id';
            if ($type === 'id') {
                $eid = (int)($_POST['etudiant_id'] ?? 0);
                if (!$eid) $errors[] = 'Veuillez selectionner un etudiant.';
                elseif (!$this->pm->addById($fid, $eid)) $errors[] = 'Cet etudiant est deja inscrit.';
            } else {
                $nom    = trim($_POST['nom']    ?? '');
                $prenom = trim($_POST['prenom'] ?? '');
                if (!$nom)    $errors[] = 'Le nom est obligatoire.';
                if (!$prenom) $errors[] = 'Le prenom est obligatoire.';
                if (!$errors) $this->pm->addManual($fid, $nom, $prenom);
            }
        }
        if ($errors) {
            $participants = $this->pm->getByFormation($fid);
            $allEtudiants = $this->pm->getAllEtudiants();
            $formationId  = $fid;
            $this->render('enseignant/participants', compact('participants','allEtudiants','formationId','errors') + ['formation'=>$f]);
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
        if (!$f || (int)$f['enseignant_id'] !== $this->uid) { $this->redirect('formations', null, 'Acces refuse.'); return; }
        $taches      = $this->tm->getByFormationWithStatuts($fid);
        $formationId = $fid;
        $this->render('enseignant/taches_list', compact('taches','formationId') + ['formation'=>$f]);
    }

    private function tacheAdd(): void {
        $fid = (int)($_GET['formation_id'] ?? 0);
        $f   = $this->fm->getById($fid);
        if (!$f || (int)$f['enseignant_id'] !== $this->uid) { $this->redirect('formations'); return; }
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
                $this->tm->create($fid, $d['titre'], $d['description'], (int)$d['duree'], $d['dateDebut'], $d['dateFin']);
                $this->redirect('taches', 'Tache ajoutee. Statut cree pour chaque participant.', null, ['formation_id'=>$fid]);
                return;
            }
        }
        $this->render('enseignant/tache_form', ['errors'=>$errors,'edit'=>false,'formationId'=>$fid,'formation'=>$f] + $d);
    }

    private function tacheEdit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $t  = $this->tm->getById($id);
        if (!$t) { $this->redirect('formations'); return; }
        $fid = (int)$t['formation_id'];
        $f   = $this->fm->getById($fid);
        if (!$f || (int)$f['enseignant_id'] !== $this->uid) { $this->redirect('formations', null, 'Acces refuse.'); return; }
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
                $this->tm->update($id, $d['titre'], $d['description'], (int)$d['duree'], $d['dateDebut'], $d['dateFin']);
                $this->redirect('taches', 'Tache mise a jour.', null, ['formation_id'=>$fid]);
                return;
            }
        } else {
            $d = ['titre'=>$t['titre'],'description'=>$t['description'],'duree'=>$t['duree'],'dateDebut'=>$t['date_debut'],'dateFin'=>$t['date_fin']];
        }
        $this->render('enseignant/tache_form', ['errors'=>$errors,'edit'=>true,'tache_id'=>$id,'formationId'=>$fid,'formation'=>$f] + $d);
    }

    private function validateTache(array $d): array {
        $e = [];
        if (!$d['titre'])      $e[] = 'Le titre est obligatoire.';
        if ($d['duree'] === '') $e[] = 'La duree est obligatoire.';
        elseif (!is_numeric($d['duree']) || (int)$d['duree'] <= 0) $e[] = 'La duree doit etre un entier positif (heures).';
        if (!$d['dateDebut'])  $e[] = 'La date de debut est obligatoire.';
        if (!$d['dateFin'])    $e[] = 'La date de fin est obligatoire.';
        if ($d['dateDebut'] && $d['dateFin'] && $d['dateFin'] < $d['dateDebut'])
            $e[] = 'La date de fin doit etre apres la date de debut.';
        return $e;
    }

    private function tacheDelete(): void {
        $id  = (int)($_GET['id'] ?? 0);
        $t   = $this->tm->getById($id);
        $fid = $t ? (int)$t['formation_id'] : 0;
        $f   = $fid ? $this->fm->getById($fid) : null;
        if ($t && $f && (int)$f['enseignant_id'] === $this->uid) {
            $this->tm->delete($id);
            $this->redirect('taches', 'Tache supprimee.', null, ['formation_id'=>$fid]);
        } else {
            $this->redirect('formations', null, 'Acces refuse.');
        }
    }

    // ─── Helpers ──────────────────────────────────────────────────────────
    private function render(string $view, array $data = []): void {
        extract($data);
        $role    = 'enseignant';
        $userId  = $this->uid;
        $success = $_SESSION['flash_success'] ?? null;
        $error   = $_SESSION['flash_error']   ?? null;
        unset($_SESSION['flash_success'], $_SESSION['flash_error']);
        require __DIR__ . '/../vues/' . $view . '.php';
    }

    private function redirect(string $action, ?string $success = null, ?string $error = null, array $extra = []): void {
        if ($success) $_SESSION['flash_success'] = $success;
        if ($error)   $_SESSION['flash_error']   = $error;
        header('Location: index.php?' . http_build_query(array_merge(['role'=>'enseignant','action'=>$action], $extra)));
        exit;
    }
}
