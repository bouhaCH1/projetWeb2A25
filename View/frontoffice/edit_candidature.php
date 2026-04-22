<?php
ob_start();
?>

<!-- ***** Page Banner Area Start ***** -->
<div class="page-banner" style="background: linear-gradient(135deg, #00bdfe 0%, #2b2b2b 100%); padding: 100px 0 50px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="top-text header-text text-center">
                    <h6 style="color: rgba(255,255,255,0.8);">Modifier</h6>
                    <h2 style="color: white;">Modifier ma candidature</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ***** Page Banner Area End ***** -->

<div class="container" style="padding: 60px 0;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div style="background: white; border-radius: 15px; padding: 40px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div style="background: #f8f9fa; border-radius: 10px; padding: 20px; margin-bottom: 30px; border-left: 4px solid #fa5b0f;">
                    <h5 style="margin-bottom: 5px; color: #2b2b2b; font-weight: 600;"><?= htmlspecialchars($candidatureData['mission_titre']) ?></h5>
                </div>

                <?php if (isset($errors['general'])): ?>
                    <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 10px; margin-bottom: 20px;"><?= htmlspecialchars($errors['general']) ?></div>
                <?php endif; ?>

                <form method="POST" action="index.php?action=front_edit_candidature&id=<?= (int)$candidatureData['id'] ?>" novalidate>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label style="font-weight: 600; color: #2b2b2b; margin-bottom: 8px; display: block;">Nom <span style="color: #fa5b0f;">*</span></label>
                            <input type="text" name="nom" class="form-control <?= isset($errors['nom']) ? 'is-invalid' : '' ?>"
                                style="border-radius: 10px; padding: 12px 15px; border: 1px solid #ddd;"
                                value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : htmlspecialchars($candidatureData['nom']) ?>"
                                onkeypress="return /^[a-zA-Z\séèêëàâäùûüôöîïç]+$/.test(String.fromCharCode(event.which))">
                            <div class="invalid-feedback"><?= isset($errors['nom']) ? htmlspecialchars($errors['nom']) : '' ?></div>
                        </div>
                        <div class="col-md-6">
                            <label style="font-weight: 600; color: #2b2b2b; margin-bottom: 8px; display: block;">Prénom <span style="color: #fa5b0f;">*</span></label>
                            <input type="text" name="prenom" class="form-control <?= isset($errors['prenom']) ? 'is-invalid' : '' ?>"
                                style="border-radius: 10px; padding: 12px 15px; border: 1px solid #ddd;"
                                value="<?= isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : htmlspecialchars($candidatureData['prenom']) ?>"
                                onkeypress="return /^[a-zA-Z\séèêëàâäùûüôöîïç]+$/.test(String.fromCharCode(event.which))">
                            <div class="invalid-feedback"><?= isset($errors['prenom']) ? htmlspecialchars($errors['prenom']) : '' ?></div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label style="font-weight: 600; color: #2b2b2b; margin-bottom: 8px; display: block;">Email <span style="color: #fa5b0f;">*</span></label>
                            <input type="email" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                style="border-radius: 10px; padding: 12px 15px; border: 1px solid #ddd;"
                                value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : htmlspecialchars($candidatureData['email']) ?>">
                            <div class="invalid-feedback"><?= isset($errors['email']) ? htmlspecialchars($errors['email']) : '' ?></div>
                        </div>
                        <div class="col-md-6">
                            <label style="font-weight: 600; color: #2b2b2b; margin-bottom: 8px; display: block;">Téléphone <span style="color: #fa5b0f;">*</span></label>
                            <input type="text" name="telephone" class="form-control <?= isset($errors['telephone']) ? 'is-invalid' : '' ?>"
                                style="border-radius: 10px; padding: 12px 15px; border: 1px solid #ddd;"
                                value="<?= isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : htmlspecialchars($candidatureData['telephone']) ?>">
                            <div class="invalid-feedback"><?= isset($errors['telephone']) ? htmlspecialchars($errors['telephone']) : '' ?></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label style="font-weight: 600; color: #2b2b2b; margin-bottom: 8px; display: block;">Motivation <span style="color: #fa5b0f;">*</span></label>
                        <textarea name="motivation" rows="5" class="form-control <?= isset($errors['motivation']) ? 'is-invalid' : '' ?>"
                                  style="border-radius: 10px; padding: 12px 15px; border: 1px solid #ddd; width: 100%;"
                                  onkeypress="return /^[a-zA-Z\séèêëàâäùûüôöîïç,.!?;:'"()-]+$/.test(String.fromCharCode(event.which))"><?= isset($_POST['motivation']) ? htmlspecialchars($_POST['motivation']) : htmlspecialchars($candidatureData['motivation']) ?></textarea>
                        <div class="invalid-feedback"><?= isset($errors['motivation']) ? htmlspecialchars($errors['motivation']) : '' ?></div>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="main-button" style="border: none; cursor: pointer;">
                            <i class="fa fa-save"></i> Mettre à jour
                        </button>
                        <a href="index.php?action=front_candidatures" class="main-button" style="background: #2b2b2b; text-decoration: none; color: white; display: inline-block; padding: 12px 25px; border-radius: 25px;">
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