<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkWave - Premium Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Libre+Franklin:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="view/assets/css/templatemo-aurum-gold.css">
    <style>
        .product-card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .product-info {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        body {
            background-color: var(--bg-dark) !important;
            color: #f8f9fa !important;
        }
        body * {
            color: #e0e0e0;
        }
        h1, h2, h3, h4, h5, h6, .navbar-brand, .logo, strong, b {
            color: var(--gold-main) !important;
        }
        p, span, div, label, td, th {
            color: #f8f9fa;
        }
        .text-muted {
            color: #a0a0a0 !important;
        }
        .form-control, .form-select {
            background-color: rgba(20, 20, 20, 0.8) !important;
            border: 1px solid rgba(212, 175, 55, 0.3) !important;
            color: #fff !important;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--gold-main) !important;
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25) !important;
        }
        .dashboard-container {
            padding: 120px 0 60px 0;
            min-height: 80vh;
        }
        .glass-card, .form-container, .card, .stat-card {
            background-color: #000000 !important;
            border: 1px solid rgba(212, 175, 55, 0.4) !important;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            color: #ffffff !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }
        h1, h2, h3, h4, h5, h6 {
            color: var(--gold-main);
        }
        .table {
            color: #fff;
        }
        .table-light {
            background-color: rgba(212, 175, 55, 0.1);
            color: var(--gold-main);
        }
        .nav-cta a {
            text-decoration: none;
        }
        .mobile-menu-cta a {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="nav" id="navbar">
        <div class="container">
            <div class="nav-inner">
                <a href="index.php" class="logo">Work<span>Wave</span></a>
                <ul class="nav-links">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="index.php#products">Offres d'emploi</a></li>
                    <li><a href="index.php#products">Portfolios</a></li>
                </ul>
                <div class="nav-cta">
                    <?php if (isset($_SESSION['user'])): ?>
                        <?php 
                            $role = strtolower($_SESSION['user']['role'] ?? ''); 
                            if ($role === 'condidat') $role = 'candidat';
                        ?>
                        <a href="index.php?action=<?= $role ?>-dashboard" class="btn btn-outline" style="text-decoration: none;">Mon Espace</a>
                        <a href="index.php?action=logout" class="btn btn-primary" style="text-decoration: none;">Déconnexion</a>
                    <?php else: ?>
                        <a href="index.php?action=login" class="btn btn-outline" style="text-decoration: none;">Connexion</a>
                        <a href="index.php?action=register" class="btn btn-primary" style="text-decoration: none;">S'inscrire</a>
                    <?php endif; ?>
                </div>
                <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Open Menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <button class="mobile-menu-close" id="mobileMenuClose" aria-label="Close Menu">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <ul class="mobile-nav-links">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="index.php#products">Offres d'emploi</a></li>
            <li><a href="index.php#products">Portfolios</a></li>
        </ul>
        <div class="mobile-menu-cta">
            <?php if (isset($_SESSION['user'])): ?>
                <?php 
                    $role = strtolower($_SESSION['user']['role'] ?? ''); 
                    if ($role === 'condidat') $role = 'candidat';
                ?>
                <a href="index.php?action=<?= $role ?>-dashboard" class="btn btn-outline" style="text-decoration: none;">Mon Espace</a>
                <a href="index.php?action=logout" class="btn btn-primary" style="text-decoration: none;">Déconnexion</a>
            <?php else: ?>
                <a href="index.php?action=login" class="btn btn-outline" style="text-decoration: none;">Connexion</a>
                <a href="index.php?action=register" class="btn btn-primary" style="text-decoration: none;">S'inscrire</a>
            <?php endif; ?>
        </div>
    </div>
