<?php
ob_start();
?>

<?php if (isset($_GET['updated'])): ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="cyber-alert cyber-alert-success">
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
            <div class="cyber-alert cyber-alert-warning">
                <i class="fa fa-check-circle"></i> Candidature supprimée avec succès.
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Hero Section -->
<section class="hero" style="min-height: 40vh; padding: 80px 0 40px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 style="font-size: 42px; font-weight: 700; margin-bottom: 15px; background: linear-gradient(135deg, #00ffcc, #00ccff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    Mes Candidatures
                </h1>
                <p style="color: rgba(255,255,255,0.7); font-size: 16px; margin-bottom: 20px;">
                    Gérez toutes vos candidatures aux missions
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Candidatures List -->
<section style="padding: 40px 0;">
    <div class="container">
        <?php if (empty($candidatures)): ?>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="cyber-card" style="text-align: center; padding: 60px 30px;">
                        <i class="fa fa-info-circle" style="font-size: 64px; color: rgba(0, 255, 204, 0.3); margin-bottom: 20px;"></i>
                        <h4 style="color: #ffffff; margin-bottom: 10px;">Aucune candidature</h4>
                        <p style="color: rgba(255,255,255,0.6); margin-bottom: 20px;">Vous n'avez pas encore postulé à des missions.</p>
                        <a href="index.php?action=missions" class="cyber-btn">
                            <i class="fa fa-briefcase"></i> Voir les missions
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($candidatures as $candidature): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="cyber-card">
                            <div style="height: 120px; background: linear-gradient(135deg, rgba(0, 255, 204, 0.1), rgba(0, 204, 255, 0.1)); display: flex; align-items: center; justify-content: center; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                                <i class="fa fa-user" style="font-size: 40px; color: rgba(0, 255, 204, 0.3);"></i>
                            </div>
                            <div style="padding: 20px;">
                                <h4 style="color: #ffffff; font-size: 16px; font-weight: 600; margin-bottom: 10px;">
                                    <?php echo htmlspecialchars($candidature['nom'] . ' ' . $candidature['prenom']); ?>
                                </h4>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                    <h6 style="color: #00ccff; margin: 0; font-size: 14px;">
                                        <?php echo htmlspecialchars($candidature['mission_titre']); ?>
                                    </h6>
                                    <?php 
                                        $statusLabel = 'En attente';
                                        $statusColor = 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)';
                                        if (isset($candidature['statut'])) {
                                            if ($candidature['statut'] === 'acceptee') {
                                                $statusLabel = 'Acceptée';
                                                $statusColor = 'linear-gradient(135deg, #00ffcc, #00ccff)';
                                            } elseif ($candidature['statut'] === 'refusee') {
                                                $statusLabel = 'Refusée';
                                                $statusColor = 'linear-gradient(135deg, #ff6b6b, #ff8e53)';
                                            }
                                        }
                                    ?>
                                    <span style="font-size: 10px; padding: 4px 10px; border-radius: 20px; background: <?php echo $statusColor; ?>; color: #fff; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                                        <?php echo $statusLabel; ?>
                                    </span>
                                </div>
                                <div style="color: rgba(255,255,255,0.5); font-size: 13px; margin-bottom: 8px;">
                                    <i class="fa fa-envelope"></i> <?php echo htmlspecialchars($candidature['email']); ?>
                                </div>
                                <div style="color: rgba(255,255,255,0.5); font-size: 13px; margin-bottom: 12px;">
                                    <i class="fa fa-phone"></i> <?php echo htmlspecialchars($candidature['telephone']); ?>
                                </div>
                                <p style="color: rgba(255,255,255,0.6); font-size: 13px; margin-bottom: 15px; line-height: 1.5;">
                                    <?php echo htmlspecialchars(substr($candidature['motivation'], 0, 80)) . '...'; ?>
                                </p>
                                <div style="display: flex; gap: 10px;">
                                    <?php if (!isset($candidature['statut']) || $candidature['statut'] === 'en_attente'): ?>
                                        <a href="index.php?action=front_edit_candidature&id=<?php echo $candidature['id']; ?>" class="cyber-btn" style="flex: 1; justify-content: center; font-size: 13px; padding: 10px;">
                                            <i class="fa fa-edit"></i> Modifier
                                        </a>
                                    <?php else: ?>
                                        <div style="flex: 1; text-align: center; padding: 10px; border-radius: 25px; background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.3); font-size: 11px; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.1);">
                                            <i class="fa fa-lock me-2"></i> Modification verrouillée
                                        </div>
                                    <?php endif; ?>
                                    <a href="index.php?action=front_delete_candidature&id=<?php echo $candidature['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette candidature ?')" style="padding: 10px 15px; border-radius: 25px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; background: linear-gradient(135deg, #ff6b6b, #ff8e53); color: #ffffff;">
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
</section>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
?>