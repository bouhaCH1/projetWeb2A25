<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;charset=utf8mb4', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    $sql = file_get_contents(__DIR__ . '/workwave6.0/model/schema.sql');

    // Split on semicolons to execute statement by statement
    $statements = array_filter(array_map('trim', explode(';', $sql)));

    foreach ($statements as $stmt) {
        if ($stmt !== '') {
            $pdo->exec($stmt);
        }
    }

    echo "<h2 style='color:green'>✅ Database workwave6_0 created successfully!</h2>";
    echo "<p>All tables have been created. You can now <a href='/workwave/workwave6.0/controller/index.php'>go back to the app</a>.</p>";
    echo "<p><strong>Admin credentials:</strong> email: <code>admin</code> / password: <code>admin</code></p>";

} catch (Exception $e) {
    echo "<h2 style='color:red'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</h2>";
}
