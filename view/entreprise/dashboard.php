<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>
<div class="dashboard-container">
<div class="container"><div class="row"><div class="col-md-3"><div class="glass-card">
        <div class="sidebar-header">
            <i class="fas fa-building" style="font-size: 2rem;"></i>
            <h4>Work Wave</h4>
            <small>Espace Entreprise</small>
        </div>
        <div class="sidebar-menu d-flex flex-column gap-3 mt-4">
            <a href="index.php?action=home"><i class="fas fa-home"></i> Accueil Public</a>
            <a href="index.php?action=entreprise-dashboard" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="index.php?action=entreprise-submit-job"><i class="fas fa-plus-circle"></i> Publier une offre</a>
            <hr style="border-color: rgba(212, 175, 55, 0.2);">
            <a href="index.php?action=logout" style="color: #e0e0e0;"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </div>
    </div>

    </div><div class="col-md-9">
        <div class="top-bar">
            <div>
                <h4 class="m-0" style="color: var(--primary);"><i class="fas fa-building"></i> <?= htmlspecialchars($_SESSION['user']['company'] ?? $_SESSION['user']['full_name']) ?></h4>
            </div>
            <a href="index.php?action=logout" class="btn btn-outline-secondary btn-sm rounded-pill" onclick="return confirm('Voulez-vous vraiment vous déconnecter ?')">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </a>
        </div>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] == 'success' ? 'success' : 'danger' ?>" style="background: rgba(25, 135, 84, 0.2); border-color: rgba(25, 135, 84, 0.5); color: #fff;">
                <?= htmlspecialchars($_SESSION['message']) ?>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-8">
                <!-- My Jobs Section -->
                <div class="card card-custom">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong><i class="fas fa-briefcase"></i> Mes Offres d'Emploi</strong>
                        <a href="index.php?action=entreprise-submit-job" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Nouvelle offre</a>
                    </div>
                    <div class="card-body">
                        <?php if (empty($myJobs)): ?>
                            <div class="text-center py-4">
                                <p class="text-muted">Aucune offre d'emploi publiée.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($myJobs as $job): ?>
                                <div class="item-card">
                                    <div class="d-flex justify-content-between">
                                        <h5 style="color: white;"><?= htmlspecialchars($job['title']) ?></h5>
                                        <span class="badge bg-secondary"><?= $job['status'] ?></span>
                                    </div>
                                    <p class="small text-muted mb-2">Publiée le <?= date('d/m/Y', strtotime($job['created_at'])) ?></p>
                                    <a href="index.php?action=entreprise-applications&job_id=<?= $job['id'] ?>" class="btn btn-sm btn-outline-light rounded-pill mt-2">
                                        <i class="fas fa-users"></i> Voir les candidatures
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Portfolios Section -->
                <div class="card card-custom">
                    <div class="card-header">
                        <strong><i class="fas fa-folder-open"></i> Portfolios de Talents Validés</strong>
                        <span class="badge bg-primary float-end"><?= count($portfolios) ?> disponibles</span>
                    </div>
                    <div class="card-body">
                        <?php if (empty($portfolios)): ?>
                            <div class="text-center py-4">
                                <p class="text-muted">Aucun portfolio disponible pour le moment</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($portfolios as $p): ?>
                                <div class="item-card" style="cursor: pointer;" onclick="window.location.href='index.php?action=entreprise-view&id=<?= $p['id'] ?>'">
                                    <div class="row align-items-center">
                                        <div class="col-md-9">
                                            <h6 style="color: white;"><?= htmlspecialchars($p['title']) ?></h6>
                                            <p class="small text-muted mb-1">Par <?= htmlspecialchars($p['submitted_by']) ?></p>
                                        </div>
                                        <div class="col-md-3 text-end">
                                            <span class="badge" style="background: var(--primary); color: #000000;"><?= htmlspecialchars($p['category']) ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card">
                    <i class="fas fa-users" style="font-size: 2rem; color: var(--primary);"></i>
                    <h3 style="color: white;"><?= count($portfolios) ?></h3>
                    <p class="mb-0">Talents sur la plateforme</p>
                </div>

                <div class="card card-custom">
                    <div class="card-header">
                        <strong><i class="fas fa-bell"></i> Notifications</strong>
                        <?php if ($unreadCount > 0): ?>
                            <span class="badge bg-secondary float-end"><?= $unreadCount ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        <?php if (empty($notifications)): ?>
                            <div class="text-center text-muted py-3">
                                <i class="fas fa-bell-slash"></i> Aucune notification
                            </div>
                        <?php else: ?>
                            <?php foreach ($notifications as $n): ?>
                                <div class="notification-item">
                                    <small class="text-muted"><?= date('d/m/Y H:i', strtotime($n['created_at'])) ?></small>
                                    <strong style="color: var(--primary); display: block;"><?= htmlspecialchars($n['title']) ?></strong>
                                    <p class="mb-1 small"><?= htmlspecialchars($n['message']) ?></p>
                                    <?php if ($n['link']): ?>
                                        <a href="<?= htmlspecialchars($n['link']) ?>" class="btn btn-sm btn-outline-light py-0 px-2" style="font-size: 0.75rem;">Voir</a>
                                    <?php endif; ?>
                                    <?php if (!$n['is_read']): ?>
                                        <a href="index.php?action=entreprise-mark-notification&id=<?= $n['id'] ?>" class="text-muted small ms-2"><i class="fas fa-check"></i> Lue</a>
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
