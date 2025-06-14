-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2025 at 02:51 PM
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
-- Database: `testing_backend`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('superadmin','admin') DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `firstname`, `lastname`, `username`, `password`, `role`) VALUES
(1, 'judea', 'forondaa', 'FORONZAS', '123456AaA', 'superadmin'),
(2, 'julian1', 'moralejo1', 'julianmoralejo211', 'moralejo12341', 'admin'),
(3, 'Kit', 'Polistico12', 'KitPolistoc12312', 'Polistico12', 'admin'),
(4, 'kit', 'andrei', 'kitandrei2', 'kit1', 'admin'),
(5, 'zas', 'zas', 'zas', 'zas', 'superadmin');

-- --------------------------------------------------------

--
-- Table structure for table `bundles`
--

CREATE TABLE `bundles` (
  `id` int(11) NOT NULL,
  `bundle_display_name` varchar(255) NOT NULL,
  `bundle_quantity` int(11) NOT NULL,
  `bundle_uid` int(11) NOT NULL,
  `bundle_price` decimal(10,2) NOT NULL,
  `bundle_description` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `bundle_image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bundles`
--

INSERT INTO `bundles` (`id`, `bundle_display_name`, `bundle_quantity`, `bundle_uid`, `bundle_price`, `bundle_description`, `status`, `bundle_image`, `created_at`) VALUES
(1, 'WORK222a', 1, 22, 2.00, 'WERrrr', 0, 'uploads/bundles/bundle_683f37f41d9102.52314659.png', '2025-06-03 19:27:29'),
(2, 'Bundle_2', 2, 145555, 100.00, 'Bundle here', 0, 'uploads/bundles/bundle_683f27d2b07845.94926196.png', '2025-06-03 22:29:58'),
(3, 'Test_product_bundle2', 3, 45, 100000.00, 'work', 0, 'uploads/bundles/bundle_683f31c87bf487.68575261.png', '2025-06-04 01:03:31'),
(4, 'Best_bundles', 3, 67857, 10000.00, 'Best bundles!', 0, 'uploads/bundles/bundle_683f6007076ab3.45471025.png', '2025-06-04 04:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `bundle_parts`
--

CREATE TABLE `bundle_parts` (
  `id` int(11) NOT NULL,
  `bundle_id` int(11) NOT NULL,
  `part_uid` varchar(255) NOT NULL,
  `part_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bundle_parts`
--

INSERT INTO `bundle_parts` (`id`, `bundle_id`, `part_uid`, `part_name`, `category`, `quantity`, `unit_price`, `created_at`) VALUES
(11, 2, '67', 'AM 56', 'CPU', 1, 5656.00, '2025-06-04 00:50:26'),
(12, 2, '1', 'GO 1', 'GPU', 1, 1.00, '2025-06-04 00:50:26'),
(16, 3, '900', 'Copy_prevs', 'CPU', 1, 10.00, '2025-06-04 01:32:56'),
(17, 3, '900', 'Copy_prevs', 'GPU', 1, 10.00, '2025-06-04 01:32:56'),
(18, 3, '221', 'Testwork', 'Motherboard', 1, 100.00, '2025-06-04 01:32:56'),
(21, 1, '1', 'GO 1', 'CPU', 1, 1.00, '2025-06-04 01:59:16'),
(22, 1, '123', 'FORMAL', 'GPU', 1, 2.00, '2025-06-04 01:59:16'),
(26, 4, '67', 'AM 561', 'CPU', 1, 5656.00, '2025-06-04 04:50:15'),
(27, 4, '78906', 'GTX sure super', 'GPU', 1, 75000.00, '2025-06-04 04:50:15'),
(28, 4, '1', 'twrow', 'Motherboard', 1, 99999999.99, '2025-06-04 04:50:15');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `title`, `price`, `image`, `status`, `category`, `created_at`) VALUES
(1, 'wwwwwwwwww', 12345.00, 'uploads/img_682569674982a3.38465966.png', 'Available', NULL, '2025-05-15 04:11:19'),
(2, 'wwwwwwwww22222', 99999999.99, 'immages/img_6826985c9d0297.71773713.png', 'Not Available', NULL, '2025-05-16 01:43:56');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ID` int(11) NOT NULL,
  `product_display_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `UID` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `manufacturer` varchar(255) DEFAULT NULL,
  `Form_factor` varchar(255) DEFAULT NULL,
  `Socket_type` varchar(255) DEFAULT NULL,
  `Ram_socket_type` varchar(255) DEFAULT NULL,
  `product_specifications` text DEFAULT NULL,
  `product_description` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Available',
  `immage` varchar(255) DEFAULT NULL,
  `warranty_duration` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(255) NOT NULL,
  `updated_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ID`, `product_display_name`, `price`, `quantity`, `UID`, `category`, `manufacturer`, `Form_factor`, `Socket_type`, `Ram_socket_type`, `product_specifications`, `product_description`, `status`, `immage`, `warranty_duration`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(465, 'NOITA', 1233.00, 12, '123123', 'Storage', 'Gigabyte', 'Not_Applicable', 'Not_Applicable', 'Not_Applicable', '12', '12', '1', 'uploads/product_465_b10b99a145cedc92.png', '365 Days', '2025-06-12 06:22:00', '2025-06-12 06:29:43', '', ''),
(466, 'TEST_IMMAGE', 10101.00, 15, '123532', 'Keyboard', 'ASUS', 'Not_Applicable', 'Not_Applicable', 'Not_Applicable', 'QWERT', 'QWERT', '1', 'product_466_64a4a68b5c635907.png', '365 Days', '2025-06-12 06:28:28', '2025-06-12 06:29:00', '', ''),
(467, 'ZOOOOzzzz', 1234.00, 67, '123222', 'GPU', 'ASUS', 'Not_Applicable', 'Not_Applicable', 'Not_Applicable', '123', '123', '1', 'uploads/product_467_684a7c84308c2.png', '180 Days', '2025-06-12 06:38:20', '2025-06-12 07:06:44', '', ''),
(468, 'TEST_NIGHT', 101012.00, 12, '1233211', 'Storage', 'AMD', 'Not_Applicable', 'Not_Applicable', 'Not_Applicable', 'BEST', 'BESY', '1', 'uploads/product_684ac5332653a_1749730611.png', '365 Days', '2025-06-12 12:16:51', '2025-06-12 12:16:51', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `bundles`
--
ALTER TABLE `bundles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bundle_parts`
--
ALTER TABLE `bundle_parts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bundle_id` (`bundle_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bundles`
--
ALTER TABLE `bundles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bundle_parts`
--
ALTER TABLE `bundle_parts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=469;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bundle_parts`
--
ALTER TABLE `bundle_parts`
  ADD CONSTRAINT `bundle_parts_ibfk_1` FOREIGN KEY (`bundle_id`) REFERENCES `bundles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
