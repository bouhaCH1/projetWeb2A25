<?php
$pdo = new PDO('mysql:host=127.0.0.1', 'root', '');
$stmt = $pdo->query('SHOW DATABASES');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

$stmt = $pdo->query('SHOW TABLES IN job_platform');
if ($stmt) {
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
} else {
    echo "job_platform not found or error\n";
}

$stmt = $pdo->query('SHOW TABLES IN workwave6_0');
if ($stmt) {
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
} else {
    echo "workwave6_0 not found or error\n";
}
