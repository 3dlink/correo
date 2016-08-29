/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : correspondencia

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2014-12-03 14:22:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for acknowledgments
-- ----------------------------
DROP TABLE IF EXISTS `acknowledgments`;
CREATE TABLE `acknowledgments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document` varchar(255) DEFAULT NULL,
  `communication_id` int(11) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of acknowledgments
-- ----------------------------
