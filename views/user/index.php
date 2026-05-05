<?php // views/user/index.php

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
    <title>User - Events & Resources</title>
    <link rel="stylesheet" href="../templatemo_602_graph_page/templatemo-graph-page.css">
    <style>
        .table-custom { width: 100%; border-collapse: collapse; margin-bottom: 30px; color: #fff; }
        .table-custom th, .table-custom td { padding: 12px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .table-custom th { background-color: rgba(255,255,255,0.05); font-weight: 600; color: #00ffcc; }
        .table-custom tr:hover { background-color: rgba(255,255,255,0.04); }

        /* Badges */
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; color: #111; }

        /* Availability */
        .avail-dot { display: inline-block; width: 12px; height: 12px; border-radius: 50%; margin-right: 6px; vertical-align: middle; }

        /* Filter button */
        .filter-btn { padding: 8px 18px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.05); color: #fff; cursor: pointer; font-size: 13px; margin-right: 10px; transition: all 0.2s; }
        .filter-btn.active, .filter-btn:hover { background: #00ffcc; color: #111; border-color: #00ffcc; font-weight: bold; }

        /* Event title link */
        .event-title-link { color: #00ffcc; cursor: pointer; text-decoration: underline dotted; }
        .event-title-link:hover { color: #fff; }

        /* Modal */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); z-index: 9999; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal-box { background: #1a1a2e; border: 1px solid rgba(0,255,204,0.3); border-radius: 20px; padding: 35px; max-width: 550px; width: 90%; position: relative; animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        .modal-close { position: absolute; top: 15px; right: 20px; font-size: 22px; cursor: pointer; color: #aaa; }
        .modal-close:hover { color: #fff; }
        .modal-title { font-size: 22px; font-weight: 700; color: #00ffcc; margin-bottom: 20px; }
        .modal-row { display: flex; gap: 10px; margin-bottom: 12px; }
        .modal-row .label { color: #888; min-width: 110px; font-size: 14px; }
        .modal-row .value { color: #fff; font-size: 14px; }
        .modal-desc { margin-top: 15px; padding-top: 15px; border-top: 1px solid rgba(255,255,255,0.1); color: #ccc; font-size: 14px; line-height: 1.7; }

        /* Section header */
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 10px; }
        .section-header h3 { color: #fff; margin: 0; }
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

    <!-- Event Detail Modal -->
    <div class="modal-overlay" id="eventModal">
        <div class="modal-box">
            <span class="modal-close" onclick="closeModal()">✕</span>
            <div class="modal-title" id="modal-title"></div>
            <div class="modal-row"><span class="label">📅 Date :</span><span class="value" id="modal-date"></span></div>
            <div class="modal-row"><span class="label">📍 Lieu :</span><span class="value" id="modal-location"></span></div>
            <div class="modal-row"><span class="label">🏷️ Statut :</span><span class="value" id="modal-status"></span></div>
            <div class="modal-desc" id="modal-desc"></div>
        </div>
    </div>

    <section class="dashboard-section" style="padding-top: 120px; min-height: 100vh;">
        <div class="dashboard-container">
            <h2 class="section-title">Bienvenue sur la page Utilisateur</h2>

            <!-- EVENTS TABLE -->
            <div class="section-header">
                <h3>Liste des Événements</h3>
                <div>
                    <button class="filter-btn active" id="btn-all" onclick="filterEvents('all')">Tous</button>
                    <button class="filter-btn" id="btn-upcoming" onclick="filterEvents('upcoming')">🗓️ À venir</button>
                </div>
            </div>
            <div style="background: rgba(255,255,255,0.05); border-radius: 15px; padding: 20px; margin-bottom: 40px; border: 1px solid rgba(255,255,255,0.1); overflow-x: auto;">
                <table class="table-custom" id="eventTable">
                    <thead><tr><th>ID</th><th>Titre</th><th>Date</th><th>Lieu</th><th>Statut</th></tr></thead>
                    <tbody>
                    <?php foreach ($events as $event):
                        $status = getEventStatus($event['date']);
                        $eventDate = strtotime($event['date']);
                        $isUpcoming = $eventDate >= strtotime(date('Y-m-d')) ? 'upcoming' : 'past';
                    ?>
                    <tr data-filter="<?= $isUpcoming ?>">
                        <td><?= htmlspecialchars($event['id']) ?></td>
                        <td>
                            <span class="event-title-link"
                                onclick="openModal(
                                    '<?= htmlspecialchars(addslashes($event['title'])) ?>',
                                    '<?= htmlspecialchars($event['date']) ?>',
                                    '<?= htmlspecialchars(addslashes($event['location'])) ?>',
                                    '<?= htmlspecialchars(addslashes($event['description'] ?? '')) ?>',
                                    '<?= $status['label'] ?>',
                                    '<?= $status['color'] ?>'
                                )">
                                <?= htmlspecialchars($event['title']) ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($event['date']) ?></td>
                        <td><?= htmlspecialchars($event['location']) ?></td>
                        <td><span class="badge" style="background-color:<?= $status['color'] ?>;"><?= $status['label'] ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- RESOURCES TABLE -->
            <h3 style="color: #fff; margin-bottom: 15px;">Liste des Ressources</h3>
            <div style="background: rgba(255,255,255,0.05); border-radius: 15px; padding: 20px; margin-bottom: 40px; border: 1px solid rgba(255,255,255,0.1); overflow-x: auto;">
                <table class="table-custom">
                    <thead><tr><th>ID</th><th>Nom</th><th>Type</th><th>Quantité</th><th>Disponibilité</th></tr></thead>
                    <tbody>
                    <?php foreach ($resources as $res):
                        $qty = (int)$res['quantity'];
                        $dotColor  = $qty > 5 ? '#00ffcc' : ($qty >= 3 ? '#f0c040' : '#ff6b6b');
                        $availLabel = $qty > 5 ? 'Disponible' : ($qty >= 3 ? 'Stock faible' : 'Stock critique');
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($res['id']) ?></td>
                        <td><?= htmlspecialchars($res['name']) ?></td>
                        <td><?= htmlspecialchars($res['type']) ?></td>
                        <td><?= htmlspecialchars($res['quantity']) ?></td>
                        <td>
                            <span class="avail-dot" style="background:<?= $dotColor ?>;"></span>
                            <span style="color:<?= $dotColor ?>; font-size:13px; font-weight:600;"><?= $availLabel ?></span>
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
        // Filter events
        function filterEvents(type) {
            document.querySelectorAll('#eventTable tbody tr').forEach(row => {
                row.style.display = (type === 'all' || row.dataset.filter === type) ? '' : 'none';
            });
            document.getElementById('btn-all').classList.toggle('active', type === 'all');
            document.getElementById('btn-upcoming').classList.toggle('active', type === 'upcoming');
        }

        // Open modal
        function openModal(title, date, location, desc, statusLabel, statusColor) {
            document.getElementById('modal-title').textContent = title;
            document.getElementById('modal-date').textContent = date;
            document.getElementById('modal-location').textContent = location || 'Non précisé';
            document.getElementById('modal-desc').textContent = desc || 'Aucune description disponible.';
            document.getElementById('modal-status').innerHTML = '<span class="badge" style="background:'+statusColor+';">'+statusLabel+'</span>';
            document.getElementById('eventModal').classList.add('open');
        }

        // Close modal
        function closeModal() {
            document.getElementById('eventModal').classList.remove('open');
        }

        // Close modal on overlay click
        document.getElementById('eventModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
</body>
</html>
