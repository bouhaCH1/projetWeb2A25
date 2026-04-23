<?php
ob_start();
?>

<?php if (isset($_GET['applied'])): ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success" style="background: #00bdfe; color: white; border: none; border-radius: 10px; padding: 15px;">
                <i class="fa fa-check-circle"></i> Candidature envoyée avec succès.
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- ***** Main Banner Area Start ***** -->
<div class="main-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="top-text header-text">
                    <h6>Plusieurs Missions Disponibles</h6>
                    <h2>Trouvez la mission parfaite pour vos compétences</h2>
                </div>
            </div>
            <div class="col-lg-12">
                <form id="search-form" name="gs" method="get" role="search" action="index.php">
                    <input type="hidden" name="action" value="missions">
                    <div class="row">
                        <div class="col-lg-4 align-self-center">
                            <fieldset>
                                <input type="text" name="search" class="searchText" placeholder="Rechercher une mission..." autocomplete="on">
                            </fieldset>
                        </div>
                        <div class="col-lg-4 align-self-center">
                            <fieldset>
                                <select name="statut" class="form-select" aria-label="Statut">
                                    <option selected value="">Tous les statuts</option>
                                    <option value="ouverte">Ouverte</option>
                                    <option value="en_cours">En cours</option>
                                    <option value="terminee">Terminée</option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-lg-4">
                            <fieldset>
                                <button class="main-button"><i class="fa fa-search"></i> Rechercher</button>
                            </fieldset>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-10 offset-lg-1">
                <ul class="categories" style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; margin-top: 30px;">
                    <li><a href="index.php?action=front_create" style="display: flex; flex-direction: column; align-items: center; text-decoration: none; transition: all 0.3s ease; padding: 15px;"><span class="icon" style="background: linear-gradient(135deg, #00bdfe 0%, #2b2b2b 100%); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 10px; box-shadow: 0 5px 15px rgba(0, 189, 254, 0.3); transition: all 0.3s ease;"><i class="fa fa-plus" style="font-size: 24px; color: white;"></i></span> <span style="font-weight: 600; color: #fff; font-size: 14px;">Publier Mission</span></a></li>
                    <li><a href="index.php?action=front_missions" style="display: flex; flex-direction: column; align-items: center; text-decoration: none; transition: all 0.3s ease; padding: 15px;"><span class="icon" style="background: linear-gradient(135deg, #00bdfe 0%, #2b2b2b 100%); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 10px; box-shadow: 0 5px 15px rgba(0, 189, 254, 0.3); transition: all 0.3s ease;"><i class="fa fa-tasks" style="font-size: 24px; color: white;"></i></span> <span style="font-weight: 600; color: #fff; font-size: 14px;">Mes Missions</span></a></li>
                    <li><a href="index.php?action=front_candidatures" style="display: flex; flex-direction: column; align-items: center; text-decoration: none; transition: all 0.3s ease; padding: 15px;"><span class="icon" style="background: linear-gradient(135deg, #00bdfe 0%, #2b2b2b 100%); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 10px; box-shadow: 0 5px 15px rgba(0, 189, 254, 0.3); transition: all 0.3s ease;"><i class="fa fa-user-check" style="font-size: 24px; color: white;"></i></span> <span style="font-weight: 600; color: #fff; font-size: 14px;">Mes Candidatures</span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- ***** Main Banner Area End ***** -->

