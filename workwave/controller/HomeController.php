<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once dirname(__DIR__) . '/model/JobModel.php';
require_once dirname(__DIR__) . '/model/PortfolioModel.php';

class HomeController {
    public function index() {
        $jobModel = new JobModel();
        $portfolioModel = new PortfolioModel();
        
        $jobs = $jobModel->getApprovedJobs();
        $portfolios = $portfolioModel->getApprovedPortfolios(6); // Limit to 6
        
        require_once dirname(__DIR__) . '/view/frontoffice/home.php';
    }
}
?>
