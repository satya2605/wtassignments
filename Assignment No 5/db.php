<?php
// SQLite database path provided by the sandbox
$db_path = '/var/www/database.sqlite';

try {
    // 1. Connect to SQLite database (it will create the file if it doesn't exist)
    $pdo = new PDO("sqlite:" . $db_path);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 2. Create table students (SQLite syntax)
    $sql = "CREATE TABLE IF NOT EXISTS students (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL
    )";
    $pdo->exec($sql);
    
} catch(PDOException $e) {
    $errorMsg = $e->getMessage();
    $customMsg = "<h2>SQLite Connection Failed!</h2>";
    $customMsg .= "<p><strong>Error Details:</strong> $errorMsg</p>";
    $customMsg .= "<div style='background:#fff3cd; padding:15px; border-left:5px solid #ffecb5;'>";
    $customMsg .= "<h3>🛠️ Troubleshooting:</h3>";
    $customMsg .= "<p>Ensure the sandbox has write permissions to <code>$db_path</code>.</p>";
    $customMsg .= "</div>";
    
    die($customMsg);
}
?>
