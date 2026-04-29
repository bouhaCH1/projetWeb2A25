<?php
$role        = $_SESSION['user_role'] ?? '';
$userName    = htmlspecialchars(($_SESSION['user_first_name'] ?? '') . ' ' . ($_SESSION['user_last_name'] ?? ''));
$userPic     = $_SESSION['user_pic'] ?? '';
$userInitial = strtoupper(substr($_SESSION['user_first_name'] ?? 'U', 0, 1));
$action      = $_GET['action'] ?? '';
$pageTitle   = $pageTitle ?? 'Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> — WorkWave</title>
    <!-- Bootstrap -->
    <link href="/workwave/View/assets/plot-listing/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/workwave/View/assets/plot-listing/css/fontawesome.css">
    
    <!-- Graph Page CSS -->
    <link rel="stylesheet" href="/workwave/View/assets/template_user/templatemo-graph-page.css">

    <style>
        .ww-form-section {
          min-height: calc(100vh - 80px);
          display: flex;
          align-items: center;
          justify-content: center;
          padding: 100px 15px 60px;
          background: #0f111a;
        }
        .ww-form-card, .dsh-card {
          background: rgba(26, 29, 41, 0.8);
          border: 1px solid rgba(0, 255, 204, 0.1);
          border-radius: 12px;
          box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
          backdrop-filter: blur(10px);
          padding: 44px 48px;
          width: 100%;
          max-width: 480px;
          margin: 0 auto 30px auto;
        }
        .ww-form-card h1, .page-header-title {
          font-size: 1.6rem;
          font-weight: 800;
          color: #fff;
          margin-bottom: 6px;
        }
        .ww-form-card .ww-subtitle, .page-header-sub {
          color: #a0a0a0;
          font-size: .88rem;
          margin-bottom: 28px;
        }
        .ww-form-card label, .dsh-card label {
          display: block;
          margin-top: 16px;
          font-size: .78rem;
          font-weight: 700;
          color: #00ffcc;
          text-transform: uppercase;
        }
        .ww-form-card input[type="text"],
        .ww-form-card input[type="password"],
        .ww-form-card input[type="file"],
        .ww-form-card select,
        .ww-form-card textarea,
        .dsh-card input, .dsh-card select, .dsh-card textarea {
          width: 100%;
          padding: 11px 14px;
          margin-top: 5px;
          background: rgba(255, 255, 255, 0.05);
          color: #fff;
          border: 1px solid rgba(0, 255, 204, 0.2);
          border-radius: 8px;
          font-size: .88rem;
          transition: border-color .2s, box-shadow .2s;
        }
        .ww-form-card input:focus,
        .ww-form-card select:focus,
        .dsh-card input:focus, .dsh-card select:focus {
          outline: none;
          border-color: #00ffcc;
          box-shadow: 0 0 10px rgba(0, 255, 204, 0.2);
        }
        .ww-btn-primary, .btn-primary {
          display: inline-block;
          margin-top: 22px;
          width: 100%;
          padding: 13px;
          background: linear-gradient(135deg, #00ffcc 0%, #00b3ff 100%);
          color: #000;
          font-weight: 700;
          font-size: .92rem;
          border: none;
          border-radius: 8px;
          cursor: pointer;
          transition: transform 0.3s ease, box-shadow 0.3s ease;
          text-align: center;
          text-decoration: none;
        }
        .ww-btn-primary:hover, .btn-primary:hover { 
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 255, 204, 0.3);
            color: #000;
        }
        .ww-btn-secondary {
          display: inline-block;
          margin-top: 12px;
          width: 100%;
          padding: 11px;
          background: transparent;
          color: #00ffcc;
          font-weight: 600;
          font-size: .88rem;
          border: 1px solid #00ffcc;
          border-radius: 8px;
          cursor: pointer;
          transition: background .18s;
          text-align: center;
          text-decoration: none;
        }
        .ww-btn-secondary:hover { background: rgba(0, 255, 204, 0.1); color: #00ffcc; }
        
        .alert { padding: 12px 18px; border-radius: 6px; margin-bottom: 18px; font-size: .88rem; }
        .alert ul { margin: 0; padding-left: 18px; }
        .alert-danger  { background: rgba(255,107,107,.1); border:1px solid rgba(255,107,107,.35); color:#ff6b6b; }
        .alert-success { background: rgba(0,255,204,.1);  border:1px solid rgba(0,255,204,.35);  color:#00ffcc; }
        .field-err { margin-top: 6px; margin-bottom: 4px; color: #ff6b6b; font-size: .78rem; font-weight: 600; }
        
        /* Navbar specific override for PHP routing */
        #navbar .nav-links li a.active {
            color: #00ffcc;
        }

        /* Adjustments for Dashboard structure */
        body { background: #0f111a; color: #e0e0e0; }
        .page-header { margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
        
        /* Stat Cards */
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card {
            background: rgba(26, 29, 41, 0.8);
            border: 1px solid rgba(0, 255, 204, 0.1);
            border-radius: 12px;
            padding: 24px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 255, 204, 0.1);
        }
        .stat-card-label { font-size: 14px; color: #a0a0a0; margin-bottom: 10px; }
        .stat-card-value { font-size: 32px; font-weight: bold; color: #00ffcc; margin-bottom: 5px; }
        .stat-card-sub { font-size: 12px; color: #666; }

        /* Action Cards */
        .action-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .action-card {
            background: rgba(26, 29, 41, 0.8);
            border: 1px solid rgba(0, 255, 204, 0.1);
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 255, 204, 0.1);
            border-color: #00ffcc;
        }
        .action-card-icon {
            font-size: 40px;
            margin-bottom: 15px;
            display: inline-block;
        }
        .action-card-title { font-size: 18px; font-weight: bold; color: #fff; margin-bottom: 10px; }
        .action-card-desc { font-size: 14px; color: #a0a0a0; }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav id="navbar">
        <div class="nav-container">
            <a href="/workwave/Controller/index.php" class="logo" style="text-decoration: none;">
                <div class="logo-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M3 13h2v8H3zm4-8h2v13H7zm4-2h2v15h-2zm4 4h2v11h-2zm4-2h2v13h-2z"/>
                    </svg>
                </div>
                <span class="logo-text">WorkWave</span>
            </a>
            <ul class="nav-links">
                <li><a href="/workwave/Controller/index.php" class="<?= (empty($_GET['action']) || $_GET['action'] === 'home') ? 'active' : '' ?>">Accueil</a></li>
                <?php if (!empty($_SESSION['user_id'])): ?>
                    <li><a href="/workwave/Controller/index.php?action=profile" class="<?= ($_GET['action'] ?? '') === 'profile' ? 'active' : '' ?>">Mon Profil</a></li>
                    <?php if ($_SESSION['user_role'] === 'job_seeker'): ?>
                        <li><a href="/workwave/Controller/index.php?action=dashboard_seeker" class="<?= ($_GET['action'] ?? '') === 'dashboard_seeker' ? 'active' : '' ?>">Tableau de bord</a></li>
                    <?php elseif ($_SESSION['user_role'] === 'employer'): ?>
                        <li><a href="/workwave/Controller/index.php?action=dashboard_employer" class="<?= ($_GET['action'] ?? '') === 'dashboard_employer' ? 'active' : '' ?>">Tableau de bord</a></li>
                    <?php endif; ?>
                    <li><a href="/workwave/Controller/index.php?action=logout" style="color: #ff6b6b;">Déconnexion</a></li>
                <?php else: ?>
                    <li><a href="/workwave/Controller/index.php?action=login" class="<?= ($_GET['action'] ?? '') === 'login' ? 'active' : '' ?>">Connexion</a></li>
                    <li><a href="/workwave/Controller/index.php?action=register" class="cta-button" style="padding: 8px 20px; font-size: 14px; text-decoration: none;">S'inscrire</a></li>
                <?php endif; ?>
            </ul>
            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <ul class="nav-links-mobile" id="navLinksMobile">
            <li><a href="/workwave/Controller/index.php" class="<?= (empty($_GET['action']) || $_GET['action'] === 'home') ? 'active' : '' ?>">Accueil</a></li>
            <?php if (!empty($_SESSION['user_id'])): ?>
                <li><a href="/workwave/Controller/index.php?action=profile">Mon Profil</a></li>
                <?php if ($_SESSION['user_role'] === 'job_seeker'): ?>
                    <li><a href="/workwave/Controller/index.php?action=dashboard_seeker">Tableau de bord</a></li>
                <?php elseif ($_SESSION['user_role'] === 'employer'): ?>
                    <li><a href="/workwave/Controller/index.php?action=dashboard_employer">Tableau de bord</a></li>
                <?php endif; ?>
                <li><a href="/workwave/Controller/index.php?action=logout" style="color: #ff6b6b;">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="/workwave/Controller/index.php?action=login">Connexion</a></li>
                <li><a href="/workwave/Controller/index.php?action=register" style="color: #00ffcc;">S'inscrire</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    
    <div style="padding-top: 100px; padding-bottom: 60px;" class="container">
