<?php
// delete-account.php - Allow users to delete their account
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$delete_err = "";
$confirm_delete = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate confirm delete
    if (empty(trim($_POST["confirm_delete"]))) {
        $delete_err = "Please confirm deletion.";
    } else {
        $confirm_delete = trim($_POST["confirm_delete"]);
        if ($confirm_delete !== "DELETE") {
            $delete_err = "Confirmation text does not match.";
        }
    }

    // Check input errors before deleting the account
    if (empty($delete_err)) {
        // Prepare a delete statement
        $sql = "DELETE FROM users WHERE id = ?";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $param_id);

            // Set parameters
            $param_id = $_SESSION["id"];

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Account deleted successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
}
// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #f44336, #d32f2f);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .delete-container {
            background: #fff;
            color: #333;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #f44336;
        }

        p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn {
            background-color: #f44336;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #d32f2f;
        }

        .btn-secondary {
            background-color: #ccc;
            color: #333;
            padding: 10px 15px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #bbb;
        }

        .error {
            color: #f44336;
            font-size: 14px;
            margin-top: 10px;
        }

        input[type="text"] {
            padding-inline: 0px;
        }

    </style>
</head>
<body>
    <div class="delete-container">
    <img src="logo.png" alt="Logo" class="logo">
        <h2>Delete Account</h2>
        <p>Are you sure you want to delete your account? This action cannot be undone.</p>
        <?php 
        if (!empty($delete_err)) {
            echo '<div class="error">' . htmlspecialchars($delete_err) . '</div>';
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="confirm_delete">Type "DELETE" to confirm:</label>
                <input type="text" name="confirm_delete" id="confirm_delete" class="form-control" value="<?php echo htmlspecialchars($confirm_delete); ?>">
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Delete Account</button>
                <a href="welcome.php" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>