<?php
include "sider.php";
include "connection.php";

// Function to sanitize input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Initialize error array
$errors = array();

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_food'])) {
    // Validate and sanitize input fields
    $name = sanitize_input($_POST['name']);
    if (empty($name)) {
        $errors['name'] = "Name is required.";
    } elseif (strlen($name) > 255) {
        $errors['name'] = "Name must be less than 255 characters.";
    }

    $description = sanitize_input($_POST['description']);
    if (strlen($description) > 1000) {
        $errors['description'] = "Description must be less than 1000 characters.";
    }

    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
    if ($price === false || $price < 0) {
        $errors['price'] = "Please enter a valid positive price.";
    }

    $category_id = filter_var($_POST['category_id'], FILTER_VALIDATE_INT);
    if ($category_id === false || $category_id <= 0) {
        $errors['category_id'] = "Please select a valid category.";
    }

    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $errors['image'] = "Please upload a valid image file.";
    } else {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['image']['type'], $allowed_types)) {
            $errors['image'] = "Only JPG, PNG, and GIF files are allowed.";
        }
    }

    $health_score = filter_var($_POST['health_score'], FILTER_VALIDATE_FLOAT);
    if ($health_score === false || $health_score < 0 || $health_score > 10) {
        $errors['health_score'] = "Health score must be between 0 and 10.";
    }

    $about = sanitize_input($_POST['about']);
    if (strlen($about) > 1000) {
        $errors['about'] = "About section must be less than 1000 characters.";
    }

    $product_url = filter_var($_POST['product_url'], FILTER_VALIDATE_URL);
    if ($product_url === false) {
        $errors['product_url'] = "Please enter a valid URL for the product.";
    }

    $calories = filter_var($_POST['calories'], FILTER_VALIDATE_FLOAT);
    if ($calories === false || $calories < 0) {
        $errors['calories'] = "Please enter a valid positive number for calories.";
    }

    $proteins = filter_var($_POST['proteins'], FILTER_VALIDATE_FLOAT);
    if ($proteins === false || $proteins < 0) {
        $errors['proteins'] = "Please enter a valid positive number for proteins.";
    }

    $carbs = filter_var($_POST['carbs'], FILTER_VALIDATE_FLOAT);
    if ($carbs === false || $carbs < 0) {
        $errors['carbs'] = "Please enter a valid positive number for carbs.";
    }

    $fats = filter_var($_POST['fats'], FILTER_VALIDATE_FLOAT);
    if ($fats === false || $fats < 0) {
        $errors['fats'] = "Please enter a valid positive number for fats.";
    }

    $vitamins = isset($_POST['vitamins']) ? filter_var($_POST['vitamins'], FILTER_VALIDATE_FLOAT) : null;
    if ($vitamins === false || $vitamins < 0) {
        $errors['vitamins'] = "Please enter a valid positive number for vitamins.";
    }

    $minerals = isset($_POST['minerals']) ? $_POST['minerals'] : [];
    if (empty($minerals)) {
        $errors['minerals'] = "Please select at least one mineral.";
    }

    // Validate ingredients
    if (!isset($_POST['ingredients']) || !is_array($_POST['ingredients']) || count($_POST['ingredients']) === 0) {
        $errors['ingredients'] = "Please add at least one ingredient.";
    } else {
        foreach ($_POST['ingredients'] as $index => $ingredient_id) {
            if (!filter_var($ingredient_id, FILTER_VALIDATE_INT) || $ingredient_id <= 0) {
                $errors['ingredients'][$index] = "Please select a valid ingredient for entry " . ($index + 1) . ".";
            }
            if (!isset($_POST['ingredient_quantities'][$index]) || !is_numeric($_POST['ingredient_quantities'][$index]) || $_POST['ingredient_quantities'][$index] <= 0) {
                $errors['ingredient_quantities'][$index] = "Please enter a valid positive quantity for ingredient " . ($index + 1) . ".";
            }
            if (!isset($_POST['ingredient_units'][$index]) || empty($_POST['ingredient_units'][$index])) {
                $errors['ingredient_units'][$index] = "Please select a valid unit for ingredient " . ($index + 1) . ".";
            }
        }
    }

    // If there are no errors, proceed with insertion
    if (empty($errors)) {
        // Upload the image
        $target_dir = "../client/asset/products/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $_FILES['image']['name'];

            // Insert into Foods table
            $sql_food = "INSERT INTO Foods (Name, Description, Price, CategoryID, Image, HealthScore, about, product_url) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql_food);
            mysqli_stmt_bind_param($stmt, "sssdsdss", $name, $description, $price, $category_id, $image, $health_score, $about, $product_url);
            
            if (mysqli_stmt_execute($stmt)) {
                $food_id = mysqli_insert_id($conn);

                // Insert into Nutritional_info table
                $sql_nutritional = "INSERT INTO Nutritional_info (FoodID, Calories, Proteins, Carbs, Fats, Vitamins, Minerals) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt_nutritional = mysqli_prepare($conn, $sql_nutritional);
                $minerals_string = implode(',', $minerals);
                mysqli_stmt_bind_param($stmt_nutritional, "iddddds", $food_id, $calories, $proteins, $carbs, $fats, $vitamins, $minerals_string);
                mysqli_stmt_execute($stmt_nutritional);

                // Insert into food_ingredients table
                $sql_food_ingredients = "INSERT INTO food_ingredients (FoodID, IngredientID, Quantity, Unit) VALUES (?, ?, ?, ?)";
                $stmt_ingredients = mysqli_prepare($conn, $sql_food_ingredients);

                for ($i = 0; $i < count($_POST['ingredients']); $i++) {
                    $ingredient_id = $_POST['ingredients'][$i];
                    $quantity = $_POST['ingredient_quantities'][$i];
                    $unit = $_POST['ingredient_units'][$i];

                    mysqli_stmt_bind_param($stmt_ingredients, "iidd", $food_id, $ingredient_id, $quantity, $unit);
                    mysqli_stmt_execute($stmt_ingredients);
                }

                // Insert into alternatives table
                if (isset($_POST['alternatives']) && is_array($_POST['alternatives'])) {
                    $sql_alternatives = "INSERT INTO alternatives (OriginalFoodID, AlternativeFoodID) VALUES (?, ?)";
                    $stmt_alternatives = mysqli_prepare($conn, $sql_alternatives);

                    foreach ($_POST['alternatives'] as $alternative_id) {
                        if (filter_var($alternative_id, FILTER_VALIDATE_INT) && $alternative_id > 0) {
                            mysqli_stmt_bind_param($stmt_alternatives, "ii", $food_id, $alternative_id);
                            mysqli_stmt_execute($stmt_alternatives);
                        }
                    }
                }
                echo "<div id='successAlert' class='alert alert-success show'>Food item added successfully! 🎉</div>";
                
                // Delay the redirection message and ensure success message is visible
                echo "<script>
                    setTimeout(function() {
                        var successAlert = document.getElementById('successAlert');
                        var redirectAlert = document.createElement('div');
                        redirectAlert.className = 'alert alert-info show mt-2';
                        redirectAlert.textContent = 'Redirecting to view products in 7 seconds... ⏳';
                        
                        // Insert the redirect alert after the success alert
                        successAlert.parentNode.insertBefore(redirectAlert, successAlert.nextSibling);
                        
                        setTimeout(function() {
                            window.location.href = 'view_products.php';
                        }, 7000);
                    }, 4000); // Increased delay to 3 seconds for better visibility of success message
                </script>";
                
                // Clear form data after successful submission
                $_POST = array();
            } else {
                echo "<div class='alert alert-danger show'>Error adding food item. Please try again.</div>";
            }
        } else {
            echo "<div class='alert alert-danger show'>Error uploading image. Please try again.</div>";
        }
    }
}

