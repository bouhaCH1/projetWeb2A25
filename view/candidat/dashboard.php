<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>
<div class="dashboard-container">
<div class="container"><div class="row"><div class="col-md-3"><div class="glass-card">
        <div class="sidebar-header">
            <i class="fas fa-user-astronaut" style="font-size: 2.5rem; color: var(--primary); margin-bottom: 10px;"></i>
            <h4>Work Wave</h4>
            <small style="color: var(--secondary);">Espace Candidat</small>
        </div>
        <div class="sidebar-menu mt-4">
            <a href="index.php?action=home"><i class="fas fa-home"></i> Accueil Public</a>
            <a href="index.php?action=candidat-dashboard" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="index.php?action=candidat-submit"><i class="fas fa-plus-circle"></i> Nouveau portfolio</a>
            <hr style="border-color: rgba(0, 210, 255, 0.2); margin: 20px 0;">
            <a href="index.php?action=logout" style="color: #ff6b6b;"><i class="fas fa-power-off"></i> Déconnexion</a>
        </div>
    </div>

    </div><div class="col-md-9">
        <div class="top-bar glass-card mb-4" style="padding: 15px 25px;">
            <div class="d-flex align-items-center gap-3">
                <i class="fas fa-user-astronaut" style="font-size: 1.5rem; color: var(--primary);"></i>
                <h5 class="m-0" style="color: white;">Bonjour, <?= htmlspecialchars($_SESSION['user']['full_name'] ?? $_SESSION['user']['username'] ?? '') ?></h5>
            </div>
            <div>
                <?php if ($unreadCount > 0): ?>
                    <span class="badge bg-primary rounded-pill me-3"><i class="fas fa-bell"></i> <?= $unreadCount ?></span>
                <?php endif; ?>
                <a href="index.php?action=logout" class="btn btn-outline-secondary btn-sm rounded-pill">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </div>
        </div>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] == 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
                <i class="fas <?= $_SESSION['message_type'] == 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle' ?>"></i> 
                <?= htmlspecialchars($_SESSION['message']) ?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>

        <div class="glass-card welcome-banner mb-4 p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 style="color: white; font-weight: 800;">Prêt à conquérir de nouvelles opportunités ?</h2>
                    <p class="text-muted" style="font-size: 1.1rem;">Gérez vos portfolios, suivez vos candidatures et décrochez le job de vos rêves.</p>
                    <a href="index.php?action=candidat-submit" class="btn btn-primary mt-2 px-4 rounded-pill"><i class="fas fa-rocket"></i> Publier un portfolio</a>
                </div>
                <div class="col-md-4 text-center d-none d-md-block">
                    <i class="fas fa-globe" style="font-size: 6rem; color: rgba(0, 210, 255, 0.2); animation: pulseBackground 4s infinite alternate;"></i>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="glass-card text-center p-4">
                    <i class="fas fa-folder-open mb-2" style="font-size: 2rem; color: var(--primary);"></i>
                    <div class="stat-badge"><?= count($portfolios) ?></div>
                    <p class="text-muted m-0">Portfolios publiés</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-card text-center p-4">
                    <i class="fas fa-paper-plane mb-2" style="font-size: 2rem; color: var(--secondary);"></i>
                    <div class="stat-badge" style="color: var(--secondary); text-shadow: 0 0 15px rgba(155, 81, 224, 0.5);"><?= count($myApplications) ?></div>
                    <p class="text-muted m-0">Candidatures envoyées</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-card text-center p-4">
                    <i class="fas fa-bell mb-2" style="font-size: 2rem; color: #f1c40f;"></i>
                    <div class="stat-badge" style="color: #f1c40f; text-shadow: 0 0 15px rgba(241, 196, 15, 0.5);"><?= count($notifications) ?></div>
                    <p class="text-muted m-0">Notifications</p>
                </div>
            </div>
        </div>

        <div class="dashboard-grid">
            <!-- Portfolios -->
            <div>
                <h4 class="mb-3" style="color: white;"><i class="fas fa-star text-primary"></i> Mes Portfolios</h4>
                <?php if (empty($portfolios)): ?>
                    <div class="glass-card text-center p-5">
                        <i class="fas fa-folder-plus mb-3" style="font-size: 3rem; color: rgba(255,255,255,0.1);"></i>
                        <h5 class="text-muted">Aucun portfolio</h5>
                        <p class="small text-muted mb-4">Montrez vos talents au monde entier.</p>
                        <a href="index.php?action=candidat-submit" class="btn btn-outline-primary rounded-pill">Créer mon premier portfolio</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($portfolios as $p): ?>
                        <div class="portfolio-card glass-card p-3 mb-3" style="border-left: 4px solid <?= $p['is_approved'] ? '#28a745' : '#ffc107' ?>;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 style="color: white; margin-bottom: 5px;"><?= htmlspecialchars($p['title'] ?? '') ?></h5>
                                    <p class="small text-muted mb-2"><?= htmlspecialchars(substr($p['description'] ?? '', 0, 60)) ?>...</p>
                                    <?php if ($p['is_approved'] == 0): ?>
                                        <span class="badge" style="background: rgba(255, 193, 7, 0.2); color: #ffc107; border: 1px solid #ffc107;"><i class="fas fa-clock"></i> En attente de validation</span>
                                    <?php else: ?>
                                        <span class="badge" style="background: rgba(40, 167, 69, 0.2); color: #28a745; border: 1px solid #28a745;"><i class="fas fa-check-circle"></i> En ligne</span>
                                    <?php endif; ?>
                                </div>
                                <?php if ($p['is_approved'] == 0): ?>
                                    <div class="d-flex gap-2">
                                        <a href="index.php?action=candidat-edit&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary" title="Modifier"><i class="fas fa-edit"></i></a>
                                        <a href="index.php?action=candidat-delete&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger" title="Supprimer" onclick="return confirm('Supprimer ce portfolio ?')"><i class="fas fa-trash"></i></a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Candidatures -->
            <div>
                <h4 class="mb-3" style="color: white;"><i class="fas fa-paper-plane text-secondary"></i> Mes Candidatures</h4>
                <?php if (empty($myApplications)): ?>
                    <div class="glass-card text-center p-5">
                        <i class="fas fa-search mb-3" style="font-size: 3rem; color: rgba(255,255,255,0.1);"></i>
                        <h5 class="text-muted">Aucune candidature</h5>
                        <p class="small text-muted mb-4">Parcourez les offres et postulez aux projets qui vous passionnent.</p>
                        <a href="index.php?action=home" class="btn btn-outline-secondary rounded-pill">Parcourir les offres</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($myApplications as $app): ?>
                        <div class="app-card glass-card p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 style="color: white; font-weight: 600; margin-bottom: 2px;"><?= htmlspecialchars($app['job_title'] ?? '') ?></h6>
                                    <div class="small text-muted mb-1"><i class="fas fa-building text-primary"></i> <?= htmlspecialchars($app['company_name'] ?? '') ?></div>
                                    <div class="small text-muted" style="font-size: 0.8rem;"><i class="far fa-calendar-alt"></i> <?= date('d/m/Y', strtotime($app['created_at'])) ?></div>
                                </div>
                                <div>
                                    <?php if ($app['status'] == 'pending'): ?>
                                        <span class="badge" style="background: rgba(255, 193, 7, 0.2); color: #ffc107; border: 1px solid #ffc107; padding: 8px 12px; border-radius: 20px;">En attente</span>
                                    <?php elseif ($app['status'] == 'accepted'): ?>
                                        <span class="badge" style="background: rgba(40, 167, 69, 0.2); color: #28a745; border: 1px solid #28a745; padding: 8px 12px; border-radius: 20px;">Acceptée</span>
                                    <?php else: ?>
                                        <span class="badge" style="background: rgba(220, 53, 69, 0.2); color: #dc3545; border: 1px solid #dc3545; padding: 8px 12px; border-radius: 20px;">Refusée</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Notifications -->
        <h4 class="mb-3 mt-4" style="color: white;"><i class="fas fa-bell" style="color: #f1c40f;"></i> Historique des Notifications</h4>
        <div class="glass-card p-4">
            <div style="max-height: 400px; overflow-y: auto; padding-right: 10px;">
                <?php if (empty($notifications)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-bell-slash" style="font-size: 2rem; color: rgba(255,255,255,0.1);"></i>
                        <p class="text-muted mt-2">Vous n'avez aucune notification.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($notifications as $n): ?>
                        <div class="notification-item p-3 mb-2 rounded" style="background: rgba(30, 30, 30, 0.5); border-left: 3px solid <?= $n['is_read'] ? 'rgba(255,255,255,0.1)' : 'var(--primary)' ?>; transition: 0.3s;">
                            <div class="d-flex justify-content-between">
                                <strong style="color: <?= $n['is_read'] ? '#b0b0b0' : 'var(--primary)' ?>;"><?= htmlspecialchars($n['title'] ?? '') ?></strong>
                                <small class="text-muted"><?= date('d/m/Y H:i', strtotime($n['created_at'])) ?></small>
                            </div>
                            <p class="mb-1 small" style="color: #e0e0e0;"><?= htmlspecialchars($n['message'] ?? '') ?></p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <?php if ($n['link']): ?>
                                    <a href="<?= htmlspecialchars($n['link'] ?? '') ?>" class="btn btn-sm btn-outline-light py-0 px-3 rounded-pill" style="font-size: 0.8rem;">Consulter</a>
                                <?php else: ?>
                                    <span></span>
                                <?php endif; ?>
                                
                                <?php if (!$n['is_read']): ?>
                                    <a href="index.php?action=candidat-mark-notification&id=<?= $n['id'] ?>" class="text-muted small hover-primary" style="text-decoration: none;"><i class="fas fa-check"></i> Marquer lue</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</div></div></div>
</div>
<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>
