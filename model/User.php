<?php
// Model/User.php

require_once __DIR__ . '/../config/database.php';

class User {

    // ── Properties ──────────────────────────────────────────────────────
    public int    $id;
    public string $first_name;
    public string $last_name;
    public string $email;
    public string $password;
    public string $phone       = '';
    public string $role        = 'job_seeker';
    public string $profile_pic = '';
    public string $created_at  = '';

    private PDO $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    // ── CREATE: Register a new user ──────────────────────────────────────
    public function register(): array {
        if ($this->emailExists()) {
            return ['success' => false, 'message' => 'This email is already registered.'];
        }

        $hashed = password_hash($this->password, PASSWORD_BCRYPT);

        $stmt = $this->pdo->prepare(
            "INSERT INTO users (first_name, last_name, email, password, phone, role)
             VALUES (:first_name, :last_name, :email, :password, :phone, :role)"
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
        return ['success' => true, 'message' => 'Account created successfully.'];
    }

    // ── READ: Verify credentials for login ──────────────────────────────
    public function login(): array {
        $stmt = $this->pdo->prepare(
            "SELECT id, first_name, last_name, email, password, role, profile_pic
             FROM users WHERE email = :email LIMIT 1"
        );
        $stmt->execute([':email' => $this->email]);
        $row = $stmt->fetch();

        if ($row && password_verify($this->password, $row['password'])) {
            $this->id          = (int) $row['id'];
            $this->first_name  = $row['first_name'];
            $this->last_name   = $row['last_name'];
            $this->role        = $row['role'];
            $this->profile_pic = $row['profile_pic'] ?? '';
            return ['success' => true, 'message' => 'Login successful.'];
        }

        return ['success' => false, 'message' => 'Invalid email or password.'];
    }

    // ── READ: Get user by ID ─────────────────────────────────────────────
    public function getById(int $id): array|false {
        $stmt = $this->pdo->prepare(
            "SELECT id, first_name, last_name, email, phone, role, profile_pic, created_at
             FROM users WHERE id = :id LIMIT 1"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // ── READ: Get all users (Back Office) ────────────────────────────────
    public function getAll(): array {
        $stmt = $this->pdo->query(
            "SELECT id, first_name, last_name, email, phone, role, created_at FROM users ORDER BY created_at DESC"
        );
        return $stmt->fetchAll();
    }

    // ── UPDATE: Update profile ───────────────────────────────────────────
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

    // ── UPDATE: Change password ──────────────────────────────────────────
    public function changePassword(string $new_password): array {
        $hashed = password_hash($new_password, PASSWORD_BCRYPT);
        $stmt   = $this->pdo->prepare("UPDATE users SET password=:password WHERE id=:id");
        $stmt->execute([':password' => $hashed, ':id' => $this->id]);
        return ['success' => true, 'message' => 'Password changed successfully.'];
    }

    // ── DELETE: Delete a user ────────────────────────────────────────────
    public function deleteAccount(int $id): array {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id=:id");
        $stmt->execute([':id' => $id]);
        return ['success' => true, 'message' => 'Account deleted.'];
    }

    // ── HELPER: Check if email already exists ────────────────────────────
    private function emailExists(): bool {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email=:email LIMIT 1");
        $stmt->execute([':email' => $this->email]);
        return (bool) $stmt->fetch();
    }
}
?>
