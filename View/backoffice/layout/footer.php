
  </div><!-- /.container -->
</div><!-- /.app-content -->

<footer>
  <div class="container">
    <div class="footer-grid">
      <div class="about">
        <h4 style="font-size:20px;font-weight:800;margin-bottom:15px">FormationPHP</h4>
        <p>Plateforme de gestion des formations professionnelles. Manager vos formations, suivez vos taches et collaborez efficacement.</p>
      </div>
      <div class="helpful-links">
        <h4>Navigation</h4>
        <div style="display:flex;gap:30px;margin-top:10px">
          <ul>
            <?php if ($role === 'manager'): ?>
            <li><a href="index.php?role=manager&action=dashboard">Dashboard</a></li>
            <li><a href="index.php?role=manager&action=formations">Formations</a></li>
            <li><a href="index.php?role=manager&action=formation_add">Nouvelle formation</a></li>
            <?php else: ?>
            <li><a href="index.php?role=client&action=dashboard">Dashboard</a></li>
            <li><a href="index.php?role=client&action=formations">Formations</a></li>
            <li><a href="index.php?role=client&action=taches">Mes taches</a></li>
            <?php endif; ?>
          </ul>
          <ul>
            <li><a href="index.php?logout=1">Deconnexion</a></li>
          </ul>
        </div>
      </div>
      <div class="contact-us">
        <h4>Connecte en tant que</h4>
        <p><?= htmlspecialchars($_SESSION['user_nom'] ?? '') ?></p>
        <p><strong><?= $role === 'manager' ? 'Manager' : 'Client' ?></strong></p>
      </div>
    </div>
    <div class="sub-footer">
      <p>FormationPHP &copy; <?= date('Y') ?> &mdash; Systeme de gestion des formations &amp; taches</p>
    </div>
  </div>
</footer>

<script src="<?= $base ?>vues/public/vendor/jquery/jquery.min.js"></script>
<script src="<?= $base ?>vues/public/js/owl-carousel.js"></script>
<script src="<?= $base ?>vues/public/js/animation.js"></script>
<script src="<?= $base ?>vues/public/js/imagesloaded.js"></script>
<script src="<?= $base ?>vues/public/js/custom.js"></script>

<script>
function doTranslate(text, targetLang, resultId) {
  var el = document.getElementById(resultId);
  if (!el) return;
  el.textContent = '...';
  el.style.display = 'block';
  el.dir = 'ltr';
  $.post(
    'index.php?role=<?= $role ?>&action=translate',
    { text: text, target_lang: targetLang },
    function(data) {
      el.textContent = data.translated || data.error || 'Traduction indisponible';
      el.dir = (targetLang === 'ar') ? 'rtl' : 'ltr';
    },
    'json'
  ).fail(function(xhr) {
    el.textContent = 'Erreur: ' + (xhr.status ? xhr.status + ' ' + xhr.statusText : 'reseau');
    el.style.color = '#dc3545';
  });
}
</script>
</body>
</html>
