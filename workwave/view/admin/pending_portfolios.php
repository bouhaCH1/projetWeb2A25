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
            <h4><i class="fas fa-clock"></i> Portfolios en attente de validation</h4>
            <a href="index.php?action=admin-dashboard" class="btn btn-outline-secondary btn-sm">← Retour</a>
        </div>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] == 'success' ? 'success' : 'danger' ?>">
                <?= htmlspecialchars($_SESSION['message']) ?>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>

        <?php if (empty($portfolios)): ?>
            <div class="alert alert-primary">
                <i class="fas fa-check-circle"></i> Aucun portfolio en attente de validation.
            </div>
        <?php else: ?>
            <?php foreach ($portfolios as $p): ?>
                <div class="portfolio-card">
                    <div class="row">
                        <div class="col-md-8">
                            <h5><?= htmlspecialchars($p['title']) ?></h5>
                            <p class="text-muted mb-1">
                                <i class="fas fa-user"></i> <?= htmlspecialchars($p['submitted_by']) ?> |
                                <i class="fas fa-building"></i> <?= htmlspecialchars($p['company_name'] ?? 'Indépendant') ?> |
                                <i class="fas fa-envelope"></i> <?= htmlspecialchars($p['email'] ?? 'Non renseigné') ?>
                            </p>
                            <p class="small"><?= htmlspecialchars(substr($p['description'], 0, 150)) ?>...</p>
                            <div>
                                <span class="badge bg-primary"><?= htmlspecialchars($p['category']) ?></span>
                                <span class="badge bg-secondary"><?= htmlspecialchars($p['technologies']) ?></span>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="index.php?action=admin-view-pending&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary">Détails</a>
                            <a href="index.php?action=admin-approve&id=<?= $p['id'] ?>" class="btn btn-sm btn-primary" onclick="return confirm('Valider ce portfolio ?')">✓ Valider</a>
                            <a href="index.php?action=admin-reject&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-secondary" onclick="return confirm('Refuser ce portfolio ?')">✗ Refuser</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div></div></div>
</div>
<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>
