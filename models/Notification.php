<?php
class Notification {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function save($sender, $recipient, $subject, $message) {
        $stmt = $this->db->prepare("INSERT INTO notifications (sender, recipient, subject, message) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$sender, $recipient, $subject, $message]);
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM notifications ORDER BY created_at DESC")->fetchAll();
    }
}
?>
