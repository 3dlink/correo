-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 19-11-2013 a las 22:44:02
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
-- Estructura de tabla para la tabla `communications`
--

CREATE TABLE IF NOT EXISTS `communications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `communication_type_id` int(11) NOT NULL,
  `communication_category_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `communications`
--

INSERT INTO `communications` (`id`, `entity_id`, `user_id`, `created`, `modified`, `communication_type_id`, `communication_category_id`, `action_id`) VALUES
(1, 3, 2, '2013-11-14 10:36:53', '2013-11-14 10:36:53', 1, 1, 0),
(2, 3, 2, '2013-11-14 12:52:31', '2013-11-14 12:52:31', 1, 3, 0),
(3, 3, 2, '2013-11-14 13:06:11', '2013-11-14 13:06:11', 1, 1, 0),
(4, 3, 2, '2013-11-14 14:21:52', '2013-11-14 14:21:52', 1, 1, 0),
(5, 3, 2, '2013-11-14 14:25:39', '2013-11-14 14:25:39', 1, 1, 0),
(6, 3, 2, '2013-11-14 15:29:25', '2013-11-14 15:29:25', 1, 1, 5),
(7, 3, 2, '2013-11-14 16:08:41', '2013-11-14 16:08:41', 1, 1, 2),
(8, 3, 2, '2013-11-15 08:41:26', '2013-11-15 08:41:26', 1, 1, 3),
(9, 17, 17, '2013-11-15 12:02:34', '2013-11-15 12:02:34', 1, 1, 2),
(10, 17, 17, '2013-11-15 12:07:06', '2013-11-15 12:07:06', 1, 1, 2),
(11, 9, 32, '2013-11-19 13:30:50', '2013-11-19 16:20:29', 3, 1, 4),
(12, 9, 32, '2013-11-19 13:39:05', '2013-11-19 13:39:05', 3, 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `communication_categories`
--

CREATE TABLE IF NOT EXISTS `communication_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) DEFAULT NULL,
  `active` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `communication_categories`
--

INSERT INTO `communication_categories` (`id`, `name`, `active`) VALUES
(1, 'Categoria A', 1),
(2, 'Categoria C', 0),
(3, 'Categoria B', 1),
(4, 'Categoria E', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `communication_tokens`
--

CREATE TABLE IF NOT EXISTS `communication_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `communication_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Volcado de datos para la tabla `communication_tokens`
--

INSERT INTO `communication_tokens` (`id`, `communication_id`, `user_id`) VALUES
(1, 1, 17),
(2, 2, 17),
(3, 3, 17),
(4, 4, 17),
(5, 5, 17),
(6, 6, 17),
(7, 7, 17),
(8, 8, 17),
(9, 9, 17),
(10, 10, 17),
(11, 11, 18),
(12, 11, 19),
(13, 11, 21),
(14, 11, 22),
(15, 11, 24),
(17, 11, 22),
(18, 12, 33),
(19, 11, 33);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `communication_views`
--

INSERT INTO `communication_views` (`id`, `communication_id`, `user_id`, `last_view`) VALUES
(1, 1, 2, '2013-11-14 11:23:43'),
(2, 2, 2, '2013-11-14 13:16:38'),
(3, 3, 2, '2013-11-14 13:07:28'),
(4, 4, 2, NULL),
(5, 5, 2, '2013-11-14 14:31:49'),
(6, 5, 17, '2013-11-14 14:31:21'),
(7, 6, 2, '2013-11-14 16:08:00'),
(8, 7, 2, '2013-11-15 08:40:13'),
(9, 8, 2, '2013-11-19 15:52:09'),
(10, 8, 17, '2013-11-15 09:47:45'),
(11, 9, 17, '2013-11-15 12:02:39'),
(12, 10, 17, '2013-11-15 12:07:10'),
(13, 11, 32, NULL),
(14, 11, 33, '2013-11-19 16:21:03'),
(15, 12, 32, NULL),
(16, 12, 33, '2013-11-19 13:44:37'),
(17, 11, 2, '2013-11-19 16:25:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entities`
--

CREATE TABLE IF NOT EXISTS `entities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `active` int(11) NOT NULL,
  `lft` int(11) NOT NULL,
  `rght` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Volcado de datos para la tabla `entities`
--

INSERT INTO `entities` (`id`, `name`, `description`, `active`, `lft`, `rght`, `parent_id`) VALUES
(1, 'Entidades', 'nada', 1, 1, 106, 0),
(2, 'Ministerio de infraestructura', 'destruir calles', 1, 2, 15, 1),
(3, 'Ministerio de Hacienda', 'haciendas', 1, 16, 17, 1),
(4, 'Ministerio de Minas', 'las minas', 1, 18, 61, 1),
(5, 'Despacho de Bienes', 'biens', 1, 3, 12, 2),
(6, 'Despacho de Obras', 'obras', 1, 13, 14, 2),
(7, 'Servicios', 'descripcion', 1, 4, 9, 5),
(8, 'Entidad A', 'descipcion de la entidad A', 1, 5, 6, 7),
(9, 'Finanzas', 'descripcion de la entidad de finanzas', 1, 10, 11, 5),
(10, 'Excabacion Maritima', 'descripcion de la excabacion', 1, 19, 38, 4),
(11, 'sadf', 'asdf sdf', 1, 20, 29, 10),
(12, 'sdfsdfsdf', 'sfdsdfs fsdf sdf', 1, 21, 22, 11),
(13, 'fsdfsdf', 'asdfasdfasdf asdf', 1, 30, 33, 10),
(14, 'ABC', 'sdfs', 1, 23, 24, 11),
(15, 'AABBCC', 'dsfaf', 1, 25, 26, 11),
(16, 'La cosa', 'sdf', 1, 27, 28, 11),
(17, 'La marina', 'asdf', 1, 34, 35, 10),
(18, 'Hola A', 'asdfasdf', 1, 36, 37, 10),
(19, 'Excabacion Terrestre', 'asfd', 1, 39, 54, 4),
(20, 'Division A', 'sdfsdf', 1, 40, 53, 19),
(21, 'Division A1', 'sdfsadf', 1, 41, 52, 20),
(22, 'Division A1a', 'sdf', 1, 42, 51, 21),
(23, 'Division B', 'asdf', 1, 31, 32, 13),
(24, 'Division n', 'asdf', 1, 43, 50, 22),
(25, 'Division N1', 'sdf', 1, 44, 49, 24),
(26, 'Division n1-2', '', 1, 45, 48, 25),
(27, 'Division N1-2-1', 'sdf', 1, 46, 47, 26),
(28, 'Excabacion Aerea', 'asdf', 1, 55, 60, 4),
(29, 'Division 1', 'sdf', 1, 56, 59, 28),
(30, 'Division 12', 'sdf', 1, 57, 58, 29),
(31, 'Ministerio de Agricultura', 'sdf', 1, 62, 63, 1),
(32, 'Ministerio del Deporte', 'sdf', 0, 64, 81, 1),
(33, 'Ministerio de la Salud', '', 1, 82, 83, 1),
(34, 'Ministerio de la Calidad de los Ministerios', 'sdf', 1, 84, 87, 1),
(35, 'Ministerio de la Mujer', 'asd', 0, 88, 93, 1),
(36, 'Despacho de las cuaimas', 'sdf', 1, 89, 92, 35),
(37, 'Menores de 16', 'sdf', 1, 90, 91, 36),
(38, 'Depuracion', 'dfsdf', 1, 85, 86, 34),
(39, 'Bicicletas', '21zsfd', 1, 65, 66, 32),
(40, 'Motos', 'asdf', 1, 67, 68, 32),
(41, 'Natacion', '2131dsf', 1, 69, 70, 32),
(42, 'Baseball', 'sdf sdf ', 1, 71, 72, 32),
(43, 'Cayoning', 'adsf asfd', 1, 73, 74, 32),
(44, 'Nado Sincronizado', 'sdf ', 1, 75, 76, 32),
(45, 'perol', 'sdf', 1, 77, 78, 32),
(46, 'ababa', '', 1, 79, 80, 32),
(47, 'Ministerio A', 'sdf ', 1, 94, 95, 1),
(48, 'Ministerio B', 'asdf ', 1, 96, 97, 1),
(49, 'Ministerio C', 'sdf afd', 1, 98, 99, 1),
(50, 'Ministerio D', 'sdf ', 1, 100, 101, 1),
(51, 'Ministerio D', 'sfg ', 1, 102, 105, 1),
(52, 'Ejemplo AA', 'zlkfsdf ', 1, 7, 8, 7),
(53, 'QWAS', 'asd', 1, 103, 104, 51);

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
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `messages`
--

INSERT INTO `messages` (`id`, `title`, `content`, `created`, `modified`) VALUES
(1, 'Prueba con categoria', 'cuerpo de la comunicacion con categoria', '2013-11-14 10:36:53', '2013-11-14 10:36:53'),
(2, 'Prueba dos de categoria', 'contenido de la prueba dos', '2013-11-14 12:52:31', '2013-11-14 12:52:31'),
(3, 'Prueba de envio', '', '2013-11-14 13:06:11', '2013-11-14 13:06:11'),
(4, 'Prueba con tags', 'sadf', '2013-11-14 14:21:53', '2013-11-14 14:21:53'),
(5, 'prueba 2 de tag', 'prueba dos de tags en la composicion de la comunicacion', '2013-11-14 14:25:39', '2013-11-14 14:25:39'),
(6, 'prueba de accion', 'prueba de envio de comunicacion con accion', '2013-11-14 15:29:25', '2013-11-14 15:29:25'),
(7, 'prueba de accion final', 'contenido de prueba de todo', '2013-11-14 16:08:41', '2013-11-14 16:08:41'),
(8, 'popopopopop', 'jhjhj', '2013-11-15 08:41:27', '2013-11-15 08:41:27'),
(9, 'prueba con formatos', 'cuerpo&nbsp;', '2013-11-15 12:02:34', '2013-11-15 12:02:34'),
(10, 'Prueba', 'documentos', '2013-11-15 12:07:06', '2013-11-15 12:07:06'),
(11, 'prueba de comunicacion 19 11 13', 'cuerpo de la comunicacion', '2013-11-19 13:30:50', '2013-11-19 13:30:50'),
(12, 'prueba', 'cuerpa', '2013-11-19 13:39:05', '2013-11-19 13:39:05'),
(13, 'prueba de comunicacion 19 11 13', 'dfasdf', '2013-11-19 16:20:29', '2013-11-19 16:20:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `redirections`
--

CREATE TABLE IF NOT EXISTS `redirections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

--
-- Volcado de datos para la tabla `redirections`
--

INSERT INTO `redirections` (`id`, `from_user_id`, `to_user_id`) VALUES
(73, 2, 18),
(74, 2, 19),
(75, 2, 21),
(76, 2, 22),
(78, 2, 24);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `tags`
--

INSERT INTO `tags` (`id`, `name`, `communication_id`, `user_id`, `created`, `modified`) VALUES
(1, 'etiqueta1', 1, 2, '2013-11-14 10:55:20', '2013-11-14 10:55:20'),
(2, 'tag2', 4, 2, '2013-11-14 14:21:53', '2013-11-14 14:21:53'),
(3, 'tag1', 4, 2, '2013-11-14 14:21:53', '2013-11-14 14:21:53'),
(4, 'deb', 5, 2, '2013-11-14 14:25:39', '2013-11-14 14:25:39'),
(5, 'abc', 5, 2, '2013-11-14 14:25:39', '2013-11-14 14:25:39'),
(6, 'casa', 5, 17, '2013-11-14 14:31:13', '2013-11-14 14:31:13'),
(7, 'etiqueta a', 7, 2, '2013-11-14 16:08:41', '2013-11-14 16:08:41'),
(8, 'test', 11, 32, '2013-11-19 13:30:50', '2013-11-19 13:30:50'),
(9, 'prueba', 11, 32, '2013-11-19 13:30:50', '2013-11-19 13:30:50'),
(10, 'prueba', 12, 32, '2013-11-19 13:39:05', '2013-11-19 13:39:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traces`
--

CREATE TABLE IF NOT EXISTS `traces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Volcado de datos para la tabla `traces`
--

INSERT INTO `traces` (`id`, `communication_id`, `message_id`, `sender_user_id`, `receive_user_id`, `sender_entity_id`, `receive_entity_id`, `read`, `read_datatime`, `created`, `modified`) VALUES
(1, 1, 1, 2, 17, 3, 17, 0, NULL, '2013-11-14 10:36:53', '2013-11-14 10:36:53'),
(2, 2, 2, 2, 17, 3, 17, 0, NULL, '2013-11-14 12:52:31', '2013-11-14 12:52:31'),
(3, 3, 3, 2, 17, 3, 17, 0, NULL, '2013-11-14 13:06:11', '2013-11-14 13:06:11'),
(4, 4, 4, 2, 17, 3, 17, 0, NULL, '2013-11-14 14:21:53', '2013-11-14 14:21:53'),
(5, 5, 5, 2, 17, 3, 17, 1, '2013-11-14 14:31:21', '2013-11-14 14:25:39', '2013-11-14 14:25:39'),
(6, 6, 6, 2, 17, 3, 17, 0, NULL, '2013-11-14 15:29:25', '2013-11-14 15:29:25'),
(7, 7, 7, 2, 17, 3, 17, 0, NULL, '2013-11-14 16:08:41', '2013-11-14 16:08:41'),
(8, 8, 8, 2, 17, 3, 17, 1, '2013-11-15 09:47:45', '2013-11-15 08:41:27', '2013-11-15 08:41:27'),
(9, 9, 9, 17, 17, 17, 17, 1, '2013-11-15 12:02:39', '2013-11-15 12:02:34', '2013-11-15 12:02:34'),
(10, 10, 10, 17, 17, 17, 17, 1, '2013-11-15 12:07:10', '2013-11-15 12:07:06', '2013-11-15 12:07:06'),
(11, 11, 11, 32, 2, 9, 3, 1, '2013-11-19 16:25:19', '2013-11-19 13:30:50', '2013-11-19 13:30:50'),
(12, 11, 11, 32, 18, 9, 6, 0, NULL, '2013-11-19 13:30:50', '2013-11-19 13:30:50'),
(13, 11, 11, 32, 19, 9, 8, 0, NULL, '2013-11-19 13:30:50', '2013-11-19 13:30:50'),
(14, 11, 11, 32, 21, 9, 8, 0, NULL, '2013-11-19 13:30:50', '2013-11-19 13:30:50'),
(15, 11, 11, 32, 22, 9, 3, 0, NULL, '2013-11-19 13:30:50', '2013-11-19 13:30:50'),
(16, 11, 11, 32, 24, 9, 6, 0, NULL, '2013-11-19 13:30:50', '2013-11-19 13:30:50'),
(17, 11, 11, 32, 22, 9, 3, 0, NULL, '2013-11-19 13:30:50', '2013-11-19 13:30:50'),
(18, 12, 12, 32, 33, 9, 6, 1, '2013-11-19 13:44:37', '2013-11-19 13:39:05', '2013-11-19 13:39:05'),
(19, 11, 13, 2, 33, 3, 6, 1, '2013-11-19 16:21:03', '2013-11-19 16:20:29', '2013-11-19 16:20:29');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Volcado de datos para la tabla `uploads`
--

INSERT INTO `uploads` (`id`, `name`, `size`, `message_id`, `real_name`, `url`, `temporal`, `document`, `visible`, `description`) VALUES
(1, 'new_photo_on_page_0799263001384463986.txt', 460, NULL, 'new_photo_on_page.txt', 'http://localhost/AIG_mensajeria/webroot/files/new_photo_on_page_0799263001384463986.txt', 89932044, 0, 0, NULL),
(2, 'new_photo_on_page_0829554001384465815.txt', 460, NULL, 'new_photo_on_page.txt', 'http://localhost/AIG_mensajeria/webroot/files/new_photo_on_page_0829554001384465815.txt', NULL, 0, 0, NULL),
(3, 'new_photo_on_page_0634030001384466856.txt', 460, NULL, 'new_photo_on_page.txt', 'http://localhost/AIG_mensajeria/webroot/files/new_photo_on_page_0634030001384466856.txt', NULL, 0, 0, NULL),
(4, 'new_photo_on_page_0188351001384466862.txt', 460, NULL, 'new_photo_on_page.txt', 'http://localhost/AIG_mensajeria/webroot/files/new_photo_on_page_0188351001384466862.txt', NULL, 0, 0, NULL),
(5, 'default_0244367001384467506.php', 8318, NULL, 'default.php', 'http://localhost/AIG_mensajeria/webroot/files/default_0244367001384467506.php', NULL, 0, 0, NULL),
(6, 'index_0995466001384467519.html', 5249, NULL, 'index.html', 'http://localhost/AIG_mensajeria/webroot/files/index_0995466001384467519.html', NULL, 0, 0, NULL),
(9, 'index_0910520001384467989.html', 5249, NULL, 'index.html', 'http://localhost/AIG_mensajeria/webroot/files/index_0910520001384467989.html', NULL, 1, 0, NULL),
(10, 'index_0081202001384467995.html', 5249, NULL, 'index.html', 'http://localhost/AIG_mensajeria/webroot/files/index_0081202001384467995.html', NULL, 1, 0, NULL),
(11, 'MANUALDEOFFICE_0431573001384522879.pdf', 1778566, 8, 'MANUAL DE OFFICE.pdf', 'http://localhost/AIG_mensajeria/webroot/files/MANUALDEOFFICE_0431573001384522879.pdf', NULL, 0, 0, NULL),
(12, 'MANUALDEOFFICE_0371336001384524501.pdf', 1778566, NULL, 'MANUAL DE OFFICE.pdf', 'http://localhost/AIG_mensajeria/webroot/files/MANUALDEOFFICE_0371336001384524501.pdf', NULL, 1, 0, ''),
(13, 'MANUALDEOFFICE_0911782001384525739.pdf', 1778566, NULL, 'MANUAL DE OFFICE.pdf', 'http://localhost/AIG_mensajeria/webroot/files/MANUALDEOFFICE_0911782001384525739.pdf', NULL, 1, 1, 'docuemnto de prueba'),
(14, 'MANUALDEOFFICE_0263420001384526312.pdf', 1778566, NULL, 'MANUAL DE OFFICE.pdf', 'http://localhost/AIG_mensajeria/webroot/files/MANUALDEOFFICE_0263420001384526312.pdf', NULL, 1, 1, 'pruebaa'),
(15, 'MANUALDEOFFICE_0281518001384526385.pdf', 1778566, NULL, 'MANUAL DE OFFICE.pdf', 'http://localhost/AIG_mensajeria/webroot/files/MANUALDEOFFICE_0281518001384526385.pdf', NULL, 1, 1, 'sdfgsdfg'),
(16, 'MANUALDEOFFICE_0103204001384526436.pdf', 1778566, NULL, 'MANUAL DE OFFICE.pdf', 'http://localhost/AIG_mensajeria/webroot/files/MANUALDEOFFICE_0103204001384526436.pdf', NULL, 1, 1, 'sgsdfg'),
(17, 'MANUALDEOFFICE_0531648001384526467.pdf', 1778566, NULL, 'MANUAL DE OFFICE.pdf', 'http://localhost/AIG_mensajeria/webroot/files/MANUALDEOFFICE_0531648001384526467.pdf', NULL, 1, 0, 'sdfgfdg'),
(18, 'proyectosdedivulgacion_0999196001384533596.jpg', 42311, NULL, 'proyectos de divulgacion.jpg', 'http://localhost/AIG_mensajeria/webroot/files/proyectosdedivulgacion_0999196001384533596.jpg', 67431593, 0, 0, NULL),
(19, 'MANUALDEOFFICE_0911782001384525739.pdf', 1778566, 10, 'MANUAL DE OFFICE.pdf', 'http://localhost/AIG_mensajeria/webroot/files/MANUALDEOFFICE_0911782001384525739.pdf', NULL, 0, 0, ''),
(20, 'MANUALDEOFFICE_0281518001384526385.pdf', 1778566, 10, 'MANUAL DE OFFICE.pdf', 'http://localhost/AIG_mensajeria/webroot/files/MANUALDEOFFICE_0281518001384526385.pdf', NULL, 0, 0, ''),
(21, 'Syllubus_0324609001384877299.pdf', 68459, NULL, 'Syllubus.pdf', 'http://localhost/AIG_mensajeria/webroot/files/Syllubus_0324609001384877299.pdf', NULL, 1, 1, 'Prueba del 1911'),
(22, 'wireframe_0271871001384877576.pdf', 401598, NULL, 'wireframe.pdf', 'http://localhost/AIG_mensajeria/webroot/files/wireframe_0271871001384877576.pdf', NULL, 1, 1, 'qwerty'),
(23, 'MANUALDEOFFICE_0911782001384525739_0925069001384885846.pdf', 1778566, 11, 'MANUALDEOFFICE_0911782001384525739.pdf', 'http://localhost/AIG_mensajeria/webroot/files/MANUALDEOFFICE_0911782001384525739_0925069001384885846.pdf', NULL, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) unsigned DEFAULT NULL,
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
  PRIMARY KEY (`id`),
  KEY `user` (`username`),
  KEY `mail` (`email`),
  KEY `users_FKIndex1` (`user_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `user_group_id`, `username`, `password`, `salt`, `email`, `first_name`, `last_name`, `email_verified`, `active`, `ip_address`, `created`, `modified`, `entity_id`, `first_time`, `telephone`, `celphone`) VALUES
(1, 1, 'admin', 'b670bffcdcf036b0f9be512bb25f664a', '51dc4bb92e72198d0dbb04bd2441f227', 'admin@admin.com', 'Admin', '', 1, 1, '', '2013-09-25 13:27:49', '2013-10-01 18:42:11', 0, 0, NULL, NULL),
(2, 2, 'jehogo', '48722b8cd498aaa88a46825cabf48d01', 'ed933e465fcedfd77ed9345b6ce3386b', 'gouveia.horacio@gmail.com', 'Jesus Horacio', 'Gouveia', 1, 1, NULL, '2013-09-26 15:10:21', '2013-11-13 14:13:56', 3, 0, NULL, NULL),
(3, 2, 'pedro', 'ea78d095f1a674db33ab9bc7496ad066', 'c8167bb42364235b3799a6ff95ce2443', 'pedrito@gmailc.om', 'Pedro Antonio', 'Lopez', 1, 1, NULL, '2013-10-01 10:21:27', '2013-10-01 11:47:11', 0, 1, NULL, NULL),
(4, 2, 'adriana', '5f5bf5147dd73a94a759e3a7d0a0c4c1', '9461110dab86a2f2a784257f19fca2f5', 'adrita@gmail.com', 'Adriana', 'Gomes Perez', 1, 0, NULL, '2013-10-01 10:22:26', '2013-10-01 13:37:31', 0, 1, NULL, NULL),
(13, 2, 'analado', '9d761afd06e022d4c7b86a1500c3b46b', '290453a12fb483a0ca5f82640f1eef48', 'ana.lado@lado.com', 'Ana', 'Lado', 1, 1, NULL, '2013-10-01 16:03:50', '2013-10-01 16:03:50', 0, 1, NULL, NULL),
(14, 2, 'chuo', '0b8475744f5d05aab72ddda4dce0c5aa', 'd13e4a9ea7438af60c5aba4f2e3e5982', 'gouveia.horacio+1@gmail.com', 'Chucho', 'Gouv', 1, 1, NULL, '2013-10-01 16:08:50', '2013-10-10 12:33:18', 38, 1, NULL, NULL),
(15, 2, 'checho', 'f4ab78aae28a27e623e2df1352750389', 'f4e66691f01382c5fb2b8bce8f44cbd9', 'che@das.com', 'checho', 'che', 1, 1, NULL, '2013-10-01 16:10:28', '2013-10-10 12:33:38', 38, 1, NULL, NULL),
(16, 2, 'pepito', '82a5e753b273c9191012be26eef816b0', '9fda8613933d548bfdcae61198d48204', 'pepito@grillo.com', 'Pepe', 'grillo', 1, 1, NULL, '2013-10-01 16:11:49', '2013-10-02 16:08:45', 6, 1, NULL, NULL),
(17, 2, 'rosa', '3ef71de1ee68c4006dea449dd057717d', '1f718e03079a04ea0265e2c02b28099f', 'rosa@aas.com', 'Rosa', 'Lado', 1, 1, NULL, '2013-10-01 16:13:12', '2013-11-14 14:27:00', 17, 0, NULL, NULL),
(18, 2, 'fabi', 'a16674325129fee043bc60768b16b8a9', 'f71af9577ddfb786e298f0a4612dc0bb', 'fa@perez.com', 'Fabian', 'Perez', 1, 1, NULL, '2013-10-01 16:14:18', '2013-10-02 16:05:42', 6, 1, NULL, NULL),
(19, 2, 'ricardo', 'e36a299e0d7ddb1db40bf053aff2f98f', '0fd3aec27d6c9bd09637ad567a904b00', 'rica@rdo.com', 'Ricardo Antonio', 'Perez Formigoni', 1, 1, NULL, '2013-10-01 16:50:40', '2013-11-19 11:02:02', 8, 1, '3265', '12345'),
(20, 3, 'admin_a', '8f43a8ba2d52d1f5f04b04517e95ef02', 'bd2a7de90b5b7901ecf61ab99398c773', 'jehogo@jehogo.com', 'Jesus', 'Gouveia', 1, 1, NULL, '2013-10-02 14:45:56', '2013-11-19 11:14:41', 2, 0, NULL, NULL),
(21, 2, 'test1', 'c19035391038690d4973208a55dca6b5', '4a533bd8c10b709e61f06148be0756ef', 'test1@google.com', 'Test', 'Uno', 1, 1, NULL, '2013-10-16 09:54:54', '2013-10-16 09:54:54', 8, 1, NULL, NULL),
(22, 2, 'test2', 'bd38dbd9303e02a2fdf7e3ac6c527694', 'f536f5b8c404e4f2760d7fdf156e5fef', 'test2@google.com', 'Test', 'Dos', 1, 1, NULL, '2013-10-16 09:55:27', '2013-10-30 14:29:18', 3, 1, NULL, NULL),
(23, 2, 'test3', '4e8913868150e99fe68b191548974aee', '707a80c7d98d84fa8cb1d2c235362137', 'test3@google.com', 'Test', 'Tres', 1, 1, NULL, '2013-10-16 09:56:02', '2013-10-16 09:56:02', 9, 1, NULL, NULL),
(24, 2, 'test4', '8edeb18b9873370247c516fc727dcddd', '33b2ddfa8c90ce25fb5d2e7cdb0ee858', 'test4@google.com', 'Test', 'Cuatro', 1, 1, NULL, '2013-10-16 09:56:32', '2013-10-16 09:56:32', 6, 1, NULL, NULL),
(25, 2, 'victor', '167970571452b68cb5540e01f2ade962', 'cc14cb2b85cc22f38fe18cb5aacff0b7', 'gouveia.horacio+6@gmail.com', 'Victor', 'Muñoz', 1, 1, NULL, '2013-10-29 15:56:45', '2013-10-29 15:56:45', 16, 1, NULL, NULL),
(26, 1, 'pedra', '523ee0ed9da327cfcadaff75387c63d8', 'b7ec11d37c2204ad33f149c5fdde9fa3', 'ped@sdf.com', 'Pedra', 'Lopez', 1, 1, NULL, '2013-11-13 12:19:58', '2013-11-13 12:19:58', 38, 1, NULL, NULL),
(27, 2, 'pedrito', '3c45caedd377dd361838fe981cc776e7', 'c53ded168df24de93649c8a5f8606bfa', 'pedrito+36@gmailc.om', 'Pedrito', 'Perez', 1, 1, NULL, '2013-11-13 12:21:20', '2013-11-13 12:21:20', 38, 1, NULL, NULL),
(28, 2, 'pepe', 'ff84098fb90b2dec1f4c785d8ade7ae1', '80dadb3b7d486b97280db663bcf7d769', 'pepe@pepe.com', 'pepe', 'pepe', 1, 1, NULL, '2013-11-13 13:18:28', '2013-11-13 13:18:28', 30, 1, NULL, NULL),
(29, 2, 'pepepe', '69d41b439ff84563c5954f091a8541a8', 'd5a60a036a0a23b78bd3b8eb56c05f81', 'pepepe@pepe.com', 'pepepepe', 'pepepepepepepe', 1, 1, NULL, '2013-11-13 13:19:06', '2013-11-13 13:19:06', 6, 1, NULL, NULL),
(30, 2, 'yoha', 'cd383dc6b921f2f8b891ba1fcccd83b9', '1bbd67b075208fb9a2c142112e432a69', 'yoha@zapino.com', 'Yohana', 'Zapino', 1, 1, NULL, '2013-11-13 13:20:52', '2013-11-13 13:51:18', 38, 0, '369852147', '121548611'),
(31, 2, 'grisel', '0d0df9307c473817b21d9319cb8b91ca', '6eeaf751b3aff6932863419ad9b69088', 'gris@zap.com', 'Grisel', 'Zapino', 1, 1, NULL, '2013-11-13 13:21:57', '2013-11-19 10:54:17', 38, 0, '+5841254112', '231548977'),
(32, 2, 'test1911', 'f642f384023695241a3462b20f368f79', '0bad9c725dd48db72049f2d6d37d6dfa', 'gouveia.horacio+63@gmail.com', 'Test', '1911', 1, 1, NULL, '2013-11-19 13:28:49', '2013-11-19 13:29:08', 9, 0, '', ''),
(33, 2, 'test10', 'b82e428ee3d8260b08f4e13b7daa1700', '58ec28eab4fe69772049cdfef836a391', 'perol@perols.com', 'test', 'diez', 1, 1, NULL, '2013-11-19 13:35:08', '2013-11-19 13:35:38', 6, 0, '1231321', '21321'),
(34, 2, 'test11', 'bb4d7bfaf646275ae675dac84f287051', 'c195b339f765d581d35490e96fc52157', 'gouveia.horacio+5665@gmail.com', 'Prueba', 'Del 1911', 1, 1, NULL, '2013-11-19 16:40:17', '2013-11-19 16:40:52', 8, 0, '', '');

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
(3, 'Administrador', 'administrador', 0, '2013-09-25 13:27:49', '2013-10-02 14:36:31');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=193 ;

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
(192, 3, 'Communications', 'documents', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
