<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>
<div class="dashboard-container">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="job-card shadow-lg">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-primary m-0"><?= htmlspecialchars($job['title']) ?></h2>
                    <span class="badge bg-secondary"><?= date('d/m/Y', strtotime($job['created_at'])) ?></span>
                </div>
                
                <h5 class="mb-4"><i class="fas fa-building text-primary"></i> <?= htmlspecialchars($job['company_name']) ?></h5>
                
                <h6 class="text-primary mt-4">Description :</h6>
                <p><?= nl2br(htmlspecialchars($job['description'])) ?></p>
                
                <h6 class="text-primary mt-4">Compétences Requises :</h6>
                <p><?= nl2br(htmlspecialchars($job['requirements'])) ?></p>
                
                <hr style="border-color: #333; margin: 40px 0;">
                
                <h4 class="text-primary mb-3">Postuler à cette offre</h4>
                <form action="index.php?action=candidat-apply-job&id=<?= $job['id'] ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Message / Lettre de motivation (Obligatoire)</label>
                        <textarea name="message" class="form-control" rows="5" required placeholder="Expliquez pourquoi vous êtes le candidat idéal..."></textarea>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="index.php" class="btn btn-outline-light rounded-pill px-4">Retour</a>
                        <button type="submit" class="btn btn-primary">Envoyer ma candidature</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


</div>
<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>
