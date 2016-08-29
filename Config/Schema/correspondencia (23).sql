-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 28-05-2014 a las 15:54:19
-- Versión del servidor: 5.1.71
-- Versión de PHP: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `correspondencia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `circles`
--

DROP TABLE IF EXISTS `circles`;
CREATE TABLE IF NOT EXISTS `circles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) NOT NULL COMMENT 'nombre del grupo',
  `active` int(11) NOT NULL DEFAULT '1' COMMENT 'indica si esta activo',
  `user_id` int(11) NOT NULL COMMENT 'id del usuario creador',
  `type` int(11) NOT NULL COMMENT '1 privado 2 publico',
  `created` datetime NOT NULL COMMENT 'fecha de creado',
  `entity_id` int(11) NOT NULL COMMENT 'id de la entidad padre del usuario creador',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='contiene los irculos creados' AUTO_INCREMENT=16 ;

--
-- Volcado de datos para la tabla `circles`
--

INSERT INTO `circles` (`id`, `name`, `active`, `user_id`, `type`, `created`, `entity_id`) VALUES
(8, 'Flujo de Compras', 1, 44, 1, '2014-03-21 10:55:01', 75),
(9, 'Flujo de Compras', 1, 43, 2, '2014-04-11 17:47:55', 57),
(10, 'Dirección de Innovación Gubernamental', 1, 45, 1, '2014-05-08 13:55:32', 136),
(11, 'Red Nacional de Internet', 1, 86, 1, '2014-05-08 14:40:03', 136),
(12, 'Dirección de Innovación Gubernamental', 1, 86, 1, '2014-05-08 14:40:40', 136),
(13, 'Dirección de Arquitectura Tecnológica', 1, 45, 1, '2014-05-09 11:45:52', 136),
(14, 'Administradores de Proyectos', 1, 45, 1, '2014-05-09 11:46:05', 136),
(15, 'Tecnología', 1, 102, 1, '2014-05-28 12:33:29', 136);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `communications`
--

DROP TABLE IF EXISTS `communications`;
CREATE TABLE IF NOT EXISTS `communications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `communication_type_id` int(11) DEFAULT '0',
  `communication_category_id` int(11) DEFAULT '0',
  `action_id` int(11) DEFAULT '0' COMMENT 'tipo de accion que requiere la comunicacion',
  `draft` int(11) NOT NULL DEFAULT '0' COMMENT '1 si la comunicacion es un borrador',
  `expires` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Volcado de datos para la tabla `communications`
--

INSERT INTO `communications` (`id`, `entity_id`, `user_id`, `created`, `modified`, `communication_type_id`, `communication_category_id`, `action_id`, `draft`, `expires`) VALUES
(1, 93, 46, '2014-02-06 16:28:54', '2014-02-06 17:04:50', 1, 14, 2, 0, NULL),
(2, 93, 46, '2014-02-08 10:11:29', '2014-02-08 10:11:29', 2, 8, 4, 0, NULL),
(3, 93, 46, '2014-02-08 10:30:31', '2014-02-08 10:30:31', 1, 11, 4, 0, NULL),
(4, 88, 44, '2014-02-12 16:11:17', '2014-02-12 16:11:48', 4, 7, 4, 0, NULL),
(5, 71, 43, '2014-02-13 10:47:17', '2014-03-21 11:11:16', 4, 7, 2, 0, NULL),
(6, 71, 43, '2014-02-13 11:11:25', '2014-02-13 11:12:09', 1, 11, 2, 0, NULL),
(7, 93, 46, '2014-03-25 15:26:14', '2014-03-25 15:26:14', 2, 8, 6, 0, NULL),
(8, 93, 46, '2014-04-04 09:45:42', '2014-04-04 09:49:42', 2, 8, 4, 0, NULL),
(9, 78, 47, '2014-04-04 09:54:51', '2014-04-04 09:57:46', 2, 8, 4, 0, NULL),
(10, 93, 46, '2014-04-04 12:46:31', '2014-04-04 12:50:18', 1, 13, 4, 0, NULL),
(11, 71, 43, '2014-04-09 11:55:11', '2014-04-09 11:55:11', 1, 11, 2, 0, NULL),
(12, 71, 43, '2014-04-11 16:41:48', '2014-04-11 16:41:48', 5, 18, 5, 1, NULL),
(13, 71, 43, '2014-04-16 11:31:03', '2014-04-16 11:31:03', 3, 3, 4, 0, NULL),
(14, 71, 43, '2014-04-24 15:53:04', '2014-04-24 15:53:04', 3, 3, 0, 1, NULL),
(15, 136, 45, '2014-05-05 12:04:24', '2014-05-05 12:04:24', 3, 5, 2, 0, NULL),
(16, 136, 45, '2014-05-06 07:56:06', '2014-05-06 07:56:06', 2, 8, 2, 1, NULL),
(17, 136, 45, '2014-05-09 09:18:38', '2014-05-09 09:27:27', 6, 15, 3, 0, NULL),
(18, 136, 45, '2014-05-09 09:45:31', '2014-05-09 09:50:04', 6, 13, 2, 0, NULL),
(19, 164, 102, '2014-05-12 11:08:24', '2014-05-12 11:08:24', 2, 1, 3, 0, NULL),
(20, 164, 102, '2014-05-12 11:11:48', '2014-05-12 11:11:48', 2, 2, 4, 0, NULL),
(21, 79, 50, '2014-05-23 11:11:46', '2014-05-23 11:11:46', 1, 7, 4, 0, '2014-05-26'),
(22, 79, 50, '2014-05-23 12:25:51', '2014-05-23 12:25:51', 2, 1, 4, 0, '2014-05-28'),
(23, 61, 51, '2014-05-23 12:37:37', '2014-05-23 12:37:37', 3, 5, 6, 0, '2014-05-28'),
(24, 61, 51, '2014-05-23 12:39:24', '2014-05-23 12:39:24', 1, 7, 6, 0, '2014-05-28'),
(25, 61, 51, '2014-05-23 12:44:29', '2014-05-23 12:44:29', 3, 5, 6, 0, '2014-05-28'),
(26, 61, 51, '2014-05-23 12:47:57', '2014-05-23 12:47:57', 3, 5, 6, 0, '2014-05-28'),
(27, 137, 45, '2014-05-23 15:50:35', '2014-05-23 15:50:35', 6, 13, 2, 0, NULL),
(28, 137, 45, '2014-05-28 11:25:28', '2014-05-28 11:25:28', 6, 13, 2, 0, '2014-06-04'),
(29, 137, 45, '2014-05-28 11:31:48', '2014-05-28 12:23:20', 6, 13, 2, 0, '2014-05-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `communication_categories`
--

DROP TABLE IF EXISTS `communication_categories`;
CREATE TABLE IF NOT EXISTS `communication_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) DEFAULT NULL,
  `active` int(11) DEFAULT '1',
  `communication_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Volcado de datos para la tabla `communication_categories`
--

INSERT INTO `communication_categories` (`id`, `name`, `active`, `communication_type_id`) VALUES
(1, 'Normativos', 1, 2),
(2, 'Informativos', 1, 2),
(3, 'Internos', 1, 3),
(4, 'Actas', 1, 6),
(5, 'Al exterior', 1, 3),
(6, 'Seminarios', 1, 5),
(7, 'Internas', 1, 1),
(8, 'Otros', 1, 2),
(9, 'Cursos', 1, 5),
(10, 'Minutas', 1, 6),
(11, 'Externas', 1, 1),
(12, 'Otros', 1, 5),
(13, 'Resoluciones', 1, 6),
(14, 'Proyectos de Ley', 1, 6),
(15, 'Acuerdos', 1, 6),
(16, 'Edictos', 1, 6),
(17, 'Oficios', 1, 6),
(18, 'Foro', 1, 5),
(19, 'Decretos', 1, 6),
(20, 'Contratos', 1, 6),
(21, 'Adendas', 1, 6),
(22, 'Pólizas', 1, 6),
(23, 'Otros', 1, 6),
(24, 'Destitución', 1, 7),
(25, 'Resueltos', 1, 7),
(26, 'Taller', 1, 5),
(27, 'Asistencias', 1, 7),
(28, 'Pago de planilla adicional', 1, 7),
(29, 'Informes', 1, 9),
(30, 'Agendas de reunión', 1, 9),
(31, 'Agendas de trabajo', 1, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `communication_tokens`
--

DROP TABLE IF EXISTS `communication_tokens`;
CREATE TABLE IF NOT EXISTS `communication_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `communication_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=90 ;

--
-- Volcado de datos para la tabla `communication_tokens`
--

INSERT INTO `communication_tokens` (`id`, `communication_id`, `user_id`) VALUES
(2, 1, 46),
(3, 2, 47),
(4, 3, 47),
(6, 4, 44),
(9, 6, 43),
(10, 5, 43),
(11, 7, 47),
(13, 8, 46),
(15, 9, 47),
(17, 10, 46),
(18, 11, 45),
(19, 12, 45),
(20, 13, 42),
(21, 13, 44),
(22, 13, 46),
(23, 13, 47),
(24, 13, 49),
(25, 13, 50),
(26, 14, 45),
(27, 15, 45),
(28, 15, 54),
(29, 16, 45),
(30, 16, 54),
(34, 17, 86),
(37, 17, 45),
(38, 17, 45),
(39, 17, 86),
(41, 17, 109),
(42, 17, 45),
(43, 17, 45),
(44, 17, 86),
(45, 17, 102),
(46, 17, 109),
(47, 17, 45),
(53, 18, 109),
(54, 18, 45),
(55, 18, 45),
(56, 18, 86),
(58, 18, 109),
(59, 18, 45),
(60, 18, 45),
(61, 18, 86),
(62, 18, 102),
(63, 18, 109),
(64, 18, 45),
(65, 19, 86),
(66, 19, 45),
(67, 20, 45),
(68, 21, 51),
(69, 22, 51),
(70, 26, 50),
(71, 27, 86),
(72, 27, 102),
(73, 27, 109),
(74, 27, 54),
(75, 28, 86),
(76, 28, 109),
(77, 28, 102),
(80, 29, 102),
(81, 29, 86),
(82, 29, 102),
(84, 29, 45),
(85, 29, 45),
(86, 29, 86),
(87, 29, 102),
(88, 29, 109),
(89, 29, 45);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `communication_trashs`
--

DROP TABLE IF EXISTS `communication_trashs`;
CREATE TABLE IF NOT EXISTS `communication_trashs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `communication_id` int(11) NOT NULL COMMENT 'id de la comunicacion',
  `user_id` int(11) NOT NULL COMMENT 'id del usuario',
  `trash` int(11) NOT NULL COMMENT '0 si es visible, 1 en trash, 2 eliminado',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='contiene informacion sobre si la comunicacion esta en la pap' AUTO_INCREMENT=92 ;

--
-- Volcado de datos para la tabla `communication_trashs`
--

