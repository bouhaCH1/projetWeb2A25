<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$action = $_GET['action'] ?? 'home';

switch($action) {
    // ========== FRONTOFFICE ==========
    case 'home':
        require_once 'controller/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
        
    case 'front-list':
        require_once 'model/PortfolioModel.php';
        $model = new PortfolioModel();
        $portfolios = $model->getApprovedPortfolios();
        require_once 'view/frontoffice/portfolio_list.php';
        break;
        
    case 'front-detail':
        $id = $_GET['id'] ?? null;
        require_once 'model/PortfolioModel.php';
        $model = new PortfolioModel();
        $portfolio = $model->getById($id);
        require_once 'view/frontoffice/portfolio_detail.php';
        break;
    
    // ========== AUTH ==========
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
        
    case 'register':
        require_once 'controller/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;
    
    // ========== ADMIN ==========
    case 'admin-dashboard':
        require_once 'controller/AdminController.php';
        $controller = new AdminController();
        $controller->dashboard();
        break;
        
    case 'admin-pending-portfolios':
        require_once 'controller/AdminController.php';
        $controller = new AdminController();
        $controller->pendingPortfolios();
        break;
        
    case 'admin-approved-portfolios':
        require_once 'controller/AdminController.php';
        $controller = new AdminController();
        $controller->approvedPortfolios();
        break;
        
    case 'admin-approve':
        $id = $_GET['id'] ?? null;
        require_once 'controller/AdminController.php';
        $controller = new AdminController();
        $controller->approvePortfolio($id);
        break;
        
    case 'admin-reject':
        $id = $_GET['id'] ?? null;
        require_once 'controller/AdminController.php';
        $controller = new AdminController();
        $controller->rejectPortfolio($id);
        break;
        
    case 'admin-view-pending':
        $id = $_GET['id'] ?? null;
        require_once 'controller/AdminController.php';
        $controller = new AdminController();
        $controller->viewPendingPortfolio($id);
        break;
        
    case 'admin-candidats':
        require_once 'controller/AdminController.php';
        $controller = new AdminController();
        $controller->candidats();
        break;
        
    case 'admin-entreprises':
        require_once 'controller/AdminController.php';
        $controller = new AdminController();
        $controller->entreprises();
        break;
        
    case 'admin-mark-notification':
        $id = $_GET['id'] ?? null;
        require_once 'controller/AdminController.php';
        $controller = new AdminController();
        $controller->markNotificationRead($id);
        break;

    case 'admin-pending-jobs':
        require_once 'controller/AdminController.php';
        $controller = new AdminController();
        $controller->pendingJobs();
        break;

    case 'admin-approve-job':
        $id = $_GET['id'] ?? null;
        require_once 'controller/AdminController.php';
        $controller = new AdminController();
        $controller->approveJob($id);
        break;

    case 'admin-reject-job':
        $id = $_GET['id'] ?? null;
        require_once 'controller/AdminController.php';
        $controller = new AdminController();
        $controller->rejectJob($id);
        break;
    
    // ========== CANDIDAT ==========
    case 'candidat-dashboard':
        require_once 'controller/CandidatController.php';
        $controller = new CandidatController();
        $controller->dashboard();
        break;
        
    case 'candidat-submit':
        require_once 'controller/CandidatController.php';
        $controller = new CandidatController();
        $controller->submitPortfolio();
        break;
        
    case 'candidat-edit':
        $id = $_GET['id'] ?? null;
        require_once 'controller/CandidatController.php';
        $controller = new CandidatController();
        $controller->editPortfolio($id);
        break;
        
    case 'candidat-delete':
        $id = $_GET['id'] ?? null;
        require_once 'controller/CandidatController.php';
        $controller = new CandidatController();
        $controller->deletePortfolio($id);
        break;
        
    case 'candidat-mark-notification':
        $id = $_GET['id'] ?? null;
        require_once 'controller/CandidatController.php';
        $controller = new CandidatController();
        $controller->markNotificationRead($id);
        break;

    case 'candidat-job-detail':
        $id = $_GET['id'] ?? null;
        require_once 'controller/CandidatController.php';
        $controller = new CandidatController();
        $controller->jobDetail($id);
        break;

    case 'candidat-apply-job':
        $id = $_GET['id'] ?? null;
        require_once 'controller/CandidatController.php';
        $controller = new CandidatController();
        $controller->applyJob($id);
        break;
    
    // ========== ENTREPRISE ==========
    case 'entreprise-dashboard':
        require_once 'controller/EntrepriseController.php';
        $controller = new EntrepriseController();
        $controller->dashboard();
        break;
        
    case 'entreprise-view':
        $id = $_GET['id'] ?? null;
        require_once 'controller/EntrepriseController.php';
        $controller = new EntrepriseController();
        $controller->viewPortfolio($id);
        break;
        
    case 'entreprise-mark-notification':
        $id = $_GET['id'] ?? null;
        require_once 'controller/EntrepriseController.php';
        $controller = new EntrepriseController();
        $controller->markNotificationRead($id);
        break;

    case 'entreprise-submit-job':
        require_once 'controller/EntrepriseController.php';
        $controller = new EntrepriseController();
        $controller->submitJob();
        break;

    case 'entreprise-applications':
        $id = $_GET['job_id'] ?? null;
        require_once 'controller/EntrepriseController.php';
        $controller = new EntrepriseController();
        $controller->viewApplications($id);
        break;

    case 'entreprise-update-application':
        $id = $_GET['id'] ?? null;
        $status = $_GET['status'] ?? null;
        require_once 'controller/EntrepriseController.php';
        $controller = new EntrepriseController();
        $controller->updateApplication($id, $status);
        break;
    
    default:
        require_once 'controller/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
}
?>