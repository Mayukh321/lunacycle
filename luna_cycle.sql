-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2026 at 07:35 PM
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
-- Database: `luna_cycle`
--

-- --------------------------------------------------------

--
-- Table structure for table `cycle_history`
--

CREATE TABLE `cycle_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL,
  `year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cycle_history`
--

INSERT INTO `cycle_history` (`id`, `user_id`, `start_date`, `end_date`, `duration`, `month`, `year`) VALUES
(13, 9, '2026-05-01', '2026-05-06', 6, 'May', 2026),
(14, 9, '2026-04-03', '2026-04-07', 5, 'April', 2026),
(15, 9, '2026-03-04', '2026-03-11', 8, 'March', 2026),
(16, 10, '2026-05-01', '2026-05-07', 7, 'May', 2026),
(17, 10, '2026-04-03', '2026-04-10', 8, 'April', 2026),
(18, 10, '2026-03-02', '2026-03-06', 5, 'March', 2026);

-- --------------------------------------------------------

--
-- Table structure for table `diet`
--

CREATE TABLE `diet` (
  `diet_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `balanced_diet` varchar(10) DEFAULT NULL,
  `junk_food` varchar(20) DEFAULT NULL,
  `water_intake` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diet`
--

INSERT INTO `diet` (`diet_id`, `user_id`, `balanced_diet`, `junk_food`, `water_intake`) VALUES
(3, 9, 'No', 'Sometimes', 6.1),
(4, 10, 'Yes', 'Rare', 0);

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `doctor_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_details`
--

CREATE TABLE `doctor_details` (
  `detail_id` int(11) NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `license_number` varchar(100) NOT NULL,
  `specialization` varchar(50) NOT NULL,
  `experience` int(11) NOT NULL,
  `hospital` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_verification`
--

