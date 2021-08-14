-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2018 at 07:52 AM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ktemplat_restaurantfinder`
--

-- --------------------------------------------------------

--
-- Table structure for table `clinic_adminlogin`
--

CREATE TABLE IF NOT EXISTS `clinic_adminlogin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `icon` varchar(250) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `clinic_adminlogin`
--

INSERT INTO `clinic_adminlogin` (`id`, `username`, `password`, `fullname`, `email`, `phone`, `icon`, `is_active`) VALUES
(1, 'admin', '123', 'administrator', 'admin@gmail.com', '9601604082', 'admin_1470741942.jpeg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `clinic_city`
--

CREATE TABLE IF NOT EXISTS `clinic_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `clinic_notification`
--

CREATE TABLE IF NOT EXISTS `clinic_notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `apikey` varchar(300) NOT NULL,
  `passphrace` varchar(50) NOT NULL,
  `certificate` varchar(50) NOT NULL,
  `environment` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `clinic_profile`
--

CREATE TABLE IF NOT EXISTS `clinic_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mcat_id` int(11) NOT NULL,
  `spcat_id` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(120) NOT NULL,
  `hours` varchar(50) NOT NULL,
  `lat` varchar(30) NOT NULL,
  `lon` varchar(30) NOT NULL,
  `about` text NOT NULL,
  `services` varchar(500) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(50) NOT NULL,
  `goole_plus` varchar(200) NOT NULL,
  `helthcare` text NOT NULL,
  `facebook` varchar(200) NOT NULL,
  `twiter` varchar(200) NOT NULL,
  `linkedin` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `clinic_reviewratting`
--

CREATE TABLE IF NOT EXISTS `clinic_reviewratting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `review_text` text NOT NULL,
  `ratting` varchar(10) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `clinic_sendnotification`
--

CREATE TABLE IF NOT EXISTS `clinic_sendnotification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `clinic_specialist`
--

CREATE TABLE IF NOT EXISTS `clinic_specialist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sp_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon` varchar(300) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `clinic_tokendata`
--

CREATE TABLE IF NOT EXISTS `clinic_tokendata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `clinic_users`
--

CREATE TABLE IF NOT EXISTS `clinic_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(40) NOT NULL,
  `image` text NOT NULL,
  `created_at` int(11) NOT NULL,
  `reg_type` varchar(100) NOT NULL,
  `reg_id` text NOT NULL,
  `platform` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
