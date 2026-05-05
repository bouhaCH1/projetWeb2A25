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
<section class="hero" style="min-height: 30vh; padding: 80px 0 30px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 style="font-size: 42px; font-weight: 700; margin-bottom: 15px; background: linear-gradient(135deg, #00ffcc, #00ccff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    <i class="fa fa-chart-pie"></i> Mes Candidatures
                </h1>
                <p style="color: rgba(255,255,255,0.7); font-size: 16px; margin-bottom: 20px;">
                    Gérez vos candidatures et consultez vos scores de matching
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Search by Email -->
<section style="padding: 0 0 30px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="cyber-card" style="padding: 20px;">
                    <form method="GET" action="index.php" style="display: flex; gap: 10px; align-items: center;">
                        <input type="hidden" name="action" value="front_candidatures">
                        <input type="email" name="email" 
                               style="background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 25px; padding: 10px 18px; flex: 1; font-size: 14px;"
                               placeholder="votre@email.com" 
                               value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                        <button type="submit" class="cyber-btn" style="padding: 10px 20px; font-size: 13px;">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Candidatures List -->
<section style="padding: 0 0 60px;">
    <div class="container">
        <?php if (empty($candidatures)): ?>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="cyber-card" style="text-align: center; padding: 60px 30px;">
                        <i class="fa fa-info-circle" style="font-size: 64px; color: rgba(0, 255, 204, 0.3); margin-bottom: 20px;"></i>
                        <h4 style="color: #ffffff; margin-bottom: 10px;">Aucune candidature</h4>
                        <p style="color: rgba(255,255,255,0.6); margin-bottom: 20px;">Aucune candidature trouvée pour cet email.</p>
                        <a href="index.php?action=missions" class="cyber-btn">
                            <i class="fa fa-briefcase"></i> Voir les missions
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($candidatures as $candidature): ?>
                    <?php
                        $score = $candidature['matching_score'] ?? 0;
                        if ($score >= 80) { $scoreColor = '#00ffcc'; $scoreLabel = 'Excellent'; }
                        elseif ($score >= 60) { $scoreColor = '#00ccff'; $scoreLabel = 'Bon'; }
                        elseif ($score >= 40) { $scoreColor = '#ffcc00'; $scoreLabel = 'Moyen'; }
                        else { $scoreColor = '#ff6b6b'; $scoreLabel = 'Faible'; }

                        $statut = $candidature['statut'] ?? '';
                        if ($statut === 'acceptee') {
                            $resLabel = 'Accepté'; $resIcon = 'fa-check-circle'; $resColor = '#00ffcc';
                            $resMsg = 'Félicitations ! Vous avez été sélectionné.';
                        } elseif ($statut === 'refusee') {
                            $resLabel = 'Refusé'; $resIcon = 'fa-times-circle'; $resColor = '#ff6b6b';
                            $resMsg = 'Votre candidature n\'a pas été retenue.';
                        } else {
                            $resLabel = 'En attente'; $resIcon = 'fa-clock'; $resColor = '#ffcc00';
                            $resMsg = 'Votre candidature est en cours d\'évaluation.';
                        }
                    ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="cyber-card">
                            <!-- Score Header -->
                            <div style="height: 100px; background: linear-gradient(135deg, rgba(0, 255, 204, 0.05), rgba(0, 204, 255, 0.05)); display: flex; align-items: center; justify-content: center; border-bottom: 1px solid rgba(255, 255, 255, 0.1); position: relative;">
                                <div style="width: 65px; height: 65px; border-radius: 50%; border: 4px solid <?php echo $scoreColor; ?>; display: flex; align-items: center; justify-content: center; background: rgba(10, 14, 39, 0.8); box-shadow: 0 0 20px <?php echo $scoreColor; ?>40;">
                                    <span style="font-size: 16px; font-weight: 700; color: <?php echo $scoreColor; ?>"><?php echo $score; ?>%</span>
                                </div>
                                <div style="position: absolute; top: 8px; right: 12px;">
                                    <span style="background: <?php echo $scoreColor; ?>20; color: <?php echo $scoreColor; ?>; font-size: 10px; padding: 3px 10px; border-radius: 12px; font-weight: 600;">
                                        <?php echo $scoreLabel; ?> Match
                                    </span>
                                </div>
                            </div>

                            <div style="padding: 20px;">
                                <!-- Candidate Name -->
                                <h4 style="color: #ffffff; font-size: 17px; font-weight: 700; margin-bottom: 5px;">
                                    <i class="fa fa-user" style="color: #00ffcc; margin-right: 6px;"></i>
                                    <?php echo htmlspecialchars($candidature['prenom'] . ' ' . $candidature['nom']); ?>
                                </h4>
                                <!-- Mission title -->
                                <h5 style="color: #00ccff; font-size: 14px; font-weight: 500; margin-bottom: 12px;">
                                    <i class="fa fa-briefcase" style="margin-right: 6px;"></i>
                                    <?php echo htmlspecialchars($candidature['mission_titre']); ?>
                                </h5>

                                <!-- Result Box -->
                                <div style="background: rgba(255,255,255,0.03); border-radius: 12px; padding: 15px; margin-bottom: 15px; border: 1px solid rgba(255,255,255,0.05);">
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                        <i class="fa <?php echo $resIcon; ?>" style="font-size: 18px; color: <?php echo $resColor; ?>"></i>
                                        <span style="font-size: 15px; font-weight: 700; color: <?php echo $resColor; ?>">
                                            <?php echo $resLabel; ?>
                                        </span>
                                    </div>
                                    <p style="color: rgba(255,255,255,0.6); font-size: 13px; margin: 0; line-height: 1.5;">
                                        <?php echo $resMsg; ?>
                                    </p>
                                </div>

                                <!-- Score Bar -->
                                <div style="margin-bottom: 15px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                                        <span style="color: rgba(255,255,255,0.5); font-size: 12px;">Score de matching</span>
                                        <span style="color: <?php echo $scoreColor; ?>; font-size: 12px; font-weight: 600;"><?php echo $score; ?>/100</span>
                                    </div>
                                    <div style="height: 6px; background: rgba(255,255,255,0.1); border-radius: 3px; overflow: hidden;">
                                        <div style="height: 100%; width: <?php echo $score; ?>%; background: linear-gradient(90deg, <?php echo $scoreColor; ?>, <?php echo $scoreColor; ?>cc); border-radius: 3px;"></div>
                                    </div>
                                </div>

                                <!-- Info -->
                                <div style="color: rgba(255,255,255,0.4); font-size: 12px; margin-bottom: 15px;">
                                    <i class="fa fa-envelope"></i> <?php echo htmlspecialchars($candidature['email']); ?>
                                    <span style="margin-left: 12px;"><i class="fa fa-calendar"></i> <?php echo date('d/m/Y', strtotime($candidature['created_at'])); ?></span>
                                </div>

                                <!-- Actions -->
                                <div style="display: flex; gap: 10px;">
                                    <?php if ($statut !== 'acceptee' && $statut !== 'refusee'): ?>
                                        <a href="index.php?action=front_edit_candidature&id=<?php echo $candidature['id']; ?>" class="cyber-btn" style="flex: 1; justify-content: center; font-size: 12px; padding: 8px;">
                                            <i class="fa fa-edit"></i> Modifier
                                        </a>
                                    <?php else: ?>
                                        <div style="flex: 1; text-align: center; padding: 8px; border-radius: 25px; background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.3); font-size: 11px; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.1);">
                                            <i class="fa fa-lock me-1"></i> Verrouillé
                                        </div>
                                    <?php endif; ?>
                                    <a href="index.php?action=front_delete_candidature&id=<?php echo $candidature['id']; ?>" onclick="return confirm('Supprimer cette candidature ?')" style="padding: 8px 12px; border-radius: 25px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; background: linear-gradient(135deg, #ff6b6b, #ff8e53); color: #ffffff;">
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