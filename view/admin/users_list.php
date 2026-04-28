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

<div class="dsh-card" style="margin-bottom: 20px; padding: 15px 24px;">
    <form method="GET" action="/workwave/Controller/index.php" style="display:flex; gap:15px; align-items:flex-end; flex-wrap:wrap;">
        <input type="hidden" name="action" value="admin_users">
        
        <div style="flex:1; min-width:200px;">
            <label style="margin-top:0; font-size:.7rem; color:#888;">Rechercher</label>
            <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Nom, e-mail..." style="margin-top:4px;">
        </div>
        
        <div style="width:200px;">
            <label style="margin-top:0; font-size:.7rem; color:#888;">Trier par</label>
            <select name="sort" style="margin-top:4px;">
                <?php $currentSort = $_GET['sort'] ?? 'created_at_desc'; ?>
                <option value="created_at_desc" <?= $currentSort === 'created_at_desc' ? 'selected' : '' ?>>Plus récents</option>
                <option value="created_at_asc" <?= $currentSort === 'created_at_asc' ? 'selected' : '' ?>>Plus anciens</option>
                <option value="name_asc" <?= $currentSort === 'name_asc' ? 'selected' : '' ?>>Nom (A-Z)</option>
                <option value="name_desc" <?= $currentSort === 'name_desc' ? 'selected' : '' ?>>Nom (Z-A)</option>
                <option value="role_asc" <?= $currentSort === 'role_asc' ? 'selected' : '' ?>>Rôle (A-Z)</option>
                <option value="role_desc" <?= $currentSort === 'role_desc' ? 'selected' : '' ?>>Rôle (Z-A)</option>
            </select>
        </div>
        
        <div>
            <button type="submit" class="btn btn-primary" style="padding:10px 18px; margin-bottom: 2px;">Filtrer</button>
            <?php if(!empty($_GET['search']) || !empty($_GET['sort'])): ?>
                <a href="/workwave/Controller/index.php?action=admin_users" class="btn btn-secondary" style="padding:10px 18px; margin-bottom: 2px;">Réinitialiser</a>
            <?php endif; ?>
        </div>
    </form>
</div>

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
