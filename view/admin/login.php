<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="content_box" style="max-width:480px;margin:0 auto;">
    <h1 style="margin-bottom:8px;">Administrator login</h1>
    <p style="color:#aaa;font-size:0.95rem;margin-bottom:20px;"><a href="/workwave/Controller/index.php?action=login">Public login</a> for seekers and employers.</p>

    <?php if (!empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger"><ul>
            <?php foreach ($_SESSION['errors'] as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; unset($_SESSION['errors']); ?>
        </ul></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <div id="js-errors" class="alert alert-warning" style="display:none;">
        <ul id="js-error-list"></ul>
    </div>

    <form id="adminLoginForm" action="/workwave/Controller/index.php?action=admin_login_submit" method="POST" novalidate>

        <label>Administrator email</label>
        <input type="text" id="email" name="email" autocomplete="username">

        <label>Password</label>
        <input type="password" id="password" name="password" autocomplete="current-password">

        <br/>
        <button type="submit" class="btn btn-primary">Sign in to admin panel</button>
        <a href="/workwave/Controller/index.php" class="btn btn-secondary">← Back to site</a>

    </form>
</div>

<script>
document.getElementById('adminLoginForm').addEventListener('submit', function(e) {
    var errors = [];
    var email = document.getElementById('email').value.trim();
    var password = document.getElementById('password').value;
    if (!email) errors.push('Email is required.');
    if (!password) errors.push('Password is required.');
    if (errors.length > 0) {
        e.preventDefault();
        var list = document.getElementById('js-error-list');
        list.innerHTML = '';
        errors.forEach(function(msg) {
            var li = document.createElement('li'); li.textContent = msg; list.appendChild(li);
        });
        document.getElementById('js-errors').style.display = 'block';
        window.scrollTo(0, 0);
    }
});
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
