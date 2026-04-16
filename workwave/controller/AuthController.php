<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once dirname(__DIR__) . '/model/Database.php';

class AuthController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Afficher le formulaire de connexion et traiter la connexion
    public function login() {
        // Si déjà connecté, rediriger vers dashboard
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
            header('Location: index.php?action=back-dashboard');
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // Validation manuelle (pas de HTML5)
            $errors = [];
            if (empty($username)) {
                $errors['username'] = "Le nom d'utilisateur est requis";
            }
            if (empty($password)) {
                $errors['password'] = "Le mot de passe est requis";
            }
            
            if (!empty($errors)) {
                require_once dirname(__DIR__) . '/view/backoffice/login.php';
                return;
            }
            
            // Recherche de l'utilisateur
            $sql = "SELECT * FROM users WHERE username = :username";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch();
            
            // Vérification du mot de passe (admin123)
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role']
                ];
                header('Location: index.php?action=back-dashboard');
                exit();
            } else {
                $error = "Identifiants invalides";
                require_once dirname(__DIR__) . '/view/backoffice/login.php';
            }
        } else {
            require_once dirname(__DIR__) . '/view/backoffice/login.php';
        }
    }
    
    // Déconnexion
    public function logout() {
        session_destroy();
        header('Location: index.php?action=login');
        exit();
    }
}
?>