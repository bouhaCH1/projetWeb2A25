<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once dirname(__DIR__) . '/model/PortfolioModel.php';

class PortfolioController {
    private $model;
    
    public function __construct() {
        $this->model = new PortfolioModel();
    }
    
    private function checkAdmin() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?action=login');
            exit();
        }
    }
    
    // ========== FRONTOFFICE ==========
    
    public function frontList() {
        $projects = $this->model->getAll(null, 'completed');
        $inProgress = $this->model->getAll(null, 'in_progress');
        require_once dirname(__DIR__) . '/view/frontoffice/portfolio_list.php';
    }
    
    public function frontDetail($id) {
        $project = $this->model->getById($id);
        if (!$project) {
            header('HTTP/1.0 404 Not Found');
            die('Projet non trouvé');
        }
        $tasks = $this->model->getTasksByProject($id);
        $members = $this->model->getProjectMembers($id);
        $stats = $this->model->getProjectStats($id);
        require_once dirname(__DIR__) . '/view/frontoffice/portfolio_detail.php';
    }
    
    // Ajouter un commentaire (AJAX possible)
    public function addComment() {
        $this->checkAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $task_id = $_POST['task_id'] ?? null;
            $comment = $_POST['comment'] ?? '';
            $user_name = $_SESSION['user']['username'] ?? 'Admin';
            
            $result = $this->model->addComment($task_id, $comment, $user_name);
            
            if ($result['success']) {
                $_SESSION['message'] = "Commentaire ajouté avec succès !";
            } else {
                $_SESSION['message'] = $result['error'] ?? "Erreur lors de l'ajout";
                $_SESSION['message_type'] = "error";
            }
            
            header('Location: index.php?action=front-detail&id=' . ($_POST['project_id'] ?? 0));
            exit();
        }
    }
    
    // ========== BACKOFFICE ==========
    
    public function backDashboard() {
        $this->checkAdmin();
        $stats = $this->model->getStats();
        $recentProjects = $this->model->getAll(5);
        require_once dirname(__DIR__) . '/view/backoffice/dashboard.php';
    }
    
    public function backList() {
        $this->checkAdmin();
        $projects = $this->model->getAll();
        require_once dirname(__DIR__) . '/view/backoffice/portfolio_list.php';
    }
    
    public function backCreate() {
        $this->checkAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->model->create($_POST);
            
            if ($result['success']) {
                $_SESSION['message'] = "Projet ajouté avec succès !";
                $_SESSION['message_type'] = "success";
                header('Location: index.php?action=back-list');
                exit();
            } else {
                $errors = $result['errors'];
                require_once dirname(__DIR__) . '/view/backoffice/portfolio_form.php';
            }
        } else {
            $project = null;
            require_once dirname(__DIR__) . '/view/backoffice/portfolio_form.php';
        }
    }
    
    public function backEdit($id) {
        $this->checkAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->model->update($id, $_POST);
            
            if ($result['success']) {
                $_SESSION['message'] = "Projet modifié avec succès !";
                $_SESSION['message_type'] = "success";
                header('Location: index.php?action=back-list');
                exit();
            } else {
                $errors = $result['errors'];
                $project = $this->model->getById($id);
                require_once dirname(__DIR__) . '/view/backoffice/portfolio_form.php';
            }
        } else {
            $project = $this->model->getById($id);
            if (!$project) {
                $_SESSION['message'] = "Projet non trouvé";
                $_SESSION['message_type'] = "error";
                header('Location: index.php?action=back-list');
                exit();
            }
            require_once dirname(__DIR__) . '/view/backoffice/portfolio_form.php';
        }
    }
    
    public function backDelete($id) {
        $this->checkAdmin();
        
        if ($this->model->delete($id)) {
            $_SESSION['message'] = "Projet supprimé avec succès !";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Erreur lors de la suppression";
            $_SESSION['message_type'] = "error";
        }
        
        header('Location: index.php?action=back-list');
        exit();
    }
    
    // ========== GESTION DES TÂCHES ==========
    
    public function backTasks($project_id) {
        $this->checkAdmin();
        $project = $this->model->getById($project_id);
        if (!$project) {
            $_SESSION['message'] = "Projet non trouvé";
            header('Location: index.php?action=back-list');
            exit();
        }
        $tasks = $this->model->getTasksByProject($project_id);
        $members = $this->model->getProjectMembers($project_id);
        require_once dirname(__DIR__) . '/view/backoffice/tasks_list.php';
    }
    
    public function backCreateTask($project_id) {
        $this->checkAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST['portfolio_id'] = $project_id;
            $result = $this->model->createTask($_POST);
            
            if ($result['success']) {
                $_SESSION['message'] = "Tâche ajoutée avec succès !";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Erreur lors de l'ajout de la tâche";
                $_SESSION['message_type'] = "error";
                $_SESSION['task_errors'] = $result['errors'] ?? [];
            }
            
            header('Location: index.php?action=back-tasks&id=' . $project_id);
            exit();
        }
        
        $project = $this->model->getById($project_id);
        require_once dirname(__DIR__) . '/view/backoffice/task_form.php';
    }
    
    public function backEditTask($task_id) {
        $this->checkAdmin();
        $task = $this->model->getTaskById($task_id);
        
        if (!$task) {
            $_SESSION['message'] = "Tâche non trouvée";
            header('Location: index.php?action=back-list');
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->model->updateTask($task_id, $_POST);
            
            if ($result['success']) {
                $_SESSION['message'] = "Tâche modifiée avec succès !";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Erreur lors de la modification";
                $_SESSION['message_type'] = "error";
            }
            
            header('Location: index.php?action=back-tasks&id=' . $task['portfolio_id']);
            exit();
        }
        
        $project = $this->model->getById($task['portfolio_id']);
        require_once dirname(__DIR__) . '/view/backoffice/task_form.php';
    }
    
    public function backDeleteTask($task_id) {
        $this->checkAdmin();
        $task = $this->model->getTaskById($task_id);
        
        if ($task && $this->model->deleteTask($task_id)) {
            $_SESSION['message'] = "Tâche supprimée avec succès !";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Erreur lors de la suppression";
            $_SESSION['message_type'] = "error";
        }
        
        header('Location: index.php?action=back-tasks&id=' . ($task['portfolio_id'] ?? 0));
        exit();
    }
    
    public function backUpdateTaskStatus() {
        $this->checkAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $task_id = $_POST['task_id'] ?? null;
            $status = $_POST['status'] ?? null;
            $project_id = $_POST['project_id'] ?? null;
            
            if ($task_id && $status) {
                $this->model->updateTaskStatus($task_id, $status);
                $_SESSION['message'] = "Statut mis à jour !";
            }
            
            header('Location: index.php?action=back-tasks&id=' . $project_id);
            exit();
        }
    }
    
    // ========== GESTION DES MEMBRES ==========
    
    public function backAddMember($project_id) {
        $this->checkAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->model->addProjectMember(
                $project_id,
                $_POST['member_name'],
                $_POST['member_email'] ?? '',
                $_POST['role'] ?? 'contributor'
            );
            
            if ($result['success']) {
                $_SESSION['message'] = "Membre ajouté avec succès !";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = $result['error'] ?? "Erreur lors de l'ajout";
                $_SESSION['message_type'] = "error";
            }
            
            header('Location: index.php?action=back-tasks&id=' . $project_id);
            exit();
        }
    }
    
    public function backRemoveMember($member_id, $project_id) {
        $this->checkAdmin();
        
        if ($this->model->removeProjectMember($member_id)) {
            $_SESSION['message'] = "Membre retiré avec succès !";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Erreur lors du retrait";
            $_SESSION['message_type'] = "error";
        }
        
        header('Location: index.php?action=back-tasks&id=' . $project_id);
        exit();
    }
}
?>