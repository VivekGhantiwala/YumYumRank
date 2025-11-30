<?php

// Start the session at the very beginning


// Include necessary files and initialize database connection
require_once "sider.php";
require_once "connection.php";

// Function to set error message
function setErrorMessage($message) {
    $_SESSION['error_message'] = $message;
}

// Function to display error message
function displayErrorMessage() {
    if (isset($_SESSION['error_message'])) {
        $message = $_SESSION['error_message'];
        unset($_SESSION['error_message']); // Clear the message after displaying
        
        echo "
        <div id='error-notification' class='error-notification' style='display: none;'>
            <span class='error-icon'>&#10060;</span>
            {$message}
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Wait for 3 seconds after the page loads (assuming loader is done by then)
            setTimeout(function() {
                var notification = document.getElementById('error-notification');
                notification.style.display = 'flex';
                setTimeout(function() {
                    notification.style.opacity = '0';
                    setTimeout(function() {
                        notification.style.display = 'none';
                    }, 500);
                }, 7000); // Display for 7 seconds
            }, 3000); // Wait for 3 seconds before showing
        });
        </script>";
    }
}

// Call displayErrorMessage() to show any existing error messages
displayErrorMessage();

// Fetch data for dashboard using prepared statements
function fetchTopFoods($conn) {
    $sql = "SELECT Name, HealthScore FROM Foods ORDER BY HealthScore DESC LIMIT 5";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        setErrorMessage("Error preparing statement: " . $conn->error);
        return false;
    }
    if (!$stmt->execute()) {
        setErrorMessage("Error executing query: " . $stmt->error);
        return false;
    }
    return $stmt->get_result();
}

function fetchTopCategories($conn) {
    $sql = "SELECT c.Name, COUNT(f.FoodID) as FoodCount
            FROM categories c
            LEFT JOIN Foods f ON c.CategoryID = f.CategoryID
            GROUP BY c.CategoryID      
            ORDER BY FoodCount DESC
            LIMIT 5";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        setErrorMessage("Error preparing statement: " . $conn->error);
        return false;
    }
    if (!$stmt->execute()) {
        setErrorMessage("Error executing query: " . $stmt->error);
        return false;
    }
    return $stmt->get_result();
}

function fetchTotalCount($conn, $table) {
    $sql = "SELECT COUNT(*) as total FROM " . $table;
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        setErrorMessage("Error preparing statement: " . $conn->error);
        return false;
    }
    if (!$stmt->execute()) {
        setErrorMessage("Error executing query: " . $stmt->error);
        return false;
    }
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total'];
}

function fetchAverageHealth($conn) {
    $sql = "SELECT AVG(HealthScore) as avg_health FROM foods";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        setErrorMessage("Error preparing statement: " . $conn->error);
        return false;
    }
    if (!$stmt->execute()) {
        setErrorMessage("Error executing query: " . $stmt->error);
        return false;
    }
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['avg_health'];
}

function fetchRecentUsers($conn) {
    $sql = "SELECT Username, RegistrationDate FROM Users ORDER BY RegistrationDate DESC LIMIT 5";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        setErrorMessage("Error preparing statement: " . $conn->error);
        return false;
    }
    if (!$stmt->execute()) {
        setErrorMessage("Error executing query: " . $stmt->error);
        return false;
    }
    return $stmt->get_result();
}

function fetchRecentReviews($conn) {
    $sql = "SELECT
        Users.Username,
        Foods.Name AS FoodName,
        ratings.RatingID AS Rating,
        ratings.Date,
        ratings.Feedback AS Feedback
    FROM ratings
    JOIN Users ON ratings.UserID = Users.UserID
    JOIN Foods ON ratings.FoodID = Foods.FoodID
    ORDER BY ratings.Date DESC LIMIT 5";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        setErrorMessage("Error preparing statement for recent reviews: " . $conn->error);
        return false;
    }
    if (!$stmt->execute()) {
        setErrorMessage("Error executing query: " . $stmt->error);
        return false;
    }
    return $stmt->get_result();
}

