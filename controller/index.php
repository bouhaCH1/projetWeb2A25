<?php
declare(strict_types=1);

require_once __DIR__ . '/../model/WorkwaveModel.php';

session_name('WORKWAVESESSID');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => dirname($_SERVER['SCRIPT_NAME']) ?: '/',
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

$model = new WorkwaveModel();
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$path = trim($_SERVER['PATH_INFO'] ?? ($_GET['r'] ?? 'home'), '/');
$route = $path === '' ? 'home' : $path;

if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}
if (isset($_SESSION['last_seen']) && time() - (int)$_SESSION['last_seen'] > 3600) {
    session_destroy();
    header("Location: {$base}/index.php?r=login&timeout=1");
    exit;
}
$_SESSION['last_seen'] = time();
restoreRememberedUser($model);

try {
    dispatch($route, $model, $base);
} catch (Throwable $e) {
    http_response_code(500);
    render('frontoffice/error', ['title' => 'Something went wrong', 'message' => $e->getMessage()], 'front');
}

function dispatch(string $route, WorkwaveModel $model, string $base): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        verifyCsrf();
    }

    switch ($route) {
        case 'home':
            render('frontoffice/home', ['title' => 'WORKWAVE', 'jobs' => $model->jobs(['salary_min' => 0]), 'freelancers' => $model->freelancers([])], 'front');
            break;

        case 'login':
            if (isPost()) {
                $user = $model->userByEmail(strtolower(post('email')));
                if (!$user || !password_verify(post('password'), $user['password_hash']) || $user['status'] !== 'active') {
                    flash('error', 'Invalid credentials or inactive account.');
                    redirect('login');
                }
                $_SESSION['user_id'] = (int)$user['id'];
                $_SESSION['role'] = $user['role'];
                if (isset($_POST['remember'])) {
                    $selector = bin2hex(random_bytes(9));
                    $validator = bin2hex(random_bytes(32));
                    $model->setRememberToken((int)$user['id'], $selector, password_hash($validator, PASSWORD_DEFAULT));
                    setcookie('ww_remember', $selector . ':' . $validator, time() + 2592000, dirname($_SERVER['SCRIPT_NAME']), '', false, true);
                }
                $model->log((int)$user['id'], 'auth.login', 'Logged in');
                redirect($user['role'] === 'admin' ? 'admin' : ($user['role'] === 'company' ? 'company' : 'freelancer'));
            }
            render('frontoffice/auth', ['title' => 'Login', 'mode' => 'login'], 'front');
            break;

        case 'register-freelancer':
        case 'register-company':
            $role = $route === 'register-company' ? 'company' : 'freelancer';
            if (isPost()) {
                if ($model->userByEmail(strtolower(post('email')))) {
                    flash('error', 'This email is already registered.');
                    redirect($route);
                }
                $id = $model->createUser($role, strtolower(post('email')), post('password'), $_POST);
                $_SESSION['user_id'] = $id;
                $_SESSION['role'] = $role;
                flash('success', 'Welcome to WORKWAVE. Your workspace is ready.');
                redirect($role);
            }
            render('frontoffice/auth', ['title' => 'Register', 'mode' => $role], 'front');
            break;

        case 'logout':
            if ($user = currentUser($model)) {
                $model->clearRememberToken((int)$user['id']);
            }
            setcookie('ww_remember', '', time() - 3600, dirname($_SERVER['SCRIPT_NAME']), '', false, true);
            session_destroy();
            redirect('home');
            break;

        case 'freelancer':
            requireRole('freelancer');
            render('frontoffice/freelancer_dashboard', freelancerPayload($model), 'front');
            break;

        case 'freelancer/profile':
            requireRole('freelancer');
            if (isPost()) {
                $model->updateFreelancer(userId(), $_POST);
                uploadProfileFiles($model, 'freelancer');
                flash('success', 'Profile updated.');
            }
            redirect('freelancer');
            break;

        case 'freelancer/skill':
            requireRole('freelancer');
            $model->addSkill(userId(), $_POST);
            flash('success', 'Skill added.');
            redirect('freelancer');
            break;

        case 'freelancer/diploma':
            requireRole('freelancer');
            $model->addDiploma(userId(), $_POST);
            flash('success', 'Diploma added.');
            redirect('freelancer');
            break;

        case 'freelancer/certificate':
            requireRole('freelancer');
            $path = secureUpload('certificate', 'pdf', 'certificates');
            if ($path) {
                $model->addCertificate(userId(), post('title'), $path);
                flash('success', 'Certificate uploaded.');
            }
            redirect('freelancer');
            break;

        case 'freelancer/certificate-title':
            requireRole('freelancer');
            $model->updateCertificateTitle(userId(), (int)post('id'), post('title'));
            redirect('freelancer');
            break;

        case 'freelancer/project':
            requireRole('freelancer');
            $image = secureUpload('image', 'image', 'portfolio');
            $model->addProject(userId(), $_POST, $image);
            flash('success', 'Portfolio project added.');
            redirect('freelancer');
            break;

        case 'delete':
            requireRole('freelancer');
            $map = ['skill' => 'freelancer_skills', 'diploma' => 'diplomas', 'certificate' => 'certificates', 'project' => 'portfolio_projects'];
            $type = $_GET['type'] ?? '';
            if (isset($map[$type])) {
                $model->deleteOwned($map[$type], (int)($_GET['id'] ?? 0), userId());
            }
            redirect('freelancer');
            break;

        case 'jobs':
            render('frontoffice/jobs', ['title' => 'Jobs', 'jobs' => $model->jobs($_GET), 'filters' => $_GET], 'front');
            break;

        case 'jobs/apply':
            requireRole('freelancer');
            $model->apply(userId(), (int)post('job_id'), post('message'));
            flash('success', 'Application submitted.');
            redirect('jobs');
            break;

        case 'jobs/save':
            requireRole('freelancer');
            $model->saveJob(userId(), (int)post('job_id'));
            flash('success', 'Job saved.');
            redirect('jobs');
            break;

        case 'company':
            requireRole('company');
            render('frontoffice/company_dashboard', companyPayload($model), 'front');
            break;

        case 'company/profile':
            requireRole('company');
            $model->updateCompany(userId(), $_POST);
            uploadProfileFiles($model, 'company');
            flash('success', 'Company profile updated.');
            redirect('company');
            break;

        case 'company/job':
            requireRole('company');
            $model->upsertJob(userId(), $_POST, !empty($_POST['id']) ? (int)$_POST['id'] : null);
            flash('success', 'Job saved.');
            redirect('company');
            break;

        case 'company/job-status':
            requireRole('company');
            $model->setJobStatus(userId(), (int)post('id'), post('status'));
            redirect('company');
            break;

        case 'company/job-delete':
            requireRole('company');
            $model->deleteJob(userId(), (int)post('id'));
            redirect('company');
            break;

        case 'company/application':
            requireRole('company');
            $model->setApplicationStatus(userId(), (int)post('id'), post('status'));
            flash('success', 'Application updated.');
            redirect('company');
            break;

        case 'map':
            $lat = (float)($_GET['lat'] ?? 36.8065);
            $lng = (float)($_GET['lng'] ?? 10.1815);
            $radius = (float)($_GET['radius'] ?? 50);
            render('frontoffice/map', ['title' => 'Nearby Talent', 'freelancers' => $model->nearby($lat, $lng, $radius, 'freelancer'), 'companies' => $model->nearby($lat, $lng, $radius, 'company'), 'lat' => $lat, 'lng' => $lng, 'radius' => $radius], 'front');
            break;

        case 'freelancers':
            render('frontoffice/freelancers', ['title' => 'Freelancers', 'freelancers' => $model->freelancers($_GET), 'filters' => $_GET], 'front');
            break;

        case 'companies':
            render('frontoffice/companies', ['title' => 'Companies', 'companies' => $model->companies($_GET), 'filters' => $_GET], 'front');
            break;

        case 'p':
            $profile = $model->publicFreelancer((string)($_GET['token'] ?? ''));
            if (!$profile) {
                http_response_code(404);
                render('frontoffice/error', ['title' => 'Profile not found', 'message' => 'This public profile is unavailable.'], 'front');
                break;
            }
            render('frontoffice/public_profile', ['title' => $profile['first_name'] . ' ' . $profile['last_name'], 'profile' => $profile], 'front');
            break;

        case 'admin':
            requireRole('admin');
            render('backoffice/dashboard', ['title' => 'Admin Dashboard', 'stats' => $model->adminStats(), 'activities' => $model->activities(), 'users' => $model->adminUsers('')], 'back');
            break;

        case 'admin/users':
            requireRole('admin');
            render('backoffice/users', ['title' => 'Users', 'freelancers' => $model->adminUsers('freelancer'), 'companies' => $model->adminUsers('company')], 'back');
            break;

        case 'admin/operations':
            requireRole('admin');
            render('backoffice/operations', ['title' => 'Operations', 'jobs' => $model->adminJobs(), 'applications' => $model->adminApplications(), 'uploads' => $model->adminUploads(), 'activities' => $model->activities()], 'back');
            break;

        case 'admin/job-status':
            requireRole('admin');
            $model->adminSetJobStatus((int)post('id'), post('status'));
            flash('success', 'Job status updated.');
            redirect('admin/operations');
            break;

        case 'admin/application-status':
            requireRole('admin');
            $model->adminSetAnyApplicationStatus((int)post('id'), post('status'));
            flash('success', 'Application status updated.');
            redirect('admin/operations');
            break;

        case 'admin/status':
            requireRole('admin');
            $model->adminSetUserStatus((int)post('id'), post('status'));
            flash('success', 'User status updated.');
            redirect('admin/users');
            break;

        case 'admin/delete':
            requireRole('admin');
            $model->adminDeleteUser((int)post('id'));
            flash('success', 'Account deleted.');
            redirect('admin/users');
            break;

        default:
            http_response_code(404);
            render('frontoffice/error', ['title' => '404', 'message' => 'Page not found.'], 'front');
    }
}

