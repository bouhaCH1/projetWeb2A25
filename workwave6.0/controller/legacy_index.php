<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name('WORKWAVESESSID');
    session_start();
}

$action = $_GET['action'] ?? 'home';

try {
switch($action) {
    // ========== FRONTOFFICE ==========
    case 'home':
        require_once __DIR__ . '/legacy/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
        
    case 'front-list':
        require_once __DIR__ . '/../model/legacy/PortfolioModel.php';
        $model = new PortfolioModel();
        $portfolios = $model->getApprovedPortfolios();
        require_once __DIR__ . '/../view/legacy/frontoffice/portfolio_list.php';
        break;
        
    case 'front-detail':
        $id = $_GET['id'] ?? null;
        require_once __DIR__ . '/../model/legacy/PortfolioModel.php';
        $model = new PortfolioModel();
        $portfolio = $model->getById($id);
        require_once __DIR__ . '/../view/legacy/frontoffice/portfolio_detail.php';
        break;
    
    // ========== AUTH ==========
    case 'login':
        require_once __DIR__ . '/legacy/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;
        
    case 'logout':
        require_once __DIR__ . '/legacy/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;
        
    case 'register':
        require_once __DIR__ . '/legacy/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;
    
    // ========== ADMIN ==========
    case 'admin-dashboard':
        require_once __DIR__ . '/legacy/AdminController.php';
        $controller = new AdminController();
        $controller->dashboard();
        break;
        
    case 'admin-pending-portfolios':
        require_once __DIR__ . '/legacy/AdminController.php';
        $controller = new AdminController();
        $controller->pendingPortfolios();
        break;
        
    case 'admin-approved-portfolios':
        require_once __DIR__ . '/legacy/AdminController.php';
        $controller = new AdminController();
        $controller->approvedPortfolios();
        break;
        
    case 'admin-approve':
        $id = $_GET['id'] ?? null;
        require_once __DIR__ . '/legacy/AdminController.php';
        $controller = new AdminController();
        $controller->approvePortfolio($id);
        break;
        
    case 'admin-reject':
        $id = $_GET['id'] ?? null;
        require_once __DIR__ . '/legacy/AdminController.php';
        $controller = new AdminController();
        $controller->rejectPortfolio($id);
        break;
        
    case 'admin-view-pending':
        $id = $_GET['id'] ?? null;
        require_once __DIR__ . '/legacy/AdminController.php';
        $controller = new AdminController();
        $controller->viewPendingPortfolio($id);
        break;
        
    case 'admin-candidats':
        require_once __DIR__ . '/legacy/AdminController.php';
        $controller = new AdminController();
        $controller->candidats();
        break;
        
    case 'admin-entreprises':
        require_once __DIR__ . '/legacy/AdminController.php';
        $controller = new AdminController();
        $controller->entreprises();
        break;
        
    case 'admin-mark-notification':
        $id = $_GET['id'] ?? null;
        require_once __DIR__ . '/legacy/AdminController.php';
        $controller = new AdminController();
        $controller->markNotificationRead($id);
        break;

    case 'admin-pending-jobs':
        require_once __DIR__ . '/legacy/AdminController.php';
        $controller = new AdminController();
        $controller->pendingJobs();
        break;

    case 'admin-approve-job':
        $id = $_GET['id'] ?? null;
        require_once __DIR__ . '/legacy/AdminController.php';
        $controller = new AdminController();
        $controller->approveJob($id);
        break;

    case 'admin-reject-job':
        $id = $_GET['id'] ?? null;
        require_once __DIR__ . '/legacy/AdminController.php';
        $controller = new AdminController();
        $controller->rejectJob($id);
        break;
    
    // ========== CANDIDAT ==========
    case 'candidat-dashboard':
        require_once __DIR__ . '/legacy/CandidatController.php';
        $controller = new CandidatController();
        $controller->dashboard();
        break;
        
    case 'candidat-submit':
        require_once __DIR__ . '/legacy/CandidatController.php';
        $controller = new CandidatController();
        $controller->submitPortfolio();
        break;
        
    case 'candidat-edit':
        $id = $_GET['id'] ?? null;
        require_once __DIR__ . '/legacy/CandidatController.php';
        $controller = new CandidatController();
        $controller->editPortfolio($id);
        break;
        
    case 'candidat-delete':
        $id = $_GET['id'] ?? null;
        require_once __DIR__ . '/legacy/CandidatController.php';
        $controller = new CandidatController();
        $controller->deletePortfolio($id);
        break;
        
    case 'candidat-mark-notification':
        $id = $_GET['id'] ?? null;
        require_once __DIR__ . '/legacy/CandidatController.php';
        $controller = new CandidatController();
        $controller->markNotificationRead($id);
        break;

    case 'candidat-job-detail':
        $id = $_GET['id'] ?? null;
        require_once __DIR__ . '/legacy/CandidatController.php';
        $controller = new CandidatController();
        $controller->jobDetail($id);
        break;

    case 'candidat-apply-job':
        $id = $_GET['id'] ?? null;
        require_once __DIR__ . '/legacy/CandidatController.php';
        $controller = new CandidatController();
        $controller->applyJob($id);
        break;
    
    // ========== ENTREPRISE ==========
    case 'entreprise-dashboard':
        require_once __DIR__ . '/legacy/EntrepriseController.php';
        $controller = new EntrepriseController();
        $controller->dashboard();
        break;
        
    case 'entreprise-view':
        $id = $_GET['id'] ?? null;
        require_once __DIR__ . '/legacy/EntrepriseController.php';
        $controller = new EntrepriseController();
        $controller->viewPortfolio($id);
        break;
        
    case 'entreprise-mark-notification':
        $id = $_GET['id'] ?? null;
        require_once __DIR__ . '/legacy/EntrepriseController.php';
        $controller = new EntrepriseController();
        $controller->markNotificationRead($id);
        break;

    case 'entreprise-submit-job':
        require_once __DIR__ . '/legacy/EntrepriseController.php';
        $controller = new EntrepriseController();
        $controller->submitJob();
        break;

    case 'entreprise-applications':
        $id = $_GET['job_id'] ?? null;
        require_once __DIR__ . '/legacy/EntrepriseController.php';
        $controller = new EntrepriseController();
        $controller->viewApplications($id);
        break;

    case 'entreprise-update-application':
        $id = $_GET['id'] ?? null;
        $status = $_GET['status'] ?? null;
        require_once __DIR__ . '/legacy/EntrepriseController.php';
        $controller = new EntrepriseController();
        $controller->updateApplication($id, $status);
        break;
    
    default:
        require_once __DIR__ . '/legacy/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
}
} catch (Throwable $e) {
    http_response_code(503);
    $templateMessage = $e->getMessage();
    $isDatabaseConnectionError = stripos($templateMessage, 'not reachable') !== false
        || stripos($templateMessage, 'not ready') !== false
        || stripos($templateMessage, 'Connection failed') !== false;
    require_once __DIR__ . '/../view/legacy/layout/header.php';
    ?>
    <section class="dashboard-section">
        <div class="ww-section">
            <div class="ww-card">
                <h1>Service temporairement indisponible</h1>
                <p class="ww-muted">MySQL est démarré dans XAMPP, mais il ne répond pas encore aux connexions. Redémarre MySQL puis actualise la page.</p>
                <p class="ww-muted"><?= htmlspecialchars($templateMessage) ?></p>
                <a href="index.php" class="btn">Retour à l'accueil</a>
            </div>
        </div>
    </section>
    <?php
    require_once __DIR__ . '/../view/legacy/layout/footer.php';
}
?>

