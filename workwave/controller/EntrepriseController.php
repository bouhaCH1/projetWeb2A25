<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once dirname(__DIR__) . '/model/PortfolioModel.php';
require_once dirname(__DIR__) . '/model/JobModel.php';

class EntrepriseController {
    private $model;
    private $jobModel;
    
    public function __construct() {
        $this->model = new PortfolioModel();
        $this->jobModel = new JobModel();
    }
    
    private function checkEntreprise() {
        $role = strtolower($_SESSION['user']['role'] ?? '');
        if (!isset($_SESSION['user']) || $role !== 'entreprise') {
            header('Location: index.php?action=login');
            exit();
        }
    }
    
    public function dashboard() {
        $this->checkEntreprise();
        $portfolios = $this->model->getApprovedPortfolios();
        $myJobs = $this->jobModel->getEnterpriseJobs($_SESSION['user']['id']);
        $notifications = $this->model->getUserNotifications($_SESSION['user']['id']);
        $unreadCount = $this->model->getUnreadNotificationsCount($_SESSION['user']['id']);
        require_once dirname(__DIR__) . '/view/entreprise/dashboard.php';
    }
    
    public function viewPortfolio($id) {
        $this->checkEntreprise();
        $portfolio = $this->model->getById($id);
        
        if (!$portfolio || $portfolio['is_approved'] != 1) {
            $_SESSION['message'] = "Portfolio non disponible";
            header('Location: index.php?action=entreprise-dashboard');
            exit();
        }
        
        require_once dirname(__DIR__) . '/view/entreprise/portfolio_detail.php';
    }
    
    public function submitJob() {
        $this->checkEntreprise();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $company_name = $_SESSION['user']['company'] ?? $_SESSION['user']['full_name'];
            $result = $this->jobModel->submitJob($_POST, $_SESSION['user']['id'], $company_name);
            
            if ($result['success']) {
                $_SESSION['message'] = "Offre d'emploi soumise ! En attente de validation.";
                $_SESSION['message_type'] = "success";
                header('Location: index.php?action=entreprise-dashboard');
                exit();
            }
        }
        require_once dirname(__DIR__) . '/view/entreprise/job_form.php';
    }

    public function viewApplications($job_id) {
        $this->checkEntreprise();
        $job = $this->jobModel->getJobById($job_id);
        if (!$job || $job['entreprise_id'] != $_SESSION['user']['id']) {
            $_SESSION['message'] = "Accès refusé.";
            header('Location: index.php?action=entreprise-dashboard');
            exit();
        }
        
        $applications = $this->jobModel->getJobApplications($job_id, $_SESSION['user']['id']);
        require_once dirname(__DIR__) . '/view/entreprise/applications.php';
    }

    public function updateApplication($id, $status) {
        $this->checkEntreprise();
        if ($status !== 'accepted' && $status !== 'rejected') {
            header('Location: index.php?action=entreprise-dashboard');
            exit();
        }
        
        $result = $this->jobModel->updateApplicationStatus($id, $_SESSION['user']['id'], $status);
        if ($result) {
            $_SESSION['message'] = "Statut de la candidature mis à jour.";
            $_SESSION['message_type'] = "success";
        }
        
        // Go back to the previous page (applications list)
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
    
    public function markNotificationRead($notification_id) {
        $this->checkEntreprise();
        $this->model->markNotificationAsRead($notification_id, $_SESSION['user']['id']);
        header('Location: index.php?action=entreprise-dashboard');
        exit();
    }
}
?>