<?php
// Database configuration
$host = 'localhost';
$dbname = 'student_feedback_db';
$username = 'root'; // Change if needed
$password = '';     // Change if needed

try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");
    
    // Create table if not exists
    $query = "CREATE TABLE IF NOT EXISTS feedbacks (
        id INT AUTO_INCREMENT PRIMARY KEY,
        studentName VARCHAR(100) NOT NULL,
        course VARCHAR(100) NOT NULL,
        instructor VARCHAR(100) NOT NULL,
        semester VARCHAR(50) NOT NULL,
        rating INT NOT NULL,
        comment TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($query);

} catch (PDOException $e) {
    die("Database Connection Error: " . $e->getMessage());
}
?>
