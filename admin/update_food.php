<?php
// Start output buffering
ob_start();

include "sider.php";
include "connection.php";

$update_message = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $food_id = $_POST['food_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $health_score = $_POST['health_score'];
    $about = $_POST['about'];
    $product_url = $_POST['product_url'];

    // Check if a new image was uploaded
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../client/asset/products/$image");
        $image_update = ", Image = '$image'";
    } else {
        $image_update = "";
    }

    $update_query = "UPDATE Foods SET 
                     Name = '$name', 
                     Description = '$description', 
                     Price = $price, 
                     CategoryID = $category_id, 
                     HealthScore = $health_score, 
                     about = '$about',
                     product_url = '$product_url'
                     $image_update
                     WHERE FoodID = $food_id";

    if (mysqli_query($conn, $update_query)) {
        // Update Nutritional_info table
        $calories = $_POST['calories'];
        $proteins = $_POST['proteins'];
        $carbs = $_POST['carbs'];
        $fats = $_POST['fats'];
        $vitamins = isset($_POST['vitamins']) ? implode(',', $_POST['vitamins']) : ''; // Convert array to comma-separated string, handle if not set
        $minerals = isset($_POST['minerals']) ? implode(',', $_POST['minerals']) : ''; // Convert array to comma-separated string, handle if not set

        $update_nutritional = "UPDATE Nutritional_info SET 
                               Calories = ?, 
                               Proteins = ?, 
                               Carbs = ?, 
                               Fats = ?, 
                               Vitamins = ?, 
                               Minerals = ? 
                               WHERE FoodID = ?";
        $stmt = mysqli_prepare($conn, $update_nutritional);
        mysqli_stmt_bind_param($stmt, "ddddssi", $calories, $proteins, $carbs, $fats, $vitamins, $minerals, $food_id);
        mysqli_stmt_execute($stmt);

        // Update food_ingredients table
        $ingredients = $_POST['ingredients'];
        $quantities = $_POST['ingredient_quantities'];
        $units = $_POST['ingredient_units'];

        // First, delete existing ingredients for this food
        $delete_ingredients = "DELETE FROM food_ingredients WHERE FoodID = ?";
        $stmt = mysqli_prepare($conn, $delete_ingredients);
        mysqli_stmt_bind_param($stmt, "i", $food_id);
        mysqli_stmt_execute($stmt);

        // Then, insert new ingredients
        $insert_ingredients = "INSERT INTO food_ingredients (FoodID, IngredientID, Quantity, Unit) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insert_ingredients);
        for ($i = 0; $i < count($ingredients); $i++) {
            $ingredient_id = $ingredients[$i];
            $quantity = $quantities[$i];
            $unit = $units[$i];
            mysqli_stmt_bind_param($stmt, "iids", $food_id, $ingredient_id, $quantity, $unit);
            mysqli_stmt_execute($stmt);
        }

        $update_message = "<div id='successAlert' class='alert alert-success show'>Food updated successfully!</div>";
        echo "<script>
                setTimeout(function() {
                    var successAlert = document.getElementById('successAlert');
                    var redirectAlert = document.createElement('div');
                    redirectAlert.className = 'alert alert-info show mt-2';
                    redirectAlert.textContent = 'Redirecting to view foods in 7 seconds... ⏳';
                    
                    // Insert the redirect alert after the success alert
                    successAlert.parentNode.insertBefore(redirectAlert, successAlert.nextSibling);
                    
                    setTimeout(function() {
                        window.location.href = 'view_products.php';
                    }, 7000);
                }, 4000);
              </script>";
    } else {
        $update_message = "<div class='alert alert-danger show'>Error updating food: " . mysqli_error($conn) . "</div>";
    }
}

