<div class="preloader">

</div>
<script>
    let loader = document.querySelector(".preloader");
    function closepreloader() {
        loader.style.opacity = 0;
        setTimeout(() => {
            loader.style.display = "none";
        }, 1000);
    }

    window.addEventListener("load", function () {
        const gif = new Image();
        gif.src = "../143.gif";

        gif.onload = function () {
            setTimeout(closepreloader, 1000);
        };
    });
</script>
<style>
    .preloader {
        height: 100vh;
        width: 100vw;
        background: #000005 url(../143.gif) no-repeat center center;
        position: fixed;
        z-index: 1000;
        opacity: 1;
    }
</style>
<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db");
if (!$conn) {
    die("<script>alert('Connection failed: " . mysqli_connect_error() . "');</script>");
}

if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/MiniProject(Aman)/login/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['updateprofile'])) {
    if (isset($_POST['username']) && !empty(trim($_POST['username']))) {
        $new_username = trim($_POST['username']);

        // Check if the username already exists
        $check_stmt = $conn->prepare("SELECT UserID FROM users WHERE Username = ? AND UserID != ?");
        $check_stmt->bind_param("si", $new_username, $user_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            echo "<script>alert('Username already exists. Please choose a different username.');</script>";
        } else {
            // Update the username
            $update_stmt = $conn->prepare("UPDATE users SET Username = ? WHERE UserID = ?");
            $update_stmt->bind_param("si", $new_username, $user_id);
            
            if ($update_stmt->execute()) {
                $user['Username'] = $new_username;
                echo '
                <div id="popup" style="display: none;">
                    <div style="background: #B2EBF2; font-family: GilroyLight, Arial, sans-serif; font-weight: 800; color: #006064; padding: 25px; border-radius: 12px; box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3); font-size: 20px; position: fixed; top: 20px; right: 20px; z-index: 1000; display: flex; align-items: center; min-width: 320px;">
                        <span style="margin-right: 15px; font-size: 28px; color: #2E7D32;">&#10004;</span>
                        Profile updated successfully!
                    </div>
                </div>
                <script>
                    document.getElementById("popup").style.display = "block";
                    setTimeout(function() {
                        document.getElementById("popup").style.display = "none";
                    }, 3000);
                </script>';
            } else {
                echo "<script>alert('Error updating username.');</script>";
            }
            $update_stmt->close();
        }
        $check_stmt->close();
    }

    // Handle profile picture update
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["profile_picture"]["name"];
        $filetype = $_FILES["profile_picture"]["type"];
        $filesize = $_FILES["profile_picture"]["size"];
    
        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
    
        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if ($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
    
        // Verify MIME type of the file
        if (in_array($filetype, $allowed)) {
            $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/MiniProject(Aman)/login/uploads/profile_pictures/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . $user_id . "_" . basename($_FILES["profile_picture"]["name"]);
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                $profile_picture_path = "uploads/profile_pictures/" . $user_id . "_" . basename($_FILES["profile_picture"]["name"]);
                
                // Update the profile picture path in the database
                $update_stmt = $conn->prepare("UPDATE users SET ProfilePicture = ? WHERE UserID = ?");
                $update_stmt->bind_param("si", $profile_picture_path, $user_id);
                
                if ($update_stmt->execute()) {
                    // echo "<script>alert('Profile picture updated successfully.');</script>";
                    // Update the user array with the new profile picture path
                    $user['ProfilePicture'] = $profile_picture_path;
                } else {
                    echo "<script>alert('Error updating profile picture in database.');</script>";
                }
                $update_stmt->close();
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file. Error: " . error_get_last()['message'] . "');</script>";
            }
        } else {
            echo "<script>alert('Error: There was a problem uploading your file. Please try again.');</script>";
        }
    }
}

// Handle profile picture update logic here...

