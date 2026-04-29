<?php include __DIR__ . '/../layout/pl_header.php'; ?>

<div class="ww-form-section">
    <div class="ww-form-card">
        <h1>Connexion Administrateur</h1>
        <p class="ww-subtitle">Accès back-office uniquement.</p>

        <?php if (!empty($_SESSION['errors'])): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($_SESSION['errors'] as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; unset($_SESSION['errors']); ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <form id="adminLoginForm" action="/workwave/Controller/index.php?action=admin_login_submit" method="POST" novalidate>
            <label>E-mail administrateur</label>
            <input type="text" id="email" name="email" autocomplete="username">

            <label>Mot de passe</label>
            <input type="password" id="password" name="password" autocomplete="current-password">

            <button type="submit" class="ww-btn-primary">Se connecter au panel admin</button>
            <a href="/workwave/Controller/index.php?action=login" class="ww-btn-secondary">Aller à la connexion publique</a>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/pl_footer.php'; ?>
