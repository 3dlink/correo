-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 29-08-2014 a las 11:18:30
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='contiene los irculos creados' AUTO_INCREMENT=20 ;

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
(15, 'Tecnología', 1, 102, 1, '2014-05-28 12:33:29', 136),
(16, 'prueba', 1, 186, 1, '2014-08-22 15:34:14', 136),
(17, 'Nuevo', 1, 50, 1, '2014-08-22 15:35:01', 75),
(18, 'nuevo', 1, 50, 1, '2014-08-22 15:36:02', 75),
(19, 'new', 1, 186, 1, '2014-08-28 10:41:17', 136);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=461 ;

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
(89, 29, 45),
(90, 30, 45),
(91, 31, 45),
(92, 1, 45),
(97, 3, 45),
(98, 3, 45),
(99, 3, 186),
(100, 4, 50),
(104, 1, 186),
(105, 2, 50),
(106, 2, 186),
(107, 4, 50),
(109, 5, 50),
(112, 6, 50),
(114, 7, 186),
(116, 8, 50),
(117, 9, 186),
(118, 10, 186),
(120, 11, 186),
(121, 12, 186),
(122, 13, 186),
(124, 14, 50),
(125, 19, 186),
(126, 20, 186),
(127, 21, 186),
(128, 22, 186),
(138, 23, 186),
(153, 24, 186),
(157, 25, 186),
(158, 25, 186),
(159, 25, 186),
(160, 25, 186),
(161, 25, 186),
(162, 25, 186),
(163, 25, 186),
(164, 25, 186),
(166, 26, 186),
(168, 27, 50),
(170, 28, 186),
(178, 30, 186),
(180, 29, 186),
(182, 31, 186),
(184, 32, 186),
(185, 32, 186),
(187, 33, 50),
(188, 33, 50),
(190, 34, 186),
(192, 35, 50),
(193, 35, 50),
(194, 35, 50),
(195, 35, 50),
(196, 35, 50),
(197, 35, 50),
(198, 35, 50),
(199, 35, 50),
(200, 35, 50),
(202, 36, 186),
(203, 36, 186),
(204, 36, 186),
(205, 36, 186),
(206, 36, 186),
(207, 36, 186),
(208, 36, 186),
(209, 36, 186),
(210, 36, 186),
(211, 36, 186),
(212, 36, 186),
(213, 36, 186),
(215, 37, 50),
(216, 37, 50),
(217, 37, 50),
(218, 37, 50),
(219, 37, 50),
(225, 38, 50),
(227, 39, 50),
(229, 40, 50),
(231, 41, 50),
(232, 42, 186),
(233, 43, 50),
(234, 43, 45),
(236, 44, 45),
(239, 44, 45),
(240, 44, 186),
(241, 45, 44),
(242, 46, 45),
(243, 46, 186),
(244, 47, 186),
(245, 48, 50),
(246, 49, 186),
(248, 50, 50),
(249, 51, 186),
(250, 52, 50),
(251, 53, 50),
(252, 54, 50),
(253, 55, 50),
(254, 56, 50),
(255, 57, 50),
(256, 58, 50),
(257, 59, 50),
(258, 60, 50),
(259, 61, 50),
(260, 73, 49),
(261, 73, 51),
(262, 73, 45),
(263, 73, 43),
(264, 74, 47),
(265, 74, 50),
(266, 74, 46),
(267, 74, 44),
(268, 75, 47),
(269, 75, 50),
(270, 75, 46),
(271, 75, 44),
(272, 76, 49),
(273, 76, 51),
(274, 76, 45),
(275, 76, 43),
(276, 76, 50),
(277, 76, 44),
(278, 77, 49),
(279, 77, 51),
(280, 77, 45),
(281, 77, 43),
(283, 77, 186),
(284, 77, 45),
(285, 77, 43),
(286, 77, 49),
(287, 77, 51),
(288, 77, 186),
(289, 77, 186),
(290, 78, 47),
(291, 78, 50),
(292, 78, 46),
(293, 78, 44),
(294, 78, 47),
(295, 78, 50),
(296, 83, 47),
(297, 83, 50),
(298, 83, 46),
(299, 83, 44),
(300, 84, 47),
(301, 84, 50),
(302, 84, 46),
(303, 84, 44),
(304, 85, 47),
(305, 85, 50),
(306, 85, 46),
(307, 85, 44),
(308, 85, 50),
(309, 86, 47),
(310, 86, 50),
(311, 86, 46),
(312, 86, 44),
(313, 86, 50),
(314, 87, 47),
(315, 87, 50),
(316, 87, 46),
(317, 87, 44),
(318, 87, 50),
(319, 88, 47),
(320, 88, 50),
(321, 88, 46),
(322, 88, 44),
(323, 88, 50),
(324, 89, 47),
(325, 89, 50),
(326, 89, 46),
(327, 89, 44),
(328, 89, 50),
(329, 90, 47),
(330, 90, 50),
(331, 90, 46),
(332, 90, 44),
(333, 90, 50),
(334, 90, 49),
(335, 90, 51),
(336, 90, 45),
(337, 90, 43),
(338, 91, 47),
(339, 91, 50),
(340, 91, 46),
(341, 91, 44),
(342, 91, 50),
(343, 91, 49),
(344, 91, 51),
(345, 91, 45),
(346, 91, 43),
(347, 92, 47),
(348, 92, 50),
(349, 92, 46),
(350, 92, 44),
(351, 92, 49),
(352, 92, 51),
(353, 92, 45),
(354, 92, 43),
(355, 93, 47),
(356, 93, 50),
(357, 93, 46),
(358, 93, 44),
(359, 94, 47),
(361, 94, 46),
(362, 94, 44),
(363, 94, 186),
(364, 94, 186),
(365, 94, 186),
(366, 94, 44),
(367, 94, 46),
(368, 94, 47),
(370, 94, 44),
(371, 94, 46),
(372, 94, 47),
(373, 94, 186),
(374, 94, 186),
(375, 94, 44),
(376, 94, 46),
(377, 94, 47),
(379, 94, 44),
(380, 94, 46),
(381, 94, 47),
(382, 94, 186),
(383, 94, 186),
(384, 94, 44),
(385, 94, 46),
(386, 94, 47),
(388, 94, 44),
(389, 94, 46),
(390, 94, 47),
(391, 94, 186),
(392, 94, 186),
(393, 94, 44),
(394, 94, 46),
(395, 94, 47),
(397, 94, 44),
(398, 94, 46),
(399, 94, 47),
(400, 94, 186),
(401, 94, 186),
(402, 94, 44),
(403, 94, 46),
(404, 94, 47),
(406, 94, 44),
(407, 94, 46),
(408, 94, 47),
(409, 94, 186),
(410, 94, 186),
(411, 94, 44),
(412, 94, 46),
(413, 94, 47),
(415, 94, 44),
(416, 94, 46),
(417, 94, 47),
(418, 94, 186),
(419, 94, 186),
(420, 94, 44),
(421, 94, 46),
(422, 94, 47),
(424, 94, 44),
(425, 94, 46),
(426, 94, 47),
(427, 94, 186),
(428, 94, 186),
(429, 94, 44),
(430, 94, 46),
(431, 94, 47),
(433, 94, 44),
(434, 94, 46),
(435, 94, 47),
(436, 94, 186),
(437, 94, 186),
(438, 94, 44),
(439, 94, 46),
(440, 94, 47),
(442, 94, 44),
(443, 94, 46),
(444, 94, 47),
(445, 94, 186),
(446, 94, 186),
(447, 94, 44),
(448, 94, 46),
(449, 94, 47),
(450, 94, 50),
(451, 95, 49),
(452, 95, 51),
(453, 95, 45),
(454, 95, 43),
(456, 95, 186),
(457, 95, 45),
(458, 95, 43),
(459, 95, 49),
(460, 95, 51);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='contiene informacion sobre si la comunicacion esta en la pap' AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla que contiene por las personas que han leido una comuni' AUTO_INCREMENT=1 ;

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
  `Zx` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `formats`
