-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2026 at 10:58 AM
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
-- Database: `datsan_thethao_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `court_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `booking_date` date NOT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('Pending','Confirmed','Cancelled','Locked') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `court_id`, `customer_name`, `customer_phone`, `user_id`, `booking_date`, `total_amount`, `status`, `created_at`) VALUES
(7, 8, 'Nguyễn Trung Kiên', '0357124853', NULL, '2026-04-27', NULL, 'Confirmed', '2026-04-27 10:05:51');

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `slot_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`id`, `booking_id`, `slot_id`) VALUES
(7, 7, 3);

-- --------------------------------------------------------

--
-- Table structure for table `courts`
--

CREATE TABLE `courts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL COMMENT 'VD: San A1, San VIP B2',
  `price` decimal(10,2) NOT NULL COMMENT 'Gia thue gio thuong (VND)',
  `status` enum('available','booked','maintenance') NOT NULL DEFAULT 'available',
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'địa chỉ sân',
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Danh sach san cau long';

--
-- Dumping data for table `courts`
--

INSERT INTO `courts` (`id`, `name`, `price`, `status`, `address`, `image_url`, `created_at`, `updated_at`) VALUES
(3, 'Sân Huỳnh Châu', 200000.00, 'available', NULL, 'https://images.unsplash.com/photo-1508098682722-e99c643e7f0b', '2026-04-26 16:06:38', '2026-04-27 14:32:57'),
(6, 'Sân Hoàng Huy', 300000.00, 'available', NULL, '', '2026-04-26 18:30:44', '2026-04-26 19:37:24'),
(7, 'Sân An Bình', 300000.00, 'available', NULL, '', '2026-04-26 18:30:59', '2026-04-26 19:37:19'),
(8, 'Sân Tây Đô', 300000.00, 'available', NULL, 'https://images.unsplash.com/photo-1508098682722-e99c643e7f0b', '2026-04-26 19:11:27', '2026-04-27 14:48:50');

-- --------------------------------------------------------

--
-- Table structure for table `time_slots`
--

CREATE TABLE `time_slots` (
  `id` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `price_modifier` decimal(3,2) DEFAULT 1.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `time_slots`
--

INSERT INTO `time_slots` (`id`, `start_time`, `end_time`, `price_modifier`) VALUES
(1, '06:00:00', '07:00:00', 1.00),
(2, '07:00:00', '08:00:00', 1.00),
(3, '08:00:00', '09:00:00', 1.00),
(4, '09:00:00', '10:00:00', 1.00),
(5, '10:00:00', '11:00:00', 1.00),
(6, '14:00:00', '15:00:00', 1.00),
(7, '15:00:00', '16:00:00', 1.00),
(8, '16:00:00', '17:00:00', 1.00),
(9, '17:00:00', '18:00:00', 1.00),
(10, '18:00:00', '19:00:00', 1.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `created_at`) VALUES
(3, 'Trần Thanh Long', 'longtran@gmail.com', '$2y$10$wiwQktlRtI1FWPSy9dmkkuypChKchKngX60sseb3.8/EMSfrDBKEC', '0939448811', '2026-04-26 16:41:17'),
(4, 'Đỗ Thành Đô', 'do@gmail.com', '$2y$10$GwS2UuWN2nVuciJTK6TFCuOe.Hg9Iw3dR86RQP0edmolN.tDLcfrK', '098419224', '2026-04-26 16:59:54'),
(5, 'Huỳnh Thành Hiệp ', 'hiep@gmail.com', '$2y$10$xaRQrIm47ZG4/ef9QETqAucJNUffd2M6o5t5ttYzQQNVHUgYYrQq6', '0994244344', '2026-04-26 17:14:05'),
(7, 'Nguyễn Trung Kiên', 'trungkien@gmail.com', '$2y$10$JsVARjR8Tmt1OjtXuwX8WOhpe28dnwa7buYsGhMzgXs.Q5HqTs9XO', '0357124853', '2026-04-27 08:38:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `court_id` (`court_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_booking_slot` (`booking_id`,`slot_id`),
  ADD KEY `slot_id` (`slot_id`);

--
-- Indexes for table `courts`
--
ALTER TABLE `courts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `time_slots`
--
ALTER TABLE `time_slots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `courts`
--
ALTER TABLE `courts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `time_slots`
--
ALTER TABLE `time_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`court_id`) REFERENCES `courts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD CONSTRAINT `booking_details_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_details_ibfk_2` FOREIGN KEY (`slot_id`) REFERENCES `time_slots` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
