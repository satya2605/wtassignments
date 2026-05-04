<?php
// Database configuration - Detecting PHPSandbox environment or local
$host = getenv('DB_HOST') ?: '127.0.0.1';
$user = getenv('DB_USERNAME') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';
$db   = getenv('DB_DATABASE') ?: 'vit_results_db';

// Create connection
$conn = new mysqli($host, $user, $pass);

// Check connection
if ($conn->connect_error) {
    // Silently continue so the API can still return fallback data if DB is down
    $db_connected = false;
} else {
    $db_connected = true;
    $conn->query("CREATE DATABASE IF NOT EXISTS $db");
    $conn->select_db($db);
}

// Create database if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS $db");
$conn->select_db($db);

// Table creation if not exists (in case the user doesn't run database.sql)
$table_sql = "CREATE TABLE IF NOT EXISTS student_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    course VARCHAR(100) NOT NULL,
    wt_mse INT DEFAULT 0,
    wt_ese INT DEFAULT 0,
    os_mse INT DEFAULT 0,
    os_ese INT DEFAULT 0,
    ai_mse INT DEFAULT 0,
    ai_ese INT DEFAULT 0,
    dbms_mse INT DEFAULT 0,
    dbms_ese INT DEFAULT 0
)";
$conn->query($table_sql);

// Check if table is empty, seed initial data if so
$check_empty = $conn->query("SELECT COUNT(*) as count FROM student_results");
$row = $check_empty->fetch_assoc();
if ($row['count'] == 0) {
    $conn->query("INSERT INTO student_results (student_name, course, wt_mse, wt_ese, os_mse, os_ese, ai_mse, ai_ese, dbms_mse, dbms_ese)
    VALUES 
    ('Satya Nadella', 'B.Tech IT', 25, 65, 28, 60, 22, 55, 26, 68),
    ('Sundar Pichai', 'B.Tech CSE', 29, 68, 27, 62, 24, 58, 28, 64),
    ('Sam Altman', 'B.Tech AI-DS', 15, 30, 18, 35, 12, 25, 20, 28)");
}
?>
