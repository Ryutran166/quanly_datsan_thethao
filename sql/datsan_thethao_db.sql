-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 18, 2026 lúc 04:53 PM
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
  `user_id` int(11) DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `booking_date` date NOT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('Pending','Confirmed','Cancelled','Locked') DEFAULT 'Pending',
  `admin_confirmed_at` datetime DEFAULT NULL,
  `owner_confirmed_at` datetime DEFAULT NULL,
  `payment_method` enum('cash','qr') DEFAULT 'cash',
  `payment_status` enum('pending','paid','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`id`, `court_id`, `user_id`, `customer_name`, `customer_phone`, `booking_date`, `total_amount`, `status`, `admin_confirmed_at`, `owner_confirmed_at`, `payment_method`, `payment_status`, `created_at`) VALUES
(13, 7, 3, 'Trần Thanh Long', '0939448811', '2026-05-04', NULL, 'Confirmed', NULL, NULL, 'cash', 'pending', '2026-05-04 12:59:21'),
(14, 7, 10, 'Ryu Tran', '0337797091', '2026-05-04', NULL, 'Confirmed', NULL, NULL, 'cash', 'pending', '2026-05-04 13:07:14'),
(21, 3, 3, 'Trần Thanh Long', '0939448811', '2026-05-05', NULL, 'Confirmed', NULL, NULL, 'cash', 'pending', '2026-05-05 06:17:24'),
(22, 3, 10, 'Ryu Tran', '0337797091', '2026-05-05', NULL, 'Confirmed', NULL, NULL, 'cash', 'pending', '2026-05-05 06:18:10'),
(23, 3, NULL, 'Nhanh', '019804144', '2026-05-05', NULL, 'Confirmed', NULL, NULL, 'cash', 'pending', '2026-05-05 06:18:47'),
(30, 7, 3, 'Trần Thanh Long', '0939448811', '2026-05-05', NULL, 'Confirmed', NULL, NULL, 'cash', 'pending', '2026-05-05 08:13:54'),
(31, 7, NULL, 'Nhanh', '0935252525', '2026-05-05', NULL, 'Confirmed', NULL, NULL, 'cash', 'pending', '2026-05-05 08:14:09'),
(37, 7, NULL, 'Nhanh', '0935252525', '2026-05-06', NULL, 'Confirmed', NULL, NULL, 'cash', 'pending', '2026-05-06 06:08:40'),
(129, 7, 3, 'Trần Thanh Long', '0939448811', '2026-05-10', NULL, 'Confirmed', NULL, NULL, 'cash', 'pending', '2026-05-10 02:51:01'),
(130, 7, 3, 'Trần Thanh Long', '0939448811', '2026-05-10', NULL, 'Confirmed', NULL, NULL, 'cash', 'pending', '2026-05-10 02:51:01'),
(131, 7, 3, 'Trần Thanh Long', '0939448811', '2026-05-10', NULL, 'Confirmed', NULL, NULL, 'cash', 'pending', '2026-05-10 02:51:01'),
(136, 3, 3, 'Trần Thanh Long', '0939448811', '2026-05-10', NULL, 'Cancelled', NULL, NULL, 'cash', 'pending', '2026-05-10 02:52:19'),
(137, 3, 3, 'Trần Thanh Long', '0939448811', '2026-05-10', NULL, 'Confirmed', NULL, NULL, 'cash', 'pending', '2026-05-10 02:52:19'),
(168, 28, NULL, 'Nhanh', '0935252525', '2026-05-11', NULL, 'Confirmed', NULL, '2026-05-11 19:53:59', 'cash', 'pending', '2026-05-11 12:53:44'),
(169, 28, 3, 'Trần Thanh Long', '0939448811', '2026-05-11', NULL, 'Cancelled', NULL, NULL, 'qr', 'pending', '2026-05-11 14:43:02'),
(170, 28, 3, 'Trần Thanh Long', '0939448811', '2026-05-11', NULL, 'Confirmed', '2026-05-11 22:06:16', '2026-05-12 14:01:42', 'cash', 'pending', '2026-05-11 15:06:07'),
(171, 28, 10, 'Ryu Tran', '0337797091', '2026-05-12', NULL, 'Confirmed', NULL, '2026-05-12 14:01:04', 'qr', 'pending', '2026-05-12 07:00:50'),
(172, 28, 10, 'Ryu Tran', '0337797091', '2026-05-12', NULL, 'Confirmed', NULL, '2026-05-12 14:00:55', 'qr', 'pending', '2026-05-12 07:00:50'),
(173, 28, 3, 'Trần Thanh Long', '0939448811', '2026-05-12', NULL, 'Cancelled', NULL, '2026-05-12 14:01:55', 'cash', 'pending', '2026-05-12 07:01:17'),
(174, 28, 11, 'Kazuro', '11209331223', '2026-05-12', NULL, 'Confirmed', NULL, '2026-05-12 14:02:47', 'cash', 'pending', '2026-05-12 07:02:16'),
(175, 28, 11, 'Kazuro', '11209331223', '2026-05-12', NULL, 'Confirmed', NULL, '2026-05-12 14:03:30', 'cash', 'pending', '2026-05-12 07:03:20'),
(176, 28, 11, 'Kazuro', '11209331223', '2026-05-13', NULL, 'Cancelled', NULL, '2026-05-12 14:04:23', 'cash', 'pending', '2026-05-12 07:04:12'),
(177, 28, 10, 'Ryu Tran', '0337797091', '2026-05-12', NULL, 'Confirmed', NULL, '2026-05-12 14:13:24', 'qr', 'pending', '2026-05-12 07:13:16'),
(178, 28, 10, 'Ryu Tran', '0337797091', '2026-05-12', NULL, 'Confirmed', NULL, '2026-05-12 14:16:11', 'qr', 'pending', '2026-05-12 07:15:50'),
(179, 28, 11, 'Kazuro', '11209331223', '2026-05-12', NULL, 'Confirmed', NULL, '2026-05-12 14:28:38', 'qr', 'pending', '2026-05-12 07:18:39'),
(180, 28, 11, 'Kazuro', '11209331223', '2026-05-12', NULL, 'Confirmed', NULL, '2026-05-12 14:28:36', 'qr', 'pending', '2026-05-12 07:19:25'),
(181, 28, NULL, 'Nhanh', '0935252525', '2026-05-12', NULL, 'Confirmed', NULL, '2026-05-12 14:28:35', 'qr', 'pending', '2026-05-12 07:20:05'),
(182, 28, NULL, 'Nhanh', '0935252525', '2026-05-12', NULL, 'Confirmed', NULL, '2026-05-12 14:35:02', 'cash', 'pending', '2026-05-12 07:28:52'),
(183, 28, 10, 'Ryu Tran', '0337797091', '2026-05-12', NULL, 'Confirmed', NULL, '2026-05-12 14:35:00', 'qr', 'pending', '2026-05-12 07:31:41'),
(184, 28, 10, 'Ryu Tran', '0337797091', '2026-05-12', NULL, 'Confirmed', NULL, '2026-05-12 14:35:44', 'qr', 'pending', '2026-05-12 07:35:10'),
(185, 28, 10, 'Ryu Tran', '0337797091', '2026-05-12', NULL, 'Confirmed', NULL, '2026-05-12 14:36:31', 'qr', 'pending', '2026-05-12 07:35:58'),
(186, 28, 10, 'Ryu Tran', '0337797091', '2026-05-12', NULL, 'Confirmed', NULL, '2026-05-12 14:36:33', 'qr', 'pending', '2026-05-12 07:35:58'),
(187, 28, 10, 'Ryu Tran', '0337797091', '2026-05-12', NULL, 'Confirmed', NULL, '2026-05-12 14:41:08', 'qr', 'pending', '2026-05-12 07:41:02'),
(188, 28, 10, 'Ryu Tran', '0337797091', '2026-05-12', NULL, 'Confirmed', NULL, '2026-05-12 15:58:58', 'qr', 'pending', '2026-05-12 08:58:32'),
(189, 28, NULL, 'Nhanh', '0935252525', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 12:52:20', 'cash', 'pending', '2026-05-13 05:51:15'),
(190, 28, NULL, 'Nhanh', '0935252525', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 12:52:23', 'cash', 'pending', '2026-05-13 05:51:15'),
(191, 28, NULL, 'Nhanh', '0935252525', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 12:52:25', 'cash', 'pending', '2026-05-13 05:51:15'),
(192, 28, NULL, 'Nhanh', '0935252525', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 12:52:26', 'cash', 'pending', '2026-05-13 05:51:15'),
(193, 28, NULL, 'Nhanh', '0935252525', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 12:52:18', 'cash', 'pending', '2026-05-13 05:51:53'),
(194, 28, NULL, 'Nhanh', '0935252525', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 12:52:16', 'cash', 'pending', '2026-05-13 05:51:53'),
(195, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 12:58:21', 'cash', 'pending', '2026-05-13 05:53:43'),
(196, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 13:06:31', 'cash', 'pending', '2026-05-13 06:06:17'),
(197, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 13:24:02', 'cash', 'pending', '2026-05-13 06:23:56'),
(198, 28, 11, 'Kazuro', '11209331223', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 13:34:07', 'cash', 'pending', '2026-05-13 06:25:26'),
(199, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 13:34:02', 'cash', 'pending', '2026-05-13 06:32:48'),
(200, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 13:40:03', 'cash', 'pending', '2026-05-13 06:39:57'),
(201, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 13:41:46', 'cash', 'pending', '2026-05-13 06:40:26'),
(202, 28, NULL, 'Nhanh', '0935252525', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 13:42:16', 'cash', 'pending', '2026-05-13 06:42:07'),
(203, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 13:44:12', 'cash', 'pending', '2026-05-13 06:43:44'),
(204, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 13:44:06', 'cash', 'pending', '2026-05-13 06:43:59'),
(205, 28, 10, 'Ryu Tran', '0337797091', '2026-05-14', NULL, 'Confirmed', NULL, '2026-05-13 13:46:08', 'cash', 'pending', '2026-05-13 06:45:31'),
(206, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 13:51:32', 'cash', 'pending', '2026-05-13 06:46:16'),
(207, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 13:51:29', 'cash', 'pending', '2026-05-13 06:49:58'),
(208, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 13:59:16', 'cash', 'pending', '2026-05-13 06:52:06'),
(209, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 13:59:19', 'cash', 'pending', '2026-05-13 06:52:30'),
(210, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 13:59:13', 'cash', 'pending', '2026-05-13 06:54:14'),
(211, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 13:59:10', 'cash', 'pending', '2026-05-13 06:57:42'),
(212, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 13:59:07', 'cash', 'pending', '2026-05-13 06:58:37'),
(213, 28, 10, 'Ryu Tran', '0337797091', '2026-05-14', NULL, 'Confirmed', NULL, '2026-05-13 13:59:05', 'cash', 'pending', '2026-05-13 06:58:53'),
(214, 28, 10, 'Ryu Tran', '0337797091', '2026-05-14', NULL, 'Confirmed', NULL, '2026-05-13 14:07:06', 'cash', 'pending', '2026-05-13 07:02:30'),
(215, 28, 10, 'Ryu Tran', '0337797091', '2026-05-14', NULL, 'Confirmed', NULL, '2026-05-13 14:34:59', 'cash', 'pending', '2026-05-13 07:07:14'),
(216, 28, 10, 'Ryu Tran', '0337797091', '2026-05-14', NULL, 'Confirmed', NULL, '2026-05-13 14:34:57', 'cash', 'pending', '2026-05-13 07:17:55'),
(217, 28, 10, 'Ryu Tran', '0337797091', '2026-05-14', NULL, 'Confirmed', NULL, '2026-05-13 14:34:55', 'cash', 'pending', '2026-05-13 07:21:20'),
(218, 28, 10, 'Ryu Tran', '0337797091', '2026-05-14', NULL, 'Confirmed', NULL, '2026-05-13 14:34:54', 'cash', 'pending', '2026-05-13 07:27:11'),
(221, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 14:39:26', 'cash', 'pending', '2026-05-13 07:39:16'),
(222, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 14:41:30', 'cash', 'pending', '2026-05-13 07:39:37'),
(223, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 14:41:27', 'cash', 'pending', '2026-05-13 07:39:43'),
(224, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 14:41:25', 'cash', 'pending', '2026-05-13 07:41:11'),
(225, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 14:42:06', 'cash', 'paid', '2026-05-13 07:41:40'),
(226, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 14:52:50', 'cash', 'cancelled', '2026-05-13 07:52:28'),
(227, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', '2026-05-13 15:13:11', '2026-05-13 15:43:05', 'cash', 'pending', '2026-05-13 08:03:41'),
(228, 28, 3, 'Trần Thanh Long', '0939448811', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 15:42:14', 'cash', 'pending', '2026-05-13 08:39:44'),
(229, 28, 3, 'Trần Thanh Long', '0939448811', '2026-05-13', NULL, 'Cancelled', '2026-05-13 15:45:54', '2026-05-13 15:46:11', 'cash', 'pending', '2026-05-13 08:44:38'),
(230, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Cancelled', '2026-05-13 15:54:13', '2026-05-13 15:54:25', 'cash', 'pending', '2026-05-13 08:53:25'),
(231, 28, NULL, 'Nhanh', '0935252525', '2026-05-14', NULL, 'Confirmed', NULL, '2026-05-13 15:58:45', 'cash', 'pending', '2026-05-13 08:58:31'),
(232, 28, 11, 'Kazuro', '11209331223', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 16:01:48', 'cash', 'pending', '2026-05-13 09:01:36'),
(233, 28, 11, 'Kazuro', '11209331223', '2026-05-14', NULL, 'Cancelled', NULL, '2026-05-13 16:02:39', 'cash', 'pending', '2026-05-13 09:02:30'),
(234, 28, NULL, 'Nhanh', '0935252525', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 16:18:06', 'cash', 'pending', '2026-05-13 09:17:59'),
(235, 28, 11, 'Kazuro', '11209331223', '2026-05-14', NULL, 'Cancelled', NULL, '2026-05-13 16:20:26', 'cash', 'pending', '2026-05-13 09:20:15'),
(236, 28, 10, 'Ryu Tran', '0337797091', '2026-05-14', NULL, 'Cancelled', NULL, '2026-05-13 16:22:25', 'cash', 'pending', '2026-05-13 09:22:08'),
(237, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 16:23:43', 'cash', 'pending', '2026-05-13 09:23:37'),
(238, 28, 11, 'Kazuro', '11209331223', '2026-05-14', NULL, 'Cancelled', NULL, '2026-05-13 16:24:40', 'cash', 'pending', '2026-05-13 09:24:27'),
(239, 28, 11, 'Kazuro', '11209331223', '2026-05-14', NULL, 'Cancelled', NULL, '2026-05-13 16:25:39', 'cash', 'pending', '2026-05-13 09:25:29'),
(240, 28, 11, 'Kazuro', '11209331223', '2026-05-14', NULL, 'Cancelled', NULL, '2026-05-13 16:37:06', 'cash', 'pending', '2026-05-13 09:36:52'),
(241, 28, 11, 'Kazuro', '11209331223', '2026-05-14', NULL, 'Cancelled', NULL, '2026-05-13 16:38:25', 'cash', 'pending', '2026-05-13 09:38:16'),
(243, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 18:52:46', 'qr', 'pending', '2026-05-13 11:52:17'),
(244, 28, 10, 'Ryu Tran', '0337797091', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 18:53:17', 'cash', 'pending', '2026-05-13 11:53:13'),
(245, 28, 10, 'Ryu Tran', '0337797091', '2026-05-14', NULL, 'Cancelled', NULL, '2026-05-13 18:54:17', 'cash', 'pending', '2026-05-13 11:54:07'),
(247, 28, 3, 'Trần Thanh Long', '0939448811', '2026-05-14', NULL, 'Confirmed', '2026-05-13 19:14:00', '2026-05-13 20:15:12', 'cash', 'pending', '2026-05-13 12:13:42'),
(248, 29, NULL, 'Nhanh', '0935252525', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 22:45:55', 'cash', 'pending', '2026-05-13 15:45:33'),
(249, 29, 11, 'Kazuro', '11209331223', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 22:47:12', 'cash', 'pending', '2026-05-13 15:46:29'),
(250, 29, 11, 'Kazuro', '11209331223', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 22:48:10', 'cash', 'pending', '2026-05-13 15:48:01'),
(251, 29, 11, 'Kazuro', '11209331223', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 22:55:27', 'cash', 'pending', '2026-05-13 15:55:15'),
(252, 29, 11, 'Kazuro', '11209331223', '2026-05-14', NULL, 'Cancelled', NULL, '2026-05-13 22:56:43', 'cash', 'pending', '2026-05-13 15:56:32'),
(253, 29, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 22:58:27', 'cash', 'pending', '2026-05-13 15:58:21'),
(254, 29, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-13', NULL, 'Confirmed', NULL, '2026-05-13 22:58:47', 'cash', 'pending', '2026-05-13 15:58:42'),
(255, 29, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', NULL, 'Cancelled', NULL, '2026-05-13 22:59:06', 'cash', 'pending', '2026-05-13 15:59:02'),
(256, 29, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', NULL, 'Cancelled', NULL, '2026-05-13 23:14:09', 'cash', 'pending', '2026-05-13 16:14:03'),
(257, 30, 11, 'Kazuro', '11209331223', '2026-05-14', NULL, 'Confirmed', NULL, '2026-05-14 13:51:29', 'cash', 'pending', '2026-05-14 06:50:55'),
(258, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', NULL, 'Confirmed', NULL, '2026-05-14 15:21:44', 'cash', 'pending', '2026-05-14 08:21:41'),
(259, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', NULL, 'Confirmed', NULL, '2026-05-14 15:22:18', 'cash', 'pending', '2026-05-14 08:22:03'),
(260, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', NULL, 'Confirmed', NULL, '2026-05-14 15:22:20', 'cash', 'pending', '2026-05-14 08:22:10'),
(261, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', NULL, 'Confirmed', NULL, '2026-05-14 15:31:47', 'cash', 'pending', '2026-05-14 08:31:37'),
(262, 28, 10, 'Ryu Tran', '0337797091', '2026-05-14', 200000.00, 'Confirmed', NULL, '2026-05-14 15:38:42', 'qr', 'pending', '2026-05-14 08:38:31'),
(263, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 200000.00, 'Confirmed', NULL, '2026-05-14 16:14:20', 'cash', 'pending', '2026-05-14 08:40:04'),
(264, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 5000.00, 'Confirmed', NULL, '2026-05-14 16:14:18', 'cash', 'pending', '2026-05-14 08:42:21'),
(265, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 5000.00, 'Confirmed', NULL, '2026-05-14 16:14:16', 'qr', 'pending', '2026-05-14 08:44:50'),
(266, 28, 10, 'Ryu Tran', '0337797091', '2026-05-14', 5000.00, 'Confirmed', NULL, '2026-05-14 16:04:38', 'cash', 'pending', '2026-05-14 09:04:22'),
(267, 28, 10, 'Ryu Tran', '0337797091', '2026-05-14', 5000.00, 'Confirmed', NULL, '2026-05-14 16:05:57', 'cash', 'pending', '2026-05-14 09:05:47'),
(268, 28, 10, 'Ryu Tran', '0337797091', '2026-05-14', 10000.00, 'Confirmed', NULL, '2026-05-14 16:06:33', 'cash', 'pending', '2026-05-14 09:06:21'),
(269, 28, 10, 'Ryu Tran', '0337797091', '2026-05-14', 5000.00, 'Confirmed', NULL, '2026-05-14 16:09:45', 'cash', 'pending', '2026-05-14 09:08:57'),
(270, 28, 10, 'Ryu Tran', '0337797091', '2026-05-14', 5000.00, 'Confirmed', NULL, '2026-05-14 16:09:42', 'cash', 'pending', '2026-05-14 09:09:35'),
(271, 30, 10, 'Ryu Tran', '0337797091', '2026-05-14', 5000.00, 'Confirmed', NULL, '2026-05-14 16:14:13', 'cash', 'pending', '2026-05-14 09:13:23'),
(272, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 5000.00, 'Confirmed', NULL, '2026-05-14 16:17:35', 'cash', 'pending', '2026-05-14 09:17:29'),
(273, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 10000.00, 'Confirmed', NULL, '2026-05-14 16:19:11', 'cash', 'pending', '2026-05-14 09:18:45'),
(274, 29, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 200000.00, 'Confirmed', NULL, '2026-05-14 16:28:47', 'qr', 'pending', '2026-05-14 09:26:00'),
(275, 29, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 100000.00, 'Confirmed', NULL, '2026-05-14 16:28:44', 'cash', 'pending', '2026-05-14 09:27:38'),
(276, 29, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 100000.00, 'Confirmed', NULL, '2026-05-14 16:33:33', 'cash', 'pending', '2026-05-14 09:31:38'),
(277, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 5000.00, 'Confirmed', NULL, '2026-05-14 16:36:33', 'qr', 'pending', '2026-05-14 09:33:45'),
(278, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 5000.00, 'Confirmed', NULL, '2026-05-14 16:39:20', 'cash', 'pending', '2026-05-14 09:39:13'),
(279, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 5000.00, 'Confirmed', NULL, '2026-05-14 16:47:06', 'cash', 'pending', '2026-05-14 09:40:06'),
(280, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 5000.00, 'Confirmed', NULL, '2026-05-14 16:47:03', 'cash', 'pending', '2026-05-14 09:42:42'),
(281, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 5000.00, 'Confirmed', NULL, '2026-05-14 16:47:02', 'cash', 'pending', '2026-05-14 09:46:57'),
(282, 29, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 200000.00, 'Confirmed', NULL, '2026-05-14 17:00:57', 'cash', 'pending', '2026-05-14 09:49:02'),
(283, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 35000.00, 'Confirmed', NULL, '2026-05-14 17:00:51', 'cash', 'pending', '2026-05-14 10:00:22'),
(284, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 35000.00, 'Confirmed', NULL, '2026-05-14 17:00:47', 'cash', 'pending', '2026-05-14 10:00:34'),
(285, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 40000.00, 'Confirmed', NULL, '2026-05-14 17:02:56', 'cash', 'pending', '2026-05-14 10:02:11'),
(286, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 40000.00, 'Confirmed', NULL, '2026-05-14 17:40:41', 'cash', 'pending', '2026-05-14 10:39:43'),
(287, 29, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 230000.00, 'Confirmed', NULL, '2026-05-14 17:42:57', 'cash', 'pending', '2026-05-14 10:42:51'),
(288, 29, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 130000.00, 'Confirmed', NULL, '2026-05-14 17:43:26', 'cash', 'pending', '2026-05-14 10:43:14'),
(289, 29, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 130000.00, 'Confirmed', NULL, '2026-05-14 17:47:10', 'cash', 'pending', '2026-05-14 10:46:18'),
(290, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-15', 35000.00, 'Cancelled', NULL, '2026-05-14 17:49:15', 'qr', 'pending', '2026-05-14 10:49:07'),
(291, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-15', 50000.00, 'Cancelled', NULL, '2026-05-14 17:51:31', 'qr', 'pending', '2026-05-14 10:51:22'),
(292, 29, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 130000.00, 'Confirmed', NULL, '2026-05-14 17:53:38', 'cash', 'pending', '2026-05-14 10:52:27'),
(293, 29, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 130000.00, 'Confirmed', NULL, '2026-05-14 17:53:36', 'cash', 'pending', '2026-05-14 10:52:38'),
(294, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-15', 5000.00, 'Confirmed', NULL, '2026-05-14 17:59:11', 'cash', 'pending', '2026-05-14 10:59:06'),
(295, 29, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-14', 200000.00, 'Confirmed', NULL, '2026-05-14 18:00:14', 'qr', 'pending', '2026-05-14 11:00:07'),
(296, 28, 10, 'Ryu Tran', '0337797091', '2026-05-14', 5000.00, 'Confirmed', NULL, '2026-05-14 18:03:14', 'cash', 'pending', '2026-05-14 11:03:07'),
(297, 28, 10, 'Ryu Tran', '0337797091', '2026-05-14', 5000.00, 'Confirmed', NULL, '2026-05-14 18:04:53', 'cash', 'pending', '2026-05-14 11:04:37'),
(298, 28, 10, 'Ryu Tran', '0337797091', '2026-05-14', 5000.00, 'Confirmed', NULL, '2026-05-14 18:04:55', 'cash', 'pending', '2026-05-14 11:04:46'),
(299, 28, 10, 'Ryu Tran', '0337797091', '2026-05-14', 5000.00, 'Confirmed', NULL, '2026-05-16 13:37:14', 'cash', 'pending', '2026-05-14 11:06:52'),
(300, 28, 10, 'Ryu Tran', '0337797091', '2026-05-16', 40000.00, 'Confirmed', NULL, '2026-05-16 13:37:01', 'cash', 'pending', '2026-05-16 06:36:44'),
(301, 28, 10, 'Ryu Tran', '0337797091', '2026-05-16', 40000.00, 'Confirmed', NULL, '2026-05-16 13:38:17', 'qr', 'pending', '2026-05-16 06:37:58'),
(302, 28, 10, 'Ryu Tran', '0337797091', '2026-05-16', 45000.00, 'Confirmed', NULL, '2026-05-16 13:39:26', 'qr', 'pending', '2026-05-16 06:39:20'),
(303, 3, 10, 'Ryu Tran', '0337797091', '2026-05-16', 435000.00, 'Confirmed', NULL, '2026-05-16 13:42:12', 'qr', 'pending', '2026-05-16 06:41:02'),
(304, 28, NULL, 'Nhanh', '0935252525', '2026-05-16', 50000.00, 'Confirmed', NULL, '2026-05-16 13:43:59', 'qr', 'pending', '2026-05-16 06:43:50'),
(305, 28, 10, 'Ryu Tran', '0337797091', '2026-05-16', 40000.00, 'Confirmed', NULL, '2026-05-16 13:44:26', 'cash', 'pending', '2026-05-16 06:44:20'),
(306, 28, 10, 'Ryu Tran', '0337797091', '2026-05-16', 40000.00, 'Confirmed', NULL, '2026-05-16 13:45:06', 'cash', 'pending', '2026-05-16 06:44:40'),
(307, 28, 10, 'Ryu Tran', '0337797091', '2026-05-16', 40000.00, 'Confirmed', NULL, '2026-05-16 13:45:03', 'qr', 'pending', '2026-05-16 06:44:53'),
(308, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-16', 40000.00, 'Confirmed', NULL, '2026-05-16 13:49:12', 'qr', 'pending', '2026-05-16 06:49:04'),
(309, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-16', 40000.00, 'Confirmed', NULL, '2026-05-16 14:19:03', 'qr', 'pending', '2026-05-16 07:12:30'),
(310, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-16', 5000.00, 'Confirmed', NULL, '2026-05-16 14:19:01', 'cash', 'pending', '2026-05-16 07:14:05'),
(311, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-16', 5000.00, 'Confirmed', NULL, '2026-05-16 14:18:59', 'cash', 'pending', '2026-05-16 07:15:21'),
(312, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-16', 35000.00, 'Confirmed', NULL, '2026-05-16 14:18:57', 'qr', 'pending', '2026-05-16 07:15:44'),
(313, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-16', 5000.00, 'Confirmed', NULL, '2026-05-16 14:18:55', 'cash', 'pending', '2026-05-16 07:17:35'),
(314, 29, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-16', 130000.00, 'Confirmed', NULL, '2026-05-16 14:18:53', 'qr', 'pending', '2026-05-16 07:17:54'),
(315, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-16', 35000.00, 'Confirmed', NULL, '2026-05-16 14:18:51', 'qr', 'pending', '2026-05-16 07:18:44'),
(316, 30, 6, 'Nguyễn Trung Kiên', '098422144', '2026-05-16', 40000.00, 'Confirmed', NULL, '2026-05-16 14:41:52', 'qr', 'pending', '2026-05-16 07:41:30'),
(317, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-16', 190000.00, 'Confirmed', NULL, '2026-05-16 15:02:44', 'cash', 'pending', '2026-05-16 08:02:11'),
(318, 30, 5, 'Huỳnh Thành Hiệp ', '0994244344', '2026-05-16', 190000.00, 'Confirmed', NULL, '2026-05-16 15:02:34', 'cash', 'pending', '2026-05-16 08:02:29'),
(319, 30, NULL, 'Nhanh', '0935252525', '2026-05-16', 300000.00, 'Confirmed', NULL, '2026-05-16 15:19:05', 'qr', 'pending', '2026-05-16 08:14:12'),
(320, 30, 3, 'Trần Thanh Long', '0939448811', '2026-05-18', 120000.00, 'Confirmed', '2026-05-18 21:51:10', '2026-05-18 21:51:28', 'qr', 'pending', '2026-05-18 14:50:53');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_details`
--

CREATE TABLE `booking_details` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `slot_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_details`
--

INSERT INTO `booking_details` (`id`, `booking_id`, `slot_id`) VALUES
(242, 221, 2),
(243, 221, 4),
(244, 221, 6),
(245, 221, 8),
(247, 222, 1),
(246, 222, 3),
(248, 222, 5),
(249, 222, 7),
(250, 223, 9),
(251, 223, 10),
(252, 223, 11),
(253, 224, 12),
(254, 224, 13),
(255, 225, 14),
(256, 225, 15),
(257, 226, 16),
(258, 226, 17),
(259, 226, 18),
(260, 227, 19),
(261, 227, 20),
(262, 228, 21),
(263, 229, 22),
(264, 229, 23),
(266, 229, 24),
(265, 229, 25),
(267, 230, 26),
(268, 230, 27),
(269, 231, 1),
(270, 232, 22),
(271, 232, 23),
(272, 233, 2),
(273, 233, 3),
(274, 234, 24),
(275, 234, 25),
(276, 234, 26),
(277, 235, 2),
(278, 235, 3),
(279, 236, 2),
(280, 236, 3),
(281, 237, 27),
(282, 237, 28),
(283, 238, 2),
(284, 238, 3),
(285, 239, 2),
(286, 239, 3),
(287, 239, 4),
(288, 240, 2),
(289, 240, 3),
(291, 241, 16),
(290, 241, 17),
(295, 243, 29),
(296, 244, 30),
(297, 244, 31),
(298, 244, 32),
(300, 245, 16),
(299, 245, 17),
(304, 247, 15),
(305, 248, 1),
(306, 248, 2),
(309, 248, 3),
(308, 248, 4),
(307, 248, 5),
(311, 248, 6),
(312, 248, 7),
(310, 248, 8),
(318, 248, 9),
(313, 248, 10),
(314, 248, 11),
(317, 248, 12),
(320, 248, 13),
(319, 248, 14),
(316, 248, 15),
(321, 248, 16),
(315, 248, 17),
(322, 249, 18),
(323, 249, 19),
(324, 249, 20),
(325, 250, 21),
(326, 250, 22),
(327, 250, 23),
(328, 250, 24),
(329, 251, 25),
(330, 251, 26),
(331, 251, 27),
(332, 252, 8),
(333, 252, 9),
(334, 253, 28),
(335, 253, 29),
(336, 253, 30),
(337, 254, 31),
(338, 254, 32),
(339, 255, 1),
(340, 255, 2),
(341, 255, 3),
(342, 255, 4),
(344, 255, 5),
(343, 255, 6),
(349, 256, 13),
(348, 256, 14),
(347, 256, 15),
(346, 256, 16),
(345, 256, 17),
(350, 257, 8),
(351, 257, 9),
(352, 257, 10),
(353, 258, 7),
(355, 259, 4),
(356, 259, 5),
(354, 259, 6),
(359, 260, 1),
(358, 260, 2),
(357, 260, 3),
(360, 261, 11),
(361, 261, 12),
(362, 261, 13),
(363, 262, 3),
(364, 262, 4),
(366, 263, 15),
(365, 263, 16),
(367, 264, 14),
(368, 265, 17),
(369, 266, 6),
(370, 267, 2),
(371, 268, 7),
(372, 268, 8),
(373, 269, 5),
(374, 270, 9),
(375, 271, 18),
(376, 272, 19),
(377, 273, 20),
(378, 273, 21),
(380, 274, 7),
(379, 274, 8),
(381, 275, 9),
(382, 276, 6),
(383, 277, 22),
(384, 278, 23),
(385, 279, 24),
(386, 280, 25),
(387, 281, 26),
(389, 282, 4),
(388, 282, 5),
(390, 283, 27),
(391, 284, 28),
(392, 285, 29),
(393, 285, 30),
(394, 286, 31),
(395, 286, 32),
(396, 287, 10),
(397, 287, 11),
(398, 288, 3),
(399, 289, 12),
(400, 290, 1),
(401, 291, 2),
(402, 291, 3),
(404, 291, 4),
(403, 291, 5),
(405, 292, 13),
(406, 293, 14),
(407, 294, 2),
(408, 295, 1),
(409, 295, 2),
(410, 296, 11),
(411, 297, 10),
(412, 298, 12),
(413, 299, 13),
(414, 300, 1),
(415, 301, 2),
(416, 302, 3),
(417, 302, 4),
(419, 303, 1),
(418, 303, 2),
(420, 304, 5),
(421, 304, 6),
(422, 304, 7),
(423, 305, 8),
(424, 306, 9),
(425, 307, 10),
(427, 308, 1),
(426, 308, 2),
(428, 309, 3),
(429, 309, 4),
(430, 310, 5),
(431, 311, 6),
(432, 312, 7),
(433, 313, 8),
(434, 314, 1),
(435, 315, 9),
(436, 316, 10),
(437, 316, 11),
(438, 317, 12),
(439, 318, 13),
(440, 319, 14),
(441, 319, 15),
(442, 319, 16),
(443, 320, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_services`
--

CREATE TABLE `booking_services` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_services`
--

INSERT INTO `booking_services` (`id`, `booking_id`, `service_id`, `created_at`) VALUES
(1, 283, 3, '2026-05-14 10:00:22'),
(2, 284, 3, '2026-05-14 10:00:34'),
(3, 285, 3, '2026-05-14 10:02:11'),
(4, 286, 3, '2026-05-14 10:39:43'),
(5, 287, 2, '2026-05-14 10:42:51'),
(6, 288, 2, '2026-05-14 10:43:14'),
(7, 289, 2, '2026-05-14 10:46:18'),
(8, 290, 3, '2026-05-14 10:49:07'),
(9, 291, 3, '2026-05-14 10:51:22'),
(10, 292, 2, '2026-05-14 10:52:27'),
(11, 293, 2, '2026-05-14 10:52:38'),
(12, 300, 4, '2026-05-16 06:36:44'),
(13, 301, 4, '2026-05-16 06:37:58'),
(14, 302, 4, '2026-05-16 06:39:20'),
(15, 303, 5, '2026-05-16 06:41:02'),
(16, 304, 4, '2026-05-16 06:43:50'),
(17, 305, 4, '2026-05-16 06:44:20'),
(18, 306, 4, '2026-05-16 06:44:40'),
(19, 307, 4, '2026-05-16 06:44:53'),
(20, 308, 3, '2026-05-16 06:49:04'),
(21, 309, 3, '2026-05-16 07:12:30'),
(22, 312, 3, '2026-05-16 07:15:44'),
(23, 314, 2, '2026-05-16 07:17:54'),
(24, 315, 3, '2026-05-16 07:18:44'),
(25, 316, 3, '2026-05-16 07:41:30'),
(26, 317, 7, '2026-05-16 08:02:11'),
(27, 317, 6, '2026-05-16 08:02:11'),
(28, 317, 3, '2026-05-16 08:02:11'),
(29, 318, 7, '2026-05-16 08:02:29'),
(30, 318, 6, '2026-05-16 08:02:29'),
(31, 318, 3, '2026-05-16 08:02:29'),
(32, 320, 8, '2026-05-18 14:50:53');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `message`, `submitted_at`) VALUES
(1, 'Trần Thanh Long', 'lt1662004@gmail.com', 'hello\r\n', '2026-05-06 07:01:04'),
(2, 'Ryu', 'ryu@gmail.com', 'hellooooo', '2026-05-11 13:56:57'),
(3, 'Ryu', 'ryu@gmail.com', 'hiiiiiiiiii', '2026-05-13 12:02:26');

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
  `image` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `owner_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Danh sach san cau long';

--
-- Đang đổ dữ liệu cho bảng `courts`
--

INSERT INTO `courts` (`id`, `name`, `price`, `status`, `address`, `image`, `created_at`, `updated_at`, `owner_id`, `quantity`) VALUES
(3, 'Sân Huỳnh Châu', 200000.00, 'available', 'Hẻm 51', 'default.png', '2026-04-26 16:06:38', '2026-05-13 22:06:16', 10, 1),
(6, 'Sân Hoàng Huy', 300000.00, 'available', NULL, '', '2026-04-26 18:30:44', '2026-05-13 22:06:16', 10, 1),
(7, 'Sân An Bình', 300000.00, 'available', 'Cái Răng', '', '2026-04-26 18:30:59', '2026-05-13 22:06:16', 10, 1),
(28, 'Sân 442', 5000.00, 'available', 'Cái Răng', '', '2026-05-11 19:53:05', '2026-05-14 16:00:27', 10, 1),
(29, 'Sân Tây Đô', 100000.00, 'available', 'Trần chiên', NULL, '2026-05-13 22:21:03', '2026-05-13 22:21:03', 5, 1),
(30, 'Sân Tây Nam', 100000.00, 'available', 'Trần chiên', '', '2026-05-13 23:17:13', '2026-05-16 14:49:15', 5, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `court_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `services`
--

INSERT INTO `services` (`id`, `court_id`, `service_name`, `price`, `description`, `image`, `status`, `created_at`, `updated_at`) VALUES
(2, 29, 'Thuê ao bib', 30000.00, NULL, NULL, 'active', '2026-05-14 08:12:13', '2026-05-14 08:12:13'),
(3, 30, 'Thuê áo bib', 30000.00, NULL, NULL, 'active', '2026-05-14 08:12:49', '2026-05-16 07:54:34'),
(4, 28, 'Thuê áo bib', 35000.00, NULL, NULL, 'active', '2026-05-14 08:37:16', '2026-05-14 08:37:16'),
(5, 3, 'Thuê áo bib', 35000.00, NULL, NULL, 'active', '2026-05-16 06:40:46', '2026-05-16 06:40:46'),
(6, 30, 'Thuê giày', 50000.00, NULL, NULL, 'active', '2026-05-16 07:55:38', '2026-05-16 07:55:38'),
(7, 30, 'Băng keo', 10000.00, NULL, NULL, 'active', '2026-05-16 08:01:58', '2026-05-16 08:01:58'),
(8, 30, 'Cọc tập luyện', 20000.00, NULL, NULL, 'active', '2026-05-16 08:03:29', '2026-05-16 08:03:29'),
(9, 30, 'nước giải khát', 30000.00, NULL, NULL, 'inactive', '2026-05-16 08:04:09', '2026-05-16 08:04:49');

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
-- Đang đổ dữ liệu cho bảng `time_slots`
--

INSERT INTO `time_slots` (`id`, `start_time`, `end_time`, `price_modifier`) VALUES
(1, '06:00:00', '06:30:00', 1.00),
(2, '06:30:00', '07:00:00', 1.00),
(3, '07:00:00', '07:30:00', 1.00),
(4, '07:30:00', '08:00:00', 1.00),
(5, '08:00:00', '08:30:00', 1.00),
(6, '08:30:00', '09:00:00', 1.00),
(7, '09:00:00', '09:30:00', 1.00),
(8, '09:30:00', '10:00:00', 1.00),
(9, '10:00:00', '10:30:00', 1.00),
(10, '10:30:00', '11:00:00', 1.00),
(11, '11:00:00', '11:30:00', 1.00),
(12, '11:30:00', '12:00:00', 1.00),
(13, '12:00:00', '12:30:00', 1.00),
(14, '12:30:00', '13:00:00', 1.00),
(15, '13:00:00', '13:30:00', 1.00),
(16, '13:30:00', '14:00:00', 1.00),
(17, '14:00:00', '14:30:00', 1.00),
(18, '14:30:00', '15:00:00', 1.00),
(19, '15:00:00', '15:30:00', 1.00),
(20, '15:30:00', '16:00:00', 1.00),
(21, '16:00:00', '16:30:00', 1.00),
(22, '16:30:00', '17:00:00', 1.00),
(23, '17:00:00', '17:30:00', 1.00),
(24, '17:30:00', '18:00:00', 1.00),
(25, '18:00:00', '18:30:00', 1.00),
(26, '18:30:00', '19:00:00', 1.00),
(27, '19:00:00', '19:30:00', 1.00),
(28, '19:30:00', '20:00:00', 1.00),
(29, '20:00:00', '20:30:00', 1.00),
(30, '20:30:00', '21:00:00', 1.00),
(31, '21:00:00', '21:30:00', 1.00),
(32, '21:30:00', '22:00:00', 1.00);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(20) DEFAULT 'customer',
  `vietqr_bank_code` varchar(20) DEFAULT NULL,
  `vietqr_account_number` varchar(50) DEFAULT NULL,
  `vietqr_account_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `created_at`, `role`, `vietqr_bank_code`, `vietqr_account_number`, `vietqr_account_name`) VALUES
(3, 'Trần Thanh Long', 'longtran@gmail.com', '$2y$10$wvIyH.1Y28Q77h1uXaXLhukodNXcvFM./v3mi2/FXaclMzWC5lB6O', '0939448811', '2026-04-26 16:41:17', 'admin', NULL, NULL, NULL),
(4, 'Đỗ Thành Đô', 'do@gmail.com', '$2y$10$GwS2UuWN2nVuciJTK6TFCuOe.Hg9Iw3dR86RQP0edmolN.tDLcfrK', '098419224', '2026-04-26 16:59:54', 'customer', NULL, NULL, NULL),
(5, 'Huỳnh Thành Hiệp ', 'hiep@gmail.com', '$2y$10$xaRQrIm47ZG4/ef9QETqAucJNUffd2M6o5t5ttYzQQNVHUgYYrQq6', '0994244344', '2026-04-26 17:14:05', 'owner', 'TCB', '16620048386', 'Tran  Thanh Long'),
(6, 'Nguyễn Trung Kiên', 'kien@gmail.com', '$2y$10$mDAwMUXQmoZqt1jPyLXY9uCvSGENxnl6KvQnVp/VUTzY7c3E2V8tq', '098422144', '2026-04-27 05:46:23', 'customer', NULL, NULL, NULL),
(7, 'Koori', 'Koori@gmail.com', '$2y$10$c7/4jbTbakkc9n6QK4Lgyuv0PjwNTFajvwPT/yzkPYrSGgesklhAS', '0935461720', '2026-04-28 07:56:44', 'customer', NULL, NULL, NULL),
(8, 'Kooria', 'kazel@gmail.com', '$2y$10$lETAprMEKzI5Rhd/1oGSXev9jqed/6VWi6.mMXjUn4ZE60hxHCh0C', '0935461720', '2026-04-29 15:58:58', 'admin', NULL, NULL, NULL),
(9, 'Kooriaa', 'aquari@gmail.com', '$2y$10$6xhk.QiZjYIFXcUoYNIcxuU5SFxSwBZpPmtUFJ.T4iLR57cdXqfom', '0935461720', '2026-04-29 18:28:21', 'customer', NULL, NULL, NULL),
(10, 'Ryu Tran', 'ryu@gmail.com', '$2y$10$S618CSdl.1vxGLTusPcOa.ieOAoVeimvxW/oAUM8CHGzYhpJhqtye', '0337797091', '2026-05-04 07:45:46', 'owner', 'VIB', '337797091', 'Tran  Thanh  Long'),
(11, 'Kazuro', 'kazurokaedehara@gmail.com', '$2y$10$9Cl4S6cLDlcgZIDx8lSkSeW38tWfjutGjG8Q0JjUIq2hmNNKVlYYG', '11209331223', '2026-05-04 08:47:51', 'customer', NULL, NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_court` (`court_id`),
  ADD KEY `idx_user` (`user_id`);

--
-- Chỉ mục cho bảng `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_booking_slot` (`booking_id`,`slot_id`),
  ADD KEY `slot_id` (`slot_id`);

--
-- Chỉ mục cho bảng `booking_services`
--
ALTER TABLE `booking_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_booking_service` (`booking_id`,`service_id`),
  ADD KEY `idx_booking_services_booking` (`booking_id`),
  ADD KEY `idx_booking_services_service` (`service_id`);

--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `courts`
--
ALTER TABLE `courts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `fk_owner` (`owner_id`);

--
-- Chỉ mục cho bảng `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_service_court` (`court_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=321;

--
-- AUTO_INCREMENT cho bảng `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=444;

--
-- AUTO_INCREMENT cho bảng `booking_services`
--
ALTER TABLE `booking_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `courts`
--
ALTER TABLE `courts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `time_slots`
--
ALTER TABLE `time_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fk_booking_court` FOREIGN KEY (`court_id`) REFERENCES `courts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_booking_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `booking_details`
--
ALTER TABLE `booking_details`
  ADD CONSTRAINT `booking_details_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_details_ibfk_2` FOREIGN KEY (`slot_id`) REFERENCES `time_slots` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `booking_services`
--
ALTER TABLE `booking_services`
  ADD CONSTRAINT `fk_booking_services_booking` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_booking_services_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `courts`
--
ALTER TABLE `courts`
  ADD CONSTRAINT `fk_owner` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `fk_service_court` FOREIGN KEY (`court_id`) REFERENCES `courts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
