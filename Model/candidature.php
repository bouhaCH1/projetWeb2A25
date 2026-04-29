<?php
class Candidature {
    private $conn;
    private $table = "candidature";

    public $id;
    public $mission_id;
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
                  (mission_id, nom, prenom, email, telephone, motivation)
                  VALUES (:mission_id, :nom, :prenom, :email, :telephone, :motivation)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':mission_id', $this->mission_id, PDO::PARAM_INT);
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
        $query = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE statut = :statut";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':statut', $statut);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }
}
?>
