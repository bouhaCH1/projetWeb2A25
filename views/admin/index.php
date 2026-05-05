<?php // views/admin/index.php

// Logistics Manager - Statut Helper
function getStatus($date) {
    $d = strtotime($date); $t = strtotime(date('Y-m-d'));
    if ($d > $t) return ['l'=>'À venir','c'=>'#00ffcc'];
    if ($d == $t) return ['l'=>'Aujourd\'hui','c'=>'#ffcc00'];
    return ['l'=>'Passé','c'=>'#ff6b6b'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Gestion Métiers</title>
    <link rel="stylesheet" href="../templatemo_602_graph_page/templatemo-graph-page.css">
    <style>
        .kpi-container { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
        .kpi-card { background: rgba(255,255,255,0.05); padding: 20px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.1); text-align: center; }
        .kpi-val { font-size: 24px; font-weight: bold; color: #00ffcc; }
        .kpi-label { font-size: 12px; color: #aaa; margin-top: 5px; }
        .badge { padding: 3px 8px; border-radius: 4px; font-size: 11px; color: #000; font-weight: bold; }
        .avail-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 5px; }
        .search-input { width: 100%; padding: 10px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 5px; margin-bottom: 10px; }
        .table-custom { width: 100%; border-collapse: collapse; color: #fff; }
        .table-custom th, .table-custom td { padding: 10px; border-bottom: 1px solid rgba(255,255,255,0.1); text-align: left; }
        .low-stock { color: #ff6b6b; font-weight: bold; }
    </style>
</head>
<body>
    <nav id="navbar"><div class="nav-container"><a href="index.php" class="logo">My Project</a><ul class="nav-links"><li><a href="index.php">User</a></li><li><a href="index.php?action=admin" class="active">Admin</a></li></ul></div></nav>

    <section class="dashboard-section" style="padding-top: 100px;">
        <div class="dashboard-container">
            <h2 class="section-title">Dashboard Admin - 12 Métiers Intégrés</h2>

            <!-- [METIER Event Manager / Accountant / HR] -->
            <div class="kpi-container">
                <div class="kpi-card"><div class="kpi-val"><?= $eventStats['total'] ?></div><div class="kpi-label">Total Events</div></div>
                <div class="kpi-card"><div class="kpi-val"><?= $eventStats['upcoming'] ?></div><div class="kpi-label">Upcoming Events</div></div>
                <div class="kpi-card"><div class="kpi-val"><?= $resStats['total'] ?></div><div class="kpi-label">Total Resources Qty</div></div>
                <div class="kpi-card" style="border-color:#ff6b6b;"><div class="kpi-val" style="color:#ff6b6b;"><?= $resStats['low_stock'] ?></div><div class="kpi-label">Low Stock (≤2)</div></div>
            </div>

            <!-- [METIER Sound/AV Tech - Recherche] -->
            <h3 style="color:#fff;">Événements (Manager/Coordinator/Logistics/Tech/Photo/Security)</h3>
            <input type="text" id="searchEvent" class="search-input" placeholder="🔍 Rechercher un événement...">
            <div style="background:rgba(255,255,255,0.05); padding:15px; border-radius:10px; border:1px solid rgba(255,255,255,0.1); margin-bottom:30px;">
                <table class="table-custom" id="eventTable">
                    <thead><tr><th>ID</th><th>Titre</th><th>Date</th><th>Lieu</th><th>Statut</th><th>Actions</th></tr></thead>
                    <tbody>
                    <?php foreach ($events as $event): $st = getStatus($event['date']); ?>
                    <tr>
                        <td><?= $event['id'] ?></td>
                        <td><?= htmlspecialchars($event['title']) ?></td>
                        <td><?= $event['date'] ?></td>
                        <td><?= htmlspecialchars($event['location']) ?></td>
                        <td><span class="badge" style="background:<?= $st['c'] ?>;"><?= $st['l'] ?></span></td>
                        <td><a href="index.php?action=form_event&id=<?= $event['id'] ?>" style="color:#00ffcc;">Edit</a></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- [METIER FullStack/SysAdmin/Graphic/Marketing/HR/Accountant] -->
            <h3 style="color:#fff;">Ressources</h3>
            <input type="text" id="searchResource" class="search-input" placeholder="🔍 Filtrer les ressources...">
            <div style="background:rgba(255,255,255,0.05); padding:15px; border-radius:10px; border:1px solid rgba(255,255,255,0.1);">
                <table class="table-custom" id="resTable">
                    <thead><tr><th>ID</th><th>Nom</th><th>Type</th><th>Quantité</th><th>État</th><th>Actions</th></tr></thead>
                    <tbody>
                    <?php foreach ($resources as $res): 
                        $qty = (int)$res['quantity'];
                        $color = $qty > 5 ? '#00ffcc' : ($qty >= 3 ? '#ffcc00' : '#ff6b6b');
                    ?>
                    <tr>
                        <td><?= $res['id'] ?></td>
                        <td><?= htmlspecialchars($res['name']) ?></td>
                        <td><?= htmlspecialchars($res['type']) ?></td>
                        <td class="<?= $qty <= 2 ? 'low-stock' : '' ?>"><?= $qty ?></td>
                        <td><span class="avail-dot" style="background:<?= $color ?>;"></span></td>
                        <td><a href="index.php?action=form_resource&id=<?= $res['id'] ?>" style="color:#00ffcc;">Edit</a></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <script>
        // METIER Sound/AV Tech & Marketing - Live Search
        document.getElementById('searchEvent').onkeyup = function() {
            let q = this.value.toLowerCase();
            document.querySelectorAll('#eventTable tbody tr').forEach(r => {
                r.style.display = r.innerText.toLowerCase().includes(q) ? '' : 'none';
            });
        };
        document.getElementById('searchResource').onkeyup = function() {
            let q = this.value.toLowerCase();
            document.querySelectorAll('#resTable tbody tr').forEach(r => {
                r.style.display = r.innerText.toLowerCase().includes(q) ? '' : 'none';
            });
        };
    </script>
</body>
</html>
