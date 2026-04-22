<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Work Wave - Plateforme de missions freelance">
    <meta name="author" content="">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Work Wave - Missions Freelance</title>

    <!-- Bootstrap core CSS -->
    <link href="View/templatemo_564_plot_listing/templatemo_564_plot_listing/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="View/templatemo_564_plot_listing/templatemo_564_plot_listing/assets/css/fontawesome.css">
    <link rel="stylesheet" href="View/templatemo_564_plot_listing/templatemo_564_plot_listing/assets/css/templatemo-plot-listing.css">
    <link rel="stylesheet" href="View/templatemo_564_plot_listing/templatemo_564_plot_listing/assets/css/animated.css">
    <link rel="stylesheet" href="View/templatemo_564_plot_listing/templatemo_564_plot_listing/assets/css/owl.css">
</head>
<body>

  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <!-- ***** Logo Start ***** -->
            <a href="index.php?action=missions" class="logo">
              <span style="font-weight: 700; color: #2b2b2b; font-size: 24px;"><i class="fa fa-briefcase"></i> WORK WAVE</span>
            </a>
            <!-- ***** Logo End ***** -->
            <!-- ***** Menu Start ***** -->
            <ul class="nav">
              <li><a href="index.php?action=missions" class="<?php echo (!isset($_GET['action']) || $_GET['action'] == 'missions' || $_GET['action'] == 'home') ? 'active' : ''; ?>">Missions</a></li>
              <li><a href="index.php?action=front_missions" class="<?php echo (isset($_GET['action']) && $_GET['action'] == 'front_missions') ? 'active' : ''; ?>">Mes Missions</a></li>
              <li><a href="index.php?action=front_candidatures" class="<?php echo (isset($_GET['action']) && $_GET['action'] == 'front_candidatures') ? 'active' : ''; ?>">Mes Candidatures</a></li>
              <li><a href="index.php?action=front_create">Publier</a></li>
              <li><a href="index.php?action=index" style="background: linear-gradient(135deg, #d4af37 0%, #f4d03f 100%); color: #1a1a2e; padding: 12px 25px; border-radius: 25px; text-decoration: none; font-weight: 700; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4); transition: all 0.3s ease; border: 2px solid transparent;"><i class="fa fa-user-shield" style="font-size: 16px;"></i> Admin</a></li>
            </ul>
            <a class='menu-trigger'>
                <span>Menu</span>
            </a>
            <!-- ***** Menu End ***** -->
          </nav>
        </div>
      </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->

  <?php echo $content; ?>

  <footer style="background: linear-gradient(135deg, #2b2b2b 0%, #1a1a2e 100%); padding: 80px 0 30px; position: relative; overflow: hidden;">
    <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #00bdfe 0%, #2b2b2b 50%, #00bdfe 100%);"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-4 mb-4 mb-lg-0">
          <div class="about" style="padding-right: 30px;">
            <div class="logo" style="margin-bottom: 25px;">
              <span style="font-weight: 800; color: white; font-size: 28px; letter-spacing: 1px;"><i class="fa fa-briefcase" style="color: #00bdfe; margin-right: 10px;"></i> WORK WAVE</span>
            </div>
            <p style="color: #b8b8b8; line-height: 1.8; font-size: 14px;">Work Wave est une plateforme de mise en relation entre freelances et clients pour des missions de qualité. Trouvez la mission parfaite ou le talent idéal.</p>
            <div style="display: flex; gap: 15px; margin-top: 25px;">
              <a href="#" style="width: 40px; height: 40px; background: rgba(0, 189, 254, 0.1); border: 1px solid rgba(0, 189, 254, 0.3); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #00bdfe; transition: all 0.3s ease; text-decoration: none;"><i class="fa fa-facebook-f"></i></a>
              <a href="#" style="width: 40px; height: 40px; background: rgba(0, 189, 254, 0.1); border: 1px solid rgba(0, 189, 254, 0.3); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #00bdfe; transition: all 0.3s ease; text-decoration: none;"><i class="fa fa-twitter"></i></a>
              <a href="#" style="width: 40px; height: 40px; background: rgba(0, 189, 254, 0.1); border: 1px solid rgba(0, 189, 254, 0.3); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #00bdfe; transition: all 0.3s ease; text-decoration: none;"><i class="fa fa-linkedin-in"></i></a>
              <a href="#" style="width: 40px; height: 40px; background: rgba(0, 189, 254, 0.1); border: 1px solid rgba(0, 189, 254, 0.3); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #00bdfe; transition: all 0.3s ease; text-decoration: none;"><i class="fa fa-instagram"></i></a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 mb-4 mb-lg-0">
          <div class="helpful-links">
            <h4 style="color: #fff; font-size: 20px; font-weight: 700; margin-bottom: 30px; position: relative; padding-bottom: 15px;">
              Liens Rapides
              <span style="position: absolute; bottom: 0; left: 0; width: 50px; height: 3px; background: #00bdfe; border-radius: 2px;"></span>
            </h4>
            <div class="row">
              <div class="col-lg-6 col-sm-6">
                <ul style="list-style: none; padding: 0; margin: 0;">
                  <li style="margin-bottom: 12px;"><a href="index.php?action=missions" style="color: #b8b8b8; text-decoration: none; transition: all 0.3s ease; font-size: 14px; display: flex; align-items: center;"><i class="fa fa-chevron-right" style="color: #00bdfe; font-size: 10px; margin-right: 10px;"></i> Missions</a></li>
                  <li style="margin-bottom: 12px;"><a href="index.php?action=front_missions" style="color: #b8b8b8; text-decoration: none; transition: all 0.3s ease; font-size: 14px; display: flex; align-items: center;"><i class="fa fa-chevron-right" style="color: #00bdfe; font-size: 10px; margin-right: 10px;"></i> Mes Missions</a></li>
                  <li style="margin-bottom: 12px;"><a href="index.php?action=front_candidatures" style="color: #b8b8b8; text-decoration: none; transition: all 0.3s ease; font-size: 14px; display: flex; align-items: center;"><i class="fa fa-chevron-right" style="color: #00bdfe; font-size: 10px; margin-right: 10px;"></i> Candidatures</a></li>
                </ul>
              </div>
              <div class="col-lg-6">
                <ul style="list-style: none; padding: 0; margin: 0;">
                  <li style="margin-bottom: 12px;"><a href="index.php?action=front_create" style="color: #b8b8b8; text-decoration: none; transition: all 0.3s ease; font-size: 14px; display: flex; align-items: center;"><i class="fa fa-chevron-right" style="color: #00bdfe; font-size: 10px; margin-right: 10px;"></i> Publier</a></li>
                  <li style="margin-bottom: 12px;"><a href="index.php?action=index" style="color: #b8b8b8; text-decoration: none; transition: all 0.3s ease; font-size: 14px; display: flex; align-items: center;"><i class="fa fa-chevron-right" style="color: #00bdfe; font-size: 10px; margin-right: 10px;"></i> Admin</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="contact-us">
            <h4 style="color: #fff; font-size: 20px; font-weight: 700; margin-bottom: 30px; position: relative; padding-bottom: 15px;">
              Contactez-nous
              <span style="position: absolute; bottom: 0; left: 0; width: 50px; height: 3px; background: #00bdfe; border-radius: 2px;"></span>
            </h4>
            <p style="color: #b8b8b8; font-size: 14px; margin-bottom: 20px; line-height: 1.8;">
              <i class="fa fa-map-marker-alt" style="color: #00bdfe; margin-right: 10px;"></i> Tunisie
            </p>
            <p style="color: #b8b8b8; font-size: 14px; margin-bottom: 20px; line-height: 1.8;">
              <i class="fa fa-envelope" style="color: #00bdfe; margin-right: 10px;"></i> 
              <a href="mailto:contact@workwave.fr" style="color: #00bdfe; text-decoration: none; transition: all 0.3s ease;">contact@workwave.fr</a>
            </p>
            <p style="color: #b8b8b8; font-size: 14px; margin-bottom: 20px; line-height: 1.8;">
              <i class="fa fa-phone" style="color: #00bdfe; margin-right: 10px;"></i> +216 23053200
            </p>
          </div>
        </div>
        <div class="col-lg-12" style="margin-top: 50px;">
          <div class="sub-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.1); padding-top: 30px;">
            <p style="color: #888; font-size: 13px; margin: 0; text-align: center;">
              Copyright © 2026 <span style="color: #00bdfe; font-weight: 600;">Work Wave</span>. Tous droits réservés. Fait avec <i class="fa fa-heart" style="color: #dc3545;"></i> en Tunisie.
            </p>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="View/templatemo_564_plot_listing/templatemo_564_plot_listing/vendor/jquery/jquery.min.js"></script>
  <script src="View/templatemo_564_plot_listing/templatemo_564_plot_listing/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="View/templatemo_564_plot_listing/templatemo_564_plot_listing/assets/js/owl-carousel.js"></script>
  <script src="View/templatemo_564_plot_listing/templatemo_564_plot_listing/assets/js/animation.js"></script>
  <script src="View/templatemo_564_plot_listing/templatemo_564_plot_listing/assets/js/imagesloaded.js"></script>
  <script src="View/templatemo_564_plot_listing/templatemo_564_plot_listing/assets/js/custom.js"></script>
  <?php echo isset($extraJs) ? $extraJs : ''; ?>
</body>
</html>