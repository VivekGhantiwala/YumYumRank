<?php
include "connection.php";

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$limit = isset($_GET['limit']) ? $_GET['limit'] : 5;
$offset = ($page - 1) * $limit;

$whereClause = '';
if (!empty($search)) {
    $whereClause = "WHERE f.Name LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' OR f.Description LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
}

$query = "SELECT f.FoodID, f.Name AS FoodName, f.Description, f.Price, c.Name AS CategoryName, f.Image, f.HealthScore, f.created_at, f.about, f.product_url,
          n.Calories, n.Proteins, n.Carbs, n.Fats, n.Vitamins, n.Minerals,
          GROUP_CONCAT(CONCAT(i.Name, ' (', fi.Quantity, ' ', fi.Unit, ')') SEPARATOR ', ') AS Ingredients
          FROM Foods f 
          LEFT JOIN Categories c ON f.CategoryID = c.CategoryID
          LEFT JOIN Nutritional_info n ON f.FoodID = n.FoodID
          LEFT JOIN food_ingredients fi ON f.FoodID = fi.FoodID
          LEFT JOIN Ingredients i ON fi.IngredientID = i.IngredientID
          $whereClause
          GROUP BY f.FoodID
          LIMIT $limit OFFSET $offset";

$result = mysqli_query($conn, $query);

$foods = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $foods[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($foods, JSON_UNESCAPED_UNICODE); // Added JSON_UNESCAPED_UNICODE

mysqli_close($conn);
?>
