<?php
// welcome.php - Welcome page after successful login
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #4CAF50, #2E8B57);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .welcome-container {
            background: #fff;
            color: #333;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #4CAF50;
        }

        p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            display: inline-block;
            margin: 10px 5px;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .btn-danger {
            background-color: #f44336;
        }

        .btn-danger:hover {
            background-color: #d32f2f;
        }

    </style>
</head>
<body>
    <div class="welcome-container">
    <img src="logo.png" alt="Logo" class="logo">
        <h1>Welcome, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>!</h1>
        <p>You are now logged in to your account. What would you like to do next?</p>
        <p>
            <a href="update-password.php" class="btn">Update Your Password</a>
            <a href="logout.php" class="btn btn-danger">Sign Out</a>
            <a href="delete-account.php" class="btn btn-danger">Delete Your Account</a>
        </p>
    </div>
</body>
</html>