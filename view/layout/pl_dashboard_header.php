<?php
$role        = $_SESSION['user_role'] ?? '';
$userName    = htmlspecialchars(($_SESSION['user_first_name'] ?? '') . ' ' . ($_SESSION['user_last_name'] ?? ''));
$userPic     = $_SESSION['user_pic'] ?? '';
$userInitial = strtoupper(substr($_SESSION['user_first_name'] ?? 'U', 0, 1));
$action      = $_GET['action'] ?? '';
$pageTitle   = $pageTitle ?? 'Dashboard';
$dashAction  = ($role === 'employer') ? 'dashboard_employer' : 'dashboard_seeker';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> — WorkWave</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">
    <style>
        /* ===== RESET ===== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: #080a12;
            color: #d0d0d0;
        }

        /* ===== LAYOUT SHELL ===== */
        .ww-shell {
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .ww-sidebar {
            width: 220px;
            flex-shrink: 0;
            background: #0c0e1a;
            border-right: 1px solid rgba(0,255,204,0.08);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 200;
            transition: transform 0.28s ease;
        }

        /* Brand */
        .ww-sb-brand {
            padding: 22px 20px 18px;
            border-bottom: 1px solid rgba(0,255,204,0.07);
        }
        .ww-sb-brand a {
            display: flex; align-items: center; gap: 10px; text-decoration: none;
        }
        .ww-sb-logo {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, #00ffcc, #00b3ff);
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .ww-sb-logo svg { width: 17px; height: 17px; fill: #000; }
        .ww-sb-brand-name { font-size: 1.05rem; font-weight: 800; color: #fff; letter-spacing: -0.3px; }

        /* User card */
        .ww-sb-user {
            padding: 14px 20px;
            border-bottom: 1px solid rgba(0,255,204,0.07);
            display: flex; align-items: center; gap: 11px;
        }
        .ww-sb-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, #00ffcc, #00b3ff);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: #000; font-size: 0.9rem;
            overflow: hidden; flex-shrink: 0;
        }
        .ww-sb-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .ww-sb-user-name { font-size: 0.82rem; font-weight: 600; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .ww-sb-badge {
            display: inline-block; margin-top: 3px;
            padding: 1px 8px; border-radius: 20px;
            font-size: 0.65rem; font-weight: 700;
            background: rgba(0,255,204,0.08);
            border: 1px solid rgba(0,255,204,0.25);
            color: #00ffcc;
        }

        /* Nav */
        .ww-sb-nav { padding: 12px 10px; flex: 1; overflow-y: auto; }
        .ww-sb-section {
            font-size: 0.62rem; font-weight: 700; color: #444;
            text-transform: uppercase; letter-spacing: 1px;
            padding: 10px 10px 5px;
        }
        .ww-sb-nav a {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 10px; border-radius: 7px;
            color: #888; text-decoration: none;
            font-size: 0.84rem; font-weight: 500;
            transition: all 0.18s;
            margin-bottom: 2px;
            border-left: 2px solid transparent;
        }
        .ww-sb-nav a i { font-size: 0.82rem; width: 14px; text-align: center; }
        .ww-sb-nav a:hover { background: rgba(0,255,204,0.06); color: #ccc; }
        .ww-sb-nav a.active {
            background: rgba(0,255,204,0.08);
            color: #00ffcc;
            border-left-color: #00ffcc;
        }

        /* Logout */
        .ww-sb-footer {
            padding: 10px 10px 16px;
            border-top: 1px solid rgba(0,255,204,0.07);
        }
        .ww-sb-footer a {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 10px; border-radius: 7px;
            color: #ff6b6b; text-decoration: none;
            font-size: 0.84rem; font-weight: 500;
            transition: background 0.18s;
        }
        .ww-sb-footer a:hover { background: rgba(255,107,107,0.08); }
        .ww-sb-footer a i { font-size: 0.82rem; }

        /* ===== MAIN AREA ===== */
        .ww-main-wrap {
            margin-left: 220px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Top bar */
        .ww-topbar {
            height: 56px;
            background: rgba(8,10,18,0.97);
            border-bottom: 1px solid rgba(0,255,204,0.07);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 24px;
            position: sticky; top: 0; z-index: 100;
            backdrop-filter: blur(8px);
        }
        .ww-topbar-left { display: flex; align-items: center; gap: 10px; }
        .ww-topbar-title { font-size: 0.95rem; font-weight: 700; color: #fff; }
        .ww-topbar-right { display: flex; align-items: center; gap: 14px; }
        .ww-topbar-user { display: flex; align-items: center; gap: 8px; font-size: 0.82rem; color: #aaa; }
        .ww-topbar-av {
            width: 30px; height: 30px; border-radius: 50%;
            background: linear-gradient(135deg, #00ffcc, #00b3ff);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: #000; font-size: 0.75rem;
            overflow: hidden;
        }
        .ww-topbar-av img { width: 100%; height: 100%; object-fit: cover; }
        .ww-hamburger {
            display: none; cursor: pointer; flex-direction: column; gap: 4px; padding: 4px;
        }
        .ww-hamburger span { display: block; width: 20px; height: 2px; background: #aaa; border-radius: 2px; }

        /* ===== PAGE CONTENT ===== */
        .ww-page { padding: 26px 26px; flex: 1; }

        /* Page header */
        .page-header { margin-bottom: 24px; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 12px; }
        .page-header-title { font-size: 1.35rem; font-weight: 800; color: #fff; }
        .page-header-sub { font-size: 0.82rem; color: #666; margin-top: 3px; }

        /* Cards */
        .dsh-card, .ww-form-card {
            background: #0d0f1d;
            border: 1px solid rgba(0,255,204,0.08);
            border-radius: 10px;
            padding: 24px 28px;
            margin-bottom: 20px;
        }

        /* Labels */
        .dsh-card label, .ww-form-card label {
            display: block; margin-top: 14px;
            font-size: 0.72rem; font-weight: 700;
            color: #00ffcc; text-transform: uppercase; letter-spacing: 0.5px;
        }

        /* Inputs */
        .dsh-card input[type="text"],
        .dsh-card input[type="password"],
        .dsh-card input[type="email"],
        .dsh-card input[type="file"],
        .ww-form-card input[type="text"],
        .ww-form-card input[type="password"],
        .ww-form-card input[type="email"],
        .ww-form-card input[type="file"] {
            width: 100%; padding: 9px 12px; margin-top: 5px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(0,255,204,0.15);
            border-radius: 6px; color: #ddd;
            font-size: 0.88rem; outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .dsh-card input:focus, .ww-form-card input:focus {
            border-color: #00ffcc;
            box-shadow: 0 0 0 3px rgba(0,255,204,0.08);
        }
        /* File input button */
        .dsh-card input[type="file"]::file-selector-button,
        .ww-form-card input[type="file"]::file-selector-button {
            background: linear-gradient(135deg,#00ffcc,#00b3ff);
            color:#000; border:none; padding:6px 12px;
            margin-right:10px; border-radius:4px; font-weight:700; cursor:pointer;
        }
        .dsh-card input[type="file"]::-webkit-file-upload-button,
        .ww-form-card input[type="file"]::-webkit-file-upload-button {
            background: linear-gradient(135deg,#00ffcc,#00b3ff);
            color:#000; border:none; padding:6px 12px;
            margin-right:10px; border-radius:4px; font-weight:700; cursor:pointer;
        }
        input[type="file"] { color: #bbb; }

        /* Selects */
        .dsh-card select, .ww-form-card select {
            width:100%; padding:9px 12px; margin-top:5px;
            background:rgba(255,255,255,0.04);
            border:1px solid rgba(0,255,204,0.15);
            border-radius:6px; color:#ddd; font-size:0.88rem; outline:none;
        }
        .dsh-card select:focus, .ww-form-card select:focus {
            border-color:#00ffcc;
        }

        /* Buttons */
        .ww-btn-primary, .btn-primary {
            display: inline-flex; align-items: center; justify-content: center; gap: 6px;
            margin-top: 18px; padding: 10px 20px;
            background: linear-gradient(135deg, #00ffcc, #00b3ff);
            color: #000; font-weight: 700; font-size: 0.88rem;
            border: none; border-radius: 7px; cursor: pointer;
            transition: transform 0.18s, box-shadow 0.18s;
            text-decoration: none;
        }
        .ww-btn-primary:hover, .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(0,255,204,0.25); color: #000;
        }
        .ww-btn-secondary, .btn-secondary, .btn-outline {
            display: inline-flex; align-items: center; justify-content: center; gap: 6px;
            margin-top: 10px; padding: 9px 18px;
            background: transparent; color: #00ffcc;
            font-weight: 600; font-size: 0.85rem;
            border: 1px solid rgba(0,255,204,0.35); border-radius: 7px;
            cursor: pointer; transition: background 0.18s;
            text-decoration: none;
        }
        .ww-btn-secondary:hover, .btn-secondary:hover, .btn-outline:hover {
            background: rgba(0,255,204,0.08); color: #00ffcc;
        }
        .btn-danger {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 9px 18px; background: transparent; color: #ff6b6b;
            font-weight: 600; font-size: 0.85rem;
            border: 1px solid rgba(255,107,107,0.35); border-radius: 7px;
            cursor: pointer; transition: background 0.18s; text-decoration: none;
        }
        .btn-danger:hover { background: rgba(255,107,107,0.08); color: #ff6b6b; }

        /* Alerts */
        .alert { padding: 11px 16px; border-radius: 7px; margin-bottom: 16px; font-size: 0.85rem; }
        .alert ul { margin: 0; padding-left: 18px; }
        .alert-danger  { background: rgba(255,107,107,.08); border:1px solid rgba(255,107,107,.3); color:#ff6b6b; }
        .alert-success { background: rgba(0,255,204,.08); border:1px solid rgba(0,255,204,.3); color:#00ffcc; }
        .field-err { margin-top: 4px; color: #ff6b6b; font-size: 0.75rem; font-weight: 600; }

        /* Stat / Action cards */
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px,1fr)); gap: 16px; margin-bottom: 20px; }
        .stat-card {
            background: #0d0f1d; border: 1px solid rgba(0,255,204,0.08);
            border-radius: 10px; padding: 20px;
            transition: transform 0.25s, box-shadow 0.25s;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 6px 18px rgba(0,255,204,0.08); }
        .stat-card-label { font-size: 0.75rem; color: #666; margin-bottom: 8px; }
        .stat-card-value { font-size: 1.8rem; font-weight: 800; color: #00ffcc; }
        .stat-card-sub { font-size: 0.72rem; color: #444; margin-top: 4px; }

        .action-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px,1fr)); gap: 16px; }
        .action-card {
            background: #0d0f1d; border: 1px solid rgba(0,255,204,0.08);
            border-radius: 10px; padding: 22px; text-align: center;
            transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
            text-decoration: none; color: inherit; display: block;
        }
        .action-card:hover {
            transform: translateY(-3px); box-shadow: 0 6px 18px rgba(0,255,204,0.08);
            border-color: rgba(0,255,204,0.25);
        }
        .action-card-icon { font-size: 2rem; margin-bottom: 12px; display: block; }
        .action-card-title { font-size: 0.95rem; font-weight: 700; color: #fff; margin-bottom: 6px; }
        .action-card-desc { font-size: 0.8rem; color: #666; }

        /* Misc helper */
        .ww-form-section {
            display: flex; align-items: center; justify-content: center;
            min-height: calc(100vh - 56px); padding: 40px 24px;
        }
        .ww-form-card { max-width: 460px; width: 100%; margin: 0 auto; }
        .ww-form-card h1 { font-size: 1.4rem; font-weight: 800; color: #fff; margin-bottom: 6px; }
        .ww-subtitle { font-size: 0.82rem; color: #666; margin-bottom: 20px; }

        /* Mobile */
        @media (max-width: 768px) {
            .ww-sidebar { transform: translateX(-100%); }
            .ww-sidebar.open { transform: translateX(0); }
            .ww-main-wrap { margin-left: 0; }
            .ww-hamburger { display: flex; }
            .ww-page { padding: 18px; }
        }
    </style>
</head>
<body>
<div class="ww-shell">

<!-- ===== SIDEBAR ===== -->
<aside class="ww-sidebar" id="wwSidebar">
    <div class="ww-sb-brand">
        <a href="/workwave/Controller/index.php">
            <div class="ww-sb-logo">
                <svg viewBox="0 0 24 24"><path d="M3 13h2v8H3zm4-8h2v13H7zm4-2h2v15h-2zm4 4h2v11h-2zm4-2h2v13h-2z"/></svg>
            </div>
            <span class="ww-sb-brand-name">WorkWave</span>
        </a>
    </div>

    <div class="ww-sb-user">
        <div class="ww-sb-avatar">
            <?php if (!empty($userPic)): ?>
                <img src="/workwave/<?= htmlspecialchars($userPic) ?>" alt="">
            <?php else: ?>
                <?= $userInitial ?>
            <?php endif; ?>
        </div>
        <div style="min-width:0;">
            <div class="ww-sb-user-name">
                <?= $userName ?>
                <?php if ((int)($_SESSION['user_verified'] ?? 0) === 1): ?>
                    <i class="fa fa-check-circle" style="color:#00ffcc; margin-left:3px;" title="Compte Certifié"></i>
                <?php endif; ?>
            </div>
            <span class="ww-sb-badge"><?= $role === 'employer' ? 'Employeur' : 'Candidat' ?></span>
        </div>
    </div>

    <nav class="ww-sb-nav">
        <div class="ww-sb-section">Navigation</div>
        <a href="/workwave/Controller/index.php?action=<?= $dashAction ?>" class="<?= $action === $dashAction ? 'active' : '' ?>">
            <i class="fa fa-th-large"></i> Tableau de bord
        </a>
        <a href="/workwave/Controller/index.php?action=profile" class="<?= $action === 'profile' ? 'active' : '' ?>">
            <i class="fa fa-user"></i> Mon Profil
        </a>

        <div class="ww-sb-section" style="margin-top:10px;">Outils IA</div>
        <a href="/workwave/Controller/index.php?action=ai_analyze" class="<?= $action === 'ai_analyze' ? 'active' : '' ?>" style="<?= $action !== 'ai_analyze' ? 'color:#00b3ff;' : '' ?>">
            <i class="fa fa-brain"></i> Analyse IA
        </a>
        <a href="/workwave/Controller/index.php?action=verify_identity" class="<?= $action === 'verify_identity' ? 'active' : '' ?>" style="<?= (int)($_SESSION['user_verified'] ?? 0) === 1 ? 'color:#00ffcc;' : 'color:#ffd700;' ?>">
            <i class="fa fa-id-card"></i> <?= (int)($_SESSION['user_verified'] ?? 0) === 1 ? '&#10003; Vérifié' : 'Vérifier CIN' ?>
        </a>

        <div class="ww-sb-section" style="margin-top:10px;">Compte</div>
        <a href="/workwave/Controller/index.php?action=security" class="<?= $action === 'security' ? 'active' : '' ?>">
            <i class="fa fa-shield-alt"></i> Sécurité & 2FA
        </a>
        <a href="/workwave/Controller/index.php" class="<?= ($action === '' || $action === 'home') ? 'active' : '' ?>">
            <i class="fa fa-globe"></i> Site public
        </a>
    </nav>

    <div class="ww-sb-footer">
        <a href="/workwave/Controller/index.php?action=logout">
            <i class="fa fa-sign-out-alt"></i> Déconnexion
        </a>
    </div>
</aside>

<!-- ===== MAIN WRAP ===== -->
<div class="ww-main-wrap">
    <div class="ww-topbar">
        <div class="ww-topbar-left">
            <div class="ww-hamburger" id="wwHamburger"><span></span><span></span><span></span></div>
            <span class="ww-topbar-title"><?= htmlspecialchars($pageTitle) ?></span>
        </div>
        <div class="ww-topbar-right">
            <div class="ww-topbar-user">
                <div class="ww-topbar-av">
                    <?php if (!empty($userPic)): ?>
                        <img src="/workwave/<?= htmlspecialchars($userPic) ?>" alt="">
                    <?php else: ?>
                        <?= $userInitial ?>
                    <?php endif; ?>
                </div>
                <?= $userName ?>
                <?php if ((int)($_SESSION['user_verified'] ?? 0) === 1): ?>
                    <i class="fa fa-check-circle" style="color:#00ffcc;" title="Compte Certifié"></i>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="ww-page">
