<?php
require_once 'connection.php';
ob_start(); // Start output buffering
include "sider.php"; // Including the sidebar
$sidebar_content = ob_get_clean(); // Get buffered content

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Validation
    if (empty($username)) {
        $errors[] = "Username is required";
    } else {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT * FROM admin_users WHERE Username = ?");
        if (!$stmt) {
            $errors[] = "Database error: " . $conn->error;
            error_log("Prepare statement failed: " . $conn->error); // Log the error
        } else {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $errors[] = "Username already exists. Please choose a different username.";
            }
            $stmt->close();
        }
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    if (empty($role)) {
        $errors[] = "Role is required";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO admin_users (Username, Email, Password, Role) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            $errors[] = "Database error: " . $conn->error;
            error_log("Prepare statement failed: " . $conn->error); // Log the error
        } else {
            $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

            if ($stmt->execute()) {
                $success = "Admin registered successfully!";
            } else {
                $errors[] = "Database error: " . $stmt->error;
                error_log("Execute statement failed: " . $stmt->error); // Log the error
            }
            $stmt->close();
        }
    }
}

// Return JSON response for AJAX requests
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    if (!empty($success)) {
        echo json_encode(['success' => true, 'message' => $success]);
    } elseif (!empty($errors)) {
        echo json_encode(['success' => false, 'message' => implode('<br>', $errors)]);
    } else {
        echo json_encode(['success' => false, 'message' => 'An unknown error occurred.']);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration - YumYumRank</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&amp;display=swap');
        .bg-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(30deg, #f6d365 12%, transparent 12.5%, transparent 87%, #f6d365 87.5%, #f6d365),
                linear-gradient(150deg, #f6d365 12%, transparent 12.5%, transparent 87%, #f6d365 87.5%, #f6d365),
                linear-gradient(30deg, #f6d365 12%, transparent 12.5%, transparent 87%, #f6d365 87.5%, #f6d365),
                linear-gradient(150deg, #f6d365 12%, transparent 12.5%, transparent 87%, #f6d365 87.5%, #f6d365),
                linear-gradient(60deg, #fda085 25%, transparent 25.5%, transparent 75%, #fda085 75%, #fda085), 
                linear-gradient(60deg, #fda085 25%, transparent 25.5%, transparent 75%, #fda085 75%, #fda085);
            background-size: 80px 140px;
            background-position: 0 0, 0 0, 40px 70px, 40px 70px, 0 0, 40px 70px;
            z-index: -1;
            opacity: 0.3;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('https://source.unsplash.com/1600x900/?food,restaurant');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .glass-container {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            padding: 2rem;
            width: 100%;
            max-width: 450px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
        }

        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .message {
            transition: all 0.5s ease;
            opacity: 0;
            height: 0;
            overflow: hidden;
        }

        .message.show {
            opacity: 1;
            height: auto;
            margin-bottom: 1rem;
        }

        /* New styles to improve text visibility */
        .glass-container {
            background: rgba(0, 0, 0, 0.6);
        }

        .text-white {
            color: #ffffff;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        .form-control {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        select.form-control {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
        }

        select.form-control option {
            background: rgba(0, 0, 0, 0.8);
            color: #ffffff;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="glass-container">
        <h2 class="text-3xl font-bold mb-6 text-center text-white">Admin Registration</h2>
        <div id="errorMessages" class="message bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert"></div>
        <div id="successMessage" class="message bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert"></div>
        <form id="registrationForm" action="" method="POST" class="space-y-4">
            <div class="form-group">
                <label for="username" class="block mb-2 text-white">Username</label>
                <input type="text" id="username" name="username" class="form-control w-full px-3 py-2 rounded-md" >
            </div>
            <div class="form-group">
                <label for="email" class="block mb-2 text-white">Email</label>
                <input type="email" id="email" name="email" class="form-control w-full px-3 py-2 rounded-md" >
            </div>
            <div class="form-group">
                <label for="password" class="block mb-2 text-white">Password</label>
                <input type="password" id="password" name="password" class="form-control w-full px-3 py-2 rounded-md" >
            </div>
            <div class="form-group">
                <label for="confirm_password" class="block mb-2 text-white">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control w-full px-3 py-2 rounded-md" >
            </div>
            <div class="form-group">
                <label for="role" class="block mb-2 text-white">Role</label>
                <select id="role" name="role" class="form-control w-full px-3 py-2 rounded-md" >
                    <option value="">Select Role</option>
                    <option value="Admin">Admin</option>
                    <option value="Super Admin">Super Admin</option>
                    <option value="Content Manager">Content Manager</option>
                    <option value="User Support">User Support</option>
                    <option value="Data Analyst">Data Analyst</option>
                </select>
            </div>
            <button type="submit" class="btn-submit w-full py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300">Register</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function showMessage(type, message) {
                var messageElement = type === 'error' ? $('#errorMessages') : $('#successMessage');
                messageElement.html(message).addClass('show');
                setTimeout(function() {
                    messageElement.removeClass('show');
                }, 5000);
            }

            $('#registrationForm').on('submit', function(e) {
                e.preventDefault();

                var errors = [];
                var username = $('#username').val().trim();
                var email = $('#email').val().trim();
                var password = $('#password').val();
                var confirm_password = $('#confirm_password').val();
                var role = $('#role').val();

                if (username === '') {
                    errors.push('Username is required');
                }
                if (email === '') {
                    errors.push('Email is required');
                } else if (!/\S+@\S+\.\S+/.test(email)) {
                    errors.push('Invalid email format');
                }
                if (password === '') {
                    errors.push('Password is required');
                } else if (password.length < 8) {
                    errors.push('Password must be at least 8 characters long');
                }
                if (password !== confirm_password) {
                    errors.push('Passwords do not match');
                }
                if (role === '') {
                    errors.push('Role is required');
                }

                if (errors.length > 0) {
                    showMessage('error', '<ul><li>' + errors.join('</li><li>') + '</li></ul>');
                } else {
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                showMessage('success', response.message);
                                $('#registrationForm')[0].reset();
                            } else {
                                showMessage('error', response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                            showMessage('error', 'An error occurred. Please try again. Detailed error: ' + xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
<?php echo $sidebar_content; ?>
