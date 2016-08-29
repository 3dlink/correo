-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 29-08-2014 a las 11:20:45
-- Versión del servidor: 5.5.31
-- Versión de PHP: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `correspondencia`
--
CREATE DATABASE IF NOT EXISTS `correspondencia` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `correspondencia`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groupis`
--

DROP TABLE IF EXISTS `groupis`;
CREATE TABLE IF NOT EXISTS `groupis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) DEFAULT NULL,
  `active` int(11) DEFAULT '1',
  `entity_id` int(11) DEFAULT '0',
  `type` int(2) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Volcado de datos para la tabla `groups`
--

INSERT INTO `groups` (`id`, `name`, `active`, `entity_id`, `type`) VALUES
(1, 'Ministros', 1, NULL, 1),
(2, 'Administradores Generales', 1, NULL, 1),
(3, 'Directores Generales', 1, NULL, 1),
(4, 'Alcaldes', 1, NULL, 1),
(5, 'Gobernadores', 1, NULL, 1),
(6, 'Diputados', 1, NULL, 1),
(7, 'Procuradores', 1, NULL, 1),
(8, 'Representantes', 1, NULL, 1),
(9, 'Jefes / Directores de Tecnología', 1, NULL, 1),
(10, 'Jefes de OIRH', 1, NULL, 1),
(11, 'Directores de Administración y Finanzas', 1, NULL, 1),
(12, 'Directores Operativos', 1, NULL, 1),
(13, 'Administradores de la Plataforma', 1, NULL, 1),
(14, 'Usuario Final', 1, NULL, 1),
(15, 'Programador', 1, 57, 2),
(17, 'sdd', 1, 136, 2),
(18, 'Prueba Vision', 1, 136, 2),
(19, 'Grupo de MEF', 1, 75, 2),
(20, 'nuevo', 1, 75, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traces`
--

DROP TABLE IF EXISTS `traces`;
CREATE TABLE IF NOT EXISTS `traces` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '0 si es to, 1 si es cc',
  `communication_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `sender_user_id` int(11) NOT NULL,
  `receive_user_id` int(11) NOT NULL,
  `sender_entity_id` int(11) NOT NULL,
  `receive_entity_id` int(11) NOT NULL,
  `read` int(11) NOT NULL DEFAULT '0',
  `read_datatime` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `type_delivery` int(11) NOT NULL DEFAULT '0' COMMENT '0 to, 1 cc, 2 cco',
  `requires_approval` int(11) DEFAULT '0',
  `approval` int(11) DEFAULT '0' COMMENT '-1 rechazado 1 aprobado',
  `namegroup` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
