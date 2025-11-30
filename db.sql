-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2024 at 10:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `AdminID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`AdminID`, `Username`, `Email`, `Password`, `Role`) VALUES
(1, 'Content Manager', 'contentmanager@gmail.com', '$2y$10$V6HCSu.Fd9hCgDZeVMRrTeOcRK9qOwZXE6fnz5/qoieleKjovYbiq', 'Content Manager'),
(2, 'Data Analyst', 'dataAnalyst@gmail.com', '$2y$10$7887l4pLN.s6lUjOxjAQHuWgyZ7Xdr1pqM0XnbZH2geq9CPkNaJ1S', 'Data Analyst'),
(3, 'User Support', 'usersupport@gmail.com', '$2y$10$cQ4AZdTIroRgETb8XdK2/efpMahvgvXhZdK0pmphghueUNWz6irGm', 'User Support'),
(4, 'Aman', 'aman@gmail.com', '$2y$10$cQ4AZdTIroRgETb8XdK2/efpMahvgvXhZdK0pmphghueUNWz6irGm', 'Super Admin'),
(5, 'Admin', 'admin@gmail.com', '$2y$10$cQ4AZdTIroRgETb8XdK2/efpMahvgvXhZdK0pmphghueUNWz6irGm', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `alternatives`
--

CREATE TABLE `alternatives` (
  `AlternativeID` int(11) NOT NULL,
  `OriginalFoodID` int(11) DEFAULT NULL,
  `AlternativeFoodID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alternatives`
--

INSERT INTO `alternatives` (`AlternativeID`, `OriginalFoodID`, `AlternativeFoodID`) VALUES
(1, 142, 146),
(133, 142, 144),
(134, 142, 145),
(135, 142, 146),
(136, 143, 146),
(137, 143, 148),
(138, 143, 149),
(139, 144, 145),
(140, 144, 146),
(141, 144, 150),
(142, 145, 146),
(143, 145, 149),
(144, 145, 153),
(145, 146, 147),
(146, 146, 148),
(147, 146, 150),
(148, 147, 148),
(149, 147, 149),
(150, 147, 150),
(151, 148, 149),
(152, 148, 150),
(153, 148, 153),
(154, 149, 150),
(155, 149, 153),
(157, 150, 151),
(158, 150, 153),
(160, 151, 152),
(161, 151, 153),
(163, 152, 153),
(170, 142, 144),
(171, 142, 145),
(172, 142, 146),
(173, 143, 146),
(174, 143, 148),
(175, 143, 149),
(176, 144, 145),
(177, 144, 146),
(178, 144, 150),
(179, 145, 146),
(180, 145, 149),
(181, 145, 153),
(182, 146, 147),
(183, 146, 148),
(184, 146, 150),
(185, 147, 148),
(186, 147, 149),
(187, 147, 150),
(188, 148, 149),
(189, 148, 150),
(190, 148, 153),
(191, 149, 150),
(192, 149, 153),
(194, 150, 151),
(195, 150, 153),
(197, 151, 152),
(198, 151, 153),
(200, 152, 153),
(207, 143, 146),
(208, 143, 148),
(209, 143, 149),
(210, 144, 145),
(211, 144, 146),
(212, 144, 150),
(213, 145, 146),
(214, 145, 149),
(215, 145, 153),
(216, 146, 147),
(217, 146, 148),
(218, 146, 150),
(219, 147, 148),
(220, 147, 149),
(221, 147, 150),
(222, 148, 149),
(223, 148, 150),
(224, 148, 153),
(225, 149, 150),
(226, 149, 153),
(228, 150, 151),
(229, 150, 153),
(231, 151, 152),
(232, 151, 153),
(234, 152, 153),
(243, 235, 146),
(244, 235, 144),
(245, 235, 145),
(246, 236, 146),
(247, 236, 144),
(248, 237, 146),
(249, 237, 144),
(250, 238, 145),
(251, 238, 147),
(256, 239, 237),
(257, 239, 238),
(258, 240, 235),
(259, 240, 236),
(260, 241, 236),
(261, 241, 240),
(264, 242, 148),
(265, 242, 150),
(266, 243, 239),
(267, 243, 240),
(268, 244, 241),
(269, 244, 237),
(270, 245, 238),
(271, 245, 146),
(272, 246, 238),
(273, 246, 142),
(274, 247, 244),
(275, 247, 148),
(276, 248, 241),
(277, 248, 237),
(278, 249, 248),
(279, 249, 238),
(280, 153, 238),
(304, 266, 235),
(305, 266, 241),
(308, 250, 249),
(309, 250, 241),
(310, 251, 248),
(311, 251, 238),
(312, 252, 251),
(313, 252, 249),
(314, 253, 252),
(315, 253, 251),
(316, 254, 251),
(317, 254, 250);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `CategoryID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `UpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`CategoryID`, `Name`, `Description`, `image_path`, `UpdatedAt`) VALUES
(12, 'Frozen Foods', 'Foods that are frozen for preservation', '../asset/ice-crem.png', '2024-10-17 18:20:12'),
(20, 'Breakfast', 'Various main course dishes', '../asset/pasta.jpeg', '2024-10-17 18:20:12'),
(24, 'Main Courses', 'Main dishes from various cuisines', '../asset/pav-bhaji.jpg', '2024-10-17 18:20:12'),
(28, 'Specialty Foods', 'Specialty or unique food items', '../asset/special.jpg', '2024-10-17 18:20:12'),
(33, 'Side Dishes', 'Accompanying dishes for main courses', '../asset/side.jpg', '2024-10-17 18:20:12'),
(43, 'Spicy Foods', 'Specialty or unique food items', '../asset/Spicy Foods.jpeg', '2024-10-17 18:20:12'),
(44, 'Beverage', 'Items baked in a bakery', '../asset/Beverages.jpeg', '2024-10-17 18:20:12'),
(56, 'Bakery Items', 'Drinks and beverages', '../asset/Bakery Items.jpg', '2024-10-17 18:20:12'),
(63, 'Low Calorie', 'Low Calorie Foods.', '../asset/salad.jpeg', '2024-10-17 18:20:12'),
(64, 'Desserts', 'Desserts Foods', '../asset/Desserts.jpg', '2024-10-17 18:20:12'),
(65, 'Snacks', 'Snacks Food', '../asset/Snacks.jpg', '2024-10-17 18:20:12');

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `FoodID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `HealthScore` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `about` text DEFAULT NULL,
  `product_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`FoodID`, `Name`, `Description`, `Price`, `CategoryID`, `Image`, `HealthScore`, `created_at`, `about`, `product_url`) VALUES
(142, 'Jackfruit Tacos', 'Jackfruit Tacos are a delicious plant-based alternative with rich flavors.', 8.99, 28, 'Jackfruit Tacos.jpg', '7', '2024-09-19 01:52:03', 'A vegan-friendly taco option filled with flavorful jackfruit, a perfect plant-based substitute for meat. This product is made with fresh ingredients and ensures great flavor while being nutritious. It can be enjoyed as part of a healthy diet and is perfect for various occasions, offering a balance of taste and health. Its unique preparation method preserves its natural flavors and nutrients, making it a delightful choice for everyone.', 'https://itdoesnttastelikechicken.com/easy-vegan-jackfruit-tacos/'),
(143, 'Grilled Asparagus', 'Grilled Asparagus is a healthy side dish, perfect for complementing meals.', 4.50, 33, 'Grilled Asparagus.jpg', '9', '2024-09-19 01:52:03', 'A simple and nutritious grilled vegetable dish. This product is made with fresh ingredients and ensures great flavor while being nutritious. It can be enjoyed as part of a healthy diet and is perfect for various occasions, offering a balance of taste and health. Its unique preparation method preserves its natural flavors and nutrients, making it a delightful choice for everyone.', 'https://www.allrecipes.com/recipe/17445/grilled-asparagus/'),
(144, 'Frozen Vegetable Dumplings', 'Frozen Vegetable Dumplings are a quick and tasty meal filled with veggies.', 5.99, 12, 'Frozen Vegetable Dumplings.jpg', '6', '2024-09-19 01:52:03', 'Frozen dumplings filled with a mix of vegetables. This product is made with fresh ingredients and ensures great flavor while being nutritious. It can be enjoyed as part of a healthy diet and is perfect for various occasions, offering a balance of taste and health. Its unique preparation method preserves its natural flavors and nutrients, making it a delightful choice for everyone.', 'https://www.amazon.com/Kale-Vegetable-Dumpling-Vegan/dp/B07WNRLDQJ'),
(145, 'Eggplant Parmesan', 'Eggplant Parmesan is a classic Italian dish made with breaded eggplant and cheese.', 12.00, 20, 'Eggplant Parmesan.jpg', '8', '2024-09-19 01:52:03', 'A rich and savory dish perfect for Italian food lovers. This delicious meal features baked eggplant topped with marinara sauce and melted cheese, making it a hearty, comforting option. This product is made with fresh ingredients and ensures great flavor while being nutritious. It can be enjoyed as part of a healthy diet and is perfect for various occasions.', 'https://www.amazon.com/Michael-Angelos-Eggplant-Parmesan/dp/B00OZC0VSY'),
(146, 'Chickpea Curry', 'Chickpea Curry is a hearty and flavorful vegan curry.', 8.00, 24, 'Chickpea Curry.jpg', '7', '2024-09-19 01:52:03', 'A satisfying curry made with chickpeas and aromatic spices. This product is made with fresh ingredients and ensures great flavor while being nutritious. It can be enjoyed as part of a healthy diet and is perfect for various occasions, offering a balance of taste and health. Its unique preparation method preserves its natural flavors and nutrients, making it a delightful choice for everyone.1', 'https://www.eatingbirdfood.com/basic-chia-seed-pudding/'),
(147, 'Burger', 'This is a juicy burger loaded with your favorite toppings.', 9.50, 20, 'burger.jpg', '2', '2024-09-19 01:52:03', 'A classic burger with fresh ingredients and rich flavors. This product is made with high-quality ingredients and ensures great taste while being nutritious. It can be enjoyed as part of a satisfying meal and is perfect for various occasions, offering a balance of indulgence and nutrition.', 'https://www.bk.com/'),
(148, 'Almond Milk Smoothies', 'Almond Milk Smoothies are a dairy-free and refreshing option.', 5.00, 56, 'Almond Milk Smoothies.jpg', '9', '2024-09-19 01:52:03', 'A nutritious smoothie made with almond milk and fresh fruits. This product is made with high-quality ingredients and ensures great taste while being nutritious. It can be enjoyed as part of a healthy diet and is perfect for various occasions, offering a balance of indulgence and nutrition.', 'https://www.amazon.com/Califia-Farms-Almondmilk-Whipped-Beverages/dp/B07L91NTKH'),
(149, 'Tofu Scramble', 'Tofu Scramble is a plant-based alternative to scrambled eggs.', 6.50, 24, 'Tofu Scramble.jpeg', '8', '2024-09-19 01:52:03', 'A protein-rich vegan breakfast option. This product is made with high-quality tofu and ensures great taste while being nutritious. It can be enjoyed as part of a healthy diet and is perfect for breakfast or brunch, offering a balance of protein and flavor.', 'https://rainbowplantlife.com/eggy-tofu-scramble/'),
(150, 'Smoothie Bowl', 'Smoothie Bowl is a thick and creamy smoothie served in a bowl.', 7.00, 56, 'Smoothie Bowl.jpg', '9', '2024-09-19 01:52:03', 'A healthy breakfast or snack option packed with nutrients. This product is made with fresh ingredients and ensures great taste while being nutritious. It can be enjoyed as part of a healthy diet and is perfect for various occasions, offering a balance of taste and health.', 'https://minimalistbaker.com/favorite-smoothie-bowls/'),
(151, 'Pizza', 'This pizza is topped with delicious ingredients and baked to perfection.', 11.00, 20, 'pizza.jpg', '1', '2024-09-19 01:52:03', 'A cheesy and flavorful pizza to satisfy your cravings. This product is made with fresh ingredients and ensures great flavor while being nutritious. It can be enjoyed as part of a balanced diet and is perfect for various occasions, offering a balance of indulgence and nutrition.', 'https://www.zomato.com/surat/la-pinoz-pizza-nanpura-surat'),
(152, 'Pav Bhaji', 'Pav Bhaji is a spicy and tangy Indian street food dish served with buttered bread rolls.', 4.00, 24, 'pav-bhaji.jpg', '3', '2024-09-19 01:52:03', 'A popular Indian dish served with buttered bread rolls and a spicy vegetable mash. This product is made with fresh ingredients and ensures great taste while being nutritious. It can be enjoyed as part of a balanced meal and is perfect for Indian food lovers, offering a mix of indulgence and flavor.', 'https://www.zomato.com/surat/daruwala-pav-bhaji-surat'),
(153, 'Pasta', 'This pasta dish is a perfect mix of flavors, textures, and fresh ingredients.', 9.00, 20, 'pasta1.png', '8', '2024-09-19 01:52:03', 'A delicious Italian pasta made with fresh ingredients and rich flavors. This product ensures great taste while being nutritious and can be enjoyed as part of a balanced meal. Its unique preparation preserves the quality and flavor, making it a perfect choice for Italian food lovers.', 'https://thepastaqueen.cooking/blogs/recipes/the-viral-tiktok-pasta-recipe'),
(235, 'Vegan Pizza', 'A delicious pizza topped with fresh vegetables and vegan cheese, perfect for a healthy meal.', 12.99, 20, 'veganPizza.jpg', '9', '2024-09-30 17:41:23', 'A flavorful vegan pizza that is both nutritious and satisfying.', 'https://www.loveandlemons.com/vegan-pizza/'),
(236, 'Berry Smoothie', 'A refreshing smoothie made with a blend of berries, almond milk, and banana.', 5.99, 24, 'berry smootie.jpg', '7', '2024-09-30 17:59:21', 'A healthy smoothie rich in antioxidants.', 'https://www.dinneratthezoo.com/mixed-berry-smoothie/'),
(237, 'Strawberry Banana Smoothie', 'A delicious and nutritious smoothie made with fresh strawberries and bananas.', 5.99, 28, 'stories-HGy-0JnAoXA-unsplash.jpg', '8', '2024-09-30 18:06:26', 'A refreshing smoothie perfect for any time of the day.', 'https://www.gimmesomeoven.com/strawberry-banana-smoothie-recipe/'),
(238, 'Quinoa Salad with Vegetables', 'A healthy and nutritious salad made with quinoa and fresh vegetables.', 7.99, 28, 'Quinoa Salad with Vegetables.jpg', '9', '2024-09-30 18:10:30', 'A perfect meal for health-conscious individuals.', 'https://cookieandkate.com/best-quinoa-salad-recipe/'),
(239, 'Overnight Oats with Chia Seeds', 'A nutritious and easy-to-make breakfast option rich in fiber and protein.', 12.99, 20, 'Overnight Oats with Chia Seeds.jpg', '8', '2024-09-30 18:20:27', 'A perfect way to start your day!', 'https://www.loveandlemons.com/overnight-oats-recipe/'),
(240, 'Lentil Soup', 'A hearty soup made with lentils, vegetables, and spices.', 6.99, 20, 'Lentil Soup.jpg', '8', '2024-09-30 18:51:37', 'This delicious lentil soup is not only comforting but also highly nutritious, packed with fiber, vitamins, and minerals.', 'https://www.recipetineats.com/lentil-soup/'),
(241, 'Vegan Pancakes', 'Fluffy vegan pancakes made without any dairy or eggs.', 5.49, 24, 'Vegan Pancakes.jpg', '7', '2024-09-30 18:57:38', 'Delicious and fluffy vegan pancakes, perfect for breakfast, made with plant-based ingredients for a healthier option.', 'https://www.noracooks.com/vegan-pancakes/'),
(242, 'Chia Pudding', 'A creamy and healthy pudding made from chia seeds.', 4.99, 20, 'Chia Pudding.jpg', '9', '2024-09-30 19:08:09', 'Chia Pudding is a nutritious, creamy dessert or snack packed with fiber, protein, and omega-3 fatty acids. It is made from chia seeds soaked in plant-based milk and can be topped with fruits, nuts, or other healthy ingredients.', 'https://www.eatingbirdfood.com/basic-chia-seed-pudding/'),
(243, 'Oatmeal with Fresh Fruit', 'A hearty and nutritious bowl of oatmeal topped with a variety of fresh fruits.', 5.50, 24, 'Oatmeal with Fresh Fruit.jpg', '8', '2024-09-30 19:16:16', 'Oatmeal with Fresh Fruit is a healthy breakfast option rich in fiber and essential vitamins. It is made with whole oats and topped with fresh fruits like berries, bananas, or apples, providing a well-balanced meal to start your day.', 'https://www.yummytoddlerfood.com/oatmeal-with-fruit/'),
(244, 'Gluten-Free Brownies', 'Delicious and fudgy brownies made without gluten, perfect for a sweet treat.', 4.99, 44, 'Gluten-Free Brownies.jpg', '2', '2024-10-01 02:20:16', 'These gluten-free brownies are a rich, chocolatey dessert option for those who avoid gluten. Made with almond flour and dark chocolate, they provide a healthier twist on a classic treat.', 'https://meaningfuleats.com/gluten-free-brownie-recipe/'),
(245, 'Sweet Potato Fries', 'Crispy and delicious sweet potato fries, baked or fried to perfection.', 3.99, 33, 'Sweet Potato Fries.jpg', '7', '2024-10-01 02:24:05', 'Sweet potato fries are a healthier alternative to regular fries. Packed with nutrients and fiber, they provide a satisfying snack or side dish.', 'https://cooking.nytimes.com/recipes/1014647-sweet-potato-fries'),
(246, 'Greek Salad', 'A fresh and vibrant salad made with tomatoes, cucumbers, olives, and feta cheese.', 6.99, 28, 'Greek Salad.jpg', '9', '2024-10-01 02:31:35', 'A delicious and nutritious Mediterranean salad, perfect for a light meal or a side dish. Packed with fresh vegetables and healthy fats from olives and olive oil.', 'https://www.loveandlemons.com/greek-salad/'),
(247, 'Gluten-Free Muffins', 'Delicious and fluffy gluten-free muffins perfect for breakfast or as a snack.', 4.99, 44, 'Gluten-Free Muffins.jpg', '7', '2024-10-01 02:33:37', 'These gluten-free muffins are a great option for people who are gluten intolerant or simply want a healthy snack. They are made with wholesome ingredients and are perfect for on-the-go.', 'https://meaningfuleats.com/gluten-free-muffins-master-recipe/'),
(248, 'Vegan Banana Bread', 'A moist and delicious banana bread made with all vegan ingredients.', 6.99, 44, 'Vegan-Banana-Bread.jpg', '8', '2024-10-01 02:36:44', 'This vegan banana bread is a healthy and tasty treat, made without any dairy or eggs. It is packed with the natural sweetness of bananas and makes for a perfect snack or breakfast.', 'https://example.com/vegan-banana-bread'),
(249, 'Whole-Grain Bagels', 'Delicious whole-grain bagels that are perfect for a healthy breakfast.', 4.99, 44, 'Whole-Grain-Bagels.jpg', '7', '2024-10-01 02:42:18', 'These whole-grain bagels are rich in fiber and nutrients, making them a healthy and filling option for breakfast or snacks. They are perfect for pairing with spreads, vegetables, or proteins.', 'https://example.com/whole-grain-bagels'),
(250, 'Spicy Foods', 'A vibrant and flavorful dish featuring red lentil Dahl, cilantro, chili, lemon, yogurt, and baguette, served on a blue background.', 7.99, 43, 'Spicy Foods.jpeg', '8', '2024-10-16 16:23:11', 'This dish is rich in flavor and packed with healthy ingredients like red lentil Dahl, cilantro, and chili. It offers a perfect balance of spices and comfort with the cooling effect of yogurt and fresh lemon.', 'https://example.com/spicy-foods'),
(251, 'Fresh Fruit', 'A plate of healthy and refreshing fresh fruit including pineapple, dragon fruit, watermelon, papaya, orange, strawberry, and melon. Served from a top view.', 6.99, 63, 'fresh-fruit.jpg', '9', '2024-10-16 17:09:49', 'This vibrant plate of fresh fruit is packed with vitamins and antioxidants, perfect for a refreshing snack or a healthy breakfast. Each fruit brings a unique flavor and health benefit.', 'https://example.com/fresh-fruit'),
(252, 'Cream Cake', 'A delicious and creamy cake topped with a smooth layer of cream and decorative toppings, perfect for dessert lovers.', 9.99, 64, 'cream-cake.jpeg', '6', '2024-10-16 17:22:41', 'This cream cake is a delightful dessert with a soft and fluffy texture, covered in a rich, velvety cream. It’s perfect for celebrating any special occasion or simply indulging in a sweet treat.', 'https://example.com/cream-cake'),
(253, 'Golden Wedding Cake', 'A beautiful and elegant cake for a golden wedding anniversary celebration, with a perfect design and a rich, delicious flavor.', 12.99, 64, 'cake.jpg', '7', '2024-10-16 17:26:35', 'This golden wedding cake is a masterpiece, made with a stunning design and delicious layers of flavor. It was carefully crafted for a special occasion, offering a perfect balance of elegance and taste.', 'https://example.com/golden-wedding-cake'),
(254, 'Homemade Bread and Hummus', 'A simple yet delicious snack featuring freshly baked homemade bread paired with creamy hummus.', 5.99, 65, 'Snacks.jpg', '8', '2024-10-16 17:30:57', 'This snack plate offers a delightful combination of homemade bread and hummus. The bread is warm and fresh, while the hummus is rich, creamy, and flavorful, making it a perfect light snack or appetizer.', 'https://example.com/homemade-bread-and-hummus'),
(266, 'Vegan Burger', 'This is burger', 20.00, 24, 'vegan-burger.jpg', '6', '2024-10-07 18:10:17', 'This is a vegan Burger', 'burger.com');

-- --------------------------------------------------------

--
-- Table structure for table `food_ingredients`
--

CREATE TABLE `food_ingredients` (
  `FoodID` int(11) NOT NULL,
  `IngredientID` int(11) NOT NULL,
  `Quantity` decimal(5,2) DEFAULT NULL,
  `Unit` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_ingredients`