function fetchRecentActivities($conn) {
    $sql = "SELECT 'Food' AS type, 'Added' AS action, Name AS item, Created_At AS date FROM Foods
            UNION ALL
            SELECT 'Category' AS type, 'Added' AS action, Name AS item, UpdatedAt AS date FROM Categories
            UNION ALL
            SELECT 'Review' AS type, 'Added' AS action, CONCAT(Users.Username, ' reviewed ', Foods.Name) AS item, reviews.Date AS date
            FROM reviews
            JOIN Users ON reviews.UserID = Users.UserID
            JOIN ratings ON reviews.UserID = ratings.UserID AND reviews.Date = ratings.Date
            JOIN Foods ON ratings.FoodID = Foods.FoodID
            UNION ALL
            SELECT 'User' AS type, 'Registered' AS action, Username AS item, RegistrationDate AS date FROM Users
            ORDER BY date DESC
            LIMIT 5";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        setErrorMessage("Error preparing statement for recent activities: " . $conn->error);
        return false;
    }
    if (!$stmt->execute()) {
        setErrorMessage("Error executing query: " . $stmt->error);
        return false;
    }
    return $stmt->get_result();
}

// Fetch data
$result_top_foods = fetchTopFoods($conn);
$result_categories = fetchTopCategories($conn);
$total_foods = fetchTotalCount($conn, 'Foods');
$avg_health = fetchAverageHealth($conn);
$total_categories = fetchTotalCount($conn, 'Categories');
$total_users = fetchTotalCount($conn, 'Users');
$result_recent_users = fetchRecentUsers($conn);
$result_recent_reviews = fetchRecentReviews($conn);
$result_recent_activities = fetchRecentActivities($conn);

// Start output buffering
ob_start();

// Display any error messages
echo displayErrorMessage();

// Your HTML and PHP code to display the dashboard goes here
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            overflow-x: hidden;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        }

        .card-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        .fade-in {
            opacity: 0;
        }

        .slide-in {
            transform: translateY(50px);
            opacity: 0;
        }
        .error-notification {
    background: #FFCDD2;
    font-family: Arial, sans-serif;
    font-weight: 800;
    color: #C62828;
    padding: 15px 25px;
    border-radius: 12px;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
    font-size: 16px;
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
    display: flex;
    align-items: center;
    min-width: 320px;
    opacity: 1;
    transition: opacity 0.5s ease-out;
}

.error-icon {
    margin-right: 15px;
    font-size: 24px;
    color: #D32F2F;
}
    </style>
</head>

