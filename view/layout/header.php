<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Job Platform</title>
<link href="/job_platform/templatemo_style.css" rel="stylesheet" type="text/css" />
<style>
    .alert-danger  { background:#ffe0e0; border:1px solid #f00; padding:10px; margin-bottom:10px; color:#900; }
    .alert-success { background:#e0ffe0; border:1px solid #0a0; padding:10px; margin-bottom:10px; color:#060; }
    .alert-warning { background:#fff8e0; border:1px solid #fa0; padding:10px; margin-bottom:10px; color:#960; }
    .alert ul { margin:0; padding-left:18px; }
    label  { display:block; margin-top:8px; font-weight:bold; color:#ccc; }
    input[type="text"], input[type="password"], input[type="file"], select, textarea {
        width:100%; padding:6px; margin-top:3px; background:#222; color:#fff;
        border:1px solid #555; box-sizing:border-box;
    }
    .btn { display:inline-block; padding:8px 18px; margin-top:10px; cursor:pointer; border:none; }
    .btn-primary   { background:#8b0000; color:#fff; }
    .btn-success   { background:#2a6000; color:#fff; }
    .btn-danger    { background:#600; color:#fff; }
    .btn-secondary { background:#444; color:#fff; }
    .btn-warning   { background:#996600; color:#fff; }
    table { width:100%; border-collapse:collapse; color:#ccc; }
    table th { background:#333; padding:8px; text-align:left; }
    table td { padding:8px; border-bottom:1px solid #333; }
    .badge-employer { background:#8b0000; color:#fff; padding:2px 8px; }
    .badge-seeker   { background:#444;    color:#fff; padding:2px 8px; }
</style>
</head>
<body>

<div id="templatemo_body_wrapper">
    <div id="templatemo_wrapper">

        <div id="templatemo_menu">
            <ul>
                <li><a href="/job_platform/index.php" class="current">Home</a></li>
                <?php if (!empty($_SESSION['user_id'])): ?>
                    <li><a href="/job_platform/index.php?action=profile">My Profile</a></li>
                    <?php if ($_SESSION['user_role'] === 'employer'): ?>
                    <li><a href="/job_platform/index.php?action=admin_users">Admin Panel</a></li>
                    <?php endif; ?>
                    <li><a href="/job_platform/index.php?action=logout">Log Out</a></li>
                <?php else: ?>
                    <li><a href="/job_platform/index.php?action=login">Log In</a></li>
                    <li><a href="/job_platform/index.php?action=register">Register</a></li>
                <?php endif; ?>
            </ul>
            <div class="cleaner"></div>
        </div>

        <div id="templatemo_header">
            <div id="site_title">
                <h1><a href="/job_platform/index.php">Job Platform</a></h1>
            </div>
        </div>

        <div id="templatmeo_main">
            <div id="templatemo_content"><span class="bottom"></span>
