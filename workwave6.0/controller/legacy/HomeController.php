<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once dirname(__DIR__, 2) . '/model/legacy/JobModel.php';
require_once dirname(__DIR__, 2) . '/model/legacy/PortfolioModel.php';

class HomeController {
    public function index() {
        $jobs = [];
        $portfolios = [];
        $databaseError = null;

        try {
            $jobModel = new JobModel();
            $portfolioModel = new PortfolioModel();
            
            $jobs = $jobModel->getApprovedJobs();
            $portfolios = $portfolioModel->getApprovedPortfolios(6); // Limit to 6
        } catch (Throwable $e) {
            $databaseError = $e->getMessage();
        }
        
        require_once dirname(__DIR__, 2) . '/view/legacy/frontoffice/home.php';
    }
}
?>

