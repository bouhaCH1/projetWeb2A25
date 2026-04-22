<?php
$pageTitle = 'Modifier l\'utilisateur';
include __DIR__ . '/../layout/dashboard_header.php';
?>

<div class="page-header">
    <div>
        <div class="page-header-title">Modifier l'utilisateur</div>
        <div class="page-header-sub">Mise à jour : <?= htmlspecialchars($data['first_name'] . ' ' . $data['last_name']) ?></div>
    </div>
    <a href="/workwave/Controller/index.php?action=admin_users" class="btn btn-secondary">← Retour aux utilisateurs</a>
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

        <label>Prénom</label>
        <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($data['first_name']) ?>">

        <label>Nom</label>
        <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($data['last_name']) ?>">

        <label>E-mail <small style="color:#555;font-weight:400;">(ne peut pas être modifié)</small></label>
        <input type="text" value="<?= htmlspecialchars($data['email']) ?>" disabled>

        <label>Téléphone <small style="color:#555;font-weight:400;">(facultatif)</small></label>
        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($data['phone'] ?? '') ?>">

        <label>Rôle</label>
        <select id="role" name="role">
            <option value="job_seeker" <?= $data['role'] === 'job_seeker' ? 'selected' : '' ?>>Candidat</option>
            <option value="employer"   <?= $data['role'] === 'employer'   ? 'selected' : '' ?>>Employeur</option>
        </select>

        <br><br>
        <button type="submit" class="btn btn-primary">Mettre à jour l'utilisateur</button>
        <a href="/workwave/Controller/index.php?action=admin_users" class="btn btn-secondary">Annuler</a>
    </form>
</div>



<?php include __DIR__ . '/../layout/dashboard_footer.php'; ?>
