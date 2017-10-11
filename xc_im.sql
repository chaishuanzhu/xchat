/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50542
 Source Host           : localhost
 Source Database       : xc_im

 Target Server Type    : MySQL
 Target Server Version : 50542
 File Encoding         : utf-8

 Date: 10/05/2017 07:25:46 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `xc_friend`
-- ----------------------------
DROP TABLE IF EXISTS `xc_friend`;
CREATE TABLE `xc_friend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xc_user_id` int(11) NOT NULL,
  `fridenUid` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '备注名',
  PRIMARY KEY (`id`),
  KEY `fk_xc_friend_xc_user1_idx` (`xc_user_id`),
  CONSTRAINT `fk_xc_friend_xc_user1` FOREIGN KEY (`xc_user_id`) REFERENCES `xc_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `xc_friendpolicy`
-- ----------------------------
DROP TABLE IF EXISTS `xc_friendpolicy`;
CREATE TABLE `xc_friendpolicy` (
  `xc_user_id` int(11) NOT NULL,
  `policy` int(11) NOT NULL DEFAULT '0' COMMENT '0：任何人都可以加好友\n1: 验证问题通过后可以加好友\n3: 拒绝任何人加好友',
  `question` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `answer` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`xc_user_id`),
  KEY `fk_xc_friendpolicy_xc_user1_idx` (`xc_user_id`),
  CONSTRAINT `fk_xc_friendpolicy_xc_user1` FOREIGN KEY (`xc_user_id`) REFERENCES `xc_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `xc_gmessage`
-- ----------------------------
DROP TABLE IF EXISTS `xc_gmessage`;
CREATE TABLE `xc_gmessage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xc_user_id` int(11) NOT NULL,
  `xc_group_id` int(11) NOT NULL,
  `content` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `sendTime` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_xc_gmessage_xc_user1_idx` (`xc_user_id`),
  KEY `fk_xc_gmessage_xc_group1_idx` (`xc_group_id`),
  CONSTRAINT `fk_xc_gmessage_xc_user1` FOREIGN KEY (`xc_user_id`) REFERENCES `xc_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_xc_gmessage_xc_group1` FOREIGN KEY (`xc_group_id`) REFERENCES `xc_group` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `xc_group`
-- ----------------------------
DROP TABLE IF EXISTS `xc_group`;
CREATE TABLE `xc_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupName` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `uid` int(11) NOT NULL,
  `createDate` datetime NOT NULL,
  `Introduction` varchar(500) COLLATE utf8_unicode_ci NOT NULL COMMENT '介绍',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `xc_message`
-- ----------------------------
DROP TABLE IF EXISTS `xc_message`;
CREATE TABLE `xc_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xc_user_id` int(11) NOT NULL,
  `toUid` int(11) NOT NULL,
  `content` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `sendTime` datetime NOT NULL,
  `type` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_xc_message_xc_user1_idx` (`xc_user_id`),
  CONSTRAINT `fk_xc_message_xc_user1` FOREIGN KEY (`xc_user_id`) REFERENCES `xc_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `xc_user`
-- ----------------------------
DROP TABLE IF EXISTS `xc_user`;
CREATE TABLE `xc_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `nickname` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `headimage` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `createIp` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `devicetoken` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `xc_user_has_xc_group`
-- ----------------------------
DROP TABLE IF EXISTS `xc_user_has_xc_group`;
CREATE TABLE `xc_user_has_xc_group` (
  `xc_user_id` int(11) NOT NULL,
  `xc_group_id` int(11) NOT NULL,
  PRIMARY KEY (`xc_user_id`,`xc_group_id`),
  KEY `fk_xc_user_has_xc_group_xc_group1_idx` (`xc_group_id`),
  KEY `fk_xc_user_has_xc_group_xc_user1_idx` (`xc_user_id`),
  CONSTRAINT `fk_xc_user_has_xc_group_xc_user1` FOREIGN KEY (`xc_user_id`) REFERENCES `xc_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_xc_user_has_xc_group_xc_group1` FOREIGN KEY (`xc_group_id`) REFERENCES `xc_group` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