--

INSERT INTO `food_ingredients` (`FoodID`, `IngredientID`, `Quantity`, `Unit`) VALUES
(142, 1, 1.00, 'cup'),
(143, 2, 1.00, 'bunch'),
(144, 3, 1.00, 'cup'),
(145, 4, 2.00, 'cup'),
(146, 187, 2.00, 'cup'),
(147, 6, 1.00, 'patty'),
(148, 7, 1.00, 'cup'),
(149, 8, 1.00, 'cup'),
(150, 9, 1.00, 'cup'),
(151, 10, 1.00, 'slice'),
(151, 52, 100.00, 'grams'),
(152, 11, 1.00, 'cup'),
(153, 12, 1.00, 'cup'),
(235, 8, 80.00, 'grams'),
(236, 61, 1.00, 'cup'),
(237, 63, 1.00, 'cup'),
(238, 66, 1.00, 'cup'),
(238, 67, 1.00, 'cup'),
(238, 68, 1.00, 'cup'),
(238, 69, 2.00, 'tablespoons'),
(239, 1, 1.00, 'cup'),
(239, 2, 2.00, 'tablespoon'),
(239, 3, 1.00, 'cup'),
(239, 4, 1.00, 'tablespoon'),
(240, 79, 200.00, 'grams'),
(240, 80, 100.00, 'grams'),
(240, 81, 50.00, 'grams'),
(240, 82, 10.00, 'grams'),
(240, 83, 5.00, 'grams'),
(241, 7, 200.00, 'ml'),
(241, 62, 1.00, 'piece'),
(241, 94, 150.00, 'grams'),
(241, 95, 10.00, 'grams'),
(241, 96, 50.00, 'ml'),
(242, 7, 1.00, 'cup'),
(242, 96, 1.00, 'tbsp'),
(242, 102, 2.00, 'tbsp'),
(243, 62, 1.00, 'pcs'),
(243, 63, 0.50, 'cup'),
(243, 105, 1.00, 'cup'),
(243, 106, 0.50, 'cup'),
(244, 96, 0.50, 'cup'),
(244, 107, 1.00, 'cup'),
(244, 108, 1.00, 'cup'),
(244, 109, 0.50, 'cup'),
(244, 110, 2.00, 'pcs'),
(245, 69, 2.00, 'tbsp'),
(245, 112, 2.00, 'pcs'),
(245, 113, 0.50, 'tsp'),
(245, 114, 0.25, 'tsp'),
(246, 69, 2.00, 'tbsp'),
(246, 116, 2.00, 'pcs'),
(246, 117, 1.00, 'pcs'),
(246, 118, 0.50, 'cup'),
(246, 119, 0.25, 'cup'),
(247, 7, 1.00, 'cup'),
(247, 95, 1.00, 'tsp'),
(247, 96, 0.50, 'cup'),
(247, 110, 2.00, 'pcs'),
(247, 121, 1.50, 'cups'),
(248, 7, 1.00, 'cup'),
(248, 62, 3.00, 'pcs'),
(248, 94, 2.00, 'cups'),
(248, 96, 0.50, 'cup'),
(248, 126, 1.00, 'tsp'),
(249, 69, 2.00, 'tbsp'),
(249, 94, 3.00, 'cups'),
(249, 96, 1.00, 'tbsp'),
(249, 131, 2.00, 'tsp'),
(249, 132, 1.50, 'cups'),
(251, 174, 1.00, 'slice'),
(251, 175, 1.00, 'slice'),
(251, 176, 1.00, 'slice'),
(251, 177, 1.00, 'slice'),
(251, 178, 1.00, 'slice'),
(251, 179, 1.00, 'whole'),
(251, 180, 1.00, 'slice'),
(252, 110, 4.00, 'eggs'),
(252, 181, 2.00, 'cups'),
(252, 182, 1.00, 'cup'),
(252, 183, 1.50, 'cups'),
(252, 184, 2.00, 'cups'),
(252, 185, 1.00, 'tsp'),
(253, 110, 4.00, 'eggs'),
(253, 182, 1.00, 'cup'),
(253, 183, 1.50, 'cups'),
(253, 185, 1.00, 'tsp'),
(253, 187, 2.00, 'cups'),
(253, 188, 1.00, 'lb'),
(254, 5, 1.50, 'cups'),
(254, 69, 2.00, 'tbsp'),
(254, 82, 2.00, 'cloves'),
(254, 94, 3.00, 'cups'),
(254, 131, 2.00, 'tsp'),
(254, 200, 2.00, 'tbsp'),
(254, 201, 3.00, 'tbsp'),
(266, 10, 1.00, 'piece'),
(266, 11, 20.00, 'g'),
(266, 107, 1.00, 'cup');

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `IngredientID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `HealthImpact` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`IngredientID`, `Name`, `description`, `HealthImpact`) VALUES
(1, 'Jackfruit', 'Rich in antioxidants and vitamins, promotes digestion and boosts immunity.', 'Neutral'),
(2, 'Asparagus', 'High in vitamins A, C, and K, supports digestion and has anti-inflammatory properties.', 'Neutral'),
(3, 'Vegetable Mix', 'Contains a variety of vegetables, providing a range of vitamins and minerals.', 'Neutral'),
(4, 'Eggplant', 'High in fiber and antioxidants, supports heart health and digestion.', 'Neutral'),
(5, 'Chickpeas', 'The main ingredient in hummus.', 'Rich in protein and fiber, supports digestion and heart health.'),
(6, 'Beef Patty', 'High in protein, but should be consumed in moderation due to high saturated fat content.', 'Neutral'),
(7, 'Almond Milk', 'Low in calories, rich in vitamins D and E, and supports bone health.', 'Neutral'),
(8, 'Tofu', 'High in protein and iron, supports heart health and is a good plant-based protein source.', 'Neutral'),
(9, 'Smoothie Ingredients', 'Varies based on specific fruits and vegetables, generally high in vitamins and minerals.', 'Neutral'),
(10, 'Cheese', 'High in calcium and protein, but should be consumed in moderation due to high fat content.', 'Negative'),
(11, 'Mixed Vegetables', 'Varies based on vegetables, generally provides vitamins, minerals, and fiber.', 'Negative'),
(12, 'Pasta', 'Contains carbohydrates and some protein, but can be high in calories.', 'Neutral'),
(13, 'Orange Juice', 'High in vitamin C and antioxidants, supports immune function and overall health.', 'Positive'),
(52, 'Tomato Sauce', 'A rich sauce made from tomatoes, providing vitamins and antioxidants.', 'Good for heart health.'),
(61, 'Berries', 'A mix of strawberries, blueberries, and raspberries, rich in antioxidants.', 'Supports heart health.'),
(62, 'Banana', 'A nutritious fruit rich in potassium and vitamins.', 'Good for energy and heart health.'),
(63, 'Strawberries', 'Fresh strawberries, rich in vitamins and antioxidants.', 'Supports heart health.'),
(66, 'Quinoa', 'A high-protein grain that is gluten-free and rich in nutrients.', 'Supports heart health and is high in fiber.'),
(67, 'Bell Peppers', 'Colorful bell peppers rich in vitamins and antioxidants.', 'Supports immune health.'),
(68, 'Cucumber', 'A refreshing vegetable that is low in calories and hydrating.', 'Good for hydration.'),
(69, 'Olive Oil', 'Used in bread and hummus for flavor and texture.', 'Supports heart health and reduces inflammation.'),
(79, 'Lentils', 'A rich source of protein and fiber, beneficial for digestion.', 'Supports heart health and aids digestion.'),
(80, 'Carrots', 'A root vegetable high in beta-carotene, fiber, and antioxidants.', 'Good for vision and immune support.'),
(81, 'Onions', 'A pungent vegetable with numerous health benefits.', 'Supports heart health and has anti-inflammatory properties.'),
(82, 'Garlic', 'Adds a pungent flavor to hummus.', 'Supports immune health and has anti-inflammatory properties.'),
(83, 'Cumin', 'A spice that adds earthy flavor and aids digestion.', 'Supports digestion and reduces inflammation.'),
(94, 'Whole Wheat Flour', 'Rich in fiber and essential nutrients.', 'Good for digestion and heart health.'),
(95, 'Baking Powder', 'A leavening agent used to make pancakes fluffy.', 'Neutral health impact.'),
(96, 'Maple Syrup', 'A natural sweetener rich in antioxidants.', 'Supports immune health but should be consumed in moderation.'),
(100, 'Ingredient2', 'Description of Ingredient2.', 'Health Impact of Ingredient2.'),
(101, 'Ingredient3', 'Description of Ingredient3.', 'Health Impact of Ingredient3.'),
(102, 'Chia Seeds', 'Rich in fiber, omega-3s, and antioxidants.', 'Supports digestion and heart health.'),
(105, 'Oats', 'A whole grain rich in fiber, supports digestion and heart health.', 'Supports digestion and reduces cholesterol.'),
(106, 'Blueberries', 'Packed with antioxidants and vitamins.', 'Supports brain health and reduces oxidative stress.'),
(107, 'Almond Flour', 'A gluten-free flour made from ground almonds, rich in protein and healthy fats.', 'Supports heart health and is a low-carb alternative to regular flour.'),
(108, 'Dark Chocolate', 'Rich in antioxidants and low in sugar.', 'Good for heart health when consumed in moderation.'),
(109, 'Cocoa Powder', 'A rich source of antioxidants.', 'Supports heart health and reduces inflammation.'),
(110, 'Eggs', 'Rich in protein and essential nutrients.', 'Supports muscle repair and overall health.'),
(112, 'Sweet Potatoes', 'A root vegetable rich in fiber, vitamins, and antioxidants.', 'Supports eye health and boosts the immune system.'),
(113, 'Sea Salt', 'A natural source of sodium used for seasoning.', 'Neutral health impact when used in moderation.'),
(114, 'Pepper', 'A spice commonly used to add flavor.', 'Neutral health impact.'),
(116, 'Tomatoes', 'Juicy and sweet, tomatoes are rich in vitamins and antioxidants.', 'Supports immune health and heart health.'),
(117, 'Cucumbers', 'A hydrating vegetable with a high water content.', 'Good for hydration and low in calories.'),
(118, 'Feta Cheese', 'A tangy and salty cheese, rich in calcium and protein.', 'Supports bone health but should be consumed in moderation.'),
(119, 'Olives', 'A source of healthy fats and antioxidants.', 'Supports heart health and reduces inflammation.'),
(121, 'Gluten-Free Flour', 'A blend of flours that are free from gluten.', 'Safe for those with gluten intolerance.'),
(126, 'Baking Soda', 'A leavening agent used in baking.', 'Neutral health impact.'),
(131, 'Yeast', 'Used as a leavening agent for bread.', 'Neutral health impact.'),
(132, 'Water', 'A key component in the bagel dough.', 'Essential for hydration and body functions.'),
(168, 'Red Lentil Dahl', 'A spiced lentil dish rich in proteins and fiber.', 'Promotes digestion and heart health.'),
(169, 'Cilantro', 'Fresh herb with a citrusy flavor.', 'Good for digestion and provides antioxidants.'),
(170, 'Chili', 'Spicy peppers that add heat to the dish.', 'Boosts metabolism and contains antioxidants.'),
(171, 'Lemon', 'Tart citrus fruit rich in vitamin C.', 'Boosts immunity and aids digestion.'),
(172, 'Yogurt', 'A creamy dairy product that complements spicy foods.', 'Good for gut health and digestion.'),
(173, 'Baguette', 'French bread that provides a crunchy and comforting texture.', 'Provides carbohydrates and fiber.'),
(174, 'Pineapple', 'Tropical fruit rich in vitamin C and antioxidants.', 'Boosts immunity and digestion.'),
(175, 'Dragon Fruit', 'Exotic fruit high in fiber, antioxidants, and vitamin C.', 'Promotes digestion and healthy skin.'),
(176, 'Watermelon', 'Juicy fruit with high water content.', 'Hydrating and rich in vitamins A and C.'),
(177, 'Papaya', 'Tropical fruit rich in enzymes and vitamin C.', 'Supports digestion and boosts immunity.'),
(178, 'Orange', 'Citrus fruit high in vitamin C and antioxidants.', 'Strengthens the immune system and promotes healthy skin.'),
(179, 'Strawberry', 'Small red fruit high in vitamin C and antioxidants.', 'Helps fight inflammation and promotes heart health.'),
(180, 'Melon', 'Sweet, hydrating fruit with a good amount of vitamins A and C.', 'Hydrating and good for skin health.'),
(181, 'All-Purpose Flour', 'Commonly used flour for baking cakes and other desserts.', 'Contains carbohydrates, but should be consumed in moderation.'),
(182, 'Butter', 'Rich in flavor and texture, used for the cake batter and cream.', 'High in saturated fats, should be consumed in moderation.'),
(183, 'Sugar', 'A sweetener used to add flavor and sweetness to desserts.', 'High in calories, can lead to weight gain if consumed excessively.'),
(184, 'Heavy Cream', 'Rich and creamy, used as the topping for the cake.', 'High in fat, should be enjoyed occasionally.'),
(185, 'Vanilla Extract', 'Adds flavor and aroma to the cake.', 'Enhances the flavor without impacting health negatively in small quantities.'),
(187, 'Cake Flour', 'A fine-textured flour used for making delicate cakes.', 'Provides carbohydrates, but should be consumed in moderation.'),
(188, 'Fondant', 'A smooth icing used for decorating cakes.', 'High in sugar, should be consumed in moderation.'),
(200, 'Lemon Juice', 'Adds acidity and brightness to hummus.', 'High in Vitamin C, supports immune function.'),
(201, 'Tahini', 'A paste made from ground sesame seeds, used in hummus.', 'Rich in healthy fats and protein.'),
(204, 'lk', 'j', 'Positive');

-- --------------------------------------------------------

--
-- Table structure for table `nutritional_info`
--

CREATE TABLE `nutritional_info` (
  `NutritionID` int(11) NOT NULL,
  `FoodID` int(11) DEFAULT NULL,
  `Calories` text DEFAULT NULL,
  `Proteins` text DEFAULT NULL,
  `Carbs` text DEFAULT NULL,
  `Fats` text DEFAULT NULL,
  `Vitamins` text DEFAULT NULL,
  `Minerals` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nutritional_info`
