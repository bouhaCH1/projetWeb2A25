<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name('WORKWAVESESSID');
    session_start();
}
require_once dirname(__DIR__, 2) . '/model/legacy/Database.php';
require_once dirname(__DIR__, 2) . '/model/legacy/PortfolioModel.php';

class AuthController {
    private $db;
    private $model;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->model = new PortfolioModel();
    }
    
    public function login() {
        if (isset($_SESSION['user'])) {
            $this->redirectByRole($_SESSION['user']['role']);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $errors = [];
            if (empty($username)) {
                $errors['username'] = "Le nom d'utilisateur est requis";
            }
            if (empty($password)) {
                $errors['password'] = "Le mot de passe est requis";
            }
            
            if (!empty($errors)) {
                require_once dirname(__DIR__, 2) . '/view/legacy/auth/login.php';
                return;
            }
            
            $sql = "SELECT
                        u.*,
                        COALESCE(fp.first_name, '') AS first_name,
                        COALESCE(fp.last_name, '') AS last_name,
                        cp.company_name
                    FROM users u
                    LEFT JOIN freelancer_profiles fp ON fp.user_id = u.id
                    LEFT JOIN company_profiles cp ON cp.user_id = u.id
                    WHERE u.email = :identifier_email
                       OR SUBSTRING_INDEX(u.email, '@', 1) = :identifier_name
                       OR (u.role = 'admin' AND :identifier_admin = 'admin')
                    LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $identifier = strtolower($username);
            $stmt->execute([
                ':identifier_email' => $identifier,
                ':identifier_name' => $identifier,
                ':identifier_admin' => $identifier,
            ]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password_hash'])) {
                $role = strtolower($user['role']);
                $legacyRole = $role === 'freelancer' ? 'candidat' : ($role === 'company' ? 'entreprise' : $role);
                $displayName = trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));
                if ($displayName === '') {
                    $displayName = $user['company_name'] ?: ($user['email'] ?? 'Utilisateur');
                }

                $_SESSION['user_id'] = (int)$user['id'];
                $_SESSION['role'] = $role;
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['email'],
                    'full_name' => $displayName,
                    'email' => $user['email'],
                    'company' => $user['company_name'] ?? '',
                    'role' => $legacyRole
                ];
                $this->redirectByRole($role);
                exit();
            } else {
                $error = "Identifiants invalides";
                require_once dirname(__DIR__, 2) . '/view/legacy/auth/login.php';
            }
        } else {
            require_once dirname(__DIR__, 2) . '/view/legacy/auth/login.php';
        }
    }
    
    private function redirectByRole($role) {
        $role = strtolower($role);
        if ($role === 'condidat') $role = 'candidat';
        if ($role === 'freelancer') $role = 'candidat';
        if ($role === 'company') $role = 'entreprise';
        switch($role) {
            case 'admin':
                header('Location: ../controller/index.php?r=admin');
                break;
            case 'candidat':
                header('Location: ../controller/index.php?r=freelancer');
                break;
            case 'entreprise':
                header('Location: ../controller/index.php?r=company');
                break;
            default:
                header('Location: ../controller/index.php?r=home');
        }
        exit();
    }
    
    public function logout() {
        session_destroy();
        header('Location: index.php');
        exit();
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ../controller/index.php?r=register-freelancer');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $target = ($_POST['role'] ?? 'candidat') === 'entreprise' ? 'register-company' : 'register-freelancer';
            header('Location: ../controller/index.php?r=' . $target);
            exit();

            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $full_name = $_POST['full_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $company = $_POST['company'] ?? '';
            $role = $_POST['role'] ?? 'candidat';
            
            $errors = [];
            
            if (empty($username)) $errors['username'] = "Nom d'utilisateur requis";
            if (strlen($password) < 4) $errors['password'] = "Mot de passe trop court (min 4 caractères)";
            if (empty($full_name)) $errors['full_name'] = "Nom complet requis";
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Email invalide";
            
            if (empty($errors)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (username, password, full_name, email, company, role) 
                        VALUES (:username, :password, :full_name, :email, :company, :role)";
                $stmt = $this->db->prepare($sql);
                
                try {
                    $stmt->execute([
                        ':username' => $username,
                        ':password' => $hashed_password,
                        ':full_name' => $full_name,
                        ':email' => $email,
                        ':company' => $company,
                        ':role' => $role
                    ]);
                    $_SESSION['message'] = "Inscription réussie ! Vous pouvez vous connecter.";
                    header('Location: index.php?action=login');
                    exit();
                } catch(PDOException $e) {
                    $error = "Ce nom d'utilisateur existe déjà";
                }
            }
        }
        
        require_once dirname(__DIR__, 2) . '/view/legacy/auth/register.php';
    }
}
?>

