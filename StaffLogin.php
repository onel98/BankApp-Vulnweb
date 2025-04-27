<?php
session_start();  

include 'db_config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username = $_POST['username'];
    $password = $_POST['password'];


    $sql = "SELECT * FROM staff WHERE username = '$username' LIMIT 1";
    $result = $pdo->query($sql);
    $staff = $result->fetch(PDO::FETCH_ASSOC);

    if ($staff) {
        if ($password == $staff['password']) {
            // Login success - store session data
            $_SESSION['staff_id'] = $staff['id'];
            $_SESSION['staff_username'] = $staff['username'];
            $_SESSION['staff_name'] = $staff['name'];

         
            header("Location: StaffDashboard.php");
            exit;
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Staff user not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login - BankApp</title>
    <link rel="stylesheet" href="StaffLogin.css">
</head>

<body>
    <div class="container">
        <header>
	<a href="index.php" style="text-decoration: none; padding: 8px 16px; background-color: #007bb5; color: white; border-radius: 4px; font-weight: bold; display: inline-block;">Back</a>

            <h1>Staff Login</h1>
        </header>

        <form class="login-form" method="POST" action="StaffLogin.php">

            <label for="staff-username">Username/Email:</label>
            <input type="text" id="staff-username" name="username" placeholder="Enter your username or email" required>

            <label for="staff-password">Password:</label>
            <input type="password" id="staff-password" name="password" placeholder="Enter your password" required>

            <button type="submit" class="login-btn">Login</button>
            <p class="forgot-password"><a href="ResetPassword.php">Forgot your password?</a></p>
        </form>

        <footer>
            <p>&copy; 2023 BankApp. All rights reserved.</p>
        </footer>
    </div>
</body>

</html>
