<?php
declare(strict_types=1);

$host = getenv('WORKWAVE_DB_HOST') ?: '127.0.0.1';
$userName = getenv('WORKWAVE_DB_USER') ?: 'root';
$pass = getenv('WORKWAVE_DB_PASS') ?: '';
$db = new PDO("mysql:host={$host};charset=utf8mb4", $userName, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_TIMEOUT => 5,
]);
$schema = file_get_contents(__DIR__ . '/schema.sql');
$db->exec($schema);

$password = password_hash('Workwave@2026', PASSWORD_DEFAULT);
$cities = [
    ['Tunis', 'Tunis', 36.8065, 10.1815], ['Ariana', 'Ariana', 36.8625, 10.1956],
    ['Sousse', 'Sousse', 35.8256, 10.6084], ['Sfax', 'Sfax', 34.7406, 10.7603],
    ['Nabeul', 'Nabeul', 36.4561, 10.7376], ['Monastir', 'Monastir', 35.7643, 10.8113],
    ['Bizerte', 'Bizerte', 37.2744, 9.8739], ['Gabes', 'Gabes', 33.8815, 10.0982],
];
$industries = ['Software', 'FinTech', 'HealthTech', 'E-commerce', 'Education', 'Marketing', 'Cybersecurity', 'Design'];
$skills = ['PHP', 'MySQL', 'JavaScript', 'HTML', 'CSS', 'UI Design', 'SEO', 'Data Analysis', 'Cybersecurity', 'Laravel Migration', 'API Design', 'Project Management'];
$first = ['Amir','Maya','Yassine','Nour','Sami','Ines','Malek','Rania','Omar','Lina','Karim','Sarra','Adam','Yosra','Mehdi','Hiba'];
$last = ['Ben Ali','Trabelsi','Mansour','Haddad','Chaabane','Gharbi','Jaziri','Mejri','Ayari','Kacem','Mabrouk','Saidi'];
$companyWords = ['Nexa','Medina','Carthage','Byte','Olive','Atlas','Blue','Spark','Nova','Dar','Vertex','Wave','Smart','Cloud','Pixel','Trust'];
$credentials = [[
    'id' => 1,
    'name' => 'Administrateur',
    'role' => 'ADMIN',
    'email' => 'admin',
    'username' => 'admin',
    'password' => 'Admin@2026!',
]];

$user = $db->prepare('INSERT INTO users(role,email,password_hash,status,created_at) VALUES(?,?,?,?,NOW())');
$company = $db->prepare('INSERT INTO company_profiles(user_id,logo_path,company_name,description,industry,address,city,governorate,email,phone,website,lat,lng) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)');
$job = $db->prepare('INSERT INTO jobs(company_id,title,description,required_skills,salary,location,contract_type,experience_level,category,expiration_date,status,created_at) VALUES(?,?,?,?,?,?,?,?,?,?,?,NOW())');

$companyIds = [];
for ($i = 1; $i <= 64; $i++) {
    $city = $cities[$i % count($cities)];
    $name = $companyWords[$i % count($companyWords)] . ' ' . $industries[$i % count($industries)] . ' Studio';
    $email = 'company' . str_pad((string)$i, 3, '0', STR_PAD_LEFT) . '@workwave.local';
    $user->execute(['company', $email, $password, 'active']);
    $uid = (int)$db->lastInsertId();
    $credentials[] = [
        'id' => $uid,
        'name' => $name,
        'role' => 'ENTREPRISE',
        'email' => $email,
        'username' => $email,
        'password' => 'Workwave@2026',
    ];
    $company->execute([$uid, null, $name, "A growing {$industries[$i % count($industries)]} company hiring verified freelance talent for digital projects.", $industries[$i % count($industries)], ($i + 10) . ' Avenue Habib Bourguiba', $city[0], $city[1], $email, '+216 2' . str_pad((string)$i, 7, '0'), 'https://company' . $i . '.workwave.local', $city[2] + ($i / 1000), $city[3] + ($i / 1000)]);
    $cid = (int)$db->lastInsertId();
    $companyIds[] = $cid;
    for ($j = 1; $j <= 3; $j++) {
        $jobSkill = $skills[($i + $j) % count($skills)] . ', ' . $skills[($i + $j + 2) % count($skills)];
        $job->execute([$cid, "{$skills[($i + $j) % count($skills)]} Freelancer", "Deliver a professional project with clean communication, weekly milestones and production-ready output.", $jobSkill, rand(900, 6500), $city[0], ['remote','onsite','hybrid'][$j % 3], ['junior','mid','senior','lead'][$j % 4], $industries[$i % count($industries)], date('Y-m-d', strtotime('+' . rand(20, 120) . ' days')), 'open']);
    }
}

