-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2025 at 05:55 AM
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

INSERT INTO `products` (`ID`, `product_display_name`, `price`, `quantity`, `UID`, `category`, `manufacturer`, `product_specifications`, `product_description`, `status`, `immage`, `warranty_duration`, `created_at`, `updated_at`) VALUES
(1, 'GTX 3080', 699.99, 15, 'A123', 'GPU', 'Nvidia', '10GB GDDR6X, 8704 CUDA cores', 'High-end gaming GPU', 'Shown', '', '365 Days', '2025-05-01 02:00:00', '2025-05-30 16:36:44'),
(2, 'Ryzen 7 5800X', 398.99, 123, '123', 'GPU', 'WORK', 'WORK', 'DD', 'Shown', 'uploads/img_68398b2a07079.PNG', '180 Days', '2025-05-02 03:00:00', '2025-05-30 10:40:42'),
(3, 'Corsair Vengeance 16GB', 79.99, 50, 'C345', 'RAM', 'Corsair', 'DDR4, 3200MHz', 'Fast gaming RAM', 'Shown', 'uploads/img_3.png', '180 Days', '2025-05-03 04:00:00', '2025-05-03 04:00:00'),
(4, 'Samsung 970 EVO 1TB', 129.99, 30, 'D456', 'Storage', 'Samsung', 'NVMe SSD, 3500MB/s read speed', 'Reliable fast storage', 'Shown', 'uploads/img_4.png', '365 Days', '2025-05-04 05:00:00', '2025-05-04 05:00:00'),
(5, 'MSI B550 Motherboard', 149.99, 25, 'E567', 'Motherboard', 'MSI', 'AM4 socket, PCIe 4.0', 'Durable motherboard', 'Shown', 'uploads/img_5.png', '365 Days', '2025-05-05 06:00:00', '2025-05-05 06:00:00'),
(6, 'Logitech G502 Mouse', 49.99, 40, 'F678', 'Peripherals', 'Logitech', '16000 DPI, RGB lighting', 'Gaming mouse', 'Shown', 'uploads/img_6.png', '90 Days', '2025-05-06 07:00:00', '2025-05-06 07:00:00'),
(7, 'Dell 24\" Monitor', 179.99, 18, 'G789', 'Monitor', 'Dell', '1920x1080, IPS panel', 'Full HD monitor', 'Shown', 'uploads/img_7.png', '365 Days', '2025-05-07 08:00:00', '2025-05-07 08:00:00'),
(8, 'EVGA 650W PSU', 79.99, 22, 'H890', 'PSU', 'EVGA', '80+ Gold certified', 'Reliable power supply', 'Shown', 'uploads/img_8.png', '365 Days', '2025-05-08 09:00:00', '2025-05-08 09:00:00'),
(9, 'NZXT H510 Case', 69.99, 35, 'I901', 'Case', 'NZXT', 'Mid tower, tempered glass', 'Sleek PC case', 'Shown', 'uploads/img_9.png', 'None', '2025-05-09 10:00:00', '2025-05-09 10:00:00'),
(10, 'HyperX Cloud Headset', 89.99, 27, 'J012', 'Audio', 'HyperX', 'Surround sound, noise cancelling', 'Gaming headset', 'Shown', 'uploads/img_10.png', '180 Days', '2025-05-10 11:00:00', '2025-05-10 11:00:00'),
(11, 'TEST5', 55.00, 55, '55', 'GPU', '55', '55', '55', 'Shown', '', '180 Days', '2025-05-21 08:07:13', '2025-05-23 11:43:23'),
(12, 'TEST5', 55.55, 55, '55', 'GPU', 'TEST55', 'TESS', 'TEST', 'Shown', 'uploads/img_682d89c52e17d.png', '180 Days', '2025-05-21 08:07:33', '2025-05-21 08:07:33'),
(13, 'TEST5', 55.55, 55, '55', 'GPU', 'TEST55', 'TESS', 'TEST', 'Shown', 'uploads/img_682d8ab9a4edd.png', '180 Days', '2025-05-21 08:11:37', '2025-05-21 08:11:37'),
(14, '5', 5.00, 5, '5', 'GPU', '5', '5', '5', 'Shown', 'uploads/img_682d8b78dab07.png', '30 Days', '2025-05-21 08:14:48', '2025-05-21 08:14:48'),
(15, 'a55', 5.00, 5, '5', 'GPU', '5', '5', '5', 'Shown', 'uploads/img_682d8c559ef0c.png', '90 Days', '2025-05-21 08:18:29', '2025-05-21 08:18:29'),
(16, 'a55', 5.00, 5, '5', 'GPU', '5', '5', '5', 'Shown', 'uploads/img_682d8c559ef0c.png', '90 Days', '2025-05-21 08:18:29', '2025-05-21 08:18:29'),
(17, '5', 5.00, 5, '5', 'GPU', '5', '5', '5', 'Shown', 'uploads/img_682d8d6db772c.png', '5days', '2025-05-21 08:23:09', '2025-05-21 08:23:09'),
(18, 'amd', 5.00, 900, '55555', 'GPU', '5', '5', '5', 'Shown', '', '365 Days', '2025-05-21 08:23:40', '2025-05-30 16:50:01'),
(19, 'a', 66.00, 66, '66', 'MOBO', '6', '6', '6', 'Shown', 'uploads/img_682d8e0457c35.png', '6', '2025-05-21 08:25:40', '2025-05-21 08:25:40'),
(27, 'Intel', 0.00, 56, '555555', 'GPU', '555', '55', '555', 'Shown', 'uploads/img_682d8f130f825.png', '365 DAYS', '2025-05-21 08:30:11', '2025-05-21 08:30:11'),
(28, 'Intel', 0.00, 56, '555555', 'GPU', '555', '55', '555', 'Shown', 'uploads/img_682d8f13dca5c.png', '365 DAYS', '2025-05-21 08:30:11', '2025-05-21 08:30:11'),
(29, 'Intel', 0.00, 56, '555555', 'GPU', '555', '55', '555', 'Shown', 'uploads/img_682d8f141d69f.png', '365 DAYS', '2025-05-21 08:30:12', '2025-05-21 08:30:12'),
(30, 'Intel', 0.00, 56, '555555', 'GPU', '555', '55', '555', 'Shown', 'uploads/img_682d8f1619c90.png', '365 DAYS', '2025-05-21 08:30:14', '2025-05-21 08:30:14'),
(31, 'Intel', 0.00, 56, '555555', 'GPU', '555', '55', '555', 'Shown', 'uploads/img_682d8f1625726.png', '365 DAYS', '2025-05-21 08:30:14', '2025-05-21 08:30:14'),
(32, 'AMD', 50.80, 123, '333333', 'GPU', 'ttest', 'test', 'test', 'Shown', 'uploads/img_682d8ff8ddff9.png', '300 days', '2025-05-21 08:34:00', '2025-05-21 08:34:00'),
(33, 'testestset', 54555.00, 2147483647, '5555555555555', 'MOBO', '5555', '555', '5555', 'Shown', 'uploads/img_682d90c54f38a.png', '200 DAYS', '2025-05-21 08:37:25', '2025-05-21 08:37:25'),
(34, 'testestest', 500.90, 45, '55554444', 'RAM', 'testestset', 'testsetset', 'estsetest', 'Shown', 'uploads/img_682db8f58b26f.png', '365 DAYS', '2025-05-21 11:28:53', '2025-05-21 11:28:53'),
(35, 'reeett', 569.90, 33, '3333333333333', 'RAM', 'testesr', 'eteterere', 'tewrsfgasdfas', 'Shown', 'uploads/img_682dba30eea5f.png', '300 days', '2025-05-21 11:34:08', '2025-05-21 11:34:08'),
(36, 'testset', 56.00, 34, '4343', 'MOBO', 'ytytyt', 'tetetet', 'etetetet', 'Shown', 'uploads/img_682dba7a971c7.png', '34 daysa', '2025-05-21 11:35:22', '2025-05-21 11:35:22'),
(37, 'eeee', 3333.00, 123, '335677', 'RAM', 'ee', 'ee', 'ee', 'Shown', 'uploads/img_682dbaff09b17.png', '333 days', '2025-05-21 11:37:35', '2025-05-21 11:37:35'),
(38, 'rrrrr', 444.00, 34, '34', 'SSD', 'rrr', 'rrr', 'rr', 'Shown', 'uploads/img_682dbb4022802.png', '34', '2025-05-21 11:38:40', '2025-05-21 11:38:40'),
(39, 'ssss', 22.00, 23, '23', 'SSD', 'ss', 'ss', 'ss', 'Shown', 'uploads/img_682dbbcd59639.png', '23', '2025-05-21 11:41:01', '2025-05-21 11:41:01'),
(40, 'e', 33.00, 2222, '3333', 'MOBO', 'ee', '33ee', 'ee3', 'Shown', 'uploads/img_682dbc5b8c827.png', '1 Year', '2025-05-21 11:43:23', '2025-05-23 12:01:47'),
(41, 'eeeeeeeeeeeeeeeeee', 45454.00, 44444444, '55444', 'RAM', 'eeeeeeeee', 'eeeeeeeeeeeeee', 'eeeeeeeeeee', 'Shown', '', '1 Year', '2025-05-21 11:56:02', '2025-05-23 11:50:51'),
(42, 'SUCCESSS', 10010.00, 111, '111', 'CPU', 'SUCCESS', 'work', 'CHANGE', 'Shown', '', '180 Days', '2025-05-23 07:45:55', '2025-05-23 11:36:14'),
(43, 'TEST3_GO', 1234.00, 111, '111', 'CPU', 'GOOO', 'GOOOO', 'GOOOO', 'Shown', 'uploads/img_68306745aef3e.jpg', '1 Year', '2025-05-23 12:17:09', '2025-05-23 12:33:22'),
(44, 'TEST_INSERT_UPDATE15', 234.00, 111, '111', 'CPU', 'UPDATE WORKS', 'Success', 'WORKED', 'Shown', '', '365 Days', '2025-05-25 12:43:05', '2025-05-25 13:46:57'),
(45, 'NEW PRODCUT', 222.00, 1123, '123', 'HEATSINK', 'TEST', 'TEST', 'TESST', 'Shown', 'uploads/img_68331923585b4.PNG', '365 Days', '2025-05-25 13:20:35', '2025-05-25 13:20:35'),
(46, 'GTX_ SAMPLE', 12321.00, 123, '123', 'GPU', 'GTX', 'GTX', 'GTX', 'Shown', 'uploads/img_683830a3c11ad.png', '365 Days', '2025-05-29 10:02:11', '2025-05-29 10:02:11'),
(47, 'GTX_ SAMPLE', 12321.00, 123, '123', 'GPU', 'GTX', 'GTX', 'GTX', 'Shown', 'uploads/img_683830a3c11aa.png', '365 Days', '2025-05-29 10:02:11', '2025-05-29 10:02:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
