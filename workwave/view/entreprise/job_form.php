<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>
<div class="dashboard-container">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-container shadow-lg">
                <h3 class="mb-4" style="color: var(--primary);">Publier une nouvelle offre d'emploi</h3>
                
                <form action="index.php?action=entreprise-submit-job" method="POST">
                    <div class="mb-3">
                        <label>Titre de l'offre</label>
                        <input type="text" name="title" class="form-control" required placeholder="Ex: Développeur Full-Stack PHP">
                    </div>
                    <div class="mb-3">
                        <label>Description du poste</label>
                        <textarea name="description" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label>Compétences requises</label>
                        <textarea name="requirements" class="form-control" rows="3" required placeholder="Ex: PHP, MySQL, React..."></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Soumettre pour validation</button>
                    <a href="index.php?action=entreprise-dashboard" class="btn btn-outline-secondary w-100 mt-2">Retour au Dashboard</a>
                </form>
            </div>
        </div>
    </div>
</div>


</div>
<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>
