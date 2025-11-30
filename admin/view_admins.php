<?php
include "connection.php";
include "sider.php"; // Including the sidebar

// Initialize message variable
$message = '';
$messageType = '';

// Handle delete action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);
    $delete_query = "DELETE FROM admin_users WHERE AdminID = '$delete_id'";
    if (mysqli_query($conn, $delete_query)) {
        $message = 'Admin deleted successfully.';
        $messageType = 'success';
    } else {
        $message = 'Error deleting admin.';
        $messageType = 'danger';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Admins</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #000000;
            line-height: 1.6;
        }
        .main-content {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .card {
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #f8f8f8;
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        .table th {
            background-color: #f8f8f8;
            font-weight: bold;
        }
        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-primary {
            background-color: #007bff;
            color: #ffffff;
        }
        .btn-danger {
            background-color: #dc3545;
            color: #ffffff;
        }
        .page-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
        }
        .stats-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .stat-card {
            background: #f8f8f8;
            padding: 15px;
            text-align: center;
            flex: 1;
            margin: 0 10px;
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
        }
        .stat-label {
            font-size: 14px;
            color: #666;
        }
        .notification {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
            transition: opacity 0.5s ease-out;
        }
        .notification-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .notification-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h1 class="page-title">Admin Dashboard</h1>
        
        <?php if (!empty($message)): ?>
        <div id="notification" class="notification notification-<?php echo $messageType; ?>">
            <?php echo $message; ?>
        </div>
        <?php endif; ?>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-number">
                    <?php
                    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM admin_users");
                    $data = mysqli_fetch_assoc($result);
                    echo $data['total'];
                    ?>
                </div>
                <div class="stat-label">Total Admins</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?php
                    $result = mysqli_query($conn, "SELECT COUNT(DISTINCT Role) as roles FROM admin_users");
                    $data = mysqli_fetch_assoc($result);
                    echo $data['roles'];
                    ?>
                </div>
                <div class="stat-label">Unique Roles</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?php
                    $result = mysqli_query($conn, "SELECT COUNT(*) as recent FROM admin_users WHERE AdminID > (SELECT MAX(AdminID) - 5 FROM admin_users)");
                    $data = mysqli_fetch_assoc($result);
                    echo $data['recent'];
                    ?>
                </div>
                <div class="stat-label">Recent Additions</div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h2>Manage Admins</h2>
                <a href="add_admin.php" class="btn btn-primary">Add New Admin</a>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM admin_users";
                        $query_run = mysqli_query($conn, $query);

                        if (mysqli_num_rows($query_run) > 0) {
                            while ($row = mysqli_fetch_assoc($query_run)) {
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['AdminID']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Username']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Role']); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['AdminID']; ?>">Delete</button>
                                    </td>
                                </tr>
                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal<?php echo $row['AdminID']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $row['AdminID']; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel<?php echo $row['AdminID']; ?>">Delete Admin</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this admin user?</p>
                                                <p><strong>Admin Details:</strong></p>
                                                <p>ID: <?php echo htmlspecialchars($row['AdminID']); ?></p>
                                                <p>Username: <?php echo htmlspecialchars($row['Username']); ?></p>
                                                <p>Role: <?php echo htmlspecialchars($row['Role']); ?></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form method="POST">
                                                    <input type="hidden" name="delete_id" value="<?php echo $row['AdminID']; ?>">
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='4'>No Record Found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS for notification -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var notification = document.getElementById('notification');
            if (notification) {
                setTimeout(function() {
                    notification.style.opacity = '0';
                    setTimeout(function() {
                        notification.style.display = 'none';
                    }, 500);
                }, 5000);
            }
        });
    </script>
</body>
</html>
