<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>
<div class="dashboard-container">
<div class="container"><div class="row"><div class="col-md-3"><div class="glass-card">
        <div class="sidebar-header">
            <i class="fas fa-user-shield" style="font-size: 2rem;"></i>
            <h4>Work Wave</h4>
            <small>Administration</small>
        </div>
        <div class="sidebar-menu d-flex flex-column gap-3 mt-4">
            <a href="index.php?action=home"><i class="fas fa-home"></i> Accueil Public</a>
            <a href="index.php?action=admin-dashboard" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="index.php?action=admin-pending-portfolios"><i class="fas fa-folder-open"></i> Portfolios</a>
            <a href="index.php?action=admin-pending-jobs"><i class="fas fa-briefcase"></i> Offres d'emploi</a>
            <a href="index.php?action=admin-candidats"><i class="fas fa-users"></i> Candidats</a>
            <a href="index.php?action=admin-entreprises"><i class="fas fa-building"></i> Entreprises</a>
            <hr style="border-color: rgba(212, 175, 55, 0.2);">
            <a href="index.php?action=logout" style="color: #e0e0e0;"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </div>
    </div>

    </div><div class="col-md-9">
        <div class="top-bar">
            <div><h4 class="m-0" style="color: var(--primary);"><i class="fas fa-user-shield"></i> Bonjour, <?= htmlspecialchars($_SESSION['user']['username']) ?></h4></div>
            <a href="index.php?action=logout" class="btn btn-outline-secondary btn-sm rounded-pill" onclick="return confirm('Voulez-vous vraiment vous déconnecter ?')"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </div>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] == 'success' ? 'success' : 'danger' ?>">
                <?= htmlspecialchars($_SESSION['message']) ?>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-3"><div class="stat-card"><i class="fas fa-folder-open" style="font-size: 2rem; color: var(--primary);"></i><h3 style="color:white;"><?= $stats['total_approved'] ?? 0 ?></h3><p class="m-0">Portfolios validés</p></div></div>
            <div class="col-md-3"><div class="stat-card"><i class="fas fa-briefcase" style="font-size: 2rem; color: #e0e0e0;"></i><h3 style="color:white;"><?= count($pendingJobs ?? []) ?></h3><p class="m-0">Offres en attente</p></div></div>
            <div class="col-md-3"><div class="stat-card"><i class="fas fa-users" style="font-size: 2rem; color: #e0e0e0;"></i><h3 style="color:white;"><?= $stats['total_candidats'] ?? 0 ?></h3><p class="m-0">Candidats inscrits</p></div></div>
            <div class="col-md-3"><div class="stat-card"><i class="fas fa-building" style="font-size: 2rem; color: #e0e0e0;"></i><h3 style="color:white;"><?= $stats['total_entreprises'] ?? 0 ?></h3><p class="m-0">Entreprises</p></div></div>
        </div>

        <div class="row mt-3">
            <div class="col-md-7">
                <!-- Section Offres d'emploi en attente -->
                <div class="card card-custom mb-4">
                    <div class="card-header">
                        <strong><i class="fas fa-briefcase"></i> Offres d'emploi en attente</strong>
                    </div>
                    <div class="card-body">
                        <?php if (empty($pendingJobs)): ?>
                            <div class="text-center py-3"><p class="text-muted">Aucune offre d'emploi en attente.</p></div>
                        <?php else: ?>
                            <?php foreach ($pendingJobs as $job): ?>
                                <div class="item-row">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong style="color:white;"><?= htmlspecialchars($job['title']) ?></strong>
                                            <br><small class="text-muted">Entreprise: <?= htmlspecialchars($job['company_name']) ?></small>
                                        </div>
                                        <div>
                                            <a href="index.php?action=admin-approve-job&id=<?= $job['id'] ?>" class="btn btn-sm btn-primary" onclick="return confirm('Valider cette offre ?')">Valider</a>
                                            <a href="index.php?action=admin-reject-job&id=<?= $job['id'] ?>" class="btn btn-sm btn-outline-secondary" onclick="return confirm('Refuser cette offre ?')">Refuser</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Section Portfolios en attente -->
                <div class="card card-custom">
                    <div class="card-header">
                        <strong><i class="fas fa-folder-open"></i> Portfolios en attente</strong>
                    </div>
                    <div class="card-body">
                        <?php if (empty($pendingPortfolios)): ?>
                            <div class="text-center py-3"><p class="text-muted">Aucun portfolio en attente.</p></div>
                        <?php else: ?>
                            <?php foreach ($pendingPortfolios as $p): ?>
                                <div class="item-row">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong style="color:white;"><?= htmlspecialchars($p['title']) ?></strong>
                                            <br><small class="text-muted">Soumis par: <?= htmlspecialchars($p['submitted_by']) ?></small>
                                        </div>
                                        <div>
                                            <a href="index.php?action=admin-view-pending&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary">Voir</a>
                                            <a href="index.php?action=admin-approve&id=<?= $p['id'] ?>" class="btn btn-sm btn-primary" onclick="return confirm('Valider ce portfolio ?')">Valider</a>
                                            <a href="index.php?action=admin-reject&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-secondary" onclick="return confirm('Refuser ce portfolio ?')">Refuser</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card card-custom">
                    <div class="card-header">
                        <strong><i class="fas fa-bell"></i> Notifications récentes</strong>
                        <?php if ($unreadCount > 0): ?><span class="badge bg-secondary float-end"><?= $unreadCount ?> non lues</span><?php endif; ?>
                    </div>
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        <?php if (empty($notifications)): ?>
                            <div class="text-center py-4"><p class="text-muted"><i class="fas fa-bell-slash"></i> Aucune notification</p></div>
                        <?php else: ?>
                            <?php foreach ($notifications as $n): ?>
                                <div class="notification-item">
                                    <small class="text-muted"><?= date('d/m/Y H:i', strtotime($n['created_at'])) ?></small>
                                    <strong style="display:block; color:var(--primary);"><?= htmlspecialchars($n['title']) ?></strong>
                                    <p class="mb-0 small"><?= htmlspecialchars($n['message']) ?></p>
                                    <?php if ($n['link']): ?>
                                        <a href="<?= htmlspecialchars($n['link']) ?>" class="btn btn-sm btn-outline-light py-0 px-2 mt-2" style="font-size: 0.75rem;">Voir plus</a>
                                    <?php endif; ?>
                                    <?php if (!$n['is_read']): ?>
                                        <a href="index.php?action=admin-mark-notification&id=<?= $n['id'] ?>" class="text-muted small ms-2 mt-2"><i class="fas fa-check"></i> Lue</a>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div></div></div>
</div>
<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>
