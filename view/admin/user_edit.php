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

<?php $fieldErrors = $_SESSION['field_errors'] ?? []; unset($_SESSION['field_errors']); ?>



<div class="dsh-card" style="max-width:560px;">
    <form id="editForm" action="/workwave/Controller/index.php?action=admin_update_user" method="POST" novalidate>
        <input type="hidden" name="id" value="<?= (int)$data['id'] ?>">

        <label>Prénom</label>
        <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($data['first_name']) ?>" class="<?= !empty($fieldErrors['first_name']) ? 'input-error' : '' ?>">
        <?php if (!empty($fieldErrors['first_name'])): ?>
            <div class="field-err"><?= htmlspecialchars($fieldErrors['first_name']) ?></div>
        <?php endif; ?>

        <label>Nom</label>
        <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($data['last_name']) ?>" class="<?= !empty($fieldErrors['last_name']) ? 'input-error' : '' ?>">
        <?php if (!empty($fieldErrors['last_name'])): ?>
            <div class="field-err"><?= htmlspecialchars($fieldErrors['last_name']) ?></div>
        <?php endif; ?>

        <label>E-mail <small style="color:#555;font-weight:400;">(ne peut pas être modifié)</small></label>
        <input type="text" value="<?= htmlspecialchars($data['email']) ?>" disabled>

        <label>Téléphone <small style="color:#555;font-weight:400;">(facultatif)</small></label>
        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($data['phone'] ?? '') ?>">

        <label>Rôle</label>
        <select id="role" name="role" class="<?= !empty($fieldErrors['role']) ? 'input-error' : '' ?>">
            <option value="job_seeker" <?= $data['role'] === 'job_seeker' ? 'selected' : '' ?>>Candidat</option>
            <option value="employer"   <?= $data['role'] === 'employer'   ? 'selected' : '' ?>>Employeur</option>
        </select>
        <?php if (!empty($fieldErrors['role'])): ?>
            <div class="field-err"><?= htmlspecialchars($fieldErrors['role']) ?></div>
        <?php endif; ?>

        <br><br>
        <button type="submit" class="btn btn-primary">Mettre à jour l'utilisateur</button>
        <a href="/workwave/Controller/index.php?action=admin_users" class="btn btn-secondary">Annuler</a>
    </form>
</div>



<?php include __DIR__ . '/../layout/dashboard_footer.php'; ?>
