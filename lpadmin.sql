

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ads`
-- ----------------------------
DROP TABLE IF EXISTS `ads`;
CREATE TABLE `ads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ads
-- ----------------------------
INSERT INTO `ads` VALUES ('52', '百度', 'http://www.perf.com/public/uploads/20180122/1516590529874909344.png', 'https://www.baidu.com/', '2018-01-22 11:08:50');

-- ----------------------------
-- Table structure for `auth`
-- ----------------------------
DROP TABLE IF EXISTS `auth`;
CREATE TABLE `auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `nav_ids` varchar(200) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth
-- ----------------------------
INSERT INTO `auth` VALUES ('1', '1', '1,31,65', '2018-02-05 10:28:56');
INSERT INTO `auth` VALUES ('2', '2', '1,31,32,33', '2018-01-17 15:32:15');
INSERT INTO `auth` VALUES ('10', '23', '31', '2018-02-05 11:17:56');

-- ----------------------------
-- Table structure for `banner`
-- ----------------------------
DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `content` text,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of banner
-- ----------------------------
INSERT INTO `banner` VALUES ('51', '2', 'http://admin.wcao.top:8080/public/uploads/20180202/1517554493234465594.jpg', '', '<p>layui 的所有图标全部采用字体形式，取材于阿里巴巴矢量图标库（iconfont）。因此你可以把一个icon看作是一个普通的文字，这意味着你直接用css控制文字属性，如color、font-size，就可以改变图标的颜色和大小。而区分不同的图标，我们主要是采用&nbsp;<em style=\"padding: 0px 3px; color: rgb(102, 102, 102); font-family: \">Unicode</em><span style=\"font-family: \">&nbsp;字符12123</span></p><p><span style=\"font-family: \"><span style=\"font-family: \">通过对一个内联元素（一般推荐用&nbsp;</span><em style=\"padding: 0px 3px; color: rgb(102, 102, 102); font-family: \">i</em><span style=\"font-family: \">标签）设定&nbsp;</span><em style=\"padding: 0px 3px; color: rgb(102, 102, 102); font-family: \">class=&quot;layui-icon&quot;</em><span style=\"font-family: \">，来定义一个图标，然后对元素加上图标对应的&nbsp;</span><em style=\"padding: 0px 3px; color: rgb(102, 102, 102); font-family: \">Unicode</em><span style=\"font-family: \">&nbsp;字符，即可显示出你想要的图标，譬如：</span></span></p><p><span style=\"font-family: \"></span></p><pre class=\"layui-code layui-box layui-code-view\" style=\"margin-top: 10px; margin-bottom: 10px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); white-space: pre-wrap; word-wrap: break-word; box-sizing: content-box; position: relative; line-height: 20px; border-width: 1px 1px 1px 6px; border-style: solid; border-color: rgb(226, 226, 226); border-image: initial; background-color: rgb(242, 242, 242); color: rgb(51, 51, 51); font-family: \">elayui.code&amp;#xe60c;其中的&nbsp;&amp;#xe60c;&nbsp;即是图标对应的Unicode字符你可以去定义它的颜色或者大小</pre>', '2018-02-02 14:55:29');
INSERT INTO `banner` VALUES ('50', '123', 'http://admin.wcao.top:8080/public/uploads/20180202/15175544861963210782.jpg', 'http://www.baidu.com', '<p><img src=\"/ueditor/php/upload/image/20180122/1516609102377776.png\" title=\"1516609102377776.png\"/></p><p><img src=\"/ueditor/php/upload/image/20180122/1516609102696512.png\" title=\"1516609102696512.png\"/></p><p><br/></p>', '2018-02-02 14:55:23');
INSERT INTO `banner` VALUES ('52', '测试2', 'http://admin.wcao.top:8080/public/uploads/20180205/15178167861889041083.jpg', 'http://www.baidu.com', '<p>asdasdasdasd</p>', '2018-02-05 15:46:34');

-- ----------------------------
-- Table structure for `catalog`
-- ----------------------------
DROP TABLE IF EXISTS `catalog`;
CREATE TABLE `catalog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of catalog
-- ----------------------------
INSERT INTO `catalog` VALUES ('8', '0', '商品', '1', '2018-01-19 17:52:28');
INSERT INTO `catalog` VALUES ('11', '9', '女装', '2', '2018-01-19 17:52:56');
INSERT INTO `catalog` VALUES ('12', '9', '童装', '3', '2018-01-19 17:53:03');
INSERT INTO `catalog` VALUES ('9', '8', '服装', '1', '2018-01-19 17:52:37');
INSERT INTO `catalog` VALUES ('10', '9', '男装', '1', '2018-01-19 17:52:47');
INSERT INTO `catalog` VALUES ('13', '10', '男款上衣', '1', '2018-01-19 17:53:24');
INSERT INTO `catalog` VALUES ('14', '10', '男士衬衫', '2', '2018-01-19 17:53:40');
INSERT INTO `catalog` VALUES ('15', '11', '裙装', '1', '2018-01-19 17:53:59');
INSERT INTO `catalog` VALUES ('17', '12', '小学生背带裤', '1', '2018-01-19 17:54:36');
INSERT INTO `catalog` VALUES ('42', '0', '课程分类', '3', '2018-02-05 15:23:38');
INSERT INTO `catalog` VALUES ('43', '42', '语文', '1', '2018-02-05 15:23:47');
INSERT INTO `catalog` VALUES ('44', '42', '数学', '2', '2018-02-05 15:23:54');
INSERT INTO `catalog` VALUES ('45', '43', '小学语文', '1', '2018-02-05 15:24:03');
INSERT INTO `catalog` VALUES ('46', '43', '中学语文', '2', '2018-02-05 15:24:12');

