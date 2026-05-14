<?php
$action = $_GET['action'] ?? 'home';
$isAdminTemplate = str_starts_with($action, 'admin-');
$templateGeneral = '../view/frontoffice/template_generale_root';
$templateAdmin = '../view/backoffice/template_admin_root/darkpan-1.0.0';
?>
<?php if ($isAdminTemplate): ?>
        </main>
    </div>
</div>
<script>
document.querySelectorAll('.sidebar-toggler').forEach(function (button) {
    button.addEventListener('click', function (event) {
        event.preventDefault();
        document.querySelector('.sidebar')?.classList.toggle('open');
        document.querySelector('.content')?.classList.toggle('open');
    });
});
</script>
</body>
</html>
<?php else: ?>
</main>
<footer class="contact-section">
    <div class="ww-section">
        <div class="contact-info">
            <h3>WorkWave</h3>
            <p>Plateforme de mise en relation entre talents, candidats et entreprises.</p>
        </div>
    </div>
</footer>
<script src="<?= $templateGeneral ?>/templatemo-graph-script.js"></script>
</body>
</html>
<?php endif; ?>
