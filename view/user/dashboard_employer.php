<?php
$pageTitle = 'My Dashboard';
include __DIR__ . '/../layout/dashboard_header.php';
?>

<div class="page-header">
    <div>
        <div class="page-header-title">Welcome back, <?= htmlspecialchars($_SESSION['user_first_name']) ?>! 👋</div>
        <div class="page-header-sub">Manage your job postings and account</div>
    </div>

</div>

<!-- Quick actions -->
<div class="action-grid" style="margin-bottom:24px;">

    <a href="/workwave/Controller/index.php?action=profile" class="action-card">
        <div class="action-card-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20v-2a8 8 0 0116 0v2"/></svg>
        </div>
        <div class="action-card-title">My Profile</div>
        <div class="action-card-desc">Update your company information and contact details</div>
    </a>

</div>

<!-- Tips card -->
<div class="dsh-card">
    <div class="dsh-card-head">
        <div class="dsh-card-title">Tips for Employers</div>
    </div>
    <ul style="color:#888;font-size:.85rem;line-height:2;padding-left:20px;">
        <li>Write clear, detailed job descriptions to attract the right candidates</li>
        <li>Include the employment type and salary range to improve visibility</li>
        <li>Keep your listings up to date — remove expired postings promptly</li>
    </ul>
</div>

<?php include __DIR__ . '/../layout/dashboard_footer.php'; ?>
