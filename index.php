<?php
session_start();
require_once __DIR__ . '/config/autoload.php';

$action = $_GET['action'] ?? 'dashboard';

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

// Login
if (isset($_POST['login'])) {
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');
    $role     = $_POST['role']          ?? '';

    if ($email && $password && in_array($role, ['manager','client'])) {
        $pdo   = getDB();
        $table = $role === 'manager' ? 'managers' : 'clients';
        $s     = $pdo->prepare("SELECT * FROM {$table} WHERE email = ?");
        $s->execute([$email]);
        $user  = $s->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['role']    = $role;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom']   = $user['prenom'] . ' ' . $user['nom'];
            header('Location: index.php?role=' . $role . '&action=dashboard');
            exit;
        } else {
            $_SESSION['login_error'] = 'Email ou mot de passe incorrect.';
        }
    } else {
        $_SESSION['login_error'] = 'Veuillez remplir tous les champs.';
    }
}

// Route
if (!empty($_SESSION['role']) && !empty($_SESSION['user_id'])) {
    $role = $_SESSION['role'];
    if ($role === 'manager') {
        (new ManagerController())->handle($action);
    } else {
        (new ClientController())->handle($action);
    }
} else {
    $guestAction = $_GET['action'] ?? 'login';
    if ($guestAction === 'register') {
        showRegister();
    } else {
        showLogin();
    }
}

function showLogin(): void {
    $error = $_SESSION['login_error'] ?? null;
    unset($_SESSION['login_error']);
    require __DIR__ . '/View/frontoffice/login.php';
}

function showRegister(): void {
    require __DIR__ . '/View/frontoffice/register.php';
}
