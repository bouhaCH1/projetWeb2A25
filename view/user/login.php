<?php include __DIR__ . '/../layout/pl_header.php'; ?>

<div class="ww-form-section">
  <div class="ww-form-card">
    <h1>Bon retour</h1>
    <p class="ww-subtitle">Connectez-vous à votre compte WorkWave</p>

    <?php $fieldErrors = $_SESSION['field_errors'] ?? []; unset($_SESSION['field_errors']); ?>

    <?php if (!empty($_SESSION['errors'])): ?>
      <div class="ww-alert ww-alert-danger">
        <?= htmlspecialchars($_SESSION['errors'][0]); unset($_SESSION['errors']); ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
      <div class="ww-alert ww-alert-success">
        <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
      </div>
    <?php endif; ?>

    <form id="loginForm" action="/workwave/Controller/index.php?action=login_submit" method="POST" novalidate>
      <label>Adresse E-mail</label>
      <input type="text" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" class="<?= !empty($fieldErrors['email']) ? 'ww-input-error' : '' ?>">
      <?php if (!empty($fieldErrors['email'])): ?>
        <div class="ww-field-err"><?= htmlspecialchars($fieldErrors['email']) ?></div>
      <?php endif; ?>

      <label>Mot de passe</label>
      <input type="password" id="password" name="password" class="<?= !empty($fieldErrors['password']) ? 'ww-input-error' : '' ?>">
      <?php if (!empty($fieldErrors['password'])): ?>
        <div class="ww-field-err"><?= htmlspecialchars($fieldErrors['password']) ?></div>
      <?php endif; ?>

      <button type="submit" class="ww-btn-primary">Se connecter</button>
      <a href="/workwave/Controller/index.php?action=register" class="ww-btn-secondary">Pas de compte ? S'inscrire</a>
    </form>
  </div>
</div>

<?php include __DIR__ . '/../layout/pl_footer.php'; ?>
