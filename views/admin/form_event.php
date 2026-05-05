<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($eventData) ? 'Modifier' : 'Créer' ?> Événement</title>
    <link rel="stylesheet" href="../templatemo_602_graph_page/templatemo-graph-page.css">
    <style>
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #fff; }
        .form-group input, .form-group textarea { width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff; }
        .form-group input:focus, .form-group textarea:focus { border-color: #00ffcc; outline: none; }
        .btn-submit { background-color: #00ffcc; color: #111; padding: 12px 24px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; }
        .btn-submit:hover { background-color: #00ccaa; }
        .btn-cancel { display: inline-block; color: #fff; margin-left: 15px; text-decoration: none; }
        .error-message { color: #ff6b6b; font-size: 13px; margin-top: 5px; display: none; }
    </style>
</head>
<body>
    <nav id="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo"><span class="logo-text">My Project</span></a>
            <ul class="nav-links">
                <li><a href="index.php">Page Utilisateur</a></li>
                <li><a href="index.php?action=admin" class="active">Page Admin</a></li>
            </ul>
        </div>
    </nav>

    <section class="dashboard-section" style="padding-top: 120px; min-height: 100vh;">
        <div class="dashboard-container">
            <h2 class="section-title"><?= isset($eventData) ? 'Modifier un Événement' : 'Créer un Événement' ?></h2>
            <div style="max-width: 600px; background: rgba(255,255,255,0.05); border-radius: 15px; padding: 30px; border: 1px solid rgba(255,255,255,0.1);">
                <form id="eventForm" action="index.php?action=save_event" method="POST" novalidate>
                    <?php if (isset($eventData)): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($eventData['id']) ?>">
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Titre</label>
                        <input type="text" id="title" name="title" value="<?= isset($eventData) ? htmlspecialchars($eventData['title']) : '' ?>">
                        <div id="error-title" class="error-message">Le titre est obligatoire.</div>
                    </div>
                    <div class="form-group">
                        <label>Date et Heure (Ex: 2026-12-31 15:30)</label>
                        <input type="text" id="date" name="date" placeholder="YYYY-MM-DD HH:MM" value="<?= isset($eventData) ? date('Y-m-d H:i', strtotime($eventData['date'])) : '' ?>">
                        <div id="error-date" class="error-message">Veuillez entrer une date valide (YYYY-MM-DD HH:MM).</div>
                    </div>
                    <div class="form-group">
                        <label>Lieu</label>
                        <input type="text" id="location" name="location" value="<?= isset($eventData) ? htmlspecialchars($eventData['location']) : '' ?>">
                        <div id="error-location" class="error-message">Le lieu est obligatoire.</div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea id="description" name="description" rows="4"><?= isset($eventData) ? htmlspecialchars($eventData['description']) : '' ?></textarea>
                        <div id="error-description" class="error-message">La description doit faire au moins 10 caractères.</div>
                    </div>
                    <button type="submit" class="btn-submit">Enregistrer</button>
                    <a href="index.php?action=admin" class="btn-cancel">Annuler</a>
                </form>
            </div>
        </div>
    </section>

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
    <script src="../templatemo_602_graph_page/templatemo-graph-script.js"></script>
</body>
</html>
