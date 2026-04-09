<?php
// Controller/UserController.php

require_once __DIR__ . '/../Model/User.php';

class UserController {

    // ════════════════════════════════════════════════════════════════════
    //  FRONT OFFICE
    // ════════════════════════════════════════════════════════════════════

    // ── Show Register page ───────────────────────────────────────────────
    public function showRegister(): void {
        require_once __DIR__ . '/../View/user/register.php';
    }

    // ── Handle Register submission ───────────────────────────────────────
    public function register(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=register');
            exit;
        }

        $first_name       = trim($_POST['first_name']   ?? '');
        $last_name        = trim($_POST['last_name']    ?? '');
        $email            = trim($_POST['email']        ?? '');
        $phone            = trim($_POST['phone']        ?? '');
        $role             = trim($_POST['role']         ?? '');
        $password         = $_POST['password']          ?? '';
        $confirm_password = $_POST['confirm_password']  ?? '';

        $errors = $this->validateRegister(
            $first_name, $last_name, $email, $phone, $role, $password, $confirm_password
        );

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old']    = compact('first_name','last_name','email','phone','role');
            header('Location: index.php?action=register');
            exit;
        }

        $user             = new User();
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

    // ── Show Login page ──────────────────────────────────────────────────
    public function showLogin(): void {
        require_once __DIR__ . '/../View/user/login.php';
    }

    // ── Handle Login submission ──────────────────────────────────────────
    public function login(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=login');
            exit;
        }

        $email    = trim($_POST['email']    ?? '');
        $password = $_POST['password']      ?? '';

        $errors = [];
        if (empty($email))    $errors[] = 'Email is required.';
        if (empty($password)) $errors[] = 'Password is required.';

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: index.php?action=login');
            exit;
        }

        $user           = new User();
        $user->email    = $email;
        $user->password = $password;
        $result         = $user->login();

        if ($result['success']) {
            $_SESSION['user_id']         = $user->id;
            $_SESSION['user_first_name'] = $user->first_name;
            $_SESSION['user_last_name']  = $user->last_name;
            $_SESSION['user_role']       = $user->role;
            $_SESSION['user_pic']        = $user->profile_pic;

            header($user->role === 'employer'
                ? 'Location: index.php?action=dashboard_employer'
                : 'Location: index.php?action=dashboard_seeker');
        } else {
            $_SESSION['errors'] = [$result['message']];
            header('Location: index.php?action=login');
        }
        exit;
    }

    // ── Show Profile page ─────────────────────────────────────────────────
    public function showProfile(): void {
        $this->requireLogin();
        $user = new User();
        $data = $user->getById($_SESSION['user_id']);
        require_once __DIR__ . '/../View/user/profile.php';
    }

    // ── Handle Profile update ─────────────────────────────────────────────
    public function updateProfile(): void {
        $this->requireLogin();

        $first_name = trim($_POST['first_name'] ?? '');
        $last_name  = trim($_POST['last_name']  ?? '');
        $phone      = trim($_POST['phone']      ?? '');

        $errors = [];
        if (empty($first_name))                        $errors[] = 'First name is required.';
        if (empty($last_name))                         $errors[] = 'Last name is required.';
        if (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]{2,}$/', $first_name)) $errors[] = 'First name is invalid.';
        if (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]{2,}$/', $last_name))  $errors[] = 'Last name is invalid.';
        if (!empty($phone) && !preg_match('/^\+?[0-9\s\-]{7,15}$/', $phone)) {
            $errors[] = 'Phone number is invalid.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: index.php?action=profile');
            exit;
        }

        $user             = new User();
        $user->id         = $_SESSION['user_id'];
        $user->first_name = htmlspecialchars($first_name);
        $user->last_name  = htmlspecialchars($last_name);
        $user->phone      = htmlspecialchars($phone);
        $user->profile_pic = $_SESSION['user_pic'] ?? '';

        // Handle file upload
        if (!empty($_FILES['profile_pic']['name'])) {
            $upload_dir = __DIR__ . '/../uploads/profile_pics/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

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
            $user->profile_pic = 'uploads/profile_pics/' . $filename;
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

    // ── Logout ─────────────────────────────────────────────────────────
    public function logout(): void {
        session_destroy();
        header('Location: index.php?action=login');
        exit;
    }

    // ════════════════════════════════════════════════════════════════════
    //  BACK OFFICE  (admin)
    // ════════════════════════════════════════════════════════════════════

    // ── List all users ───────────────────────────────────────────────────
    public function adminListUsers(): void {
        $this->requireLogin();
        $user  = new User();
        $users = $user->getAll();
        require_once __DIR__ . '/../View/admin/users_list.php';
    }

    // ── Show edit form for a user ────────────────────────────────────────
    public function adminEditUser(): void {
        $this->requireLogin();
        $id   = (int) ($_GET['id'] ?? 0);
        $user = new User();
        $data = $user->getById($id);
        if (!$data) {
            $_SESSION['errors'] = ['User not found.'];
            header('Location: index.php?action=admin_users');
            exit;
        }
        require_once __DIR__ . '/../View/admin/user_edit.php';
    }

    // ── Handle admin user update ─────────────────────────────────────────
    public function adminUpdateUser(): void {
        $this->requireLogin();

        $id         = (int) ($_POST['id']         ?? 0);
        $first_name = trim($_POST['first_name']   ?? '');
        $last_name  = trim($_POST['last_name']    ?? '');
        $phone      = trim($_POST['phone']        ?? '');
        $role       = trim($_POST['role']         ?? '');

        $errors = [];
        if (empty($first_name))                              $errors[] = 'First name is required.';
        if (empty($last_name))                               $errors[] = 'Last name is required.';
        if (!in_array($role, ['job_seeker', 'employer']))    $errors[] = 'Invalid role selected.';

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: index.php?action=admin_edit_user&id=' . $id);
            exit;
        }

        $user             = new User();
        $user->id         = $id;
        $user->first_name = htmlspecialchars($first_name);
        $user->last_name  = htmlspecialchars($last_name);
        $user->phone      = htmlspecialchars($phone);
        $user->role       = $role;
        $user->profile_pic = '';

        $result = $user->updateProfile();
        $_SESSION[$result['success'] ? 'success' : 'errors'] =
            $result['success'] ? $result['message'] : [$result['message']];

        header('Location: index.php?action=admin_users');
        exit;
    }

    // ── Handle admin user delete ─────────────────────────────────────────
    public function adminDeleteUser(): void {
        $this->requireLogin();
        $id   = (int) ($_GET['id'] ?? 0);
        $user = new User();
        $user->deleteAccount($id);
        $_SESSION['success'] = 'User deleted successfully.';
        header('Location: index.php?action=admin_users');
        exit;
    }

    // ════════════════════════════════════════════════════════════════════
    //  HELPERS
    // ════════════════════════════════════════════════════════════════════

    private function requireLogin(): void {
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
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

        if (empty($first_name))
            $errors[] = 'First name is required.';
        elseif (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]{2,50}$/', $first_name))
            $errors[] = 'First name must be 2–50 letters only.';

        if (empty($last_name))
            $errors[] = 'Last name is required.';
        elseif (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]{2,50}$/', $last_name))
            $errors[] = 'Last name must be 2–50 letters only.';

        if (empty($email))
            $errors[] = 'Email is required.';
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors[] = 'Invalid email format.';

        if (!empty($phone) && !preg_match('/^\+?[0-9\s\-]{7,15}$/', $phone))
            $errors[] = 'Phone number is invalid.';

        if (!in_array($role, ['job_seeker', 'employer']))
            $errors[] = 'Please select a valid role.';

        if (empty($password))
            $errors[] = 'Password is required.';
        elseif (strlen($password) < 8)
            $errors[] = 'Password must be at least 8 characters.';
        elseif (!preg_match('/[A-Z]/', $password))
            $errors[] = 'Password must contain at least one uppercase letter.';
        elseif (!preg_match('/[0-9]/', $password))
            $errors[] = 'Password must contain at least one number.';

        if ($password !== $confirm_password)
            $errors[] = 'Passwords do not match.';

        return $errors;
    }
}
?>
