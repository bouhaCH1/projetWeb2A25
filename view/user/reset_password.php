<?php include __DIR__ . '/../layout/pl_header.php'; ?>

<div class="ww-form-section">
  <div class="ww-form-card">
    <h1>Réinitialiser le mot de passe</h1>
    <p class="ww-subtitle">Choisissez votre nouveau mot de passe</p>

    <?php if (!empty($_SESSION['errors'])): ?>
      <div class="ww-alert ww-alert-danger">
        <?php foreach ($_SESSION['errors'] as $error): ?>
          <?= htmlspecialchars($error) ?><br>
        <?php endforeach; ?>
        <?php unset($_SESSION['errors']); ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
      <div class="ww-alert ww-alert-success">
        <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
      </div>
    <?php endif; ?>

    <form id="resetPasswordForm" action="/workwave/Controller/index.php?action=reset_password_submit" method="POST" novalidate>
      <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? $_SESSION['old_token'] ?? '') ?>">
      
      <label>Nouveau mot de passe</label>
      <input type="password" id="password" name="password" required>
      
      <label>Confirmer le mot de passe</label>
      <input type="password" id="confirm_password" name="confirm_password" required>

      <button type="submit" class="ww-btn-primary" style="margin-top: 15px;">Réinitialiser le mot de passe</button>
      <a href="/workwave/Controller/index.php?action=login" class="ww-btn-secondary">Retour à la connexion</a>
    </form>
  </div>
</div>

<?php include __DIR__ . '/../layout/pl_footer.php'; ?>
