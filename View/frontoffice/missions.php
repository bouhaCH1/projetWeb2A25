<?php
ob_start();
?>

<?php if (isset($_GET['applied'])): ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="cyber-alert cyber-alert-success">
                <i class="fa fa-check-circle"></i> Candidature envoyee avec succes.
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- ===== Hero Banner ===== -->
<div class="cyber-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h6>Plusieurs Missions Disponibles</h6>
                <h2>Trouvez la mission parfaite pour vos competences</h2>
            </div>
            <div class="col-lg-12">
                <form id="search-form" name="gs" method="get" role="search" action="index.php">
                    <input type="hidden" name="action" value="missions">
                    <div class="cyber-search">
                        <div class="row">
                            <div class="col-lg-4 align-self-center">
                                <fieldset>
                                    <input type="text" name="search" placeholder="Rechercher une mission..." autocomplete="on" value="<?= htmlspecialchars($search ?? '') ?>">
                                </fieldset>
                            </div>
                            <div class="col-lg-4 align-self-center">
                                <fieldset>
                                    <select name="statut" aria-label="Statut">
                                        <option value="" <?= empty($statut) ? 'selected' : '' ?>>Tous les statuts</option>
                                        <option value="ouverte" <?= (isset($statut) && $statut == 'ouverte') ? 'selected' : '' ?>>Ouverte</option>
                                        <option value="en_cours" <?= (isset($statut) && $statut == 'en_cours') ? 'selected' : '' ?>>En cours</option>
                                        <option value="terminee" <?= (isset($statut) && $statut == 'terminee') ? 'selected' : '' ?>>Terminee</option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-lg-4">
                                <fieldset>
                                    <button type="submit" class="cyber-btn" style="width: 100%; justify-content: center;"><i class="fa fa-search"></i> Rechercher</button>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-10 offset-lg-1">
                <div class="cyber-categories">
                    <a href="index.php?action=front_create" class="cyber-cat-item">
                        <div class="cyber-cat-icon"><i class="fa fa-plus"></i></div>
                        <span class="cyber-cat-label">Publier Mission</span>
                    </a>
                    <a href="index.php?action=front_missions" class="cyber-cat-item">
                        <div class="cyber-cat-icon"><i class="fa fa-tasks"></i></div>
                        <span class="cyber-cat-label">Mes Missions</span>
                    </a>
                    <a href="index.php?action=front_candidatures" class="cyber-cat-item">
                        <div class="cyber-cat-icon"><i class="fa fa-user-check"></i></div>
                        <span class="cyber-cat-label">Mes Candidatures</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== Recent Missions ===== -->
<div style="padding: 60px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>Missions Recentess</h2>
                    <h6>Decouvrez les opportunites</h6>
                </div>
            </div>
            <div class="col-lg-12">
                <?php if (empty($missions)): ?>
                    <div class="cyber-empty">
                        <i class="fa fa-info-circle"></i>
                        <h4>Aucune mission disponible</h4>
                        <p>Revenez plus tard pour decouvrir de nouvelles opportunites.</p>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($missions as $mission): ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="cyber-card">
                                    <div class="cyber-card-image">
                                        <i class="fa fa-briefcase"></i>
                                    </div>
                                    <div class="cyber-card-body">
                                        <h4><a href="index.php?action=front_apply&id=<?php echo (int)$mission['id']; ?>"><?php echo htmlspecialchars($mission['titre']); ?></a></h4>
                                        <span class="cyber-badge cyber-badge-green" style="margin-bottom: 10px; display: inline-block;">
                                            <?php echo htmlspecialchars($mission['statut']); ?>
                                        </span>
                                        <p><?php echo htmlspecialchars(substr($mission['description'], 0, 100)) . '...'; ?></p>
                                        <div class="cyber-price" style="margin-bottom: 8px;">
                                            <i class="fa fa-euro" style="font-size: 14px;"></i> <?php echo number_format($mission['budget'], 0, ',', ' '); ?> EUR
                                        </div>
                                        <div class="cyber-meta">
                                            <i class="fa fa-calendar"></i> Du <?php echo date('d/m/Y', strtotime($mission['date_debut'])); ?> au <?php echo date('d/m/Y', strtotime($mission['date_fin'])); ?>
                                        </div>
                                        <?php if ($mission['competences']): ?>
                                            <div class="cyber-meta">
                                                <i class="fa fa-tools"></i> <?php echo htmlspecialchars($mission['competences']); ?>
                                            </div>
                                        <?php endif; ?>
                                        <div style="margin-top: 15px;">
                                            <a href="index.php?action=front_apply&id=<?php echo (int)$mission['id']; ?>" class="cyber-btn" style="font-size: 13px; padding: 10px 20px;"><i class="fa fa-paper-plane"></i> Postuler</a>
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
require_once 'layout.php';
?>