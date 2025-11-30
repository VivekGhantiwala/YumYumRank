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
            // console.log("GIF is loaded.");
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
include 'connection.php';

session_start();
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    session_unset();
    session_destroy();
    header("Location: http://localhost/MiniProject(Aman)/client/home/index.php");
    exit();
}
if (isset($_GET['Name'])) {
    $name = urldecode($_GET['Name']);
    $input = htmlspecialchars($name);
    $query = "SELECT * FROM foods WHERE Name LIKE '$input%' ";
} elseif (isset($_GET['category'])) {
    $category = urldecode($_GET['category']);
    $input = htmlspecialchars($category);
    $query = "
        SELECT * FROM foods WHERE CategoryID = (SELECT CategoryID FROM categories WHERE Name LIKE '$input%' LIMIT 1) LIMIT 1";
} else {
    die("No product or category selected.");
}

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
if (isset($_GET['Name'])) {
    $foodName = urldecode($_GET['Name']);
    $foodName = htmlspecialchars($foodName);
    $foodIDQuery = "SELECT FoodID FROM foods WHERE Name = '$foodName' LIMIT 1";
    $result = mysqli_query($conn, $foodIDQuery);
    if ($result && mysqli_num_rows($result) > 0) {
        $foodIDRow = mysqli_fetch_assoc($result);
        $foodID = $foodIDRow['FoodID'];
    } else {
        die("Food not found.");
    }
} elseif (isset($_GET['category'])) {
    $category = urldecode($_GET['category']);
    $input = htmlspecialchars($category);
    $query = "
        SELECT * FROM foods WHERE CategoryID = (SELECT CategoryID FROM categories WHERE Name LIKE '$input%' LIMIT 1) LIMIT 1";
}
if (isset($_POST['ratingsubmit'])) {
    $userID = $_SESSION["user_id"];
    if (isset($_GET['Name'])) {
        $userID = $_SESSION['user_id'];
        $rating = $_POST['rating'];
        $foodName = urldecode($_GET['Name']);
        $foodName = htmlspecialchars($foodName);

        // Fetch the FoodID from the foods table
        $foodIDQuery = "SELECT FoodID FROM foods WHERE Name = '$foodName' LIMIT 1";
        $result = mysqli_query($conn, $foodIDQuery);

        if ($result && mysqli_num_rows($result) > 0) {
            $foodIDRow = mysqli_fetch_assoc($result);
            $foodID = $foodIDRow['FoodID'];
        } else {
            echo "<script>alert('Error fetching FoodID.');</script>";
            exit;
        }

        // Check if the user has already rated this food
        $ratingCheckQuery = "SELECT * FROM ratings WHERE UserID = $userID AND FoodID = $foodID";
        $checkResult = mysqli_query($conn, $ratingCheckQuery);

        if ($checkResult && mysqli_num_rows($checkResult) > 0) {
            echo '
            <div id="popup" style="display: none;">
                <div style="background: #FFCCCB; font-family: GilroyLight, Arial, sans-serif; font-weight: 800; color: #D8000C; padding: 25px; border-radius: 12px; box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3); font-size: 20px; position: fixed; top: 20px; right: 20px; z-index: 10000; display: flex; align-items: center; min-width: 320px;">
                    <span style="margin-right: 15px; font-size: 28px; color: #D8000C;">&#10060;</span> 
                    You have already rated this food item. You cannot rate it again.
                </div>
            </div>
            <script>
                document.getElementById("popup").style.display = "block";
                setTimeout(function() {
                    document.getElementById("popup").style.display = "none";
                }, 3000); 
            </script>';
        } else {
            // Prepare the SQL statement to insert the rating
            $name = $_POST['name'];
            $feedback = $_POST['feedback'];
            $rating = $_POST['rating'];
            $ratingInsertQuery = "INSERT INTO ratings (UserID, FoodID, name, feedback, Score, Date) 
                                  VALUES ($userID, $foodID, '$name', '$feedback', $rating, NOW())";

            // Execute the query
            if (mysqli_query($conn, $ratingInsertQuery)) {
                echo '
                <div id="popup" style="display: none;">
                    <div style="background: #B2EBF2; font-family: GilroyLight, Arial, sans-serif; font-weight: 800; color: #006064; padding: 25px; border-radius: 12px; box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3); font-size: 20px; position: fixed; top: 20px; right: 20px; z-index: 10000; display: flex; align-items: center; min-width: 320px;">
                        <span style="margin-right: 15px; font-size: 28px; color: #2E7D32;">&#10004;</span>
                      Rating submitted successfully!
                    </div>
                </div>
                <script>
                    document.getElementById("popup").style.display = "block";
                    setTimeout(function() {
                        document.getElementById("popup").style.display = "none";
                    }, 3000);
                </script>';
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        }
    } else {
        if (isset($_GET['category'])) {
            // Get the category from the URL
            $category1 = urldecode($_GET['category']);
            $rating = $_POST['rating'];
            $input1 = htmlspecialchars($category1);

            // Prepare the query to get food items based on category
            $query1 = "SELECT * FROM foods WHERE CategoryID = (SELECT CategoryID FROM categories WHERE Name LIKE '$input1%' LIMIT 1) LIMIT 1";
            $result1 = mysqli_query($conn, $query1);

            if ($result1 && mysqli_num_rows($result1) > 0) {
                $row1 = mysqli_fetch_assoc($result1);
                $foodName1 = $row1['Name']; // Use the name from the fetched food item

                // Now proceed to fetch the FoodID using the food name
                $foodIDQuery1 = "SELECT FoodID FROM foods WHERE Name = '$foodName1' LIMIT 1";
                $foodIDResult1 = mysqli_query($conn, $foodIDQuery1);

                if ($foodIDResult1 && mysqli_num_rows($foodIDResult1) > 0) {
                    $foodIDRow1 = mysqli_fetch_assoc($foodIDResult1);
                    $foodID1 = $foodIDRow1['FoodID'];
                } else {
                    echo "<script>alert('Error fetching FoodID.');</script>";
                    exit;
                }

                // Check if the user has already rated this food
                $ratingCheckQuery1 = "SELECT * FROM ratings WHERE UserID = $userID AND FoodID = $foodID1";
                $checkResult1 = mysqli_query($conn, $ratingCheckQuery1);

                if ($checkResult1 && mysqli_num_rows($checkResult1) > 0) {
                    echo '
                    <div id="popup" style="display: none;">
                        <div style="background: #FFCCCB; font-family: GilroyLight, Arial, sans-serif; font-weight: 800; color: #D8000C; padding: 25px; border-radius: 12px; box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3); font-size: 20px; position: fixed; top: 20px; right: 20px; z-index: 10000; display: flex; align-items: center; min-width: 320px;">
                            <span style="margin-right: 15px; font-size: 28px; color: #D8000C;">&#10060;</span> 
                            You have already rated this food item. You cannot rate it again.
                        </div>
                    </div>
                    <script>
                        document.getElementById("popup").style.display = "block";
                        setTimeout(function() {
                            document.getElementById("popup").style.display = "none";
                        }, 3000); 
                    </script>';
                } else {
                    // Prepare the SQL statement to insert the rating
                    $name1 = $_POST['name'];
                    $feedback1 = $_POST['feedback'];
                    $ratingInsertQuery1 = "INSERT INTO ratings (UserID, FoodID, name, feedback, Score, Date) 
                                            VALUES ($userID, $foodID1, '$name1', '$feedback1', $rating, NOW())";

                    // Execute the query
                    if (mysqli_query($conn, $ratingInsertQuery1)) {
                        echo '
                        <div id="popup" style="display: none;">
                            <div style="background: #B2EBF2; font-family: GilroyLight, Arial, sans-serif; font-weight: 800; color: #006064; padding: 25px; border-radius: 12px; box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3); font-size: 20px; position: fixed; top: 20px; right: 20px; z-index: 10000; display: flex; align-items: center; min-width: 320px;">
                                <span style="margin-right: 15px; font-size: 28px; color: #2E7D32;">&#10004;</span>
                                Rating submitted successfully!
                            </div>
                        </div>
                        <script>
                            document.getElementById("popup").style.display = "block";
                            setTimeout(function() {
                                document.getElementById("popup").style.display = "none";
                            }, 3000);
                        </script>';
                    } else {
                        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
                    }
                }
            } else {
                echo "<script>alert('No foods found in this category.');</script>";
            }
        } else {
            echo "<script>alert('No category specified.');</script>";
        }
    }



}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../cdnFiles/remixicon.css" rel="stylesheet" />
    <title>Alternative</title>
    <link rel="stylesheet" href="../cdnFiles/locomotive-scroll.css">
    <link href="../cdnFiles/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="../cdnFiles/tailwind.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../asset/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="main">
        <div id="toastMessage" class="toast">
            <span id="toastContent"></span>
        </div>
        <div class="page1" data-scroll data-scroll-speed="-3.5">
            <?php include '../header/header.php'; ?>
            <section>
                <div class="recently-added">
                    <?php
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $pname = htmlspecialchars($row['Name']);
                            $imagePath = $row['Image'];
                            $description = $row['Description'];
                            $score = $row['HealthScore'];
                            $price = $row['Price'];
                            $about = $row['about'];
                            $product_url = $row['product_url'];
                            echo '<div class="recently-product" >';

                            echo '<div class="recently-image-container">';
                            echo '<img loading="lazy" src="../asset/products/' . $imagePath . '" alt="' . $pname . '">';
                            echo '</div>';
                            echo '
                            <div class="product-data">
                            <h1>' . $pname . '</h1> ';
                            echo '<script>
                            document.addEventListener("DOMContentLoaded", function() {
                                let productname = "' . addslashes($pname) . '";
                                let latestReviewHeader = document.querySelector(".page3 .productname");
                                if (latestReviewHeader) {
                                    latestReviewHeader.innerHTML ="Reviews about " + productname;
                                }
                            });
                            </script>';
                            echo '
                            <h5>' . $description . '</h5>  
                    
                            <div class="price">
                            <h2>$' . $price . '</h2>
                            <p></p>
                            </div>
                
                            <button class="btn btn-dark text-light w-100 class="centerBtn" "><a href="' . $product_url . '" >Buy Now</a></button>
                            <form method="post">
                            <input type="submit" class="btn btn-dark text-light w-100 mt-2 class="centerBtn" value="Add to Favourites" name="like""></input>
                            </form>
                            <div class="about-item">
                            <h4>About the item</h4>
                            <li>' . $about . '</li>
                           
<!-- Rate This Product Button -->






                            
                            </div>
                            </div>
                            ';
                            echo '</div>';
                            break;
                        }
                    } else {
                        echo '<p>No Recent Product.</p>';
                    }
                    ?>
                </div>

        </div>
        <div class="page2" data-scroll data-scroll-speed="1">
            <div class="product-bottom">
                <div class="Product-details">
                    <h4>Product Details</h4>
                    <?php
                    $query = "SELECT * FROM foods WHERE Name LIKE '%$input%' ";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $pname = htmlspecialchars($row['Name']);
                            $description = htmlspecialchars($row['Description']);
                            $price = htmlspecialchars($row['Price']);

                            echo '
        <h6><span>Name: </span>' . $pname . '</h6>
        <h6><span>Description: </span>' . $description . '</h6>
        <h6><span>Price: </span>$' . $price . '</h6>
        ';
                            break;
                        }

                    } else {
                        $category_name = urldecode($_GET['category']);
                        $category_name = htmlspecialchars($category_name);

                        $category_query = "SELECT CategoryID FROM Categories WHERE Name = '$category_name' LIMIT 1";
                        $category_result = mysqli_query($conn, $category_query);

                        // echo $category_result;
                        if (mysqli_num_rows($category_result) > 0) {
                            $category_row = mysqli_fetch_assoc($category_result);
                            $category_id = $category_row['CategoryID'];


                            $query = "SELECT * FROM foods WHERE CategoryID = '$category_id' LIMIT 1";
                            $result = mysqli_query($conn, $query);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $pname = htmlspecialchars($row['Name']);
                                    $description = htmlspecialchars($row['Description']);
                                    $price = htmlspecialchars($row['Price']);

                                    echo '
        <h6><span>Name: </span>' . $pname . '</h6>
                                    <h6><span>Name: </span>' . $pname . '</h6>
                                    <h6><span>Description: </span>' . $description . '</h6>
                                    <h6><span>Price: </span>$' . $price . '</h6>
                                    ';
                                    break;
                                }
                            } else {
                                echo '<p>No food details found for this category.</p>';
                            }
                        } else {
                            echo '<p>Category not found.</p>';
                        }

                    }
                    ?>
                </div>
                <div class="Nutritional-information">
                    <?php
                    echo '
                    <h4>Nutritional Information</h4>
                    ';
                    $query = "SELECT foods.FoodID, n.Calories, n.Proteins, n.Carbs, n.Vitamins, n.Minerals, n.Fats 
                    FROM foods 
                    JOIN Nutritional_Info n ON foods.FoodID = n.FoodID
                    WHERE Foods.Name LIKE '$input%' 
                    LIMIT 0, 25";

                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $calories = $row['Calories'];
                            $protein = $row['Proteins'];
                            $carbs = $row['Carbs'];
                            $vitamins = $row['Vitamins'];
                            $minerals = $row['Minerals'];
                            $totalFat = $row['Fats'];
                            echo '
                             <h6><span>Calories: </span>' . $calories . 'g</h6>
                             <h6><span>Protein: </span>' . $protein . 'g</h6>
                             <h6><span>Carbs: </span>' . $carbs . 'g</h6>
                             <h6><span>Vitamins: </span>' . $vitamins . 'g</h6>
                             <h6><span>Minerals: </span>' . $minerals . 'g</h6>
                             <h6><span>Total Fat: </span>' . $totalFat . 'g</h6>
                            ';

                        }
                    } else {
                        $category_name = urldecode($_GET['category']);
                        $category_name = htmlspecialchars($category_name);

                        $category_query = "SELECT CategoryID FROM Categories WHERE Name = '$category_name' LIMIT 1";
                        $category_result = mysqli_query($conn, $category_query);

                        if (mysqli_num_rows($category_result) > 0) {
                            $category_row = mysqli_fetch_assoc($category_result);
                            $category_id = $category_row['CategoryID'];

                            $food_query = "SELECT * FROM foods WHERE CategoryID = '$category_id' LIMIT 1";
                            $food_result = mysqli_query($conn, $food_query);

                            if (mysqli_num_rows($food_result) > 0) {
                                while ($row = mysqli_fetch_assoc($food_result)) {
                                    $pname = htmlspecialchars($row['Name']);
                                    $description = htmlspecialchars($row['Description']);
                                    $price = htmlspecialchars($row['Price']);
                                    $food_id = $row['FoodID'];
                                    break;
                                }

                                $nutritional_query = "SELECT * FROM Nutritional_Info WHERE FoodID = '$food_id'";
                                $nutritional_result = mysqli_query($conn, $nutritional_query);

                                if (mysqli_num_rows($nutritional_result) > 0) {
                                    while ($row = mysqli_fetch_assoc($nutritional_result)) {
                                        $calories = $row['Calories'];
                                        $protein = $row['Proteins'];
                                        $carbs = $row['Carbs'];
                                        $vitamins = $row['Vitamins'];
                                        $minerals = $row['Minerals'];
                                        $totalFat = $row['Fats'];

                                        echo '
                                        <h6><span>Calories: </span>' . $calories . 'g</h6>
                                        <h6><span>Protein: </span>' . $protein . 'g</h6>
                                        <h6><span>Carbs: </span>' . $carbs . 'g</h6>
                                        <h6><span>Vitamins: </span>' . $vitamins . 'g</h6>
                                        <h6><span>Minerals: </span>' . $minerals . 'g</h6>
                                        <h6><span>Total Fat: </span>' . $totalFat . 'g</h6>
                                        ';
                                    }
                                } else {
                                    echo '<p>No nutritional information found for this product.</p>';
                                }
                            } else {
                                echo '<p>No food details found for this category.</p>';
                            }
                        } else {
                            echo '<p>Category not found.</p>';
                        }
                    }

                    ?>
                </div>

                <div class="Health-impact">
                    <?php
                    echo '<h4>Health Impact of Ingredients</h4>';

                    $query = "SELECT i.Name AS IngredientName, i.description, i.HealthImpact
          FROM Foods f
          JOIN Food_Ingredients fi ON f.FoodID = fi.FoodID
          JOIN Ingredients i ON fi.IngredientID = i.IngredientID
          WHERE f.Name LIKE '$input%'";

                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        if ($row = mysqli_fetch_assoc($result)) {
                            $ingredientName = htmlspecialchars($row['IngredientName']);
                            $description = htmlspecialchars($row['description']);
                            $healthImpact = htmlspecialchars($row['HealthImpact']);

                            echo '
            <h6><span>' . $ingredientName . ':</span> ' . $description . '</h6>
            <h6><span>Health Impact:</span> ' . $healthImpact . '</h6>
        ';
                        }
                    } else {
                        $category_name = urldecode($_GET['category']);
                        $category_name = htmlspecialchars($category_name);

                        $category_query = "SELECT CategoryID FROM Categories WHERE Name = '$category_name' LIMIT 1";
                        $category_result = mysqli_query($conn, $category_query);

                        if (mysqli_num_rows($category_result) > 0) {
                            $category_row = mysqli_fetch_assoc($category_result);
                            $category_id = $category_row['CategoryID'];

                            $food_query = "SELECT * FROM foods WHERE CategoryID = '$category_id' LIMIT 1";
                            $food_result = mysqli_query($conn, $food_query);

                            if (mysqli_num_rows($food_result) > 0) {
                                while ($row = mysqli_fetch_assoc($food_result)) {
                                    $food_id = $row['FoodID'];
                                    break;
                                }

                                $ingredients_query = "SELECT i.Name, i.description ,i.HealthImpact
                                                      FROM Ingredients i 
                                                      JOIN Food_Ingredients fi ON i.IngredientID = fi.IngredientID 
                                                      WHERE fi.FoodID = '$food_id'";
                                $ingredients_result = mysqli_query($conn, $ingredients_query);

                                if (mysqli_num_rows($ingredients_result) > 0) {
                                    if ($row = mysqli_fetch_assoc($ingredients_result)) {
                                        $ingredient_name = htmlspecialchars($row['Name']);
                                        $description = htmlspecialchars($row['description']);
                                        $health_impact = htmlspecialchars($row['HealthImpact']);
                                        echo '
                                        <h6><span>' . $ingredient_name . ': </span>' . $description . '</h6>
                                        <h6><span>Health Impact: </span>' . $health_impact . '</h6>
                                        ';
                                    }
                                } else {
                                    echo '<p>No health impact information found for ingredients in this product.</p>';
                                }
                            } else {
                                echo '<p>No food details found for this category.</p>';
                            }
                        } else {
                            echo '<p>Category not found.</p>';
                        }
                    }
                    ?>
                </div>
                <div class="Health-score">
                    <h4>Health Score</h4>
                    <div class="score">
                        <?php
                        $query = "SELECT * FROM foods WHERE Name LIKE '$input%' ";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $score = $row['HealthScore'];
                            echo '<h1 id="score">' . $score . '.0</h1>';
                        } else {
                            $category_name = urldecode($_GET['category']);
                            $category_name = htmlspecialchars($category_name);

                            $category_query = "SELECT CategoryID FROM Categories WHERE Name = '$category_name' LIMIT 1";
                            $category_result = mysqli_query($conn, $category_query);

                            if (mysqli_num_rows($category_result) > 0) {
                                $category_row = mysqli_fetch_assoc($category_result);
                                $category_id = $category_row['CategoryID'];

                                $food_query = "SELECT * FROM foods WHERE CategoryID = '$category_id' LIMIT 1";
                                $food_result = mysqli_query($conn, $food_query);

                                if (mysqli_num_rows($food_result) > 0) {
                                    $row = mysqli_fetch_assoc($food_result);
                                    $food_id = $row['FoodID'];
                                    $food_name = htmlspecialchars($row['Name']);
                                    $food_health_score = htmlspecialchars($row['HealthScore']);

                                    echo '<h1 id="score">' . $food_health_score . '.0</h1>';
                                } else {
                                    echo '<p>No food details found for this category.</p>';
                                }
                            } else {
                                echo '<p>Category not found.</p>';
                            }
                        }
                        ?>

                        <p id="score-text"></p>
                    </div>

                </div>
            </div>
            <div class="alternative">
                <div style="
    height: 10px;
