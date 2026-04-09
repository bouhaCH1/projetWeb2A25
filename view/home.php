<?php
if (!empty($_SESSION['user_id'])) {
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'employer') {
        header('Location: index.php?action=dashboard_employer');
    } else {
        header('Location: index.php?action=dashboard_seeker');
    }
    exit;
}
?>
<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="content_box">
    <h1>Welcome to Job Platform</h1>
    <p>Find your dream job or the perfect candidate. We connect talented individuals with top companies.</p>
    <br/>
    <p>
        <a href="/job_platform/index.php?action=login" class="btn btn-primary">Log In</a>
        <a href="/job_platform/index.php?action=register" class="btn btn-secondary">Register</a>
    </p>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
