<?php
include "connection.php";

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$limit = 5;
$offset = ($page - 1) * $limit;

$whereClause = '';
if (!empty($search)) {
    $whereClause = "WHERE LOWER(Categories.Name) LIKE '%" . strtolower(mysqli_real_escape_string($conn, $search)) . "%'";
}

$sql = "SELECT Categories.*, COALESCE(COUNT(Foods.FoodID), 0) AS FoodCount 
        FROM Categories 
        LEFT JOIN Foods ON Categories.CategoryID = Foods.CategoryID 
        $whereClause 
        GROUP BY Categories.CategoryID 
        LIMIT $limit OFFSET $offset";

$result = mysqli_query($conn, $sql);
$categories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
}

echo json_encode($categories);
mysqli_close($conn);
?>