function freelancerPayload(WorkwaveModel $model): array
{
    return [
        'title' => 'Freelancer Dashboard',
        'profile' => $model->freelancerByUser(userId()),
        'skills' => $model->skills(userId()),
        'diplomas' => $model->diplomas(userId()),
        'certificates' => $model->certificates(userId()),
        'projects' => $model->projects(userId()),
        'applications' => $model->freelancerApplications(userId()),
        'stats' => $model->freelancerStats(userId()),
        'notifications' => $model->notifications(userId()),
    ];
}

function companyPayload(WorkwaveModel $model): array
{
    return [
        'title' => 'Company Dashboard',
        'profile' => $model->companyByUser(userId()),
        'jobs' => $model->companyJobs(userId()),
        'applications' => $model->companyApplications(userId()),
        'notifications' => $model->notifications(userId()),
    ];
}

function uploadProfileFiles(WorkwaveModel $model, string $role): void
{
    if ($role === 'freelancer') {
        if ($avatar = secureUpload('avatar', 'image', 'avatars')) {
            $model->setProfileFile(userId(), 'freelancer', 'avatar_path', $avatar);
        }
        if ($cv = secureUpload('cv', 'pdf', 'cvs')) {
            $model->setProfileFile(userId(), 'freelancer', 'cv_path', $cv);
        }
        return;
    }
    if ($logo = secureUpload('logo', 'image', 'logos')) {
        $model->setProfileFile(userId(), 'company', 'logo_path', $logo);
    }
}

