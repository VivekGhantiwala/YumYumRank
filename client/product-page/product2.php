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
        gif.src = "../143.gif";  // Path to the preloader GIF

        // Once the GIF is loaded, proceed to hide the loader
        gif.onload = function () {
            console.log("GIF is loaded.");
            setTimeout(closepreloader, 1000);  // Delay before hiding the loader
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
// if (!isset($_SESSION['user_id'])) {
//     header("Location: ../../Login/login.php");
//     exit;
// }
include 'connection.php';


$query = "SELECT DISTINCT Name, image_path FROM categories";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>

    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../asset/logo.png" type="image/x-icon">
    <link href="../cdnFiles/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="../cdnFiles/locomotive-scroll.css">
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com"> -->
    <!-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet"> -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&display=swap" rel="stylesheet"> -->
</head>

<body>

    <!-- <div class="part1"></div>
    <div class="part2"></div>
    <div class="part3"></div>
    <div class="part4"></div> -->
    <div class="main">
        <div class="page1" data-scroll data-scroll-speed="-3.5">
            <?php include './header.php'; ?>
            <h2 class="categoryheading">What's on your mind?</h2>
            <!-- <div class="header-section"> -->
                <!-- <div class="scroll-buttons">
                    <button id="scroll-left" onclick="scrollToLeft()"><i class="ri-arrow-left-line"></i></button>
                    <button id="scroll-right" onclick="scrollToRight()"><i class="ri-arrow-right-line"></i></button>
                </div> -->
            <!-- </div> -->
            <section>
                <div class="category-panel">
                    <button class="scroll-button left"><i class="ri-arrow-left-line"></i></button>
                    <div class="move">
                    <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $category = htmlspecialchars($row['Name']);
                                $imagePath = htmlspecialchars($row['image_path']);
                                echo '<div class="category-item">';
                                echo '<a class="anchortag" href="../alternative-page/alternative.php?category=' . urlencode($category) . '">';
                                echo '<div class="image-container">';
                                echo '<img  src="' . $imagePath . '" alt="' . $category . '">';
                                echo '</div>';
                                echo '<p>' . $category . '</p>';
                                echo '</a>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>No categories available.</p>';
                        }
                        ?>
                    </div>
                    <button class="scroll-button right"><i class="ri-arrow-right-line"></i></button>
                </div>

                <!-- <div class="category-panel">
                    <div class="move">
                       
                    </div>
                </div> -->
                <div class="top-added">
                    <div class="header-section2">
                        <h2 class="heading">Top 5 Healthy Products</h2>
                    </div>
                    <div class="move2">
                        <?php
                        $query = "SELECT * FROM foods ORDER BY HealthScore desc LIMIT 5";
                        $result = mysqli_query($conn, $query);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $pname = htmlspecialchars($row['Name']);
                                $imagePath = $row['Image'];
                                $description = $row['Description'];
                                $score = $row['HealthScore'];
                                echo '<div class="top-product" >';
                                echo '<a href="../alternative-page/alternative.php?Name=' . urlencode($pname) . '">';
                                echo '<div class="top-image-container">';
                                echo '<img  src="../asset/products/' . $imagePath . '" alt="' . $pname . '">';
                                echo '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="190px" height="100px" viewBox="0 0 368 480" enable-background="new 0 0 368 480" xml:space="preserve" class="score-tag"> <path  fill="#008c3e" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"d="M107.000000,6.000000 C100.691673,8.341979 98.893227,12.949043 98.899132,19.500092 
                                C99.030807,165.499969 99.000000,311.500000 99.000000,457.500000 
                                C99.000000,464.948303 101.434715,469.330811 106.500000,471.000000 
                                C110.931488,472.460358 116.046860,469.889008 119.988075,463.992035 
                                C136.349777,439.510986 152.674362,415.005127 168.994720,390.496490 
                                C173.196518,384.186554 177.288284,377.803101 181.512497,371.508362 
                                C185.852539,365.040985 190.657471,365.004700 194.983139,371.511200 
                                C215.354340,402.152679 235.642380,432.849548 256.055145,463.463226 
                                C257.402710,465.484131 258.701904,467.558990 260.938110,469.090363 
                                C267.610413,473.659454 276.698730,469.719208 277.980530,460.997131 
                                C278.124390,460.018280 278.000000,459.000000 278.000000,458.000000 
                                C278.000000,311.666656 278.000000,165.333328 278.000000,19.000000 
                                C278.000000,10.026446 273.973541,5.999999 265.000000,5.999999 
                                C212.500000,6.000000 160.000000,6.000000 107.500000,6.000000 "/>
                                <text x="42%" y="30%" text-anchor="middle" fill="#f5f5dc" font-size="90" font-family="Arial" dy=".3em">';
                                echo $score;
                                '</text></svg>';
                                echo '</div>';
                                echo '<h1>' . $pname . '</h1>';
                                echo "<p>" . $description . "</p>";
                                echo '</a>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>No Recent Product.</p>';
                        }
                        ?>
                    </div>
                </div>
            </section>
        </div>
        <div class="page2" data-scroll data-scroll-speed="1">
            <section>

                <div class="recently-added">
                    <div class="header-section recent">
                        <h2 class="heading">Recently added</h2>
                        <!-- <div class="scroll-buttons">
                            <button id="scroll-left" onclick="scrollToLeft1()"><i
                                    class="ri-arrow-left-line"></i></button>
                            <button id="scroll-right" onclick="scrollToRight1()"><i
                                    class="ri-arrow-right-line"></i></button>
                        </div> -->
                    </div>
                    <div class="move1">
                        <?php
                        $queryRecent = "SELECT * FROM foods ORDER BY created_at desc";
                        $result = mysqli_query($conn, $queryRecent);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $pname = htmlspecialchars($row['Name']);
                                $imagePath = $row['Image'];
                                $description = $row['Description'];
                                $score = $row['HealthScore'];
                                echo '<div class="recently-product" >';
                                echo '<a href="../alternative-page/alternative.php?Name=' . urlencode($pname) . '">';
                                echo '<div class="recently-image-container">';
                                echo '<img  src="../asset/products/' . $imagePath . '" alt="' . $pname . '">';
                                echo '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="190px" height="100px" viewBox="0 0 368 480" enable-background="new 0 0 368 480" xml:space="preserve" class="score-tag"><path  fill="#008c3e" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
        d="M107.000000,6.000000 
        C100.691673,8.341979 98.893227,12.949043 98.899132,19.500092 
        C99.030807,165.499969 99.000000,311.500000 99.000000,457.500000 
        C99.000000,464.948303 101.434715,469.330811 106.500000,471.000000 
        C110.931488,472.460358 116.046860,469.889008 119.988075,463.992035 
        C136.349777,439.510986 152.674362,415.005127 168.994720,390.496490 
        C173.196518,384.186554 177.288284,377.803101 181.512497,371.508362 
        C185.852539,365.040985 190.657471,365.004700 194.983139,371.511200 
        C215.354340,402.152679 235.642380,432.849548 256.055145,463.463226 
        C257.402710,465.484131 258.701904,467.558990 260.938110,469.090363 
        C267.610413,473.659454 276.698730,469.719208 277.980530,460.997131 
        C278.124390,460.018280 278.000000,459.000000 278.000000,458.000000 
        C278.000000,311.666656 278.000000,165.333328 278.000000,19.000000 
        C278.000000,10.026446 273.973541,5.999999 265.000000,5.999999 
        C212.500000,6.000000 160.000000,6.000000 107.500000,6.000000 "/>
  <text class="score" x="42%" y="30%" text-anchor="middle" fill="#f5f5dc" font-size="90" font-family="Arial" dy=".3em">';
                                echo $score;
                                '</text>
  
</svg>
';

                                echo '</div>';
                                echo '<h1>' . $pname . '</h1>';
                                echo "<p>" . $description . "</p>";
                                echo '</a>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>No Recent Product.</p>';
                        }
                        ?>
                    </div>
                </div>
            </section>
        </div>
        <div class="page3" data-scroll data-scroll-speed="1">
            <?php include '../footer/footer.php'; ?>
        </div>
    </div>

    <div id="toast" class="toast"></div>

    <script src="../cdnFiles/locomotive-scroll.js"></script>
    <script src="../cdnFiles/gsap.min.js"></script>
    <script src="../cdnFiles/ScrollTrigger.min.js"></script>
    <script src="script.js" defer></script>

</body>

</html>