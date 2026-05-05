<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($resourceData) ? 'Modifier' : 'Créer' ?> Ressource</title>
    <link rel="stylesheet" href="../templatemo_602_graph_page/templatemo-graph-page.css">
    <style>
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #fff; }
        .form-group input, .form-group select { width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff; }
        .form-group input:focus, .form-group select:focus { border-color: #00ffcc; outline: none; }
        .btn-submit { background-color: #00ffcc; color: #111; padding: 12px 24px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; }
        .btn-submit:hover { background-color: #00ccaa; }
        .btn-cancel { display: inline-block; color: #fff; margin-left: 15px; text-decoration: none; }
        option { background-color: #222; color: #fff; }
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
            <h2 class="section-title"><?= isset($resourceData) ? 'Modifier une Ressource' : 'Créer une Ressource' ?></h2>
            <div style="max-width: 600px; background: rgba(255,255,255,0.05); border-radius: 15px; padding: 30px; border: 1px solid rgba(255,255,255,0.1);">
                <form id="resourceForm" action="index.php?action=save_resource" method="POST" novalidate>
                    <?php if (isset($resourceData)): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($resourceData['id']) ?>">
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Nom de la ressource</label>
                        <input type="text" id="name" name="name" value="<?= isset($resourceData) ? htmlspecialchars($resourceData['name']) : '' ?>">
                        <div id="error-name" class="error-message">Le nom est obligatoire.</div>
                    </div>
                    <div class="form-group">
                        <label>Type de ressource</label>
                        <select id="type" name="type">
                            <option value="">-- Sélectionnez un type --</option>
                            <option value="Matériel" <?= (isset($resourceData) && $resourceData['type'] == 'Matériel') ? 'selected' : '' ?>>Matériel</option>
                            <option value="Logiciel" <?= (isset($resourceData) && $resourceData['type'] == 'Logiciel') ? 'selected' : '' ?>>Logiciel</option>
                            <option value="Humain" <?= (isset($resourceData) && $resourceData['type'] == 'Humain') ? 'selected' : '' ?>>Humain</option>
                            <option value="Autre" <?= (isset($resourceData) && $resourceData['type'] == 'Autre') ? 'selected' : '' ?>>Autre</option>
                        </select>
                        <div id="error-type" class="error-message">Veuillez sélectionner un type.</div>
                    </div>
                    <div class="form-group">
                        <label>Quantité</label>
                        <input type="text" id="quantity" name="quantity" value="<?= isset($resourceData) ? htmlspecialchars($resourceData['quantity']) : '1' ?>">
                        <div id="error-quantity" class="error-message">La quantité doit être un nombre valide > 0.</div>
                    </div>
                    <button type="submit" class="btn-submit">Enregistrer</button>
                    <a href="index.php?action=admin" class="btn-cancel">Annuler</a>
                </form>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('resourceForm').addEventListener('submit', function(e) {
            let isValid = true;
            if(document.getElementById('name').value.trim() === '') { document.getElementById('error-name').style.display = 'block'; isValid = false; } else { document.getElementById('error-name').style.display = 'none'; }
            if(document.getElementById('type').value === '') { document.getElementById('error-type').style.display = 'block'; isValid = false; } else { document.getElementById('error-type').style.display = 'none'; }
            const qty = document.getElementById('quantity').value.trim();
            const pQty = parseInt(qty, 10);
            if(isNaN(pQty) || pQty <= 0 || qty !== pQty.toString()) { document.getElementById('error-quantity').style.display = 'block'; isValid = false; } else { document.getElementById('error-quantity').style.display = 'none'; }
            if(!isValid) e.preventDefault();
        });
    </script>
    <script src="../templatemo_602_graph_page/templatemo-graph-script.js"></script>
</body>
</html>
