<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? 'WORKWAVE Admin') ?></title>
    <link href="<?= assetUrl('view/backoffice/template_admin/darkpan-1.0.0/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= assetUrl('view/backoffice/template_admin/darkpan-1.0.0/css/style.css') ?>" rel="stylesheet">
    <link href="<?= assetUrl('view/backoffice/assets/admin.css') ?>" rel="stylesheet">
</head>
<body>
<div class="container-fluid position-relative d-flex p-0">
    <div class="sidebar pe-4 pb-3">
        <nav class="navbar bg-secondary navbar-dark">
            <a href="<?= routeUrl('admin') ?>" class="navbar-brand mx-4 mb-3"><h3 class="text-primary">WORKWAVE</h3></a>
            <div class="navbar-nav w-100">
                <a href="<?= routeUrl('admin') ?>" class="nav-item nav-link">Dashboard</a>
                <a href="<?= routeUrl('admin/users') ?>" class="nav-item nav-link">Users</a>
                <a href="<?= routeUrl('admin/operations') ?>" class="nav-item nav-link">Operations</a>
                <a href="<?= routeUrl('jobs') ?>" class="nav-item nav-link">Public Jobs</a>
                <a href="<?= routeUrl('logout') ?>" class="nav-item nav-link">Logout</a>
            </div>
        </nav>
    </div>
    <div class="content">
        <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
            <a href="#" class="sidebar-toggler flex-shrink-0">☰</a>
            <div class="navbar-nav align-items-center ms-auto"><span class="nav-link">Administrator</span></div>
        </nav>
        <main class="container-fluid pt-4 px-4">
            <?php foreach (consumeFlash() as $flash): ?><div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : 'success' ?>"><?= e($flash['message']) ?></div><?php endforeach; ?>
            <?= $content ?>
        </main>
    </div>
</div>
<script src="<?= assetUrl('view/backoffice/template_admin/darkpan-1.0.0/lib/chart/chart.min.js') ?>"></script>
<script src="<?= assetUrl('view/backoffice/template_admin/darkpan-1.0.0/js/main.js') ?>"></script>
<script src="<?= assetUrl('view/backoffice/assets/admin.js') ?>"></script>
</body>
</html>
