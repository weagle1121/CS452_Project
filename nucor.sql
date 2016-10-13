-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2016 at 03:24 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nucor`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(600) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `resource` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `start`, `end`, `resource`) VALUES
(2, 'Sample Linear Midterm', '2016-10-12 09:30:00', '2016-10-12 12:20:00', 'B'),
(3, 'Sample Event 1', '2016-10-14 10:00:00', '2016-10-14 13:00:00', ''),
(4, 'Work on database', '2016-10-09 11:00:00', '2016-10-09 19:00:00', ''),
(5, 'Sample Run: The run will begin at 9:00 A.M. Participants must be registered by this point. We are expecting to have around 100 participants. We will have sent registration applications out prior to the event, to smaller running clubs in the area. Registration fees are $20. ', '2016-10-09 08:00:00', '2016-10-09 09:30:00', ''),
(7, 'Event Lab Stuff', '2016-10-09 03:00:00', '2016-10-09 04:30:00', ''),
(8, 'Test Event', '2016-10-11 00:30:00', '2016-10-11 03:00:00', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
