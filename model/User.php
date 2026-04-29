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
    public string $status = 'active';
    public int $two_factor_enabled = 0;
    public int $is_verified = 0;
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
            'SELECT id, first_name, last_name, email, password, role, profile_pic, status, two_factor_enabled, is_verified
             FROM users WHERE email = :email LIMIT 1'
        );
        $stmt->execute([':email' => $this->email]);
        $row = $stmt->fetch();

        if ($row !== false && password_verify($this->password, $row['password'])) {
            if ($row['status'] === 'suspended') {
                return ['success' => false, 'message' => 'Ce compte a été suspendu par un administrateur.'];
            }

            if ((int)$row['two_factor_enabled'] === 1) {
                return [
                    'success' => true, 
                    'requires_2fa' => true, 
                    'user_id' => (int)$row['id'],
                    'role' => $row['role'],
                    'is_verified' => (int)$row['is_verified']
                ];
            }

            $this->id          = (int) $row['id'];
            $this->first_name  = $row['first_name'];
            $this->last_name   = $row['last_name'];
            $this->role        = $row['role'];
            $this->profile_pic = $row['profile_pic'] ?? '';
            $this->status      = $row['status'];
            $this->two_factor_enabled = 0;
            $this->is_verified = (int)$row['is_verified'];

            $this->logConnection();

            return ['success' => true, 'requires_2fa' => false, 'message' => 'Connexion réussie.'];
        }

        return ['success' => false, 'message' => 'E-mail ou mot de passe invalide.'];
    }

    public function getById(int $id) {
        $stmt = $this->pdo->prepare(
            'SELECT id, first_name, last_name, email, phone, role, profile_pic, status, two_factor_enabled, is_verified, created_at
             FROM users WHERE id = :id LIMIT 1'
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function getAll(string $search = '', string $sort = 'created_at_desc'): array {
        $sql = "SELECT id, first_name, last_name, email, phone, role, status, is_verified, created_at
                FROM users WHERE role != 'admin'";
        
        $params = [];
        if ($search !== '') {
            $sql .= " AND (first_name LIKE :search1 OR last_name LIKE :search2 OR email LIKE :search3)";
            $searchTerm = '%' . $search . '%';
            $params[':search1'] = $searchTerm;
            $params[':search2'] = $searchTerm;
            $params[':search3'] = $searchTerm;
        }

        switch ($sort) {
            case 'name_asc':
                $sql .= " ORDER BY first_name ASC, last_name ASC";
                break;
            case 'name_desc':
                $sql .= " ORDER BY first_name DESC, last_name DESC";
                break;
            case 'role_asc':
                $sql .= " ORDER BY role ASC, created_at DESC";
                break;
            case 'role_desc':
                $sql .= " ORDER BY role DESC, created_at DESC";
                break;
            case 'created_at_asc':
                $sql .= " ORDER BY created_at ASC";
                break;
            case 'created_at_desc':
            default:
                $sql .= " ORDER BY created_at DESC";
                break;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
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

    public function selfDelete(string $password): array {
        $stmt = $this->pdo->prepare('SELECT password FROM users WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $this->id]);
        $row = $stmt->fetch();

        if ($row && password_verify($password, $row['password'])) {
            $stmt = $this->pdo->prepare('DELETE FROM users WHERE id=:id');
            $stmt->execute([':id' => $this->id]);
            return ['success' => true, 'message' => 'Votre compte a été supprimé définitivement.'];
        }

        return ['success' => false, 'message' => 'Mot de passe incorrect. Suppression annulée.'];
    }

    private function logConnection(): void {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
        $agent = substr($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown', 0, 250);
        $stmt = $this->pdo->prepare(
            'INSERT INTO login_history (user_id, ip_address, user_agent) VALUES (:uid, :ip, :ua)'
        );
        $stmt->execute([':uid' => $this->id, ':ip' => $ip, ':ua' => $agent]);
    }

    public function getLoginHistory(int $limit = 5): array {
        $stmt = $this->pdo->prepare(
            'SELECT ip_address, user_agent, login_time 
             FROM login_history 
             WHERE user_id = :uid 
             ORDER BY login_time DESC 
             LIMIT :limit'
        );
        // Execute with bindValue for LIMIT to avoid string quoting issues
        $stmt->bindValue(':uid', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function toggleStatus(int $id): array {
        $user = $this->getById($id);
        if (!$user) {
            return ['success' => false, 'message' => 'Utilisateur introuvable.'];
        }
        if ($user['role'] === 'admin') {
            return ['success' => false, 'message' => 'Impossible de suspendre un administrateur.'];
        }

        $newStatus = ($user['status'] === 'active') ? 'suspended' : 'active';
        $stmt = $this->pdo->prepare("UPDATE users SET status=:status WHERE id=:id");
        $stmt->execute([':status' => $newStatus, ':id' => $id]);

        $msg = ($newStatus === 'active') ? 'Compte réactivé avec succès.' : 'Compte suspendu avec succès.';
        return ['success' => true, 'message' => $msg];
    }

    public function toggle2FA(): array {
        $user = $this->getById($this->id);
        if (!$user) {
            return ['success' => false, 'message' => 'Utilisateur introuvable.'];
        }
        
        $newState = ((int)$user['two_factor_enabled'] === 1) ? 0 : 1;
        $stmt = $this->pdo->prepare("UPDATE users SET two_factor_enabled=:state WHERE id=:id");
        $stmt->execute([':state' => $newState, ':id' => $this->id]);

        $msg = ($newState === 1) ? 'Authentification à deux facteurs activée.' : 'Authentification à deux facteurs désactivée.';
        return ['success' => true, 'message' => $msg];
    }

    public function toggleVerification(int $id): array {
        $user = $this->getById($id);
        if (!$user) {
            return ['success' => false, 'message' => 'Utilisateur introuvable.'];
        }
        
        $newState = ((int)$user['is_verified'] === 1) ? 0 : 1;
        $stmt = $this->pdo->prepare("UPDATE users SET is_verified=:state WHERE id=:id");
        $stmt->execute([':state' => $newState, ':id' => $id]);

        $msg = ($newState === 1) ? 'Utilisateur certifié avec succès.' : 'Certification retirée.';
        return ['success' => true, 'message' => $msg];
    }

    public function getStats(): array {
        $stmt = $this->pdo->query(
            "SELECT role, COUNT(*) AS cnt FROM users WHERE role != 'admin' GROUP BY role"
        );
        $stats = ['job_seeker' => 0, 'employer' => 0, 'total' => 0, 'new_this_month' => 0];
        foreach ($stmt->fetchAll() as $row) {
            $stats[$row['role']] = (int) $row['cnt'];
            $stats['total']     += (int) $row['cnt'];
        }

        $stmtMonth = $this->pdo->query(
            "SELECT COUNT(*) AS new_this_month FROM users 
             WHERE role != 'admin' AND MONTH(created_at) = MONTH(CURRENT_DATE()) 
             AND YEAR(created_at) = YEAR(CURRENT_DATE())"
        );
        $monthRow = $stmtMonth->fetch();
        if ($monthRow) {
            $stats['new_this_month'] = (int) $monthRow['new_this_month'];
        }

        return $stats;
    }

    private function emailExists(): bool {
        $stmt = $this->pdo->prepare('SELECT id FROM users WHERE email=:email LIMIT 1');
        $stmt->execute([':email' => $this->email]);
        return $stmt->fetch() !== false;
    }
}
