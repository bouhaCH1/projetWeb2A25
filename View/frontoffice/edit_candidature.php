<?php
ob_start();
?>

<div class="row justify-content-center mt-4">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning text-white">
                <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Modifier ma candidature</h4>
            </div>
            <div class="card-body p-4">
                <div class="alert alert-light border mb-4">
                    <h5 class="mb-1"><?= htmlspecialchars($candidatureData['mission_titre']) ?></h5>
                </div>

                <?php if (isset($errors['general'])): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($errors['general']) ?></div>
                <?php endif; ?>

                <form method="POST" action="index.php?action=front_edit_candidature&id=<?= (int)$candidatureData['id'] ?>" novalidate>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                            <input type="text" name="nom" class="form-control <?= isset($errors['nom']) ? 'is-invalid' : '' ?>"
                                value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : htmlspecialchars($candidatureData['nom']) ?>">
                            <div class="invalid-feedback"><?= isset($errors['nom']) ? htmlspecialchars($errors['nom']) : '' ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Prenom <span class="text-danger">*</span></label>
                            <input type="text" name="prenom" class="form-control <?= isset($errors['prenom']) ? 'is-invalid' : '' ?>"
                                value="<?= isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : htmlspecialchars($candidatureData['prenom']) ?>">
                            <div class="invalid-feedback"><?= isset($errors['prenom']) ? htmlspecialchars($errors['prenom']) : '' ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : htmlspecialchars($candidatureData['email']) ?>">
                            <div class="invalid-feedback"><?= isset($errors['email']) ? htmlspecialchars($errors['email']) : '' ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Telephone <span class="text-danger">*</span></label>
                            <input type="text" name="telephone" class="form-control <?= isset($errors['telephone']) ? 'is-invalid' : '' ?>"
                                value="<?= isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : htmlspecialchars($candidatureData['telephone']) ?>">
                            <div class="invalid-feedback"><?= isset($errors['telephone']) ? htmlspecialchars($errors['telephone']) : '' ?></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Motivation <span class="text-danger">*</span></label>
                        <textarea name="motivation" rows="5" class="form-control <?= isset($errors['motivation']) ? 'is-invalid' : '' ?>"><?= isset($_POST['motivation']) ? htmlspecialchars($_POST['motivation']) : htmlspecialchars($candidatureData['motivation']) ?></textarea>
                        <div class="invalid-feedback"><?= isset($errors['motivation']) ? htmlspecialchars($errors['motivation']) : '' ?></div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-2"></i>Mettre à jour
                        </button>
                        <a href="index.php?action=front_candidatures" class="btn btn-outline-secondary">Retour</a>
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