// Fetch food details if editing
if (isset($_GET['id'])) {
    $food_id = $_GET['id'];
    $query = "SELECT f.*, c.Name AS CategoryName, n.* 
              FROM Foods f 
              LEFT JOIN Categories c ON f.CategoryID = c.CategoryID 
              LEFT JOIN Nutritional_info n ON f.FoodID = n.FoodID 
              WHERE f.FoodID = $food_id";
    $result = mysqli_query($conn, $query);
    $food = mysqli_fetch_assoc($result);

    // Fetch ingredients for this food
    $ingredients_query = "SELECT fi.*, i.Name AS IngredientName 
                          FROM food_ingredients fi 
                          JOIN Ingredients i ON fi.IngredientID = i.IngredientID 
                          WHERE fi.FoodID = $food_id";
    $ingredients_result = mysqli_query($conn, $ingredients_query);
}

// Fetch categories for dropdown
$categories_query = "SELECT CategoryID, Name FROM Categories";
$categories_result = mysqli_query($conn, $categories_query);

// Fetch all ingredients for dropdown
$all_ingredients_query = "SELECT IngredientID, Name FROM Ingredients";
$all_ingredients_result = mysqli_query($conn, $all_ingredients_query);

// Fetch units from database
$units_query = "SELECT DISTINCT Unit FROM food_ingredients";
$units_result = mysqli_query($conn, $units_query);
$units = [];
while ($row = mysqli_fetch_assoc($units_result)) {
    $units[] = $row['Unit'];
}

