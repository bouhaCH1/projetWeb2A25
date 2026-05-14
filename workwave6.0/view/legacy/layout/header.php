<?php
$action = $_GET['action'] ?? 'home';
$isAdminTemplate = str_starts_with($action, 'admin-');
$pageTitle = $isAdminTemplate ? 'WorkWave Admin' : 'WorkWave';
$templateGeneral = '../view/frontoffice/template_generale_root';
$templateAdmin = '../view/backoffice/template_admin_root/darkpan-1.0.0';

$user = $_SESSION['user'] ?? null;
$role = strtolower($user['role'] ?? '');
if ($role === 'condidat' || $role === 'client') {
    $role = 'candidat';
}

function ww_active($currentAction, $target) {
    return $currentAction === $target ? ' active' : '';
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <?php if ($isAdminTemplate): ?>
        <link href="<?= $templateAdmin ?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= $templateAdmin ?>/css/style.css" rel="stylesheet">
        <style>
            .admin-page { padding: 24px; }
            .admin-page .dashboard-container,
            .admin-page .container { max-width: none; padding: 0; }
            .admin-page .card,
            .admin-page .glass-card,
            .admin-page .detail-card,
            .admin-page .form-container { background: var(--secondary); border: 1px solid rgba(255,255,255,.08); }
            .sidebar .nav-link.active { color: var(--primary); }
            a { text-decoration: none; }
        </style>
    <?php else: ?>
        <link rel="stylesheet" href="<?= $templateGeneral ?>/templatemo-graph-page.css">
        <style>
            .ww-content { padding-top: 110px; min-height: 80vh; }
            .ww-section { width: min(1180px, calc(100% - 32px)); margin: 0 auto 64px; }
            .ww-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 24px; }
            .dashboard-container,
            .container { width: min(1180px, calc(100% - 32px)); margin: 0 auto 64px; }
            .row { display: grid; grid-template-columns: repeat(12, 1fr); gap: 24px; }
            .col-12,
            .col-md-12,
            .col-lg-12 { grid-column: span 12; }
            .col-md-8,
            .col-lg-8 { grid-column: span 8; }
            .col-md-6,
            .col-lg-6 { grid-column: span 6; }
            .col-md-5,
            .col-lg-5 { grid-column: span 5; }
            .col-md-4,
            .col-lg-4 { grid-column: span 4; }
            .col-md-3,
            .col-lg-3 { grid-column: span 3; }
            .justify-content-center { justify-content: center; }
            .text-center { text-align: center; }
            .text-start { text-align: left; }
            .d-flex { display: flex; }
            .flex-column { flex-direction: column; }
            .gap-3 { gap: 16px; }
            .mb-0 { margin-bottom: 0; }
            .mb-3 { margin-bottom: 16px; }
            .mb-4 { margin-bottom: 24px; }
            .mb-5 { margin-bottom: 32px; }
            .mt-2 { margin-top: 8px; }
            .mt-3 { margin-top: 16px; }
            .mt-4 { margin-top: 24px; }
            .py-5 { padding-top: 48px; padding-bottom: 48px; }
            .hero-visual .dashboard-preview { background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.14); border-radius: 22px; overflow: hidden; backdrop-filter: blur(18px); }
            .preview-header { display: flex; gap: 8px; padding: 16px; border-bottom: 1px solid rgba(255,255,255,.12); }
            .dot { width: 10px; height: 10px; border-radius: 50%; background: #00d4ff; display: inline-block; }
            .preview-content { padding: 24px; }
            .chart-container { height: 180px; }
            .bar-chart { height: 100%; }
            .ww-card,
            .portfolio-card,
            .detail-card,
            .form-container,
            .glass-card,
            .card,
            .stat-card { background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.14); border-radius: 18px; padding: 24px; color: #fff; backdrop-filter: blur(18px); }
            .ww-card h3,
            .portfolio-card h5,
            .detail-card h1,
            .detail-card h4 { color: #fff; }
            .ww-muted,
            .text-muted { color: rgba(255,255,255,.68) !important; }
            .ww-pill,
            .tech-badge,
            .badge { display: inline-flex; margin: 4px 6px 4px 0; padding: 7px 10px; border-radius: 999px; background: rgba(255,255,255,.12); color: #fff; font-size: .82rem; }
            .btn,
            .contact-btn,
            .product-btn { display: inline-flex; align-items: center; justify-content: center; min-height: 40px; padding: 0 16px; border: 0; border-radius: 999px; background: linear-gradient(135deg, #00d4ff, #7c3aed); color: #fff; cursor: pointer; text-decoration: none; }
            .btn-outline,
            .btn-light,
            .btn-outline-primary { background: transparent; border: 1px solid rgba(255,255,255,.35); color: #fff; }
            input,
            select,
            textarea,
            .form-control,
            .form-select { width: 100%; min-height: 42px; border-radius: 12px; border: 1px solid rgba(255,255,255,.18); background: rgba(255,255,255,.08); color: #fff; padding: 10px 12px; }
            label { display: block; margin-bottom: 8px; color: rgba(255,255,255,.82); }
            table { width: 100%; color: #fff; border-collapse: collapse; }
            th,
            td { padding: 12px; border-bottom: 1px solid rgba(255,255,255,.12); }
            .alert { padding: 14px 16px; border-radius: 14px; background: rgba(255,255,255,.12); color: #fff; }
            .hero-text p { max-width: 640px; }
            @media (max-width: 760px) {
                .row { grid-template-columns: 1fr; }
                .row > * { grid-column: span 1 !important; }
            }
        </style>
    <?php endif; ?>
</head>
<?php if ($isAdminTemplate): ?>
<body>
<div class="container-fluid position-relative d-flex p-0">
    <div class="sidebar pe-4 pb-3">
        <nav class="navbar bg-secondary navbar-dark">
            <a href="index.php?action=admin-dashboard" class="navbar-brand mx-4 mb-3">
                <h3 class="text-primary">WORKWAVE</h3>
            </a>
            <div class="navbar-nav w-100">
                <a href="index.php?action=admin-dashboard" class="nav-item nav-link<?= ww_active($action, 'admin-dashboard') ?>">Dashboard</a>
                <a href="index.php?action=admin-pending-portfolios" class="nav-item nav-link<?= ww_active($action, 'admin-pending-portfolios') ?>">Portfolios en attente</a>
                <a href="index.php?action=admin-approved-portfolios" class="nav-item nav-link<?= ww_active($action, 'admin-approved-portfolios') ?>">Portfolios approuvés</a>
                <a href="index.php?action=admin-pending-jobs" class="nav-item nav-link<?= ww_active($action, 'admin-pending-jobs') ?>">Offres en attente</a>
                <a href="index.php?action=admin-candidats" class="nav-item nav-link<?= ww_active($action, 'admin-candidats') ?>">Candidats</a>
                <a href="index.php?action=admin-entreprises" class="nav-item nav-link<?= ww_active($action, 'admin-entreprises') ?>">Entreprises</a>
                <a href="index.php?action=logout" class="nav-item nav-link">Déconnexion</a>
            </div>
        </nav>
    </div>
    <div class="content">
        <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
            <a href="#" class="sidebar-toggler flex-shrink-0">☰</a>
            <div class="navbar-nav align-items-center ms-auto">
                <span class="nav-link">Administration</span>
            </div>
        </nav>
        <main class="admin-page">
<?php else: ?>
<body>
<nav id="navbar">
    <div class="nav-container">
        <a href="index.php" class="logo">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24"><path d="M3 13h2v8H3zm4-8h2v13H7zm4-2h2v15h-2zm4 4h2v11h-2zm4-2h2v13h-2z"/></svg>
            </div>
            <span class="logo-text">WorkWave</span>
        </a>
        <ul class="nav-links">
            <li><a href="index.php" class="<?= $action === 'home' ? 'active' : '' ?>">Accueil</a></li>
            <li><a href="index.php?action=front-list" class="<?= str_starts_with($action, 'front-') ? 'active' : '' ?>">Portfolios</a></li>
            <?php if ($user): ?>
                <li><a href="index.php?action=<?= htmlspecialchars($role) ?>-dashboard">Mon espace</a></li>
                <li><a href="index.php?action=logout">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="index.php?action=login" class="<?= $action === 'login' ? 'active' : '' ?>">Connexion</a></li>
                <li><a href="index.php?action=register" class="<?= $action === 'register' ? 'active' : '' ?>">Inscription</a></li>
            <?php endif; ?>
        </ul>
        <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
    </div>
    <ul class="nav-links-mobile" id="navLinksMobile">
        <li><a href="index.php">Accueil</a></li>
        <li><a href="index.php?action=front-list">Portfolios</a></li>
        <li><a href="index.php?action=<?= $user ? htmlspecialchars($role) . '-dashboard' : 'login' ?>"><?= $user ? 'Mon espace' : 'Connexion' ?></a></li>
    </ul>
</nav>
<main class="ww-content">
<?php endif; ?>
