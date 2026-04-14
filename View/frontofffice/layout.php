<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkFuture — Plateforme de Missions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f8f9fa; }

        /* NAVBAR */
        .navbar {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            padding: 15px 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.3);
        }
        .navbar-brand {
            color: #fff !important;
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: 1px;
        }
        .navbar-brand span { color: #4cc9f0; }
        .nav-link { color: rgba(255,255,255,0.8) !important; font-weight: 500; transition: color 0.3s; }
        .nav-link:hover { color: #4cc9f0 !important; }
        .btn-nav {
            background: #4cc9f0;
            color: #1a1a2e !important;
            font-weight: 700;
            border-radius: 25px;
            padding: 8px 20px !important;
        }
        .btn-nav:hover { background: #3ab7dc; }

        /* HERO */
        .hero {
            background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 50%, #16213e 100%);
            color: white;
            padding: 100px 0 80px;
            text-align: center;
        }
        .hero h1 { font-size: 3rem; font-weight: 800; margin-bottom: 20px; }
        .hero h1 span { color: #4cc9f0; }
        .hero p { font-size: 1.2rem; color: rgba(255,255,255,0.75); max-width: 600px; margin: 0 auto 35px; }
        .hero-btn {
            background: #4cc9f0;
            color: #1a1a2e;
            font-weight: 700;
            border: none;
            padding: 14px 35px;
            border-radius: 30px;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.3s;
        }
        .hero-btn:hover { background: #3ab7dc; transform: translateY(-2px); color: #1a1a2e; }

        /* STATS */
        .stats-bar {
            background: white;
            padding: 25px 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .stat-item { text-align: center; }
        .stat-item .number { font-size: 2rem; font-weight: 800; color: #4cc9f0; }
        .stat-item .label { color: #666; font-size: 0.9rem; }

        /* CARDS */
        .section-title { font-weight: 800; color: #1a1a2e; font-size: 2rem; }
        .mission-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
            height: 100%;
        }
        .mission-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.15);
        }
        .card-accent {
            height: 5px;
            background: linear-gradient(90deg, #4cc9f0, #0f3460);
        }
        .mission-card .card-body { padding: 25px; }
        .mission-card .card-title { font-weight: 700; color: #1a1a2e; font-size: 1.1rem; }
        .mission-card .budget { font-size: 1.3rem; font-weight: 800; color: #4cc9f0; }
        .badge-ouverte  { background: #d4edda; color: #155724; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; }
        .badge-en_cours { background: #fff3cd; color: #856404; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; }
        .badge-terminee { background: #f8d7da; color: #721c24; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; }
        .btn-postuler {
            background: linear-gradient(135deg, #1a1a2e, #0f3460);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 8px 20px;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-postuler:hover { background: #4cc9f0; color: #1a1a2e; }

        /* FOOTER */
        footer {
            background: #1a1a2e;
            color: rgba(255,255,255,0.6);
            padding: 30px 0;
            text-align: center;
        }
        footer span { color: #4cc9f0; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">🚀 Work<span>Future</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?action=missions">Missions</a></li>
                <li class="nav-item"><a class="nav-link btn-nav ms-2" href="backoffice/index.php">
                    <i class="fas fa-lock me-1"></i> Admin
                </a></li>
            </ul>
        </div>
    </div>
</nav>

<?= $content ?>

<footer>
    <div class="container">
        <p>© 2024 <span>WorkFuture</span> — Plateforme intelligente pour l'avenir du travail</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>