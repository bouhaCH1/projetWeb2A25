<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= isset($resourceData) ? 'Modifier' : 'Créer' ?> Ressource</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="../views/darkpan/css/bootstrap.min.css" rel="stylesheet">
    <link href="../views/darkpan/css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <style>
        .error-feedback { color: #eb1616; font-size: 12px; margin-top: 4px; display: none; font-weight: 500; }
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
                                <h3 class="text-primary"><i class="fa fa-boxes me-2"></i><?= isset($resourceData) ? 'Modifier' : 'Nouvelle' ?> Ressource</h3>
                            </div>
                            <form id="resourceForm" action="index.php?action=save_resource" method="POST" novalidate>
                                <?php if (isset($resourceData)): ?>
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($resourceData['id']) ?>">
                                <?php endif; ?>
                                
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?= isset($resourceData) ? htmlspecialchars($resourceData['name']) : '' ?>">
                                    <label for="name">Nom de la ressource</label>
                                    <div id="err-name" class="error-feedback">Le nom est obligatoire.</div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="type" name="type" placeholder="Type" value="<?= isset($resourceData) ? htmlspecialchars($resourceData['type']) : '' ?>">
                                    <label for="type">Type (ex: Salle, Son, Lumière)</label>
                                    <div id="err-type" class="error-feedback">Le type est obligatoire.</div>
                                </div>

                                <div class="form-floating mb-4">
                                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Quantité" value="<?= isset($resourceData) ? htmlspecialchars($resourceData['quantity']) : '' ?>">
                                    <label for="quantity">Quantité en stock</label>
                                    <div id="err-qty" class="error-feedback">La quantité doit être un nombre positif (0+).</div>
                                </div>

                                <button type="submit" class="btn btn-primary py-3 w-100 mb-3 shadow">Enregistrer la Ressource</button>
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
            
            // Nom
            if(document.getElementById('name').value.trim() === '') {
                document.getElementById('err-name').style.display = 'block'; isValid = false;
            } else document.getElementById('err-name').style.display = 'none';

            // Type
            if(document.getElementById('type').value.trim() === '') {
                document.getElementById('err-type').style.display = 'block'; isValid = false;
            } else document.getElementById('err-type').style.display = 'none';

            // Quantité
            const qty = parseInt(document.getElementById('quantity').value);
            if(isNaN(qty) || qty < 0) {
                document.getElementById('err-qty').style.display = 'block'; isValid = false;
            } else document.getElementById('err-qty').style.display = 'none';

            if(!isValid) e.preventDefault();
        });
    </script>
</body>
</html>
