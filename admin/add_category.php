<?php
// add_category.php
include "sider.php";
// Include necessary files and initialize database connection
require_once "connection.php";

$message = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $description = trim($_POST["description"]);
    $image_path = "";

    // Validate name
    if (empty($name)) {
        $errors['name'] = "Category name is required.";
    } elseif (strlen($name) > 50) {
        $errors['name'] = "Category name must be 50 characters or less.";
    } elseif (!ctype_alpha(str_replace(' ', '', $name))) {
        $errors['name'] = "Category name must contain only letters and spaces.";
    }

    // Validate description
    if (empty($description)) {
        $errors['description'] = "Description is required.";
    } elseif (strlen($description) > 255) {
        $errors['description'] = "Description must be 255 characters or less.";
    } elseif (!preg_match('/^[a-zA-Z0-9\s.,!?-]+$/', $description)) {
        $errors['description'] = "Description can only contain letters, numbers, spaces, and basic punctuation.";
    }

    // Handle file upload
    if (!isset($_FILES["image"]) || $_FILES["image"]["error"] != 0) {
        $errors['image'] = "Image is required.";
    } else {
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
                $image_path = "../asset/" . basename($_FILES["image"]["name"]);
            } else {
                $errors['image'] = "Failed to upload image.";
            }
        }
    }

    // If no errors, proceed with database insertion
    if (empty($errors)) {
        $sql = "INSERT INTO Categories (Name, Description, image_path) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $description, $image_path);

        if ($stmt->execute()) {
            $message = "New category added successfully";
        } else {
            $errors['database'] = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #000000;
            line-height: 1.6;
        }
        .main-content {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .card {
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #f8f8f8;
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        .card-body {
            padding: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .error-message {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <h1>Add New Category</h1>
            </div>
            <div class="card-body">
                <?php if ($message): ?>
                    <div class="alert alert-success" role="alert"><?php echo $message; ?></div>
                <?php endif; ?>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control <?php echo isset($errors['name']) ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>"  maxlength="50" pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed">
                        <?php if (isset($errors['name'])): ?>
                            <div class="error-message"><?php echo $errors['name']; ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control <?php echo isset($errors['description']) ? 'is-invalid' : ''; ?>" id="description" name="description" rows="3" maxlength="255"  pattern="^[a-zA-Z0-9\s.,!?-]+$" title="Only letters, numbers, spaces, and basic punctuation are allowed"><?php echo htmlspecialchars($description ?? ''); ?></textarea>
                        <?php if (isset($errors['description'])): ?>
                            <div class="error-message"><?php echo $errors['description']; ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control <?php echo isset($errors['image']) ? 'is-invalid' : ''; ?>" id="image" name="image"  accept=".jpg,.jpeg,.png,.gif">
                        <?php if (isset($errors['image'])): ?>
                            <div class="error-message"><?php echo $errors['image']; ?></div>
                        <?php endif; ?>
                        <small class="form-text text-muted">Max file size: 5MB. Allowed types: JPG, PNG, GIF.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>