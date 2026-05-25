-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2026 at 09:06 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nml_po_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` int(11) NOT NULL,
  `sn` int(11) DEFAULT NULL,
  `project_hq` varchar(255) DEFAULT NULL,
  `activity_contract` text DEFAULT NULL,
  `mode_of_tendering` varchar(50) DEFAULT NULL,
  `po_no` varchar(100) DEFAULT NULL,
  `eic_email` varchar(255) DEFAULT NULL,
  `award_value` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `contract_period_months` int(11) DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `po_extension_taken` varchar(10) DEFAULT NULL,
  `extended_end_date` date DEFAULT NULL,
  `new_pr_initiated` varchar(10) DEFAULT NULL,
  `new_pr_no` varchar(100) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `reminder_30_sent` tinyint(1) DEFAULT 0,
  `reminder_15_sent` tinyint(1) DEFAULT 0,
  `reminder_7_sent` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Active','Closed') DEFAULT 'Active',
  `eic_name` varchar(255) DEFAULT NULL,
  `eic_department` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`id`, `sn`, `project_hq`, `activity_contract`, `mode_of_tendering`, `po_no`, `eic_email`, `award_value`, `start_date`, `contract_period_months`, `end_date`, `po_extension_taken`, `extended_end_date`, `new_pr_initiated`, `new_pr_no`, `remark`, `email`, `reminder_30_sent`, `reminder_15_sent`, `reminder_7_sent`, `created_at`, `status`, `eic_name`, `eic_department`) VALUES
(3, 1, 'PBCMP', 'test', 'ST', '7894561230', 'nmlcmhqtest@nml.co.in', '1254125', '2026-04-08', 2, '2026-06-12', 'N', NULL, 'N', '', '', 'nmlcmhqtest@nml.co.in', 1, 0, 0, '2026-05-08 08:55:08', 'Active', 'rfgvd', 'dfbf'),
(4, 2, 'ABC', 'urjyrjyfjfkgj', 'LT', '4500153143', 'cmhqranchi@gmail.com', '10000', '2026-03-01', 3, '2026-06-07', 'N', NULL, 'N', '', '', 'cmhqranchi@gmail.com', 1, 0, 0, '2026-05-08 08:58:56', 'Active', NULL, NULL),
(5, 5, 'Pakri', 'test po remainder', NULL, '98754874', NULL, NULL, '2026-04-01', NULL, '2026-06-07', NULL, NULL, NULL, NULL, NULL, 'lnpradhan@ntpc.co.in', 1, 0, 0, '2026-05-08 09:36:02', 'Active', NULL, NULL),
(6, 6, 'NML HQ', 'test 2', 'LT', '8527413690', 'lnpradhan@ntpc.co.in', '852441', '2026-03-02', 4, '2026-07-01', 'N', NULL, 'N', '', 'test', 'lnpradhan@ntpc.co.in', 0, 0, 0, '2026-05-08 10:29:38', 'Active', NULL, NULL),
(7, 7, 'PBCMP', 'test', 'LT', '3698521470', 'cmhqranchi@gmail.com', '852741', '2026-01-01', 12, '2027-12-31', 'N', NULL, 'N', '', 't1', 'cmhqranchi@gmail.com', 0, 0, 0, '2026-05-08 11:12:49', 'Active', NULL, NULL),
(8, 8, 'PBCMP', '655', 'LT', '7777777777', 'dsaa@gmail.com', '777', '2026-05-01', 2, '2026-06-07', 'N', NULL, 'N', '', '', 'cmhqranchi@gmail.com', 1, 0, 0, '2026-05-08 11:23:28', 'Active', NULL, NULL),
(9, 9, 'PBCMP', 'fd', 'LT', '8527411471', 'abc@ntpc.co.in', '1234567', '2025-05-08', 12, '2026-06-07', 'N', NULL, 'N', '', '', 'nmlcmhqtest@nml.co.in', 1, 0, 0, '2026-05-08 11:29:07', 'Active', 'rfgvd', 'dfbf');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `project_code` varchar(100) DEFAULT NULL,
  `project_location` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `project_name`, `project_code`, `project_location`, `status`, `created_at`) VALUES
(1, 'PBCMP', '2040', 'Hazaribagh', 'Active', '2026-05-08 11:06:14');

-- --------------------------------------------------------

--
-- Table structure for table `reminder_logs`
--

CREATE TABLE `reminder_logs` (
  `id` int(11) NOT NULL,
  `contract_id` int(11) DEFAULT NULL,
  `po_no` varchar(100) DEFAULT NULL,
  `project_hq` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `reminder_type` varchar(50) DEFAULT NULL,
  `email_status` varchar(50) DEFAULT NULL,
  `sent_date` datetime DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reminder_logs`