$stmt = $conn->prepare("SELECT * FROM users WHERE UserID = ?");
if ($stmt === false) {
    die("<script>alert('Error preparing statement: " . $conn->error . "');</script>");
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$stmt = $conn->prepare("SELECT COUNT(*) as liked_count FROM user_likes WHERE user_id = ?");
if ($stmt === false) {
    die("<script>alert('Error preparing statement: " . $conn->error . "');</script>");
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$likeResult = $stmt->get_result();
$likedProducts = $likeResult->fetch_assoc();
$stmt->close();

$stmt = $conn->prepare("SELECT f.FoodID, f.Name, f.Description, f.Price, f.Image, ul.date 
                         FROM user_likes ul 
                         JOIN foods f ON ul.food_id = f.FoodID 
                         WHERE ul.user_id = ? 
                         ORDER BY ul.date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$favoritesResult = $stmt->get_result();
$favorites = $favoritesResult->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$stmt = $conn->prepare("SELECT * FROM users WHERE UserID = ?");
if ($stmt === false) {
    die("<script>alert('Error preparing statement: " . $conn->error . "');</script>");
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$error_message = "";

if (isset($_POST['current_password'])) {
    $current_password = $_POST['current_password'];

    if (password_verify($current_password, $user['Password'])) {
        header("Location: http://localhost/MiniProject(Aman)/login/forgot_password.php");
        exit();
    } else {
        $error_message = "Password is incorrect.";
    }
}
if (isset($_POST['changepassword'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $user_id = $_SESSION['user_id'];

        $query = "UPDATE users SET password = '$hashed_password' WHERE UserID = $user_id";

        if (mysqli_query($conn, $query)) {
            echo '
    <div id="popup" style="display: none;">
        <div style="background: #B2EBF2; font-family: GilroyLight, Arial, sans-serif; font-weight: 800; color: #006064; padding: 25px; border-radius: 12px; box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3); font-size: 20px; position: fixed; top: 20px; right: 20px; z-index: 1000; display: flex; align-items: center; min-width: 320px;">
            <span style="margin-right: 15px; font-size: 28px; color: #2E7D32;">&#10004;</span>
            Password updated successfully!
        </div>
    </div>
    <script>
        document.getElementById("popup").style.display = "block";
        setTimeout(function() {
            document.getElementById("popup").style.display = "none";
        }, 3000);
    </script>';
        } else {
            echo '<div style="color: red;">Error updating password: ' . mysqli_error($conn) . '</div>';
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
    <title>User Profile</title>
    <link rel="stylesheet" href="style.css">
    <link href="../cdnFiles/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="../cdnFiles/locomotive-scroll.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            font-family: Gilroy !important;
        }

        .main-content::-webkit-scrollbar {
            display: none;
        }

        .favorite-item h3,
        .favorite-item p {
            font-family: GilroyLight !important;
            font-weight: 900;
        }

        .main {
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .container1 {
            width: 80%;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .profile {
            display: flex;
        }

        .sidebar {
            width: 200px;
            background: #e7e7e7;
            padding: 15px;
            box-shadow: 1px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar a {
            display: block;
            padding: 10px;
            color: #333;
            text-decoration: none;
            margin-bottom: 5px;
            border-radius: 5px;
            font-family: Gilroy !important;
        }

        .sidebar a:hover {
            background: #d4d4d4;
        }

        .main-content {
            padding: 20px;
            flex-grow: 1;
        }

        .user-info {
            margin-bottom: 20px;
        }

        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        #favoritesContent {

            margin-top: 20px;
        }

        #favoritesList {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .favorite-item {
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            width: calc(33.333% - 20px);
            /* Three items per row */
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .favorite-item:hover {
            transform: scale(1.02);
        }

        .favorite-item img {
            width: 100%;
            border-radius: 5px;
            height: 100px;
            object-fit: cover;
        }

        .favorite-item h3 {
            font-size: 1.2em;
            margin: 10px 0;
            font-family: Gilroy !important;
        }

        .remove-favorite {
            background: #ff4757;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            margin-top: 10px;
        }

        .remove-favorite:hover {
            background: #ff6b81;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 100px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            /* Could be more or less, depending on screen size */
            border-radius: 8px;
            text-align: center;
        }

        .modal-button {
            background-color: #ff4757;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            margin: 5px;
            font-family: Gilroy !important;
        }

        .modal-button:hover {
            background-color: #ff6b81;
        }

        #editProfileForm {
            display: none;
        }

        /* General Profile Section Styles */
        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        #editProfileForm {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        #editProfileForm h2 {
            font-family: Gilroy !important;
            font-weight: 900;
            margin-bottom: 20px;
        }

        #editProfileForm .user-info {
            font-family: Gilroy !important;
            font-weight: 300;
        }

        #editProfileForm label {
            font-size: 1.1em;
            display: block;
            margin-bottom: 10px;
        }

        #editProfileForm input[type="text"],
        #editProfileForm input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        #editProfileForm button {
            padding: 10px 20px;
            background-color: #1e90ff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s;
        }

        #editProfileForm button:hover {
            background-color: #3772ff;
        }

        #editProfileForm img {
            margin-top: 10px;
            border-radius: 50%;
        }

        /* Change Password Form Styling */
        #changePasswordForm {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            width: 100%;
            max-width: 500px;
        }

        #changePasswordForm h2 {
            font-family: Gilroy !important;
            font-weight: 900;
            margin-bottom: 20px;
        }

        #changePasswordForm label {
            font-size: 1.1em;
            display: block;
            margin-bottom: 10px;
        }

        #changePasswordForm input {
            width: 100%;
            padding: 10px;
            /* border: 1px solid #ddd; */
            border-radius: 8px;
            /* margin-bottom: 20px; */
        }

        #changePasswordForm button {
            padding: 10px 20px;
            background-color: #1e90ff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s;
        }

        #changePasswordForm button:hover {
            background-color: #3772ff;
        }

        /* Ensure consistency in modal buttons */
        #changePasswordForm .modal-button {
            background-color: #ff4757;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            margin: 5px;
            font-family: Gilroy !important;
        }

        #changePasswordForm .modal-button:hover {
            background-color: #ff6b81;
        }

        /* Style for the password input and eye button container */
        .password-wrapper {
            position: relative;
            width: 100%;
        }

        .password-wrapper input[type="password"],
        .password-wrapper input[type="text"] {
            width: calc(100% - 40px);
            /* Adjust input width to leave space for the eye icon */
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        /* Style for the eye button */
        .password-wrapper .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #333;
        }

        .changePasswordcontainer,
        .changeCurrentPasswordcontainer {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            /* Add border to the container */
            padding: 5px;
            /* Optional: Add some padding for better appearance */
            border-radius: 5px;
            /* Optional: Rounded corners */
            background-color: rgb(255, 255, 255);
            margin: 0;
            padding: 0;
        }

        .changePasswordcontainer input,
        .changeCurrentPasswordcontainer input {
            border: rgb(255, 255, 255);
            /* Remove border from the input */
            outline: rgb(255, 255, 255);
            /* Remove outline on focus */
            flex: 1;
            /* Make the input take available space */
            padding: 5px;
            font-size: 20px;
            /* Add some padding for the input */
        }

        .changePasswordcontainer i,
        .changeCurrentPasswordcontainer i {
            cursor: pointer;
            /* Change cursor to pointer for eye icon */
            margin-right: 5px;
            font-size: 20px;
            /* Optional: Space between input and icon */
        }
    </style>

