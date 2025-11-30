<?php
include "connection.php";

$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT COUNT(*) AS total FROM Ingredients WHERE Name LIKE ? OR description LIKE ?";
$stmt = $conn->prepare($sql);
$search_pattern = "%{$search}%";
$stmt->bind_param("ss", $search_pattern, $search_pattern);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode(['total' => $row['total']]);

$stmt->close();
$conn->close();
?>
