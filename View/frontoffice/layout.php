<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Wave</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="../View/tempatemo_style.css" rel="stylesheet">
</head>
<body>
    <div class="front-animated-bg" aria-hidden="true">
        <i class="fas fa-laptop-code icon i1"></i>
        <i class="fas fa-briefcase icon i2"></i>
        <i class="fas fa-bullhorn icon i3"></i>
        <i class="fas fa-chart-line icon i4"></i>
        <i class="fas fa-users icon i5"></i>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark forge-nav">
        <div class="container forge-nav-container">
            <a class="navbar-brand forge-logo" href="index.php?action=missions">
                <span class="forge-mark"><i class="fas fa-desktop"></i></span> WORK WAVE
            </a>
            <div class="navbar-nav ms-auto forge-nav-links">
                <a class="nav-link" href="index.php?action=missions"><i class="fas fa-briefcase"></i> Missions</a>
                <a class="nav-link" href="index.php?action=front_create"><i class="fas fa-bullhorn"></i> Publier</a>
                <a class="nav-link" href="index.php?action=index"><i class="fas fa-user-shield"></i> Admin</a>
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