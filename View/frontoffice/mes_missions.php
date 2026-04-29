<?php
ob_start();
?>

<?php if (isset($_GET['success'])): ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="cyber-alert cyber-alert-success">
                <i class="fa fa-check-circle"></i> Mission publiee avec succes.
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if (isset($_GET['updated'])): ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="cyber-alert cyber-alert-success">
                <i class="fa fa-check-circle"></i> Mission mise a jour avec succes.
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
                <i class="fa fa-check-circle"></i> Mission supprimee avec succes.
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
                <h2>Mes Missions Publiees</h2>
            </div>
        </div>
    </div>
</div>

<div style="padding: 60px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>Vos Missions</h2>
                    <h6>Gerez vos missions</h6>
                </div>
                <div class="mb-4">
                    <a href="index.php?action=front_create" class="cyber-btn"><i class="fa fa-plus"></i> Publier une nouvelle mission</a>
                </div>
            </div>
            <div class="col-lg-12">
                <?php if (empty($missions)): ?>
                    <div class="cyber-empty">
                        <i class="fa fa-info-circle"></i>
                        <h4>Aucune mission publiee</h4>
                        <p>Commencez par publier votre premiere mission.</p>
                        <a href="index.php?action=front_create" class="cyber-btn"><i class="fa fa-bullhorn"></i> Publier une mission</a>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($missions as $mission): ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="cyber-card">
                                    <div class="cyber-card-image" style="height: 150px;">
                                        <i class="fa fa-briefcase"></i>
                                    </div>
                                    <div class="cyber-card-body">
                                        <h4><?php echo htmlspecialchars($mission['titre']); ?></h4>
                                        <p><?php echo htmlspecialchars(substr($mission['description'], 0, 80)) . '...'; ?></p>
                                        <span class="cyber-badge cyber-badge-green" style="margin-bottom: 10px; display: inline-block;">
                                            <?php echo htmlspecialchars($mission['statut']); ?>
                                        </span>
                                        <div class="cyber-meta">
                                            <i class="fa fa-calendar"></i> Du <?php echo date('d/m/Y', strtotime($mission['date_debut'])); ?> au <?php echo date('d/m/Y', strtotime($mission['date_fin'])); ?>
                                        </div>
                                        <div class="cyber-price" style="margin-bottom: 15px;">
                                            <i class="fa fa-euro" style="font-size: 14px;"></i> <?php echo number_format($mission['budget'], 0, ',', ' '); ?> EUR
                                        </div>
                                        <div style="display: flex; gap: 10px;">
                                            <a href="index.php?action=front_edit&id=<?php echo $mission['id']; ?>" class="cyber-btn" style="flex: 1; justify-content: center; font-size: 13px; padding: 10px 15px;"><i class="fa fa-edit"></i> Modifier</a>
                                            <a href="index.php?action=front_delete&id=<?php echo $mission['id']; ?>" onclick="return confirm('Etes-vous sur de vouloir supprimer cette mission ?')" class="cyber-btn-danger" style="padding: 10px 15px; border-radius: 25px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; font-size: 13px;">
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