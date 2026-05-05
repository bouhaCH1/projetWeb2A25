<?php include __DIR__ . '/../layout/pl_header.php'; ?>

<div class="ww-form-section">
  <div class="ww-form-card">
    <h1>Importer votre profil LinkedIn</h1>
    <p class="ww-subtitle">Connectez votre profil LinkedIn pour enrichir votre candidature</p>

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

    <form id="linkedinImportForm" action="/workwave/Controller/index.php?action=linkedin_import_submit" method="POST" novalidate>
      <label>URL de votre profil LinkedIn</label>
      <input type="url" id="linkedin_url" name="linkedin_url" placeholder="https://linkedin.com/in/votre-profil" required>
      
      <div class="ww-import-preview">
        <h4>Informations qui seront importées:</h4>
        <ul>
          <li>📋 Titre professionnel</li>
          <li>💼 Expérience professionnelle</li>
          <li>🎯 Compétences techniques</li>
          <li>📍 Localisation</li>
          <li>🎓 Formation</li>
        </ul>
      </div>

      <button type="submit" class="ww-btn-primary">Importer mon profil</button>
      <a href="/workwave/Controller/index.php?action=profile" class="ww-btn-secondary">Retour au profil</a>
    </form>
  </div>
</div>

<style>
.ww-import-preview {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    margin: 15px 0;
}

.ww-import-preview h4 {
    margin-bottom: 10px;
    color: #333;
}

.ww-import-preview ul {
    margin: 0;
    padding-left: 20px;
}

.ww-import-preview li {
    margin-bottom: 5px;
}
</style>

<?php include __DIR__ . '/../layout/pl_footer.php'; ?>
