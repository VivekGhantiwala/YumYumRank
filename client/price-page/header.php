<?php
if (session_status() == PHP_SESSION_NONE) {
    ob_start();
    session_start();
}

// Function to check if user is logged in
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

// Function to redirect guest users to login page
function redirectGuestToLogin()
{
    if (!isLoggedIn()) {
        header("Location: http://localhost/MiniProject(Aman)/Login/login.php");
        exit();
    }
}

// Logout functionality
if (isset($_GET['logout'])) {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
    header("Location: http://localhost/MiniProject(Aman)/client/home/index.php");
    exit();
}

// Determine current page
$current_page = basename($_SERVER['PHP_SELF']);

// Check if user needs to be redirected
if (in_array($current_page, ['alternative.php', 'feedback.php']) && !isLoggedIn()) {
    redirectGuestToLogin();
}

// Fetch user image from database if logged in
$user_image = '';
if (isLoggedIn()) {
    // Assuming you have a database connection established
    $user_id = $_SESSION['user_id'];

    // Replace with your actual database connection and query
    $conn1 = mysqli_connect("localhost", "root", "", "db");
    if (!$conn1) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $stmt1 = $conn1->prepare("SELECT ProfilePicture FROM users WHERE UserID = ?");
    if ($stmt1 === false) {
        die("Error preparing statement: " . $conn1->error);
    }
    $stmt1->bind_param("i", $user_id);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    if ($row1 = $result1->fetch_assoc()) {
        if (!empty($row1['ProfilePicture'])) {
            // Update the path to include the correct directory
            $user_image = "http://localhost/MiniProject(Aman)/Login/" . $row1['ProfilePicture'];
        } else {
            // Set default image path
            $user_image = "http://localhost/MiniProject(Aman)/Login/uploads/profile_pictures/default-profile.jpg";
        }
    } else {
        // Set default image path if no result found
        $user_image = "http://localhost/MiniProject(Aman)/Login/uploads/profile_pictures/default-profile.jpg";
    }
    $stmt1->close();
    // Removed $conn->close(); to keep the connection open
}
?>
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
<nav class="navigation">
    <div class="container">
        <div class="home-container">
            <a href="http://localhost/MiniProject(Aman)/client/home/index.php"><i
                    class="ri-arrow-right-up-line"></i>HOME</a>
            <div class="line"></div>
            <button id="hideButton" onclick="hide()">
                <div class="line1"></div>
                <div class="line2"></div>
            </button>
        </div>
        <div class="product-container">
            <a
                href="<?php echo isLoggedIn() ? '../product-page/product.php' : 'http://localhost/MiniProject(Aman)/Login/login.php'; ?>"><i
                    class="ri-arrow-right-up-line"></i>PRODUCT</a>
            <div class="line"></div>
        </div>
        <div class="About-container">
            <a href="http://localhost/MiniProject(Aman)/client/price-page/index.php"><i
                    class="ri-arrow-right-up-line"></i>Our Plans</a>
            <div class="line"></div>
        </div>
        <div class="Feedback-container">
            <a
                href="<?php echo isLoggedIn() ? '../feedback/feedback.php' : 'http://localhost/MiniProject(Aman)/Login/login.php'; ?>"><i
                    class="ri-arrow-right-up-line"></i>FEEDBACK</a>
            <div class="line"></div>
        </div>
    </div>
</nav>
<nav class="menu1">
<h2><a class="logo" href="http://localhost/MiniProject(Aman)/client/home/index.php">Yum Yum Rank</a></h2>
    <svg  style="
    margin-top: 20px;
" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 90" width="50" height="40" class="hamburger-icon">
        <rect class="rect1" x="55" width="45" height="5" fill="#fff"></rect>
        <rect class="rect2" x="20" y="12" width="80" height="5" fill="#fff"></rect>
        <rect class="rect3" x="0" y="24" width="100" height="5" fill="#fff"></rect>
    </svg>
    <svg style="
    margin-top: 6px;
    height:100px;
" class="svg-line" height="90" width="50">
        <line x1="0" y1="40" x2="0" y2="500" stroke="white" stroke-width="2" />
    </svg>
    <?php if (isLoggedIn()): ?>
        <div class="profile-container">
            <img src="<?php echo htmlspecialchars($user_image); ?>" alt="Profile Picture" class="profile-picture"
                onclick="toggleDropdown()">
            <div class="profile-dropdown" id="profileDropdown">
                <a href="../user-profile/user.php"><i class="ri-user-line"></i>My Profile</a>
                <a href="?logout=1"><i class="ri-logout-box-line"></i>Logout</a>
            </div>
        </div>
    <?php else: ?>
        <a href="http://localhost/MiniProject(Aman)/Login/login.php">Login</a>
    <?php endif; ?>
</nav>
<a href="https://wa.me/9737717176" class="whatsapp-button" target="_blank" rel="noopener noreferrer">
    <i class="ri-whatsapp-line" style="font-size: 24px; color: #ffffff;"></i>
