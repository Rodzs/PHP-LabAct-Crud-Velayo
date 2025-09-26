<?php
$host = 'localhost';
$dbname = 'student_lab_db';
$username = 'root';
$password = '';

$init_result = initializeDatabase();
if ($init_result !== true) {
    die($init_result);
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
function initializeDatabase() {
    global $host, $username, $password, $dbname;
    
    try {
        $pdo_init = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
        $pdo_init->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $pdo_init->exec("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $pdo_init->exec("USE $dbname");
        $createTable = "
            CREATE TABLE IF NOT EXISTS students (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                age INT NOT NULL CHECK (age >= 16 AND age <= 100),
                course VARCHAR(100) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
        ";
        
        $pdo_init->exec($createTable);
        
        return true;
        
    } catch (PDOException $e) {
        return "Database initialization failed: " . $e->getMessage();
    }
}
?>