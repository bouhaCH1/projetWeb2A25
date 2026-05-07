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
        /* AI Modal Styles */
        #ai-modal .modal-content { background: #191c24; color: #fff; border: 1px solid #eb1616; border-radius: 15px; }
        #ai-modal .modal-header { border-bottom: 1px solid #333; }
        #ai-modal .modal-footer { border-top: 1px solid #333; }
        .ai-spinner { width: 3rem; height: 3rem; color: #eb1616; }
        
        /* Floating Chat Button & Window */
        #chat-btn { position: fixed; bottom: 20px; right: 20px; width: 60px; height: 60px; background: #eb1616; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.5); z-index: 1000; transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); cursor: pointer; border: none; }
        #chat-btn:hover { transform: scale(1.1) rotate(15deg); background: #00ffcc; color: #191c24; }
        
        #chat-window { position: fixed; bottom: 90px; right: 20px; width: 350px; height: 480px; background: rgba(25, 28, 36, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; display: none; flex-direction: column; z-index: 1001; box-shadow: 0 15px 35px rgba(0,0,0,0.9); overflow: hidden; transition: all 0.3s ease; }
        #chat-header { background: linear-gradient(135deg, #eb1616, #8b0000); padding: 15px; color: #fff; font-weight: bold; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        #chat-messages { flex: 1; padding: 15px; overflow-y: auto; display: flex; flex-direction: column; gap: 12px; scroll-behavior: smooth; }
        .msg { max-width: 85%; padding: 10px 14px; border-radius: 15px; font-size: 14px; line-height: 1.4; animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .msg-ai { background: #333; color: #00ffcc; align-self: flex-start; border-bottom-left-radius: 2px; border: 1px solid rgba(0,255,204,0.1); }
        .msg-user { background: #eb1616; color: #fff; align-self: flex-end; border-bottom-right-radius: 2px; box-shadow: 0 2px 10px rgba(235,22,22,0.3); }
        #chat-input-area { padding: 12px; background: rgba(0,0,0,0.3); display: flex; gap: 10px; border-top: 1px solid rgba(255,255,255,0.05); }
        #chat-input { background: rgba(25, 28, 36, 0.8); border: 1px solid #444; color: #fff; border-radius: 25px; padding: 8px 18px; flex: 1; outline: none; transition: border-color 0.3s; }
        #chat-input:focus { border-color: #eb1616; }
        #chat-send { background: #eb1616; border: none; color: #fff; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; transition: background 0.3s; }
        #chat-send:hover { background: #ff3333; }
        
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
                    <a href="index.php?action=inbox" class="nav-item nav-link"><i class="fa fa-envelope me-2"></i>Boîte d'Envoi</a>
                    <a href="index.php?action=form_event" class="nav-item nav-link"><i class="fa fa-calendar-plus me-2"></i>Nouveau Event</a>
                    <a href="index.php?action=form_resource" class="nav-item nav-link"><i class="fa fa-plus-square me-2"></i>Nouvelle Ressource</a>
                    <a href="index.php" class="nav-item nav-link"><i class="fa fa-home me-2"></i>Retour Site</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- AI Result Modal -->
            <div class="modal fade" id="aiModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-dark border-primary">
                        <div class="modal-header">
                            <h5 class="modal-title text-primary" id="aiModalLabel">Analyse IA en cours...</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center p-5" id="aiModalBody">
                            <div class="spinner-border text-primary ai-spinner mb-3" role="status"></div>
                            <p class="mb-0">Traitement des données via le moteur IA...</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="#" class="sidebar-toggler flex-shrink-0"><i class="fa fa-bars"></i></a>
                <div class="navbar-nav align-items-center ms-auto">
                    <span class="text-muted d-none d-lg-inline">Système Opérationnel</span>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- AI Chat Interface -->
            <div id="chat-window">
                <div id="chat-header">
                    <span><i class="fa fa-robot me-2"></i>Assistant IA Pro</span>
                    <button class="btn btn-sm text-white" onclick="toggleChat()"><i class="fa fa-times"></i></button>
                </div>
                <div id="chat-messages">
                    <div class="msg msg-ai">Bonjour ! Je suis l'IA de votre site. Comment puis-je vous aider aujourd'hui ?</div>
                </div>
                <div id="chat-input-area">
                    <input type="text" id="chat-input" placeholder="Posez une question..." onkeypress="if(event.key==='Enter') sendMessage()">
                    <button id="chat-send" onclick="sendMessage()"><i class="fa fa-paper-plane"></i></button>
                </div>
            </div>

            <button id="chat-btn" onclick="toggleChat()">
                <i class="fa fa-comments"></i>
            </button>

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
        // Professional AI Simulation
        function simulateApi(service) {
            const modal = new bootstrap.Modal(document.getElementById('aiModal'));
            const label = document.getElementById('aiModalLabel');
            const body = document.getElementById('aiModalBody');
            
            label.innerText = "IA : Analyse de " + service + "...";
            body.innerHTML = `
                <div class="spinner-border text-danger ai-spinner mb-3" role="status"></div>
                <p class="text-white">Connexion aux serveurs de calcul haute performance...</p>
            `;
            modal.show();

            setTimeout(() => {
                let result = "";
                if(service === 'OCR') {
                    result = `
                        <div class="text-start">
                            <h6 class="text-info"><i class="fa fa-file-alt me-2"></i>Texte Extrait (OCR) :</h6>
                            <pre class="bg-black p-3 rounded small text-light" style="white-space: pre-wrap;">
Facture #4509
Date: 06/05/2026
Client: Ayoub Event Pro
Total: 1,250.00 TND
Statut: Payé
                            </pre>
                            <p class="small text-success"><i class="fa fa-check-circle me-1"></i>Analyse terminée avec 98.4% de confiance.</p>
                        </div>
                    `;
                } else if(service === 'Prediction') {
                    result = `
                        <div class="p-3">
                            <h6 class="text-warning mb-3"><i class="fa fa-magic me-2"></i>Prédiction de Succès (H.Face) :</h6>
                            <div class="progress mb-3" style="height: 25px; background: #333;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: 89%">89%</div>
                            </div>
                            <p class="text-white small">Analyse basée sur les <b><?= count($events) ?> événements</b> passés. Probabilité de succès élevée pour votre prochain événement !</p>
                        </div>
                    `;
                } else if(service === 'Stripe') {
                    result = `<div class="p-4"><i class="fab fa-stripe fa-4x text-primary mb-3"></i><h5 class="text-white">Passerelle de Paiement</h5><p>Module Stripe prêt pour les transactions. (TND activé)</p></div>`;
                }
                body.innerHTML = result;
                label.innerText = "IA : Résultat de " + service;
            }, 2500);
        }

        // Real-time Chat Logic
        function toggleChat() {
            const win = document.getElementById('chat-window');
            win.style.display = (win.style.display === 'flex') ? 'none' : 'flex';
        }

        function sendMessage() {
            const input = document.getElementById('chat-input');
            const text = input.value.trim();
            if(!text) {
                input.style.borderColor = '#eb1616';
                setTimeout(() => input.style.borderColor = '#444', 1000);
                return;
            }

            addMessage(text, 'user');
            input.value = '';

            // AI Expert Logic (Context-Aware)
            setTimeout(() => {
                const t = text.toLowerCase().trim();
                let reply = "Sem7ni, ma fhimtech barch klemek, ama tnajem teselny 3al events, stock, wela el météo! 🤖";
                
                const events = <?= json_encode($events) ?>;
                const resources = <?= json_encode($resources) ?>;

                // 1. Weather (Meteo / Ta9es / Weather)
                if(t.includes('meteo') || t.includes('ta9es') || t.includes('temps') || t.includes('weather')) {
                    reply = "El ta9es lyoum fi Tunis 24°C, chams mezyena! ☀️ C'est parfait pour vos activités.";
                }
                // 2. Next Event Logic (Wakteh / Jey / Next / Prochain / Upcoming)
                else if(t.includes('wakteh') || t.includes('jey') || t.includes('next') || t.includes('prochain') || t.includes('wa9t') || t.includes('upcoming')) {
                    const now = new Date();
                    let nextEvent = null;
                    events.forEach(e => {
                        const ed = new Date(e.date);
                        if(ed > now && (!nextEvent || ed < new Date(nextEvent.date))) nextEvent = e;
                    });
                    if(nextEvent) reply = "L'événement el jey howa: '" + nextEvent.title + "' le " + nextEvent.date + " fi " + nextEvent.location + ". 📅";
                    else reply = "Mafama hata événement jey (upcoming) fel wa9t el 7ather. 3andek " + events.length + " events lkol.";
                }
                // 3. Location Logic (Win / Fin / Location / Blasa / Localisation / Carte / Map)
                else if(t.includes('win') || t.includes('fin') || t.includes('location') || t.includes('blasa') || t.includes('blasat') || t.includes('localisation') || t.includes('carte') || t.includes('map')) {
                    const counts = {};
                    events.forEach(e => counts[e.location] = (counts[e.location] || 0) + 1);
                    const top = Object.keys(counts).reduce((a, b) => (counts[a] || 0) > (counts[b] || 0) ? a : b, 'Tunis');
                    reply = "Akther blasa fiha 7arka hiya " + top + ". Tnajem tchouf les localisations lkol fel carte (Map) houni! 🗺️";
                }
                // 4. Resources/Stock Logic (9adech / stock / ressource / fama / quantité / recourse)
                else if(t.includes('9adech') || t.includes('stock') || t.includes('ressource') || t.includes('fama') || t.includes('quantité') || t.includes('recourse')) {
                    const low = resources.filter(r => parseInt(r.quantity) < 3);
                    reply = "El stock fih " + resources.length + " types. 📦 \n⚠️ Alerte: " + low.length + " ressources 9rib youfaw (e.g. " + (low[0]?.name || 'matériel') + ").";
                }
                // 5. Planning/Calendar Logic
                else if(t.includes('planning') || t.includes('calendrier') || t.includes('calendar')) {
                    reply = "El Planning mte3ek fih kol chay (dates w evènements). Tnajem t'accedi l'FullCalendar men houni bech t-sync-i el wa9t! 🗓️";
                }
                // 6. Users Logic
                else if(t.includes('user') || t.includes('utilisateur') || t.includes('nes') || t.includes('client')) {
                    reply = "Les utilisateurs (clients) yesta3mlou el site mte3ek bech ychoufou el events w y-reserviw. Kol chay m-organisé houni!";
                }
                // 7. Greetings
                else if(t.includes('aslama') || t.includes('3aslama') || t.includes('labes') || t.includes('bonjour') || t.includes('salut') || t.includes('hello')) {
                    reply = "Aslama ya m3alem! 👋 Ena l'IA mte3ek. Teselny njewbek 3al site kollo (Stock, Planning, Maps, etc.)!";
                }
                // 6. Site Explanation / Métier (Simple & Avancé)
                else if(t.includes('metier') || t.includes('métier') || t.includes('fika') || t.includes('service') || t.includes('kifech')) {
                    reply = "Le site gère tout le 'Métier': \n- Simple: Tri, Recherche, Export (PDF/Excel), et Stats.\n- Avancé: Météo, IA Prédiction, OCR, et Chat interactif.";
                }
                else if(t.includes('ocr') || t.includes('lecture') || t.includes('document')) {
                    reply = "L'OCR na9ra biha el wra9 (PDF/Images) bech n'extrayi el texte automatiquement. Démarré avec 98% de précision! 📄";
                }
                else if(t.includes('prediction') || t.includes('najeh') || t.includes('face')) {
                    reply = "El IA (Hugging Face) ta3tik el 'Prédiction' mte3 el naje7 mte3 el event 7asb el data mte3ek. 🔮";
                }
                else if(t.includes('export') || t.includes('pdf') || t.includes('excel') || t.includes('imprimer')) {
                    reply = "Tnajem t'exporti kol chay (PDF, Excel, CSV) mel boutons eli fou9 el tableau mte3 el events/ressources. 📥";
                }
                else if(t.includes('recherche') || t.includes('tri') || t.includes('pagination')) {
                    reply = "El recherche wel tri automatiques houni (DataTables). Just ekteb esm el event fi 'Search' wela cliqui 3al colonnes! 🔍";
                }
                else if(t.includes('mail') || t.includes('email') || t.includes('envoyer')) {
                    reply = "Système d'Emails Automatiques (SendGrid) prêt bech yab3ath les confirmations l'ay client automatiquement. ✉️";
                }
                else if(t.includes('paiement') || t.includes('argent') || t.includes('stripe') || t.includes('rib') || t.includes('carte') || t.includes('methode')) {
                    reply = "Le module de Paiement Stripe est configuré. 💳 \nVous pouvez gérer le RIB, l'email et les montants dans 'Méthode de Paiement'.";
                }
                else if(t.includes('calendar') || t.includes('google') || t.includes('sync') || t.includes('calendrier')) {
                    reply = "La synchronisation Google Calendar est active. 📅 \nTous vos événements sont planifiés automatiquement sur votre calendrier.";
                }
                // 7. Global Site Search (Last resort before default)
                else {
                    let found = false;
                    // Search in Events
                    events.forEach(e => {
                        if(t.includes(e.title.toLowerCase()) || t.includes(e.location.toLowerCase())) {
                            reply = "J'ai trouvé l'événement: '" + e.title + "' le " + e.date + " à " + e.location + ". 📍";
                            found = true;
                        }
                    });
                    // Search in Resources
                    if(!found) {
                        resources.forEach(r => {
                            if(t.includes(r.name.toLowerCase())) {
                                reply = "La ressource '" + r.name + "' est disponible en stock (Quantité: " + r.quantity + "). 📦";
                                found = true;
                            }
                        });
                    }
                    // Search in Menu / General Keywords
                    if(!found) {
                        if(t.includes('event')) reply = "Vous avez " + events.length + " événements. Cliquez sur 'Nouveau Event' à gauche pour en ajouter un.";
                        else if(t.includes('ressource')) reply = "Il y a " + resources.length + " ressources. Gérez-les via le menu 'Nouvelle Ressource'.";
                        else if(t.includes('dashboard') || t.includes('tableau')) reply = "C'est votre tableau de bord principal avec KPIs, Cartes et Graphiques.";
                    }
                }
                
                // 8. Appreciation
                if(t.includes('m3alem') || t.includes('merci') || t.includes('bravo') || t.includes('ya3tik')) {
                    reply = "Ya m3alem enta! Men wejbi. 🚀🔥";
                }
                
                addMessage(reply, 'ai');
            }, 800);
        }

        function addMessage(text, type) {
            const area = document.getElementById('chat-messages');
            const div = document.createElement('div');
            div.className = 'msg msg-' + type;
            div.innerText = text;
            area.appendChild(div);
            area.scrollTop = area.scrollHeight;
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
