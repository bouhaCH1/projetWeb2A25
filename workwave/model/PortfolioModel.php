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
            } elseif (strlen($data['title']) > 100) {
                $errors['title'] = "Le titre ne doit pas dépasser 100 caractères";
            }
        }
        
        if (!$isUpdate || isset($data['description'])) {
            if (empty(trim($data['description']))) {
                $errors['description'] = "La description est requise";
            } elseif (strlen($data['description']) < 10) {
                $errors['description'] = "La description doit contenir au moins 10 caractères";
            }
        }
        
        if (!$isUpdate || isset($data['category'])) {
            $allowedCategories = ['Web Development', 'Mobile App', 'Design', 'AI/ML', 'Blockchain'];
            if (empty($data['category'])) {
                $errors['category'] = "La catégorie est requise";
            } elseif (!in_array($data['category'], $allowedCategories)) {
                $errors['category'] = "Catégorie invalide";
            }
        }
        
        if (!$isUpdate || isset($data['technologies'])) {
            if (empty(trim($data['technologies']))) {
                $errors['technologies'] = "Les technologies sont requises";
            }
        }
        
        if (!$isUpdate || isset($data['project_url'])) {
            if (!empty($data['project_url']) && !filter_var($data['project_url'], FILTER_VALIDATE_URL)) {
                $errors['project_url'] = "URL invalide";
            }
        }
        
        return $errors;
    }
    
    // ========== GESTION DES PROJETS ==========
    
    public function create($data) {
        $errors = $this->validateData($data);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }
        
        $sql = "INSERT INTO portfolio_items (title, description, category, technologies, image_url, project_url, start_date, end_date, status) 
                VALUES (:title, :description, :category, :technologies, :image_url, :project_url, :start_date, :end_date, :status)";
        
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            ':title' => htmlspecialchars($data['title']),
            ':description' => htmlspecialchars($data['description']),
            ':category' => $data['category'],
            ':technologies' => htmlspecialchars($data['technologies']),
            ':image_url' => !empty($data['image_url']) ? filter_var($data['image_url'], FILTER_SANITIZE_URL) : null,
            ':project_url' => !empty($data['project_url']) ? filter_var($data['project_url'], FILTER_SANITIZE_URL) : null,
            ':start_date' => !empty($data['start_date']) ? $data['start_date'] : null,
            ':end_date' => !empty($data['end_date']) ? $data['end_date'] : null,
            ':status' => $data['status']
        ]);
        
        return ['success' => $result, 'id' => $this->db->lastInsertId()];
    }
    
    public function getAll($limit = null, $status = null) {
        $sql = "SELECT * FROM portfolio_items";
        $params = [];
        
        if ($status) {
            $sql .= " WHERE status = :status";
            $params[':status'] = $status;
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT " . intval($limit);
        }
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $sql = "SELECT * FROM portfolio_items WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
    
    public function update($id, $data) {
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
                project_url = :project_url,
                start_date = :start_date,
                end_date = :end_date,
                status = :status
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            ':id' => $id,
            ':title' => htmlspecialchars($data['title']),
            ':description' => htmlspecialchars($data['description']),
            ':category' => $data['category'],
            ':technologies' => htmlspecialchars($data['technologies']),
            ':image_url' => !empty($data['image_url']) ? filter_var($data['image_url'], FILTER_SANITIZE_URL) : null,
            ':project_url' => !empty($data['project_url']) ? filter_var($data['project_url'], FILTER_SANITIZE_URL) : null,
            ':start_date' => !empty($data['start_date']) ? $data['start_date'] : null,
            ':end_date' => !empty($data['end_date']) ? $data['end_date'] : null,
            ':status' => $data['status']
        ]);
        
        return ['success' => $result];
    }
    
    public function delete($id) {
        $sql = "DELETE FROM portfolio_items WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    
    // ========== GESTION DES TÂCHES ==========
    
    public function getTasksByProject($project_id) {
        $sql = "SELECT * FROM tasks WHERE portfolio_id = :project_id ORDER BY due_date ASC, priority DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':project_id' => $project_id]);
        return $stmt->fetchAll();
    }
    
    public function getTaskById($task_id) {
        $sql = "SELECT * FROM tasks WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $task_id]);
        return $stmt->fetch();
    }
    
    private function validateTask($data, $isUpdate = false) {
        $errors = [];
        
        if (!$isUpdate || isset($data['title'])) {
            if (empty(trim($data['title']))) {
                $errors['title'] = "Le titre de la tâche est requis";
            } elseif (strlen($data['title']) < 3) {
                $errors['title'] = "Le titre doit contenir au moins 3 caractères";
            }
        }
        
        return $errors;
    }
    
    public function createTask($data) {
        $errors = $this->validateTask($data);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }
        
        $sql = "INSERT INTO tasks (portfolio_id, title, description, assigned_to, priority, status, estimated_hours, actual_hours, due_date, created_by) 
                VALUES (:portfolio_id, :title, :description, :assigned_to, :priority, :status, :estimated_hours, :actual_hours, :due_date, :created_by)";
        
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            ':portfolio_id' => $data['portfolio_id'],
            ':title' => htmlspecialchars($data['title']),
            ':description' => !empty($data['description']) ? htmlspecialchars($data['description']) : null,
            ':assigned_to' => !empty($data['assigned_to']) ? htmlspecialchars($data['assigned_to']) : null,
            ':priority' => $data['priority'] ?? 'medium',
            ':status' => $data['status'] ?? 'todo',
            ':estimated_hours' => $data['estimated_hours'] ?? 0,
            ':actual_hours' => $data['actual_hours'] ?? 0,
            ':due_date' => !empty($data['due_date']) ? $data['due_date'] : null,
            ':created_by' => $_SESSION['user']['username'] ?? 'admin'
        ]);
        
        return ['success' => $result, 'id' => $this->db->lastInsertId()];
    }
    
    public function updateTask($task_id, $data) {
        $errors = $this->validateTask($data, true);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }
        
        $sql = "UPDATE tasks SET 
                title = :title,
                description = :description,
                assigned_to = :assigned_to,
                priority = :priority,
                status = :status,
                estimated_hours = :estimated_hours,
                actual_hours = :actual_hours,
                due_date = :due_date
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            ':id' => $task_id,
            ':title' => htmlspecialchars($data['title']),
            ':description' => !empty($data['description']) ? htmlspecialchars($data['description']) : null,
            ':assigned_to' => !empty($data['assigned_to']) ? htmlspecialchars($data['assigned_to']) : null,
            ':priority' => $data['priority'] ?? 'medium',
            ':status' => $data['status'] ?? 'todo',
            ':estimated_hours' => $data['estimated_hours'] ?? 0,
            ':actual_hours' => $data['actual_hours'] ?? 0,
            ':due_date' => !empty($data['due_date']) ? $data['due_date'] : null
        ]);
        
        return ['success' => $result];
    }
    
    public function deleteTask($task_id) {
        $sql = "DELETE FROM tasks WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $task_id]);
    }
    
    public function updateTaskStatus($task_id, $status) {
        $sql = "UPDATE tasks SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $task_id, ':status' => $status]);
    }
    
    // ========== GESTION DES COMMENTAIRES ==========
    
    public function addComment($task_id, $comment, $user_name) {
        if (empty(trim($comment))) {
            return ['success' => false, 'error' => "Le commentaire ne peut pas être vide"];
        }
        
        $sql = "INSERT INTO task_comments (task_id, user_name, comment) VALUES (:task_id, :user_name, :comment)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            ':task_id' => $task_id,
            ':user_name' => htmlspecialchars($user_name),
            ':comment' => htmlspecialchars($comment)
        ]);
        
        return ['success' => $result];
    }
    
    public function getCommentsByTask($task_id) {
        $sql = "SELECT * FROM task_comments WHERE task_id = :task_id ORDER BY created_at ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':task_id' => $task_id]);
        return $stmt->fetchAll();
    }
    
    // ========== GESTION DES MEMBRES ==========
    
    public function addProjectMember($portfolio_id, $member_name, $member_email, $role = 'contributor') {
        if (empty(trim($member_name))) {
            return ['success' => false, 'error' => "Le nom du membre est requis"];
        }
        
        $sql = "INSERT INTO project_members (portfolio_id, member_name, member_email, role) 
                VALUES (:portfolio_id, :member_name, :member_email, :role)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            ':portfolio_id' => $portfolio_id,
            ':member_name' => htmlspecialchars($member_name),
            ':member_email' => !empty($member_email) ? filter_var($member_email, FILTER_SANITIZE_EMAIL) : null,
            ':role' => $role
        ]);
        
        return ['success' => $result];
    }
    
    public function getProjectMembers($portfolio_id) {
        $sql = "SELECT * FROM project_members WHERE portfolio_id = :portfolio_id ORDER BY joined_at ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':portfolio_id' => $portfolio_id]);
        return $stmt->fetchAll();
    }
    
    public function removeProjectMember($member_id) {
        $sql = "DELETE FROM project_members WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $member_id]);
    }
    
    // ========== STATISTIQUES ==========
    
    public function getStats() {
        $stats = [];
        
        $sql = "SELECT COUNT(*) as total FROM portfolio_items";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        $stats['total'] = $result['total'] ?? 0;
        
        $sql = "SELECT status, COUNT(*) as count FROM portfolio_items GROUP BY status";
        $stmt = $this->db->query($sql);
        $stats['by_status'] = $stmt->fetchAll();
        
        $sql = "SELECT category, COUNT(*) as count FROM portfolio_items GROUP BY category";
        $stmt = $this->db->query($sql);
        $stats['by_category'] = $stmt->fetchAll();
        
        $sql = "SELECT COUNT(*) as total_tasks FROM tasks";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        $stats['total_tasks'] = $result['total_tasks'] ?? 0;
        
        $sql = "SELECT status, COUNT(*) as count FROM tasks GROUP BY status";
        $stmt = $this->db->query($sql);
        $stats['tasks_by_status'] = $stmt->fetchAll();
        
        return $stats;
    }
    
    public function getProjectStats($project_id) {
        $stats = [];
        
        $sql = "SELECT COUNT(*) as total FROM tasks WHERE portfolio_id = :project_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':project_id' => $project_id]);
        $result = $stmt->fetch();
        $stats['total_tasks'] = $result['total'] ?? 0;
        
        $sql = "SELECT status, COUNT(*) as count FROM tasks WHERE portfolio_id = :project_id GROUP BY status";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':project_id' => $project_id]);
        $stats['tasks_by_status'] = $stmt->fetchAll();
        
        $sql = "SELECT COUNT(*) as total FROM project_members WHERE portfolio_id = :project_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':project_id' => $project_id]);
        $result = $stmt->fetch();
        $stats['total_members'] = $result['total'] ?? 0;
        
        return $stats;
    }
}
?>