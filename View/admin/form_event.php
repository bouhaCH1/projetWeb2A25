<?php
$pageTitle = isset($eventData) ? 'Modifier Événement' : 'Nouvel Événement';
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
    .form-floating .form-control { background: <?= $inputBg ?>; border: 1px solid rgba(255,255,255,0.1); color: #fff; }
    .form-floating .form-control:focus { background: <?= $inputBg ?>; border-color: <?= $themeColor ?>; color: #fff; box-shadow: 0 0 0 0.2rem <?= $focusShadow ?>; }
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
                        <i class="fa fa-calendar-alt me-2"></i>
                        <?= isset($eventData) ? 'Modifier' : 'Nouvel' ?> Événement
                    </h3>
                </div>

                <?php if (!empty($flash)): ?>
                <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($flash['msg']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <form id="eventForm" action="/workwave/Controller/index.php?action=save_event" method="POST" novalidate>
                    <?php if (isset($eventData)): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($eventData['id']) ?>">
                    <?php endif; ?>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="title" name="title"
                               placeholder="Titre" value="<?= isset($eventData) ? htmlspecialchars($eventData['title']) : '' ?>">
                        <label for="title">Titre de l'événement</label>
                        <div id="err-title" class="error-feedback">Le titre est obligatoire (min 3 car.).</div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="date" name="date"
                               placeholder="YYYY-MM-DD HH:MM"
                               value="<?= isset($eventData) ? date('Y-m-d H:i', strtotime($eventData['date'])) : date('Y-m-d H:i') ?>">
                        <label for="date">Date (YYYY-MM-DD HH:MM)</label>
                        <div id="err-date" class="error-feedback">Format date invalide. Ex: 2026-06-15 09:00</div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="location" name="location"
                               placeholder="Lieu" value="<?= isset($eventData) ? htmlspecialchars($eventData['location']) : '' ?>">
                        <label for="location">Lieu / Ville</label>
                        <div id="err-location" class="error-feedback">Le lieu est obligatoire.</div>
                    </div>

                    <div class="form-floating mb-4">
                        <textarea class="form-control" placeholder="Description" id="description"
                                  name="description" style="height: 110px;"><?= isset($eventData) ? htmlspecialchars($eventData['description']) : '' ?></textarea>
                        <label for="description">Description détaillée</label>
                        <div id="err-desc" class="error-feedback">La description doit faire au moins 10 caractères.</div>
                    </div>

                    <button type="submit" class="btn py-3 w-100 mb-3 shadow" style="background:<?= $themeColor ?>;color:<?= $btnText ?>;border:none;font-weight:bold;">
                        <i class="fa fa-save me-2"></i>Enregistrer l'Événement
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
document.getElementById('eventForm').addEventListener('submit', function(e) {
    let isValid = true;

    const title = document.getElementById('title').value.trim();
    if(title.length < 3) {
        document.getElementById('err-title').style.display = 'block'; isValid = false;
    } else document.getElementById('err-title').style.display = 'none';

    const dateStr = document.getElementById('date').value.trim();
    if(!/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/.test(dateStr)) {
        document.getElementById('err-date').style.display = 'block'; isValid = false;
    } else document.getElementById('err-date').style.display = 'none';

    if(document.getElementById('location').value.trim() === '') {
        document.getElementById('err-location').style.display = 'block'; isValid = false;
    } else document.getElementById('err-location').style.display = 'none';

    if(document.getElementById('description').value.trim().length < 10) {
        document.getElementById('err-desc').style.display = 'block'; isValid = false;
    } else document.getElementById('err-desc').style.display = 'none';

    if(!isValid) {
        e.preventDefault();
        if(window.navigator.vibrate) window.navigator.vibrate(50);
    }
});
</script>

<?php 
if (($_SESSION['user_role'] ?? '') === 'employer') {
    require_once __DIR__ . '/../layout/pl_dashboard_footer.php';
} else {
    require_once __DIR__ . '/../layout/dashboard_footer.php';
}
?>
