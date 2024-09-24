-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2024 at 09:18 PM
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
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `firstname`, `lastname`, `email`, `password`) VALUES
(1, 'Bill', 'Cypher', 'billcypher@hotmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `idno` int(10) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `purpose` varchar(50) NOT NULL,
  `lab` varchar(50) NOT NULL,
  `session` int(10) NOT NULL,
  `timein` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_history`
--

INSERT INTO `login_history` (`idno`, `firstName`, `lastName`, `purpose`, `lab`, `session`, `timein`) VALUES
(21459805, 'Rhodney Dame', 'Ponsica', 'Java', 'Lab 526', 30, '0000-00-00 00:00:00'),
(21448733, 'Miles', 'Campomanes', 'JavaScript', 'Lab 528', 29, '0000-00-00 00:00:00'),
(21459805, 'Rhodney Dame', 'Ponsica', 'Python', 'Lab 524', 29, '0000-00-00 00:00:00'),
(21485567, 'Jude', 'Saagundo', 'JavaScript', 'Lab 528', 28, '0000-00-00 00:00:00'),
(21448733, 'Miles', 'Campomanes', 'C++', 'Lab 526', 28, '2024-04-29 18:32:36'),
(21459805, 'Rhodney Dame', 'Ponsica', 'C', 'Lab 529', 28, '2024-04-29 18:32:44'),
(21485567, 'Jude', 'Saagundo', 'Python', 'Lab 528', 27, '2024-04-29 18:32:56'),
(21469895, 'Christanjay', 'Español', 'C#', 'Lab 526', 29, '2024-05-02 20:32:10'),
(21469895, 'Christanjay', 'Español', 'C', 'Lab 526', 28, '2024-05-02 20:32:23'),
(21485567, 'Jude', 'Saagundo', 'JavaScript', 'Lab 526', 26, '2024-05-02 20:28:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `idno` int(10) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `middleName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `password` varchar(10) NOT NULL,
  `age` int(10) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `purpose` varchar(50) NOT NULL,
  `lab` varchar(50) NOT NULL,
  `session` int(11) DEFAULT 30,
  `timein` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `idno`, `firstName`, `middleName`, `lastName`, `password`, `age`, `gender`, `contact`, `email`, `address`, `purpose`, `lab`, `session`, `timein`) VALUES
(20, 21459805, 'Rhodney Dame', 'Nellas', 'Ponsica', '123', 20, 'male', '09182745362', 'rdpons123@gmail.com', 'Cebu City', 'Python', 'Lab 528', 28, '2024-05-02 20:28:19'),
(21, 21448733, 'Miles', 'De Guzman', 'Campomanes', '123', 22, 'male', '09325415541', 'miles123@hotmail.com', 'Dalaguete, Cebu', 'C++', 'Lab 529', 28, '2024-05-02 20:28:02'),
(22, 21485567, 'Jude', 'Anova', 'Saagundo', '123', 20, 'male', '09878909543', 'praise.capt006@gmail.com', 'Mindanao', 'C', 'Lab 524', 26, '2024-05-02 21:12:21'),
(23, 21469895, 'Christanjay', 'Morante', 'Español', '123', 20, 'male', '09827564551', 'cj@gmail.com', 'Guadalupe, Cebu City', 'Java', 'Lab 526', 28, '2024-05-02 20:38:32');

-- --------------------------------------------------------

--
-- Table structure for table `users_sitin`
--

CREATE TABLE `users_sitin` (
  `id` int(10) NOT NULL,
  `idno` int(10) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `middleName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `password` varchar(10) NOT NULL,
  `age` int(10) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `purpose` varchar(50) NOT NULL,
  `lab` varchar(50) NOT NULL,
  `session` int(11) DEFAULT 30,
  `timein` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_sitin`
--

INSERT INTO `users_sitin` (`id`, `idno`, `firstName`, `middleName`, `lastName`, `password`, `age`, `gender`, `contact`, `email`, `address`, `purpose`, `lab`, `session`, `timein`) VALUES
(15, 21448733, 'Miles', 'De Guzman', 'Campomanes', '123', 22, 'male', '09325415541', 'miles123@hotmail.com', 'Dalaguete, Cebu', 'C++', 'Lab 529', 28, '2024-05-02 20:28:02'),
(16, 21459805, 'Rhodney Dame', 'Nellas', 'Ponsica', '123', 20, 'male', '09182745362', 'rdpons123@gmail.com', 'Cebu City', 'Python', 'Lab 528', 28, '2024-05-02 20:28:19'),
(20, 21469895, 'Christanjay', 'Morante', 'Español', '123', 20, 'male', '09827564551', 'cj@gmail.com', 'Guadalupe, Cebu City', 'Java', 'Lab 526', 28, '2024-05-02 20:38:32'),
(21, 21485567, 'Jude', 'Anova', 'Saagundo', '123', 20, 'male', '09878909543', 'praise.capt006@gmail.com', 'Mindanao', 'C', 'Lab 524', 26, '2024-05-02 21:12:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_sitin`
--
ALTER TABLE `users_sitin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users_sitin`
--
ALTER TABLE `users_sitin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
