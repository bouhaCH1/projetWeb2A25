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
                  (mission_id, nom, prenom, email, telephone, motivation, cv)
                  VALUES (:mission_id, :nom, :prenom, :email, :telephone, :motivation, :cv)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':mission_id', $this->mission_id, PDO::PARAM_INT);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telephone', $this->telephone);
        $stmt->bindParam(':motivation', $this->motivation);
        $stmt->bindParam(':cv', $this->cv);
        return $stmt->execute();
    }

    public function getAllWithMission($missionId = null) {
        $query = "SELECT c.*, m.titre AS mission_titre
                  FROM " . $this->table . " c
                  INNER JOIN mission m ON m.id = c.mission_id";

        if ($missionId !== null) {
            $query .= " WHERE c.mission_id = :mission_id";
        }

        $query .= " ORDER BY c.created_at DESC";
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

    public function getAll() {
        $query = "SELECT c.*, m.titre AS mission_titre
                  FROM " . $this->table . " c
                  INNER JOIN mission m ON m.id = c.mission_id
                  ORDER BY c.created_at DESC";
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
                  SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, motivation = :motivation, cv = :cv
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telephone', $this->telephone);
        $stmt->bindParam(':motivation', $this->motivation);
        $stmt->bindParam(':cv', $this->cv);
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
}
?>
