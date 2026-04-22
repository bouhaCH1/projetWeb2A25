<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once dirname(__DIR__) . '/model/Database.php';
require_once dirname(__DIR__) . '/model/PortfolioModel.php';

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
                require_once dirname(__DIR__) . '/view/auth/login.php';
                return;
            }
            
            $sql = "SELECT * FROM users WHERE username = :username";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'full_name' => $user['full_name'],
                    'email' => $user['email'],
                    'company' => $user['company'],
                    'role' => strtolower($user['role'])
                ];
                $this->redirectByRole($user['role']);
                exit();
            } else {
                $error = "Identifiants invalides";
                require_once dirname(__DIR__) . '/view/auth/login.php';
            }
        } else {
            require_once dirname(__DIR__) . '/view/auth/login.php';
        }
    }
    
    private function redirectByRole($role) {
        $role = strtolower($role);
        if ( $role === 'condidat') $role = 'candidat';
        switch($role) {
            case 'admin':
                header('Location: index.php?action=admin-dashboard');
                break;
            case 'candidat':
                header('Location: index.php?action=candidat-dashboard');
                break;
            case 'entreprise':
                header('Location: index.php?action=entreprise-dashboard');
                break;
            default:
                header('Location: index.php');
        }
        exit();
    }
    
    public function logout() {
        session_destroy();
        header('Location: index.php');
        exit();
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        
        require_once dirname(__DIR__) . '/view/auth/register.php';
    }
}
?>