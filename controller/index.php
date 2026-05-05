<?php

session_start();

require_once __DIR__ . '/UserController.php';

$action = $_GET['action'] ?? 'home';
$controller = new UserController();

switch ($action) {

    case 'register':
        $controller->showRegister();
        break;
    case 'register_submit':
        $controller->register();
        break;
    case 'login':
        $controller->showLogin();
        break;
    case 'login_submit':
        $controller->login();
        break;
    case 'login_2fa':
        $controller->showLogin2FA();
        break;
    case 'login_2fa_submit':
        $controller->processLogin2FA();
        break;
    case 'send_2fa_code':
        $controller->send2FACode();
        break;
    case 'forgot_password':
        $controller->showForgotPassword();
        break;
    case 'forgot_password_submit':
        $controller->processForgotPassword();
        break;
    case 'reset_password':
        $controller->showResetPassword();
        break;
    case 'reset_password_submit':
        $controller->processResetPassword();
        break;

    case 'profile':
        $controller->showProfile();
        break;
    case 'profile_update':
        $controller->updateProfile();
        break;
    case 'security':
        $controller->showSecurity();
        break;
    case 'export_data':
        $controller->exportData();
        break;
    case 'verify_identity':
        $controller->showVerifyIdentity();
        break;
    case 'verify_identity_submit':
        $controller->processVerifyIdentity();
        break;
    case 'toggle_2fa':
        $controller->toggle2FA();
        break;
    case 'delete_account':
        $controller->selfDeleteAccount();
        break;
    case 'ai_analyze':
        $controller->showAnalyzeProfile();
        break;
    case 'ai_analyze_submit':
        $controller->analyzeProfile();
        break;
    case 'maps_api':
        // Google Maps API proxy for location-based job search
        $location = trim($_GET['location'] ?? 'Tunis');
        $apiKey = 'YOUR_GOOGLE_MAPS_API_KEY'; // Replace with real key
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($location) . "&key=$apiKey";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $resp = curl_exec($ch);
        curl_close($ch);
        header('Content-Type: application/json');
        echo $resp ?: json_encode(['status' => 'error', 'message' => 'Maps API error']);
        exit;
    case 'salary_api':
        // Salary data API for compensation insights
        $jobTitle = trim($_GET['job_title'] ?? 'developer');
        $location = trim($_GET['location'] ?? 'Tunis');
        $url = "https://api.apilayer.com/salary/salary?job_title=" . urlencode($jobTitle) . "&location=" . urlencode($location);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['apikey: YOUR_SALARY_API_KEY']);
        $resp = curl_exec($ch);
        curl_close($ch);
        header('Content-Type: application/json');
        echo $resp ?: json_encode(['status' => 'error', 'message' => 'Salary API error']);
        exit;
    case 'linkedin_import':
        // LinkedIn profile import simulation
        $controller->showLinkedInImport();
        break;
    case 'linkedin_import_submit':
        $controller->processLinkedInImport();
        break;
    case 'logout':
        $controller->logout();
        break;
    case 'dashboard_seeker':
        $controller = new UserController();
        $stats = $controller->getDashboardStats();
        require_once __DIR__ . '/../View/user/dashboard_seeker.php';
        break;
    case 'dashboard_employer':
        $controller = new UserController();
        $stats = $controller->getDashboardStats();
        require_once __DIR__ . '/../View/user/dashboard_employer.php';
        break;
    case 'interview_scheduling':
        require_once __DIR__ . '/../View/user/interview_scheduling.php';
        break;
    case 'ai_job_matching':
        require_once __DIR__ . '/../View/user/ai_job_matching.php';
        break;
    case 'ai_parse_resume':
        $aiController = new AIController();
        $resumeText = $_POST['resume_text'] ?? '';
        $result = $aiController->parseResume($resumeText);
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    case 'ai_job_match':
        $aiController = new AIController();
        $userId = (int) $_SESSION['user_id'];
        $jobId = (int) ($_POST['job_id'] ?? 0);
        $result = $aiController->calculateJobMatch($userId, $jobId);
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    case 'ai_career_recommendations':
        $aiController = new AIController();
        $userId = (int) $_SESSION['user_id'];
        $result = $aiController->getCareerRecommendations($userId);
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    case 'ai_salary_analysis':
        $aiController = new AIController();
        $userId = (int) $_SESSION['user_id'];
        $jobId = (int) ($_POST['job_id'] ?? 0);
        $result = $aiController->getSalaryAnalysis($userId, $jobId);
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    case 'ai_interview_coach':
        require_once __DIR__ . '/../View/user/ai_interview_coach.php';
        break;
    case 'job_search':
        require_once __DIR__ . '/../View/user/enhanced_job_search.php';
        break;
    case 'admin_login':
        $controller->showAdminLogin();
        break;
    case 'admin_login_submit':
        $controller->adminLogin();
        break;
    case 'admin_dashboard':
        $controller->adminDashboard();
        break;
    case 'admin_users':
        $controller->adminListUsers();
        break;
    case 'admin_add_user':
        $controller->adminShowAddUser();
        break;
    case 'admin_add_user_submit':
        $controller->adminAddUser();
        break;
    case 'admin_edit_user':
        $controller->adminEditUser();
        break;
    case 'admin_update_user':
        $controller->adminUpdateUser();
        break;
    case 'admin_delete_user':
        $controller->adminDeleteUser();
        break;
    case 'admin_toggle_user':
        $controller->adminToggleUserStatus();
        break;
    case 'admin_toggle_verify':
        $controller->adminToggleVerification();
        break;
    case 'home':
    default:
        require_once __DIR__ . '/../View/layout/pl_header.php';
        require_once __DIR__ . '/../View/layout/home.php';
        require_once __DIR__ . '/../View/layout/pl_footer.php';
        break;
}
