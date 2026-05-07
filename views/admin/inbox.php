<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Boîte de Réception Interne - Event Pro</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="../darkpan/css/bootstrap.min.css" rel="stylesheet">
    <link href="../darkpan/css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid position-relative d-flex p-0">
        <div class="content w-100">
            <div class="container-fluid pt-4 px-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3 class="text-primary"><i class="fa fa-inbox me-2"></i>Boîte d'Envoi (Historique Réel)</h3>
                    <a href="index.php?action=admin" class="btn btn-outline-light">Retour Dashboard</a>
                </div>

                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-secondary rounded h-100 p-4">
                            <div class="table-responsive">
                                <table class="table text-start align-middle table-bordered table-hover mb-0">
                                    <thead>
                                        <tr class="text-white">
                                            <th>Date</th>
                                            <th>Expéditeur</th>
                                            <th>Destinataire</th>
                                            <th>Sujet</th>
                                            <th>Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        require_once __DIR__ . '/../../models/Database.php';
                                        require_once __DIR__ . '/../../models/Notification.php';
                                        $db = (new Database())->connect();
                                        $notifs = (new Notification($db))->getAll();
                                        foreach($notifs as $n): 
                                        ?>
                                        <tr>
                                            <td><?= date('d/m/Y H:i', strtotime($n['created_at'])) ?></td>
                                            <td><?= htmlspecialchars($n['sender']) ?></td>
                                            <td><?= htmlspecialchars($n['recipient']) ?></td>
                                            <td><span class="badge bg-primary"><?= htmlspecialchars($n['subject']) ?></span></td>
                                            <td>
                                                <button class="btn btn-sm btn-info" onclick="viewMsg(`<?= addslashes($n['message']) ?>`)">Voir le contenu</button>
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

    <!-- Modal pour voir le message -->
    <div class="modal fade" id="msgModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-secondary text-white">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Contenu de l'Email</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="msgBody"></div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function viewMsg(content) {
        document.getElementById('msgBody').innerHTML = content;
        new bootstrap.Modal(document.getElementById('msgModal')).show();
    }
    </script>
</body>
</html>