function secureUpload(string $field, string $kind, string $folder): ?string
{
    if (empty($_FILES[$field]['name']) || ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK || $_FILES[$field]['size'] > 5 * 1024 * 1024) {
        flash('error', 'Upload failed or exceeded 5MB.');
        return null;
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($_FILES[$field]['tmp_name']);
    $allowed = $kind === 'pdf'
        ? ['application/pdf' => 'pdf']
        : ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/gif' => 'gif'];
    if (!isset($allowed[$mime])) {
        flash('error', 'Invalid file type.');
        return null;
    }
    $name = bin2hex(random_bytes(12)) . '.' . $allowed[$mime];
    $relative = "view/frontoffice/uploads/{$folder}/{$name}";
    $target = realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);
    if (!move_uploaded_file($_FILES[$field]['tmp_name'], $target)) {
        flash('error', 'Could not store uploaded file.');
        return null;
    }
    return $relative;
}

function restoreRememberedUser(WorkwaveModel $model): void
{
    if (isset($_SESSION['user_id']) || empty($_COOKIE['ww_remember'])) {
        return;
    }
    [$selector, $validator] = array_pad(explode(':', $_COOKIE['ww_remember'], 2), 2, '');
    if ($selector === '' || $validator === '') {
        return;
    }
    $user = $model->userByRememberToken($selector);
    if ($user && password_verify($validator, (string)$user['remember_validator_hash']) && $user['status'] === 'active') {
        $_SESSION['user_id'] = (int)$user['id'];
        $_SESSION['role'] = $user['role'];
    }
}

function render(string $view, array $data, string $layout): void
{
    extract($data, EXTR_SKIP);
    $viewFile = __DIR__ . '/../view/' . $view . '.php';
    ob_start();
    require $viewFile;
    $content = ob_get_clean();
    require __DIR__ . '/../view/' . ($layout === 'back' ? 'backoffice/layout.php' : 'frontoffice/layout.php');
}

function currentUser(WorkwaveModel $model): ?array
{
    return isset($_SESSION['user_id']) ? $model->userById((int)$_SESSION['user_id']) : null;
}

function requireRole(string $role): void
{
    if (($_SESSION['role'] ?? null) !== $role) {
        flash('error', 'Please log in with the correct account type.');
        redirect('login');
    }
}

function isPost(): bool { return $_SERVER['REQUEST_METHOD'] === 'POST'; }
function userId(): int { return (int)($_SESSION['user_id'] ?? 0); }
function post(string $key, string $default = ''): string { return trim((string)($_POST[$key] ?? $default)); }
function e(?string $value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function csrf(): string { return '<input type="hidden" name="csrf" value="' . e($_SESSION['csrf'] ?? '') . '">'; }
function verifyCsrf(): void
{
    if (!hash_equals((string)($_SESSION['csrf'] ?? ''), (string)($_POST['csrf'] ?? ''))) {
        http_response_code(419);
        exit('Invalid CSRF token.');
    }
}
function flash(string $type, string $message): void { $_SESSION['flash'][] = ['type' => $type, 'message' => $message]; }
function consumeFlash(): array { $items = $_SESSION['flash'] ?? []; unset($_SESSION['flash']); return $items; }
function routeUrl(string $route, array $query = []): string
{
    $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    $query = array_merge(['r' => $route], $query);
    return $base . '/index.php?' . http_build_query($query);
}
function assetUrl(string $path): string
{
    return '../' . ltrim($path, '/');
}
function redirect(string $route): void
{
    header('Location: ' . routeUrl($route));
    exit;
}
