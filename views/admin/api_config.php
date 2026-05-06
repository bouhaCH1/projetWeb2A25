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
                                    <h6><i class="fab fa-stripe me-2"></i>Configuration Stripe Gateway</h6>
                                    <p>Connectez votre compte pour accepter les paiements par carte bancaire.</p>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Clé Publique" value="pk_test_51...xxxx">
                                    <label>Clé Publique (Publishable Key)</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" placeholder="Clé Secrète" value="sk_test_51...xxxx">
                                    <label>Clé Secrète (Secret Key)</label>
                                </div>
                                <button class="btn btn-primary w-100 py-3">Enregistrer & Connecter</button>

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
