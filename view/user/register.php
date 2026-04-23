<?php include __DIR__ . '/../layout/pl_header.php'; ?>

<div class="ww-form-section">
  <div class="ww-form-card" style="max-width:540px;">
    <h1>Créer un compte</h1>
    <p class="ww-subtitle">Rejoignez WorkWave en tant que Candidat ou Employeur</p>

    <?php $fieldErrors = $_SESSION['field_errors'] ?? []; ?>

    <?php if (!empty($_SESSION['errors'])): ?>
      <div class="ww-alert ww-alert-danger"><ul>
        <?php foreach ($_SESSION['errors'] as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; unset($_SESSION['errors']); ?>
      </ul></div>
    <?php endif; ?>

    <form id="registerForm" action="/workwave/Controller/index.php?action=register_submit" method="POST" novalidate>

      <label>Prénom *</label>
      <?php if (!empty($fieldErrors['first_name'])): ?>
        <div class="ww-field-err"><?= htmlspecialchars($fieldErrors['first_name']) ?></div>
      <?php endif; ?>
      <input type="text" name="first_name" value="<?= htmlspecialchars($_SESSION['old']['first_name'] ?? '') ?>">

      <label>Nom *</label>
      <?php if (!empty($fieldErrors['last_name'])): ?>
        <div class="ww-field-err"><?= htmlspecialchars($fieldErrors['last_name']) ?></div>
      <?php endif; ?>
      <input type="text" name="last_name" value="<?= htmlspecialchars($_SESSION['old']['last_name'] ?? '') ?>">

      <label>Adresse E-mail *</label>
      <?php if (!empty($fieldErrors['email'])): ?>
        <div class="ww-field-err"><?= htmlspecialchars($fieldErrors['email']) ?></div>
      <?php endif; ?>
      <input type="text" id="email" name="email" value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>">

      <label>Numéro de téléphone</label>
      <?php if (!empty($fieldErrors['phone'])): ?>
        <div class="ww-field-err"><?= htmlspecialchars($fieldErrors['phone']) ?></div>
      <?php endif; ?>
      <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($_SESSION['old']['phone'] ?? '') ?>">

      <label>Je suis un(e) *</label>
      <?php if (!empty($fieldErrors['role'])): ?>
        <div class="ww-field-err"><?= htmlspecialchars($fieldErrors['role']) ?></div>
      <?php endif; ?>
      <select id="role" name="role">
        <option value="">-- Sélectionner --</option>
        <option value="job_seeker" <?= (($_SESSION['old']['role'] ?? '') === 'job_seeker') ? 'selected' : '' ?>>Chercheur d'emploi / Candidat</option>
        <option value="employer"   <?= (($_SESSION['old']['role'] ?? '') === 'employer')   ? 'selected' : '' ?>>Employeur / Entreprise</option>
      </select>

      <label>Mot de passe * <small style="color:#aaa;font-weight:400;">(Min. 8 car., 1 majuscule, 1 chiffre)</small></label>
      <?php if (!empty($fieldErrors['password'])): ?>
        <div class="ww-field-err"><?= htmlspecialchars($fieldErrors['password']) ?></div>
      <?php endif; ?>
      <input type="password" id="password" name="password">

      <label>Confirmer le mot de passe *</label>
      <?php if (!empty($fieldErrors['confirm_password'])): ?>
        <div class="ww-field-err"><?= htmlspecialchars($fieldErrors['confirm_password']) ?></div>
      <?php endif; ?>
      <input type="password" id="confirm_password" name="confirm_password">

      <button type="submit" class="ww-btn-primary">Créer le compte</button>
      <a href="/workwave/Controller/index.php?action=login" class="ww-btn-secondary">Déjà un compte ? Se connecter</a>

    </form>
    <?php unset($_SESSION['old'], $_SESSION['field_errors']); ?>
  </div>
</div>

<?php include __DIR__ . '/../layout/pl_footer.php'; ?>
