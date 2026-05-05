<?php // views/admin/index.php

// Helper: get event status
function getEventStatus($dateStr) {
    $eventDate = strtotime($dateStr);
    $today     = strtotime(date('Y-m-d'));
    if ($eventDate > $today)      return ['label' => 'À venir',     'color' => '#00ffcc'];
    elseif ($eventDate == $today) return ['label' => "Aujourd'hui", 'color' => '#f0c040'];
    else                          return ['label' => 'Passé',       'color' => '#ff6b6b'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion Events & Resources</title>
    <link rel="stylesheet" href="../templatemo_602_graph_page/templatemo-graph-page.css">
    <style>
        /* Tables */
        .table-custom { width: 100%; border-collapse: collapse; margin-bottom: 30px; color: #fff; }
        .table-custom th, .table-custom td { padding: 12px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .table-custom th { background-color: rgba(255,255,255,0.05); font-weight: 600; color: #ff6b6b; }
        .table-custom tr:hover { background-color: rgba(255,255,255,0.04); }

        /* Buttons */
        .action-link { color: #00ffcc; text-decoration: none; margin-right: 10px; font-size: 13px; }
        .action-link.delete { color: #ff6b6b; }
        .action-link:hover { text-decoration: underline; }
        .btn-create { display: inline-block; background: linear-gradient(135deg, #00ffcc, #00b8a9); color: #111; padding: 10px 22px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 14px; }
        .btn-create:hover { opacity: 0.85; }

        /* KPI Cards */
        .kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 40px; }
        .kpi-card { background: rgba(255,255,255,0.05); border-radius: 15px; padding: 25px 20px; border: 1px solid rgba(255,255,255,0.1); text-align: center; }
        .kpi-icon { font-size: 32px; margin-bottom: 10px; }
        .kpi-value { font-size: 36px; font-weight: 800; color: #00ffcc; }
        .kpi-label { font-size: 13px; color: #a0a0a0; margin-top: 5px; }
        .kpi-card.warn .kpi-value { color: #ff6b6b; }

        /* Status Badge */
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; color: #111; }

        /* Stock Warning */
        .low-stock { color: #ffcc00; font-weight: bold; }

        /* Availability dot */
        .avail-dot { display: inline-block; width: 12px; height: 12px; border-radius: 50%; margin-right: 6px; vertical-align: middle; }

        /* Search */
        .search-box { width: 100%; padding: 10px 14px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: #fff; margin-bottom: 15px; font-size: 14px; }
        .search-box:focus { border-color: #00ffcc; outline: none; }
        .search-box::placeholder { color: #666; }

        /* Section header */
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .section-header h3 { color: #fff; margin: 0; }

        @media (max-width: 768px) { .kpi-grid { grid-template-columns: repeat(2, 1fr); } }
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
            <h2 class="section-title">Dashboard Admin</h2>

            <!-- KPI CARDS -->
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="kpi-icon">📅</div>
                    <div class="kpi-value"><?= $totalEvents ?></div>
                    <div class="kpi-label">Total Événements</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon">🗓️</div>
                    <div class="kpi-value"><?= $upcomingEvents ?></div>
                    <div class="kpi-label">Événements à venir</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon">📦</div>
                    <div class="kpi-value"><?= $totalResources ?></div>
                    <div class="kpi-label">Total Ressources</div>
                </div>
                <div class="kpi-card warn">
                    <div class="kpi-icon">⚠️</div>
                    <div class="kpi-value"><?= $lowStockCount ?></div>
                    <div class="kpi-label">Stock Critique (≤2)</div>
                </div>
            </div>

            <!-- EVENTS TABLE -->
            <div class="section-header">
                <h3>Gestion des Événements</h3>
                <a href="index.php?action=form_event" class="btn-create">+ Créer un Événement</a>
            </div>
            <input type="text" id="searchEvent" class="search-box" placeholder="🔍 Rechercher par titre ou lieu...">
            <div style="background: rgba(255,255,255,0.05); border-radius: 15px; padding: 20px; margin-bottom: 40px; border: 1px solid rgba(255,255,255,0.1); overflow-x: auto;">
                <table class="table-custom" id="eventTable">
                    <thead><tr><th>ID</th><th>Titre</th><th>Date</th><th>Lieu</th><th>Statut</th><th>Actions</th></tr></thead>
                    <tbody>
                    <?php foreach ($events as $event):
                        $status = getEventStatus($event['date']); ?>
                    <tr>
                        <td><?= htmlspecialchars($event['id']) ?></td>
                        <td><?= htmlspecialchars($event['title']) ?></td>
                        <td><?= htmlspecialchars($event['date']) ?></td>
                        <td><?= htmlspecialchars($event['location']) ?></td>
                        <td><span class="badge" style="background-color:<?= $status['color'] ?>;"><?= $status['label'] ?></span></td>
                        <td>
                            <a href="index.php?action=form_event&id=<?= $event['id'] ?>" class="action-link">[Modifier]</a>
                            <a href="index.php?action=delete_event&id=<?= $event['id'] ?>" class="action-link delete" onclick="return confirm('Supprimer cet événement ?');">[Supprimer]</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- RESOURCES TABLE -->
            <div class="section-header">
                <h3>Gestion des Ressources</h3>
                <a href="index.php?action=form_resource" class="btn-create">+ Créer une Ressource</a>
            </div>
            <input type="text" id="searchResource" class="search-box" placeholder="🔍 Rechercher par nom ou type...">
            <div style="background: rgba(255,255,255,0.05); border-radius: 15px; padding: 20px; margin-bottom: 40px; border: 1px solid rgba(255,255,255,0.1); overflow-x: auto;">
                <table class="table-custom" id="resourceTable">
                    <thead><tr><th>ID</th><th>Nom</th><th>Type</th><th>Quantité</th><th>Disponibilité</th><th>Actions</th></tr></thead>
                    <tbody>
                    <?php foreach ($resources as $res):
                        $qty = (int)$res['quantity'];
                        $dotColor = $qty > 5 ? '#00ffcc' : ($qty >= 3 ? '#f0c040' : '#ff6b6b');
                        $availLabel = $qty > 5 ? 'Disponible' : ($qty >= 3 ? 'Faible' : 'Critique');
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($res['id']) ?></td>
                        <td><?= htmlspecialchars($res['name']) ?></td>
                        <td><?= htmlspecialchars($res['type']) ?></td>
                        <td>
                            <?= htmlspecialchars($res['quantity']) ?>
                            <?php if ($qty <= 2): ?><span class="low-stock" title="Stock critique !"> ⚠️</span><?php endif; ?>
                        </td>
                        <td>
                            <span class="avail-dot" style="background:<?= $dotColor ?>;"></span>
                            <span style="color:<?= $dotColor ?>; font-size:13px;"><?= $availLabel ?></span>
                        </td>
                        <td>
                            <a href="index.php?action=form_resource&id=<?= $res['id'] ?>" class="action-link">[Modifier]</a>
                            <a href="index.php?action=delete_resource&id=<?= $res['id'] ?>" class="action-link delete" onclick="return confirm('Supprimer cette ressource ?');">[Supprimer]</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
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
    <script>
        // Live search for events table
        document.getElementById('searchEvent').addEventListener('keyup', function() {
            const q = this.value.toLowerCase();
            document.querySelectorAll('#eventTable tbody tr').forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(q) ? '' : 'none';
            });
        });

        // Live search for resources table
        document.getElementById('searchResource').addEventListener('keyup', function() {
            const q = this.value.toLowerCase();
            document.querySelectorAll('#resourceTable tbody tr').forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(q) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
