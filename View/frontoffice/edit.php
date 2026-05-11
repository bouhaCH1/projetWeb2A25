<?php
$pageTitle = 'edit';
require_once __DIR__ . '/../layout/pl_dashboard_header.php';
?>

<!-- Hero Section -->
<section class="hero" style="min-height: 40vh; padding: 80px 0 40px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 style="font-size: 42px; font-weight: 700; margin-bottom: 15px; background: linear-gradient(135deg, #00ffcc, #00ccff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    Modifier la mission #<?= (int)$missionData['id'] ?>
                </h1>
                <p style="color: rgba(255,255,255,0.7); font-size: 16px; margin-bottom: 20px;">
                    Mettez à jour les informations de votre mission
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
                    <form id="missionForm" method="POST" action="/workwave/Controller/index.php?action=front_edit&id=<?= (int)$missionData['id'] ?>" novalidate>
                        <div class="mb-4">
                            <label>Titre <span style="color: #ff6b6b;">*</span></label>
                            <input type="text" name="titre" id="titre" class="<?= isset($errors['titre']) ? 'is-invalid' : '' ?>"
                                   value="<?= isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : htmlspecialchars($missionData['titre']) ?>">
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
                                      class="<?= isset($errors['description']) ? 'is-invalid' : '' ?>"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : htmlspecialchars($missionData['description']) ?></textarea>
                            <div class="invalid-feedback"><?= isset($errors['description']) ? $errors['description'] : '' ?></div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label>Budget (EUR) <span style="color: #ff6b6b;">*</span></label>
                                <input type="number" name="budget" id="budget" class="<?= isset($errors['budget']) ? 'is-invalid' : '' ?>"
                                       value="<?= isset($_POST['budget']) ? htmlspecialchars($_POST['budget']) : htmlspecialchars($missionData['budget']) ?>">
                                <div class="invalid-feedback"><?= isset($errors['budget']) ? $errors['budget'] : '' ?></div>
                            </div>
                            <div class="col-md-6">
                                <label>Statut <span style="color: #ff6b6b;">*</span></label>
                                <?php $currentStatut = isset($_POST['statut']) ? $_POST['statut'] : $missionData['statut']; ?>
                                <select name="statut" id="statut" class="<?= isset($errors['statut']) ? 'is-invalid' : '' ?>">
                                    <option value="">-- Choisir --</option>
                                    <option value="ouverte" <?= ($currentStatut === 'ouverte') ? 'selected' : '' ?>>Ouverte</option>
                                    <option value="en_cours" <?= ($currentStatut === 'en_cours') ? 'selected' : '' ?>>En cours</option>
                                    <option value="terminee" <?= ($currentStatut === 'terminee') ? 'selected' : '' ?>>Terminée</option>
                                </select>
                                <div class="invalid-feedback"><?= isset($errors['statut']) ? $errors['statut'] : '' ?></div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label>Date début <span style="color: #ff6b6b;">*</span></label>
                                <input type="date" name="date_debut" id="date_debut" class="<?= isset($errors['date_debut']) ? 'is-invalid' : '' ?>"
                                       value="<?= isset($_POST['date_debut']) ? $_POST['date_debut'] : $missionData['date_debut'] ?>">
                                <div class="invalid-feedback"><?= isset($errors['date_debut']) ? $errors['date_debut'] : '' ?></div>
                            </div>
                            <div class="col-md-6">
                                <label>Date fin <span style="color: #ff6b6b;">*</span></label>
                                <input type="date" name="date_fin" id="date_fin" class="<?= isset($errors['date_fin']) ? 'is-invalid' : '' ?>"
                                       value="<?= isset($_POST['date_fin']) ? $_POST['date_fin'] : $missionData['date_fin'] ?>">
                                <div class="invalid-feedback"><?= isset($errors['date_fin']) ? $errors['date_fin'] : '' ?></div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label>Compétences <span style="color: #ff6b6b;">*</span></label>
                            <input type="text" name="competences" id="competences" class="<?= isset($errors['competences']) ? 'is-invalid' : '' ?>"
                                   value="<?= isset($_POST['competences']) ? htmlspecialchars($_POST['competences']) : htmlspecialchars($missionData['competences']) ?>">
                            <div class="invalid-feedback"><?= isset($errors['competences']) ? $errors['competences'] : '' ?></div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label>Catégorie <span style="color: rgba(255,255,255,0.5);">(optionnel)</span></label>
                                <?php $currentCategorie = isset($_POST['categorie']) ? $_POST['categorie'] : ($missionData['categorie'] ?? ''); ?>
                                <select name="categorie" id="categorie">
                                    <option value="">-- Choisir --</option>
                                    <option value="developpement" <?= ($currentCategorie === 'developpement') ? 'selected' : '' ?>>Développement Web</option>
                                    <option value="mobile" <?= ($currentCategorie === 'mobile') ? 'selected' : '' ?>>Applications Mobiles</option>
                                    <option value="design" <?= ($currentCategorie === 'design') ? 'selected' : '' ?>>Design & UX</option>
                                    <option value="marketing" <?= ($currentCategorie === 'marketing') ? 'selected' : '' ?>>Marketing Digital</option>
                                    <option value="data" <?= ($currentCategorie === 'data') ? 'selected' : '' ?>>Data & Analytics</option>
                                    <option value="autre" <?= ($currentCategorie === 'autre') ? 'selected' : '' ?>>Autre</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Niveau <span style="color: rgba(255,255,255,0.5);">(optionnel)</span></label>
                                <?php $currentNiveau = isset($_POST['niveau']) ? $_POST['niveau'] : ($missionData['niveau'] ?? ''); ?>
                                <select name="niveau" id="niveau">
                                    <option value="">-- Choisir --</option>
                                    <option value="debutant" <?= ($currentNiveau === 'debutant') ? 'selected' : '' ?>>Débutant</option>
                                    <option value="intermediaire" <?= ($currentNiveau === 'intermediaire') ? 'selected' : '' ?>>Intermédiaire</option>
                                    <option value="avance" <?= ($currentNiveau === 'avance') ? 'selected' : '' ?>>Avancé</option>
                                    <option value="expert" <?= ($currentNiveau === 'expert') ? 'selected' : '' ?>>Expert</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex gap-3 justify-content-end">
                            <a href="/workwave/Controller/index.php?action=front_missions" class="cyber-btn" style="background: transparent; border: 1px solid #00ffcc; color: #00ffcc;">
                                <i class="fa fa-times"></i> Annuler
                            </a>
                            <button type="submit" class="cyber-btn">
                                <i class="fa fa-save"></i> Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes spin { to { transform: rotate(360deg); } }
#aiClassifyBtn:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(168, 85, 247, 0.4); }
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
});
</script>

<?php
require_once __DIR__ . '/../layout/pl_dashboard_footer.php';
?>
