/*
 Navicat Premium Data Transfer

 Source Server         : centOS
 Source Server Type    : MySQL
 Source Server Version : 50719
 Source Host           : 106.14.80.236
 Source Database       : xc_im

 Target Server Type    : MySQL
 Target Server Version : 50719
 File Encoding         : utf-8

 Date: 10/11/2017 15:54:27 PM
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
  `friend_uid` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '备注名',
  PRIMARY KEY (`id`),
  UNIQUE KEY `xc_user_id` (`xc_user_id`,`friend_uid`),
  KEY `fk_xc_friend_xc_user1_idx` (`xc_user_id`),
  CONSTRAINT `fk_xc_friend_xc_user1` FOREIGN KEY (`xc_user_id`) REFERENCES `xc_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `xc_friend`
-- ----------------------------
BEGIN;
INSERT INTO `xc_friend` VALUES ('1', '100000001', '1', null);
COMMIT;

-- ----------------------------
--  Table structure for `xc_friendpolicy`
-- ----------------------------
DROP TABLE IF EXISTS `xc_friendpolicy`;
CREATE TABLE `xc_friendpolicy` (
  `xc_user_id` int(11) NOT NULL,
  `policy` int(1) NOT NULL DEFAULT '0' COMMENT '0：任何人都可以加好友\n1: 验证问题通过后可以加好友\n3: 拒绝任何人加好友',
  `question` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `answer` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`xc_user_id`),
  KEY `fk_xc_friendpolicy_xc_user1_idx` (`xc_user_id`),
  CONSTRAINT `fk_xc_friendpolicy_xc_user1` FOREIGN KEY (`xc_user_id`) REFERENCES `xc_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
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
  CONSTRAINT `fk_xc_gmessage_xc_group1` FOREIGN KEY (`xc_group_id`) REFERENCES `xc_group` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_xc_gmessage_xc_user1` FOREIGN KEY (`xc_user_id`) REFERENCES `xc_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `xc_group`
-- ----------------------------
DROP TABLE IF EXISTS `xc_group`;
CREATE TABLE `xc_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupName` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `uid` int(11) NOT NULL,
  `createDate` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `introduction` varchar(500) COLLATE utf8_unicode_ci NOT NULL COMMENT '介绍',
  `image` varchar(225) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10005 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `xc_group`
-- ----------------------------
BEGIN;
INSERT INTO `xc_group` VALUES ('10001', '0410', '1000000000', '2420', '242402425', null), ('10002', '46545', '100000001', '1507704280', '1111111', 'http://xchat.chaisz.xyz/headimages/20171011/e2b9f34c3546116b946cb1bfb65cbe5d.png'), ('10003', '46545', '100000001', '1507704323', '1111111', null), ('10004', 'ios', '3', '1507707205', '5143125', null);
COMMIT;

-- ----------------------------
--  Table structure for `xc_message`
-- ----------------------------
DROP TABLE IF EXISTS `xc_message`;
CREATE TABLE `xc_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xc_user_id` int(11) NOT NULL,
  `to_uid` int(11) NOT NULL,
  `content` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `sendTime` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_xc_message_xc_user1_idx` (`xc_user_id`),
  CONSTRAINT `fk_xc_message_xc_user1` FOREIGN KEY (`xc_user_id`) REFERENCES `xc_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `xc_message`
-- ----------------------------
BEGIN;
INSERT INTO `xc_message` VALUES ('1', '100000001', '1', '45435415', '1507697836', 'text'), ('2', '100000001', '1', '45435415', '1507697851', 'text'), ('3', '100000001', '1', '45435415', '1507698654', 'text'), ('4', '100000001', '1', '45435415', '1507699609', 'text'), ('5', '100000001', '1', 'applyfriend', '1507701746', 'friend_apply'), ('6', '100000001', '1', 'applyfriend', '1507701838', 'friend_apply'), ('7', '100000001', '1', 'applyfriend', '1507701850', 'friend_apply'), ('8', '100000001', '1', 'applyfriend', '1507701879', 'friend_apply'), ('9', '100000001', '1', 'applyfriend', '1507701900', 'friend_apply'), ('10', '100000000', '1', 'xxx申请添加您为好友', '1507706199', 'friend_apply'), ('11', '3', '3', '5143125', '1507707625', 'group_apply');
COMMIT;

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
  `createDate` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createIp` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `devicetoken` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=100000003 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `xc_user`
-- ----------------------------
BEGIN;
INSERT INTO `xc_user` VALUES ('1', '784854@qq.com', '5645646', null, null, null, null, null, 'ed8c1c155a6daf448f610ae749eec794be551f8d1b145448711eea973583f820', null), ('2', '7848454@qq.com', '5645646', null, 'http://xchat.chaisz.xyz/headimages/20171011/be4961ed538a58e442f1537c553cbb65.png', null, null, null, null, null), ('3', '784812454@qq.com', '5645646', null, null, '1507689873', '::1', null, '151312545454', null), ('100000000', '323@qq.com', '15213', '151312545454', 'http://xchat.chaisz.xyz/headimages/20171011/c28907c29be9e53471dc54a556549e85.png', null, null, null, null, '5642425646'), ('100000001', '1313424@qq.com', '21342342', 'tom', null, '1507691095', '::1', null, '151312545454', '17633658036'), ('100000002', '1000000@qq.com', '46545', null, null, '1507704887', '60.191.75.219', null, '1111111', null);
COMMIT;

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
  CONSTRAINT `fk_xc_user_has_xc_group_xc_group1` FOREIGN KEY (`xc_group_id`) REFERENCES `xc_group` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_xc_user_has_xc_group_xc_user1` FOREIGN KEY (`xc_user_id`) REFERENCES `xc_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
