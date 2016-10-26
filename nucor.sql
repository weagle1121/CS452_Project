-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2016 at 10:59 PM
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
  `type` char(1) NOT NULL,
  `name` varchar(60) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `details` varchar(600) NOT NULL,
  `resource` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `type`, `name`, `start`, `end`, `details`, `resource`) VALUES
(9, 'E', ' 115K FUN RUN/WALK', '2016-10-24 08:00:00', '2016-10-24 15:30:00', 'The run will begin at 9:00 A.M. Participants must be registered by this point. We are expecting to have around 100 participants. We will have sent registration applications out prior to the event, to smaller running clubs in the area. Registration fees are $20. The fees are to help cover park permit fees, park participant fees, parking fees, and refreshments. If a participant has registered early they will have a parking pass distributed by us and the East Bay Regional Parks will be reimbursed by the end of the event.', ''),
(10, 'E', 'California Association of Running Clubs', '2016-10-24 10:00:00', '2016-10-24 15:00:00', 'The run/walk will go 2 ½ miles in one direction then turn around and take the same route back. It will begin at the Macdonald Staging area. Participants will run from there to Bort Meadow Staging area and back. We will set up two water stations on the trail. One at Bort Meadow Staging area and one halfway in between Bort Meadow Staging area and Macdonald Staging area.', ''),
(11, 'E', 'Sample Event 1', '2016-10-28 09:10:00', '2016-10-28 17:08:00', 'Thank you very much for coming to this special screening of “Run Free – The True Story of Caballo Blanco” presented by [Your Name/Organization Here]. This event truly couldn’t have happened without you!', ''),
(12, 'E', 'Event', '2016-10-22 11:30:00', '2016-10-22 12:00:00', '', ''),
(13, 'E', 'Nucor Presentation', '2016-10-27 18:00:00', '2016-10-27 18:40:00', 'CS 452 gives their presentation to Nucor on the progress of the website', ''),
(14, 'E', 'Sample Event 2', '2016-10-26 12:00:00', '2016-10-26 13:00:00', 'Sample text that is in the event.', ''),
(15, 'A', 'Sample Annoucement', '2016-10-24 00:00:00', '2016-10-28 00:00:00', 'An announcement letter is a type of letter used for a number of business and personal situations. In business, an announcement letter can be written for a number of purposes - key events requiring an announcement letter to staff and/or customers would be a change in management, a new policy, the launch of a new product, or financial summaries for investors. Also, personal announcement letters are common - for instance, to announce a wedding or a birth.', ''),
(16, 'A', 'Sample Announcement 2', '2016-10-25 00:00:00', '2016-10-25 00:00:00', 'Following these tips, you will have a good outline for a successful announcement letter. In order to carry your announcement to the widest possible audience, you also need to make sure your writing style, your grammar and your spelling are of a high standard. A good announcement letter will be written in a persuasive way with the target audience in mind, using a rich English vocabulary. Also, running a spell check is essential - spelling mistakes abound in written texts, yet are easily dealt with using accurate proofreading software like WhiteSmoke.\r\n', ''),
(17, 'A', 'NUCOR Website Presentaion', '2016-10-28 18:00:00', '2016-10-28 18:30:00', 'The CS 452 group gives their presentation on how the progress of the NUCOR website and what will be worked on in the future of the website up until the last presentation in December.', '');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `imageID` int(11) NOT NULL,
  `imageYEAR` int(11) NOT NULL,
  `imageALBUM` varchar(30) NOT NULL,
  `imagePATH` varchar(40) NOT NULL,
  `imageTITLE` varchar(30) NOT NULL,
  `imageCAP` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`imageID`, `imageYEAR`, `imageALBUM`, `imagePATH`, `imageTITLE`, `imageCAP`) VALUES
(1, 2016, 'SampleAlbum', '"backend/photos/s1.jpg"', 'Sample Title 1', 'sample caption'),
(2, 2016, 'SampleAlbum', '"backend/photos/s2.jpg"', 'Sample Title 2', 'sample caption 2'),
(3, 2016, 'SampleAlbum', '"backend/photos/s3.jpg" ', 'Sample Title 3', 'sample caption 3'),
(4, 2016, 'SampleAlbum', '"backend/photos/s4.jpg"', 'Sample Title 4', 'sample caption 4');

-- --------------------------------------------------------

--
-- Table structure for table `labels`
--

CREATE TABLE `labels` (
  `PAGE_ID` int(1) NOT NULL,
  `label1` varchar(25) NOT NULL,
  `label2` varchar(25) NOT NULL,
  `label3` varchar(25) NOT NULL,
  `label4` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `labels`
--

INSERT INTO `labels` (`PAGE_ID`, `label1`, `label2`, `label3`, `label4`) VALUES
(1, 'Team Name', 'Team Captain', 'Phone Number', 'Email Address'),
(2, 'Rank', 'Team Name', 'Money Raised', '');

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
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`imageID`);

--
-- Indexes for table `labels`
--
ALTER TABLE `labels`
  ADD PRIMARY KEY (`PAGE_ID`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `imageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `labels`
--
ALTER TABLE `labels`
  MODIFY `PAGE_ID` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
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
