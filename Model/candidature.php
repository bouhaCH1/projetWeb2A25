<?php
class Candidature {
    private $conn;
    private $table = "candidature";

    public $mission_id;
    public $nom;
    public $prenom;
    public $email;
    public $telephone;
    public $motivation;

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

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
