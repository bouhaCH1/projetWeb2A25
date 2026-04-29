<?php
ob_start();
?>

<!-- Hero Section -->
<section class="hero" style="min-height: 40vh; padding: 80px 0 40px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 style="font-size: 42px; font-weight: 700; margin-bottom: 15px; background: linear-gradient(135deg, #00ffcc, #00ccff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    Modifier ma candidature
                </h1>
                <p style="color: rgba(255,255,255,0.7); font-size: 16px; margin-bottom: 20px;">
                    <?= htmlspecialchars($candidatureData['mission_titre']) ?>
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
                    <div style="background: rgba(255, 0, 255, 0.05); border: 1px solid rgba(255, 0, 255, 0.2); border-left: 4px solid #ff00ff; border-radius: 10px; padding: 20px; margin-bottom: 30px;">
                        <h5 style="color: #ffffff; font-weight: 600; margin-bottom: 5px;"><?= htmlspecialchars($candidatureData['mission_titre']) ?></h5>
                    </div>

                    <?php if (isset($errors['general'])): ?>
                        <div class="cyber-alert cyber-alert-warning"><?= htmlspecialchars($errors['general']) ?></div>
                    <?php endif; ?>

                    <form method="POST" action="index.php?action=front_edit_candidature&id=<?= (int)$candidatureData['id'] ?>" novalidate enctype="multipart/form-data">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label>Nom <span style="color: #ff6b6b;">*</span></label>
                                <input type="text" name="nom" class="<?= isset($errors['nom']) ? 'is-invalid' : '' ?>"
                                    value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : htmlspecialchars($candidatureData['nom']) ?>"
                                    onkeypress="return /^[a-zA-Z\séèêëàâäùûüôöîïç]+$/.test(String.fromCharCode(event.which))">
                                <div class="invalid-feedback"><?= isset($errors['nom']) ? htmlspecialchars($errors['nom']) : '' ?></div>
                            </div>
                            <div class="col-md-6">
                                <label>Prénom <span style="color: #ff6b6b;">*</span></label>
                                <input type="text" name="prenom" class="<?= isset($errors['prenom']) ? 'is-invalid' : '' ?>"
                                    value="<?= isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : htmlspecialchars($candidatureData['prenom']) ?>"
                                    onkeypress="return /^[a-zA-Z\séèêëàâäùûüôöîïç]+$/.test(String.fromCharCode(event.which))">
                                <div class="invalid-feedback"><?= isset($errors['prenom']) ? htmlspecialchars($errors['prenom']) : '' ?></div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label>Email <span style="color: #ff6b6b;">*</span></label>
                                <input type="email" name="email" class="<?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                    value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : htmlspecialchars($candidatureData['email']) ?>">
                                <div class="invalid-feedback"><?= isset($errors['email']) ? htmlspecialchars($errors['email']) : '' ?></div>
                            </div>
                            <div class="col-md-6">
                                <label>Téléphone <span style="color: #ff6b6b;">*</span></label>
                                <input type="text" name="telephone" class="<?= isset($errors['telephone']) ? 'is-invalid' : '' ?>"
                                    value="<?= isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : htmlspecialchars($candidatureData['telephone']) ?>"
                                    onkeypress="return /[0-9]/.test(String.fromCharCode(event.which))"
                                    pattern="[0-9]*"
                                    inputmode="numeric">
                                <div class="invalid-feedback"><?= isset($errors['telephone']) ? htmlspecialchars($errors['telephone']) : '' ?></div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label>Motivation <span style="color: #ff6b6b;">*</span></label>
                            <textarea name="motivation" rows="5" class="<?= isset($errors['motivation']) ? 'is-invalid' : '' ?>"
                                      onkeypress="return /^[a-zA-Z\séèêëàâäùûüôöîïç,.!?;:'\"()-]+$/.test(String.fromCharCode(event.which))"><?= isset($_POST['motivation']) ? htmlspecialchars($_POST['motivation']) : htmlspecialchars($candidatureData['motivation']) ?></textarea>
                            <div class="invalid-feedback"><?= isset($errors['motivation']) ? htmlspecialchars($errors['motivation']) : '' ?></div>
                        </div>

                        <div class="mb-4">
                            <label>CV (PDF, DOC, DOCX) <span style="color: rgba(255,255,255,0.5);">(optionnel)</span></label>
                            <input type="file" name="cv" accept=".pdf,.doc,.docx" class="form-control" style="background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 10px; padding: 12px 15px; color: #ffffff;">
                            <small style="color: rgba(255,255,255,0.5); font-size: 13px;">Formats acceptés: PDF, DOC, DOCX (Max 5MB)</small>
                            <?php if (!empty($candidatureData['cv'])): ?>
                                <div style="margin-top: 10px;">
                                    <small style="color: #00ffcc;">CV actuel: <a href="uploads/<?= htmlspecialchars($candidatureData['cv']) ?>" target="_blank" style="color: #00ccff; text-decoration: none;">Télécharger</a></small>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex gap-3 justify-content-end">
                            <a href="index.php?action=front_candidatures" class="cyber-btn" style="background: transparent; border: 1px solid #00ffcc; color: #00ffcc;">
                                <i class="fa fa-arrow-left"></i> Retour
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

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>