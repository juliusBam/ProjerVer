-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2022 at 10:24 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projerVer`
--

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `logID` int(11) NOT NULL,
  `fk_userID` int(11) NOT NULL COMMENT 'key to user ID',
  `fk_logType` int(11) NOT NULL COMMENT 'key to type of log',
  `timeStamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `logTypes`
--

CREATE TABLE `logTypes` (
  `logTypeID` int(11) NOT NULL,
  `logDesc` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `logTypes`
--

INSERT INTO `logTypes` (`logTypeID`, `logDesc`) VALUES
(1, 'signUp'),
(2, 'logIn'),
(3, 'logOut');

-- --------------------------------------------------------

--
-- Table structure for table `postIt`
--

CREATE TABLE `postIt` (
  `postIt_ID` int(11) NOT NULL,
  `title` tinytext NOT NULL,
  `descr` text NOT NULL,
  `createdBy_userID` int(11) NOT NULL,
  `assignedTo_userID` int(11) NOT NULL,
  `creationTimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `fk_priorityID` int(11) NOT NULL,
  `deadline` datetime DEFAULT NULL,
  `postStatus` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0--> post is open\r\n1 --> post is done(closed)\r\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `postIt`
--

INSERT INTO `postIt` (`postIt_ID`, `title`, `descr`, `createdBy_userID`, `assignedTo_userID`, `creationTimeStamp`, `fk_priorityID`, `deadline`, `postStatus`) VALUES
(1, 'Probe fetch', 'Probe fetch', 1, 1, '2022-05-11 08:04:20', 1, '2022-05-11 10:03:29', 0),
(2, 'new Title ??', 'My cool description pipapo ????', 1, 1, '2022-05-31 10:00:15', 1, '2023-02-21 20:12:01', 0),
(3, 'Probe durch Form', 'Assigned to me', 1, 1, '2022-05-31 11:11:59', 1, '2022-06-03 15:00:00', 0),
(4, 'Assign to myself', 'Assigned to me', 1, 1, '2022-05-31 11:12:50', 1, '2022-06-03 15:00:00', 0),
(5, 'Check empty list', 'Assigned to me', 1, 1, '2022-05-31 11:16:15', 2, '2022-06-03 15:00:00', 0),
(6, 'Check empty list 2', 'Checking empty list 2', 1, 1, '2022-05-31 11:20:39', 1, '2022-06-04 12:00:00', 0),
(7, 'Check empty list 2', 'Checking empty list 2', 1, 1, '2022-05-31 11:21:45', 1, '2022-06-04 12:00:00', 0),
(8, 'Julio macht es hier', 'My cool description', 1, 1, '2022-05-31 13:41:12', 1, '2022-06-02 12:00:00', 0),
(9, 'Test beim Termin', 'djlksajdkjsad', 1, 1, '2022-06-02 08:21:17', 1, '2022-06-03 12:00:00', 0),
(10, 'Probe feedback', '                    dasdsadsads', 1, 1, '2022-06-07 20:40:52', 1, '2022-06-22 12:33:00', 0),
(11, 'Probe purge list', 'dasdsadsads', 1, 1, '2022-06-07 20:42:16', 1, '2022-06-22 12:33:00', 0),
(12, 'Probe after new db connection', 'dlkajsdlsaldjslj', 1, 1, '2022-06-08 09:39:24', 2, '2022-06-16 12:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `priorities`
--

CREATE TABLE `priorities` (
  `priorityID` int(11) NOT NULL,
  `priorityLabel` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `priorities`
--

INSERT INTO `priorities` (`priorityID`, `priorityLabel`) VALUES
(1, 'urgent'),
(2, 'normal'),
(3, 'not urgent'),
(4, 'probe Prio');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `roleID` int(11) NOT NULL,
  `roleLabel` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`roleID`, `roleLabel`) VALUES
(1, 'manager'),
(2, 'worker'),
(3, 'intern');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `userName` tinytext NOT NULL,
  `firstName` tinytext NOT NULL,
  `secondName` tinytext NOT NULL,
  `userEmail` tinytext NOT NULL,
  `gender` enum('m','f','d') NOT NULL COMMENT 'Enum m,f,d',
  `birthdate` date NOT NULL,
  `pwd` tinytext NOT NULL COMMENT 'The stored password is the hashed value of it',
  `fk_roleID` int(11) NOT NULL,
  `creationTimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Boolean to define the user status 1->active 0->inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userName`, `firstName`, `secondName`, `userEmail`, `gender`, `birthdate`, `pwd`, `fk_roleID`, `creationTimeStamp`, `status`) VALUES
(1, 'julioB', 'julio', 'Bampi', 'julioBampi@gmail.com', 'm', '1997-05-27', 'ichDu', 3, '2022-05-10 15:51:13', 1),
(2, 'julioBa', 'julio', 'bampi', 'ajulioBampi@gmail.com', 'd', '2022-05-24', '210daf36240e76dd051c6d712402756b', 1, '2022-06-08 17:07:07', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`logID`),
  ADD KEY `logs_To_users` (`fk_userID`),
  ADD KEY `logs_To_logTypes` (`fk_logType`);

--
-- Indexes for table `logTypes`
--
ALTER TABLE `logTypes`
  ADD PRIMARY KEY (`logTypeID`);

--
-- Indexes for table `postIt`
--
ALTER TABLE `postIt`
  ADD PRIMARY KEY (`postIt_ID`),
  ADD KEY `creation_To_users` (`createdBy_userID`),
  ADD KEY `assigned_To_users` (`assignedTo_userID`),
  ADD KEY `postIt_To_priorities` (`fk_priorityID`);

--
-- Indexes for table `priorities`
--
ALTER TABLE `priorities`
  ADD PRIMARY KEY (`priorityID`),
  ADD UNIQUE KEY `priorityLabel_Unique` (`priorityLabel`) USING HASH;

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`roleID`),
  ADD UNIQUE KEY `roleLabel_Unique` (`roleLabel`) USING HASH;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `uniqueEmail` (`userEmail`) USING HASH,
  ADD UNIQUE KEY `userName` (`userName`) USING HASH,
  ADD KEY `users_To_roles` (`fk_roleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `logID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logTypes`
--
ALTER TABLE `logTypes`
  MODIFY `logTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `postIt`
--
ALTER TABLE `postIt`
  MODIFY `postIt_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `priorities`
--
ALTER TABLE `priorities`
  MODIFY `priorityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `roleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_To_logTypes` FOREIGN KEY (`fk_logType`) REFERENCES `logTypes` (`logTypeID`),
  ADD CONSTRAINT `logs_To_users` FOREIGN KEY (`fk_userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `postIt`
--
ALTER TABLE `postIt`
  ADD CONSTRAINT `assigned_To_users` FOREIGN KEY (`assignedTo_userID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `creation_To_users` FOREIGN KEY (`createdBy_userID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `postIt_To_priorities` FOREIGN KEY (`fk_priorityID`) REFERENCES `priorities` (`priorityID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_To_roles` FOREIGN KEY (`fk_roleID`) REFERENCES `roles` (`roleID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
