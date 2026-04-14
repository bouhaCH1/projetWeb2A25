<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/mission.php';

class MissionController {
    private $db;
    private $mission;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->mission = new Mission($this->db);
    }

    public function frontIndex() {
        $missions = $this->mission->getAll();
        require_once __DIR__ . '/../views/frontoffice/missions.php';
    }

    public function frontCreate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validate($_POST);
            if (empty($errors)) {
                $this->hydrateMission($_POST);
                if ($this->mission->create()) {
                    header('Location: index.php?action=missions&success=1');
                    exit;
                }
            }
            require_once __DIR__ . '/../views/frontoffice/create.php';
            return;
        }

        $errors = [];
        require_once __DIR__ . '/../views/frontoffice/create.php';
    }

    public function frontEdit() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $missionData = $this->mission->getById($id);
        if (!$missionData) {
            header('Location: index.php?action=missions');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validate($_POST);
            if (empty($errors)) {
                $this->mission->id = $id;
                $this->hydrateMission($_POST);
                if ($this->mission->update()) {
                    header('Location: index.php?action=missions&updated=1');
                    exit;
                }
            }
        }

        require_once __DIR__ . '/../views/frontoffice/edit.php';
    }

    public function frontDelete() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            $this->mission->delete($id);
        }
        header('Location: index.php?action=missions&deleted=1');
        exit;
    }

    public function index() {
        $missions = $this->mission->getAll();
        require_once __DIR__ . '/../views/backoffice/list.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validate($_POST);
            if (empty($errors)) {
                $this->hydrateMission($_POST);
                if ($this->mission->create()) {
                    header('Location: index.php?action=index&success=1');
                    exit;
                }
            }
            require_once __DIR__ . '/../views/backoffice/create.php';
        } else {
            $errors = [];
            require_once __DIR__ . '/../views/backoffice/create.php';
        }
    }

    public function edit() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $missionData = $this->mission->getById($id);
        if (!$missionData) {
            header('Location: index.php?action=index');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validate($_POST);
            if (empty($errors)) {
                $this->mission->id = $id;
                $this->hydrateMission($_POST);
                if ($this->mission->update()) {
                    header('Location: index.php?action=index&updated=1');
                    exit;
                }
            }
        }
        require_once __DIR__ . '/../views/backoffice/edit.php';
    }

    public function delete() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($this->mission->delete($id)) {
            header('Location: index.php?action=index&deleted=1');
            exit;
        }
    }

    private function hydrateMission($data) {
        $this->mission->titre = trim($data['titre']);
        $this->mission->description = trim($data['description']);
        $this->mission->budget = $data['budget'];
        $this->mission->date_debut = $data['date_debut'];
        $this->mission->date_fin = $data['date_fin'];
        $this->mission->statut = $data['statut'];
        $this->mission->competences = trim($data['competences']);
    }

    private function validate($data) {
        $errors = [];

        if (empty(trim($data['titre'] ?? '')))
            $errors['titre'] = "Le titre est obligatoire.";
        elseif (strlen(trim($data['titre'])) < 5)
            $errors['titre'] = "Le titre doit contenir au moins 5 caractères.";
        elseif (strlen(trim($data['titre'])) > 100)
            $errors['titre'] = "Le titre ne doit pas dépasser 100 caractères.";

        if (empty(trim($data['description'] ?? '')))
            $errors['description'] = "La description est obligatoire.";
        elseif (strlen(trim($data['description'])) < 20)
            $errors['description'] = "La description doit contenir au moins 20 caractères.";

        if (empty($data['budget']) || !is_numeric($data['budget']) || (float)$data['budget'] <= 0)
            $errors['budget'] = "Le budget doit être un nombre positif.";
        elseif ((float)$data['budget'] > 1000000)
            $errors['budget'] = "Le budget ne doit pas dépasser 1 000 000.";

        if (empty($data['date_debut']))
            $errors['date_debut'] = "La date de début est obligatoire.";

        if (empty($data['date_fin']))
            $errors['date_fin'] = "La date de fin est obligatoire.";
        elseif (!empty($data['date_debut']) && $data['date_fin'] <= $data['date_debut'])
            $errors['date_fin'] = "La date de fin doit être après la date de début.";

        if (!in_array($data['statut'] ?? '', ['ouverte', 'en_cours', 'terminee'], true))
            $errors['statut'] = "Statut invalide.";

        if (empty(trim($data['competences'] ?? '')))
            $errors['competences'] = "Les compétences sont obligatoires.";
        elseif (strlen(trim($data['competences'])) < 3)
            $errors['competences'] = "Entrez au moins une compétence valide.";

        return $errors;
    }
}
?>