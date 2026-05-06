<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Config Service - <?= htmlspecialchars($_GET['service']) ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="../darkpan/css/bootstrap.min.css" rel="stylesheet">
    <link href="../darkpan/css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid position-relative d-flex p-0">
        <div class="content w-100">
            <div class="container-fluid pt-4 px-4">
                <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                        <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h3 class="text-primary"><i class="fa fa-plug me-2"></i>API : <?= htmlspecialchars($_GET['service']) ?></h3>
                                <a href="index.php?action=admin" class="btn btn-sm btn-outline-light">Retour</a>
                            </div>

                            <?php if($_GET['service'] == 'Stripe'): ?>
                                <div class="alert alert-primary">
                                    <h6><i class="fab fa-stripe me-2"></i>Passerelle de Paiement Stripe</h6>
                                    <p class="small">Configurez les informations de transaction et les détails du compte de réception.</p>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="text-white mb-3">Informations de Réception (Virement)</h6>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="rib" placeholder="Numéro de RIB" value="TN59 1234 5678 9012 3456 7890">
                                            <label for="rib">Numéro de RIB / IBAN</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h6 class="text-white mb-3">Détails de Paiement Client</h6>
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="email" placeholder="Email" value="client@exemple.com">
                                            <label for="email">Adresse Email du Client</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="card" placeholder="N° Carte Bancaire" value="4242 4242 4242 4242">
                                            <label for="card">Numéro de Carte Bancaire (16 chiffres)</label>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="expiry" placeholder="MM/YY" value="12/28">
                                                    <label for="expiry">Date d'expiration</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="cvc" placeholder="CVC" value="123">
                                                    <label for="cvc">CVC / Code</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h6 class="text-white mb-3">Transaction</h6>
                                        <div class="form-floating mb-4">
                                            <input type="number" class="form-control" id="amount" placeholder="Somme" value="150.00">
                                            <label for="amount">La Somme à Prélever (TND)</label>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary w-100 py-3 shadow" id="btn-pay" onclick="processPayment()">
                                    <i class="fa fa-lock me-2"></i>Valider & Traiter le Paiement
                                </button>

                                <script>
                                function processPayment() {
                                    const btn = document.getElementById('btn-pay');
                                    const originalText = btn.innerHTML;
                                    
                                    // Simulation de chargement
                                    btn.disabled = true;
                                    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Traitement sécurisé en cours...';
                                    
                                    setTimeout(() => {
                                        alert("✅ Succès ! \nLe paiement de " + document.getElementById('amount').value + " TND a été traité avec succès via Stripe. \nUn email de confirmation a été envoyé à " + document.getElementById('email').value);
                                        btn.disabled = false;
                                        btn.innerHTML = originalText;
                                    }, 2500);
                                }
                                </script>

                            <?php elseif($_GET['service'] == 'SendGrid'): ?>
                                <div class="alert alert-info">
                                    <h6><i class="fa fa-envelope me-2"></i>Configuration Email SendGrid</h6>
                                    <p>Paramétrez l'envoi automatique de confirmations.</p>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="API Key" value="SG.xxxx.xxxx">
                                    <label>Clé API SendGrid</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" placeholder="Sender Email" value="admin@votre-projet.com">
                                    <label>Email de l'expéditeur vérifié</label>
                                </div>
                                <button class="btn btn-info w-100 py-3">Tester la Connexion</button>

                            <?php elseif($_GET['service'] == 'Google Calendar'): ?>
                                <div class="alert alert-warning">
                                    <h6><i class="fa fa-calendar-alt me-2"></i>Google Calendar Sync</h6>
                                    <p>Synchronisez vos événements avec les agendas de vos clients.</p>
                                </div>
                                <div class="bg-dark p-3 rounded mb-3">
                                    <p class="mb-0 small">Statut : <span class="text-success">Connecté</span></p>
                                    <p class="mb-0 small">Dernière Sync : Il y a 10 minutes</p>
                                </div>
                                <button class="btn btn-warning w-100 py-3">Forcer la Synchronisation</button>
                            <?php endif; ?>
                            
                            <hr class="my-4">
                            <p class="text-muted small text-center">Service fourni par ER PRO API Hub</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
