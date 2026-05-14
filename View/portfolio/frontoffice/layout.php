<?php $userRole = $_SESSION['portfolio_role'] ?? null; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? 'WORKWAVE') ?></title>
    <link rel="stylesheet" href="<?= assetUrl('view/portfolio/frontoffice/template_generale/templatemo-graph-page.css') ?>">
    <link rel="stylesheet" href="<?= assetUrl('view/portfolio/frontoffice/assets/workwave.css') ?>">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
</head>
<body class="ww-body">
<nav id="navbar">
    <div class="nav-container">
        <a href="<?= routeUrl('home') ?>" class="logo">
            <div class="logo-icon"><svg viewBox="0 0 24 24"><path d="M3 13h2v8H3zm4-8h2v13H7zm4-2h2v15h-2zm4 4h2v11h-2zm4-2h2v13h-2z"/></svg></div>
            <span class="logo-text">WORKWAVE</span>
        </a>
        <ul class="nav-links">
            <li><a href="<?= routeUrl('jobs') ?>">Jobs</a></li>
            <li><a href="<?= routeUrl('freelancers') ?>">Freelancers</a></li>
            <li><a href="<?= routeUrl('companies') ?>">Companies</a></li>
            <li><a href="<?= routeUrl('map') ?>">Map</a></li>
            <?php if (!$userRole): ?>
                <li><a href="<?= routeUrl('login') ?>">Login</a></li>
            <?php else: ?>
                <li><a href="<?= routeUrl($userRole === 'admin' ? 'admin' : $userRole) ?>">Dashboard</a></li>
                <li><a href="<?= routeUrl('logout') ?>">Logout</a></li>
            <?php endif; ?>
        </ul>
        <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
    </div>
    <ul class="nav-links-mobile" id="navLinksMobile">
        <li><a href="<?= routeUrl('jobs') ?>">Jobs</a></li>
        <li><a href="<?= routeUrl('freelancers') ?>">Freelancers</a></li>
        <li><a href="<?= routeUrl('companies') ?>">Companies</a></li>
        <li><a href="<?= routeUrl('map') ?>">Map</a></li>
        <li><a href="<?= routeUrl($userRole ? ($userRole === 'admin' ? 'admin' : $userRole) : 'login') ?>"><?= $userRole ? 'Dashboard' : 'Login' ?></a></li>
    </ul>
</nav>

<main class="ww-main">
    <?php foreach (consumeFlash() as $flash): ?>
        <div class="ww-alert ww-alert-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
    <?php endforeach; ?>
    <?= $content ?>
</main>

<script src="<?= assetUrl('view/portfolio/frontoffice/template_generale/templatemo-graph-script.js') ?>"></script>
<script src="<?= assetUrl('view/portfolio/frontoffice/assets/workwave.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</body>
</html>
