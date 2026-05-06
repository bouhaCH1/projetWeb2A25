<?php
// models/Payment.php
class Payment {
    private $conn;
    private $table_name = "payments";

    public function __construct($db) { $this->conn = $db; }

    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " SET rib=:rib, email=:email, amount=:amount, status='Validé'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":rib", $data['rib']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":amount", $data['amount']);
        return $stmt->execute();
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
