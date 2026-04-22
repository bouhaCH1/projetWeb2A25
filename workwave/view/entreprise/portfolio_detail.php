<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>
<div class="dashboard-container">
<div class="container"><div class="row"><div class="col-md-3"><div class="glass-card">
        <div class="sidebar-header">
            <i class="fas fa-building" style="font-size: 2rem;"></i>
            <h4>Work Wave</h4>
            <small>Espace Entreprise</small>
        </div>
        <div class="sidebar-menu d-flex flex-column gap-3 mt-4">
            <a href="index.php?action=entreprise-dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <hr style="border-color: rgba(255,255,255,0.2);">
            <a href="index.php?action=logout" style="color: #e0e0e0;"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </div>
    </div>

    </div><div class="col-md-9">
        <div class="top-bar">
            <h4><i class="fas fa-folder-open"></i> Détail du portfolio</h4>
            <a href="index.php?action=entreprise-dashboard" class="btn btn-outline-secondary btn-sm">← Retour</a>
        </div>

        <div class="detail-card">
            <div class="row">
                <div class="col-md-8">
                    <h2><?= htmlspecialchars($portfolio['title']) ?></h2>
                    <p class="text-muted">
                        <i class="fas fa-user"></i> <?= htmlspecialchars($portfolio['submitted_by']) ?> |
                        <i class="fas fa-building"></i> <?= htmlspecialchars($portfolio['company_name'] ?? 'Indépendant') ?> |
                        <i class="fas fa-calendar"></i> <?= date('d/m/Y', strtotime($portfolio['created_at'])) ?>
                    </p>
                    
                    <h5 class="mt-4">Description</h5>
                    <p><?= nl2br(htmlspecialchars($portfolio['description'])) ?></p>
                    
                    <h5>Technologies utilisées</h5>
                    <div>
                        <?php 
                        $techs = explode(',', $portfolio['technologies']);
                        foreach ($techs as $tech): 
                        ?>
                            <span class="tech-badge"><?= htmlspecialchars(trim($tech)) ?></span>
                        <?php endforeach; ?>
                    </div>
                    
                    <h5 class="mt-4">Catégorie</h5>
                    <p><span class="badge bg-primary"><?= htmlspecialchars($portfolio['category']) ?></span></p>
                    
                    <?php if ($portfolio['project_url']): ?>
                        <a href="<?= htmlspecialchars($portfolio['project_url']) ?>" target="_blank" class="btn btn-outline-primary mt-2">
                            <i class="fas fa-external-link-alt"></i> Voir le projet
                        </a>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <i class="fas fa-user-circle" style="font-size: 4rem; color: #e0e0e0;"></i>
                            <h5 class="mt-2"><?= htmlspecialchars($portfolio['submitted_by']) ?></h5>
                            <hr>
                            <button class="contact-btn" onclick="alert('Fonctionnalité de contact à venir - Email: contact@workwave.com')">
                                <i class="fas fa-envelope"></i> Contacter le talent
                            </button>
                            <p class="small text-muted mt-3">
                                <i class="fas fa-shield-alt"></i> Portfolio vérifié par l'équipe Work Wave
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div></div></div>
</div>
<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>
