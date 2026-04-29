<?php
ob_start();
?>

<?php if (isset($_GET['updated'])): ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="cyber-alert cyber-alert-success">
                <i class="fa fa-check-circle"></i> Candidature mise a jour avec succes.
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if (isset($_GET['deleted'])): ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="cyber-alert cyber-alert-warning">
                <i class="fa fa-check-circle"></i> Candidature supprimee avec succes.
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- ===== Page Banner ===== -->
<div class="cyber-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h6>Gestion</h6>
                <h2>Mes Candidatures</h2>
            </div>
        </div>
    </div>
</div>

<div style="padding: 60px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>Candidatures Soumises</h2>
                    <h6>Gerez vos candidatures aux missions</h6>
                </div>
            </div>
            <div class="col-lg-12">
                <?php if (empty($candidatures)): ?>
                    <div class="cyber-empty">
                        <i class="fa fa-info-circle"></i>
                        <h4>Aucune candidature</h4>
                        <p>Vous n'avez pas encore postule a des missions.</p>
                        <a href="index.php?action=missions" class="cyber-btn"><i class="fa fa-briefcase"></i> Voir les missions</a>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($candidatures as $candidature): ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="cyber-card">
                                    <div class="cyber-card-image" style="height: 150px;">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="cyber-card-body">
                                        <h4><?php echo htmlspecialchars($candidature['nom'] . ' ' . $candidature['prenom']); ?></h4>
                                        <h6 style="color: var(--neon-cyan); margin-bottom: 10px; font-size: 14px;"><?php echo htmlspecialchars($candidature['mission_titre']); ?></h6>
                                        <div class="cyber-meta">
                                            <i class="fa fa-envelope"></i> <?php echo htmlspecialchars($candidature['email']); ?>
                                        </div>
                                        <div class="cyber-meta">
                                            <i class="fa fa-phone"></i> <?php echo htmlspecialchars($candidature['telephone']); ?>
                                        </div>
                                        <p style="color: var(--text-dim); font-size: 13px; margin-bottom: 15px;">
                                            <?php echo htmlspecialchars(substr($candidature['motivation'], 0, 80)) . '...'; ?>
                                        </p>
                                        <div style="display: flex; gap: 10px;">
                                            <a href="index.php?action=front_edit_candidature&id=<?php echo $candidature['id']; ?>" class="cyber-btn" style="flex: 1; justify-content: center; font-size: 13px; padding: 10px 15px;"><i class="fa fa-edit"></i> Modifier</a>
                                            <a href="index.php?action=front_delete_candidature&id=<?php echo $candidature['id']; ?>" onclick="return confirm('Etes-vous sur de vouloir supprimer cette candidature ?')" class="cyber-btn-danger" style="padding: 10px 15px; border-radius: 25px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; font-size: 13px;">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
?>