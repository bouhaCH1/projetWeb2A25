<?php
$pageTitle = 'My Dashboard';
include __DIR__ . '/../layout/dashboard_header.php';
?>

<div class="page-header">
    <div>
        <div class="page-header-title">Welcome back, <?= htmlspecialchars($_SESSION['user_first_name']) ?>! 👋</div>
        <div class="page-header-sub">Manage your job postings and account</div>
    </div>
    <a href="/workwave/Controller/index.php?action=job_post" class="btn btn-primary">+ Post a Job</a>
</div>

<!-- Quick actions -->
<div class="action-grid" style="margin-bottom:24px;">
    <a href="/workwave/Controller/index.php?action=job_post" class="action-card">
        <div class="action-card-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        </div>
        <div class="action-card-title">Post a Job</div>
        <div class="action-card-desc">Create a new listing to attract candidates</div>
    </a>
    <a href="/workwave/Controller/index.php?action=my_jobs" class="action-card">
        <div class="action-card-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="8" width="18" height="12" rx="1"/><path d="M7 8V6a5 5 0 0110 0v2"/></svg>
        </div>
        <div class="action-card-title">My Listings</div>
        <div class="action-card-desc">View and manage your posted job listings</div>
    </a>
    <a href="/workwave/Controller/index.php?action=jobs" class="action-card">
        <div class="action-card-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </div>
        <div class="action-card-title">Job Board</div>
        <div class="action-card-desc">See all active job postings on the platform</div>
    </a>
    <a href="/workwave/Controller/index.php?action=profile" class="action-card">
        <div class="action-card-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20v-2a8 8 0 0116 0v2"/></svg>
        </div>
        <div class="action-card-title">My Profile</div>
        <div class="action-card-desc">Update your company information and contact details</div>
    </a>
    <a href="/workwave/Controller/index.php?action=cvs" class="action-card">
        <div class="action-card-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 014-4h4a4 4 0 014 4v2"/></svg>
        </div>
        <div class="action-card-title">Browse CVs</div>
        <div class="action-card-desc">Find top talent and review candidate resumes</div>
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