// Fetch categories for the dropdown
$categories_query = "SELECT CategoryID, Name FROM Categories";
$categories_result = mysqli_query($conn, $categories_query);

// Fetch ingredients for the dropdown
$ingredients_query = "SELECT IngredientID, Name, Description, HealthImpact FROM Ingredients";
$ingredients_result = mysqli_query($conn, $ingredients_query);

// Fetch foods for alternatives dropdown
$alternatives_query = "SELECT FoodID, Name FROM Foods";
$alternatives_result = mysqli_query($conn, $alternatives_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - YumYumRank Admin</title>
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
        <h1 class="mb-4 fade-in">Add New Product</h1>

        <!-- Add Food Form -->
        <form method="POST" action="" enctype="multipart/form-data" class="slide-in">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control <?php echo isset($errors['name']) ? 'is-invalid' : ''; ?>" id="name" name="name" required maxlength="255" value="">
                <?php if (isset($errors['name'])): ?>
                    <div class="error-message"><?php echo $errors['name']; ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control <?php echo isset($errors['description']) ? 'is-invalid' : ''; ?>" id="description" name="description" rows="3" maxlength="1000"></textarea>
                <?php if (isset($errors['description'])): ?>
                    <div class="error-message"><?php echo $errors['description']; ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control <?php echo isset($errors['price']) ? 'is-invalid' : ''; ?>" id="price" name="price" step="0.01" min="0" required value="">
                <?php if (isset($errors['price'])): ?>
                    <div class="error-message"><?php echo $errors['price']; ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-control <?php echo isset($errors['category_id']) ? 'is-invalid' : ''; ?>" id="category_id" name="category_id" required>
                    <option value="">Select a category</option>
                    <?php
                    while ($category = mysqli_fetch_assoc($categories_result)) {
                        echo "<option value='{$category['CategoryID']}'>{$category['Name']}</option>";
                    }
                    ?>
                </select>
                <?php if (isset($errors['category_id'])): ?>
                    <div class="error-message"><?php echo $errors['category_id']; ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control <?php echo isset($errors['image']) ? 'is-invalid' : ''; ?>" accept="image/jpeg,image/png,image/gif" id="image" name="image" required>
                <?php if (isset($errors['image'])): ?>
                    <div class="error-message"><?php echo $errors['image']; ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="health_score" class="form-label">Health Score</label>
                <input type="number" class="form-control <?php echo isset($errors['health_score']) ? 'is-invalid' : ''; ?>" id="health_score" name="health_score" step="0.1" min="0" max="10" required value="">
                <?php if (isset($errors['health_score'])): ?>
                    <div class="error-message"><?php echo $errors['health_score']; ?></div>
                <?php endif; ?>
            </div>
            <h3>Nutritional Information</h3>
            <div class="mb-3">
                <label for="calories" class="form-label">Calories</label>
                <input type="number" step="0.01" min="0" class="form-control <?php echo isset($errors['calories']) ? 'is-invalid' : ''; ?>" id="calories" name="calories" required value="">
                <?php if (isset($errors['calories'])): ?>
                    <div class="invalid-feedback"><?php echo $errors['calories']; ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="proteins" class="form-label">Proteins (g)</label>
                <input type="number" step="0.01" min="0" class="form-control <?php echo isset($errors['proteins']) ? 'is-invalid' : ''; ?>" id="proteins" name="proteins" required value="">
                <?php if (isset($errors['proteins'])): ?>
                    <div class="invalid-feedback"><?php echo $errors['proteins']; ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="carbs" class="form-label">Carbs (g)</label>
                <input type="number" step="0.01" min="0" class="form-control <?php echo isset($errors['carbs']) ? 'is-invalid' : ''; ?>" id="carbs" name="carbs" required value="<?php echo isset($_POST['carbs']) ? htmlspecialchars($_POST['carbs']) : ''; ?>">
                <?php if (isset($errors['carbs'])): ?>
                    <div class="invalid-feedback"><?php echo $errors['carbs']; ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="fats" class="form-label">Fats (g)</label>
                <input type="number" step="0.01" min="0" class="form-control <?php echo isset($errors['fats']) ? 'is-invalid' : ''; ?>" id="fats" name="fats" required value="">
                <?php if (isset($errors['fats'])): ?>
                    <div class="invalid-feedback"><?php echo $errors['fats']; ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Vitamins</label>
                <div id="vitamins-container">
                    <div class="vitamin-entry mb-2">
                        <select class="form-control mb-2 <?php echo isset($errors['vitamin_names']) ? 'is-invalid' : ''; ?>" name="vitamin_names[]" multiple>
                            <option value="A">Vitamin A</option>
                            <option value="B1">Vitamin B1 (Thiamine)</option>
                            <option value="B2">Vitamin B2 (Riboflavin)</option>
                            <option value="B3">Vitamin B3 (Niacin)</option>
                            <option value="B5">Vitamin B5 (Pantothenic Acid)</option>
                            <option value="B6">Vitamin B6</option>
                            <option value="B7">Vitamin B7 (Biotin)</option>
                            <option value="B9">Vitamin B9 (Folate)</option>
                            <option value="B12">Vitamin B12</option>
                            <option value="C">Vitamin C</option>
                            <option value="D">Vitamin D</option>
                            <option value="E">Vitamin E</option>
                            <option value="K">Vitamin K</option>
                        </select>
                    </div>
                </div>
                <?php if (isset($errors['vitamin_names'])): ?>
                    <div class="invalid-feedback d-block"><?php echo $errors['vitamin_names']; ?></div>
                <?php endif; ?>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var vitaminSelect = document.querySelector('select[name="vitamin_names[]"]');
                    $(vitaminSelect).select2({
                        placeholder: 'Select vitamins',
                        allowClear: true,
                        multiple: true
                    });
                });
            </script>
            <div class="mb-3">
                <label for="minerals" class="form-label">Minerals</label>
                <select class="form-control <?php echo isset($errors['minerals']) ? 'is-invalid' : ''; ?>" id="minerals" name="minerals[]" multiple required>
                    <option value="calcium">Calcium</option>
                    <option value="iron">Iron</option>
                    <option value="magnesium">Magnesium</option>
                    <option value="phosphorus">Phosphorus</option>
                    <option value="potassium">Potassium</option>
                    <option value="sodium">Sodium</option>
                    <option value="zinc">Zinc</option>
                    <option value="copper">Copper</option>
                    <option value="manganese">Manganese</option>
                    <option value="selenium">Selenium</option>
                </select>
                <?php if (isset($errors['minerals'])): ?>
                    <div class="invalid-feedback"><?php echo $errors['minerals']; ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="about" class="form-label">About</label>
                <textarea class="form-control <?php echo isset($errors['about']) ? 'is-invalid' : ''; ?>" id="about" name="about" rows="3" maxlength="1000"></textarea>
                <?php if (isset($errors['about'])): ?>
                    <div class="invalid-feedback"><?php echo $errors['about']; ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="product_url" class="form-label">Product URL</label>
                <input type="url" class="form-control <?php echo isset($errors['product_url']) ? 'is-invalid' : ''; ?>" id="product_url" name="product_url" value="">
                <?php if (isset($errors['product_url'])): ?>
                    <div class="invalid-feedback"><?php echo $errors['product_url']; ?></div>
                <?php endif; ?>
            </div>
            <h3>Ingredients</h3>
            <div id="ingredients-container">
                <div class="ingredient-entry mb-3">
                    <select class="form-control mb-2 <?php echo isset($errors['ingredients']) ? 'is-invalid' : ''; ?>" name="ingredients[]" required>
                        <option value="">Select an ingredient</option>
                        <?php
                        mysqli_data_seek($ingredients_result, 0);
                        while ($ingredient = mysqli_fetch_assoc($ingredients_result)) {
                            echo "<option value='{$ingredient['IngredientID']}'>{$ingredient['Name']} - {$ingredient['Description']} (Health Impact: {$ingredient['HealthImpact']})</option>";
                        }
                        ?>
                    </select>
                    <?php if (isset($errors['ingredients'])): ?>
                        <div class="invalid-feedback"><?php echo $errors['ingredients']; ?></div>
                    <?php endif; ?>
                    <input type="number" step="0.01" min="0" class="form-control mb-2 <?php echo isset($errors['ingredient_quantities']) ? 'is-invalid' : ''; ?>" name="ingredient_quantities[]" placeholder="Quantity" required>
                    <?php if (isset($errors['ingredient_quantities'])): ?>
                        <div class="invalid-feedback"><?php echo $errors['ingredient_quantities']; ?></div>
                    <?php endif; ?>
                    <select class="form-control mb-2 <?php echo isset($errors['ingredient_units']) ? 'is-invalid' : ''; ?>" name="ingredient_units[]" required>
                        <option value="">Select a unit</option>
                        <option value="g">Grams (g)</option>
                        <option value="kg">Kilograms (kg)</option>
                        <option value="ml">Milliliters (ml)</option>
                        <option value="l">Liters (l)</option>
                        <option value="tsp">Teaspoons (tsp)</option>
                        <option value="tbsp">Tablespoons (tbsp)</option>
                        <option value="cup">Cups</option>
                        <option value="piece">Pieces</option>
                    </select>
                </div>
            </div>
            <button type="button" class="btn btn-secondary mb-3" id="add-ingredient">Add Another Ingredient</button>
            <h3>Alternatives</h3>
            <div class="mb-3">
                <label for="alternatives" class="form-label">Select Alternatives</label>
                <select class="form-control" id="alternatives" name="alternatives[]" multiple>
                    <?php
                    while ($alternative = mysqli_fetch_assoc($alternatives_result)) {
                        echo "<option value='{$alternative['FoodID']}'>{$alternative['Name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="add_food" class="btn btn-primary">Add Product</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // GSAP Animations
        document.addEventListener('DOMContentLoaded', (event) => {
            gsap.to('.fade-in', { duration: 1, opacity: 1 });
            gsap.to('.slide-in', { duration: 1, y: 0, opacity: 1, stagger: 0.2 });

            // Form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                let isValid = true;
                const requiredFields = form.querySelectorAll('input[required], select[required], textarea[required]');
                
                requiredFields.forEach((field) => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('is-invalid');
                        let feedbackDiv = field.nextElementSibling;
                        if (!feedbackDiv || !feedbackDiv.classList.contains('invalid-feedback')) {
                            feedbackDiv = document.createElement('div');
                            feedbackDiv.className = 'invalid-feedback';
                            field.parentNode.insertBefore(feedbackDiv, field.nextSibling);
                        }
                        feedbackDiv.textContent = 'This field is required.';
                    } else {
                        field.classList.remove('is-invalid');
                        const feedbackDiv = field.nextElementSibling;
                        if (feedbackDiv && feedbackDiv.classList.contains('invalid-feedback')) {
                            feedbackDiv.remove();
                        }
                    }
                });

                // Validate file input
                const fileInput = form.querySelector('input[type="file"]');
                if (fileInput && fileInput.files.length === 0) {
                    isValid = false;
                    fileInput.classList.add('is-invalid');
                    let feedbackDiv = fileInput.nextElementSibling;
                    if (!feedbackDiv || !feedbackDiv.classList.contains('invalid-feedback')) {
                        feedbackDiv = document.createElement('div');
                        feedbackDiv.className = 'invalid-feedback';
                        fileInput.parentNode.insertBefore(feedbackDiv, fileInput.nextSibling);
                    }
                    feedbackDiv.textContent = 'Please select an image file.';
                }

                // Validate numeric inputs
                const numericInputs = form.querySelectorAll('input[type="number"]');
                numericInputs.forEach((input) => {
                    const value = parseFloat(input.value);
                    if (isNaN(value) || value < 0) {
                        isValid = false;
                        input.classList.add('is-invalid');
                        let feedbackDiv = input.nextElementSibling;
                        if (!feedbackDiv || !feedbackDiv.classList.contains('invalid-feedback')) {
                            feedbackDiv = document.createElement('div');
                            feedbackDiv.className = 'invalid-feedback';
                            input.parentNode.insertBefore(feedbackDiv, input.nextSibling);
                        }
                        feedbackDiv.textContent = 'Please enter a valid positive number.';
                    }
                });

                // Validate URL input
                const urlInput = form.querySelector('input[type="url"]');
                if (urlInput && urlInput.value && !isValidURL(urlInput.value)) {
                    isValid = false;
                    urlInput.classList.add('is-invalid');
                    let feedbackDiv = urlInput.nextElementSibling;
                    if (!feedbackDiv || !feedbackDiv.classList.contains('invalid-feedback')) {
                        feedbackDiv = document.createElement('div');
                        feedbackDiv.className = 'invalid-feedback';
                        urlInput.parentNode.insertBefore(feedbackDiv, urlInput.nextSibling);
                    }
                    feedbackDiv.textContent = 'Please enter a valid URL.';
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });
        });

        function isValidURL(string) {
            try {
                new URL(string);
                return true;
            } catch (_) {
                return false;
            }
        }

        // Initialize Select2 for alternatives dropdown
        $(document).ready(function() {
            $('#alternatives').select2({
                placeholder: "Select alternatives",
                allowClear: true
            });
            $('#minerals').select2({
                placeholder: "Select minerals",
                allowClear: true,
                multiple: true
            });
        });

        // Add ingredient functionality
        document.getElementById('add-ingredient').addEventListener('click', function() {
            const container = document.getElementById('ingredients-container');
            const lastEntry = container.querySelector('.ingredient-entry:last-child');
            
            // Check if the previous ingredient fields are filled
            const ingredientSelect = lastEntry.querySelector('select[name="ingredients[]"]');
            const quantityInput = lastEntry.querySelector('input[name="ingredient_quantities[]"]');
            const unitSelect = lastEntry.querySelector('select[name="ingredient_units[]"]');
            
            if (ingredientSelect.value === '' || quantityInput.value === '' || unitSelect.value === '') {
                // Show error message
                const errorMessage = document.createElement('div');
                errorMessage.className = 'alert alert-danger mt-2';
                errorMessage.textContent = 'Please fill in all fields for the current ingredient before adding a new one.';
                lastEntry.appendChild(errorMessage);

                // Remove error message after 3 seconds
                setTimeout(() => {
                    errorMessage.remove();
                }, 3000);

                return;
            }

            const newEntry = lastEntry.cloneNode(true);
            newEntry.querySelectorAll('select, input').forEach(element => {
                if (element.tagName === 'SELECT') {
                    element.selectedIndex = 0;
                } else {
                    element.value = '';
                }
                element.classList.remove('is-invalid');
                const feedbackDiv = element.nextElementSibling;
                if (feedbackDiv && feedbackDiv.classList.contains('invalid-feedback')) {
                    feedbackDiv.remove();
                }
            });
            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger btn-sm remove-ingredient mt-2';
            removeButton.textContent = 'Remove';
            newEntry.appendChild(removeButton);
            container.appendChild(newEntry);
            updateRemoveButtons();
        });

        // Remove ingredient functionality
        document.getElementById('ingredients-container').addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-ingredient')) {
                e.target.closest('.ingredient-entry').remove();
                updateRemoveButtons();
            }
        });

        // Ensure at least one ingredient entry remains and no remove button on first record
        function updateRemoveButtons() {
            const ingredientEntries = document.querySelectorAll('.ingredient-entry');
            ingredientEntries.forEach((entry, index) => {
                let removeButton = entry.querySelector('.remove-ingredient');
                if (index === 0) {
                    // Remove the button from the first entry if it exists
                    if (removeButton) {
                        removeButton.remove();
                    }
                } else {
                    if (!removeButton) {
                        removeButton = document.createElement('button');
                        removeButton.type = 'button';
                        removeButton.className = 'btn btn-danger btn-sm remove-ingredient mt-2';
                        removeButton.textContent = 'Remove';
                        entry.appendChild(removeButton);
                    }
                    removeButton.style.display = 'inline-block';
                }
            });
        }

        // Call updateRemoveButtons initially
        updateRemoveButtons();

      

        // Add multiple vitamins functionality
        document.getElementById('add-multiple-vitamins').addEventListener('click', function() {
            const container = document.getElementById('vitamins-container');
            const vitamins = [
                {name: 'A', unit: 'IU'},
                {name: 'B1', unit: 'mg'},
                {name: 'B2', unit: 'mg'},
                {name: 'B3', unit: 'mg'},
                {name: 'B5', unit: 'mg'},
                {name: 'B6', unit: 'mg'},
                {name: 'B7', unit: 'mcg'},
                {name: 'B9', unit: 'mcg'},
                {name: 'B12', unit: 'mcg'},
                {name: 'C', unit: 'mg'},
                {name: 'D', unit: 'IU'},
                {name: 'E', unit: 'IU'},
                {name: 'K', unit: 'mcg'}
            ];

            vitamins.forEach(vitamin => {
                const newEntry = document.createElement('div');
                newEntry.className = 'vitamin-entry mb-3';
                newEntry.innerHTML = `
                    <select class="form-control mb-2" name="vitamins[]" required>
                        <option value="${vitamin.name}">Vitamin ${vitamin.name}</option>
                    </select>
                    <input type="number" step="0.01" min="0" class="form-control mb-2" name="vitamin_amounts[]" placeholder="Amount" required>
                    <select class="form-control mb-2" name="vitamin_units[]" required>
                        <option value="${vitamin.unit}">${vitamin.unit}</option>
                    </select>
                    <button type="button" class="btn btn-danger btn-sm remove-vitamin">Remove</button>
                `;
                container.appendChild(newEntry);
            });
        });
    </script>
</body>
</html>

<?php
mysqli_close($conn);
?>