-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 21-02-2014 a las 22:07:57
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.4.3

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

CREATE TABLE IF NOT EXISTS `circles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) NOT NULL COMMENT 'nombre del grupo',
  `active` int(11) NOT NULL DEFAULT '1' COMMENT 'indica si esta activo',
  `user_id` int(11) NOT NULL COMMENT 'id del usuario creador',
  `type` int(11) NOT NULL COMMENT '0 privado 1 publico',
  `created` datetime NOT NULL COMMENT 'fecha de creado',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='contiene los irculos creados' AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `circles`
--

INSERT INTO `circles` (`id`, `name`, `active`, `user_id`, `type`, `created`) VALUES
(1, 'Circulo A', 1, 2, 2, '2014-02-20 12:52:43'),
(2, 'Circulo B', 0, 2, 2, '2014-02-20 13:09:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `communications`
--

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `communications`
--

INSERT INTO `communications` (`id`, `entity_id`, `user_id`, `created`, `modified`, `communication_type_id`, `communication_category_id`, `action_id`, `draft`) VALUES
(1, 3, 2, '2014-02-04 09:32:10', '2014-02-04 09:32:10', 1, 11, 1, 0),
(2, 3, 2, '2014-02-04 10:17:19', '2014-02-04 10:17:19', 1, 11, 3, 0),
(3, 3, 2, '2014-02-04 10:58:58', '2014-02-04 10:58:58', 2, 8, 4, 0),
(4, 17, 17, '2014-02-04 11:10:53', '2014-02-04 11:10:53', 1, 11, 3, 0),
(5, 3, 2, '2014-02-04 11:21:04', '2014-02-04 13:34:45', 1, 11, 3, 0),
(6, 3, 2, '2014-02-04 11:21:55', '2014-02-04 11:21:55', 1, 13, 5, 1),
(7, 3, 2, '2014-02-04 12:31:19', '2014-02-04 13:47:53', 1, 11, 4, 0),
(8, 3, 2, '2014-02-04 12:55:09', '2014-02-04 12:55:09', 2, 8, 1, 0),
(9, 17, 17, '2014-02-04 14:31:31', '2014-02-04 14:31:31', 1, 11, 0, 1),
(10, 3, 2, '2014-02-05 11:30:40', '2014-02-05 15:00:30', 1, 11, 0, 1),
(11, 3, 2, '2014-02-10 10:14:13', '2014-02-10 10:33:31', 1, 13, 1, 0),
(12, 3, 2, '2014-02-10 10:16:32', '2014-02-10 10:16:32', 2, NULL, 0, 1),
(13, 3, 2, '2014-02-17 09:19:29', '2014-02-17 09:19:29', 1, 11, 2, 0),
(14, 3, 2, '2014-02-17 09:26:13', '2014-02-17 09:26:13', 1, 11, 2, 0),
(15, 3, 2, '2014-02-17 10:08:23', '2014-02-17 10:08:23', 1, 13, 5, 0),
(16, 17, 17, '2014-02-17 13:23:38', '2014-02-17 13:23:38', 1, 13, 5, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `communication_categories`
--

CREATE TABLE IF NOT EXISTS `communication_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) DEFAULT NULL,
  `active` int(11) DEFAULT '1',
  `communication_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Volcado de datos para la tabla `communication_categories`
--

INSERT INTO `communication_categories` (`id`, `name`, `active`, `communication_type_id`) VALUES
(1, 'Categoria A', 1, 2),
(2, 'Categoria C', 0, 2),
(3, 'Categoria B', 1, 3),
(4, 'Categoria E', 0, 4),
(5, 'Categoria 1', 1, 3),
(6, 'categoria 2', 1, 3),
(7, 'categoria 6', 1, 4),
(8, 'categoria 7', 1, 2),
(9, 'categoria 8', 1, 3),
(10, 'categoria 9', 1, 4),
(11, 'categoria 10', 1, 1),
(12, 'categoria 11', 1, 3),
(13, 'categoria 12', 1, 1),
(14, 'categoria 13', 1, 1),
(15, 'categoria 14', 1, 2),
(16, 'categoria 15', 1, 2),
(17, 'categoria 16', 1, 3),
(18, 'categoria 17', 1, 5),
(19, 'categoria 18', 1, 1),
(20, 'categoria 19', 0, 2),
(21, 'categoria 20', 1, 3),
(22, 'categoria 21', 1, 4),
(23, 'categoria 22', 1, 3),
(24, 'categoria 23', 1, 2),
(25, 'categoria 10', 1, 1),
(26, 'Prueba Z', 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `communication_tokens`
--

CREATE TABLE IF NOT EXISTS `communication_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `communication_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Volcado de datos para la tabla `communication_tokens`
--

INSERT INTO `communication_tokens` (`id`, `communication_id`, `user_id`) VALUES
(1, 1, 2),
(2, 2, 17),
(3, 3, 17),
(4, 4, 2),
(6, 6, 17),
(8, 8, 17),
(9, 5, 2),
(10, 7, 2),
(11, 9, 21),
(12, 9, 22),
(13, 9, 17),
(14, 10, 21),
(15, 10, 22),
(16, 10, 17),
(17, 11, 21),
(18, 11, 22),
(21, 12, 21),
(22, 12, 22),
(23, 12, 17),
(24, 12, 44),
(25, 11, 2),
(28, 11, 2),
(29, 11, 21),
(30, 11, 22),
(31, 11, 17),
(33, 11, 21),
(34, 11, 22),
(35, 11, 17),
(36, 11, 44),
(37, 13, 21),
(38, 13, 22),
(39, 13, 17),
(40, 14, 21),
(41, 14, 22),
(42, 14, 17),
(43, 15, 21),
(44, 15, 22),
(45, 15, 17),
(46, 16, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `communication_trashs`
--

CREATE TABLE IF NOT EXISTS `communication_trashs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `communication_id` int(11) NOT NULL COMMENT 'id de la comunicacion',
  `user_id` int(11) NOT NULL COMMENT 'id del usuario',
  `trash` int(11) NOT NULL COMMENT '0 si es visible, 1 en trash, 2 eliminado',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='contiene informacion sobre si la comunicacion esta en la papelera, visible o no' AUTO_INCREMENT=34 ;

