<?php
/**
 * PortfolioController — fully integrated into the main WorkWave app.
 * Uses the same session ($_SESSION['user_id'], $_SESSION['user_role'])
 * and the same job_platform database as all other controllers.
 */
class PortfolioController
{
    private PDO $db;

    public function __construct()
    {
        require_once __DIR__ . '/../Model/Database.php';
        $this->db = getConnection();
        $this->ensureTables();
    }

    /* ------------------------------------------------------------------ */
    /*  ROUTING                                                             */
    /* ------------------------------------------------------------------ */

    public function handle(string $action): void
    {
        switch ($action) {
            case 'portfolio':           $this->index();          break;
            case 'portfolio_add':       $this->add();            break;
            case 'portfolio_edit':      $this->edit();           break;
            case 'portfolio_delete':    $this->delete();         break;
            case 'portfolio_map':       $this->map();            break;
            case 'portfolio_cv':        $this->cv();             break;
            case 'portfolio_cv_add':    $this->addCvItem();      break;
            case 'portfolio_cv_del':    $this->delCvItem();      break;
            case 'portfolio_admin':     $this->adminIndex();     break;
            default:                    $this->index();
        }
    }

    /* ------------------------------------------------------------------ */
    /*  LIST — all users see public projects; logged-in see their own too  */
    /* ------------------------------------------------------------------ */

    public function index(): void
    {
        $userId  = (int)($_SESSION['user_id'] ?? 0);
        $search  = trim($_GET['search'] ?? '');
        $techFilter = trim($_GET['tech'] ?? '');

        // All approved projects + own unapproved ones
        $where  = ['1=1'];
        $params = [];

        if ($search !== '') {
            $where[]  = '(p.title LIKE ? OR p.description LIKE ?)';
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        if ($techFilter !== '') {
            $where[]  = 'p.technologies LIKE ?';
            $params[] = "%$techFilter%";
        }

        $sql = 'SELECT p.*, u.first_name, u.last_name, u.profile_pic
                FROM portfolio_projects p
                JOIN users u ON u.id = p.user_id
                WHERE ' . implode(' AND ', $where) . '
                ORDER BY p.created_at DESC
                LIMIT 100';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $projects = $stmt->fetchAll();

        // Stats
        $stats = [
            'total'    => $this->scalar('SELECT COUNT(*) FROM portfolio_projects'),
            'mine'     => $userId ? $this->scalar('SELECT COUNT(*) FROM portfolio_projects WHERE user_id=?', [$userId]) : 0,
            'techs'    => $this->scalar('SELECT COUNT(DISTINCT technologies) FROM portfolio_projects WHERE technologies != ""'),
        ];

        $pageTitle = 'Portfolio';
        require_once __DIR__ . '/../View/portfolio/index.php';
    }

    /* ------------------------------------------------------------------ */
    /*  ADD                                                                 */
    /* ------------------------------------------------------------------ */

    public function add(): void
    {
        $this->requireLogin();
        $userId = (int)$_SESSION['user_id'];
        $errors = [];
        $data   = ['title'=>'','description'=>'','technologies'=>'','github_url'=>'','demo_url'=>''];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['title']        = trim($_POST['title'] ?? '');
            $data['description']  = trim($_POST['description'] ?? '');
            $data['technologies'] = trim($_POST['technologies'] ?? '');
            $data['github_url']   = trim($_POST['github_url'] ?? '');
            $data['demo_url']     = trim($_POST['demo_url'] ?? '');

            if ($data['title'] === '')       $errors[] = 'Le titre est obligatoire.';
            if ($data['description'] === '') $errors[] = 'La description est obligatoire.';

            $imagePath = null;
            if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = $this->handleUpload('image');
                if ($imagePath === null) $errors[] = 'Image invalide (JPG/PNG/WEBP, max 5MB).';
            }

            if (empty($errors)) {
                $this->db->prepare(
                    'INSERT INTO portfolio_projects
                     (user_id,title,description,technologies,github_url,demo_url,image_path,created_at)
                     VALUES (?,?,?,?,?,?,?,NOW())'
                )->execute([$userId, $data['title'], $data['description'],
                             $data['technologies'], $data['github_url'],
                             $data['demo_url'], $imagePath]);

                $_SESSION['portfolio_flash'] = ['type'=>'success','msg'=>'Projet ajouté avec succès !'];
                header('Location: /workwave/Controller/index.php?action=portfolio');
                exit;
            }
        }