</a>
<style>
    @font-face {
        font-family: Gilroy;
        src: url(../fonts/Gilroy-ExtraBold-Rupee.woff2);
    }

    @font-face {
        font-family: GilroyLight;
        src: url(../fonts/Gilroy-Light.ttf);
    }

    @font-face {
        font-family: GilroyReg;
        src: url(../fonts/Gilroy-Regular.ttf);
    }

    @font-face {
        font-family: DongporaDemo;
        src: url(../fonts/DongporaDemo-nAxJY.otf);
    }

    .logo {
        font-family: 'Poppins', sans-serif;
        /* Bold, clean font */
        font-weight: 700;
        /* Bold font weight */
        font-size: 35px;
        /* Adjust size as needed */
        text-align: center;
        /* Center the text */
        background: linear-gradient(90deg, #3B82F6, #10B981, #405d86);
        /* Themed gradient colors */
        -webkit-background-clip: text;
        /* Chrome/Safari compatibility */
        -webkit-text-fill-color: transparent;
        /* Chrome/Safari compatibility */
        background-clip: text;
        /* Standard property */
        color: transparent;
        /* Ensures gradient is visible */
        margin: 0;
        /* Remove any default margin */
        padding: 20px 0;
    }

    .navigation,
    .home-container,
    .About-container,
    .Feedback-container,
    .product-container,
    .container {
        background-color: rgb(33, 33, 33) !important;
    }

    .menu1 {
        width: 100vw;
        height: 10vh;
        margin-top: 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        background-color: rgb(33, 33, 33);
        position: absolute;
        top: 0%;
        
    }

    .whatsapp-button {
        text-decoration: none;
    }

    .menu1 h2 {
        /* height: 5.5em; */
        font-size: 2em;
        margin-left: 20%;
    }

    .menu1 svg {
        margin-right: 19em;
        cursor: pointer;
    }

    .svg-line {
        position: absolute;
        top: -30px;
        left: 84%;
    }

    .menu1>a {
        position: absolute;
        top: 20px;
        left: 85%;
        text-decoration: none;
        color: #fff;
        font-size: 1.5em;
    }

    .profile-container {
        position: absolute;
        top: 20px;
        left: 85%;
    }

    .profile-picture,
    .profile-picture-placeholder {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        object-fit: cover;
        cursor: pointer;
    }

    .profile-picture-placeholder {
        background-color: #ccc;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        color: #666;
    }

    .profile-dropdown {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background-color: #ffffff;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 10000;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .profile-dropdown a {
        color: #333;
        padding: 12px 16px;
        text-decoration: none;
        display: flex;
        align-items: center;
        transition: background-color 0.3s ease;
        font-family: Gilroy;
    }

    .profile-dropdown a i {
        margin-right: 10px;
    }

    .profile-dropdown a:hover {
        background-color: #f1f1f1;
        color: #000;
    }

    .hamburger-icon {
        overflow: visible;
    }

    .hamburger-icon rect {
        transition: width 0.3s ease, transform 0.3s ease;
    }

    .hamburger-icon:hover .rect1 {
        transform: translateX(-55px);
        width: 100px;
    }

    .hamburger-icon:hover .rect2 {
        transform: translateX(35px);
        width: 45px;
    }

    .navigation {
        width: 100vw;
        height: 100vh;
        /* background-color: crimson; */
        display: none;
        transform: translateY(-955px);
        background-color: #fff;
        z-index: 100;

    }

    .container {
        width: 75%;
        height: 80%;
        background-color: #fff;
        position: absolute;
        top: 0;
        left: 13%;
    }

    .home-container,
    .product-container,
    .About-container,
    .Feedback-container {
        /* overflow: visible; */
        width: 100%;
        height: 160px;
        background-color: rgb(33, 33, 33) !important;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between; 
        overflow: hidden;

    }

    .home-container a,
    .product-container a,
    .About-container a,
    .Feedback-container a {
        font-family: DongporaDemo;
        font-size: 5.5em;
        font-weight: 200;
        z-index: 20;
        text-decoration: none;
        display: block;
        width: 100%;
        color: #fff;x`

    }

    .home-container a i,
    .product-container a i,
    .About-container a i,
    .Feedback-container a i {
        font-size: 35px;
        font-weight: 1000;
        z-index: 2;
    }

    .home-container button {
        position: relative;
        font-size: 1em;
        padding: 20px;
        /* margin-bottom: 45px; */
        margin-right: 20px;
        display: block;
        height: 100px;
        width: 100px;
        border-radius: 50%;
        border: 1px solid black;
        z-index: 3;
        background-color: rgb(220, 220, 200) !important;
    }

    .home-container::before,
    .product-container::before,
    .About-container::before,
    .Feedback-container::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: beige;
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.5s ease;
        z-index: 1;
    }

    .home-container:hover::before,
    .product-container:hover::before,
    .About-container:hover::before,
    .Feedback-container:hover::before {
        transform: scaleX(1);
    }

    .line1,
    .line2 {
        width: 100%;
        height: 1px;
        background-color: #000;
    }

    .line {
        width: 100%;
        height: 2px;
        background-color: #000;
        position: absolute;
        top: 99%;
    }

    .whatsapp-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #25D366;
        color: #ffffff;
        border-radius: 50%;
        text-align: center;
        font-size: 30px;
        box-shadow: 2px 2px 3px #999;
        z-index: 100;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        transition: all 0.3s ease;
        animation: pulse 2s infinite;
    }

    .whatsapp-button:hover {
        background-color: #128C7E;
        transform: scale(1.1);
        animation: none;
    }

    .whatsapp-button svg {
        width: 40px;
        height: 40px;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
        }

        70% {
            transform: scale(1.05);
            box-shadow: 0 0 0 10px rgba(37, 211, 102, 0);
        }

        100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
        }
    }