" class="products">
                    <section>
                        <div class="top-added">
                            <div class="header-section2">
                                <h2 class="heading">Alternatives</h2>
                            </div>
                            <div class="move2">
                                <?php

                                // $name = urldecode($_GET['category']);
                                // $input = htmlspecialchars($name);
                                
                                $query = "SELECT FoodID, Name, Description, Price, Image, HealthScore FROM foods WHERE FoodID IN (SELECT AlternativeFoodID FROM alternatives WHERE OriginalFoodID = (SELECT FoodID FROM foods WHERE Name LIKE '$input%'))";
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
                                        echo '<img loading="lazy" src="../asset/products/' . $imagePath . '" alt="' . $pname . '">';
                                        echo '<svg version="1.1" id="Layer_1" xmlns=http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="190px" height="100px" viewBox="0 0 368 480" enable-background="new 0 0 368 480" xml:space="preserve" class="score-tag"> <path  fill="#008c3e" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"d="M107.000000,6.000000 C100.691673,8.341979 98.893227,12.949043 98.899132,19.500092 
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
                                        '
  </text>
  
</svg>
';

                                        echo '</div>';
                                        echo '<h1>' . $pname . '</h1>';
                                        echo "<p>" . $description . "</p>";
                                        echo '</a>';
                                        echo '</div>';
                                    }
                                } else {
                                    $category_name = urldecode($_GET['category']);
                                    $category_name = htmlspecialchars($category_name);

                                    $category_query = "SELECT CategoryID FROM Categories WHERE Name = '$category_name' LIMIT 1";
                                    $category_result = mysqli_query($conn, $category_query);

                                    if (mysqli_num_rows($category_result) > 0) {
                                        $category_row = mysqli_fetch_assoc($category_result);
                                        $category_id = $category_row['CategoryID'];

                                        $food_query = "SELECT FoodID FROM foods WHERE CategoryID = '$category_id'";
                                        $food_result = mysqli_query($conn, $food_query);

                                        if (mysqli_num_rows($food_result) > 0) {
                                            while ($row = mysqli_fetch_assoc($food_result)) {
                                                $food_id = $row['FoodID'];

                                                $alternatives_query = "SELECT f.FoodID, f.Name, f.Description, f.Price, f.Image, f.HealthScore 
                                                                       FROM foods f 
                                                                       WHERE f.FoodID IN (
                                                                           SELECT a.AlternativeFoodID 
                                                                           FROM alternatives a 
                                                                           WHERE a.OriginalFoodID = '$food_id'
                                                                       )";
                                                $alternatives_result = mysqli_query($conn, $alternatives_query);

                                                if (mysqli_num_rows($alternatives_result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($alternatives_result)) {
                                                        $pname = htmlspecialchars($row['Name']);
                                                        $imagePath = $row['Image'];
                                                        $description = htmlspecialchars($row['Description']);
                                                        $score = htmlspecialchars($row['HealthScore']);

                                                        echo '<div class="top-product">';
                                                        echo '<a href="../alternative-page/alternative.php?Name=' . urlencode($pname) . '">';
                                                        echo '<div class="top-image-container">';
                                                        echo '<img loading="lazy" src="../asset/products/' . $imagePath . '" alt="' . $pname . '">';
                                                        echo '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="190px" height="100px" viewBox="0 0 368 480" enable-background="new 0 0 368 480" xml:space="preserve" class="score-tag"> 
                                                            <path fill="#008c3e" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M107.000000,6.000000 C100.691673,8.341979 98.893227,12.949043 98.899132,19.500092 C99.030807,165.499969 99.000000,311.500000 99.000000,457.500000 C99.000000,464.948303 101.434715,469.330811 106.500000,471.000000 C110.931488,472.460358 116.046860,469.889008 119.988075,463.992035 C136.349777,439.510986 152.674362,415.005127 168.994720,390.496490 C173.196518,384.186554 177.288284,377.803101 181.512497,371.508362 C185.852539,365.040985 190.657471,365.004700 194.983139,371.511200 C215.354340,402.152679 235.642380,432.849548 256.055145,463.463226 C257.402710,465.484131 258.701904,467.558990 260.938110,469.090363 C267.610413,473.659454 276.698730,469.719208 277.980530,460.997131 C278.124390,460.018280 278.000000,459.000000 278.000000,458.000000 C278.000000,311.666656 278.000000,165.333328 278.000000,19.000000 C278.000000,10.026446 273.973541,5.999999 265.000000,5.999999 C212.500000,6.000000 160.000000,6.000000 107.500000,6.000000"/>
                                                            <text x="42%" y="30%" text-anchor="middle" fill="#f5f5dc" font-size="90" font-family="Arial" dy=".3em">';
                                                        echo $score;
                                                        echo '</text>
                                                        </svg>
                                                        </div>';
                                                        echo '<h1>' . $pname . '</h1>';
                                                        echo "<p>" . $description . "</p>";
                                                        echo '</a>';
                                                        echo '</div>';
                                                    }
                                                }
                                            }
                                        } else {
                                            echo '<p>No food details found for this category.</p>';
                                        }
                                    } else {
                                        echo '<p>Category not found.</p>';
                                    }
                                }

                                ?>
                            </div>
                            <div class="suggestion">
                                <div class="header-section2">
                                    <h2 class="heading">More Products</h2>
                                </div>
                                <div class="move3">
                                    <?php

                                    $query = "SELECT * FROM foods ORDER BY created_at desc";
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
                                            echo '<img loading="lazy" src="../asset/products/' . $imagePath . '" alt="' . $pname . '">';
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
                                            '
      </text>
      
    </svg>
    ';
                                            echo '</div>';
                                            echo '<h1>' . $pname . '</h1>';
                                            echo "<p>" . $description . "</p>";
                                            echo '</a>';
                                            echo '</div>';
                                        }
                                    } else {
                                        $query = "SELECT * FROM foods ORDER BY HealthScore";
                                        $result = mysqli_query($conn, $query);

                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $pname = htmlspecialchars($row['Name']);
                                                $imagePath = $row['Image'];
                                                $description = htmlspecialchars($row['Description']);
                                                $score = htmlspecialchars($row['HealthScore']);
                                                echo '<div class="top-product">';
                                                echo '<a href="../alternative-page/alternative.php?Name=' . urlencode($pname) . '">';
                                                echo '<div class="top-image-container">';
                                                echo '<img loading="lazy" src="../asset/products/' . $imagePath . '" alt="' . $pname . '">';
                                                echo '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="190px" height="100px" viewBox="0 0 368 480" enable-background="new 0 0 368 480" xml:space="preserve" class="score-tag"> 
                                                    <path fill="#008c3e" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M107.000000,6.000000 C100.691673,8.341979 98.893227,12.949043 98.899132,19.500092 C99.030807,165.499969 99.000000,311.500000 99.000000,457.500000 C99.000000,464.948303 101.434715,469.330811 106.500000,471.000000 C110.931488,472.460358 116.046860,469.889008 119.988075,463.992035 C136.349777,439.510986 152.674362,415.005127 168.994720,390.496490 C173.196518,384.186554 177.288284,377.803101 181.512497,371.508362 C185.852539,365.040985 190.657471,365.004700 194.983139,371.511200 C215.354340,402.152679 235.642380,432.849548 256.055145,463.463226 C257.402710,465.484131 258.701904,467.558990 260.938110,469.090363 C267.610413,473.659454 276.698730,469.719208 277.980530,460.997131 C278.124390,460.018280 278.000000,459.000000 278.000000,458.000000 C278.000000,311.666656 278.000000,165.333328 278.000000,19.000000 C278.000000,10.026446 273.973541,5.999999 265.000000,5.999999 C212.500000,6.000000 160.000000,6.000000 107.500000,6.000000"/>
                                                    <text x="42%" y="30%" text-anchor="middle" fill="#f5f5dc" font-size="90" font-family="Arial" dy=".3em">';
                                                echo $score;
                                                echo '</text>
                                                </svg>
                                                </div>';
                                                echo '<h1>' . $pname . '</h1>';
                                                echo "<p>" . $description . "</p>";
                                                echo '</a>';
                                                echo '</div>';
                                            }
                                        } else {
                                            echo '<p>No products available.</p>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="page3">
            <div class="reviews" style="
        --width:550px;
        --height:230px;
        --quantity:10;
    ">
                <div class="latest-review-header">
                    <div class="leftHeading">
                        <h2 class="productname"></h2>
                    </div>
                    <div class="rightHeading">

                        <!-- Popup for Rating -->
                        <button style="
    margin: 0 35px 0 0;
    font-family:GilroyLight;
    font-weight:600;
" id="openRatingPopupBtn"
                            class="bg-green-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-green-700 transition duration-200">
                            Rate This Product
                        </button>
                    </div>
                    <div id="ratingPopup" class="fixed left-0 w-full  hidden flex justify-center items-center Popup">
                        <div class="bg-white rounded-lg p-6 shadow-lg relative reviewForm"
                            style="width: 500px; height: auto;">

                            <span id="closePopupBtn" class="absolute top-2 right-2 text-3xl cursor-pointer"
                                style="margin: -9px -6px; font-size: 35px;">&times;</span>
                            <h4 class="text-lg font-semibold mb-4">Rate this product:</h4>

                            <!-- Form for rating -->
                            <form id="ratingForm" action="" method="POST">
                                <!-- Name field -->
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Your Name:</label>
                                    <input type="text" id="name" name="name" 
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <!-- Feedback field -->
                                <div class="mb-4">
                                    <label for="feedback" class="block text-sm font-medium text-gray-700">Your
                                        Feedback:</label>
                                    <textarea id="feedback" name="feedback" rows="3" 
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                                </div>

                                <!-- Rating stars -->
                                <div class="flex items-center mb-4" id="ratingStars">
                                    <p style="color: white;">Rating :</p>
                                    <input type="radio" id="unique-star1-007" name="rating" value="1" class="hidden" />
                                    <label for="unique-star1-007" title="1 star"
                                        class=" text-2xl cursor-pointer text-gray-400 hover:text-yellow-500 ratingstar star">★</label>

                                    <input type="radio" id="unique-star2-010" name="rating" value="2" class="hidden" />
                                    <label for="unique-star2-010" title="2 stars"
                                        class=" text-2xl cursor-pointer text-gray-400 hover:text-yellow-500 ratingstar star">★</label>

                                    <input type="radio" id="unique-star3-012" name="rating" value="3" class="hidden" />
                                    <label for="unique-star3-012" title="3 stars"
                                        class=" text-2xl cursor-pointer text-gray-400 hover:text-yellow-500 ratingstar star">★</label>

                                    <input type="radio" id="unique-star4-014" name="rating" value="4" class="hidden" />
                                    <label for="unique-star4-014" title="4 stars"
                                        class=" text-2xl cursor-pointer text-gray-400 hover:text-yellow-500 ratingstar star">★</label>

                                    <input type="radio" id="unique-star5-016" name="rating" value="5" class="hidden" />
                                    <label for="unique-star5-016" title="5 stars"
                                        class=" text-2xl cursor-pointer text-gray-400 hover:text-yellow-500 ratingstar star">★</label>
                                </div>

                                <!-- Submit button -->
                                <button type="submit" name="ratingsubmit"
                                    class="mt-4 bg-green-600 text-white py-2 px-4 rounded-lg w-full hover:bg-green-700 transition duration-200">
                                    Submit Rating
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- <img src="http://localhost/MiniProject(Aman)/login/uploads/profile_pictures/670e033adfec6.jpg" alt=""> -->
                <div class="review-panel">
                    <?php
                    include 'connection.php';

                    // Fetch top 10 reviews
                    if (isset($_GET['Name'])) {

                        $foodName = urldecode($_GET['Name']);
                        $foodName = htmlspecialchars($foodName);
                        $foodIDQuery = "SELECT FoodID FROM foods WHERE Name = '$foodName' LIMIT 1";
                        $result = mysqli_query($conn, $foodIDQuery);
                        if ($result && mysqli_num_rows($result) > 0) {
                            $foodIDRow = mysqli_fetch_assoc($result);
                            $foodID = $foodIDRow['FoodID'];
                        } else {
                            die("Food not found.");
                        }
                        $sql = "SELECT name, feedback, score,UserID FROM ratings where FoodId = $foodID ORDER BY score DESC LIMIT 20 ";
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
                    } else {
                        $category = urldecode($_GET['category']);
                        $input = htmlspecialchars($category);

                        // Prepare the query to get food items based on category
                        $query = "SELECT * FROM foods WHERE CategoryID = (SELECT CategoryID FROM categories WHERE Name LIKE ? LIMIT 1) LIMIT 1";
                        $stmt = $conn->prepare($query);
                        $likeInput = $input . '%';
                        $stmt->bind_param('s', $likeInput);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // echo "" . htmlspecialchars($row["Name"]) . "";
                    
                                // Prepare the food ID query using the fetched food name
                                $foodIDQuery = "SELECT FoodID FROM foods WHERE Name = ? LIMIT 1";
                                $foodIDStmt = $conn->prepare($foodIDQuery);
                                $foodName = $row['Name'];
                                $foodIDStmt->bind_param('s', $foodName);
                                $foodIDStmt->execute();
                                $foodIDResult = $foodIDStmt->get_result();

                                if ($foodIDResult && $foodIDResult->num_rows > 0) {
                                    $foodIDRow = $foodIDResult->fetch_assoc();
                                    $foodID = $foodIDRow['FoodID'];
                                } else {
                                    die("Food not found.");
                                }
                            }
                        } else {
                            die("No foods found for the specified category.");
                        }

                        // Fetch ratings based on the FoodID
                        $sql = "SELECT name, feedback, score, UserID FROM ratings WHERE FoodID = ? ORDER BY score DESC LIMIT 20";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param('i', $foodID);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            // Initialize image position counter
                            $i = 1;

                            // Output data of each row
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="user-review" style="--position: ' . $i . '">';
                                echo '<div class="profileContainer">';

                                $sql12 = "SELECT ProfilePicture, Username FROM users WHERE UserID = ?";
                                $stmt12 = $conn->prepare($sql12);
                                $stmt12->bind_param('i', $row["UserID"]);
                                $stmt12->execute();
                                $result12 = $stmt12->get_result();

                                if ($result12->num_rows > 0) {
                                    while ($row12 = $result12->fetch_assoc()) {
                                        echo '<img loading="lazy" src="http://localhost/MiniProject(Aman)/login/' . htmlspecialchars($row12["ProfilePicture"]) . '" alt="">';
                                        echo "<div>";
                                        echo '<h5 class="feedbackname">' . htmlspecialchars($row["name"]) . '</h5>';
                                        echo '<p class="feedbackusername">@' . htmlspecialchars($row12["Username"]) . '</p>';
                                        echo "</div>";
                                    }
                                }

                                // Increment image position for the next review
                                $i++;

                                echo '</div>';

                                echo '<div class="star">';
                                // Use a different loop counter for stars
                                for ($starCount = 0; $starCount < $row["score"]; $starCount++) {
                                    echo '<i class="ri-star-fill"></i>';
                                }
                                echo '</div>';

                                echo '<p>' . htmlspecialchars($row["feedback"]) . '</p>';
                                echo '</div>';
                            }
                        } else {
                            echo "0 reviews";
                        }
                    }


                    $conn->close();
                    ?>
                </div>

            </div>
            <?php include '../footer/footer.php'; ?>
        </div>






        <script src="../cdnFiles/locomotive-scroll.js"></script>
        <script src="../cdnFiles/gsap.min.js"></script>
        <script src="../cdnFiles/ScrollTrigger.min.js"></script>
        <script src="script.js" defer></script>

        <?php
        include './connection.php';
        if (isset($_POST['like'])) {
            // Assuming you have the user ID stored in session or retrieved somehow
            $user_id = $_SESSION['user_id']; // Replace with the actual user ID
        
            // Retrieve the product name from the URL and sanitize the input
            $name = urldecode($_GET['Name']);
            $input = htmlspecialchars($name);

            // Fetch FoodID based on the product name from the 'foods' table
            $query = "SELECT FoodID FROM foods WHERE Name LIKE '$input%' LIMIT 1";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                // Get the FoodID from the result
                $row = mysqli_fetch_assoc($result);
                $food_id = $row['FoodID'];

                // Check if the user already liked the product
                $check_like_query = "SELECT * FROM user_likes WHERE user_id = $user_id AND food_id = $food_id";
                $check_like_result = mysqli_query($conn, $check_like_query);

                if (mysqli_num_rows($check_like_result) > 0) {
                    // echo "<script>alert('');</script>";
                    echo '
                    <div id="popup" style="display: none;">
                        <div style="background: #FFCDD2; font-family: GilroyLight; font-weight: 800; color: #B71C1C; padding: 20px; border-radius: 12px; box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3); font-size: 20px; position: fixed; top: 20px; right: 20px; z-index: 10000; display: flex; align-items: center; min-width: 320px;">
                            <span style="margin-right: 15px; font-size: 28px; color: #B71C1C;">&#10004;</span> <!-- Checkmark icon -->
                            The product is already added.
                        </div>
                    </div>
                    <script>
                        document.getElementById("popup").style.display = "block";
                        setTimeout(function() {
                            document.getElementById("popup").style.display = "none";
                        }, 3000); // Hide after 3 seconds
                    </script>';


                } else {
                    // Insert into user_likes table
                    $like_query = "INSERT INTO user_likes (user_id, food_id) VALUES ($user_id, $food_id)";
                    if (mysqli_query($conn, $like_query)) {
                        // echo "<script>alert('');</script>";
                        echo '
                        <div id="popup" style="display: none;">
                            <div style="background: #B2EBF2; font-family: GilroyLight, Arial, sans-serif; font-weight: 800; color: #006064; padding: 25px; border-radius: 12px; box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3); font-size: 20px; position: fixed; top: 20px; right: 20px; z-index: 1000; display: flex; align-items: center; min-width: 320px;">
                                <span style="margin-right: 15px; font-size: 28px; color: #2E7D32;">&#10004;</span> <!-- Success icon (checkmark) in dark green -->
                                Product added to favorites.
                            </div>
                        </div>
                        <script>
                            document.getElementById("popup").style.display = "block";
                            setTimeout(function() {
                                document.getElementById("popup").style.display = "none";
                            }, 4000); // Hide after 3 seconds
                            
                        </script>';



                    } else {
                        echo "<script>alert('Failed to add product. Please try again.');</script>";
                    }
                }
            } else {
                echo "<script>alert('Product not found.');</script>";
            }
        }


        ?>

</body>

</html>