<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once dirname(__DIR__) . '/model/PortfolioModel.php';
require_once dirname(__DIR__) . '/model/JobModel.php';
require_once dirname(__DIR__) . '/model/Database.php';

class AdminController {
    private $model;
    private $jobModel;
    
    public function __construct() {
        $this->model = new PortfolioModel();
        $this->jobModel = new JobModel();
    }
    
    private function checkAdmin() {
        $role = strtolower($_SESSION['user']['role'] ?? '');
        if (!isset($_SESSION['user']) || $role !== 'admin') {
            header('Location: index.php?action=login');
            exit();
        }
    }
    
    public function dashboard() {
        $this->checkAdmin();
        $stats = $this->model->getStats();
        $pendingPortfolios = $this->model->getPendingPortfolios();
        $pendingJobs = $this->jobModel->getPendingJobs();
        $notifications = $this->model->getUserNotifications($_SESSION['user']['id']);
        $unreadCount = $this->model->getUnreadNotificationsCount($_SESSION['user']['id']);
        require_once dirname(__DIR__) . '/view/admin/dashboard.php';
    }
    
    // PORTFOLIOS
    public function pendingPortfolios() {
        $this->checkAdmin();
        $portfolios = $this->model->getPendingPortfolios();
        require_once dirname(__DIR__) . '/view/admin/pending_portfolios.php';
    }
    
    public function approvedPortfolios() {
        $this->checkAdmin();
        $portfolios = $this->model->getApprovedPortfolios();
        require_once dirname(__DIR__) . '/view/admin/approved_portfolios.php';
    }
    
    public function approvePortfolio($id) {
        $this->checkAdmin();
        $this->model->approvePortfolio($id);
        header('Location: index.php?action=admin-pending-portfolios');
        exit();
    }
    
    public function rejectPortfolio($id) {
        $this->checkAdmin();
        $this->model->rejectPortfolio($id);
        header('Location: index.php?action=admin-pending-portfolios');
        exit();
    }
    
    public function viewPendingPortfolio($id) {
        $this->checkAdmin();
        $portfolio = $this->model->getById($id);
        require_once dirname(__DIR__) . '/view/admin/view_pending.php';
    }

    // JOBS
    public function pendingJobs() {
        $this->checkAdmin();
        $jobs = $this->jobModel->getPendingJobs();
        require_once dirname(__DIR__) . '/view/admin/pending_jobs.php';
    }

    public function approveJob($id) {
        $this->checkAdmin();
        $this->jobModel->approveJob($id);
        $_SESSION['message'] = "Offre d'emploi validée !";
        $_SESSION['message_type'] = "success";
        header('Location: index.php?action=admin-dashboard');
        exit();
    }

    public function rejectJob($id) {
        $this->checkAdmin();
        $this->jobModel->rejectJob($id);
        $_SESSION['message'] = "Offre d'emploi refusée !";
        $_SESSION['message_type'] = "success";
        header('Location: index.php?action=admin-dashboard');
        exit();
    }
    
    // OTHERS
    public function candidats() {
        $this->checkAdmin();
        $db = Database::getInstance()->getConnection();
        $sql = "SELECT * FROM users WHERE role = 'candidat' ORDER BY created_at DESC";
        $stmt = $db->query($sql);
        $candidats = $stmt->fetchAll();
        require_once dirname(__DIR__) . '/view/admin/candidats.php';
    }
    
    public function entreprises() {
        $this->checkAdmin();
        $db = Database::getInstance()->getConnection();
        $sql = "SELECT * FROM users WHERE role = 'entreprise' ORDER BY created_at DESC";
        $stmt = $db->query($sql);
        $entreprises = $stmt->fetchAll();
        require_once dirname(__DIR__) . '/view/admin/entreprises.php';
    }
    
    public function markNotificationRead($notification_id) {
        $this->checkAdmin();
        $this->model->markNotificationAsRead($notification_id, $_SESSION['user']['id']);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>