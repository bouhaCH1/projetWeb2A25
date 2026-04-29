<?php
ob_start();
?>

<!-- ===== Page Banner ===== -->
<div class="cyber-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h6>Publier</h6>
                <h2>Creer une nouvelle mission</h2>
            </div>
        </div>
    </div>
</div>

<div class="container" style="padding: 60px 0;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="cyber-form-card">
                <form id="missionForm" method="POST" action="index.php?action=front_create" novalidate>
                    <div class="mb-4">
                        <label>Titre <span class="required">*</span></label>
                        <input type="text" name="titre" id="titre" class="<?= isset($errors['titre']) ? 'is-invalid' : '' ?>"
                               value="<?= isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '' ?>">
                        <div class="invalid-feedback" id="err-titre"><?= isset($errors['titre']) ? $errors['titre'] : '' ?></div>
                    </div>

                    <div class="mb-4">
                        <label>Description <span class="required">*</span></label>
                        <textarea name="description" id="description" rows="4"
                                  class="<?= isset($errors['description']) ? 'is-invalid' : '' ?>"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
                        <div class="invalid-feedback" id="err-description"><?= isset($errors['description']) ? $errors['description'] : '' ?></div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label>Budget (EUR) <span class="required">*</span></label>
                            <input type="text" name="budget" id="budget" class="<?= isset($errors['budget']) ? 'is-invalid' : '' ?>"
                                   value="<?= isset($_POST['budget']) ? htmlspecialchars($_POST['budget']) : '' ?>">
                            <div class="invalid-feedback" id="err-budget"><?= isset($errors['budget']) ? $errors['budget'] : '' ?></div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label>Date debut <span class="required">*</span></label>
                            <input type="date" name="date_debut" id="date_debut" class="<?= isset($errors['date_debut']) ? 'is-invalid' : '' ?>"
                                   value="<?= isset($_POST['date_debut']) ? $_POST['date_debut'] : '' ?>">
                            <div class="invalid-feedback" id="err-date_debut"><?= isset($errors['date_debut']) ? $errors['date_debut'] : '' ?></div>
                        </div>
                        <div class="col-md-4">
                            <label>Date fin <span class="required">*</span></label>
                            <input type="date" name="date_fin" id="date_fin" class="<?= isset($errors['date_fin']) ? 'is-invalid' : '' ?>"
                                   value="<?= isset($_POST['date_fin']) ? $_POST['date_fin'] : '' ?>">
                            <div class="invalid-feedback" id="err-date_fin"><?= isset($errors['date_fin']) ? $errors['date_fin'] : '' ?></div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label>Statut <span class="required">*</span></label>
                            <select name="statut" id="statut" class="<?= isset($errors['statut']) ? 'is-invalid' : '' ?>">
                                <option value="">-- Choisir --</option>
                                <option value="ouverte" <?= (isset($_POST['statut']) && $_POST['statut'] === 'ouverte') ? 'selected' : '' ?>>Ouverte</option>
                                <option value="en_cours" <?= (isset($_POST['statut']) && $_POST['statut'] === 'en_cours') ? 'selected' : '' ?>>En cours</option>
                                <option value="terminee" <?= (isset($_POST['statut']) && $_POST['statut'] === 'terminee') ? 'selected' : '' ?>>Terminee</option>
                            </select>
                            <div class="invalid-feedback" id="err-statut"><?= isset($errors['statut']) ? $errors['statut'] : '' ?></div>
                        </div>
                        <div class="col-md-6">
                            <label>Competences <span class="required">*</span></label>
                            <input type="text" name="competences" id="competences" class="<?= isset($errors['competences']) ? 'is-invalid' : '' ?>"
                                   placeholder="ex: PHP, JavaScript, MySQL"
                                   value="<?= isset($_POST['competences']) ? htmlspecialchars($_POST['competences']) : '' ?>">
                            <div class="invalid-feedback" id="err-competences"><?= isset($errors['competences']) ? $errors['competences'] : '' ?></div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label>Catégorie <span class="optional">(optionnel)</span></label>
                            <select name="categorie" id="categorie">
                                <option value="">-- Choisir --</option>
                                <option value="developpement" <?= (isset($_POST['categorie']) && $_POST['categorie'] === 'developpement') ? 'selected' : '' ?>>Développement Web</option>
                                <option value="mobile" <?= (isset($_POST['categorie']) && $_POST['categorie'] === 'mobile') ? 'selected' : '' ?>>Applications Mobiles</option>
                                <option value="design" <?= (isset($_POST['categorie']) && $_POST['categorie'] === 'design') ? 'selected' : '' ?>>Design & UX</option>
                                <option value="marketing" <?= (isset($_POST['categorie']) && $_POST['categorie'] === 'marketing') ? 'selected' : '' ?>>Marketing Digital</option>
                                <option value="data" <?= (isset($_POST['categorie']) && $_POST['categorie'] === 'data') ? 'selected' : '' ?>>Data & Analytics</option>
                                <option value="autre" <?= (isset($_POST['categorie']) && $_POST['categorie'] === 'autre') ? 'selected' : '' ?>>Autre</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Niveau <span class="optional">(optionnel)</span></label>
                            <select name="niveau" id="niveau">
                                <option value="">-- Choisir --</option>
                                <option value="debutant" <?= (isset($_POST['niveau']) && $_POST['niveau'] === 'debutant') ? 'selected' : '' ?>>Débutant</option>
                                <option value="intermediaire" <?= (isset($_POST['niveau']) && $_POST['niveau'] === 'intermediaire') ? 'selected' : '' ?>>Intermédiaire</option>
                                <option value="avance" <?= (isset($_POST['niveau']) && $_POST['niveau'] === 'avance') ? 'selected' : '' ?>>Avancé</option>
                                <option value="expert" <?= (isset($_POST['niveau']) && $_POST['niveau'] === 'expert') ? 'selected' : '' ?>>Expert</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="cyber-btn" style="border: none; cursor: pointer;">
                            <i class="fa fa-save"></i> Enregistrer
                        </button>
                        <a href="index.php?action=missions" class="cyber-btn cyber-btn-outline">
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
