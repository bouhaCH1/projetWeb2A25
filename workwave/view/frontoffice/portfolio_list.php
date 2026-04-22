<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Work Wave - Plateforme de talents</title>
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
                <li class="nav-item"><a class="nav-link" href="index.php?action=register">S'inscrire</a></li>
            </ul>
        </div>
    </div>
</nav>

<section class="hero">
    <div class="container">
        <h1>Découvrez les talents de demain</h1>
        <p>Des portfolios validés par notre équipe pour les entreprises innovantes</p>
        <a href="index.php?action=register" class="btn btn-light btn-lg mt-3">Rejoindre la communauté</a>
    </div>
</section>

<section class="container py-5">
    <h2 class="text-center mb-5">✨ Portfolios mis en avant</h2>
    <div class="row">
        <?php if (empty($portfolios)): ?>
            <div class="col-12 text-center">
                <div class="alert alert-primary">Aucun portfolio disponible pour le moment.</div>
            </div>
        <?php else: ?>
            <?php foreach ($portfolios as $p): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="portfolio-card" onclick="window.location.href='index.php?action=front-detail&id=<?= $p['id'] ?>'">
                        <div class="card-img-top">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <div class="p-3">
                            <h5><?= htmlspecialchars($p['title']) ?></h5>
                            <p class="small text-muted">Par <?= htmlspecialchars($p['submitted_by']) ?></p>
                            <p class="small"><?= htmlspecialchars(substr($p['description'], 0, 100)) ?>...</p>
                            <div>
                                <?php 
                                $techs = explode(',', $p['technologies']);
                                foreach (array_slice($techs, 0, 2) as $tech): 
                                ?>
                                    <span class="tech-badge"><?= htmlspecialchars(trim($tech)) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<footer>
    <div class="container">
        <p>&copy; 2024 Work Wave - La plateforme qui connecte talents et entreprises</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>