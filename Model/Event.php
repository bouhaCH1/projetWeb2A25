<?php
require_once __DIR__ . '/Database.php';

class Event {
    private $conn;
    private $table_name = "event";

    public function __construct() {
        $this->conn = getConnection();
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY date ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " (title, description, date, location, employer_id) VALUES (:title, :description, :date, :location, :employer_id)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':date' => $data['date'],
            ':location' => $data['location'],
            ':employer_id' => $data['employer_id'] ?? null
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table_name . " SET title=:title, description=:description, date=:date, location=:location WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':date' => $data['date'],
            ':location' => $data['location'],
            ':id' => $id
        ]);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    public function countTotal() {
        return $this->conn->query("SELECT COUNT(*) FROM " . $this->table_name)->fetchColumn();
    }
    
    public function countUpcoming() {
        return $this->conn->query("SELECT COUNT(*) FROM " . $this->table_name . " WHERE date >= CURDATE()")->fetchColumn();
    }

    public function getMonthlyStats() {
        $query = "SELECT MONTHNAME(date) as month, COUNT(*) as count FROM " . $this->table_name . " GROUP BY MONTH(date) ORDER BY MONTH(date)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLocationStats() {
        $query = "SELECT location, COUNT(*) as count FROM " . $this->table_name . " GROUP BY location LIMIT 5";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
