<?php

require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/../Model/Job.php';

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
            $_SESSION['errors'] = $errors;
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

        $_SESSION['user_id']         = $user->id;
        $_SESSION['user_first_name'] = $user->first_name;
        $_SESSION['user_last_name']  = $user->last_name;
        $_SESSION['user_role']       = $user->role;
        $_SESSION['user_pic']        = $user->profile_pic;

        header('Location: index.php?action=admin_dashboard');
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
        if (empty($email)) {
            $errors[] = 'Email is required.';
        }
        if (empty($password)) {
            $errors[] = 'Password is required.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: index.php?action=login');
            exit;
        }

        $user = new User();
        $user->email    = $email;
        $user->password = $password;

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
            $_SESSION['errors'] = [$result['message']];
            header('Location: index.php?action=login');
        }
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

        $errors = [];
        if (empty($first_name)) {
            $errors[] = 'First name is required.';
        }
        if (empty($last_name)) {
            $errors[] = 'Last name is required.';
        }
        if (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]{2,}$/', $first_name)) {
            $errors[] = 'First name is invalid.';
        }
        if (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]{2,}$/', $last_name)) {
            $errors[] = 'Last name is invalid.';
        }
        if (!empty($phone) && !preg_match('/^\+?[0-9\s\-]{7,15}$/', $phone)) {
            $errors[] = 'Phone number is invalid.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
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
                $_SESSION['errors'] = ['Only JPG, PNG and GIF images are allowed.'];
                header('Location: index.php?action=profile');
                exit;
            }

            if ($_FILES['profile_pic']['size'] > 2 * 1024 * 1024) {
                $_SESSION['errors'] = ['Image must be under 2MB.'];
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
        $jobModel  = new Job();
        $stats     = $userModel->getStats();
        $jobCount  = $jobModel->countAll();
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
            $_SESSION['errors'] = $errors;
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
            $_SESSION['success'] = 'User "' . htmlspecialchars($first_name . ' ' . $last_name) . '" created successfully.';
            header('Location: index.php?action=admin_users');
        } else {
            $_SESSION['errors'] = [$result['message']];
            header('Location: index.php?action=admin_add_user');
        }
        exit;
    }

    public function adminListUsers(): void {
        $this->requireAdmin();
        $user  = new User();
        $users = $user->getAll();
        require_once __DIR__ . '/../View/admin/users_list.php';
    }

    public function adminEditUser(): void {
        $this->requireAdmin();

        $id = (int) ($_GET['id'] ?? 0);

        $user = new User();
        $data = $user->getById($id);

        if (!$data) {
            $_SESSION['errors'] = ['User not found.'];
            header('Location: index.php?action=admin_users');
            exit;
        }

        if ($data['role'] === 'admin') {
            $_SESSION['errors'] = ['Admin accounts cannot be edited.'];
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

        $errors = [];
        if (empty($first_name)) {
            $errors[] = 'First name is required.';
        }
        if (empty($last_name)) {
            $errors[] = 'Last name is required.';
        }
        if (!in_array($role, ['job_seeker', 'employer'])) {
            $errors[] = 'Invalid role selected.';
        }

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

        $_SESSION['success'] = 'User deleted successfully.';
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
