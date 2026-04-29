<?php
$role        = $_SESSION['user_role'] ?? '';
$userName    = htmlspecialchars(($_SESSION['user_first_name'] ?? '') . ' ' . ($_SESSION['user_last_name'] ?? ''));
$userPic     = $_SESSION['user_pic'] ?? '';
$userInitial = strtoupper(substr($_SESSION['user_first_name'] ?? 'U', 0, 1));
$action      = $_GET['action'] ?? '';
$pageTitle   = $pageTitle ?? 'Dashboard';

$userPicPath = !empty($userPic) ? '/workwave/' . htmlspecialchars($userPic) : '/workwave/View/assets/darkpan/img/user.jpg';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($pageTitle) ?> — WorkWave</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="/workwave/View/assets/darkpan/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="/workwave/View/assets/darkpan/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="/workwave/View/assets/darkpan/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/workwave/View/assets/darkpan/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="/workwave/View/assets/darkpan/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="/workwave/Controller/index.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary">WorkWave</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="<?= $userPicPath ?>" alt="" style="width: 40px; height: 40px; object-fit: cover;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?= $userName ?></h6>
                        <span><?= ($role === 'admin') ? 'Administrateur' : (($role === 'employer') ? 'Employeur' : 'Candidat') ?></span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <?php if ($role === 'admin'): ?>
                        <a href="/workwave/Controller/index.php?action=admin_dashboard" class="nav-item nav-link <?= $action === 'admin_dashboard' ? 'active' : '' ?>"><i class="fa fa-tachometer-alt me-2"></i>Tableau de bord</a>
                        <a href="/workwave/Controller/index.php?action=profile" class="nav-item nav-link <?= $action === 'profile' ? 'active' : '' ?>"><i class="fa fa-user me-2"></i>Mon Profil</a>
                        <a href="/workwave/Controller/index.php?action=admin_users" class="nav-item nav-link <?= $action === 'admin_users' ? 'active' : '' ?>"><i class="fa fa-users me-2"></i>Utilisateurs</a>
                        <a href="/workwave/Controller/index.php?action=security" class="nav-item nav-link <?= $action === 'security' ? 'active' : '' ?>"><i class="fa fa-shield-alt me-2"></i>Sécurité</a>
                    <?php elseif ($role === 'employer'): ?>
                        <a href="/workwave/Controller/index.php?action=dashboard_employer" class="nav-item nav-link <?= $action === 'dashboard_employer' ? 'active' : '' ?>"><i class="fa fa-tachometer-alt me-2"></i>Tableau de bord</a>
                        <a href="/workwave/Controller/index.php?action=profile" class="nav-item nav-link <?= $action === 'profile' ? 'active' : '' ?>"><i class="fa fa-building me-2"></i>Mon Profil</a>
                    <?php else: ?>
                        <a href="/workwave/Controller/index.php?action=dashboard_seeker" class="nav-item nav-link <?= $action === 'dashboard_seeker' ? 'active' : '' ?>"><i class="fa fa-tachometer-alt me-2"></i>Tableau de bord</a>
                        <a href="/workwave/Controller/index.php?action=profile" class="nav-item nav-link <?= $action === 'profile' ? 'active' : '' ?>"><i class="fa fa-user me-2"></i>Mon Profil</a>
                    <?php endif; ?>
                    <a href="/workwave/Controller/index.php" class="nav-item nav-link"><i class="fa fa-home me-2"></i>Site public</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="/workwave/Controller/index.php" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0">WW</h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="<?= $userPicPath ?>" alt="" style="width: 40px; height: 40px; object-fit: cover;">
                            <span class="d-none d-lg-inline-flex"><?= $userName ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="/workwave/Controller/index.php?action=profile" class="dropdown-item">My Profile</a>
                            <a href="/workwave/Controller/index.php?action=security" class="dropdown-item">Settings</a>
                            <a href="/workwave/Controller/index.php?action=logout" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <div class="container-fluid pt-4 px-4">
