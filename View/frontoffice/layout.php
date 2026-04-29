<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Work Wave - Plateforme de missions freelance">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="View/templatemo_602_graph_page/templatemo-graph-page.css" rel="stylesheet">

    <title>Work Wave - Missions Freelance</title>

    <style>
        /* Override template colors for Work Wave branding */
        :root {
            --primary: #00ffcc;
            --secondary: #00ccff;
            --accent: #ff6b6b;
            --bg-dark: #0a0e27;
        }

        .page-content {
            padding-top: 80px;
            min-height: 100vh;
        }

        /* Keep existing component styles */
        .cyber-search {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 25px;
        }

        .cyber-search input,
        .cyber-search select {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 12px 16px;
            color: #ffffff;
            font-size: 14px;
            width: 100%;
        }

        .cyber-btn {
            background: linear-gradient(135deg, #00ffcc 0%, #00ccff 100%);
            color: #0a0e27;
            font-weight: 600;
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .cyber-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(0, 255, 204, 0.4);
        }

        .cyber-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .cyber-card:hover {
            border-color: rgba(0, 255, 204, 0.3);
            transform: translateY(-4px);
        }

        .cyber-form-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 40px;
        }

        .cyber-form-card label {
            color: #00ffcc;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
            display: block;
        }

        .cyber-form-card input,
        .cyber-form-card textarea,
        .cyber-form-card select {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 12px 15px;
            color: #ffffff;
            font-size: 14px;
            width: 100%;
        }

        .cyber-form-card input:focus,
        .cyber-form-card textarea:focus,
        .cyber-form-card select:focus {
            outline: none;
            border-color: #00ffcc;
            box-shadow: 0 0 15px rgba(0, 255, 204, 0.2);
        }

        .cyber-alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .cyber-alert-success {
            background: rgba(0, 255, 204, 0.1);
            border: 1px solid rgba(0, 255, 204, 0.3);
            color: #00ffcc;
        }

        .cyber-alert-warning {
            background: rgba(255, 107, 107, 0.1);
            border: 1px solid rgba(255, 107, 107, 0.3);
            color: #ff6b6b;
        }

        .invalid-feedback {
            color: #ff6b6b;
            font-size: 13px;
            margin-top: 5px;
        }

        .is-invalid {
            border-color: #ff6b6b !important;
        }

        .cyber-banner {
            background: linear-gradient(135deg, rgba(0, 255, 204, 0.1) 0%, rgba(10, 14, 39, 0.9) 50%, rgba(0, 204, 255, 0.1) 100%);
            border-bottom: 1px solid rgba(0, 255, 204, 0.15);
            padding: 80px 0 40px;
        }

        .cyber-banner h6 {
            color: #00ffcc;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 10px;
        }

        .cyber-banner h2 {
            color: #ffffff;
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 30px;
        }

        .section-heading h2 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .section-heading h6 {
            color: #00ccff;
            font-size: 14px;
            font-weight: 500;
        }

        .cyber-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .cyber-badge-green { background: rgba(0, 255, 204, 0.15); color: #00ffcc; }
        .cyber-badge-blue { background: rgba(0, 204, 255, 0.15); color: #00ccff; }
        .cyber-badge-purple { background: rgba(147, 51, 234, 0.15); color: #9333ea; }
    </style>
</head>
<body>

  <!-- ===== NAVBAR ===== -->
  <nav id="navbar">
    <div class="nav-container">
      <a href="index.php?action=missions" class="logo">
        <div class="logo-icon">
          <svg viewBox="0 0 24 24">
            <path d="M3 13h2v8H3zm4-8h2v13H7zm4-2h2v15h-2zm4 4h2v11h-2zm4-2h2v13h-2z"/>
          </svg>
        </div>
        <span class="logo-text">WORK WAVE</span>
      </a>
      <ul class="nav-links">
        <li><a href="index.php?action=missions" class="<?php echo (!isset($_GET['action']) || $_GET['action'] == 'missions' || $_GET['action'] == 'home') ? 'active' : ''; ?>">Missions</a></li>
        <li><a href="index.php?action=front_missions" class="<?php echo (isset($_GET['action']) && $_GET['action'] == 'front_missions') ? 'active' : ''; ?>">Mes Missions</a></li>
        <li><a href="index.php?action=front_candidatures" class="<?php echo (isset($_GET['action']) && $_GET['action'] == 'front_candidatures') ? 'active' : ''; ?>">Candidatures</a></li>
        <li><a href="index.php?action=front_create">Publier</a></li>
        <li><a href="index.php?action=index" style="background: linear-gradient(135deg, #00ffcc, #00ccff); color: #0a0e27; padding: 8px 20px; border-radius: 25px; font-weight: 600;">Admin</a></li>
      </ul>
      <div class="hamburger" id="hamburger">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <ul class="nav-links-mobile" id="navLinksMobile">
      <li><a href="index.php?action=missions" class="<?php echo (!isset($_GET['action']) || $_GET['action'] == 'missions' || $_GET['action'] == 'home') ? 'active' : ''; ?>">Missions</a></li>
      <li><a href="index.php?action=front_missions" class="<?php echo (isset($_GET['action']) && $_GET['action'] == 'front_missions') ? 'active' : ''; ?>">Mes Missions</a></li>
      <li><a href="index.php?action=front_candidatures" class="<?php echo (isset($_GET['action']) && $_GET['action'] == 'front_candidatures') ? 'active' : ''; ?>">Candidatures</a></li>
      <li><a href="index.php?action=front_create">Publier</a></li>
      <li><a href="index.php?action=index">Admin</a></li>
    </ul>
  </nav>

  <!-- ===== PAGE CONTENT ===== -->
  <div class="page-content">
    <?php echo $content; ?>
  </div>

  <!-- ===== FOOTER ===== -->
  <footer style="background: rgba(10, 14, 39, 0.95); border-top: 1px solid rgba(0, 255, 204, 0.2); padding: 60px 0 30px;">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 mb-4 mb-lg-0">
          <div style="margin-bottom: 25px;">
            <span style="font-weight: 700; color: white; font-size: 24px; letter-spacing: 1px;">
              <i class="fa fa-briefcase" style="color: #00ffcc; margin-right: 10px;"></i> WORK <span style="color: #00ffcc;">WAVE</span>
            </span>
          </div>
          <p style="color: rgba(255,255,255,0.7); font-size: 14px; line-height: 1.8;">Work Wave est une plateforme de mise en relation entre freelances et clients pour des missions de qualite. Trouvez la mission parfaite ou le talent ideal.</p>
          <div style="display: flex; gap: 12px; margin-top: 20px;">
            <a href="https://facebook.com/workwave" target="_blank" style="width: 40px; height: 40px; background: rgba(0, 255, 204, 0.1); border: 1px solid rgba(0, 255, 204, 0.3); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; color: #00ffcc; text-decoration: none;"><i class="fab fa-facebook-f"></i></a>
            <a href="https://twitter.com/workwave" target="_blank" style="width: 40px; height: 40px; background: rgba(0, 255, 204, 0.1); border: 1px solid rgba(0, 255, 204, 0.3); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; color: #00ffcc; text-decoration: none;"><i class="fab fa-twitter"></i></a>
            <a href="https://linkedin.com/company/workwave" target="_blank" style="width: 40px; height: 40px; background: rgba(0, 255, 204, 0.1); border: 1px solid rgba(0, 255, 204, 0.3); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; color: #00ffcc; text-decoration: none;"><i class="fab fa-linkedin-in"></i></a>
            <a href="https://instagram.com/workwave" target="_blank" style="width: 40px; height: 40px; background: rgba(0, 255, 204, 0.1); border: 1px solid rgba(0, 255, 204, 0.3); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; color: #00ffcc; text-decoration: none;"><i class="fab fa-instagram"></i></a>
            <a href="https://youtube.com/workwave" target="_blank" style="width: 40px; height: 40px; background: rgba(0, 255, 204, 0.1); border: 1px solid rgba(0, 255, 204, 0.3); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; color: #00ffcc; text-decoration: none;"><i class="fab fa-youtube"></i></a>
          </div>
        </div>
        <div class="col-lg-4 mb-4 mb-lg-0">
          <h4 style="color: #ffffff; font-size: 18px; font-weight: 700; margin-bottom: 25px; position: relative; padding-bottom: 12px;">Liens Rapides</h4>
          <div class="row">
            <div class="col-6">
              <a href="index.php?action=missions" style="color: rgba(255,255,255,0.7); text-decoration: none; display: block; padding: 6px 0; font-size: 14px;"><i class="fa fa-chevron-right" style="color: #00ffcc; font-size: 10px; margin-right: 10px;"></i> Missions</a>
              <a href="index.php?action=front_missions" style="color: rgba(255,255,255,0.7); text-decoration: none; display: block; padding: 6px 0; font-size: 14px;"><i class="fa fa-chevron-right" style="color: #00ffcc; font-size: 10px; margin-right: 10px;"></i> Mes Missions</a>
              <a href="index.php?action=front_candidatures" style="color: rgba(255,255,255,0.7); text-decoration: none; display: block; padding: 6px 0; font-size: 14px;"><i class="fa fa-chevron-right" style="color: #00ffcc; font-size: 10px; margin-right: 10px;"></i> Candidatures</a>
            </div>
            <div class="col-6">
              <a href="index.php?action=front_create" style="color: rgba(255,255,255,0.7); text-decoration: none; display: block; padding: 6px 0; font-size: 14px;"><i class="fa fa-chevron-right" style="color: #00ffcc; font-size: 10px; margin-right: 10px;"></i> Publier</a>
              <a href="index.php?action=index" style="color: rgba(255,255,255,0.7); text-decoration: none; display: block; padding: 6px 0; font-size: 14px;"><i class="fa fa-chevron-right" style="color: #00ffcc; font-size: 10px; margin-right: 10px;"></i> Admin</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <h4 style="color: #ffffff; font-size: 18px; font-weight: 700; margin-bottom: 25px; position: relative; padding-bottom: 12px;">Contactez-nous</h4>
          <div style="color: rgba(255,255,255,0.7); font-size: 14px; margin-bottom: 15px; display: flex; align-items: center;"><i class="fas fa-location-dot" style="color: #00ffcc; margin-right: 10px;"></i> Tunisie</div>
          <div style="color: rgba(255,255,255,0.7); font-size: 14px; margin-bottom: 15px; display: flex; align-items: center;"><i class="fas fa-envelope" style="color: #00ffcc; margin-right: 10px;"></i> <a href="mailto:contact@workwave.fr" style="color: #00ccff; text-decoration: none;">contact@workwave.fr</a></div>
          <div style="color: rgba(255,255,255,0.7); font-size: 14px; margin-bottom: 15px; display: flex; align-items: center;"><i class="fas fa-phone" style="color: #00ffcc; margin-right: 10px;"></i> +216 23053200</div>
        </div>
        <div class="col-lg-12">
          <div style="border-top: 1px solid rgba(255, 255, 255, 0.1); padding-top: 25px; margin-top: 40px; text-align: center;">
            <p style="color: rgba(255,255,255,0.5); font-size: 13px;">Copyright &copy; 2026 <span style="color: #00ffcc; font-weight: 600;">Work Wave</span>. Tous droits reserves. Fait avec <i class="fas fa-heart" style="color: #ff6b6b;"></i> en Tunisie.</p>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="View/templatemo_602_graph_page/templatemo-graph-script.js"></script>
  <?php echo isset($extraJs) ? $extraJs : ''; ?>
</body>
</html>