<?php
session_start();
if (!isset($_SESSION['staff_id'])) {
    header("Location: StaffLogin.php");
    exit;
}

include 'db_config.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

   
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$userId]);
}


header("Location: StaffDashboard.php");
exit;
?>