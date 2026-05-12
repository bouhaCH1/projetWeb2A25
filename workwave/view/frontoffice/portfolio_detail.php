<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Work Wave - <?= htmlspecialchars($portfolio['title'] ?? 'Détail') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="view/assets/css/galaxy.css">
</head>
<body>
    <div class="bg-galaxy"></div>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">🌊 Work Wave</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?action=login">Espace membre</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container detail-container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <?php if (!$portfolio || $portfolio['is_approved'] != 1): ?>
                <div class="alert alert-secondary">Portfolio non disponible</div>
            <?php else: ?>
                <div class="detail-card">
                    <div class="detail-header">
                        <h1><?= htmlspecialchars($portfolio['title']) ?></h1>
                        <p class="mb-0">Par <?= htmlspecialchars($portfolio['submitted_by']) ?> | <?= htmlspecialchars($portfolio['company_name'] ?? 'Indépendant') ?></p>
                    </div>
                    <div class="detail-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h4>Description</h4>
                                <p><?= nl2br(htmlspecialchars($portfolio['description'])) ?></p>
                                
                                <h4 class="mt-4">Technologies</h4>
                                <div>
                                    <?php 
                                    $techs = explode(',', $portfolio['technologies']);
                                    foreach ($techs as $tech): 
                                    ?>
                                        <span class="tech-badge"><?= htmlspecialchars(trim($tech)) ?></span>
                                    <?php endforeach; ?>
                                </div>
                                
                                <h4 class="mt-4">Catégorie</h4>
                                <p><span class="badge bg-primary"><?= htmlspecialchars($portfolio['category']) ?></span></p>
                                
                                <?php if ($portfolio['project_url']): ?>
                                    <a href="<?= htmlspecialchars($portfolio['project_url']) ?>" target="_blank" class="btn btn-outline-primary mt-3">
                                        <i class="fas fa-external-link-alt"></i> Voir le projet
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <i class="fas fa-user-circle" style="font-size: 4rem; color: #e0e0e0;"></i>
                                        <h5 class="mt-2"><?= htmlspecialchars($portfolio['submitted_by']) ?></h5>
                                        <hr>
                                        <button class="contact-btn" onclick="alert('Connectez-vous pour contacter ce talent')">
                                            <i class="fas fa-envelope"></i> Contacter
                                        </button>
                                        <p class="small text-muted mt-3">
                                            <i class="fas fa-shield-alt"></i> Portfolio vérifié
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<footer>
    <div class="container">
        <p>&copy; 2024 Work Wave - La plateforme qui connecte talents et entreprises</p>
    </div>
</footer>
</body>
</html>