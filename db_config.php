<?php
$host = 'localhost';      
$username = 'ctfuser';       
$password = 'ctfpass';           
$dbname = 'bankapp';     


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
   
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
