<?php
$pageTitle = 'create';
require_once __DIR__ . '/../layout/pl_dashboard_header.php';
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
                    <form id="missionForm" method="POST" action="/workwave/Controller/index.php?action=front_create" novalidate>
                        <div class="mb-4">
                            <label>Titre <span style="color: #ff6b6b;">*</span></label>
                            <input type="text" name="titre" id="titre" class="<?= isset($errors['titre']) ? 'is-invalid' : '' ?>"
                                   placeholder="Ex: Développement site e-commerce"
                                   value="<?= isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : '' ?>">
                            <div class="invalid-feedback"><?= isset($errors['titre']) ? $errors['titre'] : '' ?></div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <label>Description <span style="color: #ff6b6b;">*</span></label>
                                <button type="button" id="aiClassifyBtn" style="background: linear-gradient(135deg, #6366f1, #a855f7); color: white; border: none; padding: 6px 16px; border-radius: 10px; font-weight: 700; font-size: 0.8rem; display: flex; align-items: center; gap: 6px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(168, 85, 247, 0.3);">
                                    <span class="ai-spinner" style="display:none; width:14px; height:14px; border:2px solid rgba(255,255,255,0.3); border-radius:50%; border-top-color:white; animation: spin 0.8s linear infinite;"></span>
                                    <i class="fas fa-magic"></i> Analyser avec l'IA
                                </button>
                            </div>
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
                            <a href="/workwave/Controller/index.php?action=missions" class="cyber-btn" style="background: transparent; border: 1px solid #00ffcc; color: #00ffcc;">
                                <i class="fa fa-times"></i> Annuler
                            </a>
                            <button type="submit" class="cyber-btn">
                                <i class="fa fa-save"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>

                <!-- ===== Demand Forecast Widget ===== -->
                <div class="cyber-form-card" id="forecastWidget" style="margin-top: 24px; border: 1px solid rgba(0,255,204,0.2); background: linear-gradient(135deg, rgba(0,255,204,0.04), rgba(0,204,255,0.02));">
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:18px;">
                        <div style="width:40px; height:40px; border-radius:12px; background:linear-gradient(135deg,#10b981,#06b6d4); display:flex; align-items:center; justify-content:center;">
                            <i class="fas fa-chart-line" style="color:#fff; font-size:1rem;"></i>
                        </div>
                        <div>
                            <h5 style="margin:0; color:#fff; font-weight:800; font-size:1rem;">Prédiction de Demande IA</h5>
                            <small style="color:rgba(255,255,255,0.4); font-size:0.75rem;">Estimez le nombre de candidatures attendues</small>
                        </div>
                    </div>

                    <!-- Placeholder before prediction -->
                    <div id="fcPlaceholder" style="text-align:center; padding:16px 0; color:rgba(255,255,255,0.3);">
                        <i class="fas fa-magic" style="font-size:2rem; color:#10b981; opacity:0.4; display:block; margin-bottom:8px;"></i>
                        Sélectionnez une catégorie et un niveau, puis lancez la prédiction.
                    </div>

                    <!-- Result (hidden until predicted) -->
                    <div id="fcResult" style="display:none; text-align:center; margin-bottom:16px;">
                        <span id="fcNumber" style="font-size:4rem; font-weight:900; background:linear-gradient(135deg,#10b981,#06b6d4); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; line-height:1; display:block;">--</span>
                        <span style="font-size:0.7rem; text-transform:uppercase; letter-spacing:2px; color:rgba(255,255,255,0.4); font-weight:700;">candidatures estimées / 30 jours</span>
                        <div style="margin-top:12px;">
                            <span id="fcBadge" style="display:inline-flex; align-items:center; gap:5px; padding:4px 14px; border-radius:20px; font-size:0.72rem; font-weight:700; letter-spacing:1px;"></span>
                        </div>
                        <div id="fcInsight" style="display:none; margin-top:14px; background:rgba(0,0,0,0.25); border-left:3px solid #10b981; border-radius:10px; padding:10px 14px; font-size:0.78rem; color:rgba(255,255,255,0.55); line-height:1.5; text-align:left;"></div>
                    </div>

                    <!-- Predict button -->
                    <button type="button" id="fcBtn" style="width:100%; background:linear-gradient(135deg,#10b981,#0891b2); border:none; color:#fff; padding:11px 20px; border-radius:12px; font-weight:700; font-size:0.9rem; display:flex; align-items:center; justify-content:center; gap:8px; cursor:pointer; transition:all 0.3s ease; box-shadow:0 4px 15px rgba(16,185,129,0.25);">
                        <span id="fcSpinner" style="display:none; width:15px; height:15px; border:2px solid rgba(255,255,255,0.3); border-radius:50%; border-top-color:#fff; animation:spin 0.8s linear infinite;"></span>
                        <i id="fcIcon" class="fas fa-chart-bar"></i>
                        Prédire la demande
                    </button>
                </div>

            </div>
        </div>
    </div>
