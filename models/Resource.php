<?php
// models/Resource.php
class Resource {
    private $conn;
    private $table_name = "resource";

    public function __construct($db) { $this->conn = $db; }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY name ASC";
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
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, type=:type, quantity=:quantity";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $data['name']);
        $stmt->bindParam(":type", $data['type']);
        $stmt->bindParam(":quantity", $data['quantity']);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table_name . " SET name=:name, type=:type, quantity=:quantity WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $data['name']);
        $stmt->bindParam(":type", $data['type']);
        $stmt->bindParam(":quantity", $data['quantity']);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    public function countLowStock() {
        return $this->conn->query("SELECT COUNT(*) FROM " . $this->table_name . " WHERE quantity <= 2")->fetchColumn();
    }
    public function sumQuantity() {
        $sum = $this->conn->query("SELECT SUM(quantity) FROM " . $this->table_name)->fetchColumn();
        return $sum ? $sum : 0;
    }

    public function getTypeStats() {
        $query = "SELECT type, COUNT(*) as count FROM " . $this->table_name . " GROUP BY type";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // [ADVANCED STATS] Quantity distribution
    public function getQuantityRange() {
        $query = "SELECT 
            CASE 
                WHEN quantity <= 2 THEN 'Critique'
                WHEN quantity <= 10 THEN 'Moyen'
                ELSE 'Abondant'
            END as range_label, COUNT(*) as count 
            FROM " . $this->table_name . " GROUP BY range_label";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
