-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2023 at 06:32 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rental_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking_data`
--

CREATE TABLE `booking_data` (
  `id` int(100) NOT NULL,
  `car` varchar(30) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `number` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `note` text NOT NULL,
  `status` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_data`
--

INSERT INTO `booking_data` (`id`, `car`, `firstname`, `lastname`, `number`, `start_date`, `end_date`, `note`, `status`) VALUES
(1, 'Hyundai_white', 'test', 'test', 91111111, '2023-05-19', '2023-05-26', 'testing', 0),
(2, 'Mitsubishi_Infrared', 'test2', 'test2', 92222222, '2023-05-19', '2023-05-26', 'testing', 3),
(3, 'Mitsubishi_gray', 'test3', 'test3', 91111111, '2023-05-19', '2023-05-26', 'testing', 3),
(4, 'Hyundai_white', 'test', 'test', 91111111, '2023-05-11', '2023-05-18', 'testing', 0),
(5, 'Mitsubishi_Infrared', 'test2', 'test2', 92222222, '2023-05-27', '2023-05-31', 'testing', 0),
(6, 'Mitsubishi_gray', 'test3', 'test3', 91111111, '2023-05-11', '2023-05-18', 'testing', 3),
(7, 'Mitsubishi_Infrared', 'test', 'test', 911111, '2023-05-31', '2023-06-15', 'test', 3),
(9, 'Mitsubishi_gray', 'test', 'test', 0, '2023-06-07', '2023-06-08', '', 0),
(10, 'Mitsubishi_Infrared', 'test', 'test', 0, '2023-06-26', '2023-06-27', '', 0),
(11, 'Mitsubishi_Infrared', 'test', 'test', 0, '2023-06-26', '2023-06-27', '', 0),
(12, 'Mitsubishi_Infrared', 'test', 'test', 0, '2023-05-27', '2023-05-28', '', 0),
(13, 'Mitsubishi_Infrared', 'test', 'test', 0, '2023-05-28', '2023-05-29', '', 0),
(14, 'Mitsubishi_Infrared', 'test', 'test', 0, '2023-05-27', '2023-05-28', '', 0),
(15, 'Mitsubishi_Infrared', 'test', 'test', 0, '2023-05-27', '2023-05-28', '', 0),
(16, 'Mitsubishi_Infrared', 'test', 'test', 0, '2023-05-27', '2023-05-28', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking_data`
--
ALTER TABLE `booking_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking_data`
--
ALTER TABLE `booking_data`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;