/*
 Navicat Premium Data Transfer

 Source Server         : 洞悉信息
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : weke

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 02/11/2017 09:27:34
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for weke_acer_notes
-- ----------------------------
DROP TABLE IF EXISTS `weke_acer_notes`;
CREATE TABLE `weke_acer_notes`  (
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
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of weke_acer_notes
-- ----------------------------
INSERT INTO `weke_acer_notes` VALUES (4, 1, 1, 0, 0, 0, 2, '2017-11-01 17:34:21', '签到奖励元宝');
INSERT INTO `weke_acer_notes` VALUES (3, 1, 1, 0, 0, 0, 2, '2017-11-01 17:34:19', '签到奖励元宝');

-- ----------------------------
-- Table structure for weke_address
-- ----------------------------
DROP TABLE IF EXISTS `weke_address`;
CREATE TABLE `weke_address`  (
  `adress_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '收货地址ID',
  `province` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '省',
  `country` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '市',
  `district` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '区',
  `address` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '详细地址',
  `is_default` int(1) NOT NULL DEFAULT 1 COMMENT '是否为默认 1默认 2不默认',
  PRIMARY KEY (`adress_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for weke_banner
-- ----------------------------
DROP TABLE IF EXISTS `weke_banner`;
CREATE TABLE `weke_banner`  (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'banner图ID',
  `type_id` int(2) NOT NULL DEFAULT 0 COMMENT 'banner分类ID',
  `banner_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'banner图名称',
  `banner_image` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片路径',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '状态是否启用 1启用 2禁用',
  `banner_url` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片跳转路径',
  `add_time` datetime NOT NULL COMMENT '添加/修改时间',
  `sorts` int(3) NOT NULL DEFAULT 1 COMMENT '图片排序',
  PRIMARY KEY (`banner_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for weke_banner_type
-- ----------------------------
DROP TABLE IF EXISTS `weke_banner_type`;
CREATE TABLE `weke_banner_type`  (
  `type_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'banner分类id',
  `type_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `status` int(1) NOT NULL COMMENT '状态是否启用 1启用 2禁用',
  `sorts` int(2) NOT NULL COMMENT '排序',
  PRIMARY KEY (`type_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for weke_cate_type
-- ----------------------------
DROP TABLE IF EXISTS `weke_cate_type`;
CREATE TABLE `weke_cate_type`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT ' 分类id',
  `cate_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '分类id(通过淘宝客借口调取更新)',
  `cate_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '状态 1启用 2禁用',
  `sorts` int(2) NOT NULL DEFAULT 1 COMMENT '排序',
  `edit_time` datetime NOT NULL COMMENT '添加/修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of weke_cate_type
-- ----------------------------
INSERT INTO `weke_cate_type` VALUES (1, '', '热门', 1, 1, '2017-10-30 13:35:40');
INSERT INTO `weke_cate_type` VALUES (2, '', '家居', 1, 2, '2017-10-30 13:36:34');
INSERT INTO `weke_cate_type` VALUES (3, '', '服饰', 1, 3, '2017-10-30 13:41:41');
INSERT INTO `weke_cate_type` VALUES (4, '', '文体办公', 1, 4, '2017-10-30 13:41:56');
INSERT INTO `weke_cate_type` VALUES (5, '', '数码家电', 1, 5, '2017-10-30 13:42:11');
INSERT INTO `weke_cate_type` VALUES (6, '', '美妆', 1, 6, '2017-10-30 13:42:21');
INSERT INTO `weke_cate_type` VALUES (7, '', '母婴', 1, 7, '2017-10-30 13:42:29');
INSERT INTO `weke_cate_type` VALUES (8, '', '运动户外', 1, 8, '2017-10-30 13:42:42');
INSERT INTO `weke_cate_type` VALUES (9, '', '美食', 1, 9, '2017-10-30 13:42:51');
INSERT INTO `weke_cate_type` VALUES (10, '', '车品周边', 1, 10, '2017-10-30 13:43:03');

-- ----------------------------
-- Table structure for weke_exchange_order
-- ----------------------------
DROP TABLE IF EXISTS `weke_exchange_order`;
CREATE TABLE `weke_exchange_order`  (
  `order_id` int(11) NOT NULL COMMENT '兑换记录表',
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
  PRIMARY KEY (`order_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for weke_help
-- ----------------------------
DROP TABLE IF EXISTS `weke_help`;
CREATE TABLE `weke_help`  (
  `help_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '帮助表',
  `type` int(1) NOT NULL DEFAULT 1 COMMENT '帮助分类 1搜索页帮助 2添加订单页帮助',
  `image_url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片路径',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '帮助内容',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '状态 1启用 2禁用',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  `sorts` int(3) NOT NULL DEFAULT 1 COMMENT '排序',
  PRIMARY KEY (`help_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for weke_member
-- ----------------------------
DROP TABLE IF EXISTS `weke_member`;
CREATE TABLE `weke_member`  (
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
-- Records of weke_member
-- ----------------------------
INSERT INTO `weke_member` VALUES (1, '刘祺', '15846624454', 1, '123456', '', 0, '0000-00-00 00:00:00', '', '', 2, 0.00, 2, '', '', 1, '', '', '', '', '');

-- ----------------------------
-- Table structure for weke_member_evaluate
-- ----------------------------
DROP TABLE IF EXISTS `weke_member_evaluate`;
CREATE TABLE `weke_member_evaluate`  (
  `evaluate_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员晒单评价表',
  `product_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '评价的商品id',
  `member_id` int(5) NOT NULL DEFAULT 0 COMMENT '会员id',
  `evaluate_url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片路径',
  `evaluate_detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '评论详情',
  `evaluate_time` datetime NOT NULL COMMENT '评论时间',
  `examine_status` int(1) NOT NULL DEFAULT 2 COMMENT '评论审核状态 1已审核 2未审核',
  `examine_time` datetime DEFAULT NULL COMMENT '审核时间',
  `acer_num` int(3) NOT NULL DEFAULT 0 COMMENT '评论奖励元宝数量',
  `is_del` int(1) NOT NULL DEFAULT 2 COMMENT '是否删除 1已删除 2未删除',
  PRIMARY KEY (`evaluate_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for weke_member_footprint
-- ----------------------------
DROP TABLE IF EXISTS `weke_member_footprint`;
CREATE TABLE `weke_member_footprint`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '浏览足迹id',
  `member_id` int(5) NOT NULL DEFAULT 0 COMMENT '会员浏览的商品id',
  `product_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '会员产品id',
  `time` datetime NOT NULL COMMENT '浏览时间',
  `number` int(3) NOT NULL DEFAULT 0 COMMENT '商品浏览次数',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for weke_member_reveive
-- ----------------------------
DROP TABLE IF EXISTS `weke_member_reveive`;
CREATE TABLE `weke_member_reveive`  (
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
-- Table structure for weke_member_sign
-- ----------------------------
DROP TABLE IF EXISTS `weke_member_sign`;
CREATE TABLE `weke_member_sign`  (
  `sign_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '签到ID',
  `member_id` int(5) NOT NULL DEFAULT 0 COMMENT '签到会员ID',
  `sign_days` int(4) NOT NULL DEFAULT 0 COMMENT '签到总天数',
  `sign_acer` int(5) NOT NULL DEFAULT 0 COMMENT '签到获得的元宝数',
  `continue_days` int(3) NOT NULL DEFAULT 0 COMMENT '已连续签到天数',
  `sign_time` datetime NOT NULL COMMENT '最近签到时间',
  PRIMARY KEY (`sign_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of weke_member_sign
-- ----------------------------
INSERT INTO `weke_member_sign` VALUES (6, 1, 1, 10, 1, '2017-11-01 17:32:06');

-- ----------------------------
-- Table structure for weke_order_error
-- ----------------------------
DROP TABLE IF EXISTS `weke_order_error`;
CREATE TABLE `weke_order_error`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户兑换失败记录表',
  `member_id` int(5) NOT NULL DEFAULT 0 COMMENT '会员id',
  `order_num` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '失效的订单号',
  `msg` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '失效的原因',
  `add_time` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for weke_other_product
-- ----------------------------
DROP TABLE IF EXISTS `weke_other_product`;
CREATE TABLE `weke_other_product`  (
  `id` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT '应季必备/粉丝福利',
  `type` int(1) NOT NULL DEFAULT 1 COMMENT '类型 1、应季必备 2、粉丝福利',
  `product_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品id',
  `title` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `image` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品图片',
  `after_price` decimal(5, 2) NOT NULL DEFAULT 0.00 COMMENT '券后价格',
  `surplus_stock` int(4) NOT NULL DEFAULT 0 COMMENT '剩余库存',
  `saled_number` int(4) NOT NULL DEFAULT 0 COMMENT '销量',
  `acer_member` int(3) NOT NULL DEFAULT 0 COMMENT '回馈粉丝元宝数',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  `sorts` int(4) NOT NULL DEFAULT 1 COMMENT '排序',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '状态 1启用 2禁用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for weke_panic_time
-- ----------------------------
DROP TABLE IF EXISTS `weke_panic_time`;
CREATE TABLE `weke_panic_time`  (
  `panic_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '抢购时间表',
  `start_time` datetime DEFAULT NULL COMMENT '抢购开始时间',
  `end_time` datetime DEFAULT NULL COMMENT '抢购结束时间',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '状态 1启用 2禁用',
  PRIMARY KEY (`panic_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of weke_panic_time
-- ----------------------------
INSERT INTO `weke_panic_time` VALUES (1, '2017-10-30 14:28:19', '2017-10-30 15:28:23', 1);
INSERT INTO `weke_panic_time` VALUES (2, '2017-10-30 16:28:43', '2017-10-30 17:28:51', 1);

-- ----------------------------
-- Table structure for weke_product_acer
-- ----------------------------
DROP TABLE IF EXISTS `weke_product_acer`;
CREATE TABLE `weke_product_acer`  (
  `product_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '元宝商品表',
  `product_type` int(1) NOT NULL DEFAULT 1 COMMENT '积分商品分类 1虚拟类 2实物类',
  `product_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品名称',
  `title` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标题',
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
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for weke_sign_acer
-- ----------------------------
DROP TABLE IF EXISTS `weke_sign_acer`;
CREATE TABLE `weke_sign_acer`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员每次签到奖励',
  `reward_acer` int(3) NOT NULL DEFAULT 0 COMMENT '奖励元宝个数',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for weke_sign_notes
-- ----------------------------
DROP TABLE IF EXISTS `weke_sign_notes`;
CREATE TABLE `weke_sign_notes`  (
  `note_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '签到记录表',
  `member_id` int(5) NOT NULL DEFAULT 0 COMMENT '签到会员ID',
  `sign_time` datetime NOT NULL COMMENT '签到时间',
  `sign_acer` int(3) NOT NULL DEFAULT 0 COMMENT '签到所获元宝',
  `continue_days` int(4) NOT NULL COMMENT '连续签到天数',
  PRIMARY KEY (`note_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of weke_sign_notes
-- ----------------------------
INSERT INTO `weke_sign_notes` VALUES (13, 1, '2017-11-01 17:34:21', 0, 1);
INSERT INTO `weke_sign_notes` VALUES (12, 1, '2017-11-01 17:34:19', 0, 1);

-- ----------------------------
-- Table structure for weke_sign_reward
-- ----------------------------
DROP TABLE IF EXISTS `weke_sign_reward`;
CREATE TABLE `weke_sign_reward`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '连续签到奖励表',
  `sign_days` int(11) DEFAULT NULL COMMENT '连续签到天数',
  `reward_num` int(11) DEFAULT NULL COMMENT '奖励元宝数量',
  `status` int(1) DEFAULT 0 COMMENT '状态 1启用 2不启用',
  `add_time` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for weke_test
-- ----------------------------
DROP TABLE IF EXISTS `weke_test`;
CREATE TABLE `weke_test`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '测试采集',
  `test1` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `test2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of weke_test
-- ----------------------------
INSERT INTO `weke_test` VALUES (1, '肖申克的救赎', '142 分钟');
INSERT INTO `weke_test` VALUES (2, '肖申克的救赎', '142 分钟');
INSERT INTO `weke_test` VALUES (3, '辛德勒的名单', '195 分钟');
INSERT INTO `weke_test` VALUES (4, '教父', '175 分钟');
INSERT INTO `weke_test` VALUES (5, '黑暗骑士', '152分钟');
INSERT INTO `weke_test` VALUES (6, '危险人物', '154分钟');
INSERT INTO `weke_test` VALUES (7, '好的，坏的和丑的', '161分钟');
INSERT INTO `weke_test` VALUES (8, '指环王：国王的回归', '201 分钟');
INSERT INTO `weke_test` VALUES (9, '指环王：魔戒现身', '178 分钟');
INSERT INTO `weke_test` VALUES (10, '星球大战5-帝国反击', '124 分钟');
INSERT INTO `weke_test` VALUES (11, '八爪鱼与腾讯云达成战略合作', '　　目前大数据流量呈现爆发式增长，大量的用户行为和信息形成的大数据呈现出井喷的态势，而八爪鱼数据作为国内最大的基础数据平台与腾讯云达成战略合作。\n　　近日腾讯云高管约见八爪鱼数据CEO刘宝强先生，鉴于八爪鱼数据在大数据行业所做出的成绩，腾讯云方面表示希望能为八爪鱼数据提供资金支持，并就此事双方经过协商达成共识。\n　　八爪鱼数据CEO刘宝强先生表示，在“互联网+”的指引下，双方的合作之路水到渠成，基于互联网和公有云的IT环境变得越来越普遍，企业IT变得更加复杂，双方的深度合作能帮助用户轻松构建一体化、高安全');

SET FOREIGN_KEY_CHECKS = 1;
