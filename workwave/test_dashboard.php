<?php
session_start();
$_SESSION['user'] = [
    'id' => 1, // Assume a valid user id
    'username' => 'testuser',
    'full_name' => 'Test User',
    'email' => 'test@test.com',
    'company' => '',
    'role' => 'candidat'
];

require_once 'controller/CandidatController.php';

try {
    $controller = new CandidatController();
    $controller->dashboard();
} catch (Throwable $e) {
    echo "FATAL ERROR CAUGHT:\n";
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
