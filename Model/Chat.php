<?php
require_once __DIR__ . '/Database.php';

class Chat {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Envoyer un message
    public function sendMessage($senderId, $senderType, $receiverId, $message) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO chat_messages (sender_id, sender_type, receiver_id, message, created_at) VALUES (?, ?, ?, ?, NOW())");
        return $stmt->execute([$senderId, $senderType, $receiverId, $message]);
    }
    
    // Récupérer les messages d'une conversation
    public function getConversation($userId, $userType, $otherId, $limit = 50) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("
            SELECT * FROM chat_messages 
            WHERE (sender_id = ? AND receiver_id = ?) 
               OR (sender_id = ? AND receiver_id = ?)
            ORDER BY created_at ASC 
            LIMIT ?
        ");
        $stmt->execute([$userId, $otherId, $otherId, $userId, $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Marquer comme lu
    public function markAsRead($senderId, $receiverId) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE chat_messages SET is_read = 1 WHERE sender_id = ? AND receiver_id = ? AND is_read = 0");
        return $stmt->execute([$senderId, $receiverId]);
    }
    
    // Messages non lus pour un utilisateur
    public function getUnreadCount($userId, $userType) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("
            SELECT COUNT(*) FROM chat_messages 
            WHERE receiver_id = ? AND is_read = 0
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }
    
    // Toutes les conversations d'un utilisateur
    public function getConversations($userId) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("
            SELECT 
                CASE 
                    WHEN sender_id = ? THEN receiver_id 
                    ELSE sender_id 
                END as other_id,
                MAX(created_at) as last_message_date,
                (SELECT message FROM chat_messages 
                 WHERE (sender_id = ? AND receiver_id = other_id) OR (sender_id = other_id AND receiver_id = ?)
                 ORDER BY created_at DESC LIMIT 1) as last_message,
                (SELECT COUNT(*) FROM chat_messages 
                 WHERE sender_id = other_id AND receiver_id = ? AND is_read = 0) as unread_count
            FROM chat_messages 
            WHERE sender_id = ? OR receiver_id = ?
            GROUP BY other_id
            ORDER BY last_message_date DESC
        ");
        $stmt->execute([$userId, $userId, $userId, $userId, $userId, $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
