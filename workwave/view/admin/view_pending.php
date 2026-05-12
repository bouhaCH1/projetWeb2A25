<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>
<div class="dashboard-container">
<div class="container"><div class="row"><div class="col-md-3"><div class="glass-card">
        <div class="sidebar-header">
            <img src="view/assets/logo.png" class="animated-logo" alt="Logo">
            <h4>Work Wave</h4>
            <small>Administration</small>
        </div>
        <div class="sidebar-menu d-flex flex-column gap-3 mt-4">
            <a href="index.php?action=admin-dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="index.php?action=admin-pending-portfolios" class="active"><i class="fas fa-clock"></i> Portfolios en attente</a>
            <a href="index.php?action=admin-approved-portfolios"><i class="fas fa-check-circle"></i> Portfolios validés</a>
            <a href="index.php?action=admin-pending-jobs"><i class="fas fa-briefcase"></i> Offres d'emploi</a>
            <a href="index.php?action=admin-clients"><i class="fas fa-users"></i> Clients</a>
            <a href="index.php?action=admin-entreprises"><i class="fas fa-building"></i> Entreprises</a>
            <hr style="border-color: rgba(255,255,255,0.2);">
            <a href="index.php?action=logout" style="color: #e0e0e0;"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </div>
    </div>

    </div><div class="col-md-9">
        <div class="top-bar">
            <h4><i class="fas fa-eye"></i> Détail du portfolio</h4>
            <a href="index.php?action=admin-pending-portfolios" class="btn btn-outline-secondary btn-sm">← Retour</a>
        </div>

        <div class="detail-card">
            <h2><?= htmlspecialchars($portfolio['title']) ?></h2>
            <p class="text-muted">
                <i class="fas fa-user"></i> <?= htmlspecialchars($portfolio['submitted_by']) ?> |
                <i class="fas fa-calendar"></i> Soumis le <?= date('d/m/Y H:i', strtotime($portfolio['created_at'])) ?>
            </p>
            <hr>
            <h5>Description</h5>
            <p><?= nl2br(htmlspecialchars($portfolio['description'])) ?></p>
            <h5>Catégorie</h5>
            <p><?= htmlspecialchars($portfolio['category']) ?></p>
            <h5>Technologies</h5>
            <p><?= htmlspecialchars($portfolio['technologies']) ?></p>
            <?php if ($portfolio['project_url']): ?>
                <h5>Lien du projet</h5>
                <a href="<?= htmlspecialchars($portfolio['project_url']) ?>" target="_blank"><?= htmlspecialchars($portfolio['project_url']) ?></a>
            <?php endif; ?>
            <hr>
            <div class="text-center mt-4">
                <a href="index.php?action=admin-approve&id=<?= $portfolio['id'] ?>" class="btn btn-primary btn-lg" onclick="return confirm('Valider ce portfolio ?')">✓ Valider ce portfolio</a>
                <a href="index.php?action=admin-reject&id=<?= $portfolio['id'] ?>" class="btn btn-outline-secondary btn-lg" onclick="return confirm('Refuser ce portfolio ?')">✗ Refuser</a>
            </div>
        </div>
    </div>
 
</div></div></div>
</div>
<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>
