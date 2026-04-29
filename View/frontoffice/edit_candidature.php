<?php
ob_start();
?>

<!-- ===== Page Banner ===== -->
<div class="cyber-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h6>Modifier</h6>
                <h2>Modifier ma candidature</h2>
            </div>
        </div>
    </div>
</div>

<div class="container" style="padding: 60px 0;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="cyber-form-card">
                <div class="form-info form-info-edit">
                    <h5><?= htmlspecialchars($candidatureData['mission_titre']) ?></h5>
                </div>

                <?php if (isset($errors['general'])): ?>
                    <div class="cyber-alert cyber-alert-danger"><?= htmlspecialchars($errors['general']) ?></div>
                <?php endif; ?>

                <form method="POST" action="index.php?action=front_edit_candidature&id=<?= (int)$candidatureData['id'] ?>" novalidate enctype="multipart/form-data">
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label>Nom <span class="required">*</span></label>
                            <input type="text" name="nom" class="<?= isset($errors['nom']) ? 'is-invalid' : '' ?>"
                                value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : htmlspecialchars($candidatureData['nom']) ?>"
                                onkeypress="return /^[a-zA-Z\séèêëàâäùûüôöîïç]+$/.test(String.fromCharCode(event.which))">
                            <div class="invalid-feedback"><?= isset($errors['nom']) ? htmlspecialchars($errors['nom']) : '' ?></div>
                        </div>
                        <div class="col-md-6">
                            <label>Prenom <span class="required">*</span></label>
                            <input type="text" name="prenom" class="<?= isset($errors['prenom']) ? 'is-invalid' : '' ?>"
                                value="<?= isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : htmlspecialchars($candidatureData['prenom']) ?>"
                                onkeypress="return /^[a-zA-Z\séèêëàâäùûüôöîïç]+$/.test(String.fromCharCode(event.which))">
                            <div class="invalid-feedback"><?= isset($errors['prenom']) ? htmlspecialchars($errors['prenom']) : '' ?></div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label>Email <span class="required">*</span></label>
                            <input type="email" name="email" class="<?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : htmlspecialchars($candidatureData['email']) ?>">
                            <div class="invalid-feedback"><?= isset($errors['email']) ? htmlspecialchars($errors['email']) : '' ?></div>
                        </div>
                        <div class="col-md-6">
                            <label>Telephone <span class="required">*</span></label>
                            <input type="text" name="telephone" class="<?= isset($errors['telephone']) ? 'is-invalid' : '' ?>"
                                value="<?= isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : htmlspecialchars($candidatureData['telephone']) ?>">
                            <div class="invalid-feedback"><?= isset($errors['telephone']) ? htmlspecialchars($errors['telephone']) : '' ?></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label>Motivation <span class="required">*</span></label>
                        <textarea name="motivation" rows="5" class="<?= isset($errors['motivation']) ? 'is-invalid' : '' ?>"
                                  onkeypress="return /^[a-zA-Z\séèêëàâäùûüôöîïç,.!?;:'"()-]+$/.test(String.fromCharCode(event.which))"><?= isset($_POST['motivation']) ? htmlspecialchars($_POST['motivation']) : htmlspecialchars($candidatureData['motivation']) ?></textarea>
                        <div class="invalid-feedback"><?= isset($errors['motivation']) ? htmlspecialchars($errors['motivation']) : '' ?></div>
                    </div>

                    <div class="mb-4">
                        <label>CV (PDF, DOC, DOCX)</label>
                        <input type="file" name="cv" accept=".pdf,.doc,.docx">
                        <small style="color: var(--text-dim); font-size: 13px;">Formats acceptes: PDF, DOC, DOCX (Max 5MB)</small>
                        <?php if (!empty($candidatureData['cv'])): ?>
                            <div style="margin-top: 10px;">
                                <small style="color: var(--neon-green);">CV actuel: <a href="uploads/<?= htmlspecialchars($candidatureData['cv']) ?>" target="_blank" style="color: var(--neon-cyan); text-decoration: none;">Telecharger</a></small>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="cyber-btn" style="border: none; cursor: pointer;">
                            <i class="fa fa-save"></i> Mettre a jour
                        </button>
                        <a href="index.php?action=front_candidatures" class="cyber-btn cyber-btn-outline">
                            <i class="fa fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>