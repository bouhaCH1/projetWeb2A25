<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Config Service - <?= htmlspecialchars($_GET['service']) ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="../darkpan/css/bootstrap.min.css" rel="stylesheet">
    <link href="../darkpan/css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    
    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

    <style>
        .error-feedback { color: #eb1616; font-size: 12px; margin-top: 4px; display: none; font-weight: 500; }
        #calendar { background: #191c24; padding: 20px; border-radius: 10px; border: 1px solid #333; }
        .fc-header-toolbar { color: #fff; }
        .fc-daygrid-day-number { color: #fff; text-decoration: none; }
        .fc-col-header-cell-cushion { color: #00ffcc; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container-fluid position-relative d-flex p-0">
        <div class="content w-100">
            <div class="container-fluid pt-4 px-4">
                <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                    <div class="col-12 col-sm-12 col-md-10 col-lg-8">
                        <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3 shadow-lg">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h3 class="text-primary"><i class="fa fa-plug me-2"></i><?= htmlspecialchars($_GET['service']) ?></h3>
                                <a href="index.php?action=admin" class="btn btn-sm btn-outline-light">Retour Dashboard</a>
                            </div>

                            <?php if($_GET['service'] == 'Stripe'): ?>
                                <!-- Stripe Section (Same as before) -->
                                <div class="alert alert-primary">
                                    <h6><i class="fab fa-stripe me-2"></i>Passerelle de Paiement Stripe</h6>
                                    <p class="small">Détails de la transaction sécurisée.</p>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="text-white small">RIB / IBAN</label>
                                        <input type="text" id="rib" class="form-control" value="TN59 1234 5678 9012 3456 7890">
                                        <div id="err-rib" class="error-feedback">RIB invalide</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="text-white small">Email Client</label>
                                        <input type="email" id="email" class="form-control" value="client@exemple.com">
                                        <div id="err-email" class="error-feedback">Email invalide</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="text-white small">N° Carte Bancaire</label>
                                        <input type="text" id="card" class="form-control" value="4242 4242 4242 4242">
                                        <div id="err-card" class="error-feedback">16 chiffres requis</div>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label class="text-white small">Montant (TND)</label>
                                        <input type="number" id="amount" class="form-control" value="150.00">
                                        <div id="err-amount" class="error-feedback">Montant invalide</div>
                                    </div>
                                </div>
                                <button class="btn btn-primary w-100 py-3 shadow" id="btn-pay" onclick="processPayment()">Valider le Paiement</button>
                                <div id="success-msg" class="alert alert-success mt-4 d-none">
                                    <i class="fa fa-check-circle me-2"></i>Paiement validé avec succès !
                                </div>

                                <script>
                                function processPayment() {
                                    // Reset errors
                                    document.querySelectorAll('.error-feedback').forEach(e => e.style.display='none');
                                    document.getElementById('success-msg').classList.add('d-none');

                                    let v = true;
                                    const rib = document.getElementById('rib').value.trim();
                                    const email = document.getElementById('email').value.trim();
                                    const card = document.getElementById('card').value.replace(/\s/g,'');
                                    const amount = parseFloat(document.getElementById('amount').value);

                                    if(rib.length < 10){ document.getElementById('err-rib').style.display='block'; v=false; }
                                    if(!email.includes('@') || email.length < 5){ document.getElementById('err-email').style.display='block'; v=false; }
                                    if(card.length != 16 || isNaN(card)){ document.getElementById('err-card').style.display='block'; v=false; }
                                    if(isNaN(amount) || amount <= 0){ document.getElementById('err-amount').style.display='block'; v=false; }
                                    
                                    if(!v) return;
                                    
                                    const b = document.getElementById('btn-pay');
                                    b.disabled = true; b.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Traitement...';
                                    
                                    setTimeout(() => { 
                                        b.disabled = false; 
                                        b.innerHTML = 'Valider le Paiement'; 
                                        document.getElementById('success-msg').classList.remove('d-none');
                                    }, 2000);
                                }
                                </script>

                            <?php elseif($_GET['service'] == 'SendGrid'): ?>
                                <div class="alert alert-info">
                                    <h6><i class="fa fa-envelope me-2"></i>Emails Automatiques</h6>
                                    <p class="small">Notifications système actives.</p>
                                </div>
                                <button class="btn btn-info w-100 py-3">Tester l'envoi global</button>

                            <?php elseif($_GET['service'] == 'Google Calendar'): ?>
                                <div class="alert alert-warning mb-4">
                                    <h6><i class="fa fa-calendar-alt me-2"></i>Synchronisation G-Calendar</h6>
                                    <p class="small">Visualisez vos événements directement dans le calendrier synchronisé.</p>
                                </div>
                                
                                <!-- Visual Calendar -->
                                <div id='calendar'></div>

                                <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var calendarEl = document.getElementById('calendar');
                                    var calendar = new FullCalendar.Calendar(calendarEl, {
                                        initialView: 'dayGridMonth',
                                        themeSystem: 'bootstrap5',
                                        headerToolbar: {
                                            left: 'prev,next today',
                                            center: 'title',
                                            right: 'dayGridMonth,timeGridWeek'
                                        },
                                        events: [
                                            <?php foreach($events as $e): ?>
                                            {
                                                title: '<?= addslashes($e['title']) ?>',
                                                start: '<?= date('Y-m-d\TH:i:s', strtotime($e['date'])) ?>',
                                                color: '#eb1616',
                                                description: '<?= addslashes($e['location']) ?>'
                                            },
                                            <?php endforeach; ?>
                                        ],
                                        eventClick: function(info) {
                                            // Silently ignore or show in a div, but NO ALERT
                                        }
                                    });
                                    calendar.render();
                                });
                                </script>
                            <?php endif; ?>
                            
                            <hr class="my-4">
                            <p class="text-muted small text-center">Propulsé par EventResource API Hub</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
