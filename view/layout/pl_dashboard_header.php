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
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title><?= htmlspecialchars($pageTitle) ?> — WorkWave</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<!-- Bootstrap -->
<link href="/workwave/View/assets/plot-listing/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!-- Plot Listing CSS -->
<link rel="stylesheet" href="/workwave/View/assets/plot-listing/css/fontawesome.css">
<link rel="stylesheet" href="/workwave/View/assets/plot-listing/css/templatemo-plot-listing.css">
<link rel="stylesheet" href="/workwave/View/assets/plot-listing/css/animated.css">

<style>
/* ═══════════════════════════════════════════════════════
   WorkWave — Plot Listing Dashboard (Seeker / Employer)
═══════════════════════════════════════════════════════ */

/* Colors */
:root {
  --pl-orange:    #ef6f31;
  --pl-orange-dk: #d45a1e;
  --pl-dark:      #1a1a2e;
  --pl-mid:       #2a2a4a;
  --pl-light:     #f4f6f9;
  --pl-border:    #e0e4ea;
  --pl-text:      #444;
  --pl-muted:     #888;
  --pl-white:     #ffffff;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: 'Montserrat', sans-serif;
  background: var(--pl-light);
  color: var(--pl-text);
  font-size: 14px;
  line-height: 1.6;
}

a { color: var(--pl-orange); text-decoration: none; }
a:hover { color: var(--pl-orange-dk); }

/* ── Layout ──────────────────────────────────────── */
.pld-wrapper { display: flex; min-height: 100vh; }

/* ── Sidebar ─────────────────────────────────────── */
.pld-sidebar {
  width: 250px;
  min-height: 100vh;
  background: var(--pl-dark);
  display: flex;
  flex-direction: column;
  position: fixed;
  top: 0; left: 0;
  z-index: 500;
  transition: transform .3s ease;
}

/* Logo strip */
.pld-logo-wrap {
  padding: 26px 22px 20px;
  border-bottom: 1px solid rgba(255,255,255,.07);
}
.pld-logo {
  font-size: 1.45rem;
  font-weight: 800;
  color: #fff;
  letter-spacing: -.5px;
}
.pld-logo span { color: var(--pl-orange); }
.pld-role-chip {
  display: inline-block;
  margin-top: 7px;
  font-size: .6rem;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: var(--pl-orange);
  background: rgba(239,111,49,.12);
  padding: 3px 10px;
  border-radius: 20px;
  border: 1px solid rgba(239,111,49,.25);
}

/* User strip */
.pld-user-strip {
  padding: 16px 22px;
  border-bottom: 1px solid rgba(255,255,255,.07);
  display: flex;
  align-items: center;
  gap: 12px;
}
.pld-avatar {
  width: 40px; height: 40px;
  border-radius: 50%;
  flex-shrink: 0;
  background: linear-gradient(135deg, var(--pl-orange), var(--pl-orange-dk));
  display: flex; align-items: center; justify-content: center;
  font-weight: 800; font-size: 1rem; color: #fff; overflow: hidden;
}
.pld-avatar img { width: 100%; height: 100%; object-fit: cover; }
.pld-user-name  { font-size: .82rem; font-weight: 700; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 160px; }
.pld-user-role  { font-size: .7rem; color: rgba(255,255,255,.4); margin-top: 1px; text-transform: capitalize; }

