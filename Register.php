<?php
include 'db_config.php';  


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $_POST['name'];  // XSS payload could go here
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

   
    if ($password != $confirm_password) {
        echo "Passwords do not match.";
        exit;
    }

    
    $name = str_replace("'", "''", $name);  
    $email = str_replace("'", "''", $email);  
    $password = str_replace("'", "''", $password); 
    $confirm_password = str_replace("'", "''", $confirm_password); 

    
    $sql = "INSERT INTO users (name, email, password, confirm_password) 
            VALUES ('$name', '$email', '$password', '$confirm_password')";

   
    try {
        $pdo->query($sql);  
        echo "User successfully registered.<br>";
        echo "👀 View registered name: $name";  
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();  
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - BankApp</title>
    <link rel="stylesheet" href="Register.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Register for BankApp</h1>
        </header>
	<a href="index.php" style="text-decoration: none; padding: 8px 16px; background-color: #007bb5; color: white; border-radius: 4px; font-weight: bold; display: inline-block;">Back</a>
        <form class="registration-form" method="POST" action="Register.php">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" placeholder="John Doe" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="example@bankapp.com" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Re-enter your password" required>

            <button type="submit" class="submit-btn">Register</button>
        </form>

        <footer>
            <p>&copy; 2023 BankApp. All rights reserved.</p>
        </footer>
    </div>
</body>

</html>