// Fetch foods for alternatives dropdown
$alternatives_query = "SELECT FoodID, Name FROM Foods WHERE FoodID != $food_id";
$alternatives_result = mysqli_query($conn, $alternatives_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Food - YumYumRank Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .fade-in {
            opacity: 0;
            animation: fadeIn 5s ease forwards;
        }
        .slide-in {
            opacity: 0;
            transform: translateY(20px);
            animation: slideIn 0.5s ease forwards;
        }
        @keyframes fadeIn {
            to { opacity: 1; }
        }
        @keyframes slideIn {
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }
        .alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            max-width: 600px;
            padding: 15px;
            border-radius: 8px;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            z-index: 1000;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            font-family: 'Montserrat', sans-serif;
        }
        .alert-success {
            background-color: #4CAF50;
            color: white;
        }
        .alert-danger {
            background-color: #f44336;
            color: white;
        }
        .alert-info {
            background-color: #2196F3;
            color: white;
        }
        .alert.show {
            opacity: 1;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Update Food</h1>
        
        <?php if (!empty($update_message)): ?>
            <div id="successAlert"><?php echo $update_message; ?></div>
        <?php endif; ?>

        <!-- Update Food Form -->
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="food_id" value="<?php echo $food['FoodID']; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $food['Name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo $food['Description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo $food['Price']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <?php
                    mysqli_data_seek($categories_result, 0);
                    while ($category = mysqli_fetch_assoc($categories_result)) {
                        $selected = ($food['CategoryID'] == $category['CategoryID']) ? 'selected' : '';
                        echo "<option value='{$category['CategoryID']}' $selected>{$category['Name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" accept="image/*" name="image">
                <img src="../client/asset/products/<?php echo $food['Image']; ?>" width="100" class="mt-2">
            </div>
            <div class="mb-3">
                <label for="health_score" class="form-label">Health Score</label>
                <input type="number" class="form-control" id="health_score" name="health_score" step="0.1" min="0" max="10" value="<?php echo $food['HealthScore']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="about" class="form-label">About</label>
                <textarea class="form-control" id="about" name="about" rows="3"><?php echo $food['about']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="product_url" class="form-label">Product URL</label>
                <input type="text" class="form-control" id="product_url" name="product_url" value="<?php echo $food['product_url']; ?>">
            </div>

            <!-- Nutritional Information -->
            <h3>Nutritional Information</h3>
            <div class="mb-3">
                <label for="calories" class="form-label">Calories</label>
                <input type="number" class="form-control" id="calories" name="calories" value="<?php echo $food['Calories']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="proteins" class="form-label">Proteins</label>
                <input type="number" class="form-control" id="proteins" name="proteins" value="<?php echo $food['Proteins']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="carbs" class="form-label">Carbs</label>
                <input type="number" class="form-control" id="carbs" name="carbs" value="<?php echo $food['Carbs']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="fats" class="form-label">Fats</label>
                <input type="number" class="form-control" id="fats" name="fats" value="<?php echo $food['Fats']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="vitamins" class="form-label">Vitamins</label>
                <select class="form-control select2" id="vitamins" name="vitamins[]" multiple>
                    <?php
                    $vitamins = array(
                        'A' => 'Vitamin A',
                        'B1' => 'Vitamin B1 (Thiamine)',
                        'B2' => 'Vitamin B2 (Riboflavin)',
                        'B3' => 'Vitamin B3 (Niacin)',
                        'B5' => 'Vitamin B5 (Pantothenic Acid)',
                        'B6' => 'Vitamin B6 (Pyridoxine)',
                        'B7' => 'Vitamin B7 (Biotin)',
                        'B9' => 'Vitamin B9 (Folate)',
                        'B12' => 'Vitamin B12 (Cobalamin)',
                        'C' => 'Vitamin C',
                        'D' => 'Vitamin D',
                        'E' => 'Vitamin E',
                        'K' => 'Vitamin K'
                    );
                    $selected_vitamins = explode(',', $food['Vitamins']);
                    foreach ($vitamins as $key => $vitamin) {
                        $selected = in_array($key, $selected_vitamins) ? 'selected' : '';
                        echo "<option value='$key' $selected>$vitamin</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="minerals" class="form-label">Minerals</label>
                <select class="form-control select2" id="minerals" name="minerals[]" multiple>
                    <?php
                    $minerals = array(
                        'Ca' => 'Calcium',
                        'Fe' => 'Iron',
                        'Mg' => 'Magnesium',
                        'P' => 'Phosphorus',
                        'K' => 'Potassium',
                        'Na' => 'Sodium',
                        'Zn' => 'Zinc',
                        'Cu' => 'Copper',
                        'Mn' => 'Manganese',
                        'Se' => 'Selenium',
                        'I' => 'Iodine',
                        'Cr' => 'Chromium',
                        'Mo' => 'Molybdenum',
                        'F' => 'Fluoride',
                        'Cl' => 'Chloride'
                    );
                    $selected_minerals = explode(',', $food['Minerals']);
                    foreach ($minerals as $key => $mineral) {
                        $selected = in_array($key, $selected_minerals) ? 'selected' : '';
                        echo "<option value='$key' $selected>$mineral</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Ingredients -->
            <h3>Ingredients</h3>
            <div id="ingredients-container">
                <?php $first_ingredient = true; ?>
                <?php while ($ingredient = mysqli_fetch_assoc($ingredients_result)): ?>
                    <div class="ingredient-row mb-3">
                        <select name="ingredients[]" class="form-control" required>
                            <?php
                            mysqli_data_seek($all_ingredients_result, 0);
                            while ($all_ingredient = mysqli_fetch_assoc($all_ingredients_result)) {
                                $selected = ($ingredient['IngredientID'] == $all_ingredient['IngredientID']) ? 'selected' : '';
                                echo "<option value='{$all_ingredient['IngredientID']}' $selected>{$all_ingredient['Name']}</option>";
                            }
                            ?>
                        </select>
                        <input type="number" name="ingredient_quantities[]" class="form-control" value="<?php echo $ingredient['Quantity']; ?>" required>
                        <select name="ingredient_units[]" class="form-control" required>
                            <?php foreach ($units as $unit): ?>
                                <option value="<?php echo $unit; ?>" <?php echo ($ingredient['Unit'] == $unit) ? 'selected' : ''; ?>><?php echo $unit; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (!$first_ingredient): ?>
                            <button type="button" class="btn btn-danger remove-ingredient">Remove</button>
                        <?php endif; ?>
                    </div>
                    <?php $first_ingredient = false; ?>
                <?php endwhile; ?>
            </div>
            <button type="button" class="btn btn-secondary" id="add-ingredient">Add Ingredient</button>

            <!-- Alternatives -->
            <h3 class="mt-4">Alternatives</h3>
            <div class="mb-3">
                <select name="alternatives[]" class="form-control select2" multiple>
                    <?php while ($alternative = mysqli_fetch_assoc($alternatives_result)): ?>
                        <option value="<?php echo $alternative['FoodID']; ?>"><?php echo $alternative['Name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update Food</button>
            <a href="view_products.php" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            // Add ingredient functionality
            $('#add-ingredient').click(function() {
                const container = $('#ingredients-container');
                const newRow = $('<div class="ingredient-row mb-3">').html(`
                    <select name="ingredients[]" class="form-control" required>
                        <?php
                        mysqli_data_seek($all_ingredients_result, 0);
                        while ($ingredient = mysqli_fetch_assoc($all_ingredients_result)) {
                            echo "<option value='{$ingredient['IngredientID']}'>{$ingredient['Name']}</option>";
                        }
                        ?>
                    </select>
                    <input type="number" name="ingredient_quantities[]" class="form-control" required>
                    <select name="ingredient_units[]" class="form-control" required>
                        <?php foreach ($units as $unit): ?>
                            <option value="<?php echo $unit; ?>"><?php echo $unit; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" class="btn btn-danger remove-ingredient">Remove</button>
                `);
                container.append(newRow);
            });

            // Remove ingredient functionality
            $(document).on('click', '.remove-ingredient', function() {
                $(this).closest('.ingredient-row').remove();
            });

            // Add vitamin functionality
            $('#add-vitamin').click(function() {
                const container = $('#vitamins-container');
                const newRow = $('<div class="vitamin-row mb-3">').html(`
                    <input type="text" name="vitamin_names[]" class="form-control" placeholder="Vitamin Name" required>
                    <input type="number" name="vitamin_amounts[]" class="form-control" placeholder="Amount" required>
                    <select name="vitamin_units[]" class="form-control" required>
                        <option value="mg">mg</option>
                        <option value="mcg">mcg</option>
                        <option value="IU">IU</option>
                    </select>
                    <button type="button" class="btn btn-danger remove-vitamin">Remove</button>
                `);
                container.append(newRow);
            });

            // Remove vitamin functionality
            $(document).on('click', '.remove-vitamin', function() {
                $(this).closest('.vitamin-row').remove();
            });

            // Add mineral functionality
            $('#add-mineral').click(function() {
                const container = $('#minerals-container');
                const newRow = $('<div class="mineral-row mb-3">').html(`
                    <select name="mineral_names[]" class="form-control" required>
                        <option value="">Select Mineral</option>
                        <option value="Calcium">Calcium</option>
                        <option value="Iron">Iron</option>
                        <option value="Magnesium">Magnesium</option>
                        <option value="Phosphorus">Phosphorus</option>
                        <option value="Potassium">Potassium</option>
                        <option value="Sodium">Sodium</option>
                        <option value="Zinc">Zinc</option>
                        <option value="Copper">Copper</option>
                        <option value="Manganese">Manganese</option>
                        <option value="Selenium">Selenium</option>
                    </select>
                    <input type="number" name="mineral_amounts[]" class="form-control" placeholder="Amount" required>
                    <select name="mineral_units[]" class="form-control" required>
                        <option value="mg">mg</option>
                        <option value="mcg">mcg</option>
                    </select>
                    <button type="button" class="btn btn-danger remove-mineral">Remove</button>
                `);
                container.append(newRow);
            });

            // Remove mineral functionality
            $(document).on('click', '.remove-mineral', function() {
                $(this).closest('.mineral-row').remove();
            });

            // Form submission
            $('form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.includes('success')) {
                            $('<div class="alert alert-success show">Food item updated successfully!</div>').insertBefore('form');
                            setTimeout(function() {
                                var successAlert = $('.alert-success');
                                var redirectAlert = $('<div class="alert alert-info show mt-2">Redirecting to view foods in 7 seconds... ⏳</div>');
                                redirectAlert.insertAfter(successAlert);
                                setTimeout(function() {
                                    window.location.href = 'view_products.php';
                                }, 7000);
                            }, 4000);
                        } else {
                            $('<div class="alert alert-danger show">Error updating food item. Please try again.</div>').insertBefore('form');
                        }
                    },
                    error: function() {
                        $('<div class="alert alert-danger show">Error updating food item. Please try again.</div>').insertBefore('form');
                    }
                });
            });
        });
    </script>
</body>
</html>

<?php
mysqli_close($conn);
// End output buffering and flush output
ob_end_flush();
?>
