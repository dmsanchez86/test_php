-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2016 at 02:04 AM
-- Server version: 5.5.44-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `prueba`
--

-- --------------------------------------------------------

--
-- Table structure for table `dataUser`
--

CREATE TABLE IF NOT EXISTS `dataUser` (
  `id` bigint(20) NOT NULL,
  `fullname` varchar(30) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `user` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dataUser`
--

INSERT INTO `dataUser` (`id`, `fullname`, `email`, `gender`, `user`) VALUES
(1, NULL, NULL, NULL, 'mao123'),
(3, NULL, NULL, NULL, 'calilo45'),
(4, NULL, NULL, NULL, 'pao344'),
(5, NULL, NULL, NULL, 'valery12'),
(6, NULL, NULL, NULL, 'weil233'),
(12324234, 'Alexander', 'alex@gmail.com', 'Male', 'alex'),
(1053844273, 'Daniel Mauricio SÃ¡nchez Avila', 'dmsanchez86@misena.edu.co', 'Female', 'dmsanchez86'),
(1202323434, 'Mao Avila', 'mao@gmail.com', 'Male', 'maito123');

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE IF NOT EXISTS `loan` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `amount` bigint(20) NOT NULL,
  `due` int(11) NOT NULL,
  `date` date NOT NULL,
  `user` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`code`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pays`
--

CREATE TABLE IF NOT EXISTS `pays` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `payment` bigint(20) NOT NULL,
  `loan_code` int(11) NOT NULL,
  PRIMARY KEY (`code`),
  KEY `loan_code` (`loan_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE IF NOT EXISTS `requests` (
  `request_code` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(20) NOT NULL,
  `amount` bigint(20) NOT NULL,
  `dues` enum('1','3','5','6','12','18','24','36') DEFAULT NULL,
  `state` enum('active','close') DEFAULT NULL,
  PRIMARY KEY (`request_code`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`request_code`, `user`, `amount`, `dues`, `state`) VALUES
(1, 'dmsanchez86', 50000, '1', 'active'),
(2, 'dmsanchez86', 1000000, '6', 'active'),
(3, 'alex', 50000, '1', 'active'),
(4, 'dmsanchez86', 500000, '3', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL,
  `rol` enum('administrator','user') NOT NULL,
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user`, `password`, `rol`) VALUES
('admin', 'admin', 'administrator'),
('alex', '777859', 'user'),
('calilo45', '123456', 'user'),
('dmsanchez86', '123456', 'user'),
('maito123', '123456', 'user'),
('mao123', '123456', 'user'),
('masterAdmin', 'admin', 'administrator'),
('pao344', 'pao123', 'user'),
('valery12', '123456', 'user'),
('weil233', '123123', 'user');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dataUser`
--
ALTER TABLE `dataUser`
  ADD CONSTRAINT `dataUser_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`user`);

--
-- Constraints for table `loan`
--
ALTER TABLE `loan`
  ADD CONSTRAINT `loan_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`user`);

--
-- Constraints for table `pays`
--
ALTER TABLE `pays`
  ADD CONSTRAINT `pays_ibfk_1` FOREIGN KEY (`loan_code`) REFERENCES `loan` (`code`);

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`user`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
