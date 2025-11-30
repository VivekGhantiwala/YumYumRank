<?php
include "connection.php";

$search = isset($_GET['search']) ? $_GET['search'] : '';

$whereClause = '';
if (!empty($search)) {
    $whereClause = "WHERE f.Name LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' OR f.Description LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
}

$query = "SELECT COUNT(*) AS total FROM Foods f LEFT JOIN Categories c ON f.CategoryID = c.CategoryID $whereClause";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

header('Content-Type: application/json');
echo json_encode(['total' => $row['total']]);

mysqli_close($conn);
?>
