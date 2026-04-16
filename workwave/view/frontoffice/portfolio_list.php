<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Wave - Notre Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            padding: 1rem 2rem;
        }
        
        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .nav-link {
            color: #333;
            font-weight: 500;
            transition: 0.3s;
        }
        
        .nav-link:hover {
            color: #667eea;
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
            text-align: center;
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
        }
        
        .hero h1 {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }
        
        .hero p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        /* Section des projets */
        .projects-section {
            padding: 80px 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
            color: white;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            font-weight: bold;
        }
        
        .section-title p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        /* Cartes projets */
        .project-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 30px;
            height: 100%;
        }
        
        .project-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        
        .card-img-top {
            height: 200px;
            object-fit: cover;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .card-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #333;
        }
        
        .card-text {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        
        .tech-badge {
            display: inline-block;
            background: #f0f0f0;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            color: #667eea;
        }
        
        .btn-custom {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            transition: 0.3s;
        }
        
        .btn-custom:hover {
            transform: scale(1.05);
            color: white;
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .status-completed {
            background: #d4edda;
            color: #155724;
        }
        
        .status-progress {
            background: #fff3cd;
            color: #856404;
        }
        
        footer {
            background: #1a1a2e;
            color: white;
            padding: 40px 0;
            text-align: center;
        }
    </style>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">🌊 Work Wave</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#projects">Projets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#inprogress">En cours</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=login">Admin</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Notre Portfolio</h1>
        <p>Découvrez nos projets innovants qui façonnent l'avenir du travail digital</p>
    </div>
</section>

<!-- Projets terminés -->
<section id="projects" class="projects-section">
    <div class="container">
        <div class="section-title">
            <h2>✨ Projets Réalisés</h2>
            <p>Des solutions innovantes pour l'économie digitale</p>
        </div>
        <div class="row">
            <?php if (empty($projects)): ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info">Aucun projet terminé pour le moment.</div>
                </div>
            <?php else: ?>
                <?php foreach ($projects as $project): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="project-card">
                            <div class="card-img-top">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($project['title']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars(substr($project['description'], 0, 100)) ?>...</p>
                                <div class="mb-3">
                                    <?php 
                                    $techs = explode(',', $project['technologies']);
                                    foreach ($techs as $tech): 
                                    ?>
                                        <span class="tech-badge"><?= htmlspecialchars(trim($tech)) ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <span class="status-badge status-completed">
                                    <i class="fas fa-check-circle"></i> Terminé
                                </span>
                                <div class="mt-3">
                                    <a href="index.php?action=front-detail&id=<?= $project['id'] ?>" class="btn btn-custom">
                                        Voir détails <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Projets en cours -->
<section id="inprogress" class="projects-section" style="background: rgba(0,0,0,0.05);">
    <div class="container">
        <div class="section-title">
            <h2>🚧 Projets en Cours</h2>
            <p>Des innovations en développement</p>
        </div>
        <div class="row">
            <?php if (empty($inProgress)): ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info">Aucun projet en cours pour le moment.</div>
                </div>
            <?php else: ?>
                <?php foreach ($inProgress as $project): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="project-card">
                            <div class="card-img-top">
                                <i class="fas fa-spinner fa-pulse"></i>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($project['title']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars(substr($project['description'], 0, 100)) ?>...</p>
                                <div class="mb-3">
                                    <?php 
                                    $techs = explode(',', $project['technologies']);
                                    foreach ($techs as $tech): 
                                    ?>
                                        <span class="tech-badge"><?= htmlspecialchars(trim($tech)) ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <span class="status-badge status-progress">
                                    <i class="fas fa-clock"></i> En cours
                                </span>
                                <div class="mt-3">
                                    <a href="index.php?action=front-detail&id=<?= $project['id'] ?>" class="btn btn-custom">
                                        Voir détails <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="container">
        <p>&copy; 2024 Work Wave - Plateforme intelligente pour l'avenir du travail</p>
        <p>Économie digitale & Entrepreneuriat moderne</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>