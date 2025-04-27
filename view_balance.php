<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['username'])) {
    die("User not logged in.");
}

$username = $_SESSION['username']; 

$stmt = $pdo->prepare("SELECT id FROM users WHERE name = ?");
$stmt->execute([$username]);
$userIdFromSession = $stmt->fetchColumn();

if ($userIdFromSession === false) {
    die("User not found.");
}

if (!isset($_GET['id'])) {
    die("No ID provided.");
}

$userIdFromUrl = $_GET['id']; 

$stmt = $pdo->prepare("SELECT users.name, accounts.balance 
                       FROM accounts 
                       JOIN users ON accounts.user_id = users.id 
                       WHERE users.id = ?");
$stmt->execute([$userIdFromUrl]);
$data = $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Information</title>
    <style>
        body {
            font-family: Arial, sans-serif; 
            background-color: #f4f4f4; 
            margin: 0; 
            padding: 0; 
        }

        .container {
            max-width: 600px; 
            margin: 20px auto; 
            padding: 20px; 
            background-color: white; 
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
        }

        h2 {
            color: #007bb5; 
            margin-bottom: 20px; 
        }

        p {
            font-size: 16px; 
            margin-bottom: 10px; 
        }

        .flag {
            color: red;
            font-weight: bold;
            margin-top: 20px;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bb5;
        }
    </style>
</head>
<body>

<div class="container">
    <?php if ($data): ?>
        <h2>Account Details</h2>
        <p><strong>Name:</strong> <?= htmlspecialchars($data['name']) ?></p>
        <p><strong>Balance:</strong> $<?= htmlspecialchars($data['balance']) ?></p>

        <?php if ($userIdFromUrl != $userIdFromSession): ?>
            <p class="flag">FLAG: CTF{IDORVULNERABILITYEXPLOITED}</p>
        <?php endif; ?>

        <a href="ClientDashboard.php" class="back-link">← Back to Dashboard</a>
    <?php else: ?>
        <h2>Error</h2>
        <p>User not found.</p>
        <a href="ClientDashboard.php" class="back-link">← Back to Dashboard</a>
    <?php endif; ?>
</div>

</body>
</html>
