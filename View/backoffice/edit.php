<?php
$pageTitle = 'edit';
require_once __DIR__ . '/../layout/dashboard_header.php';
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

    .btn-ai-magic {
        background: linear-gradient(135deg, #6366f1, #a855f7);
        color: white;
        border: none;
        padding: 6px 14px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(168, 85, 247, 0.2);
    }

    .btn-ai-magic:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(168, 85, 247, 0.3);
        color: white;
    }

    .btn-ai-magic:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .ai-loading-spinner {
        display: none;
        width: 14px;
        height: 14px;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>

<div class="creation-container">
    <!-- Header -->
    <header class="d-flex align-items-center justify-content-between mb-5 animate-up">
        <div>
            <h1 class="h3 text-white fw-800 mb-1">
                <span class="badge-premium me-2">ÉDITION</span>
                Modifier la Mission #<?= htmlspecialchars($missionData['id']) ?>
            </h1>
            <p class="text-muted mb-0">Mettez à jour les informations pour attirer les meilleurs profils.</p>
        </div>
        <div class="d-flex gap-3">
            <a href="index.php?action=admin_missions" class="btn-forge-outline btn-sm text-decoration-none">
                <i class="fas fa-chevron-left me-2"></i> Annuler
            </a>
        </div>
    </header>

    <form id="missionForm" method="POST" action="index.php?action=admin_mission_edit&id=<?= $missionData['id'] ?>" novalidate class="needs-validation">
        
        <div class="row">
            <!-- Left Column: Main Info -->
            <div class="col-lg-8">
                <div class="forge-card animate-up stagger-1">
                    <div class="card-header-premium">
                        <i class="fas fa-edit"></i>
                        <h5 class="form-section-title">Informations Générales</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group-custom">
                            <label for="titre" class="label-premium">Titre de la mission <span class="text-danger">*</span></label>
                            <input type="text" name="titre" id="titre" 
                                   class="form-control form-control-premium <?= isset($errors['titre']) ? 'is-invalid' : '' ?>"
                                   value="<?= isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : htmlspecialchars($missionData['titre']) ?>"
                                   placeholder="Ex: Développement d'un site Web Next.js" required>
                            <div class="invalid-feedback"><?= $errors['titre'] ?? 'Le titre est requis' ?></div>
                        </div>

                        <div class="form-group-custom">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label for="description" class="label-premium mb-0">Description détaillée <span class="text-danger">*</span></label>
                                <button type="button" id="aiClassifyBtn" class="btn-ai-magic">
                                    <div class="ai-loading-spinner"></div>
                                    <i class="fas fa-magic"></i> IA Suggestion
                                </button>
                            </div>
                            <textarea name="description" id="description" rows="8"
                                      class="form-control form-control-premium <?= isset($errors['description']) ? 'is-invalid' : '' ?>"
                                      placeholder="Expliquez les objectifs, le contexte et les livrables attendus..." 
                                      required maxlength="2000"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : htmlspecialchars($missionData['description']) ?></textarea>
                            <div class="d-flex justify-content-between mt-2">
                                <small class="text-muted"><i class="fas fa-info-circle me-1"></i> Mettez à jour les détails si nécessaire</small>
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
                                       value="<?= isset($_POST['competences']) ? htmlspecialchars($_POST['competences']) : htmlspecialchars($missionData['competences']) ?>">
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
                                        <option value="developpement" <?= (isset($_POST['categorie']) && $_POST['categorie']=='developpement') || (isset($missionData['categorie']) && $missionData['categorie']=='developpement') ? 'selected' : '' ?>>Développement Web</option>
                                        <option value="mobile" <?= (isset($_POST['categorie']) && $_POST['categorie']=='mobile') || (isset($missionData['categorie']) && $missionData['categorie']=='mobile') ? 'selected' : '' ?>>Applications Mobiles</option>
                                        <option value="design" <?= (isset($_POST['categorie']) && $_POST['categorie']=='design') || (isset($missionData['categorie']) && $missionData['categorie']=='design') ? 'selected' : '' ?>>Design & UX</option>
                                        <option value="marketing" <?= (isset($_POST['categorie']) && $_POST['categorie']=='marketing') || (isset($missionData['categorie']) && $missionData['categorie']=='marketing') ? 'selected' : '' ?>>Marketing Digital</option>
                                        <option value="data" <?= (isset($_POST['categorie']) && $_POST['categorie']=='data') || (isset($missionData['categorie']) && $missionData['categorie']=='data') ? 'selected' : '' ?>>Data & Analytics</option>
                                        <option value="autre" <?= (isset($_POST['categorie']) && $_POST['categorie']=='autre') || (isset($missionData['categorie']) && $missionData['categorie']=='autre') ? 'selected' : '' ?>>Autre</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label for="niveau" class="label-premium">Niveau requis</label>
                                    <select name="niveau" id="niveau" class="form-control form-control-premium">
                                        <option value="">-- Indifférent --</option>
                                        <option value="debutant" <?= (isset($_POST['niveau']) && $_POST['niveau']=='debutant') || (isset($missionData['niveau']) && $missionData['niveau']=='debutant') ? 'selected' : '' ?>>Junior / Débutant</option>
                                        <option value="intermediaire" <?= (isset($_POST['niveau']) && $_POST['niveau']=='intermediaire') || (isset($missionData['niveau']) && $missionData['niveau']=='intermediaire') ? 'selected' : '' ?>>Intermédiaire</option>
                                        <option value="avance" <?= (isset($_POST['niveau']) && $_POST['niveau']=='avance') || (isset($missionData['niveau']) && $missionData['niveau']=='avance') ? 'selected' : '' ?>>Senior / Avancé</option>
                                        <option value="expert" <?= (isset($_POST['niveau']) && $_POST['niveau']=='expert') || (isset($missionData['niveau']) && $missionData['niveau']=='expert') ? 'selected' : '' ?>>Expert / Consultant</option>
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
                                       value="<?= isset($_POST['budget']) ? htmlspecialchars($_POST['budget']) : $missionData['budget'] ?>"
                                       placeholder="0.00" min="1" required>
                            </div>
                            <div class="invalid-feedback"><?= $errors['budget'] ?? 'Budget invalide' ?></div>
                        </div>

                        <div class="form-group-custom">
                            <label for="statut" class="label-premium">Visibilité de la mission <span class="text-danger">*</span></label>
                            <select name="statut" id="statut" class="form-control form-control-premium" required>
                                <?php
                                $statuts = ['ouverte' => 'Publique (Ouverte)', 'en_cours' => 'Privée (En cours)', 'terminee' => 'Archivée (Terminée)'];
                                $currentStatut = isset($_POST['statut']) ? $_POST['statut'] : $missionData['statut'];
                                foreach ($statuts as $val => $label):
                                ?>
                                <option value="<?= $val ?>" <?= $currentStatut == $val ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                                <?php endforeach; ?>
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
                                   value="<?= isset($_POST['date_debut']) ? $_POST['date_debut'] : $missionData['date_debut'] ?>" required>
                        </div>

                        <div class="form-group-custom">
                            <label for="date_fin" class="label-premium">Échéance prévue <span class="text-danger">*</span></label>
                            <input type="date" name="date_fin" id="date_fin" 
                                   class="form-control form-control-premium <?= isset($errors['date_fin']) ? 'is-invalid' : '' ?>"
                                   value="<?= isset($_POST['date_fin']) ? $_POST['date_fin'] : $missionData['date_fin'] ?>" required>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-3 animate-up stagger-3">
                    <button type="submit" class="btn-forge-primary w-100 py-3">
                        <i class="fas fa-save me-2"></i> ENREGISTRER LES MODIFICATIONS
                    </button>
                    <a href="index.php?action=admin_missions" class="btn-forge-outline w-100 py-3 text-center text-decoration-none border-danger-subtle text-danger">
                        <i class="fas fa-times me-2"></i> Annuler les changements
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<?php

?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const description = document.getElementById('description');
    const counter = document.getElementById('description-counter');
    const aiBtn = document.getElementById('aiClassifyBtn');
    const spinner = aiBtn.querySelector('.ai-loading-spinner');
    const aiIcon = aiBtn.querySelector('.fa-magic');
    const categorieSelect = document.getElementById('categorie');
    const niveauSelect = document.getElementById('niveau');
    const competencesInput = document.getElementById('competences');

    // Char counter
    const updateCounter = () => {
        const len = description.value.length;
        counter.textContent = `${len} / 2000`;
        counter.style.color = len > 1800 ? '#e63946' : '#4b5563';
    };
    description.addEventListener('input', updateCounter);
    updateCounter();

    // AI Classification logic
    aiBtn.addEventListener('click', async () => {
        const titre = document.getElementById('titre').value;
        const desc = description.value;

        if (!titre || !desc) {
            alert('Veuillez remplir le titre et la description avant d\'utiliser l\'IA.');
            return;
        }

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
                
                // Visual feedback
                [categorieSelect, niveauSelect, competencesInput].forEach(el => {
                    if(!el) return;
                    el.style.borderColor = '#a855f7';
                    el.style.boxShadow = '0 0 12px rgba(168, 85, 247, 0.3)';
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
});
</script>

<?php
require_once __DIR__ . '/../layout/dashboard_footer.php';
?>