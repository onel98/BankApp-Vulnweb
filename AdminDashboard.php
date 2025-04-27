<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: AdminLogin.php");
    exit;
}


include 'db_config.php';

$sql = "SELECT * FROM staff";
$result = $pdo->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - BankApp</title>
    <link rel="stylesheet" href="AdminDashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Simple modal style */
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            max-width: 400px;
            width: 100%;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9998;
        }

        .modal-header {
            font-size: 20px;
            font-weight: bold;
        }

        .modal-footer {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome, Admin</h1>
            <nav>
                <ul>
                    <li><a href="Logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <section id="staff-details">
                <h2>Staff Details</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        if ($result->rowCount() > 0) {
                          
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td><a href='#' class='view-btn' data-id='" . htmlspecialchars($row['id']) . "'>View</a> | 
                                    <a href='edit_staff.php?id=" . htmlspecialchars($row['id']) . "'>Edit</a> | 
                                    <a href='delete_staff.php?id=" . htmlspecialchars($row['id']) . "'>Delete</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No staff members found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section><br>
		FLAG{ADMINACCESSSUCESS}
        </main>

        <footer>
            <p>&copy; 2025 BankApp. All rights reserved.</p>
        </footer>
    </div>

  
    <div class="modal-overlay" id="modal-overlay"></div>
    <div class="modal" id="staff-modal">
        <div class="modal-header">
            <h3>Staff Details</h3>
        </div>
        <div id="modal-body">
           
        </div>
        <div class="modal-footer">
            <button id="close-modal">Close</button>
        </div>
    </div>

    <script>
        
        $(document).on('click', '.view-btn', function (e) {
            e.preventDefault();
            const staffId = $(this).data('id');

            // AJAX request to fetch staff details
            $.ajax({
                url: 'fetchStaffDetails.php',
                type: 'GET',
                data: { id: staffId },
                success: function (data) {
                    $('#modal-body').html(data);
                    $('#staff-modal').show();
                    $('#modal-overlay').show();
                },
                error: function () {
                    alert('Failed to fetch staff details.');
                }
            });
        });

        
        $('#close-modal').on('click', function () {
            $('#staff-modal').hide();
            $('#modal-overlay').hide();
        });

     
        $(document).on('click', function (e) {
            if ($(e.target).is('#modal-overlay')) {
                $('#staff-modal').hide();
                $('#modal-overlay').hide();
            }
        });
    </script>
</body>
</html>
