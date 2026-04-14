<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Wave - Administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="../View/tempatemo_style.css" rel="stylesheet">
</head>
<body>
    <div class="sidebar">
        <div class="logo">Work<span>Wave</span></div>
        <a href="index.php?action=index" class="<?= (isset($activePage) && $activePage === 'list') ? 'active' : '' ?>">
            <i class="fas fa-list"></i> Liste des missions
        </a>
        <a href="index.php?action=create" class="<?= (isset($activePage) && $activePage === 'create') ? 'active' : '' ?>">
            <i class="fas fa-plus-circle"></i> Ajouter une mission
        </a>
        <a href="index.php?action=missions">
            <i class="fas fa-globe"></i> Aller au FrontOffice
        </a>
    </div>

    <div class="main-content">
        <div class="topbar">
            <h5>
                <i class="fas fa-<?= isset($pageIcon) ? htmlspecialchars($pageIcon) : 'briefcase' ?> me-2"></i>
                <?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Administration' ?>
            </h5>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Mission ajoutee avec succes.</div>
        <?php endif; ?>
        <?php if (isset($_GET['updated'])): ?>
            <div class="alert alert-success">Mission mise a jour avec succes.</div>
        <?php endif; ?>
        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert alert-warning">Mission supprimee avec succes.</div>
        <?php endif; ?>

        <?= $content ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?= isset($extraJs) ? $extraJs : '' ?>
</body>
</html>