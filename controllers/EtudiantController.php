<?php
require_once __DIR__ . '/../models/Formation.php';
require_once __DIR__ . '/../models/Tache.php';
require_once __DIR__ . '/../models/Participant.php';
require_once __DIR__ . '/../models/EtudiantTacheStatut.php';

class EtudiantController {
    private Formation $fm;
    private Tache $tm;
    private Participant $pm;
    private EtudiantTacheStatut $sm;
    private int $uid;

    public function __construct() {
        $this->fm  = new Formation();
        $this->tm  = new Tache();
        $this->pm  = new Participant();
        $this->sm  = new EtudiantTacheStatut();
        $this->uid = (int)$_SESSION['user_id'];
    }

    public function handle(string $action): void {
        match($action) {
            'dashboard'      => $this->dashboard(),
            'formations'     => $this->formations(),
            'participer'     => $this->participer(),
            'quitter'        => $this->quitter(),
            'taches'         => $this->taches(),
            'update_statut'  => $this->updateStatut(),
            default          => $this->dashboard(),
        };
    }

    // ─── Dashboard ────────────────────────────────────────────────────────
    private function dashboard(): void {
        $mesFormations   = $this->fm->getByEtudiant($this->uid);
        $touteFormations = $this->fm->getAll();
        $mesTaches       = $this->tm->getByEtudiant($this->uid);
        $this->render('etudiant/dashboard', compact('mesFormations','touteFormations','mesTaches'));
    }

    // ─── Formations ───────────────────────────────────────────────────────
    private function formations(): void {
        $touteFormations = $this->fm->getAll();
        $mesFormations   = $this->fm->getByEtudiant($this->uid);
        $mesIds          = array_column($mesFormations, 'id');
        $this->render('etudiant/formations_list', compact('touteFormations','mesFormations','mesIds'));
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

        $taches      = $fid ? $this->tm->getByEtudiant($this->uid) : $this->tm->getByEtudiant($this->uid);
        $formationId = $fid;

        // Filtrer par formation si specifie
        if ($fid > 0) {
            $taches = array_filter($taches, fn($t) => (int)$t['formation_id'] === $fid);
            $taches = array_values($taches);
        }

        $this->render('etudiant/taches', compact('taches','formation','formationId'));
    }

    // ─── Mise a jour du statut personnel ──────────────────────────────────
    private function updateStatut(): void {
        $tacheId     = (int)($_POST['tache_id']     ?? 0);
        $statut      = $_POST['statut']             ?? '';
        $formationId = (int)($_POST['formation_id'] ?? 0);

        $errors = [];
        if (!$tacheId) $errors[] = 'Tache invalide.';
        if (!array_key_exists($statut, Tache::STATUTS)) $errors[] = 'Statut invalide.';

        if (!$errors) {
            // Verifier que l'etudiant participe bien a la formation de cette tache
            $tache = $this->tm->getById($tacheId);
            if ($tache && $this->pm->isParticipant((int)$tache['formation_id'], $this->uid)) {
                $this->sm->update($tacheId, $this->uid, $statut);
                $this->redirect('taches', 'Statut mis a jour.', null, $formationId ? ['formation_id'=>$formationId] : []);
                return;
            }
        }
        $this->redirect('taches', null, 'Impossible de mettre a jour le statut.', $formationId ? ['formation_id'=>$formationId] : []);
    }

    // ─── Helpers ──────────────────────────────────────────────────────────
    private function render(string $view, array $data = []): void {
        extract($data);
        $role    = 'etudiant';
        $userId  = $this->uid;
        $success = $_SESSION['flash_success'] ?? null;
        $error   = $_SESSION['flash_error']   ?? null;
        unset($_SESSION['flash_success'], $_SESSION['flash_error']);
        require __DIR__ . '/../vues/' . $view . '.php';
    }

    private function redirect(string $action, ?string $success = null, ?string $error = null, array $extra = []): void {
        if ($success) $_SESSION['flash_success'] = $success;
        if ($error)   $_SESSION['flash_error']   = $error;
        header('Location: index.php?' . http_build_query(array_merge(['role'=>'etudiant','action'=>$action], $extra)));
        exit;
    }
}
