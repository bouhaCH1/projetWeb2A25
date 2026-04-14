<?php
/**
 * setup_admin.php — Run this file ONCE in the browser to create/reset the admin account.
 * URL: http://localhost/workwave/Model/setup_admin.php
 * DELETE this file after use for security!
 */

require_once __DIR__ . '/Database.php';

$adminEmail    = 'admin@workwave.com';
$adminPassword = 'Admin1234';
$adminFirst    = 'Admin';
$adminLast     = 'WorkWave';

$pdo  = getConnection();
$hash = password_hash($adminPassword, PASSWORD_BCRYPT);

// Ensure the ENUM has the 'admin' value (for existing databases)
try {
    $pdo->exec("ALTER TABLE users MODIFY COLUMN role ENUM('job_seeker','employer','admin') NOT NULL DEFAULT 'job_seeker'");
} catch (PDOException $e) {
    // Already has admin or alter not needed — ignore
}

// Insert or update the admin account
$stmt = $pdo->prepare(
    "INSERT INTO users (first_name, last_name, email, password, role)
     VALUES (:fn, :ln, :email, :pwd, 'admin')
     ON DUPLICATE KEY UPDATE password=:pwd2, role='admin', first_name=:fn2, last_name=:ln2"
);
$stmt->execute([
    ':fn'    => $adminFirst,
    ':ln'    => $adminLast,
    ':email' => $adminEmail,
    ':pwd'   => $hash,
    ':pwd2'  => $hash,
    ':fn2'   => $adminFirst,
    ':ln2'   => $adminLast,
]);

echo '<h2 style="font-family:sans-serif;color:green;">✅ Admin account created / updated!</h2>';
echo '<p style="font-family:sans-serif;">Email: <strong>' . htmlspecialchars($adminEmail) . '</strong></p>';
echo '<p style="font-family:sans-serif;">Password: <strong>' . htmlspecialchars($adminPassword) . '</strong></p>';
echo '<p style="font-family:sans-serif;color:red;"><strong>⚠️ Delete this file now: Model/setup_admin.php</strong></p>';
echo '<p style="font-family:sans-serif;"><a href="/workwave/Controller/index.php?action=login">Go to Login →</a></p>';
