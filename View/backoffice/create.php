<?php
$activePage = 'create';
$pageTitle  = 'Ajouter une Mission';
$pageIcon   = 'plus-circle';

ob_start();
?>

<section class="bg-secondary rounded h-100 p-4 fade-in">
    <header class="mb-4">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="h6 d-flex align-items-center mb-2">
                    <i class="fas fa-plus-circle me-2 text-primary"></i>
                    <span>Nouvelle Mission</span>
                </h1>
                <p class="text-light mb-0">Créer une nouvelle mission pour les freelancers</p>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-light btn-sm" id="saveDraftBtn" title="Sauvegarder comme brouillon">
                    <i class="fas fa-save me-1"></i> Brouillon
                </button>
                <button type="button" class="btn btn-outline-light btn-sm" id="clearFormBtn" title="Vider le formulaire">
                    <i class="fas fa-eraser me-1"></i> Vider
                </button>
            </div>
        </div>
    </header>

    <!-- Progress Bar -->
    <div class="progress mb-4" style="height: 6px;">
        <div class="progress-bar bg-primary" id="formProgress" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <!-- Auto-save Status -->
    <div class="alert alert-info bg-dark border border-info text-light d-none" id="autoSaveStatus">
        <i class="fas fa-sync-alt me-2 fa-spin"></i>
        <span id="autoSaveMessage">Brouillon sauvegardé automatiquement</span>
    </div>

    <form id="missionForm" method="POST" action="index.php?action=create" novalidate class="needs-validation" novalidate>

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
                               value="<?= isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '' ?>"
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
                               value="<?= isset($_POST['budget']) ? htmlspecialchars($_POST['budget']) : '' ?>"
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
                          maxlength="2000"
                          aria-describedby="description-help err-description description-counter"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
                <div class="d-flex justify-content-between">
                    <small id="description-help" class="form-text text-light">Soyez précis sur les livrables attendus et les compétences requises</small>
                    <small id="description-counter" class="form-text text-light">0 / 2000 caractères</small>
                </div>
                <div class="invalid-feedback" id="err-description">
                    <?= isset($errors['description']) ? $errors['description'] : 'Veuillez entrer une description détaillée' ?>
                </div>
            </div>

            <!-- Additional Fields -->
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label for="categorie" class="form-label">
                        Catégorie 
                        <span class="text-muted">(optionnel)</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-0">
                            <i class="fas fa-tag text-primary"></i>
                        </span>
                        <select name="categorie" 
                                id="categorie"
                                class="form-select bg-dark border-0"
                                aria-describedby="categorie-help">
                            <option value="">-- Choisir une catégorie --</option>
                            <option value="developpement">Développement Web</option>
                            <option value="mobile">Applications Mobiles</option>
                            <option value="design">Design & UX</option>
                            <option value="marketing">Marketing Digital</option>
                            <option value="data">Data & Analytics</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                    <small id="categorie-help" class="form-text text-light">Aide à classer la mission</small>
                </div>

                <div class="col-md-6">
                    <label for="niveau" class="form-label">
                        Niveau de compétence requis 
                        <span class="text-muted">(optionnel)</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-0">
                            <i class="fas fa-graduation-cap text-primary"></i>
                        </span>
                        <select name="niveau" 
                                id="niveau"
                                class="form-select bg-dark border-0"
                                aria-describedby="niveau-help">
                            <option value="">-- Choisir un niveau --</option>
                            <option value="debutant">Débutant</option>
                            <option value="intermediaire">Intermédiaire</option>
                            <option value="avance">Avancé</option>
                            <option value="expert">Expert</option>
                        </select>
                    </div>
                    <small id="niveau-help" class="form-text text-light">Niveau d'expertise attendu</small>
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
                               value="<?= isset($_POST['date_debut']) ? $_POST['date_debut'] : '' ?>"
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
                               value="<?= isset($_POST['date_fin']) ? $_POST['date_fin'] : '' ?>"
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
                            <option value="ouverte" <?= (isset($_POST['statut']) && $_POST['statut']=='ouverte') ? 'selected' : '' ?>>
                                <i class="fas fa-door-open"></i> Ouverte
                            </option>
                            <option value="en_cours" <?= (isset($_POST['statut']) && $_POST['statut']=='en_cours') ? 'selected' : '' ?>>
                                <i class="fas fa-spinner"></i> En cours
                            </option>
                            <option value="terminee" <?= (isset($_POST['statut']) && $_POST['statut']=='terminee') ? 'selected' : '' ?>>
                                <i class="fas fa-check-circle"></i> Terminée
                            </option>
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
                           value="<?= isset($_POST['competences']) ? htmlspecialchars($_POST['competences']) : '' ?>">
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
                <span>Créer la mission</span>
            </button>
        </div>
    </form>