</section>

<style>
@keyframes spin { to { transform: rotate(360deg); } }
#aiClassifyBtn:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(168, 85, 247, 0.4); }
#fcBtn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(16,185,129,0.4); }
.fc-high   { background: rgba(16,185,129,0.15); color:#10b981; border:1px solid rgba(16,185,129,0.35); }
.fc-medium { background: rgba(245,158,11,0.15);  color:#f59e0b; border:1px solid rgba(245,158,11,0.35); }
.fc-low    { background: rgba(239,68,68,0.15);   color:#ef4444; border:1px solid rgba(239,68,68,0.35); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const aiBtn = document.getElementById('aiClassifyBtn');
    const spinner = aiBtn.querySelector('.ai-spinner');
    const aiIcon = aiBtn.querySelector('.fa-magic');
    const categorieSelect = document.getElementById('categorie');
    const niveauSelect = document.getElementById('niveau');
    const competencesInput = document.getElementById('competences');

    aiBtn.addEventListener('click', async () => {
        const titre = document.getElementById('titre').value;
        const desc = document.getElementById('description').value;

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

            const response = await fetch('/workwave/Controller/index.php?action=ai_classify', {
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
                [categorieSelect, niveauSelect, competencesInput].forEach(el => {
                    if(!el) return;
                    el.style.borderColor = '#a855f7';
                    el.style.boxShadow = '0 0 12px rgba(168, 85, 247, 0.4)';
                    setTimeout(() => { el.style.borderColor = ''; el.style.boxShadow = ''; }, 2000);
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

    // ===== Demand Forecast =====
    const fcBtn       = document.getElementById('fcBtn');
    const fcSpinner   = document.getElementById('fcSpinner');
    const fcIcon      = document.getElementById('fcIcon');
    const fcResult    = document.getElementById('fcResult');
    const fcPlaceholder = document.getElementById('fcPlaceholder');
    const fcNumber    = document.getElementById('fcNumber');
    const fcBadge     = document.getElementById('fcBadge');
    const fcInsight   = document.getElementById('fcInsight');

    fcBtn.addEventListener('click', async () => {
        const categorie   = categorieSelect.value;
        const niveau      = niveauSelect.value;
        const budget      = document.getElementById('budget').value;
        const competences = competencesInput.value;

        if (!categorie) {
            alert('Veuillez sélectionner une catégorie avant de lancer la prédiction.');
            return;
        }

        fcBtn.disabled = true;
        fcSpinner.style.display = 'block';
        fcIcon.style.display = 'none';

        try {
            const fd = new FormData();
            fd.append('categorie',   categorie);
            fd.append('niveau',      niveau);
            fd.append('budget',      budget || '0');
            fd.append('competences', competences);

            const res    = await fetch('/workwave/Controller/index.php?action=ai_forecast', { method: 'POST', body: fd });
            const result = await res.json();

            if (result.error) {
                alert('Erreur prédiction : ' + result.error);
                return;
            }

            // Animate counter
            animateCounter(fcNumber, 0, result.predicted_count, 750);

            // Confidence badge
            const confMap = {
                high:   { cls: 'fc-high',   icon: 'fa-circle-check',       label: 'Confiance élevée' },
                medium: { cls: 'fc-medium', icon: 'fa-circle-half-stroke',  label: 'Confiance moyenne' },
                low:    { cls: 'fc-low',    icon: 'fa-circle-exclamation',  label: 'Confiance faible' }
            };
            const conf = confMap[result.confidence] || confMap.medium;
            fcBadge.className = conf.cls;
            fcBadge.style.cssText = '';
            fcBadge.innerHTML = `<i class="fas ${conf.icon}"></i> ${conf.label}`;

            // Insight
            if (result.insight) {
                fcInsight.textContent = result.insight;
                fcInsight.style.display = 'block';
            } else {
                fcInsight.style.display = 'none';
            }

            fcPlaceholder.style.display = 'none';
            fcResult.style.display = 'block';

        } catch (err) {
            console.error(err);
            alert('Erreur lors de la prédiction.');
        } finally {
            fcBtn.disabled = false;
            fcSpinner.style.display = 'none';
            fcIcon.style.display = 'block';
        }
    });

    function animateCounter(el, from, to, duration) {
        const start = performance.now();
        (function update(now) {
            const p = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(from + (to - from) * eased);
            if (p < 1) requestAnimationFrame(update);
        })(start);
    }
});
</script>

<?php
require_once __DIR__ . '/../layout/pl_dashboard_footer.php';
?>
