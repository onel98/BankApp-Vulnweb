<?php
session_start();
include 'db_config.php';

if (isset($_GET['id'])) {
    $staffId = $_GET['id'];

    
    $deleteStmt = $pdo->prepare("DELETE FROM staff WHERE id = ?");
    $deleteStmt->execute([$staffId]);

   
    header("Location: AdminDashboard.php");
    exit;
} else {
    echo "Staff ID not specified.";
}
?>