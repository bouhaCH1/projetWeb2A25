<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="content_box">
    <h1>User Management</h1>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger"><ul>
            <?php foreach ($_SESSION['errors'] as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; unset($_SESSION['errors']); ?>
        </ul></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Registered</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($users)): ?>
            <tr><td colspan="7" style="text-align:center;">No users found.</td></tr>
        <?php else: ?>
            <?php foreach ($users as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['first_name'] . ' ' . $u['last_name']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= htmlspecialchars($u['phone'] ?? '—') ?></td>
                <td>
                    <span class="<?= $u['role'] === 'employer' ? 'badge-employer' : 'badge-seeker' ?>">
                        <?= ucfirst(str_replace('_', ' ', $u['role'])) ?>
                    </span>
                </td>
                <td><?= htmlspecialchars($u['created_at']) ?></td>
                <td>
                    <a href="/job_platform/index.php?action=admin_edit_user&id=<?= $u['id'] ?>" class="btn btn-warning">Edit</a>
                    <a href="/job_platform/index.php?action=admin_delete_user&id=<?= $u['id'] ?>"
                       class="btn btn-danger"
                       onclick="return confirm('Delete this user?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
