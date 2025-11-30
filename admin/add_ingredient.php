<?php
include "sider.php";
include "connection.php";

$notification = '';

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_ingredient'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $health_impact = $_POST['health_impact'];

    // Validation
    if (empty($name)) {
        $notification = '<div class="alert alert-danger" role="alert">Ingredient name cannot be empty.</div>';
    } elseif (empty($description)) {
        $notification = '<div class="alert alert-danger" role="alert">Ingredient description cannot be empty.</div>';
    } elseif (strlen($description) > 255) {
        $notification = '<div class="alert alert-danger" role="alert">Description must be 255 characters or less.</div>';
    } elseif (!in_array($health_impact, ['Positive', 'Neutral', 'Negative'])) {
        $notification = '<div class="alert alert-danger" role="alert">Invalid health impact value.</div>';
    } else {
        // Check if ingredient already exists
        $check_query = "SELECT * FROM Ingredients WHERE Name = '$name'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $notification = '<div class="alert alert-warning" role="alert">Ingredient already exists.</div>';
        } else {
            // Insert new ingredient
            $insert_query = "INSERT INTO Ingredients (Name, Description, HealthImpact) VALUES ('$name', '$description', '$health_impact')";
            $result = mysqli_query($conn, $insert_query);

            if ($result) {
                $notification = '<div class="alert alert-success" role="alert">Ingredient added successfully!</div>';
                // Redirect after a short delay
                echo "<script>
                    setTimeout(function() {
                        window.location.href = 'view_ingredients.php';
                    }, 2000);
                </script>";
            } else {
                $notification = '<div class="alert alert-danger" role="alert">Error adding ingredient: ' . mysqli_error($conn) . '</div>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Ingredients - YumYumRank Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }
        h1 {
            font-size: 2.5rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 2rem;
        }
        .form-control {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }
        .btn-primary {
            background-color: #3b82f6;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #2563eb;
        }
        .alert {
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }
        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .alert-warning {
            background-color: #fef3c7;
            color: #92400e;
        }
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container">
        <h1 class="text-3xl font-semibold text-gray-800 mb-8">Add Ingredients</h1>

        <?php 
        if (!empty($notification)) {
            echo $notification;
        }
        ?>

        <!-- Add Ingredient Form -->
        <form method="POST" action="" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Add New Ingredient</h2>
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <input type="text" class="form-control" id="name" name="name" >
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" maxlength="255" ></textarea>
            </div>
            <div class="mb-6">
                <label for="health_impact" class="block text-gray-700 text-sm font-bold mb-2">Health Impact</label>
                <select class="form-control" id="health_impact" name="health_impact" >
                    <option value="Positive">Positive</option>
                    <option value="Neutral">Neutral</option>
                    <option value="Negative">Negative</option>
                </select>
            </div>
            <button type="submit" name="add_ingredient" class="btn-primary">Add Ingredient</button>
        </form>
    </div>
</body>

</html>

<?php mysqli_close($conn); ?>