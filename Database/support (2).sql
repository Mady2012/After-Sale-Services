-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 08, 2025 at 12:54 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `support`
--

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `ProjectID` int(11) NOT NULL AUTO_INCREMENT,
  `RequestID` int(11) NOT NULL,
  `ProjectName` varchar(20) NOT NULL,
  `Description` text NOT NULL,
  `Status` varchar(20) NOT NULL DEFAULT 'New',
  PRIMARY KEY (`ProjectID`),
  KEY `RequestID` (`RequestID`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`ProjectID`, `RequestID`, `ProjectName`, `Description`, `Status`) VALUES
(16, 47, 'projectname', 'description', 'New');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

DROP TABLE IF EXISTS `request`;
CREATE TABLE IF NOT EXISTS `request` (
  `RequestID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `Request_Title` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Image` varchar(256) NOT NULL,
  PRIMARY KEY (`RequestID`),
  KEY `UserID` (`UserID`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`RequestID`, `UserID`, `Request_Title`, `Description`, `Image`) VALUES
(45, 10, 'Button', 'login button don\'t function', '../image/1757138231_login.jpg'),
(46, 10, 'Button', 'login button don\'t function', '../image/1757138881_login.jpg'),
(47, 10, 'Button', 'disconnect button don\'t function', '../image/1757142665_login.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `TaskID` int(6) NOT NULL AUTO_INCREMENT,
  `ProjectID` int(11) NOT NULL,
  `TaskName` varchar(30) NOT NULL,
  `TechnicianID` int(11) NOT NULL,
  `Status` varchar(30) NOT NULL,
  PRIMARY KEY (`TaskID`),
  KEY `ProjectID` (`ProjectID`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`TaskID`, `ProjectID`, `TaskName`, `TechnicianID`, `Status`) VALUES
(20, 16, 'Button', 11, 'Done'),
(19, 16, 'new task', 11, 'Done');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `PhoneNumber` int(20) NOT NULL,
  `Password` text NOT NULL,
  `Role` varchar(30) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `UserName`, `Email`, `PhoneNumber`, `Password`, `Role`) VALUES
(10, 'test', 'wendymadissone@gmail.com', 690845796, '$2y$10$W7Tyen3XZw87WeJpOa2G8eqUfcjRd61ZklJz0omZP2ptk1Y8DonDe', 'user'),
(9, 'Wendy', 'wendymadissone@gmail.com', 690845796, '$2y$10$a6WzB5gzWH3OUS2ODs1mROIDMsD3EuvM8HD.Rhd1wt8evXJgg3gz2', 'user'),
(8, 'test', 'peguy@test.cm', 678563771, '$2y$10$llc95aUVihDjnv3LPk42M.beM4L9XfIyhiy2o1/XpZjHhBeoRsHuG', 'admin'),
(11, 'test', 'wendymadissone@gmail.com', 690845796, '$2y$10$Aor/W3iHLPPNyYVG3FNvkeRxMiIYMWJzmCaxBYQMhRcDJ8foPZHIm', 'technician');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
