-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2023 at 11:43 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


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
  `min_stock` int(10) UNSIGNED NOT NULL,
  `img_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `workshop_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `worker_id` bigint(20) UNSIGNED,
  `vehicle_plate` varchar(255) NOT NULL,
  `vehicle_make` varchar(255) NOT NULL,
  `descr` varchar(255) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `finish_time` timestamp NULL DEFAULT NULL,
  `comment` varchar(255),
  `service_fee` decimal(8,2),
  `total_price` decimal(8,2),
  `invoice_link` varchar(255),
  `feedback` varchar(255),
  `rating` decimal(2,1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `new_login_table`
--

CREATE TABLE `new_login_table` (
  `token_id` bigint(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
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
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `workshop_id` bigint(20) UNSIGNED NOT NULL,
  `brand` varchar(255) NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(5) NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `date_purchased` timestamp NOT NULL DEFAULT current_timestamp(),
  `supplier` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `steps`
--
CREATE TABLE `steps` (
  `step_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `descr` varchar(255) NOT NULL,
  `worker_id` bigint(20) UNSIGNED NOT NULL,
  `comment` varchar(255) NOT NULL,
  `item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) UNSIGNED DEFAULT NULL,
  `total_item_price` int(11) UNSIGNED DEFAULT NULL,
  `finish` tinyint(1) NOT NULL DEFAULT 0
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
  `company` varchar(255) DEFAULT NULL,
  `phone_no` int(11) UNSIGNED DEFAULT NULL,
  `type` enum('c','w','a','s') NOT NULL,
  `gender` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `name`, `DOB`, `company`, `phone_no`, `type`, `gender`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$TSej5hh.sbPddZ6ph3VUgey2Mg/jNUSeXxNCnyD6cld7psQ/9/sNq', 'Admin', NULL, 'SafeTruck', NULL, 's', ''),
(2, 'New User', 'hamza.ishrat@yahoo.com', '$2y$10$ooCSCBGdHaiaV8/SbPANM.cmnL/BsZVIn1lHkmHiuyxBT9wWNx3AC', NULL, NULL, NULL, NULL, 'a', ''),
(123, 'MurtadaRashid', 'murtadarashid@gmail.com', '$2y$10$TSej5hh.sbPddZ6ph3VUgey2Mg/jNUSeXxNCnyD6cld7psQ/9/sNq', 'Murtada Rashid', '2020-11-30', 'Rashid', 11, 'a', ''),
(126, 'MurtadaRashid', 'murtadarashi22d@gmail.com', '$2y$10$TSej5hh.sbPddZ6ph3VUgey2Mg/jNUSeXxNCnyD6cld7psQ/9/sNq', 'Murtada Rashid', '2022-11-29', 'biubub', 11, 'a', ''),
(128, 'dfghjk', '102764926@students.swinburne.edu.my', '$2y$10$TSej5hh.sbPddZ6ph3VUgey2Mg/jNUSeXxNCnyD6cld7psQ/9/sNq', 'Murtada Rashid', '2022-11-30', 'fbebfiw', 11, 'a', ''),
(129, 'New User', 'abc@abc.com', '$2y$10$TSej5hh.sbPddZ6ph3VUgey2Mg/jNUSeXxNCnyD6cld7psQ/9/sNq', NULL, NULL, NULL, NULL, 'c', ''),
(130, 'abcd', 'abcd@abcd.com', '$2y$10$TSej5hh.sbPddZ6ph3VUgey2Mg/jNUSeXxNCnyD6cld7psQ/9/sNq', 'Abc', '2021-10-29', 'abc', 11, 'a', ''),
(131, 'murtadha_rashid ', '123@123.com', '$2y$10$TSej5hh.sbPddZ6ph3VUgey2Mg/jNUSeXxNCnyD6cld7psQ/9/sNq', 'Murtada Rashid', '2023-10-30', 'feuifbeiu', 11, 'a', ''),
(132, 'Mohammed', 'mo@gmail.com', '$2y$10$TSej5hh.sbPddZ6ph3VUgey2Mg/jNUSeXxNCnyD6cld7psQ/9/sNq', 'Mohammed', '2021-09-28', 'Mohammed', 11, 'a', ''),
(133, 'Ali', 'ali@a.com', '$2y$10$TSej5hh.sbPddZ6ph3VUgey2Mg/jNUSeXxNCnyD6cld7psQ/9/sNq', 'ALI', '2019-11-30', 'alicon', 11, 'a', 'Female'),
(134, 'ff', 'ff@mfmm.com', '$2y$10$ndrXrSR8OfpK1/EOxfqn6umopXiasTng1lqpuHDzifeSjHRQrRNk2', 'ff', '2010-06-16', 'ff', 11, 'a', 'Male'),
(138, 'test', 'zit40812@omeie.com', '$2y$10$gVkW.IYsY/vnpQc9EB4h4eXY3ZcsVW6pcNXn66mvjD.ZJ.DX580qG', 'dddd', '2023-06-01', 'test', 11, 'a', 'Male'),
(139, 'root', 'gvu84482@nezid.com', '$2y$10$F8ahH.IE.O71OdElaPGsVOVzsYtRRixnkEHpyMPeqwCQSmmXL/APS', 'dddd', '2023-05-20', 'www', 11, 'a', 'Male'),
(141, 'root', 'qum82774@nezid.com', '$2y$10$hQuSkAOXT8.ttKryo7OlF.2VbKWzWJYae63bZqb.9ctkbsDqg8B9i', 'sss', '2023-05-10', 'asa111', 11, 'a', 'Male'),
(142, 'JohnDoe', 'nzq54066@zslsz.com', '$2y$10$Aajnb.CuF2THAlrqC51NsOdK2ZSMnyv6Wi49XXBUVe73egXk/M18G', 'John', '2023-04-06', 'a company', 11, 'a', 'Male'),
(143, 'New User', 'uyc85098@zslsz.com', '$2y$10$oz3Ln/BI4qlTzc8XFV/kQOTn/cuxAfUbtL9w1b0KkmoUpxF1voUEG', NULL, NULL, NULL, NULL, 'c', ''),
(149, 'test_worker', 'test_worker@gmail.com', '$2y$10$TSej5hh.sbPddZ6ph3VUgey2Mg/jNUSeXxNCnyD6cld7psQ/9/sNq', 'test_worker', NULL, 'company', NULL, 'w', 'm'),
(150, 'test_worker2', 'test_worker2@gmail.com', '$2y$10$TSej5hh.sbPddZ6ph3VUgey2Mg/jNUSeXxNCnyD6cld7psQ/9/sNq', 'test_worker', NULL, 'company', NULL, 'w', 'm'),
(151, 'ttt', 'tttt@gmail.com', '$2y$10$TSej5hh.sbPddZ6ph3VUgey2Mg/jNUSeXxNCnyD6cld7psQ/9/sNq', 'ttt', NULL, 'dasdas', NULL, 's', 'm'),
(152, 'test_worker3', 'test_worker3@gmail.com', '$2y$10$TSej5hh.sbPddZ6ph3VUgey2Mg/jNUSeXxNCnyD6cld7psQ/9/sNq', 'test_worker', NULL, 'company', NULL, 'w', 'm'),
(153, 'test', 'test_worker56@gmail.com', '$2y$10$TSej5hh.sbPddZ6ph3VUgey2Mg/jNUSeXxNCnyD6cld7psQ/9/sNq', 'test', NULL, 'company', NULL, 'w', ''),
(154, 'admin', 'wdwd@gmaiol.com', '$2y$10$a3CuYLAUhWQFjetrkmxzAeWtQd45d8I/.O3wPBKI9tmDA2wBZeJFW', 'Murtada', '4234-03-11', 'asawww', 11, 'a', 'Male');

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
  `phone_no` varchar(14) NOT NULL,
  `workshop_lng` decimal(9,6) NOT NULL,
  `workshop_ltd` decimal(8,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `workshops`
--

INSERT INTO `workshops` (`workshop_id`, `workshop_owner_id`, `name`, `location`, `opening_hours`, `specialisations`, `phone_no`, `workshop_lng`, `workshop_ltd`) VALUES
(2, 130, 'name', 'there', '9:00 am to 9:01am', 'cars', '22292', 0.000000, 0.000000),
(3, 2, 'Alexandria ', 'Alexandria Lawmuston', '9:00 to 11:pm ', 'Tyres ', '110110111', 0.440000, 0.450000),
(6, 128, 'ggreg', 'iuguig', 'dededed', 'dwdw', '11', 0.040000, 0.043000),
(7, 134, 'ggreg', 'efuiwfw', 'dededed', 'wewe', '11', 0.040000, 0.043000),
(9, 132, 'Mohammed11', 'Yemen Tanzania', 'dededed', 'ALL IN ONE ', '11', 0.040000, 0.043000),
(30, 142, 'dd', '1.5382337115198432, 110.3137185559898', '02:47 PM to 02:48 PM', 'delete', '011-2202-2938', 110.313719, 1.538234);

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
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `workshop_id` (`workshop_id`),
  ADD KEY `item_id` (`item_id`);

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
  MODIFY `token_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  MODIFY `token_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `purchase_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `steps`
--
ALTER TABLE `steps`
  MODIFY `step_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `workers`
--
ALTER TABLE `workers`
  MODIFY `worker_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `workshops`
--
ALTER TABLE `workshops`
  MODIFY `workshop_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
-- Constraints for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD CONSTRAINT `purchase_details_ibfk_1` FOREIGN KEY (`workshop_id`) REFERENCES `workshops` (`workshop_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_details_ibfk_3` FOREIGN KEY (`item_id`) REFERENCES `inventory` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `steps`
--
ALTER TABLE `steps`
  ADD CONSTRAINT `step_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `inventory` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `step_worker_id_foreign` FOREIGN KEY (`worker_id`) REFERENCES `workers` (`worker_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `step_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`) ON DELETE CASCADE ON UPDATE CASCADE,

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
