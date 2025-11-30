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
        session_regenerate_id(true);
        $success = "Admin login successful Redirecting...";
        header("refresh:2;url=../index.php");
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
            header("refresh:2;url=index.php");
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
    <title>Animated Login Page</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap');
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap');
*
{
	margin: 0;
	padding: 0;
	box-sizing: border-box;
	font-family: 'Open Sans', sans-serif;
}
body
{
	display: flex;
	justify-content: center;
	align-items: center;
	min-height: 100vh;
	background: #111;
}
.square
{
	position: relative;
	width: 500px;
	height: 500px;
	display: flex;
	justify-content: center;
	align-items: center;
}
.square i
{
	position: absolute;
	inset: 0;
	border: 2px solid #fff;
	transition: 0.5s;
}
.square i:nth-child(1)
{
	border-radius: 38% 62% 63% 37% / 41% 44% 56% 59%;
	animation: animate 6s linear infinite;
}
.square i:nth-child(2)
{
	border-radius: 41% 44% 56% 59%/38% 62% 63% 37%;
	animation: animate 4s linear infinite;
}
.square i:nth-child(3)
{
	border-radius: 41% 44% 56% 59%/38% 62% 63% 37%;
	animation: animate2 10s linear infinite;
}
.square:hover i
{
	border: 6px solid var(--clr);
	filter: drop-shadow(0 0 20px var(--clr));
}
@keyframes animate
{
	0%
	{
		transform: rotate(0deg);
	}
	100%
	{
		transform: rotate(360deg);
	}
}
@keyframes animate2
{
	0%
	{
		transform: rotate(360deg);
	}
	100%
	{
		transform: rotate(0deg);
	}
}
.login 
{
	position: absolute;
	width: 300px;
	height: 100%;
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
	gap: 20px;
}
.login h2 
{
	font-size: 2em;
	color: #fff;
}
.login .inputBx 
{
	position: relative;
	width: 100%;
  margin-top: 20px;
}
.login .inputBx input 
{
	position: relative;
	width: 100%;
	padding: 12px 20px;
	background: transparent;
	border: 2px solid #fff;
	border-radius: 40px;
	font-size: 1.2em;
	color: #fff;
	box-shadow: none;
	outline: none;
}
.login .inputBx input[type="submit"]
{
	width: 100%;
	background: #0078ff;
	background: linear-gradient(45deg,#ff357a,#fff172);
	border: none;
	cursor: pointer;
}
.login .inputBx input::placeholder 
{
	color: rgba(255,255,255,0.75);
}
.login .links
{
	position: relative;
	width: 100%;
	display: flex;
	align-items: center;
	justify-content: space-between;
	padding: 0 20px;
}
.login .links a 
{
	color: #fff;
	text-decoration: none;
  margin-top: 10px;
}
.login .links a:hover 
{
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
            max-width: 16rem;
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
            font-size: 1.2rem;
            margin: 0;
            line-height: 1.35rem;
            font-weight: 600;
            position: relative;
            color: var(--clr);
        }

        .toast p {
            position: relative;
            font-size: 0.95rem;
            z-index: 1;
            margin: 0.25rem 0 0;
            color: #595959;
            line-height: 1.3rem;
        }

        .close {
            position: absolute;
            width: 1.35rem;
            height: 1.35rem;
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
            font-size: 1.8rem;
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
            <h2>Login</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="loginForm">
                <div class="inputBx">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="inputBx">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="inputBx">
                    <input type="submit" value="Sign in">
                </div>
                <div class="links">
                    <a href="#">Forget Password</a>
                    <a href="#">Signup</a>
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
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("loginForm");
            const usernameInput = form.querySelector('input[name="username"]');
            const passwordInput = form.querySelector('input[name="password"]');

            form.addEventListener("submit", function(event) {
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
            closeButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var toastItem = this.closest('.toast');
                    if (toastItem) {
                        toastItem.style.display = 'none';
                    }
                });
            });

            // Hide notifications after 5 seconds
            var toastItems = document.querySelectorAll('.toast');
            toastItems.forEach(function(toast) {
                setTimeout(function() {
                    toast.style.display = 'none';
                }, 5000);
            });
        });
    </script>
</body>
</html>