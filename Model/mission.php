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
    public $categorie;
    public $niveau;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // READ ALL
    public function getAll($search = '', $statut = '', $sort = 'date_desc') {
        $query = "SELECT * FROM " . $this->table;
        $conditions = [];

        if (!empty($search)) {
            $conditions[] = "(titre LIKE :search OR description LIKE :search OR competences LIKE :search)";
        }
        if (!empty($statut)) {
            $conditions[] = "statut = :statut";
        }

        if (!empty($conditions)) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }

        // Sorting logic
        switch ($sort) {
            case 'title_asc': $query .= " ORDER BY titre ASC"; break;
            case 'title_desc': $query .= " ORDER BY titre DESC"; break;
            case 'date_desc':
            default: $query .= " ORDER BY created_at DESC"; break;
        }
        $stmt = $this->conn->prepare($query);

        if (!empty($search)) {
            $searchParam = '%' . $search . '%';
            $stmt->bindParam(':search', $searchParam);
        }
        if (!empty($statut)) {
            $stmt->bindParam(':statut', $statut);
        }

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

    // CREATE
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (titre, description, budget, date_debut, date_fin, statut, competences, categorie, niveau) 
                  VALUES (:titre, :description, :budget, :date_debut, :date_fin, :statut, :competences, :categorie, :niveau)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':titre', $this->titre);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':budget', $this->budget);
        $stmt->bindParam(':date_debut', $this->date_debut);
        $stmt->bindParam(':date_fin', $this->date_fin);
        $stmt->bindParam(':statut', $this->statut);
        $stmt->bindParam(':competences', $this->competences);
        $stmt->bindParam(':categorie', $this->categorie);
        $stmt->bindParam(':niveau', $this->niveau);
        return $stmt->execute();
    }

    // UPDATE
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET titre=:titre, description=:description, budget=:budget,
                      date_debut=:date_debut, date_fin=:date_fin, 
                      statut=:statut, competences=:competences,
                      categorie=:categorie, niveau=:niveau
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
        $stmt->bindParam(':categorie', $this->categorie);
        $stmt->bindParam(':niveau', $this->niveau);
        return $stmt->execute();
    }

    // DELETE
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }


}
?>