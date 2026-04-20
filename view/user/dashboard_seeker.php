<?php
$pageTitle = 'My Dashboard';
include __DIR__ . '/../layout/dashboard_header.php';
?>

<div class="page-header">
    <div>
        <div class="page-header-title">Welcome back, <?= htmlspecialchars($_SESSION['user_first_name']) ?>! 👋</div>
        <div class="page-header-sub">Here's what's happening with your job search</div>
    </div>

</div>

<!-- Quick actions -->
<div class="action-grid" style="margin-bottom:24px;">

    <a href="/workwave/Controller/index.php?action=profile" class="action-card">
        <div class="action-card-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20v-2a8 8 0 0116 0v2"/></svg>
        </div>
        <div class="action-card-title">My Profile</div>
        <div class="action-card-desc">Update your personal information and profile picture</div>
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
