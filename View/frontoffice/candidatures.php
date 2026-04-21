<?php
ob_start();
?>

<div class="hero">
    <div class="container">
        <h1 class="display-4">Mes Candidatures</h1>
        <p class="lead">Gérez vos candidatures aux missions</p>
    </div>
</div>

<div class="row">
    <?php if (isset($_GET['updated'])): ?>
        <div class="col-12">
            <div class="alert alert-success">
                Candidature mise à jour avec succès.
            </div>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['deleted'])): ?>
        <div class="col-12">
            <div class="alert alert-success">
                Candidature supprimée avec succès.
            </div>
        </div>
    <?php endif; ?>
    <?php if (empty($candidatures)): ?>
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle fa-2x mb-3"></i>
                <h4>Aucune candidature</h4>
                <p>Vous n'avez pas encore postulé à des missions.</p>
                <a href="index.php?action=missions" class="btn btn-primary">Voir les missions</a>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($candidatures as $candidature): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card mission-card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($candidature['nom'] . ' ' . $candidature['prenom']); ?></h5>
                        <p class="card-text"><strong>Mission:</strong> <?php echo htmlspecialchars($candidature['mission_titre']); ?></p>
                        <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($candidature['email']); ?></p>
                        <p class="card-text"><strong>Téléphone:</strong> <?php echo htmlspecialchars($candidature['telephone']); ?></p>
                        <p class="card-text"><strong>Motivation:</strong> <?php echo htmlspecialchars(substr($candidature['motivation'], 0, 100)) . '...'; ?></p>
                        <div class="d-flex gap-2">
                            <a href="index.php?action=front_edit_candidature&id=<?php echo $candidature['id']; ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <a href="index.php?action=front_delete_candidature&id=<?php echo $candidature['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette candidature ?')">
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