/*
 Navicat Premium Data Transfer

 Source Server         : 192.168.1.57
 Source Server Type    : MySQL
 Source Server Version : 50727
 Source Host           : 192.168.1.57:3306
 Source Schema         : md

 Target Server Type    : MySQL
 Target Server Version : 50727
 File Encoding         : 65001

 Date: 28/10/2019 15:14:50
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for create_log
-- ----------------------------
DROP TABLE IF EXISTS `create_log`;
CREATE TABLE `create_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `authname` varchar(255) DEFAULT NULL COMMENT '推荐权限名',
  `dirname` varchar(255) DEFAULT NULL COMMENT '推荐目录名',
  `table` varchar(255) DEFAULT NULL COMMENT '多个表名逗号隔开',
  `file` text COMMENT '多个文件名逗号隔开',
  `ctime` datetime DEFAULT NULL,
  `status` tinyint(2) DEFAULT '1' COMMENT '状态1正常  9 移除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for kb_article
-- ----------------------------
DROP TABLE IF EXISTS `kb_article`;
CREATE TABLE `kb_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `mark_content` text,
  `html_content` text,
  `tags` tinyint(2) DEFAULT '0' COMMENT '分类',
  `mtime` datetime DEFAULT NULL,
  `ctime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of kb_article
-- ----------------------------
BEGIN;
INSERT INTO `kb_article` VALUES (3, '标题.md', '# markdown\n```\nhello markdown\n```\n- h1\n- h2\n- h3\n- h4\n\n|  标题 | 描述  |\n| ------------ | ------------ |\n| 企鹅  | 669852173  |\n', '<h1 id=\"h1-markdown\"><a name=\"markdown\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>markdown</h1><pre><code>hello markdown\n</code></pre><ul>\n<li>h1</li><li>h2</li><li>h3</li><li>h4</li></ul>\n<table>\n<thead>\n<tr>\n<th>标题</th>\n<th>描述</th>\n</tr>\n</thead>\n<tbody>\n<tr>\n<td>企鹅</td>\n<td>669852173</td>\n</tr>\n</tbody>\n</table>\n', 0, '2019-10-28 15:09:53', '2019-10-28 14:51:28');
COMMIT;

-- ----------------------------
-- Table structure for oplog
-- ----------------------------
DROP TABLE IF EXISTS `oplog`;
CREATE TABLE `oplog` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID，无特殊用途',
  `username` varchar(32) DEFAULT '',
  `uri` varchar(16) DEFAULT '' COMMENT '请求的uri',
  `mark` varchar(256) DEFAULT '' COMMENT '操作描述',
  `mark_ext` text COMMENT '此操作带有的参数等',
  `ip` varchar(16) DEFAULT '',
  `ctime` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `ux_user_1` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='日志表';

-- ----------------------------
-- Table structure for plat_config
-- ----------------------------
DROP TABLE IF EXISTS `plat_config`;
CREATE TABLE `plat_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID，无特殊用途',
  `cname` varchar(32) DEFAULT '配置名称',
  `ckey` varchar(32) DEFAULT '' COMMENT '配置的key',
  `cvalue` varchar(32) DEFAULT '' COMMENT '配置的值，可以是任何结构',
  `mark` varchar(256) DEFAULT '' COMMENT '注解',
  `type` tinyint(3) DEFAULT '0' COMMENT '1:系统配置不可删',
  `ctime` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `mtime` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_ckey_1` (`ckey`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='平台配置表';

-- ----------------------------
-- Records of plat_config
-- ----------------------------
BEGIN;
INSERT INTO `plat_config` VALUES (1, '开启谷歌验证码登录', 'login_code', '2', '谷歌验证码是个动态验证码，可以有效提高网站登录的安全。cvalue:1代表开启，2：代表关闭', 1, NULL, NULL);
INSERT INTO `plat_config` VALUES (2, '测试配置', 'xxx', 'ssss', '支持json配置，cvalue框是textarea', 0, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for plat_menu
-- ----------------------------
DROP TABLE IF EXISTS `plat_menu`;
CREATE TABLE `plat_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID，无特殊用途',
  `mname` varchar(32) DEFAULT '菜单名称',
  `desription` varchar(255) DEFAULT '',
  `url` varchar(128) DEFAULT '' COMMENT '菜单的地址',
  `icon` varchar(50) DEFAULT '' COMMENT '菜单前的图标',
  `parent` tinyint(11) NOT NULL COMMENT '0 为一级目录  否则为二级目录ID',
  `sort` mediumint(11) DEFAULT '0' COMMENT '排序',
  `type` tinyint(2) DEFAULT '1' COMMENT '1 目录 2 权限',
  `status` tinyint(2) DEFAULT '1' COMMENT '1显示2不显示',
  `action` varchar(255) DEFAULT NULL COMMENT '自定义权限名 默认 class_function',
  `system` int(255) DEFAULT '2' COMMENT '1 系统目录 访问权限内置，不可被分配 2 普通目录',
  `ctime` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `mtime` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_mname_1` (`mname`),
  UNIQUE KEY `action` (`action`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COMMENT='平台菜单表';

-- ----------------------------
-- Records of plat_menu
-- ----------------------------
BEGIN;
INSERT INTO `plat_menu` VALUES (1, '后台管理', '', 'manage', 'icon-home', 0, 2, 1, 1, 'manage', 1, NULL, '2017-10-31 15:33:18');
INSERT INTO `plat_menu` VALUES (2, '用户操作', '', '/m/user/index', 'icon-user', 1, 1, 1, 1, '/m/user/index', 1, NULL, '2017-11-01 15:56:10');
INSERT INTO `plat_menu` VALUES (3, '目录管理', '', '/m/manage/navigation', 'icon-folder-alt', 1, 3, 1, 1, '/m/manage/navigation', 1, NULL, '2017-11-01 15:56:10');
INSERT INTO `plat_menu` VALUES (57, '权限组管理', '', '/m/group/index', 'icon-users', 1, 2, 1, 1, '/m/group/index', 1, '2017-10-16 02:55:47', '2017-11-01 15:56:10');
INSERT INTO `plat_menu` VALUES (58, '配置管理', '', '/m/config/index', 'icon-globe', 1, 4, 1, 1, '/m/config/index', 1, '2017-10-16 15:44:04', '2017-11-01 15:56:10');
INSERT INTO `plat_menu` VALUES (60, '平台日志', '', '/m/log/index', 'icon-tag', 0, 3, 1, 1, '/m/log/index', 1, '2017-10-19 17:36:40', '2017-11-03 16:49:01');
INSERT INTO `plat_menu` VALUES (61, '商品管理', '', '', 'icon-basket-loaded', 0, 1, 1, 1, NULL, 2, '2017-10-27 15:53:29', '2017-10-27 15:53:48');
INSERT INTO `plat_menu` VALUES (62, '商品', '', '/test/goods/index', 'icon-handbag', 61, 0, 1, 1, '/test/goods/index', 2, '2017-10-27 16:04:52', '2017-10-27 16:04:52');
INSERT INTO `plat_menu` VALUES (63, '订单', '', '/test/order/index', 'icon-doc', 61, 0, 1, 1, '/test/order/index', 2, '2017-10-27 16:05:57', '2017-10-27 16:05:57');
INSERT INTO `plat_menu` VALUES (64, '添加商品', '', NULL, NULL, 62, 0, 2, 1, 'addgoods', 2, '2017-10-28 15:14:14', '2017-10-28 15:14:14');
INSERT INTO `plat_menu` VALUES (65, '修改商品', '', NULL, NULL, 62, 0, 2, 1, 'editgoods', 2, '2017-10-28 15:14:32', '2017-10-28 15:14:32');
INSERT INTO `plat_menu` VALUES (66, '删除商品', '', NULL, NULL, 62, 0, 2, 1, 'deletegoods', 2, '2017-10-28 15:14:52', '2017-10-28 15:14:52');
INSERT INTO `plat_menu` VALUES (67, '上下架商品', '', NULL, NULL, 62, 0, 2, 1, 'pullgoods', 2, '2017-10-28 15:16:06', '2017-10-28 15:16:06');
INSERT INTO `plat_menu` VALUES (69, '欢迎使用', '', '/Welcome/index', 'icon-home', 0, 0, 1, 1, NULL, 2, '2017-10-31 14:23:46', '2017-10-31 14:23:46');
INSERT INTO `plat_menu` VALUES (70, '模板创建', '', '/m/createtemp/index', 'icon-emoticon-smile', 1, 5, 1, 1, '/m/createtemp/index', 1, '2017-11-01 15:55:55', '2017-11-01 16:11:27');
INSERT INTO `plat_menu` VALUES (71, 'MarkDown', '', '', 'icon-note', 0, 0, 1, 1, NULL, 2, '2019-10-28 14:25:46', '2019-10-28 14:25:46');
INSERT INTO `plat_menu` VALUES (72, '全部', '', '/kb_article/index', 'icon-bar-chart', 71, 0, 1, 1, '/kb_article/index', 2, '2019-10-28 14:41:34', '2019-10-28 14:41:34');
INSERT INTO `plat_menu` VALUES (73, '新建', '', '/kb_article/updateArticle', 'icon-size-fullscreen', 71, 0, 1, 1, '/kb_article/updateArticle', 2, '2019-10-28 14:42:02', '2019-10-28 14:42:02');
COMMIT;

-- ----------------------------
-- Table structure for test_goods
-- ----------------------------
DROP TABLE IF EXISTS `test_goods`;
CREATE TABLE `test_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品管理表 测试用',
  `name` varchar(255) DEFAULT NULL COMMENT '商品名',
  `price` int(11) DEFAULT NULL COMMENT '单位分',
  `num` int(11) DEFAULT '0' COMMENT '库存',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态 1 正常 2 下架 3 删除',
  `mtime` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  `ctime` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of test_goods
-- ----------------------------
BEGIN;
INSERT INTO `test_goods` VALUES (3, '商品3', 1000, 19, 1, '2017-11-11 17:19:31', '2017-11-11 17:19:30');
INSERT INTO `test_goods` VALUES (4, '商品4', 1000, 5, 1, '2017-11-06 15:47:28', '2017-11-06 15:47:28');
INSERT INTO `test_goods` VALUES (5, '商品5', 1000, 93, 1, '2017-10-28 15:47:28', '2017-10-28 15:47:28');
INSERT INTO `test_goods` VALUES (6, '商品6', 1000, 94, 1, '2017-11-06 15:47:28', '2017-11-06 15:47:28');
INSERT INTO `test_goods` VALUES (7, '商品7', 1000, 23, 1, '2017-10-31 15:47:28', '2017-10-31 15:47:28');
INSERT INTO `test_goods` VALUES (8, '商品8', 1000, 30, 1, '2017-11-01 15:47:28', '2017-11-01 15:47:28');
INSERT INTO `test_goods` VALUES (9, '商品9', 1000, 26, 1, '2017-11-01 15:47:28', '2017-11-01 15:47:28');
INSERT INTO `test_goods` VALUES (10, '商品10', 1000, 23, 1, '2017-11-03 15:47:28', '2017-11-03 15:47:28');
INSERT INTO `test_goods` VALUES (11, '商品11', 1000, 50, 1, '2017-10-31 15:47:28', '2017-10-31 15:47:28');
INSERT INTO `test_goods` VALUES (12, '商品12', 1000, 24, 1, '2017-10-28 15:47:28', '2017-10-28 15:47:28');
INSERT INTO `test_goods` VALUES (13, '商品13', 1000, 70, 1, '2017-11-05 15:47:29', '2017-11-05 15:47:29');
INSERT INTO `test_goods` VALUES (14, '商品14', 1000, 48, 1, '2017-11-01 15:47:29', '2017-11-01 15:47:29');
INSERT INTO `test_goods` VALUES (15, '商品15', 1000, 32, 1, '2017-11-02 15:47:29', '2017-11-02 15:47:29');
INSERT INTO `test_goods` VALUES (16, '商品16', 1000, 100, 1, '2017-10-30 15:47:29', '2017-10-30 15:47:29');
INSERT INTO `test_goods` VALUES (17, '商品17', 1000, 7, 1, '2017-11-03 15:47:29', '2017-11-03 15:47:29');
INSERT INTO `test_goods` VALUES (18, '商品18', 1000, 90, 1, '2017-11-02 15:47:29', '2017-11-02 15:47:29');
INSERT INTO `test_goods` VALUES (19, '商品19', 1000, 60, 1, '2017-11-01 15:47:29', '2017-11-01 15:47:29');
INSERT INTO `test_goods` VALUES (20, '商品20', 1000, 42, 1, '2017-10-29 15:47:29', '2017-10-29 15:47:29');
COMMIT;

-- ----------------------------
-- Table structure for test_order
-- ----------------------------
DROP TABLE IF EXISTS `test_order`;
CREATE TABLE `test_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单管理 测试用',
  `order_id` varchar(32) DEFAULT NULL COMMENT '订单id',
  `gid` int(11) DEFAULT NULL COMMENT 'goods表id',
  `price` int(11) DEFAULT NULL COMMENT '商品原价',
  `pay` int(11) DEFAULT NULL COMMENT '实付金额 单位分',
  `status` tinyint(2) DEFAULT NULL COMMENT '订单状态 1 已创建未付款 2 已付款  9 已取消',
  `pay_time` timestamp NULL DEFAULT NULL COMMENT '支付时间',
  `ctime` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `mtime` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of test_order
-- ----------------------------
BEGIN;
INSERT INTO `test_order` VALUES (1, '9001201710271513909505', 5, 1000, 1000, 2, '2017-10-31 15:41:20', '2017-10-31 16:08:44', '2017-10-31 15:41:20');
INSERT INTO `test_order` VALUES (2, '9001201710271544984048', 2, 1000, 1000, 1, NULL, '2017-11-04 15:41:20', '2017-11-04 15:41:20');
INSERT INTO `test_order` VALUES (3, '9001201710271513829270', 7, 1000, 1000, 2, '2017-11-06 15:41:20', '2017-11-06 16:07:05', '2017-11-06 15:41:20');
INSERT INTO `test_order` VALUES (4, '9001201710271554161390', 1, 1000, 1000, 2, '2017-10-31 15:41:20', '2017-10-31 16:27:55', '2017-10-31 15:41:20');
INSERT INTO `test_order` VALUES (5, '9001201710271545282285', 7, 1000, 1000, 1, NULL, '2017-10-31 15:41:20', '2017-10-31 15:41:20');
INSERT INTO `test_order` VALUES (6, '9001201710271563080673', 6, 1000, 1000, 1, NULL, '2017-11-02 15:41:20', '2017-11-02 15:41:20');
INSERT INTO `test_order` VALUES (7, '9001201710271588459825', 1, 1000, 1000, 1, NULL, '2017-11-03 15:41:20', '2017-11-03 15:41:20');
INSERT INTO `test_order` VALUES (8, '9001201710271578669070', 18, 1000, 1000, 2, '2017-10-28 15:41:20', '2017-10-28 15:58:50', '2017-10-28 15:41:20');
INSERT INTO `test_order` VALUES (9, '9001201710271564966965', 5, 1000, 1000, 2, '2017-11-02 15:41:20', '2017-11-02 16:37:45', '2017-11-02 15:41:20');
INSERT INTO `test_order` VALUES (10, '9001201710271557690653', 8, 1000, 1000, 2, '2017-11-05 15:41:20', '2017-11-05 16:34:57', '2017-11-05 15:41:20');
INSERT INTO `test_order` VALUES (11, '9001201710271585040897', 20, 1000, 1000, 1, NULL, '2017-11-02 15:41:20', '2017-11-02 15:41:20');
INSERT INTO `test_order` VALUES (12, '9001201710271567601824', 10, 1000, 1000, 1, NULL, '2017-10-29 15:41:20', '2017-10-29 15:41:20');
INSERT INTO `test_order` VALUES (13, '9001201710271581393086', 1, 1000, 1000, 2, '2017-11-05 15:41:20', '2017-11-05 16:01:26', '2017-11-05 15:41:20');
INSERT INTO `test_order` VALUES (14, '9001201710271549420726', 3, 1000, 1000, 2, '2017-10-29 15:41:20', '2017-10-29 16:24:16', '2017-10-29 15:41:20');
INSERT INTO `test_order` VALUES (15, '9001201710271544553389', 2, 1000, 1000, 1, NULL, '2017-11-04 15:41:20', '2017-11-04 15:41:20');
INSERT INTO `test_order` VALUES (16, '9001201710271551504210', 9, 1000, 1000, 2, '2017-10-30 15:41:20', '2017-10-30 16:23:37', '2017-10-30 15:41:20');
INSERT INTO `test_order` VALUES (17, '9001201710271540437685', 18, 1000, 1000, 2, '2017-10-28 15:41:20', '2017-10-28 16:10:26', '2017-10-28 15:41:20');
INSERT INTO `test_order` VALUES (18, '9001201710271567384415', 14, 1000, 1000, 1, NULL, '2017-11-06 15:41:20', '2017-11-06 15:41:20');
INSERT INTO `test_order` VALUES (19, '9001201710271515735556', 9, 1000, 1000, 1, NULL, '2017-11-01 15:41:20', '2017-11-01 15:41:20');
INSERT INTO `test_order` VALUES (20, '9001201710271540830097', 4, 1000, 1000, 2, '2017-11-02 15:41:20', '2017-11-02 16:27:21', '2017-11-02 15:41:20');
COMMIT;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID，无特殊用途',
  `username` varchar(32) DEFAULT '',
  `password` varchar(128) DEFAULT '' COMMENT '密码',
  `nick_name` varchar(64) DEFAULT '' COMMENT '用户称呼',
  `gcode` varchar(16) DEFAULT '' COMMENT '谷歌验证码密码',
  `user_group` varchar(64) DEFAULT '' COMMENT '用户所在组,多个以","隔开',
  `user_level` tinyint(3) DEFAULT '0' COMMENT '用户管理级别 8：最高级管理员，1为普通级别，不可以分配权限',
  `user_right` text COMMENT '用户单独权限配置，多个以“,”隔开',
  `status` smallint(6) NOT NULL DEFAULT '2' COMMENT '用户状态  2:正常，3 锁定',
  `salt` varchar(32) DEFAULT '',
  `ctime` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `mtime` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_user_1` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COMMENT='平台用户表';

-- ----------------------------
-- Records of user
-- ----------------------------
BEGIN;
INSERT INTO `user` VALUES (1, 'superadmin', 'f07c3ca95d282ae5c731fe518e86cc1c712b358d', 'superadmin', 'o5rg2mdlna2wo4ll', '', 8, NULL, 2, 'zzzzzz', '2017-09-25 14:51:45', '2017-09-25 14:51:47');
INSERT INTO `user` VALUES (26, 'test1', '041239f40ea9c03d15c9f188a12d896379b36ec0', '客服_001', 'gzxte5dfobsgw4jx', '7', 1, '/test/goods/index,/test/order/index', 2, '66s37356135iop8l', '2017-10-31 11:40:10', '2017-10-31 11:40:10');
INSERT INTO `user` VALUES (27, 'test2', '5d1498da42dae6dfe428daee830c8ba80d91c5ff', '客服_002', 'oyyw46tsgrtgynbx', '7', 1, '/test/goods/index,editgoods,/test/order/index', 2, 'es7e0oflpy47u3rd', '2017-10-31 11:40:37', '2017-10-31 11:40:37');
INSERT INTO `user` VALUES (28, 'test3', '16a238671824cfee83294650ab77c7fbcbac48a9', '商品管理_001', 'ov4g653tnvqwqodk', '8', 1, '/test/goods/index,addgoods,editgoods,pullgoods', 2, 'i8a01ufs29ilh389', '2017-10-31 11:41:17', '2017-10-31 11:41:17');
INSERT INTO `user` VALUES (29, 'test4', '841d2b08e6bc766aa21e802cb03ed172b950e597', '店长_001', 'nvtg2zzvhfygom3s', '', 1, '/test/goods/index,addgoods,editgoods,deletegoods,pullgoods,/test/order/index,log', 2, 'ojpbh95sqzcp28zi', '2017-10-31 11:41:46', '2017-10-31 11:41:46');
INSERT INTO `user` VALUES (35, 'test5', '6707b7c4718a624a090ac0658afefa37768cf625', '普通管理员', 'm5rwoylcpayha4lz', '8,7', 2, '/test/goods/index,addgoods,editgoods,pullgoods,/test/order/index,/m/user/index', 2, 'q914qg5t82vd3qz9', '2017-10-31 15:57:28', '2017-10-31 15:57:28');
INSERT INTO `user` VALUES (38, 'admin', 'a9a960043a8992663726170966fa049a85e43d37', '管理员', 'mjxxcmtxo55gqmrx', '', 8, NULL, 2, '91coxs08968eui35', '2017-11-11 17:16:10', '2017-11-11 17:16:10');
COMMIT;

-- ----------------------------
-- Table structure for user_group
-- ----------------------------
DROP TABLE IF EXISTS `user_group`;
CREATE TABLE `user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID，无特殊用途',
  `gname` varchar(32) DEFAULT '' COMMENT '权限组名称',
  `ctime` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `mtime` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_gname_1` (`gname`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='用户权限组';

-- ----------------------------
-- Records of user_group
-- ----------------------------
BEGIN;
INSERT INTO `user_group` VALUES (7, '测试_客服', '2017-10-31 11:33:17', '2017-10-31 11:33:17');
INSERT INTO `user_group` VALUES (8, '测试_商品管理', '2017-10-31 11:34:14', '2017-10-31 11:34:14');
INSERT INTO `user_group` VALUES (9, '测试_店长', '2017-10-31 11:35:38', '2017-10-31 11:35:38');
COMMIT;

-- ----------------------------
-- Table structure for user_group_right
-- ----------------------------
DROP TABLE IF EXISTS `user_group_right`;
CREATE TABLE `user_group_right` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID，无特殊用途',
  `ugid` int(11) DEFAULT '0' COMMENT '权限组id',
  `pmid` int(11) DEFAULT '0' COMMENT '权限id 关联表 plat_menu',
  `ctime` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `mtime` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_ugp_1` (`ugid`,`pmid`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='权限组对应的权限';

-- ----------------------------
-- Records of user_group_right
-- ----------------------------
BEGIN;
INSERT INTO `user_group_right` VALUES (23, 7, 62, NULL, NULL);
INSERT INTO `user_group_right` VALUES (24, 7, 63, NULL, NULL);
INSERT INTO `user_group_right` VALUES (25, 8, 62, NULL, NULL);
INSERT INTO `user_group_right` VALUES (26, 8, 64, NULL, NULL);
INSERT INTO `user_group_right` VALUES (27, 8, 65, NULL, NULL);
INSERT INTO `user_group_right` VALUES (28, 8, 67, NULL, NULL);
INSERT INTO `user_group_right` VALUES (29, 9, 62, NULL, NULL);
INSERT INTO `user_group_right` VALUES (30, 9, 64, NULL, NULL);
INSERT INTO `user_group_right` VALUES (31, 9, 65, NULL, NULL);
INSERT INTO `user_group_right` VALUES (32, 9, 66, NULL, NULL);
INSERT INTO `user_group_right` VALUES (33, 9, 67, NULL, NULL);
INSERT INTO `user_group_right` VALUES (34, 9, 63, NULL, NULL);
INSERT INTO `user_group_right` VALUES (35, 9, 60, NULL, NULL);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