--

INSERT INTO `formats` (`id`, `upload_id`, `communication_type_id`, `communication_category_id`, `name`, `visible`, `created`, `modified`, `Zx`) VALUES
(1, 14, 3, 3, 'Formulario Viático al Exterior', 1, '2014-02-06 17:09:59', '2014-04-29 12:42:06', 0),
(2, 15, 3, 5, 'Solicitud de Autorización', 1, '2014-02-06 17:11:01', '2014-04-29 12:42:31', 0),
(3, 16, 3, 3, 'Gestión de Cobro', 1, '2014-04-24 15:34:27', '2014-04-29 12:42:43', 0);

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
  `forward` varchar(45) DEFAULT '0',
  `group` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

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
(21, 'Resolución Prueba', 28, 45, '2014-05-28 11:25:28', '2014-05-28 11:25:28'),
(22, '<pre class=', 0, 50, '2014-08-06 15:55:53', '2014-08-06 15:55:53');

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
  `signature` int(11) NOT NULL DEFAULT '0',
  `locked` int(11) NOT NULL DEFAULT '0',
  `locked_until` datetime DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  `token` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=250 ;

--
-- Volcado de datos para la tabla `uploads`
--

INSERT INTO `uploads` (`id`, `name`, `size`, `message_id`, `real_name`, `url`, `temporal`, `document`, `visible`, `description`, `signature`, `locked`, `locked_until`, `last_user_id`, `token`) VALUES
(1, 'Primero_0025671001407783609.txt', 3, 16, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0025671001407783609.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(2, 'Primero_0025671001407783609.txt', 3, 20, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0025671001407783609.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(3, 'Tercero_0720031001407784856.txt', 3, 30, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0720031001407784856.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(4, 'Segundo_0161580001407784888.txt', 3, 31, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0161580001407784888.txt', 98287763, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(5, 'Tercero_0720031001407784856.txt', 3, 34, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0720031001407784856.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(6, 'Tercero_0168086001407785855.txt', 3, 35, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0168086001407785855.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(7, 'Segundo_0862287001407786354.txt', 3, 36, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0862287001407786354.txt', 53906686, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(8, 'Segundo_0862287001407786354.txt', 3, NULL, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0862287001407786354.txt', 40476519, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(9, 'Segundo_0862287001407786354.txt', 3, NULL, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0862287001407786354.txt', 68942388, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(10, 'Segundo_0862287001407786354.txt', 3, NULL, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0862287001407786354.txt', 67879973, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(11, 'Segundo_0862287001407786354.txt', 3, NULL, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0862287001407786354.txt', 80666273, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(12, 'Segundo_0862287001407786354.txt', 3, 45, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0862287001407786354.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(13, 'Segundo_0862287001407786354.txt', 3, 44, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0862287001407786354.txt', 53906686, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(14, 'Segundo_0862287001407786354.txt', 3, 48, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0862287001407786354.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(15, 'Segundo_0862287001407786354.txt', 3, 47, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0862287001407786354.txt', 53906686, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(16, 'Segundo_0215383001407786960.txt', 3, 49, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0215383001407786960.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(17, 'Segundo_0215383001407786960.txt', 3, 50, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0215383001407786960.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(18, 'Primero_0481347001407789912.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0481347001407789912.txt', 30285227, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(19, 'Tercero_0775329001407790211.txt', 3, NULL, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0775329001407790211.txt', 62941339, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(20, 'Primero_0138483001407790299.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0138483001407790299.txt', 46857516, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(21, 'Primero_0099645001407790357.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0099645001407790357.txt', 26654389, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(22, 'Primero_0360722001407791168.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0360722001407791168.txt', 43297157, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(23, 'Primero_0924467001407791242.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0924467001407791242.txt', 18375855, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(24, 'Primero_0198944001407791582.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0198944001407791582.txt', 34515814, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(25, 'Primero_0381733001407791627.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0381733001407791627.txt', 31997841, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(26, 'Primero_0158015001407791769.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0158015001407791769.txt', 66114621, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(27, 'Primero_0606453001407791793.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0606453001407791793.txt', 72484278, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(28, 'Primero_0262008001407791938.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0262008001407791938.txt', 52794147, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(29, 'Primero_0919778001407792350.txt', 3, 61, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0919778001407792350.txt', 41321132, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(30, 'Primero_0510181001407792445.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0510181001407792445.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(31, 'Segundo_0551650001407792469.txt', 3, 0, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0551650001407792469.txt', 77762218, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(32, 'Tercero_0283130001407792556.txt', 6, 0, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0283130001407792556.txt', 79903248, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(33, 'Primero_0458576001407793472.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0458576001407793472.txt', 34594296, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(34, 'Primero_0003278001407793584.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0003278001407793584.txt', 73536226, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(35, 'Segundo_0949614001407793706.txt', 3, NULL, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0949614001407793706.txt', 73809575, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(36, 'Tercero_0431184001407793712.txt', 6, 0, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0431184001407793712.txt', 73809575, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(37, 'Tercero_0721756001407793881.txt', 6, 64, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0721756001407793881.txt', 27522254, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(38, 'Primero_0236884001407793887.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0236884001407793887.txt', 27522254, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(39, 'Segundo_0929598001407794305.txt', 3, NULL, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0929598001407794305.txt', 92247322, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(40, 'Primero_0052204001407794332.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0052204001407794332.txt', 94626149, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(41, 'Primero_0951973001407794452.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0951973001407794452.txt', 93259482, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(42, NULL, NULL, 71, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(43, 'Primero_0047693001407794540.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0047693001407794540.txt', 59268346, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(44, NULL, NULL, 72, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(45, 'Primero_0433040001407794680.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0433040001407794680.txt', 90857758, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(46, NULL, NULL, 73, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(47, 'Primero_0324469001407795032.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0324469001407795032.txt', 98294090, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(48, NULL, NULL, 74, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(49, 'Primero_0722955001407795074.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0722955001407795074.txt', 87262652, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(50, 'Segundo_0684231001407795131.txt', 3, 76, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0684231001407795131.txt', 80134656, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(51, 'Primero_0708496001407795160.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0708496001407795160.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(52, 'Segundo_0277387001407795180.txt', 3, 0, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0277387001407795180.txt', 26953547, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(53, 'Primero_0714960001407795329.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0714960001407795329.txt', 91674081, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(54, 'Tercero_0671831001407795391.txt', 6, 0, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0671831001407795391.txt', 36348511, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(55, 'Segundo_0804304001407795459.txt', 3, NULL, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0804304001407795459.txt', 10146082, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(56, 'Primero_0616076001407795505.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0616076001407795505.txt', 48283550, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(57, 'Segundo_0525773001407795617.txt', 3, 0, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0525773001407795617.txt', 31939872, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(58, 'Primero_0453913001407795712.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0453913001407795712.txt', 43714391, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(59, 'Segundo_0631014001407795779.txt', 3, 0, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0631014001407795779.txt', 15757436, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(60, 'Tercero_0035184001407795852.txt', 6, 0, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0035184001407795852.txt', 90584425, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(61, 'Primero_0222423001407795902.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0222423001407795902.txt', 34222858, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(63, 'Primero_0350352001407796030.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0350352001407796030.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(65, 'Primero_0603119001407796255.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0603119001407796255.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(67, 'Primero_0770746001407796332.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0770746001407796332.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(68, 'Segundo_0715728001407796348.txt', 3, 93, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0715728001407796348.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(69, 'Primero_0930931001407796511.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0930931001407796511.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(70, 'Segundo_0242344001407796621.txt', 3, 0, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0242344001407796621.txt', 48606652, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(71, 'Primero_0638352001407796727.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0638352001407796727.txt', 79491717, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(72, 'Tercero_0487051001407796753.txt', 6, 0, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0487051001407796753.txt', 49184150, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(73, 'Segundo_0111795001407796798.txt', 3, NULL, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0111795001407796798.txt', 64905646, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(74, 'Tercero_0643515001407796802.txt', 6, 0, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0643515001407796802.txt', 64905646, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(75, 'Segundo_0399517001407796835.txt', 3, 0, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0399517001407796835.txt', 97213355, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(76, 'Primero_0827717001407796838.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0827717001407796838.txt', 97213355, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(77, 'Primero_0738586001407796856.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0738586001407796856.txt', 97225939, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(78, 'Tercero_0272849001407796862.txt', 6, 0, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0272849001407796862.txt', 97225939, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(79, 'Primero_0604630001407797169.txt', 3, 101, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0604630001407797169.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(80, 'Segundo_0300102001407797333.txt', 3, 0, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0300102001407797333.txt', 52772756, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(81, 'Primero_0513021001407797354.txt', 3, 94, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0513021001407797354.txt', 24849197, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(82, 'Primero_0732807001407797509.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0732807001407797509.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(83, 'Primero_0252492001407797540.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0252492001407797540.txt', 58311882, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(84, 'Segundo_0062874001407797548.txt', 3, 104, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0062874001407797548.txt', 58311882, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(85, 'Primero_0583600001407797975.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0583600001407797975.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(86, 'Primero_0893058001407797991.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0893058001407797991.txt', 55833497, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(87, 'Segundo_0631764001407798000.txt', 3, 0, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0631764001407798000.txt', 55833497, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(88, 'Primero_0218663001407798068.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0218663001407798068.txt', 57379488, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(89, 'Segundo_0321593001407798072.txt', 3, 106, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0321593001407798072.txt', 57379488, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(90, 'Primero_0583694001407798123.txt', 3, 109, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0583694001407798123.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(91, 'Segundo_0112978001407798127.txt', 3, 0, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0112978001407798127.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(92, 'Tercero_0582218001407798149.txt', 6, NULL, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0582218001407798149.txt', 67361265, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(93, 'Tercero_0739779001407798153.txt', 6, 0, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0739779001407798153.txt', 67361265, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(94, 'Primero_0232928001407798195.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0232928001407798195.txt', 58889670, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(95, 'Primero_0018656001407798199.txt', 3, 109, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0018656001407798199.txt', 58889670, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(96, 'Primero_0301488001407852917.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0301488001407852917.txt', 78575918, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(97, 'Primero_0575655001407853723.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0575655001407853723.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(98, 'Segundo_0631927001407853750.txt', 3, NULL, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0631927001407853750.txt', 22336320, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(99, 'Tercero_0118942001407853758.txt', 6, 0, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0118942001407853758.txt', 22336320, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(100, 'Primero_0417046001407853928.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0417046001407853928.txt', 34694983, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(101, 'Segundo_0772410001407853934.txt', 3, 114, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0772410001407853934.txt', 34694983, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(102, 'Primero_0325453001407853970.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0325453001407853970.txt', 63758954, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(103, 'Primero_0752677001407854550.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0752677001407854550.txt', 17693693, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(104, 'Primero_0942947001407854723.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0942947001407854723.txt', 47931177, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(105, 'Primero_0283468001407854894.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0283468001407854894.txt', 63307393, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(106, 'Primero_0632460001407854960.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0632460001407854960.txt', 39984574, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(107, 'Primero_0228167001407855023.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0228167001407855023.txt', 72741079, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(108, 'Primero_0081712001407855077.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0081712001407855077.txt', 39812721, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(109, 'Primero_0997694001407857589.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0997694001407857589.txt', 27377359, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(110, 'Primero_0820914001407857597.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0820914001407857597.txt', 27377359, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(111, 'Primero_0807238001407857704.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0807238001407857704.txt', 36725377, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(112, 'Primero_0823919001407857713.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0823919001407857713.txt', 36725377, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(113, 'Primero_0816982001407858058.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0816982001407858058.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(114, 'Segundo_0808516001407858063.txt', 3, 0, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0808516001407858063.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(115, 'Primero_0858345001407858090.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0858345001407858090.txt', 84824770, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(116, 'Segundo_0648833001407858105.txt', 3, NULL, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0648833001407858105.txt', 84824770, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(117, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(118, 'Primero_0234923001407858318.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0234923001407858318.txt', 59754110, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(119, 'Segundo_0501240001407858324.txt', 3, NULL, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0501240001407858324.txt', 59754110, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(120, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(121, 'Primero_0975204001407858432.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0975204001407858432.txt', 82103389, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(122, 'Tercero_0787728001407858438.txt', 6, NULL, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0787728001407858438.txt', 82103389, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(123, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(124, 'Primero_0233902001407858694.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0233902001407858694.txt', 39956860, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(125, 'Segundo_0693475001407858698.txt', 3, NULL, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0693475001407858698.txt', 39956860, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(126, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(127, 'Primero_0807702001407858762.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0807702001407858762.txt', 23816098, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(128, 'Segundo_0325395001407858767.txt', 3, NULL, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0325395001407858767.txt', 23816098, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(129, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(130, 'Primero_0513929001407858812.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0513929001407858812.txt', 62421549, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(131, 'Segundo_0724586001407858816.txt', 3, NULL, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0724586001407858816.txt', 62421549, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(132, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(133, 'Primero_0436653001407858896.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0436653001407858896.txt', 24253439, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(134, 'Segundo_0543120001407858901.txt', 3, NULL, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0543120001407858901.txt', 24253439, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(135, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(136, 'Primero_0498656001407858951.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0498656001407858951.txt', 62719967, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(137, 'Segundo_0429543001407858955.txt', 3, NULL, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0429543001407858955.txt', 62719967, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(138, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(139, 'Primero_0185979001407859033.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0185979001407859033.txt', 13362632, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(140, 'Segundo_0147316001407859037.txt', 3, NULL, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0147316001407859037.txt', 13362632, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(141, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(142, 'Primero_0590846001407859100.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0590846001407859100.txt', 59384899, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(143, 'Segundo_0566114001407859104.txt', 3, NULL, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0566114001407859104.txt', 59384899, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(144, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(145, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(146, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(147, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(148, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(149, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(150, 'Primero_0794568001407859262.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0794568001407859262.txt', 61337033, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(151, 'Segundo_0438055001407859267.txt', 3, NULL, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0438055001407859267.txt', 61337033, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(152, NULL, NULL, 124, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(153, NULL, NULL, 124, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(154, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(155, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(156, 'Primero_0320758001407859490.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0320758001407859490.txt', 14989762, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(157, 'Segundo_0960279001407859495.txt', 3, NULL, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0960279001407859495.txt', 14989762, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(158, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(159, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(160, 'Tercero_0991522001407859585.txt', 6, 0, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0991522001407859585.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(161, 'Segundo_0522884001407859590.txt', 3, 0, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0522884001407859590.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(162, 'Primero_0405430001407859618.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0405430001407859618.txt', 73825998, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(163, 'Primero_0771361001407859623.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0771361001407859623.txt', 73825998, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(164, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(165, 'Primero_0959386001407859733.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0959386001407859733.txt', 76797924, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(166, 'Primero_0024337001407859738.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0024337001407859738.txt', 76797924, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(167, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(168, 'Primero_0245093001407859827.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0245093001407859827.txt', 11846291, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(169, 'Segundo_0791560001407859832.txt', 3, NULL, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0791560001407859832.txt', 11846291, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(170, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(171, 'Primero_0747862001407859885.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0747862001407859885.txt', 64554369, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(172, 'Segundo_0120569001407859890.txt', 3, 0, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0120569001407859890.txt', 64554369, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(173, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(174, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(175, 'Primero_0128628001407860017.txt', 3, 137, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0128628001407860017.txt', 58587156, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(176, 'Primero_0191200001407860021.txt', 3, 137, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0191200001407860021.txt', 58587156, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(177, 'Tercero_0942073001407867887.txt', 6, 0, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0942073001407867887.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(178, 'Segundo_0722386001407867892.txt', 3, 0, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0722386001407867892.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(179, 'Primero_0827951001407867909.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0827951001407867909.txt', 29189934, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(180, 'Primero_0625363001407867914.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0625363001407867914.txt', 29189934, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(181, 'Primero_0007684001407868065.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0007684001407868065.txt', 44491051, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(182, 'Primero_0580911001407868373.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0580911001407868373.txt', 69706338, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(183, 'Tercero_0750110001407868524.txt', 6, 0, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0750110001407868524.txt', 48446811, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(184, 'Tercero_0716335001407868528.txt', 6, 0, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0716335001407868528.txt', 48446811, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(185, 'Primero_0517321001407868533.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0517321001407868533.txt', 48446811, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(186, 'Primero_0590064001407868600.txt', 3, 143, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0590064001407868600.txt', 17625453, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(187, 'Segundo_0952109001407868604.txt', 3, 143, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0952109001407868604.txt', 17625453, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(188, 'Primero_0907423001407868608.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0907423001407868608.txt', 17625453, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(189, 'Primero_0861140001407869007.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0861140001407869007.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(190, 'Segundo_0678127001407869011.txt', 3, 0, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0678127001407869011.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(191, 'Tercero_0826873001407869042.txt', 6, 149, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0826873001407869042.txt', 28443045, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(192, 'Tercero_0659870001407869048.txt', 6, 149, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0659870001407869048.txt', 28443045, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(193, 'Primero_0014817001407869054.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0014817001407869054.txt', 28443045, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(194, 'Primero_0005539001407869155.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0005539001407869155.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(195, 'Segundo_0625384001407869160.txt', 3, 0, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0625384001407869160.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(196, 'Tercero_0078145001407869206.txt', 6, 151, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0078145001407869206.txt', 25114853, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(197, 'Tercero_0858891001407869210.txt', 6, 0, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0858891001407869210.txt', 25114853, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(198, 'Cuarto_0918494001407869215.txt', 6, 151, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0918494001407869215.txt', 25114853, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(199, 'Primero_0830921001407869304.txt', 3, 0, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0830921001407869304.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(200, 'Segundo_0243775001407869309.txt', 3, 0, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0243775001407869309.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(201, 'Tercero_0468420001407869324.txt', 6, 153, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0468420001407869324.txt', 68224530, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(202, 'Tercero_0595883001407869328.txt', 6, 153, 'Tercero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Tercero_0595883001407869328.txt', 68224530, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(203, 'Cuarto_0451033001407869333.txt', 6, 154, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0451033001407869333.txt', 68224530, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(204, 'ManualTecnicoAIG_0586686001407869810.doc', 8395776, 155, 'Manual Tecnico AIG.doc', 'http://localhost/AIG_mensajeria/webroot/files/ManualTecnicoAIG_0586686001407869810.doc', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(205, 'Cuarto_0840146001407869873.txt', 6, NULL, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0840146001407869873.txt', 14989567, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(206, 'Cuarto_0104975001407870031.txt', 6, 156, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0104975001407870031.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(207, 'Primero_0469492001407870315.txt', 3, 157, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0469492001407870315.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(208, 'Primero_0469492001407870315.txt', 3, 164, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0469492001407870315.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(209, 'Primero_0522191001407872080.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0522191001407872080.txt', 33609532, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(210, 'Primero_0967905001407872474.txt', 3, NULL, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0967905001407872474.txt', 97566835, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(211, 'Cuarto_0786043001407872638.txt', 6, NULL, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0786043001407872638.txt', 97566835, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(212, 'Cuarto_0151454001407872971.txt', 6, NULL, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0151454001407872971.txt', 70233712, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(213, 'Cuarto_0956735001407873034.txt', 6, NULL, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0956735001407873034.txt', 70233712, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(214, 'Cuarto_0914727001407873136.txt', 6, NULL, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0914727001407873136.txt', 70233712, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(215, 'Cuarto_0548137001407873208.txt', 6, NULL, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0548137001407873208.txt', 64669398, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(216, 'Cuarto_0694834001407873261.txt', 6, NULL, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0694834001407873261.txt', 64669398, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(217, 'Cuarto_0840474001407873286.txt', 6, NULL, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0840474001407873286.txt', 64669398, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(218, 'Cuarto_0906607001407873388.txt', 6, NULL, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0906607001407873388.txt', 42657384, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(219, 'Cuarto_0421239001407873486.txt', 6, NULL, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0421239001407873486.txt', 77113369, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(220, 'Cuarto_0810870001407873520.txt', 6, NULL, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0810870001407873520.txt', 37761112, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(221, 'Cuarto_0036451001407873561.txt', 6, NULL, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0036451001407873561.txt', 23888676, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(222, 'Cuarto_0992153001407873592.txt', 6, NULL, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0992153001407873592.txt', 30413736, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(223, 'Cuarto_0890045001407873627.txt', 6, NULL, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0890045001407873627.txt', 24278443, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(224, 'Cuarto_0760817001407873692.txt', 6, NULL, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0760817001407873692.txt', 89212947, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(225, 'Cuarto_0965687001407873717.txt', 6, NULL, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0965687001407873717.txt', 39532222, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(226, 'Cuarto_0453160001407873786.txt', 6, NULL, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0453160001407873786.txt', 82657113, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(227, 'Cuarto_0698423001407874029.txt', 6, NULL, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0698423001407874029.txt', 12617343, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(228, 'ManualTecnicoAIG_0155078001407874362.doc', 8395776, NULL, 'Manual Tecnico AIG.doc', 'http://localhost/AIG_mensajeria/webroot/files/ManualTecnicoAIG_0155078001407874362.doc', 60831188, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(229, 'ManualTecnicoAIG_0352646001407874550.doc', 8395776, NULL, 'Manual Tecnico AIG.doc', 'http://localhost/AIG_mensajeria/webroot/files/ManualTecnicoAIG_0352646001407874550.doc', 71584073, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(230, 'ManualTecnicoAIG_0372946001407874727.doc', 8395776, NULL, 'Manual Tecnico AIG.doc', 'http://localhost/AIG_mensajeria/webroot/files/ManualTecnicoAIG_0372946001407874727.doc', 54369713, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(231, 'ManualTecnicoAIG_0523858001407874753.doc', 8395776, NULL, 'Manual Tecnico AIG.doc', 'http://localhost/AIG_mensajeria/webroot/files/ManualTecnicoAIG_0523858001407874753.doc', 14405426, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(232, 'ManualTecnicoAIG_0744890001407874926.doc', 8395776, NULL, 'Manual Tecnico AIG.doc', 'http://localhost/AIG_mensajeria/webroot/files/ManualTecnicoAIG_0744890001407874926.doc', 25643576, 0, 0, NULL, 1, 0, NULL, NULL, NULL),
(233, 'Primero_0503070001407875791.txt', 3, 166, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0503070001407875791.txt', NULL, 0, 0, NULL, 1, 1, '2014-08-12 17:37:05', 186, 'd5fc4e430526effb688046dc93b312cf'),
(234, 'Cuarto_0267049001407875941.txt', 6, 167, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0267049001407875941.txt', NULL, 0, 0, NULL, 1, 1, '2014-08-12 17:40:20', 186, '3027c3f6481b2d20e13d211164bcb2b6'),
(235, 'Cuarto_0722356001407876176.txt', 6, 168, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0722356001407876176.txt', NULL, 0, 0, NULL, 1, 1, '2014-08-12 17:43:18', 50, 'fd0a254fadd1950db0954fd2ebe965ad'),
(236, 'Cuarto_0416116001407876292.txt', 6, 169, 'Cuarto.txt', 'http://localhost/AIG_mensajeria/webroot/files/Cuarto_0416116001407876292.txt', NULL, 0, 0, NULL, 1, 1, '2014-08-12 17:45:41', 186, '8a7d98f32baeab33d46c0f46f7f18f07'),
(237, 'Primero_0471442001407960908.txt', 3, 170, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0471442001407960908.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(238, 'Segundo_0671203001407960944.txt', 3, 171, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0671203001407960944.txt', 34223051, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(239, 'Primero_0471442001407960908.txt', 3, 173, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0471442001407960908.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(240, 'Primero_0471442001407960908.txt', 3, 176, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0471442001407960908.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(241, 'Primero_0471442001407960908.txt', 3, 182, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0471442001407960908.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(242, NULL, NULL, 185, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(243, NULL, NULL, 188, NULL, NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(244, 'Primero_0471442001407960908.txt', 3, 191, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0471442001407960908.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(245, 'Primero_0471442001407960908.txt', 3, 194, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0471442001407960908.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(246, 'Primero_0471442001407960908.txt', 3, 197, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0471442001407960908.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(247, 'Primero_0471442001407960908.txt', 3, 200, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0471442001407960908.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(248, 'Segundo_0671203001407960944.txt', 3, 202, 'Segundo.txt', 'http://localhost/AIG_mensajeria/webroot/files/Segundo_0671203001407960944.txt', 34223051, 0, 0, NULL, 0, 0, NULL, NULL, NULL),
(249, 'Primero_0471442001407960908.txt', 3, 203, 'Primero.txt', 'http://localhost/AIG_mensajeria/webroot/files/Primero_0471442001407960908.txt', NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=190 ;

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
(48, 3, '', 'admin_test', '9f584b7164f06136a0d1305b0b91f4eb', 'd7c71c4da81742623ee5cc7833eed23b', 'test@admin.com', 'test', 'admin', 1, 0, NULL, '2014-02-06 17:17:41', '2014-05-22 16:55:03', 128, 0, '123', '123', 1, 1),
(49, 1, 'Test', 'tester', '940ca974097f76aec2aa70964a16d3d6', 'be6765b9efd064e42e4da431db27e86b', 'test@testx.com', 'Prueba', 'Prueba2', 1, 1, NULL, '2014-03-12 18:43:30', '2014-03-12 18:43:30', 128, 1, '1234', '1234', 2, 1),
(50, 2, 'Prueba', 'alex_test', '71b305e60c5d5c50e03b7fdfe34cdcd6', '9bc12d1b286333b7cf00fccffc2a421f', 'a.fradiani@gmail.com', 'Alex', 'Fradiani', 1, 1, NULL, '2014-03-25 15:22:53', '2014-05-23 10:31:17', 79, 0, '123', '123', 2, 1),
(51, 2, 'xxx', 'aig_usuario', '5a9ee4a6cc07b9d0dcf5547eb06776f6', 'bd14760e1d937d205ebc69c0cb72220c', 'a.fradiani@gmail.com', 'usuario', 'xxx', 1, 1, NULL, '2014-03-25 16:32:27', '2014-05-23 11:13:42', 61, 0, '123', '123', 2, 1),
(53, 2, 'probador', 'user aig2-delete', '7a30d86527e8bd5f52b8057e222d62a4', '4dac2ae036b590f390d89788ce95bdf9', 'test@testxxxx.com-delete', 'test', 'test', 1, 0, NULL, '2014-04-07 12:19:26', '2014-04-07 12:20:22', 132, 1, '123', '123', 2, 0),
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
(148, 3, 'Gerente de Tecnologia Aplicada', 'aortega', '172231197419a670d1f74714a65d088c', '7520c3ae6dab93beb8c6235a9a30fb76', 'aortega@innovacion.gob.pa', 'Adonay', 'Ortega', 1, 1, NULL, '2014-04-15 16:06:26', '2014-08-28 11:25:30', 169, 1, '5207432', '66708809', 1, 1),
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
(164, 2, 'Conductor', 'amagallon', '5833276bc4213a09db7e1654f9e9e509', '739333ce112032a8eac45b8c8c027874', 'amagallon@innovacion.gob.pa', 'Alex', 'Magallón', 1, 0, NULL, '2014-04-16 09:13:12', '2014-08-27 11:06:18', 145, 1, '5207400', '', 14, 1),
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
(185, 2, 'Analista De Sistemas y Metodos Informaticos', 'ccogley@innovacion.gob.pa', '0e0add534247b7401f065ed948c31bcb', '781d9531019f5e83ea1d1f4bebe05971', 'ccogley@innovacion.gob.pa', 'Christopher ', 'Cogley', 1, 1, NULL, '2014-05-14 11:59:08', '2014-05-14 11:59:08', 168, 1, '520-7400', '', 14, 1),
(186, 2, 'Programador', 'Cahl', 'e91dbc4b4e856da72f498c551e34f663', '580a2ea65a1014aa38448511dfd4f87f', 'cesarherguetal@gmail.com', 'Cesar', 'Hergueta', 1, 1, NULL, '2014-08-06 16:11:23', '2014-08-06 16:11:40', 137, 0, '123456789', '123456789', 15, 1),
(187, 2, 'nada', 'prueba', '6b14c689e84bf4197dfe1cccedcfdd5b', '6a43105a518d9bad04d86a7dd8096842', 'asds@sad.com', 'asd', 'asd', 1, 1, NULL, '2014-08-25 16:53:07', '2014-08-25 16:53:07', 136, 1, '221312312', '123123123', 1, 1),
(188, 2, 'jugar', 'android', 'a1be84ebf25dc314c223093f5acbf30d', 'ddcab73690e503a0e9e0e9e74ae67bd4', 'android@et.com', 'android', 'extraterrestre', 1, 1, NULL, '2014-08-25 17:28:35', '2014-08-25 17:28:35', 136, 1, '77889988', '88997755', 1, 1),
(189, 2, 'nada', 'unonulo', '263ecfe434ae2884fa7d56bfeb3fcf52', '76880fb44e8ba22c8e29af5c4b69fc32', 'bien@ytu.com', 'bien', 'ytu', 1, 1, NULL, '2014-08-28 09:49:58', '2014-08-28 09:49:58', 136, 1, '5678', '5678', 0, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='contiene los usuarios que estan en un grupo' AUTO_INCREMENT=51 ;

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
(43, 109, 15),
(44, 186, 16),
(45, 50, 17),
(47, 50, 18),
(48, 186, 18),
(49, 50, 16),
(50, 186, 19);

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

DROP TABLE IF EXISTS `user_group_permissions`;
CREATE TABLE IF NOT EXISTS `user_group_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_group_id` int(10) unsigned NOT NULL,
  `controller` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `action` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `allowed` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=310 ;

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
(171, 3, 'Entities', 'findAllPeople', 1),
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
(210, 3, 'Communications', 'directory', 1),
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
(228, 3, 'Groups', 'findPeopleByGoup', 1),
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
(252, 3, 'Circles', 'getCircleById', 1),
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
(282, 3, 'Entities', 'edit', 1),
(283, 1, 'Communications', 'addPreUpload', 1),
(284, 2, 'Communications', 'addPreUpload', 1),
(285, 3, 'Communications', 'addPreUpload', 1),
(286, 1, 'Communications', 'add_required', 1),
(287, 2, 'Communications', 'add_required', 1),
(288, 3, 'Communications', 'add_required', 1),
(289, 1, 'Communications', 'check_file', 1),
(290, 2, 'Communications', 'check_file', 1),
(291, 3, 'Communications', 'check_file', 1),
(292, 1, 'Communications', 'block_file', 1),
(293, 2, 'Communications', 'block_file', 1),
(294, 3, 'Communications', 'block_file', 1),
(295, 1, 'Groups', 'index', 1),
(296, 2, 'Groups', 'index', 0),
(297, 3, 'Groups', 'index', 1),
(298, 1, 'Groups', 'add', 1),
(299, 2, 'Groups', 'add', 0),
(300, 3, 'Groups', 'add', 1),
(301, 1, 'Groups', 'edit', 1),
(302, 2, 'Groups', 'edit', 0),
(303, 3, 'Groups', 'edit', 1),
(304, 1, 'Groups', 'eject', 0),
(305, 2, 'Groups', 'eject', 0),
(306, 3, 'Groups', 'eject', 1),
(307, 1, 'Groups', 'addPeopleGroup', 0),
(308, 2, 'Groups', 'addPeopleGroup', 0),
(309, 3, 'Groups', 'addPeopleGroup', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
