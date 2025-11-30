<?php
include "sider.php";
include "connection.php";

// Handle form submissions for deletion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_user'])) {
        $user_id = $_POST['user_id'];

        // Debugging output
        error_log("Attempting to delete user with ID: $user_id");

        $sql = "DELETE FROM Users WHERE UserID = $user_id"; // Directly use $user_id
        if (mysqli_query($conn, $sql)) {
            $delete_success = true;
        } else {
            $delete_error = true;
            error_log("Deletion error: " . mysqli_error($conn)); // Log the error
        }
    }
}

// Get registration statistics
$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));
$week_start = date('Y-m-d', strtotime('last monday'));
$month_start = date('Y-m-01');

$stats = [
    'today' => 0,
    'yesterday' => 0,
    'this_week' => 0,
    'this_month' => 0
];

$sql = "SELECT
    SUM(CASE WHEN DATE(RegistrationDate) = '$today' THEN 1 ELSE 0 END) as today,
    SUM(CASE WHEN DATE(RegistrationDate) = '$yesterday' THEN 1 ELSE 0 END) as yesterday,
    SUM(CASE WHEN DATE(RegistrationDate) >= '$week_start' THEN 1 ELSE 0 END) as this_week,
    SUM(CASE WHEN DATE(RegistrationDate) >= '$month_start' THEN 1 ELSE 0 END) as this_month
FROM Users";

$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $stats = mysqli_fetch_assoc($result);
}

// Handle date range filter
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Ensure start_date is not later than yesterday and end_date is not in the future
$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));

if ($start_date > $yesterday) {
    $start_date = $yesterday;
}
if ($end_date > $today) {
    $end_date = $today;
}

$where_clause = "";
if ($start_date && $end_date) {
    $where_clause = "WHERE DATE(RegistrationDate) BETWEEN '$start_date' AND '$end_date'";
}

// Fetch users
$sql = "SELECT UserID, Username, Email, RegistrationDate FROM Users $where_clause ORDER BY RegistrationDate DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - YumYumRank Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f0f0f0;
            overflow-x: hidden;
        }
        .user-card, .stats-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            padding: 20px;
        }
        .user-card:hover, .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .stats-card {
            padding: 20px;
            background-color: #007bff;
            color: white;
        }
        .empty-state {
            text-align: center;
            padding: 50px;
            background-color: white;
            border-radius: 10px;
        }
        .empty-state i {
            font-size: 48px;
            color: #007bff;
            margin-bottom: 20px;
        }
        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            z-index: -1;
        }

        
    </style>
</head>

<body>
<div class="background bg-anim"></div>
<div class="container mt-5">
    <h1 class="mb-4 text-center">Manage Users</h1>

    <!-- Display success or error messages -->
    <?php if (isset($delete_success) && $delete_success): ?>
        <div class="alert alert-success" role="alert">
            User successfully deleted.
        </div>
    <?php elseif (isset($delete_error) && $delete_error): ?>
        <div class="alert alert-danger" role="alert">
            Failed to delete user.
        </div>
    <?php endif; ?>

    <!-- Stats section -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <h5>Today</h5>
                <h3><?php echo $stats['today']; ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <h5>Yesterday</h5>
                <h3><?php echo $stats['yesterday']; ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <h5>This Week</h5>
                <h3><?php echo $stats['this_week']; ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <h5>This Month</h5>
                <h3><?php echo $stats['this_month']; ?></h3>
            </div>
        </div>
    </div>

    <!-- Date filter -->
    <form class="mb-4" method="GET">
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="start_date" class="col-form-label">From</label>
            </div>
            <div class="col-auto">
                <input type="date" id="start_date" name="start_date" class="form-control" value="<?php echo $start_date; ?>" max="<?php echo $yesterday; ?>">
            </div>
            <div class="col-auto">
                <label for="end_date" class="col-form-label">To</label>
            </div>
            <div class="col-auto">
                <input type="date" id="end_date" name="end_date" class="form-control" value="<?php echo $end_date; ?>" max="<?php echo $today; ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <!-- User cards -->
    <div class="row" id="userCards">
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="col-md-4 user-card-container">';
                echo '<div class="user-card" data-user-id="' . $row["UserID"] . '">';
                echo '<div class="user-card-header">';
                echo '<h5>' . $row["Username"] . '</h5>';
                echo '</div>';
                echo '<div class="user-card-body">';
                echo '<p><strong>Email:</strong> ' . $row["Email"] . '</p>';
                echo '<p><strong>Registered:</strong> ' . $row["RegistrationDate"] . '</p>';
                echo '<button class="btn btn-danger btn-sm delete-btn" data-user-id="' . $row["UserID"] . '">Delete</button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="col-12 empty-state">';
            echo '<i class="fas fa-users"></i>';
            echo '<h2>No Users Found</h2>';
            echo '<p>There are currently no users in the system for the selected date range.</p>';
            echo '</div>';
        }
        ?>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                    <form method="POST" id="deleteForm">
                        <input type="hidden" name="user_id" id="modalUserId">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="delete_user" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.delete-btn').on('click', function() {
            var userId = $(this).data('user-id');
            $('#modalUserId').val(userId);
            $('#deleteConfirmModal').modal('show');
        });

        var today = new Date();
        var yesterday = new Date(today);
        yesterday.setDate(yesterday.getDate() - 1);

        var todayString = today.toISOString().split('T')[0];
        var yesterdayString = yesterday.toISOString().split('T')[0];

        document.getElementById('start_date').setAttribute('max', yesterdayString);
        document.getElementById('end_date').setAttribute('max', todayString);

        document.getElementById('start_date').addEventListener('change', function() {
            if (this.value > yesterdayString) {
                alert('The "From" date cannot be later than yesterday. Please select yesterday or an earlier date.');
                this.value = yesterdayString;
            }
        });

        document.getElementById('end_date').addEventListener('change', function() {
            if (this.value > todayString) {
                alert('The "To" date cannot be in the future. Please select today or an earlier date.');
                this.value = todayString;
            }
        });
    });
</script>
</body>
</html>