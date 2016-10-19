-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2016 at 12:28 AM
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
  `name` varchar(60) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `details` varchar(600) NOT NULL,
  `resource` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `start`, `end`, `details`, `resource`) VALUES
(9, ' 115K FUN RUN/WALK', '2016-10-22 08:00:00', '2016-10-22 10:30:00', 'The run will begin at 9:00 A.M. Participants must be registered by this point. We are expecting to have around 100 participants. We will have sent registration applications out prior to the event, to smaller running clubs in the area. Registration fees are $20. The fees are to help cover park permit fees, park participant fees, parking fees, and refreshments. If a participant has registered early they will have a parking pass distributed by us and the East Bay Regional Parks will be reimbursed by the end of the event.', ''),
(10, 'California Association of Running Clubs', '2016-10-18 10:00:00', '2016-10-18 16:00:00', 'The run/walk will go 2 ½ miles in one direction then turn around and take the same route back. It will begin at the Macdonald Staging area. Participants will run from there to Bort Meadow Staging area and back. We will set up two water stations on the trail. One at Bort Meadow Staging area and one halfway in between Bort Meadow Staging area and Macdonald Staging area.', ''),
(11, 'Sample Event 1', '2016-10-20 09:10:00', '2016-10-20 17:08:00', 'Thank you very much for coming to this special screening of “Run Free – The True Story of Caballo Blanco” presented by [Your Name/Organization Here]. This event truly couldn’t have happened without you!', ''),
(12, 'Event', '2016-10-22 11:30:00', '2016-10-22 12:00:00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `leaderboard`
--

CREATE TABLE `leaderboard` (
  `LB_ID` int(11) NOT NULL,
  `STATUS` tinyint(1) NOT NULL,
  `RANK` tinyint(1) NOT NULL,
  `TEAM_NAME` varchar(30) NOT NULL,
  `MONEY_RAISED` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `leaderboard`
--

INSERT INTO `leaderboard` (`LB_ID`, `STATUS`, `RANK`, `TEAM_NAME`, `MONEY_RAISED`) VALUES
(1, 1, 1, 'Angry Armadillos', '1023.45'),
(2, 1, 5, 'Crazy Cats', '2227.00'),
(3, 1, 2, 'Bashful Badgers', '45.00'),
(4, 1, 4, 'Sleepy Snakes', '12345.00'),
(5, 1, 3, 'Lazy Lizards', '3456.99');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `TID` int(11) NOT NULL,
  `STATUS` tinyint(1) NOT NULL,
  `TNAME` varchar(30) NOT NULL,
  `TCAPTAIN` varchar(30) NOT NULL,
  `TPHONE` varchar(20) NOT NULL,
  `TEMAIL` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`TID`, `STATUS`, `TNAME`, `TCAPTAIN`, `TPHONE`, `TEMAIL`) VALUES
(1, 1, 'Angry Armadillos', 'Andy Anderson', '(256) 111-1111', 'andy@example.com'),
(2, 1, 'Crazy Cats', 'Casey Clark', '(256) 333-3333', 'casey@example.com'),
(3, 1, 'Bashful Badgers', 'Betty Batson', '(256) 222-2222', 'betty@example.com'),
(4, 1, 'Lazy Lizards', 'Likeable Linard', '(256) 345-9990', 'LL@aol.com'),
(5, 1, 'Sleepy Snakes', 'Stephen Soulcatcher', '(256) 999-1111', 'SS@yahoo.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD PRIMARY KEY (`LB_ID`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`TID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `leaderboard`
--
ALTER TABLE `leaderboard`
  MODIFY `LB_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `TID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
