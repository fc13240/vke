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

 Date: 08/11/2017 09:08:59
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bjyadmin_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `bjyadmin_auth_group`;
CREATE TABLE `bjyadmin_auth_group`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `rules` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '规则id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户组表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bjyadmin_auth_group
-- ----------------------------
INSERT INTO `bjyadmin_auth_group` VALUES (1, '超级管理员', 1, '6,96,20,1,2,3,4,5,64,21,7,8,9,10,11,12,13,14,15,16,123,124,125,19,104,105,106,107,108,118,109,110,111,112,117');
INSERT INTO `bjyadmin_auth_group` VALUES (2, '产品管理员', 1, '6,96,1,2,3,4,56,57,60,61,63,71,72,65,67,74,75,66,68,69,70,73,77,78,82,83,88,89,90,99,91,92,97,98,104,105,106,107,108,118,109,110,111,112,117,113,114');
INSERT INTO `bjyadmin_auth_group` VALUES (4, '文章编辑', 1, '6,96,57,60,61,63,71,72,65,67,74,75,66,68,69,73,79,80,78,82,83,88,89,90,99,100,97,98,104,105,106,107,108,118,109,110,111,112,117,113,114');

SET FOREIGN_KEY_CHECKS = 1;
