<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Récupérer l'action depuis l'URL
$action = $_GET['action'] ?? 'front-list';

// Routage des actions
switch($action) {
    // ========== FRONTOFFICE ==========
    case 'front-list':
        require_once 'controller/PortfolioController.php';
        $controller = new PortfolioController();
        $controller->frontList();
        break;
        
    case 'front-detail':
        $id = $_GET['id'] ?? null;
        require_once 'controller/PortfolioController.php';
        $controller = new PortfolioController();
        $controller->frontDetail($id);
        break;
    
    case 'add-comment':
        require_once 'controller/PortfolioController.php';
        $controller = new PortfolioController();
        $controller->addComment();
        break;
    
    // ========== BACKOFFICE - AUTHENTIFICATION ==========
    case 'login':
        require_once 'controller/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;
        
    case 'logout':
        require_once 'controller/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;
    
    // ========== BACKOFFICE - GESTION PROJETS ==========
    case 'back-dashboard':
        require_once 'controller/PortfolioController.php';
        $controller = new PortfolioController();
        $controller->backDashboard();
        break;
        
    case 'back-list':
        require_once 'controller/PortfolioController.php';
        $controller = new PortfolioController();
        $controller->backList();
        break;
        
    case 'back-create':
        require_once 'controller/PortfolioController.php';
        $controller = new PortfolioController();
        $controller->backCreate();
        break;
        
    case 'back-edit':
        $id = $_GET['id'] ?? null;
        require_once 'controller/PortfolioController.php';
        $controller = new PortfolioController();
        $controller->backEdit($id);
        break;
        
    case 'back-delete':
        $id = $_GET['id'] ?? null;
        require_once 'controller/PortfolioController.php';
        $controller = new PortfolioController();
        $controller->backDelete($id);
        break;
    
    // ========== BACKOFFICE - GESTION TÂCHES ==========
    case 'back-tasks':
        $id = $_GET['id'] ?? null;
        require_once 'controller/PortfolioController.php';
        $controller = new PortfolioController();
        $controller->backTasks($id);
        break;
        
    case 'back-create-task':
        $id = $_GET['id'] ?? null;
        require_once 'controller/PortfolioController.php';
        $controller = new PortfolioController();
        $controller->backCreateTask($id);
        break;
        
    case 'back-edit-task':
        $id = $_GET['id'] ?? null;
        require_once 'controller/PortfolioController.php';
        $controller = new PortfolioController();
        $controller->backEditTask($id);
        break;
        
    case 'back-delete-task':
        $id = $_GET['id'] ?? null;
        require_once 'controller/PortfolioController.php';
        $controller = new PortfolioController();
        $controller->backDeleteTask($id);
        break;
        
    case 'back-update-task-status':
        require_once 'controller/PortfolioController.php';
        $controller = new PortfolioController();
        $controller->backUpdateTaskStatus();
        break;
    
    // ========== BACKOFFICE - GESTION MEMBRES ==========
    case 'back-add-member':
        $id = $_GET['id'] ?? null;
        require_once 'controller/PortfolioController.php';
        $controller = new PortfolioController();
        $controller->backAddMember($id);
        break;
        
    case 'back-remove-member':
        $member_id = $_GET['member_id'] ?? null;
        $project_id = $_GET['project_id'] ?? null;
        require_once 'controller/PortfolioController.php';
        $controller = new PortfolioController();
        $controller->backRemoveMember($member_id, $project_id);
        break;
        
    // ========== PAGE PAR DÉFAUT ==========
    default:
        require_once 'controller/PortfolioController.php';
        $controller = new PortfolioController();
        $controller->frontList();
        break;
}
?>