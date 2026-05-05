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
    <title>DarkPan - Professional Admin</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../darkpan/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../darkpan/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.php?action=admin" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>DarkPan</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="../darkpan/img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">Admin Ayoub</h6>
                        <span>Responsable</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.php?action=admin" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="index.php" class="nav-item nav-link"><i class="fa fa-home me-2"></i>Page Client</a>
                    <a href="index.php?action=form_event" class="nav-item nav-link"><i class="fa fa-calendar-plus me-2"></i>Ajout Event</a>
                    <a href="index.php?action=form_resource" class="nav-item nav-link"><i class="fa fa-plus-square me-2"></i>Ajout Resource</a>
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
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="../darkpan/img/user.jpg" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">Admin Panel</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="index.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->


            <!-- Stats Cards Start -->
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
                            <i class="fa fa-hourglass-start fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Upcoming</p>
                                <h6 class="mb-0"><?= $eventStats['upcoming'] ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-cubes fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Resources</p>
                                <h6 class="mb-0"><?= $resStats['total'] ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-exclamation-circle fa-3x text-danger"></i>
                            <div class="ms-3">
                                <p class="mb-2">Low Stock</p>
                                <h6 class="mb-0 text-danger"><?= $resStats['low_stock'] ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Stats Cards End -->


            <!-- Charts Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Analyse Mensuelle des Événements</h6>
                            </div>
                            <canvas id="events-monthly-chart"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Répartition des Ressources par Type</h6>
                            </div>
                            <canvas id="resources-type-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Charts End -->


            <!-- Tables Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <!-- Events Table -->
                    <div class="col-12">
                        <div class="bg-secondary rounded h-100 p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Gestion des Événements</h6>
                                <a href="index.php?action=form_event" class="btn btn-primary btn-sm"><i class="fa fa-plus me-2"></i>Nouvel Événement</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Titre</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Lieu</th>
                                            <th scope="col">Statut</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($events as $event): $st = getStatus($event['date']); ?>
                                        <tr>
                                            <td><?= $event['id'] ?></td>
                                            <td><?= htmlspecialchars($event['title']) ?></td>
                                            <td><?= $event['date'] ?></td>
                                            <td><?= htmlspecialchars($event['location']) ?></td>
                                            <td><span class="badge bg-<?= $st['c'] ?>"><?= $st['l'] ?></span></td>
                                            <td>
                                                <a class="btn btn-square btn-outline-info btn-sm me-1" href="index.php?action=form_event&id=<?= $event['id'] ?>"><i class="fa fa-edit"></i></a>
                                                <a class="btn btn-square btn-outline-danger btn-sm" href="index.php?action=delete_event&id=<?= $event['id'] ?>" onclick="return confirm('Supprimer cet événement ?')"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Resources Table -->
                    <div class="col-12">
                        <div class="bg-secondary rounded h-100 p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Gestion des Ressources</h6>
                                <a href="index.php?action=form_resource" class="btn btn-primary btn-sm"><i class="fa fa-plus me-2"></i>Nouvelle Ressource</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Nom</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Quantité</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($resources as $res): ?>
                                        <tr>
                                            <td><?= $res['id'] ?></td>
                                            <td><?= htmlspecialchars($res['name']) ?></td>
                                            <td><?= htmlspecialchars($res['type']) ?></td>
                                            <td class="<?= (int)$res['quantity'] <= 2 ? 'text-danger fw-bold' : '' ?>"><?= $res['quantity'] ?></td>
                                            <td>
                                                <a class="btn btn-square btn-outline-info btn-sm me-1" href="index.php?action=form_resource&id=<?= $res['id'] ?>"><i class="fa fa-edit"></i></a>
                                                <a class="btn btn-square btn-outline-danger btn-sm" href="index.php?action=delete_resource&id=<?= $res['id'] ?>" onclick="return confirm('Supprimer cette ressource ?')"><i class="fa fa-trash"></i></a>
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
            <!-- Tables End -->


            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">EventResource Pro</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Template Javascript -->
    <script src="../darkpan/js/main.js"></script>

    <script>
        // Set Chart.js Defaults for Dark Mode
        Chart.defaults.color = "#6C7293";
        Chart.defaults.borderColor = "rgba(255, 255, 255, .1)";

        // Monthly Events Chart
        const ctxEvents = document.getElementById('events-monthly-chart').getContext('2d');
        new Chart(ctxEvents, {
            type: 'bar',
            data: {
                labels: [<?php foreach($eventStats['monthly'] as $m) echo '"'.$m['month'].'",'; ?>],
                datasets: [{
                    label: "Nombre d'événements",
                    data: [<?php foreach($eventStats['monthly'] as $m) echo $m['count'].','; ?>],
                    backgroundColor: "rgba(235, 22, 22, .7)",
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Resources Type Chart
        const ctxResources = document.getElementById('resources-type-chart').getContext('2d');
        new Chart(ctxResources, {
            type: 'doughnut',
            data: {
                labels: [<?php foreach($resStats['types'] as $t) echo '"'.$t['type'].'",'; ?>],
                datasets: [{
                    backgroundColor: [
                        "rgba(235, 22, 22, .9)",
                        "rgba(235, 22, 22, .7)",
                        "rgba(235, 22, 22, .5)",
                        "rgba(235, 22, 22, .3)",
                        "rgba(235, 22, 22, .1)"
                    ],
                    data: [<?php foreach($resStats['types'] as $t) echo $t['count'].','; ?>],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 20 }
                    }
                }
            }
        });
    </script>
</body>
</html>
