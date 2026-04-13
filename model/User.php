<?php
// Model/User.php

require_once __DIR__ . '/Database.php';

class User {

    // ── Propriétés de l'utilisateur (Correspondent aux colonnes de la base de données) ──
    public int $id;
    public string $first_name;
    public string $last_name;
    public string $email;
    public string $password;
    public string $phone = '';
    public string $role = 'job_seeker'; // possible values: job_seeker | employer | admin
    public string $profile_pic = '';
    public string $created_at = '';

    // L'objet PDO pour faire le lien avec la base de données
    private PDO $pdo;

    // Le constructeur s'exécute automatiquement lors du "new User()"
    public function __construct() {
        // On récupère la connexion depuis database.php
        $this->pdo = getConnection();
    }

    // ── CREATE : Enregistrer un nouvel utilisateur ──────────────────────────────────────
    public function register(): array {
        // 1. On vérifie d'abord si l'email existe déjà dans la base
        if ($this->emailExists()) {
            return ['success' => false, 'message' => 'This email is already registered.'];
        }

        // 2. On sécurise le mot de passe avant de le sauvegarder (hachage)
        $hashed = password_hash($this->password, PASSWORD_BCRYPT);

        // 3. On prépare la requête SQL (utiliser prepare protège contre les requêtes pirates "injections SQL")
        $stmt = $this->pdo->prepare(
            "INSERT INTO users (first_name, last_name, email, password, phone, role)
             VALUES (:first_name, :last_name, :email, :password, :phone, :role)"
        );

        // 4. On exécute la requête en injectant les vraies valeurs
        $stmt->execute([
            ':first_name' => $this->first_name,
            ':last_name'  => $this->last_name,
            ':email'      => $this->email,
            ':password'   => $hashed,
            ':phone'      => $this->phone,
            ':role'       => $this->role,
        ]);

        // 5. On récupère l'ID que MySQL vient de générer et on l'assigne à l'utilisateur
        $this->id = (int) $this->pdo->lastInsertId();
        
        return ['success' => true, 'message' => 'Account created successfully.'];
    }

    // ── READ : Vérifier les identifiants pour la connexion ──────────────────────────────
    public function login(): array {
        // 1. On cherche l'utilisateur via son adresse e-mail
        $stmt = $this->pdo->prepare(
            "SELECT id, first_name, last_name, email, password, role, profile_pic
             FROM users WHERE email = :email LIMIT 1"
        );
        $stmt->execute([':email' => $this->email]);
        $row = $stmt->fetch();

        // 2. Si on trouve une ligne, on vérifie si le mot de passe tapé correspond au mot de passe haché
        if ($row !== false && password_verify($this->password, $row['password'])) {
            // Le mot de passe est bon, on remplit les informations de l'utilisateur
            $this->id          = (int) $row['id'];
            $this->first_name  = $row['first_name'];
            $this->last_name   = $row['last_name'];
            $this->role        = $row['role'];
            
            // Si la photo de profil existe on la prend, sinon on met du vide
            $this->profile_pic = $row['profile_pic'] ?? '';

            return ['success' => true, 'message' => 'Login successful.'];
        }

        // Si l'e-mail n'existe pas ou que le mot de passe est faux
        return ['success' => false, 'message' => 'Invalid email or password.'];
    }

    // ── READ : Récupérer toutes les infos d'un utilisateur par son ID ────────────────────
    public function getById(int $id) {
        $stmt = $this->pdo->prepare(
            "SELECT id, first_name, last_name, email, phone, role, profile_pic, created_at
             FROM users WHERE id = :id LIMIT 1"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // ── READ : Récupérer tous les utilisateurs (pour le tableau de bord Admin) ───────────
    // Note: On exclut les comptes admin de la liste pour les protéger.
    public function getAll(): array {
        $stmt = $this->pdo->query(
            "SELECT id, first_name, last_name, email, phone, role, created_at
             FROM users WHERE role != 'admin' ORDER BY created_at DESC"
        );
        return $stmt->fetchAll();
    }

    // ── UPDATE : Mettre à jour le profil de l'utilisateur (front-office) ───────────────────
    public function updateProfile(): array {
        $stmt = $this->pdo->prepare(
            "UPDATE users SET first_name=:first_name, last_name=:last_name,
             phone=:phone, profile_pic=:profile_pic WHERE id=:id"
        );

        $stmt->execute([
            ':first_name'  => $this->first_name,
            ':last_name'   => $this->last_name,
            ':phone'       => $this->phone,
            ':profile_pic' => $this->profile_pic,
            ':id'          => $this->id,
        ]);

        return ['success' => true, 'message' => 'Profile updated successfully.'];
    }

    // ── UPDATE : Modification des données d'un utilisateur par l'admin (back-office) ──────
    // Seuls les rôles non-admin peuvent être mis à jour ici.
    public function adminUpdate(): array {
        // Vérifier que le compte cible n'est pas un admin (sécurité supplémentaire)
        $check = $this->pdo->prepare("SELECT role FROM users WHERE id=:id LIMIT 1");
        $check->execute([':id' => $this->id]);
        $existing = $check->fetch();

        if (!$existing || $existing['role'] === 'admin') {
            return ['success' => false, 'message' => 'Cannot modify an admin account.'];
        }

        $stmt = $this->pdo->prepare(
            "UPDATE users SET first_name=:first_name, last_name=:last_name,
             phone=:phone, role=:role WHERE id=:id AND role != 'admin'"
        );

        $stmt->execute([
            ':first_name' => $this->first_name,
            ':last_name'  => $this->last_name,
            ':phone'      => $this->phone,
            ':role'       => $this->role,
            ':id'         => $this->id,
        ]);

        return ['success' => true, 'message' => 'User updated successfully.'];
    }

    // ── UPDATE : Changer le mot de passe ─────────────────────────────────────────────────
    public function changePassword(string $new_password): array {
        $hashed = password_hash($new_password, PASSWORD_BCRYPT);
        $stmt   = $this->pdo->prepare("UPDATE users SET password=:password WHERE id=:id");
        $stmt->execute([':password' => $hashed, ':id' => $this->id]);
        return ['success' => true, 'message' => 'Password changed successfully.'];
    }

    // ── DELETE : Supprimer un compte (les admins sont protégés) ─────────────────────────────
    public function deleteAccount(int $id): array {
        // On ne supprime jamais un compte admin
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id=:id AND role != 'admin'");
        $stmt->execute([':id' => $id]);
        return ['success' => true, 'message' => 'Account deleted.'];
    }

    // ── Fonction interne : Vérifier si l'email existe pour éviter les doublons ───────────
    private function emailExists(): bool {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email=:email LIMIT 1");
        $stmt->execute([':email' => $this->email]);
        $result = $stmt->fetch();
        
        // Retourne true si l'email existe, sinon false
        return $result !== false;
    }
}
?>
