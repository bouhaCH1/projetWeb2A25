<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="content_box" style="max-width:480px;margin:0 auto;">
    <h1 style="margin-bottom:8px;">Connexion Administrateur</h1>
    <p style="color:#aaa;font-size:0.95rem;margin-bottom:20px;">Accès back-office uniquement. Les candidats et employeurs utilisent la <a href="/workwave/Controller/index.php?action=login">connexion publique</a>.</p>

    <?php if (!empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger"><ul>
            <?php foreach ($_SESSION['errors'] as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; unset($_SESSION['errors']); ?>
        </ul></div>
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

        <br/>
        <button type="submit" class="btn btn-primary">Se connecter au panel admin</button>
        <a href="/workwave/Controller/index.php" class="btn btn-secondary">← Retour au site</a>

    </form>
</div>



<?php include __DIR__ . '/../layout/footer.php'; ?>
