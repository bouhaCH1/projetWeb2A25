<?php

session_start();

require_once __DIR__ . '/UserController.php';
require_once __DIR__ . '/JobController.php';

$action        = $_GET['action'] ?? 'home';
$controller    = new UserController();
$jobController = new JobController();

switch ($action) {
    case 'jobs':
        $jobController->listJobs();
        break;
    case 'job_view':
        $jobController->showJob();
        break;
    case 'job_post':
        $jobController->showPostJob();
        break;
    case 'job_post_submit':
        $jobController->postJob();
        break;
    case 'my_jobs':
        $jobController->myJobs();
        break;
    case 'job_delete':
        $jobController->deleteJob();
        break;
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
    case 'admin_login':
        $controller->showAdminLogin();
        break;
    case 'admin_login_submit':
        $controller->adminLogin();
        break;
    case 'profile':
        $controller->showProfile();
        break;
    case 'profile_update':
        $controller->updateProfile();
        break;
    case 'logout':
        $controller->logout();
        break;
    case 'dashboard_seeker':
        require_once __DIR__ . '/../View/user/dashboard_seeker.php';
        break;
    case 'dashboard_employer':
        require_once __DIR__ . '/../View/user/dashboard_employer.php';
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
    case 'home':
    default:
        require_once __DIR__ . '/../View/layout/header.php';
        require_once __DIR__ . '/../View/layout/home.php';
        require_once __DIR__ . '/../View/layout/footer.php';
        break;
}
