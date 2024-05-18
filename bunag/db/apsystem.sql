-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2024 at 10:57 AM
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
-- Database: `apsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `firstname`, `lastname`, `photo`, `created_on`) VALUES
(2, 'lorence', '$2y$10$xHrUcYAEPBPQWP/ihwMgRubqzOYsjfcat9sR0AfR01WemYd/f00Uq', 'lorence', 'collado', '432264137_959997075691959_8641264299963218118_n.jpg', '2024-03-19'),
(5, 'admin', '$2y$10$lSGFGUG07br1f4KuXTM/4.zkvfU54BmkvT1QExsXEbv/cjNgbs8Na', 'Bunag-Carlos', 'Builder\'s', 'logo222.png', '2024-03-19'),
(6, 'admin', '$2y$10$mhn0kbw5FbD7O/Mml5VGyu2KpQImlYDDoPgJaxYMyL9Kh0w6tEaOC', 'Mark lorence', 'Collado', '', '2024-03-19'),
(9, 'lorence', '$2y$10$p2guAIZw4d8/kLpt51JXg.TfLuSq2g2IRHKAsVmifjMJGZTQgjpBm', 'lorence', 'collado', '', '2024-03-24'),
(10, 'admin', '$2y$10$hqfZ99Hklk1P30dcM0WEiOM3PUDSV3yX18yezYkGYLu8juJRmAi.K', 'admin', 'admin', '', '2024-03-27'),
(11, 'admin123', '$2y$10$rdFKEtY9ZaCvJIjG9Rl/0OGTJ8p6UqkGCAqsap9j81cXHZfnomeq6', 'mark lorence', 'collado', '', '2024-03-27'),
(15, 'admin', 'admin123', 'Bunag-Carlos', 'Builder\'s', '', '2024-04-04'),
(16, 'admin321', '$2y$10$HG43nHDeTJudTUBslWA/Ye2JcJpTY3SPJTzoeU98SVUgqrQKvXLL.', 'Bunag-Carlos', 'Builder\'s', '', '2024-04-04');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time_in` time NOT NULL,
  `status` int(1) NOT NULL,
  `time_out` time NOT NULL,
  `status_out` int(1) NOT NULL,
  `num_hr` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `employee_id`, `date`, `time_in`, `status`, `time_out`, `status_out`, `num_hr`) VALUES
(127, 49, '2024-04-22', '07:30:00', 1, '17:00:00', 0, 8),
(170, 50, '2024-05-10', '05:08:07', 1, '05:08:19', 0, 2.85),
(171, 50, '2024-05-11', '05:08:45', 1, '17:00:12', 0, 8),
(172, 50, '2024-05-12', '05:08:06', 1, '17:23:27', 0, 8.3833333333333),
(173, 50, '2024-05-13', '05:24:13', 1, '16:24:25', 0, 7.4),
(174, 47, '2024-05-13', '04:25:36', 1, '17:20:51', 0, 8.3333333333333),
(175, 48, '2024-05-13', '05:15:57', 1, '17:16:11', 0, 8.2666666666667);

-- --------------------------------------------------------

--
-- Table structure for table `cashadvance`
--

CREATE TABLE `cashadvance` (
  `id` int(11) NOT NULL,
  `date_advance` date NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cashadvance`
--

INSERT INTO `cashadvance` (`id`, `date_advance`, `employee_id`, `amount`) VALUES
(9, '2024-04-24', '47', 1000),
(10, '2024-05-06', '52', 100);

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `sss_contribution` decimal(10,2) NOT NULL,
  `philhealth_contribution` decimal(10,2) NOT NULL,
  `withholding_tax` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deductions`
--

INSERT INTO `deductions` (`id`, `employee_id`, `sss_contribution`, `philhealth_contribution`, `withholding_tax`) VALUES
(8, '0', 1234.00, 123.00, 123.00);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `birthdate` date NOT NULL,
  `contact_info` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `position_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `created_on` date NOT NULL,
  `qrtext` varchar(255) NOT NULL,
  `qrimage` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_id`, `firstname`, `lastname`, `address`, `birthdate`, `contact_info`, `gender`, `position_id`, `schedule_id`, `photo`, `created_on`, `qrtext`, `qrimage`, `password`) VALUES
