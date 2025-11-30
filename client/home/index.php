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
            console.log("GIF is loaded.");
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="../cdnFiles/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="../cdnFiles/locomotive-scroll.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="main">
        <div class="page1" data-scroll data-scroll-speed="-3.5">
            <?php include '../header/header.php'; ?>
            <section class="hero" id="home">
                <div class="centerContainer">
                    <h1>Discover Healthy Food Choices</h1>
                    <p>Explore and evaluate food products based on health scores and user reviews.</p>
                    <a href="http://localhost/MiniProject(Aman)/client/product-page/product.php"
                        class="cta-button">Browse
                        Products</a>

                </div>
            </section>
            <div class="about-section-yum">
                <div class="about-yum-yum">
                    <p>Yum Yum Rank is your trusted platform for making informed food choices, providing transparent
                        and expert-backed health rankings for various food products. In today's world, understanding
                        what's healthy and what's not can be confusing. That's why we evaluate food items across
                        different categories, giving each product a health score based on its ingredients,
                        nutritional value, and overall health impact.

                        Our unique scoring system helps you make smarter decisions about your diet:
                        <br>

                        <li>Foods with a score of 3 or below are not recommended for regular consumption due to their
                            poor nutritional profile.</li>

                        <li>Foods with a score between 4 and 7 can be enjoyed occasionally, but they shouldn't be a
                            daily part of your diet.</li>
                        <li>Foods scoring between 8 and 10 are highly nutritious and should be eaten regularly to
                            maintain a healthy lifestyle.</li>
                        <br>

                    </p>
                    <p>

                        We also provide alternatives to lower-scoring products, making it easier to switch to
                        healthier options. Whether you're looking to improve your diet or simply make better food
                        choices, Yum Yum Rank is here to guide you toward a healthier you, one meal at a time.</p>
                </div>
            </div>
        </div>
        <div class="page3" data-scroll data-scroll-speed="1">
            <div class="why-choose-container">
                <h1>Why Choose Yum Yum Rank?</h1>
                <div class="cards">
                    <div class="card">
                        <h2>Comprehensive Analysis</h2>
                        <ul>
                            <li>Detailed Health Scores</li>
                            <li>Nutritional Insights</li>
                        </ul>
                        <p>Get comprehensive health ratings and in-depth nutritional information for a wide range of
                            food
                            products.</p>
                    </div>
                    <div class="card">
                        <h2>Expert Knowledge</h2>
                        <ul>
                            <li>Ingredient Analysis</li>
                            <li>Professional Insights</li>
                        </ul>
                        <p>Understand what goes into your food with detailed ingredient breakdowns and benefit from the
                            expertise of nutritionists and food scientists.</p>
                    </div>
                    <div class="card">
                        <h2>Community-Driven</h2>
                        <ul>
                            <li>User Feedback</li>
                            <li>Flavor & Variety</li>
                        </ul>
                        <p>Read real experiences from health-conscious consumers and discover healthy options without
                            compromising on taste or diversity.</p>
                    </div>
                </div>
            </div>
            <div class="how-it-works-container">
                <h1>How It Works</h1>
                <div class="steps">
                    <div class="step" onclick="showAlert('Search Products')">
                        <div class="icon">🔍</div>
                        <h2>Search Products</h2>
                        <p>Find your favorite foods in our extensive database.</p>
                    </div>
                    <div class="step" onclick="showAlert('Check Health Score')">
                        <div class="icon">⭐</div>
                        <h2>Check Health Score</h2>
                        <p>See how your choices rank on our health scale.</p>
                    </div>
                    <div class="step" onclick="showAlert('Make Informed Decisions')">
                        <div class="icon">➡️</div>
                        <h2>Make Informed Decisions</h2>
                        <p>Use our insights to improve your diet and health.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="last-page">
            <div class="reviews" style="
            --width:450px;
            --height:200px;
            --quantity:10;
        ">
                <div class="latest-review-header">
                    <h2>Latest Reviews</h2>
                </div>
                <!-- <img src="http://localhost/MiniProject(Aman)/Vivek/login/uploads/profile_pictures/670e033adfec6.jpg" alt=""> -->
                <div class="review-panel">
                    <?php
                    include 'connection.php';

                    // Fetch top 10 reviews
                    $sql = "SELECT name, feedback, score,UserID FROM reviews ORDER BY score DESC LIMIT 10 ";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Initialize image position counter
                        $i = 1;

                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="user-review" style="--position: ' . $i . '">';
                            echo '<div class="profileContainer">';


                            $sql12 = "SELECT ProfilePicture,Username FROM users WHERE UserID LIKE '" . $row["UserID"] . "'";
                            $result12 = $conn->query($sql12);

                            if ($result12->num_rows > 0) {
                                while ($row12 = $result12->fetch_assoc()) {
                                    $profilePicture = $row12["ProfilePicture"] ? 'http://localhost/MiniProject(Aman)/login/' . $row12["ProfilePicture"] : 'http://localhost/MiniProject(Aman)/login/uploads\profile_pictures/default-profile.jpg';
                                    echo '<img src="' . $profilePicture . '" alt="">';
                                    echo "<div>";
                                    echo '<h5 class="feedbackname">' . $row["name"] . '</h5>';
                                    echo '<p class="feedbackusername">@' . $row12["Username"] . '</p>';
                                    echo "</div>";
                                }
                            }

                            // Increment image position for next review
                            $i++;


                            echo '</div>';

                            echo '<div class="star">';
                            // Use a different loop counter for stars
                            for ($starCount = 0; $starCount < $row["score"]; $starCount++) {
                                echo '<i class="ri-star-fill"></i>';
                            }
                            echo '</div>';

                            echo '<p>' . $row["feedback"] . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo "0 reviews";
                    }

                    $conn->close();
                    ?>
                </div>
                <div class="review-panel2">
                    <?php
                    include 'connection.php';

                    // Fetch top 10 reviews
                    $sql = "SELECT name, feedback, score,UserID FROM reviews ORDER BY score DESC LIMIT 10 OFFSET 10";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Initialize image position counter
                        $i = 1;
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="user-review2" style="--position: ' . $i . ';
                            --width:450px;
                            --height:200px;
                            --quantity:10">';
                            echo '<div class="profileContainer">';

                            // Fetch the profile picture for the user
                            $sql12 = "SELECT ProfilePicture,Username FROM users WHERE UserID LIKE '" . $row["UserID"] . "'";
                            $result12 = $conn->query($sql12);

                            if ($result12->num_rows > 0) {
                                while ($row12 = $result12->fetch_assoc()) {
                                    echo '<img  src="http://localhost/MiniProject(Aman)/login/' . $row12["ProfilePicture"] . '" alt="">';
                                    echo "<div>";
                                    echo '<h5 class="feedbackname">' . $row["name"] . '</h5>';
                                    echo '<p class="feedbackusername">@' . $row12["Username"] . '</p>';
                                    echo "</div>";
                                }
                            }

                            // Increment image position for next review
                            $i++;

                            // echo '<p class="feedbackusername">' . $row["name"] . '</p>';
                            echo '</div>';

                            echo '<div class="star">';
                            // Use a different loop counter for stars
                            for ($starCount = 0; $starCount < $row["score"]; $starCount++) {
                                echo '<i class="ri-star-fill"></i>';
                            }
                            echo '</div>';

                            echo '<p>' . $row["feedback"] . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo "0 reviews";
                    }

                    $conn->close();
                    ?>
                </div>


            </div>


            <?php include '../footer/footer.php'; ?>
        </div>
    </div>
    <script src="../cdnFiles/lenis.js"></script>
    <script src="../cdnFiles/locomotive-scroll.js"></script>
    <script src="../cdnFiles/gsap.min.js"></script>
    <script src="../cdnFiles/ScrollTrigger.min.js"></script>
    <script src="script.js"></script>
</body>

</html>