<body >
<?php echo displayErrorMessage(); ?>
    <div class="container mt-4">
        <h1 class="mb-4">Admin Dashboard</h1>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-utensils card-icon text-primary"></i>
                        <h5 class="card-title">Total Foods</h5>
                        <p class="card-text display-4"><?= $total_foods ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-heartbeat card-icon text-danger"></i>
                        <h5 class="card-title">Average Health Score</h5>
                        <p class="card-text display-4"><?= number_format($avg_health, 1) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-th-list card-icon text-success"></i>
                        <h5 class="card-title">Total Categories</h5>
                        <p class="card-text display-4"><?= $total_categories ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Top 5 Healthiest Foods</h5>
                        <div class="chart-container">
                            <canvas id="healthChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Top 5 Categories by Food Count</h5>
                        <div class="chart-container">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">User Statistics</h5>
                        <p>Total Users: <?= $total_users ?></p>
                        <h6>Recently Registered Users:</h6>
                        <ul id="recentUsersList">
                            <?php while ($user = $result_recent_users->fetch_assoc()): ?>
                                <li><?= htmlspecialchars($user['Username']) ?> -
                                    <?= htmlspecialchars($user['RegistrationDate']) ?>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Recent Activities</h5>
                        <ul class="list-group" id="recentActivities">
                            <?php while ($activity = $result_recent_activities->fetch_assoc()): ?>
                                <li class="list-group-item">
                                    <?= htmlspecialchars($activity['type']) ?> <?= htmlspecialchars($activity['action']) ?>: 
                                    <?= htmlspecialchars($activity['item']) ?> 
                                    (<?= htmlspecialchars($activity['date']) ?>)
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Recent Reviews</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Food</th>
                                    <th>Review</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="recentReviewsTable">
                                <?php if ($result_recent_reviews): ?>
                                    <?php while ($review = $result_recent_reviews->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($review['Username']) ?></td>
                                            <td><?= htmlspecialchars($review['FoodName']) ?></td>
                                            <td><?= htmlspecialchars($review['Feedback']) ?></td>
                                            <td><?= htmlspecialchars($review['Date']) ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4">No recent reviews found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script>
        // Chart for Top 5 Healthiest Foods
        var healthCtx = document.getElementById('healthChart').getContext('2d');
        var healthChart = new Chart(healthCtx, {
            type: 'bar',
            data: {
                labels: [<?php
                $result_top_foods->data_seek(0);
                while ($row = $result_top_foods->fetch_assoc()) {
                    echo "'" . addslashes($row['Name']) . "',";
                }
                ?>],
                datasets: [{
                    label: 'Health Score',
                    data: [<?php
                    $result_top_foods->data_seek(0);
                    while ($row = $result_top_foods->fetch_assoc()) {
                        echo $row['HealthScore'] . ",";
                    }
                    ?>],
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 10
                    }
                }
            }
        });

        // Chart for Top 5 Categories
        var categoryCtx = document.getElementById('categoryChart').getContext('2d');
        var categoryChart = new Chart(categoryCtx, {
            type: 'pie',
            data: {
                labels: [<?php
                $result_categories->data_seek(0);
                while ($row = $result_categories->fetch_assoc()) {
                    echo "'" . addslashes($row['Name']) . "',";
                }
                ?>],
                datasets: [{
                    data: [<?php
                    $result_categories->data_seek(0);
                    while ($row = $result_categories->fetch_assoc()) {
                        echo $row['FoodCount'] . ",";
                    }
                    ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });

        // GSAP Animations
        gsap.from(".card", {
            duration: 1,
            y: 50,
            opacity: 0,
            stagger: 0.2,
            ease: "power3.out"
        });

        gsap.from("h1", {
            duration: 1,
            x: -50,
            opacity: 0,
            ease: "power3.out"
        });

        gsap.from("#recentActivities li", {
            duration: 0.5,
            x: -50,
            opacity: 0,
            stagger: 0.1,
            ease: "power3.out",
            delay: 1
        });

        // Function to refresh dashboard data
        function refreshDashboardData() {
            fetch('dashboard_data.php', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Update total foods
                    document.querySelector('.card-text.display-4').textContent = data.total_foods;

                    // Update average health score
                    document.querySelectorAll('.card-text.display-4')[1].textContent = data.avg_health.toFixed(1);

                    // Update total categories
                    document.querySelectorAll('.card-text.display-4')[2].textContent = data.total_categories;

                    // Update charts
                    updateCharts(data);

                    // Update recent users
                    updateRecentUsers(data.recent_users);

                    // Update recent reviews
                    updateRecentReviews(data.recent_reviews);

                    // Update recent activities
                    updateRecentActivities(data.recent_activities);
                })
                .catch(error => {
                    console.error('Error fetching dashboard data:', error);
                });
        }

        function updateCharts(data) {
            // Update health chart
            healthChart.data.labels = data.top_foods.map(food => food.Name);
            healthChart.data.datasets[0].data = data.top_foods.map(food => food.HealthScore);
            healthChart.update();

            // Update category chart
            categoryChart.data.labels = data.top_categories.map(category => category.Name);
            categoryChart.data.datasets[0].data = data.top_categories.map(category => category.FoodCount);
            categoryChart.update();
        }

        function updateRecentUsers(users) {
            const userList = document.querySelector('#recentUsersList');
            userList.innerHTML = '';
            users.forEach(user => {
                const li = document.createElement('li');
                li.textContent = `${user.Username} - ${user.RegistrationDate}`;
                userList.appendChild(li);
            });
        }

        function updateRecentReviews(reviews) {
            const reviewsTable = document.querySelector('#recentReviewsTable');
            reviewsTable.innerHTML = '';
            reviews.forEach(review => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${review.Username}</td>
                    <td>${review.FoodName}</td>
                    <td>${review.ReviewText}</td>
                    <td>${review.Date}</td>
                `;
                reviewsTable.appendChild(tr);
            });
        }

        function updateRecentActivities(activities) {
            const activitiesList = document.querySelector('#recentActivities');
            activitiesList.innerHTML = '';
            activities.forEach(activity => {
                const li = document.createElement('li');
                li.className = 'list-group-item';
                li.textContent = `${activity.type} ${activity.action}: ${activity.item} (${activity.date})`;
                activitiesList.appendChild(li);
            });
        }

        // Refresh dashboard data every 60 seconds
        setInterval(refreshDashboardData, 60000);
    </script>
</body>

</html>

<?php
// End output buffering and send content
ob_end_flush();

// Close the database connection
$conn->close();
?>