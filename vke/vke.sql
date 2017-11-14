/*
 Navicat Premium Data Transfer

 Source Server         : 洞悉信息
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : vke

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 07/11/2017 10:28:17
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for vke_acer_notes
-- ----------------------------
DROP TABLE IF EXISTS `vke_acer_notes`;
CREATE TABLE `vke_acer_notes`  (
  `note_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '元宝交易明细',
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '会员id',
  `type` int(1) NOT NULL COMMENT '1收入 2支出',
  `number` int(5) NOT NULL DEFAULT 0 COMMENT '交易数量',
  `before` int(5) NOT NULL DEFAULT 0 COMMENT '交易前元宝数量',
  `after` int(5) NOT NULL DEFAULT 0 COMMENT '交易后元宝数量',
  `class` int(1) NOT NULL COMMENT '交易类型  1粉丝福利商品获得  2每日签到获得 3兑换积分商品支出',
  `add_time` datetime NOT NULL COMMENT '交易时间',
  `msg` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '交易信息',
  PRIMARY KEY (`note_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vke_acer_notes
-- ----------------------------
INSERT INTO `vke_acer_notes` VALUES (4, 1, 1, 0, 0, 0, 2, '2017-11-01 17:34:21', '签到奖励元宝');
INSERT INTO `vke_acer_notes` VALUES (3, 1, 1, 0, 0, 0, 2, '2017-11-01 17:34:19', '签到奖励元宝');
INSERT INTO `vke_acer_notes` VALUES (5, 1, 1, 100, 100, 200, 2, '2017-11-03 17:48:23', '签到奖励元宝');
INSERT INTO `vke_acer_notes` VALUES (6, 1, 1, 110, 200, 310, 2, '2017-11-03 17:53:41', '签到奖励元宝');
INSERT INTO `vke_acer_notes` VALUES (7, 1, 1, 120, 310, 430, 2, '2017-11-03 17:55:17', '签到奖励元宝');
INSERT INTO `vke_acer_notes` VALUES (8, 1, 1, 120, 430, 550, 2, '2017-11-03 17:55:57', '签到奖励元宝');
INSERT INTO `vke_acer_notes` VALUES (9, 1, 1, 100, 550, 650, 2, '2017-11-06 09:17:10', '签到奖励元宝');

-- ----------------------------
-- Table structure for vke_acer_reward
-- ----------------------------
DROP TABLE IF EXISTS `vke_acer_reward`;
CREATE TABLE `vke_acer_reward`  (
  `id` int(11) NOT NULL COMMENT '奖励设置',
  `type` int(1) DEFAULT NULL COMMENT '1添加订单默认赠送元宝 2晒单默认赠送的元宝数',
  `acer_number` int(5) DEFAULT NULL COMMENT '赠送数量',
  `status` int(1) DEFAULT NULL COMMENT '状态 1启用 2禁用 ',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of vke_acer_reward
-- ----------------------------
INSERT INTO `vke_acer_reward` VALUES (0, 1, 100, 1);
INSERT INTO `vke_acer_reward` VALUES (2, 2, 50, 1);

-- ----------------------------
-- Table structure for vke_address
-- ----------------------------
DROP TABLE IF EXISTS `vke_address`;
CREATE TABLE `vke_address`  (
  `address_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '收货地址ID',
  `member_id` int(11) DEFAULT NULL COMMENT '用户id',
  `province` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '省',
  `country` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '市',
  `district` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '区',
  `address` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '详细地址',
  `person_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '收货人地址',
  `telephone` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '联系方式',
  `is_default` int(1) NOT NULL DEFAULT 1 COMMENT '是否为默认 1默认 2不默认',
  `create_time` datetime DEFAULT NULL COMMENT '添加时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`address_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vke_address
-- ----------------------------
INSERT INTO `vke_address` VALUES (8, 1, '江苏省', '南京市', '不知道', '不知道', '李四', '18888888888', 2, '2017-11-06 15:59:52', '2017-11-06 16:15:15');

-- ----------------------------
-- Table structure for vke_banner
-- ----------------------------
DROP TABLE IF EXISTS `vke_banner`;
CREATE TABLE `vke_banner`  (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'banner图ID',
  `type_id` int(2) NOT NULL DEFAULT 0 COMMENT 'banner分类ID',
  `banner_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'banner图名称',
  `banner_image` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片路径',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '状态是否启用 1启用 2禁用',
  `banner_url` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片跳转路径',
  `add_time` datetime NOT NULL COMMENT '添加/修改时间',
  `sorts` int(3) NOT NULL DEFAULT 1 COMMENT '图片排序',
  PRIMARY KEY (`banner_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vke_banner
-- ----------------------------
INSERT INTO `vke_banner` VALUES (1, 1, '百度图片1', 'http://g.hiphotos.baidu.com/image/h%3D300/sign=d8e1f29cd9160', 1, '', '0000-00-00 00:00:00', 1);
INSERT INTO `vke_banner` VALUES (2, 2, '百度图片2', 'http://f.hiphotos.baidu.com/image/h%3D300/sign=02d09a3970310', 1, '', '0000-00-00 00:00:00', 1);
INSERT INTO `vke_banner` VALUES (3, 3, '百度图片2', 'http://f.hiphotos.baidu.com/image/h%3D300/sign=02d09a3970310', 1, '', '0000-00-00 00:00:00', 1);
INSERT INTO `vke_banner` VALUES (4, 4, '百度图片2', 'http://f.hiphotos.baidu.com/image/h%3D300/sign=02d09a3970310', 1, '', '0000-00-00 00:00:00', 1);
INSERT INTO `vke_banner` VALUES (5, 5, '百度图片2', 'http://f.hiphotos.baidu.com/image/h%3D300/sign=02d09a3970310', 1, '', '0000-00-00 00:00:00', 1);
INSERT INTO `vke_banner` VALUES (6, 6, '百度图片2', 'http://f.hiphotos.baidu.com/image/h%3D300/sign=02d09a3970310', 1, '', '0000-00-00 00:00:00', 1);
INSERT INTO `vke_banner` VALUES (7, 7, '百度图片2', 'http://f.hiphotos.baidu.com/image/h%3D300/sign=02d09a3970310', 1, '', '0000-00-00 00:00:00', 1);
INSERT INTO `vke_banner` VALUES (8, 8, '百度图片2', 'http://f.hiphotos.baidu.com/image/h%3D300/sign=02d09a3970310', 1, '', '0000-00-00 00:00:00', 1);

-- ----------------------------
-- Table structure for vke_banner_type
-- ----------------------------
DROP TABLE IF EXISTS `vke_banner_type`;
CREATE TABLE `vke_banner_type`  (
  `type_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'banner分类id',
  `type_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '状态是否启用 1启用 2禁用',
  `sorts` int(2) NOT NULL DEFAULT 1 COMMENT '排序',
  PRIMARY KEY (`type_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vke_banner_type
-- ----------------------------
INSERT INTO `vke_banner_type` VALUES (1, '首页banner', 1, 1);
INSERT INTO `vke_banner_type` VALUES (2, '粉丝福利banner', 1, 1);
INSERT INTO `vke_banner_type` VALUES (3, '超值线报banner', 1, 1);
INSERT INTO `vke_banner_type` VALUES (4, '应季必备banner', 1, 1);
INSERT INTO `vke_banner_type` VALUES (6, '9.9元专区banner', 1, 1);
INSERT INTO `vke_banner_type` VALUES (7, '19.9专区banner', 1, 1);
INSERT INTO `vke_banner_type` VALUES (5, '应季必备(超实惠)banner', 1, 1);
INSERT INTO `vke_banner_type` VALUES (8, '聚折扣banner', 1, 1);

-- ----------------------------
-- Table structure for vke_cate_type
-- ----------------------------
DROP TABLE IF EXISTS `vke_cate_type`;
CREATE TABLE `vke_cate_type`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT ' 分类id',
  `cate_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '分类id(通过淘宝客借口调取更新)',
  `cate_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `image_url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '分类图片',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '状态 1启用 2禁用',
  `sorts` int(2) NOT NULL DEFAULT 1 COMMENT '排序',
  `edit_time` datetime NOT NULL COMMENT '添加/修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vke_cate_type
-- ----------------------------
INSERT INTO `vke_cate_type` VALUES (1, '11', '热门', '', 1, 1, '2017-10-30 13:35:40');
INSERT INTO `vke_cate_type` VALUES (2, '22', '家居', '', 1, 2, '2017-10-30 13:36:34');
INSERT INTO `vke_cate_type` VALUES (3, '33', '服饰', '', 1, 3, '2017-10-30 13:41:41');
INSERT INTO `vke_cate_type` VALUES (4, '44', '文体办公', '', 1, 4, '2017-10-30 13:41:56');
INSERT INTO `vke_cate_type` VALUES (5, '55', '数码家电', '', 1, 5, '2017-10-30 13:42:11');
INSERT INTO `vke_cate_type` VALUES (6, '66', '美妆', '', 1, 6, '2017-10-30 13:42:21');
INSERT INTO `vke_cate_type` VALUES (7, '77', '母婴', '', 1, 7, '2017-10-30 13:42:29');
INSERT INTO `vke_cate_type` VALUES (8, '88', '运动户外', '', 1, 8, '2017-10-30 13:42:42');
INSERT INTO `vke_cate_type` VALUES (9, '99', '美食', '', 1, 9, '2017-10-30 13:42:51');
INSERT INTO `vke_cate_type` VALUES (10, '1010', '车品周边', '', 1, 10, '2017-10-30 13:43:03');

-- ----------------------------
-- Table structure for vke_exchange_order
-- ----------------------------
DROP TABLE IF EXISTS `vke_exchange_order`;
CREATE TABLE `vke_exchange_order`  (
  `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '兑换记录表',
  `order_num` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '订单号',
  `product_type` int(1) NOT NULL DEFAULT 1 COMMENT '积分商品分类 1虚拟类 2实物类',
  `member_id` int(5) NOT NULL DEFAULT 0 COMMENT '会员id',
  `product_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '积分商品id',
  `address_id` int(6) NOT NULL DEFAULT 0 COMMENT '收货地址id',
  `exchange_num` int(3) NOT NULL DEFAULT 0 COMMENT '兑换数量',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '支付状态 1未支付 2已支付',
  `express_status` int(1) NOT NULL COMMENT '发货状态 1未发货 2待收货 3已收货 4申请退货 5拒绝退货 6同意退货（退货中） 7已退货',
  `exchange_time` datetime NOT NULL COMMENT '兑换时间',
  `one_acer` int(5) NOT NULL DEFAULT 0 COMMENT '商品单价(元宝)',
  `total_acer` int(6) NOT NULL DEFAULT 0 COMMENT '订单总价(元宝)',
  `is_able` int(1) NOT NULL DEFAULT 1 COMMENT '是否有效 1有效的订单 2失效的订单',
  `update_time` datetime DEFAULT NULL,
  `telephone` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '手机号码',
  `alipay` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '支付宝账号',
  PRIMARY KEY (`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vke_exchange_order
-- ----------------------------
INSERT INTO `vke_exchange_order` VALUES (11, '2017110352575550', 1, 1, '1', 0, 1, 2, 1, '2017-11-03 10:25:40', 100, 100, 1, '2017-11-03 10:25:40', '', '');
INSERT INTO `vke_exchange_order` VALUES (12, '2017110657501009', 1, 1, '1', 0, 1, 2, 1, '2017-11-06 10:08:25', 100, 100, 1, '2017-11-06 10:08:25', '', '');

-- ----------------------------
-- Table structure for vke_feedback
-- ----------------------------
DROP TABLE IF EXISTS `vke_feedback`;
CREATE TABLE `vke_feedback`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '反馈信息id',
  `member_id` int(11) DEFAULT NULL COMMENT '反馈者id',
  `num_iid` int(11) DEFAULT NULL COMMENT '商品在阿里妈妈的id',
  `msg` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '反馈内容',
  `telephone` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '反馈者联系方式',
  `create_time` datetime DEFAULT NULL COMMENT '反馈提交时间',
  `update_time` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '状态 1未读 2已读',
  `read_time` datetime DEFAULT NULL COMMENT '查看时间',
  `handle_msg` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '处理意见',
  `admin_id` int(11) DEFAULT NULL COMMENT '处理者id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vke_feedback
-- ----------------------------
INSERT INTO `vke_feedback` VALUES (1, 1, NULL, '1111', '15846624454', '2017-11-03 15:55:19', '2017-11-03 15:55:19', 1, NULL, '', NULL);
INSERT INTO `vke_feedback` VALUES (2, 1, NULL, '1111', '15846624454', '2017-11-03 15:55:33', '2017-11-03 15:55:33', 1, NULL, '', NULL);

-- ----------------------------
-- Table structure for vke_help
-- ----------------------------
DROP TABLE IF EXISTS `vke_help`;
CREATE TABLE `vke_help`  (
  `help_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '帮助表',
  `type` int(1) NOT NULL DEFAULT 1 COMMENT '帮助分类 1搜索页帮助 2添加订单页帮助',
  `image_url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片路径',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '帮助内容',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '状态 1启用 2禁用',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  `sorts` int(3) NOT NULL DEFAULT 1 COMMENT '排序',
  PRIMARY KEY (`help_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vke_help
-- ----------------------------
INSERT INTO `vke_help` VALUES (1, 2, 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aH', '', 1, '0000-00-00 00:00:00', 1);

-- ----------------------------
-- Table structure for vke_member
-- ----------------------------
DROP TABLE IF EXISTS `vke_member`;
CREATE TABLE `vke_member`  (
  `member_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员id',
  `member_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '会员昵称',
  `telephone` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '会员手机号',
  `sex` int(1) NOT NULL DEFAULT 1 COMMENT '性别 1男 2女',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '会员的登录密码',
  `head_image` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '会员头像',
  `member_acer` int(6) NOT NULL DEFAULT 0 COMMENT '会员元宝数量',
  `last_login_time` datetime NOT NULL COMMENT '会员最后一次登录时间',
  `last_login_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '会员最后一次登录IP',
  `alipay` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '支付宝账户',
  `is_del` int(1) NOT NULL DEFAULT 2 COMMENT '是否删除 1已删除 2未删除',
  `free_money` decimal(8, 2) NOT NULL DEFAULT 0.00 COMMENT '已免单金额',
  `is_first_login` int(1) NOT NULL DEFAULT 1 COMMENT '是否为首次登录',
  `wechat_openid` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '微信openid',
  `wechat_nickname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '微信昵称',
  `wechat_sex` int(1) NOT NULL DEFAULT 1 COMMENT '微信性别 1男 2女',
  `wechat_province` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '微信地址 : 省',
  `wechat_city` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '微信地址 : 市',
  `wechat_country` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '微信地址 : 区',
  `wechat_head_image` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '微信头像',
  `wechat_unionid` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'unionId',
  PRIMARY KEY (`member_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vke_member
-- ----------------------------
INSERT INTO `vke_member` VALUES (1, '刘祺', '15846624454', 1, '123456', 'https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=47', 550, '0000-00-00 00:00:00', '', '', 2, 100.00, 2, '', '', 1, '', '', '', '', '');

-- ----------------------------
-- Table structure for vke_member_evaluate
-- ----------------------------
DROP TABLE IF EXISTS `vke_member_evaluate`;
CREATE TABLE `vke_member_evaluate`  (
  `evaluate_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员晒单评价表',
  `order_num` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '评价的订单号',
  `member_id` int(5) NOT NULL DEFAULT 0 COMMENT '会员id',
  `evaluate_url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片路径',
  `evaluate_detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '评论详情',
  `create_time` datetime NOT NULL COMMENT '评论时间',
  `examine_status` int(1) NOT NULL DEFAULT 2 COMMENT '评论审核状态 1审核通过 2未审核 3审核拒绝',
  `update_time` datetime DEFAULT NULL COMMENT '审核时间',
  `acer_num` int(3) NOT NULL DEFAULT 0 COMMENT '评论奖励元宝数量',
  `is_del` int(1) NOT NULL DEFAULT 2 COMMENT '是否删除 1已删除 2未删除',
  PRIMARY KEY (`evaluate_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vke_member_evaluate
-- ----------------------------
INSERT INTO `vke_member_evaluate` VALUES (3, '1', 1, '', '132', '2017-11-06 16:52:23', 2, '2017-11-06 16:52:23', 0, 2);
INSERT INTO `vke_member_evaluate` VALUES (4, '1', 1, '', '132', '2017-11-06 16:58:54', 2, '2017-11-06 16:58:54', 0, 2);

-- ----------------------------
-- Table structure for vke_member_footprint
-- ----------------------------
DROP TABLE IF EXISTS `vke_member_footprint`;
CREATE TABLE `vke_member_footprint`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '浏览足迹id',
  `member_id` int(5) NOT NULL DEFAULT 0 COMMENT '会员浏览的商品id',
  `product_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '会员产品id',
  `time` datetime NOT NULL COMMENT '浏览时间',
  `number` int(3) NOT NULL DEFAULT 0 COMMENT '商品浏览次数',
  `is_del` int(1) NOT NULL DEFAULT 2 COMMENT '是否删除 1已删除 2未删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vke_member_footprint
-- ----------------------------
INSERT INTO `vke_member_footprint` VALUES (1, 1, '1', '2017-11-06 09:56:11', 6, 2);
INSERT INTO `vke_member_footprint` VALUES (2, 1, '2', '2017-11-05 09:56:11', 5, 2);

-- ----------------------------
-- Table structure for vke_member_reveive
-- ----------------------------
DROP TABLE IF EXISTS `vke_member_reveive`;
CREATE TABLE `vke_member_reveive`  (
  `receive_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '收货管理表',
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '会员id',
  `order_num` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '订单号',
  `address_id` int(5) NOT NULL DEFAULT 0 COMMENT '会员的地址id',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '收货状态  1未发货 2待收货 3已收货 4申请退货 5拒绝退货 6同意退货(退货中) 7已退货',
  `delivery_time` datetime DEFAULT NULL COMMENT '发货时间',
  `receive_time` datetime DEFAULT NULL COMMENT '收货时间',
  `return_time` datetime DEFAULT NULL COMMENT '退货时间',
  `replay_return_time` datetime DEFAULT NULL COMMENT '申请退货时间',
  PRIMARY KEY (`receive_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for vke_member_sign
-- ----------------------------
DROP TABLE IF EXISTS `vke_member_sign`;
CREATE TABLE `vke_member_sign`  (
  `sign_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '签到ID',
  `member_id` int(5) NOT NULL DEFAULT 0 COMMENT '签到会员ID',
  `sign_days` int(4) NOT NULL DEFAULT 0 COMMENT '签到总天数',
  `sign_acer` int(5) NOT NULL DEFAULT 0 COMMENT '签到获得的元宝数',
  `continue_days` int(3) NOT NULL DEFAULT 0 COMMENT '已连续签到天数',
  `sign_time` datetime NOT NULL COMMENT '最近签到时间',
  PRIMARY KEY (`sign_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of vke_member_sign
-- ----------------------------
INSERT INTO `vke_member_sign` VALUES (6, 1, 1, 10, 1, '2017-11-01 17:32:06');

-- ----------------------------
-- Table structure for vke_message
-- ----------------------------
DROP TABLE IF EXISTS `vke_message`;
CREATE TABLE `vke_message`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL COMMENT '用户ID',
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '标题',
  `msg` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '信息详情',
  `status` tinyint(1) DEFAULT 1 COMMENT '状态(1-未读、2-已读)',
  `is_del` tinyint(1) DEFAULT 1 COMMENT '用户是否删除 1-未删除 2-已删除',
  `add_time` datetime DEFAULT NULL COMMENT '添加时间',
  `del_time` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of vke_message
-- ----------------------------
INSERT INTO `vke_message` VALUES (1, 1, '系统消息', '通知通知通知', 1, 1, '2017-11-03 15:10:43', NULL);

-- ----------------------------
-- Table structure for vke_order
-- ----------------------------
DROP TABLE IF EXISTS `vke_order`;
CREATE TABLE `vke_order`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单表',
  `order_num` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '订单号',
  `member_id` int(11) DEFAULT NULL COMMENT '会员id',
  `num_iid` int(11) DEFAULT NULL COMMENT '商品在阿里妈妈的id',
  `create_time` datetime DEFAULT NULL COMMENT '添加时间',
  `back_acer` int(5) NOT NULL DEFAULT 0 COMMENT '返利的元宝数',
  `back_status` int(1) NOT NULL DEFAULT 2 COMMENT '返利状态 1已返 2未返 ',
  `update_time` datetime DEFAULT NULL COMMENT '返利时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vke_order
-- ----------------------------
INSERT INTO `vke_order` VALUES (1, '123456', 1, 1, '2017-11-06 17:13:36', 0, 2, '0000-00-00 00:00:00');
INSERT INTO `vke_order` VALUES (4, '111', 1, 1, '2017-11-06 18:00:59', 0, 2, '2017-11-06 18:00:59');
INSERT INTO `vke_order` VALUES (3, '11', 1, 1, '2017-11-06 17:59:05', 0, 2, '2017-11-06 17:59:05');

-- ----------------------------
-- Table structure for vke_order_error
-- ----------------------------
DROP TABLE IF EXISTS `vke_order_error`;
CREATE TABLE `vke_order_error`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户兑换失败记录表',
  `member_id` int(5) NOT NULL DEFAULT 0 COMMENT '会员id',
  `order_num` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '失效的订单号',
  `msg` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '失效的原因',
  `add_time` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for vke_panic_time
-- ----------------------------
DROP TABLE IF EXISTS `vke_panic_time`;
CREATE TABLE `vke_panic_time`  (
  `panic_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '抢购时间表',
  `start_time` time DEFAULT NULL COMMENT '抢购开始时间',
  `end_time` time DEFAULT NULL COMMENT '抢购结束时间',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '状态 1启用 2禁用',
  PRIMARY KEY (`panic_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of vke_panic_time
-- ----------------------------
INSERT INTO `vke_panic_time` VALUES (1, '10:28:19', '15:28:23', 1);
INSERT INTO `vke_panic_time` VALUES (2, '16:28:43', '17:28:51', 1);
INSERT INTO `vke_panic_time` VALUES (3, '18:43:22', '19:43:29', 1);
INSERT INTO `vke_panic_time` VALUES (4, '20:43:46', '21:43:51', 1);

-- ----------------------------
-- Table structure for vke_product
-- ----------------------------
DROP TABLE IF EXISTS `vke_product`;
CREATE TABLE `vke_product`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `store_type` int(11) NOT NULL DEFAULT 1 COMMENT '商品分类(store_type表中的id)',
  `fans_acer` int(5) NOT NULL DEFAULT 0 COMMENT '如果该商品为粉丝福利商品,此字段为回馈粉丝的元宝数量',
  `product_type` int(11) NOT NULL DEFAULT 1 COMMENT '属性分类(cate_type中的id)',
  `num_iid` int(11) NOT NULL DEFAULT 0 COMMENT '阿里妈妈商品id',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品标题',
  `pict_url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品主图',
  `small_images` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品小图',
  `reserve_price` decimal(6, 2) NOT NULL DEFAULT 0.00 COMMENT '商品一口价',
  `zk_final_price` decimal(6, 2) NOT NULL DEFAULT 0.00 COMMENT '商品折扣价格',
  `user_type` int(1) DEFAULT NULL COMMENT '卖家类型 0表示集市 1表示商城',
  `provcity` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '宝贝所在地',
  `item_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商家地址',
  `nick` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '卖家昵称',
  `seller_id` int(11) DEFAULT NULL COMMENT '卖家id',
  `volume` int(5) NOT NULL DEFAULT 0 COMMENT '30天销量',
  `cat_leaf_name` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '子分类',
  `cat_name` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '分类',
  `on_sale` int(1) NOT NULL DEFAULT 1 COMMENT '上下架 1 上架  2下架',
  `add_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vke_product
-- ----------------------------
INSERT INTO `vke_product` VALUES (1, 1, 0, 1, 1, '帽衫', 'http://h.hiphotos.baidu.com/image/h%3D300/sign=c8661cac7cc6a7efa626ae26cdfbafe9/f9dcd100baa1cd115dfc', 'http://h.hiphotos.baidu.com/image/h%3D300/sign=c8661cac7cc6a7efa626ae26cdfbafe9/f9dcd100baa1cd115dfc', 100.00, 50.00, 1, '杭州', 'www.baidu.com', '小小', 12, 100, '11', '1', 1, NULL);
INSERT INTO `vke_product` VALUES (2, 2, 0, 1, 2, '帽衫', 'http://h.hiphotos.baidu.com/image/h%3D300/sign=c8661cac7cc6a7efa626ae26cdfbafe9/f9dcd100baa1cd115dfc', 'http://h.hiphotos.baidu.com/image/h%3D300/sign=c8661cac7cc6a7efa626ae26cdfbafe9/f9dcd100baa1cd115dfc', 100.00, 50.00, 1, '杭州', 'www.baidu.com', '小小', 12, 100, '11', '1', 1, NULL);
INSERT INTO `vke_product` VALUES (3, 3, 0, 1, 3, '帽衫', 'http://h.hiphotos.baidu.com/image/h%3D300/sign=c8661cac7cc6a7efa626ae26cdfbafe9/f9dcd100baa1cd115dfc', 'http://h.hiphotos.baidu.com/image/h%3D300/sign=c8661cac7cc6a7efa626ae26cdfbafe9/f9dcd100baa1cd115dfc', 100.00, 50.00, 1, '杭州', 'www.baidu.com', '小小', 12, 100, '11', '1', 1, NULL);
INSERT INTO `vke_product` VALUES (4, 4, 0, 1, 4, '帽衫', 'http://h.hiphotos.baidu.com/image/h%3D300/sign=c8661cac7cc6a7efa626ae26cdfbafe9/f9dcd100baa1cd115dfc', 'http://h.hiphotos.baidu.com/image/h%3D300/sign=c8661cac7cc6a7efa626ae26cdfbafe9/f9dcd100baa1cd115dfc', 100.00, 50.00, 1, '杭州', 'www.baidu.com', '小小', 12, 100, '11', '1', 1, NULL);
INSERT INTO `vke_product` VALUES (5, 5, 0, 1, 5, '帽衫', 'http://h.hiphotos.baidu.com/image/h%3D300/sign=c8661cac7cc6a7efa626ae26cdfbafe9/f9dcd100baa1cd115dfc', 'http://h.hiphotos.baidu.com/image/h%3D300/sign=c8661cac7cc6a7efa626ae26cdfbafe9/f9dcd100baa1cd115dfc', 100.00, 50.00, 1, '杭州', 'www.baidu.com', '小小', 12, 100, '11', '1', 1, NULL);
INSERT INTO `vke_product` VALUES (6, 6, 0, 1, 6, '帽衫', 'http://h.hiphotos.baidu.com/image/h%3D300/sign=c8661cac7cc6a7efa626ae26cdfbafe9/f9dcd100baa1cd115dfc', 'http://h.hiphotos.baidu.com/image/h%3D300/sign=c8661cac7cc6a7efa626ae26cdfbafe9/f9dcd100baa1cd115dfc', 100.00, 50.00, 1, '杭州', 'www.baidu.com', '小小', 12, 100, '11', '1', 1, NULL);
INSERT INTO `vke_product` VALUES (7, 7, 0, 1, 7, '帽衫', 'http://h.hiphotos.baidu.com/image/h%3D300/sign=c8661cac7cc6a7efa626ae26cdfbafe9/f9dcd100baa1cd115dfc', 'http://h.hiphotos.baidu.com/image/h%3D300/sign=c8661cac7cc6a7efa626ae26cdfbafe9/f9dcd100baa1cd115dfc', 100.00, 50.00, 1, '杭州', 'www.baidu.com', '小小', 12, 100, '11', '1', 1, NULL);
INSERT INTO `vke_product` VALUES (8, 4, 0, 1, 8, '帽衫', 'http://h.hiphotos.baidu.com/image/h%3D300/sign=c8661cac7cc6a7efa626ae26cdfbafe9/f9dcd100baa1cd115dfc', 'http://h.hiphotos.baidu.com/image/h%3D300/sign=c8661cac7cc6a7efa626ae26cdfbafe9/f9dcd100baa1cd115dfc', 100.00, 50.00, 1, '杭州', 'www.baidu.com', '小小', 12, 50, '11', '1', 1, NULL);

-- ----------------------------
-- Table structure for vke_product_acer
-- ----------------------------
DROP TABLE IF EXISTS `vke_product_acer`;
CREATE TABLE `vke_product_acer`  (
  `product_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '元宝商品表',
  `product_type` int(1) NOT NULL DEFAULT 1 COMMENT '积分商品分类 1虚拟类 2实物类',
  `product_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品名称',
  `product_image` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品图片',
  `title` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `exchange_brief` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '兑换说明',
  `market_price` decimal(5, 2) NOT NULL DEFAULT 0.00 COMMENT '商品市场价',
  `exchange_acer` int(5) NOT NULL DEFAULT 0 COMMENT '需要的元宝数量',
  `stock` int(4) NOT NULL COMMENT '商品库存',
  `brief` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品简介',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品详情',
  `is_sale` int(1) NOT NULL DEFAULT 1 COMMENT '是否上架 1上架 2未上架',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  `sorts` int(4) NOT NULL DEFAULT 1 COMMENT '排序',
  `exchange_num` int(4) NOT NULL DEFAULT 0 COMMENT '兑换次数(销量)',
  PRIMARY KEY (`product_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vke_product_acer
-- ----------------------------
INSERT INTO `vke_product_acer` VALUES (1, 1, '10元话费充值卡', 'https://ss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=1602552054,373587514&fm=27&gp=0.jpg', '十元话费充值卡', '', 10.00, 100, 991, '快速到账', '省时', 1, '2017-11-03 09:58:47', 1, 0);

-- ----------------------------
-- Table structure for vke_sign_acer
-- ----------------------------
DROP TABLE IF EXISTS `vke_sign_acer`;
CREATE TABLE `vke_sign_acer`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员每次签到奖励',
  `reward_acer` int(3) NOT NULL DEFAULT 0 COMMENT '奖励元宝个数',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of vke_sign_acer
-- ----------------------------
INSERT INTO `vke_sign_acer` VALUES (1, 100);

-- ----------------------------
-- Table structure for vke_sign_notes
-- ----------------------------
DROP TABLE IF EXISTS `vke_sign_notes`;
CREATE TABLE `vke_sign_notes`  (
  `note_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '签到记录表',
  `member_id` int(5) NOT NULL DEFAULT 0 COMMENT '签到会员ID',
  `sign_time` datetime NOT NULL COMMENT '签到时间',
  `sign_acer` int(3) NOT NULL DEFAULT 0 COMMENT '签到所获元宝',
  `continue_days` int(4) NOT NULL COMMENT '连续签到天数',
  PRIMARY KEY (`note_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 20 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of vke_sign_notes
-- ----------------------------
INSERT INTO `vke_sign_notes` VALUES (2, 1, '2017-11-02 16:42:14', 100, 2);
INSERT INTO `vke_sign_notes` VALUES (1, 1, '2017-11-01 16:42:13', 100, 1);
INSERT INTO `vke_sign_notes` VALUES (19, 1, '2017-11-06 09:17:10', 100, 1);
INSERT INTO `vke_sign_notes` VALUES (18, 1, '2017-11-03 17:55:56', 120, 3);

-- ----------------------------
-- Table structure for vke_sign_reward
-- ----------------------------
DROP TABLE IF EXISTS `vke_sign_reward`;
CREATE TABLE `vke_sign_reward`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '连续签到奖励表',
  `sign_days` int(11) DEFAULT NULL COMMENT '连续签到天数',
  `reward_num` int(11) DEFAULT NULL COMMENT '奖励元宝数量',
  `status` int(1) DEFAULT 1 COMMENT '状态 1启用 2不启用',
  `add_time` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of vke_sign_reward
-- ----------------------------
INSERT INTO `vke_sign_reward` VALUES (1, 2, 10, 1, '2017-11-03 16:47:03');
INSERT INTO `vke_sign_reward` VALUES (2, 3, 20, 1, '2017-11-03 16:47:12');
INSERT INTO `vke_sign_reward` VALUES (3, 4, 30, 1, '2017-11-03 16:47:19');
INSERT INTO `vke_sign_reward` VALUES (4, 5, 40, 1, '2017-11-03 16:47:34');
INSERT INTO `vke_sign_reward` VALUES (5, 6, 50, 1, '2017-11-03 16:47:41');
INSERT INTO `vke_sign_reward` VALUES (6, 7, 60, 1, '2017-11-03 16:47:51');

-- ----------------------------
-- Table structure for vke_store_type
-- ----------------------------
DROP TABLE IF EXISTS `vke_store_type`;
CREATE TABLE `vke_store_type`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商店分类',
  `store_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商店名称',
  `image` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '按钮图片',
  `number` int(4) DEFAULT NULL COMMENT '折扣数,或者价格(使用于聚折扣和低价专区)',
  `sorts` int(3) NOT NULL DEFAULT 1 COMMENT '排序',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '状态 1启用 2禁用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vke_store_type
-- ----------------------------
INSERT INTO `vke_store_type` VALUES (2, '粉丝福利', 'http://f.hiphotos.baidu.com/image/h%3D300/sign=227c03b42c1f95cab9f594b6f9167fc5/72f082025aafa40ffe8d', NULL, 1, 1);
INSERT INTO `vke_store_type` VALUES (3, '超值线报', 'http://d.hiphotos.baidu.com/image/h%3D300/sign=6d9a749fb91c8701c9b6b4e6177e9e6e/0d338744ebf81a4c12e6', NULL, 2, 2);
INSERT INTO `vke_store_type` VALUES (4, '9.9专区', 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAAQABAAD/2wBDAAMCAgMCAgMDAwMEAwMEBQgFBQQEBQoHBwYIDAoMDAsKC', NULL, 3, 1);
INSERT INTO `vke_store_type` VALUES (5, '聚折扣', 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aH', NULL, 4, 1);
INSERT INTO `vke_store_type` VALUES (6, '应季必备', 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aH', NULL, 5, 1);
INSERT INTO `vke_store_type` VALUES (7, '19.9专区', 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aH', NULL, 6, 1);
INSERT INTO `vke_store_type` VALUES (1, '普通商品', 'https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=473753737,684628799&fm=11&gp=0.jpg', NULL, 1, 1);

-- ----------------------------
-- Table structure for vke_test
-- ----------------------------
DROP TABLE IF EXISTS `vke_test`;
CREATE TABLE `vke_test`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '测试采集',
  `test1` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `test2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vke_test
-- ----------------------------
INSERT INTO `vke_test` VALUES (1, '肖申克的救赎', '142 分钟');
INSERT INTO `vke_test` VALUES (2, '肖申克的救赎', '142 分钟');
INSERT INTO `vke_test` VALUES (3, '辛德勒的名单', '195 分钟');
INSERT INTO `vke_test` VALUES (4, '教父', '175 分钟');
INSERT INTO `vke_test` VALUES (5, '黑暗骑士', '152分钟');
INSERT INTO `vke_test` VALUES (6, '危险人物', '154分钟');
INSERT INTO `vke_test` VALUES (7, '好的，坏的和丑的', '161分钟');
INSERT INTO `vke_test` VALUES (8, '指环王：国王的回归', '201 分钟');
INSERT INTO `vke_test` VALUES (9, '指环王：魔戒现身', '178 分钟');
INSERT INTO `vke_test` VALUES (10, '星球大战5-帝国反击', '124 分钟');
INSERT INTO `vke_test` VALUES (11, '八爪鱼与腾讯云达成战略合作', '　　目前大数据流量呈现爆发式增长，大量的用户行为和信息形成的大数据呈现出井喷的态势，而八爪鱼数据作为国内最大的基础数据平台与腾讯云达成战略合作。\n　　近日腾讯云高管约见八爪鱼数据CEO刘宝强先生，鉴于八爪鱼数据在大数据行业所做出的成绩，腾讯云方面表示希望能为八爪鱼数据提供资金支持，并就此事双方经过协商达成共识。\n　　八爪鱼数据CEO刘宝强先生表示，在“互联网+”的指引下，双方的合作之路水到渠成，基于互联网和公有云的IT环境变得越来越普遍，企业IT变得更加复杂，双方的深度合作能帮助用户轻松构建一体化、高安全');

-- ----------------------------
-- View structure for vke_order_product_view
-- ----------------------------
DROP VIEW IF EXISTS `vke_order_product_view`;
CREATE ALGORITHM = UNDEFINED DEFINER = `root`@`localhost` SQL SECURITY DEFINER VIEW `vke_order_product_view` AS select `vke_product_acer`.`product_id` AS `product_id`,`vke_product_acer`.`product_name` AS `product_name`,`vke_product_acer`.`product_type` AS `product_type`,`vke_product_acer`.`product_image` AS `product_image`,`vke_exchange_order`.`status` AS `status`,`vke_exchange_order`.`is_able` AS `is_able`,`vke_exchange_order`.`order_id` AS `order_id` from (`vke_exchange_order` join `vke_product_acer` on((`vke_exchange_order`.`product_id` = `vke_product_acer`.`product_id`)));

SET FOREIGN_KEY_CHECKS = 1;
