<?php
include "sider.php";
include "connection.php";

// Function to get data for the last 30 days
function getLast30DaysData($conn, $table, $dateColumn, $valueColumn)
{
    $data = array_fill(0, 30, 0);
    $labels = [];

    for ($i = 29; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $labels[] = date('M d', strtotime($date));

        $sql = "SELECT SUM($valueColumn) as total FROM $table WHERE DATE($dateColumn) = '$date'";
        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            $data[29 - $i] = $row['total'] ? $row['total'] : 0;
        }
    }

    return ['labels' => $labels, 'data' => $data];
}

// Get top 10 trending foods
$trendingFoods = [];
$sql = "SELECT f.Name, COUNT(r.RatingID) as RatingCount
        FROM foods f 
        JOIN ratings r ON f.FoodID = r.FoodID 
        WHERE r.Date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        GROUP BY f.FoodID 
        ORDER BY RatingCount DESC 
        LIMIT 10";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $trendingFoods[] = $row;
    }
}

// Get rating trend data
$ratingTrendData = getLast30DaysData($conn, 'ratings', 'Date', 'Score');

// Get category popularity data
$categoryPopularity = [];
$sql = "SELECT c.Name, COUNT(r.RatingID) as RatingCount
        FROM categories c
        JOIN foods f ON c.CategoryID = f.CategoryID
        JOIN ratings r ON f.FoodID = r.FoodID
        WHERE r.Date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        GROUP BY c.CategoryID
        ORDER BY RatingCount DESC
        LIMIT 5";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categoryPopularity[] = $row;
    }
}

// Get top rated foods
$topRatedFoods = [];
$sql = "SELECT f.Name, AVG(r.Score) as AvgScore
        FROM foods f 
        JOIN ratings r ON f.FoodID = r.FoodID 
        WHERE r.Date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        GROUP BY f.FoodID 
        HAVING COUNT(r.RatingID) > 5
        ORDER BY AvgScore DESC 
        LIMIT 5";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $topRatedFoods[] = $row;
    }
}

// Get food price trends
$foodPriceTrends = getLast30DaysData($conn, 'foods', 'created_at', 'Price');

// Get new food additions
$newFoodAdditions = [];
$sql = "SELECT Name, created_at 
        FROM foods 
        WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        ORDER BY created_at DESC
        LIMIT 10";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $newFoodAdditions[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Trends Analytics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Food Trends Analytics</h1>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Top 10 Trending Foods (Last 30 Days)</h5>
                        <canvas id="trendingFoodsChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Rating Trend (Last 30 Days)</h5>
                        <canvas id="ratingTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Category Popularity (Last 30 Days)</h5>
                        <canvas id="categoryPopularityChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Top 5 Rated Foods (Last 30 Days)</h5>
                        <canvas id="topRatedFoodsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Food Price Trends (Last 30 Days)</h5>
                        <canvas id="foodPriceTrendsChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">New Food Additions (Last 30 Days)</h5>
                        <ul class="list-group">
                            <?php foreach ($newFoodAdditions as $food): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo htmlspecialchars($food['Name']); ?>
                                    <span class="badge bg-primary rounded-pill"><?php echo date('M d', strtotime($food['created_at'])); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Trending Foods Chart
        new Chart(document.getElementById('trendingFoodsChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($trendingFoods, 'Name')); ?>,
                datasets: [{
                    label: 'Rating Count',
                    data: <?php echo json_encode(array_column($trendingFoods, 'RatingCount')); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgb(75, 192, 192)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Ratings'
                        }
                    }
                }
            }
        });

        // Rating Trend Chart
        new Chart(document.getElementById('ratingTrendChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($ratingTrendData['labels']); ?>,
                datasets: [{
                    label: 'Average Rating',
                    data: <?php echo json_encode($ratingTrendData['data']); ?>,
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
                        max: 5,
                        title: {
                            display: true,
                            text: 'Average Rating'
                        }
                    }
                }
            }
        });

        // Category Popularity Chart
        new Chart(document.getElementById('categoryPopularityChart'), {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_column($categoryPopularity, 'Name')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($categoryPopularity, 'RatingCount')); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 206, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    title: {
                        display: true,
                        text: 'Category Popularity'
                    }
                }
            }
        });

        // Top Rated Foods Chart
        new Chart(document.getElementById('topRatedFoodsChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($topRatedFoods, 'Name')); ?>,
                datasets: [{
                    label: 'Average Score',
                    data: <?php echo json_encode(array_column($topRatedFoods, 'AvgScore')); ?>,
                    backgroundColor: 'rgba(255, 206, 86, 0.6)',
                    borderColor: 'rgb(255, 206, 86)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 5,
                        title: {
                            display: true,
                            text: 'Average Score'
                        }
                    }
                }
            }
        });

        // Food Price Trends Chart
        new Chart(document.getElementById('foodPriceTrendsChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($foodPriceTrends['labels']); ?>,
                datasets: [{
                    label: 'Average Price',
                    data: <?php echo json_encode($foodPriceTrends['data']); ?>,
                    borderColor: 'rgb(153, 102, 255)',
                    tension: 0.1,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Average Price'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
