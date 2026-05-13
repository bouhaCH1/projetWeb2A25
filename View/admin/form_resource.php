<?php
$pageTitle = isset($resourceData) ? 'Modifier Ressource' : 'Nouvelle Ressource';
$isEmployer = ($_SESSION['user_role'] ?? '') === 'employer';
if ($isEmployer) {
    require_once __DIR__ . '/../layout/pl_dashboard_header.php';
} else {
    require_once __DIR__ . '/../layout/dashboard_header.php';
}

$themeColor  = $isEmployer ? '#00ffcc' : '#eb1616';
$btnText     = $isEmployer ? '#191c24' : '#fff';
$boxStyle    = $isEmployer ? 'background: rgba(255,255,255,0.05); border-radius: 15px; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 10px 30px rgba(0,0,0,0.5);' : 'background: #191c24;';
$inputBg     = $isEmployer ? 'rgba(0,0,0,0.2)' : '#191c24';
$focusShadow = $isEmployer ? 'rgba(0,255,204,.15)' : 'rgba(235,22,22,.15)';
?>

<style>
    .error-feedback { color: <?= $themeColor ?>; font-size: 12px; margin-top: 4px; display: none; font-weight: 500; }
    .form-floating label { color: #ccc; }
    .form-floating > label::after { background-color: transparent !important; }
    .form-floating .form-control, .form-floating .form-select { background: <?= $inputBg ?>; border: 1px solid rgba(255,255,255,0.1); color: #fff; }
    .form-floating .form-control:focus, .form-floating .form-select:focus { background: <?= $inputBg ?>; border-color: <?= $themeColor ?>; color: #fff; box-shadow: 0 0 0 0.2rem <?= $focusShadow ?>; }
    option { background-color: #191c24; color: #fff; }
</style>

<div class="container-fluid pt-4 px-4">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">
            <div class="<?= $isEmployer ? 'p-4 p-sm-5 my-4' : 'bg-secondary rounded p-4 p-sm-5 my-4 shadow-lg' ?>" style="<?= $isEmployer ? $boxStyle : '' ?>">
                <!-- Header -->
                <div class="d-flex align-items-center mb-4">
                    <a href="<?= htmlspecialchars($returnUrl ?? '/workwave/Controller/index.php?action=user_events') ?>" class="btn btn-sm btn-outline-light me-3">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                    <h3 class="mb-0" style="color: <?= $themeColor ?>;">
                        <i class="fa fa-boxes me-2"></i>
                        <?= isset($resourceData) ? 'Modifier' : 'Nouvelle' ?> Ressource
                    </h3>
                </div>

                <?php if (!empty($flash)): ?>
                <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($flash['msg']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <form id="resourceForm" action="/workwave/Controller/index.php?action=save_resource" method="POST" novalidate>
                    <?php if (isset($resourceData)): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($resourceData['id']) ?>">
                    <?php endif; ?>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" name="name"
                               placeholder="Nom" value="<?= isset($resourceData) ? htmlspecialchars($resourceData['name']) : '' ?>">
                        <label for="name">Nom de la ressource</label>
                        <div id="err-name" class="error-feedback">Le nom est obligatoire.</div>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-control form-select" id="type" name="type">
                            <?php
                            $types = ['Matériel', 'Fournitures', 'Salle', 'Son', 'Lumière', 'Autre'];
                            foreach ($types as $t):
                                $sel = (isset($resourceData) && $resourceData['type'] === $t) ? 'selected' : '';
                            ?>
                            <option value="<?= $t ?>" <?= $sel ?>><?= $t ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="type">Type de ressource</label>
                        <div id="err-type" class="error-feedback">Le type est obligatoire.</div>
                    </div>

                    <div class="form-floating mb-4">
                        <input type="number" class="form-control" id="quantity" name="quantity"
                               placeholder="Quantité" min="0"
                               value="<?= isset($resourceData) ? htmlspecialchars($resourceData['quantity']) : '0' ?>">
                        <label for="quantity">Quantité en stock</label>
                        <div id="err-qty" class="error-feedback">La quantité doit être un nombre positif (0+).</div>
                    </div>

                    <button type="submit" class="btn py-3 w-100 mb-3 shadow" style="background:<?= $themeColor ?>;color:<?= $btnText ?>;border:none;font-weight:bold;">
                        <i class="fa fa-save me-2"></i>Enregistrer la Ressource
                    </button>
                    <a href="<?= htmlspecialchars($returnUrl ?? '/workwave/Controller/index.php?action=user_events') ?>" class="btn btn-outline-light w-100">
                        <i class="fa fa-times me-2"></i>Annuler
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('resourceForm').addEventListener('submit', function(e) {
    let isValid = true;

    if(document.getElementById('name').value.trim() === '') {
        document.getElementById('err-name').style.display = 'block'; isValid = false;
    } else document.getElementById('err-name').style.display = 'none';

    if(document.getElementById('type').value.trim() === '') {
        document.getElementById('err-type').style.display = 'block'; isValid = false;
    } else document.getElementById('err-type').style.display = 'none';

    const qty = parseInt(document.getElementById('quantity').value);
    if(isNaN(qty) || qty < 0) {
        document.getElementById('err-qty').style.display = 'block'; isValid = false;
    } else document.getElementById('err-qty').style.display = 'none';

    if(!isValid) e.preventDefault();
});
</script>

<?php 
if (($_SESSION['user_role'] ?? '') === 'employer') {
    require_once __DIR__ . '/../layout/pl_dashboard_footer.php';
} else {
    require_once __DIR__ . '/../layout/dashboard_footer.php';
}
?>
