<?php
ob_start();
?>

<?php if (isset($_GET['updated'])): ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success" style="background: #00bdfe; color: white; border: none; border-radius: 10px; padding: 15px;">
                <i class="fa fa-check-circle"></i> Candidature mise à jour avec succès.
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
                <i class="fa fa-check-circle"></i> Candidature supprimée avec succès.
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
                    <h2 style="color: white;">Mes Candidatures</h2>
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
                    <h2>Candidatures Soumises</h2>
                    <h6>Gérez vos candidatures aux missions</h6>
                </div>
            </div>
            <div class="col-lg-12">
                <?php if (empty($candidatures)): ?>
                    <div class="text-center" style="padding: 50px; background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <i class="fa fa-info-circle" style="font-size: 48px; color: #00bdfe; margin-bottom: 20px;"></i>
                        <h4>Aucune candidature</h4>
                        <p style="color: #666; margin-bottom: 20px;">Vous n'avez pas encore postulé à des missions.</p>
                        <div class="main-white-button">
                            <a href="index.php?action=missions"><i class="fa fa-briefcase"></i> Voir les missions</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($candidatures as $candidature): ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="listing-item" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                                    <div class="left-image" style="height: 150px; background: linear-gradient(135deg, #00bdfe 0%, #2b2b2b 100%); display: flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-user" style="font-size: 48px; color: rgba(255,255,255,0.3);"></i>
                                    </div>
                                    <div class="right-content align-self-center" style="padding: 20px;">
                                        <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 10px;"><?php echo htmlspecialchars($candidature['nom'] . ' ' . $candidature['prenom']); ?></h4>
                                        <h6 style="color: #00bdfe; margin-bottom: 10px;"><?php echo htmlspecialchars($candidature['mission_titre']); ?></h6>
                                        <p style="color: #666; font-size: 14px; margin-bottom: 5px;">
                                            <i class="fa fa-envelope"></i> <?php echo htmlspecialchars($candidature['email']); ?>
                                        </p>
                                        <p style="color: #666; font-size: 14px; margin-bottom: 5px;">
                                            <i class="fa fa-phone"></i> <?php echo htmlspecialchars($candidature['telephone']); ?>
                                        </p>
                                        <p style="color: #888; font-size: 13px; margin-bottom: 15px;">
                                            <?php echo htmlspecialchars(substr($candidature['motivation'], 0, 80)) . '...'; ?>
                                        </p>
                                        <div style="display: flex; gap: 10px;">
                                            <div class="main-white-button" style="flex: 1;">
                                                <a href="index.php?action=front_edit_candidature&id=<?php echo $candidature['id']; ?>"><i class="fa fa-edit"></i> Modifier</a>
                                            </div>
                                            <a href="index.php?action=front_delete_candidature&id=<?php echo $candidature['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette candidature ?')" class="main-button" style="background: #dc3545; text-decoration: none; color: white; padding: 10px 15px; border-radius: 25px; display: inline-flex; align-items: center; justify-content: center;">
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