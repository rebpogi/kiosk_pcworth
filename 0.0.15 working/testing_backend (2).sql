-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2025 at 05:37 PM
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
(1, 'jude', 'foronda', 'foronda21', 'foronda123', 'superadmin'),
(2, 'julian1', 'moralejo1', 'julianmoralejo211', 'moralejo12341', 'admin'),
(3, 'Kit', 'Polistico', 'KitPolistoc123', 'Polistico1', 'admin'),
(4, 'kit', 'andrei', 'kitandrei2', 'kit123', 'admin');

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
(1, 'WORK222', 1, 2, 2.00, 'WERrrr', 0, 'uploads/bundles/bundle_683ee1babeebc2.72763049.png', '2025-06-03 19:27:29'),
(2, 'Bundle_2', 2, 145555, 100.00, 'Bundle here', 0, 'uploads/bundles/bundle_683f06e66dca27.33326776.png', '2025-06-03 22:29:58');

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
(7, 1, '1', 'GO 1', 'CPU', 1, 1.00, '2025-06-03 19:51:22'),
(8, 1, '123', 'FORMAL', 'GPU', 1, 2.00, '2025-06-03 19:51:22'),
(9, 2, '67', 'AM 56', 'CPU', 1, 5656.00, '2025-06-03 22:29:58'),
(10, 2, '1', 'GO 1', 'GPU', 1, 1.00, '2025-06-03 22:29:58');

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ID`, `product_display_name`, `price`, `quantity`, `UID`, `category`, `manufacturer`, `Form_factor`, `Socket_type`, `Ram_socket_type`, `product_specifications`, `product_description`, `status`, `immage`, `warranty_duration`, `created_at`, `updated_at`) VALUES
(164, 'GLOWww', 1.00, 1, '1', 'Mobo', 'GLOW', 'ATX', 'LGA1700', 'Not_Applicable', 'GO', 'GO', '1', 'uploads/img_683db19ebc448.png', '30 Days', '2025-06-02 14:13:50', '2025-06-03 15:33:51'),
(220, 'with num 129', 100.00, 44444444, '55444', 'Monitor', 'eeeeeeeee', 'MICRO-ITX', 'AM5', 'DDR_5', 'asdf', 'asdf', 'Shown', '', '180 Days', '2025-06-02 15:17:18', '2025-06-02 15:18:08'),
(221, 'AM 56', 5656.00, 67, '67', 'PSU', 'Y', 'ATX', 'LGA1700', 'DDR_5', 'Y', 'Y', '1', '', '2 Years', '2025-06-02 15:18:59', '2025-06-03 14:30:17'),
(222, 'GO 1', 1.00, 1, '1', 'RAM', '1', 'Extended-ATX', 'LGA1851', 'DDR_5', '1', '1', '1', 'uploads/img_683dc62401f72.png', '5 Years', '2025-06-02 15:38:40', '2025-06-03 14:30:18'),
(254, 'WORKING_14', 2.00, 1, '1', 'MOBO', '1', 'ATX', 'LGA', NULL, '1', '1', 'Shown', 'uploads/img_683f039984db5.png', '2 Years', '2025-06-03 14:15:53', '2025-06-03 14:15:53'),
(255, 'WORKING_14', 2.00, 1, '1', 'MOBO', '1', 'ATX', 'LGA', NULL, '1', '1', 'Shown', 'uploads/img_683f0399898bc.png', '2 Years', '2025-06-03 14:15:53', '2025-06-03 14:15:53'),
(256, 'TEAT', 1.00, 1, '1', 'Mobo', '1', 'MICRO-ITX', 'LGA1700', 'DDR_4', '1', '1', '1', 'uploads/img_683f070fab8f6.png', '2 Years', '2025-06-03 14:30:39', '2025-06-03 14:30:39'),
(257, 'TEST2_GO', 1.00, 44444444, '44444444444444', 'RAM', '1', 'MICRO-ITX', 'AM4', 'DDR_4', '1', '1', '1', 'uploads/img_683f11efb1902.png', '365 Days', '2025-06-03 15:17:03', '2025-06-03 15:17:03'),
(258, 'Testwork', 100.00, 12, '221', 'Mobo', 'Nvidia', 'MINI-ITX', 'LGA1700', 'DDR_5', 'work', 'work', '1', 'uploads/img_683f15fee37bc.png', '365 Days', '2025-06-03 15:34:22', '2025-06-03 15:34:22'),
(259, 'Testwork', 100.00, 12, '221', 'Mobo', 'Nvidia', 'MINI-ITX', 'LGA1700', 'DDR_5', 'work', 'work', '1', 'uploads/img_683f15fee37ad.png', '365 Days', '2025-06-03 15:34:22', '2025-06-03 15:34:22'),
(260, 'Testwork', 100.00, 12, '221', 'Mobo', 'Nvidia', 'MINI-ITX', 'LGA1700', 'DDR_5', 'work', 'work', '1', 'uploads/img_683f15fee3811.png', '365 Days', '2025-06-03 15:34:22', '2025-06-03 15:34:22'),
(261, 'Testwork', 100.00, 12, '221', 'Mobo', 'Nvidia', 'MINI-ITX', 'LGA1700', 'DDR_5', 'work', 'work', '1', 'uploads/img_683f15fee8551.png', '365 Days', '2025-06-03 15:34:22', '2025-06-03 15:34:22'),
(262, 'Testwork', 100.00, 12, '221', 'Mobo', 'Nvidia', 'MINI-ITX', 'LGA1700', 'DDR_5', 'work', 'work', '1', 'uploads/img_683f15fee863e.png', '365 Days', '2025-06-03 15:34:22', '2025-06-03 15:34:22'),
(263, 'Testwork', 100.00, 12, '221', 'Mobo', 'Nvidia', 'MINI-ITX', 'LGA1700', 'DDR_5', 'work', 'work', '1', 'uploads/img_683f15fee85de.png', '365 Days', '2025-06-03 15:34:22', '2025-06-03 15:34:22'),
(264, 'Testwork', 100.00, 12, '221', 'Mobo', 'Nvidia', 'MINI-ITX', 'LGA1700', 'DDR_5', 'work', 'work', '1', 'uploads/img_683f15fee85f1.png', '365 Days', '2025-06-03 15:34:22', '2025-06-03 15:34:22'),
(265, 'Copy_prevs', 10.00, 90, '900', 'Storage', 'yown', 'ATX', 'LGA1700', 'DDR_5', 'work', 'work', '1', 'uploads/img_683f163a71b67.png', '365 Days', '2025-06-03 15:35:22', '2025-06-03 15:35:30');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bundles`
--
ALTER TABLE `bundles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bundle_parts`
--
ALTER TABLE `bundle_parts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=266;

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
