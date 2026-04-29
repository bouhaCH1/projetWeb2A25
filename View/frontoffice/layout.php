<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Work Wave - Plateforme de missions freelance">
    <meta name="author" content="">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="View/templatemo_564_plot_listing/templatemo_564_plot_listing/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <title>Work Wave - Missions Freelance</title>

    <style>
        :root {
            --bg-deep: #0a0015;
            --bg-card: #1a0a2e;
            --border-glow: #2a1a4a;
            --neon-green: #00ff99;
            --neon-cyan: #00ffff;
            --neon-magenta: #ff00ff;
            --text-primary: #ffffff;
            --text-muted: #b0b0d0;
            --text-dim: #6a6a8a;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-deep);
            color: var(--text-primary);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background:
                radial-gradient(ellipse at 20% 20%, rgba(0, 255, 153, 0.03) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 80%, rgba(0, 255, 255, 0.03) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%, rgba(255, 0, 255, 0.02) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        /* ===== NAVBAR ===== */
        .cyber-nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            background: rgba(10, 0, 21, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 255, 153, 0.2);
            box-shadow: 0 4px 30px rgba(0, 255, 153, 0.05);
            transition: all 0.3s ease;
        }

        .cyber-nav .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            height: 72px;
        }

        .cyber-nav .logo-link {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .cyber-nav .logo-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--neon-green), var(--neon-cyan));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 14px;
            color: var(--bg-deep);
            box-shadow: 0 0 20px rgba(0, 255, 153, 0.3);
        }

        .cyber-nav .logo-text {
            font-weight: 700;
            font-size: 20px;
            color: var(--text-primary);
            letter-spacing: 0.5px;
        }

        .cyber-nav .logo-text span {
            color: var(--neon-green);
        }

        .cyber-nav .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .cyber-nav .nav-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .cyber-nav .nav-links a:hover,
        .cyber-nav .nav-links a.active {
            color: var(--neon-green);
            background: rgba(0, 255, 153, 0.1);
        }

        .cyber-nav .nav-links .admin-btn {
            background: linear-gradient(135deg, var(--neon-green), var(--neon-cyan));
            color: var(--bg-deep);
            font-weight: 700;
            border-radius: 25px;
            padding: 10px 22px;
            box-shadow: 0 0 20px rgba(0, 255, 153, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .cyber-nav .nav-links .admin-btn:hover {
            box-shadow: 0 0 30px rgba(0, 255, 153, 0.5);
            transform: translateY(-1px);
        }

        .cyber-nav .mobile-toggle {
            display: none;
            background: none;
            border: 1px solid var(--border-glow);
            border-radius: 8px;
            color: var(--neon-green);
            padding: 8px 12px;
            cursor: pointer;
            font-size: 18px;
        }

        @media (max-width: 991px) {
            .cyber-nav .nav-links {
                display: none;
                position: absolute;
                top: 72px; left: 0; right: 0;
                background: rgba(10, 0, 21, 0.95);
                backdrop-filter: blur(20px);
                flex-direction: column;
                padding: 20px;
                border-bottom: 1px solid rgba(0, 255, 153, 0.2);
            }
            .cyber-nav .nav-links.open { display: flex; }
            .cyber-nav .mobile-toggle { display: block; }
        }

        /* ===== CONTENT AREA ===== */
        .page-content {
            position: relative;
            z-index: 1;
            padding-top: 72px;
        }

        /* ===== HERO / BANNER ===== */
        .cyber-banner {
            background: linear-gradient(135deg, rgba(0, 255, 153, 0.1) 0%, rgba(10, 0, 21, 0.9) 50%, rgba(0, 255, 255, 0.1) 100%);
            border-bottom: 1px solid rgba(0, 255, 153, 0.15);
            padding: 80px 0 40px;
            position: relative;
            overflow: hidden;
        }

        .cyber-banner::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(circle, rgba(0, 255, 153, 0.05) 0%, transparent 70%);
            animation: pulse-glow 8s ease-in-out infinite;
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }

        .cyber-banner h6 {
            color: var(--neon-green);
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 10px;
        }

        .cyber-banner h2 {
            color: var(--text-primary);
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 30px;
        }

        /* ===== SEARCH FORM ===== */
        .cyber-search {
            background: rgba(26, 10, 46, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-glow);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
        }

        .cyber-search input,
        .cyber-search select {
            background: rgba(10, 0, 21, 0.8);
            border: 1px solid var(--border-glow);
            border-radius: 10px;
            padding: 12px 16px;
            color: var(--text-primary);
            font-size: 14px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .cyber-search input::placeholder {
            color: var(--text-dim);
        }

        .cyber-search input:focus,
        .cyber-search select:focus {
            outline: none;
            border-color: var(--neon-green);
            box-shadow: 0 0 15px rgba(0, 255, 153, 0.2);
        }

        .cyber-search select option {
            background: var(--bg-deep);
            color: var(--text-primary);
        }

        .cyber-btn {
            background: linear-gradient(135deg, var(--neon-green), var(--neon-cyan));
            color: var(--bg-deep);
            font-weight: 700;
            font-size: 14px;
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 0 20px rgba(0, 255, 153, 0.3);
        }

        .cyber-btn:hover {
            box-shadow: 0 0 30px rgba(0, 255, 153, 0.5);
            transform: translateY(-2px);
            color: var(--bg-deep);
        }

        .cyber-btn-outline {
            background: transparent;
            color: var(--neon-green);
            border: 1px solid var(--neon-green);
            box-shadow: none;
        }

        .cyber-btn-outline:hover {
            background: rgba(0, 255, 153, 0.1);
            color: var(--neon-green);
            box-shadow: 0 0 20px rgba(0, 255, 153, 0.2);
        }

        .cyber-btn-danger {
            background: linear-gradient(135deg, #ff1744, #ff0066);
            color: #fff;
            box-shadow: 0 0 20px rgba(255, 23, 68, 0.3);
        }

        .cyber-btn-danger:hover {
            box-shadow: 0 0 30px rgba(255, 23, 68, 0.5);
            color: #fff;
        }

        /* ===== CATEGORY ICONS ===== */
        .cyber-categories {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .cyber-cat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            padding: 15px;
            transition: all 0.3s ease;
        }

        .cyber-cat-icon {
            width: 60px; height: 60px;
            background: rgba(0, 255, 153, 0.1);
            border: 1px solid rgba(0, 255, 153, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .cyber-cat-icon i {
            font-size: 22px;
            color: var(--neon-green);
        }

        .cyber-cat-item:hover .cyber-cat-icon {
            background: rgba(0, 255, 153, 0.2);
            box-shadow: 0 0 25px rgba(0, 255, 153, 0.3);
        }

        .cyber-cat-label {
            font-weight: 600;
            color: var(--text-muted);
            font-size: 14px;
        }

        .cyber-cat-item:hover .cyber-cat-label {
            color: var(--neon-green);
        }

        /* ===== SECTION HEADING ===== */
        .section-heading h2 {
            color: var(--text-primary);
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .section-heading h6 {
            color: var(--neon-cyan);
            font-size: 14px;
            font-weight: 500;
        }

        /* ===== CARDS ===== */
        .cyber-card {
            background: rgba(26, 10, 46, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-glow);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .cyber-card:hover {
            border-color: rgba(0, 255, 153, 0.4);
            box-shadow: 0 0 30px rgba(0, 255, 153, 0.1);
            transform: translateY(-4px);
        }

        .cyber-card-image {
            height: 180px;
            background: linear-gradient(135deg, rgba(0, 255, 153, 0.15), rgba(0, 255, 255, 0.15));
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid var(--border-glow);
        }

        .cyber-card-image i {
            font-size: 48px;
            color: rgba(0, 255, 153, 0.2);
        }

        .cyber-card-body {
            padding: 20px;
        }

        .cyber-card-body h4 {
            color: var(--text-primary);
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .cyber-card-body h4 a {
            color: var(--text-primary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .cyber-card-body h4 a:hover {
            color: var(--neon-green);
        }

        .cyber-card-body p {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 10px;
        }

        .cyber-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .cyber-badge-green { background: rgba(0, 255, 153, 0.15); color: var(--neon-green); border: 1px solid rgba(0, 255, 153, 0.3); }
        .cyber-badge-cyan { background: rgba(0, 255, 255, 0.15); color: var(--neon-cyan); border: 1px solid rgba(0, 255, 255, 0.3); }
        .cyber-badge-magenta { background: rgba(255, 0, 255, 0.15); color: var(--neon-magenta); border: 1px solid rgba(255, 0, 255, 0.3); }
        .cyber-badge-red { background: rgba(255, 23, 68, 0.15); color: #ff1744; border: 1px solid rgba(255, 23, 68, 0.3); }
        .cyber-badge-gray { background: rgba(74, 74, 106, 0.3); color: var(--text-muted); border: 1px solid rgba(74, 74, 106, 0.5); }

        .cyber-price {
            color: var(--neon-green);
            font-weight: 700;
            font-size: 16px;
        }

        .cyber-meta {
            color: var(--text-dim);
            font-size: 13px;
            margin-bottom: 8px;
        }

        .cyber-meta i {
            color: var(--neon-cyan);
            margin-right: 5px;
        }

        /* ===== FORMS ===== */
        .cyber-form-card {
            background: rgba(26, 10, 46, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-glow);
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .cyber-form-card label {
            color: var(--neon-cyan);
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
            display: block;
        }

        .cyber-form-card label .required {
            color: #ff1744;
        }

        .cyber-form-card input,
        .cyber-form-card textarea,
        .cyber-form-card select {
            background: rgba(10, 0, 21, 0.8);
            border: 1px solid var(--border-glow);
            border-radius: 10px;
            padding: 12px 15px;
            color: var(--text-primary);
            font-size: 14px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .cyber-form-card input::placeholder,
        .cyber-form-card textarea::placeholder {
            color: var(--text-dim);
        }

        .cyber-form-card input:focus,
        .cyber-form-card textarea:focus,
        .cyber-form-card select:focus {
            outline: none;
            border-color: var(--neon-green);
            box-shadow: 0 0 15px rgba(0, 255, 153, 0.2);
        }

        .cyber-form-card select option {
            background: var(--bg-deep);
            color: var(--text-primary);
        }

        .cyber-form-card .form-info {
            background: rgba(0, 255, 153, 0.05);
            border: 1px solid rgba(0, 255, 153, 0.2);
            border-left: 4px solid var(--neon-green);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .cyber-form-card .form-info h5 {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 5px;
        }

        .cyber-form-card .form-info small {
            color: var(--neon-green);
        }

        .cyber-form-card .form-info-edit {
            border-left-color: var(--neon-magenta);
            background: rgba(255, 0, 255, 0.05);
            border-color: rgba(255, 0, 255, 0.2);
        }

        .cyber-form-card .form-info-edit small {
            color: var(--neon-magenta);
        }

        .invalid-feedback {
            color: #ff1744;
            font-size: 13px;
            margin-top: 5px;
        }

        .is-invalid {
            border-color: #ff1744 !important;
            box-shadow: 0 0 10px rgba(255, 23, 68, 0.2) !important;
        }

        /* ===== ALERTS ===== */
        .cyber-alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .cyber-alert-success {
            background: rgba(0, 255, 153, 0.1);
            border: 1px solid rgba(0, 255, 153, 0.3);
            color: var(--neon-green);
        }

        .cyber-alert-warning {
            background: rgba(255, 0, 255, 0.1);
            border: 1px solid rgba(255, 0, 255, 0.3);
            color: var(--neon-magenta);
        }

        .cyber-alert-danger {
            background: rgba(255, 23, 68, 0.1);
            border: 1px solid rgba(255, 23, 68, 0.3);
            color: #ff1744;
        }

        /* ===== EMPTY STATE ===== */
        .cyber-empty {
            text-align: center;
            padding: 60px 20px;
            background: rgba(26, 10, 46, 0.4);
            border: 1px solid var(--border-glow);
            border-radius: 16px;
        }

        .cyber-empty i {
            font-size: 64px;
            color: rgba(0, 255, 153, 0.2);
            margin-bottom: 20px;
        }

        .cyber-empty h4 {
            color: var(--text-primary);
            font-size: 20px;
            margin-bottom: 10px;
        }

        .cyber-empty p {
            color: var(--text-muted);
            margin-bottom: 20px;
        }

        /* ===== FOOTER ===== */
        .cyber-footer {
            background: rgba(10, 0, 21, 0.95);
            border-top: 1px solid rgba(0, 255, 153, 0.2);
            padding: 60px 0 30px;
            position: relative;
        }

        .cyber-footer::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--neon-green), var(--neon-cyan), var(--neon-magenta), var(--neon-green));
        }

        .cyber-footer h4 {
            color: var(--text-primary);
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 12px;
        }

        .cyber-footer h4::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 40px; height: 2px;
            background: var(--neon-green);
            box-shadow: 0 0 10px rgba(0, 255, 153, 0.5);
        }

        .cyber-footer p {
            color: var(--text-muted);
            font-size: 14px;
            line-height: 1.8;
        }

        .cyber-footer a {
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .cyber-footer a:hover {
            color: var(--neon-green);
        }

        .cyber-footer .social-icon {
            width: 40px; height: 40px;
            background: rgba(0, 255, 153, 0.08);
            border: 1px solid rgba(0, 255, 153, 0.2);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--neon-green);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .cyber-footer .social-icon:hover {
            background: rgba(0, 255, 153, 0.2);
            box-shadow: 0 0 15px rgba(0, 255, 153, 0.3);
        }

        .cyber-footer .footer-link {
            color: var(--text-muted);
            font-size: 14px;
            display: flex;
            align-items: center;
            padding: 6px 0;
        }

        .cyber-footer .footer-link i {
            color: var(--neon-green);
            font-size: 10px;
            margin-right: 10px;
        }

        .cyber-footer .footer-link:hover {
            color: var(--neon-green);
        }

        .cyber-footer .contact-item {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .cyber-footer .contact-item i {
            color: var(--neon-green);
            margin-right: 10px;
            width: 16px;
        }

        .cyber-footer .contact-item a {
            color: var(--neon-cyan);
        }

        .cyber-footer .sub-footer {
            border-top: 1px solid var(--border-glow);
            padding-top: 25px;
            margin-top: 40px;
        }

        .cyber-footer .sub-footer p {
            color: var(--text-dim);
            font-size: 13px;
            text-align: center;
        }

        .cyber-footer .sub-footer .highlight {
            color: var(--neon-green);
            font-weight: 600;
        }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--bg-deep); }
        ::-webkit-scrollbar-thumb { background: var(--border-glow); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--neon-green); }
    </style>
</head>
<body>

  <!-- ===== NAVBAR ===== -->
  <nav class="cyber-nav">
    <div class="nav-inner">
      <a href="index.php?action=missions" class="logo-link">
        <div class="logo-icon">WW</div>
        <span class="logo-text">WORK <span>WAVE</span></span>
      </a>
      <ul class="nav-links" id="navLinks">
        <li><a href="index.php?action=missions" class="<?php echo (!isset($_GET['action']) || $_GET['action'] == 'missions' || $_GET['action'] == 'home') ? 'active' : ''; ?>">Missions</a></li>
        <li><a href="index.php?action=front_missions" class="<?php echo (isset($_GET['action']) && $_GET['action'] == 'front_missions') ? 'active' : ''; ?>">Mes Missions</a></li>
        <li><a href="index.php?action=front_candidatures" class="<?php echo (isset($_GET['action']) && $_GET['action'] == 'front_candidatures') ? 'active' : ''; ?>">Candidatures</a></li>
        <li><a href="index.php?action=front_create">Publier</a></li>
        <li><a href="index.php?action=index" class="admin-btn"><i class="fa fa-user-shield"></i> Admin</a></li>
      </ul>
      <button class="mobile-toggle" onclick="document.getElementById('navLinks').classList.toggle('open')">
        <i class="fa fa-bars"></i>
      </button>
    </div>
  </nav>

  <!-- ===== PAGE CONTENT ===== -->
  <div class="page-content">
    <?php echo $content; ?>
  </div>

  <!-- ===== FOOTER ===== -->
  <footer class="cyber-footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 mb-4 mb-lg-0">
          <div style="padding-right: 30px;">
            <div style="margin-bottom: 25px;">
              <span style="font-weight: 800; color: white; font-size: 24px; letter-spacing: 1px;">
                <i class="fa fa-briefcase" style="color: var(--neon-green); margin-right: 10px;"></i> WORK <span style="color: var(--neon-green);">WAVE</span>
              </span>
            </div>
            <p>Work Wave est une plateforme de mise en relation entre freelances et clients pour des missions de qualite. Trouvez la mission parfaite ou le talent ideal.</p>
            <div style="display: flex; gap: 12px; margin-top: 20px;">
              <a href="https://facebook.com/workwave" target="_blank" class="social-icon"><i class="fa fa-facebook-f"></i></a>
              <a href="https://twitter.com/workwave" target="_blank" class="social-icon"><i class="fa fa-twitter"></i></a>
              <a href="https://linkedin.com/company/workwave" target="_blank" class="social-icon"><i class="fa fa-linkedin-in"></i></a>
              <a href="https://instagram.com/workwave" target="_blank" class="social-icon"><i class="fa fa-instagram"></i></a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 mb-4 mb-lg-0">
          <h4>Liens Rapides</h4>
          <div class="row">
            <div class="col-6">
              <a href="index.php?action=missions" class="footer-link"><i class="fa fa-chevron-right"></i> Missions</a>
              <a href="index.php?action=front_missions" class="footer-link"><i class="fa fa-chevron-right"></i> Mes Missions</a>
              <a href="index.php?action=front_candidatures" class="footer-link"><i class="fa fa-chevron-right"></i> Candidatures</a>
            </div>
            <div class="col-6">
              <a href="index.php?action=front_create" class="footer-link"><i class="fa fa-chevron-right"></i> Publier</a>
              <a href="index.php?action=index" class="footer-link"><i class="fa fa-chevron-right"></i> Admin</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <h4>Contactez-nous</h4>
          <div class="contact-item"><i class="fa fa-map-marker-alt"></i> Tunisie</div>
          <div class="contact-item"><i class="fa fa-envelope"></i> <a href="mailto:contact@workwave.fr">contact@workwave.fr</a></div>
          <div class="contact-item"><i class="fa fa-phone"></i> +216 23053200</div>
        </div>
        <div class="col-lg-12">
          <div class="sub-footer">
            <p>Copyright &copy; 2026 <span class="highlight">Work Wave</span>. Tous droits reserves. Fait avec <i class="fa fa-heart" style="color: #ff1744;"></i> en Tunisie.</p>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <script src="View/templatemo_564_plot_listing/templatemo_564_plot_listing/vendor/jquery/jquery.min.js"></script>
  <script src="View/templatemo_564_plot_listing/templatemo_564_plot_listing/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <?php echo isset($extraJs) ? $extraJs : ''; ?>
</body>
</html>