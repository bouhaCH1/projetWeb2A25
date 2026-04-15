<?php
if (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: /workwave/Controller/index.php');
    exit;
}
include __DIR__ . '/../layout/header.php';
?>

<div class="content_box">

    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:24px;">
        <div>
            <h1 style="margin:0;">🛡️ Admin Panel — User Management</h1>
            <p style="margin:4px 0 0; color:#aaa; font-size:0.9rem;">
                Logged in as <strong style="color:#C4A15A;"><?= htmlspecialchars($_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name']) ?></strong>
                &nbsp;|&nbsp; <a href="/workwave/Controller/index.php?action=logout">Log Out</a>
            </p>
        </div>
        <div style="display:flex; align-items:center; gap:12px;">
            <a href="/workwave/Controller/index.php?action=admin_add_user"
               class="btn btn-primary" style="font-weight:700;">+ Add User</a>
            <span style="background:#C4A15A; color:#000; padding:6px 14px; border-radius:20px; font-weight:700; font-size:0.85rem; letter-spacing:1px;">
                ADMINISTRATOR
            </span>
        </div>
    </div>

    <!-- ── Flash Messages ─────────────────────────────────────────── -->
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

    <!-- ── Users Table ────────────────────────────────────────────── -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Registered</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($users)): ?>
            <tr><td colspan="7" style="text-align:center; color:#aaa;">No users found.</td></tr>
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
                    <a href="/workwave/Controller/index.php?action=admin_edit_user&id=<?= $u['id'] ?>"
                       class="btn btn-warning">Edit</a>
                    <a href="/workwave/Controller/index.php?action=admin_delete_user&id=<?= $u['id'] ?>"
                       class="btn btn-danger"
                       onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>

    <p style="margin-top:16px; color:#666; font-size:0.85rem;">
        * Admin accounts are not listed here and are protected from deletion.
    </p>

</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
