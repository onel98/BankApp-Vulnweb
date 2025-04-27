<?php
session_start();
include 'db_config.php';

if (isset($_GET['id'])) {
    $staffId = $_GET['id'];

    
    $stmt = $pdo->prepare("SELECT * FROM staff WHERE id = ?");
    $stmt->execute([$staffId]);
    $staff = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$staff) {
        die("Staff not found.");
    }

 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
      

        
        $updateStmt = $pdo->prepare("UPDATE staff SET name = ?, username = ?, email = ?WHERE id = ?");
        $updateStmt->execute([$name, $username, $email, $staffId]);

        
        header("Location: AdminDashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff - Admin Dashboard</title>
    <link rel="stylesheet" href="edit_staff.css">
</head>
<body>
    <h1>Edit Staff Details</h1>
    <form action="edit_staff.php?id=<?php echo $staff['id']; ?>" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($staff['name']); ?>" required><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($staff['username']); ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($staff['email']); ?>" required><br>

     

        <button type="submit">Update Staff</button>
    </form>
</body>
</html>
