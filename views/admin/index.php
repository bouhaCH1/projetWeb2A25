<?php // views/admin/index.php ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion Events & Resources</title>
    <link rel="stylesheet" href="../templatemo_602_graph_page/templatemo-graph-page.css">
    <style>
        .table-custom { width: 100%; border-collapse: collapse; margin-bottom: 30px; color: #fff; }
        .table-custom th, .table-custom td { padding: 12px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .table-custom th { background-color: rgba(255,255,255,0.05); font-weight: 600; color: #ff6b6b; }
        .table-custom tr:hover { background-color: rgba(255,255,255,0.02); }
        .action-link { color: #00ffcc; text-decoration: none; margin-right: 10px; }
        .action-link.delete { color: #ff6b6b; }
        .action-link:hover { text-decoration: underline; }
        .btn-create { display: inline-block; background-color: #00ffcc; color: #111; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold; margin-bottom: 15px; }
        .btn-create:hover { background-color: #00ccaa; }
    </style>
</head>
<body>
    <nav id="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo"><span class="logo-text">My Project</span></a>
            <ul class="nav-links">
                <li><a href="index.php">Page Utilisateur</a></li>
                <li><a href="index.php?action=admin" class="active">Page Admin</a></li>
            </ul>
        </div>
    </nav>

    <section class="dashboard-section" style="padding-top: 120px; min-height: 100vh;">
        <div class="dashboard-container">
            <h2 class="section-title">Bienvenue sur la page Admin</h2>

            <h3 style="color: #fff; margin-bottom: 15px; display: inline-block;">Gestion des Événements</h3>
            <a href="index.php?action=form_event" class="btn-create" style="float: right;">+ Créer un Événement</a>

            <div style="clear: both; background: rgba(255,255,255,0.05); border-radius: 15px; padding: 20px; margin-bottom: 40px; border: 1px solid rgba(255,255,255,0.1);">
                <table class="table-custom">
                    <tr><th>ID</th><th>Titre</th><th>Date</th><th>Lieu</th><th>Actions</th></tr>
                    <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?= htmlspecialchars($event['id']) ?></td>
                        <td><?= htmlspecialchars($event['title']) ?></td>
                        <td><?= htmlspecialchars($event['date']) ?></td>
                        <td><?= htmlspecialchars($event['location']) ?></td>
                        <td>
                            <a href="index.php?action=form_event&id=<?= $event['id'] ?>" class="action-link">[Modifier]</a>
                            <a href="index.php?action=delete_event&id=<?= $event['id'] ?>" class="action-link delete" onclick="return confirm('Supprimer cet événement ?');">[Supprimer]</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>

            <h3 style="color: #fff; margin-bottom: 15px; display: inline-block;">Gestion des Ressources</h3>
            <a href="index.php?action=form_resource" class="btn-create" style="float: right;">+ Créer une Ressource</a>

            <div style="clear: both; background: rgba(255,255,255,0.05); border-radius: 15px; padding: 20px; margin-bottom: 40px; border: 1px solid rgba(255,255,255,0.1);">
                <table class="table-custom">
                    <tr><th>ID</th><th>Nom</th><th>Type</th><th>Quantité</th><th>Actions</th></tr>
                    <?php foreach ($resources as $res): ?>
                    <tr>
                        <td><?= htmlspecialchars($res['id']) ?></td>
                        <td><?= htmlspecialchars($res['name']) ?></td>
                        <td><?= htmlspecialchars($res['type']) ?></td>
                        <td><?= htmlspecialchars($res['quantity']) ?></td>
                        <td>
                            <a href="index.php?action=form_resource&id=<?= $res['id'] ?>" class="action-link">[Modifier]</a>
                            <a href="index.php?action=delete_resource&id=<?= $res['id'] ?>" class="action-link delete" onclick="return confirm('Supprimer cette ressource ?');">[Supprimer]</a>
                        </td>
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
