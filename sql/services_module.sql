-- SQL module: Quản lý dịch vụ
-- Tạo bảng: services, booking_services

-- =============================
-- Table: services
-- =============================
CREATE TABLE IF NOT EXISTS `services` (
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

ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_service_court` (`court_id`);

ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `services`
  ADD CONSTRAINT `fk_service_court`
  FOREIGN KEY (`court_id`) REFERENCES `courts` (`id`) ON DELETE CASCADE;

-- =============================
-- Table: booking_services
-- =============================
CREATE TABLE IF NOT EXISTS `booking_services` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `booking_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_booking_service` (`booking_id`,`service_id`),
  ADD KEY `idx_booking_services_booking` (`booking_id`),
  ADD KEY `idx_booking_services_service` (`service_id`);

ALTER TABLE `booking_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `booking_services`
  ADD CONSTRAINT `fk_booking_services_booking`
  FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

ALTER TABLE `booking_services`
  ADD CONSTRAINT `fk_booking_services_service`
  FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

