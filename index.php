<?php
session_start();
require_once __DIR__ . '/config/database.php';

$action = $_GET['action'] ?? 'dashboard';

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

// Login
if (isset($_POST['login'])) {
    $id   = (int)($_POST['user_id'] ?? 0);
    $role = $_POST['role'] ?? '';
    if ($id > 0 && in_array($role, ['enseignant','etudiant'])) {
        $_SESSION['role']    = $role;
        $_SESSION['user_id'] = $id;
        header('Location: index.php?role=' . $role . '&action=dashboard');
        exit;
    }
}

// Route
if (!empty($_SESSION['role']) && !empty($_SESSION['user_id'])) {
    $role = $_SESSION['role'];
    if ($role === 'enseignant') {
        require_once __DIR__ . '/controllers/EnseignantController.php';
        (new EnseignantController())->handle($action);
    } else {
        require_once __DIR__ . '/controllers/EtudiantController.php';
        (new EtudiantController())->handle($action);
    }
} else {
    showLogin();
}

// ── Page de connexion ──────────────────────────────────────────────────────
function showLogin(): void {
    $pdo         = getDB();
    $enseignants = $pdo->query("SELECT * FROM enseignants ORDER BY nom")->fetchAll();
    $etudiants   = $pdo->query("SELECT * FROM etudiants ORDER BY nom")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FormationPHP &mdash; Connexion</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body class="login-body">

<div class="login-container">

    <div class="login-logo">
        <h1>FormationPHP</h1>
        <p>Gestion des Formations &amp; Taches</p>
    </div>

    <form method="POST" action="index.php" novalidate>

        <div class="form-group">
            <label for="roleSelect">Role</label>
            <select name="role" id="roleSelect" onchange="majUtilisateurs()">
                <option value="">Choisir un role</option>
                <option value="enseignant">Enseignant</option>
                <option value="etudiant">Etudiant</option>
            </select>
        </div>

        <div class="form-group">
            <label for="userSelect">Utilisateur</label>
            <select name="user_id" id="userSelect">
                <option value="">Choisir d'abord le role</option>
            </select>
        </div>

        <button type="submit" name="login" class="btn btn-primary btn-full">Se connecter</button>
    </form>

    <p class="login-note">Systeme provisoire &mdash; aucun mot de passe requis</p>

</div>

<script>
var enseignants = <?= json_encode($enseignants) ?>;
var etudiants   = <?= json_encode($etudiants) ?>;

function majUtilisateurs() {
    var role = document.getElementById('roleSelect').value;
    var sel  = document.getElementById('userSelect');
    sel.innerHTML = '<option value="">Selectionner</option>';
    var liste = role === 'enseignant' ? enseignants : etudiants;
    liste.forEach(function(u) {
        var opt = document.createElement('option');
        opt.value = u.id;
        opt.textContent = u.prenom + ' ' + u.nom + ' (ID: ' + u.id + ')';
        sel.appendChild(opt);
    });
}
</script>

</body>
</html>
<?php
}
