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



<?php include __DIR__ . '/../layout/dashboard_footer.php'; ?>
