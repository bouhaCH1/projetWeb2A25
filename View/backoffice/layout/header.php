<?php
// Base URL always relative to index.php in project root
$base = '../';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= htmlspecialchars($pageTitle ?? 'FormationPHP') ?></title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= $base ?>View/public/css/fontawesome.css">
  <link rel="stylesheet" href="<?= $base ?>View/public/css/templatemo-plot-listing.css">
  <link rel="stylesheet" href="<?= $base ?>View/public/css/app.css">
  <link rel="stylesheet" href="<?= $base ?>View/public/css/theme-graph.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
</head>
<body>

<!-- Preloader -->
<div id="js-preloader" class="js-preloader">
  <div class="preloader-inner">
    <span class="dot"></span>
    <div class="dots"><span></span><span></span><span></span></div>
  </div>
</div>

<!-- Header -->
<header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
  <div class="container">
    <nav class="main-nav" style="display:flex;align-items:center;justify-content:space-between;min-height:80px">
      <a href="<?= $base ?>Controller/index.php?role=<?= $role ?>&action=dashboard" style="font-size:22px;font-weight:800;color:#fff;letter-spacing:1px">
        <i class="fa fa-graduation-cap" style="margin-right:8px;color:#8d99af"></i>FormationPHP
      </a>
      <ul class="nav" style="margin-top:0;align-items:center;display:flex">
        <?php if ($role === 'manager'): ?>
        <li><a href="<?= $base ?>Controller/index.php?role=manager&action=dashboard" <?= ($action??'')==='dashboard'?'class="active"':'' ?>>Dashboard</a></li>
        <li><a href="<?= $base ?>Controller/index.php?role=manager&action=formations" <?= ($action??'')==='formations'?'class="active"':'' ?>>Formations</a></li>
        <li>
          <div class="main-white-button">
            <a href="<?= $base ?>Controller/index.php?role=manager&action=formation_add"><i class="fa fa-plus"></i> Nouvelle</a>
          </div>
        </li>
        <?php else: ?>
        <li><a href="<?= $base ?>Controller/index.php?role=client&action=dashboard" <?= ($action??'')==='dashboard'?'class="active"':'' ?>>Dashboard</a></li>
        <li><a href="<?= $base ?>Controller/index.php?role=client&action=formations" <?= ($action??'')==='formations'?'class="active"':'' ?>>Formations</a></li>
        <li><a href="<?= $base ?>Controller/index.php?role=client&action=taches" <?= ($action??'')==='taches'?'class="active"':'' ?>>Mes Taches</a></li>
        <?php endif; ?>
        <li style="padding-left:20px">
          <span style="color:rgba(255,255,255,.6);font-size:13px">
            <i class="fa fa-user" style="margin-right:5px"></i>
            <?= htmlspecialchars($_SESSION['user_nom'] ?? '') ?>
            <span style="background:#8d99af;color:#fff;font-size:10px;padding:2px 8px;border-radius:10px;margin-left:6px"><?= $role ?></span>
          </span>
        </li>
        <li>
          <a href="<?= $base ?>Controller/index.php?action=logout" style="color:rgba(255,255,255,.5);font-size:13px">
            <i class="fa fa-sign-out"></i> Quitter
          </a>
        </li>
      </ul>
      <a class="menu-trigger"><span>Menu</span></a>
    </nav>
  </div>
</header>

<!-- Page heading banner -->
<div class="page-heading" style="padding:170px 0 60px">
  <div class="container">
    <div class="top-text">
      <h6><?= $role === 'manager' ? 'Espace Manager' : 'Espace Client' ?></h6>
      <h2 style="line-height:1.2;font-size:36px"><?= htmlspecialchars($pageTitle ?? 'FormationPHP') ?></h2>
    </div>
    <?php if (!empty($success) || !empty($error) || (!empty($errors) && is_array($errors))): ?>
    <div style="margin-top:20px;max-width:700px">
      <?php if (!empty($success)): ?>
      <div class="app-alert app-alert-success"><i class="fa fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
      <?php endif; ?>
      <?php if (!empty($error)): ?>
      <div class="app-alert app-alert-danger"><i class="fa fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <?php if (!empty($errors) && is_array($errors)): ?>
      <div class="app-alert app-alert-danger">
        <i class="fa fa-exclamation-circle"></i>
        <ul style="margin:4px 0 0 16px;padding:0">
        <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
</div>

<div class="app-content">
  <div class="container">
