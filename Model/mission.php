<?php
class Mission {
    private $conn;
    private $table = "mission";

    public $id;
    public $titre;
    public $description;
    public $budget;
    public $date_debut;
    public $date_fin;
    public $statut;
    public $competences;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // READ ALL
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ ONE
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // CREATE
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (titre, description, budget, date_debut, date_fin, statut, competences) 
                  VALUES (:titre, :description, :budget, :date_debut, :date_fin, :statut, :competences)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':titre', $this->titre);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':budget', $this->budget);
        $stmt->bindParam(':date_debut', $this->date_debut);
        $stmt->bindParam(':date_fin', $this->date_fin);
        $stmt->bindParam(':statut', $this->statut);
        $stmt->bindParam(':competences', $this->competences);
        return $stmt->execute();
    }

    // UPDATE
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET titre=:titre, description=:description, budget=:budget,
                      date_debut=:date_debut, date_fin=:date_fin, 
                      statut=:statut, competences=:competences
                  WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':titre', $this->titre);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':budget', $this->budget);
        $stmt->bindParam(':date_debut', $this->date_debut);
        $stmt->bindParam(':date_fin', $this->date_fin);
        $stmt->bindParam(':statut', $this->statut);
        $stmt->bindParam(':competences', $this->competences);
        return $stmt->execute();
    }

    // DELETE
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getPopular($limit = 5) {
        $query = "SELECT m.*, COUNT(c.id) as application_count
                  FROM " . $this->table . " m
                  LEFT JOIN candidature c ON m.id = c.mission_id
                  GROUP BY m.id
                  HAVING application_count > 0
                  ORDER BY application_count DESC
                  LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>