-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2020 at 06:50 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `intern_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`name`) VALUES
('Chemical'),
('Civil'),
('Computer Science'),
('Electrical'),
('Electronics'),
('Mechanical');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `prof_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `abstract` text NOT NULL,
  `description` text NOT NULL,
  `department` varchar(100) NOT NULL,
  `skills` varchar(100) NOT NULL,
  `project_webpage` varchar(100) NOT NULL,
  `faculty_webpage` varchar(100) NOT NULL,
  `pdf_loc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `prof_id`, `title`, `abstract`, `description`, `department`, `skills`, `project_webpage`, `faculty_webpage`, `pdf_loc`) VALUES
(9, 7, 'asfj', 'fjkhak', 'k', 'Chemical', 'khajd', 'jkdah', 'kjasd', 'sample.pdf'),
(10, 7, 'asdfkh', 'jfasdkf', 'kjjkasdhfkj', 'Chemical', 'jfkahfj', 'asjdkfhaksj', 'fajksfh', ''),
(11, 7, 'asjdfhasjk', 'fkjhdsakjf', 'hkjhkjsahf', 'Electronics', 'jflksadjfl', 'adslkfj', 'flkdsaj', '');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `email` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `password` varchar(900) NOT NULL,
  `Gender` varchar(20) NOT NULL,
  `college` varchar(100) NOT NULL,
  `project1_id` int(11) NOT NULL,
  `project2_id` int(11) NOT NULL,
  `project3_id` int(11) NOT NULL,
  `project4_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `resumeName` varchar(200) NOT NULL,
  `imageName` varchar(200) NOT NULL,
  `projectSelected` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`email`, `first_name`, `last_name`, `password`, `Gender`, `college`, `project1_id`, `project2_id`, `project3_id`, `project4_id`, `description`, `resumeName`, `imageName`, `projectSelected`) VALUES
('kaguyasama27@gmail.com', 'Bilal', 'Khan', 'Male', '202cb962ac59075b964b', 'IIT Patna', 1, 5, 7, 0, 'Very good buy', 'sample.pdf', 'sample.png', 1),
('ritwizsinha0@gmail.com', 'ritwiz', 'sinha', 'Male', '202cb962ac59075b964b', '', 5, 7, 6, 1, '', 'sample.pdf', 'sample.png', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `type` varchar(10) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(900) NOT NULL,
  `validation_code` varchar(900) NOT NULL,
  `active` varchar(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `type`, `gender`, `email`, `password`, `validation_code`, `active`, `date_created`) VALUES
(1, 'Test', 'Yadav', '2', 'Male', 'test@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '53eb97c680f138d7de673057a73359b0', '1', '2019-09-30 17:32:37'),
(4, 'Starny', 'Chaaturvedi', '2', 'Male', 'starnyc312@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '449afc05c9dca2315a8fa53f2b7c1dce', '1', '2019-10-01 10:23:20'),
(6, 'ProfessorAsh', 'Yadav', '1', 'Male', '1801ee13@iitp.ac.in', 'e10adc3949ba59abbe56e057f20f883e', '2b181b85364902dd809409df40559f3c', '1', '2019-10-01 11:15:06'),
(7, 'ritwiz', 'sinha', '1', 'Male', '1801cs39@iitp.ac.in', '202cb962ac59075b964b07152d234b70', '2e78fad4d2fa280956e96fc134161d1d', '1', '2019-12-16 10:24:09'),
(11, 'Bilal', 'Khan', '2', 'Male', 'kaguyasama27@gmail.com', '202cb962ac59075b964b07152d234b70', 'f6c6caff9adbe5f66df9378d80175fbd', '1', '2019-12-29 16:26:02'),
(12, 'ritwiz', 'sinha', '2', 'Male', 'blankkindler@gmail.com', '202cb962ac59075b964b07152d234b70', 'a751f043b0ce4c3a0a642f08bc9e5923', '0', '2020-01-05 06:45:49'),
(13, 'ritwiz', 'sinha', '2', 'Male', 'ritwizsinha0@gmail.com', '202cb962ac59075b964b07152d234b70', '5dc6a7114fb904d67be20d2e6513851d', '1', '2020-01-05 12:45:57'),
(14, 'jkahfsdl', 'fhajkdsh', '1', 'Male', '1801cs12@iitp.ac.in', '202cb962ac59075b964b07152d234b70', '4cde23c993238f645b88c97cc1f1c102', '0', '2020-01-08 13:10:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
