<?php
$activePage = 'create';
$pageTitle  = 'Ajouter une Mission';
$pageIcon   = 'plus-circle';

ob_start();
?>

<div class="bg-secondary rounded h-100 p-4">
    <h6 class="mb-4"><i class="fas fa-plus-circle me-2"></i>Nouvelle Mission</h6>
    <form id="missionForm" method="POST" action="index.php?action=create" novalidate>

        <div class="row mb-3">
            <div class="col-md-8">
                <label class="form-label">Titre <span class="text-danger">*</span></label>
                <input type="text" name="titre" id="titre" class="form-control bg-dark border-0 <?= isset($errors['titre']) ? 'is-invalid' : '' ?>"
                       value="<?= isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '' ?>"
                       onkeypress="return /^[a-zA-Z\séèêëàâäùûüôöîïç]+$/.test(String.fromCharCode(event.which))">
                <div class="invalid-feedback" id="err-titre">
                    <?= isset($errors['titre']) ? $errors['titre'] : '' ?>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Budget (EUR) <span class="text-danger">*</span></label>
                <input type="text" name="budget" id="budget" class="form-control bg-dark border-0 <?= isset($errors['budget']) ? 'is-invalid' : '' ?>"
                       value="<?= isset($_POST['budget']) ? htmlspecialchars($_POST['budget']) : '' ?>">
                <div class="invalid-feedback" id="err-budget">
                    <?= isset($errors['budget']) ? $errors['budget'] : '' ?>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Description <span class="text-danger">*</span></label>
            <textarea name="description" id="description" rows="4"
                      class="form-control bg-dark border-0 <?= isset($errors['description']) ? 'is-invalid' : '' ?>"
                      onkeypress="return /^[a-zA-Z\séèêëàâäùûüôöîïç,.!?;:'"()-]+$/.test(String.fromCharCode(event.which))"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
            <div class="invalid-feedback" id="err-description">
                <?= isset($errors['description']) ? $errors['description'] : '' ?>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <label class="form-label">Date de debut <span class="text-danger">*</span></label>
                <input type="date" name="date_debut" id="date_debut"
                       class="form-control bg-dark border-0 <?= isset($errors['date_debut']) ? 'is-invalid' : '' ?>"
                       value="<?= isset($_POST['date_debut']) ? $_POST['date_debut'] : '' ?>">
                <div class="invalid-feedback" id="err-date_debut">
                    <?= isset($errors['date_debut']) ? $errors['date_debut'] : '' ?>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Date de fin <span class="text-danger">*</span></label>
                <input type="date" name="date_fin" id="date_fin"
                       class="form-control bg-dark border-0 <?= isset($errors['date_fin']) ? 'is-invalid' : '' ?>"
                       value="<?= isset($_POST['date_fin']) ? $_POST['date_fin'] : '' ?>">
                <div class="invalid-feedback" id="err-date_fin">
                    <?= isset($errors['date_fin']) ? $errors['date_fin'] : '' ?>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Statut <span class="text-danger">*</span></label>
                <select name="statut" id="statut" class="form-select bg-dark border-0 <?= isset($errors['statut']) ? 'is-invalid' : '' ?>">
                    <option value="">-- Choisir --</option>
                    <option value="ouverte"  <?= (isset($_POST['statut']) && $_POST['statut']=='ouverte')  ? 'selected':'' ?>>Ouverte</option>
                    <option value="en_cours" <?= (isset($_POST['statut']) && $_POST['statut']=='en_cours') ? 'selected':'' ?>>En cours</option>
                    <option value="terminee" <?= (isset($_POST['statut']) && $_POST['statut']=='terminee') ? 'selected':'' ?>>Terminee</option>
                </select>
                <div class="invalid-feedback" id="err-statut">
                    <?= isset($errors['statut']) ? $errors['statut'] : '' ?>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Competences requises <span class="text-danger">*</span></label>
            <input type="text" name="competences" id="competences"
                   class="form-control bg-dark border-0 <?= isset($errors['competences']) ? 'is-invalid' : '' ?>"
                   placeholder="ex: PHP, JavaScript, MySQL"
                   value="<?= isset($_POST['competences']) ? htmlspecialchars($_POST['competences']) : '' ?>">
            <div class="invalid-feedback" id="err-competences">
                <?= isset($errors['competences']) ? $errors['competences'] : '' ?>
            </div>
        </div>

        <div class="d-flex gap-3" style="margin-top: 30px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Enregistrer
            </button>
            <a href="index.php?action=index" class="btn btn-outline-light">
                <i class="fas fa-times me-1"></i> Annuler
            </a>
        </div>
    </form>
</div>

<?php
$extraJs = '<script src="../View/public/assets/js/validation.php"></script>';
$content = ob_get_clean();
require_once 'layout.php';
?>