<?php
$pageTitle = 'Ajouter un utilisateur';
include __DIR__ . '/../layout/dashboard_header.php';
?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h6 class="mb-0">Ajouter un utilisateur</h6>
        <small class="text-muted">Créer manuellement un compte candidat ou employeur</small>
    </div>
    <a href="/workwave/Controller/index.php?action=admin_users" class="btn btn-secondary"><i class="fa fa-arrow-left me-2"></i>Retour</a>
</div>

<?php $fieldErrors = $_SESSION['field_errors'] ?? []; unset($_SESSION['field_errors']); ?>

<div class="bg-secondary rounded p-4" style="max-width: 800px;">
    <form id="addForm" action="/workwave/Controller/index.php?action=admin_add_user_submit" method="POST" novalidate>
        
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label text-muted">Prénom</label>
                <input type="text" name="first_name" value="<?= htmlspecialchars($_SESSION['old']['first_name'] ?? '') ?>" 
                       class="form-control bg-dark border-0 text-white <?= !empty($fieldErrors['first_name']) ? 'is-invalid' : '' ?>">
                <?php if (!empty($fieldErrors['first_name'])): ?>
                    <div class="invalid-feedback d-block text-danger"><?= htmlspecialchars($fieldErrors['first_name']) ?></div>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <label class="form-label text-muted">Nom</label>
                <input type="text" name="last_name" value="<?= htmlspecialchars($_SESSION['old']['last_name'] ?? '') ?>" 
                       class="form-control bg-dark border-0 text-white <?= !empty($fieldErrors['last_name']) ? 'is-invalid' : '' ?>">
                <?php if (!empty($fieldErrors['last_name'])): ?>
                    <div class="invalid-feedback d-block text-danger"><?= htmlspecialchars($fieldErrors['last_name']) ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label text-muted">E-mail</label>
                <input type="email" name="email" value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>" 
                       class="form-control bg-dark border-0 text-white <?= !empty($fieldErrors['email']) ? 'is-invalid' : '' ?>">
                <?php if (!empty($fieldErrors['email'])): ?>
                    <div class="invalid-feedback d-block text-danger"><?= htmlspecialchars($fieldErrors['email']) ?></div>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <label class="form-label text-muted">Téléphone <small>(facultatif)</small></label>
                <input type="text" name="phone" value="<?= htmlspecialchars($_SESSION['old']['phone'] ?? '') ?>" 
                       class="form-control bg-dark border-0 text-white <?= !empty($fieldErrors['phone']) ? 'is-invalid' : '' ?>">
                <?php if (!empty($fieldErrors['phone'])): ?>
                    <div class="invalid-feedback d-block text-danger"><?= htmlspecialchars($fieldErrors['phone']) ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label text-muted">Rôle</label>
            <select name="role" class="form-select bg-dark border-0 text-white <?= !empty($fieldErrors['role']) ? 'is-invalid' : '' ?>">
                <?php $oldRole = $_SESSION['old']['role'] ?? ''; ?>
                <option value="job_seeker" <?= $oldRole === 'job_seeker' ? 'selected' : '' ?>>Candidat</option>
                <option value="employer"   <?= $oldRole === 'employer'   ? 'selected' : '' ?>>Employeur</option>
            </select>
            <?php if (!empty($fieldErrors['role'])): ?>
                <div class="invalid-feedback d-block text-danger"><?= htmlspecialchars($fieldErrors['role']) ?></div>
            <?php endif; ?>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label text-muted">Mot de passe <small>(min 8 car., 1 majuscule, 1 chiffre)</small></label>
                <input type="password" name="password" class="form-control bg-dark border-0 text-white <?= !empty($fieldErrors['password']) ? 'is-invalid' : '' ?>">
                <?php if (!empty($fieldErrors['password'])): ?>
                    <div class="invalid-feedback d-block text-danger"><?= htmlspecialchars($fieldErrors['password']) ?></div>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <label class="form-label text-muted">Confirmer le mot de passe</label>
                <input type="password" name="confirm_password" class="form-control bg-dark border-0 text-white <?= !empty($fieldErrors['confirm_password']) ? 'is-invalid' : '' ?>">
                <?php if (!empty($fieldErrors['confirm_password'])): ?>
                    <div class="invalid-feedback d-block text-danger"><?= htmlspecialchars($fieldErrors['confirm_password']) ?></div>
                <?php endif; ?>
            </div>
        </div>

        <?php unset($_SESSION['old']); ?>

        <div class="mt-4 pt-3 border-top border-dark">
            <button type="submit" class="btn btn-primary py-2 px-4"><i class="fa fa-user-plus me-2"></i>Créer l'utilisateur</button>
            <a href="/workwave/Controller/index.php?action=admin_users" class="btn btn-outline-light ms-2 py-2 px-4">Annuler</a>
        </div>
    </form>
</div>



<?php include __DIR__ . '/../layout/dashboard_footer.php'; ?>
