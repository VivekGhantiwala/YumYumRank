<?php
include "sider.php";
include "connection.php";

// Function to get data for the last 7 days
function getLast7DaysData($conn, $table, $dateColumn)
{
    $data = array_fill(0, 7, 0);
    $labels = [];

    for ($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $labels[] = date('D', strtotime($date));

        $sql = "SELECT COUNT(*) as count FROM $table WHERE DATE($dateColumn) = '$date'";
        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            $data[6 - $i] = $row['count'];
        }
    }

    return ['labels' => $labels, 'data' => $data];
}

// Get user registration data for the last 7 days
$userRegistrationData = getLast7DaysData($conn, 'users', 'RegistrationDate');

// Get food rating data for the last 7 days
$foodRatingData = getLast7DaysData($conn, 'ratings', 'Date');

// Get top 5 rated foods
$topRatedFoods = [];
$sql = "SELECT f.Name, AVG(r.Score) as AvgScore, COUNT(r.RatingID) as RatingCount
        FROM foods f 
        JOIN ratings r ON f.FoodID = r.FoodID 
        GROUP BY f.FoodID 
        HAVING RatingCount > 5
        ORDER BY AvgScore DESC 
        LIMIT 5";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $topRatedFoods[] = $row;
    }
}

// Get user statistics
$sql = "SELECT 
    (SELECT COUNT(*) FROM users) as TotalUsers,
    (SELECT COUNT(*) FROM users WHERE DATE(RegistrationDate) = CURDATE()) as NewUsersToday,
    (SELECT COUNT(*) FROM ratings) as TotalRatings,
    (SELECT COUNT(*) FROM reviews) as TotalReviews,
    (SELECT COUNT(DISTINCT UserID) FROM (
        SELECT UserID FROM ratings WHERE DATE(Date) = CURDATE()
        UNION
        SELECT UserID FROM reviews WHERE DATE(Date) = CURDATE()
    ) as ActiveUsers) as ActiveUsersToday";
$result = $conn->query($sql);
$userStats = $result->fetch_assoc();

// Get user growth data for the last 30 days
$userGrowthData = [];
$sql = "SELECT DATE(RegistrationDate) as Date, COUNT(*) as Count 
        FROM users 
        WHERE RegistrationDate >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) 
        GROUP BY DATE(RegistrationDate) 
        ORDER BY Date DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userGrowthData[] = $row;
    }
}

// Get recent activities
$recentActivities = [];
$sql = "SELECT u.Username, 'rated' as Action, f.Name as FoodName, r.Date 
        FROM ratings r 
        JOIN users u ON r.UserID = u.UserID 
        JOIN foods f ON r.FoodID = f.FoodID 
        UNION ALL 
        SELECT u.Username, 'reviewed' as Action, f.Name as FoodName, rv.Date 
        FROM ratings rv 
        JOIN users u ON rv.UserID = u.UserID 
        JOIN foods f ON rv.FoodID = f.FoodID 
        ORDER BY Date DESC 
        LIMIT 10";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recentActivities[] = $row;
    }
}

// Get most active users
$mostActiveUsers = [];
$sql = "SELECT u.Username, 
        COUNT(DISTINCT r.RatingID) as RatingCount, 
        COUNT(DISTINCT rv.ReviewID) as ReviewCount
        FROM users u
        LEFT JOIN ratings r ON u.UserID = r.UserID
        LEFT JOIN reviews rv ON u.UserID = rv.UserID
        GROUP BY u.UserID
        ORDER BY (COUNT(DISTINCT r.RatingID) + COUNT(DISTINCT rv.ReviewID)) DESC
        LIMIT 5";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mostActiveUsers[] = $row;
    }
}

// Get food category distribution
$foodCategories = [];
$sql = "SELECT c.Name, COUNT(f.FoodID) as FoodCount
        FROM categories c
        LEFT JOIN foods f ON c.CategoryID = f.CategoryID
        GROUP BY c.CategoryID
        ORDER BY FoodCount DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $foodCategories[] = $row;
    }
}

// Get user retention rate
$retentionRate = [];
$sql = "SELECT 
    WEEK(RegistrationDate) as Week,
    COUNT(DISTINCT UserID) as NewUsers,
    COUNT(DISTINCT CASE WHEN EXISTS (
        SELECT 1 FROM ratings 
        WHERE ratings.UserID = users.UserID 
        AND DATEDIFF(ratings.Date, users.RegistrationDate) >= 7
    ) THEN UserID END) as RetainedUsers
FROM users
WHERE RegistrationDate >= DATE_SUB(CURDATE(), INTERVAL 8 WEEK)
GROUP BY WEEK(RegistrationDate)
ORDER BY Week DESC
LIMIT 8";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $retentionRate[] = $row;
    }
}

// Calculate retention rate percentage
$retentionRateData = array_map(function($week) {
    return $week['NewUsers'] > 0 ? round(($week['RetainedUsers'] / $week['NewUsers']) * 100, 1) : 0;
}, array_reverse($retentionRate));

