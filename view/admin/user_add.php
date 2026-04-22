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

<?php if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger"><ul>
        <?php foreach ($_SESSION['errors'] as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; unset($_SESSION['errors']); ?>
    </ul></div>
<?php endif; ?>


<div class="dsh-card" style="max-width:560px;">
    <form id="addForm" action="/workwave/Controller/index.php?action=admin_add_user_submit" method="POST" novalidate>

        <label>Prénom</label>
        <input type="text" id="first_name" name="first_name"
               value="<?= htmlspecialchars($_SESSION['old']['first_name'] ?? '') ?>">

        <label>Nom</label>
        <input type="text" id="last_name" name="last_name"
               value="<?= htmlspecialchars($_SESSION['old']['last_name'] ?? '') ?>">

        <label>E-mail</label>
        <input type="text" id="email" name="email"
               value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>">

        <label>Téléphone <small style="color:#555;font-weight:400;">(facultatif)</small></label>
        <input type="text" id="phone" name="phone"
               value="<?= htmlspecialchars($_SESSION['old']['phone'] ?? '') ?>">

        <label>Rôle</label>
        <select id="role" name="role">
            <?php $oldRole = $_SESSION['old']['role'] ?? ''; ?>
            <option value="job_seeker" <?= $oldRole === 'job_seeker' ? 'selected' : '' ?>>Candidat</option>
            <option value="employer"   <?= $oldRole === 'employer'   ? 'selected' : '' ?>>Employeur</option>
        </select>

        <label>Mot de passe <small style="color:#555;font-weight:400;">(min 8 car., 1 majuscule, 1 chiffre)</small></label>
        <input type="password" id="password" name="password">

        <label>Confirmer le mot de passe</label>
        <input type="password" id="confirm_password" name="confirm_password">

        <?php unset($_SESSION['old']); ?>

        <br><br>
        <button type="submit" class="btn btn-primary">Créer l'utilisateur</button>
        <a href="/workwave/Controller/index.php?action=admin_users" class="btn btn-secondary">Annuler</a>
    </form>
</div>



<?php include __DIR__ . '/../layout/dashboard_footer.php'; ?>
