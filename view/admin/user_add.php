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



<?php include __DIR__ . '/../layout/dashboard_footer.php'; ?>
