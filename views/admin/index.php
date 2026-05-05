<?php // views/admin/index.php

function getStatus($date) {
    $d = strtotime($date); $t = strtotime(date('Y-m-d'));
    if ($d > $t) return ['l'=>'À venir','c'=>'primary'];
    if ($d == $t) return ['l'=>'Aujourd\'hui','c'=>'warning'];
    return ['l'=>'Passé','c'=>'danger'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>EventResource Pro - Premium Admin</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- DarkPan Styles -->
    <link href="../darkpan/css/bootstrap.min.css" rel="stylesheet">
    <link href="../darkpan/css/style.css" rel="stylesheet">

    <style>
        .chart-container { position: relative; height: 300px; width: 100%; }
        .activity-item { border-left: 2px solid #eb1616; padding-left: 15px; margin-bottom: 20px; position: relative; }
        .activity-item::before { content: ""; position: absolute; width: 10px; height: 10px; background: #eb1616; border-radius: 50%; left: -6px; top: 5px; }
        .badge-outline { border: 1px solid currentColor; background: transparent !important; }
    </style>
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.php?action=admin" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-chart-pie me-2"></i>ER PRO</h3>
                </a>
                <div class="navbar-nav w-100">
                    <a href="index.php?action=admin" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-calendar me-2"></i>Événements</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="index.php?action=admin" class="dropdown-item">Liste</a>
                            <a href="index.php?action=form_event" class="dropdown-item">Ajouter</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-tools me-2"></i>Ressources</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="index.php?action=admin" class="dropdown-item">Liste</a>
                            <a href="index.php?action=form_resource" class="dropdown-item">Ajouter</a>
                        </div>
                    </div>
                    <a href="index.php" class="nav-item nav-link"><i class="fa fa-external-link-alt me-2"></i>Vue Client</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="#" class="sidebar-toggler flex-shrink-0"><i class="fa fa-bars"></i></a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <span class="d-none d-lg-inline-flex">Administrateur</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="index.php" class="dropdown-item">Déconnexion</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Stats Grid -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 shadow-sm">
                            <i class="fa fa-calendar-check fa-3x text-primary"></i>
                            <div class="ms-3 text-end">
                                <p class="mb-2">Total Events</p>
                                <h4 class="mb-0"><?= $eventStats['total'] ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 shadow-sm">
                            <i class="fa fa-clock fa-3x text-info"></i>
                            <div class="ms-3 text-end">
                                <p class="mb-2">À Venir</p>
                                <h4 class="mb-0"><?= $eventStats['upcoming'] ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 shadow-sm">
                            <i class="fa fa-boxes fa-3x text-warning"></i>
                            <div class="ms-3 text-end">
                                <p class="mb-2">Total Qty</p>
                                <h4 class="mb-0"><?= $resStats['total'] ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 shadow-sm">
                            <i class="fa fa-exclamation-triangle fa-3x text-danger"></i>
                            <div class="ms-3 text-end">
                                <p class="mb-2">Critique</p>
                                <h4 class="mb-0 text-danger"><?= $resStats['low_stock'] ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advanced Charts Row 1 -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-8">
                        <div class="bg-secondary text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Tendance Mensuelle (Line Chart)</h6>
                            </div>
                            <div class="chart-container">
                                <canvas id="line-chart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="bg-secondary text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Répartition (Doughnut)</h6>
                            </div>
                            <div class="chart-container">
                                <canvas id="doughnut-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advanced Charts Row 2 -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="bg-secondary text-center rounded p-4">
                            <h6 class="mb-4">Top Lieux (Bar)</h6>
                            <div class="chart-container">
                                <canvas id="bar-chart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="bg-secondary text-center rounded p-4">
                            <h6 class="mb-4">Disponibilité (Polar)</h6>
                            <div class="chart-container">
                                <canvas id="polar-chart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-xl-4">
                        <div class="bg-secondary p-4 h-100 rounded">
                            <h6 class="mb-4">Activités Récentes</h6>
                            <div class="activity-item">
                                <div class="d-flex justify-content-between"><strong>Nouvel Event</strong> <small class="text-muted">À l'instant</small></div>
                                <p class="text-muted small mb-0">Un nouvel événement a été ajouté à Tunis.</p>
                            </div>
                            <div class="activity-item">
                                <div class="d-flex justify-content-between"><strong>Stock Bas</strong> <small class="text-muted">Il y a 5m</small></div>
                                <p class="text-muted small mb-0">La ressource "Projecteur" est passée en critique.</p>
                            </div>
                            <div class="activity-item">
                                <div class="d-flex justify-content-between"><strong>Mise à jour</strong> <small class="text-muted">Il y a 1h</small></div>
                                <p class="text-muted small mb-0">Modification des détails de la salle de conférence.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Full Tables -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Gestion Complète</h6>
                    </div>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-events">Events</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-resources">Resources</button></li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="tab-events">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead><tr><th>ID</th><th>Titre</th><th>Date</th><th>Statut</th><th>Actions</th></tr></thead>
                                    <tbody>
                                        <?php foreach($events as $e): $st=getStatus($e['date']); ?>
                                        <tr>
                                            <td><?= $e['id'] ?></td>
                                            <td><?= htmlspecialchars($e['title']) ?></td>
                                            <td><?= $e['date'] ?></td>
                                            <td><span class="badge badge-outline text-<?= $st['c'] ?>"><?= $st['l'] ?></span></td>
                                            <td>
                                                <a href="index.php?action=form_event&id=<?= $e['id'] ?>" class="btn btn-sm btn-outline-info me-1"><i class="fa fa-edit"></i></a>
                                                <a href="index.php?action=delete_event&id=<?= $e['id'] ?>" onclick="return confirm('Sûr?')" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-resources">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead><tr><th>ID</th><th>Nom</th><th>Type</th><th>Qty</th><th>Actions</th></tr></thead>
                                    <tbody>
                                        <?php foreach($resources as $r): ?>
                                        <tr>
                                            <td><?= $r['id'] ?></td>
                                            <td><?= htmlspecialchars($r['name']) ?></td>
                                            <td><?= htmlspecialchars($r['type']) ?></td>
                                            <td><?= $r['quantity'] ?></td>
                                            <td>
                                                <a href="index.php?action=form_resource&id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-info me-1"><i class="fa fa-edit"></i></a>
                                                <a href="index.php?action=delete_resource&id=<?= $r['id'] ?>" onclick="return confirm('Sûr?')" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4 text-center">
                    <p class="mb-0">&copy; 2026 <strong>EventResource Pro</strong>. Système Expert.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../darkpan/js/main.js"></script>

    <script>
        // Global Chart Config
        Chart.defaults.color = "#888";
        Chart.defaults.borderColor = "rgba(255,255,255,0.05)";

        // 1. Line Chart (Events Trend)
        new Chart(document.getElementById('line-chart'), {
            type: 'line',
            data: {
                labels: [<?php foreach($eventStats['monthly'] as $m) echo '"'.$m['month'].'",'; ?>],
                datasets: [{
                    label: "Événements",
                    data: [<?php foreach($eventStats['monthly'] as $m) echo $m['count'].','; ?>],
                    borderColor: "#eb1616",
                    backgroundColor: "rgba(235, 22, 22, .2)",
                    fill: true,
                    tension: 0.4
                }]
            },
            options: { maintainAspectRatio: false }
        });

        // 2. Doughnut Chart (Resource Types)
        new Chart(document.getElementById('doughnut-chart'), {
            type: 'doughnut',
            data: {
                labels: [<?php foreach($resStats['types'] as $t) echo '"'.$t['type'].'",'; ?>],
                datasets: [{
                    data: [<?php foreach($resStats['types'] as $t) echo $t['count'].','; ?>],
                    backgroundColor: ["#eb1616", "#00ffcc", "#ffcc00", "#36a2eb", "#9966ff"],
                    borderWidth: 0
                }]
            },
            options: { maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
        });

        // 3. Bar Chart (Top Locations)
        new Chart(document.getElementById('bar-chart'), {
            type: 'bar',
            data: {
                labels: [<?php foreach($eventStats['location'] as $l) echo '"'.$l['location'].'",'; ?>],
                datasets: [{
                    label: "Events",
                    data: [<?php foreach($eventStats['location'] as $l) echo $l['count'].','; ?>],
                    backgroundColor: "#00ffcc"
                }]
            },
            options: { maintainAspectRatio: false }
        });

        // 4. Polar Area Chart (Quantity Ranges)
        new Chart(document.getElementById('polar-chart'), {
            type: 'polarArea',
            data: {
                labels: [<?php foreach($resStats['ranges'] as $r) echo '"'.$r['range_label'].'",'; ?>],
                datasets: [{
                    data: [<?php foreach($resStats['ranges'] as $r) echo $r['count'].','; ?>],
                    backgroundColor: ["#eb1616", "#ffcc00", "#00ffcc"]
                }]
            },
            options: { maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
        });
    </script>
</body>
</html>
