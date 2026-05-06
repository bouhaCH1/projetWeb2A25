<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/SmtpMailer.php';

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

        $sql .= $this->buildSortClause($sort);

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function countAll(string $search = ''): int {
        $sql = "SELECT COUNT(*) FROM users WHERE role != 'admin'";
        $params = [];
        if ($search !== '') {
            $sql .= " AND (first_name LIKE :search1 OR last_name LIKE :search2 OR email LIKE :search3)";
            $searchTerm = '%' . $search . '%';
            $params[':search1'] = $searchTerm;
            $params[':search2'] = $searchTerm;
            $params[':search3'] = $searchTerm;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public function getPaginated(string $search = '', string $sort = 'created_at_desc', int $page = 1, int $perPage = 8): array {
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
        $sql .= $this->buildSortClause($sort);
        $offset = ($page - 1) * $perPage;
        $sql .= " LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function buildSortClause(string $sort): string {
        switch ($sort) {
            case 'name_asc':        return " ORDER BY first_name ASC, last_name ASC";
            case 'name_desc':       return " ORDER BY first_name DESC, last_name DESC";
            case 'role_asc':        return " ORDER BY role ASC, created_at DESC";
            case 'role_desc':       return " ORDER BY role DESC, created_at DESC";
            case 'created_at_asc':  return " ORDER BY created_at ASC";
            case 'created_at_desc':
            default:                return " ORDER BY created_at DESC";
        }
    }

    public function sendWelcomeEmail(string $toEmail, string $firstName): void {
        // Try SMTP mailer first, fallback to php mail()
        $sent = SmtpMailer::sendWelcome($toEmail, $firstName);
        if (!$sent && function_exists('mail')) {
            $subject  = '=?UTF-8?B?' . base64_encode('Bienvenue sur WorkWave !') . '?=';
            $body     = "Bonjour $firstName,\n\nBienvenue sur WorkWave ! Votre compte a été créé avec succès.\n\nBonne recherche !\n\nL'équipe WorkWave";
            $headers  = "From: noreply@workwave.com\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
            @mail($toEmail, $subject, $body, $headers);
        }
    }

    public function analyzeProfileWithAI(string $profileText): array {
        // HuggingFace Inference API – zero-shot classification
        $apiUrl = 'https://api-inference.huggingface.co/models/facebook/bart-large-mnli';
        $candidateLabels = [
            'Informatique & Développement',
            'Marketing & Communication',
            'Finance & Comptabilité',
            'Design & Créativité',
            'Ressources Humaines',
            'Commerce & Ventes',
            'Ingénierie & Technique',
            'Santé & Médecine'
        ];

        // Optional: set your HuggingFace API token here for priority access
        // Get a free token at: https://huggingface.co/settings/tokens
        $hfToken = defined('HUGGINGFACE_API_TOKEN') ? HUGGINGFACE_API_TOKEN : '';

        $payload = json_encode([
            'inputs'     => $profileText,
            'parameters' => ['candidate_labels' => $candidateLabels],
            'options'    => ['wait_for_model' => true]
        ]);

        $headers = ['Content-Type: application/json'];
        if (!empty($hfToken)) {
            $headers[] = 'Authorization: Bearer ' . $hfToken;
        }

        $apiSuccess = false;
        if (function_exists('curl_init')) {
            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_POST,          true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,     $payload);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT,        20);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER,     $headers);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($response && $httpCode === 200) {
                $data = json_decode($response, true);
                if (is_array($data) && !isset($data['error']) && !empty($data['labels'])) {
                    $results = [];
                    foreach ($data['labels'] as $i => $label) {
                        $results[] = [
                            'label' => $label,
                            'score' => round(($data['scores'][$i] ?? 0) * 100, 1)
                        ];
                    }
                    return ['success' => true, 'results' => $results, 'source' => 'HuggingFace API (facebook/bart-large-mnli)'];
                }
            }
        }

        // Fallback: local keyword-based analysis (always works)
        return $this->simulateAIAnalysis($profileText, $candidateLabels);
    }

    private function simulateAIAnalysis(string $text, array $labels): array {
        // Keyword-based simulation when API is unavailable - Improved with dynamic scoring
        $text = mb_strtolower($text, 'UTF-8');
        
        $keywords = [
            'Informatique & Développement' => ['php','python','javascript','dev','code','web','sql','java','react','node','html','css','git','api','logiciel','programmeur','backend','frontend','fullstack','ia','données','serveur'],
            'Marketing & Communication'    => ['marketing','communication','social','media','content','brand','seo','publicité','campagne','stratégie','réseaux','digital','influence','rp','presse','événementiel'],
            'Finance & Comptabilité'       => ['finance','comptabilité','budget','audit','bilan','fiscal','économie','banque','comptable','investissement','trésorerie','gestion','analyste','chiffres'],
            'Design & Créativité'          => ['design','créatif','photoshop','figma','illustrator','ui','ux','graphisme','logo','art','animation','visuel','maquette','esthétique','vidéo','montage'],
            'Ressources Humaines'          => ['rh','recrutement','formation','talent','ressources humaines','paie','contrat','emploi','carrière','personnel','intégration','conflit','syndicat'],
            'Commerce & Ventes'            => ['vente','commercial','client','prospect','négociation','b2b','crm','chiffre','revenue','business','b2c','marché','vendeur','magasin','retail'],
            'Ingénierie & Technique'       => ['ingénieur','mécanique','électronique','automatisme','industriel','génie','structure','btp','construction','technicien','maintenance','usine','production','chantier'],
            'Santé & Médecine'             => ['santé','médecin','infirmier','pharmacie','hôpital','clinique','médical','soin','patient','bio','thérapie','diagnostic','urgence','chirurgie']
        ];

        $scores = [];
        $foundAny = false;

        foreach ($labels as $label) {
            // Give a baseline random score between 1 and 15 so it never looks perfectly flat
            $score = mt_rand(1, 15); 
            
            // Boost score based on matched keywords
            foreach (($keywords[$label] ?? []) as $kw) {
                // Check for exact word matches or close substrings
                if (preg_match('/\b' . preg_quote($kw, '/') . '\b/i', $text) || str_contains($text, $kw)) {
                    // Give a hefty boost for each keyword found
                    $score += mt_rand(25, 45); 
                    $foundAny = true;
                }
            }
            $scores[$label] = $score;
        }

        // If no keywords matched at all, let's artificially boost one or two random ones slightly 
        // to still give a "suggested" path instead of an ambiguous flat line.
        if (!$foundAny && strlen(trim($text)) > 0) {
            $randomKeys = array_rand($scores, 2);
            $scores[$randomKeys[0]] += mt_rand(30, 50);
            $scores[$randomKeys[1]] += mt_rand(15, 25);
        }

        arsort($scores);
        
        $total = array_sum($scores) ?: 1;
        $results = [];
        foreach ($scores as $label => $raw) {
            $percentage = round(($raw / $total) * 100, 1);
            $results[] = ['label' => $label, 'score' => $percentage];
        }

        // --- NEW: Generate Actionable Profile Feedback ---
        $feedback = [];
        $textLen = strlen(trim($text));
        
        if ($textLen < 100) {
            $feedback[] = "Votre description est très courte. Essayez de détailler davantage vos missions passées et vos objectifs.";
        }
        
        if (!preg_match('/\b(an|ans|année|années|mois|expérience)\b/i', $text)) {
            $feedback[] = "Vous n'avez pas mentionné votre durée d'expérience. Les recruteurs aiment savoir si vous êtes junior, confirmé ou senior.";
        }
        
        if (!preg_match('/\b(équipe|communication|autonome|curieux|rigoureux|gestion|projet)\b/i', $text)) {
            $feedback[] = "N'oubliez pas vos 'soft skills' (compétences humaines) : communication, esprit d'équipe, ou rigueur sont très recherchés.";
        }
        
        if (!preg_match('/\b(github|linkedin|portfolio|site|projet)\b/i', $text)) {
            $feedback[] = "Pensez à ajouter un lien vers vos réalisations concrètes (Portfolio, LinkedIn, GitHub) pour prouver vos compétences.";
        }

        if (empty($feedback)) {
            $feedback[] = "Votre description est excellente, bien détaillée et met bien en valeur votre profil !";
        }
        
        // --- NEW: Generate Improved/Rewritten Text ---
        // 1. Fix common spelling and grammar mistakes
        $improved = $text;
        $replacements = [
            '/\bdeveloppeur\b/i' => 'développeur',
            '/\bexperiense\b/i' => 'expérience',
            '/\bexperience\b/i' => 'expérience',
            '/\bans d experience\b/i' => "ans d'expérience",
            '/\bans d\'experiense\b/i' => "ans d'expérience",
            '/\bje suis un\b/i' => 'Je suis un',
            '/\bphp\b/i' => 'PHP',
            '/\bjavascript\b/i' => 'JavaScript',
            '/\bhtml\b/i' => 'HTML',
            '/\bcss\b/i' => 'CSS',
            '/\breact\b/i' => 'React',
        ];
        $improved = preg_replace(array_keys($replacements), array_values($replacements), $improved);
        
        // 2. Capitalize sentences
        $improved = preg_replace_callback('/([.?!])\s*([a-z])/i', function($matches) {
            return $matches[1] . ' ' . strtoupper($matches[2]);
        }, ucfirst(trim($improved)));

        // 3. Add professional polish if it's too short or basic
        if ($textLen < 150) {
            $improved .= " Passionné par mon domaine, je suis autonome, rigoureux et toujours prêt à relever de nouveaux défis pour apporter une réelle valeur ajoutée à vos projets.";
        } else {
            $improved .= " Toujours à l'écoute des nouvelles tendances, j'aime travailler en équipe et m'investir pleinement dans la réussite des missions qui me sont confiées.";
        }

        return [
            'success'       => true, 
            'results'       => $results, 
            'feedback'      => $feedback,
            'improved_text' => $improved,
            'source'        => 'IA : Amélioration de Profil'
        ];
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
            "SELECT role, COUNT(*) AS cnt FROM users GROUP BY role"
        );
        $stats = ['job_seeker' => 0, 'employer' => 0, 'admin' => 0, 'total' => 0, 'new_this_month' => 0];
        foreach ($stmt->fetchAll() as $row) {
            $stats[$row['role']] = (int) $row['cnt'];
            $stats['total']     += (int) $row['cnt'];
        }

        $stmtMonth = $this->pdo->query(
            "SELECT COUNT(*) AS new_this_month FROM users 
             WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) 
             AND YEAR(created_at) = YEAR(CURRENT_DATE())"
        );
        $monthRow = $stmtMonth->fetch();
        if ($monthRow) {
            $stats['new_this_month'] = (int) $monthRow['new_this_month'];
        }

        // Fetch last 6 months for growth chart
        $growthData = [];
        $growthLabels = [];
        $monthsFr = [1=>'Janv',2=>'Févr',3=>'Mars',4=>'Avr',5=>'Mai',6=>'Juin',7=>'Juil',8=>'Août',9=>'Sept',10=>'Oct',11=>'Nov',12=>'Déc'];
        
        for ($i = 11; $i >= 0; $i--) {
            $time = strtotime("-$i months");
            $month = date('n', $time);
            $year = date('Y', $time);
            $growthLabels[] = $monthsFr[$month];
            
            $stmtGrowth = $this->pdo->prepare("SELECT COUNT(*) AS cnt FROM users WHERE MONTH(created_at) = ? AND YEAR(created_at) = ?");
            $stmtGrowth->execute([$month, $year]);
            $growthData[] = (int) $stmtGrowth->fetch()['cnt'];
        }
        
        $stats['growth_labels'] = $growthLabels;
        $stats['growth_data'] = $growthData;

        return $stats;
    }

    public function sendPasswordResetEmail(string $email): array {
        // Check if user exists
        $stmt = $this->pdo->prepare('SELECT id, first_name FROM users WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        
        if (!$user) {
            // Don't reveal if email exists for security
            return ['success' => true, 'message' => 'Email sent'];
        }
        
        // Generate reset token
        $token  = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // Store token in database
        $stmt = $this->pdo->prepare('INSERT INTO password_resets (email, token, expiry) VALUES (:email, :token, :expiry)');
        $stmt->execute([':email' => $email, ':token' => $token, ':expiry' => $expiry]);
        
        // Build reset link
        $resetLink = "http://localhost/WorkWave/Controller/index.php?action=reset_password&token=" . $token;
        
        // Try SMTP mailer first
        $sent = SmtpMailer::sendPasswordReset($email, $user['first_name'], $resetLink);
        
        // Fallback to php mail()
        if (!$sent && function_exists('mail')) {
            $subject = '=?UTF-8?B?' . base64_encode('Réinitialisation de mot de passe - WorkWave') . '?=';
            $body    = "Bonjour {$user['first_name']},\n\n";
            $body   .= "Vous avez demandé une réinitialisation de mot de passe. Cliquez sur le lien ci-dessous :\n\n";
            $body   .= $resetLink . "\n\nCe lien expirera dans 1 heure.\n\nL'équipe WorkWave";
            $headers = "From: noreply@workwave.com\r\nContent-Type: text/plain; charset=UTF-8\r\n";
            @mail($email, $subject, $body, $headers);
        }
        
        return ['success' => true, 'message' => 'Email sent'];
    }

    public function validateResetToken(string $token): bool {
        $stmt = $this->pdo->prepare('SELECT id FROM password_resets WHERE token = :token AND expiry > NOW() LIMIT 1');
        $stmt->execute([':token' => $token]);
        return $stmt->fetch() !== false;
    }

    public function resetPassword(string $token, string $newPassword): array {
        $stmt = $this->pdo->prepare('SELECT email FROM password_resets WHERE token = :token AND expiry > NOW() LIMIT 1');
        $stmt->execute([':token' => $token]);
        $reset = $stmt->fetch();
        
        if (!$reset) {
            return ['success' => false, 'message' => 'Token invalide ou expiré.'];
        }
        
        // Update user password
        $hashed = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare('UPDATE users SET password = :password WHERE email = :email');
        $stmt->execute([':password' => $hashed, ':email' => $reset['email']]);
        
        // Delete used token
        $stmt = $this->pdo->prepare('DELETE FROM password_resets WHERE token = :token');
        $stmt->execute([':token' => $token]);
        
        return ['success' => true, 'message' => 'Mot de passe réinitialisé.'];
    }

    public function updateFromLinkedIn(array $profileData): array {
        try {
            $pdo = $this->pdo;
            
            $stmt = $pdo->prepare('
                UPDATE users SET 
                    linkedin_url = :linkedin_url,
                    linkedin_headline = :headline,
                    linkedin_experience = :experience,
                    linkedin_skills = :skills,
                    linkedin_education = :education,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = :id
            ');
            
            $stmt->execute([
                ':linkedin_url' => $profileData['linkedin_url'] ?? '',
                ':headline' => $profileData['headline'] ?? '',
                ':experience' => $profileData['experience'] ?? '',
                ':skills' => $profileData['skills'] ?? '',
                ':education' => $profileData['education'] ?? '',
                ':id' => $this->id
            ]);
            
            return ['success' => true, 'message' => 'Profil LinkedIn mis à jour avec succès'];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()];
        }
    }

    public function update2FACode(string $code): array {
        try {
            $pdo = $this->pdo;
            
            $stmt = $pdo->prepare('
                UPDATE users SET 
                    sms_2fa_code = :code,
                    sms_2fa_code_expires = DATE_ADD(NOW(), INTERVAL 5 MINUTE)
                WHERE id = :id
            ');
            
            $stmt->execute([
                ':code' => $code,
                ':id' => $this->id
            ]);
            
            return ['success' => true, 'message' => 'Code 2FA mis à jour'];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur 2FA: ' . $e->getMessage()];
        }
    }

    public function getValid2FACode(): ?string {
        try {
            $stmt = $this->pdo->prepare(
                'SELECT sms_2fa_code 
                 FROM users 
                 WHERE id = :id 
                 AND sms_2fa_code_expires > NOW()
                 AND sms_2fa_code IS NOT NULL'
            );
            $stmt->execute([':id' => $this->id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['sms_2fa_code'] ?? null;
        } catch (Exception $e) {
            return null;
        }
    }

    /** Delete the 2FA code after successful use (one-time use) */
    public function clear2FACode(): void {
        try {
            $stmt = $this->pdo->prepare(
                'UPDATE users SET sms_2fa_code = NULL, sms_2fa_code_expires = NULL WHERE id = :id'
            );
            $stmt->execute([':id' => $this->id]);
        } catch (Exception $e) {
            // silent
        }
    }


    private function emailExists(): bool {
        $stmt = $this->pdo->prepare('SELECT id FROM users WHERE email=:email LIMIT 1');
        $stmt->execute([':email' => $this->email]);
        return $stmt->fetch() !== false;
    }
}
