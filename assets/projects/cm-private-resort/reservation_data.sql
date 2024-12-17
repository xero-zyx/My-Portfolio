-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 14, 2023 at 06:13 PM
-- Server version: 10.5.16-MariaDB
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id20751424_csm_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `reservation_data`
--

CREATE TABLE `reservation_data` (
  `id` int(100) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `middleinitial` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `mobilenumber` bigint(11) NOT NULL,
  `reservationdate` date NOT NULL,
  `note` varchar(300) NOT NULL,
  `status` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservation_data`
--

INSERT INTO `reservation_data` (`id`, `firstname`, `lastname`, `middleinitial`, `email`, `mobilenumber`, `reservationdate`, `note`, `status`) VALUES
(1, 'test', 'test', 'test', 'text@gmail.com', 9123456789, '0000-00-00', 'Test The original 1472 was a consolidation of various other human factors standards. I assume they’re from both formal research and “lessons learned” from operational experience. Human factor engineering came into its own in the military in the 1940s when the armed forces had to contend with o Test.', 0),
(40, 'test', 'test', 'test', 'test@gmail.com', 0, '2023-04-28', 'test', 1),
(41, 'test', 'test', 'test', 'test@gmail.com', 0, '2023-04-28', 'test', 2),
(42, 'test', 'test', 'test', 'test@gmail.com', 9123456789, '2023-04-29', 'test', 3),
(43, 'test', 'test', 'test', 'test@gmail.com', 9123456789, '2023-04-27', 'test', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reservation_data`
--
ALTER TABLE `reservation_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reservation_data`
--
ALTER TABLE `reservation_data`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
