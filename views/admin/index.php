<?php // views/admin/index.php

function getStatus($date) {
    $d = strtotime($date); $t = strtotime(date('Y-m-d'));
    if ($d > $t) return ['l'=>'À venir','c'=>'primary'];
    if ($d == $t) return ['l'=>'Aujourd\'hui','c'=>'warning'];
    return ['l'=>'Passé','c'=>'danger'];
}

// Data for JS
$months = array_column($eventStats['monthly'], 'month');
$monthCounts = array_column($eventStats['monthly'], 'count');
$resTypes = array_column($resStats['types'], 'type');
$resTypeCounts = array_column($resStats['types'], 'count');
$locNames = array_column($eventStats['location'], 'location');
$locCounts = array_column($eventStats['location'], 'count');
$rangeLabels = array_column($resStats['ranges'], 'range_label');
$rangeCounts = array_column($resStats['ranges'], 'count');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>EventResource Pro - Premium Admin</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../darkpan/css/bootstrap.min.css" rel="stylesheet">
    <link href="../darkpan/css/style.css" rel="stylesheet">

    <!-- Leaflet, FullCalendar & DataTables -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

    <style>
        .chart-container { position: relative; height: 250px; width: 100%; }
        .map-container { height: 400px; width: 100%; border-radius: 10px; z-index: 1; }
        #calendar { background: #191c24; padding: 10px; border-radius: 10px; border: 1px solid #333; font-size: 0.85em; }
        .fc-header-toolbar { margin-bottom: 1em !important; }
        .fc-toolbar-title { font-size: 1.2em !important; color: #fff; }
        .fc-daygrid-day-number { color: #fff !important; text-decoration: none; }
        .fc-col-header-cell-cushion { color: #00ffcc !important; text-decoration: none; }
        .fc-event { cursor: pointer; }
        /* Floating Chat Button */
        #chat-btn { position: fixed; bottom: 20px; right: 20px; width: 60px; height: 60px; background: #eb1616; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.5); z-index: 1000; transition: transform 0.3s; cursor: pointer; border: none; }
        #chat-btn:hover { transform: scale(1.1); background: #00ffcc; color: #191c24; }
        
        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate { color: #888 !important; }
        .dataTables_wrapper .dataTables_filter input { background: #191c24; border: 1px solid #333; color: #fff; border-radius: 5px; }
        .dataTables_wrapper .dataTables_length select { background: #191c24; border: 1px solid #333; color: #fff; border-radius: 5px; }
        .dt-buttons .btn { background: #eb1616 !important; border: none !important; color: #fff !important; margin-right: 5px; font-size: 12px; }
        .page-item.active .page-link { background-color: #eb1616 !important; border-color: #eb1616 !important; }
        .page-link { background-color: #191c24 !important; border: 1px solid #333 !important; color: #888 !important; }
        .activity-item { border-left: 2px solid #eb1616; padding-left: 15px; margin-bottom: 20px; position: relative; }
        .activity-item::before { content: ""; position: absolute; width: 10px; height: 10px; background: #eb1616; border-radius: 50%; left: -6px; top: 5px; }
        .empty-chart-msg { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #666; font-style: italic; }
    </style>
</head>
<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.php?action=admin" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-chart-line me-2"></i>ER PRO</h3>
                </a>
                <div class="navbar-nav w-100">
                    <a href="index.php?action=admin" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="index.php?action=form_event" class="nav-item nav-link"><i class="fa fa-calendar-plus me-2"></i>Nouveau Event</a>
                    <a href="index.php?action=form_resource" class="nav-item nav-link"><i class="fa fa-plus-square me-2"></i>Nouvelle Ressource</a>
                    <a href="index.php" class="nav-item nav-link"><i class="fa fa-home me-2"></i>Retour Site</a>
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
                    <span class="text-muted d-none d-lg-inline">Système Opérationnel</span>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- KPI Cards -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 shadow">
                            <i class="fa fa-calendar-alt fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Events</p>
                                <h4 class="mb-0"><?= $eventStats['total'] ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 shadow">
                            <i class="fa fa-clock fa-3x text-info"></i>
                            <div class="ms-3">
                                <p class="mb-2">Upcoming</p>
                                <h4 class="mb-0"><?= $eventStats['upcoming'] ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 shadow">
                            <i class="fa fa-boxes fa-3x text-warning"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Qty</p>
                                <h4 class="mb-0"><?= $resStats['total'] ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 shadow">
                            <i class="fa fa-exclamation-triangle fa-3x text-danger"></i>
                            <div class="ms-3">
                                <p class="mb-2">Alerte Stock</p>
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
                            <h6 class="mb-4">Localisation des Événements</h6>
                            <div id="map" class="map-container"></div>
                            <p class="text-muted small mt-2"><i class="fa fa-info-circle me-1"></i> Système Leaflet (OpenStreetMap) actif.</p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="bg-secondary text-center rounded p-4">
                            <h6 class="mb-4">Services Connectés (APIs)</h6>
                            <div class="d-grid gap-2">
                                <a href="index.php?action=api_config&service=Stripe" class="btn btn-outline-primary mb-2"><i class="fab fa-stripe me-2"></i>Méthode de Paiement</a>
                                <a href="index.php?action=api_config&service=SendGrid" class="btn btn-outline-info mb-2"><i class="fa fa-envelope me-2"></i>Emails Automatiques</a>
                                <a href="index.php?action=api_config&service=Google Calendar" class="btn btn-outline-warning mb-2"><i class="fa fa-calendar-alt me-2"></i>G-Calendar : Sync</a>
                            </div>
                            <hr>
                            <h6 class="mb-3 text-primary"><i class="fa fa-cloud-sun me-2"></i>Météo Locale</h6>
                            <div class="bg-dark p-3 rounded mb-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div><h4 class="mb-0 text-white">24°C</h4><p class="small mb-0">Tunis, Tunisie</p></div>
                                    <i class="fa fa-sun fa-3x text-warning"></i>
                                </div>
                            </div>
                            <hr>
                            <h6 class="mb-3 text-info"><i class="fa fa-brain me-2"></i>Intelligence Artificielle</h6>
                            <div class="d-grid gap-2">
                                <button class="btn btn-sm btn-outline-info" onclick="simulateApi('OCR')"><i class="fa fa-eye me-2"></i>OCR : Lecture Doc</button>
                                <button class="btn btn-sm btn-outline-light" onclick="simulateApi('Prediction')"><i class="fa fa-magic me-2"></i>H.Face : Prédiction</button>
                            </div>
                            <hr>
                            <h6 class="mb-3">Tendance Mensuelle</h6>
                            <div class="chart-container" style="height: 150px;">
                                <canvas id="line-chart"></canvas>
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
                            <h6 class="mb-4">Top Locations</h6>
                            <div class="chart-container">
                                <?php if(empty($locNames)): ?><div class="empty-chart-msg">Aucune donnée disponible</div><?php endif; ?>
                                <canvas id="bar-chart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="bg-secondary text-center rounded p-4">
                            <h6 class="mb-4">Disponibilité Stocks</h6>
                            <div class="chart-container">
                                <?php if(empty($rangeLabels)): ?><div class="empty-chart-msg">Aucune donnée disponible</div><?php endif; ?>
                                <canvas id="polar-chart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-xl-4">
                        <div class="bg-secondary p-4 h-100 rounded">
                            <h6 class="mb-4">Planning des Événements</h6>
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabbed Tables -->
            <div class="container-fluid pt-4 px-4 pb-4">
                <div class="bg-secondary rounded p-4">
                    <h6 class="mb-4">Administration des Données</h6>
                    <nav>
                        <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-events-tab" data-bs-toggle="tab" data-bs-target="#nav-events" type="button" role="tab">Événements</button>
                            <button class="nav-link" id="nav-resources-tab" data-bs-toggle="tab" data-bs-target="#nav-resources" type="button" role="tab">Ressources</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-events" role="tabpanel">
                            <div class="table-responsive p-3">
                                <table id="eventsTable" class="table table-hover w-100">
                                    <thead><tr><th>ID</th><th>Titre</th><th>Date</th><th>Lieu</th><th>Statut</th><th>Actions</th></tr></thead>
                                    <tbody>
                                        <?php foreach($events as $e): $st=getStatus($e['date']); ?>
                                        <tr>
                                            <td><?= $e['id'] ?></td>
                                            <td><?= htmlspecialchars($e['title']) ?></td>
                                            <td><?= $e['date'] ?></td>
                                            <td><?= htmlspecialchars($e['location']) ?></td>
                                            <td><span class="badge rounded-pill bg-<?= $st['c'] ?>"><?= $st['l'] ?></span></td>
                                            <td>
                                                <a href="index.php?action=form_event&id=<?= $e['id'] ?>" class="btn btn-sm btn-info me-1"><i class="fa fa-edit"></i></a>
                                                <a href="index.php?action=delete_event&id=<?= $e['id'] ?>" onclick="return confirm('Sûr?')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-resources" role="tabpanel">
                            <div class="table-responsive p-3">
                                <table id="resourcesTable" class="table table-hover w-100">
                                    <thead><tr><th>ID</th><th>Nom</th><th>Type</th><th>Quantité</th><th>Actions</th></tr></thead>
                                    <tbody>
                                        <?php foreach($resources as $r): ?>
                                        <tr>
                                            <td><?= $r['id'] ?></td>
                                            <td><?= htmlspecialchars($r['name']) ?></td>
                                            <td><?= htmlspecialchars($r['type']) ?></td>
                                            <td class="<?= (int)$r['quantity'] <= 2 ? 'text-danger fw-bold' : '' ?>"><?= $r['quantity'] ?></td>
                                            <td>
                                                <a href="index.php?action=form_resource&id=<?= $r['id'] ?>" class="btn btn-sm btn-info me-1"><i class="fa fa-edit"></i></a>
                                                <a href="index.php?action=delete_resource&id=<?= $r['id'] ?>" onclick="return confirm('Sûr?')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../darkpan/js/main.js"></script>

    <!-- DataTables & Buttons -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <script>
        // API Simulation Function
        function simulateApi(service) {
            let msg = "";
            let color = "#00ffcc";
            
            if(service === 'Stripe') {
                msg = "Connexion sécurisée à Stripe Gateway... \nStatut: Prêt pour les paiements en ligne.";
                color = "#6772e5";
            } else if(service === 'SendGrid') {
                msg = "Test d'envoi SendGrid réussi ! \nDestinataire: admin@votre-projet.com \nStatut: Délivré.";
                color = "#1296ba";
            } else if(service === 'Google Calendar') {
                msg = "Synchronisation avec Google Calendar en cours... \nStatut: 4 événements importés.";
                color = "#4285f4";
            } else if(service === 'OCR') {
                msg = "Démarrage du moteur OCR... \nAnalyse du document en cours... \nRésultat: Texte extrait avec 98% de précision.";
                color = "#17a2b8";
            } else if(service === 'Prediction') {
                msg = "Modèle Hugging Face (Bert-base) chargé. \nAnalyse prédictive: Forte probabilité de succès pour l'événement (89%).";
                color = "#ffc107";
            } else if(service === 'ChatBot') {
                msg = "Assistant IA (GPT-4o) connecté. \nComment puis-je vous aider à gérer vos événements aujourd'hui ?";
                color = "#00ffcc";
            }

            alert("🌐 [Advanced AI Service] " + service + "\n" + "----------------------------------\n" + msg);
        }

        // Leaflet Map Initialization
        const map = L.map('map').setView([36.8065, 10.1815], 11);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        // Markers for events
        <?php foreach($events as $e): ?>
            L.marker([36.8 + (Math.random() * 0.1), 10.1 + (Math.random() * 0.1)]).addTo(map)
                .bindPopup("<b><?= htmlspecialchars($e['title']) ?></b><br><?= htmlspecialchars($e['location']) ?>");
        <?php endforeach; ?>

        // FullCalendar Initialization
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 350,
                headerToolbar: { left: 'prev,next', center: 'title', right: '' },
                events: [
                    <?php foreach($events as $e): ?>
                    {
                        title: '<?= addslashes($e['title']) ?>',
                        start: '<?= date('Y-m-d\TH:i:s', strtotime($e['date'])) ?>',
                        color: '#eb1616'
                    },
                    <?php endforeach; ?>
                ]
            });
            calendar.render();
        });

        $(document).ready(function() {
            const tableConfig = {
                language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json' },
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                pageLength: 5,
                responsive: true
            };
            $('#eventsTable').DataTable(tableConfig);
            $('#resourcesTable').DataTable(tableConfig);
        });

        Chart.defaults.color = "#888";
        Chart.defaults.borderColor = "rgba(255,255,255,0.05)";

        const lineCtx = document.getElementById('line-chart');
        if(lineCtx) {
            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: <?= json_encode($months) ?>,
                    datasets: [{
                        label: "Événements",
                        data: <?= json_encode($monthCounts) ?>,
                        borderColor: "#eb1616",
                        backgroundColor: "rgba(235, 22, 22, .3)",
                        fill: true, tension: 0.4
                    }]
                },
                options: { maintainAspectRatio: false }
            });
        }

        const doughnutCtx = document.getElementById('doughnut-chart');
        if(doughnutCtx) {
            new Chart(doughnutCtx, {
                type: 'doughnut',
                data: {
                    labels: <?= json_encode($resTypes) ?>,
                    datasets: [{
                        data: <?= json_encode($resTypeCounts) ?>,
                        backgroundColor: ["#eb1616", "#00ffcc", "#ffcc00", "#36a2eb", "#9966ff"],
                        borderWidth: 0
                    }]
                },
                options: { maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
            });
        }

        const barCtx = document.getElementById('bar-chart');
        if(barCtx) {
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($locNames) ?>,
                    datasets: [{
                        label: "Nombre",
                        data: <?= json_encode($locCounts) ?>,
                        backgroundColor: "#00ffcc"
                    }]
                },
                options: { maintainAspectRatio: false }
            });
        }

        const polarCtx = document.getElementById('polar-chart');
        if(polarCtx) {
            new Chart(polarCtx, {
                type: 'polarArea',
                data: {
                    labels: <?= json_encode($rangeLabels) ?>,
                    datasets: [{
                        data: <?= json_encode($rangeCounts) ?>,
                        backgroundColor: ["#eb1616", "#ffcc00", "#00ffcc"]
                    }]
                },
                options: { maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
            });
        }
    </script>
</body>
</html>
