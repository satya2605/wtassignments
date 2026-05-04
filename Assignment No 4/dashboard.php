<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php?error=Please log in to access the secure part of the application.");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Session Active</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #e0f7fa; 
            display: flex; 
            justify-content: center; 
            padding: 60px; 
            margin: 0;
            color: #333;
        }
        .container { 
            background: white; 
            padding: 40px; 
            border-radius: 8px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.08); 
            width: 500px; 
            text-align: center; 
        }
        h1 { color: #00796b; margin-top: 0; }
        .welcome-msg { font-size: 18px; color: #555; margin-bottom: 30px; }
        .info-card { 
            background: #f1f8e9; 
            padding: 20px; 
            border-radius: 6px; 
            border-left: 4px solid #8bc34a; 
            margin: 20px 0; 
            text-align: left; 
        }
        .info-card h3 {
            margin-top: 0;
            color: #558b2f;
            font-size: 16px;
            margin-bottom: 15px;
        }
        .info-row {
            margin-bottom: 10px;
            font-size: 15px;
        }
        .info-row strong {
            display: inline-block;
            width: 100px;
            color: #555;
        }
        .logout-btn { 
            display: inline-block; 
            padding: 12px 25px; 
            background: #e74c3c; 
            color: white; 
            text-decoration: none; 
            border-radius: 4px; 
            margin-top: 25px; 
            font-weight: 500;
            transition: background 0.3s;
        }
        .logout-btn:hover { background: #c0392b; }
        .footer-note {
            color: #888; 
            font-size: 13px;
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard</h1>
        <div class="welcome-msg">Welcome back, <strong><?php echo htmlspecialchars($_SESSION['name']); ?></strong>!</div>
        
        <div class="info-card">
            <h3>Active Session Information</h3>
            <div class="info-row">
                <strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['name']); ?>
            </div>
            <div class="info-row">
                <strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?>
            </div>
            <div class="info-row">
                <strong>Session ID:</strong> <?php echo htmlspecialchars(session_id()); ?>
            </div>
        </div>
        
        <a href="logout.php" class="logout-btn">Logout Securely</a>
        
        <div class="footer-note">
            This protected page verifies the <code>$_SESSION['logged_in']</code> variable. If you try to access it after logging out, you will be redirected to the home page.
        </div>
    </div>
</body>
</html>
