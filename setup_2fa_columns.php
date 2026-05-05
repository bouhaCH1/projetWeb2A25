<?php
require_once __DIR__ . '/Model/Database.php';

try {
    $pdo = getConnection();
    
    // Add 2FA SMS columns to users table
    $sql = "
        ALTER TABLE users 
        ADD COLUMN sms_2fa_code VARCHAR(10) NULL,
        ADD COLUMN sms_2fa_code_expires DATETIME NULL
    ";
    
    $pdo->exec($sql);
    
    echo "✅ 2FA columns added successfully to users table!\n";
    
} catch (Exception $e) {
    echo "❌ Error adding 2FA columns: " . $e->getMessage() . "\n";
}
?>