<!-- ***** Popular Missions Area Start ***** -->
<?php if (!empty($popularMissions)): ?>
<div class="recent-listing" style="background: linear-gradient(135deg, #00bdfe 0%, #2b2b2b 100%); padding: 40px 0; margin-bottom: 30px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading" style="text-align: center;">
                    <h2 style="color: white;">🔥 Missions Populaires</h2>
                    <h6 style="color: rgba(255,255,255,0.8);">Les missions les plus demandées</h6>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <?php foreach ($popularMissions as $mission): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="listing-item" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.3); transform: translateY(0); transition: all 0.3s ease;">
                                <div style="position: absolute; top: 15px; right: 15px; background: #ff6b6b; color: white; padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: 600; z-index: 10;">
                                    <i class="fa fa-fire"></i> <?= $mission['application_count'] ?> candidatures
                                </div>
                                <div class="left-image" style="height: 180px; background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%); display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-fire" style="font-size: 48px; color: rgba(255,255,255,0.3);"></i>
                                </div>
                                <div class="right-content align-self-center" style="padding: 20px;">
                                    <a href="index.php?action=front_apply&id=<?= (int)$mission['id'] ?>">
                                        <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 10px; color: #2b2b2b;"><?= htmlspecialchars($mission['titre']) ?></h4>
                                    </a>
                                    <h6 style="color: #ff6b6b; margin-bottom: 10px;">
                                        <span class="badge" style="background: #ff6b6b; color: white; padding: 5px 10px; border-radius: 20px;">
                                            <?= htmlspecialchars($mission['statut']) ?>
                                        </span>
                                    </h6>
                                    <p style="color: #666; font-size: 14px; margin-bottom: 15px;">
                                        <?= htmlspecialchars(substr($mission['description'], 0, 80)) . '...'; ?>
                                    </p>
                                    <span class="price" style="display: block; margin-bottom: 10px;">
                                        <div class="icon" style="display: inline-block; margin-right: 5px;"><i class="fa fa-euro" style="color: #ff6b6b;"></i></div>
                                        <?= htmlspecialchars($mission['budget']) ?>
                                    </span>
                                    <a href="index.php?action=front_apply&id=<?= (int)$mission['id'] ?>" class="main-button" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%); color: white; text-decoration: none; display: inline-block; padding: 10px 20px; border-radius: 25px; font-size: 13px; font-weight: 600;">
                                        Postuler
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<!-- ***** Popular Missions Area End ***** -->

<!-- ***** Recent Missions Area Start ***** -->
<div class="recent-listing">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>Missions Récentes</h2>
                    <h6>Découvrez les opportunités</h6>
                </div>
            </div>
            <div class="col-lg-12">
                <?php if (empty($missions)): ?>
                    <div class="text-center" style="padding: 50px;">
                        <i class="fa fa-info-circle" style="font-size: 48px; color: #00bdfe; margin-bottom: 20px;"></i>
                        <h4>Aucune mission disponible</h4>
                        <p>Revenez plus tard pour découvrir de nouvelles opportunités.</p>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($missions as $mission): ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="listing-item" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                                    <div class="left-image" style="height: 200px; background: linear-gradient(135deg, #00bdfe 0%, #2b2b2b 100%); display: flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-briefcase" style="font-size: 48px; color: rgba(255,255,255,0.3);"></i>
                                    </div>
                                    <div class="right-content align-self-center" style="padding: 20px;">
                                        <a href="index.php?action=front_apply&id=<?php echo (int)$mission['id']; ?>">
                                            <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 10px;"><?php echo htmlspecialchars($mission['titre']); ?></h4>
                                        </a>
                                        <h6 style="color: #00bdfe; margin-bottom: 10px;">
                                            <span class="badge" style="background: #00bdfe; color: white; padding: 5px 10px; border-radius: 20px;">
                                                <?php echo htmlspecialchars($mission['statut']); ?>
                                            </span>
                                        </h6>
                                        <p style="color: #666; font-size: 14px; margin-bottom: 15px;">
                                            <?php echo htmlspecialchars(substr($mission['description'], 0, 100)) . '...'; ?>
                                        </p>
                                        <span class="price" style="display: block; margin-bottom: 10px;">
                                            <div class="icon" style="display: inline-block; margin-right: 5px;"><i class="fa fa-euro" style="color: #00bdfe;"></i></div>
                                            <strong><?php echo number_format($mission['budget'], 0, ',', ' '); ?> €</strong>
                                        </span>
                                        <span class="details" style="display: block; margin-bottom: 10px; font-size: 13px; color: #888;">
                                            <i class="fa fa-calendar"></i> Du <?php echo date('d/m/Y', strtotime($mission['date_debut'])); ?> au <?php echo date('d/m/Y', strtotime($mission['date_fin'])); ?>
                                        </span>
                                        <?php if ($mission['competences']): ?>
                                            <p style="font-size: 13px; color: #666; margin-bottom: 15px;">
                                                <i class="fa fa-tools"></i> <?php echo htmlspecialchars($mission['competences']); ?>
                                            </p>
                                        <?php endif; ?>
                                        <div class="main-white-button" style="margin-top: 10px;">
                                            <a href="index.php?action=front_apply&id=<?php echo (int)$mission['id']; ?>"><i class="fa fa-paper-plane"></i> Postuler</a>
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
<!-- ***** Recent Missions Area End ***** -->

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>