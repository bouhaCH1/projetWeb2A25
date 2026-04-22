<?php

require_once __DIR__ . '/Database.php';

class User {

    public int $id;
    public string $first_name;
    public string $last_name;
    public string $email;
    public string $password;
    public string $phone = '';
    public string $role = 'job_seeker';
    public string $profile_pic = '';
    public string $created_at = '';

    private PDO $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    public function register(): array {
        if ($this->emailExists()) {
            return ['success' => false, 'message' => 'Cette adresse e-mail est déjà enregistrée.'];
        }

        $hashed = password_hash($this->password, PASSWORD_BCRYPT);

        $stmt = $this->pdo->prepare(
            'INSERT INTO users (first_name, last_name, email, password, phone, role)
             VALUES (:first_name, :last_name, :email, :password, :phone, :role)'
        );

        $stmt->execute([
            ':first_name' => $this->first_name,
            ':last_name'  => $this->last_name,
            ':email'      => $this->email,
            ':password'   => $hashed,
            ':phone'      => $this->phone,
            ':role'       => $this->role,
        ]);

        $this->id = (int) $this->pdo->lastInsertId();

        return ['success' => true, 'message' => 'Compte créé avec succès.'];
    }

    public function login(): array {
        $stmt = $this->pdo->prepare(
            'SELECT id, first_name, last_name, email, password, role, profile_pic
             FROM users WHERE email = :email LIMIT 1'
        );
        $stmt->execute([':email' => $this->email]);
        $row = $stmt->fetch();

        if ($row !== false && password_verify($this->password, $row['password'])) {
            $this->id          = (int) $row['id'];
            $this->first_name  = $row['first_name'];
            $this->last_name   = $row['last_name'];
            $this->role        = $row['role'];
            $this->profile_pic = $row['profile_pic'] ?? '';

            return ['success' => true, 'message' => 'Connexion réussie.'];
        }

        return ['success' => false, 'message' => 'E-mail ou mot de passe invalide.'];
    }

    public function getById(int $id) {
        $stmt = $this->pdo->prepare(
            'SELECT id, first_name, last_name, email, phone, role, profile_pic, created_at
             FROM users WHERE id = :id LIMIT 1'
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function getAll(): array {
        $stmt = $this->pdo->query(
            "SELECT id, first_name, last_name, email, phone, role, created_at
             FROM users WHERE role != 'admin' ORDER BY created_at DESC"
        );
        return $stmt->fetchAll();
    }

    public function updateProfile(): array {
        $stmt = $this->pdo->prepare(
            'UPDATE users SET first_name=:first_name, last_name=:last_name,
             phone=:phone, profile_pic=:profile_pic WHERE id=:id'
        );

        $stmt->execute([
            ':first_name'  => $this->first_name,
            ':last_name'   => $this->last_name,
            ':phone'       => $this->phone,
            ':profile_pic' => $this->profile_pic,
            ':id'          => $this->id,
        ]);

        return ['success' => true, 'message' => 'Profil mis à jour avec succès.'];
    }

    public function adminUpdate(): array {
        $check = $this->pdo->prepare('SELECT role FROM users WHERE id=:id LIMIT 1');
        $check->execute([':id' => $this->id]);
        $existing = $check->fetch();

        if (!$existing || $existing['role'] === 'admin') {
            return ['success' => false, 'message' => 'Impossible de modifier un compte administrateur.'];
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

        return ['success' => true, 'message' => 'Utilisateur mis à jour avec succès.'];
    }

    public function changePassword(string $new_password): array {
        $hashed = password_hash($new_password, PASSWORD_BCRYPT);
        $stmt   = $this->pdo->prepare('UPDATE users SET password=:password WHERE id=:id');
        $stmt->execute([':password' => $hashed, ':id' => $this->id]);
        return ['success' => true, 'message' => 'Mot de passe modifié avec succès.'];
    }

    public function deleteAccount(int $id): array {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id=:id AND role != 'admin'");
        $stmt->execute([':id' => $id]);
        return ['success' => true, 'message' => 'Compte supprimé.'];
    }

    /**
     * Returns counts of non-admin users grouped by role.
     * Used by the admin dashboard overview.
     */
    public function getStats(): array {
        $stmt = $this->pdo->query(
            "SELECT role, COUNT(*) AS cnt FROM users WHERE role != 'admin' GROUP BY role"
        );
        $stats = ['job_seeker' => 0, 'employer' => 0, 'total' => 0];
        foreach ($stmt->fetchAll() as $row) {
            $stats[$row['role']] = (int) $row['cnt'];
            $stats['total']     += (int) $row['cnt'];
        }
        return $stats;
    }

    private function emailExists(): bool {
        $stmt = $this->pdo->prepare('SELECT id FROM users WHERE email=:email LIMIT 1');
        $stmt->execute([':email' => $this->email]);
        return $stmt->fetch() !== false;
    }
}
