<?php // views/user/index.php ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - Events & Services</title>
    <link rel="stylesheet" href="../templatemo_602_graph_page/templatemo-graph-page.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .table-custom { width: 100%; border-collapse: collapse; margin-bottom: 30px; color: #fff; }
        .table-custom th, .table-custom td { padding: 12px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .table-custom th { background-color: rgba(255,255,255,0.05); font-weight: 600; color: #00ffcc; }
        .btn-action { padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 13px; font-weight: bold; margin-right: 5px; display: inline-block; }
        .btn-pay { background: #6772e5; color: #fff; } /* Stripe Color */
        .btn-cal { background: #4285f4; color: #fff; } /* Google Color */
        .btn-pay:hover, .btn-cal:hover { opacity: 0.9; transform: translateY(-1px); }
    </style>
</head>
<body>
    <nav id="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo"><span class="logo-text">Events PRO</span></a>
            <ul class="nav-links">
                <li><a href="index.php" class="active">Utilisateur</a></li>
                <li><a href="index.php?action=admin">Administration</a></li>
            </ul>
        </div>
    </nav>

    <section class="dashboard-section" style="padding-top: 120px; min-height: 100vh;">
        <div class="dashboard-container">
            <h2 class="section-title">Découvrez nos Événements & Services</h2>

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
                                <a href="https://checkout.stripe.com/pay/simulated" class="btn-action btn-pay" onclick="alert('Redirection vers Stripe Gateway...')">
                                    <i class="fab fa-stripe me-1"></i> Payer
                                </a>
                                <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text=<?= urlencode($event['title']) ?>" target="_blank" class="btn-action btn-cal">
                                    <i class="fab fa-google me-1"></i> + Cal
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
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
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <p class="copyright">© 2026 EventResource Pro. Alimenté par Stripe, SendGrid & Google Cloud.</p>
        </div>
    </footer>
    <script src="../templatemo_602_graph_page/templatemo-graph-script.js"></script>
</body>
</html>
