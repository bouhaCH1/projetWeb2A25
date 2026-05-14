<?php
declare(strict_types=1);

require_once __DIR__ . '/../model/PortfolioWorkwaveModel.php';

final class PortfolioController
{
    private PortfolioWorkwaveModel $model;

    public function __construct()
    {
        $this->model = new PortfolioWorkwaveModel();
        if (!isset($_SESSION['portfolio_csrf'])) {
            $_SESSION['portfolio_csrf'] = bin2hex(random_bytes(32));
        }
        portfolioRestoreRememberedUser($this->model);
    }

    public function handle(?string $route = null): void
    {
        $route = trim((string)($route ?? ($_GET['r'] ?? 'home')), '/');
        $route = $route === '' ? 'home' : $route;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            portfolioVerifyCsrf();
        }

        try {
            $this->dispatch($route);
        } catch (Throwable $e) {
            http_response_code(500);
            portfolioRender('frontoffice/error', [
                'title' => 'Something went wrong',
                'message' => $e->getMessage(),
            ], 'front');
        }
    }

    private function dispatch(string $route): void
    {
        switch ($route) {
            case 'home':
                portfolioRender('frontoffice/home', [
                    'title' => 'WORKWAVE Portfolio',
                    'jobs' => $this->model->jobs(['salary_min' => 0]),
                    'freelancers' => $this->model->freelancers([]),
                ], 'front');
                break;

            case 'login':
                if (portfolioIsPost()) {
                    $user = $this->model->userByEmail(strtolower(portfolioPost('email')));
                    if (!$user || !password_verify(portfolioPost('password'), $user['password_hash']) || $user['status'] !== 'active') {
                        portfolioFlash('error', 'Invalid credentials or inactive account.');
                        portfolioRedirect('login');
                    }
                    $_SESSION['portfolio_user_id'] = (int)$user['id'];
                    $_SESSION['portfolio_role'] = $user['role'];
                    if (isset($_POST['remember'])) {
                        $selector = bin2hex(random_bytes(9));
                        $validator = bin2hex(random_bytes(32));
                        $this->model->setRememberToken((int)$user['id'], $selector, password_hash($validator, PASSWORD_DEFAULT));
                        setcookie('ww_portfolio_remember', $selector . ':' . $validator, time() + 2592000, dirname($_SERVER['SCRIPT_NAME']), '', false, true);
                    }
                    $this->model->log((int)$user['id'], 'auth.login', 'Logged in');
                    portfolioRedirect($user['role'] === 'admin' ? 'admin' : ($user['role'] === 'company' ? 'company' : 'freelancer'));
                }
                portfolioRender('frontoffice/auth', ['title' => 'Portfolio Login', 'mode' => 'login'], 'front');
                break;

            case 'register-freelancer':
            case 'register-company':
                $role = $route === 'register-company' ? 'company' : 'freelancer';
                if (portfolioIsPost()) {
                    if ($this->model->userByEmail(strtolower(portfolioPost('email')))) {
                        portfolioFlash('error', 'This email is already registered.');
                        portfolioRedirect($route);
                    }
                    $id = $this->model->createUser($role, strtolower(portfolioPost('email')), portfolioPost('password'), $_POST);
                    $_SESSION['portfolio_user_id'] = $id;
                    $_SESSION['portfolio_role'] = $role;
                    portfolioFlash('success', 'Welcome to WORKWAVE. Your workspace is ready.');
                    portfolioRedirect($role);
                }
                portfolioRender('frontoffice/auth', ['title' => 'Portfolio Register', 'mode' => $role], 'front');
                break;

            case 'logout':
                if ($user = portfolioCurrentUser($this->model)) {
                    $this->model->clearRememberToken((int)$user['id']);
                }
                setcookie('ww_portfolio_remember', '', time() - 3600, dirname($_SERVER['SCRIPT_NAME']), '', false, true);
                unset($_SESSION['portfolio_user_id'], $_SESSION['portfolio_role']);
                portfolioRedirect('home');
                break;

            case 'freelancer':
                portfolioRequireRole('freelancer');
                portfolioRender('frontoffice/freelancer_dashboard', portfolioFreelancerPayload($this->model), 'front');
                break;

            case 'freelancer/profile':
                portfolioRequireRole('freelancer');
                $this->model->updateFreelancer(portfolioUserId(), $_POST);
                portfolioUploadProfileFiles($this->model, 'freelancer');
                portfolioFlash('success', 'Profile updated.');
                portfolioRedirect('freelancer');
                break;

            case 'freelancer/skill':
                portfolioRequireRole('freelancer');
                $this->model->addSkill(portfolioUserId(), $_POST);
                portfolioFlash('success', 'Skill added.');
                portfolioRedirect('freelancer');
                break;

            case 'freelancer/diploma':
                portfolioRequireRole('freelancer');
                $this->model->addDiploma(portfolioUserId(), $_POST);
                portfolioFlash('success', 'Diploma added.');
                portfolioRedirect('freelancer');
                break;

            case 'freelancer/certificate':
                portfolioRequireRole('freelancer');
                $path = portfolioSecureUpload('certificate', 'pdf', 'certificates');
                if ($path) {
                    $this->model->addCertificate(portfolioUserId(), portfolioPost('title'), $path);
                    portfolioFlash('success', 'Certificate uploaded.');
                }
                portfolioRedirect('freelancer');
                break;

            case 'freelancer/project':
                portfolioRequireRole('freelancer');
                $image = portfolioSecureUpload('image', 'image', 'portfolio');
                $this->model->addProject(portfolioUserId(), $_POST, $image);
                portfolioFlash('success', 'Portfolio project added.');
                portfolioRedirect('freelancer');
                break;

            case 'jobs':
                portfolioRender('frontoffice/jobs', [
                    'title' => 'Portfolio Jobs',
                    'jobs' => $this->model->jobs($_GET),
                    'filters' => $_GET,
                ], 'front');
                break;

            case 'jobs/apply':
                portfolioRequireRole('freelancer');
                $this->model->apply(portfolioUserId(), (int)portfolioPost('job_id'), portfolioPost('message'));
                portfolioFlash('success', 'Application submitted.');
                portfolioRedirect('jobs');
                break;

            case 'jobs/save':
                portfolioRequireRole('freelancer');
                $this->model->saveJob(portfolioUserId(), (int)portfolioPost('job_id'));
                portfolioFlash('success', 'Job saved.');
                portfolioRedirect('jobs');
                break;

            case 'company':
                portfolioRequireRole('company');
                portfolioRender('frontoffice/company_dashboard', portfolioCompanyPayload($this->model), 'front');
                break;

            case 'company/profile':
                portfolioRequireRole('company');
                $this->model->updateCompany(portfolioUserId(), $_POST);
                portfolioUploadProfileFiles($this->model, 'company');
                portfolioFlash('success', 'Company profile updated.');
                portfolioRedirect('company');
                break;

            case 'company/job':
                portfolioRequireRole('company');
                $this->model->upsertJob(portfolioUserId(), $_POST, !empty($_POST['id']) ? (int)$_POST['id'] : null);
                portfolioFlash('success', 'Job saved.');
                portfolioRedirect('company');
                break;

            case 'company/job-status':
                portfolioRequireRole('company');
                $this->model->setJobStatus(portfolioUserId(), (int)portfolioPost('id'), portfolioPost('status'));
                portfolioRedirect('company');
                break;

            case 'company/application':
                portfolioRequireRole('company');
                $this->model->setApplicationStatus(portfolioUserId(), (int)portfolioPost('id'), portfolioPost('status'));
                portfolioFlash('success', 'Application updated.');
                portfolioRedirect('company');
                break;

            case 'map':
                $lat = (float)($_GET['lat'] ?? 36.8065);
                $lng = (float)($_GET['lng'] ?? 10.1815);
                $radius = (float)($_GET['radius'] ?? 50);
                portfolioRender('frontoffice/map', [
                    'title' => 'Nearby Talent',
                    'freelancers' => $this->model->nearby($lat, $lng, $radius, 'freelancer'),
                    'companies' => $this->model->nearby($lat, $lng, $radius, 'company'),
                    'lat' => $lat,
                    'lng' => $lng,
                    'radius' => $radius,
                ], 'front');
                break;

            case 'freelancers':
                portfolioRender('frontoffice/freelancers', [
                    'title' => 'Freelancers',
                    'freelancers' => $this->model->freelancers($_GET),
                    'filters' => $_GET,
                ], 'front');
                break;

            case 'companies':
                portfolioRender('frontoffice/companies', [
                    'title' => 'Companies',
                    'companies' => $this->model->companies($_GET),
                    'filters' => $_GET,
                ], 'front');
                break;

            case 'p':
                $profile = $this->model->publicFreelancer((string)($_GET['token'] ?? ''));
                if (!$profile) {
                    http_response_code(404);
                    portfolioRender('frontoffice/error', ['title' => 'Profile not found', 'message' => 'This public profile is unavailable.'], 'front');
                    break;
                }
                portfolioRender('frontoffice/public_profile', ['title' => $profile['first_name'] . ' ' . $profile['last_name'], 'profile' => $profile], 'front');
                break;

            case 'admin':
                portfolioRequireRole('admin');
                portfolioRender('backoffice/dashboard', [
                    'title' => 'Portfolio Admin',
                    'stats' => $this->model->adminStats(),
                    'activities' => $this->model->activities(),
                    'users' => $this->model->adminUsers(''),
                ], 'back');
                break;

            case 'admin/users':
                portfolioRequireRole('admin');
                portfolioRender('backoffice/users', [
                    'title' => 'Portfolio Users',
                    'freelancers' => $this->model->adminUsers('freelancer'),
                    'companies' => $this->model->adminUsers('company'),
                ], 'back');
                break;

            case 'admin/operations':
                portfolioRequireRole('admin');
                portfolioRender('backoffice/operations', [
                    'title' => 'Portfolio Operations',
                    'jobs' => $this->model->adminJobs(),
                    'applications' => $this->model->adminApplications(),
                    'uploads' => $this->model->adminUploads(),
                    'activities' => $this->model->activities(),
                ], 'back');
                break;

            case 'admin/job-status':
                portfolioRequireRole('admin');
                $this->model->adminSetJobStatus((int)portfolioPost('id'), portfolioPost('status'));
                portfolioFlash('success', 'Job status updated.');
                portfolioRedirect('admin/operations');
                break;

            case 'admin/application-status':
                portfolioRequireRole('admin');
                $this->model->adminSetAnyApplicationStatus((int)portfolioPost('id'), portfolioPost('status'));
                portfolioFlash('success', 'Application status updated.');
                portfolioRedirect('admin/operations');
                break;

            case 'admin/status':
                portfolioRequireRole('admin');
                $this->model->adminSetUserStatus((int)portfolioPost('id'), portfolioPost('status'));
                portfolioFlash('success', 'User status updated.');
                portfolioRedirect('admin/users');
                break;

            case 'admin/delete':
                portfolioRequireRole('admin');
                $this->model->adminDeleteUser((int)portfolioPost('id'));
                portfolioFlash('success', 'Account deleted.');
                portfolioRedirect('admin/users');
                break;

            default:
                http_response_code(404);
                portfolioRender('frontoffice/error', ['title' => '404', 'message' => 'Page not found.'], 'front');
        }
    }
}

