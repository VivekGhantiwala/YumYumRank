<?php
include "connection.php";

$search = isset($_GET['search']) ? $_GET['search'] : '';
$whereClause = '';
if (!empty($search)) {
    $whereClause = "WHERE LOWER(Name) LIKE '%" . strtolower(mysqli_real_escape_string($conn, $search)) . "%' OR LOWER(Description) LIKE '%" . strtolower(mysqli_real_escape_string($conn, $search)) . "%'";
}

$sql = "SELECT COUNT(*) AS total FROM Categories $whereClause";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
echo json_encode(['total' => $row['total']]);
mysqli_close($conn);
?>
