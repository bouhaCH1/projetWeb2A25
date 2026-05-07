<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= isset($eventData) ? 'Modifier' : 'Créer' ?> Événement</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="../views/darkpan/css/bootstrap.min.css" rel="stylesheet">
    <link href="../views/darkpan/css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <style>
        .error-feedback { color: #eb1616; font-size: 12px; margin-top: 4px; display: none; font-weight: 500; }
        .form-control:invalid { border-color: #eb1616; }
    </style>
</head>
<body>
    <div class="container-fluid position-relative d-flex p-0">
        <div class="content w-100">
            <div class="container-fluid pt-4 px-4">
                <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                        <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3 shadow-lg">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h3 class="text-primary"><i class="fa fa-calendar-alt me-2"></i><?= isset($eventData) ? 'Modifier' : 'Nouveau' ?> Event</h3>
                            </div>
                            <form id="eventForm" action="index.php?action=save_event" method="POST" novalidate>
                                <?php if (isset($eventData)): ?>
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($eventData['id']) ?>">
                                <?php endif; ?>
                                
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Titre" value="<?= isset($eventData) ? htmlspecialchars($eventData['title']) : '' ?>">
                                    <label for="title">Titre de l'événement</label>
                                    <div id="err-title" class="error-feedback">Le titre est obligatoire (min 3 car.).</div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="date" name="date" placeholder="YYYY-MM-DD HH:MM" value="<?= isset($eventData) ? date('Y-m-d H:i', strtotime($eventData['date'])) : date('Y-m-d H:i') ?>">
                                    <label for="date">Date (Format: YYYY-MM-DD HH:MM)</label>
                                    <div id="err-date" class="error-feedback">Format date invalide.</div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="location" name="location" placeholder="Lieu" value="<?= isset($eventData) ? htmlspecialchars($eventData['location']) : '' ?>">
                                    <label for="location">Lieu / Ville</label>
                                    <div id="err-location" class="error-feedback">Le lieu est obligatoire.</div>
                                </div>

                                <div class="form-floating mb-4">
                                    <textarea class="form-control" placeholder="Description" id="description" name="description" style="height: 100px;"><?= isset($eventData) ? htmlspecialchars($eventData['description']) : '' ?></textarea>
                                    <label for="description">Description détaillée</label>
                                    <div id="err-desc" class="error-feedback">La description doit faire au moins 10 caractères.</div>
                                </div>

                                <button type="submit" class="btn btn-primary py-3 w-100 mb-3 shadow">Enregistrer l'Événement</button>
                                <a href="index.php?action=admin" class="btn btn-outline-light w-100">Annuler</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('eventForm').addEventListener('submit', function(e) {
            let isValid = true;
            
            // Titre
            const title = document.getElementById('title').value.trim();
            if(title.length < 3) {
                document.getElementById('err-title').style.display = 'block'; isValid = false;
            } else document.getElementById('err-title').style.display = 'none';

            // Date (Regex for YYYY-MM-DD HH:MM)
            const dateStr = document.getElementById('date').value.trim();
            if(!/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/.test(dateStr)) {
                document.getElementById('err-date').style.display = 'block'; isValid = false;
            } else document.getElementById('err-date').style.display = 'none';

            // Lieu
            if(document.getElementById('location').value.trim() === '') {
                document.getElementById('err-location').style.display = 'block'; isValid = false;
            } else document.getElementById('err-location').style.display = 'none';

            // Description
            if(document.getElementById('description').value.trim().length < 10) {
                document.getElementById('err-desc').style.display = 'block'; isValid = false;
            } else document.getElementById('err-desc').style.display = 'none';

            if(!isValid) {
                e.preventDefault();
                // Vibration ou effet visuel si mobile
                if(window.navigator.vibrate) window.navigator.vibrate(50);
            }
        });
    </script>
</body>
</html>
