<?php
session_start();

// Process form using GET method
if (isset($_GET['name']) && isset($_GET['email'])) {
    $name = trim($_GET['name']);
    $email = trim($_GET['email']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format received via GET!";
        $color = "#e74c3c";
        $bg = "#fadbd8";
        $border = "#e74c3c";
    } else {
        $message = "Successfully received valid data via GET method!";
        $color = "#27ae60";
        $bg = "#d5f5e3";
        $border = "#27ae60";
    }
} else {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GET Processing</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Verdana, sans-serif; 
            background: #f4f7f6; 
            padding: 50px; 
            display: flex;
            justify-content: center;
            margin: 0;
        }
        .box { 
            background: white; 
            padding: 40px; 
            border-radius: 8px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
            text-align: left;
            width: 400px;
        }
        .alert {
            padding: 15px;
            border-radius: 4px;
            color: <?php echo $color; ?>;
            background-color: <?php echo $bg; ?>;
            border-left: 4px solid <?php echo $border; ?>;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .data-row {
            margin-bottom: 10px;
            font-size: 16px;
            color: #555;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .data-row strong {
            color: #333;
            display: inline-block;
            width: 150px;
        }
        a.back-btn { 
            display: inline-block; 
            margin-top: 25px; 
            color: white; 
            background: #3498db;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none; 
            transition: background 0.3s;
            font-weight: 500;
        }
        a.back-btn:hover { background: #2980b9; }
    </style>
</head>
<body>
    <div class="box">
        <h2 style="margin-top:0; color: #2c3e50;">GET Response</h2>
        <div class="alert"><?php echo $message; ?></div>
        
        <div class="data-row">
            <strong>Name received:</strong> 
            <?php echo htmlspecialchars($name); ?>
        </div>
        
        <div class="data-row">
            <strong>Email received:</strong> 
            <?php echo htmlspecialchars($email); ?>
        </div>
        
        <a href="index.php" class="back-btn">&larr; Back to Home</a>
    </div>
</body>
</html>