--
-- Volcado de datos para la tabla `communication_trashs`
--

INSERT INTO `communication_trashs` (`id`, `communication_id`, `user_id`, `trash`) VALUES
(1, 1, 2, 0),
(2, 2, 2, 0),
(3, 2, 17, 0),
(4, 3, 2, 0),
(5, 3, 17, 1),
(6, 4, 17, 0),
(7, 4, 2, 1),
(8, 5, 2, 2),
(9, 5, 17, 0),
(10, 6, 2, 1),
(11, 6, 17, 0),
(12, 7, 2, 1),
(13, 7, 17, 0),
(14, 8, 2, 1),
(15, 8, 17, 1),
(16, 9, 17, 0),
(17, 10, 2, 0),
(18, 10, 17, 0),
(19, 11, 2, 0),
(20, 11, 17, 0),
(21, 11, 44, 0),
(22, 12, 2, 0),
(23, 12, 17, 0),
(24, 12, 44, 0),
(25, 11, 43, 0),
(26, 13, 2, 0),
(27, 13, 17, 0),
(28, 14, 2, 0),
(29, 14, 17, 0),
(30, 15, 2, 0),
(31, 15, 17, 0),
(32, 16, 17, 0),
(33, 16, 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `communication_types`
--

CREATE TABLE IF NOT EXISTS `communication_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) DEFAULT NULL,
  `active` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `communication_types`
--

INSERT INTO `communication_types` (`id`, `name`, `active`) VALUES
(1, 'Circular', 1),
(2, 'Memo', 1),
(3, 'Viático Interno', 1),
(4, 'Viático Extranjero ', 1),
(5, 'Invitación', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `communication_views`
--

CREATE TABLE IF NOT EXISTS `communication_views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `communication_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `last_view` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Volcado de datos para la tabla `communication_views`
--

INSERT INTO `communication_views` (`id`, `communication_id`, `user_id`, `last_view`) VALUES
(1, 1, 2, '2014-02-04 14:01:52'),
(2, 2, 2, '2014-02-17 13:56:28'),
(3, 3, 2, '2014-02-17 10:09:07'),
(4, 4, 17, '2014-02-17 10:34:34'),
(5, 5, 2, '2014-02-04 14:01:19'),
(6, 6, 2, '2014-02-04 11:21:55'),
(7, 7, 2, '2014-02-17 13:44:55'),
(8, 8, 2, '2014-02-17 13:45:15'),
(9, 4, 2, '2014-02-17 13:44:20'),
(10, 5, 17, '2014-02-04 13:34:12'),
(11, 7, 17, '2014-02-04 13:47:30'),
(12, 9, 17, '2014-02-04 14:31:31'),
(13, 10, 2, '2014-02-05 11:30:40'),
(14, 11, 2, '2014-02-20 08:59:57'),
(15, 12, 2, '2014-02-10 10:16:32'),
(16, 11, 17, '2014-02-17 10:32:53'),
(17, 11, 44, '2014-02-10 10:32:43'),
(18, 11, 43, '2014-02-10 10:49:35'),
(19, 13, 2, '2014-02-20 13:53:30'),
(20, 13, 17, '2014-02-17 09:19:58'),
(21, 14, 2, '2014-02-20 13:52:34'),
(22, 14, 17, '2014-02-17 10:05:59'),
(23, 15, 2, '2014-02-20 09:03:21'),
(24, 15, 17, '2014-02-17 13:24:56'),
(25, 16, 17, '2014-02-17 13:23:38'),
(26, 2, 17, '2014-02-17 13:29:33'),
(27, 16, 2, '2014-02-20 13:52:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control_views`
--

CREATE TABLE IF NOT EXISTS `control_views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `communication_id` int(11) NOT NULL,
  `sender_user_id` int(11) NOT NULL,
  `receive_user_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla que contiene por las personas que han leido una comunicacion por primera vez y quien lo manda no lo ha abierto' AUTO_INCREMENT=20 ;

--
-- Volcado de datos para la tabla `control_views`
--

INSERT INTO `control_views` (`id`, `communication_id`, `sender_user_id`, `receive_user_id`, `created`) VALUES
(3, 5, 17, 2, '2014-02-04 13:34:56'),
(5, 7, 17, 2, '2014-02-04 13:48:32'),
(10, 11, 44, 43, '2014-02-10 10:33:18'),
(13, 11, 44, 17, '2014-02-17 10:32:53'),
(14, 11, 43, 17, '2014-02-17 10:32:53'),
(17, 16, 17, 2, '2014-02-17 15:54:20'),
(18, 11, 17, 2, '2014-02-20 08:59:47'),
(19, 11, 44, 2, '2014-02-20 08:59:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entities`
--

CREATE TABLE IF NOT EXISTS `entities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `active` int(11) NOT NULL,
  `website` varchar(127) DEFAULT NULL,
  `lft` int(11) NOT NULL,
  `rght` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Volcado de datos para la tabla `entities`
--

INSERT INTO `entities` (`id`, `name`, `description`, `active`, `website`, `lft`, `rght`, `parent_id`) VALUES
(1, 'Entidades', 'nada', 1, NULL, 1, 124, 0),
(2, 'Ministerio de infraestructura', 'destruir calles', 1, NULL, 2, 21, 1),
(3, 'Ministerio de Hacienda', 'haciendas', 1, NULL, 22, 23, 1),
(4, 'Ministerio de Minas', 'las minas', 1, NULL, 24, 67, 1),
(5, 'Despacho de Bienes', 'biens', 1, NULL, 3, 12, 2),
(6, 'Despacho de Obras', 'obras', 1, NULL, 13, 14, 2),
(7, 'Servicios', 'descripcion', 1, NULL, 4, 9, 5),
(8, 'Entidad A', 'descipcion de la entidad A', 1, 'http://www.jehogo.com', 5, 6, 7),
(9, 'Finanzas', 'descripcion de la entidad de finanzas', 1, NULL, 10, 11, 5),
(10, 'Excabacion Maritima', 'descripcion de la excabacion', 1, NULL, 25, 44, 4),
(11, 'sadf', 'asdf sdf', 1, NULL, 26, 35, 10),
(12, 'sdfsdfsdf', 'sfdsdfs fsdf sdf', 1, NULL, 27, 28, 11),
(13, 'fsdfsdf', 'asdfasdfasdf asdf', 1, NULL, 36, 39, 10),
(14, 'ABC', 'sdfs', 1, NULL, 29, 30, 11),
(15, 'AABBCC', 'dsfaf', 1, NULL, 31, 32, 11),
(16, 'La cosa', 'sdf', 1, NULL, 33, 34, 11),
(17, 'La marina', 'asdf', 1, NULL, 40, 41, 10),
(18, 'Hola A', 'asdfasdf', 1, NULL, 42, 43, 10),
(19, 'Excabacion Terrestre', 'asfd', 1, NULL, 45, 60, 4),
(20, 'Division A', 'sdfsdf', 1, NULL, 46, 59, 19),
(21, 'Division A1', 'sdfsadf', 1, NULL, 47, 58, 20),
(22, 'Division A1a', 'sdf', 1, NULL, 48, 57, 21),
(23, 'Division B', 'asdf', 1, NULL, 37, 38, 13),
(24, 'Division n', 'asdf', 1, NULL, 49, 56, 22),
(25, 'Division N1', 'sdf', 1, NULL, 50, 55, 24),
(26, 'Division n1-2', '', 1, NULL, 51, 54, 25),
(27, 'Division N1-2-1', 'sdf', 1, NULL, 52, 53, 26),
(28, 'Excabacion Aerea', 'asdf', 1, NULL, 61, 66, 4),
(29, 'Division 1', 'sdf', 1, NULL, 62, 65, 28),
(30, 'Division 12', 'sdf', 1, NULL, 63, 64, 29),
(31, 'Ministerio de Agricultura', 'sdf', 1, NULL, 68, 69, 1),
(32, 'Ministerio del Deporte', 'sdf', 0, NULL, 70, 87, 1),
(33, 'Ministerio de la Salud', '', 1, NULL, 88, 89, 1),
(34, 'Ministerio de la Calidad de los Ministerios', 'sdf', 1, NULL, 90, 93, 1),
(35, 'Ministerio de la Mujer', 'asd', 0, NULL, 94, 99, 1),
(36, 'Despacho de las cuaimas', 'sdf', 1, NULL, 95, 98, 35),
(37, 'Menores de 16', 'sdf', 1, NULL, 96, 97, 36),
(38, 'Depuracion', 'dfsdf', 1, NULL, 91, 92, 34),
(39, 'Bicicletas', '21zsfd', 1, NULL, 71, 72, 32),
(40, 'Motos', 'asdf', 1, NULL, 73, 74, 32),
(41, 'Natacion', '2131dsf', 1, NULL, 75, 76, 32),
(42, 'Baseball', 'sdf sdf ', 1, NULL, 77, 78, 32),
(43, 'Cayoning', 'adsf asfd', 1, NULL, 79, 80, 32),
(44, 'Nado Sincronizado', 'sdf ', 1, NULL, 81, 82, 32),
(45, 'perol', 'sdf', 1, NULL, 83, 84, 32),
(46, 'ababa', '', 1, NULL, 85, 86, 32),
(47, 'Ministerio A', 'sdf ', 1, NULL, 100, 101, 1),
(48, 'Ministerio B', 'asdf ', 1, NULL, 102, 103, 1),
(49, 'Ministerio C', 'sdf afd', 1, NULL, 104, 105, 1),
(50, 'Ministerio D', 'sdf ', 1, NULL, 106, 109, 1),
(51, 'Ministerio D', 'sfg ', 1, NULL, 110, 115, 1),
(52, 'Ejemplo AA', 'zlkfsdf ', 1, NULL, 7, 8, 7),
(53, 'QWAS', 'asd', 0, NULL, 111, 112, 51),
(54, 'Compota', 'compota', 1, NULL, 113, 114, 51),
(55, 'Compota', 'compota', 1, NULL, 107, 108, 50),
(56, 'Ministerio de Diciembre', 'descripcion de min', 0, NULL, 116, 117, 1),
(57, 'Ministerio de 2013', 'descripcion', 1, NULL, 118, 119, 1),
(58, 'prueba AA', 'sag', 1, NULL, 15, 18, 2),
(59, 'prueba AB', 'asdf', 1, NULL, 16, 17, 58),
(60, 'Entidad P', 'descr', 1, 'http://www.caracas.com', 19, 20, 2),
(61, 'prueba', 'descripcion', 1, 'http://www.ccs.com', 120, 121, 1),
(62, 'dfsdf', 'dsafgasfdg', 1, 'http://www.ccs.com', 122, 123, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formats`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `formats`
--

INSERT INTO `formats` (`id`, `upload_id`, `communication_type_id`, `communication_category_id`, `name`, `visible`, `created`, `modified`) VALUES
(1, 1, 1, 11, 'Manual de ofiice', 1, '2014-02-04 14:32:34', '2014-02-04 14:32:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) DEFAULT NULL,
  `active` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `groups`
--

INSERT INTO `groups` (`id`, `name`, `active`) VALUES
(1, 'Grupo A1', 1),
(2, 'Grupo B1', 0),
(3, 'Grupo C', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_tokens`
--

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

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `private` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Volcado de datos para la tabla `messages`
--

INSERT INTO `messages` (`id`, `title`, `content`, `private`, `created`, `modified`) VALUES
(1, 'myself', 'cuerpo del mensaje de prueba', 0, '2014-02-04 09:32:10', '2014-02-04 09:32:10'),
(2, 'Prueba de query', 'perolito casa prueb a de envio', 0, '2014-02-04 10:17:19', '2014-02-04 10:17:19'),
(3, 'Comunicacion al 04022014', 'comunicacion de lectura para la carta aval de vida del hecho ocurrido en la carretera vigesima de chile', 0, '2014-02-04 10:58:58', '2014-02-04 10:58:58'),
(4, 'Prueba de envio para horacio', 'prueba', 0, '2014-02-04 11:10:53', '2014-02-04 11:10:53'),
(5, 'Prueba para borrador', 'cuerpo del mensaje. esto es para prueba de borrador', 0, '2014-02-04 11:21:04', '2014-02-04 11:21:04'),
(6, 'Go to Borradores', 'prueba de mensaje para borrador', 0, '2014-02-04 11:21:55', '2014-02-04 11:21:55'),
(7, 'prueba', 'prueba', 0, '2014-02-04 12:31:19', '2014-02-04 12:31:19'),
(8, 'prueba 0125', 'sfdgsfdg', 0, '2014-02-04 12:55:10', '2014-02-04 12:55:10'),
(9, 'Prueba para borrador', 'holaaaa', 0, '2014-02-04 13:34:45', '2014-02-04 13:34:45'),
(10, 'prueba', 'respondiendo. esto no lo deberias ver jesus horacio porque es trash tuyo', 0, '2014-02-04 13:47:53', '2014-02-04 13:47:53'),
(11, 'mandarlo para borrador', 'cuerpo del mensaje enviado para borrador', 0, '2014-02-04 14:31:32', '2014-02-04 14:31:32'),
(12, 'prueba para borrador', 'prueba para borrador', 0, '2014-02-05 11:30:40', '2014-02-05 15:00:30'),
(13, 'Prueba con CC', 'cuerpa del mensaje', 0, '2014-02-10 10:14:13', '2014-02-10 10:14:13'),
(14, 'Asuntos politicos', 'perolita', 0, '2014-02-10 10:16:32', '2014-02-10 10:16:32'),
(15, 'Prueba con CC', 'envio de la respuesta', 0, '2014-02-10 10:28:59', '2014-02-10 10:28:59'),
(16, 'Prueba con CC', 'toma', 0, '2014-02-10 10:31:14', '2014-02-10 10:31:14'),
(17, 'Prueba con CC', 'sapo', 0, '2014-02-10 10:33:31', '2014-02-10 10:33:31'),
(18, 'prueba', 'cuerpo, requiere aprobacion', 0, '2014-02-17 09:19:30', '2014-02-17 09:19:30'),
(19, 'prueba2', 'cuerpoa', 0, '2014-02-17 09:26:13', '2014-02-17 09:26:13'),
(20, 'prueba3', 'asdfasdf', 0, '2014-02-17 10:08:23', '2014-02-17 10:08:23'),
(21, 'Prueba de comunicacion con busqueda de texto', 'el contenido debe tener la palabra perol para que sea encontrado', 0, '2014-02-17 13:23:38', '2014-02-17 13:23:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `redirections`
--

CREATE TABLE IF NOT EXISTS `redirections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `redirections`
--

INSERT INTO `redirections` (`id`, `from_user_id`, `to_user_id`) VALUES
(1, 17, 21),
(2, 17, 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) NOT NULL,
  `communication_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Volcado de datos para la tabla `tags`
--

INSERT INTO `tags` (`id`, `name`, `communication_id`, `user_id`, `created`, `modified`) VALUES
(1, 'prueba', 1, 2, '2014-02-04 08:50:56', '2014-02-04 08:50:56'),
(2, 'prueba', 1, 2, '2014-02-04 08:56:02', '2014-02-04 08:56:02'),
(3, 'prueba', 1, 17, '2014-02-04 09:26:21', '2014-02-04 09:26:21'),
(4, 'prueba', 2, 17, '2014-02-04 09:27:00', '2014-02-04 09:27:00'),
(5, 'prueba', 1, 2, '2014-02-04 09:32:10', '2014-02-04 09:32:10'),
(6, 'prueba', 2, 2, '2014-02-04 10:17:19', '2014-02-04 10:17:19'),
(7, 'casa', 4, 17, '2014-02-04 11:10:53', '2014-02-04 11:10:53'),
(8, 'edf', 4, 17, '2014-02-04 11:10:53', '2014-02-04 11:10:53'),
(9, 'prueba', 5, 2, '2014-02-04 11:21:04', '2014-02-04 11:21:04'),
(10, 'borrador', 6, 2, '2014-02-04 11:21:55', '2014-02-04 11:21:55'),
(11, 'prueba', 9, 17, '2014-02-04 14:31:32', '2014-02-04 14:31:32'),
(12, 'prueba', 13, 2, '2014-02-17 09:19:30', '2014-02-17 09:19:30'),
(13, 'hoy', 13, 2, '2014-02-17 09:19:30', '2014-02-17 09:19:30'),
(14, 'prueba', 14, 2, '2014-02-17 09:26:13', '2014-02-17 09:26:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traces`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Volcado de datos para la tabla `traces`
--

INSERT INTO `traces` (`id`, `communication_id`, `message_id`, `sender_user_id`, `receive_user_id`, `sender_entity_id`, `receive_entity_id`, `read`, `read_datatime`, `created`, `modified`, `type_delivery`, `requires_approval`, `approval`) VALUES
(1, 1, 1, 2, 2, 3, 3, 1, '2014-02-04 14:01:52', '2014-02-04 09:32:10', '2014-02-04 09:32:10', 0, 0, 0),
(2, 2, 2, 2, 17, 3, 17, 1, '2014-02-17 13:29:33', '2014-02-04 10:17:19', '2014-02-04 10:17:19', 0, 0, 0),
(3, 3, 3, 2, 17, 3, 17, 0, NULL, '2014-02-04 10:58:59', '2014-02-04 10:58:59', 0, 0, 0),
(4, 4, 4, 17, 2, 17, 3, 1, '2014-02-17 13:44:20', '2014-02-04 11:10:53', '2014-02-04 11:10:53', 0, 0, 0),
(5, 5, 5, 2, 17, 3, 17, 1, '2014-02-04 13:34:13', '2014-02-04 11:21:04', '2014-02-04 11:21:04', 0, 0, 0),
(6, 6, 6, 2, 17, 3, 17, 0, NULL, '2014-02-04 11:21:55', '2014-02-04 11:21:55', 0, 0, 0),
(7, 7, 7, 2, 17, 3, 17, 1, '2014-02-04 13:47:30', '2014-02-04 12:31:19', '2014-02-04 12:31:19', 0, 0, 0),
(8, 8, 8, 2, 17, 3, 17, 0, NULL, '2014-02-04 12:55:10', '2014-02-04 12:55:10', 0, 0, 0),
(9, 5, 9, 17, 2, 17, 3, 1, '2014-02-04 14:01:19', '2014-02-04 13:34:45', '2014-02-04 13:34:45', 0, 0, 0),
(10, 7, 10, 17, 2, 17, 3, 1, '2014-02-17 13:44:55', '2014-02-04 13:47:53', '2014-02-04 13:47:53', 0, 0, 0),
(11, 9, 11, 17, 17, 17, 17, 0, NULL, '2014-02-04 14:31:32', '2014-02-04 14:31:32', 0, 0, 0),
(12, 9, 11, 17, 21, 17, 8, 0, NULL, '2014-02-04 14:31:32', '2014-02-04 14:31:32', 0, 0, 0),
(13, 9, 11, 17, 22, 17, 3, 0, NULL, '2014-02-04 14:31:32', '2014-02-04 14:31:32', 0, 0, 0),
(14, 10, 12, 2, 17, 3, 17, 0, NULL, '2014-02-05 11:30:40', '2014-02-05 11:30:40', 0, 0, 0),
(15, 10, 12, 2, 21, 3, 8, 0, NULL, '2014-02-05 11:30:40', '2014-02-05 11:30:40', 0, 0, 0),
(16, 10, 12, 2, 22, 3, 3, 0, NULL, '2014-02-05 11:30:40', '2014-02-05 11:30:40', 0, 0, 0),
(17, 11, 13, 2, 17, 3, 17, 1, '2014-02-17 10:32:53', '2014-02-10 10:14:13', '2014-02-10 10:14:13', 0, 0, 0),
(18, 11, 13, 2, 21, 3, 8, 0, NULL, '2014-02-10 10:14:13', '2014-02-10 10:14:13', 0, 0, 0),
(19, 11, 13, 2, 22, 3, 3, 0, NULL, '2014-02-10 10:14:13', '2014-02-10 10:14:13', 0, 0, 0),
(20, 11, 13, 2, 44, 3, 8, 1, '2014-02-10 10:32:43', '2014-02-10 10:14:13', '2014-02-10 10:14:13', 1, 0, 0),
(21, 12, 14, 2, 17, 3, 17, 0, NULL, '2014-02-10 10:16:32', '2014-02-10 10:16:32', 0, 0, 0),
(22, 12, 14, 2, 21, 3, 8, 0, NULL, '2014-02-10 10:16:32', '2014-02-10 10:16:32', 0, 0, 0),
(23, 12, 14, 2, 22, 3, 3, 0, NULL, '2014-02-10 10:16:32', '2014-02-10 10:16:32', 0, 0, 0),
(24, 12, 14, 2, 44, 3, 8, 0, NULL, '2014-02-10 10:16:32', '2014-02-10 10:16:32', 1, 0, 0),
(25, 11, 15, 17, 2, 17, 3, 1, '2014-02-20 08:59:57', '2014-02-10 10:28:59', '2014-02-10 10:28:59', 0, 0, 0),
(26, 11, 15, 17, 44, 17, 8, 1, '2014-02-10 10:32:43', '2014-02-10 10:28:59', '2014-02-10 10:28:59', 0, 0, 0),
(27, 11, 15, 17, 43, 17, 52, 1, '2014-02-10 10:49:35', '2014-02-10 10:28:59', '2014-02-10 10:28:59', 1, 0, 0),
(28, 11, 16, 44, 2, 8, 3, 1, '2014-02-20 08:59:57', '2014-02-10 10:31:14', '2014-02-10 10:31:14', 0, 0, 0),
(29, 11, 16, 44, 17, 8, 17, 1, '2014-02-17 10:32:53', '2014-02-10 10:31:14', '2014-02-10 10:31:14', 0, 0, 0),
(30, 11, 16, 44, 21, 8, 8, 0, NULL, '2014-02-10 10:31:14', '2014-02-10 10:31:14', 0, 0, 0),
(31, 11, 16, 44, 22, 8, 3, 0, NULL, '2014-02-10 10:31:14', '2014-02-10 10:31:14', 0, 0, 0),
(32, 11, 16, 44, 43, 8, 52, 1, '2014-02-10 10:49:35', '2014-02-10 10:31:14', '2014-02-10 10:31:14', 1, 0, 0),
(33, 11, 17, 43, 17, 52, 17, 1, '2014-02-17 10:32:53', '2014-02-10 10:33:31', '2014-02-10 10:33:31', 0, 0, 0),
(34, 11, 17, 43, 21, 52, 8, 0, NULL, '2014-02-10 10:33:31', '2014-02-10 10:33:31', 0, 0, 0),
(35, 11, 17, 43, 22, 52, 3, 0, NULL, '2014-02-10 10:33:31', '2014-02-10 10:33:31', 0, 0, 0),
(36, 11, 17, 43, 44, 52, 8, 0, NULL, '2014-02-10 10:33:31', '2014-02-10 10:33:31', 1, 0, 0),
(37, 13, 18, 2, 17, 3, 17, 1, '2014-02-17 09:19:58', '2014-02-17 09:19:30', '2014-02-17 09:19:30', 0, 1, 0),
(38, 13, 18, 2, 21, 3, 8, 0, NULL, '2014-02-17 09:19:30', '2014-02-17 09:19:30', 0, 0, 0),
(39, 13, 18, 2, 22, 3, 3, 0, NULL, '2014-02-17 09:19:30', '2014-02-17 09:19:30', 0, 0, 0),
(40, 14, 19, 2, 17, 3, 17, 1, '2014-02-17 10:05:59', '2014-02-17 09:26:13', '2014-02-17 09:26:13', 0, 1, 0),
(41, 14, 19, 2, 21, 3, 8, 0, NULL, '2014-02-17 09:26:13', '2014-02-17 09:26:13', 0, 0, 0),
(42, 14, 19, 2, 22, 3, 3, 0, NULL, '2014-02-17 09:26:13', '2014-02-17 09:26:13', 0, 0, 0),
(43, 15, 20, 2, 17, 3, 17, 1, '2014-02-17 13:24:56', '2014-02-17 10:08:23', '2014-02-17 10:08:23', 0, 0, 0),
(44, 15, 20, 2, 21, 3, 8, 0, NULL, '2014-02-17 10:08:23', '2014-02-17 10:08:23', 0, 0, 0),
(45, 15, 20, 2, 22, 3, 3, 0, NULL, '2014-02-17 10:08:23', '2014-02-17 10:08:23', 0, 0, 0),
(46, 16, 21, 17, 2, 17, 3, 1, '2014-02-20 13:52:21', '2014-02-17 13:23:38', '2014-02-17 13:23:38', 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `uploads`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `uploads`
--

INSERT INTO `uploads` (`id`, `name`, `size`, `message_id`, `real_name`, `url`, `temporal`, `document`, `visible`, `description`) VALUES
(1, 'MANUALDEOFFICE_0488943001391542342.pdf', 1778566, NULL, 'MANUAL DE OFFICE.pdf', 'http://localhost/AIG_mensajeria/webroot/files/MANUALDEOFFICE_0488943001391542342.pdf', NULL, 1, 1, '42201415222'),
(2, 'MANUALDEOFFICE_0644277001391617834.pdf', 1778566, 12, 'MANUAL DE OFFICE.pdf', 'http://localhost/AIG_mensajeria/webroot/files/MANUALDEOFFICE_0644277001391617834.pdf', NULL, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

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
  `visible` int(11) NOT NULL DEFAULT '1' COMMENT '1 usuario visible 0 no visible',
  PRIMARY KEY (`id`),
  KEY `user` (`username`),
  KEY `mail` (`email`),
  KEY `users_FKIndex1` (`user_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `user_group_id`, `position`, `username`, `password`, `salt`, `email`, `first_name`, `last_name`, `email_verified`, `active`, `ip_address`, `created`, `modified`, `entity_id`, `first_time`, `telephone`, `celphone`, `group_id`, `visible`) VALUES
(1, 1, NULL, 'admin', 'b670bffcdcf036b0f9be512bb25f664a', '51dc4bb92e72198d0dbb04bd2441f227', 'admin@admin.com', 'Admin', '', 1, 1, '', '2013-09-25 13:27:49', '2013-10-01 18:42:11', 0, 0, NULL, NULL, NULL, 1),
(2, 2, 'Desarrollador RIA', 'jehogo', '15adedee5071c72b61a2258023f33929', 'ec3afff348f4cdfe628775c18bbbaf7c', 'gouveia.horacio@gmail.com', 'Jesus Horacio', 'Gouveia', 1, 1, NULL, '2013-09-26 15:10:21', '2013-12-12 11:41:16', 3, 0, '36254145', '213543132', NULL, 1),
(3, 2, NULL, 'pedro', 'ea78d095f1a674db33ab9bc7496ad066', 'c8167bb42364235b3799a6ff95ce2443', 'pedrito@gmailc.om', 'Pedro Antonio', 'Lopez', 1, 1, NULL, '2013-10-01 10:21:27', '2013-10-01 11:47:11', 0, 1, NULL, NULL, NULL, 1),
(4, 2, NULL, 'adriana', '5f5bf5147dd73a94a759e3a7d0a0c4c1', '9461110dab86a2f2a784257f19fca2f5', 'adrita@gmail.com', 'Adriana', 'Gomes Perez', 1, 0, NULL, '2013-10-01 10:22:26', '2013-10-01 13:37:31', 0, 1, NULL, NULL, NULL, 1),
(13, 2, NULL, 'analado', '9d761afd06e022d4c7b86a1500c3b46b', '290453a12fb483a0ca5f82640f1eef48', 'ana.lado@lado.com', 'Ana', 'Lado', 1, 1, NULL, '2013-10-01 16:03:50', '2013-10-01 16:03:50', 0, 1, NULL, NULL, NULL, 1),
(14, 2, NULL, 'chuo', '0b8475744f5d05aab72ddda4dce0c5aa', 'd13e4a9ea7438af60c5aba4f2e3e5982', 'gouveia.horacio+1@gmail.com', 'Chucho', 'Gouv', 1, 1, NULL, '2013-10-01 16:08:50', '2013-10-10 12:33:18', 38, 1, NULL, NULL, NULL, 1),
(15, 2, NULL, 'checho', 'f4ab78aae28a27e623e2df1352750389', 'f4e66691f01382c5fb2b8bce8f44cbd9', 'che@das.com', 'checho', 'che', 1, 1, NULL, '2013-10-01 16:10:28', '2013-10-10 12:33:38', 38, 1, NULL, NULL, NULL, 1),
(16, 2, NULL, 'pepito', '82a5e753b273c9191012be26eef816b0', '9fda8613933d548bfdcae61198d48204', 'pepito@grillo.com', 'Pepe', 'grillo', 1, 1, NULL, '2013-10-01 16:11:49', '2013-10-02 16:08:45', 6, 1, NULL, NULL, NULL, 1),
(17, 2, 'Camarera', 'rosa', '3ef71de1ee68c4006dea449dd057717d', '1f718e03079a04ea0265e2c02b28099f', 'rosa@aas.com', 'Rosa', 'Lado', 1, 1, NULL, '2013-10-01 16:13:12', '2013-11-14 14:27:00', 17, 0, NULL, NULL, NULL, 1),
(18, 2, NULL, 'fabi', '4f49de2445c01597cfe0914910fff800', '01c714dbb16d16da7d8004f934c7ce83', 'fa@perez.com', 'Fabian', 'Perez', 1, 1, NULL, '2013-10-01 16:14:18', '2013-12-02 09:17:39', 6, 0, NULL, NULL, NULL, 1),
(19, 1, NULL, 'ricardo', 'e36a299e0d7ddb1db40bf053aff2f98f', '0fd3aec27d6c9bd09637ad567a904b00', 'rica@rdo.com', 'Ricardo Antonio', 'Perez Formigoni', 1, 1, NULL, '2013-10-01 16:50:40', '2014-02-10 09:49:38', 8, 1, '3265', '12345', 1, 1),
(20, 3, NULL, 'admin_a', '8f43a8ba2d52d1f5f04b04517e95ef02', 'bd2a7de90b5b7901ecf61ab99398c773', 'jehogo@jehogo.com', 'Jesus', 'Gouveia', 1, 1, NULL, '2013-10-02 14:45:56', '2013-11-19 11:14:41', 2, 0, NULL, NULL, NULL, 1),
(21, 2, NULL, 'test1', '38238d018376aaa3fcf166616bb5e872', '8947cc5a68f43d82f881df50d2981206', 'test1@google.com', 'Test', 'Uno', 1, 1, NULL, '2013-10-16 09:54:54', '2013-11-29 16:56:22', 8, 0, NULL, NULL, NULL, 1),
(22, 2, NULL, 'test2', '0d0dd1a9b9dd181ddc4fca42bf6269c1', '8e2be2dec04fdb725138dd2804f16735', 'test2@google.com', 'Test', 'Dos', 1, 1, NULL, '2013-10-16 09:55:27', '2013-12-10 13:53:22', 3, 0, NULL, NULL, NULL, 1),
(23, 2, NULL, 'test3', '4e8913868150e99fe68b191548974aee', '707a80c7d98d84fa8cb1d2c235362137', 'test3@google.com', 'Test', 'Tres', 1, 1, NULL, '2013-10-16 09:56:02', '2013-10-16 09:56:02', 9, 1, NULL, NULL, NULL, 1),
(24, 2, NULL, 'test4', '8edeb18b9873370247c516fc727dcddd', '33b2ddfa8c90ce25fb5d2e7cdb0ee858', 'test4@google.com', 'Test', 'Cuatro', 1, 1, NULL, '2013-10-16 09:56:32', '2013-10-16 09:56:32', 6, 1, NULL, NULL, NULL, 1),
(25, 2, NULL, 'victor', '167970571452b68cb5540e01f2ade962', 'cc14cb2b85cc22f38fe18cb5aacff0b7', 'gouveia.horacio+6@gmail.com', 'Victor', 'Muñoz', 1, 1, NULL, '2013-10-29 15:56:45', '2013-10-29 15:56:45', 16, 1, NULL, NULL, NULL, 1),
(26, 1, NULL, 'pedra', '523ee0ed9da327cfcadaff75387c63d8', 'b7ec11d37c2204ad33f149c5fdde9fa3', 'ped@sdf.com', 'Pedra', 'Lopez', 1, 1, NULL, '2013-11-13 12:19:58', '2013-11-13 12:19:58', 38, 1, NULL, NULL, NULL, 1),
(27, 2, NULL, 'pedrito', '3c45caedd377dd361838fe981cc776e7', 'c53ded168df24de93649c8a5f8606bfa', 'pedrito+36@gmailc.om', 'Pedrito', 'Perez', 1, 1, NULL, '2013-11-13 12:21:20', '2013-11-13 12:21:20', 38, 1, NULL, NULL, NULL, 1),
(28, 2, NULL, 'pepe', 'ff84098fb90b2dec1f4c785d8ade7ae1', '80dadb3b7d486b97280db663bcf7d769', 'pepe@pepe.com', 'pepe', 'pepe', 1, 1, NULL, '2013-11-13 13:18:28', '2013-11-13 13:18:28', 30, 1, NULL, NULL, NULL, 1),
(29, 2, NULL, 'pepepe', '69d41b439ff84563c5954f091a8541a8', 'd5a60a036a0a23b78bd3b8eb56c05f81', 'pepepe@pepe.com', 'pepepepe', 'pepepepepepepe', 1, 1, NULL, '2013-11-13 13:19:06', '2013-11-13 13:19:06', 6, 1, NULL, NULL, NULL, 1),
(30, 2, NULL, 'yoha', 'cd383dc6b921f2f8b891ba1fcccd83b9', '1bbd67b075208fb9a2c142112e432a69', 'yoha@zapino.com', 'Yohana', 'Zapino', 1, 1, NULL, '2013-11-13 13:20:52', '2013-11-13 13:51:18', 38, 0, '369852147', '121548611', NULL, 1),
(31, 2, NULL, 'grisel', '0d0df9307c473817b21d9319cb8b91ca', '6eeaf751b3aff6932863419ad9b69088', 'gris@zap.com', 'Grisel', 'Zapino', 1, 1, NULL, '2013-11-13 13:21:57', '2013-11-19 10:54:17', 38, 0, '+5841254112', '231548977', NULL, 1),
(32, 2, NULL, 'test1911', 'f642f384023695241a3462b20f368f79', '0bad9c725dd48db72049f2d6d37d6dfa', 'gouveia.horacio+63@gmail.com', 'Test', '1911', 1, 1, NULL, '2013-11-19 13:28:49', '2013-11-19 13:29:08', 9, 0, '', '', NULL, 1),
(33, 2, NULL, 'test10', 'b82e428ee3d8260b08f4e13b7daa1700', '58ec28eab4fe69772049cdfef836a391', 'perol@perols.com', 'test', 'diez', 1, 1, NULL, '2013-11-19 13:35:08', '2013-11-19 13:35:38', 6, 0, '1231321', '21321', NULL, 1),
(34, 2, NULL, 'test11', 'bb4d7bfaf646275ae675dac84f287051', 'c195b339f765d581d35490e96fc52157', 'gouveia.horacio+5665@gmail.com', 'Prueba', 'Del 1911', 1, 1, NULL, '2013-11-19 16:40:17', '2013-11-19 16:40:52', 8, 0, '', '', NULL, 1),
(35, 2, NULL, 'test27', '6e546397d4b828549b71ec91a6bbe320', 'b4b034ef077d8ea3e6ad23a209e59040', 'gouveia.horaci+co@gmail.com', 'Usuario', 'de Compota', 1, 1, NULL, '2013-11-27 11:07:36', '2013-11-27 11:07:36', 55, 1, '', '', NULL, 1),
(36, 2, NULL, 'test28', 'b015d29e3c85dcf39a603c2e09958650', '3d722d1d1c634db6db78cba85131e904', 'gouveia.+sadfhoracio@gmail.com', 'test', '28', 1, 1, NULL, '2013-11-27 11:08:05', '2013-11-27 11:08:05', 54, 1, '', '', NULL, 1),
(37, 2, NULL, 'test0412', '72ab9a90ba7374a6620c8c655c11258d', '7480c6eac5f5a3f6848fbc7c73563c09', 'victorperez@gmail.com', 'Victor ', 'Perez', 1, 1, NULL, '2013-12-04 09:49:53', '2013-12-04 09:49:53', 52, 1, '232615', '435245', NULL, 1),
(38, 1, NULL, 'test45-delete', '57c44a1d739aa9125267cdb5db1a1705', 'e170850924d95b315022cbd624cdde1b', 'prueba@group.com-delete', 'Eliminado', 'Eliminado', 1, 0, NULL, '2013-12-04 10:23:29', '2014-02-04 17:09:25', 60, 0, '362514', '145236', 1, 0),
(39, 2, NULL, 'oscarsito', '806860ab56d5f9cabc3c5aa68f329f1f', '9fff48808c6d77cd15aae2b8800ddc1f', 'asdfg@asdfg.com', 'oscar', 'brandon', 1, 1, NULL, '2013-12-19 17:47:08', '2013-12-19 17:47:08', 8, 1, '21354', '213', 0, 1),
(40, 3, NULL, 'admin_b', '7f5469fa822480b08c9a68713c347b06', 'e805fa616a3520bb7b47435fd409b2cb', 'admin_b@gmail.com', 'admin B', 'B', 1, 1, NULL, '2013-12-19 17:48:24', '2013-12-19 17:48:24', 31, 1, '123', '546', 0, 1),
(41, 2, NULL, 'user17', '3405c472a4a05ba424ae329c46953292', 'bede0128ae51447e66d4bbc5b74bd454', 'gouveia.horacio+17@gmail.com', 'David', 'Mora', 1, 1, NULL, '2014-01-17 16:59:03', '2014-01-17 16:59:24', 8, 0, '584129484502', '584129484502', 0, 1),
(42, 1, 'Prueba', 'test1002', 'fcd0ce93306779d4456c9b806906ef68', 'a439b3d81445a10268db8b5087328d55', 'gouveia.horacio+12@gmail.com', 'Pedro Luis', 'Flores', 1, 1, NULL, '2014-02-10 09:39:38', '2014-02-10 09:52:29', 6, 1, '2121845', '1215841', 1, 1),
(43, 2, NULL, 'test1024', '41fcf1724dc878216087a19542a63507', 'dc3d98a5d78e5fefc93c3bca2ca9baab', 'gouveia.horacio+25@gmail.com', 'Jose Felix', 'Ribas', 1, 1, NULL, '2014-02-10 09:55:55', '2014-02-10 10:33:17', 52, 0, '123456', '321654', 1, 1),
(44, 2, 'Dictador', 'jgomez', 'f113e87f2d20920a914daecf7082fd60', 'fef018272f6d9588b3ed4892521dbb13', 'gouveia.horacio+36@gmail.com', 'Juan Vicente', 'Gomez', 1, 1, NULL, '2014-02-10 09:57:57', '2014-02-10 10:30:47', 8, 0, '123456', '216846', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_circles`
--

CREATE TABLE IF NOT EXISTS `user_circles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'id del usuario',
  `circle_id` int(11) NOT NULL COMMENT 'id del grupo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='contiene los usuarios que estan en un grupo' AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `user_circles`
--

INSERT INTO `user_circles` (`id`, `user_id`, `circle_id`) VALUES
(1, 2, 1),
(2, 17, 1),
(3, 21, 1),
(4, 22, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_groups`
--

CREATE TABLE IF NOT EXISTS `user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `alias_name` varchar(100) DEFAULT NULL,
  `allowRegistration` int(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

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

CREATE TABLE IF NOT EXISTS `user_group_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_group_id` int(10) unsigned NOT NULL,
  `controller` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `action` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `allowed` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=253 ;

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
(252, 3, 'Circles', 'getCircleById', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
