<?php
session_start();


if (!isset($_SESSION['username'])) {
    header("Location: ClientLogin.php");
    exit;
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];

include 'db_config.php';

// Get user ID from email 
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
$userId = $stmt->fetchColumn();

if ($userId === false) {
    die("User not found.");
}

//get balance from accounts table using user ID
$stmt = $pdo->prepare("SELECT balance FROM accounts WHERE user_id = ?");
$stmt->execute([$userId]);
$balance = $stmt->fetchColumn();

if ($balance === false) {
    $balance = 0.00;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipientName = $_POST['recipient'];
    $amount = $_POST['amount'];

    // Get recipient user ID from users table using name
    $stmt = $pdo->query("SELECT id FROM users WHERE name = '$recipientName'");
    $recipientUserId = $stmt->fetchColumn();

    if ($recipientUserId !== false) {
        // Add to recipient's balance
        $pdo->exec("UPDATE accounts SET balance = balance + $amount WHERE user_id = $recipientUserId");

        // Deduct from current user's balance
        $pdo->exec("UPDATE accounts SET balance = balance - $amount WHERE user_id = $userId");

        $transferStatus = "Successfully transferred $$amount to $recipientName.";
	
	if ($_SESSION['username'] === 'Onel' && $recipientName === 'Sathmi') {
            $transferStatus .= "<br><strong>FLAG: CTF{TRANSFERLOGICSUCCESS}</strong>";
        }	

        // Redirect to the same page to prevent form resubmission on refresh
            header("Location: " . $_SERVER['PHP_SELF'] . "?msg=" . urlencode($transferStatus));
            exit; // Make sure the script stops executing after the redirect
    } else {
        $transferStatus = "Recipient not found.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard - BankApp</title>
    <link rel="stylesheet" href="ClientDashboard.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Welcome to Dashboard, <?php echo $_SESSION['username'];?>!
		     <?php if ($_SESSION['username'] === 'Onel') {
    echo "<h3> FLAG: CTF{SQLINJECTIONSUCCESSFULL}</h3>";
} ?>
         
</h1><br>
            <nav>
                <ul class="nav-links">
                    <li><a href="view_balance.php?id=<?php echo $userId; ?>">Check Balance</a></li>
                    <li><a href="#transfer-money">Transfer Money</a></li>
                    <li><a href="#transactions">Transaction History</a></li>
                    <li><a href="Logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <section id="balance" class="dashboard-section">
                <h2>Your Account Balance</h2><br>
                <p>$<?php echo number_format($balance, 2); ?></p>
            </section>

            <section id="transfer-money" class="dashboard-section">
                <h2>Transfer Money</h2>
                <form class="transfer-form" method="POST" action="ClientDashboard.php"><br>
                    <label for="recipient">Recipient Account Number:</label>
                    <input type="text" id="recipient" name="recipient" placeholder="Enter recipient's account number" required>

                    <label for="amount">Amount:</label>
                    <input type="number" id="amount" name="amount" placeholder="Enter amount" required>

                    <button type="submit" class="transfer-btn">Transfer</button>
                </form>
            </section>

            <section id="transactions" class="dashboard-section">
                <h2>Transaction History</h2>
                <table class="transactions-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php if (isset($_GET['msg'])) echo $_GET['msg']; ?>
                        </tr>
                                            </tbody>
                </table>
            </section>
        </main>

        <footer>
            <p>&copy; 2023 BankApp. All rights reserved.</p>
        </footer>
    </div>
</body>

</html>
