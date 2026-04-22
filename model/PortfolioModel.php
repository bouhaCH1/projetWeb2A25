<?php
require_once 'Database.php';

class PortfolioModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // ========== VALIDATION ==========
    private function validateData($data, $isUpdate = false) {
        $errors = [];
        
        if (!$isUpdate || isset($data['title'])) {
            if (empty(trim($data['title']))) {
                $errors['title'] = "Le titre est requis";
            } elseif (strlen($data['title']) < 3) {
                $errors['title'] = "Le titre doit contenir au moins 3 caractères";
            }
        }
        
        if (!$isUpdate || isset($data['description'])) {
            if (empty(trim($data['description']))) {
                $errors['description'] = "La description est requise";
            } elseif (strlen($data['description']) < 10) {
                $errors['description'] = "La description doit contenir au moins 10 caractères";
            }
        }
        
        return $errors;
    }
    
    // ========== GESTION DES PROJETS ==========
    
    public function submitPortfolio($data, $user_id, $username, $company_name) {
        $errors = $this->validateData($data);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }
        
        $sql = "INSERT INTO portfolio_items (user_id, submitted_by, company_name, title, description, category, technologies, image_url, project_url, start_date, end_date, status, is_approved) 
                VALUES (:user_id, :submitted_by, :company_name, :title, :description, :category, :technologies, :image_url, :project_url, :start_date, :end_date, :status, 0)";
        
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            ':user_id' => $user_id,
            ':submitted_by' => $username,
            ':company_name' => $company_name,
            ':title' => htmlspecialchars($data['title']),
            ':description' => htmlspecialchars($data['description']),
            ':category' => $data['category'],
            ':technologies' => htmlspecialchars($data['technologies']),
            ':image_url' => !empty($data['image_url']) ? filter_var($data['image_url'], FILTER_SANITIZE_URL) : null,
            ':project_url' => !empty($data['project_url']) ? filter_var($data['project_url'], FILTER_SANITIZE_URL) : null,
            ':start_date' => !empty($data['start_date']) ? $data['start_date'] : null,
            ':end_date' => !empty($data['end_date']) ? $data['end_date'] : null,
            ':status' => $data['status'] ?? 'planned'
        ]);
        
        if ($result) {
            $portfolio_id = $this->db->lastInsertId();
            $this->createNotification(1, "Nouveau portfolio à valider", "Le candidat {$username} a soumis un nouveau portfolio : {$data['title']}", "portfolio", "index.php?action=admin-pending-portfolios");
        }
        
        return ['success' => $result, 'id' => $portfolio_id ?? null];
    }
    
    public function getPendingPortfolios() {
        $sql = "SELECT p.*, u.username, u.email, u.company as user_company 
                FROM portfolio_items p 
                JOIN users u ON p.user_id = u.id 
                WHERE p.is_approved = 0 
                ORDER BY p.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getApprovedPortfolios($limit = null) {
        $sql = "SELECT p.*, u.username, u.company as user_company 
                FROM portfolio_items p 
                JOIN users u ON p.user_id = u.id 
                WHERE p.is_approved = 1 
                ORDER BY p.created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT " . intval($limit);
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getCandidatPortfolios($user_id) {
        $sql = "SELECT * FROM portfolio_items WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll();
    }
    
    public function approvePortfolio($portfolio_id) {
        $sql = "UPDATE portfolio_items SET is_approved = 1, status = 'completed' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([':id' => $portfolio_id]);
        
        if ($result) {
            $portfolio = $this->getById($portfolio_id);
            if ($portfolio) {
                $this->createNotification($portfolio['user_id'], "Portfolio validé", "Votre portfolio '{$portfolio['title']}' a été validé par l'administrateur.", "success", "index.php?action=candidat-dashboard");
            }
        }
        
        return $result;
    }
    
    public function rejectPortfolio($portfolio_id) {
        $portfolio = $this->getById($portfolio_id);
        $sql = "DELETE FROM portfolio_items WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([':id' => $portfolio_id]);
        
        if ($result && $portfolio) {
            $this->createNotification($portfolio['user_id'], "Portfolio refusé", "Votre portfolio '{$portfolio['title']}' n'a pas été validé. Veuillez vérifier les informations.", "danger", "index.php?action=candidat-dashboard");
        }
        
        return $result;
    }
    
    public function getById($id) {
        $sql = "SELECT * FROM portfolio_items WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
    
    public function updateCandidatPortfolio($id, $data, $user_id) {
        $sql_check = "SELECT id FROM portfolio_items WHERE id = :id AND user_id = :user_id AND is_approved = 0";
        $stmt_check = $this->db->prepare($sql_check);
        $stmt_check->execute([':id' => $id, ':user_id' => $user_id]);
        
        if (!$stmt_check->fetch()) {
            return ['success' => false, 'error' => "Vous ne pouvez pas modifier ce portfolio"];
        }
        
        $errors = $this->validateData($data, true);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }
        
        $sql = "UPDATE portfolio_items SET 
                title = :title,
                description = :description,
                category = :category,
                technologies = :technologies,
                image_url = :image_url,
                project_url = :project_url
                WHERE id = :id AND user_id = :user_id";
        
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            ':id' => $id,
            ':user_id' => $user_id,
            ':title' => htmlspecialchars($data['title']),
            ':description' => htmlspecialchars($data['description']),
            ':category' => $data['category'],
            ':technologies' => htmlspecialchars($data['technologies']),
            ':image_url' => !empty($data['image_url']) ? filter_var($data['image_url'], FILTER_SANITIZE_URL) : null,
            ':project_url' => !empty($data['project_url']) ? filter_var($data['project_url'], FILTER_SANITIZE_URL) : null
        ]);
        
        return ['success' => $result];
    }
    
    public function deleteCandidatPortfolio($id, $user_id) {
        $sql = "DELETE FROM portfolio_items WHERE id = :id AND user_id = :user_id AND is_approved = 0";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id, ':user_id' => $user_id]);
    }
    
    // ========== NOTIFICATIONS ==========
    
    public function createNotification($user_id, $title, $message, $type = 'info', $link = null) {
        $sql = "INSERT INTO notifications (user_id, title, message, type, link) VALUES (:user_id, :title, :message, :type, :link)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id' => $user_id,
            ':title' => $title,
            ':message' => $message,
            ':type' => $type,
            ':link' => $link
        ]);
    }
    
    public function getUserNotifications($user_id, $limit = 10) {
        $sql = "SELECT * FROM notifications WHERE user_id = :user_id ORDER BY created_at DESC LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function markNotificationAsRead($notification_id, $user_id) {
        $sql = "UPDATE notifications SET is_read = 1 WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $notification_id, ':user_id' => $user_id]);
    }
    
    public function getUnreadNotificationsCount($user_id) {
        $sql = "SELECT COUNT(*) as count FROM notifications WHERE user_id = :user_id AND is_read = 0";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        $result = $stmt->fetch();
        return $result['count'] ?? 0;
    }
    
    // ========== STATISTIQUES ==========
    
    public function getStats() {
        $stats = [];
        
        $sql = "SELECT COUNT(*) as total FROM portfolio_items WHERE is_approved = 1";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        $stats['total_approved'] = $result['total'] ?? 0;
        
        $sql = "SELECT COUNT(*) as pending FROM portfolio_items WHERE is_approved = 0";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        $stats['pending'] = $result['pending'] ?? 0;
        
        $sql = "SELECT COUNT(*) as total_candidats FROM users WHERE role = 'candidat'";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        $stats['total_candidats'] = $result['total_candidats'] ?? 0;
        
        $sql = "SELECT COUNT(*) as total_entreprises FROM users WHERE role = 'entreprise'";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        $stats['total_entreprises'] = $result['total_entreprises'] ?? 0;
        
        return $stats;
    }
}
?>