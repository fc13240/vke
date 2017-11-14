/*
 Navicat Premium Data Transfer

 Source Server         : 洞悉信息
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : think_auth

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 08/11/2017 09:09:39
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bjyadmin_users
-- ----------------------------
DROP TABLE IF EXISTS `bjyadmin_users`;
CREATE TABLE `bjyadmin_users`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '登录密码；mb_password加密',
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户头像，相对于upload/avatar目录',
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '登录邮箱',
  `email_code` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '激活码',
  `phone` bigint(11) UNSIGNED DEFAULT NULL COMMENT '手机号',
  `status` tinyint(1) NOT NULL DEFAULT 2 COMMENT '用户状态 0：禁用； 1：正常 ；2：未验证',
  `register_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '注册时间',
  `last_login_ip` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `last_login_time` int(10) UNSIGNED NOT NULL COMMENT '最后登录时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_login_key`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 90 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of bjyadmin_users
-- ----------------------------
INSERT INTO `bjyadmin_users` VALUES (88, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '/Upload/avatar/user1.jpg', '', '', NULL, 1, 1449199996, '', 0);
INSERT INTO `bjyadmin_users` VALUES (89, 'admin2', 'e10adc3949ba59abbe56e057f20f883e', '/Upload/avatar/user2.jpg', '', '', NULL, 1, 1449199996, '', 0);

SET FOREIGN_KEY_CHECKS = 1;
