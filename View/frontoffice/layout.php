<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Wave</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
            text-align: center;
        }
        .mission-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .mission-card:hover {
            transform: translateY(-5px);
        }
        .statut-badge {
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-briefcase"></i> Work Wave
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php?action=missions">
                    <i class="fas fa-home"></i> Accueil
                </a>
                <a class="nav-link" href="index.php?action=front_create">
                    <i class="fas fa-plus-circle"></i> Publier
                </a>
                <a class="nav-link" href="index.php?action=index">
                    <i class="fas fa-cog"></i> Administration
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php echo $content; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo isset($extraJs) ? $extraJs : ''; ?>
</body>
</html>