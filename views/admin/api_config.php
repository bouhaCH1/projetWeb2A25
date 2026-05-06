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
                            <div id="api-content">
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
                                        <input type="text" id="rib" class="form-control" placeholder="20 chiffres" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        <div id="err-rib" class="error-feedback">Veuillez saisir votre RIB (min. 10 car.)</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="text-white small">Email Client</label>
                                        <input type="email" id="email" class="form-control" placeholder="exemple@mail.com">
                                        <div id="err-email" class="error-feedback">Email valide obligatoire</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="text-white small">N° Carte Bancaire</label>
                                        <input type="text" id="card" class="form-control" placeholder="16 chiffres" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        <div id="err-card" class="error-feedback">16 chiffres requis</div>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label class="text-white small">Montant (TND)</label>
                                        <input type="number" id="amount" class="form-control" placeholder="0.00">
                                        <div id="err-amount" class="error-feedback">Le montant doit être supérieur à 0</div>
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

                                    // Strict numeric RIB (20 digits for Tunisia)
                                    const ribRegex = /^\d{20}$/;
                                    if(!ribRegex.test(rib)){ 
                                        document.getElementById('err-rib').innerText = "Le RIB doit contenir exactement 20 chiffres.";
                                        document.getElementById('err-rib').style.display='block'; 
                                        v=false; 
                                    }
                                    
                                    // Strict Email Regex
                                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                                    if(!emailRegex.test(email)){ document.getElementById('err-email').style.display='block'; v=false; }
                                    
                                    // Strict 16-digit Card Regex
                                    if(!/^\d{16}$/.test(card)){ document.getElementById('err-card').style.display='block'; v=false; }
                                    
                                    if(isNaN(amount) || amount <= 0){ document.getElementById('err-amount').style.display='block'; v=false; }
                                    
                                    if(!v) return;
                                    
                                    const b = document.getElementById('btn-pay');
                                    b.disabled = true; b.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Traitement...';
                                    
                                    // AJAX Save to Database
                                    const formData = new FormData();
                                    formData.append('rib', rib);
                                    formData.append('email', email);
                                    formData.append('amount', amount);

                                    fetch('index.php?action=save_payment', {
                                        method: 'POST',
                                        body: formData
                                    })
                                    .then(response => response.text())
                                    .then(data => {
                                        if(data === 'success') {
                                            setTimeout(() => { 
                                                b.disabled = false; 
                                                b.innerHTML = 'Valider le Paiement'; 
                                                document.getElementById('success-msg').classList.remove('d-none');
                                            }, 1500);
                                        }
                                    });
                                }
                                </script>

                            <?php elseif($_GET['service'] == 'SendGrid'): ?>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="text-white small">SendGrid API Key</label>
                                        <input type="password" id="sg-key" class="form-control" placeholder="SG.xxxxx...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-white small">Email Expéditeur (Vérifié)</label>
                                        <input type="email" id="sg-from" class="form-control" placeholder="admin@domaine.com">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-white small">Email Destinataire</label>
                                        <input type="email" id="sg-to" class="form-control" placeholder="client@mail.com">
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label class="text-white small">Message Test</label>
                                        <textarea id="sg-msg" class="form-control">Ceci est un test de notification réelle depuis Event Pro AI.</textarea>
                                    </div>
                                </div>
                                <button class="btn btn-info w-100 py-3" id="btn-email" onclick="sendTestEmail()">Tester l'envoi réel</button>
                                <div id="email-success" class="alert alert-success mt-3 d-none">Email envoyé avec succès !</div>
                                <div id="email-error" class="alert alert-danger mt-3 d-none">Erreur lors de l'envoi (vérifiez votre clé).</div>

                                <script>
                                function sendTestEmail() {
                                    const b = document.getElementById('btn-email');
                                    const s = document.getElementById('email-success');
                                    const e = document.getElementById('email-error');
                                    
                                    s.classList.add('d-none');
                                    e.classList.add('d-none');
                                    b.disabled = true; b.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Envoi...';

                                    const fd = new FormData();
                                    fd.append('key', document.getElementById('sg-key').value);
                                    fd.append('from', document.getElementById('sg-from').value);
                                    fd.append('to', document.getElementById('sg-to').value);
                                    fd.append('subject', 'Test Notification Réelle - Event Pro');
                                    fd.append('message', document.getElementById('sg-msg').value);

                                    fetch('index.php?action=send_email', {
                                        method: 'POST',
                                        body: fd
                                    })
                                    .then(r => r.text())
                                    .then(data => {
                                        b.disabled = false; b.innerHTML = "Tester l'envoi réel";
                                        if(data === 'success') s.classList.remove('d-none');
                                        else e.classList.remove('d-none');
                                    });
                                }
                                </script>

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
