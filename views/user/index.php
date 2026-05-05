<?php // views/user/index.php ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - Events & Resources</title>
    <link rel="stylesheet" href="../templatemo_602_graph_page/templatemo-graph-page.css">
    <style>
        .table-custom { width: 100%; border-collapse: collapse; margin-bottom: 30px; color: #fff; }
        .table-custom th, .table-custom td { padding: 12px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .table-custom th { background-color: rgba(255,255,255,0.05); font-weight: 600; color: #00ffcc; }
        .table-custom tr:hover { background-color: rgba(255,255,255,0.02); }
    </style>
</head>
<body>
    <nav id="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo"><span class="logo-text">My Project</span></a>
            <ul class="nav-links">
                <li><a href="index.php" class="active">Page Utilisateur</a></li>
                <li><a href="index.php?action=admin">Page Admin</a></li>
            </ul>
        </div>
    </nav>

    <section class="dashboard-section" style="padding-top: 120px; min-height: 100vh;">
        <div class="dashboard-container">
            <h2 class="section-title">Bienvenue sur la page Utilisateur</h2>

            <h3 style="color: #fff; margin-bottom: 15px;">Liste des Événements</h3>
            <div style="background: rgba(255,255,255,0.05); border-radius: 15px; padding: 20px; margin-bottom: 40px; border: 1px solid rgba(255,255,255,0.1);">
                <table class="table-custom">
                    <tr><th>ID</th><th>Titre</th><th>Date</th><th>Lieu</th></tr>
                    <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?= htmlspecialchars($event['id']) ?></td>
                        <td><?= htmlspecialchars($event['title']) ?></td>
                        <td><?= htmlspecialchars($event['date']) ?></td>
                        <td><?= htmlspecialchars($event['location']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>

            <h3 style="color: #fff; margin-bottom: 15px;">Liste des Ressources</h3>
            <div style="background: rgba(255,255,255,0.05); border-radius: 15px; padding: 20px; margin-bottom: 40px; border: 1px solid rgba(255,255,255,0.1);">
                <table class="table-custom">
                    <tr><th>ID</th><th>Nom</th><th>Type</th><th>Quantité</th></tr>
                    <?php foreach ($resources as $res): ?>
                    <tr>
                        <td><?= htmlspecialchars($res['id']) ?></td>
                        <td><?= htmlspecialchars($res['name']) ?></td>
                        <td><?= htmlspecialchars($res['type']) ?></td>
                        <td><?= htmlspecialchars($res['quantity']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <p class="copyright">© 2026 My Project. All rights reserved.</p>
        </div>
    </footer>
    <script src="../templatemo_602_graph_page/templatemo-graph-script.js"></script>
</body>
</html>
