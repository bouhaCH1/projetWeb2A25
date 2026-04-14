<?php
<<<<<<< HEAD
=======
// Controller/JobController.php
>>>>>>> b2a8300c8d5e972f31e17e8b354ce666ccf5ef8b

require_once __DIR__ . '/../Model/Job.php';

class JobController {

<<<<<<< HEAD
=======
    /** Public list of jobs (JOIN in model). */
>>>>>>> b2a8300c8d5e972f31e17e8b354ce666ccf5ef8b
    public function listJobs(): void {
        $job  = new Job();
        $jobs = $job->findAllWithEmployers();
        require_once __DIR__ . '/../View/job/list.php';
    }

<<<<<<< HEAD
=======
    /** Single job with employer row (JOIN). */
>>>>>>> b2a8300c8d5e972f31e17e8b354ce666ccf5ef8b
    public function showJob(): void {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id < 1) {
            $_SESSION['errors'] = ['Invalid job.'];
            header('Location: /workwave/Controller/index.php?action=jobs');
            exit;
        }
        $job = new Job();
        $row = $job->findByIdWithEmployer($id);
        if ($row === null) {
            $_SESSION['errors'] = ['This job listing is not available.'];
            header('Location: /workwave/Controller/index.php?action=jobs');
            exit;
        }
        require_once __DIR__ . '/../View/job/view.php';
    }

    public function showPostJob(): void {
        $this->requireEmployer();
        require_once __DIR__ . '/../View/job/post.php';
    }

    public function postJob(): void {
        $this->requireEmployer();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /workwave/Controller/index.php?action=job_post');
            exit;
        }

<<<<<<< HEAD
        $title           = trim($_POST['title'] ?? '');
        $description     = trim($_POST['description'] ?? '');
        $location        = trim($_POST['location'] ?? '');
        $employment_type = trim($_POST['employment_type'] ?? '');
        $salary_range    = trim($_POST['salary_range'] ?? '');
=======
        $title            = trim($_POST['title'] ?? '');
        $description      = trim($_POST['description'] ?? '');
        $location         = trim($_POST['location'] ?? '');
        $employment_type  = trim($_POST['employment_type'] ?? '');
        $salary_range     = trim($_POST['salary_range'] ?? '');
>>>>>>> b2a8300c8d5e972f31e17e8b354ce666ccf5ef8b

        $errors = $this->validateJobInput($title, $description, $location, $employment_type, $salary_range);

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_job'] = [
                'title'           => $title,
                'description'     => $description,
                'location'        => $location,
                'employment_type' => $employment_type,
                'salary_range'    => $salary_range,
            ];
            header('Location: /workwave/Controller/index.php?action=job_post');
            exit;
        }

        $job = new Job();
<<<<<<< HEAD
        $job->employer_id     = (int) $_SESSION['user_id'];
        $job->title           = $title;
        $job->description     = $description;
        $job->location        = $location;
        $job->employment_type = $employment_type;
        $job->salary_range    = $salary_range;
=======
        $job->employer_id      = (int) $_SESSION['user_id'];
        $job->title            = $title;
        $job->description      = $description;
        $job->location         = $location;
        $job->employment_type  = $employment_type;
        $job->salary_range     = $salary_range;
>>>>>>> b2a8300c8d5e972f31e17e8b354ce666ccf5ef8b

        $result = $job->create();
        $_SESSION['success'] = $result['message'];
        header('Location: /workwave/Controller/index.php?action=my_jobs');
        exit;
    }

<<<<<<< HEAD
    public function myJobs(): void {
        $this->requireEmployer();
        $job  = new Job();
=======
    /** Employer's listings (JOIN in model). */
    public function myJobs(): void {
        $this->requireEmployer();
        $job = new Job();
>>>>>>> b2a8300c8d5e972f31e17e8b354ce666ccf5ef8b
        $jobs = $job->findByEmployerWithEmployerInfo((int) $_SESSION['user_id']);
        require_once __DIR__ . '/../View/job/my_jobs.php';
    }

    public function deleteJob(): void {
        $this->requireEmployer();
        $jobId = (int) ($_GET['id'] ?? 0);
        if ($jobId < 1) {
            $_SESSION['errors'] = ['Invalid job.'];
            header('Location: /workwave/Controller/index.php?action=my_jobs');
            exit;
        }
        $job = new Job();
        $result = $job->deleteByOwner($jobId, (int) $_SESSION['user_id']);
        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
        } else {
            $_SESSION['errors'] = [$result['message']];
        }
        header('Location: /workwave/Controller/index.php?action=my_jobs');
        exit;
    }

    private function requireLogin(): void {
        if (empty($_SESSION['user_id'])) {
            header('Location: /workwave/Controller/index.php?action=login');
            exit;
        }
    }

    private function requireEmployer(): void {
        $this->requireLogin();
        if (($_SESSION['user_role'] ?? '') !== 'employer') {
            $_SESSION['errors'] = ['Only employer accounts can manage job postings.'];
            header('Location: /workwave/Controller/index.php?action=jobs');
            exit;
        }
    }

<<<<<<< HEAD
=======
    /**
     * Server-side validation only (no HTML5 constraint attributes).
     *
     * @return string[]
     */
>>>>>>> b2a8300c8d5e972f31e17e8b354ce666ccf5ef8b
    private function validateJobInput(
        string $title,
        string $description,
        string $location,
        string $employment_type,
        string $salary_range
    ): array {
        $errors = [];
        $allowedTypes = ['full_time', 'part_time', 'contract', 'internship'];

        if ($title === '') {
            $errors[] = 'Job title is required.';
        } elseif (strlen($title) > 200) {
            $errors[] = 'Job title must be at most 200 characters.';
        }

        if ($description === '') {
            $errors[] = 'Job description is required.';
        } elseif (strlen($description) < 30) {
            $errors[] = 'Job description must be at least 30 characters.';
        } elseif (strlen($description) > 8000) {
            $errors[] = 'Job description is too long.';
        }

        if ($location !== '' && strlen($location) > 150) {
            $errors[] = 'Location must be at most 150 characters.';
        }

        if (!in_array($employment_type, $allowedTypes, true)) {
            $errors[] = 'Please select a valid employment type.';
        }

        if ($salary_range !== '' && strlen($salary_range) > 120) {
            $errors[] = 'Salary or compensation field is too long.';
        }

        return $errors;
    }
}