CREATE TABLE `doctor_verification` (
  `verification_id` int(11) NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `document_path` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lifestyle`
--

CREATE TABLE `lifestyle` (
  `lifestyle_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `stress_level` varchar(20) DEFAULT NULL,
  `sleep_hours` int(11) DEFAULT NULL,
  `exercise` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lifestyle`
--

INSERT INTO `lifestyle` (`lifestyle_id`, `user_id`, `stress_level`, `sleep_hours`, `exercise`) VALUES
(3, 9, 'Moderate', 6, '1-2 Days'),
(4, 10, 'Moderate', 5, 'None');

-- --------------------------------------------------------

--
-- Table structure for table `medical`
--

CREATE TABLE `medical` (
  `medical_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `condition_type` varchar(50) DEFAULT NULL,
  `medication` varchar(10) DEFAULT NULL,
  `medication_details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical`
--

INSERT INTO `medical` (`medical_id`, `user_id`, `condition_type`, `medication`, `medication_details`) VALUES
(3, 9, 'None', 'No', ''),
(4, 10, 'None', 'No', '');

-- --------------------------------------------------------

--
-- Table structure for table `predictions`
--

CREATE TABLE `predictions` (
  `prediction_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `prediction` varchar(255) DEFAULT NULL,
  `risk_level` varchar(50) DEFAULT NULL,
  `suggestion` text DEFAULT NULL,
  `risk_text` varchar(255) DEFAULT NULL,
  `analysis_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `predictions`
--

INSERT INTO `predictions` (`prediction_id`, `user_id`, `prediction`, `risk_level`, `suggestion`, `risk_text`, `analysis_notes`) VALUES
(1, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle and track cycle regularly', 'No Major Symptoms Detected', NULL),
(2, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(3, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(4, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(5, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(6, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(7, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(8, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(9, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(10, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(11, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(12, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(13, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(14, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(15, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(16, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(17, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(18, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(19, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(20, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(21, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(22, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(23, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(24, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(25, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(26, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(27, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(28, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(29, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(30, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(31, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(32, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(33, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(34, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(35, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(36, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(37, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(38, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(39, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(40, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(41, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle, drink enough water and track your cycle regularly.', 'No Major Symptoms Detected', NULL),
(42, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle and continue regular cycle tracking.', 'No major menstrual health concerns detected. Menstrual cramps detected.', NULL),
(43, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle and continue regular cycle tracking.', 'No major menstrual health concerns detected. Menstrual cramps detected.', 'Menstrual cramps detected.'),
(44, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle and continue regular cycle tracking.', 'No major menstrual health concerns detected. Menstrual cramps detected.', 'Menstrual cramps detected.'),
(45, 9, 'Normal Cycle', NULL, 'Maintain healthy lifestyle and continue regular cycle tracking.', 'No major menstrual health concerns detected. Menstrual cramps detected.', 'Menstrual cramps detected.');

-- --------------------------------------------------------

--
-- Table structure for table `reproductive_history`
--

CREATE TABLE `reproductive_history` (
  `reproductive_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `birth_control` varchar(10) DEFAULT NULL,
  `pregnancy` varchar(10) DEFAULT NULL,
  `ovulation_tracking` varchar(10) DEFAULT NULL,
  `basal_temp` float DEFAULT NULL,
  `family_history` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `symptoms`
--

CREATE TABLE `symptoms` (
  `symptom_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `cramps` tinyint(1) DEFAULT NULL,
  `irregular` tinyint(1) DEFAULT NULL,
  `missed` tinyint(1) DEFAULT NULL,
  `heavy_bleeding` tinyint(1) DEFAULT NULL,
  `acne` tinyint(1) DEFAULT NULL,
  `excess_hair` tinyint(1) DEFAULT NULL,
  `hair_loss` tinyint(1) DEFAULT NULL,
  `mood_swings` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `symptoms`
--

INSERT INTO `symptoms` (`symptom_id`, `user_id`, `cramps`, `irregular`, `missed`, `heavy_bleeding`, `acne`, `excess_hair`, `hair_loss`, `mood_swings`) VALUES
(3, 9, 1, 0, 0, 0, 0, 0, 0, 1),
(4, 10, 1, 0, 0, 0, 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `age` int(11) DEFAULT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `dob`, `age`, `phone`, `email`, `password`, `created_at`, `profile`) VALUES
(9, 'soumili Saha', '2007-12-10', 18, '9432', '', '$2y$10$dB5vscEWczmLA4mKTUCrRONrm/XUjIU1bVrU7wU7iXBFDVvHmIGfe', '2026-05-09 12:43:19', NULL),
(10, 'abcd', '2006-06-06', 19, '9432', '', '$2y$10$2j6r99.hb7eGJgpV8c1ble7CEut3k.4TiLq.6oAcEcbPiff4Pjwq.', '2026-05-09 16:52:38', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cycle_history`
--
ALTER TABLE `cycle_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `diet`
--
ALTER TABLE `diet`
  ADD PRIMARY KEY (`diet_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`doctor_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `doctor_details`
--
ALTER TABLE `doctor_details`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `doctor_verification`
--
ALTER TABLE `doctor_verification`
  ADD PRIMARY KEY (`verification_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `lifestyle`
--
ALTER TABLE `lifestyle`
  ADD PRIMARY KEY (`lifestyle_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `medical`
--
ALTER TABLE `medical`
  ADD PRIMARY KEY (`medical_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `predictions`
--
ALTER TABLE `predictions`
  ADD PRIMARY KEY (`prediction_id`);

--
-- Indexes for table `reproductive_history`
--
ALTER TABLE `reproductive_history`
  ADD PRIMARY KEY (`reproductive_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `symptoms`
--
ALTER TABLE `symptoms`
  ADD PRIMARY KEY (`symptom_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cycle_history`
--
ALTER TABLE `cycle_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `diet`
--
ALTER TABLE `diet`
  MODIFY `diet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `doctor_details`
--
ALTER TABLE `doctor_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `doctor_verification`
--
ALTER TABLE `doctor_verification`
  MODIFY `verification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lifestyle`
--
ALTER TABLE `lifestyle`
  MODIFY `lifestyle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `medical`
--
ALTER TABLE `medical`
  MODIFY `medical_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `predictions`
--
ALTER TABLE `predictions`
  MODIFY `prediction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `reproductive_history`
--
ALTER TABLE `reproductive_history`
  MODIFY `reproductive_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `symptoms`
--
ALTER TABLE `symptoms`
  MODIFY `symptom_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cycle_history`
--
ALTER TABLE `cycle_history`
  ADD CONSTRAINT `cycle_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `diet`
--
ALTER TABLE `diet`
  ADD CONSTRAINT `diet_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `doctor_details`
--
ALTER TABLE `doctor_details`
  ADD CONSTRAINT `doctor_details_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`) ON DELETE CASCADE;

--
-- Constraints for table `doctor_verification`
--
ALTER TABLE `doctor_verification`
  ADD CONSTRAINT `doctor_verification_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`) ON DELETE CASCADE;

--
-- Constraints for table `lifestyle`
--
ALTER TABLE `lifestyle`
  ADD CONSTRAINT `lifestyle_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `medical`
--
ALTER TABLE `medical`
  ADD CONSTRAINT `medical_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `reproductive_history`
--
ALTER TABLE `reproductive_history`
  ADD CONSTRAINT `reproductive_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `symptoms`
--
ALTER TABLE `symptoms`
  ADD CONSTRAINT `symptoms_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
