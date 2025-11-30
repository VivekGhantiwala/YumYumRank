<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];
$new_username = $_POST['username'] ?? '';

// Fetch the current username
$stmt = $conn->prepare("SELECT Username FROM users WHERE UserID = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$current_username = $user['Username'];

if ($new_username === $current_username) {
    echo json_encode(['success' => true, 'message' => 'No change in username']);
    exit();
}

// Check if the new username already exists
$stmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE Username = ? AND UserID != ?");
$stmt->bind_param("si", $new_username, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

if ($row['count'] > 0) {
    echo json_encode(['success' => false, 'message' => 'The username already exists']);
} else {
    echo json_encode(['success' => true, 'message' => 'Username is available']);
}

mysqli_close($conn);
?>
