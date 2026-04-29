<?php
ob_start();
?>

<!-- ===== Page Banner ===== -->
<div class="cyber-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h6>Modifier</h6>
                <h2>Modifier la mission #<?= (int)$missionData['id'] ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="container" style="padding: 60px 0;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="cyber-form-card">
                <form id="missionForm" method="POST" action="index.php?action=front_edit&id=<?= (int)$missionData['id'] ?>" novalidate>
                    <div class="mb-4">
                        <label>Titre <span class="required">*</span></label>
                        <input type="text" name="titre" id="titre" class="<?= isset($errors['titre']) ? 'is-invalid' : '' ?>"
                               value="<?= isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : htmlspecialchars($missionData['titre']) ?>">
                        <div class="invalid-feedback" id="err-titre"><?= isset($errors['titre']) ? $errors['titre'] : '' ?></div>
                    </div>

                    <div class="mb-4">
                        <label>Description <span class="required">*</span></label>
                        <textarea name="description" id="description" rows="4"
                                  class="<?= isset($errors['description']) ? 'is-invalid' : '' ?>"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : htmlspecialchars($missionData['description']) ?></textarea>
                        <div class="invalid-feedback" id="err-description"><?= isset($errors['description']) ? $errors['description'] : '' ?></div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label>Budget (EUR) <span class="required">*</span></label>
                            <input type="text" name="budget" id="budget" class="<?= isset($errors['budget']) ? 'is-invalid' : '' ?>"
                                   value="<?= isset($_POST['budget']) ? htmlspecialchars($_POST['budget']) : htmlspecialchars($missionData['budget']) ?>">
                            <div class="invalid-feedback" id="err-budget"><?= isset($errors['budget']) ? $errors['budget'] : '' ?></div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label>Date debut <span class="required">*</span></label>
                            <input type="date" name="date_debut" id="date_debut" class="<?= isset($errors['date_debut']) ? 'is-invalid' : '' ?>"
                                   value="<?= isset($_POST['date_debut']) ? $_POST['date_debut'] : $missionData['date_debut'] ?>">
                            <div class="invalid-feedback" id="err-date_debut"><?= isset($errors['date_debut']) ? $errors['date_debut'] : '' ?></div>
                        </div>
                        <div class="col-md-4">
                            <label>Date fin <span class="required">*</span></label>
                            <input type="date" name="date_fin" id="date_fin" class="<?= isset($errors['date_fin']) ? 'is-invalid' : '' ?>"
                                   value="<?= isset($_POST['date_fin']) ? $_POST['date_fin'] : $missionData['date_fin'] ?>">
                            <div class="invalid-feedback" id="err-date_fin"><?= isset($errors['date_fin']) ? $errors['date_fin'] : '' ?></div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label>Statut <span class="required">*</span></label>
                            <?php $currentStatut = isset($_POST['statut']) ? $_POST['statut'] : $missionData['statut']; ?>
                            <select name="statut" id="statut" class="<?= isset($errors['statut']) ? 'is-invalid' : '' ?>">
                                <option value="">-- Choisir --</option>
                                <option value="ouverte" <?= ($currentStatut === 'ouverte') ? 'selected' : '' ?>>Ouverte</option>
                                <option value="en_cours" <?= ($currentStatut === 'en_cours') ? 'selected' : '' ?>>En cours</option>
                                <option value="terminee" <?= ($currentStatut === 'terminee') ? 'selected' : '' ?>>Terminee</option>
                            </select>
                            <div class="invalid-feedback" id="err-statut"><?= isset($errors['statut']) ? $errors['statut'] : '' ?></div>
                        </div>
                        <div class="col-md-6">
                            <label>Competences <span class="required">*</span></label>
                            <input type="text" name="competences" id="competences" class="<?= isset($errors['competences']) ? 'is-invalid' : '' ?>"
                                   value="<?= isset($_POST['competences']) ? htmlspecialchars($_POST['competences']) : htmlspecialchars($missionData['competences']) ?>">
                            <div class="invalid-feedback" id="err-competences"><?= isset($errors['competences']) ? $errors['competences'] : '' ?></div>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="cyber-btn" style="border: none; cursor: pointer;">
                            <i class="fa fa-save"></i> Mettre a jour
                        </button>
                        <a href="index.php?action=front_missions" class="cyber-btn cyber-btn-outline">
                            <i class="fa fa-times"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$extraJs = '<script src="../View/public/assets/js/validation.php"></script>';
require_once 'layout.php';
?>
