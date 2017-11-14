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

 Date: 08/11/2017 09:09:13
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bjyadmin_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `bjyadmin_auth_rule`;
CREATE TABLE `bjyadmin_auth_rule`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '父级id',
  `name` char(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `title` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态：为1正常，为0禁用',
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `condition` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 126 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '规则表' ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of bjyadmin_auth_rule
-- ----------------------------
INSERT INTO `bjyadmin_auth_rule` VALUES (1, 20, 'Admin/ShowNav/nav', '菜单管理', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (2, 1, 'Admin/Nav/index', '菜单列表', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (3, 1, 'Admin/Nav/add', '添加菜单', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (4, 1, 'Admin/Nav/edit', '修改菜单', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (5, 1, 'Admin/Nav/delete', '删除菜单', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (21, 0, 'Admin/ShowNav/rule', '权限控制', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (7, 21, 'Admin/Rule/index', '权限管理', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (8, 7, 'Admin/Rule/add', '添加权限', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (9, 7, 'Admin/Rule/edit', '修改权限', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (10, 7, 'Admin/Rule/delete', '删除权限', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (11, 21, 'Admin/Rule/group', '用户组管理', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (12, 11, 'Admin/Rule/add_group', '添加用户组', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (13, 11, 'Admin/Rule/edit_group', '修改用户组', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (14, 11, 'Admin/Rule/delete_group', '删除用户组', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (15, 11, 'Admin/Rule/rule_group', '分配权限', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (16, 11, 'Admin/Rule/check_user', '添加成员', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (19, 21, 'Admin/Rule/admin_user_list', '管理员列表', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (20, 0, 'Admin/ShowNav/config', '系统设置', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (6, 0, 'Admin/Index/index', '后台首页', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (64, 1, 'Admin/Nav/order', '菜单排序', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (96, 6, 'Admin/Index/welcome', '欢迎界面', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (104, 0, 'Admin/ShowNav/posts', '文章管理', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (105, 104, 'Admin/Posts/index', '文章列表', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (106, 105, 'Admin/Posts/add_posts', '添加文章', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (107, 105, 'Admin/Posts/edit_posts', '修改文章', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (108, 105, 'Admin/Posts/delete_posts', '删除文章', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (109, 104, 'Admin/Posts/category_list', '分类列表', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (110, 109, 'Admin/Posts/add_category', '添加分类', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (111, 109, 'Admin/Posts/edit_category', '修改分类', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (112, 109, 'Admin/Posts/delete_category', '删除分类', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (117, 109, 'Admin/Posts/order_category', '分类排序', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (118, 105, 'Admin/Posts/order_posts', '文章排序', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (123, 11, 'Admin/Rule/add_user_to_group', '设置为管理员', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (124, 11, 'Admin/Rule/add_admin', '添加管理员', 1, 1, '');
INSERT INTO `bjyadmin_auth_rule` VALUES (125, 11, 'Admin/Rule/edit_admin', '修改管理员', 1, 1, '');

SET FOREIGN_KEY_CHECKS = 1;
