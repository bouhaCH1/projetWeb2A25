<?php
ob_start();
?>

<div class="hero">
    <div class="container">
        <h1 class="display-4">Mes Missions Publiées</h1>
        <p class="lead">Gérez vos missions</p>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <a href="index.php?action=front_create" class="btn btn-success">
            <i class="fas fa-plus"></i> Publier une nouvelle mission
        </a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="col-12">
            <div class="alert alert-success">
                Mission publiée avec succès.
            </div>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['updated'])): ?>
        <div class="col-12">
            <div class="alert alert-success">
                Mission mise à jour avec succès.
            </div>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['deleted'])): ?>
        <div class="col-12">
            <div class="alert alert-success">
                Mission supprimée avec succès.
            </div>
        </div>
    <?php endif; ?>

    <?php if (empty($missions)): ?>
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle fa-2x mb-3"></i>
                <h4>Aucune mission publiée</h4>
                <p>Commencez par publier votre première mission.</p>
                <a href="index.php?action=front_create" class="btn btn-primary">Publier une mission</a>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($missions as $mission): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card mission-card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($mission['titre']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars(substr($mission['description'], 0, 80)) . '...'; ?></p>
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
                        <div class="d-flex gap-2">
                            <a href="index.php?action=front_edit&id=<?php echo $mission['id']; ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <a href="index.php?action=front_delete&id=<?php echo $mission['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette mission ?')">
                                <i class="fas fa-trash"></i> Supprimer
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
?>