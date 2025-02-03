<?php
try {
    $pdo = new PDO("mysql:host=127.0.0.1;port=3306", "root", "password");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "CREATE DATABASE IF NOT EXISTS rop1 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $pdo->exec($sql);
    echo "Database created successfully\n";
} catch(PDOException $e) {
    echo "Error creating database: " . $e->getMessage() . "\n";
}
?>
