<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Wave - Administration</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Libre+Franklin:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="../View/templatemo_610_aurum_gold/templatemo_610_aurum_gold/templatemo-aurum-gold.css" rel="stylesheet">
    <style>
        .admin-sidebar {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            min-height: 100vh;
            padding: 30px 20px;
            border-right: 3px solid #d4af37;
        }
        .admin-sidebar .logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 28px;
            font-weight: 700;
            color: #d4af37;
            margin-bottom: 40px;
            text-align: center;
        }
        .admin-sidebar .logo span {
            color: #fff;
        }
        .admin-sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 20px;
            color: #b8b8b8;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            font-family: 'Libre Franklin', sans-serif;
            font-size: 14px;
            font-weight: 500;
        }
        .admin-sidebar a:hover,
        .admin-sidebar a.active {
            background: linear-gradient(135deg, #d4af37 0%, #f4d03f 100%);
            color: #1a1a2e;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        }
        .admin-sidebar a i {
            font-size: 16px;
        }
        .admin-main {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .admin-header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            padding: 20px 30px;
            border-bottom: 3px solid #d4af37;
        }
        .admin-header h5 {
            font-family: 'Cormorant Garamond', serif;
            color: #d4af37;
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }
        .admin-header h5 i {
            color: #d4af37;
            margin-right: 10px;
        }
        .admin-content {
            padding: 30px;
        }
        .admin-alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-family: 'Libre Franklin', sans-serif;
        }
        .admin-alert.success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }
        .admin-alert.warning {
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            color: #1a1a2e;
        }
    </style>
</head>
<body>
    <div style="display: flex;">
        <div class="admin-sidebar" style="width: 280px; position: fixed; height: 100vh; overflow-y: auto;">
            <div class="logo">WORK <span>WAVE</span></div>
            <a href="index.php?action=index" class="<?= (isset($activePage) && $activePage === 'list') ? 'active' : '' ?>">
                <i class="fas fa-list"></i> Liste des missions
            </a>
            <a href="index.php?action=create" class="<?= (isset($activePage) && $activePage === 'create') ? 'active' : '' ?>">
                <i class="fas fa-plus-circle"></i> Ajouter une mission
            </a>
            <a href="index.php?action=candidatures" class="<?= (isset($activePage) && $activePage === 'candidatures') ? 'active' : '' ?>">
                <i class="fas fa-user-check"></i> Candidatures
            </a>
            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid rgba(212, 175, 55, 0.3);">
                <a href="index.php?action=missions" style="background: transparent; border: 2px solid #d4af37; color: #d4af37;">
                    <i class="fas fa-globe"></i> Retour au FrontOffice
                </a>
            </div>
        </div>

        <div class="admin-main" style="margin-left: 280px; flex: 1;">
            <div class="admin-header">
                <h5>
                    <i class="fas fa-<?= isset($pageIcon) ? htmlspecialchars($pageIcon) : 'briefcase' ?>"></i>
                    <?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Administration' ?>
                </h5>
            </div>

            <div class="admin-content">
                <?php if (isset($_GET['success'])): ?>
                    <div class="admin-alert success">
                        <i class="fas fa-check-circle"></i> Mission ajoutee avec succes.
                    </div>
                <?php endif; ?>
                <?php if (isset($_GET['updated'])): ?>
                    <div class="admin-alert success">
                        <i class="fas fa-check-circle"></i> Mission mise a jour avec succes.
                    </div>
                <?php endif; ?>
                <?php if (isset($_GET['deleted'])): ?>
                    <div class="admin-alert warning">
                        <i class="fas fa-trash-alt"></i> Mission supprimee avec succes.
                    </div>
                <?php endif; ?>

                <?= $content ?>
            </div>
        </div>
    </div>

    <script src="../View/templatemo_610_aurum_gold/templatemo_610_aurum_gold/templatemo-aurum-script.js"></script>
    <?= isset($extraJs) ? $extraJs : '' ?>
</body>
</html>