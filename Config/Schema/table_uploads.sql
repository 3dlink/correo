-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2014 at 05:47 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `correspondencia`
--

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--
ALTER TABLE  `uploads` ADD  `signature` int(11) NOT NULL DEFAULT '0';
ALTER TABLE  `uploads` ADD  `locked` int(11) NOT NULL DEFAULT '0';
ALTER TABLE  `uploads` ADD  `locked_until` datetime DEFAULT NULL;
ALTER TABLE  `uploads` ADD  `last_user_id` int(11) DEFAULT NULL;
ALTER TABLE  `uploads` ADD  `token` varchar(32) DEFAULT NULL;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
