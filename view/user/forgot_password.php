<?php include __DIR__ . '/../layout/pl_header.php'; ?>

<div class="ww-form-section">
  <div class="ww-form-card">
    <h1>Mot de passe oublié ?</h1>
    <p class="ww-subtitle">Entrez votre adresse e-mail pour recevoir un lien de réinitialisation.</p>

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

    <form id="forgotPasswordForm" action="/workwave/Controller/index.php?action=forgot_password_submit" method="POST" novalidate>
      <label>Adresse E-mail</label>
      <input type="text" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" class="<?= !empty($fieldErrors['email']) ? 'ww-input-error' : '' ?>">
      <?php if (!empty($fieldErrors['email'])): ?>
        <div class="ww-field-err"><?= htmlspecialchars($fieldErrors['email']) ?></div>
      <?php endif; ?>

      <button type="submit" class="ww-btn-primary" style="margin-top: 15px;">Envoyer le lien de réinitialisation</button>
      <a href="/workwave/Controller/index.php?action=login" class="ww-btn-secondary">Retour à la connexion</a>
    </form>
  </div>
</div>

<?php include __DIR__ . '/../layout/pl_footer.php'; ?>
