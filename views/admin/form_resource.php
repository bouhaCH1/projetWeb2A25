<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= isset($resourceData) ? 'Modifier' : 'Créer' ?> Ressource</title>
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
                                <h3 class="text-primary"><?= isset($resourceData) ? 'Modifier' : 'Nouveu' ?></h3>
                            </div>
                            <form id="resourceForm" action="index.php?action=save_resource" method="POST" novalidate>
                                <?php if (isset($resourceData)): ?>
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($resourceData['id']) ?>">
                                <?php endif; ?>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?= isset($resourceData) ? htmlspecialchars($resourceData['name']) : '' ?>">
                                    <label for="name">Nom de la ressource</label>
                                    <div id="error-name" class="error-message">Obligatoire</div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="type" name="type" placeholder="Type" value="<?= isset($resourceData) ? htmlspecialchars($resourceData['type']) : '' ?>">
                                    <label for="type">Type (Ex: Salle, Matériel)</label>
                                    <div id="error-type" class="error-message">Obligatoire</div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Quantité" value="<?= isset($resourceData) ? htmlspecialchars($resourceData['quantity']) : '' ?>">
                                    <label for="quantity">Quantité</label>
                                    <div id="error-quantity" class="error-message">Doit être un nombre positif</div>
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
        document.getElementById('resourceForm').addEventListener('submit', function(e) {
            let isValid = true;
            if(document.getElementById('name').value.trim() === '') { document.getElementById('error-name').style.display = 'block'; isValid = false; } else { document.getElementById('error-name').style.display = 'none'; }
            if(document.getElementById('type').value.trim() === '') { document.getElementById('error-type').style.display = 'block'; isValid = false; } else { document.getElementById('error-type').style.display = 'none'; }
            let qty = parseInt(document.getElementById('quantity').value);
            if(isNaN(qty) || qty < 0) { document.getElementById('error-quantity').style.display = 'block'; isValid = false; } else { document.getElementById('error-quantity').style.display = 'none'; }
            if(!isValid) e.preventDefault();
        });
    </script>
</body>
</html>
