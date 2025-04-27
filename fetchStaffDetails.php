<?php
include 'db_config.php';

if (isset($_GET['id'])) {
    $staffId = $_GET['id'];

    
    $stmt = $pdo->prepare("SELECT * FROM staff WHERE id = ?");
    $stmt->execute([$staffId]);
    $staff = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($staff) {
      
        echo "<p><strong>ID:</strong> " . htmlspecialchars($staff['id']) . "</p>";
        echo "<p><strong>Name:</strong> " . htmlspecialchars($staff['name']) . "</p>";
        echo "<p><strong>Username:</strong> " . htmlspecialchars($staff['username']) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($staff['email']) . "</p>";
        
    } else {
        echo "<p>Staff not found.</p>";
    }
} else {
    echo "<p>Invalid staff ID.</p>";
}
?>