$freelancer = $db->prepare('INSERT INTO freelancer_profiles(user_id,avatar_path,cv_path,first_name,last_name,phone,address,city,governorate,bio,linkedin,github,website,qr_token,lat,lng,profile_views) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
$skillStmt = $db->prepare('INSERT INTO freelancer_skills(user_id,name,category,level) VALUES(?,?,?,?)');
$diplomaStmt = $db->prepare('INSERT INTO diplomas(user_id,title,institution,graduation_year) VALUES(?,?,?,?)');
$certStmt = $db->prepare('INSERT INTO certificates(user_id,title,file_path,created_at) VALUES(?,?,?,NOW())');
$projectStmt = $db->prepare('INSERT INTO portfolio_projects(user_id,title,description,technologies,github_url,demo_url,image_path,created_at) VALUES(?,?,?,?,?,?,?,NOW())');
$freelancerIds = [];
for ($i = 1; $i <= 128; $i++) {
    $city = $cities[$i % count($cities)];
    $fn = $first[$i % count($first)];
    $ln = $last[$i % count($last)];
    $email = 'freelancer' . str_pad((string)$i, 3, '0', STR_PAD_LEFT) . '@workwave.local';
    $user->execute(['freelancer', $email, $password, 'active']);
    $uid = (int)$db->lastInsertId();
    $credentials[] = [
        'id' => $uid,
        'name' => $fn . ' ' . $ln,
        'role' => 'FREELANCER',
        'email' => $email,
        'username' => $email,
        'password' => 'Workwave@2026',
    ];
    $freelancer->execute([$uid, null, null, $fn, $ln, '+216 5' . str_pad((string)$i, 7, '0'), ($i + 3) . ' Rue de la Liberte', $city[0], $city[1], "Freelance specialist in {$skills[$i % count($skills)]}, product delivery and collaborative remote work.", 'https://linkedin.com/in/workwave' . $i, 'https://github.com/workwave' . $i, 'https://portfolio' . $i . '.workwave.local', bin2hex(random_bytes(16)), $city[2] + ($i / 2000), $city[3] + ($i / 2000), rand(12, 900)]);
    $fid = (int)$db->lastInsertId();
    $freelancerIds[] = $fid;
    for ($s = 0; $s < 5; $s++) {
        $skillStmt->execute([$uid, $skills[($i + $s) % count($skills)], ['Engineering','Design','Business'][$s % 3], rand(55, 98)]);
    }
    $diplomaStmt->execute([$uid, 'Professional Bachelor in Computer Science', 'University of ' . $city[0], rand(2014, 2025)]);
    $certStmt->execute([$uid, 'Verified Workwave Certificate', 'view/frontoffice/uploads/certificates/demo-certificate.pdf']);
    for ($p = 1; $p <= 2; $p++) {
        $projectStmt->execute([$uid, "Project {$p} by {$fn}", 'A polished freelance project with measurable business impact and maintainable code.', $skills[$i % count($skills)] . ', ' . $skills[($i + 1) % count($skills)], 'https://github.com/workwave/project' . $i . '-' . $p, 'https://demo.workwave.local/project' . $i . '-' . $p, null]);
    }
}

$jobs = $db->query('SELECT id FROM jobs')->fetchAll(PDO::FETCH_COLUMN);
$app = $db->prepare('INSERT IGNORE INTO applications(job_id,freelancer_id,message,status,created_at) VALUES(?,?,?,?,NOW())');
foreach ($freelancerIds as $index => $fid) {
    for ($a = 0; $a < 4; $a++) {
        $app->execute([$jobs[($index + $a) % count($jobs)], $fid, 'I can deliver this project with clear milestones and reliable communication.', ['pending','accepted','rejected'][$a % 3]]);
    }
}

$lines = ["=== LISTE DES UTILISATEURS DU PROJET WORKWAVE ===", ""];
foreach ($credentials as $entry) {
    $lines[] = 'ID : ' . $entry['id'];
    $lines[] = 'Nom complet : ' . $entry['name'];
    $lines[] = 'Role : ' . $entry['role'];
    $lines[] = 'Email : ' . $entry['email'];
    $lines[] = "Nom d'utilisateur : " . $entry['username'];
    $lines[] = 'Mot de passe : ' . $entry['password'];
    $lines[] = '--------------------------------------------------';
}
file_put_contents(__DIR__ . '/legacy/utilisateurs.txt', implode(PHP_EOL, $lines) . PHP_EOL);

$db->exec("INSERT INTO activity_logs(user_id,action,details,ip_address,created_at) VALUES(NULL,'seed.complete','Generated 64 companies, 128 freelancers, jobs, portfolios and applications','cli',NOW())");
echo "WORKWAVE database seeded.\nAdmin login: admin / Admin@2026!\nDemo password for generated users: Workwave@2026\nCredentials file: model/legacy/utilisateurs.txt\n";
