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
    case 'forgot_password':
        $controller->showForgotPassword();
        break;
    case 'forgot_password_submit':
        $controller->processForgotPassword();
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
    case 'toggle_2fa':
        $controller->toggle2FA();
        break;
    case 'delete_account':
        $controller->selfDeleteAccount();
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
