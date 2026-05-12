<?php
$pageTitle = 'candidature';
require_once __DIR__ . '/../layout/pl_dashboard_header.php';

// Pre-fill from session if logged in
$prefillNom       = isset($_POST['nom'])       ? $_POST['nom']       : ($_SESSION['last_name']  ?? '');
$prefillPrenom    = isset($_POST['prenom'])    ? $_POST['prenom']    : ($_SESSION['first_name'] ?? '');
$prefillEmail     = isset($_POST['email'])     ? $_POST['email']     : ($_SESSION['email']       ?? '');
$prefillTelephone = isset($_POST['telephone']) ? $_POST['telephone'] : ($_SESSION['phone']       ?? '');
$isLoggedIn       = !empty($_SESSION['user_id']);
?>

<!-- Hero Section -->
<section class="hero" style="min-height: 40vh; padding: 80px 0 40px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 style="font-size: 42px; font-weight: 700; margin-bottom: 15px; background: linear-gradient(135deg, #00ffcc, #00ccff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    Postuler à la mission
                </h1>
                <p style="color: rgba(255,255,255,0.7); font-size: 16px; margin-bottom: 20px;">
                    <?= htmlspecialchars($missionData['titre']) ?>
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
                    <div style="background: rgba(0, 255, 204, 0.05); border: 1px solid rgba(0, 255, 204, 0.2); border-left: 4px solid #00ffcc; border-radius: 10px; padding: 20px; margin-bottom: 30px;">
                        <h5 style="color: #ffffff; font-weight: 600; margin-bottom: 5px;"><?= htmlspecialchars($missionData['titre']) ?></h5>
                        <small style="color: #00ffcc;"><i class="fa fa-tools"></i> <?= htmlspecialchars($missionData['competences']) ?></small>
                    </div>

                    <?php if (isset($errors['general'])): ?>
                        <div class="cyber-alert cyber-alert-warning"><?= htmlspecialchars($errors['general']) ?></div>
                    <?php endif; ?>

                    <form method="POST" action="/workwave/Controller/index.php?action=front_apply&id=<?= (int)$missionData['id'] ?>" novalidate enctype="multipart/form-data">
                        <?php if ($isLoggedIn): ?>
                        <div style="background: rgba(0,255,204,0.07); border: 1px solid rgba(0,255,204,0.25); border-left: 4px solid #00ffcc; border-radius: 10px; padding: 12px 18px; margin-bottom: 20px; font-size: 13px; color: rgba(255,255,255,0.7);">
                            <i class="fa fa-user-check" style="color: #00ffcc;"></i>
                            Informations pr&eacute;-remplies depuis votre compte. Vous pouvez les modifier si n&eacute;cessaire.
                        </div>
                        <?php endif; ?>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label>Nom <span style="color: #ff6b6b;">*</span></label>
                                <input type="text" name="nom" class="<?= isset($errors['nom']) ? 'is-invalid' : '' ?>"
                                    value="<?= htmlspecialchars($prefillNom) ?>"
                                    onkeypress="return /^[a-zA-Z\séèêëàâäùûüôöîïç]+$/.test(String.fromCharCode(event.which))">
                                <div class="invalid-feedback"><?= isset($errors['nom']) ? htmlspecialchars($errors['nom']) : '' ?></div>
                            </div>
                            <div class="col-md-6">
                                <label>Prénom <span style="color: #ff6b6b;">*</span></label>
                                <input type="text" name="prenom" class="<?= isset($errors['prenom']) ? 'is-invalid' : '' ?>"
                                    value="<?= htmlspecialchars($prefillPrenom) ?>"
                                    onkeypress="return /^[a-zA-Z\séèêëàâäùûüôöîïç]+$/.test(String.fromCharCode(event.which))">
                                <div class="invalid-feedback"><?= isset($errors['prenom']) ? htmlspecialchars($errors['prenom']) : '' ?></div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label>Email <span style="color: #ff6b6b;">*</span></label>
                                <input type="email" name="email" class="<?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                    value="<?= htmlspecialchars($prefillEmail) ?>">
                                <div class="invalid-feedback"><?= isset($errors['email']) ? htmlspecialchars($errors['email']) : '' ?></div>
                            </div>
                            <div class="col-md-6">
                                <label>Téléphone <span style="color: #ff6b6b;">*</span></label>
                                <input type="text" name="telephone" class="<?= isset($errors['telephone']) ? 'is-invalid' : '' ?>"
                                    value="<?= htmlspecialchars($prefillTelephone) ?>"
                                    onkeypress="return /[0-9]/.test(String.fromCharCode(event.which))"
                                    pattern="[0-9]*"
                                    inputmode="numeric">
                                <div class="invalid-feedback"><?= isset($errors['telephone']) ? htmlspecialchars($errors['telephone']) : '' ?></div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label>Motivation <span style="color: #ff6b6b;">*</span></label>
                            <textarea name="motivation" rows="5" class="<?= isset($errors['motivation']) ? 'is-invalid' : '' ?>"
                                      placeholder="Expliquez pourquoi vous êtes le bon candidat pour cette mission..."
                                      onkeypress="return /^[a-zA-Z\séèêëàâäùûüôöîïç,.!?;:'\"()-]+$/.test(String.fromCharCode(event.which))"><?= isset($_POST['motivation']) ? htmlspecialchars($_POST['motivation']) : '' ?></textarea>
                            <div class="invalid-feedback"><?= isset($errors['motivation']) ? htmlspecialchars($errors['motivation']) : '' ?></div>
                        </div>

                        <div class="mb-4">
                            <label>CV (PDF, DOC, DOCX) <span style="color: rgba(255,255,255,0.5);">(optionnel)</span></label>
                            <input type="file" name="cv" accept=".pdf,.doc,.docx" class="form-control" style="background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 10px; padding: 12px 15px; color: #ffffff;">
                            <small style="color: rgba(255,255,255,0.5); font-size: 13px;">Formats acceptés: PDF, DOC, DOCX (Max 5MB)</small>
                        </div>

                        <div class="d-flex gap-3 justify-content-end">
                            <a href="/workwave/Controller/index.php?action=missions" class="cyber-btn" style="background: transparent; border: 1px solid #00ffcc; color: #00ffcc;">
                                <i class="fa fa-arrow-left"></i> Retour
                            </a>
                            <button type="submit" class="cyber-btn">
                                <i class="fa fa-paper-plane"></i> Envoyer ma candidature
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
require_once __DIR__ . '/../layout/pl_dashboard_footer.php';
?>
