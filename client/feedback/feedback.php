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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="../cdnFiles/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="../cdnFiles/locomotive-scroll.css">
    <link href="../cdnFiles/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="shortcut icon" href="../asset/logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Feedback</title>
</head>

<body>
    <div class="main">
        <div class="page1">
            <?php include '../header/header.php'; ?>
            <div class="flex items-center justify-center min-h-screen">
                <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-md shadow-lg">
                    <h2 class="mb-8 text-2xl font-bold text-center text-gray-800 space-y-6">Feedback Form</h2>
                    <form method="POST" action="" id="feedbackForm">
                        <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Name</label>
                            <input type="text" id="name" name="name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter your name">
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email
                                address</label>
                            <input type="email" id="email" name="email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter your email">
                        </div>
                        <div class="mb-4">
                            <label for="feedback" class="block mb-2 text-sm font-medium text-gray-700">Feedback</label>
                            <textarea id="feedback" name="feedback" rows="6"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter your feedback"></textarea>
                        </div>

                        <!-- Rating Score Field -->
                        <div class="mb-4">
                            <div class="flex items-center">
                                <label for="rating"
                                    class="inline-block w-auto font-medium text-gray-700 mr-2">Rating:</label>
                                <div class="rating flex justify-start items-center">
                                    <input type="radio" id="star5" name="rating" value="5" class="hidden" />
                                    <label for="star5" title="5 stars"
                                        class="text-2xl cursor-pointer text-gray-400 hover:text-yellow-500">★</label>
                                    <input type="radio" id="star4" name="rating" value="4" class="hidden" />
                                    <label for="star4" title="4 stars"
                                        class="text-2xl cursor-pointer text-gray-400 hover:text-yellow-500">★</label>
                                    <input type="radio" id="star3" name="rating" value="3" class="hidden" />
                                    <label for="star3" title="3 stars"
                                        class="text-2xl cursor-pointer text-gray-400 hover:text-yellow-500">★</label>
                                    <input type="radio" id="star2" name="rating" value="2" class="hidden" />
                                    <label for="star2" title="2 stars"
                                        class="text-2xl cursor-pointer text-gray-400 hover:text-yellow-500">★</label>
                                    <input type="radio" id="star1" name="rating" value="1" class="hidden" />
                                    <label for="star1" title="1 star"
                                        class="text-2xl cursor-pointer text-gray-400 hover:text-yellow-500">★</label>
                                </div>
                            </div>
                        </div>


                        <div class="text-center mt-4">
                            <input type="submit" name="submit"
                                class="px-3 py-1 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        </div>
                    </form>

                </div>
            </div>
            <?php
            include 'connection.php';
            if (isset($_POST['submit'])) {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $feedback = $_POST['feedback'];
                $rating = $_POST['rating'];
                $user_id = $_SESSION['user_id'];

                $sql = "INSERT INTO reviews (UserID,name, email, feedback , score) VALUES ('$user_id','$name', '$email', '$feedback','$rating')";

                if (mysqli_query($conn, $sql)) {
                    echo '
    <div id="popup" style="display: none;">
        <div style="background: #B2EBF2; font-family: GilroyLight, Arial, sans-serif; font-weight: 800; color: #006064; padding: 25px; border-radius: 12px; box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3); font-size: 20px; position: fixed; top: 20px; right: 20px; z-index: 10000; display: flex; align-items: center; min-width: 320px;">
            <span style="margin-right: 15px; font-size: 28px; color: #2E7D32;">&#10004;</span> <!-- Success icon (checkmark) in dark green -->
           Feedback submitted successfully!
        </div>
    </div>
    <script>
        document.getElementById("popup").style.display = "block";
        setTimeout(function() {
            window.location.href = "../home/index.php";
        }, 1000); // Redirect after 3 seconds
    </script>';
                    // echo "<script>alert('');</script>";
                    // echo "<script>window.location.href = '../home/index.php';</script>";
                } else {
                    echo "<script>alert('Error: " . $sql . "<br>" . mysqli_error($conn) . "');</script>";
                }
            }
            ?>
        </div>
    </div>
    <script src="../cdnFiles/gsap.min.js"></script>
    <script src="../cdnFiles/locomotive-scroll.js"></script>
    <script>
        document.querySelector('form').addEventListener('submit', function (event) {
            const nameInput = document.getElementById('name').value;
            const emailInput = document.getElementById('email').value;
            const feedbackInput = document.getElementById('feedback').value;
            const ratingInputs = document.querySelectorAll('input[name="rating"]');
            let isRatingSelected = false;

            // Check if name is empty
            if (nameInput.trim() === '') {
                alert('Name field cannot be empty.');
                event.preventDefault();
                return;
            }

            // Check if email is empty
            if (emailInput.trim() === '') {
                alert('Email field cannot be empty.');
                event.preventDefault();
                return;
            }

            // Check if feedback is empty
            if (feedbackInput.trim() === '') {
                alert('Feedback field cannot be empty.');
                event.preventDefault();
                return;
            }

            // Check if rating is selected
            for (let i = 0; i < ratingInputs.length; i++) {
                if (ratingInputs[i].checked) {
                    isRatingSelected = true;
                    break;
                }
            }
            if (!isRatingSelected) {
                alert('Please select a rating.');
                event.preventDefault();
                return;
            }

            const nameRegex = /[a-zA-Z]/;
            if (!nameRegex.test(nameInput)) {
                alert('Name should contain at least one character and not be only numbers.');
                event.preventDefault();
                return;
            }

            const feedbackWords = feedbackInput.trim().split(/\s+/);
            if (feedbackInput.length <= 10 || feedbackWords.length <= 3) {
                alert('Feedback should be more than 10 characters and more than 3 words.');
                event.preventDefault();
                return;
            }
        });
    </script>
</body>

</html>