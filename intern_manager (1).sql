-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2020 at 08:17 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE
= "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT
= 0;
START TRANSACTION;
SET time_zone
= "+00:00";


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

CREATE TABLE `departments`
(
  `name` varchar
(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`
name`)
VALUES
  ('Chemical'),
  ('Civil'),
  ('Computer Science'),
  ('Electrical'),
  ('Electronics'),
  ('Mechanical');

-- --------------------------------------------------------

--
-- Table structure for table `prefrence_1`
--

CREATE TABLE `prefrence_1`
(
  `project_id` int
(11) NOT NULL,
  `student_id` int
(11) NOT NULL,
  `prof_id` int
(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prefrence_2`
--

CREATE TABLE `prefrence_2`
(
  `project_id` int
(11) NOT NULL,
  `student_id` int
(11) NOT NULL,
  `prof_id` int
(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prefrence_3`
--

CREATE TABLE `prefrence_3`
(
  `project_id` int
(11) NOT NULL,
  `student_id` int
(11) NOT NULL,
  `prof_id` int
(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prefrence_4`
--

CREATE TABLE `prefrence_4`
(
  `project_id` int
(11) NOT NULL,
  `student_id` int
(11) NOT NULL,
  `prof_id` int
(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `professors`
--

CREATE TABLE `professors`
(
  `id` int
(11) NOT NULL,
  `phase` int
(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `professors`
--

INSERT INTO `professors` (`
id`,
`phase
`) VALUES
(34, 1);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects`
(
  `id` int
(11) NOT NULL,
  `prof_id` int
(11) NOT NULL,
  `title` varchar
(200) NOT NULL,
  `abstract` text NOT NULL,
  `description` text NOT NULL,
  `department` varchar
(100) NOT NULL,
  `skills` varchar
(100) NOT NULL,
  `project_webpage` varchar
(100) NOT NULL,
  `faculty_webpage` varchar
(100) NOT NULL,
  `pdf_loc` varchar
(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`
id`,
`prof_id
`, `title`, `abstract`, `description`, `department`, `skills`, `project_webpage`, `faculty_webpage`, `pdf_loc`) VALUES
(46, 34, 'Ghar banana hai', 'afsdjk', 'kljfdsalkjdl', 'Civil', 'fkldasjkfl', 'flkjsdaklf', 'fjklsda', ''),
(47, 34, 'NLP project', 'fjlaksdjf', 'fjksadjl', 'Computer', 'fjlksjd', 'lkfjkla', 'kfjaklsdf', ''),
(48, 34, 'zeher banana hai', 'fklasfd', 'fasdf', 'Chemical', 'fasdf', 'fadsfa', 'fdsaf', ''),
(49, 34, 'Electric Car', 'jflkasj', 'fjlkjfkslafj', 'Electrical', 'alksjfdk', 'fjalksdf', 'faslkdfj', ''),
(50, 34, 'asdf', 'asjkdfa', 'jlkfjsdklfj', 'Electronics', 'lfkajsdkfj', 'fjaklsdjflka', 'jflkdsajf', ''),
(51, 34, 'RObot bhi bana do', 'asjfd', 'lkfjsaj', 'Mechanical', 'flaksdf', 'fjaskldf', 'fjklsda', '');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students`
(
  `id` int
(11) NOT NULL,
  `email` varchar
(100) NOT NULL,
  `first_name` varchar
(100) NOT NULL,
  `last_name` varchar
(100) NOT NULL,
  `password` varchar
(900) NOT NULL,
  `Gender` varchar
(20) NOT NULL,
  `college` varchar
(100) NOT NULL,
  `project1_id` int
(11) NOT NULL,
  `project2_id` int
(11) NOT NULL,
  `project3_id` int
(11) NOT NULL,
  `project4_id` int
(11) NOT NULL,
  `description` text NOT NULL,
  `resumeName` varchar
(200) NOT NULL,
  `imageName` varchar
(200) NOT NULL,
  `projectSelected` int
(11) NOT NULL DEFAULT 0,
  `selected` int
(11) NOT NULL,
  `prof_id` int
(11) NOT NULL,
  `proj_id` int
(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`
id`,
`email`,
`first_name`,
`last_name`,
`password`,
`Gender`,
`college`,
`project1_id`,
`project2_id`,
`project3_id
`, `project4_id`, `description`, `resumeName`, `imageName`, `projectSelected`, `selected`, `prof_id`, `proj_id`) VALUES
(31, 'ritwizsinha0@gmail.com', 'prem', 'bhawnani', '202cb962ac59075b964b07152d234b70', 'Male', '', 47, 49, 48, 50, '', 'CS-225-Ass1-2-CS39.pdf', '', 4, 1, 34, 47);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users`
(
  `id` int
(11) NOT NULL,
  `first_name` varchar
(255) NOT NULL,
  `last_name` varchar
(255) NOT NULL,
  `type` varchar
(10) NOT NULL,
  `gender` varchar
(10) NOT NULL,
  `email` varchar
(255) NOT NULL,
  `password` varchar
(900) NOT NULL,
  `validation_code` varchar
(900) NOT NULL,
  `active` varchar
(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp
()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`
id`,
`first_name
`, `last_name`, `type`, `gender`, `email`, `password`, `validation_code`, `active`, `date_created`) VALUES
(31, 'prem', 'bhawnani', '2', 'Male', 'ritwizsinha0@gmail.com', '202cb962ac59075b964b07152d234b70', 'cc2a94b2b805fe98ae481781ade3eea5', '1', '2020-03-09 15:15:23'),
(34, 'ritwiz', 'sinha', '1', 'Male', '1801cs39@iitp.ac.in', '202cb962ac59075b964b07152d234b70', '8e788e79336ad389efe270b0359621d7', '1', '2020-03-09 15:19:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
ADD PRIMARY KEY
(`name`);

--
-- Indexes for table `prefrence_1`
--
ALTER TABLE `prefrence_1`
ADD PRIMARY KEY
(`student_id`);

--
-- Indexes for table `prefrence_2`
--
ALTER TABLE `prefrence_2`
ADD PRIMARY KEY
(`student_id`);

--
-- Indexes for table `prefrence_3`
--
ALTER TABLE `prefrence_3`
ADD PRIMARY KEY
(`student_id`);

--
-- Indexes for table `prefrence_4`
--
ALTER TABLE `prefrence_4`
ADD PRIMARY KEY
(`student_id`);

--
-- Indexes for table `professors`
--
ALTER TABLE `professors`
ADD PRIMARY KEY
(`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
ADD PRIMARY KEY
(`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
ADD PRIMARY KEY
(`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
ADD PRIMARY KEY
(`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int
(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int
(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