function portfolioFreelancerPayload(PortfolioWorkwaveModel $model): array
{
    return [
        'title' => 'Freelancer Dashboard',
        'profile' => $model->freelancerByUser(portfolioUserId()),
        'skills' => $model->skills(portfolioUserId()),
        'diplomas' => $model->diplomas(portfolioUserId()),
        'certificates' => $model->certificates(portfolioUserId()),
        'projects' => $model->projects(portfolioUserId()),
        'applications' => $model->freelancerApplications(portfolioUserId()),
        'stats' => $model->freelancerStats(portfolioUserId()),
        'notifications' => $model->notifications(portfolioUserId()),
    ];
}

function portfolioCompanyPayload(PortfolioWorkwaveModel $model): array
{
    return [
        'title' => 'Company Dashboard',
        'profile' => $model->companyByUser(portfolioUserId()),
        'jobs' => $model->companyJobs(portfolioUserId()),
        'applications' => $model->companyApplications(portfolioUserId()),
        'notifications' => $model->notifications(portfolioUserId()),
    ];
}

function portfolioUploadProfileFiles(PortfolioWorkwaveModel $model, string $role): void
{
    if ($role === 'freelancer') {
        if ($avatar = portfolioSecureUpload('avatar', 'image', 'avatars')) {
            $model->setProfileFile(portfolioUserId(), 'freelancer', 'avatar_path', $avatar);
        }
        if ($cv = portfolioSecureUpload('cv', 'pdf', 'cvs')) {
            $model->setProfileFile(portfolioUserId(), 'freelancer', 'cv_path', $cv);
        }
        return;
    }
    if ($logo = portfolioSecureUpload('logo', 'image', 'logos')) {
        $model->setProfileFile(portfolioUserId(), 'company', 'logo_path', $logo);
    }
}

