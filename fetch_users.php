<?php
include 'db_config.php';

if (isset($_GET['id'])) {
    $clientId = $_GET['id'];

   
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$clientId]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($client) {
      
        echo "<p><strong>ID:</strong> " . htmlspecialchars($client['id']) . "</p>";
        echo "<p><strong>Name:</strong> " . htmlspecialchars($client['name']) . "</p>";
        
        echo "<p><strong>Email:</strong> " . htmlspecialchars($client['email']) . "</p>";
    
    } else {
        echo "<p>Client not found.</p>";
    }
} else {
    echo "<p>Invalid client ID.</p>";
}
?>