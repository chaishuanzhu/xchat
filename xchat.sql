/*
 Navicat Premium Data Transfer

 Source Server         : centOS
 Source Server Type    : MySQL
 Source Server Version : 50719
 Source Host           : 106.14.80.236
 Source Database       : xchat

 Target Server Type    : MySQL
 Target Server Version : 50719
 File Encoding         : utf-8

 Date: 09/28/2017 07:17:44 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(11) NOT NULL,
  `password` varchar(32) NOT NULL,
  `phone` int(11) DEFAULT NULL,
  `nickname` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `sex` int(1) DEFAULT NULL COMMENT '0:男，1:女，2:未知',
  `headimage` varchar(100) DEFAULT NULL,
  `devicetoken` varchar(64) DEFAULT NULL,
  `token` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=100000002 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `user`
-- ----------------------------
BEGIN;
INSERT INTO `user` VALUES ('100000000', '54345354356', '35635', null, null, null, null, null, null), ('100000001', '24532', '354356', null, null, null, null, null, null);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
