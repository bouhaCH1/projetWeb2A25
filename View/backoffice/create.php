<?php
$activePage = 'create';
$pageTitle  = 'Ajouter une Mission';
$pageIcon   = 'plus-circle';

ob_start();
?>

<style>
    :root {
        --accent-gradient: linear-gradient(135deg, #ff6b35, #e63946);
        --glass-bg: rgba(18, 22, 31, 0.85);
        --glass-border: rgba(255, 255, 255, 0.08);
        --input-focus-shadow: 0 0 0 4px rgba(255, 107, 53, 0.15);
    }

    .creation-container {
        max-width: 1100px;
        margin: 0 auto;
        padding-bottom: 50px;
    }

    .forge-card {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        margin-bottom: 30px;
        transition: transform 0.3s ease, border-color 0.3s ease;
    }

    .forge-card:hover {
        border-color: rgba(255, 107, 53, 0.3);
    }

    .card-header-premium {
        background: linear-gradient(90deg, rgba(42, 49, 67, 0.8), rgba(32, 39, 56, 0.8));
        padding: 20px 30px;
        border-bottom: 1px solid var(--glass-border);
        display: flex;
        align-items: center;
    }

    .card-header-premium i {
        background: var(--accent-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 1.4rem;
        margin-right: 15px;
    }

    .form-section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #fff;
        margin: 0;
        letter-spacing: 0.5px;
    }

    .form-group-custom {
        margin-bottom: 25px;
    }

    .label-premium {
        color: #cfd6e6;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 10px;
        display: block;
        transition: color 0.3s ease;
    }

    .form-control-premium {
        background: rgba(15, 19, 29, 0.7);
        border: 1px solid #2b3140;
        border-radius: 12px;
        color: #fff;
        padding: 12px 18px;
        font-size: 0.95rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-control-premium:focus {
        background: rgba(15, 19, 29, 0.9);
        border-color: #ff936d;
        box-shadow: var(--input-focus-shadow);
        transform: translateY(-2px);
    }

    .form-control-premium::placeholder {
        color: #4b5563;
    }

    .input-group-premium {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon-left {
        position: absolute;
        left: 15px;
        color: #ff936d;
        font-size: 0.9rem;
        pointer-events: none;
    }

    .input-group-premium .form-control-premium {
        padding-left: 42px;
    }

    .btn-forge-primary {
        background: var(--accent-gradient);
        border: none;
        color: #fff;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 700;
        letter-spacing: 0.5px;
        box-shadow: 0 8px 20px rgba(230, 57, 70, 0.3);
        transition: all 0.3s ease;
    }

    .btn-forge-primary:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 12px 28px rgba(230, 57, 70, 0.45);
        color: #fff;
    }

    .btn-forge-outline {
        background: transparent;
        border: 1px solid var(--glass-border);
        color: #cfd6e6;
        padding: 12px 25px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-forge-outline:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: #ff936d;
        color: #fff;
        transform: translateY(-2px);
    }

    .badge-premium {
        background: rgba(255, 107, 53, 0.1);
        color: #ff936d;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .char-counter {
        font-size: 0.8rem;
        color: #4b5563;
        font-weight: 500;
    }

    .animate-up {
        animation: slideUp 0.6s ease forwards;
        opacity: 0;
    }

    @keyframes slideUp {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }
    .stagger-3 { animation-delay: 0.3s; }

    /* Custom select arrow */
    select.form-control-premium {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23ff936d' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        padding-right: 45px;
    }
</style>

<div class="creation-container">
    <!-- Header -->
    <header class="d-flex align-items-center justify-content-between mb-5 animate-up">
        <div>
            <h1 class="h3 text-white fw-800 mb-1">
                <span class="badge-premium me-2">NOUVEAU</span>
                Ajouter une Mission
            </h1>
            <p class="text-muted mb-0">Donnez vie à vos projets en recrutant les meilleurs talents.</p>
        </div>
        <div class="d-flex gap-3">
            <button type="button" class="btn-forge-outline btn-sm" id="saveDraftBtn">
                <i class="fas fa-bookmark me-2"></i> Brouillon
            </button>
            <button type="button" class="btn-forge-outline btn-sm border-danger-subtle text-danger" id="clearFormBtn">
                <i class="fas fa-trash-alt me-2"></i> Effacer
            </button>
        </div>
    </header>

    <!-- Auto-save Status -->
    <div class="alert alert-info bg-dark border border-info text-light d-none mb-4 fade-in" id="autoSaveStatus">
        <i class="fas fa-sync-alt fa-spin me-2 text-info"></i>
        <span id="autoSaveMessage">Brouillon mis à jour...</span>
    </div>

    <form id="missionForm" method="POST" action="index.php?action=create" novalidate class="needs-validation">
        
        <div class="row">
            <!-- Left Column: Main Info -->
            <div class="col-lg-8">
                <div class="forge-card animate-up stagger-1">
                    <div class="card-header-premium">
                        <i class="fas fa-rocket"></i>
                        <h5 class="form-section-title">Informations Générales</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group-custom">
                            <label for="titre" class="label-premium">Titre de la mission <span class="text-danger">*</span></label>
                            <input type="text" name="titre" id="titre" 
                                   class="form-control form-control-premium <?= isset($errors['titre']) ? 'is-invalid' : '' ?>"
                                   value="<?= isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '' ?>"
                                   placeholder="Ex: Développement d'un site Web Next.js" required>
                            <div class="invalid-feedback"><?= $errors['titre'] ?? 'Le titre est requis' ?></div>
                        </div>

                        <div class="form-group-custom">
                            <label for="description" class="label-premium">Description détaillée <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" rows="8"
                                      class="form-control form-control-premium <?= isset($errors['description']) ? 'is-invalid' : '' ?>"
                                      placeholder="Expliquez les objectifs, le contexte et les livrables attendus..." 
                                      required maxlength="2000"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
                            <div class="d-flex justify-content-between mt-2">
                                <small class="text-muted"><i class="fas fa-info-circle me-1"></i> Markdown supporté</small>
                                <span id="description-counter" class="char-counter">0 / 2000</span>
                            </div>
                            <div class="invalid-feedback"><?= $errors['description'] ?? 'La description est requise' ?></div>
                        </div>
                    </div>
                </div>

                <div class="forge-card animate-up stagger-2">
                    <div class="card-header-premium">
                        <i class="fas fa-brain"></i>
                        <h5 class="form-section-title">Compétences & Expertise</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group-custom">
                            <label for="competences" class="label-premium">Compétences techniques <span class="text-danger">*</span></label>
                            <div class="input-group-premium">
                                <i class="fas fa-tags input-icon-left"></i>
                                <input type="text" name="competences" id="competences" 
                                       class="form-control form-control-premium <?= isset($errors['competences']) ? 'is-invalid' : '' ?>"
                                       placeholder="PHP, React, Docker, Figma..." required
                                       value="<?= isset($_POST['competences']) ? htmlspecialchars($_POST['competences']) : '' ?>">
                            </div>
                            <small class="text-muted mt-2 d-block">Séparez les compétences par des virgules</small>
                            <div class="invalid-feedback"><?= $errors['competences'] ?? 'Indiquez au moins une compétence' ?></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label for="categorie" class="label-premium">Catégorie</label>
                                    <select name="categorie" id="categorie" class="form-control form-control-premium">
                                        <option value="">-- Sélectionner --</option>
                                        <option value="developpement">Développement Web</option>
                                        <option value="mobile">Applications Mobiles</option>
                                        <option value="design">Design & UX</option>
                                        <option value="marketing">Marketing Digital</option>
                                        <option value="data">Data & Analytics</option>
                                        <option value="autre">Autre</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label for="niveau" class="label-premium">Niveau requis</label>
                                    <select name="niveau" id="niveau" class="form-control form-control-premium">
                                        <option value="">-- Indifférent --</option>
                                        <option value="debutant">Junior / Débutant</option>
                                        <option value="intermediaire">Intermédiaire</option>
                                        <option value="avance">Senior / Avancé</option>
                                        <option value="expert">Expert / Consultant</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar Settings -->
            <div class="col-lg-4">
                <div class="forge-card animate-up stagger-1">
                    <div class="card-header-premium">
                        <i class="fas fa-wallet"></i>
                        <h5 class="form-section-title">Budget & Statut</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group-custom">
                            <label for="budget" class="label-premium">Budget estimé (EUR) <span class="text-danger">*</span></label>
                            <div class="input-group-premium">
                                <i class="fas fa-euro-sign input-icon-left"></i>
                                <input type="number" name="budget" id="budget" 
                                       class="form-control form-control-premium <?= isset($errors['budget']) ? 'is-invalid' : '' ?>"
                                       value="<?= isset($_POST['budget']) ? htmlspecialchars($_POST['budget']) : '' ?>"
                                       placeholder="0.00" min="1" required>
                            </div>
                            <div class="invalid-feedback"><?= $errors['budget'] ?? 'Budget invalide' ?></div>
                        </div>

                        <div class="form-group-custom">
                            <label for="statut" class="label-premium">Visibilité de la mission <span class="text-danger">*</span></label>
                            <select name="statut" id="statut" class="form-control form-control-premium" required>
                                <option value="ouverte" <?= (isset($_POST['statut']) && $_POST['statut']=='ouverte') ? 'selected' : '' ?>>Publique (Ouverte)</option>
                                <option value="en_cours" <?= (isset($_POST['statut']) && $_POST['statut']=='en_cours') ? 'selected' : '' ?>>Privée (En cours)</option>
                                <option value="terminee" <?= (isset($_POST['statut']) && $_POST['statut']=='terminee') ? 'selected' : '' ?>>Archivée (Terminée)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="forge-card animate-up stagger-2">
                    <div class="card-header-premium">
                        <i class="fas fa-calendar-alt"></i>
                        <h5 class="form-section-title">Timeline</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group-custom">
                            <label for="date_debut" class="label-premium">Date de début <span class="text-danger">*</span></label>
                            <input type="date" name="date_debut" id="date_debut" 
                                   class="form-control form-control-premium <?= isset($errors['date_debut']) ? 'is-invalid' : '' ?>"
                                   value="<?= isset($_POST['date_debut']) ? $_POST['date_debut'] : date('Y-m-d') ?>" required>
                        </div>

                        <div class="form-group-custom">
                            <label for="date_fin" class="label-premium">Échéance prévue <span class="text-danger">*</span></label>
                            <input type="date" name="date_fin" id="date_fin" 
                                   class="form-control form-control-premium <?= isset($errors['date_fin']) ? 'is-invalid' : '' ?>"
                                   value="<?= isset($_POST['date_fin']) ? $_POST['date_fin'] : '' ?>" required>
                        </div>
                        
                        <div class="alert alert-secondary bg-opacity-10 border-0 p-3 mb-0" style="background: rgba(255,255,255,0.03)">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-2 text-primary"></i>
                                Vos données sont protégées et cryptées.
                            </small>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-3 animate-up stagger-3">
                    <button type="submit" class="btn-forge-primary w-100 py-3">
                        <i class="fas fa-paper-plane me-2"></i> PUBLIER LA MISSION
                    </button>
                    <a href="index.php?action=index" class="btn-forge-outline w-100 py-3 text-center text-decoration-none">
                        <i class="fas fa-chevron-left me-2"></i> Retour au tableau de bord
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

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