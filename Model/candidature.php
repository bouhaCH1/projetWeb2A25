<?php
class Candidature {
    private $conn;
    private $table = "candidature";

    public $id;
    public $mission_id;
    public $id_job_seeker; // FK → users.id
    public $nom;
    public $prenom;
    public $email;
    public $telephone;
    public $motivation;
    public $cv;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . "
                  (mission_id, user_id, nom, prenom, email, telephone, motivation)
                  VALUES (:mission_id, :user_id, :nom, :prenom, :email, :telephone, :motivation)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':mission_id', $this->mission_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $this->id_job_seeker, PDO::PARAM_INT);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telephone', $this->telephone);
        $stmt->bindParam(':motivation', $this->motivation);
        return $stmt->execute();
    }

    public function getAllWithMission($missionId = null, $sort = 'date_desc') {
        $query = "SELECT c.*, m.titre AS mission_titre
                  FROM " . $this->table . " c
                  INNER JOIN mission m ON m.id = c.mission_id";

        if ($missionId !== null) {
            $query .= " WHERE c.mission_id = :mission_id";
        }

        switch ($sort) {
            case 'name_asc': $query .= " ORDER BY c.prenom ASC, c.nom ASC"; break;
            case 'name_desc': $query .= " ORDER BY c.prenom DESC, c.nom DESC"; break;
            case 'date_desc':
            default: $query .= " ORDER BY c.created_at DESC"; break;
        }
        $stmt = $this->conn->prepare($query);

        if ($missionId !== null) {
            $stmt->bindParam(':mission_id', $missionId, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatut($id, $statut) {
        $query = "UPDATE " . $this->table . " SET statut = :statut WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':statut', $statut);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getAll($sort = 'date_desc') {
        $query = "SELECT c.*, m.titre AS mission_titre
                  FROM " . $this->table . " c
                  INNER JOIN mission m ON m.id = c.mission_id";
        
        switch ($sort) {
            case 'name_asc': $query .= " ORDER BY c.prenom ASC, c.nom ASC"; break;
            case 'name_desc': $query .= " ORDER BY c.prenom DESC, c.nom DESC"; break;
            case 'date_desc':
            default: $query .= " ORDER BY c.created_at DESC"; break;
        }
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT c.*, m.titre AS mission_titre
                  FROM " . $this->table . " c
                  INNER JOIN mission m ON m.id = c.mission_id
                  WHERE c.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update() {
        $query = "UPDATE " . $this->table . "
                  SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, motivation = :motivation
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telephone', $this->telephone);
        $stmt->bindParam(':motivation', $this->motivation);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Fetch all candidatures belonging to a specific logged-in user.
     */
    public function getByUserId(int $userId, string $sort = 'date_desc'): array {
        $query = "SELECT c.*, m.titre AS mission_titre,
                         m.competences AS mission_competences,
                         m.categorie   AS mission_categorie,
                         m.description AS mission_description
                  FROM " . $this->table . " c
                  INNER JOIN mission m ON m.id = c.mission_id
                  WHERE c.user_id = :user_id";

        switch ($sort) {
            case 'name_asc':  $query .= " ORDER BY c.prenom ASC, c.nom ASC"; break;
            case 'name_desc': $query .= " ORDER BY c.prenom DESC, c.nom DESC"; break;
            case 'date_desc':
            default:          $query .= " ORDER BY c.created_at DESC"; break;
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Check if a user has already applied to a given mission.
     */
    public function hasUserApplied(int $userId, int $missionId): bool {
        $query = "SELECT COUNT(*) FROM " . $this->table . "
                  WHERE user_id = :user_id AND mission_id = :mission_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':mission_id', $missionId, PDO::PARAM_INT);
        $stmt->execute();
        return (int)$stmt->fetchColumn() > 0;
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function countByMission($missionId) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE mission_id = :mission_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':mission_id', $missionId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    public function countAll() {
        $query = "SELECT COUNT(*) as count FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    public function countByStatut($statut) {
        if ($statut === 'en_attente') {
            $query = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE statut = :statut OR statut IS NULL OR statut = ''";
        } else {
            $query = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE statut = :statut";
        }
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':statut', $statut);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    public function countByEmailAndCategory($email, $categorie) {
        if (empty($email) || empty($categorie)) return 0;
        $query = "SELECT COUNT(*) as count
                  FROM " . $this->table . " c
                  INNER JOIN mission m ON m.id = c.mission_id
                  WHERE c.email = :email AND m.categorie = :categorie";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':categorie', $categorie);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    public function getByEmail($email) {
        $query = "SELECT c.*, m.titre AS mission_titre, m.competences AS mission_competences, m.categorie AS mission_categorie, m.description AS mission_description
                  FROM " . $this->table . " c
                  INNER JOIN mission m ON m.id = c.mission_id
                  WHERE c.email = :email
                  ORDER BY c.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
