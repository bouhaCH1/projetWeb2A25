<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="content_box">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name']) ?>! 👋</h1>
    <p>You are logged in as an <strong>Employer</strong>.</p>
    <br/>
    <a href="/job_platform/index.php?action=profile"     class="btn btn-primary">My Profile</a>
    <a href="/job_platform/index.php?action=admin_users" class="btn btn-warning">Manage Users</a>
    <a href="/job_platform/index.php?action=logout"      class="btn btn-danger">Log Out</a>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
