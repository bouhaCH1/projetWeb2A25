<?php
// index.php — Single entry point (Front Controller)

session_start();

require_once __DIR__ . '/Controller/UserController.php';

$action     = $_GET['action'] ?? 'home';
$controller = new UserController();

switch ($action) {

    // ── Front Office ─────────────────────────────────────────────────────
    case 'register':         $controller->showRegister();     break;
    case 'register_submit':  $controller->register();         break;
    case 'login':            $controller->showLogin();        break;
    case 'login_submit':     $controller->login();            break;
    case 'profile':          $controller->showProfile();      break;
    case 'profile_update':   $controller->updateProfile();    break;
    case 'logout':           $controller->logout();           break;

    // ── Dashboards ───────────────────────────────────────────────────────
    case 'dashboard_seeker':
        require_once __DIR__ . '/View/user/dashboard_seeker.php';
        break;
    case 'dashboard_employer':
        require_once __DIR__ . '/View/user/dashboard_employer.php';
        break;

    // ── Back Office ──────────────────────────────────────────────────────
    case 'admin_users':      $controller->adminListUsers();   break;
    case 'admin_edit_user':  $controller->adminEditUser();    break;
    case 'admin_update_user':$controller->adminUpdateUser();  break;
    case 'admin_delete_user':$controller->adminDeleteUser();  break;

    case 'home':
    default:
        require_once __DIR__ . '/view/layout/header.php';
        require_once __DIR__ . '/view/layout/home.php';
        require_once __DIR__ . '/view/layout/footer.php';
        break;
}
?>
