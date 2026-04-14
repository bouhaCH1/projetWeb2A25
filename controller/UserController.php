<?php
// Controller/UserController.php

// On a besoin de la classe User (le Modèle) pour que le contrôleur puisse parler à la BDD
require_once __DIR__ . '/../Model/User.php';

class UserController {

    // ════════════════════════════════════════════════════════════════════
    //  FRONT OFFICE (Interface Publique)
    // ════════════════════════════════════════════════════════════════════

    // ── Afficher la page d'inscription ──────────────────────────────────
    public function showRegister(): void {
        require_once __DIR__ . '/../View/user/register.php';
    }

    // ── Gérer le formulaire d'inscription quand on clique sur "Submit" ──
    public function register(): void {
        // Rediriger si on essaie d'accéder sans envoyer de formulaire POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=register');
            exit;
        }

        // Récupération classique des données du formulaire POST
        $first_name       = trim($_POST['first_name'] ?? '');
        $last_name        = trim($_POST['last_name'] ?? '');
        $email            = trim($_POST['email'] ?? '');
        $phone            = trim($_POST['phone'] ?? '');
        $role             = trim($_POST['role'] ?? '');
        $password         = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        // Appel de la méthode de sécurité pour vérifier que tout soit propre
        $errors = $this->validateRegister(
            $first_name, $last_name, $email, $phone, $role, $password, $confirm_password
        );

        // S'il y a des erreurs, on les sauvegarde en session et on retourne en arrière
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            
            // Sauvegarder les valeurs pour éviter que l'utilisateur doive tout retaper
            $_SESSION['old'] = array(
                'first_name' => $first_name,
                'last_name'  => $last_name,
                'email'      => $email,
                'phone'      => $phone,
                'role'       => $role
            );
            