--

INSERT INTO `nutritional_info` (`NutritionID`, `FoodID`, `Calories`, `Proteins`, `Carbs`, `Fats`, `Vitamins`, `Minerals`) VALUES
(1, 142, '320', '9', '50', '8', '', ''),
(2, 143, '50', '3', '5', '0.4', 'Vitamin K, Vitamin C', 'Potassium'),
(3, 144, '250', '7', '35', '5', 'Vitamin B12', 'Calcium, Iron'),
(4, 145, '450', '21', '40', '20', 'Vitamin A, Vitamin C', 'Iron, Calcium'),
(5, 146, '300', '12', '45', '10', 'A', 'Fe'),
(6, 147, '500', '25', '45', '20', 'Vitamin B12, Vitamin D', 'Zinc, Iron'),
(7, 148, '180', '5', '25', '8', 'Vitamin E, Vitamin D', 'Calcium, Magnesium'),
(8, 149, '200', '16', '12', '10', 'Vitamin B12, Vitamin D', 'Iron, Calcium'),
(9, 150, '300', '6', '50', '12', 'Vitamin C, Vitamin A', 'Iron, Potassium'),
(10, 151, '270', '12', '35', '8', 'Vitamin A, Vitamin C', 'Iron, Calcium'),
(11, 152, '400', '10', '55', '20', 'Vitamin B12, Vitamin C', 'Sodium, Potassium'),
(12, 153, '350', '10', '60', '12', 'Vitamin A, Vitamin B', 'Iron, Calcium'),
(43, 235, '300', '10', '35', '8', 'Vitamin A, Vitamin C', 'Iron, Calcium'),
(44, 236, '200', '5', '35', '2', 'Vitamin C', 'Calcium'),
(45, 237, '220', '4', '30', '2', 'Vitamin C', 'Calcium'),
(46, 238, '300', '10', '40', '12', '12', '52'),
(47, 239, '300', '10', '50', '5', 'A, B, C', 'Iron, Calcium'),
(48, 240, '350', '15', '45', '8', 'Vitamin A, Vitamin C', 'Iron, Potassium'),
(49, 241, '400', '8', '70', '10', 'Vitamin D, Vitamin E', 'Potassium, Iron'),
(51, 242, '150', '5', '20', '8', 'Vitamin D, Vitamin E', 'Calcium, Iron'),
(52, 243, '220', '7', '40', '5', 'Vitamin C, Potassium', 'Iron, Magnesium'),
(53, 244, '320', '8', '30', '20', 'Vitamin E', 'Magnesium, Iron'),
(54, 245, '200', '3', '30', '8', 'Vitamin A, Vitamin C', 'Potassium'),
(55, 246, '300', '7', '15', '20', 'Vitamin A, Vitamin C', 'Calcium, Potassium'),
(56, 247, '250', '6', '35', '10', 'Vitamin D, Vitamin E', 'Calcium, Potassium'),
(57, 248, '200', '4', '40', '6', 'Vitamin D, Potassium', 'Calcium, Magnesium'),
(58, 249, '250', '8', '45', '5', 'Vitamin E, Vitamin B', 'Iron, Magnesium'),
(71, 266, '20', '20', '10', '20', '5', '3'),
(74, 250, '350', '18', '50', '10', 'Vitamin C, Vitamin A', 'Iron, Magnesium'),
(75, 251, '150', '2', '35', '0.5', 'Vitamin C, Vitamin A, Fiber', 'Potassium, Magnesium'),
(76, 252, '350', '4', '50', '18', 'Vitamin A, Vitamin D', 'Calcium, Iron'),
(77, 253, '450', '5', '70', '20', 'Vitamin A, Vitamin D', 'Calcium, Iron'),
(78, 254, '300', '10', '45', '12', 'Vitamin E, Vitamin C', 'Iron, Magnesium');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_attempts`
--

CREATE TABLE `password_reset_attempts` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `attempt_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_reset_attempts`
--

INSERT INTO `password_reset_attempts` (`id`, `email`, `attempt_time`) VALUES
(1, 'amanpatel30@gmail.com', '2024-10-13 19:09:56'),
(2, 'amanpatel30@gmail.com', '2024-10-15 00:58:00'),
(3, 'amanpatel30@gmail.com', '2024-10-15 01:05:11'),
(4, 'amanpatel30@gmail.com', '2024-10-15 01:06:15'),
(5, 'amanpatel30@gmail.com', '2024-10-15 10:38:57'),
(6, 'jane@example.com', '2024-10-16 02:38:32'),
(7, 'panda12@gmail.com', '2024-10-16 03:45:56'),
(8, 'amanpatel30@gmail.com', '2024-10-16 10:58:26'),
(9, 'amanpatel30@gmail.com', '2024-10-16 14:30:05'),
(10, 'Demo@gmail.com', '2024-10-19 10:44:41'),
(11, 'john@example.com', '2024-10-19 10:45:09'),
(12, 'john@example.com', '2024-10-19 10:45:14'),
(13, 'john@example.com', '2024-10-19 10:45:21'),
(14, 'Demo@gmail.com', '2024-10-19 10:51:22'),
(15, 'nidhi1@gmail.com', '2024-10-19 12:15:44'),
(16, 'finalcheck@gmail.com', '2024-10-20 00:11:14'),
(17, 'Loki1@gmail.com', '2024-10-21 14:44:22'),
(18, 'Loki1@gmail.com', '2024-10-21 14:44:39'),
(19, 'Loki1@gmail.com', '2024-10-21 14:44:44'),
(20, 'Loki1@gmail.com', '2024-10-21 16:26:14'),
(21, 'Loki1@gmail.com', '2024-10-21 16:26:23'),
(22, 'Loki1@gmail.com', '2024-10-21 16:26:28'),
(23, 'amanpatel1030@gmail.com', '2024-10-21 17:57:59'),
(24, 'amanpatel1030@gmail.com', '2024-10-21 22:26:20'),
(25, 'pritesh@gmail.com', '2024-10-23 00:32:14'),
(26, 'pritesh@gmail.com', '2024-10-23 00:33:21'),
(27, 'pritesh@gmail.com', '2024-10-23 00:33:24'),
(28, 'mosam123@gmail.com', '2024-10-23 08:40:37'),
(29, 'dhvani123@gmail.com', '2024-10-23 12:57:15'),
(30, 'amanpatel1030@gmail.com', '2024-11-27 11:18:43');

-- --------------------------------------------------------

--
-- Table structure for table `pricingplans`
--

CREATE TABLE `pricingplans` (
  `PlanID` int(11) NOT NULL,
  `PlanName` varchar(50) NOT NULL,
  `Price` decimal(5,2) NOT NULL,
  `Features` text NOT NULL,
  `CTA_Text` varchar(50) NOT NULL,
  `PlanOrder` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pricingplans`
--

