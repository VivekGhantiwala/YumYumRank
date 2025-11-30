<div class="preloader">

</div>
<script>
    let loader = document.querySelector(".preloader");
    function closepreloader() {
        loader.style.opacity = 0;  // Fade the loader out
        setTimeout(() => {
            loader.style.display = "none";  // Hide the loader completely
        }, 1000); // Increased delay (1000ms = 1s) to match the fade-out duration
    }

    window.addEventListener("load", function () {
        const gif = new Image();
        gif.src = "./143.gif";  // Path to the preloader GIF

        // Once the GIF is loaded, proceed to hide the loader
        gif.onload = function () {
            // console.log("GIF is loaded.");
            setTimeout(closepreloader, 1000);  // Delay before hiding the loader
        };
    });
</script>
<style>
    .preloader {
        height: 100vh;
        width: 100vw;
        background: #000005 url(./143.gif) no-repeat center center;
        position: fixed;
        z-index: 1000;
        opacity: 1;
    }
</style>
<?php
$conn = mysqli_connect("localhost", "root", "", "db");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$error = "";
$success = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    // Check if email exists in Users table
    $sql = "SELECT * FROM Users WHERE Email = '$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Check if the password_reset_attempts table exists
        $table_check_sql = "SHOW TABLES LIKE 'password_reset_attempts'";
        $table_check_result = mysqli_query($conn, $table_check_sql);

        if (mysqli_num_rows($table_check_result) == 0) {
            // Create the password_reset_attempts table if it doesn't exist
            $create_table_sql = "CREATE TABLE password_reset_attempts (
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) NOT NULL,
                attempt_time DATETIME NOT NULL
            )";
            mysqli_query($conn, $create_table_sql);
        }

        // Check reset attempts in the last hour
        $check_attempts_sql = "SELECT COUNT(*) as attempt_count FROM password_reset_attempts WHERE email = '$email' AND attempt_time > DATE_SUB(NOW(), INTERVAL 1 HOUR)";
        $attempt_result = mysqli_query($conn, $check_attempts_sql);
        $attempt_count = mysqli_fetch_assoc($attempt_result)['attempt_count'];

        if ($attempt_count < 3) {
            // Generate a temporary password
            $temp_password = bin2hex(random_bytes(8)); // 16 characters long
            $hashed_temp_password = password_hash($temp_password, PASSWORD_DEFAULT);

            // Update the user's password in the database
            $update_sql = "UPDATE Users SET Password = '$hashed_temp_password' WHERE Email = '$email'";
            if (mysqli_query($conn, $update_sql)) {
                // Log the reset attempt
                $log_attempt_sql = "INSERT INTO password_reset_attempts (email, attempt_time) VALUES ('$email', NOW())";
                mysqli_query($conn, $log_attempt_sql);

                // Instead of sending an email, we'll display the temporary password to the user
                $success = "Your temporary password is: " . $temp_password . ". Please login and change your password immediately.";
            } else {
                $error = "Failed to reset password. Please try again.";
            }
        } else {
            $error = "You have exceeded the maximum number of password reset attempts. Please try again later.";
        }
    } else {
        $error = "Email not found in our records.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YumYum Forgot Password</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Open Sans', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #111;
        }

        .square {
            position: relative;
            width: 400px;
            height: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;
        }

        .square i {
            position: absolute;
            inset: 0;
            border: 2px solid #fff;
            transition: 0.5s;
        }

        .square i:nth-child(1) {
            border-radius: 38% 62% 63% 37% / 41% 44% 56% 59%;
            animation: animate 6s linear infinite;
        }

        .square i:nth-child(2) {
            border-radius: 41% 44% 56% 59%/38% 62% 63% 37%;
            animation: animate 4s linear infinite;
        }

        .square i:nth-child(3) {
            border-radius: 41% 44% 56% 59%/38% 62% 63% 37%;
            animation: animate2 10s linear infinite;
        }

        .square:hover i {
            border: 6px solid var(--clr);
            filter: drop-shadow(0 0 20px var(--clr));
        }

        .login {
            position: relative;
            width: 300px;
            height: auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            border-radius: 10px;
            padding: 40px;
            z-index: 20;
        }

        .login h2 {
            font-size: 2em;
            color: #fff;
            margin-bottom: 20px;
        }

        .login .inputBx {
            position: relative;
            width: 100%;
            margin-bottom: 20px;
        }

        .login .inputBx input {
            width: 100%;
            padding: 10px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            outline: none;
            border-radius: 30px;
            color: #fff;
            font-size: 1em;
        }

        .login .inputBx input[type="submit"] {
            background: #fff;
            color: #111;
            cursor: pointer;
            font-weight: 600;
        }

        .login .links {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-top: 15px;
        }

        .login .links a {
            color: #fff;
            text-decoration: none;
            font-size: 0.9em;
        }

        @keyframes animate {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes animate2 {
            0% {
                transform: rotate(360deg);
            }
            100% {
                transform: rotate(0deg);
            }
        }

        .toast-panel {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .toast {
            background: #fff;
            border-radius: 4px;
            padding: 16px 20px;
            margin-bottom: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            position: relative;
            transition: 0.3s;
            opacity: 1;
        }

        .toast h3 {
            font-size: 1.3rem;
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--clr);
        }

        .toast p {
            font-size: 1.1rem;
            z-index: 1;
            margin: 0.25rem 0 0;
            color: #595959;
            line-height: 1.5rem;
        }

        .close {
            position: absolute;
            width: 1.5rem;
            height: 1.5rem;
            text-align: center;
            right: 1rem;
            cursor: pointer;
            border-radius: 100%;
        }

        .close:after {
            position: absolute;
            font-family: 'Varela Round', san-serif;
            width: 100%;
            height: 100%;
            left: 0;
            font-size: 2rem;
            content: "+";
            transform: rotate(-45deg);
            border-radius: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #595959;
            text-indent: 1px;
        }

        .close:hover:after {
            background: var(--clr);
            color: #fff;
        }

        .toast.success {
            --clr: #03a65a;
        }

        .toast.error {
            --clr: #db3056;
        }
    </style>
</head>

<body>
    <div class="square">
        <i style="--clr: #00ff0a"></i>
        <i style="--clr: #ff0057"></i>
        <i style="--clr: #fffd44"></i>
        <div class="login">
            <h2>Forgot Password</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="forgotPasswordForm">
                <div class="inputBx">
                    <input type="email" name="email" placeholder="Email" >
                    <p id="emailError" class="error-message" style="display: none; color: red;">Please enter your email address.</p>
                </div>
                <div class="inputBx">
                    <input type="submit" value="Reset Password">
                </div>
                <div class="links">
                    <a href="login.php">Back to Login</a>
                </div>
            </form>
        </div>
    </div>

    <div class="toast-panel">
        <?php if (!empty($success)): ?>
            <div class="toast success">
                <label class="close"></label>
                <h3>Success!</h3>
                <p><?php echo htmlspecialchars($success); ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="toast error">
                <label class="close"></label>
                <h3>Error!</h3>
                <p><?php echo htmlspecialchars($error); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("forgotPasswordForm");
            const emailInput = form.querySelector('input[name="email"]');
            const emailError = document.getElementById("emailError");

            form.addEventListener("submit", function (event) {
                let isValid = true;

                if (!emailInput.value.trim()) {
                    isValid = false;
                    emailError.style.display = "block";
                } else {
                    emailError.style.display = "none";
                }

                if (!isValid) {
                    event.preventDefault();
                }
            });

            // Close button functionality for toasts
            const closeButtons = document.querySelectorAll('.close');
            closeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.toast').style.opacity = '0';
                    setTimeout(() => {
                        this.closest('.toast').remove();
                    }, 300);
                });
            });
        });
    </script>
</body>

</html>
