<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Wave - Administration</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../View/darkpan-1.0.0/darkpan-1.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="../View/darkpan-1.0.0/darkpan-1.0.0/css/style.css" rel="stylesheet">
    <style>
        :root {
            --primary: #EB1616;
            --secondary: #191C24;
            --light: #6C7293;
            --dark: #000000;
        }
        body {
            font-family: 'Open Sans', sans-serif;
            background: var(--dark);
        }
        .sidebar .navbar-brand h3 {
            font-family: 'Roboto', sans-serif;
        }
        .sidebar .nav-link-front {
            display: flex;
            align-items: center;
            padding: 7px 20px;
            color: var(--light);
            font-weight: 500;
            border-left: 3px solid var(--secondary);
            border-radius: 0 30px 30px 0;
            outline: none;
            text-decoration: none;
            margin-top: 10px;
            border-top: 1px solid rgba(108, 114, 147, 0.2);
            padding-top: 20px;
        }
        .sidebar .nav-link-front:hover {
            color: var(--primary);
            background: var(--dark);
            border-color: var(--primary);
        }
        .sidebar .nav-link-front i {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--dark);
            border-radius: 40px;
            margin-right: 10px;
        }
        .sidebar .nav-link-front:hover i {
            background: var(--secondary);
        }
        .admin-alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-family: 'Open Sans', sans-serif;
        }
        .admin-alert.success {
            background: rgba(40, 167, 69, 0.15);
            border: 1px solid rgba(40, 167, 69, 0.3);
            color: #28a745;
        }
        .admin-alert.warning {
            background: rgba(255, 193, 7, 0.15);
            border: 1px solid rgba(255, 193, 7, 0.3);
            color: #ffc107;
        }
    </style>
</head>
<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.php?action=index" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-shield-halved me-2"></i>WorkWave</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <div style="width: 40px; height: 40px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fa fa-user-shield text-white"></i>
                        </div>
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0" style="color: #fff;">Admin</h6>
                        <span style="color: var(--light);">Administrateur</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.php?action=index" class="nav-item nav-link <?= (isset($activePage) && $activePage === 'list') ? 'active' : '' ?>">
                        <i class="fa fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a href="index.php?action=index" class="nav-item nav-link <?= (isset($activePage) && $activePage === 'list') ? 'active' : '' ?>">
                        <i class="fa fa-table me-2"></i>Missions
                    </a>
                    <a href="index.php?action=create" class="nav-item nav-link <?= (isset($activePage) && $activePage === 'create') ? 'active' : '' ?>">
                        <i class="fa fa-keyboard me-2"></i>Ajouter Mission
                    </a>
                    <a href="index.php?action=candidatures" class="nav-item nav-link <?= (isset($activePage) && $activePage === 'candidatures') ? 'active' : '' ?>">
                        <i class="fa fa-user-check me-2"></i>Candidatures
                    </a>
                    <a href="index.php?action=missions" class="nav-link-front">
                        <i class="fa fa-globe"></i>Retour au FrontOffice
                    </a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="index.php?action=index" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-shield-halved"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item">
                        <span class="nav-link" style="color: var(--light);">
                            <i class="fa fa-<?= isset($pageIcon) ? htmlspecialchars($pageIcon) : 'briefcase' ?> me-2"></i>
                            <?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Administration' ?>
                        </span>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Admin Content -->
            <div class="container-fluid pt-4 px-4">
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

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#" style="color: var(--primary);">WorkWave</a>, All Right Reserved.
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end" style="color: var(--light);">
                            Designed By <a href="https://htmlcodex.com" style="color: var(--primary);">HTML Codex</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../View/darkpan-1.0.0/darkpan-1.0.0/js/main.js"></script>
    <?= isset($extraJs) ? $extraJs : '' ?>
</body>
</html>