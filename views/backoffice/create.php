<?php
$activePage = 'create';
$pageTitle  = 'Ajouter une Mission';
$pageIcon   = 'plus-circle';

ob_start();
?>
<div class="card">
    <div class="card-header">
        <i class="fas fa-plus-circle me-2"></i> Nouvelle Mission
    </div>
    <div class="card-body p-4">
        <form id="missionForm" method="POST" action="index.php?action=create" novalidate>

            <div class="row mb-3">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Titre <span class="text-danger">*</span></label>
                    <input type="text" name="titre" id="titre" class="form-control <?= isset($errors['titre']) ? 'is-invalid' : '' ?>"
                           value="<?= isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '' ?>">
                    <div class="invalid-feedback" id="err-titre">
                        <?= isset($errors['titre']) ? $errors['titre'] : '' ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Budget (€) <span class="text-danger">*</span></label>
                    <input type="text" name="budget" id="budget" class="form-control <?= isset($errors['budget']) ? 'is-invalid' : '' ?>"
                           value="<?= isset($_POST['budget']) ? htmlspecialchars($_POST['budget']) : '' ?>">
                    <div class="invalid-feedback" id="err-budget">
                        <?= isset($errors['budget']) ? $errors['budget'] : '' ?>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                <textarea name="description" id="description" rows="4"
                          class="form-control <?= isset($errors['description']) ? 'is-invalid' : '' ?>"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
                <div class="invalid-feedback" id="err-description">
                    <?= isset($errors['description']) ? $errors['description'] : '' ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Date de début <span class="text-danger">*</span></label>
                    <input type="date" name="date_debut" id="date_debut"
                           class="form-control <?= isset($errors['date_debut']) ? 'is-invalid' : '' ?>"
                           value="<?= isset($_POST['date_debut']) ? $_POST['date_debut'] : '' ?>">
                    <div class="invalid-feedback" id="err-date_debut">
                        <?= isset($errors['date_debut']) ? $errors['date_debut'] : '' ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Date de fin <span class="text-danger">*</span></label>
                    <input type="date" name="date_fin" id="date_fin"
                           class="form-control <?= isset($errors['date_fin']) ? 'is-invalid' : '' ?>"
                           value="<?= isset($_POST['date_fin']) ? $_POST['date_fin'] : '' ?>">
                    <div class="invalid-feedback" id="err-date_fin">
                        <?= isset($errors['date_fin']) ? $errors['date_fin'] : '' ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Statut <span class="text-danger">*</span></label>
                    <select name="statut" id="statut" class="form-select <?= isset($errors['statut']) ? 'is-invalid' : '' ?>">
                        <option value="">-- Choisir --</option>
                        <option value="ouverte"  <?= (isset($_POST['statut']) && $_POST['statut']=='ouverte')  ? 'selected':'' ?>>Ouverte</option>
                        <option value="en_cours" <?= (isset($_POST['statut']) && $_POST['statut']=='en_cours') ? 'selected':'' ?>>En cours</option>
                        <option value="terminee" <?= (isset($_POST['statut']) && $_POST['statut']=='terminee') ? 'selected':'' ?>>Terminée</option>
                    </select>
                    <div class="invalid-feedback" id="err-statut">
                        <?= isset($errors['statut']) ? $errors['statut'] : '' ?>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Compétences requises <span class="text-danger">*</span></label>
                <input type="text" name="competences" id="competences"
                       class="form-control <?= isset($errors['competences']) ? 'is-invalid' : '' ?>"
                       placeholder="ex: PHP, JavaScript, MySQL"
                       value="<?= isset($_POST['competences']) ? htmlspecialchars($_POST['competences']) : '' ?>">
                <div class="invalid-feedback" id="err-competences">
                    <?= isset($errors['competences']) ? $errors['competences'] : '' ?>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-2"></i> Enregistrer
                </button>
                <a href="index.php?action=index" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-times me-2"></i> Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<?php
$extraJs = '<script src="../public/assets/js/validation.js"></script>';
$content = ob_get_clean();
require_once 'layout.php';
?>