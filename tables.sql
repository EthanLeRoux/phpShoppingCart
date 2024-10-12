-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 12, 2024 at 05:42 PM
-- Server version: 8.0.37
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ggg`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `storeID` varchar(10) DEFAULT NULL,
  `productID` varchar(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `price` float DEFAULT NULL,
  PRIMARY KEY (`productID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`storeID`, `productID`, `name`, `description`, `price`) VALUES
('COFFEE', 'COFFEE001', 'Jamaican Blue Mountain Coffee', 'This extraordinary coffee, famous for its exquisite flavor and strong body, is grown in teh majestic Blue Mountain range in Jamaica. Weight: 1 pound.', 22.95),
('COFFEE', 'COFFEE002', 'Blue Grove Hawaiian Maui Premium Coffee', 'This delightful coffee has an aroma that is captivatingly rich and nutty with a faint hint of citrus. Weight: 1 pound.', 18.89),
('COFFEE', 'COFFEE003', 'Sumatra Supreme Coffee', 'One of the finest coffees in the world, medium roasted to accentuate its robust character. Weight: 5 pounds.', 29.95),
('COFFEE', 'COFFEE004', 'Pure Kona Coffee', 'Grown and processed using traditional Hawaiian methods, then roasted in small batches to maintain peak freshness and flavor. Weight: 10 ounces.', 21.45),
('COFFEE', 'COFFEE005', 'Guatemala Antigua Coffee', 'An outstanding coffee with a rich, spicy, and smokey flavor. Weight: 10 ounces.', 7.5),
('ANTIQUE', 'ANTIQUE001', 'Set of four Shaker ladderback chairs', 'From the early 1800\'s, this set of four matching ladderback chairs in the traditional Shaker style have been in the same family for eight generations. All four have the original rush seats (one slight', 12000),
('ANTIQUE', 'ANTIQUE002', 'Hepplewhite Secretary', 'All original glass and hardware. Made of mahogany, brass and glass. All decorative inlays and finials intact. Some minor condition issues (bumps and nicks) that add to, rather than detract from, the h', 19500),
('ANTIQUE', 'ANTIQUE003', 'Empire Sideboard', 'Mahogany primary with cypress secondaries. Three drawers above three cupboards. From an ante-bellum Louisiana estate. Excellent condition.', 3450),
('ANTIQUE', 'ANTIQUE004', 'Gothic Bookcase', 'All walnut with blocked corners and glazed sliding doors. This unit has a dentillated pediment and a molded cornice. Wonderful condition, made in New York in the early 1800\'s', 14500),
('ANTIQUE', 'ANTIQUE005', 'Federal Dining Table', 'Mahogany two-pillar dining table. Each urn form column rests on three molded sabre legs with brass paws. Two removable leaves are still in place. Excellent condition, minimal wear.', 4500),
('ELECBOUT', 'ELECBT001', '32GB High Speed microSD card', 'With enough speed for high-speed digital cameras and enough storage space for nearly 50 CDs, this card is perfect for your multimedia devices.', 123.99),
('ELECBOUT', 'ELECBT002', '3-in-1 4GB USB 2.0 Flash Drive Pen and Laser Pointer', 'Carry it all in a single device. The bottom is a ball-point pen, the top is a laser pointer, and inside is a 4GB USB flash drive.', 14.99),
('ELECBOUT', 'ELECBT003', 'Bluetooth Bracelet with OLED Display', 'Pair this bracelet to your bluetooth-enabled phone, and ringtones are a thing of the past. When a call is received, the bracelet vibrates and the incoming caller ID displays on the OLED screen.', 49),
('ELECBOUT', 'ELECBT004', 'Fitness Watch with Heart Rate Monitor', 'Not only does this device time your workout, it monitors your heart rate. Using ANT+ technology, the device can pair with your exercise equipment or an optional foot pod to track your progress. All of', 149),
('ELECBOUT', 'ELECBT005', 'Solar Charging Backpack', 'Recharge your phone, mp3 player, or handheld device while on the go with this stylish and roomy backpack. The exterior features a solar cell that charges a built-in rechargeable battery. Connectors ar', 179.95);

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

DROP TABLE IF EXISTS `orderitems`;
CREATE TABLE IF NOT EXISTS `orderitems` (
  `order_item_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `productID` varchar(10) NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`order_item_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `order_total` double NOT NULL,
  `order_date` datetime NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_info`
--

DROP TABLE IF EXISTS `store_info`;
CREATE TABLE IF NOT EXISTS `store_info` (
  `storeID` varchar(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `welcome` text,
  `css_file` varchar(250) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`storeID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_info`
--

INSERT INTO `store_info` (`storeID`, `name`, `description`, `welcome`, `css_file`, `email`) VALUES
('COFFEE', 'Gosselin\'s Gourmet Coffee', 'Specialty coffees made from the world\'s finest beans', 'Welcome to Gosselin\'s Gourmet Coffee. Here you will find many of the world\'s finest gourmet coffees. Our blends are hand-selected from the most unique and flavorful beans, each custom-roasted to enhance the distinct flavor. Whether you desire a dark, medium or light roast, you will find a special treat on our list.', 'GosselinGourmet.css', 'ggcoffee@example.com'),
('ANTIQUE', 'Old Tyme Antiques', 'Furniture from America\'s Colonial and Post-war periods', 'At Old Tyme Antiques, we search for the finest examples of Early American furniture. Our appraisers and researchers have researched each and every one of our items, and all have a certified provenance. Any restoration work has been performed by our expert restorers, and is fully documented. We are constantly searching estate sales for new items. If you have an item, we would be glad to appraise it for you, or even sell it on consignment.', 'OldTymeAntiques.css', 'antique1783@example.net'),
('ELECBOUT', 'Electronic Boutique', 'Computer accessories and peripheral devices', 'Want the coolest high-tech gadgets around? You\'ve come to the right place. We offer USB drives, media cards, and other electronic devices to enhance your digital life.', 'ElectronicsBoutique.css', 'usb4sale@example.org');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