function portfolioSecureUpload(string $field, string $kind, string $folder): ?string
{
    if (empty($_FILES[$field]['name']) || ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK || $_FILES[$field]['size'] > 5 * 1024 * 1024) {
        portfolioFlash('error', 'Upload failed or exceeded 5MB.');
        return null;
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($_FILES[$field]['tmp_name']);
    $allowed = $kind === 'pdf'
        ? ['application/pdf' => 'pdf']
        : ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/gif' => 'gif'];
    if (!isset($allowed[$mime])) {
        portfolioFlash('error', 'Invalid file type.');
        return null;
    }
    $name = bin2hex(random_bytes(12)) . '.' . $allowed[$mime];
    $relative = "view/portfolio/frontoffice/uploads/{$folder}/{$name}";
    $target = realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);
    $dir = dirname($target);
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
    if (!move_uploaded_file($_FILES[$field]['tmp_name'], $target)) {
        portfolioFlash('error', 'Could not store uploaded file.');
        return null;
    }
    return $relative;
}

function portfolioRestoreRememberedUser(PortfolioWorkwaveModel $model): void
{
    if (isset($_SESSION['portfolio_user_id']) || empty($_COOKIE['ww_portfolio_remember'])) {
        return;
    }
    [$selector, $validator] = array_pad(explode(':', $_COOKIE['ww_portfolio_remember'], 2), 2, '');
    if ($selector === '' || $validator === '') {
        return;
    }
    $user = $model->userByRememberToken($selector);
    if ($user && password_verify($validator, (string)$user['remember_validator_hash']) && $user['status'] === 'active') {
        $_SESSION['portfolio_user_id'] = (int)$user['id'];
        $_SESSION['portfolio_role'] = $user['role'];
    }
}

