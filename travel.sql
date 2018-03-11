-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 11, 2018 at 04:37 
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travel`
--

-- --------------------------------------------------------

--
-- Table structure for table `Angajati`
--

CREATE TABLE `Angajati` (
  `IDAngajat` int(3) NOT NULL,
  `Nume` varchar(30) NOT NULL,
  `Prenume` varchar(30) NOT NULL,
  `Mail` varchar(35) NOT NULL,
  `Passwd` varchar(25) NOT NULL,
  `Salariu` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Angajati`
--

INSERT INTO `Angajati` (`IDAngajat`, `Nume`, `Prenume`, `Mail`, `Passwd`, `Salariu`) VALUES
(7, 'Popa', 'Daniel', 'mail', 'pass', 23),
(8, 'Saru', 'Alin', 'mail', 'pass', 44),
(9, 'Danescu', 'Ionut', 'mail', 'pass', 56),
(14, 'Popescu', 'Andrei', 'mail', 'pass', 44);

-- --------------------------------------------------------

--
-- Table structure for table `Cazare`
--

CREATE TABLE `Cazare` (
  `IDCazare` int(3) NOT NULL,
  `Locatie` varchar(30) NOT NULL DEFAULT 'Fara',
  `Hotel` varchar(20) NOT NULL DEFAULT 'Fara',
  `Pret` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Cazare`
--

INSERT INTO `Cazare` (`IDCazare`, `Locatie`, `Hotel`, `Pret`) VALUES
(33, 'Paris', 'Luvre', 12);

-- --------------------------------------------------------

--
-- Table structure for table `Clienti`
--

CREATE TABLE `Clienti` (
  `IDClient` int(3) NOT NULL,
  `Nume` varchar(30) NOT NULL,
  `Prenume` varchar(30) NOT NULL,
  `Varsta` int(2) NOT NULL,
  `IDAngajat` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Clienti`
--

INSERT INTO `Clienti` (`IDClient`, `Nume`, `Prenume`, `Varsta`, `IDAngajat`) VALUES
(9, 'Prepelita', 'Adelina', 34, 14),
(10, 'Geovani', 'Andreea', 44, 9),
(11, 'Stamate ', 'Adelin', 21, 8),
(12, 'Prunel', 'Alexandru', 21, 9);

-- --------------------------------------------------------

--
-- Table structure for table `Excursie`
--

CREATE TABLE `Excursie` (
  `IDExcursie` int(3) NOT NULL,
  `Destinatie` varchar(40) NOT NULL,
  `DataPlecare` date NOT NULL,
  `DataSosire` date NOT NULL,
  `Pret` int(5) NOT NULL DEFAULT '0',
  `IDCazare` int(3) NOT NULL DEFAULT '0',
  `IDTransport` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Excursie`
--

INSERT INTO `Excursie` (`IDExcursie`, `Destinatie`, `DataPlecare`, `DataSosire`, `Pret`, `IDCazare`, `IDTransport`) VALUES
(61, 'Paris', '2018-01-21', '2018-01-27', 34, 33, 19);

-- --------------------------------------------------------

--
-- Table structure for table `Transport`
--

CREATE TABLE `Transport` (
  `IDTransport` int(3) NOT NULL,
  `Mijloc` varchar(15) NOT NULL DEFAULT 'Fara',
  `Firma` varchar(20) NOT NULL DEFAULT 'Fara',
  `Pret` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Transport`
--

INSERT INTO `Transport` (`IDTransport`, `Mijloc`, `Firma`, `Pret`) VALUES
(19, 'Tren', 'CFR', 22);

-- --------------------------------------------------------

--
-- Table structure for table `Vacanta`
--

CREATE TABLE `Vacanta` (
  `IDVacanta` int(3) NOT NULL,
  `IDClient` int(3) NOT NULL DEFAULT '0',
  `IDExcursie` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Vacanta`
--

INSERT INTO `Vacanta` (`IDVacanta`, `IDClient`, `IDExcursie`) VALUES
(28, 9, 61);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Angajati`
--
ALTER TABLE `Angajati`
  ADD PRIMARY KEY (`IDAngajat`);

--
-- Indexes for table `Cazare`
--
ALTER TABLE `Cazare`
  ADD PRIMARY KEY (`IDCazare`),
  ADD UNIQUE KEY `Locatie` (`Locatie`);

--
-- Indexes for table `Clienti`
--
ALTER TABLE `Clienti`
  ADD PRIMARY KEY (`IDClient`),
  ADD KEY `IDAngajat` (`IDAngajat`),
  ADD KEY `IDAngajat_2` (`IDAngajat`);

--
-- Indexes for table `Excursie`
--
ALTER TABLE `Excursie`
  ADD PRIMARY KEY (`IDExcursie`),
  ADD KEY `IDCazare` (`IDCazare`),
  ADD KEY `IDTransport` (`IDTransport`),
  ADD KEY `IDCazare_2` (`IDCazare`,`IDTransport`);

--
-- Indexes for table `Transport`
--
ALTER TABLE `Transport`
  ADD PRIMARY KEY (`IDTransport`);

--
-- Indexes for table `Vacanta`
--
ALTER TABLE `Vacanta`
  ADD PRIMARY KEY (`IDVacanta`),
  ADD KEY `IDClient` (`IDClient`),
  ADD KEY `IDExcursie` (`IDExcursie`),
  ADD KEY `IDClient_2` (`IDClient`,`IDExcursie`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Angajati`
--
ALTER TABLE `Angajati`
  MODIFY `IDAngajat` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `Cazare`
--
ALTER TABLE `Cazare`
  MODIFY `IDCazare` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `Clienti`
--
ALTER TABLE `Clienti`
  MODIFY `IDClient` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `Excursie`
--
ALTER TABLE `Excursie`
  MODIFY `IDExcursie` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `Transport`
--
ALTER TABLE `Transport`
  MODIFY `IDTransport` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `Vacanta`
--
ALTER TABLE `Vacanta`
  MODIFY `IDVacanta` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
