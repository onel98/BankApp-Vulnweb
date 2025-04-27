<?php
session_start();
if (!isset($_SESSION['staff_id'])) {
    header("Location: StaffLogin.php");
    exit;
}

$staffName = $_SESSION['staff_name'];
include 'db_config.php';
$sql = "SELECT * FROM users";
$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="StaffDashboard.css">
    <title>Staff Dashboard - BankApp</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        button {
            padding: 6px 10px;
            border: none;
            border-radius: 5px;
            margin-right: 5px;
            cursor: pointer;
        }

        .view-btn { background-color: #17a2b8; color: white; }
        .edit-btn { background-color: #ffc107; color: white; }
        .delete-btn { background-color: #dc3545; color: white; }

        /* Modal overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            z-index: 999;
        }

        /* Modal box */
        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            width: 400px;
            max-width: 90%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            display: none;
            border-radius: 10px;
        }

        .modal-header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .modal-footer {
            margin-top: 20px;
            text-align: right;
        }

        .close-btn {
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($staffName); ?>!</h1>
        <nav>
                <ul class="nav-links">
                    <li><a href="#client-inquiries">Client Inquiries</a></li>
                    <li><a href="#transaction-summary">Transaction Summary</a></li>
                    <li><a href="#updates">Updates</a></li>
                    <li><button type="button" class="logout-btn"><a href="Logout.php">Log Out</a></button></li> 

                </ul>
            </nav>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td>
                        <button class="view-btn" onclick="openModal('view', <?= htmlspecialchars(json_encode($row)) ?>)">View</button>
                        <a href="edit.php?id=<?php echo $row['id']; ?>"><button class="edit-btn">Edit</button></a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');"><button class="delete-btn">Delete</button></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <h2>Add Funds to User</h2>
<form action="add_funds.php" method="POST">
    <label for="user_id">Select User:</label>
    <select name="user_id" required>
        <?php
        // Populate dropdown from users
        $userStmt = $pdo->query("SELECT id, name FROM users");
        while ($user = $userStmt->fetch()) {
            echo "<option value='{$user['id']}'>{$user['name']} (ID: {$user['id']})</option>";
        }
        ?>
    </select>
    <br><br>
    <label for="amount">Amount to Add:</label>
    <input type="number" name="amount" step="0.01" min="0.01" required>
    <br><br>
    <button type="submit">Add Funds</button>
</form>
<?php
// Check if there's a success message in the URL
if (isset($_GET['success']) && $_GET['success'] === 'funds_added') {
    // Retrieve the message from the URL (this will contain the flag for onel)
    $message = isset($_GET['message']) ? $_GET['message'] : 'Funds added successfully!';

    // Display the message (you can style it as needed)
    echo "<div class='alert alert-success'>$message</div>";
}
?>
    </div>

    <!-- Modal Overlay -->
    <div class="modal-overlay" id="modalOverlay" onclick="closeModal()"></div>

    <!-- Modal Box -->
    <div class="modal" id="modalBox">
        <div class="modal-header" id="modalTitle">Modal Title</div>
        <div class="modal-body" id="modalContent"></div>
        <div class="modal-footer">
            <button class="close-btn" onclick="closeModal()">Close</button>
        </div>
    </div>

    <script>
        function openModal(type, data) {
            const modalOverlay = document.getElementById("modalOverlay");
            const modalBox = document.getElementById("modalBox");
            const modalTitle = document.getElementById("modalTitle");
            const modalContent = document.getElementById("modalContent");

            if (type === 'view') {
                modalTitle.innerText = "Client Info";
                modalContent.innerHTML = `
                    <p><strong>ID:</strong> ${data.id}</p>
                    <p><strong>Name:</strong> ${data.name}</p>
                    <p><strong>Email:</strong> ${data.email}</p>
                `;
            } else if (type === 'edit') {
                modalTitle.innerText = "Edit Client";
                modalContent.innerHTML = `
                    <form method="POST" action="update_user.php">
                        <input type="hidden" name="id" value="${data.id}">
                        <p><label>Name: <input type="text" name="name" value="${data.name}"></label></p>
                        <p><label>Email: <input type="email" name="email" value="${data.email}"></label></p>
                        <div class="modal-footer">
                            <button type="submit" class="edit-btn">Save</button>
                            <button type="button" class="close-btn" onclick="closeModal()">Cancel</button>
                        </div>
                    </form>
                `;
            } else if (type === 'delete') {
                modalTitle.innerText = "Delete Client";
                modalContent.innerHTML = `
                    <p>Are you sure you want to delete <strong>${data.name}</strong>?</p>
                    <form method="POST" action="delete_user.php">
                        <input type="hidden" name="id" value="${data.id}">
                        <div class="modal-footer">
                            <button type="submit" class="delete-btn">Delete</button>
                            <button type="button" class="close-btn" onclick="closeModal()">Cancel</button>
                        </div>
                    </form>
                `;
            }

            modalOverlay.style.display = 'block';
            modalBox.style.display = 'block';
        }

        function closeModal() {
            document.getElementById("modalOverlay").style.display = 'none';
            document.getElementById("modalBox").style.display = 'none';
        }
    </script>
</body>
</html>
