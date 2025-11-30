<?php
// edit_category.php
include "sider.php";
require_once "connection.php";

$message = "";
$errors = [];
$category = null;

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $category_id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM Categories WHERE CategoryID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();
    $stmt->close();

    if (!$category) {
        $errors['category'] = "Category not found.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $name = trim($_POST["name"]);
    $description = trim($_POST["description"]);
    $current_image = $_POST["current_image"];

    // Validate name
    if (empty($name)) {
        $errors['name'] = "Category name is required.";
    } elseif (strlen($name) > 50) {
        $errors['name'] = "Category name must be 50 characters or less.";
    } elseif (!ctype_alpha(str_replace(' ', '', $name))) {
        $errors['name'] = "Category name must contain only letters and spaces.";
    }

    // Validate description (optional, but if provided, limit length)
    if (!empty($description) && strlen($description) > 255) {
        $errors['description'] = "Description must be 255 characters or less.";
    }

    // Handle file upload if a new image is provided
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB

        if (!in_array($_FILES["image"]["type"], $allowed_types)) {
            $errors['image'] = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
        } elseif ($_FILES["image"]["size"] > $max_size) {
            $errors['image'] = "File size exceeds 5MB limit.";
        } else {
            $target_dir = "../client/asset/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = "../client/asset/" . basename($_FILES["image"]["name"]);
            } else {
                $errors['image'] = "Failed to upload image.";
            }
        }
    } else {
        $image_path = $current_image;
    }

    // If no errors, proceed with database update
    if (empty($errors)) {
        $sql = "UPDATE Categories SET Name = ?, Description = ?, image_path = ? WHERE CategoryID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $description, $image_path, $category_id);

        if ($stmt->execute()) {
            $message = "Category updated successfully";
        } else {
            $errors['database'] = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        .fade-in {
            animation: fadeIn 0.5s;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .btn-primary {
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .error-message {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 data-aos="fade-down">Edit Category</h1>
        <?php if ($message): ?>
            <div class="alert alert-success fade-in" role="alert"><?php echo $message; ?></div>
        <?php endif; ?>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger fade-in" role="alert">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <?php if ($category): ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" data-aos="fade-up">
                <input type="hidden" name="category_id" value="<?php echo $category['CategoryID']; ?>">
                <input type="hidden" name="current_image" value="<?php echo $category['image_path']; ?>">
                <div class="mb-3" data-aos="fade-right" data-aos-delay="100">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control <?php echo isset($errors['name']) ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?php echo htmlspecialchars($category['Name']); ?>" required maxlength="50" pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed">
                    <?php if (isset($errors['name'])): ?>
                        <div class="error-message"><?php echo $errors['name']; ?></div>
                    <?php endif; ?>
                </div>
                <div class="mb-3" data-aos="fade-right" data-aos-delay="200">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control <?php echo isset($errors['description']) ? 'is-invalid' : ''; ?>" id="description" name="description" rows="3" maxlength="255"><?php echo htmlspecialchars($category['Description']); ?></textarea>
                    <?php if (isset($errors['description'])): ?>
                        <div class="error-message"><?php echo $errors['description']; ?></div>
                    <?php endif; ?>
                </div>
                <div class="mb-3" data-aos="fade-right" data-aos-delay="300">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control <?php echo isset($errors['image']) ? 'is-invalid' : ''; ?>" id="image" name="image" accept=".jpg,.jpeg,.png,.gif">
                    <?php if (isset($errors['image'])): ?>
                        <div class="error-message"><?php echo $errors['image']; ?></div>
                    <?php endif; ?>
                    <small class="form-text text-muted">Max file size: 5MB. Allowed types: JPG, PNG, GIF. Leave empty to keep the current image.</small>
                </div>
                <div class="mb-3">
                    <label>Current Image:</label>
                    <?php if (!empty($category['image_path'])): ?>
                        <img src="../client/asset/<?php echo $category['image_path']; ?>" alt="Current Category Image" style="max-width: 200px; max-height: 200px;">
                    <?php else: ?>
                        <p>No image currently set.</p>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary" data-aos="zoom-in" data-aos-delay="400">Update Category</button>
            </form>
        <?php else: ?>
            <p>Category not found.</p>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
</body>
</html>

<?php
mysqli_close($conn);
?>
