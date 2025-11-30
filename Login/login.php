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
    // Get form data
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    // First, check the Admin table
    $sql = "SELECT * FROM Admin_Users WHERE Username = '$username'";
    $result = mysqli_query($conn, $sql);
    $admin = mysqli_fetch_assoc($result);

    if ($admin && password_verify($password, $admin["Password"])) {
        session_start();
        $_SESSION['admin_id'] = $admin['AdminID'];
        $_SESSION['admin_username'] = $admin['Username'];
        $_SESSION['is_admin'] = true;
        $_SESSION['Role'] = $admin['Role'];
        session_regenerate_id(true);
        $success = "Admin login successful Redirecting...";
        header("refresh:2;url=../admin/index.php");
    } else {
        // Check Users table if admin login fails
        $sql = "SELECT * FROM Users WHERE Username = '$username'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user["Password"])) {
            session_start();
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['username'] = $user['Username'];
            $_SESSION['is_admin'] = false;
            session_regenerate_id(true);
            $success = "Login successful Redirecting...";
            header("refresh:2;url=../client/home/index.php");
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YumYum Login Page</title>
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
            width: 600px;
            height: 600px;
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

        .login {
            position: absolute;
            width: 400px;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 30px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            padding: 50px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .login h2 {
            font-size: 2.5em;
            color: #fff;
            margin-bottom: 20px;
        }

        .login .inputBx {
            position: relative;
            width: 100%;
            margin-top: 25px;
        }

        .login .inputBx input {
            position: relative;
            width: 100%;
            padding: 15px 25px;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid #fff;
            border-radius: 40px;
            font-size: 1.3em;
            color: #fff;
            box-shadow: none;
            outline: none;
        }

        .login .inputBx input[type="submit"] {
            width: 100%;
            background: #0078ff;
            background: linear-gradient(45deg, #ff357a, #fff172);
            border: none;
            cursor: pointer;
            font-size: 1.4em;
            font-weight: 600;
            margin-top: 30px;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .login .links {
            position: relative;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            margin-top: 20px;
        }

        .login .links a {
            color: #fff;
            text-decoration: none;
            font-size: 1.1em;
        }

        .login .links a:hover {
            color: #fff;
            text-decoration: underline;
        }

        /* Add these new styles for notifications */
        .toast-panel {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 10px;
        }

        .toast {
            background: #fff;
            color: #f5f5f5;
            padding: 1rem 2rem 1rem 3rem;
            text-align: center;
            border-radius: 1rem;
            position: relative;
            font-weight: 300;
            text-align: left;
            max-width: 20rem;
            transition: all 0.5s ease 0s;
            opacity: 1;
            border: 0.15rem solid #fff2;
            box-shadow: 0 0 1.5rem 0 #1a1f4360;
        }

        .toast:before {
            content: "";
            position: absolute;
            width: 0.5rem;
            height: calc(100% - 1.5rem);
            top: 0.75rem;
            left: 0.5rem;
            z-index: 0;
            border-radius: 1rem;
            background: var(--clr);
        }

        .toast h3 {
            font-size: 1.3rem;
            margin: 0;
            line-height: 1.5rem;
            font-weight: 600;
            position: relative;
            color: var(--clr);
        }

        .toast p {
            position: relative;
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
        .error-message{
            color:red !important;
        }   
    </style>
</head>

<body>
    <!-- <img src="Login/143.gif" alt=""> -->

    <div class="square">
        <i style="--clr: #00ff0a"></i>
        <i style="--clr: #ff0057"></i>
        <i style="--clr: #fffd44"></i>
        <div class="login">
            <h2>Login</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="loginForm">
                <div class="inputBx">
                    <input type="text" name="username" placeholder="Username"   >
                </div>
                <div class="inputBx">
                    <input type="password" name="password" placeholder="Password"    id="passwordInput">

                    <svg class="toggle-password" id="togglePassword"
                        style="position: absolute; right: 20px; top: 15px; cursor: pointer; width: 24px; height: 24px;"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path id="eyeOpen"
                            d="M12 4.5C6.48 4.5 2.01 8.21 1.14 12c.87 3.79 5.34 7.5 10.86 7.5 5.42 0 10-3.71 10-7.5S17.42 4.5 12 4.5zm0 13c-3.87 0-7-2.69-8.54-5 1.54-2.31 4.67-5 8.54-5 3.87 0 7 2.69 8.54 5-1.54 2.31-4.67 5-8.54 5z"
                            fill="#fff" />
                        <circle cx="12" cy="12" r="3" fill="#fff" />
                    </svg>

                    <svg class="toggle-password" id="togglePasswordClosed"
                        style="position: absolute; right: 20px; top: 15px; cursor: pointer; width: 24px; height: 24px; display: none;"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path id="eyeClosed"
                            d="M12 4.5C6.48 4.5 2.01 8.21 1.14 12c.87 3.79 5.34 7.5 10.86 7.5 5.42 0 10-3.71 10-7.5S17.42 4.5 12 4.5zm0 13c-3.87 0-7-2.69-8.54-5 1.54-2.31 4.67-5 8.54-5 3.87 0 7 2.69 8.54 5-1.54 2.31-4.67 5-8.54 5z"
                            fill="#fff" />
                        <circle cx="12" cy="12" r="3" fill="#fff" />
                        <line x1="3" y1="3" x2="20" y2="20" stroke="#fff" stroke-width="2" />
                    </svg>
                </div>

                <div class="inputBx">
                    <input type="submit" value="Sign in">
                </div>
                <div class="links">
                    <a href="registration.php">Signup</a>
                    <a href="forgot_password.php">Forgot Password</a>
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
        // Password visibility toggle
        const passwordInput = document.getElementById('passwordInput');
        const togglePassword = document.getElementById('togglePassword');
        const togglePasswordClosed = document.getElementById('togglePasswordClosed');

        togglePassword.addEventListener('click', function () {
            // Change input type to text
            passwordInput.setAttribute('type', 'text');
            // Hide open eye icon and show closed eye icon
            togglePassword.style.display = 'none';
            togglePasswordClosed.style.display = 'block';
        });

        togglePasswordClosed.addEventListener('click', function () {
            // Change input type to password
            passwordInput.setAttribute('type', 'password');
            // Show open eye icon and hide closed eye icon
            togglePassword.style.display = 'block';
            togglePasswordClosed.style.display = 'none';
        });

        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("loginForm");
            const usernameInput = form.querySelector('input[name="username"]');
            const passwordInput = form.querySelector('input[name="password"]');

            form.addEventListener("submit", function (event) {
                let isValid = true;

                if (usernameInput.value.trim() === "") {
                    isValid = false;
                    showError(usernameInput, "Please enter a username.");
                } else {
                    clearError(usernameInput);
                }

                if (passwordInput.value.trim() === "") {
                    isValid = false;
                    showError(passwordInput, "Please enter a password.");
                } else {
                    clearError(passwordInput);
                }

                if (!isValid) {
                    event.preventDefault();
                }
            });

            function showError(input, message) {
                const errorElement = input.parentElement.querySelector('.error-message');
                if (!errorElement) {
                    const newErrorElement = document.createElement('div');
                    newErrorElement.className = 'error-message';
                    newErrorElement.textContent = message;
                    input.parentElement.appendChild(newErrorElement);
                } else {
                    errorElement.textContent = message;
                }
                input.classList.add('error-input');
            }

            function clearError(input) {
                const errorElement = input.parentElement.querySelector('.error-message');
                if (errorElement) {
                    errorElement.remove();
                }
                input.classList.remove('error-input');
            }

            // Close button functionality for notifications
            var closeButtons = document.querySelectorAll('.toast .close');
            closeButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var toastItem = this.closest('.toast');
                    if (toastItem) {
                        toastItem.style.display = 'none';
                    }
                });
            });

            // Hide notifications after 5 seconds
            var toastItems = document.querySelectorAll('.toast');
            toastItems.forEach(function (toast) {
                setTimeout(function () {
                    toast.style.display = 'none';
                }, 5000);
            });
        });
    </script>
</body>

</html>