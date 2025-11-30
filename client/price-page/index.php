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

</style><!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Pricing</title>
</head>

<body>
  <?php include "./header.php" ?>
  <main class="main flow">
    <h1 class="main__heading">Pricing</h1>
    <div class="main__cards cards">
      <div class="cards__inner">

        <?php
        include 'connection.php';
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT PlanName, Price, Features, CTA_Text FROM PricingPlans ORDER BY PlanOrder";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $features = explode(',', $row['Features']);
            ?>
            <div class="cards__card card">
              <h2 class="card__heading"><?= $row['PlanName'] ?></h2>
              <p class="card__price">$<?= $row['Price'] ?></p>
              <ul role="list" class="card__bullets flow">
                <?php foreach ($features as $feature): ?>
                  <li><?= $feature ?></li>
                <?php endforeach; ?>
              </ul>
              <a href="#<?= strtolower($row['PlanName']) ?>" class="card__cta cta"><?= $row['CTA_Text'] ?></a>
            </div>

            <?php
          }
        } else {
          echo "No plans available.";
        }
        ?>

      </div>

      <div class="overlay cards__inner"></div>
    </div>
  </main>
  
  <script src="../cdnFiles/gsap.min.js" defer></script>
  <script src="../cdnFiles/ScrollTrigger.min.js" defer></script>
  <script src="script.js"></script>
</body>

</html>