/* Nav */
.pld-nav { flex: 1; padding: 14px 0; overflow-y: auto; }
.pld-nav-label {
  font-size: .58rem; text-transform: uppercase; letter-spacing: 2px;
  color: rgba(255,255,255,.25); padding: 10px 22px 4px;
}
.pld-nav-link {
  display: flex; align-items: center; gap: 12px;
  padding: 11px 22px;
  color: rgba(255,255,255,.55);
  font-size: .82rem; font-weight: 500;
  border-left: 3px solid transparent;
  transition: all .18s;
}
.pld-nav-link svg { flex-shrink: 0; opacity: .7; }
.pld-nav-link:hover  { color: #fff; background: rgba(255,255,255,.05); border-left-color: rgba(239,111,49,.4); }
.pld-nav-link.active { color: var(--pl-orange); background: rgba(239,111,49,.1); border-left-color: var(--pl-orange); font-weight: 700; }
.pld-nav-link.active svg { opacity: 1; }

/* Sidebar foot */
.pld-sidebar-foot {
  padding: 16px 22px;
  border-top: 1px solid rgba(255,255,255,.07);
}
.pld-logout {
  display: flex; align-items: center; gap: 10px;
  color: rgba(255,255,255,.35); font-size: .82rem;
  transition: color .18s;
}
.pld-logout:hover { color: #ff6b6b; }

/* ── Main ─────────────────────────────────────────── */
.pld-main {
  margin-left: 250px;
  flex: 1;
  display: flex; flex-direction: column;
  min-height: 100vh;
}

/* Topbar */
.pld-topbar {
  background: #fff;
  border-bottom: 1.5px solid var(--pl-border);
  padding: 0 30px; height: 62px;
  display: flex; align-items: center; justify-content: space-between;
  position: sticky; top: 0; z-index: 100;
  box-shadow: 0 2px 16px rgba(0,0,0,.06);
}
.pld-topbar-left { display: flex; align-items: center; gap: 14px; }
.pld-topbar-title {
  font-size: 1.05rem; font-weight: 800;
  color: var(--pl-dark); letter-spacing: -.3px;
}
.pld-burger {
  display: none; background: none;
  border: 1.5px solid var(--pl-border); color: #888;
  padding: 6px 8px; border-radius: 6px; cursor: pointer;
  align-items: center;
}
.pld-topbar-right { display: flex; align-items: center; gap: 10px; }
.pld-topbar-link {
  font-size: .78rem; color: var(--pl-muted); padding: 6px 14px;
  border: 1.5px solid var(--pl-border); border-radius: 6px;
  transition: all .18s; font-weight: 600;
}
.pld-topbar-link:hover { color: var(--pl-dark); border-color: #b0b8c8; }
.pld-topbar-btn {
  font-size: .78rem; font-weight: 700;
  background: var(--pl-orange); color: #fff;
  padding: 7px 16px; border-radius: 6px;
  transition: opacity .18s;
}
.pld-topbar-btn:hover { opacity: .88; color: #fff; }

/* Content */
.pld-content { padding: 30px 34px; flex: 1; }

/* ── Components ──────────────────────────────────── */

/* Alerts */
.alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 18px; font-size: .85rem; }
.alert ul { margin: 0; padding-left: 18px; }
.alert-danger  { background: rgba(220,60,60,.08);  border: 1px solid rgba(220,60,60,.25);  color: #c0392b; }
.alert-success { background: rgba(39,174,96,.08);  border: 1px solid rgba(39,174,96,.25);  color: #1e8449; }
.alert-warning { background: rgba(243,156,18,.08); border: 1px solid rgba(243,156,18,.25); color: #9a6200; }

/* Buttons */
.btn { display: inline-block; padding: 9px 18px; border-radius: 7px; font-size: .82rem; font-weight: 600; border: none; cursor: pointer; transition: all .18s; text-align: center; font-family: 'Montserrat', sans-serif; }
.btn-primary   { background: var(--pl-orange); color: #fff; }
.btn-primary:hover { background: var(--pl-orange-dk); color: #fff; }
.btn-secondary { background: #f0f2f5; color: #555; border: 1.5px solid var(--pl-border); }
.btn-secondary:hover { background: #e4e8ef; color: #222; }
.btn-danger    { background: rgba(220,53,53,.08); color: #c0392b; border: 1px solid rgba(220,53,53,.2); }
.btn-danger:hover { background: rgba(220,53,53,.15); }
.btn-outline   { background: transparent; color: var(--pl-orange); border: 1.5px solid rgba(239,111,49,.4); }
.btn-outline:hover { background: rgba(239,111,49,.07); color: var(--pl-orange); }
.btn-sm { padding: 5px 11px; font-size: .75rem; }

/* Forms */
form label { display: block; margin-top: 16px; font-size: .75rem; font-weight: 700; color: #555; text-transform: uppercase; letter-spacing: .6px; }
input[type="text"], input[type="password"], input[type="file"], select, textarea {
  width: 100%; padding: 10px 14px; margin-top: 5px;
  background: #f4f6f9; color: var(--pl-dark);
  border: 1.5px solid var(--pl-border); border-radius: 8px;
  font-family: 'Montserrat', sans-serif; font-size: .88rem;
  transition: border-color .2s, box-shadow .2s;
}
input:focus, select:focus, textarea:focus { outline: none; border-color: var(--pl-orange); box-shadow: 0 0 0 3px rgba(239,111,49,.12); }
input:disabled { opacity: .5; cursor: not-allowed; }

/* Tables */
.pld-table-wrap { overflow-x: auto; border-radius: 10px; border: 1.5px solid var(--pl-border); }
table { width: 100%; border-collapse: collapse; }
table th { background: var(--pl-light); color: #777; padding: 12px 16px; text-align: left; font-size: .68rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; white-space: nowrap; }
table td { padding: 12px 16px; border-top: 1px solid var(--pl-border); color: #555; font-size: .85rem; vertical-align: middle; }
table tbody tr:hover td { background: rgba(239,111,49,.03); }

/* Stat cards */
.stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; margin-bottom: 26px; }
.stat-card { background: #fff; border: 1.5px solid var(--pl-border); border-radius: 12px; padding: 22px 24px; }
.stat-card-label { font-size: .62rem; text-transform: uppercase; letter-spacing: 1.5px; color: #aaa; margin-bottom: 10px; font-weight: 700; }
.stat-card-value { font-size: 2.1rem; color: var(--pl-orange); line-height: 1; font-weight: 800; }
.stat-card-sub { font-size: .72rem; color: #bbb; margin-top: 6px; }

/* Section cards */
.pld-card { background: #fff; border: 1.5px solid var(--pl-border); border-radius: 12px; padding: 24px 26px; margin-bottom: 22px; }
.pld-card-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
.pld-card-title { font-size: .95rem; font-weight: 700; color: var(--pl-dark); }

/* Badges */
.badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: .68rem; font-weight: 700; }
.badge-employer { background: rgba(239,111,49,.12); color: var(--pl-orange); border: 1px solid rgba(239,111,49,.3); }
.badge-seeker   { background: rgba(52,152,219,.1); color: #2980b9; border: 1px solid rgba(52,152,219,.25); }
.badge-admin    { background: rgba(220,60,60,.1); color: #c0392b; border: 1px solid rgba(220,60,60,.25); }

/* Quick-action cards */
.action-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; }
.action-card {
  background: #fff; border: 1.5px solid var(--pl-border); border-radius: 12px;
  padding: 22px 24px; display: flex; flex-direction: column; gap: 10px;
  transition: border-color .2s, box-shadow .2s; color: inherit;
}
.action-card:hover { border-color: var(--pl-orange); box-shadow: 0 4px 20px rgba(239,111,49,.1); color: inherit; }
.action-card-icon {
  width: 42px; height: 42px; border-radius: 10px;
  background: rgba(239,111,49,.1); display: flex; align-items: center; justify-content: center;
  color: var(--pl-orange);
}
.action-card-title { font-size: .9rem; font-weight: 700; color: var(--pl-dark); }
.action-card-desc  { font-size: .77rem; color: var(--pl-muted); }

/* Page header */
.page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 26px; }
.page-header-title { font-size: 1.6rem; color: var(--pl-dark); font-weight: 800; letter-spacing: -.5px; }
.page-header-sub   { font-size: .82rem; color: var(--pl-muted); margin-top: 4px; }

/* CSS variable aliases used by existing views */
:root {
  --gold-light: var(--pl-orange);
  --border-color: var(--pl-border);
  --card-bg: #fff;
}

/* Responsive */
@media (max-width: 768px) {
  .pld-sidebar { transform: translateX(-100%); }
  .pld-sidebar.open { transform: translateX(0); box-shadow: 4px 0 30px rgba(0,0,0,.15); }
  .pld-main { margin-left: 0; }
  .pld-content { padding: 18px 16px; }
  .pld-burger { display: flex; }
  .stat-grid { grid-template-columns: repeat(2, 1fr); }
  .action-grid { grid-template-columns: 1fr; }
}
</style>
</head>
<body>
<div class="pld-wrapper">

<!-- ═══════════ SIDEBAR ═══════════ -->
<aside class="pld-sidebar" id="pldSidebar">

  <div class="pld-logo-wrap">
    <a href="/workwave/Controller/index.php" class="pld-logo">Work<span>Wave</span></a><br>
    <?php if ($role === 'employer'): ?>
      <span class="pld-role-chip">Employer</span>
    <?php else: ?>
      <span class="pld-role-chip">Job Seeker</span>
    <?php endif; ?>
  </div>

  <div class="pld-user-strip">
    <div class="pld-avatar">
      <?php if (!empty($userPic)): ?>
        <img src="/workwave/<?= htmlspecialchars($userPic) ?>" alt="avatar">
      <?php else: ?>
        <?= $userInitial ?>
      <?php endif; ?>
    </div>
    <div>
      <div class="pld-user-name"><?= $userName ?></div>
      <div class="pld-user-role"><?= htmlspecialchars(str_replace('_', ' ', $role)) ?></div>
    </div>
  </div>

  <nav class="pld-nav">
    <?php if ($role === 'employer'): ?>

      <div class="pld-nav-label">My Account</div>
      <a href="/workwave/Controller/index.php?action=dashboard_employer"
         class="pld-nav-link <?= $action === 'dashboard_employer' ? 'active' : '' ?>">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
        Dashboard
      </a>
      <a href="/workwave/Controller/index.php?action=profile"
         class="pld-nav-link <?= $action === 'profile' ? 'active' : '' ?>">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M4 20v-2a8 8 0 0116 0v2"/></svg>
        Company Profile
      </a>

      <div class="pld-nav-label">Recruitment (Coming Soon)</div>
      <a href="#" class="pld-nav-link" onclick="event.preventDefault();">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
        Post a Job
      </a>
      <a href="#" class="pld-nav-link" onclick="event.preventDefault();">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
        Manage Jobs
      </a>
      <a href="#" class="pld-nav-link" onclick="event.preventDefault();">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
        Applications
      </a>

      <div class="pld-nav-label">More</div>
      <a href="/workwave/Controller/index.php" class="pld-nav-link">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
        Public Site
      </a>

    <?php else: /* job_seeker */ ?>

      <div class="pld-nav-label">My Account</div>
      <a href="/workwave/Controller/index.php?action=dashboard_seeker"
         class="pld-nav-link <?= $action === 'dashboard_seeker' ? 'active' : '' ?>">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
        Dashboard
      </a>
      <a href="/workwave/Controller/index.php?action=profile"
         class="pld-nav-link <?= $action === 'profile' ? 'active' : '' ?>">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M4 20v-2a8 8 0 0116 0v2"/></svg>
        My Profile
      </a>

      <div class="pld-nav-label">Jobs (Coming Soon)</div>
      <a href="#" class="pld-nav-link" onclick="event.preventDefault();">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
        My Applications
      </a>
      <a href="#" class="pld-nav-link" onclick="event.preventDefault();">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg>
        Saved Jobs
      </a>
      <a href="#" class="pld-nav-link" onclick="event.preventDefault();">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        Messages
      </a>

      <div class="pld-nav-label">More</div>
      <a href="/workwave/Controller/index.php" class="pld-nav-link">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
        Public Site
      </a>

    <?php endif; ?>
  </nav>

  <div class="pld-sidebar-foot">
    <a href="/workwave/Controller/index.php?action=logout" class="pld-logout">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
      Sign Out
    </a>
  </div>
</aside>

<!-- ═══════════ MAIN ═══════════ -->
<div class="pld-main">
  <!-- Topbar -->
  <div class="pld-topbar">
    <div class="pld-topbar-left">
      <button class="pld-burger" id="pldBurger" aria-label="Toggle menu">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
      <div class="pld-topbar-title"><?= htmlspecialchars($pageTitle) ?></div>
    </div>
    <div class="pld-topbar-right">
      <a href="/workwave/Controller/index.php" class="pld-topbar-link">← Public Site</a>
    </div>
  </div>
  <!-- Content starts here -->
  <div class="pld-content">
