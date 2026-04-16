<?php
// Model/Cv.php — Third entity: CVs linked to job seekers (users)

require_once __DIR__ . '/Database.php';

class Cv {

    public int $id = 0;
    public int $seeker_id = 0;
    public string $professional_title = '';
    public string $skills = '';
    public int $experience_years = 0;
    public string $hourly_rate = '';
    public string $about_me = '';
    public string $created_at = '';

    private PDO $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    /**
     * Insert a new CV row.
     */
    public function create(): array {
        $stmt = $this->pdo->prepare(
            'INSERT INTO cvs (seeker_id, professional_title, skills, experience_years, hourly_rate, about_me)
             VALUES (:seeker_id, :professional_title, :skills, :experience_years, :hourly_rate, :about_me)'
        );
        $stmt->execute([
            ':seeker_id'          => $this->seeker_id,
            ':professional_title' => $this->professional_title,
            ':skills'             => $this->skills,
            ':experience_years'   => $this->experience_years,
            ':hourly_rate'        => $this->hourly_rate,
            ':about_me'           => $this->about_me,
        ]);
        $this->id = (int) $this->pdo->lastInsertId();
        return ['success' => true, 'message' => 'CV published successfully.'];
    }

    /**
     * Update an existing CV row.
     */
    public function update(): array {
        $stmt = $this->pdo->prepare(
            'UPDATE cvs SET professional_title = :professional_title, skills = :skills, 
                            experience_years = :experience_years, hourly_rate = :hourly_rate, about_me = :about_me
             WHERE seeker_id = :seeker_id'
        );
        $stmt->execute([
            ':seeker_id'          => $this->seeker_id,
            ':professional_title' => $this->professional_title,
            ':skills'             => $this->skills,
            ':experience_years'   => $this->experience_years,
            ':hourly_rate'        => $this->hourly_rate,
            ':about_me'           => $this->about_me,
        ]);
        return ['success' => true, 'message' => 'CV updated successfully.'];
    }

    /**
     * Single CV detail by seeker_id.
     */
    public function findBySeekerId(int $seekerId): ?array {
        $sql = 'SELECT c.id, c.seeker_id, c.professional_title, c.skills, c.experience_years, c.hourly_rate, c.about_me, c.created_at
                FROM cvs c
                WHERE c.seeker_id = :seeker_id
                LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':seeker_id' => $seekerId]);
        $row = $stmt->fetch();
        return $row !== false ? $row : null;
    }

    /**
     * Single CV detail by primary id with INNER JOIN to get seeker info.
     */
    public function findByIdWithSeeker(int $id): ?array {
        $sql = 'SELECT c.id, c.seeker_id, c.professional_title, c.skills, c.experience_years, c.hourly_rate, c.about_me, c.created_at,
                       u.first_name, u.last_name, u.email, u.profile_pic
                FROM cvs c
                INNER JOIN users u ON c.seeker_id = u.id
                WHERE c.id = :id
                LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row !== false ? $row : null;
    }

    /**
     * Public CV board: all CVs with seeker name (INNER JOIN users).
     *
     * @return array<int, array<string, mixed>>
     */
    public function findAllWithSeekers(): array {
        $sql = 'SELECT c.id, c.seeker_id, c.professional_title, c.skills, c.experience_years, c.hourly_rate, c.about_me, c.created_at,
                       u.first_name, u.last_name, u.email, u.profile_pic
                FROM cvs c
                INNER JOIN users u ON c.seeker_id = u.id
                WHERE u.role = :role_seeker
                ORDER BY c.created_at DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':role_seeker' => 'job_seeker']);
        return $stmt->fetchAll();
    }
}
