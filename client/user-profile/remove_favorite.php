<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db"); // Replace with your actual database credentials
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['food_id']) && isset($_SESSION['user_id'])) {
    $food_id = $_POST['food_id'];
    $user_id = $_SESSION['user_id'];

    // Prepare the SQL statement to remove the favorite
    $stmt = $conn->prepare("DELETE FROM user_likes WHERE food_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $food_id, $user_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error removing from favorites.']);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}

mysqli_close($conn);
?>
