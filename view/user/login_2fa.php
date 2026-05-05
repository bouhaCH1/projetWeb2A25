<?php include __DIR__ . '/../layout/pl_header.php'; ?>

<div class="ww-form-section">
  <div class="ww-form-card">
    <h1>Double Authentification</h1>
    <p class="ww-subtitle">Un code de sécurité a été envoyé à votre adresse. Vous pouvez utiliser le code généré OU <strong>123456</strong> comme code de secours.</p>

    <?php if (!empty($_SESSION['errors'])): ?>
      <div class="ww-alert ww-alert-danger">
        <?= htmlspecialchars($_SESSION['errors'][0]); unset($_SESSION['errors']); ?>
      </div>
    <?php endif; ?>
    
    
    <form action="/workwave/Controller/index.php?action=login_2fa_submit" method="POST">
      <label>Code à 6 chiffres</label>
      <input type="text" name="code" placeholder="123456" required style="font-size: 1.5rem; letter-spacing: 10px; text-align: center; font-weight: bold;">
      
      <button type="submit" class="ww-btn-primary" style="margin-top: 20px;">Vérifier et se connecter</button>
      <div style="text-align: center; margin-top: 15px;">
        <a href="/workwave/Controller/index.php?action=login" style="font-size:.85rem; color:#777; text-decoration:none;">Annuler la connexion</a>
      </div>
    </form>
  </div>
</div>

<?php include __DIR__ . '/../layout/pl_footer.php'; ?>
