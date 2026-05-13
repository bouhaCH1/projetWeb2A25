<?php
define("FORM_DB_HOST", "localhost");
define("FORM_DB_NAME", "formation");
define("FORM_DB_USER", "root");
define("FORM_DB_PASS", "");
define("FORM_DB_CHARSET", "utf8mb4");

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = "mysql:host=".FORM_DB_HOST.";dbname=".FORM_DB_NAME.";charset=".FORM_DB_CHARSET;
        $opts = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try { $pdo = new PDO($dsn, FORM_DB_USER, FORM_DB_PASS, $opts); }
        catch (PDOException $e) {
            die("<div style='color:red;padding:20px'><h2>Erreur connexion DB</h2><p>".htmlspecialchars($e->getMessage())."</p></div>");
        }
    }
    return $pdo;
}
