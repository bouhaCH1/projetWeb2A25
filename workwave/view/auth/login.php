<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>
<div class="dashboard-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="glass-card text-center py-5">
                    <img src="view/assets/logo.png" alt="Logo" style="height: 60px; margin-bottom: 20px;">
                    <h2 class="mb-3">Work Wave</h2>
                    <p class="text-muted mb-4">Connectez-vous à votre espace</p>
                    
                    <?php if (isset($error)): ?>
                        <div class="alert alert-secondary mb-3"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-primary mb-3"><?= htmlspecialchars($_SESSION['message']) ?></div>
                        <?php unset($_SESSION['message']); ?>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-3">Se connecter</button>
                    </form>
                    
                    <hr style="border-color: rgba(212, 175, 55, 0.3); margin: 30px 0;">
                    
                    <div>
                        <p class="mb-1">Pas encore de compte ? <a href="index.php?action=register" style="color: var(--gold-main);">S'inscrire</a></p>
                        <small class="text-muted">Comptes test: admin/admin123 | candidat/candidat123</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>