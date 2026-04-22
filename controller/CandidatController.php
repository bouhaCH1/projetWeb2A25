<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once dirname(__DIR__) . '/model/PortfolioModel.php';
require_once dirname(__DIR__) . '/model/JobModel.php';

class CandidatController {
    private $model;
    private $jobModel;
    
    public function __construct() {
        $this->model = new PortfolioModel();
        $this->jobModel = new JobModel();
    }
    
    private function checkCandidat() {
        $role = strtolower($_SESSION['user']['role'] ?? '');
        if (!isset($_SESSION['user']) || ($role !== 'candidat' && $role !== 'client' && $role !== 'condidat')) {
            header('Location: index.php?action=login');
            exit();
        }
    }
    
    public function dashboard() {
        $this->checkCandidat();
        $portfolios = $this->model->getCandidatPortfolios($_SESSION['user']['id']);
        $jobs = $this->jobModel->getApprovedJobs();
        $myApplications = $this->jobModel->getCandidatApplications($_SESSION['user']['id']);
        $notifications = $this->model->getUserNotifications($_SESSION['user']['id']);
        $unreadCount = $this->model->getUnreadNotificationsCount($_SESSION['user']['id']);
        require_once dirname(__DIR__) . '/view/candidat/dashboard.php';
    }
    
    public function submitPortfolio() {
        $this->checkCandidat();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->model->submitPortfolio($_POST, $_SESSION['user']['id'], $_SESSION['user']['username'], $_SESSION['user']['company'] ?? $_SESSION['user']['full_name']);
            if ($result['success']) {
                $_SESSION['message'] = "Portfolio soumis avec succès ! En attente de validation.";
                $_SESSION['message_type'] = "success";
                header('Location: index.php?action=candidat-dashboard');
                exit();
            }
        }
        require_once dirname(__DIR__) . '/view/candidat/portfolio_form.php';
    }
    
    public function editPortfolio($id) {
        $this->checkCandidat();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->model->updateCandidatPortfolio($id, $_POST, $_SESSION['user']['id']);
            if ($result['success']) {
                $_SESSION['message'] = "Portfolio modifié avec succès !";
                $_SESSION['message_type'] = "success";
                header('Location: index.php?action=candidat-dashboard');
                exit();
            }
        }
        $portfolio = $this->model->getById($id);
        require_once dirname(__DIR__) . '/view/candidat/portfolio_form.php';
    }
    
    public function deletePortfolio($id) {
        $this->checkCandidat();
        $this->model->deleteCandidatPortfolio($id, $_SESSION['user']['id']);
        header('Location: index.php?action=candidat-dashboard');
        exit();
    }

    public function jobDetail($id) {
        $this->checkCandidat();
        $job = $this->jobModel->getJobById($id);
        require_once dirname(__DIR__) . '/view/candidat/job_detail.php';
    }

    public function applyJob($job_id) {
        $this->checkCandidat();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $message = $_POST['message'] ?? '';
            $result = $this->jobModel->applyToJob($job_id, $_SESSION['user']['id'], $message, $_SESSION['user']['full_name']);
            
            if ($result['success']) {
                $_SESSION['message'] = "Candidature envoyée avec succès !";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = $result['error'] ?? "Erreur lors de la candidature.";
                $_SESSION['message_type'] = "danger";
            }
        }
        header('Location: index.php?action=candidat-dashboard');
        exit();
    }
    
    public function markNotificationRead($notification_id) {
        $this->checkCandidat();
        $this->model->markNotificationAsRead($notification_id, $_SESSION['user']['id']);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>