INSERT INTO `pricingplans` (`PlanID`, `PlanName`, `Price`, `Features`, `CTA_Text`, `PlanOrder`) VALUES
(1, 'Basic', 9.99, 'Access to standard workouts and nutrition plans,Email support', 'Get Started', 1),
(2, 'Pro', 19.99, 'Access to advanced workouts and nutrition plans,Priority Email support,Exclusive access to live Q&A sessions', 'Upgrade to Pro', 2),
(3, 'Ultimate', 29.99, 'Access to all premium workouts and nutrition plans,24/7 Priority support,1-on-1 virtual coaching session every month,Exclusive content and early access to new features', 'Go Ultimate', 3);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `RatingID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `FoodID` int(11) DEFAULT NULL,
  `name` varchar(20) NOT NULL,
  `feedback` text NOT NULL,
  `Score` text NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`RatingID`, `UserID`, `FoodID`, `name`, `feedback`, `Score`, `Date`) VALUES
(379, 16, 142, 'john_doe', 'The Jackfruit Tacos were amazing! The texture of the jackfruit was just like pulled meat, and the flavors were so fresh and tangy. Would definitely order again!', '5', '2024-10-18 17:40:54'),
(380, 3, 142, 'jane_smith', 'I loved the Jackfruit Tacos! The jackfruit was seasoned perfectly and the combination of spices with the salsa made it a memorable dish. Highly recommend for taco lovers!', '4', '2024-10-18 17:40:54'),
(381, 14, 142, 'alex_jones', 'Jackfruit Tacos were quite tasty. I liked the tangy flavor, but the texture could have been slightly better. Still, a good vegetarian option for taco night.', '4', '2024-10-18 17:40:54'),
(382, 7, 142, 'Aman30', 'These Jackfruit Tacos were absolutely delicious! The jackfruit was tender, and the spices blended perfectly. They are a great meat-free alternative that’s full of flavor!', '5', '2024-10-18 17:40:54'),
(384, 2, 142, 'Aman1232', 'Surprisingly, the Jackfruit Tacos were delicious! I was skeptical at first, but the seasoning and toppings made the jackfruit shine. Great option for those who love plant-based meals.', '4', '2024-10-18 17:40:54'),
(385, 1, 142, 'KingU', 'The Jackfruit Tacos were a refreshing change from the usual tacos. The jackfruit was seasoned perfectly, and the toppings added a nice crunch. Will definitely try again!', '5', '2024-10-18 17:40:54'),
(386, 12, 142, 'krishna', 'These Jackfruit Tacos were fantastic! The jackfruit was cooked so well, it tasted just like pulled meat. The flavors were on point, making it a great taco experience.', '5', '2024-10-18 17:40:54'),
(387, 10, 142, 'Aman123', 'Jackfruit Tacos were flavorful and filling. The jackfruit gave the tacos a nice meaty texture, and the sauce added a great tang. Would definitely recommend to others!', '4', '2024-10-18 17:40:54'),
(388, 9, 142, 'withOutImage', 'The Jackfruit Tacos were deliciously surprising! The texture was almost like meat, and the seasoning was spot on. A great alternative to traditional tacos, especially for vegetarians.', '5', '2024-10-18 17:40:54'),
(389, 16, 143, 'john_doe', 'The Grilled Asparagus was absolutely delicious. The asparagus was perfectly cooked, with a nice char that added smokiness. It was light yet flavorful and made for a perfect side dish.', '5', '2024-10-18 17:43:56'),
(390, 3, 143, 'jane_smith', 'I really enjoyed the Grilled Asparagus. It was well-seasoned and had a delightful smoky taste from the grilling. A healthy option that didn’t compromise on flavor!', '4', '2024-10-18 17:43:56'),
(391, 14, 143, 'alex_jones', 'The Grilled Asparagus was good, but it could have used a bit more seasoning. The texture was perfect, though. A good healthy side, but it didn’t stand out too much.', '3', '2024-10-18 17:43:56'),
(392, 7, 143, 'Aman30', 'Grilled Asparagus was excellent! The grilling added a nice smoky flavor, and the asparagus retained a slight crunch. A great option for those looking for something healthy and flavorful.', '5', '2024-10-18 17:43:56'),
(394, 2, 143, 'Aman1232', 'The Grilled Asparagus was cooked to perfection. It was tender with a slight char that added depth to the flavor. Definitely a great choice for anyone looking for a light side dish.', '5', '2024-10-18 17:43:56'),
(395, 1, 143, 'KingU', 'Grilled Asparagus was fresh and tasty. The grilling brought out a subtle smoky flavor, and the seasoning was just right. It made for a great accompaniment to my meal.', '4', '2024-10-18 17:43:56'),
(396, 12, 143, 'krishna', 'The Grilled Asparagus had a nice, smoky char on the outside but was still tender and flavorful on the inside. A great side dish that was both healthy and delicious.', '5', '2024-10-18 17:43:56'),
(397, 10, 143, 'Aman123', 'I loved the Grilled Asparagus! It was cooked perfectly with a slight crisp, and the smoky flavor was subtle yet delicious. A perfect light and healthy side dish for any meal.', '5', '2024-10-18 17:43:56'),
(398, 9, 143, 'withOutImage', 'Grilled Asparagus was a pleasant surprise. It was tender and had a nice grilled flavor. I could taste the freshness of the asparagus, and the seasoning was spot on.', '4', '2024-10-18 17:43:56'),
(399, 16, 145, 'john_doe', 'The Eggplant Parmesan was fantastic! The layers of crispy eggplant, tangy tomato sauce, and melted cheese were absolutely perfect. It was rich and satisfying, yet still felt light enough for a healthy meal.', '5', '2024-10-18 17:44:42'),
(400, 3, 145, 'jane_smith', 'I really enjoyed the Eggplant Parmesan. The eggplant was well-cooked, and the cheese was perfectly melted. The tomato sauce added just the right amount of tang. A well-balanced and flavorful dish.', '4', '2024-10-18 17:44:42'),
(401, 14, 145, 'alex_jones', 'Eggplant Parmesan was decent. The flavors were good, but I felt like the eggplant could have been crispier. Still, it was a hearty meal with a rich combination of flavors.', '3', '2024-10-18 17:44:42'),
(402, 7, 145, 'Aman30', 'The Eggplant Parmesan was delicious! The eggplant was crispy on the outside and tender on the inside, with a flavorful sauce that brought everything together. A great option for vegetarians.', '5', '2024-10-18 17:44:42'),
(404, 2, 145, 'Aman1232', 'Eggplant Parmesan was excellent. The crispy layers of eggplant combined with the savory tomato sauce and cheese made for a comforting and flavorful meal. One of my favorite vegetarian dishes.', '5', '2024-10-18 17:44:42'),
(405, 1, 145, 'KingU', 'The Eggplant Parmesan had great flavor, though I wish the eggplant had been a bit crispier. The sauce and cheese were well-balanced, making it a hearty and satisfying meal overall.', '4', '2024-10-18 17:44:42'),
(406, 12, 145, 'krishna', 'Eggplant Parmesan was well-executed. The combination of tender eggplant, cheesy layers, and rich tomato sauce made it a delicious and comforting meal. A great choice for eggplant lovers!', '5', '2024-10-18 17:44:42'),
(407, 10, 145, 'Aman123', 'Eggplant Parmesan was fantastic! The eggplant was perfectly fried, with a nice crunch, and the tomato sauce was tangy and flavorful. A well-balanced dish with great textures.', '5', '2024-10-18 17:44:42'),
(408, 9, 145, 'withOutImage', 'Eggplant Parmesan was a tasty dish. The cheese was melted perfectly, and the tomato sauce had a nice tang. The eggplant itself was cooked well, but could have been a bit crispier.', '4', '2024-10-18 17:44:42'),
(409, 16, 146, 'john_doe', 'The Chickpea Curry was amazing! The chickpeas were tender, and the curry sauce was rich and flavorful with a perfect blend of spices. It’s a great vegetarian dish, full of protein.', '5', '2024-10-18 17:47:23'),
(410, 3, 146, 'jane_smith', 'I absolutely loved the Chickpea Curry! The curry sauce was thick and flavorful, and the chickpeas were cooked perfectly. It was hearty, healthy, and made for a very satisfying meal.', '5', '2024-10-18 17:47:23'),
(411, 14, 146, 'alex_jones', 'Chickpea Curry was quite good. The curry had a nice spicy kick to it, and the chickpeas were cooked to perfection. A great option for a filling and nutritious vegetarian meal.', '4', '2024-10-18 17:47:23'),
(412, 7, 146, 'Aman30', 'The Chickpea Curry had an excellent balance of flavors. The spices were not overwhelming, and the chickpeas absorbed all the flavors well. Definitely a satisfying and healthy dish.', '5', '2024-10-18 17:47:23'),
(414, 2, 146, 'Aman1232', 'Chickpea Curry was hearty and packed with flavor. The chickpeas were soft and well-seasoned, and the curry was rich in flavor. It was a filling and healthy meal that I really enjoyed.', '4', '2024-10-18 17:47:23'),
(415, 1, 146, 'KingU', 'The Chickpea Curry was pretty good. The curry was flavorful and had the right amount of heat, and the chickpeas were cooked just right. A solid vegetarian option that I would order again.', '4', '2024-10-18 17:47:23'),
(416, 12, 146, 'krishna', 'Chickpea Curry was delightful! The chickpeas were soft and soaked up all the wonderful spices. The curry sauce was thick and creamy, making it a perfect vegetarian meal. Loved it!', '5', '2024-10-18 17:47:23'),
(417, 10, 146, 'Aman123', 'Chickpea Curry was a delicious surprise! The spices were well-balanced, and the chickpeas were tender. It was hearty, filling, and perfect for a healthy vegetarian meal.', '5', '2024-10-18 17:47:23'),
(418, 9, 146, 'withOutImage', 'Chickpea Curry had great flavor, but I found the spices a bit too strong for my taste. However, the chickpeas were cooked perfectly and the dish was still satisfying overall.', '3', '2024-10-18 17:47:23'),
(419, 16, 147, 'john_doe', 'The Burger was fantastic! The patty was juicy and flavorful, the buns were perfectly toasted, and the toppings were fresh. A perfect combination of savory flavors that satisfied my cravings.', '5', '2024-10-18 17:47:33'),
(420, 3, 147, 'jane_smith', 'I had the Burger, and it was absolutely delicious. The beef patty was cooked to perfection, and the sauce added a nice tangy flavor. Definitely one of the best burgers I’ve ever had!', '5', '2024-10-18 17:47:33'),
(421, 14, 147, 'alex_jones', 'This Burger was solid. The patty had a great char, the vegetables were fresh, and the sauce was a nice touch. It could have been a bit juicier, but overall, a satisfying meal.', '4', '2024-10-18 17:47:33'),
(422, 7, 147, 'Aman30', 'The Burger was good, but I was hoping for a bit more flavor in the seasoning. The meat was tender, and the condiments were great. A solid burger, just not extraordinary.', '3', '2024-10-18 17:47:33'),
(424, 2, 147, 'Aman1232', 'This Burger was tasty and fulfilling. The beef patty was perfectly cooked, and the toppings really elevated the flavor. The combination of flavors made for a great bite every time.', '5', '2024-10-18 17:47:33'),
(425, 1, 147, 'KingU', 'The Burger was decent. While the meat was well-cooked and juicy, I felt like the sauce could’ve used a bit more flavor. Nonetheless, the overall taste was good, and I enjoyed it.', '4', '2024-10-18 17:47:33'),
(426, 12, 147, 'krishna', 'The Burger was amazing! It had all the right ingredients—fresh lettuce, a perfectly cooked patty, and a delicious sauce. The flavors blended together perfectly, making this one of the best burgers.', '5', '2024-10-18 17:47:33'),
(427, 10, 147, 'Aman123', 'The Burger was tasty, but not the best I’ve had. The patty was flavorful, and the toppings were good, but the bun got soggy quickly. Still, a decent meal that I would try again.', '4', '2024-10-18 17:47:33'),
(428, 9, 147, 'withOutImage', 'The Burger was okay. While the beef was cooked well, the flavors didn’t pop as much as I expected. The bun was a little too soft for my liking. It was an average burger experience.', '3', '2024-10-18 17:47:33'),
(429, 16, 148, 'john_doe', 'The Almond Milk Smoothie was refreshing and light. The blend of almond milk with fresh fruits was delicious, and it was a great way to start my morning. Perfect for a healthy boost!', '5', '2024-10-18 17:47:58'),
(430, 3, 148, 'jane_smith', 'This Almond Milk Smoothie is a game-changer! It’s so creamy and smooth, with a subtle nutty flavor. The combination of fruits adds a perfect balance, making it a healthy and tasty treat!', '5', '2024-10-18 17:47:58'),
(431, 14, 148, 'alex_jones', 'I loved the Almond Milk Smoothie! It’s the perfect drink when I need a quick, nutritious snack. The almond milk gives it a nice texture, and the fruit flavors are well-balanced. Highly recommend!', '4', '2024-10-18 17:47:58'),
(432, 7, 148, 'Aman30', 'The Almond Milk Smoothie is decent, but I expected a bit more flavor. It was refreshing, but I think adding a little more sweetness or flavor would make it perfect for my taste.', '3', '2024-10-18 17:47:58'),
(434, 2, 148, 'Aman1232', 'The Almond Milk Smoothie was good but a bit too thick for my liking. It was still tasty and refreshing, with a great blend of almond and fruit flavors. A healthy option for sure.', '4', '2024-10-18 17:47:58'),
(435, 1, 148, 'KingU', 'This Almond Milk Smoothie was solid. The almond milk gave it a smooth texture, but I felt the fruit could have been more vibrant. Overall, a satisfying and nutritious drink.', '4', '2024-10-18 17:47:58'),
(436, 12, 148, 'krishna', 'The Almond Milk Smoothie was fantastic! The smoothness of the almond milk paired beautifully with the fresh fruit, making it a refreshing and nourishing drink. Perfect for a midday boost!', '5', '2024-10-18 17:47:58'),
(437, 10, 148, 'Aman123', 'The Almond Milk Smoothie was tasty but not very exciting. It had a good balance of flavors, but I would love to see a wider variety of fruits included to enhance the taste.', '3', '2024-10-18 17:47:58'),
(438, 9, 148, 'withOutImage', 'I really enjoyed the Almond Milk Smoothie. It’s smooth and creamy, with a refreshing taste. The almond milk adds a subtle nuttiness, and the fruit flavors are balanced and delicious.', '5', '2024-10-18 17:47:58'),
(439, 16, 149, 'john_doe', 'The Tofu Scramble was absolutely delicious! The texture was perfectly scrambled, and the flavors were spot-on. It felt light yet filling, making it an excellent breakfast option for any time of the day.', '5', '2024-10-18 17:48:23'),
(440, 3, 149, 'jane_smith', 'I tried the Tofu Scramble for the first time and was pleasantly surprised. The tofu was well-seasoned, and the veggies added a nice crunch. A healthy and satisfying dish that’s perfect for a quick meal!', '5', '2024-10-18 17:48:23'),
(441, 14, 149, 'alex_jones', 'The Tofu Scramble was pretty good but could use a bit more seasoning. The texture was great, and the addition of vegetables made it a healthy choice. Would love to try it again with a little more spice.', '4', '2024-10-18 17:48:23'),
(442, 7, 149, 'Aman30', 'This Tofu Scramble was okay, but I felt it was lacking in flavor. The tofu itself was cooked well, but I would have preferred more seasoning or some extra ingredients to enhance the taste.', '3', '2024-10-18 17:48:23'),
(444, 2, 149, 'Aman1232', 'The Tofu Scramble was good, but I felt it needed more vegetables or seasoning to really bring out the flavor. Overall, it was a healthy and satisfying option for breakfast.', '4', '2024-10-18 17:48:23'),
(445, 1, 149, 'KingU', 'The Tofu Scramble was a great option for those looking for a vegan breakfast. The tofu was cooked well, and the seasoning was decent, but I think it could be even better with a little more spice.', '4', '2024-10-18 17:48:23'),
(446, 12, 149, 'krishna', 'I absolutely loved the Tofu Scramble! It’s a great alternative to scrambled eggs, and the flavor was fantastic. The tofu was fluffy and seasoned perfectly, making it a great choice for a wholesome meal.', '5', '2024-10-18 17:48:23'),
(447, 10, 149, 'Aman123', 'The Tofu Scramble was decent, but I wasn’t blown away. It had good texture and was filling, but the seasoning could have been better. It’s a solid choice for a vegan meal but could use more flavor.', '3', '2024-10-18 17:48:23'),
(448, 9, 149, 'withOutImage', 'I enjoyed the Tofu Scramble! The texture was great, and it had a nice balance of flavors. The veggies added a fresh touch, and the tofu itself was soft and delicious. Definitely worth trying!', '5', '2024-10-18 17:48:23'),
(449, 16, 150, 'john_doe', 'The Smoothie Bowl was amazing! The blend of fruits was refreshing, and the toppings added a nice crunch. It felt both indulgent and healthy, making it the perfect breakfast option to start the day.', '5', '2024-10-18 17:48:49'),
(450, 3, 150, 'jane_smith', 'I absolutely loved the Smoothie Bowl! It was beautifully presented, and the combination of fresh fruits, granola, and seeds made it an energizing and delicious breakfast. A great start to my morning!', '5', '2024-10-18 17:48:49'),
(451, 14, 150, 'alex_jones', 'The Smoothie Bowl was good but could use more variety in the toppings. I loved the creamy texture of the smoothie base, but the bowl felt a bit simple with just the usual fruits and granola.', '4', '2024-10-18 17:48:49'),
(452, 7, 150, 'Aman30', 'I tried the Smoothie Bowl and found it quite tasty! The fruit was fresh, but I would have liked more toppings like nuts or coconut flakes. Overall, it’s a great, healthy option for breakfast.', '4', '2024-10-18 17:48:49'),
(454, 2, 150, 'Aman1232', 'I enjoyed the Smoothie Bowl but found it to be a little too sweet for my taste. The mix of fruits was good, but I think less sugar or more savory toppings could improve it.', '3', '2024-10-18 17:48:49'),
(455, 1, 150, 'KingU', 'The Smoothie Bowl was pretty good, but it felt like something was missing. The fruit was fresh, and the base was creamy, but I think it could have used more variety in the toppings for added texture.', '4', '2024-10-18 17:48:49'),
(456, 12, 150, 'krishna', 'I loved this Smoothie Bowl! The flavors were fantastic, and the toppings like granola, seeds, and coconut flakes gave it a wonderful crunch. It was a perfect balance of sweet and healthy.', '5', '2024-10-18 17:48:49'),
(457, 10, 150, 'Aman123', 'The Smoothie Bowl was okay but not exceptional. The fruit was fresh, but the overall flavor was a bit bland. I’d like to see more variety in the toppings or a more flavorful base next time.', '3', '2024-10-18 17:48:49'),
(458, 9, 150, 'withOutImage', 'The Smoothie Bowl was delicious! The fresh fruit and the creamy texture made it an enjoyable breakfast. I liked the added crunch from the granola, and the chia seeds made it even better. Definitely a must-try!', '5', '2024-10-18 17:48:49'),
(459, 16, 153, 'john_doe', 'The Pasta was absolutely delicious! The sauce was creamy, and the noodles were cooked perfectly. It’s the kind of comforting dish that feels like a warm hug for your soul.', '5', '2024-10-18 17:50:00'),
(460, 3, 153, 'jane_smith', 'I loved the Pasta! The balance of flavors was perfect, and the texture of the pasta was just right. It’s a classic dish that’s always satisfying, especially when paired with garlic bread.', '5', '2024-10-18 17:50:00'),
(461, 14, 153, 'alex_jones', 'The Pasta was good, but I felt it lacked a bit of seasoning. The noodles were al dente, and the sauce was flavorful, but a little more spice would have made it perfect.', '4', '2024-10-18 17:50:00'),
(462, 7, 153, 'Aman30', 'This Pasta was amazing! The sauce was rich and the pasta was cooked to perfection. It was a comforting and hearty meal, ideal for a cozy evening at home.', '5', '2024-10-18 17:50:00'),
(464, 2, 153, 'Aman1232', 'The Pasta was decent, but it felt a bit heavy. The flavors were good, but the sauce could have used a touch more freshness. It’s a solid dish but not exceptional.', '3', '2024-10-18 17:50:00'),
(465, 1, 153, 'KingU', 'The Pasta was quite good, but it didn’t blow me away. The sauce was creamy, and the pasta was cooked well, but I expected more flavors to make it stand out.', '3', '2024-10-18 17:50:00'),
(466, 12, 153, 'krishna', 'The Pasta was really tasty! I loved how the sauce and pasta worked together. The flavors were well-rounded, and it was the perfect comfort food. Highly recommend trying it!', '5', '2024-10-18 17:50:00'),
(467, 10, 153, 'Aman123', 'The Pasta was okay, but I felt it was missing something. The sauce was creamy, but it didn’t have enough seasoning. A bit more spice would have elevated the dish.', '3', '2024-10-18 17:50:00'),
(468, 9, 153, 'withOutImage', 'The Pasta was delicious! The sauce was flavorful, and the pasta was cooked just right. I loved the dish, especially with a sprinkle of parmesan. Perfect comfort food!', '5', '2024-10-18 17:50:00'),
(469, 16, 152, 'john_doe', 'Pav Bhaji was excellent! The blend of vegetables in the bhaji was perfectly spiced, and the pav was soft and buttery. It’s a classic street food made to perfection!', '5', '2024-10-18 17:50:09'),
(470, 3, 152, 'jane_smith', 'The Pav Bhaji was fantastic! The vegetables were well-cooked, and the spices were just right. The pav was soft and buttery, making it an irresistible comfort food experience.', '5', '2024-10-18 17:50:09'),
(471, 14, 152, 'alex_jones', 'The Pav Bhaji was tasty, but I felt like it could use a bit more spice. The pav was soft and buttery, and the bhaji had a good mix of flavors, though it was slightly bland.', '4', '2024-10-18 17:50:09'),
(472, 7, 152, 'Aman30', 'Pav Bhaji is one of my favorite street foods, and this version did not disappoint! The bhaji was flavorful, and the pav was buttery. I thoroughly enjoyed it!', '5', '2024-10-18 17:50:09'),
(474, 2, 152, 'Aman1232', 'Pav Bhaji was good, but I expected a bit more kick from the spices. The bhaji was flavorful, but I feel like it could have been a bit more vibrant in taste.', '3', '2024-10-18 17:50:09'),
(475, 1, 152, 'KingU', 'The Pav Bhaji was decent, but it didn’t blow me away. The bhaji was well-seasoned, but I would’ve liked the pav to be more crispy, and the flavor was just okay.', '3', '2024-10-18 17:50:09'),
(476, 12, 152, 'krishna', 'The Pav Bhaji was absolutely delicious! The flavor of the bhaji was rich and spicy, and the pav was soft. It was a perfect combination of textures and tastes that I loved!', '5', '2024-10-18 17:50:09'),
(477, 10, 152, 'Aman123', 'The Pav Bhaji was alright, but not my favorite. The bhaji lacked depth in flavor, and the pav wasn’t as buttery as I expected. It was decent, but not something I’d crave.', '3', '2024-10-18 17:50:09'),
(478, 9, 152, 'withOutImage', 'Pav Bhaji was great! The bhaji was flavorful, with just the right amount of spice, and the pav was soft and buttery. It’s a great street food choice for anyone who loves bold flavors!', '5', '2024-10-18 17:50:09'),
(479, 16, 151, 'john_doe', 'The Pizza was phenomenal! The crust was thin and crispy, and the toppings were fresh. The balance of cheese and sauce was perfect, making it one of the best pizzas I’ve ever had.', '5', '2024-10-18 17:50:17'),
(480, 3, 151, 'jane_smith', 'This Pizza was outstanding! The crust was thin and the cheese melted beautifully. The toppings were fresh, and the combination of flavors was absolutely delightful. Highly recommend trying it!', '5', '2024-10-18 17:50:17'),
(481, 14, 151, 'alex_jones', 'The Pizza was good, but I expected a bit more from the crust. The toppings were fresh and flavorful, but the crust didn’t have the crispy texture I was hoping for.', '4', '2024-10-18 17:50:17'),
(482, 7, 151, 'Aman30', 'I tried the Pizza, and it was delicious! The toppings were fresh, and the sauce was just the right amount of tangy. I loved the thin, crispy crust as well. Definitely a great pizza!', '5', '2024-10-18 17:50:17'),
(484, 2, 151, 'Aman1232', 'The Pizza was alright, but I feel it could use more seasoning. The toppings were fresh, but the flavor felt a bit flat, and the crust wasn’t as crispy as I’d like.', '3', '2024-10-18 17:50:17'),
(485, 1, 151, 'KingU', 'Pizza was decent, but I expected a bit more from it. The toppings were good, and the sauce was flavorful, but the crust didn’t have that extra crunch that makes a pizza great.', '3', '2024-10-18 17:50:17'),
(486, 12, 151, 'krishna', 'This Pizza was amazing! The crust was crispy, and the combination of toppings was perfect. I loved the richness of the cheese and the tangy sauce. Definitely worth trying!', '5', '2024-10-18 17:50:17'),
(487, 10, 151, 'Aman123', 'The Pizza was good, but not extraordinary. The crust was thin, but it lacked a bit of flavor. The toppings were fine, though nothing that really stood out for me.', '3', '2024-10-18 17:50:17'),
(488, 9, 151, 'withOutImage', 'Pizza was delicious! The crust was perfectly crispy, and the cheese was melted to perfection. The toppings were fresh, and the balance of flavors was spot-on. I loved every bite!', '5', '2024-10-18 17:50:17'),
(489, 16, 240, 'john_doe', 'The Lentil Soup was hearty and flavorful! The lentils were tender, and the broth had just the right amount of spices. It’s a perfect meal for chilly days!', '5', '2024-10-18 17:56:21'),
(490, 3, 240, 'jane_smith', 'I loved the Lentil Soup! It was packed with flavor and had a great texture. The lentils were perfectly cooked, and the seasoning was spot on. Highly recommend it!', '5', '2024-10-18 17:56:21'),
(491, 14, 240, 'alex_jones', 'The Lentil Soup was good, but it felt a bit too salty for my taste. The lentils were cooked well, and the flavors were nice, but I wish it had more variety in vegetables.', '4', '2024-10-18 17:56:21'),
(492, 7, 240, 'Aman30', 'The Lentil Soup was delicious! It was filling and comforting, with the perfect blend of spices. It made for an amazing dinner on a cold evening. Definitely would order again!', '5', '2024-10-18 17:56:21'),
(494, 2, 240, 'Aman1232', 'The Lentil Soup was decent, but I feel like it could use a bit more seasoning. The lentils were good, but the overall taste was a bit bland for my liking.', '3', '2024-10-18 17:56:21'),
(495, 1, 240, 'KingU', 'The Lentil Soup was okay, but I expected more depth in flavor. The lentils were fine, but it felt like it lacked a bit of the richness I enjoy in soups.', '3', '2024-10-18 17:56:21'),
(496, 12, 240, 'krishna', 'The Lentil Soup was fantastic! I loved the hearty texture of the lentils and the depth of flavor in the broth. It was warm, satisfying, and perfect for a cold day!', '5', '2024-10-18 17:56:21'),
(497, 10, 240, 'Aman123', 'The Lentil Soup was alright, but it didn’t quite hit the mark. The flavor was good, but the soup could have been a bit thicker and more flavorful overall.', '3', '2024-10-18 17:56:21'),
(498, 9, 240, 'withOutImage', 'The Lentil Soup was really tasty! The lentils were cooked well, and the broth was flavorful. It was the perfect soup for a cozy winter evening. Definitely a great choice!', '5', '2024-10-18 17:56:21'),
(499, 16, 239, 'john_doe', 'The Overnight Oats with Chia Seeds were amazing! It was so refreshing, with a perfect balance of flavors. The chia seeds added a great texture, and the oats were soft and creamy.', '5', '2024-10-18 17:56:28'),
(500, 3, 239, 'jane_smith', 'I absolutely loved the Overnight Oats with Chia Seeds! The oats were soft, and the chia seeds added a great texture. It was a perfect healthy breakfast that kept me full for hours.', '5', '2024-10-18 17:56:28'),
(501, 14, 239, 'alex_jones', 'The Overnight Oats with Chia Seeds were good, but I felt like they were a bit too thick for my taste. The flavor was nice, but I would’ve preferred a lighter consistency.', '4', '2024-10-18 17:56:28'),
(502, 7, 239, 'Aman30', 'The Overnight Oats with Chia Seeds were delicious! The oats were creamy, and the chia seeds added a nice texture. I loved the combination of flavors, and it made for a filling breakfast.', '5', '2024-10-18 17:56:28'),
(504, 2, 239, 'Aman1232', 'The Overnight Oats with Chia Seeds were good, but I felt like they were a bit bland. They could’ve used more fruit or a bit of sweetness to make them more flavorful.', '3', '2024-10-18 17:56:28'),
(505, 1, 239, 'KingU', 'The Overnight Oats with Chia Seeds were alright, but I expected more flavor. They were a bit plain for my taste, and the texture of the oats could have been better as well.', '3', '2024-10-18 17:56:28'),
(506, 12, 239, 'krishna', 'The Overnight Oats with Chia Seeds were fantastic! The oats were creamy, and the chia seeds added a great crunch. It was a perfect and healthy way to start my morning.', '5', '2024-10-18 17:56:28'),
(507, 10, 239, 'Aman123', 'The Overnight Oats with Chia Seeds were fine, but they didn’t wow me. The texture was good, but I felt like they could use more flavor or toppings to make it more interesting.', '3', '2024-10-18 17:56:28'),
(508, 9, 239, 'withOutImage', 'The Overnight Oats with Chia Seeds were so good! The oats were creamy, and the chia seeds gave it a nice texture. It was filling and kept me energized for the whole morning.', '5', '2024-10-18 17:56:28'),
(509, 16, 238, 'john_doe', 'The Quinoa Salad with Vegetables was fresh and flavorful! The quinoa was perfectly cooked, and the vegetables added a great crunch. It’s a healthy and tasty dish!', '5', '2024-10-18 17:56:38'),
(510, 3, 238, 'jane_smith', 'The Quinoa Salad with Vegetables was fantastic! The combination of quinoa and fresh veggies made it a satisfying and nutritious meal. The dressing was perfect and tied everything together.', '5', '2024-10-18 17:56:38'),
(511, 14, 238, 'alex_jones', 'The Quinoa Salad with Vegetables was good, but I felt like the vegetables were a bit underseasoned. The quinoa was fluffy and light, but the overall flavor could’ve been enhanced.', '4', '2024-10-18 17:56:38'),
(512, 7, 238, 'Aman30', 'The Quinoa Salad with Vegetables was delicious! The quinoa was light and fluffy, and the veggies were fresh and crunchy. It’s a perfect light lunch that’s both healthy and filling.', '5', '2024-10-18 17:56:38'),
(514, 2, 238, 'Aman1232', 'The Quinoa Salad with Vegetables was decent, but I thought the vegetables were a bit too raw for my taste. The quinoa was good, but I prefer a bit more seasoning.', '3', '2024-10-18 17:56:38'),
(515, 1, 238, 'KingU', 'The Quinoa Salad with Vegetables was okay, but it didn’t stand out. The quinoa was cooked well, but the vegetables lacked flavor and could have used more seasoning or a tangy dressing.', '3', '2024-10-18 17:56:38'),
(516, 12, 238, 'krishna', 'The Quinoa Salad with Vegetables was delicious! The combination of quinoa and fresh vegetables was perfect, and the dressing added a nice zing. It’s a perfect healthy meal!', '5', '2024-10-18 17:56:38'),
(517, 10, 238, 'Aman123', 'The Quinoa Salad with Vegetables was fine, but I didn’t love it. The vegetables were a bit bland, and I expected more flavor from the dressing. It was just an average salad.', '3', '2024-10-18 17:56:38'),
(518, 9, 238, 'withOutImage', 'The Quinoa Salad with Vegetables was fantastic! The quinoa was light, and the fresh veggies gave it a nice crunch. The dressing was perfect, making this a healthy and satisfying meal.', '5', '2024-10-18 17:56:38'),
(519, 16, 237, 'john_doe', 'The Strawberry Banana Smoothie was delicious! The flavors of fresh strawberries and bananas blended perfectly. It was refreshing and filling – a perfect smoothie for any time of day.', '5', '2024-10-18 17:56:47'),
(520, 3, 237, 'jane_smith', 'I loved the Strawberry Banana Smoothie! The sweetness of the strawberries and bananas made it taste like dessert, but it was light and refreshing. Highly recommend for a tasty pick-me-up.', '5', '2024-10-18 17:56:47'),
(521, 14, 237, 'alex_jones', 'The Strawberry Banana Smoothie was good, but I feel like it could use more strawberries. The banana flavor was strong, but I wanted a bit more tartness from the berries.', '4', '2024-10-18 17:56:47'),
(522, 7, 237, 'Aman30', 'The Strawberry Banana Smoothie was fantastic! The strawberries and bananas blended together perfectly. It was sweet and smooth with just the right amount of creaminess. Loved it!', '5', '2024-10-18 17:56:47'),
(524, 2, 237, 'Aman1232', 'The Strawberry Banana Smoothie was good, but it felt a bit too sweet for my taste. The banana flavor was a bit overpowering, and I wish it had a bit more tartness from the strawberries.', '3', '2024-10-18 17:56:47'),
(525, 1, 237, 'KingU', 'The Strawberry Banana Smoothie was okay. The banana flavor was a bit too strong for me, and the smoothie could have been a bit thicker. It was refreshing but not outstanding.', '3', '2024-10-18 17:56:47'),
(526, 12, 237, 'krishna', 'The Strawberry Banana Smoothie was incredible! The combination of strawberries and bananas made it so delicious. It was refreshing, healthy, and perfect for a morning boost or a post-workout snack.', '5', '2024-10-18 17:56:47'),
(527, 10, 237, 'Aman123', 'The Strawberry Banana Smoothie was fine, but I expected a bit more flavor. The banana overpowered the strawberries, and the texture was a bit runny for my liking.', '3', '2024-10-18 17:56:47'),
(528, 9, 237, 'withOutImage', 'The Strawberry Banana Smoothie was so tasty! The fresh strawberries and bananas made it sweet and refreshing. It was the perfect snack to energize me during a busy day.', '5', '2024-10-18 17:56:47'),
(529, 16, 236, 'john_doe', 'The Berry Smoothie was amazing! The blend of mixed berries created the perfect balance of sweet and tart. It was so refreshing and kept me energized throughout the day!', '5', '2024-10-18 17:57:34'),
(530, 3, 236, 'jane_smith', 'I loved the Berry Smoothie! The combination of berries was refreshing, and it had just the right amount of sweetness. It was a delicious and nutritious drink for any time of day!', '5', '2024-10-18 17:57:34'),
(531, 14, 236, 'alex_jones', 'The Berry Smoothie was good, but I thought the flavor was a bit too sweet. The berries were fresh, but I wish the smoothie had a bit more tartness and less sugar.', '4', '2024-10-18 17:57:34'),
(532, 7, 236, 'Aman30', 'The Berry Smoothie was fantastic! It was full of flavor and really refreshing. The berries were a great combination, and the smoothie was just the right consistency – not too thick or thin.', '5', '2024-10-18 17:57:34'),
(534, 2, 236, 'Aman1232', 'The Berry Smoothie was good, but I felt like the sweetness was a bit much. The berries tasted fresh, but I would’ve preferred a more balanced flavor.', '3', '2024-10-18 17:57:34'),
(535, 1, 236, 'KingU', 'The Berry Smoothie was alright. The berries were fresh, but the smoothie was a bit too sweet and lacked the tanginess I was hoping for. It wasn’t my favorite.', '3', '2024-10-18 17:57:34'),
(536, 12, 236, 'krishna', 'The Berry Smoothie was absolutely delicious! The blend of berries created the perfect drink. It was refreshing and packed with flavor – a great way to get some vitamins and energy.', '5', '2024-10-18 17:57:34'),
(537, 10, 236, 'Aman123', 'The Berry Smoothie was fine, but I expected a bit more flavor. It was refreshing, but I wish it had more of the tartness from the berries to balance the sweetness.', '3', '2024-10-18 17:57:34'),
(538, 9, 236, 'withOutImage', 'The Berry Smoothie was so tasty! The berries gave it a great burst of flavor, and it was the perfect drink to enjoy during a hot day. Highly recommend it!', '5', '2024-10-18 17:57:34'),
(539, 16, 235, 'john_doe', 'The Vegan Pizza was amazing! The crust was perfectly thin and crispy, and the toppings were fresh and flavorful. It was a delicious vegan option that I will definitely order again.', '5', '2024-10-18 17:57:48'),
(540, 3, 235, 'jane_smith', 'I loved the Vegan Pizza! The crust was crunchy and light, and the toppings were fresh and flavorful. It was the perfect plant-based pizza that I could eat over and over again.', '5', '2024-10-18 17:57:48'),
(541, 14, 235, 'alex_jones', 'The Vegan Pizza was good, but I thought the toppings were a bit sparse. The crust was nice, but the overall flavor could’ve been more pronounced. Still, it was a decent vegan pizza.', '4', '2024-10-18 17:57:48'),
(542, 7, 235, 'Aman30', 'The Vegan Pizza was fantastic! The crust was perfectly crispy, and the vegan cheese was delicious. The fresh veggies and toppings made it a satisfying and flavorful pizza experience.', '5', '2024-10-18 17:57:48'),
(544, 2, 235, 'Aman1232', 'The Vegan Pizza was decent, but I felt like the cheese was a bit too rubbery for my liking. The crust was good, but I wanted more flavor from the toppings.', '3', '2024-10-18 17:57:48'),
(545, 1, 235, 'KingU', 'The Vegan Pizza was okay, but it didn’t live up to my expectations. The crust was too thin, and the toppings were not as flavorful as I hoped. I probably wouldn’t order it again.', '3', '2024-10-18 17:57:48'),
(546, 12, 235, 'krishna', 'The Vegan Pizza was incredible! The crust was light and crispy, and the toppings were fresh and flavorful. It was the perfect vegan pizza and a great alternative to the traditional version.', '5', '2024-10-18 17:57:48'),
(547, 10, 235, 'Aman123', 'The Vegan Pizza was fine, but I expected more from the toppings. The crust was good, but it felt like it lacked the punch I wanted from a pizza.', '3', '2024-10-18 17:57:48'),
(548, 9, 235, 'withOutImage', 'The Vegan Pizza was delicious! The crust was perfectly crispy, and the toppings were fresh and flavorful. It’s a great vegan pizza option for those looking for a plant-based meal.', '5', '2024-10-18 17:57:48'),
(549, 16, 266, 'john_doe', 'The Vegan Burger was delicious! The patty was flavorful, and the bun was soft yet crispy. It was the perfect plant-based burger that I will definitely order again.', '5', '2024-10-18 17:58:20'),
(550, 3, 266, 'jane_smith', 'I loved the Vegan Burger! The flavors were well-balanced, and the patty was juicy and satisfying. A great option for anyone looking for a tasty vegan meal.', '5', '2024-10-18 17:58:20'),
(551, 14, 266, 'alex_jones', 'The Vegan Burger was good, but I thought the flavors were a bit mild. The patty was nice, but I would have preferred a bit more seasoning and spice.', '4', '2024-10-18 17:58:20'),
(552, 7, 266, 'Aman30', 'The Vegan Burger was fantastic! The patty had a great texture, and the toppings were fresh and flavorful. I loved the sauce – it made the burger stand out.', '5', '2024-10-18 17:58:20'),
(554, 2, 266, 'Aman1232', 'The Vegan Burger was good, but the patty was a bit dry for my taste. The flavors were okay, but it could have been a bit more flavorful.', '3', '2024-10-18 17:58:20'),
(555, 1, 266, 'KingU', 'The Vegan Burger was okay, but it didn’t quite live up to my expectations. The patty was a bit too dry, and the toppings weren’t very exciting.', '3', '2024-10-18 17:58:20'),
(556, 12, 266, 'krishna', 'The Vegan Burger was incredible! The flavors were perfect, and the patty had the right texture. Definitely one of the best vegan burgers I’ve ever had.', '5', '2024-10-18 17:58:20'),
(557, 10, 266, 'Aman123', 'The Vegan Burger was fine, but I felt like it needed more seasoning. The texture was good, but I was hoping for more flavor from the patty.', '3', '2024-10-18 17:58:20'),
(558, 9, 266, 'withOutImage', 'The Vegan Burger was tasty! The patty was juicy, and the burger as a whole was satisfying. Great vegan option for anyone craving a burger.', '5', '2024-10-18 17:58:20'),
(559, 16, 254, 'john_doe', 'The Homemade Bread and Hummus was delicious! The bread was soft and warm, and the hummus was creamy and flavorful. A perfect snack or meal.', '5', '2024-10-18 17:58:30'),
(560, 3, 254, 'jane_smith', 'I loved the Homemade Bread and Hummus! The bread was fresh, and the hummus had the right amount of seasoning. A great snack for any time of day.', '5', '2024-10-18 17:58:30'),
(561, 14, 254, 'alex_jones', 'The Homemade Bread and Hummus was good, but I thought the bread could have been a bit softer. The hummus was tasty but could use a bit more flavor.', '4', '2024-10-18 17:58:30'),
(562, 7, 254, 'Aman30', 'The Homemade Bread and Hummus was fantastic! The bread was warm and fresh, and the hummus was creamy and smooth. A perfect pairing!', '5', '2024-10-18 17:58:30'),
(564, 2, 254, 'Aman1232', 'The Homemade Bread and Hummus was decent, but the bread was a bit dry for my taste. The hummus was good but lacked a bit of seasoning.', '3', '2024-10-18 17:58:30'),
(565, 1, 254, 'KingU', 'The Homemade Bread and Hummus was okay. The bread was a bit too firm, and the hummus didn’t stand out as much as I had hoped.', '3', '2024-10-18 17:58:30'),
(566, 12, 254, 'krishna', 'The Homemade Bread and Hummus was incredible! The bread was soft, and the hummus was rich and flavorful. A fantastic combination.', '5', '2024-10-18 17:58:30'),
(567, 10, 254, 'Aman123', 'The Homemade Bread and Hummus was fine, but the bread could have been softer. The hummus was okay but needed more flavor for my liking.', '3', '2024-10-18 17:58:30'),
(568, 9, 254, 'withOutImage', 'The Homemade Bread and Hummus was delicious! The bread was soft, and the hummus was smooth and flavorful. A great snack or appetizer.', '5', '2024-10-18 17:58:30'),
(569, 16, 252, 'john_doe', 'The Cream Cake was absolutely divine! The cream was so smooth and the cake was moist. A perfect dessert for celebrations.', '5', '2024-10-18 18:01:07'),
(570, 3, 252, 'jane_smith', 'The Cream Cake was delicious! The layers of cream were so rich, and the cake was light and fluffy. A delightful treat.', '5', '2024-10-18 18:01:07'),
(571, 14, 252, 'alex_jones', 'The Cream Cake was good, but I found it to be a bit too sweet for my taste. The texture was great though, and I loved the cream.', '4', '2024-10-18 18:01:07'),
(572, 7, 252, 'Aman30', 'The Cream Cake was fantastic! The cream was perfectly balanced and the cake itself was soft and moist. I would definitely have it again!', '5', '2024-10-18 18:01:07'),
(574, 2, 252, 'Aman1232', 'The Cream Cake was nice, but it felt a bit too rich for me. The texture was good, but I would have preferred a bit less sweetness.', '3', '2024-10-18 18:01:07'),
(575, 1, 252, 'KingU', 'The Cream Cake was okay. It was a bit too sweet, and the cream didn’t quite suit my taste.', '3', '2024-10-18 18:01:07'),
(576, 12, 252, 'krishna', 'The Cream Cake was incredible! The texture was perfect and the cream was heavenly. A must-try for any dessert lover.', '5', '2024-10-18 18:01:07'),
(577, 10, 252, 'Aman123', 'The Cream Cake was fine, but I felt it was a bit too rich. The flavor was good, but the cream was a bit overwhelming for me.', '3', '2024-10-18 18:01:07'),
(578, 9, 252, 'withOutImage', 'The Cream Cake was delicious! The cream was smooth and the cake was light. Definitely a dessert I would recommend.', '5', '2024-10-18 18:01:07'),
(579, 16, 251, 'john_doe', 'The Fresh Fruit was refreshing! The fruits were perfectly ripe, and the variety was amazing. A healthy and tasty choice for a snack.', '5', '2024-10-18 18:01:07'),
(580, 3, 251, 'jane_smith', 'The Fresh Fruit was amazing! The selection was vibrant and the taste was just right. A perfect snack to balance out my day.', '5', '2024-10-18 18:01:07'),
(581, 14, 251, 'alex_jones', 'The Fresh Fruit was good, but I felt like some of the fruit could have been a bit sweeter. Still, it was a great healthy option.', '4', '2024-10-18 18:01:07'),
(582, 7, 251, 'Aman30', 'The Fresh Fruit was fantastic! Each piece was juicy and flavorful. A great way to stay healthy and refreshed throughout the day.', '5', '2024-10-18 18:01:07'),
(584, 2, 251, 'Aman1232', 'The Fresh Fruit was fine, but I found a couple of fruits a bit sour. Still, overall it was a good healthy option.', '3', '2024-10-18 18:01:07'),
(585, 1, 251, 'KingU', 'The Fresh Fruit was okay. It was fresh, but I wasn’t really impressed by the variety. I would have preferred a bit more selection.', '3', '2024-10-18 18:01:07'),
(586, 12, 251, 'krishna', 'The Fresh Fruit was incredible! Each fruit was fresh and sweet. It was a perfect snack to keep me energized throughout the day.', '5', '2024-10-18 18:01:07'),
(587, 10, 251, 'Aman123', 'The Fresh Fruit was good, but some of the pieces were a bit too sour for my taste. Overall, it was refreshing though.', '3', '2024-10-18 18:01:07'),
(588, 9, 251, 'withOutImage', 'The Fresh Fruit was great! The variety and freshness made it a perfect choice for a quick and healthy snack.', '5', '2024-10-18 18:01:07'),
(589, 16, 250, 'john_doe', 'The Spicy Foods were absolutely delicious! The heat was just right, and the flavors were bold and vibrant. A perfect choice for spice lovers.', '5', '2024-10-18 18:01:07'),
(590, 3, 250, 'jane_smith', 'The Spicy Foods were great! The spice level was perfect for my taste, and the flavors really stood out. Definitely would eat again.', '5', '2024-10-18 18:01:07'),
(591, 14, 250, 'alex_jones', 'The Spicy Foods were good, but I found them to be a bit too spicy for my liking. The flavors were great though, just a little much on the heat.', '4', '2024-10-18 18:01:07'),
(592, 7, 250, 'Aman30', 'The Spicy Foods were fantastic! The heat was just right and the combination of spices really brought the flavors to life. I loved it!', '5', '2024-10-18 18:01:07'),
(594, 2, 250, 'Aman1232', 'The Spicy Foods were good, but they were a little too hot for me. The flavor was excellent, though, and I enjoyed it overall.', '3', '2024-10-18 18:01:07'),
(595, 1, 250, 'KingU', 'The Spicy Foods were okay. They were too hot for my taste, and I didn’t really enjoy the flavor combination as much as I expected.', '3', '2024-10-18 18:01:07'),
(596, 12, 250, 'krishna', 'The Spicy Foods were incredible! The flavor was amazing, and the spice level was just right. I would definitely order this again.', '5', '2024-10-18 18:01:07'),
(597, 10, 250, 'Aman123', 'The Spicy Foods were fine, but the heat was a bit much for me. The flavors were good, but I prefer a milder spice.', '3', '2024-10-18 18:01:07'),
(598, 9, 250, 'withOutImage', 'The Spicy Foods were really good! The flavors were bold, and the spice level was perfect for someone who enjoys a good kick in their meal.', '5', '2024-10-18 18:01:07'),
(599, 16, 249, 'john_doe', 'The Whole-Grain Bagels were a perfect snack! The texture was great, and the taste was wholesome. A healthier and tasty option for breakfast.', '5', '2024-10-18 18:01:07'),
(600, 3, 249, 'jane_smith', 'The Whole-Grain Bagels were delicious! They were soft inside and had a nice crunch on the outside. A great choice for a light breakfast.', '5', '2024-10-18 18:01:07'),
(601, 14, 249, 'alex_jones', 'The Whole-Grain Bagels were good, but I found them to be a bit too dry for my taste. They had a nice flavor though.', '4', '2024-10-18 18:01:07'),
(602, 7, 249, 'Aman30', 'The Whole-Grain Bagels were fantastic! The texture was spot on, and the flavor was just what I was looking for in a healthy bagel.', '5', '2024-10-18 18:01:07'),
(604, 2, 249, 'Aman1232', 'The Whole-Grain Bagels were fine, but I thought they were a bit too dense. The flavor was good, though, and I enjoyed them overall.', '3', '2024-10-18 18:01:07'),
(605, 1, 249, 'KingU', 'The Whole-Grain Bagels were okay. They weren’t as soft as I expected, and the texture was a bit too heavy for my liking.', '3', '2024-10-18 18:01:07'),
(606, 12, 249, 'krishna', 'The Whole-Grain Bagels were incredible! They had the perfect balance of chewiness and crunch, and the flavor was amazing. Definitely worth trying!', '5', '2024-10-18 18:01:07'),
(607, 10, 249, 'Aman123', 'The Whole-Grain Bagels were fine, but I prefer bagels with a bit more softness. The flavor was good, but the texture didn’t work for me.', '3', '2024-10-18 18:01:07'),
(608, 9, 249, 'withOutImage', 'The Whole-Grain Bagels were really good! The texture was perfect, and the flavor was great. I would definitely recommend these for breakfast.', '5', '2024-10-18 18:01:07'),
(609, 16, 248, 'john_doe', 'The Vegan Banana Bread was delicious! The banana flavor was rich and the texture was moist. Perfect for a healthy yet indulgent snack.', '5', '2024-10-18 18:03:22'),
(610, 3, 248, 'jane_smith', 'The Vegan Banana Bread was amazing! It was soft, flavorful, and not too sweet. A great guilt-free treat for any time of the day.', '5', '2024-10-18 18:03:22'),
(611, 14, 248, 'alex_jones', 'The Vegan Banana Bread was good, but I felt like it needed a bit more sweetness. The texture was perfect though.', '4', '2024-10-18 18:03:22'),
(612, 7, 248, 'Aman30', 'The Vegan Banana Bread was fantastic! The banana flavor was spot on, and the bread itself was moist and flavorful. I would definitely have it again!', '5', '2024-10-18 18:03:22'),
(614, 2, 248, 'Aman1232', 'The Vegan Banana Bread was fine, but I found it to be a bit too dense for my liking. Still, the flavor was good.', '3', '2024-10-18 18:03:22'),
(615, 1, 248, 'KingU', 'The Vegan Banana Bread was okay. The texture was good, but I thought it could have used a bit more sweetness.', '3', '2024-10-18 18:03:22'),
(616, 12, 248, 'krishna', 'The Vegan Banana Bread was incredible! The flavors were rich, and the texture was perfectly moist. It’s a must-try for anyone who loves banana bread.', '5', '2024-10-18 18:03:22'),
(617, 10, 248, 'Aman123', 'The Vegan Banana Bread was fine, but I prefer my banana bread to be a bit sweeter. The texture was nice, though.', '3', '2024-10-18 18:03:22'),
(618, 9, 248, 'withOutImage', 'The Vegan Banana Bread was delicious! The flavor was wonderful, and the texture was just right. A great option for a healthy snack.', '5', '2024-10-18 18:03:22'),
(619, 16, 247, 'john_doe', 'The Gluten-Free Muffins were really good! They were soft, light, and had a nice texture. A great gluten-free option that doesn’t compromise on taste.', '5', '2024-10-18 18:03:22'),
(620, 3, 247, 'jane_smith', 'The Gluten-Free Muffins were amazing! The texture was perfect, and the taste was light and fluffy. I couldn’t even tell they were gluten-free!', '5', '2024-10-18 18:03:22'),
(621, 14, 247, 'alex_jones', 'The Gluten-Free Muffins were good, but I found them to be a bit too dry. The flavor was nice though, and I liked the texture.', '4', '2024-10-18 18:03:22'),
(622, 7, 247, 'Aman30', 'The Gluten-Free Muffins were fantastic! The texture was spot on, and the flavor was light and delicious. Definitely a great gluten-free option!', '5', '2024-10-18 18:03:22'),
(624, 2, 247, 'Aman1232', 'The Gluten-Free Muffins were okay, but they seemed a little dry to me. The flavor was good, though.', '3', '2024-10-18 18:03:22'),
(625, 1, 247, 'KingU', 'The Gluten-Free Muffins were fine. They were a bit dense and dry, but the flavor was decent enough for a gluten-free snack.', '3', '2024-10-18 18:03:22'),
(626, 12, 247, 'krishna', 'The Gluten-Free Muffins were incredible! The flavor was delicious, and the texture was light and fluffy. A perfect gluten-free treat.', '5', '2024-10-18 18:03:22'),
(627, 10, 247, 'Aman123', 'The Gluten-Free Muffins were good, but I thought they could use a bit more moisture. Still, they were tasty overall.', '3', '2024-10-18 18:03:22'),
(628, 9, 247, 'withOutImage', 'The Gluten-Free Muffins were great! They were soft, flavorful, and a fantastic gluten-free option that I would recommend to anyone.', '5', '2024-10-18 18:03:22'),
(629, 16, 246, 'john_doe', 'The Greek Salad was fantastic! The combination of fresh vegetables and feta cheese was perfect. The dressing was light and flavorful, making it a refreshing meal.', '5', '2024-10-18 18:03:23'),
(630, 3, 246, 'jane_smith', 'The Greek Salad was amazing! The vegetables were crisp and fresh, and the feta added a wonderful creaminess. A great healthy choice for any time of the day.', '5', '2024-10-18 18:03:23');
INSERT INTO `ratings` (`RatingID`, `UserID`, `FoodID`, `name`, `feedback`, `Score`, `Date`) VALUES
(631, 14, 246, 'alex_jones', 'The Greek Salad was good, but I felt it needed more seasoning. The vegetables were fresh, but the flavor didn’t pop as much as I expected.', '4', '2024-10-18 18:03:23'),
(632, 7, 246, 'Aman30', 'The Greek Salad was perfect! The crunch of the cucumbers and the creaminess of the feta balanced each other wonderfully. I loved the light and flavorful dressing.', '5', '2024-10-18 18:03:23'),
(634, 2, 246, 'Aman1232', 'The Greek Salad was okay, but I found the vegetables to be a bit bland. The dressing was good, though, and the feta was a nice touch.', '3', '2024-10-18 18:03:23'),
(635, 1, 246, 'KingU', 'The Greek Salad was decent. It was fresh, but I would have liked more seasoning or flavor in the dressing.', '3', '2024-10-18 18:03:23'),
(636, 12, 246, 'krishna', 'The Greek Salad was incredible! The mix of textures and flavors was perfect, and the dressing was the right balance of tangy and light.', '5', '2024-10-18 18:03:23'),
(637, 10, 246, 'Aman123', 'The Greek Salad was fine, but I felt like it was missing something. The ingredients were fresh, but the overall flavor was a bit underwhelming.', '3', '2024-10-18 18:03:23'),
(638, 9, 246, 'withOutImage', 'The Greek Salad was delicious! The fresh veggies and feta cheese made for a fantastic combination. A great healthy meal.', '5', '2024-10-18 18:03:23'),
(639, 16, 245, 'john_doe', 'The Sweet Potato Fries were amazing! Crispy on the outside, tender on the inside, and perfectly seasoned. A great alternative to regular fries.', '5', '2024-10-18 18:03:23'),
(640, 3, 245, 'jane_smith', 'The Sweet Potato Fries were fantastic! They were crispy, flavorful, and not overly greasy. Definitely a healthier option for fries lovers.', '5', '2024-10-18 18:03:23'),
(641, 14, 245, 'alex_jones', 'The Sweet Potato Fries were good, but I found them to be a bit too sweet. The texture was great though, and they were crispy.', '4', '2024-10-18 18:03:23'),
(642, 7, 245, 'Aman30', 'The Sweet Potato Fries were perfect! They were crispy, flavorful, and a great combination of sweet and savory. Definitely a healthier snack option!', '5', '2024-10-18 18:03:23'),
(644, 2, 245, 'Aman1232', 'The Sweet Potato Fries were fine, but I thought they were a bit too sweet for my taste. The texture was good, though.', '3', '2024-10-18 18:03:23'),
(645, 1, 245, 'KingU', 'The Sweet Potato Fries were okay. They were a bit too sweet for me, and I found them a little too soft.', '3', '2024-10-18 18:03:23'),
(646, 12, 245, 'krishna', 'The Sweet Potato Fries were incredible! They were perfectly crispy and the sweetness was just right. A delicious and healthy side dish.', '5', '2024-10-18 18:03:23'),
(647, 10, 245, 'Aman123', 'The Sweet Potato Fries were good, but I thought they could use a bit more seasoning. They were soft and sweet but lacked flavor.', '3', '2024-10-18 18:03:23'),
(648, 9, 245, 'withOutImage', 'The Sweet Potato Fries were delicious! Crispy on the outside, soft on the inside, and perfectly seasoned. A great side dish!', '5', '2024-10-18 18:03:23'),
(649, 16, 244, 'john_doe', 'The Gluten-Free Brownies were delightful! They were rich, fudgy, and had just the right amount of sweetness. A great gluten-free treat that tastes amazing.', '5', '2024-10-18 18:03:23'),
(650, 3, 244, 'jane_smith', 'The Gluten-Free Brownies were fantastic! They were decadent, soft, and rich in chocolate flavor. Definitely a great gluten-free dessert option!', '5', '2024-10-18 18:03:23'),
(651, 14, 244, 'alex_jones', 'The Gluten-Free Brownies were good, but I found them a little dry. The flavor was nice, though, and they were still enjoyable.', '4', '2024-10-18 18:03:23'),
(652, 7, 244, 'Aman30', 'The Gluten-Free Brownies were delicious! They were rich, moist, and full of chocolate flavor. A perfect gluten-free dessert!', '5', '2024-10-18 18:03:23'),
(654, 2, 244, 'Aman1232', 'The Gluten-Free Brownies were okay, but I thought they were a bit too dense. The flavor was good, though.', '3', '2024-10-18 18:03:23'),
(655, 1, 244, 'KingU', 'The Gluten-Free Brownies were fine. They were rich, but a little dry for my taste.', '3', '2024-10-18 18:03:23'),
(656, 12, 244, 'krishna', 'The Gluten-Free Brownies were incredible! They were rich, fudgy, and chocolatey, making for a delicious gluten-free dessert.', '5', '2024-10-18 18:03:23'),
(657, 10, 244, 'Aman123', 'The Gluten-Free Brownies were good, but they could use a little more moisture. The flavor was fine, though.', '3', '2024-10-18 18:03:23'),
(658, 9, 244, 'withOutImage', 'The Gluten-Free Brownies were delicious! Moist, rich, and full of chocolate flavor. A perfect gluten-free dessert.', '5', '2024-10-18 18:03:23'),
(659, 16, 243, 'john_doe', 'The Oatmeal with Fresh Fruit was a perfect breakfast! It was hearty, nutritious, and the combination of oats and fresh fruit made it both delicious and healthy.', '5', '2024-10-18 18:03:23'),
(660, 3, 243, 'jane_smith', 'The Oatmeal with Fresh Fruit was amazing! It was filling, comforting, and the fresh fruit added a great touch of sweetness. Definitely a great way to start the day.', '5', '2024-10-18 18:03:23'),
(661, 14, 243, 'alex_jones', 'The Oatmeal with Fresh Fruit was good, but I felt like it could use a bit more flavor. The fresh fruit was a nice addition though.', '4', '2024-10-18 18:03:23'),
(662, 7, 243, 'Aman30', 'The Oatmeal with Fresh Fruit was perfect! The oats were creamy, and the fruit was fresh and sweet. A great, healthy breakfast option.', '5', '2024-10-18 18:03:23'),
(664, 2, 243, 'Aman1232', 'The Oatmeal with Fresh Fruit was okay, but I found the oatmeal to be a bit bland. The fruit was nice though.', '3', '2024-10-18 18:03:23'),
(665, 1, 243, 'KingU', 'The Oatmeal with Fresh Fruit was fine. It was filling, but a bit plain in flavor.', '3', '2024-10-18 18:03:23'),
(666, 12, 243, 'krishna', 'The Oatmeal with Fresh Fruit was incredible! It was filling, flavorful, and the fresh fruit was the perfect addition. A great way to start the day.', '5', '2024-10-18 18:03:23'),
(667, 10, 243, 'Aman123', 'The Oatmeal with Fresh Fruit was good, but it needed a bit more seasoning or flavor. Still, it was a good, healthy breakfast.', '3', '2024-10-18 18:03:23'),
(668, 9, 243, 'withOutImage', 'The Oatmeal with Fresh Fruit was delicious! The combination of oats and fresh fruit was perfect. A great and healthy breakfast option.', '5', '2024-10-18 18:03:23'),
(669, 16, 242, 'john_doe', 'The Chia Pudding was amazing! It was creamy, flavorful, and packed with nutrients. A great healthy snack or breakfast.', '5', '2024-10-18 18:03:23'),
(670, 3, 242, 'jane_smith', 'The Chia Pudding was fantastic! It was creamy and had a lovely texture. The chia seeds absorbed the flavor well, and it was a delicious, healthy treat.', '5', '2024-10-18 18:03:23'),
(671, 14, 242, 'alex_jones', 'The Chia Pudding was good, but I found the texture a bit too gelatinous for my taste. The flavor was great though.', '4', '2024-10-18 18:03:23'),
(672, 7, 242, 'Aman30', 'The Chia Pudding was perfect! It was smooth, creamy, and flavorful. A great, healthy breakfast option!', '5', '2024-10-18 18:03:23'),
(674, 2, 242, 'Aman1232', 'The Chia Pudding was fine, but I thought it was a bit too thick. The flavor was good though.', '3', '2024-10-18 18:03:23'),
(675, 1, 242, 'KingU', 'The Chia Pudding was okay. It was healthy, but I didn’t really enjoy the texture.', '3', '2024-10-18 18:03:23'),
(676, 12, 242, 'krishna', 'The Chia Pudding was incredible! It was smooth, flavorful, and packed with nutrients. A perfect healthy snack or breakfast.', '5', '2024-10-18 18:03:23'),
(677, 10, 242, 'Aman123', 'The Chia Pudding was good, but it could have been a little thinner. The flavor was nice though.', '3', '2024-10-18 18:03:23'),
(678, 9, 242, 'withOutImage', 'The Chia Pudding was delicious! Smooth, creamy, and full of flavor. A great healthy snack.', '5', '2024-10-18 18:03:23'),
(679, 16, 241, 'john_doe', 'The Vegan Pancakes were amazing! They were light, fluffy, and had a great texture. Perfect for a healthy yet indulgent breakfast.', '5', '2024-10-18 18:03:23'),
(680, 3, 241, 'jane_smith', 'The Vegan Pancakes were fantastic! They were light, fluffy, and had a lovely flavor. A perfect gluten-free breakfast option!', '5', '2024-10-18 18:03:23'),
(681, 14, 241, 'alex_jones', 'The Vegan Pancakes were good, but I felt like they were a little too dense. The flavor was nice though.', '4', '2024-10-18 18:03:23'),
(682, 7, 241, 'Aman30', 'The Vegan Pancakes were perfect! Light, fluffy, and delicious. Definitely one of the best vegan pancakes I’ve ever had.', '5', '2024-10-18 18:03:23'),
(684, 2, 241, 'Aman1232', 'The Vegan Pancakes were fine, but they were a bit dense for my taste. Still, they were tasty.', '3', '2024-10-18 18:03:23'),
(685, 1, 241, 'KingU', 'The Vegan Pancakes were okay. The texture was good, but they lacked flavor and were a bit heavy.', '3', '2024-10-18 18:03:23'),
(686, 12, 241, 'krishna', 'The Vegan Pancakes were incredible! Light, fluffy, and perfectly cooked. A must-try for anyone who loves pancakes.', '5', '2024-10-18 18:03:23'),
(687, 10, 241, 'Aman123', 'The Vegan Pancakes were good, but I thought they could use a bit more flavor. The texture was nice, though.', '3', '2024-10-18 18:03:23'),
(688, 9, 241, 'withOutImage', 'The Vegan Pancakes were delicious! Light, fluffy, and perfect for a healthy breakfast. Highly recommended.', '5', '2024-10-18 18:03:23'),
(692, 19, 146, 'Aman1030', 'This is my feedback on Chickpea Curry.', '5', '2024-10-18 20:35:13'),
(699, 19, 253, 'Aman', 'I love the flavor! It has a unique taste that is hard to find in other dishes. The texture is smooth, and every bite is full of vibrant and rich flavors.', '5', '2024-10-21 13:08:26'),
(701, 28, 143, 'Mosam', 'Vadapav Lasan', '5', '2024-10-23 03:14:23'),
(702, 19, 238, 'Aman', 'This is rating about Quinoa Salad with Vegetables from user Aman.', '5', '2024-11-27 05:43:23');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `ReviewID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `name` varchar(30) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(30) NOT NULL,
  `feedback` text NOT NULL,
  `score` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`ReviewID`, `UserID`, `name`, `Date`, `email`, `feedback`, `score`) VALUES
