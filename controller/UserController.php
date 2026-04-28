<?php

require_once __DIR__ . '/../Model/User.php';

class UserController {

    public function showRegister(): void {
        require_once __DIR__ . '/../View/user/register.php';
    }

    public function register(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=register');
            exit;
        }

        $first_name       = trim($_POST['first_name'] ?? '');
        $last_name        = trim($_POST['last_name'] ?? '');
        $email            = trim($_POST['email'] ?? '');
        $phone            = trim($_POST['phone'] ?? '');
        $role             = trim($_POST['role'] ?? '');
        $password         = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        $errors = $this->validateRegister(
            $first_name, $last_name, $email, $phone, $role, $password, $confirm_password
        );

        if (!empty($errors)) {
            $_SESSION['field_errors'] = $this->extractRegisterFieldErrors($errors);
            $_SESSION['old'] = [
                'first_name' => $first_name,
                'last_name'  => $last_name,
                'email'      => $email,
                'phone'      => $phone,
                'role'       => $role,
            ];
            header('Location: index.php?action=register');
            exit;
        }

        $user = new User();
        $user->first_name = htmlspecialchars($first_name);
        $user->last_name  = htmlspecialchars($last_name);
        $user->email      = $email;
        $user->phone      = htmlspecialchars($phone);
        $user->role       = $role;
        $user->password   = $password;