-- ----------------------------
-- Table structure for `link`
-- ----------------------------
DROP TABLE IF EXISTS `link`;
CREATE TABLE `link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of link
-- ----------------------------
INSERT INTO `link` VALUES ('52', '百度', 'http://admin.wcao.top:8080/public/uploads/20180202/151755459267244268.png', 'https://www.baidu.com/', '2018-02-02 14:57:08');

-- ----------------------------
-- Table structure for `manage`
-- ----------------------------
DROP TABLE IF EXISTS `manage`;
CREATE TABLE `manage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `pwd` varchar(50) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_ip` varchar(50) DEFAULT NULL,
  `last_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of manage
-- ----------------------------
INSERT INTO `manage` VALUES ('1', 'admin', '123456', '2', null, null, '2018-02-27 20:19:39', '202.120.19.84', '2018-02-27 18:02:29');
INSERT INTO `manage` VALUES ('18', 'admin1', '1234567', '1', null, null, '2018-01-17 17:30:29', '127.0.0.1', '2018-01-17 10:01:48');
INSERT INTO `manage` VALUES ('19', 'test', '123456', '23', null, null, '2018-02-05 11:18:29', '61.171.221.91', '2018-02-05 11:02:25');

-- ----------------------------
-- Table structure for `menu`
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `controller` varchar(20) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `first` int(11) DEFAULT NULL COMMENT '是否为顶级节点，1：是，0：不是',
  `play` char(10) DEFAULT NULL COMMENT '是否显示,on：显示，off：隐藏',
  `icon` char(50) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', '系统设置', 'Admin', '0', '1', 'on', '614', '2018-02-27 19:08:39');
INSERT INTO `menu` VALUES ('2', '菜单设置', 'Menu', '1', '0', 'on', '630', '2018-01-15 17:18:40');
INSERT INTO `menu` VALUES ('3', '角色设置', 'Role', '1', '0', 'on', '612', '2018-01-15 17:19:01');
INSERT INTO `menu` VALUES ('5', '权限设置', 'Auth', '1', '0', 'on', '857', '2018-01-16 14:47:08');
INSERT INTO `menu` VALUES ('4', '后台账号', 'Manage', '1', '0', 'on', '613', '2018-01-22 16:31:03');
INSERT INTO `menu` VALUES ('31', '全局设置', '', '0', '1', 'on', '705', '2018-02-27 17:53:55');
INSERT INTO `menu` VALUES ('33', 'Banner', 'Banner', '31', '0', 'on', '634', '2018-02-05 15:10:24');
INSERT INTO `menu` VALUES ('32', '全局分类', 'Catalog', '31', '0', 'on', '624', '2018-02-05 15:10:21');
INSERT INTO `menu` VALUES ('36', '广告设置', 'Ads', '31', '0', 'on', '638', '2018-01-19 10:49:11');
INSERT INTO `menu` VALUES ('38', '友情链接', 'Link', '31', '0', 'on', '63a', '2018-01-23 12:01:06');

-- ----------------------------
-- Table structure for `role`
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES ('1', '管理员', '2018-01-17 17:28:20');
INSERT INTO `role` VALUES ('2', '超级管理员', '2018-01-15 17:55:39');
INSERT INTO `role` VALUES ('23', '测试账号', '2018-02-05 11:17:48');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `sex` int(11) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('3', '李雷', '1', '15618509453', '2017-09-21 14:41:08');
INSERT INTO `user` VALUES ('4', '测试', '2', '15618509453', '2017-09-21 14:42:53');
INSERT INTO `user` VALUES ('5', '123', '1', '15000137707', '2017-09-22 10:06:24');
