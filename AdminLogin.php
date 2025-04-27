<?php
session_start();
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_user = $_POST['username'];
    $admin_pass = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username = '$admin_user' LIMIT 1";
    $result = $pdo->query($sql);
    $admin = $result->fetch(PDO::FETCH_ASSOC);

    if ($admin && $admin['password'] == $admin_pass) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header("Location: AdminDashboard.php");
        exit;
    } else {
        echo "Invalid admin credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - BankApp</title>
    <link rel="stylesheet" href="AdminLogin.css">
</head>

<body>
    <div class="container">
        <header>
		 <a href="index.php" style="text-decoration: none; padding: 8px 16px; background-color: #007bb5; color: white; border-radius: 4px; font-weight: bold; display: inline-block;">Back</a>

            <h1>Admin Login</h1>
        </header>

        <form class="login-form" method="POST" action="AdminLogin.php">
            <label for="admin-username">Username/Email:</label>
            <input type="text" id="admin-username" name="username" placeholder="Enter your username or email" required>

            <label for="admin-password">Password:</label>
            <input type="password" id="admin-password" name="password" placeholder="Enter your password" required>

            <button type="submit" class="login-btn">Login</button>
            <p class="forgot-password"><a href="ResetPassword.php">Forgot your password?</a></p>
        </form>

        <footer>
            <p>&copy; 2023 BankApp. All rights reserved.</p>
        </footer>
    </div>
</body>

</html>
