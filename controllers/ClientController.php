<?php
require_once __DIR__ . '/../models/repositories/FormationRepository.php';
require_once __DIR__ . '/../models/repositories/TacheRepository.php';
require_once __DIR__ . '/../models/repositories/ParticipantRepository.php';
require_once __DIR__ . '/../models/repositories/ClientTacheStatutRepository.php';
require_once __DIR__ . '/../models/repositories/CommentaireRepository.php';
require_once __DIR__ . '/../models/services/TranslationService.php';
require_once __DIR__ . '/../models/services/WeatherService.php';
require_once __DIR__ . '/../models/services/BadWordsService.php';

class ClientController {
    private FormationRepository $fm;
    private TacheRepository $tm;
    private ParticipantRepository $pm;
    private ClientTacheStatutRepository $sm;
    private CommentaireRepository $cm;
    private TranslationService $translator;
    private int $uid;

    public function __construct() {
        $this->fm         = new FormationRepository();
        $this->tm         = new TacheRepository();
        $this->pm         = new ParticipantRepository();
        $this->sm         = new ClientTacheStatutRepository();
        $this->cm         = new CommentaireRepository();
        $this->translator = new TranslationService();
        $this->uid        = (int)$_SESSION['user_id'];
    }

    public function handle(string $action): void {
        match($action) {
            'dashboard'      => $this->dashboard(),
            'formations'     => $this->formations(),
            'participer'     => $this->participer(),
            'quitter'        => $this->quitter(),
            'taches'         => $this->taches(),
            'update_statut'  => $this->updateStatut(),
            'comment_add'    => $this->commentAdd(),
            'comment_delete' => $this->commentDelete(),
            'translate'      => $this->translateAction(),
            default          => $this->dashboard(),
        };
    }

    // ─── Dashboard ────────────────────────────────────────────────────────
    private function dashboard(): void {
        $mesFormations   = $this->fm->getByClient($this->uid);
        $touteFormations = $this->fm->getAll();
        $mesTaches       = $this->tm->getByClient($this->uid);
        $weather         = (new WeatherService())->current();
        $this->render('client/dashboard', compact('mesFormations','touteFormations','mesTaches','weather'));
    }

    // ─── Formations ───────────────────────────────────────────────────────
    private function formations(): void {
        $filters = [
            'q'      => trim((string)($_GET['q'] ?? '')),
            'niveau' => trim((string)($_GET['niveau'] ?? '')),
            'lieu'   => trim((string)($_GET['lieu'] ?? '')),
        ];
        $touteFormations = $this->fm->getAllFiltered($filters);
        $mesFormations   = $this->fm->getByClient($this->uid);
        $mesIds          = array_column($mesFormations, 'id');
        $this->render('client/formations_list', compact('touteFormations','mesFormations','mesIds','filters'));
    }

    private function participer(): void {
        $fid = (int)($_GET['formation_id'] ?? 0);
        if ($fid > 0) {
            $this->pm->participate($fid, $this->uid);
            $this->redirect('formations', 'Vous avez rejoint la formation !');
        } else {
            $this->redirect('formations', null, 'Formation introuvable.');
        }
    }

    private function quitter(): void {
        $fid = (int)($_GET['formation_id'] ?? 0);
        if ($fid > 0) {
            $this->pm->leave($fid, $this->uid);
            $this->redirect('formations', 'Vous avez quitte la formation.');
        } else {
            $this->redirect('formations');
        }
    }

    // ─── Taches ───────────────────────────────────────────────────────────
    private function taches(): void {
        $fid       = (int)($_GET['formation_id'] ?? 0);
        $formation = $fid ? $this->fm->getById($fid) : null;

        if ($fid > 0 && !$this->pm->isParticipant($fid, $this->uid)) {
            $this->redirect('formations', null, 'Vous ne participez pas a cette formation.');
            return;
        }

        $taches = $this->tm->getByClient($this->uid);
        if ($fid > 0) {
            $taches = array_values(array_filter($taches, fn($t) => (int)$t['formation_id'] === $fid));
        }

        // Charger les commentaires pour chaque tache
        foreach ($taches as &$t) {
            $t['commentaires'] = $this->cm->getByTache((int)$t['id']);
        }
        unset($t);

        $formationId = $fid;
        $this->render('client/taches', compact('taches','formation','formationId'));
    }

    // ─── Statut ───────────────────────────────────────────────────────────
    private function updateStatut(): void {
        $tacheId     = (int)($_POST['tache_id']     ?? 0);
        $statut      = $_POST['statut']             ?? '';
        $formationId = (int)($_POST['formation_id'] ?? 0);

        if (!$tacheId || !array_key_exists($statut, Tache::STATUTS)) {
            $this->redirect('taches', null, 'Statut invalide.', $formationId ? ['formation_id'=>$formationId] : []);
            return;
        }
        $tache = $this->tm->getById($tacheId);
        if ($tache && $this->pm->isParticipant((int)$tache['formation_id'], $this->uid)) {
            $this->sm->update($tacheId, $this->uid, $statut);
            $this->redirect('taches', 'Statut mis a jour.', null, $formationId ? ['formation_id'=>$formationId] : []);
            return;
        }
        $this->redirect('taches', null, 'Impossible de mettre a jour.', $formationId ? ['formation_id'=>$formationId] : []);
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

        $tache = $this->tm->getById($tacheId);
        if (!$tache || !$this->pm->isParticipant((int)$tache['formation_id'], $this->uid)) {
            $this->redirect('taches', null, 'Acces refuse.', ['formation_id'=>$formationId]);
            return;
        }

        $bw      = new BadWordsService();
        $contenu = $bw->filter($contenu);

        $this->cm->add($tacheId, $this->uid, 'client', $contenu);
        $this->redirect('taches', 'Commentaire ajoute.', null, ['formation_id'=>$formationId]);
    }

    private function commentDelete(): void {
        $id          = (int)($_GET['id']           ?? 0);
        $formationId = (int)($_GET['formation_id'] ?? 0);
        $this->cm->delete($id, $this->uid, 'client');
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
    private function render(string $view, array $data = []): void {
        extract($data);
        $role    = 'client';
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
        header('Location: index.php?' . http_build_query(array_merge(['role'=>'client','action'=>$action], $extra)));
        exit;
    }
}
