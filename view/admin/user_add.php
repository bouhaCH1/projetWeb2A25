<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="content_box">
    <h1>Add New User</h1>
    <a href="/workwave/Controller/index.php?action=admin_users" class="btn btn-secondary">← Back to list</a>
    <br/><br/>

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

    <form id="addForm" action="/workwave/Controller/index.php?action=admin_add_user_submit" method="POST" novalidate>

        <label>First Name</label>
        <input type="text" id="first_name" name="first_name"
               value="<?= htmlspecialchars($_SESSION['old']['first_name'] ?? '') ?>">

        <label>Last Name</label>
        <input type="text" id="last_name" name="last_name"
               value="<?= htmlspecialchars($_SESSION['old']['last_name'] ?? '') ?>">

        <label>Email</label>
        <input type="text" id="email" name="email"
               value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>">

        <label>Phone</label>
        <input type="text" id="phone" name="phone"
               value="<?= htmlspecialchars($_SESSION['old']['phone'] ?? '') ?>">

        <label>Role</label>
        <select id="role" name="role">
            <?php $oldRole = $_SESSION['old']['role'] ?? ''; ?>
            <option value="job_seeker" <?= $oldRole === 'job_seeker' ? 'selected' : '' ?>>Job Seeker</option>
            <option value="employer"   <?= $oldRole === 'employer'   ? 'selected' : '' ?>>Employer</option>
        </select>

        <label>Password</label>
        <input type="password" id="password" name="password">

        <label>Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password">

        <?php unset($_SESSION['old']); ?>

        <br/>
        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>

<script>
document.getElementById('addForm').addEventListener('submit', function(e) {
    var errors          = [];
    var firstName       = document.getElementById('first_name').value.trim();
    var lastName        = document.getElementById('last_name').value.trim();
    var email           = document.getElementById('email').value.trim();
    var phone           = document.getElementById('phone').value.trim();
    var password        = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm_password').value;
    var nameRegex       = /^[a-zA-ZÀ-ÿ\s\-]{2,50}$/;
    var phoneRegex      = /^\+?[0-9\s\-]{7,15}$/;
    var emailRegex      = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!firstName)                       errors.push('First name is required.');
    else if (!nameRegex.test(firstName))  errors.push('First name must be 2–50 letters only.');
    if (!lastName)                        errors.push('Last name is required.');
    else if (!nameRegex.test(lastName))   errors.push('Last name must be 2–50 letters only.');
    if (!email)                           errors.push('Email is required.');
    else if (!emailRegex.test(email))     errors.push('Invalid email format.');
    if (phone && !phoneRegex.test(phone)) errors.push('Phone number is invalid.');
    if (!password)                        errors.push('Password is required.');
    else if (password.length < 8)         errors.push('Password must be at least 8 characters.');
    else if (!/[A-Z]/.test(password))     errors.push('Password must contain at least one uppercase letter.');
    else if (!/[0-9]/.test(password))     errors.push('Password must contain at least one number.');
    if (password !== confirmPassword)     errors.push('Passwords do not match.');

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
