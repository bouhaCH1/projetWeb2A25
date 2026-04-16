<?php
// Controller/CvController.php

require_once __DIR__ . '/../Model/Cv.php';

class CvController {

    /** Public list of CVs for employers (JOIN in model). */
    public function listCvs(): void {
        $cvModel = new Cv();
        $cvs = $cvModel->findAllWithSeekers();
        require_once __DIR__ . '/../View/cv/list.php';
    }

    /** Single CV view for employers. */
    public function showCv(): void {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id < 1) {
            $_SESSION['errors'] = ['Invalid CV.'];
            header('Location: /workwave/Controller/index.php?action=cvs');
            exit;
        }
        $cvModel = new Cv();
        $cv = $cvModel->findByIdWithSeeker($id);
        if ($cv === null) {
            $_SESSION['errors'] = ['This CV is not available.'];
            header('Location: /workwave/Controller/index.php?action=cvs');
            exit;
        }
        require_once __DIR__ . '/../View/cv/view.php';
    }

    /** Job Seeker's form to manage their own CV. */
    public function myCv(): void {
        $this->requireSeeker();
        
        $cvModel = new Cv();
        $cv = $cvModel->findBySeekerId((int) $_SESSION['user_id']);
        
        require_once __DIR__ . '/../View/cv/form.php';
    }

    /** Processing the CV form submission. */
    public function submitCv(): void {
        $this->requireSeeker();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /workwave/Controller/index.php?action=my_cv');
            exit;
        }

        $title      = trim($_POST['professional_title'] ?? '');
        $skills     = trim($_POST['skills'] ?? '');
        $years      = trim($_POST['experience_years'] ?? '');
        $rate       = trim($_POST['hourly_rate'] ?? '');
        $about      = trim($_POST['about_me'] ?? '');

        // Strict Server-Side Validation
        $errors = [];
        if ($title === '') {
            $errors[] = 'Professional title is required.';
        } elseif (strlen($title) > 150) {
            $errors[] = 'Professional title is too long (max 150 chars).';
        }

        if ($skills === '') {
            $errors[] = 'Skills are required.';
        } elseif (strlen($skills) > 1000) {
            $errors[] = 'Skills section is too long.';
        }

        if ($years !== '' && !is_numeric($years)) {
            $errors[] = 'Experience years must be a number.';
        }

        if ($rate !== '' && strlen($rate) > 50) {
            $errors[] = 'Hourly rate field is too long.';
        }

        if ($about === '') {
            $errors[] = 'About me section is required.';
        } elseif (strlen($about) > 5000) {
            $errors[] = 'About me section is too long.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_cv'] = [
                'professional_title' => $title,
                'skills'             => $skills,
                'experience_years'   => $years,
                'hourly_rate'        => $rate,
                'about_me'           => $about,
            ];
            header('Location: /workwave/Controller/index.php?action=my_cv');
            exit;
        }

        $cvModel = new Cv();
        $cvModel->seeker_id          = (int) $_SESSION['user_id'];
        $cvModel->professional_title = $title;
        $cvModel->skills             = $skills;
        $cvModel->experience_years   = (int) $years;
        $cvModel->hourly_rate        = $rate;
        $cvModel->about_me           = $about;

        // Check if updating or creating
        $existing = $cvModel->findBySeekerId((int) $_SESSION['user_id']);
        if ($existing) {
            $result = $cvModel->update();
        } else {
            $result = $cvModel->create();
        }

        $_SESSION['success'] = $result['message'];
        header('Location: /workwave/Controller/index.php?action=my_cv');
        exit;
    }

    private function requireSeeker(): void {
        if (empty($_SESSION['user_id'])) {
            header('Location: /workwave/Controller/index.php?action=login');
            exit;
        }
        if (($_SESSION['user_role'] ?? '') !== 'job_seeker') {
            $_SESSION['errors'] = ['Only job seeker accounts can manage a CV.'];
            header('Location: /workwave/Controller/index.php');
            exit;
        }
    }
}
