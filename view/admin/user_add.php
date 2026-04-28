<?php
$pageTitle = 'Ajouter un utilisateur';
include __DIR__ . '/../layout/dashboard_header.php';
?>

<div class="page-header">
    <div>
        <div class="page-header-title">Ajouter un utilisateur</div>
        <div class="page-header-sub">Créer manuellement un compte candidat ou employeur</div>
    </div>
    <a href="/workwave/Controller/index.php?action=admin_users" class="btn btn-secondary">← Retour aux utilisateurs</a>
</div>

<?php $fieldErrors = $_SESSION['field_errors'] ?? []; unset($_SESSION['field_errors']); ?>



<div class="dsh-card" style="max-width:560px;">
    <form id="addForm" action="/workwave/Controller/index.php?action=admin_add_user_submit" method="POST" novalidate>

        <label>Prénom</label>
        <input type="text" id="first_name" name="first_name"
               value="<?= htmlspecialchars($_SESSION['old']['first_name'] ?? '') ?>" class="<?= !empty($fieldErrors['first_name']) ? 'input-error' : '' ?>">
        <?php if (!empty($fieldErrors['first_name'])): ?>
            <div class="field-err"><?= htmlspecialchars($fieldErrors['first_name']) ?></div>
        <?php endif; ?>

        <label>Nom</label>
        <input type="text" id="last_name" name="last_name"
               value="<?= htmlspecialchars($_SESSION['old']['last_name'] ?? '') ?>" class="<?= !empty($fieldErrors['last_name']) ? 'input-error' : '' ?>">
        <?php if (!empty($fieldErrors['last_name'])): ?>
            <div class="field-err"><?= htmlspecialchars($fieldErrors['last_name']) ?></div>
        <?php endif; ?>

        <label>E-mail</label>
        <input type="text" id="email" name="email"
               value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>" class="<?= !empty($fieldErrors['email']) ? 'input-error' : '' ?>">
        <?php if (!empty($fieldErrors['email'])): ?>
            <div class="field-err"><?= htmlspecialchars($fieldErrors['email']) ?></div>
        <?php endif; ?>

        <label>Téléphone <small style="color:#555;font-weight:400;">(facultatif)</small></label>
        <input type="text" id="phone" name="phone"
               value="<?= htmlspecialchars($_SESSION['old']['phone'] ?? '') ?>" class="<?= !empty($fieldErrors['phone']) ? 'input-error' : '' ?>">
        <?php if (!empty($fieldErrors['phone'])): ?>
            <div class="field-err"><?= htmlspecialchars($fieldErrors['phone']) ?></div>
        <?php endif; ?>

        <label>Rôle</label>
        <select id="role" name="role" class="<?= !empty($fieldErrors['role']) ? 'input-error' : '' ?>">
            <?php $oldRole = $_SESSION['old']['role'] ?? ''; ?>
            <option value="job_seeker" <?= $oldRole === 'job_seeker' ? 'selected' : '' ?>>Candidat</option>
            <option value="employer"   <?= $oldRole === 'employer'   ? 'selected' : '' ?>>Employeur</option>
        </select>
        <?php if (!empty($fieldErrors['role'])): ?>
            <div class="field-err"><?= htmlspecialchars($fieldErrors['role']) ?></div>
        <?php endif; ?>

        <label>Mot de passe <small style="color:#555;font-weight:400;">(min 8 car., 1 majuscule, 1 chiffre)</small></label>
        <input type="password" id="password" name="password" class="<?= !empty($fieldErrors['password']) ? 'input-error' : '' ?>">
        <?php if (!empty($fieldErrors['password'])): ?>
            <div class="field-err"><?= htmlspecialchars($fieldErrors['password']) ?></div>
        <?php endif; ?>

        <label>Confirmer le mot de passe</label>
        <input type="password" id="confirm_password" name="confirm_password" class="<?= !empty($fieldErrors['confirm_password']) ? 'input-error' : '' ?>">
        <?php if (!empty($fieldErrors['confirm_password'])): ?>
            <div class="field-err"><?= htmlspecialchars($fieldErrors['confirm_password']) ?></div>
        <?php endif; ?>

        <?php unset($_SESSION['old']); ?>

        <br><br>
        <button type="submit" class="btn btn-primary">Créer l'utilisateur</button>
        <a href="/workwave/Controller/index.php?action=admin_users" class="btn btn-secondary">Annuler</a>
    </form>
</div>



<?php include __DIR__ . '/../layout/dashboard_footer.php'; ?>
