<?php ob_start(); ?>

<!-- HERO -->
<section class="hero">
    <div class="container">
        <h1>Trouvez la Mission<br><span>Qui Vous Correspond</span></h1>
        <p>Des centaines d'opportunités dans la tech, le digital et l'entrepreneuriat moderne.</p>
        <a href="#missions" class="hero-btn">
            <i class="fas fa-search me-2"></i> Explorer les Missions
        </a>
    </div>
</section>

<!-- STATS -->
<section class="stats-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-4 stat-item">
                <div class="number"><?= count($missions) ?>+</div>
                <div class="label">Missions disponibles</div>
            </div>
            <div class="col-md-4 stat-item">
                <div class="number">
                    <?= count(array_filter($missions, fn($m) => $m['statut'] === 'ouverte')) ?>
                </div>
                <div class="label">Missions ouvertes</div>
            </div>
            <div class="col-md-4 stat-item">
                <div class="number">
                    <?= count(array_filter($missions, fn($m) => $m['statut'] === 'en_cours')) ?>
                </div>
                <div class="label">En cours</div>
            </div>
        </div>
    </div>
</section>

<!-- MISSIONS -->
<section id="missions" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Missions Disponibles</h2>
            <p class="text-muted">Explorez les meilleures opportunités du moment</p>
        </div>

        <?php if (empty($missions)): ?>
            <div class="text-center py-5 text-muted">
                <i class="fas fa-inbox fa-4x mb-3" style="color:#4cc9f0;"></i>
                <h4>Aucune mission disponible</h4>
                <p>Revenez bientôt pour découvrir de nouvelles opportunités.</p>
            </div>
        <?php else: ?>
        <div class="row g-4">
            <?php foreach ($missions as $m): ?>
            <div class="col-md-6 col-lg-4">
                <div class="mission-card card">
                    <div class="card-accent"></div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="badge-<?= $m['statut'] ?>">
                                <?= ucfirst(str_replace('_', ' ', $m['statut'])) ?>
                            </span>
                            <span class="budget"><?= number_format($m['budget'], 0) ?> €</span>
                        </div>
                        <h5 class="card-title mb-2"><?= htmlspecialchars($m['titre']) ?></h5>
                        <p class="text-muted small mb-3">
                            <?= htmlspecialchars(substr($m['description'], 0, 100)) ?>...
                        </p>
                        <div class="mb-3 small text-muted">
                            <i class="fas fa-calendar me-1 text-primary"></i>
                            <?= $m['date_debut'] ?> → <?= $m['date_fin'] ?>
                        </div>
                        <div class="mb-4">
                            <?php foreach (explode(',', $m['competences']) as $comp): ?>
                                <span class="badge bg-light text-dark border me-1 mb-1">
                                    <?= htmlspecialchars(trim($comp)) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                        <?php if ($m['statut'] === 'ouverte'): ?>
                            <a href="#" class="btn-postuler">
                                <i class="fas fa-paper-plane me-2"></i>Postuler
                            </a>
                        <?php else: ?>
                            <span class="text-muted small">
                                <i class="fas fa-lock me-1"></i>Mission non disponible
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>