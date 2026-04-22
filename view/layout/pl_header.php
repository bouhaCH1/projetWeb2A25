<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="WorkWave - Find your next career opportunity or hire top talent.">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <title>WorkWave</title>

  <!-- Bootstrap -->
  <link href="/workwave/View/assets/plot-listing/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Plot Listing CSS -->
  <link rel="stylesheet" href="/workwave/View/assets/plot-listing/css/fontawesome.css">
  <link rel="stylesheet" href="/workwave/View/assets/plot-listing/css/templatemo-plot-listing.css">
  <link rel="stylesheet" href="/workwave/View/assets/plot-listing/css/animated.css">
  <link rel="stylesheet" href="/workwave/View/assets/plot-listing/css/owl.css">

  <style>
    /* ── WorkWave overrides on top of Plot Listing ── */
    body { font-family: 'Montserrat', sans-serif; }

    /* Alerts */
    .ww-alert { padding: 12px 18px; border-radius: 6px; margin-bottom: 18px; font-size: .88rem; }
    .ww-alert ul { margin: 0; padding-left: 18px; }
    .ww-alert-danger  { background: rgba(220,60,60,.1);  border:1px solid rgba(220,60,60,.35);  color:#c0392b; }
    .ww-alert-success { background: rgba(39,174,96,.1);  border:1px solid rgba(39,174,96,.35);  color:#1e8449; }
    .ww-alert-warning { background: rgba(243,156,18,.1); border:1px solid rgba(243,156,18,.35); color:#9a6200; }

    /* Public form card */
    .ww-form-section {
      min-height: calc(100vh - 80px);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 100px 15px 60px;
      background: #f8f9fa;
    }
    .ww-form-card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 8px 40px rgba(0,0,0,.10);
      padding: 44px 48px;
      width: 100%;
      max-width: 480px;
    }
    .ww-form-card h1 {
      font-size: 1.6rem;
      font-weight: 800;
      color: #1a1a2e;
      margin-bottom: 6px;
      letter-spacing: -.5px;
    }
    .ww-form-card .ww-subtitle {
      color: #777;
      font-size: .88rem;
      margin-bottom: 28px;
    }
    .ww-form-card label {
      display: block;
      margin-top: 16px;
      font-size: .78rem;
      font-weight: 700;
      color: #444;
      text-transform: uppercase;
      letter-spacing: .6px;
    }
    .ww-form-card input[type="text"],
    .ww-form-card input[type="password"],
    .ww-form-card input[type="file"],
    .ww-form-card select,
    .ww-form-card textarea {
      width: 100%;
      padding: 11px 14px;
      margin-top: 5px;
      background: #f4f6f8;
      color: #1a1a2e;
      border: 1.5px solid #e0e4ea;
      border-radius: 8px;
      font-family: 'Montserrat', sans-serif;
      font-size: .88rem;
      transition: border-color .2s, box-shadow .2s;
      box-sizing: border-box;
    }
    .ww-form-card input:focus,
    .ww-form-card select:focus {
      outline: none;
      border-color: #ef6f31;
      box-shadow: 0 0 0 3px rgba(239,111,49,.12);
    }
    .ww-btn-primary {
      display: inline-block;
      margin-top: 22px;
      width: 100%;
      padding: 13px;
      background: linear-gradient(135deg, #ef6f31, #d45a1e);
      color: #fff;
      font-weight: 700;
      font-size: .92rem;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: opacity .2s, transform .1s;
      letter-spacing: .3px;
      text-align: center;
      text-decoration: none;
    }
    .ww-btn-primary:hover { opacity: .92; transform: translateY(-1px); color: #fff; }
    .ww-btn-secondary {
      display: inline-block;
      margin-top: 12px;
      width: 100%;
      padding: 11px;
      background: #f0f2f5;
      color: #444;
      font-weight: 600;
      font-size: .88rem;
      border: 1.5px solid #dde1e7;
      border-radius: 8px;
      cursor: pointer;
      transition: background .18s;
      text-align: center;
      text-decoration: none;
    }
    .ww-btn-secondary:hover { background: #e4e8ef; color: #222; }

    /* Nav overrides — keep Plot Listing nav but brand it as WorkWave */
    .main-nav .logo::after { content: 'WorkWave'; font-weight: 800; font-size: 1.4rem; color: #fff; letter-spacing: -.5px; }
    .main-nav .logo img { display: none; }
  </style>
</head>
<body>

<!-- Preloader -->
<div id="js-preloader" class="js-preloader">
  <div class="preloader-inner">
    <span class="dot"></span>
    <div class="dots"><span></span><span></span><span></span></div>
  </div>
</div>

<!-- Header -->
<header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <nav class="main-nav">
          <!-- Logo -->
          <a href="/workwave/Controller/index.php" class="logo" style="font-weight:800;font-size:1.4rem;color:#fff;letter-spacing:-.5px;font-family:'Montserrat',sans-serif;">
            Work<span style="color:#ef6f31;">Wave</span>
          </a>
          <!-- Menu -->
          <ul class="nav">
            <li><a href="/workwave/Controller/index.php" class="<?= (empty($_GET['action']) || $_GET['action'] === 'home') ? 'active' : '' ?>">Home</a></li>
            <?php if (!empty($_SESSION['user_id'])): ?>
              <li><a href="/workwave/Controller/index.php?action=profile">My Profile</a></li>
              <?php if ($_SESSION['user_role'] === 'job_seeker'): ?>
                <li><a href="/workwave/Controller/index.php?action=dashboard_seeker">Dashboard</a></li>
              <?php elseif ($_SESSION['user_role'] === 'employer'): ?>
                <li><a href="/workwave/Controller/index.php?action=dashboard_employer">Dashboard</a></li>
              <?php endif; ?>
              <li>
                <div class="main-white-button">
                  <a href="/workwave/Controller/index.php?action=logout"><i class="fa fa-sign-out"></i> Log Out</a>
                </div>
              </li>
            <?php else: ?>
              <li><a href="/workwave/Controller/index.php?action=login">Log In</a></li>
              <li>
                <div class="main-white-button">
                  <a href="/workwave/Controller/index.php?action=register"><i class="fa fa-plus"></i> Register</a>
                </div>
              </li>
            <?php endif; ?>
          </ul>
          <a class='menu-trigger'><span>Menu</span></a>
        </nav>
      </div>
    </div>
  </div>
</header>
<!-- End Header -->
