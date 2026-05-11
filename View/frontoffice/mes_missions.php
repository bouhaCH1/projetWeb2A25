<?php
$pageTitle = 'mes_missions';
require_once __DIR__ . '/../layout/pl_dashboard_header.php';
?>

<?php if (isset($_GET['success'])): ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="cyber-alert cyber-alert-success">
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
            <div class="cyber-alert cyber-alert-success">
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
            <div class="cyber-alert cyber-alert-warning">
                <i class="fa fa-check-circle"></i> Mission supprimée avec succès.
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
                    Mes Missions Publiées
                </h1>
                <p style="color: rgba(255,255,255,0.7); font-size: 16px; margin-bottom: 20px;">
                    Gérez toutes vos missions freelance en un seul endroit
                </p>
            </div>
            <div class="col-lg-4 text-end">
                <a href="/workwave/Controller/index.php?action=front_create" class="cyber-btn">
                    <i class="fa fa-plus"></i> Nouvelle Mission
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Missions List -->
<section style="padding: 40px 0;">
    <div class="container">
        <?php if (empty($missions)): ?>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="cyber-card" style="text-align: center; padding: 60px 30px;">
                        <i class="fa fa-info-circle" style="font-size: 64px; color: rgba(0, 255, 204, 0.3); margin-bottom: 20px;"></i>
                        <h4 style="color: #ffffff; margin-bottom: 10px;">Aucune mission publiée</h4>
                        <p style="color: rgba(255,255,255,0.6); margin-bottom: 20px;">Commencez par publier votre première mission.</p>
                        <a href="/workwave/Controller/index.php?action=front_create" class="cyber-btn">
                            <i class="fa fa-bullhorn"></i> Publier une mission
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($missions as $mission): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="cyber-card">
                            <div style="height: 120px; background: linear-gradient(135deg, rgba(0, 255, 204, 0.1), rgba(0, 204, 255, 0.1)); display: flex; align-items: center; justify-content: center; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                                <i class="fa fa-briefcase" style="font-size: 40px; color: rgba(0, 255, 204, 0.3);"></i>
                            </div>
                            <div style="padding: 20px;">
                                <h4 style="color: #ffffff; font-size: 16px; font-weight: 600; margin-bottom: 10px;">
                                    <?php echo htmlspecialchars($mission['titre']); ?>
                                </h4>
                                <p style="color: rgba(255,255,255,0.6); font-size: 13px; margin-bottom: 12px; line-height: 1.5;">
                                    <?php echo htmlspecialchars(substr($mission['description'], 0, 80)) . '...'; ?>
                                </p>
                                <div style="margin-bottom: 12px;">
                                    <span class="cyber-badge cyber-badge-green" style="margin-right: 5px;">
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
                                    <span class="cyber-badge cyber-badge-blue" style="margin-right: 5px;">
                                        <?php echo $categorieLabels[$categorie] ?? $categorie; ?>
                                    </span>
                                    <?php endif; ?>
                                    <?php 
                                    $niveauLabels = [
                                        'debutant' => 'Débutant',
                                        'intermediaire' => 'Intermédiaire',
                                        'avance' => 'Avancé',
                                        'expert' => 'Expert'
                                    ];
                                    $niveau = $mission['niveau'] ?? '';
                                    if ($niveau): ?>
                                    <span class="cyber-badge cyber-badge-purple">
                                        <?php echo $niveauLabels[$niveau] ?? $niveau; ?>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div style="color: rgba(255,255,255,0.5); font-size: 12px; margin-bottom: 10px;">
                                    <i class="fa fa-calendar"></i> <?php echo date('d/m/Y', strtotime($mission['date_debut'])); ?> - <?php echo date('d/m/Y', strtotime($mission['date_fin'])); ?>
                                </div>
                                <div style="color: #00ffcc; font-weight: 700; font-size: 16px; margin-bottom: 15px;">
                                    <i class="fa fa-euro" style="font-size: 12px;"></i> <?php echo number_format($mission['budget'], 0, ',', ' '); ?>
                                </div>
                                <div style="display: flex; gap: 10px;">
                                    <a href="/workwave/Controller/index.php?action=front_edit&id=<?php echo $mission['id']; ?>" class="cyber-btn" style="flex: 1; justify-content: center; font-size: 13px; padding: 10px;">
                                        <i class="fa fa-edit"></i> Modifier
                                    </a>
                                    <a href="/workwave/Controller/index.php?action=front_delete&id=<?php echo $mission['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette mission ?')" style="padding: 10px 15px; border-radius: 25px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; background: linear-gradient(135deg, #ff6b6b, #ff8e53); color: #ffffff;">
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

