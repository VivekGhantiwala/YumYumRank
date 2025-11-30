<?php
include "sider.php";
include "connection.php";

$ingredient_id = isset($_GET['ingredient_id']) ? intval($_GET['ingredient_id']) : 0;
if ($ingredient_id <= 0) {
    die("Invalid ingredient ID");
}

$stmt = mysqli_prepare($conn, "SELECT * FROM Ingredients WHERE IngredientID = ?");
mysqli_stmt_bind_param($stmt, "i", $ingredient_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$ingredient = mysqli_fetch_assoc($result);

if (!$ingredient) {
    die("Ingredient not found");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $health_impact = $_POST['health_impact'];
    $description = trim($_POST['description']);

    if (empty($name) || strlen($name) > 255) {
        $error = "Name is required and must be less than 255 characters.";
    } elseif (!in_array($health_impact, ['Positive', 'Neutral', 'Negative'])) {
        $error = "Invalid health impact value.";
    } elseif (strlen($description) > 1000) {
        $error = "Description must be less than 1000 characters.";
    } else {
        $update_stmt = mysqli_prepare($conn, "UPDATE Ingredients SET Name=?, HealthImpact=?, Description=? WHERE IngredientID=?");
        mysqli_stmt_bind_param($update_stmt, "sssi", $name, $health_impact, $description, $ingredient_id);
        
        if (mysqli_stmt_execute($update_stmt)) {
            echo "<script>window.location.href='view_ingredients.php';</script>";
            exit;
        } else {
            $error = "Error updating ingredient: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Ingredient - YumYumRank Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f4f6f9;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 50px;
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1><i class="fas fa-edit"></i> Update Ingredient</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Update Ingredient Form -->
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($ingredient['Name']); ?>" required maxlength="255">
            </div>
            <div class="mb-3">
                <label for="health_impact" class="form-label">Health Impact</label>
                <select class="form-control" id="health_impact" name="health_impact" required>
                    <option value="Positive" <?= $ingredient['HealthImpact'] == 'Positive' ? 'selected' : ''; ?>>Positive</option>
                    <option value="Neutral" <?= $ingredient['HealthImpact'] == 'Neutral' ? 'selected' : ''; ?>>Neutral</option>
                    <option value="Negative" <?= $ingredient['HealthImpact'] == 'Negative' ? 'selected' : ''; ?>>Negative</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" maxlength="1000"><?= htmlspecialchars($ingredient['description']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Ingredient</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>