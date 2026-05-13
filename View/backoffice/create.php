<?php
$pageTitle = 'create';
require_once __DIR__ . '/../layout/dashboard_header.php';
?>

<style>
    :root {
        --accent-gradient: linear-gradient(135deg, #ff6b35, #e63946);
        --glass-bg: rgba(18, 22, 31, 0.85);
        --glass-border: rgba(255, 255, 255, 0.08);
        --input-bg: rgba(15, 19, 29, 0.6);
        --input-focus-border: #ff936d;
        --input-focus-shadow: 0 0 0 4px rgba(255, 107, 53, 0.15);
    }

    .creation-container {
        max-width: 1200px;
        margin: 0 auto;
        padding-bottom: 60px;
    }

    /* Cards Styling */
    .forge-card {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        margin-bottom: 35px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .forge-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--accent-gradient);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .forge-card:hover {
        border-color: rgba(255, 107, 53, 0.4);
        transform: translateY(-5px);
    }

    .forge-card:hover::before {
        opacity: 1;
    }

    .card-header-premium {
        background: rgba(255, 255, 255, 0.03);
        padding: 25px 35px;
        border-bottom: 1px solid var(--glass-border);
        display: flex;
        align-items: center;
    }

    .card-header-premium i {
        background: var(--accent-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 1.6rem;
        margin-right: 15px;
    }

    .form-section-title {
        font-size: 1.2rem;
        font-weight: 800;
        color: #fff;
        margin: 0;
        letter-spacing: 0.8px;
        text-transform: uppercase;
    }

    /* Form Elements */
    .form-group-custom {
        margin-bottom: 30px;
    }

    .label-premium {
        color: #ff936d;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 12px;
        display: block;
    }

    .form-control-premium {
        background: var(--input-bg);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 14px;
        color: #fff;
        padding: 14px 20px;
        font-size: 1rem;
        width: 100%;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-control-premium:focus {
        background: rgba(15, 19, 29, 0.9);
        border-color: var(--input-focus-border);
        box-shadow: var(--input-focus-shadow);
        outline: none;
    }

    .form-control-premium::placeholder {
        color: rgba(255, 255, 255, 0.2);
        font-style: italic;
    }

    .input-group-premium {
        position: relative;
    }

    .input-icon-left {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--input-focus-border);
        font-size: 1rem;
        pointer-events: none;
        z-index: 5;
    }

    .input-group-premium .form-control-premium {
        padding-left: 55px;
    }

    /* Buttons */
    .btn-forge-primary {
        background: var(--accent-gradient);
        border: none;
        color: #fff;
        padding: 16px 35px;
        border-radius: 16px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 10px 25px rgba(230, 57, 70, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        width: 100%;
    }

    .btn-forge-primary:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 15px 35px rgba(230, 57, 70, 0.45);
        color: #fff;
    }

    .btn-forge-outline {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--glass-border);
        color: #cfd6e6;
        padding: 14px 25px;
        border-radius: 14px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .btn-forge-outline:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: var(--input-focus-border);
        color: #fff;
        transform: translateY(-2px);
    }

    /* Validation & Indicators */
    .invalid-feedback {
        color: #ff6b6b;
        font-size: 0.8rem;
        font-weight: 600;
        margin-top: 8px;
        display: none;
        align-items: center;
        gap: 5px;
    }

    .is-invalid + .invalid-feedback {
        display: flex;
    }

    .badge-premium {
        background: var(--accent-gradient);
        color: #fff;
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 1px;
    }

    .char-counter {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 600;
        background: rgba(0,0,0,0.2);
        padding: 2px 10px;
        border-radius: 20px;
    }

    /* Select Overrides */
    select.form-control-premium {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23ff936d' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 20px center;
    }

    .animate-in {
        animation: fadeInScale 0.5s ease-out forwards;
    }

    @keyframes fadeInScale {
        from { opacity: 0; transform: scale(0.98) translateY(10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .btn-ai-magic {
        background: linear-gradient(135deg, #6366f1, #a855f7);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(168, 85, 247, 0.3);
    }

    .btn-ai-magic:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 6px 20px rgba(168, 85, 247, 0.4);
        color: white;
    }

    .btn-ai-magic:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .ai-loading-spinner {
        display: none;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* === Demand Forecast Widget === */
    .forecast-card {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.08), rgba(5, 150, 105, 0.04));
        border: 1px solid rgba(16, 185, 129, 0.25);
    }

    .forecast-card .card-header-premium i {
        background: linear-gradient(135deg, #10b981, #06b6d4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .forecast-number {
        font-size: 3.5rem;
        font-weight: 900;
        background: linear-gradient(135deg, #10b981, #06b6d4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 1;
        display: block;
        text-align: center;
        margin: 10px 0 4px;
        transition: all 0.4s ease;
    }

    .forecast-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #64748b;
        font-weight: 700;
        text-align: center;
    }

    .confidence-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .confidence-high   { background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16,185,129,0.3); }
    .confidence-medium { background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245,158,11,0.3); }
    .confidence-low    { background: rgba(239, 68, 68, 0.15);  color: #ef4444; border: 1px solid rgba(239,68,68,0.3); }

    .forecast-insight {
        background: rgba(0,0,0,0.2);
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.78rem;
        color: #94a3b8;
        line-height: 1.5;
        margin-top: 12px;
        border-left: 3px solid #10b981;
    }

    .btn-forecast {
        background: linear-gradient(135deg, #10b981, #0891b2);
        border: none;
        color: #fff;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25);
        width: 100%;
        cursor: pointer;
    }

    .btn-forecast:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        color: #fff;
    }

    .btn-forecast:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .forecast-placeholder {
        text-align: center;
        padding: 10px 0;
        color: #475569;
        font-size: 0.85rem;
    }
</style>

<div class="creation-container animate-in">
    <!-- Page Header -->
    <header class="d-flex align-items-center justify-content-between mb-5">
        <div>
            <div class="d-flex align-items-center mb-2">
                <span class="badge-premium me-3">STUDIO</span>
                <h1 class="h3 text-white fw-900 mb-0">Créer une Mission</h1>
            </div>
            <p class="text-muted mb-0">Définissez les paramètres de votre nouveau projet.</p>
        </div>
        <div class="d-flex gap-3">
            <button type="button" class="btn-forge-outline" id="saveDraftBtn">
                <i class="fas fa-save me-2 text-primary"></i> Sauvegarder Brouillon
            </button>
            <button type="button" class="btn-forge-outline border-danger-subtle text-danger" id="clearFormBtn">
                <i class="fas fa-eraser me-2"></i> Réinitialiser
            </button>
        </div>
    </header>

    <!-- Auto-save Status -->
    <div id="autoSaveStatus" class="alert d-none mb-4" style="background: rgba(0, 255, 204, 0.05); border: 1px solid rgba(0, 255, 204, 0.2); color: #00ffcc; border-radius: 15px;">
        <i class="fas fa-circle-notch fa-spin me-2"></i>
        <span id="autoSaveMessage">Brouillon mis à jour...</span>
    </div>

    <form id="missionForm" method="POST" action="index.php?action=admin_mission_create" novalidate>
        <div class="row">
            <!-- Left Side: Main Content -->
            <div class="col-lg-8">
                <!-- Section 1: Basic Info -->
                <div class="forge-card">
                    <div class="card-header-premium">
                        <i class="fas fa-file-alt"></i>
                        <h5 class="form-section-title">Contenu de la Mission</h5>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="form-group-custom">
                            <label for="titre" class="label-premium">Titre du Projet <span class="text-danger">*</span></label>
                            <input type="text" name="titre" id="titre" 
                                   class="form-control-premium <?= isset($errors['titre']) ? 'is-invalid' : '' ?>"
                                   value="<?= isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '' ?>"
                                   placeholder="Ex: Développement d'une plateforme E-commerce" required>
                            <div class="invalid-feedback"><i class="fas fa-exclamation-triangle"></i> <?= $errors['titre'] ?? 'Le titre est obligatoire' ?></div>
                        </div>

                        <div class="form-group-custom">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label for="description" class="label-premium mb-0">Description Détaillée <span class="text-danger">*</span></label>
                                <div class="d-flex align-items-center gap-3">
                                    <button type="button" id="aiClassifyBtn" class="btn-ai-magic">
                                        <div class="ai-loading-spinner"></div>
                                        <i class="fas fa-magic"></i> Analyser avec l'IA
                                    </button>
                                    <span id="description-counter" class="char-counter">0 / 2000</span>
                                </div>
                            </div>
                            <textarea name="description" id="description" rows="10"
                                      class="form-control-premium <?= isset($errors['description']) ? 'is-invalid' : '' ?>"
                                      placeholder="Décrivez précisément les objectifs, les livrables et le contexte de la mission..." 
                                      required maxlength="2000"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
                            <div class="invalid-feedback"><i class="fas fa-exclamation-triangle"></i> <?= $errors['description'] ?? 'La description est obligatoire' ?></div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Requirements -->
                <div class="forge-card">
                    <div class="card-header-premium">
                        <i class="fas fa-tools"></i>
                        <h5 class="form-section-title">Compétences & Catégorie</h5>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="form-group-custom">
                            <label for="competences" class="label-premium">Expertise Requise <span class="text-danger">*</span></label>
                            <div class="input-group-premium">
                                <i class="fas fa-tag input-icon-left"></i>
                                <input type="text" name="competences" id="competences" 
                                       class="form-control-premium <?= isset($errors['competences']) ? 'is-invalid' : '' ?>"
                                       placeholder="Ex: PHP 8, React, MySQL, UI Design..." required
                                       value="<?= isset($_POST['competences']) ? htmlspecialchars($_POST['competences']) : '' ?>">
                            </div>
                            <small class="text-muted mt-2 d-block">Séparez les compétences par des virgules (,)</small>
                            <div class="invalid-feedback"><i class="fas fa-exclamation-triangle"></i> <?= $errors['competences'] ?? 'Veuillez indiquer les compétences' ?></div>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="categorie" class="label-premium">Domaine</label>
                                <select name="categorie" id="categorie" class="form-control-premium">
                                    <option value="">Sélectionner une catégorie</option>
                                    <option value="developpement">Développement Web</option>
                                    <option value="mobile">Mobile & App</option>
                                    <option value="design">Design & Création</option>
                                    <option value="marketing">Marketing & Comm</option>
                                    <option value="data">Data Science</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="niveau" class="label-premium">Séniorité</label>
                                <select name="niveau" id="niveau" class="form-control-premium">
                                    <option value="">Niveau indifférent</option>
                                    <option value="debutant">Junior</option>
                                    <option value="intermediaire">Intermédiaire</option>
                                    <option value="avance">Senior</option>
                                    <option value="expert">Expert</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Sidebar -->
            <div class="col-lg-4">
                <!-- Budget Card -->
                <div class="forge-card">
                    <div class="card-header-premium">
                        <i class="fas fa-coins"></i>
                        <h5 class="form-section-title">Finances & Statut</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group-custom">
                            <label for="budget" class="label-premium">Budget Prévu (EUR) <span class="text-danger">*</span></label>
                            <div class="input-group-premium">
                                <i class="fas fa-euro-sign input-icon-left"></i>
                                <input type="number" name="budget" id="budget" 
                                       class="form-control-premium <?= isset($errors['budget']) ? 'is-invalid' : '' ?>"
                                       value="<?= isset($_POST['budget']) ? htmlspecialchars($_POST['budget']) : '' ?>"
                                       placeholder="0.00" min="1" required>
                            </div>
                            <div class="invalid-feedback"><i class="fas fa-exclamation-triangle"></i> <?= $errors['budget'] ?? 'Budget invalide' ?></div>
                        </div>

                        <div class="form-group-custom mb-0">
                            <label for="statut" class="label-premium">État Initial</label>
                            <select name="statut" id="statut" class="form-control-premium" required>
                                <option value="ouverte">Ouverte (Public)</option>
                                <option value="en_cours">Brouillon (Privé)</option>
                                <option value="terminee">Archivée</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Timeline Card -->
                <div class="forge-card">
                    <div class="card-header-premium">
                        <i class="fas fa-hourglass-half"></i>
                        <h5 class="form-section-title">Planification</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group-custom">
                            <label for="date_debut" class="label-premium">Début Prévu <span class="text-danger">*</span></label>
                            <div class="input-group-premium">
                                <i class="fas fa-calendar-day input-icon-left"></i>
                                <input type="date" name="date_debut" id="date_debut" 
                                       class="form-control-premium <?= isset($errors['date_debut']) ? 'is-invalid' : '' ?>"
                                       value="<?= isset($_POST['date_debut']) ? $_POST['date_debut'] : date('Y-m-d') ?>" required>
                            </div>
                        </div>

                        <div class="form-group-custom mb-0">
                            <label for="date_fin" class="label-premium">Date de Fin <span class="text-danger">*</span></label>
                            <div class="input-group-premium">
                                <i class="fas fa-calendar-check input-icon-left"></i>
                                <input type="date" name="date_fin" id="date_fin" 
                                       class="form-control-premium <?= isset($errors['date_fin']) ? 'is-invalid' : '' ?>"
                                       value="<?= isset($_POST['date_fin']) ? $_POST['date_fin'] : '' ?>" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-grid gap-3">
                    <button type="submit" class="btn-forge-primary">
                        <i class="fas fa-plus-circle me-2"></i> CRÉER LA MISSION
                    </button>
                    <a href="index.php?action=admin_missions" class="btn-forge-outline text-center text-decoration-none">
                        <i class="fas fa-times me-2"></i> Annuler
                    </a>
                </div>

                <!-- Demand Forecast Widget -->
                <div class="forge-card forecast-card mt-4" id="forecastCard">
                    <div class="card-header-premium">
                        <i class="fas fa-chart-line"></i>
                        <h5 class="form-section-title">Demande Prévue</h5>
                    </div>
                    <div class="card-body p-4" id="forecastBody">
                        <div class="forecast-placeholder" id="forecastPlaceholder">
                            <i class="fas fa-magic mb-2" style="font-size:1.8rem;color:#10b981;opacity:0.5;"></i>
                            <p class="mb-0">Remplissez la catégorie et le niveau, puis lancez la prédiction.</p>
                        </div>
                        <div id="forecastResult" style="display:none;">
                            <div class="text-center">
                                <span class="forecast-number" id="forecastCount">--</span>
                                <span class="forecast-label">candidatures estimées</span>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <span class="confidence-badge" id="forecastConfidence"></span>
                            </div>
                            <div class="forecast-insight" id="forecastInsight" style="display:none;"></div>
                        </div>
                        <button type="button" class="btn-forecast mt-3" id="forecastBtn">
                            <div class="ai-loading-spinner" id="forecastSpinner"></div>
                            <i class="fas fa-chart-bar" id="forecastIcon"></i>
                            Prédire la demande
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('missionForm');
    const description = document.getElementById('description');
    const counter = document.getElementById('description-counter');
    const saveBtn = document.getElementById('saveDraftBtn');
    const clearBtn = document.getElementById('clearFormBtn');
    const status = document.getElementById('autoSaveStatus');
    const aiBtn = document.getElementById('aiClassifyBtn');
    const spinner = aiBtn.querySelector('.ai-loading-spinner');
    const aiIcon = aiBtn.querySelector('.fa-magic');
    const categorieSelect = document.getElementById('categorie');
    const niveauSelect = document.getElementById('niveau');
    const competencesInput = document.getElementById('competences');

    // Char counter
    description.addEventListener('input', () => {
        const len = description.value.length;
        counter.textContent = `${len} / 2000`;
        counter.style.color = len > 1800 ? '#ff6b6b' : '#64748b';
    });

    // Save draft
    saveBtn.addEventListener('click', () => {
        const data = {};
        new FormData(form).forEach((value, key) => data[key] = value);
        localStorage.setItem('mission_draft', JSON.stringify(data));
        showStatus('Brouillon sauvegardé !');
    });

    // Clear form
    clearBtn.addEventListener('click', () => {
        if(confirm('Réinitialiser le formulaire ?')) {
            form.reset();
            localStorage.removeItem('mission_draft');
            counter.textContent = '0 / 2000';
        }
    });

    // Load draft
    const draft = localStorage.getItem('mission_draft');
    if(draft) {
        const data = JSON.parse(draft);
        Object.keys(data).forEach(key => {
            const el = form.querySelector(`[name="${key}"]`);
            if(el) el.value = data[key];
        });
        description.dispatchEvent(new Event('input'));
    }

    // Auto-save logic
    let timer;
    form.addEventListener('input', () => {
        clearTimeout(timer);
        timer = setTimeout(() => {
            const data = {};
            new FormData(form).forEach((value, key) => data[key] = value);
            localStorage.setItem('mission_draft', JSON.stringify(data));
            showStatus('Auto-sauvegarde effectuée');
        }, 2000);
    });

    function showStatus(msg) {
        status.querySelector('#autoSaveMessage').textContent = msg;
        status.classList.remove('d-none');
        setTimeout(() => status.classList.add('d-none'), 3000);
    }

    // Validation styling
    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            form.querySelectorAll(':invalid').forEach(el => el.classList.add('is-invalid'));
            const firstErr = form.querySelector(':invalid');
            if(firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            localStorage.removeItem('mission_draft');
        }
    });

    // Clear invalid class on change
    form.querySelectorAll('input, textarea, select').forEach(el => {
        el.addEventListener('input', () => el.classList.remove('is-invalid'));
    });

    // AI Classification logic
    aiBtn.addEventListener('click', async () => {
        const titre = document.getElementById('titre').value;
        const desc = description.value;

        if (!titre || !desc) {
            alert('Veuillez remplir le titre et la description avant d\'utiliser l\'IA.');
            return;
        }

        // UI State: Loading
        aiBtn.disabled = true;
        spinner.style.display = 'block';
        aiIcon.style.display = 'none';

        try {
            const formData = new FormData();
            formData.append('titre', titre);
            formData.append('description', desc);

            const response = await fetch('index.php?action=ai_classify', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.error) {
                alert('Erreur IA: ' + (result.details?.error?.message || result.error));
            } else {
                if (result.categorie) categorieSelect.value = result.categorie;
                if (result.niveau) niveauSelect.value = result.niveau;
                if (result.competences) competencesInput.value = result.competences;
                showStatus('Classification IA appliquée ! ✨');
                
                // Add a subtle pulse effect to the updated fields
                [categorieSelect, niveauSelect, competencesInput].forEach(el => {
                    if(!el) return;
                    el.style.borderColor = '#a855f7';
                    el.style.boxShadow = '0 0 15px rgba(168, 85, 247, 0.4)';
                    setTimeout(() => {
                        el.style.borderColor = '';
                        el.style.boxShadow = '';
                    }, 2000);
                });
            }
        } catch (err) {
            console.error(err);
            alert('Erreur lors de l\'analyse IA.');
        } finally {
            aiBtn.disabled = false;
            spinner.style.display = 'none';
            aiIcon.style.display = 'block';
        }
    });

    // ===== Demand Forecast Logic =====
    const forecastBtn      = document.getElementById('forecastBtn');
    const forecastSpinner  = document.getElementById('forecastSpinner');
    const forecastIcon     = document.getElementById('forecastIcon');
    const forecastResult   = document.getElementById('forecastResult');
    const forecastPlaceholder = document.getElementById('forecastPlaceholder');
    const forecastCount    = document.getElementById('forecastCount');
    const forecastConfBadge = document.getElementById('forecastConfidence');
    const forecastInsight  = document.getElementById('forecastInsight');

    forecastBtn.addEventListener('click', async () => {
        const categorie   = categorieSelect.value;
        const niveau      = niveauSelect.value;
        const budget      = document.getElementById('budget').value;
        const competences = competencesInput.value;

        if (!categorie) {
            alert('Veuillez sélectionner une catégorie avant de lancer la prédiction.');
            return;
        }

        // Loading state
        forecastBtn.disabled = true;
        forecastSpinner.style.display = 'block';
        forecastIcon.style.display = 'none';

        try {
            const fd = new FormData();
            fd.append('categorie',   categorie);
            fd.append('niveau',      niveau);
            fd.append('budget',      budget || '0');
            fd.append('competences', competences);

            const res    = await fetch('index.php?action=ai_forecast', { method: 'POST', body: fd });
            const result = await res.json();

            if (result.error) {
                alert('Erreur prédiction : ' + result.error);
                return;
            }

            // Animate number
            animateCounter(forecastCount, 0, result.predicted_count, 700);

            // Confidence badge
            const confMap = {
                high:   { cls: 'confidence-high',   icon: 'fa-circle-check',    label: 'Confiance élevée' },
                medium: { cls: 'confidence-medium',  icon: 'fa-circle-half-stroke', label: 'Confiance moyenne' },
                low:    { cls: 'confidence-low',     icon: 'fa-circle-exclamation', label: 'Confiance faible' }
            };
            const conf = confMap[result.confidence] || confMap.medium;
            forecastConfBadge.className = `confidence-badge ${conf.cls}`;
            forecastConfBadge.innerHTML = `<i class="fas ${conf.icon}"></i> ${conf.label}`;

            // Insight
            if (result.insight) {
                forecastInsight.textContent = result.insight;
                forecastInsight.style.display = 'block';
            } else {
                forecastInsight.style.display = 'none';
            }

            forecastPlaceholder.style.display = 'none';
            forecastResult.style.display = 'block';
            showStatus('Prédiction de demande calculée ! 📈');

        } catch (err) {
            console.error(err);
            alert('Erreur lors de la prédiction.');
        } finally {
            forecastBtn.disabled = false;
            forecastSpinner.style.display = 'none';
            forecastIcon.style.display = 'block';
        }
    });

    function animateCounter(el, from, to, duration) {
        const start = performance.now();
        function update(now) {
            const elapsed = now - start;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3); // ease-out cubic
            el.textContent = Math.round(from + (to - from) * eased);
            if (progress < 1) requestAnimationFrame(update);
        }
        requestAnimationFrame(update);
    }
});
</script>

<?php

require_once __DIR__ . '/../layout/dashboard_footer.php';
?>
