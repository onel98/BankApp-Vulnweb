<?php
session_start();
if (!isset($_SESSION['staff_id'])) {
    header("Location: StaffLogin.php");
    exit;
}

include 'db_config.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if (!$user) {
        echo "User not found.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $update = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $update->execute([$name, $email, $userId]);

    header("Location: StaffDashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <link rel="stylesheet" href="edit.css">
    <title>Edit User</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        form { max-width: 400px; margin: auto; }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
        }
        button {
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h2>Edit User</h2>
<form method="POST">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
    <label>Name:</label><br>
    <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br>
    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>
    <button type="submit">Save Changes</button>
</form>

</body>
</html>
