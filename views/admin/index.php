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
    <title>Admin - DarkPan Statistics</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../darkpan/css/bootstrap.min.css" rel="stylesheet">
    <link href="../darkpan/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>Admin Panel</h3>
                </a>
                <div class="navbar-nav w-100">
                    <a href="index.php?action=admin" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="index.php" class="nav-item nav-link"><i class="fa fa-home me-2"></i>User View</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
            </nav>
            <!-- Navbar End -->

            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-calendar-alt fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Events</p>
                                <h6 class="mb-0"><?= $eventStats['total'] ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-clock fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Upcoming</p>
                                <h6 class="mb-0"><?= $eventStats['upcoming'] ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-box fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Qty</p>
                                <h6 class="mb-0"><?= $resStats['total'] ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-exclamation-triangle fa-3x text-danger"></i>
                            <div class="ms-3">
                                <p class="mb-2">Low Stock</p>
                                <h6 class="mb-0 text-danger"><?= $resStats['low_stock'] ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sale & Revenue End -->

            <!-- Charts Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Événements par Mois</h6>
                            </div>
                            <canvas id="events-chart"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Répartition des Ressources</h6>
                            </div>
                            <canvas id="resources-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Charts End -->

            <!-- Recent Data Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Gestion Rapide</h6>
                        <div>
                            <a href="index.php?action=form_event" class="btn btn-sm btn-primary"> + Event</a>
                            <a href="index.php?action=form_resource" class="btn btn-sm btn-primary"> + Resource</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-white">
                                    <th>Type</th>
                                    <th>Nom / Titre</th>
                                    <th>Date / Qty</th>
                                    <th>Statut / Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($events, 0, 3) as $e): $st = getStatus($e['date']); ?>
                                <tr>
                                    <td>Event</td>
                                    <td><?= htmlspecialchars($e['title']) ?></td>
                                    <td><?= $e['date'] ?></td>
                                    <td><span class="badge bg-<?= $st['c'] ?>"><?= $st['l'] ?></span></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Recent Data End -->

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <p class="mb-0">&copy; <a href="#">My Project</a>, All Right Reserved.</p>
                </div>
            </div>
            <!-- Footer End -->
        </div>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../darkpan/js/main.js"></script>

    <script>
        // Chart.js - Events Monthly
        const ctx1 = document.getElementById('events-chart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: [<?php foreach($eventStats['monthly'] as $m) echo '"'.$m['month'].'",'; ?>],
                datasets: [{
                    label: "Événements",
                    data: [<?php foreach($eventStats['monthly'] as $m) echo $m['count'].','; ?>],
                    backgroundColor: "rgba(235, 22, 22, .7)"
                }]
            },
            options: { responsive: true }
        });

        // Chart.js - Resources Types
        const ctx2 = document.getElementById('resources-chart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: [<?php foreach($resStats['types'] as $t) echo '"'.$t['type'].'",'; ?>],
                datasets: [{
                    backgroundColor: [
                        "rgba(235, 22, 22, .7)",
                        "rgba(235, 22, 22, .6)",
                        "rgba(235, 22, 22, .5)",
                        "rgba(235, 22, 22, .4)",
                        "rgba(235, 22, 22, .3)"
                    ],
                    data: [<?php foreach($resStats['types'] as $t) echo $t['count'].','; ?>]
                }]
            },
            options: { responsive: true }
        });
    </script>
</body>
</html>