            header('Location: index.php?action=register');
            exit;
        }

        // Configuration de l'entité User (le modèle)
        $user = new User();
        $user->first_name = htmlspecialchars($first_name);
        $user->last_name  = htmlspecialchars($last_name);
        $user->email      = $email;
        $user->phone      = htmlspecialchars($phone);
        $user->role       = $role;
        $user->password   = $password;

        // On ordonne au Modèle de sauvegarder dans MySQL
        $result = $user->register();

        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
            header('Location: index.php?action=login');
        } else {
            $_SESSION['errors'] = array($result['message']);
            header('Location: index.php?action=register');
        }
        exit;
    }

    // ── Afficher la page de connexion ───────────────────────────────────
    public function showLogin(): void {
        require_once __DIR__ . '/../View/user/login.php';
    }

    // ── Connexion administrateur (page dédiée) ──────────────────────────
    public function showAdminLogin(): void {
        require_once __DIR__ . '/../View/admin/login.php';
    }

    public function adminLogin(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=admin_login');
            exit;
        }

        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = [];
        if ($email === '') {
            $errors[] = 'Email is required.';
        }
        if ($password === '') {
            $errors[] = 'Password is required.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: index.php?action=admin_login');
            exit;
        }

        $user = new User();
        $user->email    = $email;
        $user->password = $password;

        $result = $user->login();

        if (!$result['success']) {
            $_SESSION['errors'] = [$result['message']];
            header('Location: index.php?action=admin_login');
            exit;
        }

        if ($user->role !== 'admin') {
            $_SESSION['errors'] = ['This login is reserved for administrator accounts only. Use the public login for job seekers and employers.'];
            header('Location: index.php?action=admin_login');
            exit;
        }

        $_SESSION['user_id']          = $user->id;
        $_SESSION['user_first_name']  = $user->first_name;
        $_SESSION['user_last_name']   = $user->last_name;
        $_SESSION['user_role']        = $user->role;
        $_SESSION['user_pic']         = $user->profile_pic;

        header('Location: index.php?action=admin_users');
        exit;
    }

    // ── Gérer le fonctionnement de la connexion ─────────────────────────
    public function login(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=login');
            exit;
        }

        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = [];
        if (empty($email)) { $errors[] = 'Email is required.'; }
        if (empty($password)) { $errors[] = 'Password is required.'; }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: index.php?action=login');
            exit;
        }

        $user = new User();
        $user->email = $email;
        $user->password = $password;
        
        // On demande au modèle si le compte est valide
        $result = $user->login();

        if ($result['success']) {
            // Les comptes admin utilisent la page de connexion dédiée
            if ($user->role === 'admin') {
                $_SESSION['errors'] = ['Administrator accounts must sign in via the Administrator login page.'];
                header('Location: index.php?action=admin_login');
                exit;
            }

            $_SESSION['user_id']         = $user->id;
            $_SESSION['user_first_name'] = $user->first_name;
            $_SESSION['user_last_name']  = $user->last_name;
            $_SESSION['user_role']       = $user->role;
            $_SESSION['user_pic']        = $user->profile_pic;

            if ($user->role === 'employer') {
                header('Location: index.php?action=dashboard_employer');
            } else {
                header('Location: index.php?action=dashboard_seeker');
            }
        } else {
            $_SESSION['errors'] = array($result['message']);
            header('Location: index.php?action=login');
        }
        exit;
    }

    // ── Afficher la page du Profil ───────────────────────────────────
    public function showProfile(): void {
        $this->requireLogin();
        $user = new User();
        $data = $user->getById($_SESSION['user_id']);
        require_once __DIR__ . '/../View/user/profile.php';
    }

    // ── Modifier le Profil de l'utilisateur connecté ──────────────────
    public function updateProfile(): void {
        $this->requireLogin();

        $first_name = trim($_POST['first_name'] ?? '');
        $last_name  = trim($_POST['last_name'] ?? '');
        $phone      = trim($_POST['phone'] ?? '');

        $errors = [];
        if (empty($first_name)) { $errors[] = 'First name is required.'; }
        if (empty($last_name)) { $errors[] = 'Last name is required.'; }
        if (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]{2,}$/', $first_name)) { $errors[] = 'First name is invalid.'; }
        if (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]{2,}$/', $last_name)) { $errors[] = 'Last name is invalid.'; }
        if (!empty($phone) && !preg_match('/^\+?[0-9\s\-]{7,15}$/', $phone)) {
            $errors[] = 'Phone number is invalid.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: index.php?action=profile');
            exit;
        }

        $user = new User();
        $user->id = $_SESSION['user_id'];
        $user->first_name = htmlspecialchars($first_name);
        $user->last_name  = htmlspecialchars($last_name);
        $user->phone      = htmlspecialchars($phone);
        
        // Garder l'ancienne photo s'il y en a une
        $user->profile_pic = $_SESSION['user_pic'] ?? '';

        // Gérer le téléchargement de la nouvelle photo
        if (!empty($_FILES['profile_pic']['name'])) {
            $upload_dir = __DIR__ . '/../View/uploads/profile_pics/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $ext = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($ext, $allowed)) {
                $_SESSION['errors'] = array('Only JPG, PNG and GIF images are allowed.');
                header('Location: index.php?action=profile');
                exit;
            }

            if ($_FILES['profile_pic']['size'] > 2 * 1024 * 1024) {
                $_SESSION['errors'] = array('Image must be under 2MB.');
                header('Location: index.php?action=profile');
                exit;
            }

            $filename = 'user_' . $user->id . '_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['profile_pic']['tmp_name'], $upload_dir . $filename);
            $user->profile_pic = 'View/uploads/profile_pics/' . $filename;
        }

        $result = $user->updateProfile();

        if ($result['success']) {
            $_SESSION['user_first_name'] = $user->first_name;
            $_SESSION['user_last_name']  = $user->last_name;
            $_SESSION['user_pic']        = $user->profile_pic;
            $_SESSION['success']         = $result['message'];
        } else {
            $_SESSION['errors'] = array($result['message']);
        }

        header('Location: index.php?action=profile');
        exit;
    }

    // ── Se déconnecter ───────────────────────────────────────────────
    public function logout(): void {
        session_destroy();
        header('Location: index.php?action=login');
        exit;
    }

    // ════════════════════════════════════════════════════════════════════
    //  BACK OFFICE (La partie réservée à l'administration)
    // ════════════════════════════════════════════════════════════════════

    // ── Lister tous les utilisateurs dans un tableau ─────────────────
    public function adminListUsers(): void {
        $this->requireAdmin();
        $user  = new User();
        $users = $user->getAll(); // Appel au modèle
        require_once __DIR__ . '/../View/admin/users_list.php';
    }

    // ── Afficher le formulaire de modification pour un utilisateur ───
    public function adminEditUser(): void {
        $this->requireAdmin();
        
        $id = (int) ($_GET['id'] ?? 0);

        $user = new User();
        $data = $user->getById($id);
        
        if (!$data) {
            $_SESSION['errors'] = array('User not found.');
            header('Location: index.php?action=admin_users');
            exit;
        }

        // Un admin ne peut pas modifier un autre compte admin
        if ($data['role'] === 'admin') {
            $_SESSION['errors'] = array('Admin accounts cannot be edited.');
            header('Location: index.php?action=admin_users');
            exit;
        }

        require_once __DIR__ . '/../View/admin/user_edit.php';
    }

    // ── Appliquer les changements d'un utilisateur depuis l'admin ────
    public function adminUpdateUser(): void {
        $this->requireAdmin();

        $id         = (int) ($_POST['id'] ?? 0);
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name  = trim($_POST['last_name'] ?? '');
        $phone      = trim($_POST['phone'] ?? '');
        $role       = trim($_POST['role'] ?? '');

        $errors = [];
        if (empty($first_name)) { $errors[] = 'First name is required.'; }
        if (empty($last_name)) { $errors[] = 'Last name is required.'; }
        // Seuls job_seeker et employer sont autorisés (pas admin)
        if (!in_array($role, ['job_seeker', 'employer'])) { $errors[] = 'Invalid role selected.'; }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: index.php?action=admin_edit_user&id=' . $id);
            exit;
        }

        $user = new User();
        $user->id         = $id;
        $user->first_name = htmlspecialchars($first_name);
        $user->last_name  = htmlspecialchars($last_name);
        $user->phone      = htmlspecialchars($phone);
        $user->role       = $role;

        // On utilise la méthode dédiée au back-office (elle protège les admins)
        $result = $user->adminUpdate();
        
        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
        } else {
            $_SESSION['errors'] = array($result['message']);
        }

        header('Location: index.php?action=admin_users');
        exit;
    }

    // ── Effacer le compte d'un utilisateur ────────────────────────────
    public function adminDeleteUser(): void {
        $this->requireAdmin();
        
        $id = (int) ($_GET['id'] ?? 0);
        
        $user = new User();
        $user->deleteAccount($id);
        
        $_SESSION['success'] = 'User deleted successfully.';
        header('Location: index.php?action=admin_users');
        exit;
    }

    // ════════════════════════════════════════════════════════════════════
    //  OUTILS D'AIDE (Fonctions privées du contrôleur)
    // ════════════════════════════════════════════════════════════════════

    // Sécurité de base, si non connecté, retour à la page login.
    private function requireLogin(): void {
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
    }

    // Sécurité back-office : seuls les admin ont accès.
    // Si quelqu'un qui n'est pas admin essaie d'accéder, on le redirige.
    private function requireAdmin(): void {
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?action=admin_login');
            exit;
        }
        if (($_SESSION['user_role'] ?? '') !== 'admin') {
            // Accès refusé — on redirige vers la page d'accueil
            header('Location: index.php');
            exit;
        }
    }

    // Validation manuelle de l'inscription
    private function validateRegister(
        string $first_name,
        string $last_name,
        string $email,
        string $phone,
        string $role,
        string $password,
        string $confirm_password
    ): array {
        $errors = [];

        if (empty($first_name)) {
            $errors[] = 'First name is required.';
        } elseif (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]{2,50}$/', $first_name)) {
            $errors[] = 'First name must be 2–50 letters only.';
        }

        if (empty($last_name)) {
            $errors[] = 'Last name is required.';
        } elseif (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]{2,50}$/', $last_name)) {
            $errors[] = 'Last name must be 2–50 letters only.';
        }

        if (empty($email)) {
            $errors[] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format.';
        }

        if (!empty($phone) && !preg_match('/^\+?[0-9\s\-]{7,15}$/', $phone)) {
            $errors[] = 'Phone number is invalid.';
        }

        if (!in_array($role, ['job_seeker', 'employer'])) {
            $errors[] = 'Please select a valid role.';
        }

        if (empty($password)) {
            $errors[] = 'Password is required.';
        } elseif (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters.';
        } elseif (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password must contain at least one uppercase letter.';
        } elseif (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password must contain at least one number.';
        }

        if ($password !== $confirm_password) {
            $errors[] = 'Passwords do not match.';
        }

        return $errors;
    }
}
?>
