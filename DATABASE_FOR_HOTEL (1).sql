-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2023 at 12:01 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

USE hotel;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerID` int(11) NOT NULL,
  `CustomerLogin` varchar(32) NOT NULL,
  `CustomerPassword` varchar(32) NOT NULL,
  `CustomerEmail` varchar(32) NOT NULL,
  `CustomerName` varchar(32) NOT NULL,
  `CustomerSurname` varchar(32) NOT NULL,
  `CustomerPhoneNum` varchar(32) NOT NULL,
  `CreditCard` varchar(32) DEFAULT NULL,
  `CreditCardExpire` varchar(8) DEFAULT NULL,
  `CreditCardSecurity` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerID`, `CustomerLogin`, `CustomerPassword`, `CustomerEmail`, `CustomerName`, `CustomerSurname`, `CustomerPhoneNum`, `CreditCard`, `CreditCardExpire`, `CreditCardSecurity`) VALUES
(1, 'customer1', 'customer1', 'customer1@example.com', 'Customer', 'One', '0899630122', '1111222233334444', '04/26', '123'),
(2, 'customer2', 'customer2', 'customer2@example.com', 'Customer', 'Two', '0899630123', '4444333322221111', '05/28', '321'),
(4, 'atxsu', '1234', 'atxsu@gmail.com', 'Anrique', 'Glogowski', '0899530899', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `booked_extras`
--

CREATE TABLE `booked_extras` (
  `ExtraID` int(20) NOT NULL,
  `ReservationID` int(11) NOT NULL,
  `ExtraPrice` double NOT NULL,
  `ExtraDescription` text NOT NULL,
  `ExtraDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booked_extras`
--

INSERT INTO `booked_extras` (`ExtraID`, `ReservationID`, `ExtraPrice`, `ExtraDescription`) VALUES
(1, 2, 10, 'extra stuff customer 1 wants'),
(2, 3, 25, 'whatever customer 2 wants');

-- --------------------------------------------------------

--
-- Table structure for table `extra_list`
--

CREATE TABLE `extra_list` (
  `ExtraName` varchar(30) NOT NULL,
  `ExtraPrice` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `extra_list`
--

INSERT INTO `extra_list` (`ExtraName`, `ExtraPrice`) VALUES
('Room Service', 15),
('Firmer Pillows', 10),
('Electric Socket Adapters', 5),
('Bottle of Champagne', 15),
('Car Rental', 20);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `ReservationID` int(11) NOT NULL,
  `RoomNUM` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `ResCheckInDate` date NOT NULL,
  `ResCheckOutDate` date NOT NULL,
  `CustomerCheckedIn` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`ReservationID`, `RoomNUM`, `CustomerID`, `ResCheckInDate`, `ResCheckOutDate`, `CustomerCheckedIn`) VALUES
(2, 1, 1, '2023-03-05', '2023-03-15', 0),
(3, 2, 2, '2023-03-06', '2023-03-16', 0);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `reviewID` int(11) NOT NULL,
  `DateAdded` datetime NOT NULL DEFAULT current_timestamp(),
  `ReviewDescription` varchar(500) NOT NULL,
  `Rating` int(11) DEFAULT 0,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `room`
--

INSERT INTO `review` (`reviewID`, `DateAdded`, `ReviewDescription`, `Rating`, `name`) VALUES
(1, '2023-04-11 15:26:17', 'Type your comment he', 0, NULL),
(2, '2023-04-11 15:26:32', 'Very Nice', 0, NULL),
(3, '2023-04-11 15:33:46', 'g', 4, NULL),
(4, '2023-04-11 15:50:37', 'very good', 2, 'oksana'),
(5, '2023-04-11 15:56:59', 'nice', 3, 'Oksana'),
(6, '2023-04-11 16:07:51', 'Horrible hotel', 5, 'Igor');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `RoomNUM` int(11) NOT NULL,
  `RoomPrice` double NOT NULL,
  `NumberOfRooms` int(11) NOT NULL,
  `RoomDescription` text NOT NULL,
  `RoomType` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`RoomNUM`, `RoomPrice`, `NumberOfRooms`, `RoomDescription`, `RoomType`) VALUES
(1, 50, 1, '1', 'Single'),
(2, 50, 1, '2', 'Single'),
(3, 60, 2, '3', 'Double'),
(4, 60, 2, '4', 'Double'),
(5, 70, 4, '5', 'Family'),
(6, 70, 4, '6', 'Family');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `StaffID` int(11) NOT NULL,
  `StaffLogin` varchar(32) NOT NULL,
  `StaffPassword` varchar(32) NOT NULL,
  `StaffEmail` varchar(32) NOT NULL,
  `StaffName` varchar(32) NOT NULL,
  `StaffSurname` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`StaffID`, `StaffLogin`, `StaffPassword`, `StaffEmail`, `StaffName`, `StaffSurname`) VALUES
(1, 'staff1', 'staff1', 'staff1@example.com', 'Staff', 'One'),
(2, 'staff2', 'staff2', 'staff2@example.com', 'Staff', 'Two');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `booked_extras`
--
ALTER TABLE `booked_extras`
  ADD PRIMARY KEY (`ExtraID`),
  ADD KEY `ExtraReservationID` (`ReservationID`);

--
-- Indexes for table `extra_list`
--
ALTER TABLE `extra_list`
  ADD PRIMARY KEY (`ExtraName`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`ReservationID`),
  ADD KEY `ReservationRoomNUM` (`RoomNUM`),
  ADD KEY `ReservationCustomerID` (`CustomerID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`ReviewID`);
  /*ADD KEY `ReviewCustomerID` (`RoomNUM`);*/

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`RoomNUM`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`StaffID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `extra`
--
ALTER TABLE `booked_extras`
  MODIFY `ExtraID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `ReservationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `StaffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Booked_extra`
--
ALTER TABLE `booked_extras`
  ADD CONSTRAINT `ExtraReservationID` FOREIGN KEY (`ReservationID`) REFERENCES `reservation` (`ReservationID`) ON DELETE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `ReservationCustomerID` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE,
  ADD CONSTRAINT `ReservationRoomNUM` FOREIGN KEY (`RoomNUM`) REFERENCES `room` (`RoomNUM`) ON DELETE CASCADE;

--
-- Constraints for table `review`
--
/*ALTER TABLE `review`
  ADD CONSTRAINT `ReviewCustomerID` FOREIGN KEY (`RoomNUM`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE;
  ADD CONSTRAINT `ReviewRoomNUM` FOREIGN KEY (`RoomNUM`) REFERENCES `room` (`RoomNUM`) ON DELETE CASCADE;*/
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