--

INSERT INTO `reminder_logs` (`id`, `contract_id`, `po_no`, `project_hq`, `email`, `reminder_type`, `email_status`, `sent_date`, `created_at`) VALUES
(1, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Failed', '2026-05-08 12:36:41', '2026-05-08 09:38:06'),
(2, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Failed', '2026-05-08 12:36:47', '2026-05-08 09:38:06'),
(3, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Failed', '2026-05-08 12:42:47', '2026-05-08 09:38:06'),
(4, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Failed', '2026-05-08 12:43:57', '2026-05-08 09:38:06'),
(5, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Failed', '2026-05-08 12:47:31', '2026-05-08 09:38:06'),
(6, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Failed', '2026-05-08 12:47:33', '2026-05-08 09:38:06'),
(7, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Failed', '2026-05-08 12:50:21', '2026-05-08 09:38:06'),
(8, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Failed', '2026-05-08 12:50:22', '2026-05-08 09:38:06'),
(9, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Failed', '2026-05-08 12:50:22', '2026-05-08 09:38:06'),
(10, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Failed', '2026-05-08 12:52:44', '2026-05-08 09:38:06'),
(11, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Failed', '2026-05-08 13:01:13', '2026-05-08 09:38:06'),
(12, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Failed', '2026-05-08 13:01:32', '2026-05-08 09:38:06'),
(13, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Failed', '2026-05-08 13:24:56', '2026-05-08 09:38:06'),
(14, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Failed', '2026-05-08 13:24:58', '2026-05-08 09:38:06'),
(15, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Failed', '2026-05-08 13:27:59', '2026-05-08 09:38:06'),
(16, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Failed', '2026-05-08 13:30:38', '2026-05-08 09:38:06'),
(17, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Failed', '2026-05-08 13:32:23', '2026-05-08 09:38:06'),
(18, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Failed', '2026-05-08 13:58:58', '2026-05-08 09:38:06'),
(19, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Failed', '2026-05-08 13:59:01', '2026-05-08 09:38:06'),
(20, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Failed', '2026-05-08 14:15:00', '2026-05-08 09:38:06'),
(21, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Failed', '2026-05-08 14:15:02', '2026-05-08 09:38:06'),
(22, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Failed', '2026-05-08 14:18:51', '2026-05-08 09:38:06'),
(23, 1, '1234567890', 'NML HQ', 'nmlcmhqtest@nml.co.in', '30 Days', 'Sent', '2026-05-08 14:20:36', '2026-05-08 09:38:06'),
(24, 2, '9874569874', 'NML HQ', 'nmlcmhtest@nml.co.in', '30 Days', 'Sent', '2026-05-08 14:22:43', '2026-05-08 09:38:06'),
(25, 3, '32313354455', 'Pakri', 'nmlcmhqtest@nml.co.in', '30 Days', 'Sent', '2026-05-08 14:25:13', '2026-05-08 09:38:06'),
(26, 4, '4500153143', 'ABC', 'cmhqranchi@gmail.com', '30 Days', 'Sent', '2026-05-08 14:29:00', '2026-05-08 09:38:06'),
(27, 5, '98754874', 'Pakri', 'lnpradhan@ntpc.co.in', '30 Days', 'Sent', '2026-05-08 15:08:24', '2026-05-08 09:38:24'),
(28, 8, '7777777777', 'PBCMP', 'cmhqranchi@gmail.com', '30 Days', 'Sent', '2026-05-08 16:55:36', '2026-05-08 11:25:36'),
(29, 9, '8527411471', 'PBCMP', 'nmlcmhqtest@nml.co.in', '30 Days', 'Sent', '2026-05-08 17:11:34', '2026-05-08 11:41:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('super_admin','admin','viewer') DEFAULT 'viewer',
  `department` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `department`, `created_at`) VALUES
(1, 'Super Admin', 'admin@ntpc.co.in', '0192023a7bbd73250516f069df18b500', 'super_admin', 'ADMIN', '2026-05-08 04:54:32'),
(4, 'Mukesh Kumar', 'cmhqranchi1@gmail.com', '49f9ff3a98826af6cb10082688c8fba1', 'admin', 'IT', '2026-05-13 10:42:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `po_no` (`po_no`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reminder_logs`
--
ALTER TABLE `reminder_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reminder_logs`
--
ALTER TABLE `reminder_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