// Get user engagement scores (example data, replace with actual data from your database)
$userEngagementScores = [7, 8, 6, 9, 5];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Engagement - YumYumRank Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f4f6f9;
        }
        .stats-card {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .stats-card h3 {
            font-size: 2rem;
            margin-bottom: 0;
            color: #007bff;
        }
        .stats-card i {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #6c757d;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-title {
            font-weight: bold;
            color: #495057;
        }
        .list-group-item {
            border: none;
            padding: 0.5rem 1rem;
        }
        .list-group-item:nth-child(even) {
            background-color: #f8f9fa;
        }
        .content-wrapper {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <div class="container-fluid mt-5">
            <h1 class="mb-4 text-center">User Engagement Dashboard</h1>

            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stats-card text-center">
                        <i class="fas fa-users mb-2"></i>
                        <h5>Total Users</h5>
                        <h3><?php echo number_format($userStats['TotalUsers']); ?></h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card text-center">
                        <i class="fas fa-user-plus mb-2"></i>
                        <h5>New Users Today</h5>
                        <h3><?php echo $userStats['NewUsersToday']; ?></h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card text-center">
                        <i class="fas fa-star mb-2"></i>
                        <h5>Total Ratings</h5>
                        <h3><?php echo number_format($userStats['TotalRatings']); ?></h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card text-center">
                        <i class="fas fa-comments mb-2"></i>
                        <h5>Total Reviews</h5>
                        <h3><?php echo number_format($userStats['TotalReviews']); ?></h3>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">User Registrations (Last 7 Days)</h5>
                            <canvas id="userRegistrationChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Food Ratings (Last 7 Days)</h5>
                            <canvas id="foodRatingChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Top 5 Rated Foods</h5>
                            <?php if (count($topRatedFoods) > 0): ?>
                                <canvas id="topRatedFoodsChart"></canvas>
                            <?php else: ?>
                                <p class="text-center">No foods with more than 5 ratings found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">User Growth (Last 30 Days)</h5>
                            <canvas id="userGrowthChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Recent Activity</h5>
                            <ul class="list-group">
                                <?php foreach ($recentActivities as $activity): ?>
                                    <li class="list-group-item">
                                        <strong><?php echo htmlspecialchars($activity['Username']); ?></strong>
                                        <?php echo $activity['Action']; ?>
                                        <strong><?php echo htmlspecialchars($activity['FoodName']); ?></strong>
                                        on <?php echo date('F j, Y', strtotime($activity['Date'])); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Most Active Users</h5>
                            <ul class="list-group">
                                <?php foreach ($mostActiveUsers as $user): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?php echo htmlspecialchars($user['Username']); ?>
                                        <span class="badge bg-primary rounded-pill">
                                            <?php echo $user['RatingCount'] + $user['ReviewCount']; ?> activities
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Food Category Distribution</h5>
                            <canvas id="foodCategoryChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">User Retention Rate (Last 8 Weeks)</h5>
                            <canvas id="retentionRateChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">User Engagement Score</h5>
                            <canvas id="userEngagementScoreChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // User Registration Chart
        new Chart(document.getElementById('userRegistrationChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($userRegistrationData['labels']); ?>,
                datasets: [{
                    label: 'New Users',
                    data: <?php echo json_encode($userRegistrationData['data']); ?>,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Food Rating Chart
        // Food Rating Chart
        new Chart(document.getElementById('foodRatingChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($foodRatingData['labels']); ?>,
                datasets: [{
                    label: 'Ratings',
                    data: <?php echo json_encode($foodRatingData['data']); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgb(54, 162, 235)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Top Rated Foods Chart
        <?php if (count($topRatedFoods) > 0): ?>
            new Chart(document.getElementById('topRatedFoodsChart'), {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode(array_column($topRatedFoods, 'Name')); ?>,
                    datasets: [{
                        label: 'Average Score',
                        data: <?php echo json_encode(array_map(function ($food) {
                            return round($food['AvgScore'], 2);
                        }, $topRatedFoods)); ?>,
                        backgroundColor: 'rgba(255, 206, 86, 0.5)',
                        borderColor: 'rgb(255, 206, 86)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true,
                            max: 5
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += context.parsed.x.toFixed(2) + ' (';
                                    label += <?php echo json_encode(array_column($topRatedFoods, 'RatingCount')); ?>[context.dataIndex] + ' ratings)';
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        <?php endif; ?>

        // User Growth Chart
        new Chart(document.getElementById('userGrowthChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_map(function ($data) {
                    return date('M d', strtotime($data['Date']));
                }, array_reverse($userGrowthData))); ?>,
                datasets: [{
                    label: 'New Users',
                    data: <?php echo json_encode(array_map(function ($data) {
                        return $data['Count'];
                    }, array_reverse($userGrowthData))); ?>,
                    borderColor: 'rgb(255, 99, 132)',
                    tension: 0.1,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Food Category Distribution Chart
        new Chart(document.getElementById('foodCategoryChart'), {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_column($foodCategories, 'Name')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($foodCategories, 'FoodCount')); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)'
                    ],
                    borderColor: 'white',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                var value = context.parsed || 0;
                                var total = context.dataset.data.reduce((a, b) => a + b, 0);
                                var percentage = ((value / total) * 100).toFixed(1);
                                return label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // User Retention Rate Chart
        new Chart(document.getElementById('retentionRateChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_map(function($week) { return 'Week ' . $week; }, range(1, 8))); ?>,
                datasets: [{
                    label: 'Retention Rate',
                    data: <?php echo json_encode($retentionRateData); ?>,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Retention: ' + context.parsed.y.toFixed(1) + '%';
                            }
                        }
                    }
                }
            }
        });

        // User Engagement Score Chart
        new Chart(document.getElementById('userEngagementScoreChart'), {
            type: 'radar',
            data: {
                labels: ['Logins', 'Ratings', 'Reviews', 'Likes', 'Time Spent'],
                datasets: [{
                    label: 'Engagement Score',
                    data: <?php echo json_encode($userEngagementScores); ?>,
                    fill: true,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgb(255, 99, 132)',
                    pointBackgroundColor: 'rgb(255, 99, 132)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(255, 99, 132)'
                }]
            },
            options: {
                elements: {
                    line: {
                        borderWidth: 3
                    }
                },
                scales: {
                    r: {
                        angleLines: {
                            display: false
                        },
                        suggestedMin: 0,
                        suggestedMax: 10
                    }
                }
            }
        });
    </script>
</body>
</html>