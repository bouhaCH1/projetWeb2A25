<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Wave - Administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            z-index: 100;
        }
        .sidebar .logo {
            color: #fff;
            font-size: 1.3rem;
            font-weight: 700;
            padding: 15px 25px 30px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar .logo span { color: #4cc9f0; }
        .sidebar a {
            display: block;
            color: rgba(255,255,255,0.7);
            padding: 12px 25px;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 0.95rem;
        }
        .sidebar a:hover,
        .sidebar a.active {
            color: #fff;
            background: rgba(76,201,240,0.15);
            border-left: 3px solid #4cc9f0;
        }
        .sidebar a i { margin-right: 10px; width: 18px; }
        .main-content {
            margin-left: 250px;
            padding: 30px;
        }
        .topbar {
            background: #fff;
            padding: 15px 30px;
            margin: -30px -30px 30px -30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .topbar h5 {
            margin: 0;
            font-weight: 600;
            color: #1a1a2e;
        }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.08); }
        .card-header {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 15px 20px;
        }
        .btn-primary {
            background: #4cc9f0;
            border-color: #4cc9f0;
            color: #1a1a2e;
            font-weight: 600;
        }
        .btn-primary:hover {
            background: #3ab7dc;
            border-color: #3ab7dc;
            color: #1a1a2e;
        }
        .badge-ouverte  { background: #d4edda; color: #155724; }
        .badge-en_cours { background: #fff3cd; color: #856404; }
        .badge-terminee { background: #f8d7da; color: #721c24; }
        .badge-annulee  { background: #e2e3e5; color: #383d41; }
    </style>
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
        <a href="../index.php?action=missions">
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