INSERT INTO `communication_trashs` (`id`, `communication_id`, `user_id`, `trash`) VALUES
(17, 1, 46, 0),
(18, 1, 47, 0),
(19, 2, 46, 2),
(20, 2, 47, 0),
(21, 3, 46, 0),
(22, 3, 47, 1),
(23, 4, 44, 0),
(24, 4, 43, 2),
(25, 5, 43, 1),
(26, 5, 44, 0),
(27, 6, 43, 0),
(28, 6, 45, 0),
(29, 7, 46, 0),
(30, 7, 47, 0),
(31, 8, 46, 0),
(32, 8, 47, 0),
(33, 9, 47, 0),
(34, 9, 46, 0),
(35, 10, 46, 0),
(36, 10, 47, 0),
(37, 11, 43, 0),
(38, 11, 45, 0),
(39, 12, 43, 0),
(40, 12, 45, 0),
(41, 13, 43, 0),
(42, 13, 42, 0),
(43, 13, 44, 0),
(44, 13, 46, 0),
(45, 13, 47, 0),
(46, 13, 49, 0),
(47, 13, 50, 0),
(48, 14, 43, 0),
(49, 14, 45, 0),
(50, 15, 45, 0),
(51, 15, 54, 0),
(52, 16, 45, 0),
(53, 16, 54, 0),
(54, 17, 45, 1),
(55, 17, 86, 0),
(56, 17, 102, 0),
(57, 17, 109, 0),
(58, 18, 45, 0),
(59, 18, 86, 0),
(60, 18, 109, 0),
(61, 18, 102, 0),
(62, 19, 102, 0),
(63, 19, 45, 0),
(64, 19, 86, 0),
(65, 20, 102, 0),
(66, 20, 45, 0),
(67, 21, 50, 0),
(68, 21, 51, 0),
(69, 22, 50, 0),
(70, 22, 51, 0),
(71, 23, 51, 0),
(72, 23, 50, 0),
(73, 24, 51, 0),
(74, 24, 50, 0),
(75, 25, 51, 0),
(76, 25, 50, 0),
(77, 26, 51, 0),
(78, 26, 50, 0),
(79, 27, 45, 0),
(80, 27, 86, 0),
(81, 27, 102, 0),
(82, 27, 109, 0),
(83, 27, 54, 0),
(84, 28, 45, 0),
(85, 28, 86, 0),
(86, 28, 109, 0),
(87, 28, 102, 0),
(88, 29, 45, 0),
(89, 29, 86, 0),
(90, 29, 109, 0),
(91, 29, 102, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `communication_types`
--

DROP TABLE IF EXISTS `communication_types`;
CREATE TABLE IF NOT EXISTS `communication_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) DEFAULT NULL,
  `active` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `communication_types`
--

INSERT INTO `communication_types` (`id`, `name`, `active`) VALUES
(1, 'Circular', 1),
(2, 'Memorando', 1),
(3, 'Viático ', 1),
(4, 'Notas', 1),
(5, 'Invitación', 1),
(6, 'Documentos Legales', 1),
(7, 'Recursos Humanos', 1),
(8, 'Documentos Financieros', 1),
(9, 'Otros', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `communication_views`
--

DROP TABLE IF EXISTS `communication_views`;
CREATE TABLE IF NOT EXISTS `communication_views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `communication_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `last_view` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Volcado de datos para la tabla `communication_views`
--

INSERT INTO `communication_views` (`id`, `communication_id`, `user_id`, `last_view`) VALUES
(1, 1, 46, '2014-03-25 15:25:51'),
(2, 1, 47, '2014-02-06 17:03:55'),
(3, 2, 46, '2014-02-08 10:13:47'),
(4, 3, 46, '2014-03-25 15:10:21'),
(5, 3, 47, '2014-02-08 10:31:32'),
(6, 4, 44, '2014-03-21 11:22:53'),
(7, 4, 43, '2014-02-13 10:52:09'),
(8, 5, 43, '2014-04-09 11:52:12'),
(9, 6, 43, '2014-02-13 11:12:26'),
(10, 6, 45, '2014-02-13 11:11:40'),
(11, 5, 44, '2014-03-21 11:18:21'),
(12, 7, 46, '2014-03-25 15:26:14'),
(13, 8, 46, '2014-04-04 09:50:50'),
(14, 8, 47, '2014-04-04 09:53:26'),
(15, 9, 47, '2014-04-04 09:54:51'),
(16, 9, 46, '2014-04-04 10:08:25'),
(17, 10, 46, '2014-04-04 12:52:03'),
(18, 10, 47, '2014-04-04 12:47:36'),
(19, 11, 43, '2014-04-11 16:34:52'),
(20, 11, 45, '2014-05-23 10:40:17'),
(21, 12, 43, '2014-04-11 16:41:48'),
(22, 13, 43, '2014-04-25 12:06:36'),
(23, 13, 44, '2014-04-16 11:31:56'),
(24, 14, 43, '2014-04-24 15:53:04'),
(25, 15, 45, '2014-05-23 10:43:00'),
(26, 16, 45, '2014-05-06 07:56:06'),
(27, 17, 45, '2014-05-09 09:28:57'),
(28, 17, 86, '2014-05-09 09:48:11'),
(29, 17, 109, '2014-05-09 09:46:25'),
(30, 17, 102, '2014-05-09 09:27:40'),
(31, 18, 45, '2014-05-09 10:19:45'),
(32, 18, 109, '2014-05-09 09:47:27'),
(33, 18, 86, '2014-05-12 11:13:13'),
(34, 18, 102, '2014-05-09 09:50:16'),
(35, 19, 102, '2014-05-12 11:08:24'),
(36, 19, 86, '2014-05-12 11:08:59'),
(37, 19, 45, '2014-05-12 11:10:16'),
(38, 20, 102, '2014-05-12 11:11:48'),
(39, 20, 45, '2014-05-12 11:13:55'),
(40, 21, 50, '2014-05-23 11:13:14'),
(41, 13, 50, '2014-05-23 11:12:48'),
(42, 21, 51, '2014-05-23 11:13:46'),
(43, 22, 50, '2014-05-23 12:27:01'),
(44, 23, 51, '2014-05-23 12:37:38'),
(45, 24, 51, '2014-05-23 12:39:24'),
(46, 25, 51, '2014-05-23 12:44:29'),
(47, 26, 51, '2014-05-23 12:47:57'),
(48, 27, 45, '2014-05-28 09:09:00'),
(49, 27, 86, '2014-05-28 11:35:13'),
(50, 28, 45, '2014-05-28 11:25:28'),
(51, 29, 45, '2014-05-28 11:31:48'),
(52, 29, 86, '2014-05-28 12:07:28'),
(53, 29, 109, '2014-05-28 12:21:10'),
(54, 29, 102, '2014-05-28 12:26:41'),
(55, 28, 102, '2014-05-28 12:26:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control_views`
--

DROP TABLE IF EXISTS `control_views`;
CREATE TABLE IF NOT EXISTS `control_views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `communication_id` int(11) NOT NULL,
  `sender_user_id` int(11) NOT NULL,
  `receive_user_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla que contiene por las personas que han leido una comuni' AUTO_INCREMENT=63 ;

--
-- Volcado de datos para la tabla `control_views`
--

INSERT INTO `control_views` (`id`, `communication_id`, `sender_user_id`, `receive_user_id`, `created`) VALUES
(6, 6, 45, 43, '2014-02-13 11:12:26'),
(7, 1, 47, 46, '2014-03-21 10:06:54'),
(11, 9, 47, 46, '2014-04-04 09:56:27'),
(13, 10, 47, 46, '2014-04-04 12:52:03'),
(14, 5, 44, 43, '2014-04-09 11:51:54'),
(28, 17, 102, 45, '2014-05-09 09:28:06'),
(29, 17, 102, 45, '2014-05-09 09:28:06'),
(31, 17, 102, 109, '2014-05-09 09:46:25'),
(35, 17, 109, 86, '2014-05-09 09:48:10'),
(36, 17, 102, 86, '2014-05-09 09:48:10'),
(38, 18, 109, 86, '2014-05-09 09:48:24'),
(41, 18, 109, 102, '2014-05-09 09:49:41'),
(44, 18, 109, 45, '2014-05-09 09:50:48'),
(47, 18, 102, 45, '2014-05-09 09:50:48'),
(48, 18, 102, 45, '2014-05-09 09:50:48'),
(49, 19, 102, 86, '2014-05-12 11:08:58'),
(50, 19, 102, 45, '2014-05-12 11:10:16'),
(51, 18, 102, 86, '2014-05-12 11:13:13'),
(52, 20, 102, 45, '2014-05-12 11:13:55'),
(53, 13, 43, 50, '2014-05-23 11:12:48'),
(54, 21, 50, 51, '2014-05-23 11:13:46'),
(56, 29, 45, 86, '2014-05-28 11:33:05'),
(57, 29, 45, 109, '2014-05-28 12:20:57'),
(58, 29, 86, 109, '2014-05-28 12:20:57'),
(59, 29, 45, 102, '2014-05-28 12:23:52'),
(60, 29, 86, 102, '2014-05-28 12:23:52'),
(61, 29, 109, 102, '2014-05-28 12:23:52'),
(62, 28, 45, 102, '2014-05-28 12:25:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entities`
--

DROP TABLE IF EXISTS `entities`;
CREATE TABLE IF NOT EXISTS `entities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `active` int(11) NOT NULL,
  `website` varchar(127) CHARACTER SET utf8 DEFAULT NULL,
  `lft` int(11) NOT NULL,
  `rght` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=181 ;

--
-- Volcado de datos para la tabla `entities`
--

INSERT INTO `entities` (`id`, `name`, `description`, `active`, `website`, `lft`, `rght`, `parent_id`, `order`) VALUES
(1, 'Entidades', 'nada', 1, NULL, 1, 348, 0, NULL),
(57, '(AIG) Autoridad Nacional para la Innovación Gubernamental', 'La Autoridad Nacional para la Innovación Gubernamental, es la entidad responsable de la modernización del Estado, mediante el uso de las Tecnologías de Información y Comunicaciones (TICs).\n\nProyectos como la Red Internet para Todos (RNI), la operación del 3-1-1 y del Centro de Atención Ciudadana, el sistema informático que respalda la implantación del Sistema Penal Acusatorio (SPA), los trámites electrónicos de los ciudadanos con el Estado, un Panamá Sin Papel (PSP), el despliegue de computadoras en las aulas de clases, los sistemas de citas médicas y expedientes electrónicos, las ventanillas únicas para la atención a los inversionistas y los exportadores, los nuevos sistemas para pasaportes, seguridad ciudadana, procesos aduanales y de finanzas públicas, son algunos ejemplos de los más de 142 proyectos que adelanta la Autoridad Nacional para la Innovación Gubernamental con el fin de dar servicios de calidad, con diligencia y transparencia a la ciudadanía.', 1, NULL, 126, 173, 1, 1),
(58, 'Consejo Nacional para la Innovación Gubernamental (CNIG)', '', 1, NULL, 127, 172, 57, NULL),
(59, 'Administrador General', '', 1, NULL, 128, 171, 58, NULL),
(60, 'Oficina de Asesoría Legal', '', 1, NULL, 129, 142, 59, NULL),
(61, 'Oficina de Cooperación Internacional', '', 1, NULL, 143, 144, 59, NULL),
(62, 'Oficina de Auditoría Interna', '', 0, NULL, 145, 146, 59, NULL),
(63, 'Oficina de Fiscalización de la Contraloría General', '', 1, NULL, 147, 148, 59, NULL),
(64, 'Oficina de Fiscalización de la Contraloría General', '', 0, NULL, 149, 150, 59, NULL),
(65, 'Dirección de Finanzas', '', 1, NULL, 151, 152, 59, NULL),
(66, 'Dirección de Administración Ejecutiva', '', 1, NULL, 153, 154, 59, NULL),
(67, 'Dirección Nacional Arquitectura Tecnológica', '', 1, NULL, 155, 156, 59, NULL),
(68, 'Dirección Nacional Innovación Gubernamental', '', 1, NULL, 157, 158, 59, NULL),
(69, 'Dirección Nacional Gobierno Digital', '', 1, NULL, 159, 160, 59, NULL),
(70, 'Dirección Nacional Tecnología y Transformación', '', 1, NULL, 161, 162, 59, NULL),
(71, 'Dirección Tecnológica y Sistemas', '', 1, NULL, 163, 164, 59, NULL),
(72, 'Dirección ITI', '', 1, NULL, 165, 166, 59, NULL),
(73, 'Dirección RNI', '', 1, NULL, 167, 168, 59, NULL),
(74, 'Dirección Atención Ciudadana 311', '', 1, NULL, 169, 170, 59, NULL),
(75, 'Ministerio de Economía y Finanzas (MEF)', 'El Ministerio de Economía y Finanzas, conocido por sus siglas como MEF, inicia su vida institucional en los primeros años de historia republicana, debido a que es el resultado de la integración del Ministerio de Hacienda y Tesoro y del Ministerio de Planificación y Política Económica.\n\nDe parte del Ministerio de Hacienda y Tesoro su creación se origina el 12 de noviembre de 1903, cuando la Junta Provisional de Gobierno, conformada por José Agustín Arango, Tomás Arias y Manuel Espinosa Batista, firman el decreto ejecutivo número 1 que reglamenta el servicio del Ministerio de Hacienda, siendo su primer ministro, Manuel Encarnación Amador. En ese primer momento patrio lo que se buscaba era organizar las estructuras del estado, en aspectos como los ingresos, el cobro de los impuestos comerciales, de licores, la renta por importación del opio y los juegos de suerte y azar. Así como hacerle frente a las abruptas transformaciones que encaraba el país debido al reinicio de los trabajos de excavación del canal interoceánico. Noventa y cinco años después orientado a la política fiscal y financiera del país, administrando el sistema tributario y el régimen aduanero de la República , así como custodiando los bienes nacionales, el Ministerio de Hacienda y Tesoro, dio el paso siguiente de su modernización y tecnificación.\n\nPor parte del Ministerio de Planificación y Política Económica, conocido por sus siglas como MIPPE, la historia es más reciente. Es hasta que se organiza el despacho de la Presidencia de la República el 16 de noviembre de 1956 que se crea el Departamento de Planificación, que dos años más tarde conforma el Ministerio de la Presidencia. Un año después, en 1959, se crea la Dirección General de Planificación y Administración de la Presidencia y el Departamento de Planificación mediante los decretos leyes 11 y 12, siendo su primer director el ingeniero David Samudio. En el proceso evolutivo y de desarrollo del país, la Dirección General de Planificación y Administración de la Presidencia requería ser una entidad planificadora, coordinadora y orientadora del desarrollo económico y social del país para que por la vía del fortalecimiento y diversificación de la producción y el desarrollo regional, se acrecentara la riqueza y el ingreso nacional en beneficio de todos los panameños. Así se crea mediante la Ley N °.16 de 28 de febrero de 1973 el Ministerio de Planificación y Política Económica. Fue su primer ministro, Nicolás Ardito Barletta.\n\nPor 25 años el MIPPE preparó los planes nacionales de desarrollo económico y social, diseñó y formuló las políticas económicas y sociales, coordinó los programas de desarrollo, dirigió la administración presupuestaria, organizó la administración de personal, gestionó y negoció el financiamiento externo, la cooperación técnica y administró los fondos del Gobierno Nacional, hasta que se transforman sus funciones para hacer el manejo administrativo gubernamental de la cosa pública más eficiente y eficaz. A finales de 1998 las transformaciones requeridas tanto por el Ministerio de Hacienda y Tesoro, como de Planificación y Política Económica toma forma ante la Asamblea Legislativa y mediante la Ley 97 de 21 de diciembre se aprueba la creación del Ministerio de Economía y Finanzas, oficializándose la fusión de los Ministerios de Planificación y Política Económica y de Hacienda y Tesoro. El Ministerio de Economía y Finanzas se crea con el propósito de transformar la Administración Pública y a fin de dar mayor coherencia e integralidad a la gestión financiera y presupuestaria del Estado, así como brindar una mayor definición y coordinación de las políticas económicas, fiscales y sociales. Su primer ministro fue Fernando Aramburu Porras.\n\nEl Ministerio de Economía y Finanzas (MEF) tiene a su cargo todo lo relacionado a la formulación de iniciativas en materia de política económica; la programación de las inversiones públicas y la estrategia social, el diseño y ejecución de las directrices generales y las tareas específicas del Gobierno sobre Hacienda y Tesorería Nacional; la elaboración, ejecución y control del Presupuesto General del Estado, Crédito Público y modernización del Estado, así como la elaboración y ejecución de la Programación .', 1, 'www.mef.gob.pa', 174, 249, 1, 3),
(76, 'Consejo de Coordinación Financiera de la República de Panamá', '', 0, NULL, 175, 176, 75, NULL),
(77, 'Ministro(a)', '', 1, NULL, 177, 178, 75, NULL),
(78, 'Consejo de Coordinación Financiera de la República de Panamá', '', 1, NULL, 179, 180, 75, NULL),
(79, 'Consejo Económico Nacional', '', 1, NULL, 181, 182, 75, NULL),
(80, 'Viceministerio de Economía', '', 1, NULL, 183, 212, 75, NULL),
(81, 'Viceministerio de Finanzas', '', 1, NULL, 213, 232, 75, NULL),
(82, 'Secretaría General', '', 1, NULL, 233, 234, 75, NULL),
(83, 'Oficina de Asesoría Legal', '', 1, NULL, 235, 236, 75, NULL),
(84, 'Oficina de Relaciones Públicas', '', 1, NULL, 237, 238, 75, NULL),
(85, 'Oficina de Auditoría Interna', '', 1, NULL, 239, 240, 75, NULL),
(86, 'Oficina de Fiscalización de la Contraloría General de la República', '', 1, NULL, 241, 242, 75, NULL),
(87, 'Dirección de Administración y Finanzas', '', 1, NULL, 243, 244, 75, NULL),
(88, 'Dirección de Tecnología e Informática', '', 1, NULL, 245, 246, 75, NULL),
(89, 'Oficina Institucional de Recursos Humanos', '', 1, NULL, 247, 248, 75, NULL),
(90, 'Fondo de Preinversión', '', 1, NULL, 184, 185, 80, NULL),
(91, 'Comisión Mixta para Centro América', '', 1, NULL, 186, 187, 80, NULL),
(92, 'Comisión Arancelería', '', 1, NULL, 188, 189, 80, NULL),
(93, 'Secretaría Técnica del Consejo Económico Nacional', '', 1, NULL, 190, 191, 80, NULL),
(94, 'Secretaría Ejecutiva del Fondo de Preinversión', '', 1, NULL, 192, 193, 80, NULL),
(95, 'Secretaría Ejecutiva de la Junta de Controles de Juegos', '', 1, NULL, 194, 195, 80, NULL),
(96, 'Unidad Coordinadora para Centro América', '', 1, NULL, 196, 197, 80, NULL),
(97, 'Dirección de Presupuesto de la Nación', '', 1, NULL, 198, 199, 80, NULL),
(98, 'Dirección de Políticas Públicas', '', 1, NULL, 200, 201, 80, NULL),
(99, 'Dirección de Gestión Administrativa de Proyectos', '', 1, NULL, 202, 203, 80, NULL),
(100, 'Dirección de Análisis Económico y Social ', '', 1, NULL, 204, 205, 80, NULL),
(101, 'Dirección de Cooperación Técnica Internacional', '', 1, NULL, 206, 207, 80, NULL),
(102, 'Dirección de Planificación Regional', '', 1, NULL, 208, 209, 80, NULL),
(103, 'Dirección de Programación de Inversiones', '', 1, NULL, 210, 211, 80, NULL),
(104, 'Dirección de Proyectos Especiales', '', 1, NULL, 214, 215, 81, NULL),
(105, 'Unidad de Adquisición y Contratación del Estado', '', 1, NULL, 216, 217, 81, NULL),
(106, 'Unidad Administrativa de Bienes Revertidos', '', 1, NULL, 218, 219, 81, NULL),
(107, 'Dirección de Tesorería', '', 1, NULL, 220, 221, 81, NULL),
(108, 'Dirección General de Ingresos', '', 1, NULL, 222, 223, 81, NULL),
(109, 'Dirección Nacional de Contabilidad', '', 1, NULL, 224, 225, 81, NULL),
(110, 'Dirección de Bienes Patrimoniales del Estado', '', 1, NULL, 226, 227, 81, NULL),
(111, 'Dirección de Crédito Público', '', 1, NULL, 228, 229, 81, NULL),
(112, 'Dirección de Inversiones, Concesiones y Riesgos del Estado', '', 1, NULL, 230, 231, 81, NULL),
(116, 'Entidad Prueba', 'pruebas', 1, 'http://www.hola.com', 14, 15, 115, NULL),
(117, 'Despacho 2', 'xxx', 1, 'http://www.hola.com', 33, 36, 3, NULL),
(118, 'Entidad A', 'pruebas', 1, 'http://www.hola.com', 34, 35, 117, NULL),
(119, 'Entidad Prueba', 'tests', 1, 'http://www.hola.com', 29, 30, 56, NULL),
(120, 'despacho temporal', 'para borrarlo....', 0, 'http://www.aig.com', 21, 22, 2, NULL),
(121, 'Ministerio para borrar', 'xxx', 0, 'http://www.ministerio.com', 254, 255, 1, NULL),
(122, 'Prueba C', 'descripcion de la prueba A', 1, 'http://www.jehogo.com', 23, 24, 2, NULL),
(123, 'ENTIDAD TEST-BORRAR', 'pruebas de entidades', 1, 'http://www.test.com', 256, 263, 1, 2),
(124, 'subentidad', 'test', 1, 'http://www.test.com', 257, 258, 123, NULL),
(125, 'subentidad2', 'desc', 0, 'http://www.test.com', 259, 262, 123, NULL),
(126, 'ent3', '', 1, 'http://www.test.com', 260, 261, 125, NULL),
(127, 'Departamento de Finanzas', '', 0, 'http://www.fin.gob.pa', 130, 131, 60, NULL),
(128, 'Departamento de Finanzas', '', 0, 'http://www.fin.gob.pa', 132, 133, 60, NULL),
(129, 'Departamento de Finanzas', '', 0, 'http://www.fin.gob.pa', 134, 135, 60, NULL),
(130, 'Departamento de Finanzas', '', 0, 'http://www.fin.gob.pa', 136, 137, 60, NULL),
(131, 'Departamento de Finanzas', '', 0, 'http://www.fin.gob.pa', 138, 139, 60, NULL),
(132, 'prueba', '', 0, 'http://www.prueba.com', 140, 141, 60, NULL),
(133, 'AIG 2', '', 0, 'http://www.aig.com', 353, 358, 0, NULL),
(134, 'dep 1', '', 1, 'http://www.dep.com', 354, 355, 133, NULL),
(135, 'dep 2', '', 0, 'http://www.dep2.com', 356, 357, 133, NULL),
(136, 'Autoridad Nacional para la Innovación Gubernamental', '', 1, 'http://www.innovacion.gob.pa', 264, 345, 1, 5),
(137, 'Administración General', 'Planificar y coordinar los planes, programas, proyectos, actividades administrativas, financieras y operacionales que se desarrollan en la entidad.', 1, 'http://www.innovacion.gob.pa', 265, 266, 136, 1),
(138, 'Administración General', 'Planificar y coordinar los planes, programas, proyectos, actividades administrativas, financieras y operacionales que se desarrollan en la entidad.', 0, 'http://www.innovacion.gob.pa', 267, 268, 136, NULL),
(139, 'Oficina de Asesoría Legal', '', 1, 'http://www.innovacion.gob.pa', 269, 270, 136, 3),
(140, 'Oficina de Asistencia Técnica internacional', '', 1, 'http://www.innovacion.gob.pa', 271, 272, 136, 2),
(141, 'Oficina de Auditoría Interna', '', 1, 'http://www.innovacion.gob.pa', 273, 274, 136, 4),
(142, 'Dirección Nacional de Administración Ejecutiva', '', 1, 'http://www.innovacion.gob.pa', 275, 286, 136, 5),
(143, 'Oficina de Relaciones Públicas', '', 1, 'http://www.innovacion.gob.pa', 276, 277, 142, NULL),
(144, 'Oficina Institucional de Recursos Humanos', '', 1, 'http://www.innovacion.gob.pa', 278, 279, 142, NULL),
(145, 'Departamento de Servicios Generales', '', 1, 'http://www.innovacion.gob.pa', 280, 281, 142, NULL),
(146, 'Departamento de Compras', '', 1, 'http://www.innovacion.gob.pa', 282, 283, 142, NULL),
(147, 'Departamento de Seguridad', '', 1, 'http://www.innovacion.gob.pa', 284, 285, 142, NULL),
(148, 'Dirección Nacional de Finanzas', '', 1, 'http://www.innovacion.gob.pa', 287, 294, 136, 6),
(149, 'Departamento de Contabilidad', '', 1, 'http://www.innovacion.gob.pa', 288, 289, 148, 2),
(150, 'Departamento de Planificación y Estudios Económicos', '', 1, 'http://www.innovacion.gob.pa', 290, 291, 148, 3),
(151, 'Departamento de Tesorería', '', 1, 'http://www.innovacion.gob.pa', 292, 293, 148, 4),
(152, 'Dirección Nacional de Tecnología', '', 1, 'http://www.innovacion.gob.pa', 295, 298, 136, 7),
(153, 'Oficina AIG sin Papel', '', 1, 'http://www.innovacion.gob.pa', 296, 297, 152, NULL),
(154, 'Dirección Nacional de Innovación Gubernamental', '', 1, 'http://www.innovacion.gob.pa', 299, 306, 136, 8),
(155, 'Oficina de Panamá Sin Papel (PSP)', '', 1, 'http://www.innovacion.gob.pa', 300, 301, 154, NULL),
(156, 'Oficina de Gobiernos Locales', '', 1, 'http://www.innovacion.gob.pa', 302, 303, 154, NULL),
(157, 'Oficina de Sistema Penal Acusatorio (SPA)', '', 1, 'http://www.innovacion.gob.pa', 304, 305, 154, NULL),
(158, 'Dirección Nacional de Tecnología y Transformación', '', 1, 'http://www.innovacion.gob.pa', 307, 318, 136, 9),
(159, 'Departamento de Seguridad ITI y Virtualización', '', 1, 'http://www.innovacion.gob.pa', 308, 309, 158, NULL),
(160, 'Departamento de Telecomunicaciones', '', 1, 'http://www.innovacion.gob.pa', 310, 311, 158, NULL),
(161, 'Departamento de Red Nacional Multiservicios (RMS)', '', 1, 'http://www.innovacion.gob.pa', 312, 313, 158, NULL),
(162, 'Red Nacional de Internet', '', 1, 'http://www.internetparatodos.gob.pa', 314, 315, 158, NULL),
(163, 'Junta Asesora (JAS)', '', 1, 'http://www.innovacion.gob.pa', 316, 317, 158, NULL),
(164, 'Dirección Nacional de Gobierno Digital', '', 1, 'http://www.innovacion.gob.pa', 319, 324, 136, 10),
(165, 'Proyectos Institucionales', '', 1, 'http://www.innovacion.gob.pa', 320, 321, 164, NULL),
(166, 'Instituto de Tecnología e Innovación', '', 1, 'http://www.innovacion.gob.pa', 322, 323, 164, NULL),
(167, 'Dirección Nacional de Arquitectura Tecnológica', '', 1, 'http://www.innovacion.gob.pa', 325, 334, 136, 11),
(168, 'Departamento de Investigación y Desarrollo Tecnológico', '', 1, 'http://www.innovacion.gob.pa', 326, 327, 167, NULL),
(169, 'Departamento de Tecnologías Aplicadas', '', 1, 'http://www.innovacion.gob.pa', 328, 329, 167, NULL),
(170, 'Departamento de Compras Tecnológicas', '', 1, 'http://www.innovacion.gob.pa', 330, 331, 167, NULL),
(171, 'Centros Tecnológicos', '', 1, 'http://www.innovacion.gob.pa', 332, 333, 167, NULL),
(172, 'Centro de Atención Ciudadana (311)', '', 1, 'http://www.innovacion.gob.pa', 335, 340, 136, 12),
(173, 'Departamento de Operaciones', '', 1, 'http://www.innovacion.gob.pa', 336, 337, 172, NULL),
(174, 'Departamento de Comunicaciones y Seguridad', '', 1, 'http://www.innovacion.gob.pa', 338, 339, 172, NULL),
(175, 'Oficina de Fiscalización de la República ', '', 1, 'http://www.innovacion.gob.pa', 341, 342, 136, 13),
(176, 'aig_test', '', 0, 'http://http://www.aig.com', 349, 350, 0, NULL),
(177, 'test311', '', 0, 'http://http://www.311.com', 351, 352, 0, NULL),
(178, 'Ministerio de la Presidencia', '', 1, 'http://www.presidencia.gob.pa', 346, 347, 1, 4),
(179, 'finanzas test', 'xxx', 0, 'http://www.xxx.com', 359, 360, 0, 1),
(180, 'TEST xxx', 'PRUEBA', 1, 'http://www.xxx.com', 343, 344, 136, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formats`
--

DROP TABLE IF EXISTS `formats`;
CREATE TABLE IF NOT EXISTS `formats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `upload_id` int(11) DEFAULT NULL,
  `communication_type_id` int(11) DEFAULT NULL,
  `communication_category_id` int(11) DEFAULT NULL,
  `name` varchar(127) DEFAULT NULL,
  `visible` int(11) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `formats`
--

INSERT INTO `formats` (`id`, `upload_id`, `communication_type_id`, `communication_category_id`, `name`, `visible`, `created`, `modified`) VALUES
(1, 14, 3, 3, 'Formulario Viático al Exterior', 1, '2014-02-06 17:09:59', '2014-04-29 12:42:06'),
(2, 15, 3, 5, 'Solicitud de Autorización', 1, '2014-02-06 17:11:01', '2014-04-29 12:42:31'),
(3, 16, 3, 3, 'Gestión de Cobro', 1, '2014-04-24 15:34:27', '2014-04-29 12:42:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) DEFAULT NULL,
  `active` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Volcado de datos para la tabla `groups`
--

INSERT INTO `groups` (`id`, `name`, `active`) VALUES
(1, 'Ministros', 1),
(2, 'Administradores Generales', 1),
(3, 'Directores Generales', 1),
(4, 'Alcaldes', 1),
(5, 'Gobernadores', 1),
(6, 'Diputados', 1),
(7, 'Procuradores', 1),
(8, 'Representantes', 1),
(9, 'Jefes / Directores de Tecnología', 1),
(10, 'Jefes de OIRH', 1),
(11, 'Directores de Administración y Finanzas', 1),
(12, 'Directores Operativos', 1),
(13, 'Administradores de la Plataforma', 1),
(14, 'Usuario Final', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_tokens`
--

DROP TABLE IF EXISTS `login_tokens`;
CREATE TABLE IF NOT EXISTS `login_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` char(32) NOT NULL,
  `duration` varchar(32) NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `private` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Volcado de datos para la tabla `messages`
--

INSERT INTO `messages` (`id`, `title`, `content`, `private`, `created`, `modified`) VALUES
(1, 'Mensaje prueba', 'Buenas.<div>Este es un mensaje de prueba</div>', 0, '2014-02-06 16:28:54', '2014-02-06 16:28:54'),
(2, 'Mensaje prueba', 'Probando aprobado.', 0, '2014-02-06 17:04:50', '2014-02-06 17:04:50'),
(3, 'prueba de mensaje para borrar', 'hola', 0, '2014-02-08 10:11:29', '2014-02-08 10:11:29'),
(4, 'borrar esto ', 'este mensaje sera borrado', 0, '2014-02-08 10:30:31', '2014-02-08 10:30:31'),
(5, 'aprobar', 'favor aprobar', 0, '2014-02-12 16:11:17', '2014-02-12 16:11:17'),
(6, 'aprobar', 'aprobado!', 0, '2014-02-12 16:11:48', '2014-02-12 16:11:48'),
(7, 'Prueba', '', 0, '2014-02-13 10:47:17', '2014-02-13 10:47:17'),
(8, 'Circular para Gobierno', 'Confirmar Circular adjunta<br>', 0, '2014-02-13 11:11:25', '2014-02-13 11:11:25'),
(9, 'Circular para Gobierno', 'Excelente, mandalo', 0, '2014-02-13 11:12:09', '2014-02-13 11:12:09'),
(10, 'Prueba', 'aprobado', 0, '2014-03-21 11:11:16', '2014-03-21 11:11:16'),
(11, 'Mensaje prueba', 'Buenas.<div>Este es un mensaje de prueba</div>', 0, '2014-03-25 15:26:14', '2014-03-25 15:26:14'),
(12, 'sobre firmas', 'esto tiene un doc con firma', 0, '2014-04-04 09:45:42', '2014-04-04 09:45:42'),
(13, 'sobre firmas', 'listo agrego ahora', 0, '2014-04-04 09:49:42', '2014-04-04 09:49:42'),
(14, 'saludo', 'saludo', 0, '2014-04-04 09:54:51', '2014-04-04 09:54:51'),
(15, 'saludo', '', 0, '2014-04-04 09:57:47', '2014-04-04 09:57:47'),
(16, 'documento firmado', 'esto tiene un documento', 0, '2014-04-04 12:46:31', '2014-04-04 12:46:31'),
(17, 'documento firmado', 'respondo', 0, '2014-04-04 12:50:18', '2014-04-04 12:50:18'),
(18, 'PROPUESTA PARA APROBACIÓN', 'ADJUNTO PROPUESTA PARA LA IMPLEMENTACION DE UN SISTEMA DE GESTION DE COBRO PARA LA AUTORIDAD NACIONAL DE INNOVACION GUBERNAMENTAL.<div><br></div><div>FAVOR REVISAR EL DOCUMENTO PARA SU DEBIDA APROBACIÓN.</div>', 0, '2014-04-09 11:55:11', '2014-04-09 11:55:11'),
(19, 'INVITACION A CONFERENCIA DE INNOVACION TECNOLOGIA', 'LE INVITAMOS A PARTICIPAR EN ESTA CONFERENCIA QUE SE REALIZARÁ EN EL HOTEL SHERATON EL DÍA 11 DE MARZO DE 2014.<div><br></div><div>AGRADECEMOS CONFIRMAR SU ASISTENCIA.</div>', 0, '2014-04-11 16:41:48', '2014-04-11 16:41:48'),
(20, 'Prueba ', 'Prueba', 0, '2014-04-16 11:31:03', '2014-04-16 11:31:03'),
(21, 'Prueba de formulario', 'Adjunto formulario de viático al extranjero para su aprobación.', 0, '2014-04-24 15:53:04', '2014-04-24 15:53:04'),
(22, 'Aplicación del Sistema de Gestión de Cobro', '', 0, '2014-05-05 12:04:24', '2014-05-05 12:04:24'),
(23, 'Prueba de Correspondencia', 'Solicito aprobación para la Implementación en la AIG del sistema de correspondencia estatal.', 0, '2014-05-06 07:56:06', '2014-05-06 07:56:06'),
(24, 'Aprobación de Resolución de Consejo Nacional de Innovación', '', 1, '2014-05-09 09:18:38', '2014-05-09 09:18:38'),
(25, 'Aprobación de Resolución de Consejo Nacional de Innovación', 'Esto en una prueba hay que modificarlo', 0, '2014-05-09 09:22:49', '2014-05-09 09:22:49'),
(26, 'Aprobación de Resolución de Consejo Nacional de Innovación', 'No tengo Comentarios', 0, '2014-05-09 09:26:40', '2014-05-09 09:26:40'),
(27, 'Aprobación de Resolución de Consejo Nacional de Innovación', 'me parece bien la Resolución', 0, '2014-05-09 09:27:27', '2014-05-09 09:27:27'),
(28, 'Aprobación de Resolución de Consejo Nacional de Innovación', '', 0, '2014-05-09 09:45:31', '2014-05-09 09:45:31'),
(29, 'Aprobación de Resolución de Consejo Nacional de Innovación', '', 0, '2014-05-09 09:47:21', '2014-05-09 09:47:21'),
(30, 'Aprobación de Resolución de Consejo Nacional de Innovación', '', 0, '2014-05-09 09:48:46', '2014-05-09 09:48:46'),
(31, 'Aprobación de Resolución de Consejo Nacional de Innovación', '', 0, '2014-05-09 09:50:04', '2014-05-09 09:50:04'),
(32, 'Nueva Plataforma de Correspondencia', 'Adjunto la Normativa para el uso de la Plataforma de Correspondencia Estatal', 0, '2014-05-12 11:08:24', '2014-05-12 11:08:24'),
(33, 'prueba de Plataforma', '', 0, '2014-05-12 11:11:48', '2014-05-12 11:11:48'),
(34, 'Hola', 'Saludo', 0, '2014-05-23 11:11:46', '2014-05-23 11:11:46'),
(35, 'Responde aca por favor', 'Saludo', 0, '2014-05-23 12:25:51', '2014-05-23 12:25:51'),
(36, 'mensaje', 'ViAJE!!!!!', 0, '2014-05-23 12:37:38', '2014-05-23 12:37:38'),
(37, 'prueba', 'Hola', 0, '2014-05-23 12:39:24', '2014-05-23 12:39:24'),
(38, 'hola', 'xxxxxxxxxxxxx', 0, '2014-05-23 12:44:29', '2014-05-23 12:44:29'),
(39, 'xxx', 'xxx', 0, '2014-05-23 12:47:57', '2014-05-23 12:47:57'),
(40, 'Aprobación de Resolución', 'Esto es una resolución de Prueba de la Plataforma', 0, '2014-05-23 15:50:35', '2014-05-23 15:50:35'),
(41, 'Prueba de Firma Digital', 'esto es una prueba a la resolución', 0, '2014-05-28 11:25:28', '2014-05-28 11:25:28'),
(42, 'Prueba de Aprobación', 'Esto es una prueba para aprobaciones múltiples', 0, '2014-05-28 11:31:48', '2014-05-28 11:31:48'),
(43, 'Prueba de Aprobación', '', 0, '2014-05-28 12:09:08', '2014-05-28 12:09:08'),
(44, 'Prueba de Aprobación', '', 0, '2014-05-28 12:23:20', '2014-05-28 12:23:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `redirections`
--

DROP TABLE IF EXISTS `redirections`;
CREATE TABLE IF NOT EXISTS `redirections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `redirections`
--

INSERT INTO `redirections` (`id`, `from_user_id`, `to_user_id`) VALUES
(4, 43, 45);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) NOT NULL,
  `communication_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Volcado de datos para la tabla `tags`
--

INSERT INTO `tags` (`id`, `name`, `communication_id`, `user_id`, `created`, `modified`) VALUES
(1, 'importante', 1, 43, '2014-01-06 16:54:52', '2014-01-06 16:54:52'),
(2, 'importante', 1, 46, '2014-02-06 16:28:54', '2014-02-06 16:28:54'),
(3, 'importante', 2, 46, '2014-02-08 10:11:29', '2014-02-08 10:11:29'),
(4, 'importante', 3, 46, '2014-02-08 10:30:31', '2014-02-08 10:30:31'),
(5, 'Tema que conversamos en el almuerzo', 5, 43, '2014-02-13 10:47:17', '2014-02-13 10:47:17'),
(6, 'Carnavales', 6, 43, '2014-02-13 11:11:25', '2014-02-13 11:11:25'),
(7, 'pruebas', 1, 46, '2014-03-21 10:07:11', '2014-03-21 10:07:11'),
(8, 'importante', 8, 46, '2014-04-04 09:45:43', '2014-04-04 09:45:43'),
(9, 'importante', 10, 46, '2014-04-04 12:46:31', '2014-04-04 12:46:31'),
(10, 'importante', 11, 43, '2014-04-09 11:55:11', '2014-04-09 11:55:11'),
(11, 'Correspondencia', 16, 45, '2014-05-06 07:56:06', '2014-05-06 07:56:06'),
(12, 'Resolución', 17, 45, '2014-05-09 09:18:38', '2014-05-09 09:18:38'),
(13, 'Resolución', 18, 45, '2014-05-09 09:45:31', '2014-05-09 09:45:31'),
(14, 'Plataforma de Cprrespondencia', 19, 102, '2014-05-12 11:08:24', '2014-05-12 11:08:24'),
(15, 'Prueba a Plataforma', 20, 102, '2014-05-12 11:11:48', '2014-05-12 11:11:48'),
(16, 'tests', 21, 50, '2014-05-23 11:11:46', '2014-05-23 11:11:46'),
(17, 'tests', 22, 50, '2014-05-23 12:25:51', '2014-05-23 12:25:51'),
(18, 'test', 23, 51, '2014-05-23 12:37:38', '2014-05-23 12:37:38'),
(19, 'test', 24, 51, '2014-05-23 12:39:24', '2014-05-23 12:39:24'),
(20, 'Aprobación de Resolución No.2014', 27, 45, '2014-05-23 15:50:35', '2014-05-23 15:50:35'),
(21, 'Resolución Prueba', 28, 45, '2014-05-28 11:25:28', '2014-05-28 11:25:28');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=93 ;

--
-- Volcado de datos para la tabla `traces`
--

INSERT INTO `traces` (`id`, `communication_id`, `message_id`, `sender_user_id`, `receive_user_id`, `sender_entity_id`, `receive_entity_id`, `read`, `read_datatime`, `created`, `modified`, `type_delivery`, `requires_approval`, `approval`) VALUES
(1, 1, 1, 46, 47, 93, 78, 1, '2014-02-06 17:03:55', '2014-02-06 16:28:54', '2014-02-06 16:28:54', 0, 1, 0),
(2, 1, 2, 47, 46, 78, 93, 1, '2014-03-25 15:25:51', '2014-02-06 17:04:50', '2014-02-06 17:04:50', 0, 0, 1),
(3, 2, 3, 46, 47, 93, 78, 0, NULL, '2014-02-08 10:11:29', '2014-02-08 10:11:29', 0, 0, 0),
(4, 3, 4, 46, 47, 93, 78, 1, '2014-02-08 10:31:32', '2014-02-08 10:30:31', '2014-02-08 10:30:31', 0, 0, 0),
(5, 4, 5, 44, 43, 88, 71, 1, '2014-02-13 10:52:09', '2014-02-12 16:11:17', '2014-02-12 16:11:17', 0, 0, 0),
(6, 4, 6, 43, 44, 71, 88, 1, '2014-03-21 11:22:53', '2014-02-12 16:11:49', '2014-02-12 16:11:49', 0, 0, 0),
(7, 5, 7, 43, 44, 71, 88, 1, '2014-03-21 11:18:21', '2014-02-13 10:47:17', '2014-02-13 10:47:17', 0, 1, 0),
(8, 6, 8, 43, 45, 71, 57, 1, '2014-02-13 11:11:40', '2014-02-13 11:11:25', '2014-02-13 11:11:25', 0, 1, 0),
(9, 6, 9, 45, 43, 57, 71, 1, '2014-02-13 11:12:26', '2014-02-13 11:12:09', '2014-02-13 11:12:09', 0, 0, 1),
(10, 5, 10, 44, 43, 88, 71, 1, '2014-04-09 11:52:12', '2014-03-21 11:11:16', '2014-03-21 11:11:16', 0, 0, 1),
(11, 7, 11, 46, 47, 93, 78, 0, NULL, '2014-03-25 15:26:14', '2014-03-25 15:26:14', 0, 0, 0),
(12, 8, 12, 46, 47, 93, 78, 1, '2014-04-04 09:53:26', '2014-04-04 09:45:43', '2014-04-04 09:45:43', 0, 0, 0),
(13, 8, 13, 47, 46, 78, 93, 1, '2014-04-04 09:50:50', '2014-04-04 09:49:42', '2014-04-04 09:49:42', 0, 0, 0),
(14, 9, 14, 47, 46, 78, 93, 1, '2014-04-04 10:08:25', '2014-04-04 09:54:51', '2014-04-04 09:54:51', 0, 0, 0),
(15, 9, 15, 46, 47, 93, 78, 0, NULL, '2014-04-04 09:57:47', '2014-04-04 09:57:47', 0, 0, 0),
(16, 10, 16, 46, 47, 93, 78, 1, '2014-04-04 12:47:36', '2014-04-04 12:46:31', '2014-04-04 12:46:31', 0, 0, 0),
(17, 10, 17, 47, 46, 78, 93, 1, '2014-04-04 12:52:03', '2014-04-04 12:50:18', '2014-04-04 12:50:18', 0, 0, 0),
(18, 11, 18, 43, 45, 71, 136, 1, '2014-05-23 10:40:17', '2014-04-09 11:55:11', '2014-04-09 11:55:11', 0, 1, -2),
(19, 12, 19, 43, 45, 71, 136, 0, NULL, '2014-04-11 16:41:48', '2014-04-11 16:41:48', 0, 0, 0),
(20, 13, 20, 43, 42, 71, 75, 0, NULL, '2014-04-16 11:31:03', '2014-04-16 11:31:03', 0, 0, 0),
(21, 13, 20, 43, 44, 71, 88, 1, '2014-04-16 11:31:56', '2014-04-16 11:31:03', '2014-04-16 11:31:03', 0, 0, 0),
(22, 13, 20, 43, 46, 71, 93, 0, NULL, '2014-04-16 11:31:03', '2014-04-16 11:31:03', 0, 0, 0),
(23, 13, 20, 43, 47, 71, 78, 0, NULL, '2014-04-16 11:31:03', '2014-04-16 11:31:03', 0, 0, 0),
(24, 13, 20, 43, 49, 71, 90, 0, NULL, '2014-04-16 11:31:03', '2014-04-16 11:31:03', 0, 0, 0),
(25, 13, 20, 43, 50, 71, 79, 1, '2014-05-23 11:12:48', '2014-04-16 11:31:03', '2014-04-16 11:31:03', 0, 0, 0),
(26, 14, 21, 43, 45, 71, 136, 0, NULL, '2014-04-24 15:53:04', '2014-04-24 15:53:04', 0, 0, 0),
(27, 15, 22, 45, 45, 136, 136, 1, '2014-05-23 10:43:00', '2014-05-05 12:04:24', '2014-05-05 12:04:24', 0, 1, -2),
(28, 15, 22, 45, 54, 136, 154, 0, NULL, '2014-05-05 12:04:24', '2014-05-05 12:04:24', 1, 1, -2),
(29, 16, 23, 45, 45, 136, 136, 0, NULL, '2014-05-06 07:56:06', '2014-05-06 07:56:06', 0, 1, -2),
(30, 16, 23, 45, 54, 136, 154, 0, NULL, '2014-05-06 07:56:06', '2014-05-06 07:56:06', 1, 1, -2),
(31, 17, 24, 45, 86, 136, 162, 1, '2014-05-09 09:48:11', '2014-05-09 09:18:38', '2014-05-09 09:18:38', 0, 0, 0),
(32, 17, 24, 45, 102, 136, 164, 1, '2014-05-09 09:27:40', '2014-05-09 09:18:38', '2014-05-09 09:18:38', 0, 0, 0),
(33, 17, 24, 45, 109, 136, 153, 1, '2014-05-09 09:46:25', '2014-05-09 09:18:38', '2014-05-09 09:18:38', 0, 0, 0),
(34, 17, 25, 86, 86, 162, 162, 1, '2014-05-09 09:48:11', '2014-05-09 09:22:49', '2014-05-09 09:22:49', 0, 0, 0),
(35, 17, 25, 86, 102, 162, 164, 1, '2014-05-09 09:27:40', '2014-05-09 09:22:50', '2014-05-09 09:22:50', 0, 0, 0),
(36, 17, 25, 86, 109, 162, 153, 1, '2014-05-09 09:46:25', '2014-05-09 09:22:50', '2014-05-09 09:22:50', 0, 0, 0),
(37, 17, 25, 86, 45, 162, 136, 1, '2014-05-09 09:28:57', '2014-05-09 09:22:50', '2014-05-09 09:22:50', 0, 0, 0),
(38, 17, 26, 109, 45, 153, 136, 1, '2014-05-09 09:28:57', '2014-05-09 09:26:40', '2014-05-09 09:26:40', 0, 0, 0),
(39, 17, 26, 109, 86, 153, 162, 1, '2014-05-09 09:48:11', '2014-05-09 09:26:40', '2014-05-09 09:26:40', 0, 0, 0),
(40, 17, 26, 109, 102, 153, 164, 1, '2014-05-09 09:27:40', '2014-05-09 09:26:40', '2014-05-09 09:26:40', 0, 0, 0),
(41, 17, 26, 109, 109, 153, 153, 1, '2014-05-09 09:46:25', '2014-05-09 09:26:40', '2014-05-09 09:26:40', 0, 0, 0),
(42, 17, 26, 109, 45, 153, 136, 1, '2014-05-09 09:28:57', '2014-05-09 09:26:40', '2014-05-09 09:26:40', 0, 0, 0),
(43, 17, 27, 102, 45, 164, 136, 1, '2014-05-09 09:28:57', '2014-05-09 09:27:27', '2014-05-09 09:27:27', 0, 0, 0),
(44, 17, 27, 102, 86, 164, 162, 1, '2014-05-09 09:48:11', '2014-05-09 09:27:27', '2014-05-09 09:27:27', 0, 0, 0),
(45, 17, 27, 102, 102, 164, 164, 1, '2014-05-09 09:27:40', '2014-05-09 09:27:27', '2014-05-09 09:27:27', 0, 0, 0),
(46, 17, 27, 102, 109, 164, 153, 1, '2014-05-09 09:46:25', '2014-05-09 09:27:27', '2014-05-09 09:27:27', 0, 0, 0),
(47, 17, 27, 102, 45, 164, 136, 1, '2014-05-09 09:28:57', '2014-05-09 09:27:27', '2014-05-09 09:27:27', 0, 0, 0),
(48, 18, 28, 45, 86, 136, 162, 1, '2014-05-12 11:13:13', '2014-05-09 09:45:31', '2014-05-09 09:45:31', 0, 1, -2),
(49, 18, 28, 45, 109, 136, 153, 1, '2014-05-09 09:47:27', '2014-05-09 09:45:31', '2014-05-09 09:45:31', 0, 1, -2),
(50, 18, 28, 45, 102, 136, 164, 1, '2014-05-09 09:50:16', '2014-05-09 09:45:31', '2014-05-09 09:45:31', 0, 1, -2),
(51, 18, 29, 109, 86, 153, 162, 1, '2014-05-12 11:13:13', '2014-05-09 09:47:21', '2014-05-09 09:47:21', 0, 0, 1),
(52, 18, 29, 109, 102, 153, 164, 1, '2014-05-09 09:50:16', '2014-05-09 09:47:21', '2014-05-09 09:47:21', 0, 0, 1),
(53, 18, 29, 109, 109, 153, 153, 1, '2014-05-09 09:47:27', '2014-05-09 09:47:21', '2014-05-09 09:47:21', 0, 0, 1),
(54, 18, 29, 109, 45, 153, 136, 1, '2014-05-09 10:19:45', '2014-05-09 09:47:21', '2014-05-09 09:47:21', 0, 0, 1),
(55, 18, 30, 86, 45, 162, 136, 1, '2014-05-09 10:19:45', '2014-05-09 09:48:46', '2014-05-09 09:48:46', 0, 0, -1),
(56, 18, 30, 86, 86, 162, 162, 1, '2014-05-12 11:13:13', '2014-05-09 09:48:46', '2014-05-09 09:48:46', 0, 0, -1),
(57, 18, 30, 86, 102, 162, 164, 1, '2014-05-09 09:50:16', '2014-05-09 09:48:46', '2014-05-09 09:48:46', 0, 0, -1),
(58, 18, 30, 86, 109, 162, 153, 0, NULL, '2014-05-09 09:48:46', '2014-05-09 09:48:46', 0, 0, -1),
(59, 18, 30, 86, 45, 162, 136, 1, '2014-05-09 10:19:45', '2014-05-09 09:48:46', '2014-05-09 09:48:46', 0, 0, -1),
(60, 18, 31, 102, 45, 164, 136, 1, '2014-05-09 10:19:45', '2014-05-09 09:50:04', '2014-05-09 09:50:04', 0, 0, 1),
(61, 18, 31, 102, 86, 164, 162, 1, '2014-05-12 11:13:13', '2014-05-09 09:50:04', '2014-05-09 09:50:04', 0, 0, 1),
(62, 18, 31, 102, 102, 164, 164, 1, '2014-05-09 09:50:16', '2014-05-09 09:50:04', '2014-05-09 09:50:04', 0, 0, 1),
(63, 18, 31, 102, 109, 164, 153, 0, NULL, '2014-05-09 09:50:04', '2014-05-09 09:50:04', 0, 0, 1),
(64, 18, 31, 102, 45, 164, 136, 1, '2014-05-09 10:19:45', '2014-05-09 09:50:04', '2014-05-09 09:50:04', 0, 0, 1),
(65, 19, 32, 102, 45, 164, 136, 1, '2014-05-12 11:10:16', '2014-05-12 11:08:24', '2014-05-12 11:08:24', 0, 0, 0),
(66, 19, 32, 102, 86, 164, 162, 1, '2014-05-12 11:08:59', '2014-05-12 11:08:24', '2014-05-12 11:08:24', 0, 0, 0),
(67, 20, 33, 102, 45, 164, 136, 1, '2014-05-12 11:13:55', '2014-05-12 11:11:48', '2014-05-12 11:11:48', 0, 0, 0),
(68, 21, 34, 50, 51, 79, 61, 1, '2014-05-23 11:13:46', '2014-05-23 11:11:46', '2014-05-23 11:11:46', 0, 0, 0),
(69, 22, 35, 50, 51, 79, 61, 0, NULL, '2014-05-23 12:25:51', '2014-05-23 12:25:51', 0, 0, 0),
(70, 23, 36, 51, 50, 61, 79, 0, NULL, '2014-05-23 12:37:38', '2014-05-23 12:37:38', 0, 0, 0),
(71, 24, 37, 51, 50, 61, 79, 0, NULL, '2014-05-23 12:39:24', '2014-05-23 12:39:24', 0, 0, 0),
(72, 25, 38, 51, 50, 61, 79, 0, NULL, '2014-05-23 12:44:29', '2014-05-23 12:44:29', 0, 0, 0),
(73, 26, 39, 51, 50, 61, 79, 0, NULL, '2014-05-23 12:47:57', '2014-05-23 12:47:57', 0, 0, 0),
(74, 27, 40, 45, 86, 137, 162, 1, '2014-05-28 11:35:13', '2014-05-23 15:50:35', '2014-05-23 15:50:35', 0, 1, -2),
(75, 27, 40, 45, 102, 137, 164, 0, NULL, '2014-05-23 15:50:35', '2014-05-23 15:50:35', 0, 1, -2),
(76, 27, 40, 45, 109, 137, 153, 0, NULL, '2014-05-23 15:50:35', '2014-05-23 15:50:35', 0, 1, -2),
(77, 27, 40, 45, 54, 137, 154, 0, NULL, '2014-05-23 15:50:35', '2014-05-23 15:50:35', 0, 1, -2),
(78, 28, 41, 45, 86, 137, 162, 0, NULL, '2014-05-28 11:25:28', '2014-05-28 11:25:28', 0, 1, -2),
(79, 28, 41, 45, 109, 137, 153, 0, NULL, '2014-05-28 11:25:38', '2014-05-28 11:25:38', 0, 1, -2),
(80, 28, 41, 45, 102, 137, 164, 1, '2014-05-28 12:26:05', '2014-05-28 11:25:45', '2014-05-28 11:25:45', 0, 1, -2),
(81, 29, 42, 45, 86, 137, 162, 1, '2014-05-28 12:07:28', '2014-05-28 11:31:48', '2014-05-28 11:31:48', 0, 1, -2),
(82, 29, 42, 45, 109, 137, 153, 1, '2014-05-28 12:21:10', '2014-05-28 11:31:55', '2014-05-28 11:31:55', 0, 1, -2),
(83, 29, 42, 45, 102, 137, 164, 1, '2014-05-28 12:26:41', '2014-05-28 11:32:03', '2014-05-28 11:32:03', 0, 1, -2),
(84, 29, 43, 86, 86, 162, 162, 0, NULL, '2014-05-28 12:09:08', '2014-05-28 12:09:08', 0, 0, 1),
(85, 29, 43, 86, 102, 162, 164, 1, '2014-05-28 12:26:41', '2014-05-28 12:09:08', '2014-05-28 12:09:08', 0, 0, 1),
(86, 29, 43, 86, 109, 162, 153, 1, '2014-05-28 12:21:10', '2014-05-28 12:09:08', '2014-05-28 12:09:08', 0, 0, 1),
(87, 29, 43, 86, 45, 162, 137, 0, NULL, '2014-05-28 12:09:08', '2014-05-28 12:09:08', 0, 0, 1),
(88, 29, 44, 109, 45, 153, 137, 0, NULL, '2014-05-28 12:23:20', '2014-05-28 12:23:20', 0, 0, 1),
(89, 29, 44, 109, 86, 153, 162, 0, NULL, '2014-05-28 12:23:20', '2014-05-28 12:23:20', 0, 0, 1),
(90, 29, 44, 109, 102, 153, 164, 1, '2014-05-28 12:26:41', '2014-05-28 12:23:20', '2014-05-28 12:23:20', 0, 0, 1),
(91, 29, 44, 109, 109, 153, 153, 0, NULL, '2014-05-28 12:23:20', '2014-05-28 12:23:20', 0, 0, 1),
(92, 29, 44, 109, 45, 153, 137, 0, NULL, '2014-05-28 12:23:20', '2014-05-28 12:23:20', 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `uploads`
--

DROP TABLE IF EXISTS `uploads`;
CREATE TABLE IF NOT EXISTS `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `message_id` int(11) DEFAULT NULL,
  `real_name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `temporal` int(11) DEFAULT NULL,
  `document` int(11) NOT NULL DEFAULT '0',
  `visible` int(11) NOT NULL DEFAULT '0',
  `description` varchar(127) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Volcado de datos para la tabla `uploads`
--

INSERT INTO `uploads` (`id`, `name`, `size`, `message_id`, `real_name`, `url`, `temporal`, `document`, `visible`, `description`) VALUES
(3, '2013-Ford-Mustang-GT-Track-Pack-front-view_0244295001395343652.jpg', 754039, NULL, '2013-Ford-Mustang-GT-Track-Pack-front-view.jpg', 'http://10.252.251.43/AIG_Mensajeria/webroot/files/2013-Ford-Mustang-GT-Track-Pack-front-view_0244295001395343652.jpg', 12466522, 0, 0, NULL),
(4, 'firmas_ejemplo_0024969001396619113.txt', 47, 12, 'firmas_ejemplo.txt', 'http://10.252.251.43/AIG_Mensajeria/webroot/files/firmas_ejemplo_0024969001396619113.txt', NULL, 0, 0, NULL),
(5, 'firmas_ejemplo_0736719001396619317.txt', 106, NULL, 'firmas_ejemplo.txt', 'http://10.252.251.43/AIG_Mensajeria/webroot/files/firmas_ejemplo_0736719001396619317.txt', 86389361, 0, 0, NULL),
(6, 'firmas_ejemplo_0860865001396619677.txt', 106, NULL, 'firmas_ejemplo.txt', 'http://10.252.251.43/AIG_Mensajeria/webroot/files/firmas_ejemplo_0860865001396619677.txt', NULL, 0, 0, NULL),
(7, 'firmas_ejemplo_0469026001396619859.txt', 126, 14, 'firmas_ejemplo.txt', 'http://10.252.251.43/AIG_Mensajeria/webroot/files/firmas_ejemplo_0469026001396619859.txt', 80274915, 0, 0, NULL),
(8, 'ejemplo_0658548001396629976.txt', 48, 0, 'ejemplo.txt', 'http://10.252.251.43/AIG_Mensajeria/webroot/files/ejemplo_0658548001396629976.txt', NULL, 0, 0, NULL),
(9, 'ejemplo_0304071001396630192.txt', 106, 16, 'ejemplo.txt', 'http://10.252.251.43/AIG_Mensajeria/webroot/files/ejemplo_0304071001396630192.txt', 50126032, 0, 0, NULL),
(14, 'SoliciuddeAprobacióndeViático-Interno1_0387978001398789720.pdf', 67106, NULL, 'Soliciud de Aprobación de Viático-Interno1.pdf', 'http://10.252.251.43/AIG_Mensajeria/webroot/files/SoliciuddeAprobaci%C3%B3ndeVi%C3%A1tico-Interno1_0387978001398789720.pdf', NULL, 1, 1, '2942014114718'),
(15, 'SolicituddeAutorizacióndeMisiónOficial(Presidencia)1_0183371001398789748.pdf', 479813, NULL, 'Solicitud de Autorización de Misión Oficial (Presidencia) 1.pdf', 'http://10.252.251.43/AIG_Mensajeria/webroot/files/SolicituddeAutorizaci%C3%B3ndeMisi%C3%B3nOficial%28Presidencia%291_0183371001398789748.pdf', NULL, 1, 1, '2942014114746'),
(16, 'GESTIÓNDECOBRO1_0804409001398789760.pdf', 81261, NULL, 'GESTIÓN DE COBRO1.pdf', 'http://10.252.251.43/AIG_Mensajeria/webroot/files/GESTI%C3%93NDECOBRO1_0804409001398789760.pdf', NULL, 1, 1, '2942014114759'),
(17, 'SolicituddeAutorizacióndemisiónoficial2_0129203001399302837.docx', 39223, 22, 'Solicitud de Autorización de misión oficial 2.docx', 'http://10.252.251.43/AIG_Mensajeria/webroot/files/SolicituddeAutorizaci%C3%B3ndemisi%C3%B3noficial2_0129203001399302837.docx', NULL, 0, 0, NULL),
(18, 'SolicituddeAutorizacióndeMisiónOficial(Presidencia)1_0093841001399641491.pdf', 479813, 0, 'Solicitud de Autorización de Misión Oficial (Presidencia) 1.pdf', 'http://10.252.251.43/AIG_Mensajeria/webroot/files/SolicituddeAutorizaci%C3%B3ndeMisi%C3%B3nOficial%28Presidencia%291_0093841001399641491.pdf', NULL, 0, 0, NULL),
(19, NULL, NULL, 24, NULL, NULL, NULL, 0, 0, NULL),
(20, 'SolicituddeAutorizacióndeMisiónOficial(Presidencia)1_0083676001399643129.pdf', 479813, 28, 'Solicitud de Autorización de Misión Oficial (Presidencia) 1.pdf', 'http://10.252.251.43/AIG_Mensajeria/webroot/files/SolicituddeAutorizaci%C3%B3ndeMisi%C3%B3nOficial%28Presidencia%291_0083676001399643129.pdf', NULL, 0, 0, NULL),
(21, 'SolicituddeAutorizacióndeMisiónOficial(Presidencia)1_0832483001400874623.pdf', 479813, 40, 'Solicitud de Autorización de Misión Oficial (Presidencia) 1.pdf', 'http://10.252.251.43/AIG_Mensajeria/webroot/files/SolicituddeAutorizaci%C3%B3ndeMisi%C3%B3nOficial%28Presidencia%291_0832483001400874623.pdf', NULL, 0, 0, NULL),
(22, 'SoliciuddeAprobacióndeViático-Interno1_0068743001401291066.pdf', 67106, 0, 'Soliciud de Aprobación de Viático-Interno1.pdf', 'http://www.correspondenciaestatal.gob.pa/AIG_Mensajeria/webroot/files/SoliciuddeAprobaci%C3%B3ndeVi%C3%A1tico-Interno1_0068743001401291066.pdf', NULL, 0, 0, NULL),
(23, 'PruebadeFirma_0154886001401293229.pdf', 87890, NULL, 'Prueba de Firma.pdf', 'http://www.correspondenciaestatal.gob.pa/AIG_Mensajeria/webroot/files/PruebadeFirma_0154886001401293229.pdf', 50144965, 0, 0, NULL),
(24, 'PruebadeFirma_0341680001401293338.pdf', 87890, 0, 'Prueba de Firma.pdf', 'http://www.correspondenciaestatal.gob.pa/AIG_Mensajeria/webroot/files/PruebadeFirma_0341680001401293338.pdf', 84188912, 0, 0, NULL),
(25, 'PrubadeFirma2_0953307001401294197.pdf', 108837, 42, 'Pruba de Firma 2.pdf', 'http://www.correspondenciaestatal.gob.pa/AIG_Mensajeria/webroot/files/PrubadeFirma2_0953307001401294197.pdf', 73134377, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) unsigned DEFAULT NULL,
  `position` varchar(127) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `salt` text,
  `email` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email_verified` int(1) DEFAULT '0',
  `active` int(1) NOT NULL DEFAULT '0',
  `ip_address` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `first_time` int(11) DEFAULT '1',
  `telephone` varchar(20) DEFAULT NULL,
  `celphone` varchar(20) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `visible` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user` (`username`),
  KEY `mail` (`email`),
  KEY `users_FKIndex1` (`user_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=186 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `user_group_id`, `position`, `username`, `password`, `salt`, `email`, `first_name`, `last_name`, `email_verified`, `active`, `ip_address`, `created`, `modified`, `entity_id`, `first_time`, `telephone`, `celphone`, `group_id`, `visible`) VALUES
(1, 1, NULL, 'admin', 'b670bffcdcf036b0f9be512bb25f664a', '51dc4bb92e72198d0dbb04bd2441f227', 'admin@admin.com', 'Admin', '', 1, 1, '', '2013-09-25 13:27:49', '2013-10-01 18:42:11', 0, 0, NULL, NULL, NULL, 1),
(41, 3, '', 'admin_aig', '330e5a43a4c2939e0fe564b2e8e1bd60', '2270cd2bfa03921709c5833a4220bc31', 'admin@aig.com', 'administrador', 'AIG', 1, 1, NULL, '2014-01-06 16:44:57', '2014-05-26 12:30:01', 136, 0, '66666666', '6666666', 2, 1),
(42, 3, '', 'admin_mef', 'f2c995fb732ec306fe8a64a69801aa7b', 'c1463aaf0f47b08704709570322db855', 'admin@mef.com', 'administrador', 'mef', 1, 1, NULL, '2014-01-06 16:45:54', '2014-05-28 12:46:33', 75, 0, '555555', '666666', 2, 1),
(43, 2, NULL, 'aig_sistemas', '70d87cf2adab0450347640d64ea0d5b9', '1eff95b259b5d3e3a7de9d6415c6f174', 'sistemas@aig.com', 'aig', 'sistema', 1, 1, NULL, '2014-01-06 16:49:16', '2014-04-07 12:13:26', 71, 0, '', '', 2, 1),
(44, 2, NULL, 'info_mef', '33b3d300dd7a08d770bdfeb0329df2d0', 'a73e84ec8769d217b85a1a913c08f5f8', 'infor@mef.com', 'informatica', 'mef', 1, 1, NULL, '2014-01-06 16:51:27', '2014-01-06 16:56:20', 88, 0, '', '', 2, 1),
(45, 2, 'Gerente de Riesgo Tecnológico', 'MGolder', 'bcc37ae4adde5efedc67d6a6875d7b85', '2d21c8a25caaa7caab9fef0cd3ce3f19', 'mgolder@innovacion.gob.pa', 'Mary Luz', 'Golder', 1, 1, NULL, '2014-01-16 15:30:42', '2014-05-26 12:25:38', 137, 0, '520-7436', '', 2, 1),
(46, 2, NULL, 'test_user_mef_1', '62285aac9e743ff931c52a3a013900e3', '0a6dcff416da9ce12d26b3af7b2591a6', 'test@test.com', 'Test', 'User 1', 1, 1, NULL, '2014-02-06 16:17:22', '2014-02-06 16:24:39', 93, 0, '123', '123', 2, 1),
(47, 2, NULL, 'test_user_mef_2', 'c1447b6bb34e76b20ea15546bdb16d13', '89aafa324e87ca6ba9c5626ec59f5fd5', 'test@test2.com', 'Test', 'User 2', 1, 1, NULL, '2014-02-06 16:19:31', '2014-02-06 17:03:40', 78, 0, '123', '123', 2, 1),
(48, 3, '', 'admin_test', '9f584b7164f06136a0d1305b0b91f4eb', 'd7c71c4da81742623ee5cc7833eed23b', 'test@admin.com', 'test', 'admin', 1, 1, NULL, '2014-02-06 17:17:41', '2014-05-22 16:55:03', 137, 0, '123', '123', 1, 1),
(49, 1, 'Test', 'tester', '940ca974097f76aec2aa70964a16d3d6', 'be6765b9efd064e42e4da431db27e86b', 'test@testx.com', 'Prueba', 'Prueba2', 1, 1, NULL, '2014-03-12 18:43:30', '2014-03-12 18:43:30', 90, 1, '1234', '1234', 2, 1),
(50, 2, 'Prueba', 'alex_test', '71b305e60c5d5c50e03b7fdfe34cdcd6', '9bc12d1b286333b7cf00fccffc2a421f', 'a.fradiani@gmail.com', 'Alex', 'Fradiani', 1, 1, NULL, '2014-03-25 15:22:53', '2014-05-23 10:31:17', 79, 0, '123', '123', 2, 1),
(51, 2, 'xxx', 'aig_usuario', '5a9ee4a6cc07b9d0dcf5547eb06776f6', 'bd14760e1d937d205ebc69c0cb72220c', 'a.fradiani@gmail.com', 'usuario', 'xxx', 1, 1, NULL, '2014-03-25 16:32:27', '2014-05-23 11:13:42', 61, 0, '123', '123', 2, 1),
(53, 2, 'probador', 'user aig2-delete', '7a30d86527e8bd5f52b8057e222d62a4', '4dac2ae036b590f390d89788ce95bdf9', 'test@testxxxx.com-delete', 'test', 'test', 1, 0, NULL, '2014-04-07 12:19:26', '2014-04-07 12:20:22', 134, 1, '123', '123', 2, 0),
(54, 2, 'Director Nacional de Innovacion', 'erodriguez', 'f0c6974aa7cff6eab02cbb6ee8546923', 'c3df97dd5e742b52ba19aae78ac561f1', 'erodriguez@innovacion.gob.pa', 'Edgar', 'Rodríguez', 1, 1, NULL, '2014-04-14 13:07:46', '2014-04-14 13:07:46', 154, 1, '520-7400', '', 1, 1),
(55, 2, 'Administrador General', 'eejaen', '2cd6d0ae358439c06ab3abf1370a3041', '9705965bd3dbac4a00e9397237e7f1cc', 'eejaen@innovacion.gob.pa', 'Eduardo', 'Jaén', 1, 1, NULL, '2014-04-14 14:09:26', '2014-05-08 12:40:48', 137, 1, '5207401', '66700238', 1, 1),
(56, 2, 'Jefe de Supervisión Tecnológica', 'ffletcher', 'd7085488cb6b4778c96f1316e23a5bc8', '8154ad1e8d493ad399e89d048fe3df8c', 'ffletcher@aig.gob.pa', 'Fabricio R.', 'Fletcher Mundins', 1, 1, NULL, '2014-04-14 14:12:29', '2014-04-14 14:12:29', 170, 1, '520-7435', '', 1, 1),
(57, 2, 'Director Nacional de Tecnología y Transformación', 'dsanchez', '1c85918142b33082c025dc7617713f7c', '5be83eaee98eaa2d07a8b7782bf540d9', 'dsanchez@innovacion.gob.pa', 'Dionys', 'Sánchez', 1, 1, NULL, '2014-04-14 14:14:56', '2014-04-14 14:14:56', 158, 1, '5207421', '66706294', 1, 1),
(58, 2, 'Analista Programador de Sistemas Informáticos', 'mgongora', 'ef132d3894d81de6f4de3510a8a8bb3b', '41f6b2e3681f4dd91d3082fc0357ed66', 'mgongora@innovacion.gob.pa', 'Mario', 'Góngora', 1, 1, NULL, '2014-04-14 14:17:15', '2014-04-14 14:17:15', 159, 1, '5207487', '', 1, 1),
(59, 2, 'Jefe de Infraestructura Tecnológica', 'rcarrillo', '434d0e348dbbf8ede6efd0a912e85fb4', '8dfa4aebd9ecdb601b1e3bc47eace377', 'rcarrillo@innovacion.gob.pa', 'René Javier', 'Carrillo Ortega', 1, 0, NULL, '2014-04-14 14:20:56', '2014-05-14 12:03:46', 152, 1, '5207514', '66150242', 1, 1),
(60, 2, 'Abogada', 'maguilar', '1bd14b7cd4398755e9b305b73523bd82', '71397d0ba6d8c597c5f017c7681f46cd', 'maguilar@innovacion.gob.pa', 'Marlene', 'Aguilar Pinzón', 1, 1, NULL, '2014-04-14 14:31:06', '2014-05-12 11:57:28', 139, 1, '5207549', '64503724', 1, 1),
(61, 2, 'Coordinadora de Planes y Programas', 'mwong', 'c4a92acf5c5af3f1861be0c238246069', 'ce94a67ebf2e40da051bc40fbe7392b9', 'mwong@innovacion.gob.pa', 'Maribel', 'Wong', 1, 1, NULL, '2014-04-14 14:33:00', '2014-04-14 14:33:00', 164, 1, '520-7474', '', 1, 1),
(62, 2, 'Abogado', 'dmorales', 'ecbeee01f49c3f97d4ac6fc4fb28fd24', 'cbb76450acb8fc89661094ebfb9defdb', 'dmorales@innovacion.gob.pa', 'Diego Alonso', 'Morales Riley', 1, 1, NULL, '2014-04-14 14:34:45', '2014-05-12 11:57:39', 139, 1, '520-7411', '', 1, 1),
(63, 2, 'Soporte técnico', 'augonzalez', '4ffbe22e1d636f8127fb5887ccadacde', '5e7c3b9142edc158823dc18357e77ee5', 'augonzalez@innovacion.gob.pa', 'Alvaro Ulises', 'González Velásquez', 1, 1, NULL, '2014-04-14 14:37:11', '2014-05-28 10:24:30', 152, 1, '5207404', '68534228', 14, 1),
(64, 2, 'Secretaria Ejecutiva', 'kguerra', '3a6396f035654abcdf5be711337ce4c3', 'ae9e0589bd9c37704067eee42ee4cbbc', 'kguerra@innovacion.gob.pa', 'Karen Jaaziel', 'Guerra Gonzalez', 1, 1, NULL, '2014-04-14 14:39:03', '2014-05-12 11:56:11', 137, 1, '520 7402', '', 1, 1),
(65, 2, 'Secretaria I', 'lgutierrez', 'e6c76fb2423d5b0a8f6c7f1874a50110', '87deac691daa789ce8204d04d3029973', 'lgutierrez@innovacion.gob.pa', 'Lissette Agerette', 'Gutiérrez Pitty', 1, 1, NULL, '2014-04-14 14:41:19', '2014-04-14 14:41:19', 148, 1, '520-7494', '', 1, 1),
(66, 2, 'Jefa de Servicios Generales', 'gvergara', '361b76df51aa8ddceee043d1d8447926', 'bfe626123798a8415e6c83abd27012f8', 'gvergara@innovacion.gob.pa', 'Graciela', 'Vergara', 1, 1, NULL, '2014-04-14 14:43:07', '2014-04-14 14:43:07', 145, 1, '520-7649', '6675-0107', 1, 1),
(67, 2, 'Soporte Tecnico', 'jdpinzon', '4eb5c1d2b46c1efb7c21b9eb1c254e4b', 'e18b40f8627401068c949ad5e3c7d4ce', 'jdpinzon@innovacion.gob.pa', 'Julio', 'Pinzón', 1, 1, NULL, '2014-04-14 14:45:01', '2014-04-14 14:45:01', 152, 1, '520-7600', '67261289', 1, 1),
(68, 2, 'Administrador de Sistemas', 'pespinosa', '13026dabbfbcaa01b8ad277846d3a8cf', 'c1d64e09ea18f548d960ad91fc9ec175', 'pespinosa@innovacion.gob.pa', 'Paulo Emilio', 'Espinosa Gomez', 1, 1, NULL, '2014-04-14 14:49:18', '2014-04-14 14:49:18', 152, 1, '5207530', '', 1, 1),
(69, 2, 'Asistente Ejecutiva del Despacho Superior', 'cruiz', '40e9d07e2ef91918c5ce5efc0f4eaa85', '342e08de7c1e16e9a3bf9a7ae7b4b0a1', 'cruiz@innovacion.gob.pa', 'Carla', 'Ruiz', 1, 1, NULL, '2014-04-14 14:54:38', '2014-05-12 11:56:35', 137, 1, '5207540', '60907155', 1, 1),
(70, 2, 'Supervisora de Operaciones', 'jmendez', 'f0dc5a13bf0aba618beeb5cd417dff5d', '9d2298bb41978499511e4242f7472c6e', 'jmendez@innovacion.gob.pa', 'Jessyann', 'Méndez', 1, 1, NULL, '2014-04-14 15:07:00', '2014-04-14 15:07:00', 173, 1, '520-7460', '', 1, 1),
(71, 2, 'Fotógrafo', 'eherrera', '8288a7a827dc7d60fb31c8d313622326', '374e24924b31bd63f3279566afc519aa', 'eherrera@innovacion.gob.pa', 'Eric Jahir', 'Herrera Alemán', 1, 1, NULL, '2014-04-14 15:09:00', '2014-04-14 15:09:00', 143, 1, '520 7484', '', 1, 1),
(72, 2, 'Supervisor de Operaciones', 'eacedeno', 'df5f15d7f96d25a846ff3862d4f33dd6', 'aebad22f24d9e033701defc313efd556', 'eacedeno@innovacion.gob.pa', 'Edwin Axel', 'Cedeño Ortega', 1, 1, NULL, '2014-04-14 15:11:01', '2014-04-14 15:11:01', 174, 1, '5207465', '67825030', 1, 1),
(73, 2, 'Recepcionista', 'tcole', 'c6279b3b295d9d0ad4f9af580ed49dac', '6dc31625cc3a1a3220af317828391f17', 'tcole@innovacion.gob.pa', 'Tatiana Lisbeth', 'Cole Pinock', 1, 1, NULL, '2014-04-14 15:13:16', '2014-04-14 15:13:16', 142, 1, '520-7400', '', 1, 1),
(74, 2, 'Seguridad', 'lmurrillo', '2d52cee474fb6be1804057bda93d5807', 'b232bba1434f513ca193b3cd202186a6', 'lmurrillo@innovacion.gob.pa', 'Luis', 'Murillo', 1, 1, NULL, '2014-04-14 15:15:02', '2014-04-14 15:15:02', 147, 1, '5207400', '', 1, 1),
(75, 2, 'Director Nacional de Finanzas', 'rcucalon', '215fee5ccb5f794e1c2d3485f8951680', '16a49c17717a8f4de6f8e6b87fda26d5', 'rcucalon@innovacion.gob.pa', 'Ricardo', 'Cucalón', 1, 1, NULL, '2014-04-14 15:16:24', '2014-04-14 15:16:24', 148, 1, '520-7493', '6676-6403', 1, 1),
(76, 2, 'Jefe de Planificación y Estudios Tecnológicos', 'rvalverde', '30f8f6581bb172dc699e475d22a09571', 'd9d2599c41ead1b745082fbc93698927', 'rvalverde@innovacion.gob.pa', 'Reyes Arturo', 'Valverde Batista', 1, 1, NULL, '2014-04-14 15:18:52', '2014-04-14 15:18:52', 150, 1, '520-7476', '64967230', 1, 1),
(77, 2, 'Analista de Métodos y Sistemas Informáticos', 'gsantander', '732de82b7ebf4f0294192f715f1bbf0f', '721076bd728b483ea4f67403e5d7ee5d', 'gsantander@innovacion.gob.pa', 'Geraldine', 'Ssantander', 1, 1, NULL, '2014-04-14 15:22:12', '2014-04-14 15:22:12', 173, 1, '5207595', '6940-6701', 1, 1),
(78, 2, 'Supervisora de Operaciones', 'khim', '1f740e4c2e74c5e7a291c49bc857a043', 'bdb71649c12434917ab59e435cfda3e6', 'khim@innovacion.gob.pa', 'Karla', 'Him', 1, 1, NULL, '2014-04-14 15:23:44', '2014-04-14 15:23:44', 173, 1, '5207461', '', 1, 1),
(79, 2, 'Seguridad', 'ichang', '0c6ad613fd631980ac477b0ffb963ee7', 'a47c7db55b3ccdae7b6f6826a73ab84f', 'ichang@innovacion.gob.pa', 'Issac', 'hang', 1, 1, NULL, '2014-04-14 15:25:04', '2014-04-14 15:25:04', 147, 1, '5207400', '', 1, 1),
(80, 2, 'Operador de Computadoras', 'ejrodriguez', '002bb550687da6eb48471e15f797e17b', '7fe0671d5d3f1a1efcae3967d320a5fb', 'ejrodriguez@innovacion.gob.pa', 'Eric Javier', 'Rodríguez Villarreal', 1, 1, NULL, '2014-04-14 15:27:42', '2014-04-14 15:27:42', 158, 1, '5207485', '66250874', 1, 1),
(81, 2, 'Coordinador de Planes y Programas', 'jprestan', '239383d8196e872ea4408562aecab06e', '8dff5170340f5ffc37c3e5696f64ce47', 'jprestan@innovacion.gob.pa', 'Julio', 'Prestán', 1, 1, NULL, '2014-04-14 15:29:06', '2014-04-14 15:29:06', 164, 1, '520-7456', '', 1, 1),
(82, 2, 'Analista de Métodos y Sistemas Informáticos', 'xllerena', 'e03c3a69d611d8f988d1e2aa0f9ae4e9', 'ecd36b761cf5d85698aece47ff2e22c3', 'xllerena@innovacion.gob.pa', 'Xavier Alonso', 'Llerea Walcott', 1, 1, NULL, '2014-04-14 15:31:15', '2014-04-14 15:31:15', 159, 1, '5207548', '', 1, 1),
(83, 2, 'Soporte de Comunicaciones', 'aflores', '115c02b03e520552bdebb5e14592f55c', '1005fd4e486da8dac7542be19239fcc1', 'aflores@innovacion.gob.pa', 'Alma', 'Flores', 1, 0, NULL, '2014-04-14 15:33:46', '2014-05-28 10:23:32', 152, 1, '520-7495', '', 14, 1),
(84, 2, 'Jefe de Comunicación y Relaciones Públicas', 'lvelarde', '82a792c8f6ad646c73b6d94b7d1e2af4', 'e39caf6c14e1416b1d7a18fc333098b2', 'lvelarde@innovacion.gob.pa', 'Luis Carlos', 'Velarde De León', 1, 1, NULL, '2014-04-14 15:35:28', '2014-04-14 15:35:28', 143, 1, '520-7400', '60598099', 1, 1),
(85, 2, 'Gerente de Programas e Ingresos', 'cprieto', '8dad81c30e3eebfd4ec15b9953c91a5a', '1113f956a3176147a5be3b8aa8637f4d', 'cprieto@innovacion.gob.pa', 'César', 'Prieto', 1, 1, NULL, '2014-04-14 15:37:35', '2014-04-14 15:37:35', 158, 1, '5207509', '65504959', 1, 1),
(86, 2, 'Evaluadora de Proyectos', 'jrivas', '7cb7de6df49a5783d0c7b4cfbce9e2d9', '51f2b53964d84604b15a23df38382308', 'jrivas@innovacion.gob.pa', 'Judy Lia', 'Rivas', 1, 1, NULL, '2014-04-14 15:39:33', '2014-05-08 14:39:17', 162, 0, '5207429', '', 1, 1),
(87, 2, 'Ingeniero en Telecomunicaciones', 'operez', '02883552ad4fb30bb09d7c942009f78a', '7f086930593a8ae0d1d10abceeb6e70c', 'operez@innovacion.gob.pa', 'Oscar Arturo', 'Pérez Sánchez', 1, 1, NULL, '2014-04-14 15:42:00', '2014-04-14 15:42:00', 160, 1, '5207424', '', 1, 1),
(88, 2, 'Asistente de Abogado', 'mcampagna', 'c236d71f6dd6ade45c9ad489fc3b4f23', '0a26f5467bbabc0da3c6831b460fdf46', 'mcampagna@innovacion.gob.pa', 'María Fernanda', 'Campagna Díaz', 1, 1, NULL, '2014-04-14 15:45:35', '2014-05-12 11:59:15', 139, 1, '5207448', '', 1, 1),
(89, 2, 'Abogado', 'oarcia', 'ff99bdd910d6f5d45906adea0f717dd1', '30d4d262fcd5b3346f4ff95109010281', 'oarcia@innovacion.gob.pa', 'Omar Humberto', 'Arcia Rodríguez', 1, 1, NULL, '2014-04-14 15:47:29', '2014-04-14 15:47:29', 140, 1, '5207412', '63728155', 1, 1),
(90, 2, 'Contadora', 'jdonald', 'a101da73f5880c9124944652593ec078', '0d4cc3d56282039d725a0543f60888ad', 'jdonald@innovacion.gob.pa', 'Jane Gloria', 'Donald Morris', 1, 1, NULL, '2014-04-14 16:00:45', '2014-04-14 16:00:45', 149, 1, '5207589', '66003352', 1, 1),
(91, 2, 'Secretaria I de Fiscalización', 'ycardenas', 'ee59182440895134a57699375a8fae3e', '3f3849638becd8e8a84945ad31ff0f5e', 'ycardenas@innovacion.gob.pa', 'Yaribel', 'Cárdenas Gordón', 1, 1, NULL, '2014-04-14 16:02:56', '2014-05-12 11:59:52', 175, 1, '5207638', '68049118', 1, 1),
(92, 2, 'Analista de Personal II', 'yguerrero', '966b68af79a6a15fb79c6287f08e5754', 'd6b099fc1fee7a37a605346167f709f6', 'yguerrero@innovacion.gob.pa', 'Yaricelys', 'Guerrero', 1, 1, NULL, '2014-04-14 16:04:32', '2014-04-14 16:04:32', 144, 1, '5207491', '', 1, 1),
(93, 2, 'Jefe de Supervision Tecnologica', 'rmoreno', 'efcb686705ac2dab9582ab93b2e90cc3', 'e43873576dd618b10f9f1f2fee42f029', 'rmoreno@innovacion.gob.pa', 'Ricardo', 'Moreno Campos', 1, 1, NULL, '2014-04-14 16:08:26', '2014-04-14 16:12:26', 160, 1, '5207426', '64309302', 1, 1),
(94, 2, 'Analista de Metodos y Sistemas Informaticos', 'jpinzon', '63de613f83c22295b01ac93b4451cbe5', '4c7670fc1d20e63cb4a4c888c96d6408', 'jpinzon@innovacion.gob.pa', 'Jorge Oscar', 'Pinzon Lopez', 1, 1, NULL, '2014-04-14 16:10:43', '2014-04-14 16:10:43', 152, 1, '5207517', '67815955', 1, 1),
(95, 2, 'Analista de Personal I', 'irodriguez', '1b98d2adc8236abf07db476ec2a24ee1', '7088a1a2e4dc0555a0b44d3c5de5fc39', 'irodriguez@innovacion.gob.pa', 'Isamar ', 'Rodríguez ', 1, 1, NULL, '2014-04-14 16:18:23', '2014-04-14 16:18:23', 144, 1, '5207490', '', 1, 1),
(96, 2, 'Coordinador de Asistencia Técnica Internacional', 'imolino', '7e564468f595c9348ab73e99dd4295fe', '4f1413df07f31bb0c455f657091598cf', 'imolino@innovacion.gob.pa', 'Ignacio Antonio', 'Molino Mihalitsianos', 1, 1, NULL, '2014-04-15 08:05:21', '2014-04-15 08:05:21', 140, 1, '5207479', '6550-8033', 1, 1),
(97, 2, 'Analista Administrativo', 'murena', '2fb5603c8a634b81179b4ae64ad88fbd', 'dfc36fade57a4ba99c04da6c5cc6e3d0', 'murena@innovacion.gob.pa', 'Maria Anelis ', 'Ureña Monroy ', 1, 1, NULL, '2014-04-15 08:07:05', '2014-04-15 08:07:05', 144, 1, '520-7490', '', 1, 1),
(98, 2, 'Coordinadora de Proyecto ', 'snegron', 'b2b378915f427663a399f6f54dbd91ee', '6221cb5c71afce38fc2dd6cebecdb3e0', 'snegron@innovacion.gob.pa', 'Shirley', 'Negron Smith', 1, 1, NULL, '2014-04-15 08:10:22', '2014-04-15 08:10:22', 165, 1, '5207438', '62468543', 1, 1),
(99, 2, 'Coordinador de Comunicaciones', 'lsuman', '34301797f4a6cf77c304743f823ecf63', '2c693ec05fd3fc62cebdb92709db46f4', 'lsuman@innovacion.gob.pa', 'Luis Angel', 'Suman', 1, 1, NULL, '2014-04-15 08:12:26', '2014-04-15 08:12:26', 152, 1, '5207410', '62157748', 1, 1),
(100, 2, 'Analista de Metódos y Sistemas Informáticos', 'ahim', 'f5a3eaa14449b129768f9f641d1ef8fe', '0b9a5762dd54a528a5289e3682bb9d34', 'ahim@innovacion.gob.pa', 'Alma', 'Him', 1, 1, NULL, '2014-04-15 08:14:48', '2014-05-28 10:24:01', 140, 1, '5207415', '6632-9123', 14, 1),
(101, 2, 'Analista de Métodos y Sistemas Informaticos', 'krosero', 'e83045faa5a889a0f86199b4ffe2e2d9', 'ad920a794398cf168b2f90105c3358a9', 'krosero@innovacion.gob.pa', 'Karelys', 'Rosero', 1, 1, NULL, '2014-04-15 08:17:43', '2014-04-15 08:17:43', 161, 1, '5207522', '62534782', 1, 1),
(102, 2, 'Coordinadora de Planes y Programas', 'lfossatti', '3117e9c5b09adfce8bc3f344299168be', 'de269a59ebeaf1feff2a87cad9fcb9e7', 'lfossatti@innovacion.gob.pa', 'Lizbeth Aneth', 'Fossatti Franceschi', 1, 1, NULL, '2014-04-15 08:20:21', '2014-05-09 09:27:06', 164, 0, '5207436', '', 1, 1),
(103, 2, 'Coordinador de Planes y Programas', 'ccdeleon', '88c886a52c5100440259927eadf3ac4b', '1eac4c446f2e8f16321e23a0a4fbac03', 'ccdeleon@innovacion.gob.pa', 'Caridad del Carmen', 'De León', 1, 1, NULL, '2014-04-15 08:22:02', '2014-04-15 08:22:02', 154, 1, '5207403', '60679719', 1, 1),
(104, 2, 'Director Nacional de Tecnologia y Sistemas', 'jhuertas', 'f5f25111a1c58d15968fa914e0d07f15', '6f7cb8ecde3a4289531cd6fb85905846', 'jhuertas@innovacion.gob.pa', 'Joaquin Antonio ', 'Huertas De Leon', 1, 1, NULL, '2014-04-15 08:45:34', '2014-04-15 08:45:34', 152, 1, '5207580', '66743361', 1, 1),
(105, 2, 'Coordinador de Planes y Programas ', 'nmolina', 'f14c56b352978e6bcc9af72e848282b8', '418140f46456336a67444af65e376999', 'nmolina@innovacion.gob.pa', 'Nicolas Jose', 'Molina Aguilar', 1, 1, NULL, '2014-04-15 08:49:45', '2014-04-15 08:49:45', 156, 1, '5207449', '6630-2720', 1, 1),
(106, 2, 'Jefe de Supervisión Tecnológica', 'ngonzalez', '75115c02015b6f77859d226d082c902c', '742e7632fef029e82594f0b76e9b41b8', 'ngonzalez@innovacion.gob.pa', 'Nayreth Maruquel', 'González Dunkley', 1, 1, NULL, '2014-04-15 08:52:11', '2014-04-15 08:52:11', 161, 1, '5207451', '65508542', 1, 1),
(107, 2, 'Analista de Presupuesto I', 'gfranco', '3128de1d35618298c6e944f998d63b33', '97818190aa60bfeb93d2340b7584b177', 'gfranco@innovacion.gob.pa', 'Guadalupe', 'Franco', 1, 1, NULL, '2014-04-15 10:20:00', '2014-04-15 10:20:00', 150, 1, '5207519', '67918075', 1, 1),
(108, 2, 'Coordinador de Planes y Programas', 'mgalvez', 'a4965230f61e33f18af19a9320257232', '8740fc74e3ccebcbfa672164ba531dd3', 'mgalvez@innovacion.gob.pa', 'Mario Isaias', 'Gálvez Gómez', 1, 1, NULL, '2014-04-15 11:12:50', '2014-04-15 11:17:05', 157, 1, '5207471', '62302333', 1, 1),
(109, 2, 'Gerente de Riesgo Informático', 'jgarrido', '0532f1a3d281891db8c1cd433c00df31', 'e075a4923269fd3c78d2f2a2c206885a', 'jgarrido@innovacion.gob.pa', 'Javier A.', 'Garrido C.', 1, 1, NULL, '2014-04-15 11:19:33', '2014-05-09 09:26:12', 153, 0, '5207452 ', '', 1, 1),
(110, 2, 'Jefe de Adiestramiento', 'jtorres', 'd85c18dac644b4455adab39354419317', 'adf5a02c72db4901598612899295d206', 'jtorres@innovacion.gob.pa', 'Jorge Alberto', 'Torres Saavedra', 1, 1, NULL, '2014-04-15 11:26:40', '2014-04-15 11:26:40', 147, 1, '5207400', '66749305', 1, 1),
(111, 2, 'Analista de Métodos y Sistemas Informáticos', 'squiroz', '774a86f79dcb4181f5bf26b9504eb978', '8e2336e3cfe4302095669d7f28fa7649', 'squiroz@innovacion.gob.pa', 'Sandra', 'Quiroz', 1, 1, NULL, '2014-04-15 11:28:39', '2014-04-15 11:28:39', 157, 1, '5207472', '66797475', 1, 1),
(112, 2, 'Auditor Forense', 'dlaird', 'c571da292ba5d5fe79d3ef46b4999654', '4aa1763ae26ee0c0256ced5d34b87680', 'dlaird@innovacion.gob.pa', 'Donaldo', 'Laird', 1, 1, NULL, '2014-04-15 11:30:29', '2014-04-15 11:30:29', 164, 1, '5207433', '67027037', 1, 1),
(113, 2, 'Jefe Contabilidad', 'dgonzalez', '56486ccfbae5bf61341821eac8494f86', '06d0356aa517900d618c5023077102a5', 'dgonzalez@innovacion.gob.pa', 'Domingo', 'González Valderrama', 1, 1, NULL, '2014-04-15 11:32:03', '2014-04-15 11:32:03', 149, 1, '5207477', '65830196', 1, 1),
(114, 2, 'Asistente Administrativa', 'agutierrez', '9590e21126184a614567d8b60a828c25', 'cba40ea15bbdbc2d226c11386455ba2c', 'agutierrez@innovacion.gob.pa', 'Anisca Rosmary', 'Gutierrez Aguero', 1, 1, NULL, '2014-04-15 11:34:36', '2014-05-28 10:27:40', 142, 1, '5207563', '', 14, 1),
(115, 2, 'Asistente Ejecutiva II', 'srios', 'bb2f2c1a7ceaf9075a850689c2afc845', 'ebd51b9b7da6fa931ebe516f0400ba37', 'srios@innovacion.gob.pa', 'Sherly ', 'Ríos F.', 1, 1, NULL, '2014-04-15 11:36:29', '2014-04-15 11:36:29', 157, 1, '5207470', '66748981', 1, 1),
(116, 2, 'Auxiliar de Bienes Patrimoniales', 'ccaicedo', '1f9195c5f8d43cbcf772657ada166aac', '105e65a199a00773c07b41a786f48f28', 'ccaicedo@innovacion.gob.pa', 'Carmen María', 'Caicedo de Chen', 1, 1, NULL, '2014-04-15 11:38:23', '2014-04-15 11:38:23', 142, 1, '5207478', '', 1, 1),
(117, 2, 'Secretaria Ejecutiva I', 'lbeiia', '7f80d26bbf2a2595dcd2bb1f8ce1e87c', 'dee2d5ee4de67000182f8bbfa72a135c', 'lbeiia@innovacion.gob.pa', 'Lucinda', 'Beitia', 1, 1, NULL, '2014-04-15 11:40:10', '2014-04-15 11:40:10', 151, 1, '5207496', '', 1, 1),
(118, 2, 'Analista de Métodos y Sistemas Informáticos', 'cdeleon', '022ca13c2e3b1e7db1117bc886a1b453', 'b255cf86f2af8c8a46d081222b4a2b6f', 'cdeleon@innovacion.gob.pa', 'Carlos ', 'De León ', 1, 1, NULL, '2014-04-15 11:42:52', '2014-04-15 11:42:52', 160, 1, '5207427', '67539810', 1, 1),
(119, 2, 'Director del Instituto de Tecnología e Innovación', 'ehenriquez', '7cfeb5b408b0f69e0ce09699617e4ee8', '3bd3c17e391c5ed77ff66b2dd68b71ae', 'ehenriquez@innovacion.gob.pa', 'Edwin Arcelio', 'Henríquez Alvarado', 1, 1, NULL, '2014-04-15 11:45:36', '2014-04-15 11:45:36', 166, 1, '5204001', '65508031', 1, 1),
(120, 2, 'Técnico', 'javiersanchez', 'e6d4b430155327e331053356725516b1', '62a404e414b364da73c328290ddf7513', 'javiersanchez@innovacion.gob.pa', 'Javier', 'Sánchez', 1, 1, NULL, '2014-04-15 11:47:31', '2014-04-15 11:47:31', 168, 1, '5204001', '', 1, 1),
(121, 2, 'Secretaria I', 'avergara', '8544ecc2cf33ec48f07ba222ea09d5f2', 'ee03b0091af00916d47eed6e73c460bf', 'avergara@innovacion.gob.pa', 'Antonia', 'Vergara Espinosa', 1, 1, NULL, '2014-04-15 11:49:26', '2014-04-15 11:49:26', 166, 1, '5204001', '', 1, 1),
(122, 2, 'Jefe de Tesoreria', 'mcalvit', '9cc6beee87f042d285cf9e87959326ca', 'fbe2aa83454d6b5f58a6a8ec53b59008', 'mcalvit@innovacion.gob.pa', 'Mario Arturo', 'Calvit Choy', 1, 1, NULL, '2014-04-15 11:54:34', '2014-04-15 11:54:34', 151, 1, '5207489', '6151-0271', 1, 1),
(123, 2, 'Analista de Sistemas y Métodos Informáticos', 'ksalas', '0e67c3472f1f5f52a92c32d2cd315db7', '1ebbaf97372f15fa3ff0d133cea19d54', 'ksalas@innovacion.gob.pa', 'Katherine Giselle', 'Salas Cano', 1, 1, NULL, '2014-04-15 13:56:14', '2014-04-15 13:56:14', 155, 1, '5207443', '', 1, 1),
(124, 2, 'Secretaria I', 'aherrera', '5a03315f17d23eb44a12ff962a36aec9', '3e3ad1b0d38c1bb6c1d8312dc424141b', 'aherrera@innovacion.gob.pa', 'Aricelis', 'Herrera', 1, 1, NULL, '2014-04-15 14:04:46', '2014-04-15 14:04:46', 158, 1, '5207420', '66719382', 1, 1),
(125, 2, 'Analista de Sistemas y Métodos Informáticos II', 'lserrano', 'bebe226bb8e406234544c14a6769f794', '00041fb60a21ff201f498136cc473b47', 'lserrano@innovacion.gob.pa', 'Lidia Ibeth', 'Serrano Quiroz', 1, 1, NULL, '2014-04-15 14:10:05', '2014-04-15 14:10:05', 153, 1, '5207457', '', 1, 1),
(126, 2, 'Administrador 1', 'egonzalez', '90aba10505d316a9204e7b2c4963bfa3', '5f57bb61b7ca4daf2a503ca98331881f', 'egonzalez@innovacion.gob.pa', 'Edith', 'Gonzalez', 1, 1, NULL, '2014-04-15 14:14:07', '2014-04-15 14:14:07', 154, 1, '5207440', '66504197', 1, 1),
(127, 2, 'Analista de Sistemas y Métodos Informáticos', 'izeballos', '78c3101d65e2c0547ad95ae2fb30c989', '9537f179b5adf85b24cab93396cb1271', 'izeballos@innovacion.gob.pa', 'Ismael', 'Zeballos', 1, 1, NULL, '2014-04-15 14:15:42', '2014-04-15 14:15:42', 155, 1, '5207445', '', 1, 1),
(128, 2, 'Periodista', 'ecarcache', '30b8dbcf3cb404346725e959adf5d46b', '1c68693d60efd5b974d8a9bb0798f7ae', 'ecarcache@innovacion.gob.pa', 'Earmy', 'Carcache', 1, 1, NULL, '2014-04-15 14:17:13', '2014-04-15 14:17:13', 143, 1, '5207502', '60558905', 1, 1),
(129, 2, 'Secretaria Ejecutiva', 'mcastillero', 'e3f6062624866f14b5613093abc2a2df', '7d5a24ca2cce5179fb9e27617f8fa062', 'mcastillero@innovacion.gob.pa', 'Melcinia Esther', 'Castillero Flores', 1, 1, NULL, '2014-04-15 14:19:06', '2014-05-12 11:56:51', 137, 1, '5207401', '69113624', 1, 1),
(130, 2, 'Asistente de Auditoria ', 'rrodriguez', '509f3a7b2da0209944e8c1580c568c2b', '9b9929d2422c429e443c7ae71f207094', 'rrodriguez@innovacion.gob.pa', 'Ruth ', 'Rodriguez', 1, 1, NULL, '2014-04-15 14:28:31', '2014-04-15 14:28:31', 141, 1, '5207510', '69804805', 1, 1),
(131, 2, 'Gerente de Riesgo Tecnológico', 'revers', 'e385a9e19c5dec3a7cd36a0bf58b3c3b', 'fed5267de924a65566235113936a80a0', 'revers@innovacion.gob.pa', 'Ricardo Alberto', 'Evers Aizprúa', 1, 1, NULL, '2014-04-15 14:30:16', '2014-04-15 14:30:16', 152, 1, '5207511', '', 1, 1),
(132, 2, 'Asistente de Tesoreria', 'ymosquera', '1dc29c0b17f98a389d21b3b6066cb2bd', '37b8fde23421f9269bd07d351601ed2d', 'ymosquera@innovacion.gob.pa', 'Yerizel', 'Mosquera', 1, 1, NULL, '2014-04-15 14:33:46', '2014-04-15 14:33:46', 151, 1, '5207588', '69604185', 1, 1),
(133, 2, 'Gerente de Riesgo Tecnológico', 'jcedeno', 'f91a62cd909a0c45aaa89f9fb59711d6', '53b9a19ed7dd469b98367ddcc339f1d5', 'jcedeno@innovacion.gob.pa', 'José Guillermo', 'Cedeño Saldaña', 1, 1, NULL, '2014-04-15 14:35:40', '2014-04-15 14:35:40', 150, 1, '5207454', '66757255', 1, 1),
(134, 2, 'Gerente dee Riesgo Tecnológico', 'abroce', '197c2b03717f882796bdbf73fdb018e5', 'c5703991ff3e07dd55028e4e18e6bfa7', 'abroce@innovacion.gob.pa', 'Anabel', 'Broce', 1, 1, NULL, '2014-04-15 14:38:22', '2014-05-28 10:26:59', 170, 1, '5207400', '64191161', 14, 1),
(135, 2, 'Coordinador de Planes y Proyectos', 'Kfragueiro', 'e9551819af2859b76262006e838d1095', '097055ccdfd53919a81bf75e8d2ce84c', 'Kfragueiro@innovacion.gob.pa', 'Kelkyra', 'Fragueiro Rosas', 1, 1, NULL, '2014-04-15 14:40:05', '2014-05-12 12:00:09', 174, 1, '5207462', '', 1, 1),
(136, 2, 'Jefe de Supervisión Tecnólogica', 'jmlee', '45d01df635ad2ee0feab3d7ac4d08b3e', '8cfde26bbe45919052295572eba7aef2', 'jmlee@innovacion.gob.pa', 'José', 'Lee', 1, 1, NULL, '2014-04-15 14:44:44', '2014-04-15 14:44:44', 165, 1, '5071872', '66720260', 1, 1),
(137, 2, 'Chofer', 'dreyes', 'c2323c7def2b5a84c15c504e7cb3435b', '1b655abd10998d4cbb371701758cbc36', 'dreyes@innovacion.gob.pa', 'Diomedes', 'Reyes', 1, 1, NULL, '2014-04-15 14:46:52', '2014-04-15 14:46:52', 145, 1, '5207400', '', 1, 1),
(138, 2, 'Conductor', 'rgonzalez', 'bc4fafc5e9b686d6aea7d1145d477c3b', '2e72f6c65a26c2865dafa94ebbe70b83', 'rgonzalez@innovacion.gob.pa', 'Ronny', 'Gonzalez', 1, 1, NULL, '2014-04-15 14:48:32', '2014-04-15 14:48:32', 145, 1, '5207400', '', 1, 1),
(139, 2, 'Coordinador de Adiestramiento', 'sbernal', '22f278a23b3e1c4979edba698c7b53b9', '24c0a2a383fe9d7e768bb4c98e3b97a6', 'sbernal@innovacion.gob.pa', 'Segundo Bolívar', 'Bernal Quijada', 1, 1, NULL, '2014-04-15 14:52:06', '2014-04-15 14:52:06', 166, 1, '5204002', '66905429', 1, 1),
(140, 2, 'Asistente de Relaciones Publicas', 'rguardado', '56afb61293c408eff2c16b587df6066e', '663aa5b6c8bb1b1c2760481fdc0669c6', 'rguardado@innovacion.gob.pa', 'Ricardo Lentefino', 'Guardado', 1, 1, NULL, '2014-04-15 14:56:41', '2014-04-15 14:56:41', 143, 1, '5207400', '6479-5169', 1, 1),
(141, 2, 'Inspector III Supervisor', 'cburgos', 'f5064be8df9ebc675332431380293916', '99bcc6a63378ad98a516869183704c3f', 'cburgos@innovacion.gob.pa', 'Carlos Alberto', 'Burgos Mata', 1, 1, NULL, '2014-04-15 14:58:06', '2014-04-15 14:58:06', 152, 1, '5207513', '', 1, 1),
(142, 2, 'Secretaria', 'jmartinez', '99f7c6454fa8ef91d9003632073bb2c7', '998ae52c2fc5a4f128bbdff80072201c', 'jmartinez@innovacion.gob.pa', 'Jessica Valeria', 'Martínez Guerra', 1, 1, NULL, '2014-04-15 15:00:03', '2014-04-15 15:00:03', 152, 1, '5207408', '', 1, 1),
(143, 2, 'Analista de Sistemas y Métodos Informáticos', 'sbatista', '694727d4d1f02c30656fcb80bc31fe69', '8c9dd95793222518031de9dd5699835a', 'sbatista@innovacion.gob.pa', 'Silvia', 'Batista', 1, 1, NULL, '2014-04-15 15:02:12', '2014-04-15 15:02:12', 159, 1, '5207520', '', 1, 1),
(144, 2, 'Jefe de Soporte Tecnico', 'mtapia', 'bd02e1379b4a81b072930e793d22c58b', '8840a466c328ce9734075d718f2f8188', 'mtapia@innovacion.gob.pa', 'Moisés R.', 'Tapia S.', 1, 1, NULL, '2014-04-15 15:03:38', '2014-04-15 15:03:38', 152, 1, '5207515', '', 1, 1),
(145, 2, 'Diseño Gráfico', 'krusso', '5367f69d1d8b2acdcdbd4ce7933d404e', '7f05ae4e74812228488dae36010d4e78', 'krusso@innovacion.gob.pa', 'Krystel', 'Russo', 1, 1, NULL, '2014-04-15 15:05:18', '2014-04-15 15:05:18', 143, 1, '5207518', '', 1, 1),
(146, 2, 'Analista de Presupuesto', 'oolivares', '6d8724110aca7376e03180294a266dc4', '318e2fe48c3848d35f659fa5e6972281', 'oolivares@innvocacion.gob.pa', 'Olga', 'olivares Jimenez', 1, 1, NULL, '2014-04-15 15:07:27', '2014-04-15 15:07:27', 150, 1, '5207414', '', 1, 1),
(147, 2, 'Jefe de Personal', 'tzorrilla', '756219075263fc712fa8c20784d398bd', '7502d7356ec838741dc2d362c93cd168', 'tzorrilla@innovacion.gob.pa', 'Thays ', 'Zorrilla ', 1, 1, NULL, '2014-04-15 16:04:40', '2014-04-15 16:04:40', 144, 1, '520-7444', '', 1, 1),
(148, 2, 'Gerente de Tecnologia Aplicada', 'aortega', '172231197419a670d1f74714a65d088c', '7520c3ae6dab93beb8c6235a9a30fb76', 'aortega@innovacion.gob.pa', 'Adonay', 'Ortega', 1, 1, NULL, '2014-04-15 16:06:26', '2014-05-28 12:42:50', 169, 1, '5207432', '66708809', 1, 1),
(149, 2, 'Coordinador de Planes y Programas', 'pruidiaz', '479ccb15f8b30d34307fd18aa7676e6b', 'dfb2af414e56701c509d178384fad3d6', 'pruidiaz@innovacion.gob.pa', 'Pablo A.', 'Ruidiaz M.', 1, 1, NULL, '2014-04-15 16:12:41', '2014-05-12 12:00:54', 162, 1, '5207430', '66770213', 1, 1),
(150, 2, 'Jefe del Depaetamento de Compras', 'agonzalez', 'ec1f0e23f101ea8f2c4f7fb3ae6cd7a2', 'a853dbc46a5bde4ce40c1e95ffd85455', 'agonzalez@innovacion.gob.pa', 'Ana Zylka', 'Gonzalez', 1, 1, NULL, '2014-04-15 16:14:44', '2014-05-28 10:26:43', 146, 1, '5207481', '', 14, 1),
(151, 2, 'Asistente', 'jvillarreal', '6e028e9e800adf8295821dc6c72f5658', '78b0cdb35bcfe9f3f9f16202219dcc0c', 'jvillarreal@innovacion.gob.pa', 'Jenny', 'Villarreal', 1, 1, NULL, '2014-04-15 16:23:47', '2014-04-15 16:23:47', 139, 1, '5207409', '', 1, 1),
(152, 2, 'Asistente de Tesoreria ', 'kpalomino', '5baa5f447013765bcfd27d3ed544388b', 'aba722972896981c1bca21f92a6894cb', 'kpalomino@innovacion.gob.pa', 'Kirania ', 'Palomino', 1, 1, NULL, '2014-04-16 07:51:23', '2014-04-16 07:51:23', 151, 1, '5207488', '67822854', 1, 1),
(153, 2, 'Supervisor de Operaciones', 'rrivas', '943d4abb29ebfe0cb9cdc0eccfe65740', 'c051406402a6422528c50f1ddf107b3d', 'rrivas@innovacion.gob.pa', 'Ruth', 'Rivas', 1, 1, NULL, '2014-04-16 07:54:08', '2014-04-16 07:54:08', 173, 1, '5207508', '69313266', 1, 1),
(154, 2, 'Abogada III ', 'acastro', 'c14e4c6a0abc9d837d2f899862d0859a', 'b99fbcddf8f9cc7433068c02ade62bc2', 'acastro@innovacion.gob.pa', 'Ana Cristina', 'Castro Vernaza', 1, 1, NULL, '2014-04-16 07:56:00', '2014-05-28 10:26:01', 157, 1, '5207419', '66072068', 14, 1),
(155, 2, 'Director de la Junta Asesora', 'cdiaz', '5711a4deb0d3eedb3ba4a4f4b976e6ba', 'ea51156f665496a8f54196b5a23eab7e', 'cdiaz@innovacion.gob.pa', 'Carlos Iván ', 'Díaz Díaz ', 1, 1, NULL, '2014-04-16 07:58:09', '2014-04-16 07:58:09', 163, 1, '520-7450', '66701114', 1, 1),
(156, 2, 'Jefe de Auditoría Interna', 'ggonzalez', '3c4a486df74b035dd253bbdc3183bc31', 'f80396c1c483e2da67dc1fdd491d82e5', 'ggonzalez@innovacion.gob.pa', 'Gisela ', 'González', 1, 1, NULL, '2014-04-16 08:00:00', '2014-04-16 08:00:00', 141, 1, '5207439', '62634264', 1, 1),
(157, 2, 'Contadora I', 'mdiaz', '244d55497c5f2b115166a4b674270f09', '852449de4248f2db6624db6ed691dedb', 'mdiaz@innovacion.gob.pa', 'María', 'Díaz', 1, 1, NULL, '2014-04-16 08:07:37', '2014-04-16 08:07:37', 149, 1, '5207516', '65377565', 1, 1),
(158, 2, 'Secretaria de compras', 'matencio', '9c76b04cc29aff89c5dbe6445c70df30', '28d4ab59ce22e41047f63127e19f0017', 'matencio@innovacion.gob.pa', 'Mitzaida Edith', 'Atencio Toribio', 1, 1, NULL, '2014-04-16 08:09:52', '2014-04-16 08:09:52', 146, 1, '5207480', '68440177', 1, 1),
(159, 2, 'Analista Programador de Sistemas informáticos', 'aaflores', 'd4fdf633964cbd1b1bbc8dde64af9958', '45a86fcf9a8c9b222f94e072c838105f', 'aaflores@innovacion.gob.pa', 'Alexis Anibal', 'Flores Valdes', 1, 1, NULL, '2014-04-16 08:11:33', '2014-05-28 10:23:17', 159, 1, '5207473', '', 14, 1),
(160, 2, 'Cotizador', 'zgonzalez', '76de6949878319f3cb190772eb5f5216', '163b4ffd205ed94f34f202c6920ebd50', 'zgonzalez@innovacion.gob.pa', 'Zulma del Carmen', 'González Diamantópulos', 1, 1, NULL, '2014-04-16 08:31:03', '2014-04-16 08:31:03', 146, 1, '5207524', '', 1, 1),
(161, 2, 'Evaluación de Proyectos II', 'mrodriguez', '94c877c13ef0aeafbc18df1f3b2e08e8', '39d792115fa4fe6108c2cb7d9fce4cc1', 'mrodriguez@innovacion.gob.pa', 'Maricela', 'Rodríguez', 1, 1, NULL, '2014-04-16 08:32:43', '2014-04-16 08:32:43', 164, 1, '5207547', '', 1, 1),
(162, 2, 'Directora de Gobierno Digital', 'kortega', '2c25529e97e056afd20f4a8017e19278', '69ae06194a02cfb3ce17715905738e20', 'kortega@innovacion.gob.pa', 'Karen Haidee', 'Ortega Cornejo', 1, 1, NULL, '2014-04-16 08:37:32', '2014-04-16 08:37:32', 164, 1, '520-7446', '69491987', 1, 1),
(163, 2, 'Ayudante General', 'agobea', '058053d543d91aa88b1ea888d735ee52', 'd65378d366c14d29df23b2db44a9c27a', 'agobea@innovacion.gob.pa', 'Andres', 'Gobea', 1, 1, NULL, '2014-04-16 09:11:48', '2014-05-28 10:27:24', 145, 1, '5207400', '', 14, 1),
(164, 2, 'Conductor', 'amagallon', '5833276bc4213a09db7e1654f9e9e509', '739333ce112032a8eac45b8c8c027874', 'amagallon@innovacion.gob.pa', 'Alex', 'Magallón', 1, 1, NULL, '2014-04-16 09:13:12', '2014-05-28 10:22:39', 145, 1, '5207400', '', 14, 1),
(165, 2, 'Ayudante General', 'alio', '344ed99aab886659d8e5da6985e8fa02', 'fd4a0a1670387c6c9b93abc571231bfe', 'alio@innovacion.gob.pa', 'Ana', 'Lio', 1, 1, NULL, '2014-04-16 09:14:23', '2014-05-28 10:25:26', 145, 1, '5207400', '', 14, 1),
(166, 2, 'Ayudante General', 'lchery', '972bd50c1d3db1a4523f7b10bb9a1620', '95bf4ea035338913ae6ff89ed467c5e0', 'lchery@innovacion.gob.pa', 'Lionel', 'Chery', 1, 1, NULL, '2014-04-16 09:15:45', '2014-04-16 09:15:45', 145, 1, '5207400', '', 1, 1),
(167, 2, 'Ayudante General', 'csanchez', '6df89cd51a98c15cf60d4ec3ab0a2eef', 'ee54e513758bce535867f9d2a1be3eed', 'csanchez@innovacion.gob.pa', 'Carlos', 'Sánchez', 1, 1, NULL, '2014-04-16 09:16:55', '2014-04-16 09:16:55', 145, 1, '5207400', '', 1, 1),
(168, 2, 'Ayudante General', 'marias', 'd287a3014379222e1bf60b1e76cbe05c', 'a8cccd4f97f82c25b2792c830368346d', 'marias@innovacion.gob.pa', 'Manuel ', 'Arias', 1, 1, NULL, '2014-04-16 09:18:25', '2014-04-16 09:18:25', 145, 1, '5207400', '', 1, 1),
(169, 2, 'Director del Centro de Atención Ciudadana (311)', 'rcaballero', '1bf08fd6400d157de6153cd111003a4f', '5866011f06c5b19d4d6f8ad7ca7764d9', 'rcaballero@innovacion.gob.pa', 'Rodolfo', 'Caballero', 1, 1, NULL, '2014-04-16 09:31:11', '2014-04-16 09:31:11', 172, 1, '5207400', '', 1, 1),
(170, 2, 'Conductor', 'mcoronado', '84b2a70ba38251d58714433260b48727', 'b3fa01deb343fafc7fa95f39831d0977', 'mcoronado@innovacion.gob.pa', 'Máximo', 'Coronado', 1, 1, NULL, '2014-04-16 09:32:45', '2014-04-16 09:32:45', 145, 1, '5207400', '', 1, 1),
(171, 2, 'Coordinadora de Planes y Programas', 'mventura', '87cd8ad1ae02a3ff81030f510de30bee', 'b6a21670d39b80ab863781653f57709b', 'mventura@innovacion.gob.pa', 'María Mercedes', 'Ventura de Chalhoub', 1, 1, NULL, '2014-04-16 10:48:47', '2014-04-16 10:48:47', 155, 1, '5207442', '60308942', 1, 1),
(172, 2, 'Asistente Técnico', 'fguardia', '8556103f754c930936099ee983e8f268', '35e8f9aaa369a2217479b8b578e9db92', 'fguardia@innovacion.gob.pa', 'Felipe', 'De La Guardia', 1, 1, NULL, '2014-04-16 15:04:37', '2014-04-16 15:04:37', 169, 1, '', '62282871', 1, 1),
(173, 2, 'Coordinador de Planes y Proyectos', 'echarter', '6367f4052a2f1c906bdd5a775bae8f79', 'a900b2184a038140d42e56966a19a7c2', 'echarter@innovacion.gob.pa', 'Ernesto Rogelio', 'Charter Sánchez', 1, 1, NULL, '2014-04-16 15:06:50', '2014-04-16 15:06:50', 164, 1, '5207400', '63831300', 1, 1),
(174, 2, 'Jefe de Supervisión Tecnológica', 'mquintero', '928d45af78d59a5e9b6b3efe1c485dfa', '6ee86a3e5fb80adfded238f1d01bdc35', 'mquintero@innovacion.gob.pa', 'Manuel Ezequiel', 'Quintero Trinquete', 1, 1, NULL, '2014-04-16 15:09:00', '2014-04-16 15:09:00', 154, 1, '5207447', '66755383', 1, 1),
(175, 2, 'Encargado de Almacén', 'lmoran', 'a6845af5b7c41b2664d1ea1408c5c9c6', 'bde6385bf54861c80a67e49b9c89d5d1', 'lmoran@innovacion.gob.pa', 'Luis Carlos ', 'Morán Moreno', 1, 1, NULL, '2014-04-16 15:54:14', '2014-04-16 15:54:14', 146, 1, '5207482', '66919389', 1, 1),
(176, 2, 'Analista de Organización y Sistemas', 'mcontreras@innovacion.gob.pa', '7f63aea1a4188a23d019a63e10d560bf', '8cda5167aadc447e46811731e3d5f1f3', 'mcontreras@innovacion.gob.pa', 'Myriam', 'Contreras', 1, 1, NULL, '2014-04-16 15:57:10', '2014-04-16 15:57:10', 154, 1, '5207469', '', 1, 1),
(177, 2, 'Coordinadora de Planes y Programas', 'yrios', '7dedce444fa052a8e0ed3d0344e6eb01', 'c44633f22a50f5b279889579b5e531a6', 'yrios@innovacion.gob.pa', 'Yasmín Elizabeth', 'Ríos Araúz', 1, 1, NULL, '2014-04-16 15:59:11', '2014-04-16 15:59:11', 142, 1, '5207413', '68769252', 1, 1),
(178, 2, 'Analista de Sistemas', 'nvelasquez', 'f4c4d84df37a1ebc3e6d03668757b306', '5df63ae37346027e2b25dd3468846d78', 'nvelasquez@innovacion.gob.pa', 'Nicolas', 'Velasquez', 1, 1, NULL, '2014-04-16 16:01:41', '2014-04-16 16:01:41', 168, 1, '5207400', '', 1, 1),
(179, 2, 'Social Media Manager', 'faskha', '79e03c0402c663fdde6e76f406c73043', '1b5730b64ebb90681da374ac58710750', 'faskha@gmail.com', 'Esther', 'Faskha', 1, 1, NULL, '2014-04-16 16:03:22', '2014-04-16 16:03:22', 167, 1, '5207435', '60709013', 1, 1),
(180, 2, 'Jefe Supervision Tecnologica', 'barosemena', '8ef4986706754102fbb3b3c306e16634', '6679c347dd2446f9ed866c583a250649', 'barosemena@innovacion.gob.pa', 'Betty', 'Arosemena', 1, 1, NULL, '2014-04-16 16:05:27', '2014-04-16 16:05:27', 167, 1, '5207431', '', 1, 1),
(181, 2, 'Director de Arquitectura Tecnologica', 'ebriceno', '463f903d15f56f7fb5d40fe2c951e3bb', '43df3987ca2427367baeadfb07febd10', 'ebriceno@innovacion.gob.pa', 'Eduardo', 'Briceño', 1, 1, NULL, '2014-04-16 16:09:09', '2014-04-16 16:09:09', 172, 1, '5207434', '66729039', 1, 1),
(182, 2, 'Directora de Administración Ejecutiva', 'olezcano', '4cbdc6ede3fb080976df08660107898a', '68dc424f695040e76da63bc611b76f23', 'olezcano@innovacion.gob.pa', 'Olmaris', 'Lezcano de Araúz', 1, 1, NULL, '2014-04-16 16:11:46', '2014-04-16 16:11:46', 142, 1, '5207406', '', 1, 1),
(183, 2, 'Asistente Administrativo I', 'jnunez', 'e6b9bb21b7da43583ce8e36b2867c86d', 'fb2fb513e57cb45596d34de127098106', 'jnunez@innovacion.gob.pa', 'Elsie Janeth', 'Núñez Pérez', 1, 1, NULL, '2014-05-14 11:55:34', '2014-05-14 11:55:34', 163, 1, '5207428', '', 14, 1),
(184, 2, 'Coordinadora de Proyectos', 'omoreno', 'ad6de93eb9f4a8f9bb8cd4c01ba23731', '120b1aa4830958d620754b3d8fdc8541', 'omoreno@innovacion.gob.pa', 'Orly', 'Moreno', 1, 1, NULL, '2014-05-14 11:57:22', '2014-05-14 11:57:22', 165, 1, '5207422', '66791925', 14, 1),
(185, 2, 'Analista De Sistemas y Metodos Informaticos', 'ccogley@innovacion.gob.pa', '0e0add534247b7401f065ed948c31bcb', '781d9531019f5e83ea1d1f4bebe05971', 'ccogley@innovacion.gob.pa', 'Christopher ', 'Cogley', 1, 1, NULL, '2014-05-14 11:59:08', '2014-05-14 11:59:08', 168, 1, '520-7400', '', 14, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_circles`
--

DROP TABLE IF EXISTS `user_circles`;
CREATE TABLE IF NOT EXISTS `user_circles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'id del usuario',
  `circle_id` int(11) NOT NULL COMMENT 'id del grupo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='contiene los usuarios que estan en un grupo' AUTO_INCREMENT=44 ;

--
-- Volcado de datos para la tabla `user_circles`
--

INSERT INTO `user_circles` (`id`, `user_id`, `circle_id`) VALUES
(34, 44, 8),
(35, 43, 9),
(36, 45, 10),
(37, 86, 11),
(38, 86, 12),
(39, 45, 13),
(40, 45, 14),
(41, 89, 9),
(42, 102, 15),
(43, 109, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
CREATE TABLE IF NOT EXISTS `user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `alias_name` varchar(100) DEFAULT NULL,
  `allowRegistration` int(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `user_groups`
--

INSERT INTO `user_groups` (`id`, `name`, `alias_name`, `allowRegistration`, `created`, `modified`) VALUES
(1, 'Super', 'super', 0, '2013-09-25 13:27:49', '2013-10-02 14:36:10'),
(2, 'Usuario', 'User', 1, '2013-09-25 13:27:49', '2013-10-02 13:55:59'),
(3, 'Administrador', 'administrador', 0, '2013-09-25 13:27:49', '2013-12-12 16:47:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_group_permissions`
--

DROP TABLE IF EXISTS `user_group_permissions`;
CREATE TABLE IF NOT EXISTS `user_group_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_group_id` int(10) unsigned NOT NULL,
  `controller` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `action` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `allowed` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=283 ;

--
-- Volcado de datos para la tabla `user_group_permissions`
--

INSERT INTO `user_group_permissions` (`id`, `user_group_id`, `controller`, `action`, `allowed`) VALUES
(1, 1, 'Pages', 'display', 1),
(2, 2, 'Pages', 'display', 1),
(3, 3, 'Pages', 'display', 1),
(4, 1, 'UserGroupPermissions', 'index', 1),
(5, 2, 'UserGroupPermissions', 'index', 0),
(6, 3, 'UserGroupPermissions', 'index', 0),
(7, 1, 'UserGroupPermissions', 'update', 1),
(8, 2, 'UserGroupPermissions', 'update', 0),
(9, 3, 'UserGroupPermissions', 'update', 0),
(10, 1, 'UserGroups', 'index', 1),
(11, 2, 'UserGroups', 'index', 0),
(12, 3, 'UserGroups', 'index', 0),
(13, 1, 'UserGroups', 'addGroup', 1),
(14, 2, 'UserGroups', 'addGroup', 0),
(15, 3, 'UserGroups', 'addGroup', 0),
(16, 1, 'UserGroups', 'editGroup', 1),
(17, 2, 'UserGroups', 'editGroup', 0),
(18, 3, 'UserGroups', 'editGroup', 0),
(19, 1, 'UserGroups', 'deleteGroup', 1),
(20, 2, 'UserGroups', 'deleteGroup', 0),
(21, 3, 'UserGroups', 'deleteGroup', 0),
(22, 1, 'Users', 'index', 1),
(23, 2, 'Users', 'index', 0),
(24, 3, 'Users', 'index', 1),
(25, 1, 'Users', 'viewUser', 1),
(26, 2, 'Users', 'viewUser', 0),
(27, 3, 'Users', 'viewUser', 1),
(28, 1, 'Users', 'myprofile', 1),
(29, 2, 'Users', 'myprofile', 1),
(30, 3, 'Users', 'myprofile', 1),
(31, 1, 'Users', 'login', 1),
(32, 2, 'Users', 'login', 1),
(33, 3, 'Users', 'login', 1),
(34, 1, 'Users', 'logout', 1),
(35, 2, 'Users', 'logout', 1),
(36, 3, 'Users', 'logout', 1),
(37, 1, 'Users', 'register', 1),
(38, 2, 'Users', 'register', 0),
(39, 3, 'Users', 'register', 1),
(40, 1, 'Users', 'changePassword', 1),
(41, 2, 'Users', 'changePassword', 1),
(42, 3, 'Users', 'changePassword', 1),
(43, 1, 'Users', 'changeUserPassword', 1),
(44, 2, 'Users', 'changeUserPassword', 0),
(45, 3, 'Users', 'changeUserPassword', 1),
(46, 1, 'Users', 'addUser', 1),
(47, 2, 'Users', 'addUser', 0),
(48, 3, 'Users', 'addUser', 1),
(49, 1, 'Users', 'editUser', 1),
(50, 2, 'Users', 'editUser', 0),
(51, 3, 'Users', 'editUser', 1),
(52, 1, 'Users', 'dashboard', 1),
(53, 2, 'Users', 'dashboard', 1),
(54, 3, 'Users', 'dashboard', 1),
(55, 1, 'Users', 'deleteUser', 1),
(56, 2, 'Users', 'deleteUser', 0),
(57, 3, 'Users', 'deleteUser', 1),
(58, 1, 'Users', 'makeActive', 1),
(59, 2, 'Users', 'makeActive', 0),
(60, 3, 'Users', 'makeActive', 0),
(61, 1, 'Users', 'accessDenied', 1),
(62, 2, 'Users', 'accessDenied', 1),
(63, 3, 'Users', 'accessDenied', 1),
(64, 1, 'Users', 'userVerification', 1),
(65, 2, 'Users', 'userVerification', 1),
(66, 3, 'Users', 'userVerification', 1),
(67, 1, 'Users', 'forgotPassword', 1),
(68, 2, 'Users', 'forgotPassword', 1),
(69, 3, 'Users', 'forgotPassword', 1),
(70, 1, 'Users', 'makeActiveInactive', 1),
(71, 2, 'Users', 'makeActiveInactive', 0),
(72, 3, 'Users', 'makeActiveInactive', 1),
(73, 1, 'Users', 'verifyEmail', 1),
(74, 2, 'Users', 'verifyEmail', 0),
(75, 3, 'Users', 'verifyEmail', 1),
(76, 1, 'Users', 'activatePassword', 1),
(77, 2, 'Users', 'activatePassword', 1),
(78, 3, 'Users', 'activatePassword', 1),
(79, 1, 'Entities', 'index', 1),
(80, 2, 'Entities', 'index', 0),
(81, 3, 'Entities', 'index', 1),
(82, 1, 'Entities', 'children', 1),
(83, 2, 'Entities', 'children', 1),
(84, 3, 'Entities', 'children', 1),
(85, 1, 'Entities', 'add', 1),
(86, 2, 'Entities', 'add', 0),
(87, 3, 'Entities', 'add', 1),
(88, 1, 'Entities', 'delete', 1),
(89, 2, 'Entities', 'delete', 0),
(90, 3, 'Entities', 'delete', 1),
(91, 1, 'Users', 'addUser2', 0),
(92, 2, 'Users', 'addUser2', 0),
(93, 3, 'Users', 'addUser2', 0),
(94, 1, 'Users', 'emailVerification', 0),
(95, 2, 'Users', 'emailVerification', 0),
(96, 3, 'Users', 'emailVerification', 0),
(97, 1, 'Communications', 'index', 0),
(98, 2, 'Communications', 'index', 1),
(99, 3, 'Communications', 'index', 0),
(100, 1, 'Communications', 'add', 0),
(101, 2, 'Communications', 'add', 1),
(102, 3, 'Communications', 'add', 0),
(103, 1, 'Communications', 'reply', 0),
(104, 2, 'Communications', 'reply', 1),
(105, 3, 'Communications', 'reply', 0),
(106, 1, 'Communications', 'view', 0),
(107, 2, 'Communications', 'view', 1),
(108, 3, 'Communications', 'view', 0),
(109, 1, 'Communications', 'findUsersAndEntities', 0),
(110, 2, 'Communications', 'findUsersAndEntities', 1),
(111, 3, 'Communications', 'findUsersAndEntities', 0),
(112, 1, 'Communications', 'getNewCommunications', 0),
(113, 2, 'Communications', 'getNewCommunications', 1),
(114, 3, 'Communications', 'getNewCommunications', 0),
(115, 1, 'Communications', 'getNewInteractions', 0),
(116, 2, 'Communications', 'getNewInteractions', 1),
(117, 3, 'Communications', 'getNewInteractions', 0),
(118, 1, 'Tags', 'add', 0),
(119, 2, 'Tags', 'add', 1),
(120, 3, 'Tags', 'add', 0),
(121, 1, 'Tags', 'findTags', 0),
(122, 2, 'Tags', 'findTags', 1),
(123, 3, 'Tags', 'findTags', 0),
(124, 1, 'Tags', 'delete', 0),
(125, 2, 'Tags', 'delete', 1),
(126, 3, 'Tags', 'delete', 0),
(127, 1, 'Tags', 'index', 0),
(128, 2, 'Tags', 'index', 1),
(129, 3, 'Tags', 'index', 0),
(130, 1, 'Entities', 'find', 1),
(131, 2, 'Entities', 'find', 0),
(132, 3, 'Entities', 'find', 1),
(133, 1, 'Users', 'findUsers', 1),
(134, 2, 'Users', 'findUsers', 1),
(135, 3, 'Users', 'findUsers', 1),
(136, 1, 'Handler', 'index', 1),
(137, 2, 'Handler', 'index', 1),
(138, 3, 'Handler', 'index', 1),
(139, 1, 'FileUpload', 'index', 0),
(140, 2, 'FileUpload', 'index', 0),
(141, 3, 'FileUpload', 'index', 0),
(142, 1, 'Communications', 'redirection', 0),
(143, 2, 'Communications', 'redirection', 0),
(144, 3, 'Communications', 'redirection', 0),
(145, 1, 'Redirections', 'add', 0),
(146, 2, 'Redirections', 'add', 1),
(147, 3, 'Redirections', 'add', 0),
(148, 1, 'Redirections', 'delete', 0),
(149, 2, 'Redirections', 'delete', 1),
(150, 3, 'Redirections', 'delete', 0),
(151, 1, 'Redirections', 'index', 0),
(152, 2, 'Redirections', 'index', 1),
(153, 3, 'Redirections', 'index', 0),
(154, 1, 'Users', 'directory', 0),
(155, 2, 'Users', 'directory', 1),
(156, 3, 'Users', 'directory', 0),
(157, 1, 'Communications', 'download', 0),
(158, 2, 'Communications', 'download', 1),
(159, 3, 'Communications', 'download', 0),
(160, 1, 'Users', 'setPassword', 1),
(161, 2, 'Users', 'setPassword', 1),
(162, 3, 'Users', 'setPassword', 1),
(163, 1, 'Communications', 'documentsVisible', 0),
(164, 2, 'Communications', 'documentsVisible', 1),
(165, 3, 'Communications', 'documentsVisible', 0),
(166, 1, 'Communications', 'updateVisible', 0),
(167, 2, 'Communications', 'updateVisible', 0),
(168, 3, 'Communications', 'updateVisible', 0),
(169, 1, 'Entities', 'findAllPeople', 0),
(170, 2, 'Entities', 'findAllPeople', 1),
(171, 3, 'Entities', 'findAllPeople', 0),
(172, 1, 'CommunicationCategories', 'edit', 1),
(173, 2, 'CommunicationCategories', 'edit', 0),
(174, 3, 'CommunicationCategories', 'edit', 1),
(175, 1, 'CommunicationCategories', 'add', 1),
(176, 2, 'CommunicationCategories', 'add', 0),
(177, 3, 'CommunicationCategories', 'add', 1),
(178, 1, 'CommunicationCategories', 'index', 1),
(179, 2, 'CommunicationCategories', 'index', 0),
(180, 3, 'CommunicationCategories', 'index', 1),
(181, 1, 'CommunicationTypes', 'edit', 1),
(182, 2, 'CommunicationTypes', 'edit', 0),
(183, 3, 'CommunicationTypes', 'edit', 1),
(184, 1, 'CommunicationTypes', 'add', 1),
(185, 2, 'CommunicationTypes', 'add', 0),
(186, 3, 'CommunicationTypes', 'add', 1),
(187, 1, 'CommunicationTypes', 'index', 1),
(188, 2, 'CommunicationTypes', 'index', 0),
(189, 3, 'CommunicationTypes', 'index', 1),
(190, 1, 'Communications', 'documents', 1),
(191, 2, 'Communications', 'documents', 0),
(192, 3, 'Communications', 'documents', 1),
(193, 1, 'Formats', 'index', 1),
(194, 2, 'Formats', 'index', 0),
(195, 3, 'Formats', 'index', 1),
(196, 1, 'Formats', 'add', 1),
(197, 2, 'Formats', 'add', 0),
(198, 3, 'Formats', 'add', 1),
(199, 1, 'Formats', 'edit', 1),
(200, 2, 'Formats', 'edit', 0),
(201, 3, 'Formats', 'edit', 1),
(202, 1, 'Formats', 'updateVisible', 1),
(203, 2, 'Formats', 'updateVisible', 1),
(204, 3, 'Formats', 'updateVisible', 1),
(205, 1, 'Formats', 'documentsVisible', 1),
(206, 2, 'Formats', 'documentsVisible', 1),
(207, 3, 'Formats', 'documentsVisible', 1),
(208, 1, 'Communications', 'directory', 0),
(209, 2, 'Communications', 'directory', 1),
(210, 3, 'Communications', 'directory', 0),
(211, 1, 'Communications', 'draft', 0),
(212, 2, 'Communications', 'draft', 1),
(213, 3, 'Communications', 'draft', 0),
(214, 1, 'Traces', 'delete', 0),
(215, 2, 'Traces', 'delete', 1),
(216, 3, 'Traces', 'delete', 0),
(217, 1, 'CommunicationCategories', 'findByCommunicationTypeId', 0),
(218, 2, 'CommunicationCategories', 'findByCommunicationTypeId', 1),
(219, 3, 'CommunicationCategories', 'findByCommunicationTypeId', 0),
(220, 1, 'Communications', 'deletePreUpload', 0),
(221, 2, 'Communications', 'deletePreUpload', 1),
(222, 3, 'Communications', 'deletePreUpload', 0),
(223, 1, 'Communications', 'edit', 0),
(224, 2, 'Communications', 'edit', 1),
(225, 3, 'Communications', 'edit', 0),
(226, 1, 'Groups', 'findPeopleByGoup', 0),
(227, 2, 'Groups', 'findPeopleByGoup', 1),
(228, 3, 'Groups', 'findPeopleByGoup', 0),
(229, 1, 'Communications', 'setTrash', 0),
(230, 2, 'Communications', 'setTrash', 1),
(231, 3, 'Communications', 'setTrash', 0),
(232, 1, 'Circles', 'index', 0),
(233, 2, 'Circles', 'index', 1),
(234, 3, 'Circles', 'index', 0),
(235, 1, 'Circles', 'view', 0),
(236, 2, 'Circles', 'view', 1),
(237, 3, 'Circles', 'view', 0),
(238, 1, 'Circles', 'add', 0),
(239, 2, 'Circles', 'add', 1),
(240, 3, 'Circles', 'add', 0),
(241, 1, 'Circles', 'edit', 0),
(242, 2, 'Circles', 'edit', 1),
(243, 3, 'Circles', 'edit', 0),
(244, 1, 'Circles', 'delete', 0),
(245, 2, 'Circles', 'delete', 1),
(246, 3, 'Circles', 'delete', 0),
(247, 1, 'Circles', 'getMembersByCircleId', 0),
(248, 2, 'Circles', 'getMembersByCircleId', 1),
(249, 3, 'Circles', 'getMembersByCircleId', 0),
(250, 1, 'Circles', 'getCircleById', 0),
(251, 2, 'Circles', 'getCircleById', 1),
(252, 3, 'Circles', 'getCircleById', 0),
(253, 1, 'Circles', 'addUserToCircle', 0),
(254, 2, 'Circles', 'addUserToCircle', 1),
(255, 3, 'Circles', 'addUserToCircle', 0),
(256, 1, 'Circles', 'deleteUserFromCircle', 0),
(257, 2, 'Circles', 'deleteUserFromCircle', 1),
(258, 3, 'Circles', 'deleteUserFromCircle', 0),
(259, 1, 'Circles', 'myCircles', 0),
(260, 2, 'Circles', 'myCircles', 1),
(261, 3, 'Circles', 'myCircles', 0),
(262, 1, 'Circles', 'outFromCircle', 0),
(263, 2, 'Circles', 'outFromCircle', 1),
(264, 3, 'Circles', 'outFromCircle', 0),
(265, 1, 'Circles', 'findPeopleByGoup', 0),
(266, 2, 'Circles', 'findPeopleByGoup', 1),
(267, 3, 'Circles', 'findPeopleByGoup', 0),
(268, 1, 'Circles', 'findPeopleByCircle', 0),
(269, 2, 'Circles', 'findPeopleByCircle', 1),
(270, 3, 'Circles', 'findPeopleByCircle', 0),
(271, 1, 'Communications', 'forward', 0),
(272, 2, 'Communications', 'forward', 1),
(273, 3, 'Communications', 'forward', 0),
(274, 1, 'Entities', 'newParent', 1),
(275, 2, 'Entities', 'newParent', 0),
(276, 3, 'Entities', 'newParent', 1),
(277, 1, 'Entities', 'orderTree', 1),
(278, 2, 'Entities', 'orderTree', 0),
(279, 3, 'Entities', 'orderTree', 1),
(280, 1, 'Entities', 'edit', 1),
(281, 2, 'Entities', 'edit', 0),
(282, 3, 'Entities', 'edit', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
