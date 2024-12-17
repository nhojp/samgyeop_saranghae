-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2024 at 04:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saranghae`
--

-- --------------------------------------------------------

--
-- Table structure for table `bundles`
--

CREATE TABLE `bundles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bundles`
--

INSERT INTO `bundles` (`id`, `name`, `price`) VALUES
(3, 'Bundle A', 299.00),
(4, 'Bundle B', 399.00),
(5, 'Unli 3', 499.00);

-- --------------------------------------------------------

--
-- Table structure for table `bundle_items`
--

CREATE TABLE `bundle_items` (
  `id` int(11) NOT NULL,
  `bundle_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bundle_items`
--

INSERT INTO `bundle_items` (`id`, `bundle_id`, `item_id`) VALUES
(11, 3, 2),
(12, 3, 3),
(13, 4, 2),
(14, 4, 3),
(15, 4, 4),
(16, 5, 2),
(17, 5, 3),
(18, 5, 4),
(19, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `name`, `description`, `price`, `image`) VALUES
(2, 'Korean BBQ', 'Korean BBQ is a popular and vibrant dining experience that involves grilling bite-sized pieces of marinated meat, often beef, pork, or chicken, at the table. The meats are typically seasoned with a savory blend of soy sauce, sesame oil, garlic, and other flavorful ingredients. As the meat sizzles on a grill, diners can enjoy the interactive nature of cooking their own food, paired with an array of traditional side dishes like kimchi, pickled vegetables, and steamed rice. The communal style of dining encourages sharing, making Korean BBQ a fun and flavorful way to experience Korean cuisine with friends and family.', 0.00, 'uploads/Korean-Barbecue-Grill-001-1.jpg'),
(3, 'Kimchi', 'Kimchi is a traditional Korean side dish made from fermented vegetables, usually napa cabbage or radishes, and flavored with chili pepper, garlic, ginger, and various seasonings. It is a staple in Korean cuisine, offering a tangy and spicy flavor that complements grilled meats like samgyeopsal.', 0.00, 'uploads/kimchi.jfif'),
(4, 'Banchan ', 'Banchan refers to the small side dishes served along with the main course in Korean meals. These can include a variety of pickled vegetables, seasoned greens, fried tofu, and more. They are meant to be shared and provide a balance of flavors, textures, and nutrients to the meal.', 0.00, 'uploads/banchan.jfif'),
(5, 'Japchae ', 'Japchae is a popular Korean stir-fried noodle dish made from glass noodles (sweet potato starch noodles), vegetables, and sometimes beef or other proteins. It\'s flavored with soy sauce, sesame oil, and garlic, offering a slightly sweet and savory flavor that\'s a great side dish to accompany grilled meats.', 0.00, 'uploads/japchae.jfif');

-- --------------------------------------------------------

--
-- Table structure for table `operation_hours`
--

CREATE TABLE `operation_hours` (
  `id` int(11) NOT NULL,
  `day` varchar(10) DEFAULT NULL,
  `opening_hour` time DEFAULT NULL,
  `closing_hour` time DEFAULT NULL,
  `status` enum('open','closed') NOT NULL DEFAULT 'closed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `operation_hours`
--

INSERT INTO `operation_hours` (`id`, `day`, `opening_hour`, `closing_hour`, `status`) VALUES
(1, 'Monday', '08:00:00', '20:00:00', 'open'),
(3, 'Tuesday', '08:00:00', '20:00:00', 'open'),
(4, 'Wednesday', '08:00:00', '20:00:00', 'open'),
(5, 'Thursday', '09:00:00', '24:00:00', 'open'),
(6, 'Friday', '09:00:00', '23:00:00', 'open'),
(7, 'Saturday', '09:00:00', '22:00:00', 'open'),
(8, 'Sunday', NULL, NULL, 'closed');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `reservation_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_status` enum('pending','completed','failed') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `reservation_date` date DEFAULT NULL,
  `reservation_time` time DEFAULT NULL,
  `duration` int(11) DEFAULT 120,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT NULL,
  `payment_method` enum('gcash','paypal','paymaya','cash') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `table_id`, `reservation_date`, `reservation_time`, `duration`, `total_price`, `status`, `payment_method`) VALUES
(1, 1, 2, '2024-12-10', '18:00:00', 2, 50.00, 'confirmed', 'gcash'),
(2, 2, 3, '2024-12-11', '19:30:00', 3, 75.00, 'pending', ''),
(3, 3, 4, '2024-12-12', '17:00:00', 1, 30.00, '', 'paymaya'),
(4, 4, 5, '2024-12-13', '20:00:00', 2, 60.00, 'cancelled', 'paypal');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` int(11) NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `seats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `table_name`, `seats`) VALUES
(1, 'A', 4),
(3, 'B', 4),
(4, 'C', 6),
(5, 'D', 6),
(6, 'E', 4),
(7, 'F', 8),
(8, 'G', 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `email`, `created_at`) VALUES
(1, 'admin', 'admin123', 'Admin User', 'admin@example.com', '2024-11-18 04:37:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bundles`
--
ALTER TABLE `bundles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bundle_items`
--
ALTER TABLE `bundle_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bundle_id` (`bundle_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operation_hours`
--
ALTER TABLE `operation_hours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_id` (`reservation_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bundles`
--
ALTER TABLE `bundles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bundle_items`
--
ALTER TABLE `bundle_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `operation_hours`
--
ALTER TABLE `operation_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bundle_items`
--
ALTER TABLE `bundle_items`
  ADD CONSTRAINT `bundle_items_ibfk_1` FOREIGN KEY (`bundle_id`) REFERENCES `bundles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bundle_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
