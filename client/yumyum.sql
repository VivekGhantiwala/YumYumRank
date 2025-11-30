-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2024 at 07:20 PM
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
-- Database: `yumyum`
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
(11, 104, 105),
(12, 104, 106),
(13, 109, 108),
(14, 109, 113),
(15, 107, 111),
(16, 107, 115),
(17, 105, 112),
(18, 108, 113),
(19, 108, 110),
(20, 111, 113),
(21, 113, 112),
(22, 106, 110),
(23, 114, 115),
(24, 114, 111),
(25, 115, 114),
(26, 112, 113),
(27, 110, 105);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `CategoryID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`CategoryID`, `Name`, `Description`, `image_path`) VALUES
(12, 'Frozen Foods', 'Foods that are frozen for preservation', '../asset/icecream.png'),
(20, 'Main Courses', 'Various main course dishes', '../asset/pasta.png'),
(22, 'Breakfast', 'Breakfast items and meals', '../asset/icecream.png'),
(24, 'Main Courses', 'Main dishes from various cuisines', '../asset/sancocho.jpg'),
(28, 'Specialty Foods', 'Specialty or unique food items', '../asset/spcial.png'),
(33, 'Side Dishes', 'Accompanying dishes for main courses', '../asset/spcial.png'),
(43, 'Specialty Foods', 'Specialty or unique food items', '../asset/spcial.png'),
(44, 'Bakery Items', 'Items baked in a bakery', '../asset/Orange.png'),
(56, 'Beverage', 'Drinks and beverages', '../asset/salad.jpg'),
(57, 'Italian', 'Italian cuisine', NULL),
(58, 'Italian', 'Italian cuisine', NULL);

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
  `about` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`FoodID`, `Name`, `Description`, `Price`, `CategoryID`, `Image`, `HealthScore`, `created_at`, `about`) VALUES
(104, 'Pasta', 'Delicious Italian pasta.', 20.00, 20, '../asset/pasta.png', '2', '2024-09-12 16:20:41', 'Classic Italian pasta made with high-quality durum wheat and prepared with a rich tomato sauce, fresh basil, and Parmesan cheese. Perfect for a hearty meal that everyone will enjoy.'),
(105, 'Artisan Bread', 'Freshly baked artisan bread.', 6.00, 44, '../asset/Orange.png', '6', '2024-09-12 16:20:41', 'Freshly baked artisan bread with a crusty exterior and a soft, flavorful interior. Made with traditional methods and high-quality ingredients, it’s perfect for sandwiches, toasts, or as a side to any meal.'),
(106, 'Pav Bhaji', 'A popular Indian street food.', 1.00, 24, '../asset/sancocho.jpg', '8', '2024-09-12 16:20:41', 'A popular Indian street food, Pav Bhaji is a flavorful mix of mashed vegetables and spices, served with buttered bread rolls. This dish offers a vibrant and spicy taste of Indian cuisine in every bite.'),
(107, 'Ice Cream', 'Refreshing ice cream for breakfast.', 5.00, 22, '../asset/icecream.png', '5', '2024-09-12 16:20:41', 'Indulge in our creamy and refreshing ice cream, made with the finest ingredients and a variety of flavors to suit every taste. Perfect for a sweet treat or a special dessert after any meal.'),
(108, 'Pizza', 'Hot and cheesy pizza.', 7.00, 56, '../asset/pizza.jpg', '7', '2024-09-12 16:20:41', 'Hot and cheesy pizza with a delicious, hand-tossed crust and topped with a blend of premium cheeses, fresh vegetables, and savory meats. A classic favorite for pizza lovers and a great choice for gatherings.'),
(109, 'Frozen Pizza', 'Frozen pizza ready to bake.', 4.00, 12, '../asset/icecream.png', '4', '2024-09-12 16:20:41', 'Convenient frozen pizza that offers a delicious and crispy crust, topped with a blend of savory cheeses, a flavorful tomato sauce, and your choice of premium toppings. Ideal for a quick and satisfying meal.'),
(110, 'Garlic Mashed Potatoes', 'Creamy mashed potatoes with garlic.', 8.00, 33, '../asset/spcial.png', '8', '2024-09-12 16:20:41', 'Creamy mashed potatoes with a rich, buttery texture and infused with roasted garlic. These mashed potatoes make a perfect side dish that complements a wide range of main courses and adds a burst of flavor to any meal.'),
(111, 'Gluten-Free Brownies', 'Delicious gluten-free brownies.', 3.00, 33, '../asset/spcial.png', '7', '2024-09-12 16:20:41', 'Tasty gluten-free brownies that provide the same rich, chocolatey flavor as traditional brownies, made without gluten-containing ingredients. Ideal for those with gluten sensitivities who still want to enjoy a delicious treat.'),
(112, 'Keto Brownies', 'Low-carb brownies for keto diet.', 6.00, 43, '../asset/spcial.png', '6', '2024-09-12 16:20:41', 'Delicious low-carb brownies that are perfect for those following a keto diet. Made with rich cocoa, almond flour, and sweetened with keto-friendly ingredients, these brownies are both satisfying and nutritious.'),
(113, 'Low-Carb Brownies', 'Perfect for a low-carb diet.', 7.00, 28, '../asset/spcial.png', '7', '2024-09-12 16:20:41', 'Perfect for those on a low-carb diet, these brownies are made with low-carb ingredients while still offering a rich, decadent chocolate flavor. A great option for satisfying your sweet tooth without the carbs.'),
(114, 'Salad', 'A fresh and healthy mix of vegetables and greens.', 9.00, 33, '../asset/pizza.jpg', '9', '2024-09-13 17:26:05', 'A fresh and healthy mix of crisp vegetables and greens, tossed with a light dressing. This salad is perfect as a side dish or a light meal, providing essential nutrients and a burst of freshness in every bite.'),
(115, 'Smoothie', 'A nutritious drink made from blended fruits and vegetables.', 8.00, 56, '../asset/pav-bhaji.jpg', '8', '2024-09-13 17:26:05', 'Nutritious smoothie made from a blend of fresh fruits and vegetables, providing essential vitamins and minerals in a refreshing drink. Ideal for a healthy snack or a quick breakfast that supports your well-being.');

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
(104, 2, 150.00, 'ml'),
(104, 10, 200.00, 'g'),
(104, 11, 30.00, 'ml'),
(107, 4, 500.00, 'ml'),
(107, 5, 200.00, 'g'),
(107, 6, 10.00, 'ml'),
(108, 1, 200.00, 'g'),
(108, 2, 100.00, 'ml'),
(108, 3, 150.00, 'g'),
(112, 7, 100.00, 'g'),
(112, 8, 50.00, 'g'),
(112, 9, 100.00, 'g');

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `IngredientID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `HealthImpact` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`IngredientID`, `Name`, `HealthImpact`) VALUES
(1, 'Flour', 'High in carbohydrates'),
(2, 'Tomato Sauce', 'Rich in vitamins'),
(3, 'Cheese', 'High in calcium'),
(4, 'Milk', 'Good source of calcium'),
(5, 'Sugar', 'High in calories'),
(6, 'Vanilla Extract', 'Contains antioxidants'),
(7, 'Almond Flour', 'Low in carbs, high in protein'),
(8, 'Cocoa Powder', 'Rich in antioxidants'),
(9, 'Butter', 'High in fats'),
(10, 'Pasta', 'High in carbohydrates'),
(11, 'Olive Oil', 'Rich in healthy fats');

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
(1, 104, '350', '12', '70', '1', 'B1, B2', 'Iron, Zinc'),
(2, 109, '280', '12', '30', '10', 'A, C', 'Calcium, Iron'),
(3, 107, '200', '4', '25', '10', 'D', 'Calcium'),
(4, 105, '180', '6', '30', '2', 'B1', 'Iron'),
(5, 112, '160', '8', '12', '10', 'E', 'Magnesium'),
(6, 108, '250', '14', '40', '10', 'A, C', 'Calcium, Iron'),
(7, 111, '170', '6', '22', '8', 'E', 'Magnesium'),
(8, 113, '160', '8', '12', '10', 'E', 'Magnesium'),
(9, 106, '300', '8', '40', '12', 'C', 'Iron'),
(10, 110, '210', '4', '30', '9', 'A', 'Potassium'),
(11, 115, '150', '3', '32', '0', 'C', 'Potassium'),
(12, 114, '90', '2', '15', '1', 'K', 'Calcium, Iron');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `RatingID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `FoodID` int(11) DEFAULT NULL,
  `Score` text NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `ReviewID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `RegistrationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Email`, `Password`, `RegistrationDate`) VALUES
(1, 'john_doe', 'john@example.com', 'hashed_password_1', '2024-09-12 14:41:31'),
(2, 'jane_smith', 'jane@example.com', 'hashed_password_2', '2024-09-12 14:41:31'),
(3, 'alex_jones', 'alex@example.com', 'hashed_password_3', '2024-09-12 14:41:31');

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
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `alternatives`
--
ALTER TABLE `alternatives`
  MODIFY `AlternativeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `FoodID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `IngredientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `nutritional_info`
--
ALTER TABLE `nutritional_info`
  MODIFY `NutritionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `RatingID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