</section>

<?php
$extraJs = '
<script>
// Auto-save functionality
let autoSaveTimer;
const form = document.getElementById("missionForm");
const autoSaveStatus = document.getElementById("autoSaveStatus");
const autoSaveMessage = document.getElementById("autoSaveMessage");
const progressBar = document.getElementById("formProgress");

// Character counter for description
const descriptionTextarea = document.getElementById("description");
const descriptionCounter = document.getElementById("description-counter");

descriptionTextarea.addEventListener("input", function() {
    const length = this.value.length;
    const maxLength = this.maxLength;
    descriptionCounter.textContent = `${length} / ${maxLength} caractères`;
    
    if (length > maxLength * 0.9) {
        descriptionCounter.classList.add("text-warning");
    } else {
        descriptionCounter.classList.remove("text-warning");
    }
});

// Progress bar update
function updateProgress() {
    const inputs = form.querySelectorAll("input[required], textarea[required], select[required]");
    let filled = 0;
    
    inputs.forEach(input => {
        if (input.value.trim() !== "") {
            filled++;
        }
    });
    
    const progress = (filled / inputs.length) * 100;
    progressBar.style.width = progress + "%";
    progressBar.setAttribute("aria-valuenow", progress);
}

// Auto-save to localStorage
function saveDraft() {
    const formData = new FormData(form);
    const draft = {};
    
    for (let [key, value] of formData.entries()) {
        draft[key] = value;
    }
    
    localStorage.setItem("missionDraft", JSON.stringify(draft));
    
    // Show auto-save status
    autoSaveStatus.classList.remove("d-none");
    autoSaveMessage.textContent = "Brouillon sauvegardé automatiquement";
    
    setTimeout(() => {
        autoSaveStatus.classList.add("d-none");
    }, 2000);
}

// Load draft from localStorage
function loadDraft() {
    const draft = localStorage.getItem("missionDraft");
    if (draft) {
        const data = JSON.parse(draft);
        
        Object.keys(data).forEach(key => {
            const input = form.querySelector(`[name="${key}"]`);
            if (input) {
                input.value = data[key];
            }
        });
        
        updateProgress();
        
        // Update character counter
        const descriptionLength = descriptionTextarea.value.length;
        descriptionCounter.textContent = `${descriptionLength} / 2000 caractères`;
    }
}

// Clear form
document.getElementById("clearFormBtn").addEventListener("click", function() {
    if (confirm("Êtes-vous sûr de vouloir vider le formulaire ?")) {
        form.reset();
        localStorage.removeItem("missionDraft");
        updateProgress();
        descriptionCounter.textContent = "0 / 2000 caractères";
    }
});

// Save draft manually
document.getElementById("saveDraftBtn").addEventListener("click", function() {
    saveDraft();
    autoSaveMessage.textContent = "Brouillon sauvegardé manuellement";
});

// Auto-save on input change
form.addEventListener("input", function() {
    clearTimeout(autoSaveTimer);
    autoSaveTimer = setTimeout(saveDraft, 1000);
    updateProgress();
});

// Form validation
form.addEventListener("submit", function(e) {
    if (!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
        
        // Show validation feedback
        const inputs = form.querySelectorAll(":invalid");
        inputs.forEach(input => {
            input.classList.add("is-invalid");
        });
        
        // Scroll to first error
        const firstError = form.querySelector(":invalid");
        if (firstError) {
            firstError.scrollIntoView({ behavior: "smooth", block: "center" });
            firstError.focus();
        }
    } else {
        // Clear draft on successful submission
        localStorage.removeItem("missionDraft");
    }
});

// Real-time validation
const inputs = form.querySelectorAll("input, textarea, select");
inputs.forEach(input => {
    input.addEventListener("blur", function() {
        if (this.checkValidity()) {
            this.classList.remove("is-invalid");
            this.classList.add("is-valid");
        } else {
            this.classList.remove("is-valid");
            this.classList.add("is-invalid");
        }
    });
});

// Initialize on page load
document.addEventListener("DOMContentLoaded", function() {
    loadDraft();
    updateProgress();
});

// Keyboard shortcuts
document.addEventListener("keydown", function(e) {
    // Ctrl+S to save draft
    if (e.ctrlKey && e.key === "s") {
        e.preventDefault();
        saveDraft();
    }
    
    // Ctrl+Enter to submit form
    if (e.ctrlKey && e.key === "Enter") {
        e.preventDefault();
        form.submit();
    }
});
</script>';
$content = ob_get_clean();
require_once 'layout.php';
?>