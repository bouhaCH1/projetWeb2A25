<?php
$pageTitle = 'Vérification d\'Identité (OCR)';
$isAdmin = ($_SESSION['user_role'] ?? '') === 'admin';
if ($isAdmin) {
    include __DIR__ . '/../layout/dashboard_header.php';
} else {
    include __DIR__ . '/../layout/pl_dashboard_header.php';
}
?>

<div class="page-header" style="max-width: 800px; margin: 0 auto 30px;">
    <div>
        <h1 class="page-header-title" style="margin-bottom: 0;">
            <i class="fa fa-id-card" style="color:#00ffcc; margin-right:10px;"></i>
            Vérification d'Identité
        </h1>
        <div class="page-header-sub">Validez votre profil à l'aide de notre intelligence artificielle OCR</div>
    </div>
</div>

<?php if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger" style="max-width: 800px; margin: 0 auto 20px;">
        <?php foreach ($_SESSION['errors'] as $e): ?>
            <div><i class="fa fa-exclamation-circle" style="margin-right: 8px;"></i><?= htmlspecialchars($e) ?></div>
        <?php endforeach; unset($_SESSION['errors']); ?>
    </div>
<?php endif; ?>

<div class="dsh-card" style="max-width: 800px; margin: 0 auto; padding: 30px;">
    <div style="text-align: center; margin-bottom: 30px;">
        <i class="fa fa-robot fa-3x" style="color: #00ffcc; margin-bottom: 15px;"></i>
        <h3 style="color: #fff; margin-bottom: 10px;">Vérification Automatique (IA OCR)</h3>
        <p style="color: #a0a0a0; font-size: 0.9rem; line-height: 1.6;">
            Pour obtenir votre badge <span style="color:#00ffcc; font-weight:bold;"><i class="fa fa-check-circle"></i> Vérifié</span>, 
            veuillez uploader une photo nette de votre carte d'identité, passeport ou permis de conduire. 
            Notre système extraira le texte pour vérifier que le nom (<b><?= htmlspecialchars($_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name']) ?></b>) correspond.
        </p>
    </div>

    <form action="/workwave/Controller/index.php?action=verify_identity_submit" method="POST" enctype="multipart/form-data">
        <div style="background: rgba(0, 255, 204, 0.05); border: 1px dashed rgba(0, 255, 204, 0.3); border-radius: 10px; padding: 40px 20px; text-align: center; margin-bottom: 25px; transition: 0.3s;" onmouseover="this.style.background='rgba(0, 255, 204, 0.1)'" onmouseout="this.style.background='rgba(0, 255, 204, 0.05)'">
            <i class="fa fa-cloud-upload-alt fa-2x" style="color: #00ffcc; margin-bottom: 10px;"></i>
            <div style="margin-bottom: 15px; color: #fff; font-weight: bold;">Sélectionnez une image de votre pièce d'identité</div>
            <div style="color: #666; font-size: 0.8rem; margin-bottom: 20px;">Formats acceptés : JPG, PNG (Max. 5 Mo)</div>
            
            <input type="file" name="id_document" id="id_document" accept="image/jpeg, image/png" required style="display: block; margin: 0 auto; background: #222; padding: 10px; border-radius: 5px; border: 1px solid #333; color: #fff; width: 100%; max-width: 300px;">
        </div>

        <div style="display: flex; gap: 15px; justify-content: center;">
            <a href="/workwave/Controller/index.php?action=security" class="ww-btn-secondary" style="text-decoration: none; padding: 12px 25px; border-radius: 8px; background: #333; color: #fff; font-weight: bold; transition: 0.2s;">Annuler</a>
            <button type="submit" class="ww-btn-primary" style="padding: 12px 25px; border-radius: 8px; font-weight: bold; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px; background: #00ffcc; color: #000;">
                <i class="fa fa-magic"></i> Lancer la vérification
            </button>
        </div>
    </form>
    
    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); font-size: 0.8rem; color: #666; text-align: center;">
        <i class="fa fa-lock" style="margin-right: 5px;"></i> Les images sont traitées en toute sécurité via l'API OCR.space et ne sont pas conservées sur nos serveurs.
    </div>
</div>

<?php
if ($isAdmin) {
    include __DIR__ . '/../layout/dashboard_footer.php';
} else {
    include __DIR__ . '/../layout/pl_dashboard_footer.php';
}
?>
