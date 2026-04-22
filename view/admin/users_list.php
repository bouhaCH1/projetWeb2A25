<?php
if (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: /workwave/Controller/index.php');
    exit;
}
$pageTitle = 'Gérer les utilisateurs';
include __DIR__ . '/../layout/dashboard_header.php';
?>

<div class="page-header">
    <div>
        <div class="page-header-title">Gérer les utilisateurs</div>
        <div class="page-header-sub">Tous les candidats et employeurs enregistrés</div>
    </div>
    <a href="/workwave/Controller/index.php?action=admin_add_user" class="btn btn-primary">+ Ajouter un utilisateur</a>
</div>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger"><ul>
        <?php foreach ($_SESSION['errors'] as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; unset($_SESSION['errors']); ?>
    </ul></div>
<?php endif; ?>

<div class="dsh-table-wrap">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>E-mail</th>
                <th>Téléphone</th>
                <th>Rôle</th>
                <th>Enregistré le</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($users)): ?>
            <tr><td colspan="7" style="text-align:center;color:#555;padding:24px;">Aucun utilisateur trouvé.</td></tr>
        <?php else: ?>
            <?php foreach ($users as $u): ?>
            <tr>
                <td style="color:#555;"><?= $u['id'] ?></td>
                <td style="color:#e0e0e0;font-weight:500;"><?= htmlspecialchars($u['first_name'] . ' ' . $u['last_name']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= htmlspecialchars($u['phone'] ?? '—') ?></td>
                <td>
                    <span class="badge <?= $u['role'] === 'employer' ? 'badge-employer' : 'badge-seeker' ?>">
                        <?php
                        if ($u['role'] === 'job_seeker') echo 'Candidat';
                        elseif ($u['role'] === 'employer') echo 'Employeur';
                        else echo htmlspecialchars($u['role']);
                        ?>
                    </span>
                </td>
                <td style="color:#555;"><?= htmlspecialchars(substr((string)$u['created_at'], 0, 10)) ?></td>
                <td>
                    <a href="/workwave/Controller/index.php?action=admin_edit_user&id=<?= $u['id'] ?>"
                       class="btn btn-warning btn-sm">Modifier</a>
                    <a href="/workwave/Controller/index.php?action=admin_delete_user&id=<?= $u['id'] ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Supprimer cet utilisateur définitivement ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<p style="margin-top:12px;color:#444;font-size:.78rem;">* Les comptes administrateurs sont exclus de cette liste.</p>

<?php include __DIR__ . '/../layout/dashboard_footer.php'; ?>
