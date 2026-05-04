<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    // Process form using POST method (Done by checking $_SERVER and using $_POST)
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: index.php?error=Invalid email format provided.");
        exit;
    }

    if (empty($name) || empty($password)) {
        header("Location: index.php?error=All fields are required.");
        exit;
    }

    // Create cookie to store username
    if ($remember) {
        // Store for 30 days
        setcookie("username", $name, time() + (86400 * 30), "/"); 
    } else {
        // Clear cookie if not checked
        setcookie("username", "", time() - 3600, "/");
    }

    // Implement session-based login example
    // In a real app, verify password from database here
    $_SESSION['logged_in'] = true;
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;

    header("Location: dashboard.php");
    exit;
} else {
    // If accessed directly without POST
    header("Location: index.php");
    exit;
}
