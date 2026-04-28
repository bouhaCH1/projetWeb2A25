<?php
$pageTitle = 'Mon Profil';
$isAdmin = ($_SESSION['user_role'] ?? '') === 'admin';
if ($isAdmin) {
    include __DIR__ . '/../layout/dashboard_header.php';
} else {
    include __DIR__ . '/../layout/pl_dashboard_header.php';
}
?>

<div class="page-header">
    <div>
        <div class="page-header-title">Mon Profil</div>
        <div class="page-header-sub">Mettez à jour vos informations personnelles et votre photo de profil</div>
    </div>
</div>

<?php $fieldErrors = $_SESSION['field_errors'] ?? []; unset($_SESSION['field_errors']); ?>
<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>


<div class="dsh-card" style="max-width:560px;">
    <!-- Avatar preview -->
    <div style="display:flex;align-items:center;gap:18px;margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid #1c1c1c;">
        <div style="width:64px;height:64px;border-radius:50%;overflow:hidden;background:linear-gradient(135deg,#C4A15A,#7a5f30);display:flex;align-items:center;justify-content:center;font-size:1.6rem;font-weight:700;color:#000;flex-shrink:0;">
            <?php if (!empty($data['profile_pic'])): ?>
                <img src="/workwave/<?= htmlspecialchars($data['profile_pic']) ?>" alt="avatar" style="width:100%;height:100%;object-fit:cover;">
            <?php else: ?>
                <?= strtoupper(substr($data['first_name'], 0, 1)) ?>
            <?php endif; ?>
        </div>
        <div>
            <div style="font-size:1rem;font-weight:600;color:#e0e0e0;"><?= htmlspecialchars($data['first_name'] . ' ' . $data['last_name']) ?></div>
            <div style="font-size:.78rem;color:#666;margin-top:3px;"><?= htmlspecialchars($data['email']) ?></div>
            <span class="badge <?= $data['role'] === 'admin' ? 'badge-admin' : ($data['role'] === 'employer' ? 'badge-employer' : 'badge-seeker') ?>" style="margin-top:6px;">
                <?php
                if ($data['role'] === 'job_seeker') echo 'Candidat';
                elseif ($data['role'] === 'employer') echo 'Employeur';
                elseif ($data['role'] === 'admin') echo 'Administrateur';
                else echo htmlspecialchars($data['role']);
                ?>
            </span>
        </div>
    </div>

    <form id="profileForm" action="/workwave/Controller/index.php?action=profile_update"
          method="POST" enctype="multipart/form-data" novalidate>

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
        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($data['phone'] ?? '') ?>" class="<?= !empty($fieldErrors['phone']) ? 'input-error' : '' ?>">
        <?php if (!empty($fieldErrors['phone'])): ?>
            <div class="field-err"><?= htmlspecialchars($fieldErrors['phone']) ?></div>
        <?php endif; ?>

        <label>Photo de profil <small style="color:#555;font-weight:400;">(JPG, PNG, GIF — max 2 Mo)</small></label>
        <input type="file" name="profile_pic" accept="image/*">

        <hr style="border: 0; border-top: 1px solid #1c1c1c; margin: 24px 0;">

        <label>Nouveau mot de passe <small style="color:#555;font-weight:400;">(Laissez vide si inchangé)</small></label>
        <input type="password" id="new_password" name="new_password" class="<?= !empty($fieldErrors['new_password']) ? 'input-error' : '' ?>">
        <?php if (!empty($fieldErrors['new_password'])): ?>
            <div class="field-err"><?= htmlspecialchars($fieldErrors['new_password']) ?></div>
        <?php endif; ?>

        <label>Confirmer le nouveau mot de passe</label>
        <input type="password" id="confirm_password" name="confirm_password" class="<?= !empty($fieldErrors['confirm_password']) ? 'input-error' : '' ?>">
        <?php if (!empty($fieldErrors['confirm_password'])): ?>
            <div class="field-err"><?= htmlspecialchars($fieldErrors['confirm_password']) ?></div>
        <?php endif; ?>

        <br><br>
        <button type="submit" class="btn btn-primary">Sauvegarder les modifications</button>
    </form>
</div>



<?php
if ($isAdmin) {
    include __DIR__ . '/../layout/dashboard_footer.php';
} else {
    include __DIR__ . '/../layout/pl_dashboard_footer.php';
}
?>