(15, 2, 'john_doe', '2024-09-28 08:19:20', 'jane.smith@example.com', 'I love the flavor! It has a unique taste that is hard to find in other dishes. The texture is smooth, and every bite is full of vibrant and rich flavors.', 4),
(16, 3, 'jane_smith', '2024-09-28 08:19:20', 'mike@gmail.com', 'Good, but could be better. I enjoyed some parts of the dish, but it lacked seasoning in some areas. With a few tweaks, it could become an excellent meal for everyone.', 3),
(17, 7, 'alex_jones', '2024-09-28 08:19:20', 'emily.davis@example.com', 'Absolutely delicious! I couldn’t stop eating. The spices were perfect, and the balance between all ingredients made it an unforgettable dish. I will definitely order it again next time.', 5),
(19, 2, 'Aman30', '2024-09-28 08:19:20', 'jane.smith@example.com', 'Great texture, and the flavors blend perfectly! I was impressed by how the dish was put together. Each bite had a burst of flavor that was both enjoyable and satisfying.', 4),
(20, 3, 'jane_smith', '2024-09-28 08:19:20', 'mike.johnson@example.com', 'Highly recommend! The presentation was wonderful, and the taste exceeded my expectations. Everything about the meal was perfectly balanced, and I enjoyed every single bite of it.', 5),
(21, 7, 'Aman1232', '2024-09-28 08:19:20', 'emily.davis@example.com', 'Not my favorite, but it wasn’t bad either. The flavor could be improved, and I think the ingredients didn’t mix well. However, it’s a decent option for a quick meal.', 2),
(29, 16, 'a1', '2024-10-03 04:44:34', 'a1@gmail.com', 'The product was excellent and exceeded all my expectations. I will definitely be ordering it again.', 5),
(30, 16, 'a1', '2024-10-03 04:44:34', 'a1@gmail.com', 'The food was okay, but I felt like the flavor could have been stronger. It lacked the punch I was expecting.', 4),
(31, 16, 'a1', '2024-10-03 04:44:34', 'a1@gmail.com', 'I absolutely loved this dish! The flavors were spot on and everything was cooked to perfection. Will order again.', 5),
(32, 16, 'a1', '2024-10-03 04:44:34', 'a1@gmail.com', 'I loved this dish! The flavors were rich, and it arrived fresh and hot. Can’t wait to order more.', 3),
(33, 16, 'a1', '2024-10-03 04:44:34', 'a1@gmail.com', 'Excellent quality and fantastic taste! I’m impressed with the service and will recommend it to my friends.', 4),
(43, 7, 'Aman11', '2024-10-15 11:11:13', 'amanpatel30@gmail.com', 'this is my review.', 4),
(54, 1, 'john_doe', '2024-09-01 04:30:00', 'john@example.com', 'Amazing experience! The flavors were incredible and the presentation was top-notch.', 5),
(55, 2, 'jane_smith', '2024-09-12 14:41:31', 'jane@example.com', 'I absolutely loved this meal! It was delicious and perfectly cooked.', 5),
(56, 3, 'alex_jones', '2024-09-12 14:41:31', 'alex@example.com', 'The food was decent, but I expected more based on the reviews.', 3),
(57, 7, 'Aman30', '2024-09-23 10:38:48', 'amanpatel30@gmail.com', 'Best dining experience I have had in a long time! Highly recommend.', 5),
(58, 8, 'Aman11', '2024-09-28 12:12:31', 'panda@gmail.com', 'The dish was good, but it could use a bit more seasoning.', 4),
(59, 9, 'Aman1232', '2024-09-28 12:16:31', 'panda12@gmail.com', 'Not impressed. I found the food to be bland and uninspired.', 2),
(60, 10, 'KingU', '2024-09-30 06:35:50', 'Loki1@gmail.com', 'An unforgettable meal! Everything was perfect, from start to finish.', 5),
(83, 19, 'Aman', '2024-10-21 12:38:43', 'amanpatel1030@gmail.com', 'I love the flavor! It has a unique taste that is hard to find in other dishes. The texture is smooth, and every bite is full of vibrant and rich flavors.', 5),
(88, 19, 'Aman', '2024-10-23 07:18:22', 'amanpatel@gmail.com', 'This is my feedback.', 5),
(89, 29, 'abcv', '2024-10-23 07:26:41', 'abc@gmail.com', 'this is very nice', 4),
(90, 19, 'Aman', '2024-11-27 05:45:37', 'abc@gmail.com', 'This is rating on Yum Yum Rank from user Aman', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `ProfilePicture` text NOT NULL,
  `RegistrationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Email`, `Password`, `ProfilePicture`, `RegistrationDate`) VALUES
