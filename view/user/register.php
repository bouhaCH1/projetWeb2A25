<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="content_box">
    <h1>Create an Account</h1>

    <?php if (!empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger"><ul>
            <?php foreach ($_SESSION['errors'] as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; unset($_SESSION['errors']); ?>
        </ul></div>
    <?php endif; ?>

    <div id="js-errors" class="alert alert-warning" style="display:none;">
        <ul id="js-error-list"></ul>
    </div>

    <form id="registerForm" action="/workwave/Controller/index.php?action=register_submit" method="POST" novalidate>

        <label>First Name *</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($_SESSION['old']['first_name'] ?? '') ?>">

        <label>Last Name *</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($_SESSION['old']['last_name'] ?? '') ?>">

        <label>Email Address *</label>
        <input type="text" id="email" name="email" value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>">

        <label>Phone Number</label>
        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($_SESSION['old']['phone'] ?? '') ?>">

        <label>I am a *</label>
        <select id="role" name="role">
            <option value="">-- Select --</option>
            <option value="job_seeker" <?= (($_SESSION['old']['role'] ?? '') === 'job_seeker') ? 'selected' : '' ?>>Job Seeker</option>
            <option value="employer"   <?= (($_SESSION['old']['role'] ?? '') === 'employer')   ? 'selected' : '' ?>>Employer / Company</option>
        </select>

        <label>Password * <small style="color:#aaa;">(Min. 8 chars, one uppercase, one number)</small></label>
        <input type="password" id="password" name="password">

        <label>Confirm Password *</label>
        <input type="password" id="confirm_password" name="confirm_password">

        <br/>
        <button type="submit" class="btn btn-primary">Register</button>
        <a href="/workwave/Controller/index.php?action=login" class="btn btn-secondary">Already have an account?</a>

    </form>
    <?php unset($_SESSION['old']); ?>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', function(e) {
    var errors = [];
    var firstName = document.querySelector('[name="first_name"]').value.trim();
    var lastName  = document.querySelector('[name="last_name"]').value.trim();
    var email     = document.getElementById('email').value.trim();
    var phone     = document.getElementById('phone').value.trim();
    var role      = document.getElementById('role').value;
    var password  = document.getElementById('password').value;
    var confirm   = document.getElementById('confirm_password').value;
    var nameRegex  = /^[a-zA-ZÀ-ÿ\s\-]{2,50}$/;
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var phoneRegex = /^\+?[0-9\s\-]{7,15}$/;

    if (!firstName)                       errors.push('First name is required.');
    else if (!nameRegex.test(firstName))  errors.push('First name must be 2-50 letters only.');
    if (!lastName)                        errors.push('Last name is required.');
    else if (!nameRegex.test(lastName))   errors.push('Last name must be 2-50 letters only.');
    if (!email)                           errors.push('Email is required.');
    else if (!emailRegex.test(email))     errors.push('Invalid email format.');
    if (phone && !phoneRegex.test(phone)) errors.push('Phone number is invalid.');
    if (!role)                            errors.push('Please select a role.');
    if (!password)                        errors.push('Password is required.');
    else if (password.length < 8)         errors.push('Password must be at least 8 characters.');
    else if (!/[A-Z]/.test(password))     errors.push('Password must contain at least one uppercase letter.');
    else if (!/[0-9]/.test(password))     errors.push('Password must contain at least one number.');
    if (password !== confirm)             errors.push('Passwords do not match.');

    if (errors.length > 0) {
        e.preventDefault();
        var list = document.getElementById('js-error-list');
        list.innerHTML = '';
        errors.forEach(function(msg) {
            var li = document.createElement('li'); li.textContent = msg; list.appendChild(li);
        });
        document.getElementById('js-errors').style.display = 'block';
        window.scrollTo(0,0);
    }
});
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