        $result = $user->register();

        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
            header('Location: index.php?action=login');
        } else {
            $_SESSION['errors'] = [$result['message']];
            header('Location: index.php?action=register');
        }
        exit;
    }

    public function showLogin(): void {
        require_once __DIR__ . '/../View/user/login.php';
    }

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
            $errors[] = 'L\'adresse e-mail est requise.';
        }
        if ($password === '') {
            $errors[] = 'Le mot de passe est requis.';
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
            $_SESSION['errors'] = ['Cette connexion est réservée aux comptes administrateurs. Utilisez la connexion publique pour les candidats et les employeurs.'];
            header('Location: index.php?action=admin_login');
            exit;
        }

        $_SESSION['user_id']         = $user->id;
        $_SESSION['user_first_name'] = $user->first_name;
        $_SESSION['user_last_name']  = $user->last_name;
        $_SESSION['user_role']       = $user->role;
        $_SESSION['user_pic']        = $user->profile_pic;

        header('Location: index.php?action=admin_dashboard');
        exit;
    }

    public function login(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=login');
            exit;
        }

        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $fieldErrors = [];
        if (empty($email)) {
            $fieldErrors['email'] = 'L\'adresse e-mail est requise.';
        }
        if (empty($password)) {
            $fieldErrors['password'] = 'Le mot de passe est requis.';
        }

        if (!empty($fieldErrors)) {
            $_SESSION['field_errors'] = $fieldErrors;
            header('Location: index.php?action=login');
            exit;
        }

        $user = new User();
        $user->email    = $email;
        $user->password = $password;

        $result = $user->login();

        if ($result['success']) {
            $_SESSION['user_id']         = $user->id;
            $_SESSION['user_first_name'] = $user->first_name;
            $_SESSION['user_last_name']  = $user->last_name;
            $_SESSION['user_role']       = $user->role;
            $_SESSION['user_pic']        = $user->profile_pic;

            if ($user->role === 'admin') {
                header('Location: index.php?action=admin_dashboard');
            } elseif ($user->role === 'employer') {
                header('Location: index.php?action=dashboard_employer');
            } else {
                header('Location: index.php?action=dashboard_seeker');
            }
        } else {
            $_SESSION['errors'] = [$result['message']];
            header('Location: index.php?action=login');
        }
        exit;
    }

    public function showForgotPassword(): void {
        require_once __DIR__ . '/../View/user/forgot_password.php';
    }

    public function processForgotPassword(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=forgot_password');
            exit;
        }

        $email = trim($_POST['email'] ?? '');

        if (empty($email)) {
            $_SESSION['field_errors'] = ['email' => 'L\'adresse e-mail est requise.'];
            header('Location: index.php?action=forgot_password');
            exit;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['field_errors'] = ['email' => 'Format d\'e-mail invalide.'];
            header('Location: index.php?action=forgot_password');
            exit;
        }

        // En pratique, on générerait un token et on enverrait un email ici.
        // Pour ce projet, on affiche simplement un message de succès.
        $_SESSION['success'] = 'Si cette adresse existe, un email contenant les instructions a été envoyé.';
        header('Location: index.php?action=forgot_password');
        exit;
    }

    public function showProfile(): void {
        $this->requireLogin();
        $user = new User();
        $data = $user->getById((int) $_SESSION['user_id']);
        require_once __DIR__ . '/../View/user/profile.php';
    }

    public function updateProfile(): void {
        $this->requireLogin();

        $first_name = trim($_POST['first_name'] ?? '');
        $last_name  = trim($_POST['last_name'] ?? '');
        $phone      = trim($_POST['phone'] ?? '');

        $fieldErrors = [];
        if (empty($first_name)) {
            $fieldErrors['first_name'] = 'Le prénom est requis.';
        } elseif (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]{2,}$/', $first_name)) {
            $fieldErrors['first_name'] = 'Le prénom est invalide (lettres uniquement, min. 2 caractères).';
        }
        if (empty($last_name)) {
            $fieldErrors['last_name'] = 'Le nom est requis.';
        } elseif (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]{2,}$/', $last_name)) {
            $fieldErrors['last_name'] = 'Le nom est invalide (lettres uniquement, min. 2 caractères).';
        }
        if (!empty($phone) && !preg_match('/^\+?[0-9\s\-]{7,15}$/', $phone)) {
            $fieldErrors['phone'] = 'Le numéro de téléphone est invalide.';
        }

        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (!empty($new_password)) {
            if (strlen($new_password) < 8) {
                $fieldErrors['new_password'] = 'Le mot de passe doit comporter au moins 8 caractères.';
            } elseif (!preg_match('/[A-Z]/', $new_password)) {
                $fieldErrors['new_password'] = 'Le mot de passe doit contenir au moins une lettre majuscule.';
            } elseif (!preg_match('/[0-9]/', $new_password)) {
                $fieldErrors['new_password'] = 'Le mot de passe doit contenir au moins un chiffre.';
            }

            if ($new_password !== $confirm_password) {
                $fieldErrors['confirm_password'] = 'Les mots de passe ne correspondent pas.';
            }
        }

        if (!empty($fieldErrors)) {
            $_SESSION['field_errors'] = $fieldErrors;
            header('Location: index.php?action=profile');
            exit;
        }

        $user = new User();
        $user->id         = (int) $_SESSION['user_id'];
        $user->first_name = htmlspecialchars($first_name);
        $user->last_name  = htmlspecialchars($last_name);
        $user->phone      = htmlspecialchars($phone);
        $user->profile_pic = $_SESSION['user_pic'] ?? '';

        if (!empty($_FILES['profile_pic']['name'])) {
            $upload_dir = __DIR__ . '/../View/uploads/profile_pics/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $ext     = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($ext, $allowed)) {
                $_SESSION['errors'] = ['Seules les images JPG, PNG et GIF sont autorisées.'];
                header('Location: index.php?action=profile');
                exit;
            }

            if ($_FILES['profile_pic']['size'] > 2 * 1024 * 1024) {
                $_SESSION['errors'] = ['L\'image doit faire moins de 2 Mo.'];
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

            if (!empty($new_password)) {
                $pwdResult = $user->changePassword($new_password);
                if ($pwdResult['success']) {
                    $_SESSION['success'] .= ' ' . $pwdResult['message'];
                }
            }
        } else {
            $_SESSION['errors'] = [$result['message']];
        }

        header('Location: index.php?action=profile');
        exit;
    }

    public function logout(): void {
        session_destroy();
        header('Location: index.php?action=login');
        exit;
    }

    public function adminDashboard(): void {
        $this->requireAdmin();
        $userModel = new User();
        $stats     = $userModel->getStats();
        $pageTitle = 'Admin Dashboard';
        require_once __DIR__ . '/../View/admin/dashboard.php';
    }

    public function adminShowAddUser(): void {
        $this->requireAdmin();
        require_once __DIR__ . '/../View/admin/user_add.php';
    }

    public function adminAddUser(): void {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=admin_add_user');
            exit;
        }

        $first_name       = trim($_POST['first_name'] ?? '');
        $last_name        = trim($_POST['last_name'] ?? '');
        $email            = trim($_POST['email'] ?? '');
        $phone            = trim($_POST['phone'] ?? '');
        $role             = trim($_POST['role'] ?? '');
        $password         = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        $errors = $this->validateRegister(
            $first_name, $last_name, $email, $phone, $role, $password, $confirm_password
        );

        if (!empty($errors)) {
            $_SESSION['field_errors'] = $this->extractRegisterFieldErrors($errors);
            $_SESSION['old'] = [
                'first_name' => $first_name,
                'last_name'  => $last_name,
                'email'      => $email,
                'phone'      => $phone,
                'role'       => $role,
            ];
            header('Location: index.php?action=admin_add_user');
            exit;
        }

        $user = new User();
        $user->first_name = htmlspecialchars($first_name);
        $user->last_name  = htmlspecialchars($last_name);
        $user->email      = $email;
        $user->phone      = htmlspecialchars($phone);
        $user->role       = $role;
        $user->password   = $password;

        $result = $user->register();

        if ($result['success']) {
            $_SESSION['success'] = 'L\'utilisateur "' . htmlspecialchars($first_name . ' ' . $last_name) . '" a été créé avec succès.';
            header('Location: index.php?action=admin_users');
        } else {
            $_SESSION['errors'] = [$result['message']];
            header('Location: index.php?action=admin_add_user');
        }
        exit;
    }

    public function adminListUsers(): void {
        $this->requireAdmin();
        
        $search = trim($_GET['search'] ?? '');
        $sort   = trim($_GET['sort'] ?? 'created_at_desc');

        $user  = new User();
        $users = $user->getAll($search, $sort);
        
        require_once __DIR__ . '/../View/admin/users_list.php';
    }

    public function adminEditUser(): void {
        $this->requireAdmin();

        $id = (int) ($_GET['id'] ?? 0);

        $user = new User();
        $data = $user->getById($id);

        if (!$data) {
            $_SESSION['errors'] = ['Utilisateur non trouvé.'];
            header('Location: index.php?action=admin_users');
            exit;
        }

        if ($data['role'] === 'admin') {
            $_SESSION['errors'] = ['Les comptes administrateurs ne peuvent pas être modifiés.'];
            header('Location: index.php?action=admin_users');
            exit;
        }

        require_once __DIR__ . '/../View/admin/user_edit.php';
    }

    public function adminUpdateUser(): void {
        $this->requireAdmin();

        $id         = (int) ($_POST['id'] ?? 0);
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name  = trim($_POST['last_name'] ?? '');
        $phone      = trim($_POST['phone'] ?? '');
        $role       = trim($_POST['role'] ?? '');

        $fieldErrors = [];
        if (empty($first_name)) {
            $fieldErrors['first_name'] = 'Le prénom est requis.';
        }
        if (empty($last_name)) {
            $fieldErrors['last_name'] = 'Le nom est requis.';
        }
        if (!in_array($role, ['job_seeker', 'employer'])) {
            $fieldErrors['role'] = 'Rôle sélectionné invalide.';
        }

        if (!empty($fieldErrors)) {
            $_SESSION['field_errors'] = $fieldErrors;
            header('Location: index.php?action=admin_edit_user&id=' . $id);
            exit;
        }

        $user = new User();
        $user->id         = $id;
        $user->first_name = htmlspecialchars($first_name);
        $user->last_name  = htmlspecialchars($last_name);
        $user->phone      = htmlspecialchars($phone);
        $user->role       = $role;

        $result = $user->adminUpdate();

        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
        } else {
            $_SESSION['errors'] = [$result['message']];
        }

        header('Location: index.php?action=admin_users');
        exit;
    }

    public function adminDeleteUser(): void {
        $this->requireAdmin();

        $id = (int) ($_GET['id'] ?? 0);

        $user = new User();
        $user->deleteAccount($id);

        $_SESSION['success'] = 'Utilisateur supprimé avec succès.';
        header('Location: index.php?action=admin_users');
        exit;
    }

    private function requireLogin(): void {
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
    }

    private function requireAdmin(): void {
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?action=admin_login');
            exit;
        }
        if (($_SESSION['user_role'] ?? '') !== 'admin') {
            header('Location: index.php');
            exit;
        }
    }

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
            $errors[] = 'Le prénom est requis.';
        } elseif (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]{2,50}$/', $first_name)) {
            $errors[] = 'Le prénom doit contenir uniquement de 2 à 50 lettres.';
        }

        if (empty($last_name)) {
            $errors[] = 'Le nom est requis.';
        } elseif (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]{2,50}$/', $last_name)) {
            $errors[] = 'Le nom doit contenir uniquement de 2 à 50 lettres.';
        }

        if (empty($email)) {
            $errors[] = 'L\'adresse e-mail est requise.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Format d\'e-mail invalide.';
        }

        if (!empty($phone) && !preg_match('/^\+?[0-9\s\-]{7,15}$/', $phone)) {
            $errors[] = 'Le numéro de téléphone est invalide.';
        }

        if (!in_array($role, ['job_seeker', 'employer'])) {
            $errors[] = 'Veuillez sélectionner un rôle valide.';
        }

        if (empty($password)) {
            $errors[] = 'Le mot de passe est requis.';
        } elseif (strlen($password) < 8) {
            $errors[] = 'Le mot de passe doit comporter au moins 8 caractères.';
        } elseif (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Le mot de passe doit contenir au moins une lettre majuscule.';
        } elseif (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Le mot de passe doit contenir au moins un chiffre.';
        }

        if ($password !== $confirm_password) {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        }

        return $errors;
    }

    private function extractRegisterFieldErrors(array $errors): array {
        $fieldErrors = [];

        foreach ($errors as $error) {
            if (str_contains($error, 'prénom')) {
                $fieldErrors['first_name'] = $error;
                continue;
            }
            if (str_contains($error, 'nom est requis') || str_contains($error, 'Le nom doit')) {
                $fieldErrors['last_name'] = $error;
                continue;
            }
            if (str_contains($error, 'e-mail')) {
                $fieldErrors['email'] = $error;
                continue;
            }
            if (str_contains($error, 'téléphone')) {
                $fieldErrors['phone'] = $error;
                continue;
            }
            if (str_contains($error, 'rôle')) {
                $fieldErrors['role'] = $error;
                continue;
            }
            if (str_contains($error, 'mots de passe ne correspondent')) {
                $fieldErrors['confirm_password'] = $error;
                continue;
            }
            if (str_contains($error, 'mot de passe')) {
                $fieldErrors['password'] = $error;
            }
        }

        return $fieldErrors;
    }
}