</head>

<body>
    <?php include "./header.php"; ?>
    <div class="main">
        <div class="container1">
            <div class="profile">
                <div class="sidebar">
                    <a href="#" id="viewProfile">My Profile</a>
                    <a href="#" id="editProfile">Edit Profile</a>
                    <a href="#" id="changePassword">Change Password </a>
                    <a href="#" id="favorites">Favourites</a>
                    <!-- Edit Profile Button added here -->
                </div>
                <div class="main-content" id="profileContent">
                    <h2 id="profileHeading">My Profile</h2>
                    <div class="user-info" id="viewProfileContent">
                        <p><strong>Name:</strong> <span
                                id="userName"><?php echo htmlspecialchars($user['Username']); ?></span></p>
                        <p><strong>Email:</strong> <span
                                id="userEmail"><?php echo htmlspecialchars($user['Email']); ?></span></p>
                        <img src="<?php echo empty($user['ProfilePicture']) ? 'http://localhost/MiniProject(Aman)/Login/uploads/profile_pictures/default-profile.jpg' : 'http://localhost/MiniProject(Aman)/Login/' . htmlspecialchars($user['ProfilePicture']); ?>"
                            alt="Profile Picture" class="profile-image" id="profileImage">

                        <p><strong>Liked Products:</strong> <span
                                id="likedCount"><?php echo htmlspecialchars($likedProducts['liked_count']); ?></span>
                        </p>
                    </div>
                    <!-- Edit Profile Form -->
                    <div id="editProfileForm">
                        <!-- <h2>Edit Profile</h2> -->
                        <form action="" method="POST" enctype="multipart/form-data" id="updateProfileForm">
                            <div class="user-info">
                                <label for="username">Username:</label>
                                <input type="text" name="username" id="username"
                                    value="<?php echo htmlspecialchars($user['Username']); ?>"><br>
                                <p id="usernameError" style="color: red; display: none;"></p>
                                <label for="profile_picture">Profile Picture:</label>
                                <input type="file" name="profile_picture" id="profile_picture"><br>
                                <img src="<?php echo empty($user['ProfilePicture']) ? 'http://localhost/MiniProject(Aman)/login/uploads/profile_pictures/default-profile.jpg' : 'http://localhost/MiniProject(Aman)/Login/' . htmlspecialchars($user['ProfilePicture']); ?>"
                                    alt="Profile Picture" class="profile-image" id="currentProfileImage"><br>
                                <button name="updateprofile" type="submit" id="updateProfileButton">Update
                                    Profile</button>
                            </div>
                        </form>
                    </div>


                    <div id="favoritesContent" style="display: none;">
                        <div id="favoritesList">
                            <?php if (empty($favorites)): ?>
                                <p>No favorites added yet.</p>
                            <?php else: ?>
                                <?php foreach ($favorites as $item): ?>
                                    <div class="favorite-item">
                                        <img src="http://localhost/MiniProject(Aman)/client/asset/products/<?php echo htmlspecialchars($item['Image']); ?>"
                                            alt="<?php echo htmlspecialchars($item['Name']); ?>">
                                        <h3><?php echo htmlspecialchars($item['Name']); ?></h3>
                                        <p><?php echo htmlspecialchars($item['Description']); ?></p>
                                        <p>Price: $<?php echo htmlspecialchars($item['Price']); ?></p>
                                        <button class="remove-favorite" data-id="<?php echo $item['FoodID']; ?>">Remove from
                                            Favorites</button>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div id="changePasswordForm" style="display: none;">
                        <form id="changePasswordFormElement">
                            <div class="user-info">
                                <label for="current_password">Enter Current Password:</label>
                                <div class="changeCurrentPasswordcontainer">
                                    <input type="password" name="current_password" id="current_password" required>
                                    <i class="ri-eye-line toggle-password" id="togglePassword"></i>
                                </div>
                                <br>
                                <!-- Error message placeholder -->
                                <p id="errorMessage" style="color: red; display: none;"></p>

                                <button type="submit" style="margin-right: 10px;">Submit</button>
                                <a href="http://localhost/MiniProject(Aman)/Login/forgot_password.php"
                                    style="text-decoration: none; background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; display: inline-block;">
                                    Forgot Password
                                </a>
                            </div>
                        </form>
                        </form>
                        <div class="user-info" id="newPasswordFields" style="display: none;">
                            <form action="" method="POST" id="passwordForm"> <!-- Form starts here -->
                                <label for="new_password">New Password:</label>
                                <div class="changePasswordcontainer">
                                    <input type="password" id="new_password" name="new_password" required>
                                    <i class="ri-eye-line toggle-password" id="togglePasswordNew"></i>
                                </div>
                                <br>
                                <label for="confirm_password">Confirm Password:</label>
                                <div class="changePasswordcontainer">
                                    <input type="password" id="confirm_password" name="confirm_password" required>
                                    <i class="ri-eye-line toggle-password" id="togglePasswordConfirm"></i>
                                </div>
                                <br>
                                <p id="error-message" style="color: red; display: none;">Both passwords do not match.
                                </p>
                                <button id="changepassword" name="changepassword" type="submit">Submit</button>
                            </form> <!-- Form ends here -->
                        </div>


                    </div>
                    <!-- Modal for confirmation -->
                    <div id="confirmationModal" class="modal">
                        <div class="modal-content">
                            <h3>Are you sure you want to remove this item from favorites?</h3>
                            <button id="confirmRemove" class="modal-button">OK</button>
                            <button id="cancelRemove" class="modal-button">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../cdnFiles/gsap.min.js"></script>
    <script src="../cdnFiles/ScrollTrigger.min.js"></script>
    <script>

        document.getElementById("viewProfile").addEventListener('click', function () {
            document.getElementById('viewProfileContent').style.display = 'block';
            document.getElementById('favoritesContent').style.display = 'none';
            document.getElementById('profileHeading').innerText = "My Profile";
        });

        document.getElementById('favorites').addEventListener('click', function () {
            document.getElementById('viewProfileContent').style.display = 'none';
            document.getElementById('favoritesContent').style.display = 'block';
            document.getElementById('profileHeading').innerText = "My Favorites";
        });

        let foodIdToRemove;
        document.querySelectorAll('.remove-favorite').forEach(button => {
            button.addEventListener('click', function () {
                foodIdToRemove = this.getAttribute('data-id');
                document.getElementById('confirmationModal').style.display = 'block';
            });
        });

        document.getElementById('confirmRemove').addEventListener('click', function () {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "remove_favorite.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                const response = JSON.parse(this.responseText);
                if (response.status === 'success') {
                    // Show pop-up for success
                    const popup = document.createElement('div');
                    popup.innerHTML = `
                <div id="popup" style="background: #B2EBF2; font-family: GilroyLight, Arial, sans-serif; font-weight: 800; color: #006064; padding: 25px; border-radius: 12px; box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3); font-size: 20px; position: fixed; top: 20px; right: 20px; z-index: 1000; display: flex; align-items: center; min-width: 320px;">
                    <span style="margin-right: 15px; font-size: 28px; color: #2E7D32;">&#10004;</span> <!-- Success icon (checkmark) in dark green -->
                    Product removed successfully!

                </div>
            `;
                    document.body.appendChild(popup);

                    // Display the popup for 3 seconds
                    setTimeout(function () {
                        popup.style.display = "none";
                        location.reload(); // Reload the page after popup disappears
                    }, 1200);

                } else {
                    alert(response.message);
                }
            };
            xhr.send("food_id=" + foodIdToRemove);
        });


        document.getElementById('cancelRemove').addEventListener('click', function () {
            document.getElementById('confirmationModal').style.display = 'none';
        });

        window.onclick = function (event) {
            const modal = document.getElementById('confirmationModal');
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };
        document.getElementById("viewProfile").addEventListener('click', function () {
            document.getElementById('viewProfileContent').style.display = 'block';
            document.getElementById('editProfileForm').style.display = 'none';
            document.getElementById('profileHeading').innerText = "My Profile";
        });

        document.getElementById('editProfile').addEventListener('click', function () {
            document.getElementById('viewProfileContent').style.display = 'none';
            document.getElementById('editProfileForm').style.display = 'block';
            document.getElementById('profileHeading').innerText = "Edit Profile";
        });
        document.getElementById("viewProfile").addEventListener('click', function () {
            document.getElementById('viewProfileContent').style.display = 'block';
            document.getElementById('favoritesContent').style.display = 'none';
            document.getElementById('editProfileForm').style.display = 'none';
            document.getElementById('profileHeading').innerText = "My Profile";
        });

        document.getElementById('favorites').addEventListener('click', function () {
            document.getElementById('viewProfileContent').style.display = 'none';
            document.getElementById('favoritesContent').style.display = 'block';
            document.getElementById('editProfileForm').style.display = 'none';
            document.getElementById('profileHeading').innerText = "My Favorites";
        });

        document.getElementById("editProfile").addEventListener('click', function () {
            document.getElementById('viewProfileContent').style.display = 'none';
            document.getElementById('favoritesContent').style.display = 'none';
            document.getElementById('editProfileForm').style.display = 'block';
            document.getElementById('profileHeading').innerText = "Edit Profile";
        });

        document.getElementById('changePassword').addEventListener('click', function () {
            document.getElementById('viewProfileContent').style.display = 'none';
            document.getElementById('editProfileForm').style.display = 'none';
            document.getElementById('favoritesContent').style.display = 'none';
            document.getElementById('changePasswordForm').style.display = 'block';
            document.getElementById('profileHeading').innerText = "Change Password";
        });

        document.getElementById('viewProfile').addEventListener('click', function () {
            document.getElementById('viewProfileContent').style.display = 'block';
            document.getElementById('editProfileForm').style.display = 'none';
            document.getElementById('favoritesContent').style.display = 'none';
            document.getElementById('changePasswordForm').style.display = 'none';
            document.getElementById('profileHeading').innerText = "My Profile";
        });

        document.getElementById('favorites').addEventListener('click', function () {
            document.getElementById('viewProfileContent').style.display = 'none';
            document.getElementById('editProfileForm').style.display = 'none';
            document.getElementById('favoritesContent').style.display = 'block';
            document.getElementById('changePasswordForm').style.display = 'none';
            document.getElementById('profileHeading').innerText = "My Favorites";
        });

        document.getElementById('editProfile').addEventListener('click', function () {
            document.getElementById('viewProfileContent').style.display = 'none';
            document.getElementById('editProfileForm').style.display = 'block';
            document.getElementById('favoritesContent').style.display = 'none';
            document.getElementById('changePasswordForm').style.display = 'none';
            document.getElementById('profileHeading').innerText = "Edit Profile";
        });

        document.getElementById('changePassword').addEventListener('click', function () {
            document.getElementById('viewProfileContent').style.display = 'none';
            document.getElementById('editProfileForm').style.display = 'none';
            document.getElementById('favoritesContent').style.display = 'none';
            document.getElementById('changePasswordForm').style.display = 'block';
            document.getElementById('profileHeading').innerText = "Change Password";
        });
        document.getElementById('changePassword').addEventListener('click', function () {
            document.getElementById('changePasswordForm').style.display = 'block';
        });

        document.getElementById('changePasswordFormElement').addEventListener('submit', function (event) {
            event.preventDefault();

            const currentPassword = document.getElementById('current_password').value;
            const errorMessageElement = document.getElementById('errorMessage');
            const newPasswordFields = document.getElementById('newPasswordFields');

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "check_password.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);

                    if (response.success) {
                        newPasswordFields.style.display = 'block';

                        document.querySelector('.changeCurrentPasswordcontainer').style.display = 'none';
                        errorMessageElement.style.display = 'none';

                    } else {
                        errorMessageElement.textContent = "Password is incorrect.";
                        errorMessageElement.style.display = 'block';
                        document.getElementById('current_password').value = '';
                        newPasswordFields.style.display = 'none';
                    }
                } else {
                    errorMessageElement.textContent = "An error occurred. Please try again later.";
                    errorMessageElement.style.display = 'block';
                    newPasswordFields.style.display = 'none';
                }
            };

            xhr.send("current_password=" + encodeURIComponent(currentPassword));
        });

        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('current_password');
            const passwordType = passwordInput.getAttribute('type');
            if (passwordType === 'password') {
                passwordInput.setAttribute('type', 'text');
                this.classList.replace('ri-eye-line', 'ri-eye-off-line');
            } else {
                passwordInput.setAttribute('type', 'password');
                this.classList.replace('ri-eye-off-line', 'ri-eye-line');
            }
        });
        document.getElementById('togglePasswordNew').addEventListener('click', function () {
            const newPasswordInput = document.getElementById('new_password');
            const confirmPasswordInput = document.getElementById('confirm_password');

            const isPasswordType = newPasswordInput.getAttribute('type') === 'password';

            newPasswordInput.setAttribute('type', isPasswordType ? 'text' : 'password');
            confirmPasswordInput.setAttribute('type', isPasswordType ? 'text' : 'password');

            if (isPasswordType) {
                this.classList.replace('ri-eye-line', 'ri-eye-off-line');
                document.getElementById('togglePasswordConfirm').classList.replace('ri-eye-line', 'ri-eye-off-line');
            } else {
                this.classList.replace('ri-eye-off-line', 'ri-eye-line');
                document.getElementById('togglePasswordConfirm').classList.replace('ri-eye-off-line', 'ri-eye-line');
            }
        });
        document.getElementById('togglePasswordConfirm').addEventListener('click', function () {
            const newPasswordInput = document.getElementById('new_password');
            const confirmPasswordInput = document.getElementById('confirm_password');

            const isPasswordType = newPasswordInput.getAttribute('type') === 'password';

            newPasswordInput.setAttribute('type', isPasswordType ? 'text' : 'password');
            confirmPasswordInput.setAttribute('type', isPasswordType ? 'text' : 'password');

            if (isPasswordType) {
                this.classList.replace('ri-eye-line', 'ri-eye-off-line');
                document.getElementById('togglePasswordNew').classList.replace('ri-eye-line', 'ri-eye-off-line');
            } else {
                this.classList.replace('ri-eye-off-line', 'ri-eye-line');
                document.getElementById('togglePasswordNew').classList.replace('ri-eye-off-line', 'ri-eye-line');
            }
        });
        const newPasswordInput = document.getElementById('new_password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const errorMessage = document.getElementById('error-message');
        const submitButton = document.getElementById('changepassword');

        confirmPasswordInput.addEventListener('keyup', function () {
            const newPassword = newPasswordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            errorMessage.style.display = 'none';

            if (newPassword.length < 8) {
                errorMessage.textContent = 'Password must be at least 8 characters long.';
                errorMessage.style.display = 'block';
                submitButton.disabled = true;
            } else if (confirmPassword !== newPassword) {
                errorMessage.textContent = 'Both passwords do not match.';
                errorMessage.style.display = 'block';
                submitButton.disabled = true;
            } else {
                errorMessage.style.display = 'none';
                submitButton.disabled = false;
            }
        });
        newPasswordInput.addEventListener('keyup', function () {
            const newPassword = newPasswordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            errorMessage.style.display = 'none';

            if (newPassword.length < 8) {
                errorMessage.textContent = 'Password must be at least 8 characters long.';
                errorMessage.style.display = 'block';
                submitButton.disabled = true;
            } else if (confirmPassword !== newPassword) {
                errorMessage.textContent = 'Both passwords do not match.';
                errorMessage.style.display = 'block';
                submitButton.disabled = true;
            } else {
                errorMessage.style.display = 'none';
                submitButton.disabled = false;
            }
        });






    </script>
</body>

</html>


