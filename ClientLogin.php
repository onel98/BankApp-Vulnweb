<?php
session_start(); 

include 'db_config.php';  


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['username']) && isset($_GET['password'])) {
    
    $username = $_GET['username'];
    $password = $_GET['password'];

    

    
    $sql = "SELECT * FROM users WHERE email = '$username' OR name = '$username' LIMIT 1";  

    
    $result = $pdo->query($sql);

    
    $user = $result->fetch(PDO::FETCH_ASSOC);

    var_dump($user);

    if ($user) {
    
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['name'];
    $_SESSION['email'] = $user['email'];

    header("Location: ClientDashboard.php");
    exit;
} else {
    echo "User not found.";
}
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Login - BankApp</title>
    <link rel="stylesheet" href="ClientLogin.css">
</head>

<body>
    <div class="container">
        <header>
            <a href="index.php" style="text-decoration: none; padding: 8px 16px; background-color: #007bb5; color: white; border-radius: 4px; font-weight: bold; display: inline-block;">Back</a>

            <h1>Client Login</h1>
        </header>

        <form class="login-form" method="GET" action="ClientLogin.php">
            <label for="username">Username/Email:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username or email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password">

            <button type="submit" class="login-btn">Login</button>
            <p class="forgot-password"><a href="ResetPassword.php">Forgot your password?</a></p>
        </form>

        <footer>
            <p>&copy; 2023 BankApp. All rights reserved.</p>
        </footer>
    </div>
</body>

</html>
