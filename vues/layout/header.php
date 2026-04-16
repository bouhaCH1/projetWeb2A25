<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formation &mdash; <?= htmlspecialchars($pageTitle ?? '') ?></title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-brand">Formation</div>

    <div class="nav-links">
        <?php if (($role ?? '') === 'enseignant'): ?>
            <a href="index.php?role=enseignant&action=dashboard"  class="nav-link">Tableau de bord</a>
            <a href="index.php?role=enseignant&action=formations" class="nav-link">Formations</a>
        <?php else: ?>
            <a href="index.php?role=etudiant&action=dashboard"  class="nav-link">Tableau de bord</a>
            <a href="index.php?role=etudiant&action=formations" class="nav-link">Formations</a>
            <a href="index.php?role=etudiant&action=taches"     class="nav-link">Mes Taches</a>
        <?php endif; ?>
    </div>

    <div class="nav-user">
        <span class="badge-role <?= htmlspecialchars($role ?? '') ?>">
            <?= ($role ?? '') === 'enseignant' ? 'Enseignant' : 'Etudiant' ?> #<?= (int)($userId ?? 0) ?>
        </span>
        <a href="index.php?logout=1" class="btn btn-sm btn-outline">Deconnexion</a>
    </div>
</nav>

<?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<main class="main-content">
