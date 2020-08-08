-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 08, 2020 at 03:22 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `CatID` int(11) NOT NULL AUTO_INCREMENT,
  `CatName` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `parent` int(11) NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`CatID`),
  UNIQUE KEY `Name` (`CatName`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`CatID`, `CatName`, `Description`, `parent`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(8, 'Hand Made', 'Hand Made Items', 0, 1, 1, 1, 1),
(9, 'Computers', 'Computers Item', 0, 2, 0, 0, 0),
(10, 'Cell Phones', 'Cell Phones', 0, 3, 0, 0, 0),
(11, 'Clothing', 'Clothing And Fashion', 8, 4, 0, 0, 0),
(12, 'Tools', 'Home Tools', 0, 5, 0, 0, 0),
(14, 'Blackberry', 'Blackberry Phones', 10, 2, 0, 0, 0),
(15, 'Hammers', 'Hammers Desc', 12, 1, 0, 0, 0),
(17, 'Games', 'Hand Made Games ', 12, 3, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `Comment_ID` int(11) NOT NULL AUTO_INCREMENT,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `comment_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`Comment_ID`),
  KEY `items_comment` (`item_id`),
  KEY `comment_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`Comment_ID`, `comment`, `status`, `comment_date`, `item_id`, `user_id`) VALUES
(1, 'Very Nice', 1, '2016-05-11', 15, 28),
(2, 'Nice Item Thanks so much', 1, '2016-05-11', 18, 28),
(5, 'This Is Very Good Phone', 1, '2016-06-17', 16, 24),
(7, 'Very Cool', 1, '2016-06-17', 18, 25),
(8, 'Very Nice This Is The Second Comment', 1, '2016-06-17', 18, 25),
(9, 'This Is Me Turki', 1, '2016-06-17', 18, 30),
(10, 'Cool', 1, '2016-06-17', 15, 30),
(11, 'Helllo Comment', 1, '2016-06-17', 22, 30);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `ItemID` int(11) NOT NULL AUTO_INCREMENT,
  `ItemName` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Date` date NOT NULL,
  `MadeCountry` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ItemID`),
  KEY `member_1` (`User_ID`),
  KEY `cat_1` (`Cat_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`ItemID`, `ItemName`, `Description`, `Price`, `Date`, `MadeCountry`, `Image`, `Status`, `Rating`, `approve`, `Cat_ID`, `User_ID`, `tags`) VALUES
(14, 'Speaker', 'Very Good Speaker', '$10', '2016-05-09', 'China', '', '1', 0, 1, 9, 28, ''),
(15, 'Yeti Blue Mic', 'Very Good Microphone Very Good Microphone', '$108', '2016-05-09', 'USA', '', '1', 0, 1, 9, 28, ''),
(16, 'iPhone 6s', 'Apple iPhone 6s', '$300', '2016-05-09', 'USA', '', '2', 0, 1, 10, 24, ''),
(17, 'Magic Mouse', 'Apple Magic Mouse', '$150', '2016-05-09', 'USA', '', '1', 0, 1, 9, 24, ''),
(18, 'Network Cable', 'Cat 9 Network Cable', '$100', '2016-05-09', 'USA', '', '1', 0, 1, 9, 25, ''),
(19, 'Game', 'Test Game For Item', '120', '2016-06-17', 'USA', '', '2', 0, 1, 9, 30, ''),
(20, 'iPhone 6s', 'iPhone 6s Very Cool Phone', '1500', '2016-06-17', 'USA', '', '2', 0, 1, 10, 30, ''),
(21, 'Hammer', 'A Very Good Iron Hammer', '30', '2016-06-17', 'China', '', '3', 0, 1, 12, 30, ''),
(22, 'Good Box', 'Nice Hand Made Box', '40', '2016-06-17', 'Egypt', '', '1', 0, 1, 8, 30, ''),
(23, 'Test Item', 'This Is Test Item To Test Approve Status', '100', '2016-06-17', 'Japan', '', '3', 0, 1, 8, 30, ''),
(24, 'Testing Item', 'Testing Description Testing Description', '120', '2016-06-17', 'Korea', '', '3', 0, 0, 10, 30, ''),
(25, 'Osama', 'Osama Osama Elzero Elzero', '100', '2016-06-17', 'Egypt', '', '3', 0, 1, 10, 30, ''),
(26, '12121212', '33333333333', '33333', '2016-06-17', '333333', '', '2', 0, 1, 11, 30, ''),
(27, 'My Item', 'My New Description', '12', '2016-06-17', 'Saudi Arabia', '', '1', 0, 1, 10, 30, 'Test, Discount, Elzero'),
(28, 'Wooden Game', 'A Good Wooden game', '100', '2016-07-25', 'Egypt', '', '1', 0, 1, 8, 30, 'Elzero, Hand, Discount, Gurantee'),
(29, 'Diablo III', 'Good Playstation 4 Game', '70', '2016-07-25', 'USA', '', '1', 0, 1, 17, 30, 'RPG, Online, Game'),
(30, 'Ys Oath In Felghana', 'A Good Ps Game', '100', '2016-07-25', 'Japan', '', '1', 0, 1, 17, 30, 'Online, RPG, Game');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'To Identify User',
  `UserName` varchar(255) NOT NULL COMMENT 'Username To Login',
  `Password` varchar(255) NOT NULL COMMENT 'Password To Login',
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0 COMMENT 'Identify User Group',
  `TrustStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'Seller Rank',
  `RegStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'User Approval',
  `RegesterDate` date NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `Username` (`UserName`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `UserName`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `RegesterDate`, `avatar`) VALUES
(1, 'Osama', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'o@elzero.info', 'Osama Mohamed', 1, 0, 1, '0000-00-00', ''),
(24, 'Ahmed', '601f1889667efaebb33b8c12572835da3f027f78', 'ahmed@ahmed.com', 'Ahmed Sameh', 0, 0, 1, '2016-05-06', ''),
(25, 'Gamal', '601f1889667efaebb33b8c12572835da3f027f78', 'Gamal@mmm.com', 'Gamal Ahmed', 0, 0, 1, '2016-05-06', ''),
(26, 'Sameh', '601f1889667efaebb33b8c12572835da3f027f78', 's123@s.com', 'Sameh Ahmed', 0, 0, 1, '2016-05-08', ''),
(27, 'Application', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'app@app.com', 'Application API', 0, 0, 1, '2016-05-11', ''),
(28, 'Khalid', '601f1889667efaebb33b8c12572835da3f027f78', 'kh@kh.com', 'Khalid Ahmed', 0, 0, 1, '2016-05-04', ''),
(30, 'Turki', '601f1889667efaebb33b8c12572835da3f027f78', 'Turki@turki.com', '', 0, 0, 0, '2016-06-16', ''),
(31, 'AboGamal', '00ea1da4192a2030f9ae023de3b3143ed647bbab', '123123@123123.com', 'Abo Gamal', 0, 0, 1, '2017-04-24', '568621957_wordpress-custom-user-avatar.png'),
(32, 'Yazeed', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'asysg@jff.com', 'yazeed nazal', 0, 0, 1, '2020-08-08', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_comment` FOREIGN KEY (`item_id`) REFERENCES `items` (`ItemID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`CatID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
