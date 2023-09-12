-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2023 at 07:50 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `university_election`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch_info`
--

CREATE TABLE `branch_info` (
  `branch_id` int(100) NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `degree_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch_info`
--

INSERT INTO `branch_info` (`branch_id`, `branch_name`, `degree_id`) VALUES
(1, 'CSE', 1),
(2, 'ISE', 1),
(3, 'Mech', 1),
(4, 'Civil', 1),
(5, 'ECE', 1),
(6, 'EEE', 1),
(7, 'Computer Networks', 2),
(9999, 'All Branches', 9999),
(10001, 'CSE', 7),
(10002, 'ECE', 7),
(10003, 'Mech', 7),
(10004, 'Power Electronics', 2);

-- --------------------------------------------------------

--
-- Table structure for table `color_info`
--

CREATE TABLE `color_info` (
  `color_id` int(11) NOT NULL,
  `color_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `color_info`
--

INSERT INTO `color_info` (`color_id`, `color_name`) VALUES
(1, 'red'),
(2, 'blue'),
(3, 'green'),
(4, 'purple'),
(5, 'black'),
(6, 'grey'),
(7, 'pink'),
(8, 'skyblue'),
(9, 'brown'),
(10, 'silver'),
(11, 'white'),
(9999, 'Volunteers\r\n'),
(10002, 'yellow');

-- --------------------------------------------------------

--
-- Table structure for table `contesten_election_info`
--