function portfolioRender(string $view, array $data, string $layout): void
{
    extract($data, EXTR_SKIP);
    $viewFile = __DIR__ . '/../view/portfolio/' . $view . '.php';
    ob_start();
    require $viewFile;
    $content = ob_get_clean();
    require __DIR__ . '/../view/portfolio/' . ($layout === 'back' ? 'backoffice/layout.php' : 'frontoffice/layout.php');
}

function portfolioCurrentUser(PortfolioWorkwaveModel $model): ?array
{
    return isset($_SESSION['portfolio_user_id']) ? $model->userById((int)$_SESSION['portfolio_user_id']) : null;
}

function portfolioRequireRole(string $role): void
{
    if (($_SESSION['portfolio_role'] ?? null) !== $role) {
        portfolioFlash('error', 'Please log in with the correct account type.');
        portfolioRedirect('login');
    }
}

function portfolioIsPost(): bool { return $_SERVER['REQUEST_METHOD'] === 'POST'; }
function portfolioUserId(): int { return (int)($_SESSION['portfolio_user_id'] ?? 0); }
function portfolioPost(string $key, string $default = ''): string { return trim((string)($_POST[$key] ?? $default)); }

function e(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function csrf(): string
{
    return '<input type="hidden" name="csrf" value="' . e($_SESSION['portfolio_csrf'] ?? '') . '">';
}

function portfolioVerifyCsrf(): void
{
    if (!hash_equals((string)($_SESSION['portfolio_csrf'] ?? ''), (string)($_POST['csrf'] ?? ''))) {
        http_response_code(419);
        exit('Invalid CSRF token.');
    }
}

function portfolioFlash(string $type, string $message): void
{
    $_SESSION['portfolio_flash'][] = ['type' => $type, 'message' => $message];
}

function consumeFlash(): array
{
    $items = $_SESSION['portfolio_flash'] ?? [];
    unset($_SESSION['portfolio_flash']);
    return $items;
}

function routeUrl(string $route, array $query = []): string
{
    $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    $query = array_merge(['action' => 'portfolio', 'r' => $route], $query);
    return $base . '/index.php?' . http_build_query($query);
}

function absoluteRouteUrl(string $route, array $query = []): string
{
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    return $scheme . '://' . $host . routeUrl($route, $query);
}

function assetUrl(string $path): string
{
    return '../' . ltrim($path, '/');
}

function portfolioRedirect(string $route): void
{
    header('Location: ' . routeUrl($route));
    exit;
}
