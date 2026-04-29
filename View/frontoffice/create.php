<?php
ob_start();
?>

<!-- Hero Section -->
<section class="hero" style="min-height: 40vh; padding: 80px 0 40px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 style="font-size: 42px; font-weight: 700; margin-bottom: 15px; background: linear-gradient(135deg, #00ffcc, #00ccff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    Créer une nouvelle mission
                </h1>
                <p style="color: rgba(255,255,255,0.7); font-size: 16px; margin-bottom: 20px;">
                    Publiez votre mission et trouvez le freelancer parfait
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Form Section -->
<section style="padding: 40px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="cyber-form-card">
                    <form id="missionForm" method="POST" action="index.php?action=front_create" novalidate>
                        <div class="mb-4">
                            <label>Titre <span style="color: #ff6b6b;">*</span></label>
                            <input type="text" name="titre" id="titre" class="<?= isset($errors['titre']) ? 'is-invalid' : '' ?>"
                                   placeholder="Ex: Développement site e-commerce"
                                   value="<?= isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '' ?>">
                            <div class="invalid-feedback"><?= isset($errors['titre']) ? $errors['titre'] : '' ?></div>
                        </div>

                        <div class="mb-4">
                            <label>Description <span style="color: #ff6b6b;">*</span></label>
                            <textarea name="description" id="description" rows="5"
                                      class="<?= isset($errors['description']) ? 'is-invalid' : '' ?>"
                                      placeholder="Décrivez en détail la mission..."><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
                            <div class="invalid-feedback"><?= isset($errors['description']) ? $errors['description'] : '' ?></div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label>Budget (EUR) <span style="color: #ff6b6b;">*</span></label>
                                <input type="number" name="budget" id="budget" class="<?= isset($errors['budget']) ? 'is-invalid' : '' ?>"
                                       placeholder="1000"
                                       value="<?= isset($_POST['budget']) ? htmlspecialchars($_POST['budget']) : '' ?>">
                                <div class="invalid-feedback"><?= isset($errors['budget']) ? $errors['budget'] : '' ?></div>
                            </div>
                            <div class="col-md-6">
                                <label>Statut <span style="color: #ff6b6b;">*</span></label>
                                <select name="statut" id="statut" class="<?= isset($errors['statut']) ? 'is-invalid' : '' ?>">
                                    <option value="">-- Choisir --</option>
                                    <option value="ouverte" <?= (isset($_POST['statut']) && $_POST['statut'] === 'ouverte') ? 'selected' : '' ?>>Ouverte</option>
                                    <option value="en_cours" <?= (isset($_POST['statut']) && $_POST['statut'] === 'en_cours') ? 'selected' : '' ?>>En cours</option>
                                    <option value="terminee" <?= (isset($_POST['statut']) && $_POST['statut'] === 'terminee') ? 'selected' : '' ?>>Terminée</option>
                                </select>
                                <div class="invalid-feedback"><?= isset($errors['statut']) ? $errors['statut'] : '' ?></div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label>Date début <span style="color: #ff6b6b;">*</span></label>
                                <input type="date" name="date_debut" id="date_debut" class="<?= isset($errors['date_debut']) ? 'is-invalid' : '' ?>"
                                       value="<?= isset($_POST['date_debut']) ? $_POST['date_debut'] : '' ?>">
                                <div class="invalid-feedback"><?= isset($errors['date_debut']) ? $errors['date_debut'] : '' ?></div>
                            </div>
                            <div class="col-md-6">
                                <label>Date fin <span style="color: #ff6b6b;">*</span></label>
                                <input type="date" name="date_fin" id="date_fin" class="<?= isset($errors['date_fin']) ? 'is-invalid' : '' ?>"
                                       value="<?= isset($_POST['date_fin']) ? $_POST['date_fin'] : '' ?>">
                                <div class="invalid-feedback"><?= isset($errors['date_fin']) ? $errors['date_fin'] : '' ?></div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label>Compétences <span style="color: #ff6b6b;">*</span></label>
                            <input type="text" name="competences" id="competences" class="<?= isset($errors['competences']) ? 'is-invalid' : '' ?>"
                                   placeholder="ex: PHP, JavaScript, MySQL"
                                   value="<?= isset($_POST['competences']) ? htmlspecialchars($_POST['competences']) : '' ?>">
                            <div class="invalid-feedback"><?= isset($errors['competences']) ? $errors['competences'] : '' ?></div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label>Catégorie <span style="color: rgba(255,255,255,0.5);">(optionnel)</span></label>
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
                                <label>Niveau <span style="color: rgba(255,255,255,0.5);">(optionnel)</span></label>
                                <select name="niveau" id="niveau">
                                    <option value="">-- Choisir --</option>
                                    <option value="debutant" <?= (isset($_POST['niveau']) && $_POST['niveau'] === 'debutant') ? 'selected' : '' ?>>Débutant</option>
                                    <option value="intermediaire" <?= (isset($_POST['niveau']) && $_POST['niveau'] === 'intermediaire') ? 'selected' : '' ?>>Intermédiaire</option>
                                    <option value="avance" <?= (isset($_POST['niveau']) && $_POST['niveau'] === 'avance') ? 'selected' : '' ?>>Avancé</option>
                                    <option value="expert" <?= (isset($_POST['niveau']) && $_POST['niveau'] === 'expert') ? 'selected' : '' ?>>Expert</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex gap-3 justify-content-end">
                            <a href="index.php?action=missions" class="cyber-btn" style="background: transparent; border: 1px solid #00ffcc; color: #00ffcc;">
                                <i class="fa fa-times"></i> Annuler
                            </a>
                            <button type="submit" class="cyber-btn">
                                <i class="fa fa-save"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
$extraJs = '<script src="../View/public/assets/js/validation.php"></script>';
require_once 'layout.php';
?>
