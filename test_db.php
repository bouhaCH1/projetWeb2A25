<?php
require_once 'config/Database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    echo "Connexion à la base de données réussie!<br>";

    // Test query
    $stmt = $db->query("SELECT COUNT(*) as total FROM mission");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Nombre de missions dans la base: " . $result['total'];
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage();
}
?>