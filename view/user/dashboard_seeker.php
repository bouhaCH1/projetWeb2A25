<?php
$pageTitle = 'My Dashboard';
include __DIR__ . '/../layout/dashboard_header.php';
?>

<div class="page-header">
    <div>
        <div class="page-header-title">Welcome back, <?= htmlspecialchars($_SESSION['user_first_name']) ?>! 👋</div>
        <div class="page-header-sub">Here's what's happening with your job search</div>
    </div>
    <a href="/workwave/Controller/index.php?action=jobs" class="btn btn-primary">Browse Jobs</a>
</div>

<!-- Quick actions -->
<div class="action-grid" style="margin-bottom:24px;">
    <a href="/workwave/Controller/index.php?action=jobs" class="action-card">
        <div class="action-card-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </div>
        <div class="action-card-title">Browse Jobs</div>
        <div class="action-card-desc">Discover new job opportunities on the platform</div>
    </a>
    <a href="/workwave/Controller/index.php?action=profile" class="action-card">
        <div class="action-card-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20v-2a8 8 0 0116 0v2"/></svg>
        </div>
        <div class="action-card-title">My Profile</div>
        <div class="action-card-desc">Update your personal information and profile picture</div>
    </a>
    <a href="/workwave/Controller/index.php?action=my_cv" class="action-card">
        <div class="action-card-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 00-2 2v16c0 1.1.9 2 2 2h12a2 2 0 002-2V8l-6-6z"/><path d="M14 3v5h5M16 13H8M16 17H8M10 9H8"/></svg>
        </div>
        <div class="action-card-title">Manage CV</div>
        <div class="action-card-desc">Update your resume skills and details for employers</div>
    </a>
</div>

<!-- Tips card -->
<div class="dsh-card">
    <div class="dsh-card-head">
        <div class="dsh-card-title">Getting Started</div>
    </div>
    <ul style="color:#888;font-size:.85rem;line-height:2;padding-left:20px;">
        <li>Complete your profile to stand out to employers</li>
        <li>Browse the job board and find listings that match your skills</li>
        <li>Contact employers directly via the job listing details</li>
    </ul>
</div>

<?php include __DIR__ . '/../layout/dashboard_footer.php'; ?>
