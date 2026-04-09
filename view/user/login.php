<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="content_box">
    <h1>Log In</h1>

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

    <form id="loginForm" action="/job_platform/index.php?action=login_submit" method="POST" novalidate>

        <label>Email Address</label>
        <input type="text" id="email" name="email">

        <label>Password</label>
        <input type="password" id="password" name="password">

        <br/>
        <button type="submit" class="btn btn-primary">Log In</button>
        <a href="/job_platform/index.php?action=register" class="btn btn-secondary">No account? Register</a>

    </form>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    var errors = [];
    var email    = document.getElementById('email').value.trim();
    var password = document.getElementById('password').value;
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!email)                       errors.push('Email is required.');
    else if (!emailRegex.test(email)) errors.push('Invalid email format.');
    if (!password)                    errors.push('Password is required.');

    if (errors.length > 0) {
        e.preventDefault();
        var list = document.getElementById('js-error-list');
        list.innerHTML = '';
        errors.forEach(function(msg) {
            var li = document.createElement('li'); li.textContent = msg; list.appendChild(li);
        });
        document.getElementById('js-errors').style.display = 'block';
    }
});
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
