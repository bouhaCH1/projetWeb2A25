<?php
ob_start();
?>

<div class="hero">
    <div class="container">
        <h1 class="display-4">Découvrez nos Missions</h1>
        <p class="lead">Trouvez la mission parfaite pour vos compétences</p>
    </div>
</div>

<div class="row">
    <?php if (isset($_GET['applied'])): ?>
        <div class="col-12">
            <div class="alert alert-success">
                Candidature envoyee avec succes.
            </div>
        </div>
    <?php endif; ?>
    <?php if (empty($missions)): ?>
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle fa-2x mb-3"></i>
                <h4>Aucune mission disponible</h4>
                <p>Revenez plus tard pour découvrir de nouvelles opportunités.</p>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($missions as $mission): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card mission-card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($mission['titre']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars(substr($mission['description'], 0, 100)) . '...'; ?></p>
                        <div class="mb-2">
                            <span class="badge statut-badge badge-<?= htmlspecialchars($mission['statut']) ?>">
                                <?php echo htmlspecialchars($mission['statut']); ?>
                            </span>
                        </div>
                        <p class="text-muted mb-2">
                            <i class="fas fa-calendar"></i> Du <?php echo date('d/m/Y', strtotime($mission['date_debut'])); ?> au <?php echo date('d/m/Y', strtotime($mission['date_fin'])); ?>
                        </p>
                        <p class="text-success fw-bold mb-2">
                            <i class="fas fa-euro-sign"></i> <?php echo number_format($mission['budget'], 0, ',', ' '); ?> €
                        </p>
                        <?php if ($mission['competences']): ?>
                            <p class="mb-3">
                                <i class="fas fa-tools"></i> <strong>Compétences:</strong> <?php echo htmlspecialchars($mission['competences']); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="index.php?action=front_apply&id=<?php echo (int)$mission['id']; ?>" class="btn btn-primary btn-sm mb-2">
                            <i class="fas fa-paper-plane"></i> Postuler
                        </a>
                        <br>
                        <small class="text-muted">
                            <i class="fas fa-clock"></i> Postée le <?php echo date('d/m/Y', strtotime($mission['created_at'])); ?>
                        </small>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>