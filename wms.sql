-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2023 at 10:29 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
CREATE DATABASE IF NOT EXISTS wms;
USE wms;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wms`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `workshop_id` bigint(20) UNSIGNED DEFAULT 0,
  `vehicle_plate` varchar(255) NOT NULL,
  `vehicle_make` varchar(255) NOT NULL,
  `customer_lng` decimal(9,6) NOT NULL,
  `customer_ltd` decimal(8,6) NOT NULL,
  `description` varchar(255) NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `accepted_status` enum('pending','accepted','rejected') NOT NULL,
  `accepted_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `customer_id`, `workshop_id`, `vehicle_plate`, `vehicle_make`, `customer_lng`, `customer_ltd`, `description`, `time_created`, `accepted_status`, `accepted_time`) VALUES
(3, 1, 1, 'gh 288 s', 'toy', 0.000000, 0.000000, 'bruh', '2023-05-01 10:24:48', 'pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `workshop_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `price` decimal(8,2) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `min_stock` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `workshop_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `worker_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_plate` varchar(255) NOT NULL,
  `vehicle_make` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `finish_time` timestamp NULL DEFAULT NULL,
  `comment` varchar(255) NOT NULL,
  `invoice_link` varchar(255) NOT NULL,
  `feedback` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `new_login_table`
--

CREATE TABLE `new_login_table` (
  `token_id` bigint(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` int(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `token_id` bigint(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `steps`
--

CREATE TABLE `steps` (
  `step_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `desc` varchar(255) NOT NULL,
  `finish` tinyint(1) NOT NULL DEFAULT 0,
  `worker_id` bigint(20) UNSIGNED NOT NULL,
  `comment` varchar(255) NOT NULL,
  `item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `worker_fee` decimal(8,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `gender` varchar(7) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `phone_no` int(11) UNSIGNED DEFAULT NULL,
  `type` enum('c','w','a','s') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `name`, `DOB`, `company`, `phone_no`, `type`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$TSej5hh.sbPddZ6ph3VUgey2Mg/jNUSeXxNCnyD6cld7psQ/9/sNq', 'Admin', NULL, 'SafeTruck', NULL, 's'),
(2, 'New User', 'hamza.ishrat@yahoo.com', '$2y$10$Q7/WPj7rsdI/SGyDn.IlFua/SW9IQrbiaK08cTG2jXTz/mB9XwCBq', NULL, NULL, NULL, NULL, 'c');

-- --------------------------------------------------------

--
-- Table structure for table `workers`
--

CREATE TABLE `workers` (
  `worker_id` bigint(20) UNSIGNED NOT NULL,
  `workshop_id` bigint(20) UNSIGNED NOT NULL,
  `has_inventory_access` tinyint(1) NOT NULL,
  `has_job_access` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `workshops`
--

CREATE TABLE `workshops` (
  `workshop_id` bigint(20) UNSIGNED NOT NULL,
  `workshop_owner_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `opening_hours` varchar(255) NOT NULL,
  `specialisations` varchar(255) NOT NULL,
  `phone_no` int(11) NOT NULL,
  `workshop_lng` decimal(9,6) NOT NULL,
  `workshop_ltd` decimal(8,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `workshops`
--

INSERT INTO `workshops` (`workshop_id`, `workshop_owner_id`, `name`, `location`, `opening_hours`, `specialisations`, `phone_no`, `workshop_lng`, `workshop_ltd`) VALUES
(1, 2, 'name', 'there', '9:00 am to 9:01am', 'cars', 22292, 0.000000, 0.000000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `booking_customer_id_foreign` (`customer_id`),
  ADD KEY `booking_workshop_id_foreign` (`workshop_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `inventory_workshop_id_foreign` (`workshop_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `job_workshop_id_foreign` (`workshop_id`),
  ADD KEY `job_customer_id_foreign` (`customer_id`),
  ADD KEY `job_worker_id_foreign` (`worker_id`);

--
-- Indexes for table `new_login_table`
--
ALTER TABLE `new_login_table`
  ADD PRIMARY KEY (`token_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`token_id`);

--
-- Indexes for table `steps`
--
ALTER TABLE `steps`
  ADD PRIMARY KEY (`step_id`),
  ADD KEY `step_worker_id_foreign` (`worker_id`),
  ADD KEY `step_item_id_foreign` (`item_id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`worker_id`),
  ADD KEY `worker_workshop_id_foreign` (`workshop_id`);

--
-- Indexes for table `workshops`
--
ALTER TABLE `workshops`
  ADD PRIMARY KEY (`workshop_id`),
  ADD KEY `workshops_workshop_owner_id_foreign` (`workshop_owner_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `item_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `job_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `new_login_table`
--
ALTER TABLE `new_login_table`
  MODIFY `token_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  MODIFY `token_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `steps`
--
ALTER TABLE `steps`
  MODIFY `step_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `workers`
--
ALTER TABLE `workers`
  MODIFY `worker_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `workshops`
--
ALTER TABLE `workshops`
  MODIFY `workshop_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `booking_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_workshop_id_foreign` FOREIGN KEY (`workshop_id`) REFERENCES `workshops` (`workshop_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_workshop_id_foreign` FOREIGN KEY (`workshop_id`) REFERENCES `workshops` (`workshop_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `job_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_worker_id_foreign` FOREIGN KEY (`worker_id`) REFERENCES `workers` (`worker_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_workshop_id_foreign` FOREIGN KEY (`workshop_id`) REFERENCES `workshops` (`workshop_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `steps`
--
ALTER TABLE `steps`
  ADD CONSTRAINT `step_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `inventory` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `step_worker_id_foreign` FOREIGN KEY (`worker_id`) REFERENCES `workers` (`worker_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `steps_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`);

--
-- Constraints for table `workers`
--
ALTER TABLE `workers`
  ADD CONSTRAINT `worker_worker_id_foreign` FOREIGN KEY (`worker_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `worker_workshop_id_foreign` FOREIGN KEY (`workshop_id`) REFERENCES `workshops` (`workshop_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `workshops`
--
ALTER TABLE `workshops`
  ADD CONSTRAINT `workshops_workshop_owner_id_foreign` FOREIGN KEY (`workshop_owner_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
