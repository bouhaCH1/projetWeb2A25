<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>
<div class="dashboard-container">
<div class="container"><div class="row"><div class="col-md-3"><div class="glass-card">
        <div class="sidebar-header">
            <img src="view/assets/logo.png" class="animated-logo" alt="Logo">
            <h4>Work Wave</h4>
            <small>Espace Candidat</small>
        </div>
        <div class="sidebar-menu d-flex flex-column gap-3 mt-4">
            <a href="index.php?action=candidat-dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="index.php?action=candidat-submit" class="active"><i class="fas fa-plus-circle"></i> Soumettre un portfolio</a>
            <hr style="border-color: rgba(255,255,255,0.2);">
            <a href="index.php?action=logout" style="color: #e0e0e0;"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </div>
    </div>

    </div><div class="col-md-9">
        <div class="top-bar">
            <h4><i class="fas fa-<?= isset($portfolio) ? 'edit' : 'plus' ?>"></i> <?= isset($portfolio) ? 'Modifier mon portfolio' : 'Soumettre un nouveau portfolio' ?></h4>
            <a href="index.php?action=logout" class="btn btn-outline-secondary btn-sm" onclick="return confirm('Voulez-vous vraiment vous déconnecter ?')">Déconnexion</a>
        </div>

        <div class="form-container">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-secondary">
                    <?php foreach($errors as $e): ?>• <?= htmlspecialchars($e) ?><br><?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Titre du projet *</label>
                            <input type="text" name="title" value="<?= htmlspecialchars($portfolio['title'] ?? '') ?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description *</label>
                            <textarea name="description" rows="5" required><?= htmlspecialchars($portfolio['description'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Catégorie</label>
                            <select name="category">
                                <option value="Web Development" <?= (($portfolio['category'] ?? '') == 'Web Development') ? 'selected' : '' ?>>Web Development</option>
                                <option value="Mobile App" <?= (($portfolio['category'] ?? '') == 'Mobile App') ? 'selected' : '' ?>>Mobile App</option>
                                <option value="Design" <?= (($portfolio['category'] ?? '') == 'Design') ? 'selected' : '' ?>>Design</option>
                                <option value="AI/ML" <?= (($portfolio['category'] ?? '') == 'AI/ML') ? 'selected' : '' ?>>AI/ML</option>
                                <option value="Blockchain" <?= (($portfolio['category'] ?? '') == 'Blockchain') ? 'selected' : '' ?>>Blockchain</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Technologies</label>
                            <input type="text" name="technologies" value="<?= htmlspecialchars($portfolio['technologies'] ?? '') ?>" placeholder="PHP, MySQL, React...">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>URL du projet (optionnel)</label>
                            <input type="text" name="project_url" value="<?= htmlspecialchars($portfolio['project_url'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>URL de l'image (optionnel)</label>
                            <input type="text" name="image_url" value="<?= htmlspecialchars($portfolio['image_url'] ?? '') ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> <?= isset($portfolio) ? 'Mettre à jour' : 'Soumettre pour validation' ?>
                    </button>
                    <a href="index.php?action=candidat-dashboard" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
            <div class="alert alert-primary mt-3">
                <i class="fas fa-info-circle"></i> Votre portfolio sera examiné par un administrateur avant d'être visible publiquement.
            </div>
        </div>
    </div>

</div></div></div>
</div>
<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>
