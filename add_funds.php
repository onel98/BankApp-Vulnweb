<?php
session_start();
if (!isset($_SESSION['staff_id'])) {
    header("Location: StaffLogin.php");
    exit;
}

include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $amount = $_POST['amount'];

  
    if (!is_numeric($amount) || $amount <= 0) {
        die("Invalid amount.");
    }

    try {
        
        $pdo->beginTransaction();

        
        $stmt = $pdo->prepare("SELECT * FROM accounts WHERE user_id = ?");
        $stmt->execute([$userId]);
        $account = $stmt->fetch();

        if ($account) {
            
            $update = $pdo->prepare("UPDATE accounts SET balance = balance + ? WHERE user_id = ?");
            $update->execute([$amount, $userId]);
        } else {
            
            $insert = $pdo->prepare("INSERT INTO accounts (user_id, balance) VALUES (?, ?)");
            $insert->execute([$userId, $amount]);
        }

        $pdo->commit();

	
	$stmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $userName = $stmt->fetchColumn();

        // If the username is 'onel', set the flag
        if ($userName === 'Onel') {
            // Add the flag message for 'onel'
            $message = "Funds added to $userName's account! FLAG: CTF{ADDEDFUNDSTOONEL}";
        } else {
            $message = "Funds successfully added to $userName's account.";
        }

        // Redirect back to the staff dashboard with a success message
        header("Location: StaffDashboard.php?success=funds_added&message=" . urlencode($message));
        exit;
	

    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
