<?php
ob_start();
?>

<?php if (isset($_GET['success'])): ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success" style="background: #00bdfe; color: white; border: none; border-radius: 10px; padding: 15px;">
                <i class="fa fa-check-circle"></i> Mission publiée avec succès.
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if (isset($_GET['updated'])): ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success" style="background: #00bdfe; color: white; border: none; border-radius: 10px; padding: 15px;">
                <i class="fa fa-check-circle"></i> Mission mise à jour avec succès.
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if (isset($_GET['deleted'])): ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success" style="background: #00bdfe; color: white; border: none; border-radius: 10px; padding: 15px;">
                <i class="fa fa-check-circle"></i> Mission supprimée avec succès.
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- ***** Page Banner Area Start ***** -->
<div class="page-banner" style="background: linear-gradient(135deg, #00bdfe 0%, #2b2b2b 100%); padding: 100px 0 50px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="top-text header-text text-center">
                    <h6 style="color: rgba(255,255,255,0.8);">Gestion</h6>
                    <h2 style="color: white;">Mes Missions Publiées</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ***** Page Banner Area End ***** -->

<div class="recent-listing" style="padding: 60px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>Vos Missions</h2>
                    <h6>Gérez vos missions</h6>
                </div>
                <div class="mb-4">
                    <div class="main-white-button">
                        <a href="index.php?action=front_create"><i class="fa fa-plus"></i> Publier une nouvelle mission</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <?php if (empty($missions)): ?>
                    <div class="text-center" style="padding: 50px; background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <i class="fa fa-info-circle" style="font-size: 48px; color: #00bdfe; margin-bottom: 20px;"></i>
                        <h4>Aucune mission publiée</h4>
                        <p style="color: #666; margin-bottom: 20px;">Commencez par publier votre première mission.</p>
                        <div class="main-white-button">
                            <a href="index.php?action=front_create"><i class="fa fa-bullhorn"></i> Publier une mission</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($missions as $mission): ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="listing-item" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                                    <div class="left-image" style="height: 150px; background: linear-gradient(135deg, #00bdfe 0%, #2b2b2b 100%); display: flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-briefcase" style="font-size: 48px; color: rgba(255,255,255,0.3);"></i>
                                    </div>
                                    <div class="right-content align-self-center" style="padding: 20px;">
                                        <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 10px;"><?php echo htmlspecialchars($mission['titre']); ?></h4>
                                        <p style="color: #666; font-size: 14px; margin-bottom: 10px;"><?php echo htmlspecialchars(substr($mission['description'], 0, 80)) . '...'; ?></p>
                                        <span class="badge" style="background: #00bdfe; color: white; padding: 5px 10px; border-radius: 20px; margin-bottom: 10px; display: inline-block;">
                                            <?php echo htmlspecialchars($mission['statut']); ?>
                                        </span>
                                        <span class="details" style="display: block; margin-bottom: 10px; font-size: 13px; color: #888;">
                                            <i class="fa fa-calendar"></i> Du <?php echo date('d/m/Y', strtotime($mission['date_debut'])); ?> au <?php echo date('d/m/Y', strtotime($mission['date_fin'])); ?>
                                        </span>
                                        <span class="price" style="display: block; margin-bottom: 15px; font-weight: 600; color: #00bdfe;">
                                            <i class="fa fa-euro"></i> <?php echo number_format($mission['budget'], 0, ',', ' '); ?> €
                                        </span>
                                        <div style="display: flex; gap: 10px;">
                                            <div class="main-white-button" style="flex: 1;">
                                                <a href="index.php?action=front_edit&id=<?php echo $mission['id']; ?>"><i class="fa fa-edit"></i> Modifier</a>
                                            </div>
                                            <a href="index.php?action=front_delete&id=<?php echo $mission['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette mission ?')" class="main-button" style="background: #dc3545; text-decoration: none; color: white; padding: 10px 15px; border-radius: 25px; display: inline-flex; align-items: center; justify-content: center;">
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