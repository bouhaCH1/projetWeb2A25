<?php
// $pageTitle, $data, $errors, $project (edit only) are set by controller
require_once __DIR__ . '/../../View/layout/pl_dashboard_header.php';
$isEdit = isset($project);
$action_url = $isEdit
    ? '/workwave/Controller/index.php?action=portfolio_edit&id=' . (int)$project['id']
    : '/workwave/Controller/index.php?action=portfolio_add';
?>

<div class="ww-page">

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <div class="page-header-title">
            <i class="fa fa-<?= $isEdit ? 'edit' : 'plus-circle' ?>" style="color:#00ffcc;"></i>
            <?= $isEdit ? 'Modifier le projet' : 'Ajouter un projet' ?>
        </div>
        <div class="page-header-sub">Remplissez les informations de votre réalisation</div>
    </div>
    <a href="/workwave/Controller/index.php?action=portfolio" class="ww-btn-secondary" style="margin-top:0;">
        <i class="fa fa-arrow-left"></i> Retour
    </a>
</div>

<!-- ERRORS -->
<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
    <ul style="margin:0;padding-left:18px;">
        <?php foreach ($errors as $e): ?>
        <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<!-- FORM -->
<div style="max-width:700px;">
    <div class="dsh-card">
        <form method="POST" action="<?= $action_url ?>" enctype="multipart/form-data">

            <label>Titre du projet <span style="color:#ff6b6b;">*</span></label>
            <input type="text" name="title" value="<?= htmlspecialchars($data['title'] ?? '') ?>"
                   placeholder="Ex: Plateforme e-commerce React + Node.js" required>

            <label>Description <span style="color:#ff6b6b;">*</span></label>
            <textarea name="description" rows="5"
                      placeholder="Décrivez votre projet, les défis techniques, les fonctionnalités…"
                      style="width:100%;background:rgba(255,255,255,.04);border:1px solid rgba(0,255,204,.15);border-radius:6px;padding:10px 12px;color:#ddd;font-size:.88rem;outline:none;resize:vertical;"
                      required><?= htmlspecialchars($data['description'] ?? '') ?></textarea>

            <label>Technologies (séparées par des virgules)</label>
            <input type="text" name="technologies" value="<?= htmlspecialchars($data['technologies'] ?? '') ?>"
                   placeholder="Ex: React, Node.js, MySQL, Docker">

            <label>URL GitHub</label>
            <input type="text" name="github_url" value="<?= htmlspecialchars($data['github_url'] ?? '') ?>"
                   placeholder="https://github.com/votre-repo">

            <label>URL Démo / Live</label>
            <input type="text" name="demo_url" value="<?= htmlspecialchars($data['demo_url'] ?? '') ?>"
                   placeholder="https://votre-site.com">

            <label>Image du projet <?= $isEdit ? '(laisser vide pour conserver)' : '' ?></label>
            <input type="file" name="image" accept="image/*">
            <?php if ($isEdit && !empty($data['image_path'])): ?>
            <div style="margin-top:10px;">
                <img src="/workwave/<?= htmlspecialchars($data['image_path']) ?>"
                     alt="Aperçu" style="height:120px;border-radius:8px;object-fit:cover;border:1px solid rgba(0,255,204,.15);">
            </div>
            <?php endif; ?>

            <div style="display:flex;gap:12px;margin-top:22px;flex-wrap:wrap;">
                <button type="submit" class="ww-btn-primary" style="margin-top:0;">
                    <i class="fa fa-<?= $isEdit ? 'save' : 'plus' ?>"></i>
                    <?= $isEdit ? 'Enregistrer les modifications' : 'Publier le projet' ?>
                </button>
                <a href="/workwave/Controller/index.php?action=portfolio" class="ww-btn-secondary" style="margin-top:0;">
                    Annuler
                </a>
            </div>

        </form>
    </div>
</div>

</div><!-- /.ww-page -->

<?php require_once __DIR__ . '/../../View/layout/pl_dashboard_footer.php'; ?>