(1, 'john_doe', 'john@example.com', '$2y$10$Ob3o8jtGl/4a/rRYabWfEu0o3Ex.eVq6WdAJo93azKPtWlQ0Rxnha', 'uploads/profile_pictures/66ee831de8fd8.jpg', '2024-09-01 04:30:00'),
(2, 'jane_smith', 'jane@example.com', '$2y$10$YmQXzvBriQRhnhOOKHGyn.LLxQg03tha/RBeY3dPcXyB9dOOVyQhG', 'uploads/profile_pictures/670eda10ec769.png', '2024-09-12 14:41:31'),
(3, 'alex_jones', 'alex@example.com', '$2y$10$OsdV9ao7dM2i5VKU00oHyeUvH0Y3Zhm7rnRSUmIKqDWqmE9VVswGy', 'uploads/profile_pictures/66efed78a76c3.jpg', '2024-09-12 14:41:31'),
(7, 'Aman30', 'amanpatel30@gmail.com', '$2y$10$uWuoZ0zWJwCc/yKmfgnbwOZcw/ccdDeBrFBge0EPVniIwtVImM0cG', 'uploads/profile_pictures/670e033adfec6.jpg', '2024-09-23 10:38:48'),
(8, 'Aman11', 'panda@gmail.com', '$2y$10$OsdV9ao7dM2i5VKU00oHyeUvH0Y3Zhm7rnRSUmIKqDWqmE9VVswGy', 'uploads/profile_pictures/670e033adfec6.jpg', '2024-09-28 12:12:31'),
(9, 'Aman1232', 'panda12@gmail.com', '$2y$10$0SBOgixpwoPdTRhS13QUv.6xIh2tygGgPWp73oB8sFs4GvawzJwma', 'uploads/profile_pictures/670ee9c32e4ae.jpg', '2024-09-28 12:16:31'),
(10, 'KingU', 'Loki1@gmail.com', '$2y$10$JSbim.XxikttOJJJ3o7n2.JQJDvKBjGf5bqymQalBuftXW4pxxhVu', 'uploads/profile_pictures/66fa46c624863.png', '2024-09-30 06:35:50'),
(12, 'krishna', 'k@gmail.com', '$2y$10$aH9/9TMCulW2ciyG2TghpeCZUlIro3gwhzuqdShcN9ZywvFpSGPeu', 'uploads/profile_pictures/66ee831de8fd8.jpg', '2024-10-01 07:48:43'),
(14, 'Aman123', 'aman123@gmail.com', '$2y$10$iApiwe4qIzlDQ9b8lCkci.GlbEyd9AY9O8WPXKwONSTIP1KVrM3ki', 'uploads/profile_pictures/66fe148ad8864.jpg', '2024-10-03 03:50:34'),
(15, 'withOutImage', 'withoutimage@gmail.com', '$2y$10$SGHm5JryZ3Qa.8zhXpjWs.Vu4GLXtwmy7O3WlcnMP2BytziRejUs.', '', '2024-10-03 03:56:06'),
(16, 'a1', 'a1@gmail.com', '$2y$10$ZkR7go3duXL27TNjf6py.enBA2lbQKbwTAB9V7CR9yliN9VltvISy', 'uploads/profile_pictures/66ee831de8fd8.jpg', '2024-10-03 04:14:39'),
(19, 'Aman1030', 'amanpatel1030@gmail.com', '$2y$10$SQmQAgMf3l23Zi7acQoRZeqrTorilq1SUulQBAjnGS68NcWmZt6JS', 'uploads/profile_pictures/19_slider2_3.png', '2024-10-18 18:09:47'),
(23, 'Aman123Go', 'aman123Go@gmail.com', '$2y$10$sWfj9gz3RA1v6gnu2NyIYedQKTIrVIr7bzK0d0z99u9Ae5xrYhcK2', 'uploads/profile_pictures/67140ca638b0f.png', '2024-10-19 19:46:16'),
(28, 'Mosam123', 'mosam123@gmail.com', '$2y$10$qYASs0g/FMFVUULRv2qcl.6l79GeWk/68WBpVI5YRvdkCkdfm4R.y', 'uploads/profile_pictures/671848cbcc3cd.png', '2024-10-23 00:52:27'),
(29, 'Dhvani123', 'dhvani123@gmail.com', '$2y$10$Qm5U7gzu6ZLlaBWwRAVF.O8GANsa.4w8//1Yo3QlT6gNE6WC9mU46', 'uploads/profile_pictures/29_slider2_2.png', '2024-10-23 00:53:13'),
(30, 'Dhvani', 'cjaushcjabschjbas@gmail.com', '$2y$10$Caj/u.PRAEz/aUh37c6gf.a7mWh8Sw4JaEJeB1/qx0U6qMUM0FWkm', '', '2024-10-23 03:09:25'),
(31, 'abcd', 'abcd@gmail.com', '$2y$10$2mjnWhry3fT8On8lmAbyRu2WoSue2Yg5rass4EtBok4tX/Ru/FsJa', 'uploads/profile_pictures/6718a1f6f2dcd.jpg', '2024-10-23 07:12:55'),
(32, 'New User', 'newuser@gmail.com', '$2y$10$3K6Gp7u/heNES7Gu/2B14Ottu5STRdgkenGmWkGeEpSBAMnJERnru', 'uploads/profile_pictures/6746b36c9f3a1.png', '2024-11-27 05:51:40');

