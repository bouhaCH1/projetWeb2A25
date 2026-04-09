<?php
$host = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS plateforme_travail CHARACTER SET utf8 COLLATE utf8_general_ci";
    $conn->exec($sql);
    echo "Base de données créée avec succès.<br>";

    // Select database
    $conn->exec("USE plateforme_travail");

    // Create table
    $sql = "CREATE TABLE IF NOT EXISTS mission (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titre VARCHAR(255) NOT NULL,
        description TEXT,
        budget DECIMAL(10,2),
        date_debut DATE,
        date_fin DATE,
        statut ENUM('ouverte', 'en_cours', 'terminee', 'annulee') DEFAULT 'ouverte',
        competences TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->exec($sql);
    echo "Table mission créée avec succès.<br>";

    // Insert sample data
    $sql = "INSERT INTO mission (titre, description, budget, date_debut, date_fin, statut, competences) VALUES
    ('Développement site web', 'Création d\'un site web responsive pour une entreprise locale.', 2500.00, '2024-05-01', '2024-06-15', 'ouverte', 'HTML, CSS, JavaScript, PHP'),
    ('Application mobile', 'Développement d\'une app mobile pour la gestion des tâches.', 4000.00, '2024-05-10', '2024-07-20', 'ouverte', 'React Native, Firebase'),
    ('Analyse de données', 'Analyse des ventes et création de rapports pour une entreprise.', 1800.00, '2024-04-20', '2024-05-10', 'en_cours', 'Python, Pandas, SQL')";
    $conn->exec($sql);
    echo "Données d'exemple insérées avec succès.";

} catch (PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
?>