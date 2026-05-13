<?php
$error = $error ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>FormationPHP &mdash; Connexion</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/fontawesome.css">
    <link rel="stylesheet" href="../public/css/templatemo-plot-listing.css">
    <link rel="stylesheet" href="../public/css/app.css">
    <link rel="stylesheet" href="../public/css/theme-graph.css">
</head>
<body>

<div class="login-wrapper">
  <div class="login-box">
    <div class="login-side-left">
      <h1><i class="fa fa-graduation-cap" style="margin-right:10px"></i>FormationPHP</h1>
      <p>Plateforme de gestion des formations professionnelles</p>
      <div class="login-feature"><i class="fa fa-check-circle"></i> Gestion des formations</div>
      <div class="login-feature"><i class="fa fa-check-circle"></i> Suivi des taches</div>
      <div class="login-feature"><i class="fa fa-check-circle"></i> Commentaires collaboratifs</div>
      <div class="login-feature"><i class="fa fa-check-circle"></i> Traduction integree</div>
    </div>
    <div class="login-side-right">
      <h2>Connexion</h2>
      <p class="sub">Bienvenue ! Connectez-vous pour continuer.</p>

      <?php if ($error): ?>
      <div class="app-alert app-alert-danger" style="margin-bottom:18px">
        <i class="fa fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
      </div>
      <?php endif; ?>

      <form method="POST" action="index.php">
        <div class="form-field">
          <label>Role</label>
          <div class="role-toggle">
            <input type="radio" name="role" id="role_manager" value="manager" checked>
            <label for="role_manager"><i class="fa fa-user"></i> Manager</label>
            <input type="radio" name="role" id="role_client" value="client">
            <label for="role_client"><i class="fa fa-user"></i> Client</label>
          </div>
        </div>

        <div class="login-field">
          <label class="login-label" for="login_email"><i class="fa fa-envelope"></i> Email</label>
          <input class="login-input" type="email" name="email" id="login_email" placeholder="votre@email.com" required autocomplete="email">
        </div>

        <div class="login-field">
          <label class="login-label" for="login_password"><i class="fa fa-lock"></i> Mot de passe</label>
          <div class="input-pwd">
            <input class="login-input" type="password" name="password" id="login_password" placeholder="••••••••" required autocomplete="current-password">
            <button type="button" class="toggle-pwd" onclick="togglePw()"><i class="fa fa-eye" id="pwIcon"></i></button>
          </div>
        </div>

        <button type="submit" name="login" class="btn-login-submit">
          <i class="fa fa-sign-in"></i> Se connecter
        </button>
      </form>

      <div class="login-hint" style="margin-bottom:10px">
        <strong>Demo :</strong> email = <code>jean.dupont@example.com</code> (manager)
        ou <code>alice@example.com</code> (client) &mdash; mot de passe = <code>password</code>
      </div>
      <div style="font-size:13px">
        Nouveau compte ? <a href="index.php?action=register">Creer un compte</a>
      </div>
    </div>
  </div>
</div>

<script>
function togglePw() {
    var pw   = document.getElementById('login_password');
    var icon = document.getElementById('pwIcon');
    if (pw.type === 'password') {
        pw.type = 'text';
        icon.className = 'fa fa-eye-slash';
    } else {
        pw.type = 'password';
        icon.className = 'fa fa-eye';
    }
}
</script>
</body>
</html>