</style>
<script>
    const menu1 = document.querySelector(".menu1 svg");
    menu1.addEventListener("click", () => {
        // console.log("object");
        gsap.to(".navigation", {
            display: "block",
            y: 0,
            duration: 0.5,
            ease: "power2.out"
        });
        var tl = gsap.timeline({
            delay: 0.3
        });

        tl.from("a", {
            y: 250,
            stagger: 0.1,
            duration: 0.3,
            ease: "ease",
        });
    });

    function hide() {
        gsap.to(".navigation", {
            display: "none",
            y: -1000,
            duration: 0.5,
            ease: "power2.out"
        });
    }
    function menuinfo() {
        const homeContainer = document.querySelector(".home-container");

        homeContainer.addEventListener("mouseover", () => {
            gsap.to(".home-container::before", {
                duration: 0.1,
                transformOrigin: "left"
            });
            gsap.to(".home-container a", {
                color: "rgb(33, 33, 33)"
            });

            gsap.to(".line1", {
                rotate: "-45deg",
                backgroundColor: "#000"
            });
            gsap.to(".line2", {
                rotate: "45deg",
                backgroundColor: "#000"
            });
            gsap.to(".home-container button", {
                backgroundColor: "rgb(30, 30, 30)",
                border: "1px solid rgb(50, 50, 50)",
                // delay: 0.2,

            });
        });

        homeContainer.addEventListener("mouseout", () => {
            gsap.to(".home-container::before", {
                duration: 0.1,
                transformOrigin: "left",
            });
            gsap.to(".home-container button", {
                backgroundColor: "#fff",
                border: "1px solid #000",
            });
            gsap.to(".line1,.line2", {
                rotate: "0deg",
                backgroundColor: "#000"
            });
            gsap.to(".home-container a", {
                color: "#fff",
                // delay:0.1
            });
        });

        const productContainer = document.querySelector(".product-container");

        productContainer.addEventListener("mouseover", () => {
            gsap.to(".product-container::before", {
                duration: 0.1,
                transformOrigin: "left"
            });
            gsap.to(".product-container a", {
                color: "rgb(33, 33, 33)"
            });
        });

        productContainer.addEventListener("mouseout", () => {
            gsap.to(".product-container::before", {
                duration: 0.1,
                transformOrigin: "left",
            });
            gsap.to(".product-container a", {
                color: "#fff",
                // delay:0.1
            });
        });

        const AboutContainer = document.querySelector(".About-container");

        AboutContainer.addEventListener("mouseover", () => {
            gsap.to(".About-container::before", {
                duration: 0.1,
                transformOrigin: "left"
            });
            gsap.to(".About-container a", {
                color: "rgb(33, 33, 33)"
            });
        });

        AboutContainer.addEventListener("mouseout", () => {
            gsap.to(".About-container::before", {
                duration: 0.1,
                transformOrigin: "left",
            });
            gsap.to(".About-container a", {
                color: "#fff",
                // delay:0.1
            });
        });
        const FeedbackContainer = document.querySelector(".Feedback-container");

        FeedbackContainer.addEventListener("mouseover", () => {
            gsap.to(".Feedback-container::before", {
                duration: 0.1,
                transformOrigin: "left"
            });
            gsap.to(".Feedback-container a", {
                color: "rgb(33, 33, 33)",
            });
        });

        FeedbackContainer.addEventListener("mouseout", () => {
            gsap.to(".Feedback-container::before", {
                duration: 0.1,
                transformOrigin: "left",
            });
            gsap.to(".Feedback-container a", {
                color: "#fff",
                // delay:0.1
            });
        });
    }

    menuinfo();

    function toggleDropdown() {
        var dropdown = document.getElementById("profileDropdown");
        if (dropdown.style.display === "block") {
            gsap.to(dropdown, { duration: 0.3, opacity: 0, y: -10, display: "none", ease: "power2.out" });
        } else {
            dropdown.style.display = "block";
            gsap.fromTo(dropdown,
                { opacity: 0, y: -10 },
                { duration: 0.3, opacity: 1, y: 0, ease: "power2.out" }
            );
        }
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function (event) {
        if (!event.target.matches('.profile-picture') && !event.target.matches('.profile-picture-placeholder')) {
            var dropdown = document.getElementById("profileDropdown");
            if (dropdown.style.display === "block") {
                gsap.to(dropdown, { duration: 0.3, opacity: 0, y: -10, display: "none", ease: "power2.out" });
            }
        }
    }
</script>