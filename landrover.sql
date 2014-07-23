/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : landrover

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2014-07-23 15:19:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `coupon_base`
-- ----------------------------
DROP TABLE IF EXISTS `coupon_base`;
CREATE TABLE `coupon_base` (
  `coupon_id` varchar(255) NOT NULL,
  `user_type` tinyint(2) NOT NULL,
  `city` tinyint(1) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `same_per_coupon_id` varchar(255) NOT NULL,
  `hotel_is` tinyint(1) NOT NULL,
  `cx` varchar(255) NOT NULL,
  PRIMARY KEY (`coupon_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of coupon_base
-- ----------------------------
INSERT INTO `coupon_base` VALUES ('LREBJ0000000', '1', '1', '小一', '先生', '13912345678', '13912345678@qq.com', '1', '1', 'A');
INSERT INTO `coupon_base` VALUES ('LREBJ0000001', '1', '1', '小一', '先生', '13912345678', '13912345678@qq.com', '1', '1', 'A');
INSERT INTO `coupon_base` VALUES ('LREBJ0000002', '2', '1', '小二', '先生', '13325363636', '13325363636@qq.com', '2', '1', 'B');
INSERT INTO `coupon_base` VALUES ('LREBJ0000003', '2', '1', '小二', '先生', '13325363636', '13325363636@qq.com', '2', '1', 'B');
INSERT INTO `coupon_base` VALUES ('LREGZ0000004', '2', '2', '小三', '女士', '13511111111', '13511111111@qq.com', '3', '0', 'A');
INSERT INTO `coupon_base` VALUES ('LREGZ0000005', '2', '2', '小三', '先生', '13511111111', '13511111111@qq.com', '3', '0', 'A');
INSERT INTO `coupon_base` VALUES ('LREGZ0000006', '1', '2', '小四', '女士', '13522222222', '13522222222@qq.com', '4', '0', 'B');
INSERT INTO `coupon_base` VALUES ('LREGZ0000007', '1', '2', '小四', '先生', '13522222222', '13522222222@qq.com', '4', '0', 'B');
INSERT INTO `coupon_base` VALUES ('LRECD0000008', '1', '4', '小伍', '女士', '13533333333', '13533333333@qq.com', '5', '1', 'A');
INSERT INTO `coupon_base` VALUES ('LRECD0000009', '1', '4', '小伍', '先生', '13533333333', '13533333333@qq.com', '5', '1', 'A');
INSERT INTO `coupon_base` VALUES ('LRECD0000010', '2', '4', '小六', '女士', '13544444444', '13544444444@qq.com', '6', '1', 'B');
INSERT INTO `coupon_base` VALUES ('LRECD0000011', '2', '4', '小六', '先生', '13544444444', '13544444444@qq.com', '6', '1', 'B');
INSERT INTO `coupon_base` VALUES ('LREHZ0000012', '0', '3', '小七', '女士', '13566666666', '13566666666@qq.com', '7', '0', 'A');
INSERT INTO `coupon_base` VALUES ('LREHZ0000013', '0', '3', '小七', '先生', '13566666666', '13566666666@qq.com', '7', '0', 'A');
INSERT INTO `coupon_base` VALUES ('LREHZ0000014', '0', '3', '小八', '女士', '13577777777', '13577777777@qq.com', '8', '0', 'B');
INSERT INTO `coupon_base` VALUES ('LREHZ0000015', '0', '3', '小八', '先生', '13577777777', '13577777777@qq.com', '8', '0', 'B');
INSERT INTO `coupon_base` VALUES ('LREBJ0000016', '0', '1', '小一', '先生', '13912345678', '13912345678@qq.com', '9', '0', 'A');
INSERT INTO `coupon_base` VALUES ('LREBJ0000017', '0', '1', '小一', '先生', '13912345678', '13912345678@qq.com', '9', '0', 'A');
INSERT INTO `coupon_base` VALUES ('LREBJ0000018', '0', '1', '小二', '先生', '13588888888', '13588888888@qq.com', '10', '0', 'B');
INSERT INTO `coupon_base` VALUES ('LREBJ0000019', '0', '1', '小二', '先生', '13588888888', '13588888888@qq.com', '10', '0', 'B');

-- ----------------------------
-- Table structure for `coupon_base_u`
-- ----------------------------
DROP TABLE IF EXISTS `coupon_base_u`;
CREATE TABLE `coupon_base_u` (
  `coupon_id` varchar(255) NOT NULL,
  `user_type` tinyint(2) NOT NULL,
  `city` tinyint(1) NOT NULL,
  `name` varchar(255) NOT NULL,
  `identity_card` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `yy_time` int(11) NOT NULL,
  `state` int(1) NOT NULL,
  `utime` int(11) NOT NULL,
  `hotel_is` tinyint(1) NOT NULL,
  `who_hotel` tinyint(1) NOT NULL,
  PRIMARY KEY (`coupon_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of coupon_base_u
-- ----------------------------
INSERT INTO `coupon_base_u` VALUES ('LREBJ0000000', '1', '1', '小一', '123456789123456789', '先生', '13565855324', '13912345678@qq.com', '1405699200', '1', '1405919815', '1', '1');
INSERT INTO `coupon_base_u` VALUES ('LREBJ0000001', '1', '1', '小一', '123456789123456789', '先生', '13565855324', '13912345678@qq.com', '1405699200', '1', '1405919815', '1', '1');
INSERT INTO `coupon_base_u` VALUES ('LREBJ0000002', '2', '1', '小二', '', '先生', '13325363636', '13325363636@qq.com', '1405612800', '0', '1405672117', '1', '0');
INSERT INTO `coupon_base_u` VALUES ('LREBJ0000003', '2', '1', '小二', '123456789123456789', '先生', '13325363636', '13325363636@qq.com', '1405699200', '1', '1405672117', '1', '1');
INSERT INTO `coupon_base_u` VALUES ('LREGZ0000006', '1', '2', '小四', '123456789123456789', '女士', '13522222222', '13522222222@qq.com', '1436803200', '1', '1405926251', '0', '1');
INSERT INTO `coupon_base_u` VALUES ('LREGZ0000007', '1', '2', '小四', '123456789123456789', '先生', '13522222222', '13522222222@qq.com', '1436803200', '1', '1405926251', '0', '1');

-- ----------------------------
-- Table structure for `hotel_info`
-- ----------------------------
DROP TABLE IF EXISTS `hotel_info`;
CREATE TABLE `hotel_info` (
  `hotel_key` varchar(255) NOT NULL,
  `hotel_id` varchar(255) NOT NULL,
  `reserve_code` varchar(255) NOT NULL,
  `check_in_time` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  `state` tinyint(2) NOT NULL,
  `utime` int(11) NOT NULL,
  PRIMARY KEY (`hotel_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hotel_info
-- ----------------------------
INSERT INTO `hotel_info` VALUES ('LREBJ0000001-LREBJ0000000', '酒店名称', '', '1406736000', '1', '1', '1406022070');
INSERT INTO `hotel_info` VALUES ('LREBJ0000003-LREBJ0000002', '2', '', '1405958400', '1', '3', '1405672103');
INSERT INTO `hotel_info` VALUES ('LRECD0000009-LRECD0000008', '2', '', '1405267200', '4', '3', '1405314990');
INSERT INTO `hotel_info` VALUES ('LRECD0000011-LRECD0000010', '3', '', '1405267200', '4', '2', '1405316053');
INSERT INTO `hotel_info` VALUES ('LREGZ0000005-LREGZ0000004', '0', '', '0', '2', '0', '0');
INSERT INTO `hotel_info` VALUES ('LREGZ0000007-LREGZ0000006', '0', '', '0', '2', '0', '0');

-- ----------------------------
-- Table structure for `landrover_user`
-- ----------------------------
DROP TABLE IF EXISTS `landrover_user`;
CREATE TABLE `landrover_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(255) NOT NULL,
  `psd` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `city` tinyint(1) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` tinyint(2) NOT NULL,
  `psd_s` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0为未修改',
  `state` tinyint(1) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of landrover_user
-- ----------------------------
INSERT INTO `landrover_user` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin_name', '4', '', '924670@qq.com', '-1', '1', '0');
INSERT INTO `landrover_user` VALUES ('19', 'bj_ty', 'aec60231d83fe6cf81444bc536596887', 'bj_ty', '1', '13011112222', 'bj_t@qq.com', '2', '1', '0');
INSERT INTO `landrover_user` VALUES ('23', 'bj_jd', 'e10adc3949ba59abbe56e057f20f883e', 'bj_jd', '1', '22222', 'bj_jd@qq.com', '3', '1', '0');
INSERT INTO `landrover_user` VALUES ('22', 'cd_ty', 'e10adc3949ba59abbe56e057f20f883e', 'cd_ty', '4', '12312312312', 'cd_ty@qq.com', '2', '1', '0');
INSERT INTO `landrover_user` VALUES ('24', 'gz_jd', 'e10adc3949ba59abbe56e057f20f883e', 'gz_jd', '2', '12312312312', 'gz_jd@qq.com', '3', '1', '0');
INSERT INTO `landrover_user` VALUES ('25', 'hz_jd', 'e10adc3949ba59abbe56e057f20f883e', 'hz_jd', '3', '123445', 'hz_jd@qq.com', '3', '0', '0');
INSERT INTO `landrover_user` VALUES ('26', 'cd_jd', 'e10adc3949ba59abbe56e057f20f883e', 'cd_jd', '4', '12312312312', 'cd_jd', '3', '0', '0');
INSERT INTO `landrover_user` VALUES ('21', 'hz_ty', 'e10adc3949ba59abbe56e057f20f883e', 'hz_ty', '3', '123445', 'hz_ty@qq.com', '2', '0', '0');
INSERT INTO `landrover_user` VALUES ('20', 'gz_ty', 'e10adc3949ba59abbe56e057f20f883e', 'gz_ty', '2', '12312312312', 'gz_ty@qq.com', '2', '1', '0');
