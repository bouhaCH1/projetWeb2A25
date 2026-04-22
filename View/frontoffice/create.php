<?php
ob_start();
?>

<!-- ***** Page Banner Area Start ***** -->
<div class="page-banner" style="background: linear-gradient(135deg, #00bdfe 0%, #2b2b2b 100%); padding: 100px 0 50px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="top-text header-text text-center">
                    <h6 style="color: rgba(255,255,255,0.8);">Publier</h6>
                    <h2 style="color: white;">Créer une nouvelle mission</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ***** Page Banner Area End ***** -->

<div class="container" style="padding: 60px 0;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div style="background: white; border-radius: 15px; padding: 40px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <form id="missionForm" method="POST" action="index.php?action=front_create" novalidate>
                    <div class="mb-4">
                        <label style="font-weight: 600; color: #2b2b2b; margin-bottom: 8px; display: block;">Titre <span style="color: #fa5b0f;">*</span></label>
                        <input type="text" name="titre" id="titre" class="form-control <?= isset($errors['titre']) ? 'is-invalid' : '' ?>"
                               style="border-radius: 10px; padding: 12px 15px; border: 1px solid #ddd;"
                               value="<?= isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '' ?>">
                        <div class="invalid-feedback" id="err-titre"><?= isset($errors['titre']) ? $errors['titre'] : '' ?></div>
                    </div>

                    <div class="mb-4">
                        <label style="font-weight: 600; color: #2b2b2b; margin-bottom: 8px; display: block;">Description <span style="color: #fa5b0f;">*</span></label>
                        <textarea name="description" id="description" rows="4"
                                  style="border-radius: 10px; padding: 12px 15px; border: 1px solid #ddd; width: 100%;"
                                  class="form-control <?= isset($errors['description']) ? 'is-invalid' : '' ?>"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
                        <div class="invalid-feedback" id="err-description"><?= isset($errors['description']) ? $errors['description'] : '' ?></div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label style="font-weight: 600; color: #2b2b2b; margin-bottom: 8px; display: block;">Budget (EUR) <span style="color: #fa5b0f;">*</span></label>
                            <input type="text" name="budget" id="budget" class="form-control <?= isset($errors['budget']) ? 'is-invalid' : '' ?>"
                                   style="border-radius: 10px; padding: 12px 15px; border: 1px solid #ddd;"
                                   value="<?= isset($_POST['budget']) ? htmlspecialchars($_POST['budget']) : '' ?>">
                            <div class="invalid-feedback" id="err-budget"><?= isset($errors['budget']) ? $errors['budget'] : '' ?></div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label style="font-weight: 600; color: #2b2b2b; margin-bottom: 8px; display: block;">Date début <span style="color: #fa5b0f;">*</span></label>
                            <input type="date" name="date_debut" id="date_debut" class="form-control <?= isset($errors['date_debut']) ? 'is-invalid' : '' ?>"
                                   style="border-radius: 10px; padding: 12px 15px; border: 1px solid #ddd;"
                                   value="<?= isset($_POST['date_debut']) ? $_POST['date_debut'] : '' ?>">
                            <div class="invalid-feedback" id="err-date_debut"><?= isset($errors['date_debut']) ? $errors['date_debut'] : '' ?></div>
                        </div>
                        <div class="col-md-4">
                            <label style="font-weight: 600; color: #2b2b2b; margin-bottom: 8px; display: block;">Date fin <span style="color: #fa5b0f;">*</span></label>
                            <input type="date" name="date_fin" id="date_fin" class="form-control <?= isset($errors['date_fin']) ? 'is-invalid' : '' ?>"
                                   style="border-radius: 10px; padding: 12px 15px; border: 1px solid #ddd;"
                                   value="<?= isset($_POST['date_fin']) ? $_POST['date_fin'] : '' ?>">
                            <div class="invalid-feedback" id="err-date_fin"><?= isset($errors['date_fin']) ? $errors['date_fin'] : '' ?></div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label style="font-weight: 600; color: #2b2b2b; margin-bottom: 8px; display: block;">Statut <span style="color: #fa5b0f;">*</span></label>
                            <select name="statut" id="statut" class="form-select <?= isset($errors['statut']) ? 'is-invalid' : '' ?>"
                                    style="border-radius: 10px; padding: 12px 15px; border: 1px solid #ddd;">
                                <option value="">-- Choisir --</option>
                                <option value="ouverte" <?= (isset($_POST['statut']) && $_POST['statut'] === 'ouverte') ? 'selected' : '' ?>>Ouverte</option>
                                <option value="en_cours" <?= (isset($_POST['statut']) && $_POST['statut'] === 'en_cours') ? 'selected' : '' ?>>En cours</option>
                                <option value="terminee" <?= (isset($_POST['statut']) && $_POST['statut'] === 'terminee') ? 'selected' : '' ?>>Terminée</option>
                            </select>
                            <div class="invalid-feedback" id="err-statut"><?= isset($errors['statut']) ? $errors['statut'] : '' ?></div>
                        </div>
                        <div class="col-md-6">
                            <label style="font-weight: 600; color: #2b2b2b; margin-bottom: 8px; display: block;">Compétences <span style="color: #fa5b0f;">*</span></label>
                            <input type="text" name="competences" id="competences" class="form-control <?= isset($errors['competences']) ? 'is-invalid' : '' ?>"
                                   style="border-radius: 10px; padding: 12px 15px; border: 1px solid #ddd;"
                                   placeholder="ex: PHP, JavaScript, MySQL"
                                   value="<?= isset($_POST['competences']) ? htmlspecialchars($_POST['competences']) : '' ?>">
                            <div class="invalid-feedback" id="err-competences"><?= isset($errors['competences']) ? $errors['competences'] : '' ?></div>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="main-button" style="border: none; cursor: pointer;">
                            <i class="fa fa-save"></i> Enregistrer
                        </button>
                        <a href="index.php?action=missions" class="main-button" style="background: #2b2b2b; text-decoration: none; color: white; display: inline-block; padding: 12px 25px; border-radius: 25px;">
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
