-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 27, 2026 lúc 10:00 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `datsan_thethao_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `court_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `booking_date` date NOT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('Pending','Confirmed','Cancelled','Locked') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_details`
--

CREATE TABLE `booking_details` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `slot_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `courts`
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
-- Đang đổ dữ liệu cho bảng `courts`
--

INSERT INTO `courts` (`id`, `name`, `price`, `status`, `address`, `image_url`, `created_at`, `updated_at`) VALUES
(3, 'Sân Huỳnh Châu', 200000.00, 'available', NULL, 'https://images.unsplash.com/photo-1508098682722-e99c643e7f0b', '2026-04-26 16:06:38', '2026-04-27 14:32:57'),
(6, 'Sân Hoàng Huy', 300000.00, 'available', NULL, '', '2026-04-26 18:30:44', '2026-04-26 19:37:24'),
(7, 'Sân An Bình', 300000.00, 'available', NULL, '', '2026-04-26 18:30:59', '2026-04-26 19:37:19'),
(8, 'Sân Tây Đô', 300000.00, 'available', NULL, 'https://images.unsplash.com/photo-1508098682722-e99c643e7f0b', '2026-04-26 19:11:27', '2026-04-27 14:48:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `time_slots`
--

CREATE TABLE `time_slots` (
  `id` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `price_modifier` decimal(3,2) DEFAULT 1.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đổ dữ liệu mẫu cho bảng `time_slots`
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
-- Cấu trúc bảng cho bảng `users`
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
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `created_at`) VALUES
(3, 'Trần Thanh Long', 'longtran@gmail.com', '$2y$10$wiwQktlRtI1FWPSy9dmkkuypChKchKngX60sseb3.8/EMSfrDBKEC', '0939448811', '2026-04-26 16:41:17'),
(4, 'Đỗ Thành Đô', 'do@gmail.com', '$2y$10$GwS2UuWN2nVuciJTK6TFCuOe.Hg9Iw3dR86RQP0edmolN.tDLcfrK', '098419224', '2026-04-26 16:59:54'),
(5, 'Huỳnh Thành Hiệp ', 'hiep@gmail.com', '$2y$10$xaRQrIm47ZG4/ef9QETqAucJNUffd2M6o5t5ttYzQQNVHUgYYrQq6', '0994244344', '2026-04-26 17:14:05'),
(6, 'Nguyễn Trung Kiên', 'kien@gmail.com', '$2y$10$mDAwMUXQmoZqt1jPyLXY9uCvSGENxnl6KvQnVp/VUTzY7c3E2V8tq', '098422144', '2026-04-27 05:46:23');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `court_id` (`court_id`);

--
-- Chỉ mục cho bảng `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_booking_slot` (`booking_id`,`slot_id`),
  ADD KEY `slot_id` (`slot_id`);

--
-- Chỉ mục cho bảng `courts`
--
ALTER TABLE `courts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`);

--
-- Chỉ mục cho bảng `time_slots`
--
ALTER TABLE `time_slots`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `courts`
--
ALTER TABLE `courts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `time_slots`
--
ALTER TABLE `time_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`court_id`) REFERENCES `courts` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `booking_details`
--
ALTER TABLE `booking_details`
  ADD CONSTRAINT `booking_details_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_details_ibfk_2` FOREIGN KEY (`slot_id`) REFERENCES `time_slots` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
