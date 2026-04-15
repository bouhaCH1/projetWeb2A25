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
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700&family=Libre+Franklin:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
/* ── Reset & Base ─────────────────────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { background: #0a0a0a; color: #d0d0d0; font-family: 'Libre Franklin', sans-serif; font-size: 14px; line-height: 1.6; }
a { color: #C4A15A; text-decoration: none; }
a:hover { color: #d4b16a; }

/* ── Layout ───────────────────────────────────────────────────── */
.dsh-wrapper { display: flex; min-height: 100vh; }

/* ── Sidebar ──────────────────────────────────────────────────── */
.dsh-sidebar {
    width: 240px; min-height: 100vh;
    background: #0f0f0f; border-right: 1px solid #1c1c1c;
    display: flex; flex-direction: column;
    position: fixed; top: 0; left: 0; z-index: 200;
    transition: transform .3s ease;
}
.dsh-logo-wrap {
    padding: 24px 20px 18px;
    border-bottom: 1px solid #1c1c1c;
}
.dsh-logo {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.5rem; font-weight: 700; color: #fff; letter-spacing: 1px;
}
.dsh-logo span { color: #C4A15A; }
.dsh-role-chip {
    display: inline-block; margin-top: 6px;
    font-size: 0.62rem; text-transform: uppercase; letter-spacing: 2px;
    color: #C4A15A; background: rgba(196,161,90,.1);
    padding: 2px 8px; border-radius: 20px; border: 1px solid rgba(196,161,90,.25);
}

/* User info strip */
.dsh-user-strip {
    padding: 14px 20px; border-bottom: 1px solid #1c1c1c;
    display: flex; align-items: center; gap: 11px;
}
.dsh-avatar {
    width: 38px; height: 38px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, #C4A15A, #7a5f30);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: .95rem; color: #000; overflow: hidden;
}
.dsh-avatar img { width: 100%; height: 100%; object-fit: cover; }
.dsh-user-name { font-size: .82rem; font-weight: 600; color: #e8e8e8; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 156px; }
.dsh-user-role { font-size: .7rem; color: #666; margin-top: 1px; text-transform: capitalize; }

/* Nav */
.dsh-nav { flex: 1; padding: 12px 0; overflow-y: auto; }
.dsh-nav-label {
    font-size: .6rem; text-transform: uppercase; letter-spacing: 2px;
    color: #444; padding: 10px 20px 4px;
}
.dsh-nav-link {
    display: flex; align-items: center; gap: 11px;
    padding: 10px 20px; color: #888; font-size: .83rem;
    border-left: 3px solid transparent; transition: all .18s;
}
.dsh-nav-link svg { flex-shrink: 0; opacity: .75; }
.dsh-nav-link:hover { color: #d0d0d0; background: rgba(196,161,90,.06); border-left-color: rgba(196,161,90,.35); }
.dsh-nav-link.active { color: #C4A15A; background: rgba(196,161,90,.1); border-left-color: #C4A15A; font-weight: 600; }
.dsh-nav-link.active svg { opacity: 1; }

/* Sidebar footer — logout */
.dsh-sidebar-foot {
    padding: 14px 20px; border-top: 1px solid #1c1c1c;
}
.dsh-logout {
    display: flex; align-items: center; gap: 10px;
    color: #666; font-size: .83rem; transition: color .18s;
}
.dsh-logout:hover { color: #e05555; }

/* ── Main area ────────────────────────────────────────────────── */
.dsh-main { margin-left: 240px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

/* Topbar */
.dsh-topbar {
    background: #0f0f0f; border-bottom: 1px solid #1c1c1c;
    padding: 0 28px; height: 58px;
    display: flex; align-items: center; justify-content: space-between;
    position: sticky; top: 0; z-index: 100;
}
.dsh-topbar-left { display: flex; align-items: center; gap: 14px; }
.dsh-topbar-title { font-family: 'Cormorant Garamond', serif; font-size: 1.25rem; color: #fff; font-weight: 600; }
.dsh-burger {
    display: none; background: none; border: 1px solid #222; color: #aaa;
    padding: 6px 8px; border-radius: 5px; cursor: pointer; align-items: center;
}
.dsh-topbar-right { display: flex; align-items: center; gap: 10px; }
.dsh-topbar-link {
    font-size: .78rem; color: #666; padding: 6px 12px;
    border: 1px solid #1e1e1e; border-radius: 5px; transition: all .18s;
}
.dsh-topbar-link:hover { color: #d0d0d0; border-color: #444; }

/* Content */
.dsh-content { padding: 28px 32px; flex: 1; }

/* ── Reusable components ──────────────────────────────────────── */
/* Alerts */
.alert { padding: 12px 16px; border-radius: 6px; margin-bottom: 18px; font-size: .85rem; }
.alert ul { margin: 0; padding-left: 18px; }
.alert-danger  { background: rgba(220,60,60,.1);  border: 1px solid rgba(220,60,60,.3);  color: #ff8080; }
.alert-success { background: rgba(60,200,100,.1); border: 1px solid rgba(60,200,100,.3); color: #70c888; }
.alert-warning { background: rgba(255,180,0,.1);  border: 1px solid rgba(255,180,0,.3);  color: #ffc040; }

/* Buttons */
.btn { display: inline-block; padding: 9px 18px; border-radius: 6px; font-size: .82rem; font-weight: 500; border: none; cursor: pointer; transition: all .18s; text-align: center; font-family: inherit; }
.btn-primary   { background: #C4A15A; color: #000; }
.btn-primary:hover { background: #d4b16a; color: #000; }
.btn-secondary { background: #1a1a1a; color: #999; border: 1px solid #2a2a2a; }
.btn-secondary:hover { background: #252525; color: #e0e0e0; }
.btn-danger    { background: rgba(220,53,53,.12); color: #ff6b6b; border: 1px solid rgba(220,53,53,.3); }
.btn-danger:hover { background: rgba(220,53,53,.22); }
.btn-warning   { background: rgba(255,165,0,.12); color: #ffa040; border: 1px solid rgba(255,165,0,.3); }
.btn-warning:hover { background: rgba(255,165,0,.22); }
.btn-sm { padding: 5px 11px; font-size: .76rem; }
.btn-outline { background: transparent; color: #C4A15A; border: 1px solid rgba(196,161,90,.4); }
.btn-outline:hover { background: rgba(196,161,90,.08); }

/* Forms */
form label { display: block; margin-top: 14px; font-size: .78rem; font-weight: 600; color: #888; text-transform: uppercase; letter-spacing: .6px; }
input[type="text"], input[type="password"], input[type="file"], select, textarea {
    width: 100%; padding: 9px 13px; margin-top: 5px;
    background: #141414; color: #d0d0d0;
    border: 1px solid #242424; border-radius: 6px;
    font-family: inherit; font-size: .88rem; transition: border-color .2s;
}
input:focus, select:focus, textarea:focus { outline: none; border-color: #C4A15A; }
input:disabled { opacity: .5; cursor: not-allowed; }

/* Tables */
.dsh-table-wrap { overflow-x: auto; border-radius: 8px; border: 1px solid #1c1c1c; }
table { width: 100%; border-collapse: collapse; }
table th { background: #121212; color: #888; padding: 11px 16px; text-align: left; font-size: .7rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; white-space: nowrap; }
table td { padding: 11px 16px; border-top: 1px solid #181818; color: #bbb; font-size: .85rem; vertical-align: middle; }
table tbody tr:hover td { background: rgba(255,255,255,.025); }

/* Stat cards */
.stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 14px; margin-bottom: 26px; }
.stat-card { background: #0f0f0f; border: 1px solid #1c1c1c; border-radius: 10px; padding: 20px 22px; }
.stat-card-label { font-size: .65rem; text-transform: uppercase; letter-spacing: 1.5px; color: #555; margin-bottom: 10px; }
.stat-card-value { font-family: 'Cormorant Garamond', serif; font-size: 2.2rem; color: #C4A15A; line-height: 1; font-weight: 700; }
.stat-card-sub { font-size: .72rem; color: #444; margin-top: 5px; }

/* Section card */
.dsh-card { background: #0f0f0f; border: 1px solid #1c1c1c; border-radius: 10px; padding: 22px 24px; margin-bottom: 22px; }
.dsh-card-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
.dsh-card-title { font-size: .95rem; font-weight: 600; color: #e0e0e0; }

/* Badges */
.badge { display: inline-block; padding: 3px 9px; border-radius: 20px; font-size: .7rem; font-weight: 600; }
.badge-employer { background: rgba(196,161,90,.15); color: #C4A15A; border: 1px solid rgba(196,161,90,.3); }
.badge-seeker   { background: rgba(120,120,255,.12); color: #8888ff; border: 1px solid rgba(120,120,255,.25); }

/* Quick-action cards */
.action-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; }
.action-card {
    background: #0f0f0f; border: 1px solid #1c1c1c; border-radius: 10px;
    padding: 20px 22px; display: flex; flex-direction: column; gap: 10px;
    transition: border-color .2s, background .2s;
}
.action-card:hover { border-color: rgba(196,161,90,.4); background: rgba(196,161,90,.04); }
.action-card-icon {
    width: 40px; height: 40px; border-radius: 8px;
    background: rgba(196,161,90,.1); display: flex; align-items: center; justify-content: center;
    color: #C4A15A;
}
.action-card-title { font-size: .88rem; font-weight: 600; color: #e0e0e0; }
.action-card-desc  { font-size: .77rem; color: #666; }

/* Page header */
.page-header { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 24px; }
.page-header-title { font-family: 'Cormorant Garamond', serif; font-size: 1.75rem; color: #fff; font-weight: 700; }
.page-header-sub   { font-size: .82rem; color: #666; margin-top: 3px; }

/* Responsive */
@media (max-width: 768px) {
    .dsh-sidebar { transform: translateX(-100%); }
    .dsh-sidebar.open { transform: translateX(0); box-shadow: 4px 0 24px rgba(0,0,0,.6); }
    .dsh-main { margin-left: 0; }
    .dsh-content { padding: 18px 16px; }
    .dsh-burger { display: flex; }
    .stat-grid { grid-template-columns: repeat(2, 1fr); }
    .action-grid { grid-template-columns: 1fr; }
}
</style>
</head>
<body>
<div class="dsh-wrapper">

<!-- ───────── SIDEBAR ───────── -->
<aside class="dsh-sidebar" id="dshSidebar">

    <div class="dsh-logo-wrap">
        <a href="/workwave/Controller/index.php" class="dsh-logo">Work<span>Wave</span></a><br>
        <?php if ($role === 'admin'): ?>
            <span class="dsh-role-chip">Admin Panel</span>
        <?php elseif ($role === 'employer'): ?>
            <span class="dsh-role-chip">Employer</span>
        <?php else: ?>
            <span class="dsh-role-chip">Job Seeker</span>
        <?php endif; ?>
    </div>

    <div class="dsh-user-strip">
        <div class="dsh-avatar">
            <?php if (!empty($userPic)): ?>
                <img src="/workwave/<?= htmlspecialchars($userPic) ?>" alt="avatar">
            <?php else: ?>
                <?= $userInitial ?>
            <?php endif; ?>
        </div>
        <div>
            <div class="dsh-user-name"><?= $userName ?></div>
            <div class="dsh-user-role"><?= htmlspecialchars(str_replace('_', ' ', $role)) ?></div>
        </div>
    </div>

    <nav class="dsh-nav">
        <?php if ($role === 'admin'): ?>
            <div class="dsh-nav-label">Overview</div>
            <a href="/workwave/Controller/index.php?action=admin_dashboard"
               class="dsh-nav-link <?= $action === 'admin_dashboard' ? 'active' : '' ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
            <div class="dsh-nav-label">Users</div>
            <a href="/workwave/Controller/index.php?action=admin_users"
               class="dsh-nav-link <?= $action === 'admin_users' ? 'active' : '' ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 014-4h4a4 4 0 014 4v2"/><path d="M16 3.13a4 4 0 010 7.75"/><path d="M21 21v-2a4 4 0 00-3-3.85"/></svg>
                Manage Users
            </a>
            <a href="/workwave/Controller/index.php?action=admin_add_user"
               class="dsh-nav-link <?= $action === 'admin_add_user' ? 'active' : '' ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 014-4h4"/><line x1="17" y1="11" x2="17" y2="17"/><line x1="14" y1="14" x2="20" y2="14"/></svg>
                Add User
            </a>
            <div class="dsh-nav-label">Site</div>
            <a href="/workwave/Controller/index.php?action=jobs" class="dsh-nav-link">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="8" width="18" height="12" rx="1"/><path d="M7 8V6a5 5 0 0110 0v2"/></svg>
                View Jobs
            </a>
            <a href="/workwave/Controller/index.php" class="dsh-nav-link">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                Public Site
            </a>

        <?php elseif ($role === 'employer'): ?>
            <div class="dsh-nav-label">My Account</div>
            <a href="/workwave/Controller/index.php?action=dashboard_employer"
               class="dsh-nav-link <?= $action === 'dashboard_employer' ? 'active' : '' ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
            <a href="/workwave/Controller/index.php?action=profile"
               class="dsh-nav-link <?= $action === 'profile' ? 'active' : '' ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="8" r="4"/><path d="M4 20v-2a8 8 0 0116 0v2"/></svg>
                My Profile
            </a>
            <div class="dsh-nav-label">Jobs</div>
            <a href="/workwave/Controller/index.php?action=my_jobs"
               class="dsh-nav-link <?= $action === 'my_jobs' ? 'active' : '' ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="8" width="18" height="12" rx="1"/><path d="M7 8V6a5 5 0 0110 0v2"/></svg>
                My Listings
            </a>
            <a href="/workwave/Controller/index.php?action=job_post"
               class="dsh-nav-link <?= $action === 'job_post' ? 'active' : '' ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Post a Job
            </a>
            <a href="/workwave/Controller/index.php?action=jobs" class="dsh-nav-link">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                Browse All Jobs
            </a>

        <?php else: /* job_seeker */ ?>
            <div class="dsh-nav-label">My Account</div>
            <a href="/workwave/Controller/index.php?action=dashboard_seeker"
               class="dsh-nav-link <?= $action === 'dashboard_seeker' ? 'active' : '' ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
            <a href="/workwave/Controller/index.php?action=profile"
               class="dsh-nav-link <?= $action === 'profile' ? 'active' : '' ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="8" r="4"/><path d="M4 20v-2a8 8 0 0116 0v2"/></svg>
                My Profile
            </a>
            <div class="dsh-nav-label">Jobs</div>
            <a href="/workwave/Controller/index.php?action=jobs"
               class="dsh-nav-link <?= $action === 'jobs' ? 'active' : '' ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                Browse Jobs
            </a>
        <?php endif; ?>
    </nav>

    <div class="dsh-sidebar-foot">
        <a href="/workwave/Controller/index.php?action=logout" class="dsh-logout">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Sign Out
        </a>
    </div>
</aside>

<!-- ───────── MAIN ───────── -->
<div class="dsh-main">
    <div class="dsh-topbar">
        <div class="dsh-topbar-left">
            <button class="dsh-burger" id="dshBurger" aria-label="Toggle menu">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <div class="dsh-topbar-title"><?= htmlspecialchars($pageTitle) ?></div>
        </div>
        <div class="dsh-topbar-right">
            <a href="/workwave/Controller/index.php" class="dsh-topbar-link">← Public Site</a>
        </div>
    </div>
    <div class="dsh-content">