CREATE TABLE `contesten_election_info` (
  `election_id` int(100) NOT NULL,
  `contesten_reg_no` varchar(255) NOT NULL,
  `contestent_color` int(100) NOT NULL,
  `no_of_votes` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contesten_election_info`
--

INSERT INTO `contesten_election_info` (`election_id`, `contesten_reg_no`, `contestent_color`, `no_of_votes`) VALUES
(1, '21GACSD001', 1, 0),
(1, '21GACSD002', 2, 0),
(1, '21GACSD005', 4, 0),
(12, '21GACSD001', 1, 5),
(12, '21GACSD002', 3, 3),
(12, '21GACSD003', 2, 1),
(13, '21GACSD001', 8, 1),
(13, '21GACSD004', 4, 0),
(13, '21GACSD005', 9, 0),
(13, '21GACSD006', 1, 56),
(13, '21GACSD010', 5, 45),
(16, '21GACSD001', 1, 0),
(16, '21GACSD002', 1, 0),
(16, '21GACSD005', 1, 0),
(16, '21GACSD006', 1, 0),
(16, '21GACSD007', 1, 0),
(16, '21GACSD008', 1, 0),
(17, '21GACSD001', 9999, 0);

-- --------------------------------------------------------

--
-- Table structure for table `degree_info`
--

CREATE TABLE `degree_info` (
  `degree_id` int(100) NOT NULL,
  `degree_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `degree_info`
--

INSERT INTO `degree_info` (`degree_id`, `degree_name`) VALUES
(1, 'B.Tech'),
(2, 'M.Tech'),
(3, 'B.Com'),
(4, 'M.Com'),
(5, 'BA'),
(6, 'MBA'),
(7, 'Diploma'),
(9999, 'All Degrees'),
(10001, 'BSE'),
(10003, 'BCA');

-- --------------------------------------------------------

--
-- Table structure for table `election_info`
--

CREATE TABLE `election_info` (
  `election_id` int(100) NOT NULL,
  `election_name` varchar(255) NOT NULL,
  `election_roles_responsibility` varchar(255) NOT NULL,
  `all_degree` int(1) NOT NULL,
  `degree_id` int(100) NOT NULL,
  `all_branch` int(1) NOT NULL,
  `branch_id` int(100) NOT NULL,
  `eligible_year` int(100) NOT NULL,
  `start_registration_date` date DEFAULT NULL,
  `end_registration_date` date DEFAULT NULL,
  `start_registration_time` time(3) DEFAULT NULL,
  `end_registration_time` time(3) DEFAULT NULL,
  `election_date` date NOT NULL,
  `election_start_time` time(3) NOT NULL,
  `election_end_time` time(3) NOT NULL,
  `voting` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `election_info`
--

INSERT INTO `election_info` (`election_id`, `election_name`, `election_roles_responsibility`, `all_degree`, `degree_id`, `all_branch`, `branch_id`, `eligible_year`, `start_registration_date`, `end_registration_date`, `start_registration_time`, `end_registration_time`, `election_date`, `election_start_time`, `election_end_time`, `voting`) VALUES
(1, 'PRESIDENT', 'ghfghfhfg', 1, 9999, 1, 9999, 9999, '2023-06-12', '2023-06-20', '12:49:00.000', '13:49:00.000', '2023-06-15', '07:58:00.264', '20:58:00.094', 1),
(10, 'Tharun', 'gdfhgdhg', 0, 2, 0, 7, 2, '2023-06-13', '2023-06-14', '12:26:00.000', '13:26:00.000', '2023-06-16', '01:26:00.000', '14:26:00.000', 1),
(12, 'VICE-PRESIDENT', 'dfgdfgdg', 0, 1, 0, 1, 9999, '2023-06-13', '2023-06-19', '18:08:00.000', '11:20:00.938', '2023-06-20', '09:21:00.076', '20:08:00.726', 1),
(13, 'PRIME MINISTER', 'dhdfhfhf', 1, 9999, 1, 9999, 9999, '2023-06-11', '2023-06-18', '06:12:00.000', '21:12:00.187', '2023-06-19', '06:12:00.000', '21:12:00.750', 1),
(14, 'CHEIF MOINISTER', 'hdfghfghfh', 0, 2, 0, 7, 1, '2023-06-11', '2023-06-14', '06:14:00.000', '18:14:00.000', '2023-06-15', '06:14:00.000', '18:14:00.000', 1),
(16, 'HHJGHJKGG', 'sdfgsgsdfgf', 1, 9999, 1, 9999, 9999, '2023-06-14', '2023-06-15', '13:41:00.000', '14:41:00.000', '2023-06-16', '13:41:00.000', '14:41:00.000', 0),
(17, 'FGDG', 'hdhdhfdfgh', 1, 9999, 1, 9999, 9999, '2023-06-18', '2023-06-20', '07:27:00.000', '08:27:00.000', '2023-06-21', '07:27:00.000', '08:27:00.000', 0);

-- --------------------------------------------------------

--
-- Table structure for table `election_results`
--

CREATE TABLE `election_results` (
  `election_id` int(100) NOT NULL,
  `winning_reg_no` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `election_results`
--

INSERT INTO `election_results` (`election_id`, `winning_reg_no`) VALUES
(10, '21GACSD002'),
(12, '21GACSD002'),
(1, '21GACSD004'),
(13, '21GACSD006');

-- --------------------------------------------------------

--
-- Table structure for table `login_info`
--

CREATE TABLE `login_info` (
  `login_id` int(100) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_info`
--

INSERT INTO `login_info` (`login_id`, `admin_name`, `admin_email`, `admin_password`, `admin_status`) VALUES
(1, 'Mithun P', 'mithun@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_info`
--

CREATE TABLE `student_info` (
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `gender` char(1) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile_no` bigint(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `degree_id` int(100) NOT NULL,
  `branch_id` int(100) NOT NULL,
  `ieee` int(1) NOT NULL,
  `register_no` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `year` int(100) NOT NULL,
  `image` varchar(25) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_info`
--

INSERT INTO `student_info` (`fname`, `lname`, `gender`, `address`, `mobile_no`, `email`, `degree_id`, `branch_id`, `ieee`, `register_no`, `password`, `year`, `image`, `status`) VALUES
('Abhishek', 'M', 'M', 'Bangalore', 9865412037, 'abhishek@gmail.com', 1, 1, 1, '21GACSD001', '81dc9bdb52d04dc20036dbd8313ed055', 3, 'image.png', 1),
('Hemanth', 'S', 'M', 'Udupi', 9865421030, 'hemanth@gmail.com', 1, 1, 1, '21GACSD002', '81dc9bdb52d04dc20036dbd8313ed055', 3, 'Hemanth_3.png', 1),
('Amrutha', 'G', 'F', 'Mysore', 9065478213, 'amrutha@gmail.com', 1, 1, 0, '21GACSD003', '81dc9bdb52d04dc20036dbd8313ed055', 3, 'image.png', 1),
('Hemraj', 'KP', 'M', 'Hassan', 9752148063, 'kphemraj@gmail.com', 1, 1, 0, '21GACSD004', '81dc9bdb52d04dc20036dbd8313ed055', 3, 'Hemraj KP_3.png', 1),
('Mithun', 'P', 'M', 'Bangalore', 9721458630, 'mit@gmail.com', 1, 1, 1, '21GACSD005', '81dc9bdb52d04dc20036dbd8313ed055', 3, 'image.png', 1),
('Karthik', 'G', 'M', 'Hassan', 7854120369, 'karthik@gmail.com', 1, 2, 0, '21GACSD006', '81dc9bdb52d04dc20036dbd8313ed055', 3, 'Karthik_1.jpeg', 1),
('Swasthik', 'Vaidya', 'M', 'Udupi', 8971425603, 'swasthik@gmail.com', 1, 2, 1, '21GACSD007', '81dc9bdb52d04dc20036dbd8313ed055', 3, 'image.png', 1),
('Vachan', 'K', 'M', 'Tumkur', 9768541023, 'vachan@gmail.com', 1, 2, 0, '21GACSD008', '81dc9bdb52d04dc20036dbd8313ed055', 3, 'image.png', 1),
('Venu', 'Kishore', 'M', 'Hassan', 9865741023, 'venu@gmail.com', 2, 7, 1, '21GACSD009', '81dc9bdb52d04dc20036dbd8313ed055', 1, 'image.png', 1),
('Tejaswini', 'Gowda', 'F', 'Banaglore', 8752104639, 'tejaswini@gmail.com', 2, 7, 1, '21GACSD010', '81dc9bdb52d04dc20036dbd8313ed055', 1, 'image.png', 1),
('tharesh', 'm', 'm', 'hassan', 7852140369, 'tharesh@gmail.com', 1, 1, 0, '21GACSD011', '9a65669537cb93ec2e6e9b58959258d1', 3, 'image.png', 1),
('Sinchana', 'l', 'f', 'Udupi', 9862541709, 'sinchana@gmail.com', 1, 2, 0, '21GACSD012', '423ef2b19ebdbfbbfe1e025cd796e3b8', 3, 'image.png', 1),
('Harshitha', 'M', 'F', 'Bangalore', 9865320147, 'harshsitha@gmail.com', 2, 7, 0, '21gacsd013', '83f25ff9c324c6e28a27a4912f5d13e7', 1, 'image.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `voted_students_info`
--

CREATE TABLE `voted_students_info` (
  `election_id` int(100) NOT NULL,
  `student_register_no` varchar(100) NOT NULL,
  `contestent_id` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `time` time(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `voted_students_info`
--

INSERT INTO `voted_students_info` (`election_id`, `student_register_no`, `contestent_id`, `date`, `time`) VALUES
(12, '21GACSD001', '21GACSD002', '2023-06-14', '08:57:20.000'),
(12, '21GACSD002', '21GACSD002', '2023-06-14', '09:38:17.000'),
(12, '21GACSD003', '21GACSD001', '2023-06-20', '06:55:35.000'),
(12, '21GACSD004', '21GACSD003', '2023-06-20', '06:58:45.000'),
(12, '21GACSD005', '21GACSD001', '2023-06-20', '07:03:28.000'),
(13, '21GACSD001', '21GACSD006', '2023-06-17', '16:37:35.000'),
(13, '21GACSD004', '21GACSD001', '2023-06-19', '17:27:00.000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch_info`
--
ALTER TABLE `branch_info`
  ADD PRIMARY KEY (`branch_id`),
  ADD KEY `degree_id` (`degree_id`);

--
-- Indexes for table `color_info`
--
ALTER TABLE `color_info`
  ADD PRIMARY KEY (`color_id`);

--
-- Indexes for table `contesten_election_info`
--
ALTER TABLE `contesten_election_info`
  ADD PRIMARY KEY (`election_id`,`contesten_reg_no`),
  ADD KEY `contesten_reg_no` (`contesten_reg_no`),
  ADD KEY `contestent_id` (`contestent_color`);

--
-- Indexes for table `degree_info`
--
ALTER TABLE `degree_info`
  ADD PRIMARY KEY (`degree_id`);

--
-- Indexes for table `election_info`
--
ALTER TABLE `election_info`
  ADD PRIMARY KEY (`election_id`),
  ADD KEY `degree` (`degree_id`),
  ADD KEY `branch` (`branch_id`);

--
-- Indexes for table `election_results`
--
ALTER TABLE `election_results`
  ADD PRIMARY KEY (`election_id`),
  ADD KEY `winning_reg_no` (`winning_reg_no`);

--
-- Indexes for table `login_info`
--
ALTER TABLE `login_info`
  ADD PRIMARY KEY (`login_id`);

--
-- Indexes for table `student_info`
--
ALTER TABLE `student_info`
  ADD PRIMARY KEY (`register_no`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `degree_info` (`degree_id`);

--
-- Indexes for table `voted_students_info`
--
ALTER TABLE `voted_students_info`
  ADD PRIMARY KEY (`election_id`,`student_register_no`),
  ADD KEY `student_reg_no` (`student_register_no`),
  ADD KEY `student_reg` (`contestent_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branch_info`
--
ALTER TABLE `branch_info`
  MODIFY `branch_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10007;

--
-- AUTO_INCREMENT for table `color_info`
--
ALTER TABLE `color_info`
  MODIFY `color_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10004;

--
-- AUTO_INCREMENT for table `degree_info`
--
ALTER TABLE `degree_info`
  MODIFY `degree_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10004;

--
-- AUTO_INCREMENT for table `election_info`
--
ALTER TABLE `election_info`
  MODIFY `election_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `login_info`
--
ALTER TABLE `login_info`
  MODIFY `login_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branch_info`
--
ALTER TABLE `branch_info`
  ADD CONSTRAINT `degree_id` FOREIGN KEY (`degree_id`) REFERENCES `degree_info` (`degree_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contesten_election_info`
--
ALTER TABLE `contesten_election_info`
  ADD CONSTRAINT `contesten_reg_no` FOREIGN KEY (`contesten_reg_no`) REFERENCES `student_info` (`register_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contestent_id` FOREIGN KEY (`contestent_color`) REFERENCES `color_info` (`color_id`),
  ADD CONSTRAINT `election` FOREIGN KEY (`election_id`) REFERENCES `election_info` (`election_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `election_info`
--
ALTER TABLE `election_info`
  ADD CONSTRAINT `branch` FOREIGN KEY (`branch_id`) REFERENCES `branch_info` (`branch_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `degree` FOREIGN KEY (`degree_id`) REFERENCES `degree_info` (`degree_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `election_results`
--
ALTER TABLE `election_results`
  ADD CONSTRAINT `election_ref` FOREIGN KEY (`election_id`) REFERENCES `election_info` (`election_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `winning_reg_no` FOREIGN KEY (`winning_reg_no`) REFERENCES `student_info` (`register_no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_info`
--
ALTER TABLE `student_info`
  ADD CONSTRAINT `branch_id` FOREIGN KEY (`branch_id`) REFERENCES `branch_info` (`branch_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `degree_info` FOREIGN KEY (`degree_id`) REFERENCES `degree_info` (`degree_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `voted_students_info`
--
ALTER TABLE `voted_students_info`
  ADD CONSTRAINT `election_ref_id` FOREIGN KEY (`election_id`) REFERENCES `election_info` (`election_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_reg` FOREIGN KEY (`contestent_id`) REFERENCES `contesten_election_info` (`contesten_reg_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_reg_no` FOREIGN KEY (`student_register_no`) REFERENCES `student_info` (`register_no`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
