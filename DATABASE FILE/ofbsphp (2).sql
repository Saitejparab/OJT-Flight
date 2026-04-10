-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2026 at 09:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ofbsphp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_uname` varchar(20) NOT NULL,
  `admin_email` varchar(50) NOT NULL,
  `admin_pwd` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_uname`, `admin_email`, `admin_pwd`) VALUES
(1, 'admin', 'admin@mail.com', '$2y$10$KRXGkY.dxYjD8FLZclW/Tu04wl76lD7IA4Z3nAsxtpdZxHNbYo4ZW');

-- --------------------------------------------------------

--
-- Table structure for table `airline`
--

CREATE TABLE `airline` (
  `airline_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `seats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `airline`
--

INSERT INTO `airline` (`airline_id`, `name`, `seats`) VALUES
(1, 'IndiGo', 180),
(2, 'Air India', 150),
(3, 'SpiceJet', 180),
(4, 'Vistara', 160);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city`) VALUES
('Goa (GOI)'),
('Mumbai (BOM)'),
('Pune (PNQ)'),
('Bangalore (BLR)'),
('Delhi (DEL)');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feed_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `q1` varchar(250) NOT NULL,
  `q2` varchar(20) NOT NULL,
  `q3` varchar(250) NOT NULL,
  `rate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `flight_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `arrivale` datetime NOT NULL,
  `departure` datetime NOT NULL,
  `Destination` varchar(20) NOT NULL,
  `source` varchar(20) NOT NULL,
  `airline` varchar(20) NOT NULL,
  `Seats` varchar(110) NOT NULL,
  `duration` varchar(20) NOT NULL,
  `Price` int(11) NOT NULL,
  `status` varchar(6) DEFAULT NULL,
  `issue` varchar(50) DEFAULT NULL,
  `last_seat` varchar(5) DEFAULT '',
  `bus_seats` int(11) DEFAULT 20,
  `last_bus_seat` varchar(5) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`flight_id`, `admin_id`, `arrivale`, `departure`, `Destination`, `source`, `airline`, `Seats`, `duration`, `Price`, `status`, `issue`, `last_seat`, `bus_seats`, `last_bus_seat`) VALUES
(24, 1, '2026-03-25 10:35:00', '2026-03-25 09:05:00', 'Mumbai (BOM)', 'Goa (GOI)', 'IndiGo', '179', '90', 4500, 'issue', 'solved', '21A', 3, '17B'),
(25, 1, '2026-03-25 13:20:00', '2026-03-25 12:20:00', 'Pune (PNQ)', 'Goa (GOI)', 'Air India', '150', '60', 3500, 'dep', 'solved', '', 20, ''),
(26, 1, '2026-03-25 21:00:00', '2026-03-25 19:30:00', 'Bangalore (BLR)', 'Goa (GOI)', 'Vistara', '160', '90', 4100, 'Depart', '', '', 20, ''),
(27, 1, '2026-03-27 18:13:00', '2026-03-27 16:12:00', 'Delhi', 'Goa (GOI)', 'IndiGo', '180', '2 Hr', 7999, '', '', '', 20, ''),
(28, 1, '2026-03-24 17:56:00', '2026-03-24 16:47:00', 'Bangalore', 'Goa (GOI)', 'IndiGo', '180', '1Hr', 3500, '', 'solved', '', 20, ''),
(35, 1, '2026-03-27 10:30:00', '2026-03-27 09:00:00', 'Mumbai (BOM)', 'Goa (GOI)', 'IndiGo', '', '', 4500, NULL, NULL, '', 20, ''),
(36, 1, '2026-03-27 19:30:00', '2026-03-27 18:00:00', 'Goa', 'Mumbai', 'IndiGo', '', '', 4200, NULL, NULL, '', 20, ''),
(37, 1, '2026-03-28 11:30:00', '2026-03-28 10:00:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '', '', 5500, NULL, NULL, '', 20, ''),
(38, 1, '2026-03-28 21:30:00', '2026-03-28 20:00:00', 'Goa', 'Mumbai', 'Air India', '', '', 5200, NULL, NULL, '', 20, ''),
(39, 1, '2026-03-29 10:15:00', '2026-03-29 08:45:00', 'Mumbai (BOM)', 'Goa (GOI)', 'SpiceJet', '', '', 3800, NULL, NULL, '', 20, ''),
(40, 1, '2026-03-29 22:30:00', '2026-03-29 21:00:00', 'Goa', 'Mumbai', 'SpiceJet', '', '', 4000, NULL, NULL, '', 20, ''),
(41, 1, '2026-03-26 10:30:00', '2026-03-26 08:00:00', 'Mumbai (BOM)', 'Goa (GOI)', 'IndiGo', '', '', 2500, NULL, NULL, '', 20, ''),
(42, 1, '2026-03-27 11:35:00', '2026-03-27 09:05:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'Air India', '', '', 2515, NULL, NULL, '', 20, ''),
(43, 1, '2026-03-28 12:40:00', '2026-03-28 10:10:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '', '', 2530, NULL, NULL, '', 20, ''),
(44, 1, '2026-03-29 13:45:00', '2026-03-29 11:15:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'Vistara', '', '', 2545, NULL, NULL, '', 20, ''),
(45, 1, '2026-03-26 14:50:00', '2026-03-26 12:20:00', 'Goa (GOI)', 'Pune (PNQ)', 'Vistara', '', '', 2560, NULL, NULL, '', 20, ''),
(46, 1, '2026-03-27 15:55:00', '2026-03-27 13:25:00', 'Mumbai (BOM)', 'Goa (GOI)', 'IndiGo', '', '', 2575, NULL, NULL, '', 20, ''),
(47, 1, '2026-03-28 17:00:00', '2026-03-28 14:30:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'IndiGo', '', '', 2590, NULL, NULL, '', 20, ''),
(48, 1, '2026-03-29 18:05:00', '2026-03-29 15:35:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'Air India', '', '', 2605, NULL, NULL, '', 20, ''),
(49, 1, '2026-03-26 19:10:00', '2026-03-26 16:40:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'SpiceJet', '', '', 2620, NULL, NULL, '', 20, ''),
(50, 1, '2026-03-27 20:15:00', '2026-03-27 17:45:00', 'Goa (GOI)', 'Pune (PNQ)', 'Vistara', '', '', 2635, NULL, NULL, '', 20, ''),
(51, 1, '2026-03-28 21:20:00', '2026-03-28 18:50:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Vistara', '', '', 2650, NULL, NULL, '', 20, ''),
(52, 1, '2026-03-29 22:25:00', '2026-03-29 19:55:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'IndiGo', '', '', 2665, NULL, NULL, '', 20, ''),
(53, 1, '2026-03-26 23:30:00', '2026-03-26 21:00:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'IndiGo', '', '', 2680, NULL, NULL, '', 20, ''),
(54, 1, '2026-03-28 00:35:00', '2026-03-27 22:05:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'Air India', '', '', 2695, NULL, NULL, '', 20, ''),
(55, 1, '2026-03-28 11:40:00', '2026-03-28 09:10:00', 'Goa (GOI)', 'Pune (PNQ)', 'SpiceJet', '', '', 2710, NULL, NULL, '', 20, ''),
(56, 1, '2026-03-29 12:45:00', '2026-03-29 10:15:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Vistara', '', '', 2725, NULL, NULL, '', 20, ''),
(57, 1, '2026-03-26 13:50:00', '2026-03-26 11:20:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'Vistara', '', '', 2740, NULL, NULL, '', 20, ''),
(58, 1, '2026-03-27 14:55:00', '2026-03-27 12:25:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'IndiGo', '', '', 2755, NULL, NULL, '', 20, ''),
(59, 1, '2026-03-28 16:00:00', '2026-03-28 13:30:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'IndiGo', '', '', 2770, NULL, NULL, '', 20, ''),
(60, 1, '2026-03-29 17:05:00', '2026-03-29 14:35:00', 'Goa (GOI)', 'Pune (PNQ)', 'Air India', '', '', 2785, NULL, NULL, '', 20, ''),
(61, 1, '2026-03-26 18:10:00', '2026-03-26 15:40:00', 'Mumbai (BOM)', 'Goa (GOI)', 'SpiceJet', '', '', 2800, NULL, NULL, '', 20, ''),
(62, 1, '2026-03-27 19:15:00', '2026-03-27 16:45:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'Vistara', '', '', 2815, NULL, NULL, '', 20, ''),
(63, 1, '2026-03-28 20:20:00', '2026-03-28 17:50:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'Vistara', '', '', 2830, NULL, NULL, '', 20, ''),
(64, 1, '2026-03-29 21:25:00', '2026-03-29 18:55:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'IndiGo', '', '', 2845, NULL, NULL, '', 20, ''),
(65, 1, '2026-03-26 22:30:00', '2026-03-26 20:00:00', 'Goa (GOI)', 'Pune (PNQ)', 'IndiGo', '', '', 2860, NULL, NULL, '', 20, ''),
(66, 1, '2026-03-27 23:35:00', '2026-03-27 21:05:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '-1', '', 2875, NULL, NULL, '21A', 20, ''),
(67, 1, '2026-03-29 00:40:00', '2026-03-28 22:10:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'SpiceJet', '', '', 2890, NULL, NULL, '', 20, ''),
(68, 1, '2026-03-30 01:45:00', '2026-03-29 23:15:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'Vistara', '', '', 2905, NULL, NULL, '', 20, ''),
(69, 1, '2026-03-26 12:50:00', '2026-03-26 10:20:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'Vistara', '', '', 2920, NULL, NULL, '', 20, ''),
(70, 1, '2026-03-27 13:55:00', '2026-03-27 11:25:00', 'Goa (GOI)', 'Pune (PNQ)', 'IndiGo', '', '', 2935, NULL, NULL, '', 20, ''),
(71, 1, '2026-03-28 15:00:00', '2026-03-28 12:30:00', 'Mumbai (BOM)', 'Goa (GOI)', 'IndiGo', '', '', 2950, NULL, NULL, '', 20, ''),
(72, 1, '2026-03-29 16:05:00', '2026-03-29 13:35:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'Air India', '', '', 2965, NULL, NULL, '', 20, ''),
(73, 1, '2026-03-26 17:10:00', '2026-03-26 14:40:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '', '', 2980, NULL, NULL, '', 20, ''),
(74, 1, '2026-03-27 18:15:00', '2026-03-27 15:45:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'Vistara', '', '', 2995, NULL, NULL, '', 20, ''),
(75, 1, '2026-03-28 19:20:00', '2026-03-28 16:50:00', 'Goa (GOI)', 'Pune (PNQ)', 'Vistara', '', '', 3010, NULL, NULL, '', 20, ''),
(76, 1, '2026-03-29 20:25:00', '2026-03-29 17:55:00', 'Mumbai (BOM)', 'Goa (GOI)', 'IndiGo', '', '', 3025, NULL, NULL, '', 20, ''),
(77, 1, '2026-03-26 21:30:00', '2026-03-26 19:00:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'IndiGo', '', '', 3040, NULL, NULL, '', 20, ''),
(78, 1, '2026-03-27 22:35:00', '2026-03-27 20:05:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'Air India', '', '', 3055, NULL, NULL, '', 20, ''),
(79, 1, '2026-03-28 23:40:00', '2026-03-28 21:10:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'SpiceJet', '', '', 3070, NULL, NULL, '', 20, ''),
(80, 1, '2026-03-30 00:45:00', '2026-03-29 22:15:00', 'Goa (GOI)', 'Pune (PNQ)', 'Vistara', '', '', 3085, NULL, NULL, '', 20, ''),
(81, 1, '2026-03-27 01:50:00', '2026-03-26 23:20:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Vistara', '', '', 3100, NULL, NULL, '', 20, ''),
(82, 1, '2026-03-28 02:55:00', '2026-03-28 00:25:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'IndiGo', '', '', 3115, NULL, NULL, '', 20, ''),
(83, 1, '2026-03-28 14:00:00', '2026-03-28 11:30:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'IndiGo', '', '', 3130, NULL, NULL, '', 20, ''),
(84, 1, '2026-03-29 15:05:00', '2026-03-29 12:35:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'Air India', '', '', 3145, NULL, NULL, '', 20, ''),
(85, 1, '2026-03-26 16:10:00', '2026-03-26 13:40:00', 'Goa (GOI)', 'Pune (PNQ)', 'SpiceJet', '', '', 3160, NULL, NULL, '', 20, ''),
(86, 1, '2026-03-27 17:15:00', '2026-03-27 14:45:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Vistara', '', '', 3175, NULL, NULL, '', 20, ''),
(87, 1, '2026-03-28 18:20:00', '2026-03-28 15:50:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'Vistara', '', '', 3190, NULL, NULL, '', 20, ''),
(88, 1, '2026-03-29 19:25:00', '2026-03-29 16:55:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'IndiGo', '', '', 3205, NULL, NULL, '', 20, ''),
(89, 1, '2026-03-26 20:30:00', '2026-03-26 18:00:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'IndiGo', '', '', 3220, NULL, NULL, '', 20, ''),
(90, 1, '2026-03-27 21:35:00', '2026-03-27 19:05:00', 'Goa (GOI)', 'Pune (PNQ)', 'Air India', '', '', 3235, NULL, NULL, '', 20, ''),
(91, 1, '2026-03-28 22:40:00', '2026-03-28 20:10:00', 'Mumbai (BOM)', 'Goa (GOI)', 'SpiceJet', '', '', 3250, NULL, NULL, '', 20, ''),
(92, 1, '2026-03-29 23:45:00', '2026-03-29 21:15:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'Vistara', '', '', 3265, NULL, NULL, '', 20, ''),
(93, 1, '2026-03-27 00:50:00', '2026-03-26 22:20:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'Vistara', '', '', 3280, NULL, NULL, '', 20, ''),
(94, 1, '2026-03-28 01:55:00', '2026-03-27 23:25:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'IndiGo', '', '', 3295, NULL, NULL, '', 20, ''),
(95, 1, '2026-03-29 03:00:00', '2026-03-29 00:30:00', 'Goa (GOI)', 'Pune (PNQ)', 'IndiGo', '', '', 3310, NULL, NULL, '', 20, ''),
(96, 1, '2026-03-30 04:05:00', '2026-03-30 01:35:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '', '', 3325, NULL, NULL, '', 20, ''),
(97, 1, '2026-03-26 15:10:00', '2026-03-26 12:40:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'SpiceJet', '', '', 3340, NULL, NULL, '', 20, ''),
(98, 1, '2026-03-27 16:15:00', '2026-03-27 13:45:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'Vistara', '', '', 3355, NULL, NULL, '', 20, ''),
(99, 1, '2026-03-28 17:20:00', '2026-03-28 14:50:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'Vistara', '', '', 3370, NULL, NULL, '', 20, ''),
(100, 1, '2026-03-29 18:25:00', '2026-03-29 15:55:00', 'Goa (GOI)', 'Pune (PNQ)', 'IndiGo', '', '', 3385, NULL, NULL, '', 20, ''),
(101, 1, '2026-03-26 19:30:00', '2026-03-26 17:00:00', 'Mumbai (BOM)', 'Goa (GOI)', 'IndiGo', '', '', 3400, NULL, NULL, '', 20, ''),
(102, 1, '2026-03-27 20:35:00', '2026-03-27 18:05:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'Air India', '', '', 3415, NULL, NULL, '', 20, ''),
(103, 1, '2026-03-28 21:40:00', '2026-03-28 19:10:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '', '', 3430, NULL, NULL, '', 20, ''),
(104, 1, '2026-03-29 22:45:00', '2026-03-29 20:15:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'Vistara', '', '', 3445, NULL, NULL, '', 20, ''),
(105, 1, '2026-03-26 23:50:00', '2026-03-26 21:20:00', 'Goa (GOI)', 'Pune (PNQ)', 'Vistara', '', '', 3460, NULL, NULL, '', 20, ''),
(106, 1, '2026-03-28 00:55:00', '2026-03-27 22:25:00', 'Mumbai (BOM)', 'Goa (GOI)', 'IndiGo', '', '', 3475, NULL, NULL, '', 20, ''),
(107, 1, '2026-03-29 02:00:00', '2026-03-28 23:30:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'IndiGo', '', '', 3490, NULL, NULL, '', 20, ''),
(108, 1, '2026-03-30 03:05:00', '2026-03-30 00:35:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'Air India', '', '', 3505, NULL, NULL, '', 20, ''),
(109, 1, '2026-03-27 04:10:00', '2026-03-27 01:40:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'SpiceJet', '', '', 3520, NULL, NULL, '', 20, ''),
(110, 1, '2026-03-28 05:15:00', '2026-03-28 02:45:00', 'Goa (GOI)', 'Pune (PNQ)', 'Vistara', '', '', 3535, NULL, NULL, '', 20, ''),
(111, 1, '2026-03-28 16:20:00', '2026-03-28 13:50:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Vistara', '', '', 3550, NULL, NULL, '', 20, ''),
(112, 1, '2026-03-29 17:25:00', '2026-03-29 14:55:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'IndiGo', '', '', 3565, NULL, NULL, '', 20, ''),
(113, 1, '2026-03-26 18:30:00', '2026-03-26 16:00:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'IndiGo', '', '', 3580, NULL, NULL, '', 20, ''),
(114, 1, '2026-03-27 19:35:00', '2026-03-27 17:05:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'Air India', '', '', 3595, NULL, NULL, '', 20, ''),
(115, 1, '2026-03-28 20:40:00', '2026-03-28 18:10:00', 'Goa (GOI)', 'Pune (PNQ)', 'SpiceJet', '', '', 3610, NULL, NULL, '', 20, ''),
(116, 1, '2026-03-29 21:45:00', '2026-03-29 19:15:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Vistara', '', '', 3625, NULL, NULL, '', 20, ''),
(117, 1, '2026-03-26 22:50:00', '2026-03-26 20:20:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'Vistara', '', '', 3640, NULL, NULL, '', 20, ''),
(118, 1, '2026-03-27 23:55:00', '2026-03-27 21:25:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'IndiGo', '', '', 3655, NULL, NULL, '', 20, ''),
(119, 1, '2026-03-29 01:00:00', '2026-03-28 22:30:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'IndiGo', '', '', 3670, NULL, NULL, '', 20, ''),
(120, 1, '2026-03-30 02:05:00', '2026-03-29 23:35:00', 'Goa (GOI)', 'Pune (PNQ)', 'Air India', '', '', 3685, NULL, NULL, '', 20, ''),
(121, 1, '2026-03-27 03:10:00', '2026-03-27 00:40:00', 'Mumbai (BOM)', 'Goa (GOI)', 'SpiceJet', '', '', 3700, NULL, NULL, '', 20, ''),
(122, 1, '2026-03-28 04:15:00', '2026-03-28 01:45:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'Vistara', '', '', 3715, NULL, NULL, '', 20, ''),
(123, 1, '2026-03-29 05:20:00', '2026-03-29 02:50:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'Vistara', '', '', 3730, NULL, NULL, '', 20, ''),
(124, 1, '2026-03-30 06:25:00', '2026-03-30 03:55:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'IndiGo', '', '', 3745, NULL, NULL, '', 20, ''),
(125, 1, '2026-03-26 17:30:00', '2026-03-26 15:00:00', 'Goa (GOI)', 'Pune (PNQ)', 'IndiGo', '', '', 3760, NULL, NULL, '', 20, ''),
(126, 1, '2026-03-27 18:35:00', '2026-03-27 16:05:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '', '', 3775, NULL, NULL, '', 20, ''),
(127, 1, '2026-03-28 19:40:00', '2026-03-28 17:10:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'SpiceJet', '', '', 3790, NULL, NULL, '', 20, ''),
(128, 1, '2026-03-29 20:45:00', '2026-03-29 18:15:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'Vistara', '', '', 3805, NULL, NULL, '', 20, ''),
(129, 1, '2026-03-26 21:50:00', '2026-03-26 19:20:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'Vistara', '', '', 3820, NULL, NULL, '', 20, ''),
(130, 1, '2026-03-27 22:55:00', '2026-03-27 20:25:00', 'Goa (GOI)', 'Pune (PNQ)', 'IndiGo', '', '', 3835, NULL, NULL, '', 20, ''),
(131, 1, '2026-03-29 00:00:00', '2026-03-28 21:30:00', 'Mumbai (BOM)', 'Goa (GOI)', 'IndiGo', '', '', 3850, NULL, NULL, '', 20, ''),
(132, 1, '2026-03-30 01:05:00', '2026-03-29 22:35:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'Air India', '', '', 3865, NULL, NULL, '', 20, ''),
(133, 1, '2026-03-27 02:10:00', '2026-03-26 23:40:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '', '', 3880, NULL, NULL, '', 20, ''),
(134, 1, '2026-03-28 03:15:00', '2026-03-28 00:45:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'Vistara', '', '', 3895, NULL, NULL, '', 20, ''),
(135, 1, '2026-03-29 04:20:00', '2026-03-29 01:50:00', 'Goa (GOI)', 'Pune (PNQ)', 'Vistara', '', '', 3910, NULL, NULL, '', 20, ''),
(136, 1, '2026-03-30 05:25:00', '2026-03-30 02:55:00', 'Mumbai (BOM)', 'Goa (GOI)', 'IndiGo', '', '', 3925, NULL, NULL, '', 20, ''),
(137, 1, '2026-03-27 06:30:00', '2026-03-27 04:00:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'IndiGo', '', '', 3940, NULL, NULL, '', 20, ''),
(138, 1, '2026-03-28 07:35:00', '2026-03-28 05:05:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'Air India', '', '', 3955, NULL, NULL, '', 20, ''),
(139, 1, '2026-03-28 18:40:00', '2026-03-28 16:10:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'SpiceJet', '', '', 3970, NULL, NULL, '', 20, ''),
(140, 1, '2026-03-29 19:45:00', '2026-03-29 17:15:00', 'Goa (GOI)', 'Pune (PNQ)', 'Vistara', '', '', 3985, NULL, NULL, '', 20, ''),
(141, 1, '2026-03-26 20:50:00', '2026-03-26 18:20:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Vistara', '', '', 4000, NULL, NULL, '', 20, ''),
(142, 1, '2026-03-27 21:55:00', '2026-03-27 19:25:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'IndiGo', '', '', 4015, NULL, NULL, '', 20, ''),
(143, 1, '2026-03-28 23:00:00', '2026-03-28 20:30:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'IndiGo', '', '', 4030, NULL, NULL, '', 20, ''),
(144, 1, '2026-03-30 00:05:00', '2026-03-29 21:35:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'Air India', '', '', 4045, NULL, NULL, '', 20, ''),
(145, 1, '2026-03-27 01:10:00', '2026-03-26 22:40:00', 'Goa (GOI)', 'Pune (PNQ)', 'SpiceJet', '', '', 4060, NULL, NULL, '', 20, ''),
(146, 1, '2026-03-28 02:15:00', '2026-03-27 23:45:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Vistara', '', '', 4075, NULL, NULL, '', 20, ''),
(147, 1, '2026-03-29 03:20:00', '2026-03-29 00:50:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'Vistara', '', '', 4090, NULL, NULL, '', 20, ''),
(148, 1, '2026-03-30 04:25:00', '2026-03-30 01:55:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'IndiGo', '', '', 4105, NULL, NULL, '', 20, ''),
(149, 1, '2026-03-27 05:30:00', '2026-03-27 03:00:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'IndiGo', '', '', 4120, NULL, NULL, '', 20, ''),
(150, 1, '2026-03-28 06:35:00', '2026-03-28 04:05:00', 'Goa (GOI)', 'Pune (PNQ)', 'Air India', '', '', 4135, NULL, NULL, '', 20, ''),
(151, 1, '2026-03-29 07:40:00', '2026-03-29 05:10:00', 'Mumbai (BOM)', 'Goa (GOI)', 'SpiceJet', '', '', 4150, NULL, NULL, '', 20, ''),
(152, 1, '2026-03-30 08:45:00', '2026-03-30 06:15:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'Vistara', '', '', 4165, NULL, NULL, '', 20, ''),
(153, 1, '2026-03-26 19:50:00', '2026-03-26 17:20:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'Vistara', '', '', 4180, NULL, NULL, '', 20, ''),
(154, 1, '2026-03-27 20:55:00', '2026-03-27 18:25:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'IndiGo', '', '', 4195, NULL, NULL, '', 20, ''),
(155, 1, '2026-03-28 22:00:00', '2026-03-28 19:30:00', 'Goa (GOI)', 'Pune (PNQ)', 'IndiGo', '', '', 4210, NULL, NULL, '', 20, ''),
(156, 1, '2026-03-29 23:05:00', '2026-03-29 20:35:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '', '', 4225, NULL, NULL, '', 20, ''),
(157, 1, '2026-03-27 00:10:00', '2026-03-26 21:40:00', 'Delhi (DEL)', 'Mumbai (BOM)', 'SpiceJet', '', '', 4240, NULL, NULL, '', 20, ''),
(158, 1, '2026-03-28 01:15:00', '2026-03-27 22:45:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'Vistara', '', '', 4255, NULL, NULL, '', 20, ''),
(159, 1, '2026-03-29 02:20:00', '2026-03-28 23:50:00', 'Pune (PNQ)', 'Bangalore (BLR)', 'Vistara', '', '', 4270, NULL, NULL, '', 20, ''),
(160, 1, '2026-03-30 03:25:00', '2026-03-30 00:55:00', 'Goa (GOI)', 'Pune (PNQ)', 'IndiGo', '', '', 4285, NULL, NULL, '', 20, ''),
(168, 1, '2026-03-26 09:45:00', '2026-03-26 07:15:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 3500, NULL, NULL, '', 20, ''),
(169, 1, '2026-03-27 10:49:00', '2026-03-27 08:19:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 3510, NULL, NULL, '', 20, ''),
(170, 1, '2026-03-28 11:53:00', '2026-03-28 09:23:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 3520, NULL, NULL, '', 20, ''),
(171, 1, '2026-03-29 12:57:00', '2026-03-29 10:27:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 3530, NULL, NULL, '', 20, ''),
(172, 1, '2026-03-26 14:01:00', '2026-03-26 11:31:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 3540, NULL, NULL, '', 20, ''),
(173, 1, '2026-03-27 15:05:00', '2026-03-27 12:35:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 3550, NULL, NULL, '', 20, ''),
(174, 1, '2026-03-28 16:09:00', '2026-03-28 13:39:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 3560, NULL, NULL, '', 20, ''),
(175, 1, '2026-03-29 17:13:00', '2026-03-29 14:43:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 3570, NULL, NULL, '', 20, ''),
(176, 1, '2026-03-26 18:17:00', '2026-03-26 15:47:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 3580, NULL, NULL, '', 20, ''),
(177, 1, '2026-03-27 19:21:00', '2026-03-27 16:51:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 3590, NULL, NULL, '', 20, ''),
(178, 1, '2026-03-28 20:25:00', '2026-03-28 17:55:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 3600, NULL, NULL, '', 20, ''),
(179, 1, '2026-03-29 21:29:00', '2026-03-29 18:59:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 3610, NULL, NULL, '', 20, ''),
(180, 1, '2026-03-26 22:33:00', '2026-03-26 20:03:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 3620, NULL, NULL, '', 20, ''),
(181, 1, '2026-03-27 23:37:00', '2026-03-27 21:07:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 3630, NULL, NULL, '', 20, ''),
(182, 1, '2026-03-28 10:41:00', '2026-03-28 08:11:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 3640, NULL, NULL, '', 20, ''),
(183, 1, '2026-03-29 11:45:00', '2026-03-29 09:15:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 3650, NULL, NULL, '', 20, ''),
(184, 1, '2026-03-26 12:49:00', '2026-03-26 10:19:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 3660, NULL, NULL, '', 20, ''),
(185, 1, '2026-03-27 13:53:00', '2026-03-27 11:23:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 3670, NULL, NULL, '', 20, ''),
(186, 1, '2026-03-28 14:57:00', '2026-03-28 12:27:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 3680, NULL, NULL, '', 20, ''),
(187, 1, '2026-03-29 16:01:00', '2026-03-29 13:31:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 3690, NULL, NULL, '', 20, ''),
(188, 1, '2026-03-26 17:05:00', '2026-03-26 14:35:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 3700, NULL, NULL, '', 20, ''),
(189, 1, '2026-03-27 18:09:00', '2026-03-27 15:39:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 3710, NULL, NULL, '', 20, ''),
(190, 1, '2026-03-28 19:13:00', '2026-03-28 16:43:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 3720, NULL, NULL, '', 20, ''),
(191, 1, '2026-03-29 20:17:00', '2026-03-29 17:47:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 3730, NULL, NULL, '', 20, ''),
(192, 1, '2026-03-26 21:21:00', '2026-03-26 18:51:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 3740, NULL, NULL, '', 20, ''),
(193, 1, '2026-03-27 22:25:00', '2026-03-27 19:55:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 3750, NULL, NULL, '', 20, ''),
(194, 1, '2026-03-28 23:29:00', '2026-03-28 20:59:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 3760, NULL, NULL, '', 20, ''),
(195, 1, '2026-03-30 00:33:00', '2026-03-29 22:03:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 3770, NULL, NULL, '', 20, ''),
(196, 1, '2026-03-26 11:37:00', '2026-03-26 09:07:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 3780, NULL, NULL, '', 20, ''),
(197, 1, '2026-03-27 12:41:00', '2026-03-27 10:11:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 3790, NULL, NULL, '', 20, ''),
(198, 1, '2026-03-28 13:45:00', '2026-03-28 11:15:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 3800, NULL, NULL, '', 20, ''),
(199, 1, '2026-03-29 14:49:00', '2026-03-29 12:19:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 3810, NULL, NULL, '', 20, ''),
(200, 1, '2026-03-26 15:53:00', '2026-03-26 13:23:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 3820, NULL, NULL, '', 20, ''),
(201, 1, '2026-03-27 16:57:00', '2026-03-27 14:27:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 3830, NULL, NULL, '', 20, ''),
(202, 1, '2026-03-28 18:01:00', '2026-03-28 15:31:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 3840, NULL, NULL, '', 20, ''),
(203, 1, '2026-03-29 19:05:00', '2026-03-29 16:35:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 3850, NULL, NULL, '', 20, ''),
(204, 1, '2026-03-26 20:09:00', '2026-03-26 17:39:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 3860, NULL, NULL, '', 20, ''),
(205, 1, '2026-03-27 21:13:00', '2026-03-27 18:43:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 3870, NULL, NULL, '', 20, ''),
(206, 1, '2026-03-28 22:17:00', '2026-03-28 19:47:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 3880, NULL, NULL, '', 20, ''),
(207, 1, '2026-03-29 23:21:00', '2026-03-29 20:51:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 3890, NULL, NULL, '', 20, ''),
(208, 1, '2026-03-27 00:25:00', '2026-03-26 21:55:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 3900, NULL, NULL, '', 20, ''),
(209, 1, '2026-03-28 01:29:00', '2026-03-27 22:59:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 3910, NULL, NULL, '', 20, ''),
(210, 1, '2026-03-28 12:33:00', '2026-03-28 10:03:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 3920, NULL, NULL, '', 20, ''),
(211, 1, '2026-03-29 13:37:00', '2026-03-29 11:07:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 3930, NULL, NULL, '', 20, ''),
(212, 1, '2026-03-26 14:41:00', '2026-03-26 12:11:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 3940, NULL, NULL, '', 20, ''),
(213, 1, '2026-03-27 15:45:00', '2026-03-27 13:15:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 3950, NULL, NULL, '', 20, ''),
(214, 1, '2026-03-28 16:49:00', '2026-03-28 14:19:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 3960, NULL, NULL, '', 20, ''),
(215, 1, '2026-03-29 17:53:00', '2026-03-29 15:23:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 3970, NULL, NULL, '', 20, ''),
(216, 1, '2026-03-26 18:57:00', '2026-03-26 16:27:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 3980, NULL, NULL, '', 20, ''),
(217, 1, '2026-03-27 20:01:00', '2026-03-27 17:31:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 3990, NULL, NULL, '', 20, ''),
(218, 1, '2026-03-28 21:05:00', '2026-03-28 18:35:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 4000, NULL, NULL, '', 20, ''),
(219, 1, '2026-03-29 22:09:00', '2026-03-29 19:39:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 4010, NULL, NULL, '', 20, ''),
(220, 1, '2026-03-26 23:13:00', '2026-03-26 20:43:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 4020, NULL, NULL, '', 20, ''),
(221, 1, '2026-03-28 00:17:00', '2026-03-27 21:47:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 4030, NULL, NULL, '', 20, ''),
(222, 1, '2026-03-29 01:21:00', '2026-03-28 22:51:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 4040, NULL, NULL, '', 20, ''),
(223, 1, '2026-03-30 02:25:00', '2026-03-29 23:55:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 4050, NULL, NULL, '', 20, ''),
(224, 1, '2026-03-26 13:29:00', '2026-03-26 10:59:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 4060, NULL, NULL, '', 20, ''),
(225, 1, '2026-03-27 14:33:00', '2026-03-27 12:03:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 4070, NULL, NULL, '', 20, ''),
(226, 1, '2026-03-28 15:37:00', '2026-03-28 13:07:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 4080, NULL, NULL, '', 20, ''),
(227, 1, '2026-03-29 16:41:00', '2026-03-29 14:11:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 4090, NULL, NULL, '', 20, ''),
(228, 1, '2026-03-26 17:45:00', '2026-03-26 15:15:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 4100, NULL, NULL, '', 20, ''),
(229, 1, '2026-03-27 18:49:00', '2026-03-27 16:19:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 4110, NULL, NULL, '', 20, ''),
(230, 1, '2026-03-28 19:53:00', '2026-03-28 17:23:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 4120, NULL, NULL, '', 20, ''),
(231, 1, '2026-03-29 20:57:00', '2026-03-29 18:27:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 4130, NULL, NULL, '', 20, ''),
(232, 1, '2026-03-26 22:01:00', '2026-03-26 19:31:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 4140, NULL, NULL, '', 20, ''),
(233, 1, '2026-03-27 23:05:00', '2026-03-27 20:35:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 4150, NULL, NULL, '', 20, ''),
(234, 1, '2026-03-29 00:09:00', '2026-03-28 21:39:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 4160, NULL, NULL, '', 20, ''),
(235, 1, '2026-03-30 01:13:00', '2026-03-29 22:43:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 4170, NULL, NULL, '', 20, ''),
(236, 1, '2026-03-27 02:17:00', '2026-03-26 23:47:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 4180, NULL, NULL, '', 20, ''),
(237, 1, '2026-03-28 03:21:00', '2026-03-28 00:51:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 4190, NULL, NULL, '', 20, ''),
(238, 1, '2026-03-28 14:25:00', '2026-03-28 11:55:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 4200, NULL, NULL, '', 20, ''),
(239, 1, '2026-03-29 15:29:00', '2026-03-29 12:59:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 4210, NULL, NULL, '', 20, ''),
(240, 1, '2026-03-26 16:33:00', '2026-03-26 14:03:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 4220, NULL, NULL, '', 20, ''),
(241, 1, '2026-03-27 17:37:00', '2026-03-27 15:07:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 4230, NULL, NULL, '', 20, ''),
(242, 1, '2026-03-28 18:41:00', '2026-03-28 16:11:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 4240, NULL, NULL, '', 20, ''),
(243, 1, '2026-03-29 19:45:00', '2026-03-29 17:15:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 4250, NULL, NULL, '', 20, ''),
(244, 1, '2026-03-26 20:49:00', '2026-03-26 18:19:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 4260, NULL, NULL, '', 20, ''),
(245, 1, '2026-03-27 21:53:00', '2026-03-27 19:23:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 4270, NULL, NULL, '', 20, ''),
(246, 1, '2026-03-28 22:57:00', '2026-03-28 20:27:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 4280, NULL, NULL, '', 20, ''),
(247, 1, '2026-03-30 00:01:00', '2026-03-29 21:31:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 4290, NULL, NULL, '', 20, ''),
(248, 1, '2026-03-27 01:05:00', '2026-03-26 22:35:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 4300, NULL, NULL, '', 20, ''),
(249, 1, '2026-03-28 02:09:00', '2026-03-27 23:39:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 4310, NULL, NULL, '', 20, ''),
(250, 1, '2026-03-29 03:13:00', '2026-03-29 00:43:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 4320, NULL, NULL, '', 20, ''),
(251, 1, '2026-03-30 04:17:00', '2026-03-30 01:47:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 4330, NULL, NULL, '', 20, ''),
(252, 1, '2026-03-26 15:21:00', '2026-03-26 12:51:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 4340, NULL, NULL, '', 20, ''),
(253, 1, '2026-03-27 16:25:00', '2026-03-27 13:55:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 4350, NULL, NULL, '', 20, ''),
(254, 1, '2026-03-28 17:29:00', '2026-03-28 14:59:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 4360, NULL, NULL, '', 20, ''),
(255, 1, '2026-03-29 18:33:00', '2026-03-29 16:03:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 4370, NULL, NULL, '', 20, ''),
(256, 1, '2026-03-26 19:37:00', '2026-03-26 17:07:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 4380, NULL, NULL, '', 20, ''),
(257, 1, '2026-03-27 20:41:00', '2026-03-27 18:11:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 4390, NULL, NULL, '', 20, ''),
(258, 1, '2026-03-28 21:45:00', '2026-03-28 19:15:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 4400, NULL, NULL, '', 20, ''),
(259, 1, '2026-03-29 22:49:00', '2026-03-29 20:19:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 4410, NULL, NULL, '', 20, ''),
(260, 1, '2026-03-26 23:53:00', '2026-03-26 21:23:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 4420, NULL, NULL, '', 20, ''),
(261, 1, '2026-03-28 00:57:00', '2026-03-27 22:27:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 4430, NULL, NULL, '', 20, ''),
(262, 1, '2026-03-29 02:01:00', '2026-03-28 23:31:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 4440, NULL, NULL, '', 20, ''),
(263, 1, '2026-03-30 03:05:00', '2026-03-30 00:35:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 4450, NULL, NULL, '', 20, ''),
(264, 1, '2026-03-27 04:09:00', '2026-03-27 01:39:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '179', '', 4460, NULL, NULL, '21A', 20, ''),
(265, 1, '2026-03-28 05:13:00', '2026-03-28 02:43:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 4470, NULL, NULL, '', 20, ''),
(266, 1, '2026-03-28 16:17:00', '2026-03-28 13:47:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 4480, NULL, NULL, '', 20, ''),
(267, 1, '2026-03-29 17:21:00', '2026-03-29 14:51:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 4490, NULL, NULL, '', 20, ''),
(268, 1, '2026-03-26 18:25:00', '2026-03-26 15:55:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 4500, NULL, NULL, '', 20, ''),
(269, 1, '2026-03-27 19:29:00', '2026-03-27 16:59:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 4510, NULL, NULL, '', 20, ''),
(270, 1, '2026-03-28 20:33:00', '2026-03-28 18:03:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 4520, NULL, NULL, '', 20, ''),
(271, 1, '2026-03-29 21:37:00', '2026-03-29 19:07:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 4530, NULL, NULL, '', 20, ''),
(272, 1, '2026-03-26 22:41:00', '2026-03-26 20:11:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 4540, NULL, NULL, '', 20, ''),
(273, 1, '2026-03-27 23:45:00', '2026-03-27 21:15:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 4550, NULL, NULL, '', 20, ''),
(274, 1, '2026-03-29 00:49:00', '2026-03-28 22:19:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 4560, NULL, NULL, '', 20, ''),
(275, 1, '2026-03-30 01:53:00', '2026-03-29 23:23:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 4570, NULL, NULL, '', 20, ''),
(276, 1, '2026-03-27 02:57:00', '2026-03-27 00:27:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 4580, NULL, NULL, '', 20, ''),
(277, 1, '2026-03-28 04:01:00', '2026-03-28 01:31:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 4590, NULL, NULL, '', 20, ''),
(278, 1, '2026-03-29 05:05:00', '2026-03-29 02:35:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 4600, NULL, NULL, '', 20, ''),
(279, 1, '2026-03-30 06:09:00', '2026-03-30 03:39:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 4610, NULL, NULL, '', 20, ''),
(280, 1, '2026-03-26 17:13:00', '2026-03-26 14:43:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 4620, NULL, NULL, '', 20, ''),
(281, 1, '2026-03-27 18:17:00', '2026-03-27 15:47:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 4630, NULL, NULL, '', 20, ''),
(282, 1, '2026-03-28 19:21:00', '2026-03-28 16:51:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 4640, NULL, NULL, '', 20, ''),
(283, 1, '2026-03-29 20:25:00', '2026-03-29 17:55:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 4650, NULL, NULL, '', 20, ''),
(284, 1, '2026-03-26 21:29:00', '2026-03-26 18:59:00', 'Goa (GOI)', 'Mumbai (BOM)', 'IndiGo', '180', '', 4660, NULL, NULL, '', 20, ''),
(285, 1, '2026-03-27 22:33:00', '2026-03-27 20:03:00', 'Mumbai (BOM)', 'Goa (GOI)', 'Air India', '150', '', 4670, NULL, NULL, '', 20, ''),
(286, 1, '2026-03-28 23:37:00', '2026-03-28 21:07:00', 'Bangalore (BLR)', 'Delhi (DEL)', 'SpiceJet', '180', '', 4680, NULL, NULL, '', 20, ''),
(287, 1, '2026-03-30 00:41:00', '2026-03-29 22:11:00', 'Delhi (DEL)', 'Bangalore (BLR)', 'Vistara', '160', '', 4690, NULL, NULL, '', 20, '');

-- --------------------------------------------------------

--
-- Table structure for table `passenger_profile`
--

CREATE TABLE `passenger_profile` (
  `passenger_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `mobile` varchar(110) NOT NULL,
  `dob` datetime NOT NULL,
  `f_name` varchar(20) DEFAULT NULL,
  `m_name` varchar(20) DEFAULT NULL,
  `l_name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `passenger_profile`
--

INSERT INTO `passenger_profile` (`passenger_id`, `user_id`, `flight_id`, `mobile`, `dob`, `f_name`, `m_name`, `l_name`) VALUES
(15, 7, 24, '9168899951', '2001-01-30 00:00:00', 'saitejtest', 'babu', 'parab test1'),
(18, 7, 24, '9168899951', '1998-02-03 00:00:00', 'saitejtest roundtrip', 'babu', 'parab test'),
(19, 7, 24, '9168899951', '2001-02-05 00:00:00', 'saitejtestt', 'babu', 'parab test'),
(20, 7, 66, '9168899951', '2000-11-11 00:00:00', 'saitejtestt rioundtr', 'babu', 'parab test'),
(21, 7, 66, '9168899951', '2000-11-22 00:00:00', 'saitejtestt rioundtr', 'test 2', 'test 2'),
(22, 7, 66, '9168899951', '2000-11-11 00:00:00', 'saitejtestt rioundtr', 'test 3', 'test 2');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `card_no` varchar(16) NOT NULL,
  `user_id` int(11) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `expire_date` varchar(5) DEFAULT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `card_no`, `user_id`, `flight_id`, `expire_date`, `amount`) VALUES
(1, '1234123412342345', 7, 24, '08/28', 6750),
(2, '1234123412342345', 7, 24, '08/28', 6750),
(3, '2345679876543', 7, 24, '11/27', 6750),
(4, '1234567876543', 7, 24, '12/29', 6750),
(5, '987654322341', 7, 24, '12/29', 6750),
(6, '1234566543234', 7, 24, '12/29', 6750),
(7, '123456788765', 7, 24, '12/29', 6750),
(8, '1234676543445', 7, 24, '12/28', 6750),
(9, '87654356789876', 7, 24, '12/33', 6750),
(10, '3456765434567', 7, 24, '12/28', 6750),
(11, '2345678876542', 7, 24, '12/29', 6750),
(12, '345678765433', 7, 24, '12/28', 6750),
(13, '1234576543345', 7, 24, '11/28', 6750),
(14, '1234567654321', 7, 24, '12/28', 20250),
(15, '1234567891234', 7, 24, '12/29', 4500),
(16, '8765432234654', 7, 24, '12/28', 6750),
(17, '12345676543234', 7, 66, '11/26', 9160),
(18, '1234567898765', 7, 66, '11/26', 8920),
(19, '1234567898765', 7, 66, '11/26', 8920);

-- --------------------------------------------------------

--
-- Table structure for table `pwdreset`
--

CREATE TABLE `pwdreset` (
  `pwd_reset_id` int(11) NOT NULL,
  `pwd_reset_email` varchar(50) NOT NULL,
  `pwd_reset_selector` varchar(80) NOT NULL,
  `pwd_reset_token` varchar(120) NOT NULL,
  `pwd_reset_expires` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticket_id` int(11) NOT NULL,
  `passenger_id` int(11) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `seat_no` varchar(10) NOT NULL,
  `cost` int(11) NOT NULL,
  `class` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ticket_id`, `passenger_id`, `flight_id`, `user_id`, `seat_no`, `cost`, `class`) VALUES
(15, 15, 24, 7, '16B', 20250, 'B'),
(16, 18, 24, 7, '21A', 4500, 'E'),
(17, 19, 24, 7, '17B', 6750, 'B'),
(18, 22, 66, 7, '21A', 4460, 'E'),
(19, 22, 264, 7, '21A', 4460, 'E');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role`) VALUES
(1, 'Testuser001', 'kevinrakwar12@gmail.com', '$2y$10$DqsHHNGm2AT5UxXajKaSqu.3H8Xg2CKoqCOGuHOfIJI1PB9mc4JYe', 'user'),
(6, 'Mary', 'mary12@gmail.com', '$2y$10$6V1vAh/qycO1Mc7rhryUWOHk6kXRkVFqZWr4oOs5yvFCzbEU8cL1O', 'user'),
(7, 'saitej', 'saitejparab@gmail.com', '$2y$10$mIcjn1LqCXwf2ootGGNyX.ioMqmaVuzg27ongmybb.QOtptRlreqa', 'user'),
(8, 'staff1', 'staff1@gmail.com', 'staff', 'staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `airline`
--
ALTER TABLE `airline`
  ADD PRIMARY KEY (`airline_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feed_id`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`flight_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `passenger_profile`
--
ALTER TABLE `passenger_profile`
  ADD PRIMARY KEY (`passenger_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `flight_id` (`flight_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `flight_id` (`flight_id`);

--
-- Indexes for table `pwdreset`
--
ALTER TABLE `pwdreset`
  ADD PRIMARY KEY (`pwd_reset_id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `flight_id` (`flight_id`),
  ADD KEY `passenger_id` (`passenger_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `airline`
--
ALTER TABLE `airline`
  MODIFY `airline_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `flight_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=295;

--
-- AUTO_INCREMENT for table `passenger_profile`
--
ALTER TABLE `passenger_profile`
  MODIFY `passenger_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pwdreset`
--
ALTER TABLE `pwdreset`
  MODIFY `pwd_reset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `flight`
--
ALTER TABLE `flight`
  ADD CONSTRAINT `flight_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`);

--
-- Constraints for table `passenger_profile`
--
ALTER TABLE `passenger_profile`
  ADD CONSTRAINT `passenger_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `passenger_profile_ibfk_2` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`flight_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`flight_id`);

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`flight_id`),
  ADD CONSTRAINT `ticket_ibfk_3` FOREIGN KEY (`passenger_id`) REFERENCES `passenger_profile` (`passenger_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
