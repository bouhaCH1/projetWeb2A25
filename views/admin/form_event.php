<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= isset($eventData) ? 'Modifier' : 'Créer' ?> Événement</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="../darkpan/css/bootstrap.min.css" rel="stylesheet">
    <link href="../darkpan/css/style.css" rel="stylesheet">
    <style>
        .error-message { color: #eb1616; font-size: 13px; margin-top: 5px; display: none; }
    </style>
</head>
<body>
    <div class="container-fluid position-relative d-flex p-0">
        <div class="content w-100">
            <div class="container-fluid pt-4 px-4">
                <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                        <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h3 class="text-primary"><?= isset($eventData) ? 'Modifier' : 'Nouveau' ?></h3>
                            </div>
                            <form id="eventForm" action="index.php?action=save_event" method="POST" novalidate>
                                <?php if (isset($eventData)): ?>
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($eventData['id']) ?>">
                                <?php endif; ?>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Titre" value="<?= isset($eventData) ? htmlspecialchars($eventData['title']) : '' ?>">
                                    <label for="title">Titre</label>
                                    <div id="error-title" class="error-message">Obligatoire</div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="date" name="date" placeholder="YYYY-MM-DD HH:MM" value="<?= isset($eventData) ? date('Y-m-d H:i', strtotime($eventData['date'])) : '' ?>">
                                    <label for="date">Date et Heure (YYYY-MM-DD HH:MM)</label>
                                    <div id="error-date" class="error-message">Format invalide</div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="location" name="location" placeholder="Lieu" value="<?= isset($eventData) ? htmlspecialchars($eventData['location']) : '' ?>">
                                    <label for="location">Lieu</label>
                                    <div id="error-location" class="error-message">Obligatoire</div>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" placeholder="Description" id="description" name="description" style="height: 100px;"><?= isset($eventData) ? htmlspecialchars($eventData['description']) : '' ?></textarea>
                                    <label for="description">Description</label>
                                    <div id="error-description" class="error-message">Min 10 caractères</div>
                                </div>
                                <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Enregistrer</button>
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
            if(document.getElementById('title').value.trim() === '') { document.getElementById('error-title').style.display = 'block'; isValid = false; } else { document.getElementById('error-title').style.display = 'none'; }
            if(!/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/.test(document.getElementById('date').value.trim())) { document.getElementById('error-date').style.display = 'block'; isValid = false; } else { document.getElementById('error-date').style.display = 'none'; }
            if(document.getElementById('location').value.trim() === '') { document.getElementById('error-location').style.display = 'block'; isValid = false; } else { document.getElementById('error-location').style.display = 'none'; }
            if(document.getElementById('description').value.trim().length < 10) { document.getElementById('error-description').style.display = 'block'; isValid = false; } else { document.getElementById('error-description').style.display = 'none'; }
            if(!isValid) e.preventDefault();
        });
    </script>
</body>
</html>
