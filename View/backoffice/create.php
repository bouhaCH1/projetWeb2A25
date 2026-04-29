<?php
$activePage = 'create';
$pageTitle  = 'Ajouter une Mission';
$pageIcon   = 'plus-circle';

ob_start();
?>

<section class="bg-secondary rounded h-100 p-4 fade-in">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-secondary">
        <div>
            <h2 class="h4 text-white mb-1">
                <i class="fas fa-plus-circle text-primary me-2"></i>
                Nouvelle Mission
            </h2>
            <p class="text-muted mb-0">Remplissez les détails pour publier une nouvelle mission</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-primary btn-sm" id="saveDraftBtn">
                <i class="fas fa-save me-1"></i> Sauvegarder
            </button>
            <button type="button" class="btn btn-outline-danger btn-sm" id="clearFormBtn">
                <i class="fas fa-eraser me-1"></i> Réinitialiser
            </button>
        </div>
    </div>

    <!-- Auto-save Status -->
    <div class="alert alert-info bg-dark border border-info text-light d-none mb-4" id="autoSaveStatus">
        <i class="fas fa-check-circle me-2"></i>
        <span id="autoSaveMessage">Brouillon sauvegardé</span>
    </div>

    <form id="missionForm" method="POST" action="index.php?action=create" novalidate class="needs-validation">
        
        <!-- Main Info Card -->
        <div class="card bg-dark border-0 mb-4">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations de base</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-12">
                        <label for="titre" class="form-label text-light fw-bold">
                            Titre de la mission <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="titre" 
                               id="titre" 
                               class="form-control bg-secondary border-0 text-white <?= isset($errors['titre']) ? 'is-invalid' : '' ?>"
                               value="<?= isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '' ?>"
                               placeholder="Ex: Développement site e-commerce"
                               required>
                        <div class="invalid-feedback text-danger">
                            <?= isset($errors['titre']) ? $errors['titre'] : 'Le titre est obligatoire' ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="budget" class="form-label text-light fw-bold">
                            Budget (EUR) <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-secondary border-0 text-primary">€</span>
                            <input type="number" 
                                   name="budget" 
                                   id="budget" 
                                   class="form-control bg-secondary border-0 text-white <?= isset($errors['budget']) ? 'is-invalid' : '' ?>"
                                   value="<?= isset($_POST['budget']) ? htmlspecialchars($_POST['budget']) : '' ?>"
                                   placeholder="1000"
                                   min="1"
                                   max="999999"
                                   required>
                        </div>
                        <div class="invalid-feedback text-danger">
                            <?= isset($errors['budget']) ? $errors['budget'] : 'Budget invalide' ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="statut" class="form-label text-light fw-bold">
                            Statut <span class="text-danger">*</span>
                        </label>
                        <select name="statut" 
                                id="statut" 
                                class="form-select bg-secondary border-0 text-white <?= isset($errors['statut']) ? 'is-invalid' : '' ?>"
                                required>
                            <option value="">Choisir le statut</option>
                            <option value="ouverte" <?= (isset($_POST['statut']) && $_POST['statut']=='ouverte') ? 'selected' : '' ?>>Ouverte</option>
                            <option value="en_cours" <?= (isset($_POST['statut']) && $_POST['statut']=='en_cours') ? 'selected' : '' ?>>En cours</option>
                            <option value="terminee" <?= (isset($_POST['statut']) && $_POST['statut']=='terminee') ? 'selected' : '' ?>>Terminée</option>
                        </select>
                        <div class="invalid-feedback text-danger">
                            <?= isset($errors['statut']) ? $errors['statut'] : 'Statut requis' ?>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label text-light fw-bold">
                            Description <span class="text-danger">*</span>
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="5"
                                  class="form-control bg-secondary border-0 text-white <?= isset($errors['description']) ? 'is-invalid' : '' ?>"
                                  placeholder="Décrivez en détail la mission..."
                                  required
                                  maxlength="2000"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">Soyez précis sur les livrables</small>
                            <small id="description-counter" class="text-muted">0 / 2000</small>
                        </div>
                        <div class="invalid-feedback text-danger">
                            <?= isset($errors['description']) ? $errors['description'] : 'Description requise' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Card -->
        <div class="card bg-dark border-0 mb-4">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Détails additionnels</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="categorie" class="form-label text-light fw-bold">
                            Catégorie
                        </label>
                        <select name="categorie" 
                                id="categorie"
                                class="form-select bg-secondary border-0 text-white">
                            <option value="">Sélectionner (optionnel)</option>
                            <option value="developpement">Développement Web</option>
                            <option value="mobile">Applications Mobiles</option>
                            <option value="design">Design & UX</option>
                            <option value="marketing">Marketing Digital</option>
                            <option value="data">Data & Analytics</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="niveau" class="form-label text-light fw-bold">
                            Niveau requis
                        </label>
                        <select name="niveau" 
                                id="niveau"
                                class="form-select bg-secondary border-0 text-white">
                            <option value="">Sélectionner (optionnel)</option>
                            <option value="debutant">Débutant</option>
                            <option value="intermediaire">Intermédiaire</option>
                            <option value="avance">Avancé</option>
                            <option value="expert">Expert</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="date_debut" class="form-label text-light fw-bold">
                            Date de début <span class="text-danger">*</span>
                        </label>
                        <input type="date" 
                               name="date_debut" 
                               id="date_debut"
                               class="form-control bg-secondary border-0 text-white <?= isset($errors['date_debut']) ? 'is-invalid' : '' ?>"
                               value="<?= isset($_POST['date_debut']) ? $_POST['date_debut'] : '' ?>"
                               min="<?= date('Y-m-d') ?>"
                               required>
                        <div class="invalid-feedback text-danger">
                            <?= isset($errors['date_debut']) ? $errors['date_debut'] : 'Date requise' ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="date_fin" class="form-label text-light fw-bold">
                            Date de fin <span class="text-danger">*</span>
                        </label>
                        <input type="date" 
                               name="date_fin" 
                               id="date_fin"
                               class="form-control bg-secondary border-0 text-white <?= isset($errors['date_fin']) ? 'is-invalid' : '' ?>"
                               value="<?= isset($_POST['date_fin']) ? $_POST['date_fin'] : '' ?>"
                               min="<?= date('Y-m-d') ?>"
                               required>
                        <div class="invalid-feedback text-danger">
                            <?= isset($errors['date_fin']) ? $errors['date_fin'] : 'Date requise' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Skills Card -->
        <div class="card bg-dark border-0 mb-4">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0"><i class="fas fa-tools me-2"></i>Compétences requises</h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label for="competences" class="form-label text-light fw-bold">
                        Compétences techniques <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           name="competences" 
                           id="competences"
                           class="form-control bg-secondary border-0 text-white <?= isset($errors['competences']) ? 'is-invalid' : '' ?>"
                           placeholder="Ex: PHP, JavaScript, MySQL"
                           required
                           value="<?= isset($_POST['competences']) ? htmlspecialchars($_POST['competences']) : '' ?>">
                    <div class="invalid-feedback text-danger">
                        <?= isset($errors['competences']) ? $errors['competences'] : 'Compétences requises' ?>
                    </div>
                </div>
                <div class="alert alert-secondary border-0">
                    <i class="fas fa-lightbulb text-warning me-2"></i>
                    <small class="text-muted">Soyez spécifique: "JavaScript avancé", "React 3+ ans"</small>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex gap-3 justify-content-end pt-3">
            <a href="index.php?action=index" class="btn btn-outline-light px-4">
                <i class="fas fa-times me-2"></i> Annuler
            </a>
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-check me-2"></i> Créer la mission
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

// Character counter for description
const descriptionTextarea = document.getElementById("description");
const descriptionCounter = document.getElementById("description-counter");

descriptionTextarea.addEventListener("input", function() {
    const length = this.value.length;
    const maxLength = this.maxLength;
    descriptionCounter.textContent = `${length} / ${maxLength}`;
    
    if (length > maxLength * 0.9) {
        descriptionCounter.classList.add("text-warning");
    } else {
        descriptionCounter.classList.remove("text-warning");
    }
});

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
    autoSaveMessage.textContent = "Brouillon sauvegardé";
    
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
        
        // Update character counter
        const descriptionLength = descriptionTextarea.value.length;
        descriptionCounter.textContent = `${descriptionLength} / 2000`;
    }
}

// Clear form
document.getElementById("clearFormBtn").addEventListener("click", function() {
    if (confirm("Êtes-vous sûr de vouloir réinitialiser le formulaire ?")) {
        form.reset();
        localStorage.removeItem("missionDraft");
        descriptionCounter.textContent = "0 / 2000";
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