/*
 Navicat Premium Data Transfer

 Source Server         : devbuluo
 Source Server Type    : MySQL
 Source Server Version : 50559
 Source Host           : 221.122.93.163:3306
 Source Schema         : devbuluo

 Target Server Type    : MySQL
 Target Server Version : 50559
 File Encoding         : 65001

 Date: 04/11/2019 11:23:50
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for dbl_admin_app
-- ----------------------------
DROP TABLE IF EXISTS `dbl_admin_app`;
CREATE TABLE `dbl_admin_app` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '应用名称（标识）',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '应用标题',
  `icon` varchar(64) NOT NULL DEFAULT '' COMMENT '图标',
  `description` text NOT NULL COMMENT '描述',
  `author` varchar(32) NOT NULL DEFAULT '' COMMENT '作者',
  `author_url` varchar(255) NOT NULL DEFAULT '' COMMENT '作者主页',
  `config` text COMMENT '配置信息',
  `access` text COMMENT '授权配置',
  `version` varchar(16) NOT NULL DEFAULT '' COMMENT '版本号',
  `identifier` varchar(64) NOT NULL DEFAULT '' COMMENT '模块唯一标识符',
  `system_app` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否为系统应用',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `state` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='应用表';

-- ----------------------------
-- Records of dbl_admin_app
-- ----------------------------
BEGIN;
INSERT INTO `dbl_admin_app` VALUES (1, 'admin', '系统', '', '系统应用，管理所有平台应用', 'devbuluo', 'http://www.devbuluo.com', NULL, NULL, '1.0.0', 'admin.devbuluo.apps', 1, 1556811702, 1556811702, 100, 1);
INSERT INTO `dbl_admin_app` VALUES (2, 'user', '用户', '', '用户系统，所有应用公用的用户体系', 'devbuluo', 'http://www.devbuluo.com', NULL, NULL, '1.0.0', 'user.devbuluo.apps', 1, 1556811702, 1556811702, 100, 1);
INSERT INTO `dbl_admin_app` VALUES (3, 'api', '接口', '', '接口系统', 'devbuluo', 'http://www.devbuluo.com', NULL, NULL, '1.0.0', 'api.devbuluo.com', 1, 1556811702, 1556811702, 100, 1);
COMMIT;

-- ----------------------------
-- Table structure for dbl_admin_config
-- ----------------------------
DROP TABLE IF EXISTS `dbl_admin_config`;
CREATE TABLE `dbl_admin_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field` varchar(64) NOT NULL DEFAULT '' COMMENT '名称',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '标题',
  `group` varchar(32) NOT NULL DEFAULT '' COMMENT '配置分组',
  `template` varchar(32) NOT NULL DEFAULT '' COMMENT '类型',
  `value` text NOT NULL COMMENT '配置值',
  `options` text NOT NULL COMMENT '配置项',
  `tips` varchar(256) NOT NULL DEFAULT '' COMMENT '配置提示',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `state` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：0禁用，1启用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COMMENT='系统配置表';

-- ----------------------------
-- Records of dbl_admin_config
-- ----------------------------
BEGIN;
INSERT INTO `dbl_admin_config` VALUES (1, 'web_site_status', '站点开关', 'base', 'switch', '1', 'active-value:1\r\ninactive-value:0', '', 1556504611, 1572155991, 50, 1);
INSERT INTO `dbl_admin_config` VALUES (2, 'web_site_title', '站点标题', 'base', 'text', '开发者部落', '', '', 1556504897, 1572156796, 50, 1);
INSERT INTO `dbl_admin_config` VALUES (3, 'web_site_description', '站点描述', 'base', 'textarea', '这是站点描述', '', '', 1556505027, 1557213972, 50, 1);
INSERT INTO `dbl_admin_config` VALUES (4, 'web_site_keywords', '站点关键词', 'base', 'textarea', '这是站点关键词1', '', '', 1556505654, 1557213972, 50, 1);
INSERT INTO `dbl_admin_config` VALUES (5, 'captcha_signin', '后台验证码', 'system', 'switch', '1', 'active-value:1\ninactive-value:0', '', 1556505931, 1557212670, 50, 1);
INSERT INTO `dbl_admin_config` VALUES (6, 'system_log', '系统日志', 'system', 'switch', '1', 'active-value:1\ninactive-value:0', '', 1556506047, 1557212670, 50, 1);
INSERT INTO `dbl_admin_config` VALUES (7, 'config_group', '配置分组', 'system', 'array', 'base:基本\r\nsystem:系统\r\nupload:上传\r\ndevelop:开发\r\ndatabase:数据库', '', '', 1556506209, 1557212670, 50, 1);
INSERT INTO `dbl_admin_config` VALUES (8, 'form_items_template', '表单模板', 'system', 'array', 'text:单行文本\r\ntextarea:多行文本\r\ncheckbox:复选框\r\nradio:单选按钮\r\nswitch:开关\r\narray:数组\r\nselect:下拉框', '', '', 1556506323, 1557212670, 50, 1);
INSERT INTO `dbl_admin_config` VALUES (9, 'develop_mode', '开发模式', 'develop', 'radio', '1', '1:开启\r\n0:关闭', '', 1556809768, 1556809768, 50, 1);
COMMIT;

-- ----------------------------
-- Table structure for dbl_admin_log
-- ----------------------------
DROP TABLE IF EXISTS `dbl_admin_log`;
CREATE TABLE `dbl_admin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `user_id` int(11) NOT NULL COMMENT '用户编号',
  `details` varchar(255) NOT NULL COMMENT '备注',
  `param` varchar(50) NOT NULL COMMENT '请求参数',
  `url` varchar(50) NOT NULL COMMENT '访问的url',
  `ip` varchar(50) NOT NULL COMMENT '访问的ip',
  `state` enum('0','1') NOT NULL DEFAULT '0' COMMENT '操作是否成功',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COMMENT='后台操作日志表';

-- ----------------------------
-- Records of dbl_admin_log
-- ----------------------------
BEGIN;
INSERT INTO `dbl_admin_log` VALUES (22, '', 1, '{\"uid\":5,\"create_time\":1556275903}', '', '', '', '0', 0, 0);
INSERT INTO `dbl_admin_log` VALUES (23, '没有记录菜单的操作', 1, '', '', '/admin.php/admin/config/disable.html', '0', '0', 1572017316, 1572017316);
INSERT INTO `dbl_admin_log` VALUES (24, '没有记录菜单的操作', 1, '', '', '/admin.php/admin/config/enable.html', '0', '0', 1572017386, 1572017386);
INSERT INTO `dbl_admin_log` VALUES (25, '没有记录菜单的操作', 1, '', '', '/admin.php/admin/config/enable.html', '0', '0', 1572017386, 1572017386);
INSERT INTO `dbl_admin_log` VALUES (26, '没有记录菜单的操作', 1, '', '', '/admin.php/admin/config/enable.html', '0', '0', 1572017412, 1572017412);
INSERT INTO `dbl_admin_log` VALUES (27, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_config`  SET `state` = 1  WHERE  `id` IN (4,3,2,1)', '', '/admin.php/admin/config/enable.html', '0', '0', 1572017492, 1572017492);
INSERT INTO `dbl_admin_log` VALUES (28, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_config`  SET `state` = 1  WHERE  `id` IN (4,3,2,1)', '', '/admin.php/admin/config/enable.html', '0', '0', 1572017492, 1572017492);
INSERT INTO `dbl_admin_log` VALUES (29, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_config`  SET `state` = 0  WHERE  `id` = 5', '', '/admin.php/admin/config/disable.html', '0', '0', 1572094496, 1572094496);
INSERT INTO `dbl_admin_log` VALUES (30, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_config`  SET `state` = 1  WHERE  `id` = 5', '', '/admin.php/admin/config/enable.html', '0', '0', 1572094503, 1572094503);
INSERT INTO `dbl_admin_log` VALUES (31, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_config`  SET `state` = 1  WHERE  `id` IN (8,7,6,5)', '', '/admin.php/admin/config/enable.html', '0', '0', 1572094668, 1572094668);
INSERT INTO `dbl_admin_log` VALUES (32, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_config`  SET `state` = 0  WHERE  `id` IN (8,7,6,5)', '', '/admin.php/admin/config/disable.html', '0', '0', 1572094698, 1572094698);
INSERT INTO `dbl_admin_log` VALUES (33, '没有记录菜单的操作', 1, 'UPDATE `dbl_api_app_group`  SET `state` = 0  WHERE  `id` = 1', '', '/admin.php/api/appgroup/disable.html', '0', '0', 1572167288, 1572167288);
INSERT INTO `dbl_admin_log` VALUES (34, '没有记录菜单的操作', 1, 'UPDATE `dbl_api_app_group`  SET `state` = 1  WHERE  `id` = 1', '', '/admin.php/api/appgroup/enable.html', '0', '0', 1572167295, 1572167295);
INSERT INTO `dbl_admin_log` VALUES (35, '新增菜单', 1, 'INSERT INTO `dbl_admin_menu` SET `id` = 0 , `app` = \'api\' , `pid` = 22 , `title` = \'接口设置\' , `url_value` = \'\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `create_time` = 1572173703 , `update_time` = 1572173703', '', '/admin.php/admin/menu/add.html', '0', '1', 1572173703, 1572173703);
INSERT INTO `dbl_admin_log` VALUES (36, '新增菜单', 1, 'INSERT INTO `dbl_admin_menu` SET `id` = 0 , `app` = \'api\' , `pid` = 32 , `title` = \'接口分组\' , `url_value` = \'api/Interface/index\' , `icon` = \'dui-icon-article\' , `sort` = 100 , `state` = 1 , `create_time` = 1572174475 , `update_time` = 1572174475', '', '/admin.php/admin/menu/add.html', '0', '1', 1572174475, 1572174475);
INSERT INTO `dbl_admin_log` VALUES (37, '新增菜单', 1, 'INSERT INTO `dbl_admin_menu` SET `id` = 0 , `app` = \'api\' , `pid` = 32 , `title` = \'接口列表\' , `url_value` = \'api/Interface/index\' , `icon` = \'dui-icon-article\' , `sort` = 100 , `state` = 1 , `create_time` = 1572174739 , `update_time` = 1572174739', '', '/admin.php/admin/menu/add.html', '0', '1', 1572174740, 1572174740);
INSERT INTO `dbl_admin_log` VALUES (38, '新增菜单', 1, 'INSERT INTO `dbl_admin_menu` SET `id` = 0 , `app` = \'api\' , `pid` = 24 , `title` = \'添加应用组\' , `url_value` = \'api/appgroup/add\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `create_time` = 1572174937 , `update_time` = 1572174937', '', '/admin.php/admin/menu/add.html', '0', '1', 1572174937, 1572174937);
INSERT INTO `dbl_admin_log` VALUES (39, '新增菜单', 1, 'INSERT INTO `dbl_admin_menu` SET `id` = 0 , `app` = \'api\' , `pid` = 24 , `title` = \'修改应用组\' , `url_value` = \'api/appgroup/edit\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `create_time` = 1572175050 , `update_time` = 1572175050', '', '/admin.php/admin/menu/add.html', '0', '1', 1572175050, 1572175050);
INSERT INTO `dbl_admin_log` VALUES (40, '新增菜单', 1, 'INSERT INTO `dbl_admin_menu` SET `id` = 0 , `app` = \'api\' , `pid` = 24 , `title` = \'删除应用组\' , `url_value` = \'api/appgroup/delete\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `create_time` = 1572175704 , `update_time` = 1572175704', '', '/admin.php/admin/menu/add.html', '0', '1', 1572175704, 1572175704);
INSERT INTO `dbl_admin_log` VALUES (41, '新增菜单', 1, 'INSERT INTO `dbl_admin_menu` SET `id` = 0 , `app` = \'api\' , `pid` = 24 , `title` = \'禁用应用组\' , `url_value` = \'api/appgroup/enable\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `create_time` = 1572175937 , `update_time` = 1572175937', '', '/admin.php/admin/menu/add.html', '0', '1', 1572175937, 1572175937);
INSERT INTO `dbl_admin_log` VALUES (42, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 38 , `app` = \'api\' , `title` = \'启用应用组\' , `url_value` = \'api/appgroup/enable\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `update_time` = 1572176302  WHERE  `id` = 38', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572176302, 1572176302);
INSERT INTO `dbl_admin_log` VALUES (43, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 38 , `app` = \'api\' , `title` = \'启用应用组\' , `url_value` = \'api/appgroup/enable\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `update_time` = 1572176468  WHERE  `id` = 38', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572176469, 1572176469);
INSERT INTO `dbl_admin_log` VALUES (44, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572176704  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572176704, 1572176704);
INSERT INTO `dbl_admin_log` VALUES (45, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572176758  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572176758, 1572176758);
INSERT INTO `dbl_admin_log` VALUES (46, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 31 , `app` = \'api\' , `title` = \'应用列表\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-apps\' , `sort` = 100 , `state` = 1 , `update_time` = 1572177252  WHERE  `id` = 31', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572177252, 1572177252);
INSERT INTO `dbl_admin_log` VALUES (47, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 1 , `app` = \'admin\' , `title` = \'首页\' , `url_value` = \'admin/index/index\' , `icon` = \'dui-icon-home\' , `sort` = 100 , `state` = 1 , `update_time` = 1572177312  WHERE  `id` = 1', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572177312, 1572177312);
INSERT INTO `dbl_admin_log` VALUES (48, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572177394  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572177394, 1572177394);
INSERT INTO `dbl_admin_log` VALUES (49, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572178138  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572178138, 1572178138);
INSERT INTO `dbl_admin_log` VALUES (50, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572178185  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572178185, 1572178185);
INSERT INTO `dbl_admin_log` VALUES (51, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572178786  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572178787, 1572178787);
INSERT INTO `dbl_admin_log` VALUES (52, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 6 , `app` = \'admin\' , `title` = \'系统\' , `url_value` = \'admin/system/index\' , `icon` = \'dui-icon-setting2\' , `sort` = 100 , `state` = 1 , `update_time` = 1572178810  WHERE  `id` = 6', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572178810, 1572178810);
INSERT INTO `dbl_admin_log` VALUES (53, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572178867  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572178867, 1572178867);
INSERT INTO `dbl_admin_log` VALUES (54, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572178894  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572178894, 1572178894);
INSERT INTO `dbl_admin_log` VALUES (55, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572179199  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572179199, 1572179199);
INSERT INTO `dbl_admin_log` VALUES (56, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572179271  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572179271, 1572179271);
INSERT INTO `dbl_admin_log` VALUES (57, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572179415  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572179415, 1572179415);
INSERT INTO `dbl_admin_log` VALUES (58, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `state` = 1  WHERE  `id` = 22', '', '/admin.php/admin/menu/enable.html', '0', '0', 1572179472, 1572179472);
INSERT INTO `dbl_admin_log` VALUES (59, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 18 , `app` = \'user\' , `title` = \'用户\' , `url_value` = \'member/index/index\' , `icon` = \'dui-icon-user\' , `sort` = 100 , `state` = 1 , `update_time` = 1572180257  WHERE  `id` = 18', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572180257, 1572180257);
INSERT INTO `dbl_admin_log` VALUES (60, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572180299  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572180299, 1572180299);
INSERT INTO `dbl_admin_log` VALUES (61, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572180711  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572180711, 1572180711);
INSERT INTO `dbl_admin_log` VALUES (62, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572180821  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572180821, 1572180821);
INSERT INTO `dbl_admin_log` VALUES (63, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572180848  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572180848, 1572180848);
INSERT INTO `dbl_admin_log` VALUES (64, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572180878  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572180878, 1572180878);
INSERT INTO `dbl_admin_log` VALUES (65, '新增菜单', 1, 'INSERT INTO `dbl_admin_menu` SET `id` = 0 , `app` = \'api\' , `pid` = 24 , `title` = \'禁用\' , `url_value` = \'api/appgroup/disable\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `create_time` = 1572183326 , `update_time` = 1572183326', '', '/admin.php/admin/menu/add.html', '0', '1', 1572183326, 1572183326);
INSERT INTO `dbl_admin_log` VALUES (66, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 39 , `app` = \'api\' , `title` = \'禁用应用组\' , `url_value` = \'api/appgroup/disable\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `update_time` = 1572183385  WHERE  `id` = 39', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572183385, 1572183385);
INSERT INTO `dbl_admin_log` VALUES (67, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 23 , `app` = \'api\' , `pid` = 22 , `title` = \'应用接入\' , `url_value` = \'\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572184448  WHERE  `id` = 23', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572184448, 1572184448);
INSERT INTO `dbl_admin_log` VALUES (68, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `pid` = 0 , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572184462  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572184462, 1572184462);
INSERT INTO `dbl_admin_log` VALUES (69, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `pid` = 0 , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572184523  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572184523, 1572184523);
INSERT INTO `dbl_admin_log` VALUES (70, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `pid` = 0 , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572184595  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572184595, 1572184595);
INSERT INTO `dbl_admin_log` VALUES (71, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `pid` = 0 , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572184627  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572184627, 1572184627);
INSERT INTO `dbl_admin_log` VALUES (72, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `pid` = 0 , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572184659  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572184659, 1572184659);
INSERT INTO `dbl_admin_log` VALUES (73, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `pid` = 0 , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572184667  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572184667, 1572184667);
INSERT INTO `dbl_admin_log` VALUES (74, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 33 , `app` = \'api\' , `pid` = 32 , `title` = \'接口分组\' , `url_value` = \'api/group/index\' , `icon` = \'dui-icon-article\' , `sort` = 100 , `state` = 1 , `update_time` = 1572186476  WHERE  `id` = 33', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572186476, 1572186476);
INSERT INTO `dbl_admin_log` VALUES (75, '没有记录菜单的操作', 1, 'INSERT INTO `dbl_api_group` SET `id` = 0 , `name` = \'用户中心\' , `description` = \'这里是和用户相关的操作api\' , `hash` = \'5db5aca7b1fbe\' , `state` = 1 , `create_time` = 1572187352 , `update_time` = 1572187352', '', '/admin.php/api/group/add.html', '0', '1', 1572187352, 1572187352);
INSERT INTO `dbl_admin_log` VALUES (76, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 34 , `app` = \'api\' , `pid` = 32 , `title` = \'接口列表\' , `url_value` = \'api/index/index\' , `icon` = \'dui-icon-article\' , `sort` = 100 , `state` = 1 , `update_time` = 1572189328  WHERE  `id` = 34', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572189328, 1572189328);
INSERT INTO `dbl_admin_log` VALUES (77, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 6 , `app` = \'admin\' , `pid` = 0 , `title` = \'系统\' , `url_value` = \'admin/system/index\' , `icon` = \'dui-icon-config\' , `sort` = 100 , `state` = 1 , `update_time` = 1572194704  WHERE  `id` = 6', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572194704, 1572194704);
INSERT INTO `dbl_admin_log` VALUES (78, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 18 , `app` = \'user\' , `pid` = 0 , `title` = \'用户\' , `url_value` = \'member/index/index\' , `icon` = \'dui-icon-users\' , `sort` = 100 , `state` = 1 , `update_time` = 1572194719  WHERE  `id` = 18', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572194719, 1572194719);
INSERT INTO `dbl_admin_log` VALUES (79, '没有记录菜单的操作', 1, 'INSERT INTO `dbl_api_group` SET `id` = 0 , `name` = \'公共操作\' , `description` = \'这是一些公共的接口分组\' , `hash` = \'5db5c9f554463\' , `state` = 1 , `create_time` = 1572194836 , `update_time` = 1572194836', '', '/admin.php/api/group/add.html', '0', '1', 1572194836, 1572194836);
INSERT INTO `dbl_admin_log` VALUES (80, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `pid` = 0 , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-apps\' , `sort` = 100 , `state` = 1 , `update_time` = 1572195207  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572195207, 1572195207);
INSERT INTO `dbl_admin_log` VALUES (81, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 22 , `app` = \'api\' , `pid` = 0 , `title` = \'接口\' , `url_value` = \'api/app/index\' , `icon` = \'dui-icon-code\' , `sort` = 100 , `state` = 1 , `update_time` = 1572195253  WHERE  `id` = 22', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572195253, 1572195253);
INSERT INTO `dbl_admin_log` VALUES (82, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 23 , `app` = \'api\' , `pid` = 22 , `title` = \'应用接入\' , `url_value` = \'\' , `icon` = \'dui-icon-apps\' , `sort` = 100 , `state` = 1 , `update_time` = 1572195269  WHERE  `id` = 23', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572195269, 1572195269);
INSERT INTO `dbl_admin_log` VALUES (83, '新增菜单', 1, 'INSERT INTO `dbl_admin_menu` SET `id` = 0 , `app` = \'api\' , `pid` = 33 , `title` = \'添加接口组\' , `url_value` = \'api/group/add\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `create_time` = 1572233532 , `update_time` = 1572233532', '', '/admin.php/admin/menu/add.html', '0', '1', 1572233532, 1572233532);
INSERT INTO `dbl_admin_log` VALUES (84, '新增菜单', 1, 'INSERT INTO `dbl_admin_menu` SET `id` = 0 , `app` = \'api\' , `pid` = 33 , `title` = \'修改接口组\' , `url_value` = \'api/group/edit\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `create_time` = 1572234265 , `update_time` = 1572234265', '', '/admin.php/admin/menu/add.html', '0', '1', 1572234266, 1572234266);
INSERT INTO `dbl_admin_log` VALUES (85, '新增菜单', 1, 'INSERT INTO `dbl_admin_menu` SET `id` = 0 , `app` = \'api\' , `pid` = 33 , `title` = \'启用接口组\' , `url_value` = \'api/group/enable\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `create_time` = 1572234389 , `update_time` = 1572234389', '', '/admin.php/admin/menu/add.html', '0', '1', 1572234389, 1572234389);
INSERT INTO `dbl_admin_log` VALUES (86, '新增菜单', 1, 'INSERT INTO `dbl_admin_menu` SET `id` = 0 , `app` = \'api\' , `pid` = 33 , `title` = \'禁用接口组\' , `url_value` = \'api/group/disable\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `create_time` = 1572234799 , `update_time` = 1572234799', '', '/admin.php/admin/menu/add.html', '0', '1', 1572234799, 1572234799);
INSERT INTO `dbl_admin_log` VALUES (87, '新增菜单', 1, 'INSERT INTO `dbl_admin_menu` SET `id` = 0 , `app` = \'api\' , `pid` = 33 , `title` = \'删除接口组\' , `url_value` = \'api/group/delete\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `create_time` = 1572234828 , `update_time` = 1572234828', '', '/admin.php/admin/menu/add.html', '0', '1', 1572234829, 1572234829);
INSERT INTO `dbl_admin_log` VALUES (88, '新增菜单', 1, 'INSERT INTO `dbl_admin_menu` SET `id` = 0 , `app` = \'api\' , `pid` = 34 , `title` = \'添加接口\' , `url_value` = \'api/index/add\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `create_time` = 1572234887 , `update_time` = 1572234887', '', '/admin.php/admin/menu/add.html', '0', '1', 1572234887, 1572234887);
INSERT INTO `dbl_admin_log` VALUES (89, '新增菜单', 1, 'INSERT INTO `dbl_admin_menu` SET `id` = 0 , `app` = \'api\' , `pid` = 34 , `title` = \'修改接口\' , `url_value` = \'api/index/edit\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `create_time` = 1572241202 , `update_time` = 1572241202', '', '/admin.php/admin/menu/add.html', '0', '1', 1572241203, 1572241203);
INSERT INTO `dbl_admin_log` VALUES (90, '新增菜单', 1, 'INSERT INTO `dbl_admin_menu` SET `id` = 0 , `app` = \'api\' , `pid` = 34 , `title` = \'启用接口\' , `url_value` = \'api/index/enable\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `create_time` = 1572241230 , `update_time` = 1572241230', '', '/admin.php/admin/menu/add.html', '0', '1', 1572241230, 1572241230);
INSERT INTO `dbl_admin_log` VALUES (91, '新增菜单', 1, 'INSERT INTO `dbl_admin_menu` SET `id` = 0 , `app` = \'api\' , `pid` = 34 , `title` = \'禁用接口\' , `url_value` = \'api/index/disabel\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `create_time` = 1572241271 , `update_time` = 1572241271', '', '/admin.php/admin/menu/add.html', '0', '1', 1572241271, 1572241271);
INSERT INTO `dbl_admin_log` VALUES (92, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 48 , `app` = \'api\' , `pid` = 34 , `title` = \'禁用接口\' , `url_value` = \'api/index/disable\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `update_time` = 1572241286  WHERE  `id` = 48', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572241286, 1572241286);
INSERT INTO `dbl_admin_log` VALUES (93, '新增菜单', 1, 'INSERT INTO `dbl_admin_menu` SET `id` = 0 , `app` = \'api\' , `pid` = 34 , `title` = \'删除接口\' , `url_value` = \'api/index/delete\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `create_time` = 1572241359 , `update_time` = 1572241359', '', '/admin.php/admin/menu/add.html', '0', '1', 1572241359, 1572241359);
INSERT INTO `dbl_admin_log` VALUES (94, '新增菜单', 1, 'INSERT INTO `dbl_admin_menu` SET `id` = 0 , `app` = \'api\' , `pid` = 34 , `title` = \'添加请求参数\' , `url_value` = \'api/index/request\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `create_time` = 1572273584 , `update_time` = 1572273584', '', '/admin.php/admin/menu/add.html', '0', '1', 1572273584, 1572273584);
INSERT INTO `dbl_admin_log` VALUES (95, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 50 , `app` = \'api\' , `pid` = 34 , `title` = \'请求参数列表\' , `url_value` = \'api/index/request\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `update_time` = 1572273603  WHERE  `id` = 50', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572273603, 1572273603);
INSERT INTO `dbl_admin_log` VALUES (96, '新增菜单', 1, 'INSERT INTO `dbl_admin_menu` SET `id` = 0 , `app` = \'api\' , `pid` = 34 , `title` = \'返回参数列表\' , `url_value` = \'api/fields/response\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `create_time` = 1572273677 , `update_time` = 1572273677', '', '/admin.php/admin/menu/add.html', '0', '1', 1572273677, 1572273677);
INSERT INTO `dbl_admin_log` VALUES (97, '没有记录菜单的操作', 1, 'UPDATE `dbl_admin_menu`  SET `id` = 50 , `app` = \'api\' , `pid` = 34 , `title` = \'请求参数列表\' , `url_value` = \'api/fields/request\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `update_time` = 1572273690  WHERE  `id` = 50', '', '/admin.php/admin/menu/edit.html', '0', '1', 1572273690, 1572273690);
INSERT INTO `dbl_admin_log` VALUES (98, '新增菜单', 1, 'INSERT INTO `dbl_admin_menu` SET `id` = 0 , `app` = \'api\' , `pid` = 34 , `title` = \'添加字段\' , `url_value` = \'api/fields/add\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `create_time` = 1572273723 , `update_time` = 1572273723', '', '/admin.php/admin/menu/add.html', '0', '1', 1572273723, 1572273723);
INSERT INTO `dbl_admin_log` VALUES (99, '新增菜单', 1, 'INSERT INTO `dbl_admin_menu` SET `id` = 0 , `app` = \'api\' , `pid` = 34 , `title` = \'修改接口字段\' , `url_value` = \'api/fields/edit\' , `icon` = \'\' , `sort` = 100 , `state` = 1 , `create_time` = 1572273771 , `update_time` = 1572273771', '', '/admin.php/admin/menu/add.html', '0', '1', 1572273771, 1572273771);
INSERT INTO `dbl_admin_log` VALUES (100, '禁用接口', 1, 'UPDATE `dbl_api_list`  SET `state` = 0  WHERE  `id` = 1', '', '/admin.php/api/index/disable.html', '0', '0', 1572276344, 1572276344);
INSERT INTO `dbl_admin_log` VALUES (101, '启用接口', 1, 'UPDATE `dbl_api_list`  SET `state` = 1  WHERE  `id` = 1', '', '/admin.php/api/index/enable.html', '0', '0', 1572276350, 1572276350);
INSERT INTO `dbl_admin_log` VALUES (102, '添加接口', 1, 'INSERT INTO `dbl_api_list` SET `id` = 0 , `name` = \'\' , `api_class` = \'\' , `group_hash` = \'5db5c9f554463\' , `hash` = \'5db70dde70b9f\' , `method` = 0 , `access_token` = \'0\' , `user_token` = \'0\' , `is_test` = \'0\' , `state` = 1 , `create_time` = 1572277730 , ', '', '/admin.php/api/index/add.html', '0', '1', 1572277731, 1572277731);
INSERT INTO `dbl_admin_log` VALUES (103, '删除接口', 1, 'DELETE FROM `dbl_api_list` WHERE  `id` = 2', '', '/admin.php/api/index/delete.html', '0', '0', 1572277741, 1572277741);
INSERT INTO `dbl_admin_log` VALUES (104, '没有记录菜单的操作', 1, 'INSERT INTO `dbl_api_app` SET `id` = 0 , `name` = \'开发者部落PC端\' , `app_group` = \'5db55dcccdd66\' , `app_id` = \'48375923\' , `app_secret` = \'ea1bdf302647c110c2d2a9d18a2a732f\' , `description` = \'这是关于pc端的系列接口\' , `app_api` = \'[\\\"5db5c20c9abaa\\\"]\' , `state` = 1 , `', '', '/admin.php/api/app/add.html', '0', '1', 1572837626, 1572837626);
COMMIT;

-- ----------------------------
-- Table structure for dbl_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `dbl_admin_menu`;
CREATE TABLE `dbl_admin_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上级菜单id',
  `app` varchar(16) NOT NULL DEFAULT '' COMMENT '所属应用',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '菜单标题',
  `icon` varchar(64) NOT NULL DEFAULT '' COMMENT '菜单图标',
  `url_value` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `url_target` enum('_pjax','_pop','_blank','_self') NOT NULL DEFAULT '_pjax' COMMENT '链接打开方式：_blank,_self',
  `url_params` varchar(255) NOT NULL DEFAULT '' COMMENT '参数',
  `online_hide` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '网站上线后是否隐藏',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `system_menu` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否为系统菜单，系统菜单不可删除',
  `state` enum('0','1') CHARACTER SET utf8 NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COMMENT='后台菜单表';

-- ----------------------------
-- Records of dbl_admin_menu
-- ----------------------------
BEGIN;
INSERT INTO `dbl_admin_menu` VALUES (1, 0, 'admin', '首页', 'dui-icon-home', 'admin/index/index', '_pjax', '', 0, 1546252114, 1572177312, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (2, 1, 'admin', '快捷操作', 'dui-icon-folder-open', '', '_pjax', '', 0, 1546252114, 1572159554, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (3, 2, 'admin', '后台首页', 'dui-icon-home', 'admin/index/index', '_pjax', '', 0, 1546252114, 1572159571, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (4, 2, 'admin', '个人设置', 'dui-icon-user-setting', 'admin/index/profile', '_pjax', '', 0, 1546252114, 1572159595, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (5, 2, 'admin', '清空缓存', 'dui-icon-trash', 'admin/index/clearcache', '_pjax', '', 0, 1546252114, 1572159634, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (6, 0, 'admin', '系统', 'dui-icon-config', 'admin/system/index', '_pjax', '', 0, 1546252114, 1572194704, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (7, 6, 'admin', '系统功能', 'dui-icon-config', '', '_pjax', '', 0, 1546252114, 1572160246, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (8, 7, 'admin', '系统设置', 'dui-icon-config2', 'admin/system/index', '_pjax', '', 0, 1546252114, 1572160259, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (9, 7, 'admin', '配置管理', 'dui-icon-setting', 'admin/config/index', '_pjax', '', 0, 1546252114, 1572160221, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (10, 7, 'admin', '菜单管理', 'dui-icon-list-ul', 'admin/menu/index', '_pjax', '', 0, 1546252114, 1546252114, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (11, 7, 'admin', '附件管理', 'dui-icon-upload', 'admin/attachment/index', '_pjax', '', 0, 1546252114, 1572160285, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (12, 7, 'admin', '日志管理', 'dui-icon-log', 'admin/log/index', '_pjax', '', 0, 1546252114, 1572160364, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (13, 7, 'admin', '数据库管理', 'dui-icon-database', 'admin/database/index', '_pjax', '', 0, 1546252114, 1546252114, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (14, 6, 'admin', '扩展管理', 'dui-icon-apps2', '', '_pjax', '', 0, 1546252114, 1572160402, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (15, 14, 'admin', '应用管理', 'dui-icon-apps', 'admin/module/index', '_pjax', '', 0, 1546252114, 1572160435, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (16, 14, 'admin', '插件管理', 'dui-icon-plugin', 'admin/plugin/index', '_pjax', '', 0, 1546252114, 1572160452, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (17, 14, 'admin', '钩子管理', 'dui-icon-hook', 'admin/hook/index', '_pjax', '', 0, 1546252114, 1572160465, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (18, 0, 'user', '用户', 'dui-icon-users', 'member/index/index', '_pjax', '', 0, 1546252114, 1572194719, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (19, 18, 'user', '用户管理', 'dui-icon-user-list', '', '_pjax', '', 0, 1546252114, 1572160511, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (20, 19, 'user', '用户管理', 'dui-icon-user-list', 'member/index/index', '_pjax', '', 0, 1546252114, 1572160581, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (21, 28, 'user', '团队成员', 'dui-icon-user-list', 'member/perm/index', '_pjax', '', 0, 1546252114, 1572160595, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (22, 0, 'api', '接口', 'dui-icon-code', 'api/app/index', '_pjax', '', 0, 1546252114, 1572195253, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (23, 22, 'api', '应用接入', 'dui-icon-apps', '', '_pjax', '', 0, 1546252114, 1572195269, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (24, 23, 'api', '应用分组', 'dui-icon-code', 'api/appgroup/index', '_pjax', '', 0, 1546252114, 1546252114, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (25, 9, 'admin', '新增配置', '', 'admin/config/add', '', '', 0, 1546252114, 1546252114, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (26, 10, 'admin', '新增菜单', '', 'admin/menu/add', '', '', 0, 1546252114, 1546252114, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (27, 19, 'user', '用户栏目', 'dui-icon-user-profile', 'member/profile/index', '_pjax', '', 0, 1565235394, 1572160538, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (28, 18, 'user', '后台团队', 'dui-icon-users', '', '_pjax', '', 0, 1565318306, 1565318306, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (29, 28, 'user', '团队职务', 'dui-icon-job', 'member/role/index', '_pjax', '', 0, 1565318358, 1572160640, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (30, 29, 'user', '编辑职务', '', 'member/role/edit', '_pjax', '', 0, 1565684121, 1565684121, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (31, 23, 'api', '应用列表', 'dui-icon-apps', 'api/app/index', '_pjax', '', 0, 1572172892, 1572177252, 100, 1, '1');
INSERT INTO `dbl_admin_menu` VALUES (32, 22, 'api', '接口设置', 'dui-icon-code', '', '_pjax', '', 0, 1572173703, 1572173703, 100, 0, '1');
INSERT INTO `dbl_admin_menu` VALUES (33, 32, 'api', '接口分组', 'dui-icon-article', 'api/group/index', '_pjax', '', 0, 1572174475, 1572186476, 100, 0, '1');
INSERT INTO `dbl_admin_menu` VALUES (34, 32, 'api', '接口列表', 'dui-icon-article', 'api/index/index', '_pjax', '', 0, 1572174739, 1572189328, 100, 0, '1');
INSERT INTO `dbl_admin_menu` VALUES (35, 24, 'api', '添加应用组', '', 'api/appgroup/add', '_pjax', '', 0, 1572174937, 1572174937, 100, 0, '1');
INSERT INTO `dbl_admin_menu` VALUES (36, 24, 'api', '修改应用组', '', 'api/appgroup/edit', '_pjax', '', 0, 1572175050, 1572175050, 100, 0, '1');
INSERT INTO `dbl_admin_menu` VALUES (37, 24, 'api', '删除应用组', '', 'api/appgroup/delete', '_pjax', '', 0, 1572175704, 1572175704, 100, 0, '1');
INSERT INTO `dbl_admin_menu` VALUES (38, 24, 'api', '启用应用组', '', 'api/appgroup/enable', '_pjax', '', 0, 1572175937, 1572176468, 100, 0, '1');
INSERT INTO `dbl_admin_menu` VALUES (39, 24, 'api', '禁用应用组', '', 'api/appgroup/disable', '_pjax', '', 0, 1572183326, 1572183385, 100, 0, '1');
INSERT INTO `dbl_admin_menu` VALUES (40, 33, 'api', '添加接口组', '', 'api/group/add', '_pjax', '', 0, 1572233532, 1572233532, 100, 0, '1');
INSERT INTO `dbl_admin_menu` VALUES (41, 33, 'api', '修改接口组', '', 'api/group/edit', '_pjax', '', 0, 1572234265, 1572234265, 100, 0, '1');
INSERT INTO `dbl_admin_menu` VALUES (42, 33, 'api', '启用接口组', '', 'api/group/enable', '_pjax', '', 0, 1572234389, 1572234389, 100, 0, '1');
INSERT INTO `dbl_admin_menu` VALUES (43, 33, 'api', '禁用接口组', '', 'api/group/disable', '_pjax', '', 0, 1572234799, 1572234799, 100, 0, '1');
INSERT INTO `dbl_admin_menu` VALUES (44, 33, 'api', '删除接口组', '', 'api/group/delete', '_pjax', '', 0, 1572234828, 1572234828, 100, 0, '1');
INSERT INTO `dbl_admin_menu` VALUES (45, 34, 'api', '添加接口', '', 'api/index/add', '_pjax', '', 0, 1572234887, 1572234887, 100, 0, '1');
INSERT INTO `dbl_admin_menu` VALUES (46, 34, 'api', '修改接口', '', 'api/index/edit', '_pjax', '', 0, 1572241202, 1572241202, 100, 0, '1');
INSERT INTO `dbl_admin_menu` VALUES (47, 34, 'api', '启用接口', '', 'api/index/enable', '_pjax', '', 0, 1572241230, 1572241230, 100, 0, '1');
INSERT INTO `dbl_admin_menu` VALUES (48, 34, 'api', '禁用接口', '', 'api/index/disable', '_pjax', '', 0, 1572241271, 1572241286, 100, 0, '1');
INSERT INTO `dbl_admin_menu` VALUES (49, 34, 'api', '删除接口', '', 'api/index/delete', '_pjax', '', 0, 1572241359, 1572241359, 100, 0, '1');
INSERT INTO `dbl_admin_menu` VALUES (50, 34, 'api', '请求参数列表', '', 'api/fields/request', '_pjax', '', 0, 1572273584, 1572273690, 100, 0, '1');
INSERT INTO `dbl_admin_menu` VALUES (51, 34, 'api', '返回参数列表', '', 'api/fields/response', '_pjax', '', 0, 1572273677, 1572273677, 100, 0, '1');
INSERT INTO `dbl_admin_menu` VALUES (52, 34, 'api', '添加字段', '', 'api/fields/add', '_pjax', '', 0, 1572273723, 1572273723, 100, 0, '1');
INSERT INTO `dbl_admin_menu` VALUES (53, 34, 'api', '修改接口字段', '', 'api/fields/edit', '_pjax', '', 0, 1572273771, 1572273771, 100, 0, '1');
COMMIT;

-- ----------------------------
-- Table structure for dbl_admin_perm
-- ----------------------------
DROP TABLE IF EXISTS `dbl_admin_perm`;
CREATE TABLE `dbl_admin_perm` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(11) NOT NULL COMMENT '用户编号',
  `role_id` int(11) NOT NULL COMMENT '所属角色',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='后台团队表';

-- ----------------------------
-- Records of dbl_admin_perm
-- ----------------------------
BEGIN;
INSERT INTO `dbl_admin_perm` VALUES (1, 1, 1);
INSERT INTO `dbl_admin_perm` VALUES (2, 2, 2);
COMMIT;

-- ----------------------------
-- Table structure for dbl_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `dbl_admin_role`;
CREATE TABLE `dbl_admin_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父组别',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '组名',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `auth` text CHARACTER SET utf8 NOT NULL COMMENT '规则ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `state` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='分组表';

-- ----------------------------
-- Records of dbl_admin_role
-- ----------------------------
BEGIN;
INSERT INTO `dbl_admin_role` VALUES (1, 0, '超级管理员', '这是超级管理员', '', 1544110132, 1544110132, '1');
INSERT INTO `dbl_admin_role` VALUES (2, 1, '门户管理', '这是用户管理员', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"25\",\"10\",\"26\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"27\",\"28\",\"21\",\"29\",\"30\",\"22\",\"23\",\"24\"]', 1565162940, 1565685468, '1');
COMMIT;

-- ----------------------------
-- Table structure for dbl_api_app
-- ----------------------------
DROP TABLE IF EXISTS `dbl_api_app`;
CREATE TABLE `dbl_api_app` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一识别号',
  `name` varchar(50) NOT NULL COMMENT '分组名称',
  `app_group` varchar(30) NOT NULL COMMENT '当前所属分组',
  `app_id` varchar(10) NOT NULL COMMENT '应用id',
  `app_secret` varchar(32) NOT NULL COMMENT '应用密匙',
  `app_api` text COMMENT '包含的api接口',
  `description` varchar(255) NOT NULL COMMENT '应用说明',
  `state` enum('0','1') NOT NULL DEFAULT '0' COMMENT '当前状态',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dbl_api_app
-- ----------------------------
BEGIN;
INSERT INTO `dbl_api_app` VALUES (1, '开发者部落PC端', '5db55dcccdd66', '48375923', 'ea1bdf302647c110c2d2a9d18a2a732f', '[\"5db5c20c9abaa\"]', '这是关于pc端的系列接口', '1', 1572837626, 1572837626);
COMMIT;

-- ----------------------------
-- Table structure for dbl_api_app_group
-- ----------------------------
DROP TABLE IF EXISTS `dbl_api_app_group`;
CREATE TABLE `dbl_api_app_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一识别号',
  `name` varchar(50) NOT NULL COMMENT '分组名称',
  `hash` varchar(36) NOT NULL COMMENT '应用标识',
  `description` varchar(255) NOT NULL COMMENT '分组说明',
  `state` enum('0','1') NOT NULL DEFAULT '0' COMMENT '当前状态',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dbl_api_app_group
-- ----------------------------
BEGIN;
INSERT INTO `dbl_api_app_group` VALUES (1, '开发者部落应用组', '5db55dcccdd66', '这个开发者部落的相关应用', '1', 1572166999, 1572167142);
COMMIT;

-- ----------------------------
-- Table structure for dbl_api_group
-- ----------------------------
DROP TABLE IF EXISTS `dbl_api_group`;
CREATE TABLE `dbl_api_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一识别号',
  `name` varchar(50) NOT NULL COMMENT '分组名称',
  `description` varchar(255) NOT NULL COMMENT '分组说明',
  `hash` varchar(36) NOT NULL COMMENT '应用标识',
  `state` enum('0','1') NOT NULL DEFAULT '0' COMMENT '当前状态',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dbl_api_group
-- ----------------------------
BEGIN;
INSERT INTO `dbl_api_group` VALUES (1, '公共操作', '这是一些公共的接口分组', '5db5c9f554463', '1', 1572194836, 1572194836);
INSERT INTO `dbl_api_group` VALUES (2, '用户中心', '这里是和用户相关的操作api', '5db5aca7b1fbe', '1', 1572187352, 1572187352);
COMMIT;

-- ----------------------------
-- Table structure for dbl_api_list
-- ----------------------------
DROP TABLE IF EXISTS `dbl_api_list`;
CREATE TABLE `dbl_api_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一识别号',
  `name` varchar(50) NOT NULL COMMENT '分组名称',
  `hash` varchar(50) NOT NULL COMMENT '接口映射',
  `method` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0' COMMENT '请求方式0不限，1.post，2为get',
  `api_class` varchar(50) NOT NULL COMMENT 'api访问的真实类库',
  `access_token` enum('0','1','2') NOT NULL DEFAULT '1' COMMENT '0为不认证 1.简单验证，1为复杂验证',
  `user_token` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0则不需要，1为需要',
  `header` text COMMENT '需要传递的header',
  `request_type` enum('form','custom') NOT NULL DEFAULT 'form' COMMENT '请求参数类型',
  `custom_type` enum('application/json','text/html','x-application','application/xml') NOT NULL DEFAULT 'application/json' COMMENT '自定义请求类型',
  `request` text COMMENT '请求参数',
  `success` text COMMENT '成功返回示例',
  `error` text COMMENT '失败返回示例',
  `remark` text COMMENT '注意事项',
  `group_hash` varchar(50) NOT NULL COMMENT '所属组的hash',
  `state` enum('1','2','3','4','5') NOT NULL DEFAULT '1' COMMENT '''1''=>''启用'',\n''2''=>''维护'',\n''3''=>''开发'',\n''4''=>''测试'',\n''5''=>''BUG'',\n',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dbl_api_list
-- ----------------------------
BEGIN;
INSERT INTO `dbl_api_list` VALUES (1, '获取access-token', '5db5c20c9abaa', '1', 'Build/accessToken', '0', '0', NULL, 'form', 'application/json', '[{\"name\":\"app_id\",\"type\":\"1\",\"require\":true,\"default\":\"\",\"remark\":\"应用编号 \",\"example\":\"99124105\",\"options\":\"\"},{\"name\":\"app_secret\",\"type\":\"1\",\"require\":true,\"default\":\"\",\"remark\":\"应用密匙\",\"example\":\"aCmiKGDiBRWivkRsAOkFSWZObtHTMkZF\",\"options\":\"\"},{\"name\":\"device_id\",\"type\":\"1\",\"require\":true,\"default\":\"\",\"remark\":\"设备标识\",\"example\":\"根据不同平台获取\",\"options\":\"\"},{\"name\":\"rand_str\",\"type\":\"1\",\"require\":true,\"default\":\"\",\"remark\":\"随机字符串\",\"example\":\"1453115434\",\"options\":\"\"},{\"name\":\"timestamp\",\"type\":\"1\",\"require\":true,\"default\":\"\",\"remark\":\"当前时间戳13位\",\"example\":\"1572192876000\",\"options\":\"\"}]', '{\r\n    \"code\": 1, \r\n    \"msg\": \"操作成功\", \r\n    \"data\": {\r\n        \"access_token\": \"611683ab0392479e05b56e2182bcd608\", \r\n        \"expires_in\": 7200\r\n    }\r\n}', '{\r\n    \"code\": -1, \r\n    \"msg\": \"获取失败\",\r\n}', NULL, '5db5c9f554463', '1', 1572192876, 1572832662);
COMMIT;

-- ----------------------------
-- Table structure for dbl_common_member
-- ----------------------------
DROP TABLE IF EXISTS `dbl_common_member`;
CREATE TABLE `dbl_common_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '用户名',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `salt` varchar(30) NOT NULL DEFAULT '' COMMENT '密码盐',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别',
  `joinip` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '加入IP',
  `jointime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '加入时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `state` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `email` (`email`),
  KEY `mobile` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='会员表';

-- ----------------------------
-- Records of dbl_common_member
-- ----------------------------
BEGIN;
INSERT INTO `dbl_common_member` VALUES (1, 'admin', 'admin', 'c4031c43ef9e051f7ed9a9cd7d2baa11', 'rpR6Bv', '876771120@qq.com', '15023989265', '', 0, '127.0.0.1', 1491461418, 1491461418, 1516171614, '1');
INSERT INTO `dbl_common_member` VALUES (2, 'a876771120', '印度阿四', '76fae0bc8b0a59b61e0b61c4cf614571', 'F7bAg1', '1053544563@qq.com', '15023989268', '', 0, '', 1565579320, 1565579320, 1565604679, '1');
COMMIT;

-- ----------------------------
-- Table structure for dbl_common_member_log
-- ----------------------------
DROP TABLE IF EXISTS `dbl_common_member_log`;
CREATE TABLE `dbl_common_member_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增',
  `user_id` int(11) NOT NULL COMMENT '用户编号',
  `type` enum('1','2','3','4') CHARACTER SET utf8 NOT NULL COMMENT '日志类型1.登录,2.修改密码,3.修改资料',
  `remark` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '备注',
  `ip` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '访问的ip',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COMMENT='会员操作记录表';

SET FOREIGN_KEY_CHECKS = 1;
