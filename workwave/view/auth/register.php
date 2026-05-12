<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>
<div class="dashboard-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="glass-card text-center py-5">
                    <img src="view/assets/logo.png" alt="Logo" style="height: 60px; margin-bottom: 20px;">
                    <h2 class="mb-3">Inscription</h2>
                    <p class="text-muted mb-4">Rejoignez Work Wave</p>
                    
                    <?php if (isset($error)): ?>
                        <div class="alert alert-secondary mb-3"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-secondary mb-3 text-start">
                            <?php foreach($errors as $e): ?>• <?= htmlspecialchars($e) ?><br><?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <input type="text" name="full_name" class="form-control" placeholder="Nom complet" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="company" class="form-control" placeholder="Nom de l'entreprise (optionnel)">
                        </div>
                        <div class="mb-3">
                            <select name="role" class="form-select" required>
                                <option value="candidat">Candidat (exposer mon portfolio)</option>
                                <option value="entreprise">Entreprise (rechercher des talents)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-3">S'inscrire</button>
                    </form>
                    
                    <hr style="border-color: rgba(212, 175, 55, 0.3); margin: 30px 0;">
                    
                    <div>
                        <a href="index.php?action=login" style="color: var(--gold-main);">Déjà inscrit ? Se connecter</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>