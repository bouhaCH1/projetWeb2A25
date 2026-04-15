<?php
$pageTitle = 'Add New User';
include __DIR__ . '/../layout/dashboard_header.php';
?>

<div class="page-header">
    <div>
        <div class="page-header-title">Add New User</div>
        <div class="page-header-sub">Manually create a job seeker or employer account</div>
    </div>
    <a href="/workwave/Controller/index.php?action=admin_users" class="btn btn-secondary">← Back to Users</a>
</div>

<?php if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger"><ul>
        <?php foreach ($_SESSION['errors'] as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; unset($_SESSION['errors']); ?>
    </ul></div>
<?php endif; ?>
<div class="alert alert-warning" id="js-errors" style="display:none;"><ul id="js-error-list"></ul></div>

<div class="dsh-card" style="max-width:560px;">
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

        <label>Phone <small style="color:#555;font-weight:400;">(optional)</small></label>
        <input type="text" id="phone" name="phone"
               value="<?= htmlspecialchars($_SESSION['old']['phone'] ?? '') ?>">

        <label>Role</label>
        <select id="role" name="role">
            <?php $oldRole = $_SESSION['old']['role'] ?? ''; ?>
            <option value="job_seeker" <?= $oldRole === 'job_seeker' ? 'selected' : '' ?>>Job Seeker</option>
            <option value="employer"   <?= $oldRole === 'employer'   ? 'selected' : '' ?>>Employer</option>
        </select>

        <label>Password <small style="color:#555;font-weight:400;">(min 8 chars, 1 uppercase, 1 number)</small></label>
        <input type="password" id="password" name="password">

        <label>Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password">

        <?php unset($_SESSION['old']); ?>

        <br><br>
        <button type="submit" class="btn btn-primary">Create User</button>
        <a href="/workwave/Controller/index.php?action=admin_users" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
document.getElementById('addForm').addEventListener('submit', function(e) {
    var errors = [], fn = document.getElementById('first_name').value.trim(),
        ln = document.getElementById('last_name').value.trim(),
        em = document.getElementById('email').value.trim(),
        ph = document.getElementById('phone').value.trim(),
        pw = document.getElementById('password').value,
        cp = document.getElementById('confirm_password').value,
        nr = /^[a-zA-ZÀ-ÿ\s\-]{2,50}$/, pr = /^\+?[0-9\s\-]{7,15}$/,
        er = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!fn) errors.push('First name is required.');
    else if (!nr.test(fn)) errors.push('First name: 2–50 letters only.');
    if (!ln) errors.push('Last name is required.');
    else if (!nr.test(ln)) errors.push('Last name: 2–50 letters only.');
    if (!em) errors.push('Email is required.');
    else if (!er.test(em)) errors.push('Invalid email format.');
    if (ph && !pr.test(ph)) errors.push('Phone number is invalid.');
    if (!pw) errors.push('Password is required.');
    else if (pw.length < 8) errors.push('Password must be at least 8 characters.');
    else if (!/[A-Z]/.test(pw)) errors.push('Password must contain an uppercase letter.');
    else if (!/[0-9]/.test(pw)) errors.push('Password must contain a number.');
    if (pw !== cp) errors.push('Passwords do not match.');
    if (errors.length > 0) {
        e.preventDefault();
        var list = document.getElementById('js-error-list');
        list.innerHTML = '';
        errors.forEach(function(m){ var li = document.createElement('li'); li.textContent = m; list.appendChild(li); });
        document.getElementById('js-errors').style.display = 'block';
        window.scrollTo(0,0);
    }
});
</script>

<?php include __DIR__ . '/../layout/dashboard_footer.php'; ?>
