<?php
$activePage = 'list';
$pageTitle  = 'Modifier la Mission';
$pageIcon   = 'edit';

ob_start();
?>

<section class="bg-secondary rounded h-100 p-4 fade-in">
    <header class="mb-4">
        <h1 class="h6 d-flex align-items-center">
            <i class="fas fa-edit me-2 text-primary"></i>
            <span>Modifier la Mission #<?= htmlspecialchars($missionData['id']) ?></span>
        </h1>
        <p class="text-light mb-0">Mettre à jour les informations de la mission</p>
    </header>

    <form id="missionForm" method="POST" action="index.php?action=edit&id=<?= $missionData['id'] ?>" novalidate class="needs-validation" novalidate>

        <fieldset class="form-section mb-4">
            <legend class="h6 text-primary mb-3">
                <i class="fas fa-info-circle me-2"></i>Informations générales
            </legend>
            
            <div class="row g-3">
                <div class="col-md-8">
                    <label for="titre" class="form-label">
                        Titre de la mission 
                        <span class="text-danger" aria-label="obligatoire">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-0">
                            <i class="fas fa-heading text-primary"></i>
                        </span>
                        <input type="text" 
                               name="titre" 
                               id="titre" 
                               class="form-control bg-dark border-0 <?= isset($errors['titre']) ? 'is-invalid' : '' ?>"
                               value="<?= isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : htmlspecialchars($missionData['titre']) ?>"
                               placeholder="Entrez un titre clair et descriptif"
                               pattern="^[a-zA-Z\séèêëàâäùûüôöîïç]+$"
                               title="Lettres et accents uniquement"
                               required
                               aria-describedby="titre-help err-titre">
                    </div>
                    <small id="titre-help" class="form-text text-light">Utilisez des mots clés pertinents pour attirer les bons freelancers</small>
                    <div class="invalid-feedback" id="err-titre">
                        <?= isset($errors['titre']) ? $errors['titre'] : 'Veuillez entrer un titre valide' ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="budget" class="form-label">
                        Budget (EUR) 
                        <span class="text-danger" aria-label="obligatoire">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-0">
                            <i class="fas fa-euro-sign text-primary"></i>
                        </span>
                        <input type="number" 
                               name="budget" 
                               id="budget" 
                               class="form-control bg-dark border-0 <?= isset($errors['budget']) ? 'is-invalid' : '' ?>"
                               value="<?= isset($_POST['budget']) ? htmlspecialchars($_POST['budget']) : $missionData['budget'] ?>"
                               placeholder="1000"
                               min="1"
                               max="999999"
                               required
                               aria-describedby="budget-help err-budget">
                    </div>
                    <small id="budget-help" class="form-text text-light">Budget total pour la mission</small>
                    <div class="invalid-feedback" id="err-budget">
                        <?= isset($errors['budget']) ? $errors['budget'] : 'Veuillez entrer un budget valide (minimum 1 EUR)' ?>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <label for="description" class="form-label">
                    Description détaillée 
                    <span class="text-danger" aria-label="obligatoire">*</span>
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="4"
                          class="form-control bg-dark border-0 <?= isset($errors['description']) ? 'is-invalid' : '' ?>"
                          placeholder="Décrivez en détail les tâches à accomplir..."
                          pattern="^[a-zA-Z\séèêëàâäùûüôöîïç,.!?;:'"()-]+$"
                          required
                          aria-describedby="description-help err-description"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : htmlspecialchars($missionData['description']) ?></textarea>
                <small id="description-help" class="form-text text-light">Soyez précis sur les livrables attendus et les compétences requises</small>
                <div class="invalid-feedback" id="err-description">
                    <?= isset($errors['description']) ? $errors['description'] : 'Veuillez entrer une description détaillée' ?>
                </div>
            </div>
        </fieldset>

        <fieldset class="form-section mb-4">
            <legend class="h6 text-primary mb-3">
                <i class="fas fa-calendar-alt me-2"></i>Période et statut
            </legend>
            
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="date_debut" class="form-label">
                        Date de début 
                        <span class="text-danger" aria-label="obligatoire">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-0">
                            <i class="fas fa-play text-primary"></i>
                        </span>
                        <input type="date" 
                               name="date_debut" 
                               id="date_debut"
                               class="form-control bg-dark border-0 <?= isset($errors['date_debut']) ? 'is-invalid' : '' ?>"
                               value="<?= isset($_POST['date_debut']) ? $_POST['date_debut'] : $missionData['date_debut'] ?>"
                               min="<?= date('Y-m-d') ?>"
                               required
                               aria-describedby="date_debut-help err-date_debut">
                    </div>
                    <small id="date_debut-help" class="form-text text-light">Date à laquelle la mission doit commencer</small>
                    <div class="invalid-feedback" id="err-date_debut">
                        <?= isset($errors['date_debut']) ? $errors['date_debut'] : 'Veuillez choisir une date de début valide' ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="date_fin" class="form-label">
                        Date de fin 
                        <span class="text-danger" aria-label="obligatoire">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-0">
                            <i class="fas fa-stop text-primary"></i>
                        </span>
                        <input type="date" 
                               name="date_fin" 
                               id="date_fin"
                               class="form-control bg-dark border-0 <?= isset($errors['date_fin']) ? 'is-invalid' : '' ?>"
                               value="<?= isset($_POST['date_fin']) ? $_POST['date_fin'] : $missionData['date_fin'] ?>"
                               min="<?= date('Y-m-d') ?>"
                               required
                               aria-describedby="date_fin-help err-date_fin">
                    </div>
                    <small id="date_fin-help" class="form-text text-light">Date limite de réalisation</small>
                    <div class="invalid-feedback" id="err-date_fin">
                        <?= isset($errors['date_fin']) ? $errors['date_fin'] : 'Veuillez choisir une date de fin valide' ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="statut" class="form-label">
                        Statut 
                        <span class="text-danger" aria-label="obligatoire">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-0">
                            <i class="fas fa-flag text-primary"></i>
                        </span>
                        <select name="statut" 
                                id="statut" 
                                class="form-select bg-dark border-0 <?= isset($errors['statut']) ? 'is-invalid' : '' ?>"
                                required
                                aria-describedby="statut-help err-statut">
                            <option value="">-- Choisir un statut --</option>
                            <?php
                            $statuts = ['ouverte' => 'Ouverte', 'en_cours' => 'En cours', 'terminee' => 'Terminée'];
                            $currentStatut = isset($_POST['statut']) ? $_POST['statut'] : $missionData['statut'];
                            foreach ($statuts as $val => $label):
                            ?>
                            <option value="<?= $val ?>" <?= $currentStatut == $val ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <small id="statut-help" class="form-text text-light">État actuel de la mission</small>
                    <div class="invalid-feedback" id="err-statut">
                        <?= isset($errors['statut']) ? $errors['statut'] : 'Veuillez choisir un statut' ?>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset class="form-section mb-4">
            <legend class="h6 text-primary mb-3">
                <i class="fas fa-tools me-2"></i>Compétences requises
            </legend>
            
            <div class="mb-3">
                <label for="competences" class="form-label">
                    Compétences techniques 
                    <span class="text-danger" aria-label="obligatoire">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-dark border-0">
                        <i class="fas fa-code text-primary"></i>
                    </span>
                    <input type="text" 
                           name="competences" 
                           id="competences"
                           class="form-control bg-dark border-0 <?= isset($errors['competences']) ? 'is-invalid' : '' ?>"
                           placeholder="ex: PHP, JavaScript, MySQL, React"
                           pattern="^[a-zA-Z\s,\-]+$"
                           title="Compétences séparées par des virgules"
                           required
                           aria-describedby="competences-help err-competences"
                           value="<?= isset($_POST['competences']) ? htmlspecialchars($_POST['competences']) : htmlspecialchars($missionData['competences']) ?>">
                </div>
                <small id="competences-help" class="form-text text-light">Séparez les compétences par des virgules</small>
                <div class="invalid-feedback" id="err-competences">
                    <?= isset($errors['competences']) ? $errors['competences'] : 'Veuillez entrer les compétences requises' ?>
                </div>
            </div>

            <div class="alert alert-info bg-dark border border-info text-light">
                <i class="fas fa-lightbulb me-2"></i>
                <strong>Conseil:</strong> Soyez spécifique sur les technologies et niveaux de compétence requis (ex: "JavaScript avancé", "React 3+ ans")
            </div>
        </fieldset>

        <div class="form-actions d-flex gap-3 justify-content-end pt-3 border-top border-secondary">
            <a href="index.php?action=index" class="btn btn-outline-light">
                <i class="fas fa-times me-1"></i> 
                <span>Annuler</span>
            </a>
            <button type="submit" class="btn btn-primary pulse-on-hover">
                <i class="fas fa-save me-1"></i> 
                <span>Mettre à jour</span>
            </button>
        </div>
    </form>
</section>

<?php
$extraJs = '<script src="../View/public/assets/js/validation.php"></script>';
$content = ob_get_clean();
require_once 'layout.php';
?>