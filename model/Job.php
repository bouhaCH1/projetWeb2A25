<?php
// Model/Job.php — Second entity: job postings linked to employers (users)

require_once __DIR__ . '/Database.php';

class Job {

    public int $id = 0;
    public int $employer_id = 0;
    public string $title = '';
    public string $description = '';
    public string $location = '';
    /** full_time | part_time | contract | internship */
    public string $employment_type = 'full_time';
    public string $salary_range = '';
    public string $created_at = '';

    private PDO $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    /**
     * Insert a new job row (employer must be validated by controller).
     */
    public function create(): array {
        $stmt = $this->pdo->prepare(
            'INSERT INTO jobs (employer_id, title, description, location, employment_type, salary_range)
             VALUES (:employer_id, :title, :description, :location, :employment_type, :salary_range)'
        );
        $stmt->execute([
            ':employer_id'      => $this->employer_id,
            ':title'            => $this->title,
            ':description'      => $this->description,
            ':location'         => $this->location,
            ':employment_type' => $this->employment_type,
            ':salary_range'     => $this->salary_range,
        ]);
        $this->id = (int) $this->pdo->lastInsertId();
        return ['success' => true, 'message' => 'Job posted successfully.'];
    }

    /**
     * Public job board: all jobs with employer name (INNER JOIN users).
     *
     * @return array<int, array<string, mixed>>
     */
    public function findAllWithEmployers(): array {
        $sql = 'SELECT j.id, j.title, j.description, j.location, j.employment_type, j.salary_range,
                       j.created_at, j.employer_id,
                       u.first_name AS employer_first_name, u.last_name AS employer_last_name, u.email AS employer_email
                FROM jobs j
                INNER JOIN users u ON j.employer_id = u.id
                WHERE u.role = :role_employer
                ORDER BY j.created_at DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':role_employer' => 'employer']);
        return $stmt->fetchAll();
    }

    /**
     * Single job detail with employer info (INNER JOIN).
     */
    public function findByIdWithEmployer(int $id): ?array {
        $sql = 'SELECT j.id, j.title, j.description, j.location, j.employment_type, j.salary_range,
                       j.created_at, j.employer_id,
                       u.first_name AS employer_first_name, u.last_name AS employer_last_name, u.email AS employer_email
                FROM jobs j
                INNER JOIN users u ON j.employer_id = u.id
                WHERE j.id = :id
                LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row !== false ? $row : null;
    }

    /**
     * Jobs posted by one employer (same JOIN pattern for consistent columns in the view).
     *
     * @return array<int, array<string, mixed>>
     */
    public function findByEmployerWithEmployerInfo(int $employerId): array {
        $sql = 'SELECT j.id, j.title, j.description, j.location, j.employment_type, j.salary_range,
                       j.created_at, j.employer_id,
                       u.first_name AS employer_first_name, u.last_name AS employer_last_name, u.email AS employer_email
                FROM jobs j
                INNER JOIN users u ON j.employer_id = u.id
                WHERE j.employer_id = :employer_id
                ORDER BY j.created_at DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':employer_id' => $employerId]);
        return $stmt->fetchAll();
    }

    /**
     * Delete a job only if it belongs to the given employer.
     */
    public function deleteByOwner(int $jobId, int $employerId): array {
        $stmt = $this->pdo->prepare('DELETE FROM jobs WHERE id = :id AND employer_id = :employer_id');
        $stmt->execute([':id' => $jobId, ':employer_id' => $employerId]);
        if ($stmt->rowCount() > 0) {
            return ['success' => true, 'message' => 'Job removed.'];
        }
        return ['success' => false, 'message' => 'Job not found or you do not have permission to delete it.'];
    }
}