-- --------------------------------------------------------

--
-- Table structure for table `user_likes`
--

CREATE TABLE `user_likes` (
  `like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_likes`
--

INSERT INTO `user_likes` (`like_id`, `user_id`, `food_id`, `date`) VALUES
(3, 1, 142, '2024-10-05 06:17:55'),
(6, 8, 148, '2024-10-05 06:17:55'),
(9, 14, 235, '2024-10-05 06:17:55'),
(10, 14, 150, '2024-10-05 06:17:55'),
(11, 14, 238, '2024-10-05 06:17:55'),
(12, 14, 243, '2024-10-05 06:17:55'),
(13, 8, 235, '2024-10-05 06:17:55'),
(14, 8, 242, '2024-10-05 06:17:55'),
(15, 8, 236, '2024-10-05 06:17:55'),
(17, 9, 237, '2024-10-05 06:17:55'),
(18, 9, 242, '2024-10-05 06:17:55'),
(19, 9, 246, '2024-10-05 06:17:55'),
(20, 9, 241, '2024-10-05 06:17:55'),
(22, 9, 152, '2024-10-05 06:17:55'),
(23, 14, 244, '2024-10-05 06:17:55'),
(24, 15, 150, '2024-10-05 06:17:55'),
(25, 15, 244, '2024-10-05 06:17:55'),
(26, 15, 239, '2024-10-05 06:17:55'),
(27, 15, 238, '2024-10-05 06:19:52'),
(50, 7, 151, '2024-10-15 12:52:17'),
(53, 7, 148, '2024-10-16 00:15:42'),
(54, 7, 142, '2024-10-16 22:42:08'),
(55, 7, 246, '2024-10-16 22:47:57'),
(57, 7, 251, '2024-10-16 22:49:09'),
(58, 7, 254, '2024-10-16 23:02:22'),
(59, 7, 146, '2024-10-16 23:04:49'),
(60, 10, 143, '2024-10-19 09:12:19'),
(61, 10, 148, '2024-10-19 11:02:10'),
(62, 10, 247, '2024-10-19 11:04:46'),
(63, 10, 150, '2024-10-19 11:10:01'),
(66, 19, 148, '2024-10-19 23:36:38'),
(68, 10, 142, '2024-10-21 14:36:11'),
(69, 10, 235, '2024-10-21 16:40:57'),
(70, 28, 143, '2024-10-23 08:45:05'),
(71, 29, 150, '2024-10-23 12:55:26'),
(72, 19, 235, '2024-10-26 20:24:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `alternatives`
--
ALTER TABLE `alternatives`
  ADD PRIMARY KEY (`AlternativeID`),
  ADD KEY `OriginalFoodID` (`OriginalFoodID`),
  ADD KEY `AlternativeFoodID` (`AlternativeFoodID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`FoodID`),
  ADD KEY `CategoryID` (`CategoryID`);

--
-- Indexes for table `food_ingredients`
--
ALTER TABLE `food_ingredients`
  ADD PRIMARY KEY (`FoodID`,`IngredientID`),
  ADD KEY `IngredientID` (`IngredientID`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`IngredientID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `nutritional_info`
--
ALTER TABLE `nutritional_info`
  ADD PRIMARY KEY (`NutritionID`),
  ADD KEY `FoodID` (`FoodID`);

--
-- Indexes for table `password_reset_attempts`
--
ALTER TABLE `password_reset_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pricingplans`
--
ALTER TABLE `pricingplans`
  ADD PRIMARY KEY (`PlanID`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`RatingID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `FoodID` (`FoodID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `fk_reviews_user` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `user_likes`
--
ALTER TABLE `user_likes`
  ADD PRIMARY KEY (`like_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`food_id`),
  ADD KEY `food_id` (`food_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `alternatives`
--
ALTER TABLE `alternatives`
  MODIFY `AlternativeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=322;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `FoodID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=275;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `IngredientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT for table `nutritional_info`
--
ALTER TABLE `nutritional_info`
  MODIFY `NutritionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `password_reset_attempts`
--
ALTER TABLE `password_reset_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `pricingplans`
--
ALTER TABLE `pricingplans`
  MODIFY `PlanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `RatingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=703;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `user_likes`
--
ALTER TABLE `user_likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alternatives`
--
ALTER TABLE `alternatives`
  ADD CONSTRAINT `alternatives_ibfk_1` FOREIGN KEY (`OriginalFoodID`) REFERENCES `foods` (`FoodID`) ON DELETE CASCADE,
  ADD CONSTRAINT `alternatives_ibfk_2` FOREIGN KEY (`AlternativeFoodID`) REFERENCES `foods` (`FoodID`) ON DELETE CASCADE;

--
-- Constraints for table `foods`
--
ALTER TABLE `foods`
  ADD CONSTRAINT `foods_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`CategoryID`) ON DELETE SET NULL;

--
-- Constraints for table `food_ingredients`
--
ALTER TABLE `food_ingredients`
  ADD CONSTRAINT `food_ingredients_ibfk_1` FOREIGN KEY (`FoodID`) REFERENCES `foods` (`FoodID`) ON DELETE CASCADE,
  ADD CONSTRAINT `food_ingredients_ibfk_2` FOREIGN KEY (`IngredientID`) REFERENCES `ingredients` (`IngredientID`) ON DELETE CASCADE;

--
-- Constraints for table `nutritional_info`
--
ALTER TABLE `nutritional_info`
  ADD CONSTRAINT `nutritional_info_ibfk_1` FOREIGN KEY (`FoodID`) REFERENCES `foods` (`FoodID`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`FoodID`) REFERENCES `foods` (`FoodID`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_user` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_likes`
--
ALTER TABLE `user_likes`
  ADD CONSTRAINT `user_likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `user_likes_ibfk_2` FOREIGN KEY (`food_id`) REFERENCES `foods` (`FoodID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
