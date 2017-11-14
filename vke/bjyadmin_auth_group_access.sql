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

 Date: 08/11/2017 09:09:05
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bjyadmin_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `bjyadmin_auth_group_access`;
CREATE TABLE `bjyadmin_auth_group_access`  (
  `uid` int(11) UNSIGNED NOT NULL COMMENT '用户id',
  `group_id` int(11) UNSIGNED NOT NULL COMMENT '用户组id',
  UNIQUE INDEX `uid_group_id`(`uid`, `group_id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户组明细表' ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of bjyadmin_auth_group_access
-- ----------------------------
INSERT INTO `bjyadmin_auth_group_access` VALUES (88, 1);
INSERT INTO `bjyadmin_auth_group_access` VALUES (89, 2);
INSERT INTO `bjyadmin_auth_group_access` VALUES (89, 4);

SET FOREIGN_KEY_CHECKS = 1;
