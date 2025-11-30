<?php
include "connection.php";

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT i.*, COUNT(fi.FoodID) as usage_count 
        FROM Ingredients i 
        LEFT JOIN food_ingredients fi ON i.IngredientID = fi.IngredientID 
        WHERE i.Name LIKE ? OR i.description LIKE ?
        GROUP BY i.IngredientID
        ORDER BY i.Name
        LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error in SQL preparation: " . $conn->error);
}

$search_pattern = "%{$search}%";
if (!$stmt->bind_param("ssii", $search_pattern, $search_pattern, $limit, $offset)) {
    die("Error in parameter binding: " . $stmt->error);
}

if (!$stmt->execute()) {
    die("Error in SQL execution: " . $stmt->error);
}

$result = $stmt->get_result();
if (!$result) {
    die("Error getting result set: " . $stmt->error);
}

$ingredients = [];
while ($row = $result->fetch_assoc()) {
    $ingredients[] = $row;
}

header('Content-Type: application/json');
echo json_encode($ingredients);

$stmt->close();
$conn->close();
?>
