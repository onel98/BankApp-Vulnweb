<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - BankApp</title>
    <link rel="stylesheet" href="ResetPassword.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Forgot Password</h1>
        </header>

        <form class="forgot-password-form">
            <label for="forgot-email">Email:</label>
            <input type="email" id="forgot-email" name="email" placeholder="example@bankapp.com" required>

            <button type="submit" class="reset-btn">Send Reset Link</button>
        </form>

        <p class="back-to-login"><a href="index.php">Back to Login</a></p>

        <footer>
            <p>&copy; 2023 BankApp. All rights reserved.</p>
        </footer>
    </div>
</body>

</html>