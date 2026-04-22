<?php
$activePage = 'list';
$pageTitle  = 'Modifier la Mission';
$pageIcon   = 'edit';

ob_start();
?>
<style>
    .premium-card {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        border-radius: 15px;
        border: 1px solid rgba(212, 175, 55, 0.3);
        box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        overflow: hidden;
    }
    .premium-card-header {
        background: linear-gradient(135deg, #d4af37 0%, #f4d03f 100%);
        padding: 25px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .premium-card-header h4 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 22px;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
    }
    .premium-form label {
        color: #d4af37;
        font-family: 'Libre Franklin', sans-serif;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 8px;
        display: block;
    }
    .premium-form label span.required {
        color: #dc3545;
    }
    .premium-form input, .premium-form textarea, .premium-form select {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(212, 175, 55, 0.3);
        border-radius: 10px;
        padding: 12px 15px;
        color: #fff;
        width: 100%;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    .premium-form input:focus, .premium-form textarea:focus, .premium-form select:focus {
        border-color: #d4af37;
        outline: none;
        background: rgba(255, 255, 255, 0.08);
    }
    .premium-form input::placeholder, .premium-form textarea::placeholder {
        color: #666;
    }
    .premium-btn {
        background: linear-gradient(135deg, #d4af37 0%, #f4d03f 100%);
        color: #1a1a2e;
        padding: 12px 30px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .premium-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(212, 175, 55, 0.4);
    }
    .premium-btn-outline {
        background: transparent;
        color: #d4af37;
        border: 2px solid #d4af37;
    }
    .premium-btn-outline:hover {
        background: #d4af37;
        color: #1a1a2e;
    }
    .invalid-feedback {
        color: #dc3545;
        font-size: 13px;
        margin-top: 5px;
    }
</style>

<div class="premium-card">
    <div class="premium-card-header">
        <h4><i class="fas fa-edit"></i> Modifier la Mission #<?= $missionData['id'] ?></h4>
    </div>
    <div class="card-body p-4 premium-form">
        <form id="missionForm" method="POST" action="index.php?action=edit&id=<?= $missionData['id'] ?>" novalidate>

            <div class="row mb-3">
                <div class="col-md-8">
                    <label>Titre <span class="required">*</span></label>
                    <input type="text" name="titre" id="titre" class="form-control <?= isset($errors['titre']) ? 'is-invalid' : '' ?>"
                           value="<?= isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : htmlspecialchars($missionData['titre']) ?>"
                           onkeypress="return /^[a-zA-Z\séèêëàâäùûüôöîïç]+$/.test(String.fromCharCode(event.which))">
                    <div class="invalid-feedback" id="err-titre">
                        <?= isset($errors['titre']) ? $errors['titre'] : '' ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <label>Budget (€) <span class="required">*</span></label>
                    <input type="text" name="budget" id="budget" class="form-control <?= isset($errors['budget']) ? 'is-invalid' : '' ?>"
                           value="<?= isset($_POST['budget']) ? htmlspecialchars($_POST['budget']) : $missionData['budget'] ?>">
                    <div class="invalid-feedback" id="err-budget">
                        <?= isset($errors['budget']) ? $errors['budget'] : '' ?>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label>Description <span class="required">*</span></label>
                <textarea name="description" id="description" rows="4"
                          class="form-control <?= isset($errors['description']) ? 'is-invalid' : '' ?>"
                          onkeypress="return /^[a-zA-Z\séèêëàâäùûüôöîïç,.!?;:'"()-]+$/.test(String.fromCharCode(event.which))"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : htmlspecialchars($missionData['description']) ?></textarea>
                <div class="invalid-feedback" id="err-description">
                    <?= isset($errors['description']) ? $errors['description'] : '' ?>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <label>Date de début <span class="required">*</span></label>
                    <input type="date" name="date_debut" id="date_debut"
                           class="form-control <?= isset($errors['date_debut']) ? 'is-invalid' : '' ?>"
                           value="<?= isset($_POST['date_debut']) ? $_POST['date_debut'] : $missionData['date_debut'] ?>">
                    <div class="invalid-feedback" id="err-date_debut">
                        <?= isset($errors['date_debut']) ? $errors['date_debut'] : '' ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <label>Date de fin <span class="required">*</span></label>
                    <input type="date" name="date_fin" id="date_fin"
                           class="form-control <?= isset($errors['date_fin']) ? 'is-invalid' : '' ?>"
                           value="<?= isset($_POST['date_fin']) ? $_POST['date_fin'] : $missionData['date_fin'] ?>">
                    <div class="invalid-feedback" id="err-date_fin">
                        <?= isset($errors['date_fin']) ? $errors['date_fin'] : '' ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <label>Statut <span class="required">*</span></label>
                    <select name="statut" id="statut" class="form-select <?= isset($errors['statut']) ? 'is-invalid' : '' ?>">
                        <option value="">-- Choisir --</option>
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
                    <div class="invalid-feedback" id="err-statut">
                        <?= isset($errors['statut']) ? $errors['statut'] : '' ?>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label>Compétences requises <span class="required">*</span></label>
                <input type="text" name="competences" id="competences"
                       class="form-control <?= isset($errors['competences']) ? 'is-invalid' : '' ?>"
                       value="<?= isset($_POST['competences']) ? htmlspecialchars($_POST['competences']) : htmlspecialchars($missionData['competences']) ?>">
                <div class="invalid-feedback" id="err-competences">
                    <?= isset($errors['competences']) ? $errors['competences'] : '' ?>
                </div>
            </div>

            <div class="d-flex gap-3" style="margin-top: 30px;">
                <button type="submit" class="premium-btn">
                    <i class="fas fa-save"></i> Mettre à jour
                </button>
                <a href="index.php?action=index" class="premium-btn premium-btn-outline">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<?php
$extraJs = '<script src="../View/public/assets/js/validation.php"></script>';
$content = ob_get_clean();
require_once 'layout.php';
?>