<?php
$pageTitle = 'My Dashboard';
include __DIR__ . '/../layout/pl_dashboard_header.php';
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
        <div class="action-card-desc">Update your personal information</div>
    </a>

    <!-- Placeholder actions for future features -->
    <a href="#" class="action-card" style="border-style: dashed; cursor: default;">
        <div class="action-card-icon" style="background: rgba(255, 215, 0, 0.1); color: var(--gold-light);">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <div class="action-card-title">My Applications</div>
        <div class="action-card-desc">Track your submitted jobs (Coming Soon)</div>
    </a>

    <a href="#" class="action-card" style="border-style: dashed; cursor: default;">
        <div class="action-card-icon" style="background: rgba(0, 200, 100, 0.1); color: #00c864;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
        </div>
        <div class="action-card-title">Saved Jobs</div>
        <div class="action-card-desc">View your bookmarked roles (Coming Soon)</div>
    </a>

</div>

<!-- Available Jobs Placeholder Section -->
<div class="dsh-card" style="margin-bottom: 24px;">
    <div class="dsh-card-head" style="display:flex; justify-content:space-between; align-items:center; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; margin-bottom: 15px;">
        <div class="dsh-card-title">Recommended Jobs</div>
        <a href="#" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.85rem;" onclick="event.preventDefault();">Browse All</a>
    </div>
    <div class="job-list" style="display: flex; flex-direction: column; gap: 12px;">
        <!-- Static Job Item 1 -->
        <div style="border: 1px solid var(--border-color); padding: 16px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; background-color: var(--card-bg);">
            <div>
                <h4 style="margin: 0 0 6px 0; color: var(--gold-light); font-size: 1.1rem;">Frontend Developer</h4>
                <div style="color: #888; font-size: 0.9rem; display: flex; flex-wrap: wrap; gap: 15px;">
                    <span style="display:flex; align-items:center; gap:4px;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V5a2 2 0 012-2h10a2 2 0 012 2v16M9 21v-4a2 2 0 012-2h2a2 2 0 012 2v4M9 7h6M9 11h6"/></svg> TechNova Corp</span>
                    <span style="display:flex; align-items:center; gap:4px;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg> Remote</span>
                    <span style="display:flex; align-items:center; gap:4px;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg> $70k - $90k</span>
                </div>
            </div>
            <a href="#" class="btn btn-outline" style="padding: 6px 16px; font-size: 0.85rem;" onclick="event.preventDefault();">View Details</a>
        </div>
        
        <!-- Static Job Item 2 -->
        <div style="border: 1px solid var(--border-color); padding: 16px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; background-color: var(--card-bg);">
            <div>
                <h4 style="margin: 0 0 6px 0; color: var(--gold-light); font-size: 1.1rem;">UX/UI Designer</h4>
                <div style="color: #888; font-size: 0.9rem; display: flex; flex-wrap: wrap; gap: 15px;">
                    <span style="display:flex; align-items:center; gap:4px;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V5a2 2 0 012-2h10a2 2 0 012 2v16M9 21v-4a2 2 0 012-2h2a2 2 0 012 2v4M9 7h6M9 11h6"/></svg> Creative Labs</span>
                    <span style="display:flex; align-items:center; gap:4px;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg> New York, NY</span>
                    <span style="display:flex; align-items:center; gap:4px;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg> $50k - $65k</span>
                </div>
            </div>
            <a href="#" class="btn btn-outline" style="padding: 6px 16px; font-size: 0.85rem;" onclick="event.preventDefault();">View Details</a>
        </div>
        
        <!-- Static Job Item 3 -->
        <div style="border: 1px solid var(--border-color); padding: 16px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; background-color: var(--card-bg);">
            <div>
                <h4 style="margin: 0 0 6px 0; color: var(--gold-light); font-size: 1.1rem;">Data Analyst</h4>
                <div style="color: #888; font-size: 0.9rem; display: flex; flex-wrap: wrap; gap: 15px;">
                    <span style="display:flex; align-items:center; gap:4px;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V5a2 2 0 012-2h10a2 2 0 012 2v16M9 21v-4a2 2 0 012-2h2a2 2 0 012 2v4M9 7h6M9 11h6"/></svg> DataSphere.io</span>
                    <span style="display:flex; align-items:center; gap:4px;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg> London, UK</span>
                    <span style="display:flex; align-items:center; gap:4px;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg> $60k - $80k</span>
                </div>
            </div>
            <a href="#" class="btn btn-outline" style="padding: 6px 16px; font-size: 0.85rem;" onclick="event.preventDefault();">View Details</a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/pl_dashboard_footer.php'; ?>
