<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>WorkWave</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Libre+Franklin:wght@300;400;500;600&display=swap" rel="stylesheet">

<!-- The New Template Styles -->
<link rel="stylesheet" href="/workwave/View/assets/templatemo-aurum-gold.css">

<style>
    .alert-danger  { background:#ffe0e0; border:1px solid #f00; padding:10px; margin-bottom:10px; color:#900; }
    .alert-success { background:#e0ffe0; border:1px solid #0a0; padding:10px; margin-bottom:10px; color:#060; }
    .alert-warning { background:#fff8e0; border:1px solid #fa0; padding:10px; margin-bottom:10px; color:#960; }
    .alert ul { margin:0; padding-left:18px; }
    form label  { display:block; margin-top:15px; font-weight:bold; color:#fff; }
    input[type="text"], input[type="password"], input[type="file"], select, textarea {
        width:100%; padding:10px; margin-top:5px; background:#1e1e1e; color:#fff;
        border:1px solid #C4A15A; border-radius: 4px; box-sizing:border-box;
    }
    input[type="submit"] { margin-top: 15px; background: #C4A15A; color: #000; padding: 10px 20px; border: none; cursor: pointer; font-weight: bold; border-radius: 4px; }
    table { width:100%; border-collapse:collapse; color:#fff; margin-top: 15px; }
    table th { background:#C4A15A; color: #000; padding:10px; text-align:left; }
    table td { padding:10px; border-bottom:1px solid #333; }
    .badge-employer { background:#C4A15A; color:#000; padding:4px 8px; border-radius: 4px; }
    .badge-seeker   { background:#444;    color:#fff; padding:4px 8px; border-radius: 4px; }
    a { color: #C4A15A; text-decoration: none; }
</style>
</head>
<body>

    <!-- Navigation -->
    <nav class="nav" id="navbar">
        <div class="container">
            <div class="nav-inner">
                <a href="/workwave/Controller/index.php" class="logo">Work<span>Wave</span></a>
                
                <ul class="nav-links">
                    <li><a href="/workwave/Controller/index.php">Home</a></li>
                    <?php if (!empty($_SESSION['user_id'])): ?>
                        <li><a href="/workwave/Controller/index.php?action=profile">My Profile</a></li>
                        <?php if ($_SESSION['user_role'] === 'employer'): ?>
                        <?php endif; ?>
                        <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <li><a href="/workwave/Controller/index.php?action=admin_users">Admin Panel</a></li>
                        <?php endif; ?>
                        <li><a href="/workwave/Controller/index.php?action=logout">Log Out</a></li>
                    <?php else: ?>
                        <li><a href="/workwave/Controller/index.php?action=login">Log In</a></li>
                        <li><a href="/workwave/Controller/index.php?action=register">Register</a></li>
                    <?php endif; ?>
                </ul>
                
                <div class="nav-cta">
                    <?php if (!empty($_SESSION['user_id'])): ?>
                        <a href="/workwave/Controller/index.php?action=profile" class="btn btn-outline">Dashboard</a>
                    <?php else: ?>
                        <a href="/workwave/Controller/index.php?action=register" class="btn btn-outline">Sign Up</a>
                        <a href="/workwave/Controller/index.php?action=login" class="btn btn-primary">Sign In</a>
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
            <li><a href="/workwave/Controller/index.php">Home</a></li>
            <?php if (!empty($_SESSION['user_id'])): ?>
                <li><a href="/workwave/Controller/index.php?action=profile">My Profile</a></li>
                <?php if ($_SESSION['user_role'] === 'employer'): ?>
                <?php endif; ?>
                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                <li><a href="/workwave/Controller/index.php?action=admin_users">Admin Panel</a></li>
                <?php endif; ?>
                <li><a href="/workwave/Controller/index.php?action=logout">Log Out</a></li>
            <?php else: ?>
                <li><a href="/workwave/Controller/index.php?action=login">Log In</a></li>
                <li><a href="/workwave/Controller/index.php?action=register">Register</a></li>
            <?php endif; ?>
        </ul>
        <div class="mobile-menu-cta">
            <?php if (!empty($_SESSION['user_id'])): ?>
                <a href="/workwave/Controller/index.php?action=profile" class="btn btn-outline">Dashboard</a>
            <?php else: ?>
                <a href="/workwave/Controller/index.php?action=register" class="btn btn-outline">Sign Up</a>
                <a href="/workwave/Controller/index.php?action=login" class="btn btn-primary">Sign In</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- MAIN VIEW WRAPPER -->
    <?php $isHome = empty($_GET['action']) || $_GET['action'] === 'home'; ?>
    <?php if (!$isHome): ?>
    <div class="container" style="padding-top: 120px; padding-bottom: 60px; min-height: 70vh;">
    <?php endif; ?>
