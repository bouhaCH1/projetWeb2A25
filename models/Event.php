<?php
// models/Event.php
class Event {
    private $conn;
    private $table_name = "event";

    public function __construct($db) { $this->conn = $db; }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY date ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " SET title=:title, description=:description, date=:date, location=:location, price=:price, payment_status=:payment_status";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":title", $data['title']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":date", $data['date']);
        $stmt->bindParam(":location", $data['location']);
        $stmt->bindParam(":price", $data['price']);
        $stmt->bindParam(":payment_status", $data['payment_status']);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table_name . " SET title=:title, description=:description, date=:date, location=:location, price=:price, payment_status=:payment_status WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":title", $data['title']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":date", $data['date']);
        $stmt->bindParam(":location", $data['location']);
        $stmt->bindParam(":price", $data['price']);
        $stmt->bindParam(":payment_status", $data['payment_status']);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
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
