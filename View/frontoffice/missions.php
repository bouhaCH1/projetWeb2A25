<?php
ob_start();
?>

<?php if (isset($_GET['applied'])): ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="cyber-alert cyber-alert-success">
                <i class="fa fa-check-circle"></i> Candidature envoyée avec succès.
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Hero Section -->
<section class="hero" style="min-height: 60vh; padding: 100px 0 60px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 style="font-size: 48px; font-weight: 700; margin-bottom: 20px; background: linear-gradient(135deg, #00ffcc, #00ccff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    Trouvez la mission<br>parfaite pour vous
                </h1>
                <p style="color: rgba(255,255,255,0.7); font-size: 18px; margin-bottom: 30px; line-height: 1.6;">
                    Découvrez des opportunités freelance exceptionnelles et faites avancer votre carrière
                </p>
            </div>
            <div class="col-lg-6">
                <form method="get" action="index.php">
                    <input type="hidden" name="action" value="missions">
                    <div class="cyber-search">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="search" placeholder="Rechercher une mission..." value="<?= htmlspecialchars($search ?? '') ?>">
                            </div>
                            <div class="col-md-4">
                                <select name="statut">
                                    <option value="">Tous les statuts</option>
                                    <option value="ouverte" <?= (isset($statut) && $statut == 'ouverte') ? 'selected' : '' ?>>Ouverte</option>
                                    <option value="en_cours" <?= (isset($statut) && $statut == 'en_cours') ? 'selected' : '' ?>>En cours</option>
                                    <option value="terminee" <?= (isset($statut) && $statut == 'terminee') ? 'selected' : '' ?>>Terminée</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="cyber-btn" style="width: 100%;">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Quick Actions -->
<section style="padding: 40px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="row g-4">
                    <div class="col-md-4">
                        <a href="index.php?action=front_create" style="text-decoration: none;">
                            <div class="cyber-card" style="text-align: center; padding: 30px;">
                                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #00ffcc, #00ccff); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                                    <i class="fa fa-plus" style="color: #0a0e27; font-size: 24px;"></i>
                                </div>
                                <h5 style="color: #ffffff; margin-bottom: 5px;">Publier</h5>
                                <p style="color: rgba(255,255,255,0.6); font-size: 14px; margin: 0;">Créer une mission</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="index.php?action=front_missions" style="text-decoration: none;">
                            <div class="cyber-card" style="text-align: center; padding: 30px;">
                                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #00ffcc, #00ccff); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                                    <i class="fa fa-tasks" style="color: #0a0e27; font-size: 24px;"></i>
                                </div>
                                <h5 style="color: #ffffff; margin-bottom: 5px;">Mes Missions</h5>
                                <p style="color: rgba(255,255,255,0.6); font-size: 14px; margin: 0;">Gérer mes missions</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="index.php?action=front_candidatures" style="text-decoration: none;">
                            <div class="cyber-card" style="text-align: center; padding: 30px;">
                                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #00ffcc, #00ccff); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                                    <i class="fa fa-user-check" style="color: #0a0e27; font-size: 24px;"></i>
                                </div>
                                <h5 style="color: #ffffff; margin-bottom: 5px;">Candidatures</h5>
                                <p style="color: rgba(255,255,255,0.6); font-size: 14px; margin: 0;">Voir mes candidatures</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Missions List -->
<section style="padding: 60px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading" style="text-align: center; margin-bottom: 30px;">
                    <h2>Missions Disponibles</h2>
                    <h6>Découvrez les opportunités</h6>
                </div>
                
                <!-- Modern Cyber Filter & Sort Bar -->
                <div style="background: rgba(10, 14, 39, 0.6); backdrop-filter: blur(20px); border: 1px solid rgba(0, 255, 204, 0.2); border-radius: 20px; padding: 25px; margin-bottom: 50px; box-shadow: 0 15px 35px rgba(0,0,0,0.4);">
                    <form method="GET" action="index.php" class="row g-4 align-items-center">
                        <input type="hidden" name="action" value="missions">
                        
                        <!-- Search Box -->
                        <div class="col-lg-5">
                            <div style="position: relative;">
                                <i class="fa fa-search" style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: #00ffcc; opacity: 0.7;"></i>
                                <input type="text" name="search" 
                                    style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 15px; padding: 15px 15px 15px 50px; color: #fff; outline: none; transition: all 0.3s;"
                                    placeholder="Rechercher un projet ou une compétence..." 
                                    onfocus="this.style.borderColor='#00ffcc'; this.style.boxShadow='0 0 15px rgba(0,255,204,0.1)';"
                                    onblur="this.style.borderColor='rgba(255,255,255,0.1)';"
                                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                            </div>
                        </div>

                        <!-- Sort Toggle -->
                        <div class="col-lg-4">
                            <div class="d-flex align-items-center" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 15px; padding: 5px 15px;">
                                <i class="fa fa-sort-alpha-down" style="color: #00ffcc; margin-right: 15px;"></i>
                                <select name="sort" onchange="this.form.submit()" 
                                    style="background: transparent; border: none; color: #fff; padding: 10px; width: 100%; outline: none; cursor: pointer; font-size: 14px; font-weight: 600;">
                                    <option value="date_desc" style="background: #0a0e27;" <?= (($_GET['sort'] ?? '') === 'date_desc') ? 'selected' : '' ?>>Plus récents</option>
                                    <option value="title_asc" style="background: #0a0e27;" <?= (($_GET['sort'] ?? '') === 'title_asc') ? 'selected' : '' ?>>Ordre A-Z</option>
                                    <option value="title_desc" style="background: #0a0e27;" <?= (($_GET['sort'] ?? '') === 'title_desc') ? 'selected' : '' ?>>Ordre Z-A</option>
                                </select>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="col-lg-3">
                            <div class="d-flex gap-2">
                                <button type="submit" class="cyber-btn" style="flex: 1; padding: 12px; font-size: 14px;">
                                    <i class="fa fa-filter me-2"></i> Filtrer
                                </button>
                                <?php if(!empty($_GET['search']) || !empty($_GET['sort'])): ?>
                                    <a href="index.php?action=missions" class="btn" 
                                       style="width: 45px; height: 45px; border-radius: 12px; background: rgba(255,107,107,0.1); border: 1px solid rgba(255,107,107,0.2); color: #ff6b6b; display: flex; align-items: center; justify-content: center; transition: 0.3s;"
                                       onmouseover="this.style.background='rgba(255,107,107,0.2)'"
                                       onmouseout="this.style.background='rgba(255,107,107,0.1)'"
                                       title="Réinitialiser">
                                        <i class="fa fa-times"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php if (empty($missions)): ?>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="cyber-card" style="text-align: center; padding: 60px 30px;">
                        <i class="fa fa-info-circle" style="font-size: 64px; color: rgba(0, 255, 204, 0.3); margin-bottom: 20px;"></i>
                        <h4 style="color: #ffffff; margin-bottom: 10px;">Aucune mission disponible</h4>
                        <p style="color: rgba(255,255,255,0.6); margin-bottom: 20px;">Revenez plus tard pour découvrir de nouvelles opportunités.</p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($missions as $mission): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="cyber-card">
                            <div style="height: 150px; background: linear-gradient(135deg, rgba(0, 255, 204, 0.1), rgba(0, 204, 255, 0.1)); display: flex; align-items: center; justify-content: center; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                                <i class="fa fa-briefcase" style="font-size: 48px; color: rgba(0, 255, 204, 0.3);"></i>
                            </div>
                            <div style="padding: 25px;">
                                <h4 style="color: #ffffff; font-size: 18px; font-weight: 600; margin-bottom: 15px;">
                                    <a href="index.php?action=front_apply&id=<?php echo (int)$mission['id']; ?>" style="color: #ffffff; text-decoration: none; transition: color 0.3s;">
                                        <?php echo htmlspecialchars($mission['titre']); ?>
                                    </a>
                                </h4>
                                <div style="margin-bottom: 15px;">
                                    <span class="cyber-badge cyber-badge-green">
                                        <?php echo htmlspecialchars($mission['statut']); ?>
                                    </span>
                                    <?php 
                                    $categorieLabels = [
                                        'developpement' => 'Développement Web',
                                        'mobile' => 'Mobile',
                                        'design' => 'Design',
                                        'marketing' => 'Marketing',
                                        'data' => 'Data',
                                        'autre' => 'Autre'
                                    ];
                                    $categorie = $mission['categorie'] ?? '';
                                    if ($categorie): ?>
                                    <span class="cyber-badge cyber-badge-blue" style="margin-left: 5px;">
                                        <?php echo $categorieLabels[$categorie] ?? $categorie; ?>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <p style="color: rgba(255,255,255,0.7); font-size: 14px; margin-bottom: 15px; line-height: 1.6;">
                                    <?php echo htmlspecialchars(substr($mission['description'], 0, 100)) . '...'; ?>
                                </p>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                                    <div style="color: #00ffcc; font-weight: 700; font-size: 18px;">
                                        <i class="fa fa-euro" style="font-size: 14px;"></i> <?php echo number_format($mission['budget'], 0, ',', ' '); ?>
                                    </div>
                                    <div style="color: rgba(255,255,255,0.5); font-size: 13px;">
                                        <i class="fa fa-calendar"></i> <?php echo date('d/m/Y', strtotime($mission['date_debut'])); ?>
                                    </div>
                                </div>
                                <?php if ($mission['competences']): ?>
                                    <div style="color: rgba(255,255,255,0.5); font-size: 13px; margin-bottom: 15px;">
                                        <i class="fa fa-tools"></i> <?php echo htmlspecialchars($mission['competences']); ?>
                                    </div>
                                <?php endif; ?>
                                <a href="index.php?action=front_apply&id=<?php echo (int)$mission['id']; ?>" class="cyber-btn" style="width: 100%; justify-content: center;">
                                    <i class="fa fa-paper-plane"></i> Postuler
                                </a>
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
require_once 'layout.php';
?>