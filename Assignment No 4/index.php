<?php
session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: dashboard.php");
    exit;
}

// Read cookie for username if it exists
$username_cookie = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment No 4 - Form & Session</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #f4f7f6; 
            display: flex; 
            justify-content: center; 
            padding: 50px; 
            margin: 0;
            color: #333;
        }
        .main-wrapper {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .container { 
            background: white; 
            padding: 30px; 
            border-radius: 8px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
            width: 350px; 
        }
        h2 { 
            margin-top: 0; 
            color: #2c3e50; 
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #555; font-weight: 500; }
        input[type="text"], input[type="email"], input[type="password"] { 
            width: 100%; 
            padding: 10px; 
            border: 1px solid #ddd; 
            border-radius: 4px; 
            box-sizing: border-box; 
            transition: border-color 0.3s;
        }
        input:focus {
            border-color: #3498db;
            outline: none;
        }
        button { 
            width: 100%; 
            padding: 12px; 
            background: #2ecc71; 
            color: white; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            font-size: 16px; 
            font-weight: 600;
            transition: background 0.3s;
        }
        button:hover { background: #27ae60; }
        .btn-get { background: #3498db; }
        .btn-get:hover { background: #2980b9; }
        
        .error { color: #e74c3c; margin-bottom: 15px; background: #fadbd8; padding: 10px; border-left: 4px solid #e74c3c; border-radius: 0 4px 4px 0; font-size: 14px; }
        .success { color: #27ae60; margin-bottom: 15px; background: #d5f5e3; padding: 10px; border-left: 4px solid #27ae60; border-radius: 0 4px 4px 0; font-size: 14px; }
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }
        .checkbox-container input {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <div class="container">
            <h2>POST Method (Login)</h2>
            <p style="font-size: 14px; color: #7f8c8d; margin-bottom: 20px;">Use this form to test POST submission, session creation, and cookies.</p>
            
            <?php
            if (isset($_GET['error'])) {
                echo '<div class="error">' . htmlspecialchars($_GET['error']) . '</div>';
            }
            if (isset($_GET['message'])) {
                 echo '<div class="success">' . htmlspecialchars($_GET['message']) . '</div>';
            }
            ?>
            
            <form action="process_post.php" method="POST">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($username_cookie); ?>" required placeholder="Enter your name">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                </div>
                
                <label class="checkbox-container">
                    <input type="checkbox" name="remember" <?php echo $username_cookie ? 'checked' : ''; ?>>
                    Remember my name (Cookie)
                </label>
                
                <button type="submit">Login (POST)</button>
            </form>
        </div>

        <div class="container">
            <h2>GET Method (Demo)</h2>
            <p style="font-size: 14px; color: #7f8c8d; margin-bottom: 20px;">Use this form to test GET submission and URL parameters.</p>
            
            <form action="process_get.php" method="GET">
                 <div class="form-group">
                    <label for="search_name">Name:</label>
                    <input type="text" id="search_name" name="name" required placeholder="Name parameter">
                </div>
                <div class="form-group">
                    <label for="search_email">Email:</label>
                    <input type="text" id="search_email" name="email" required placeholder="Email parameter">
                </div>
                <button type="submit" class="btn-get">Submit (GET)</button>
            </form>
        </div>
    </div>
</body>
</html>
