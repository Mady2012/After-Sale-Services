-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 19, 2025 at 02:17 PM
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
-- Table structure for table `groupe`
--

DROP TABLE IF EXISTS `groupe`;
CREATE TABLE IF NOT EXISTS `groupe` (
  `GroupID` int(11) NOT NULL AUTO_INCREMENT,
  `GroupName` varchar(30) NOT NULL,
  `Description` varchar(30) NOT NULL,
  PRIMARY KEY (`GroupID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groupe`
--

INSERT INTO `groupe` (`GroupID`, `GroupName`, `Description`) VALUES
(1, 'wendy', 'developpeur');

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
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`ProjectID`, `RequestID`, `ProjectName`, `Description`, `Status`) VALUES
(25, 56, 'projectname', 'description', 'New'),
(26, 57, 'projectname', 'description', 'New');

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
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`RequestID`, `UserID`, `Request_Title`, `Description`, `Image`) VALUES
(45, 10, 'Button', 'login button don\'t function', '../image/1757138231_login.jpg'),
(46, 10, 'Button', 'login button don\'t function', '../image/1757138881_login.jpg'),
(47, 10, 'Button', 'disconnect button don\'t function', '../image/1757142665_login.jpg'),
(57, 12, 'GlutanCorporation Sarl ', 'je veux manger beaucoup de nourriture', '../image/1758042644_Le tableau de bord des donnÃ©es commerciales fournit des analyses de business intelligence modernes _ Image Premium gÃ©nÃ©rÃ©e Ã  base dâ€™IA.jpeg'),
(56, 12, 'Disconnection button', 'When i click on the disconnection button it don\'t function', '../image/1758037441_login.jpg'),
(54, 12, 'Disconnection button', 'When i click on the disconnection button it don\'t function', '../image/1757783535_login.jpg'),
(55, 12, 'Disconnection button', 'When i click on the disconnection button it don\'t function', '../image/1757783584_login.jpg');

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
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`TaskID`, `ProjectID`, `TaskName`, `TechnicianID`, `Status`) VALUES
(21, 16, 'page de login', 12, 'Done'),
(20, 16, 'Button', 11, 'Done'),
(23, 17, 'Button', 12, 'In progress'),
(24, 16, 'Button', 12, 'In progress'),
(25, 16, 'Button', 12, 'in review');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `GroupID` int(11) NOT NULL,
  `UserName` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `PhoneNumber` int(20) NOT NULL,
  `Password` text NOT NULL,
  `Role` varchar(30) NOT NULL,
  PRIMARY KEY (`UserID`),
  KEY `GroupID` (`GroupID`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `GroupID`, `UserName`, `Email`, `PhoneNumber`, `Password`, `Role`) VALUES
(12, 1, 'test', 'wendymadissone@gmail.com', 678908765, '$2y$10$0Td3hTQwsuVD9GLXUzQxKeVGpRQORmpv0c7dEjS8sG57SitSJXDzm', 'technician');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