(47, 'FYL136958402', 'Romnik', 'Paraon', 'Camp tinio, Cabanatuan City', '1990-10-22', '', 'Male', 8, 2, 'romnik.jpg', '2024-04-24', '1715247698.png', '', 'Romnikforeman'),
(48, 'SZD234615980', 'Alex', 'Ladignan', 'Bakod bayan, Cab city', '1978-12-25', '', 'Male', 7, 2, 'alex.jpg', '2024-04-24', '1714061232.png', '', 'Alexmason'),
(49, 'JMG375284901', 'Jr', 'Ortiz', 'Cabantuan City', '0000-00-00', '', 'Male', 4, 2, '', '2024-04-24', '1714003247.png', '', 'Jrlabor'),
(50, 'LJA602498713', 'Joshua', 'Paraon', 'Camp tinio, Cabanatuan City', '2003-04-14', '', 'Male', 4, 2, 'joshua.jpg', '2024-04-24', '1714184789.png', '', 'Joshualabor'),
(51, 'ITA841735069', 'Jessie ', 'Esguerra', 'Bakod bayan, Cabanatuan City', '1990-04-13', '', 'Male', 4, 2, 'jesie.jpg', '2024-04-24', '1714184792.png', '', 'Jessie laborer'),
(52, 'YVL572946018', 'Elmer', 'Batumbakal', 'Cabanatuan City', '0000-00-00', '', 'Male', 11, 2, '', '2024-04-24', '1714184797.png', '', 'Elmerdriver'),
(53, 'ULS390278456', 'Ian', 'Batumbakal', 'Cabanatuan City', '0000-00-00', '', 'Male', 5, 2, '', '2024-04-24', '1714185412.png', '', 'Ianwelder'),
(54, 'MAF036912478', 'Ian', 'Lagarta', 'Cabanatuan City', '0000-00-00', '', 'Male', 4, 2, '', '2024-04-24', '1714185415.png', '', 'Ianlaborer'),
(55, 'WEY715069234', 'Anthony ', 'Carlos', 'Cabanatuan City', '0000-00-00', '', 'Male', 9, 2, '', '2024-04-24', '1714185420.png', '', 'Anthony electrician'),
(56, 'KVL965083472', 'Michael', 'Batumbakal', 'Cabanatuan City', '0000-00-00', '', 'Male', 9, 2, '', '2024-04-24', '1714185423.png', '', 'Michaelelectrician'),
(57, 'SNI098617254', 'Harden', 'Batumbakal', 'Cabatuan City', '0000-00-00', '', 'Male', 5, 2, '', '2024-04-24', '1714185427.png', '', 'Hardenwelder'),
(58, 'IFM681274953', 'Meliton', 'Miranda', 'Cabanatuan City', '0000-00-00', '', 'Male', 7, 2, '', '2024-04-24', '1714185432.png', '', 'Melitonmason'),
(59, 'UXV479203168', 'Mark', 'Sapatero', 'Cabatuab City', '0000-00-00', '', 'Male', 7, 2, '', '2024-04-24', '1714185435.png', '', 'Markmason'),
(60, 'BYW569718320', 'Wilfred', 'Azarcon', 'Cabatuan City', '0000-00-00', '', 'Male', 7, 2, '', '2024-04-24', '1714120301.png', '', 'Wilfredmason'),
(61, 'COY342701586', 'Carding', 'Acosta', 'Cabatuan City', '0000-00-00', '', 'Male', 7, 2, '', '2024-04-24', '1714185439.png', '', 'Cardingmason'),
(62, 'IDE867251093', 'Dany', 'Acosta', 'Cabatuan City', '0000-00-00', '', 'Male', 7, 2, '', '2024-04-24', '1714185442.png', '', 'Danymason'),
(63, 'SBT751836942', 'Joey', 'Alvan', 'Cabatuan City', '0000-00-00', '', 'Male', 5, 2, '', '2024-04-24', '1714185453.png', '', 'Joeywelder'),
(64, 'HRW207489513', 'Mario', 'Yuzon', 'Cabanatuan City', '0000-00-00', '', 'Male', 7, 2, '', '2024-04-24', '1714185451.png', '', 'mariomason'),
(65, 'WVE539072816', 'Carlo', 'Laxamana', 'Cabatuab City', '0000-00-00', '', 'Male', 12, 2, '', '2024-04-24', '1714185448.png', '', 'Carlopainter'),
(66, 'DHB156784039', 'Victor', 'Azarcon', 'Cabanatuan', '0000-00-00', '', 'Male', 12, 2, '', '2024-04-24', '1714185445.png', '', 'Victorpainter');

-- --------------------------------------------------------

--
-- Table structure for table `other_earnings`
--

CREATE TABLE `other_earnings` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `bonus` decimal(10,2) DEFAULT 0.00,
  `overtime` decimal(10,2) DEFAULT 0.00,
  `transportation_allowance` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `other_earnings`
--

INSERT INTO `other_earnings` (`id`, `employee_id`, `bonus`, `overtime`, `transportation_allowance`, `created_at`, `updated_at`) VALUES
(26, 47, 1234.00, 1234.00, 1234.00, '2024-05-10 03:54:24', '2024-05-10 03:54:24'),
(27, 49, 100.00, 100.00, 100.00, '2024-05-10 08:16:58', '2024-05-10 08:16:58'),
(28, 50, 12345.00, 1234.00, 12345.00, '2024-05-10 08:17:56', '2024-05-10 08:17:56');

-- --------------------------------------------------------

--
-- Table structure for table `overtime`
--

CREATE TABLE `overtime` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `hours` double NOT NULL,
  `rate` double NOT NULL,
  `date_overtime` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `overtime`
--

INSERT INTO `overtime` (`id`, `employee_id`, `hours`, `rate`, `date_overtime`) VALUES
(5, '52', 1, 81.25, '2024-04-22');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `description` varchar(150) NOT NULL,
  `rate` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `description`, `rate`) VALUES
(4, 'Laborer', 62.5),
(5, 'Welder', 75),
(6, 'Skilled', 62.5),
(7, 'Mason', 81.25),
(8, 'Foreman', 81.25),
(9, 'Electrician', 81.25),
(10, 'Supervisor', 87.5),
(11, 'Driver', 81.25),
(12, 'Painter', 75);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `time_in`, `time_out`) VALUES
(2, '08:00:00', '17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` int(11) NOT NULL,
  `password` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashadvance`
--
ALTER TABLE `cashadvance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_earnings`
--
ALTER TABLE `other_earnings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `overtime`
--
ALTER TABLE `overtime`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `cashadvance`
--
ALTER TABLE `cashadvance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `other_earnings`
--
ALTER TABLE `other_earnings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `overtime`
--
ALTER TABLE `overtime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `other_earnings`
--
ALTER TABLE `other_earnings`
  ADD CONSTRAINT `other_earnings_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