        $pageTitle = 'Ajouter un projet';
        require_once __DIR__ . '/../View/portfolio/form.php';
    }

    /* ------------------------------------------------------------------ */
    /*  EDIT                                                                */
    /* ------------------------------------------------------------------ */

    public function edit(): void
    {
        $this->requireLogin();
        $userId    = (int)$_SESSION['user_id'];
        $projectId = (int)($_GET['id'] ?? 0);
        $errors    = [];

        $project = $this->findProject($projectId, $userId);
        if (!$project) {
            $_SESSION['portfolio_flash'] = ['type'=>'error','msg'=>'Projet introuvable.'];
            header('Location: /workwave/Controller/index.php?action=portfolio');
            exit;
        }

        $data = $project;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['title']        = trim($_POST['title'] ?? '');
            $data['description']  = trim($_POST['description'] ?? '');
            $data['technologies'] = trim($_POST['technologies'] ?? '');
            $data['github_url']   = trim($_POST['github_url'] ?? '');
            $data['demo_url']     = trim($_POST['demo_url'] ?? '');

            if ($data['title'] === '')       $errors[] = 'Le titre est obligatoire.';
            if ($data['description'] === '') $errors[] = 'La description est obligatoire.';

            $imagePath = $project['image_path'];
            if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $newPath = $this->handleUpload('image');
                if ($newPath === null) {
                    $errors[] = 'Image invalide (JPG/PNG/WEBP, max 5MB).';
                } else {
                    $imagePath = $newPath;
                }
            }

            if (empty($errors)) {
                $this->db->prepare(
                    'UPDATE portfolio_projects
                     SET title=?,description=?,technologies=?,github_url=?,demo_url=?,image_path=?
                     WHERE id=? AND user_id=?'
                )->execute([$data['title'], $data['description'], $data['technologies'],
                             $data['github_url'], $data['demo_url'], $imagePath,
                             $projectId, $userId]);

                $_SESSION['portfolio_flash'] = ['type'=>'success','msg'=>'Projet modifié avec succès !'];
                header('Location: /workwave/Controller/index.php?action=portfolio');
                exit;
            }
        }

        $pageTitle = 'Modifier le projet';
        require_once __DIR__ . '/../View/portfolio/form.php';
    }

    /* ------------------------------------------------------------------ */
    /*  DELETE                                                              */
    /* ------------------------------------------------------------------ */

    public function delete(): void
    {
        $this->requireLogin();
        $userId    = (int)$_SESSION['user_id'];
        $projectId = (int)($_GET['id'] ?? 0);
        $role      = $_SESSION['user_role'] ?? '';

        // Admin can delete any; others only their own
        if ($role === 'admin') {
            $this->db->prepare('DELETE FROM portfolio_projects WHERE id=?')->execute([$projectId]);
        } else {
            $this->db->prepare('DELETE FROM portfolio_projects WHERE id=? AND user_id=?')->execute([$projectId, $userId]);
        }

        $_SESSION['portfolio_flash'] = ['type'=>'success','msg'=>'Projet supprimé.'];
        header('Location: /workwave/Controller/index.php?action=portfolio');
        exit;
    }

    /* ------------------------------------------------------------------ */
    /*  MAP SECTION                                                         */
    /* ------------------------------------------------------------------ */

    public function map(): void
    {
        $lat    = (float)($_GET['lat'] ?? 36.8065);
        $lng    = (float)($_GET['lng'] ?? 10.1815);
        $radius = (float)($_GET['radius'] ?? 50);

        // Fetch freelancers
        $sqlF = "SELECT p.*, u.first_name as u_fname, u.last_name as u_lname,
                 (6371 * ACOS(COS(RADIANS(?)) * COS(RADIANS(lat)) * COS(RADIANS(lng) - RADIANS(?)) + SIN(RADIANS(?)) * SIN(RADIANS(lat)))) AS distance_km 
                 FROM freelancer_profiles p
                 JOIN users u ON u.id = p.user_id
                 HAVING distance_km <= ? ORDER BY distance_km LIMIT 80";
        $stmt = $this->db->prepare($sqlF);
        $stmt->execute([$lat, $lng, $lat, $radius]);
        $freelancers = $stmt->fetchAll();

        // Fetch companies
        $sqlC = "SELECT p.*, u.first_name as u_fname, u.last_name as u_lname,
                 (6371 * ACOS(COS(RADIANS(?)) * COS(RADIANS(lat)) * COS(RADIANS(lng) - RADIANS(?)) + SIN(RADIANS(?)) * SIN(RADIANS(lat)))) AS distance_km 
                 FROM company_profiles p
                 JOIN users u ON u.id = p.user_id
                 HAVING distance_km <= ? ORDER BY distance_km LIMIT 80";
        $stmt = $this->db->prepare($sqlC);
        $stmt->execute([$lat, $lng, $lat, $radius]);
        $companies = $stmt->fetchAll();

        $pageTitle = 'Carte des Talents';
        require_once __DIR__ . '/../View/portfolio/map.php';
    }

    /* ------------------------------------------------------------------ */
    /*  CV / PROFIL COMPLET (Skills, Diplomas, Certificates)                */
    /* ------------------------------------------------------------------ */

    public function cv(): void
    {
        $this->requireLogin();
        $userId = (int)$_SESSION['user_id'];
        
        $skills = $this->db->prepare('SELECT * FROM freelancer_skills WHERE user_id=? ORDER BY level DESC');
        $skills->execute([$userId]);
        $skills = $skills->fetchAll();

        $diplomas = $this->db->prepare('SELECT * FROM diplomas WHERE user_id=? ORDER BY graduation_year DESC');
        $diplomas->execute([$userId]);
        $diplomas = $diplomas->fetchAll();

        $certificates = $this->db->prepare('SELECT * FROM certificates WHERE user_id=? ORDER BY created_at DESC');
        $certificates->execute([$userId]);
        $certificates = $certificates->fetchAll();

        $pageTitle = 'Mon CV Portfolio';
        require_once __DIR__ . '/../View/portfolio/cv.php';
    }

    public function addCvItem(): void
    {
        $this->requireLogin();
        $userId = (int)$_SESSION['user_id'];
        $type   = $_POST['type'] ?? '';

        if ($type === 'skill') {
            $name  = trim($_POST['name'] ?? '');
            $level = (int)($_POST['level'] ?? 1);
            if ($name) {
                $this->db->prepare('INSERT INTO freelancer_skills (user_id, name, level) VALUES (?, ?, ?)')
                         ->execute([$userId, $name, $level]);
            }
        } elseif ($type === 'diploma') {
            $title = trim($_POST['title'] ?? '');
            $inst  = trim($_POST['institution'] ?? '');
            $year  = (int)($_POST['graduation_year'] ?? date('Y'));
            if ($title && $inst) {
                $this->db->prepare('INSERT INTO diplomas (user_id, title, institution, graduation_year) VALUES (?, ?, ?, ?)')
                         ->execute([$userId, $title, $inst, $year]);
            }
        } elseif ($type === 'certificate') {
            $title = trim($_POST['title'] ?? '');
            if ($title && !empty($_FILES['file']['name']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $path = $this->handleUpload('file');
                if ($path) {
                    $this->db->prepare('INSERT INTO certificates (user_id, title, file_path) VALUES (?, ?, ?)')
                             ->execute([$userId, $title, $path]);
                }
            }
        }

        $_SESSION['portfolio_flash'] = ['type'=>'success','msg'=>'Élément ajouté avec succès.'];
        header('Location: /workwave/Controller/index.php?action=portfolio_cv');
        exit;
    }

    public function delCvItem(): void
    {
        $this->requireLogin();
        $userId = (int)$_SESSION['user_id'];
        $type   = $_GET['type'] ?? '';
        $id     = (int)($_GET['id'] ?? 0);

        $tables = ['skill' => 'freelancer_skills', 'diploma' => 'diplomas', 'certificate' => 'certificates'];
        if (isset($tables[$type])) {
            $this->db->prepare("DELETE FROM {$tables[$type]} WHERE id=? AND user_id=?")->execute([$id, $userId]);
            $_SESSION['portfolio_flash'] = ['type'=>'success','msg'=>'Élément supprimé.'];
        }

        header('Location: /workwave/Controller/index.php?action=portfolio_cv');
        exit;
    }

    /* ------------------------------------------------------------------ */
    /*  ADMIN LIST                                                          */
    /* ------------------------------------------------------------------ */

    public function adminIndex(): void
    {
        $this->requireRole('admin');
        $projects = $this->db->query(
            'SELECT p.*, u.first_name, u.last_name, u.email
             FROM portfolio_projects p
             JOIN users u ON u.id = p.user_id
             ORDER BY p.created_at DESC'
        )->fetchAll();

        $stats = [
            'total'   => count($projects),
            'users'   => $this->scalar('SELECT COUNT(DISTINCT user_id) FROM portfolio_projects'),
        ];

        $pageTitle = 'Admin — Portfolios';
        require_once __DIR__ . '/../View/portfolio/admin.php';
    }

    /* ------------------------------------------------------------------ */
    /*  HELPERS                                                             */
    /* ------------------------------------------------------------------ */

    private function requireLogin(): void
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /workwave/Controller/index.php?action=login');
            exit;
        }
    }

    private function requireRole(string $role): void
    {
        $this->requireLogin();
        if (($_SESSION['user_role'] ?? '') !== $role) {
            header('Location: /workwave/Controller/index.php?action=portfolio');
            exit;
        }
    }

    private function findProject(int $id, int $userId): ?array
    {
        $role = $_SESSION['user_role'] ?? '';
        if ($role === 'admin') {
            $stmt = $this->db->prepare('SELECT * FROM portfolio_projects WHERE id=?');
            $stmt->execute([$id]);
        } else {
            $stmt = $this->db->prepare('SELECT * FROM portfolio_projects WHERE id=? AND user_id=?');
            $stmt->execute([$id, $userId]);
        }
        return $stmt->fetch() ?: null;
    }

    private function handleUpload(string $field): ?string
    {
        $file = $_FILES[$field];
        if ($file['size'] > 5 * 1024 * 1024) return null;

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime  = $finfo->file($file['tmp_name']);
        $allowed = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp','image/gif'=>'gif'];
        if (!isset($allowed[$mime])) return null;

        $dir = __DIR__ . '/../View/uploads/portfolio/';
        if (!is_dir($dir)) mkdir($dir, 0775, true);

        $name = bin2hex(random_bytes(12)) . '.' . $allowed[$mime];
        if (!move_uploaded_file($file['tmp_name'], $dir . $name)) return null;

        return 'View/uploads/portfolio/' . $name;
    }

    private function scalar(string $sql, array $params = []): int
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    private function ensureTables(): void
    {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS `portfolio_projects` (
                `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `user_id`      INT NOT NULL,
                `title`        VARCHAR(255) NOT NULL,
                `description`  TEXT DEFAULT NULL,
                `technologies` VARCHAR(500) DEFAULT '',
                `github_url`   VARCHAR(500) DEFAULT '',
                `demo_url`     VARCHAR(500) DEFAULT '',
                `image_path`   VARCHAR(500) DEFAULT NULL,
                `created_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                KEY `idx_pp_user` (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }
}
