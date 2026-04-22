<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>
<div class="dashboard-container">
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary">Candidatures pour l'offre : <?= htmlspecialchars($job['title']) ?></h3>
        <a href="index.php?action=entreprise-dashboard" class="btn btn-outline-secondary">Retour</a>
    </div>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?= $_SESSION['message_type'] ?>"><?= $_SESSION['message'] ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <?php if (empty($applications)): ?>
        <div class="text-center py-5">
            <h5 class="text-muted">Aucune candidature pour le moment.</h5>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($applications as $app): ?>
                <div class="col-12">
                    <div class="card-custom">
                        <div class="d-flex justify-content-between">
                            <h5 class="text-primary"><i class="fas fa-user"></i> <?= htmlspecialchars($app['candidat_name']) ?></h5>
                            <small class="text-muted"><?= date('d/m/Y H:i', strtotime($app['created_at'])) ?></small>
                        </div>
                        <p><strong>Email :</strong> <?= htmlspecialchars($app['candidat_email']) ?></p>
                        <p><strong>Message :</strong></p>
                        <div class="p-3 mb-3" style="background: #1a1a1a; border-radius: 5px;">
                            <?= nl2br(htmlspecialchars($app['message'])) ?>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                Statut : 
                                <?php if ($app['status'] == 'pending'): ?>
                                    <span class="badge badge-pending">En attente</span>
                                <?php elseif ($app['status'] == 'accepted'): ?>
                                    <span class="badge badge-accepted">Acceptée</span>
                                <?php else: ?>
                                    <span class="badge badge-rejected">Refusée</span>
                                <?php endif; ?>
                            </div>
                            <?php if ($app['status'] == 'pending'): ?>
                                <div>
                                    <a href="index.php?action=entreprise-update-application&id=<?= $app['id'] ?>&status=accepted" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Accepter</a>
                                    <a href="index.php?action=entreprise-update-application&id=<?= $app['id'] ?>&status=rejected" class="btn btn-outline-secondary btn-sm"><i class="fas fa-times"></i> Refuser</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>


</div>
<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>
