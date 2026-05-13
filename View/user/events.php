<?php
$pageTitle = 'Événements & Services';
require_once __DIR__ . '/../layout/pl_dashboard_header.php';
?>
<style>
    .table-custom { width: 100%; border-collapse: collapse; margin-bottom: 30px; color: #fff; }
    .table-custom th, .table-custom td { padding: 12px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1); }
    .table-custom th { background-color: rgba(255,255,255,0.05); font-weight: 600; color: #00ffcc; }
    .btn-action { padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 13px; font-weight: bold; margin-right: 5px; display: inline-block; }
    .btn-pay { background: #6772e5; color: #fff; } /* Stripe Color */
    .btn-cal { background: #4285f4; color: #fff; } /* Google Color */
    .btn-pay:hover, .btn-cal:hover { opacity: 0.9; transform: translateY(-1px); }
</style>

    <section class="dashboard-section" style="padding-top: 40px; min-height: 100vh;">
        <div class="dashboard-container">
            <h2 class="section-title text-white mb-4">Découvrez nos Événements & Services</h2>

            <h3 style="color: #fff; margin-bottom: 20px;"><i class="fa fa-calendar-alt me-2" style="color: #00ffcc;"></i>Prochains Événements</h3>
            <div style="background: rgba(255,255,255,0.05); border-radius: 15px; padding: 25px; margin-bottom: 40px; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                <table class="table-custom">
                    <thead>
                        <tr><th>Titre</th><th>Date</th><th>Lieu</th><th>Réservation</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events as $event): ?>
                        <tr>
                            <td style="font-weight: bold;"><?= htmlspecialchars($event['title']) ?></td>
                            <td><?= date('d M Y, H:i', strtotime($event['date'])) ?></td>
                            <td><i class="fa fa-map-marker-alt me-2" style="color: #ff6b6b;"></i><?= htmlspecialchars($event['location']) ?></td>
                            <td>
                                <a href="#" class="btn-action btn-pay" onclick="openPayment('<?= addslashes($event['title']) ?>')">
                                    <i class="fab fa-stripe me-1"></i> Payer
                                </a>
                                <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text=<?= urlencode($event['title']) ?>" target="_blank" class="btn-action btn-cal">
                                    <i class="fab fa-google me-1"></i> + Cal
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($events)): ?>
                        <tr><td colspan="4" class="text-center text-muted">Aucun événement à venir.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <h3 style="color: #fff; margin-bottom: 20px;"><i class="fa fa-tools me-2" style="color: #00ffcc;"></i>Ressources Disponibles</h3>
            <div style="background: rgba(255,255,255,0.05); border-radius: 15px; padding: 25px; margin-bottom: 40px; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                <table class="table-custom">
                    <thead>
                        <tr><th>Nom</th><th>Type</th><th>Stock</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resources as $res): ?>
                        <tr>
                            <td><?= htmlspecialchars($res['name']) ?></td>
                            <td><span class="badge" style="background: rgba(0,255,204,0.1); color: #00ffcc; padding: 5px 10px; border-radius: 20px; font-size: 11px;"><?= htmlspecialchars($res['type']) ?></span></td>
                            <td><?= htmlspecialchars($res['quantity']) ?></td>
                            <td>
                                <button class="btn-action" style="background: rgba(255,255,255,0.1); color: #fff; border: none; cursor: pointer;" onclick="alert('Notification envoyée au responsable via SendGrid !')">
                                    <i class="fa fa-envelope me-1"></i> Info
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($resources)): ?>
                        <tr><td colspan="4" class="text-center text-muted">Aucune ressource disponible.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Modal Paiement -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white border-primary shadow-lg">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title"><i class="fab fa-stripe me-2 text-primary"></i>Passerelle de Paiement Sécurisée</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="paymentForm">
                        <div class="mb-3">
                            <label class="small text-white-50">RIB / Numéro de Carte</label>
                            <input type="text" id="pay-rib" class="form-control bg-secondary text-white border-0" placeholder="TN59 1234..." required>
                        </div>
                        <div class="mb-3">
                            <label class="small text-white-50">Email de Facturation</label>
                            <input type="email" id="pay-email" class="form-control bg-secondary text-white border-0" placeholder="ayoub@mail.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="small text-white-50">Montant (TND)</label>
                            <input type="number" id="pay-amount" class="form-control bg-secondary text-white border-0" value="150" required>
                        </div>
                        <div id="pay-success" class="alert alert-success d-none">
                            <i class="fa fa-check-circle me-2"></i>Paiement validé avec succès !
                        </div>
                        <button type="submit" id="btn-submit-pay" class="btn btn-primary w-100" style="background:#6772e5;border:none;">Confirmer le Paiement</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    function openPayment(title) {
        // Bootstrap is already loaded from pl_dashboard_header.php
        const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
        modal.show();
    }

    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('btn-submit-pay');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Validation...';

        const fd = new FormData();
        fd.append('rib', document.getElementById('pay-rib').value);
        fd.append('email', document.getElementById('pay-email').value);
        fd.append('amount', document.getElementById('pay-amount').value);

        fetch('index.php?action=save_payment', {
            method: 'POST',
            body: fd
        })
        .then(res => res.text())
        .then(data => {
            if(data === 'success') {
                document.getElementById('pay-success').classList.remove('d-none');
                setTimeout(() => {
                    location.reload();
                }, 1500);
            }
        });
    });
    </script>
<?php require_once __DIR__ . '/../layout/pl_dashboard_footer.php'; ?>
