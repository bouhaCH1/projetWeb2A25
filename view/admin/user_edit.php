<?php
$pageTitle = 'Edit User';
include __DIR__ . '/../layout/dashboard_header.php';
?>

<div class="page-header">
    <div>
        <div class="page-header-title">Edit User</div>
        <div class="page-header-sub">Updating: <?= htmlspecialchars($data['first_name'] . ' ' . $data['last_name']) ?></div>
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
    <form id="editForm" action="/workwave/Controller/index.php?action=admin_update_user" method="POST" novalidate>
        <input type="hidden" name="id" value="<?= (int)$data['id'] ?>">

        <label>First Name</label>
        <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($data['first_name']) ?>">

        <label>Last Name</label>
        <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($data['last_name']) ?>">

        <label>Email <small style="color:#555;font-weight:400;">(cannot be changed)</small></label>
        <input type="text" value="<?= htmlspecialchars($data['email']) ?>" disabled>

        <label>Phone <small style="color:#555;font-weight:400;">(optional)</small></label>
        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($data['phone'] ?? '') ?>">

        <label>Role</label>
        <select id="role" name="role">
            <option value="job_seeker" <?= $data['role'] === 'job_seeker' ? 'selected' : '' ?>>Job Seeker</option>
            <option value="employer"   <?= $data['role'] === 'employer'   ? 'selected' : '' ?>>Employer</option>
        </select>

        <br><br>
        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="/workwave/Controller/index.php?action=admin_users" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
document.getElementById('editForm').addEventListener('submit', function(e) {
    var errors = [], fn = document.getElementById('first_name').value.trim(),
        ln = document.getElementById('last_name').value.trim(),
        ph = document.getElementById('phone').value.trim(),
        nr = /^[a-zA-ZÀ-ÿ\s\-]{2,50}$/, pr = /^\+?[0-9\s\-]{7,15}$/;
    if (!fn) errors.push('First name is required.');
    else if (!nr.test(fn)) errors.push('First name is invalid.');
    if (!ln) errors.push('Last name is required.');
    else if (!nr.test(ln)) errors.push('Last name is invalid.');
    if (ph && !pr.test(ph)) errors.push('Phone number is invalid.');
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
