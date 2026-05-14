<?php
declare(strict_types=1);

require_once __DIR__ . '/PortfolioDatabase.php';

final class PortfolioWorkwaveModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = PortfolioDatabase::pdo();
    }

    public function userByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public function userById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function userByRememberToken(string $selector): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE remember_selector = ? AND remember_expires_at > NOW() LIMIT 1');
        $stmt->execute([$selector]);
        return $stmt->fetch() ?: null;
    }

    public function setRememberToken(int $id, string $selector, string $validatorHash): void
    {
        $stmt = $this->db->prepare('UPDATE users SET remember_selector = ?, remember_validator_hash = ?, remember_expires_at = DATE_ADD(NOW(), INTERVAL 30 DAY) WHERE id = ?');
        $stmt->execute([$selector, $validatorHash, $id]);
    }

    public function clearRememberToken(int $id): void
    {
        $stmt = $this->db->prepare('UPDATE users SET remember_selector = NULL, remember_validator_hash = NULL, remember_expires_at = NULL WHERE id = ?');
        $stmt->execute([$id]);
    }

    public function createUser(string $role, string $email, string $password, array $profile): int
    {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare('INSERT INTO users(role,email,password_hash,status,created_at) VALUES(?,?,?,?,NOW())');
            $stmt->execute([$role, $email, password_hash($password, PASSWORD_DEFAULT), 'active']);
            $userId = (int)$this->db->lastInsertId();

            if ($role === 'freelancer') {
                $stmt = $this->db->prepare('INSERT INTO freelancer_profiles(user_id,first_name,last_name,phone,address,city,governorate,bio,linkedin,github,website,qr_token,lat,lng) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
                $stmt->execute([
                    $userId,
                    $profile['first_name'] ?? '',
                    $profile['last_name'] ?? '',
                    $profile['phone'] ?? '',
                    $profile['address'] ?? '',
                    $profile['city'] ?? '',
                    $profile['governorate'] ?? '',
                    $profile['bio'] ?? '',
                    $profile['linkedin'] ?? '',
                    $profile['github'] ?? '',
                    $profile['website'] ?? '',
                    bin2hex(random_bytes(16)),
                    $profile['lat'] ?? 36.8065,
                    $profile['lng'] ?? 10.1815,
                ]);
            }

            if ($role === 'company') {
                $stmt = $this->db->prepare('INSERT INTO company_profiles(user_id,company_name,description,industry,address,city,governorate,email,phone,website,lat,lng) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)');
                $stmt->execute([
                    $userId,
                    $profile['company_name'] ?? '',
                    $profile['description'] ?? '',
                    $profile['industry'] ?? '',
                    $profile['address'] ?? '',
                    $profile['city'] ?? '',
                    $profile['governorate'] ?? '',
                    $email,
                    $profile['phone'] ?? '',
                    $profile['website'] ?? '',
                    $profile['lat'] ?? 36.8065,
                    $profile['lng'] ?? 10.1815,
                ]);
            }

            $this->log($userId, 'auth.register', "Registered {$role} account");
            $this->db->commit();
            return $userId;
        } catch (Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function updateFreelancer(int $userId, array $data): void
    {
        $sql = 'UPDATE freelancer_profiles SET first_name=?,last_name=?,phone=?,address=?,city=?,governorate=?,bio=?,linkedin=?,github=?,website=?,lat=?,lng=? WHERE user_id=?';
        $this->db->prepare($sql)->execute([
            $data['first_name'] ?? '', $data['last_name'] ?? '', $data['phone'] ?? '', $data['address'] ?? '',
            $data['city'] ?? '', $data['governorate'] ?? '', $data['bio'] ?? '', $data['linkedin'] ?? '',
            $data['github'] ?? '', $data['website'] ?? '', $data['lat'] ?? null, $data['lng'] ?? null, $userId,
        ]);
        $this->log($userId, 'profile.update', 'Updated freelancer profile');
    }

    public function updateCompany(int $userId, array $data): void
    {
        $sql = 'UPDATE company_profiles SET company_name=?,description=?,industry=?,address=?,city=?,governorate=?,email=?,phone=?,website=?,lat=?,lng=? WHERE user_id=?';
        $this->db->prepare($sql)->execute([
            $data['company_name'] ?? '', $data['description'] ?? '', $data['industry'] ?? '', $data['address'] ?? '',
            $data['city'] ?? '', $data['governorate'] ?? '', $data['email'] ?? '', $data['phone'] ?? '',
            $data['website'] ?? '', $data['lat'] ?? null, $data['lng'] ?? null, $userId,
        ]);
        $this->log($userId, 'profile.update', 'Updated company profile');
    }

    public function setProfileFile(int $userId, string $role, string $field, string $path): void
    {
        $table = $role === 'company' ? 'company_profiles' : 'freelancer_profiles';
        $allowed = $role === 'company' ? ['logo_path'] : ['avatar_path', 'cv_path'];
        if (!in_array($field, $allowed, true)) {
            throw new InvalidArgumentException('Invalid file field');
        }
        $this->db->prepare("UPDATE {$table} SET {$field}=? WHERE user_id=?")->execute([$path, $userId]);
    }

    public function freelancerByUser(int $userId): ?array
    {
        $stmt = $this->db->prepare('SELECT u.email,u.status,p.* FROM users u JOIN freelancer_profiles p ON p.user_id=u.id WHERE u.id=?');
        $stmt->execute([$userId]);
        return $stmt->fetch() ?: null;
    }

    public function companyByUser(int $userId): ?array
    {
        $stmt = $this->db->prepare('SELECT u.email AS login_email,u.status,p.* FROM users u JOIN company_profiles p ON p.user_id=u.id WHERE u.id=?');
        $stmt->execute([$userId]);
        return $stmt->fetch() ?: null;
    }

    public function publicFreelancer(string $token): ?array
    {
        $stmt = $this->db->prepare('SELECT u.email,p.* FROM users u JOIN freelancer_profiles p ON p.user_id=u.id WHERE p.qr_token=? AND u.status="active"');
        $stmt->execute([$token]);
        $profile = $stmt->fetch();
        if (!$profile) {
            return null;
        }
        $this->db->prepare('UPDATE freelancer_profiles SET profile_views = profile_views + 1 WHERE id = ?')->execute([$profile['id']]);
        $profile['skills'] = $this->skills((int)$profile['user_id']);
        $profile['diplomas'] = $this->diplomas((int)$profile['user_id']);
        $profile['certificates'] = $this->certificates((int)$profile['user_id']);
        $profile['projects'] = $this->projects((int)$profile['user_id']);
        $profile['applications'] = $this->freelancerApplications((int)$profile['user_id']);
        return $profile;
    }

    public function addSkill(int $userId, array $data): void
    {
        $this->db->prepare('INSERT INTO freelancer_skills(user_id,name,category,level) VALUES(?,?,?,?)')
            ->execute([$userId, $data['name'], $data['category'], (int)$data['level']]);
    }

    public function deleteOwned(string $table, int $id, int $userId): void
    {
        $allowed = ['freelancer_skills', 'diplomas', 'certificates', 'portfolio_projects', 'saved_jobs'];
        if (!in_array($table, $allowed, true)) {
            throw new InvalidArgumentException('Invalid table');
        }
        $this->db->prepare("DELETE FROM {$table} WHERE id=? AND user_id=?")->execute([$id, $userId]);
    }

    public function skills(int $userId): array
    {
        return $this->rows('SELECT * FROM freelancer_skills WHERE user_id=? ORDER BY category,name', [$userId]);
    }

    public function addDiploma(int $userId, array $data): void
    {
        $this->db->prepare('INSERT INTO diplomas(user_id,title,institution,graduation_year) VALUES(?,?,?,?)')
            ->execute([$userId, $data['title'], $data['institution'], (int)$data['graduation_year']]);
    }

    public function diplomas(int $userId): array
    {
        return $this->rows('SELECT * FROM diplomas WHERE user_id=? ORDER BY graduation_year DESC', [$userId]);
    }

    public function addCertificate(int $userId, string $title, string $path): void
    {
        $this->db->prepare('INSERT INTO certificates(user_id,title,file_path,created_at) VALUES(?,?,?,NOW())')->execute([$userId, $title, $path]);
    }

    public function updateCertificateTitle(int $userId, int $id, string $title): void
    {
        $this->db->prepare('UPDATE certificates SET title=? WHERE user_id=? AND id=?')->execute([$title, $userId, $id]);
    }

    public function certificates(int $userId): array
    {
        return $this->rows('SELECT * FROM certificates WHERE user_id=? ORDER BY created_at DESC', [$userId]);
    }

    public function addProject(int $userId, array $data, ?string $imagePath): void
    {
        $this->db->prepare('INSERT INTO portfolio_projects(user_id,title,description,technologies,github_url,demo_url,image_path,created_at) VALUES(?,?,?,?,?,?,?,NOW())')
            ->execute([$userId, $data['title'], $data['description'], $data['technologies'], $data['github_url'], $data['demo_url'], $imagePath]);
    }

    public function projects(int $userId): array
    {
        return $this->rows('SELECT * FROM portfolio_projects WHERE user_id=? ORDER BY created_at DESC', [$userId]);
    }

    public function upsertJob(int $companyUserId, array $data, ?int $jobId = null): int
    {
        $company = $this->companyByUser($companyUserId);
        if (!$company) {
            throw new RuntimeException('Company profile missing');
        }
        if ($jobId) {
            $sql = 'UPDATE jobs SET title=?,description=?,required_skills=?,salary=?,location=?,contract_type=?,experience_level=?,category=?,expiration_date=? WHERE id=? AND company_id=?';
            $this->db->prepare($sql)->execute([$data['title'], $data['description'], $data['required_skills'], $data['salary'], $data['location'], $data['contract_type'], $data['experience_level'], $data['category'], $data['expiration_date'], $jobId, $company['id']]);
            return $jobId;
        }
        $sql = 'INSERT INTO jobs(company_id,title,description,required_skills,salary,location,contract_type,experience_level,category,expiration_date,status,created_at) VALUES(?,?,?,?,?,?,?,?,?,?,"open",NOW())';
        $this->db->prepare($sql)->execute([$company['id'], $data['title'], $data['description'], $data['required_skills'], $data['salary'], $data['location'], $data['contract_type'], $data['experience_level'], $data['category'], $data['expiration_date']]);
        $id = (int)$this->db->lastInsertId();
        $this->log($companyUserId, 'job.create', 'Created job ' . $data['title']);
        return $id;
    }

    public function setJobStatus(int $companyUserId, int $jobId, string $status): void
    {
        $company = $this->companyByUser($companyUserId);
        $this->db->prepare('UPDATE jobs SET status=? WHERE id=? AND company_id=?')->execute([$status, $jobId, $company['id'] ?? 0]);
    }

    public function deleteJob(int $companyUserId, int $jobId): void
    {
        $company = $this->companyByUser($companyUserId);
        $this->db->prepare('DELETE FROM jobs WHERE id=? AND company_id=?')->execute([$jobId, $company['id'] ?? 0]);
    }

    public function jobs(array $filters = []): array
    {
        $where = ['j.deleted_at IS NULL'];
        $args = [];
        if (!empty($filters['q'])) {
            $where[] = '(j.title LIKE ? OR j.description LIKE ? OR j.required_skills LIKE ?)';
            $q = '%' . $filters['q'] . '%';
            array_push($args, $q, $q, $q);
        }
        foreach (['category', 'contract_type', 'location'] as $field) {
            if (!empty($filters[$field])) {
                $where[] = "j.{$field} = ?";
                $args[] = $filters[$field];
            }
        }
        if (!empty($filters['salary_min'])) {
            $where[] = 'j.salary >= ?';
            $args[] = (float)$filters['salary_min'];
        }
        $sql = 'SELECT j.*,c.company_name,c.logo_path,c.industry FROM jobs j JOIN company_profiles c ON c.id=j.company_id WHERE ' . implode(' AND ', $where) . ' ORDER BY j.created_at DESC LIMIT 100';
        return $this->rows($sql, $args);
    }

    public function companyJobs(int $companyUserId): array
    {
        $company = $this->companyByUser($companyUserId);
        return $this->rows('SELECT * FROM jobs WHERE company_id=? ORDER BY created_at DESC', [$company['id'] ?? 0]);
    }

    public function apply(int $userId, int $jobId, string $message): void
    {
        $profile = $this->freelancerByUser($userId);
        $stmt = $this->db->prepare('INSERT IGNORE INTO applications(job_id,freelancer_id,message,status,created_at) VALUES(?,?,?,"pending",NOW())');
        $stmt->execute([$jobId, $profile['id'], $message]);
        $this->notify($userId, 'Application sent', 'Your application was submitted.');
    }

    public function saveJob(int $userId, int $jobId): void
    {
        $this->db->prepare('INSERT IGNORE INTO saved_jobs(user_id,job_id,created_at) VALUES(?,?,NOW())')->execute([$userId, $jobId]);
    }

    public function freelancerApplications(int $userId): array
    {
        $profile = $this->freelancerByUser($userId);
        return $this->rows('SELECT a.*,j.title,c.company_name FROM applications a JOIN jobs j ON j.id=a.job_id JOIN company_profiles c ON c.id=j.company_id WHERE a.freelancer_id=? ORDER BY a.created_at DESC', [$profile['id'] ?? 0]);
    }

    public function companyApplications(int $companyUserId): array
    {
        $company = $this->companyByUser($companyUserId);
        return $this->rows('SELECT a.*,j.title,fp.first_name,fp.last_name,fp.city,fp.qr_token,u.email FROM applications a JOIN jobs j ON j.id=a.job_id JOIN freelancer_profiles fp ON fp.id=a.freelancer_id JOIN users u ON u.id=fp.user_id WHERE j.company_id=? ORDER BY a.created_at DESC', [$company['id'] ?? 0]);
    }

    public function setApplicationStatus(int $companyUserId, int $applicationId, string $status): void
    {
        $company = $this->companyByUser($companyUserId);
        $stmt = $this->db->prepare('UPDATE applications a JOIN jobs j ON j.id=a.job_id SET a.status=? WHERE a.id=? AND j.company_id=?');
        $stmt->execute([$status, $applicationId, $company['id'] ?? 0]);
    }

    public function freelancerStats(int $userId): array
    {
        $profile = $this->freelancerByUser($userId);
        $fid = (int)($profile['id'] ?? 0);
        return [
            'total' => $this->count('SELECT COUNT(*) FROM applications WHERE freelancer_id=?', [$fid]),
            'accepted' => $this->count('SELECT COUNT(*) FROM applications WHERE freelancer_id=? AND status="accepted"', [$fid]),
            'pending' => $this->count('SELECT COUNT(*) FROM applications WHERE freelancer_id=? AND status="pending"', [$fid]),
            'rejected' => $this->count('SELECT COUNT(*) FROM applications WHERE freelancer_id=? AND status="rejected"', [$fid]),
            'completed' => $this->count('SELECT COUNT(*) FROM portfolio_projects WHERE user_id=?', [$userId]),
            'views' => (int)($profile['profile_views'] ?? 0),
        ];
    }

    public function adminStats(): array
    {
        return [
            'freelancers' => $this->count('SELECT COUNT(*) FROM users WHERE role="freelancer"', []),
            'companies' => $this->count('SELECT COUNT(*) FROM users WHERE role="company"', []),
            'jobs' => $this->count('SELECT COUNT(*) FROM jobs WHERE deleted_at IS NULL', []),
            'applications' => $this->count('SELECT COUNT(*) FROM applications', []),
            'uploads' => $this->count('SELECT COUNT(*) FROM certificates', []) + $this->count('SELECT COUNT(*) FROM portfolio_projects WHERE image_path IS NOT NULL', []),
        ];
    }

    public function adminUsers(string $role = ''): array
    {
        if ($role === 'freelancer') {
            return $this->rows('SELECT u.*,CONCAT(p.first_name," ",p.last_name) AS display_name,p.city FROM users u JOIN freelancer_profiles p ON p.user_id=u.id WHERE u.role="freelancer" ORDER BY u.created_at DESC', []);
        }
        if ($role === 'company') {
            return $this->rows('SELECT u.*,p.company_name AS display_name,p.city FROM users u JOIN company_profiles p ON p.user_id=u.id WHERE u.role="company" ORDER BY u.created_at DESC', []);
        }
        return $this->rows('SELECT * FROM users ORDER BY created_at DESC', []);
    }

    public function adminSetUserStatus(int $id, string $status): void
    {
        $this->db->prepare('UPDATE users SET status=? WHERE id=? AND role!="admin"')->execute([$status, $id]);
    }

    public function adminDeleteUser(int $id): void
    {
        $this->db->prepare('DELETE FROM users WHERE id=? AND role!="admin"')->execute([$id]);
    }

    public function activities(): array
    {
        return $this->rows('SELECT l.*,u.email FROM activity_logs l LEFT JOIN users u ON u.id=l.user_id ORDER BY l.created_at DESC LIMIT 30', []);
    }

    public function adminJobs(): array
    {
        return $this->rows('SELECT j.*,c.company_name FROM jobs j JOIN company_profiles c ON c.id=j.company_id ORDER BY j.created_at DESC LIMIT 200', []);
    }

    public function adminApplications(): array
    {
        return $this->rows('SELECT a.*,j.title,CONCAT(f.first_name," ",f.last_name) AS freelancer,c.company_name FROM applications a JOIN jobs j ON j.id=a.job_id JOIN freelancer_profiles f ON f.id=a.freelancer_id JOIN company_profiles c ON c.id=j.company_id ORDER BY a.created_at DESC LIMIT 200', []);
    }

    public function adminUploads(): array
    {
        $certs = $this->rows('SELECT "certificate" AS type,title AS name,file_path,created_at FROM certificates ORDER BY created_at DESC LIMIT 100', []);
        $cvs = $this->rows('SELECT "cv" AS type,CONCAT(first_name," ",last_name) AS name,cv_path AS file_path,NOW() AS created_at FROM freelancer_profiles WHERE cv_path IS NOT NULL LIMIT 100', []);
        return array_merge($certs, $cvs);
    }

    public function adminSetJobStatus(int $id, string $status): void
    {
        $this->db->prepare('UPDATE jobs SET status=? WHERE id=?')->execute([$status, $id]);
    }

    public function adminSetAnyApplicationStatus(int $id, string $status): void
    {
        $this->db->prepare('UPDATE applications SET status=?, updated_at=NOW() WHERE id=?')->execute([$status, $id]);
    }

    public function notifications(int $userId): array
    {
        return $this->rows('SELECT * FROM notifications WHERE user_id=? ORDER BY created_at DESC LIMIT 20', [$userId]);
    }

    public function freelancers(array $filters = []): array
    {
        $where = ['u.status="active"'];
        $args = [];
        if (!empty($filters['city'])) {
            $where[] = 'p.city = ?';
            $args[] = $filters['city'];
        }
        if (!empty($filters['skill'])) {
            $where[] = 'EXISTS(SELECT 1 FROM freelancer_skills s WHERE s.user_id=u.id AND s.name LIKE ?)';
            $args[] = '%' . $filters['skill'] . '%';
        }
        $sql = 'SELECT u.email,p.* FROM users u JOIN freelancer_profiles p ON p.user_id=u.id WHERE ' . implode(' AND ', $where) . ' ORDER BY p.profile_views DESC LIMIT 200';
        return $this->rows($sql, $args);
    }

    public function companies(array $filters = []): array
    {
        $where = ['u.status="active"'];
        $args = [];
        if (!empty($filters['industry'])) {
            $where[] = 'p.industry LIKE ?';
            $args[] = '%' . $filters['industry'] . '%';
        }
        $sql = 'SELECT p.* FROM users u JOIN company_profiles p ON p.user_id=u.id WHERE ' . implode(' AND ', $where) . ' ORDER BY p.company_name LIMIT 100';
        return $this->rows($sql, $args);
    }

    public function nearby(float $lat, float $lng, float $radiusKm, string $type): array
    {
        $table = $type === 'company' ? 'company_profiles' : 'freelancer_profiles';
        $name = $type === 'company' ? 'company_name' : 'CONCAT(first_name," ",last_name)';
        $sql = "SELECT *,({$name}) AS display_name,(6371*ACOS(COS(RADIANS(?))*COS(RADIANS(lat))*COS(RADIANS(lng)-RADIANS(?))+SIN(RADIANS(?))*SIN(RADIANS(lat)))) AS distance_km FROM {$table} HAVING distance_km <= ? ORDER BY distance_km LIMIT 80";
        return $this->rows($sql, [$lat, $lng, $lat, $radiusKm]);
    }

    public function notify(int $userId, string $title, string $message): void
    {
        $this->db->prepare('INSERT INTO notifications(user_id,title,message,created_at) VALUES(?,?,?,NOW())')->execute([$userId, $title, $message]);
    }

    public function log(?int $userId, string $action, string $details): void
    {
        $this->db->prepare('INSERT INTO activity_logs(user_id,action,details,ip_address,created_at) VALUES(?,?,?,?,NOW())')
            ->execute([$userId, $action, $details, $_SERVER['REMOTE_ADDR'] ?? 'cli']);
    }

    private function rows(string $sql, array $args): array
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($args);
        return $stmt->fetchAll();
    }

    private function count(string $sql, array $args): int
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($args);
        return (int)$stmt->fetchColumn();
    }
}
