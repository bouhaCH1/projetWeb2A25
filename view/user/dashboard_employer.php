<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="content_box">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name']) ?>! 👋</h1>
    <p>You are logged in as an <strong>Employer</strong>.</p>
    <br/>
    <a href="/workwave/Controller/index.php?action=jobs"       class="btn btn-primary">Job board</a>
    <a href="/workwave/Controller/index.php?action=job_post"   class="btn btn-primary">Post a job</a>
    <a href="/workwave/Controller/index.php?action=my_jobs"   class="btn btn-primary">My postings</a>
    <a href="/workwave/Controller/index.php?action=profile"   class="btn btn-outline">My Profile</a>
    <a href="/workwave/Controller/index.php?action=logout"    class="btn btn-danger">Log Out</a>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
