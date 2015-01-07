# Sequel Pro dump
# Version 2210
# http://code.google.com/p/sequel-pro
#
# Host: 127.0.0.1 (MySQL 5.1.63-lucky9805)
# Database: db
# Generation Time: 2013-05-17 02:21:16 +0000
# ************************************************************

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table articles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `articles`;

CREATE TABLE `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` text,
  `picurl` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `type` enum('text','news','extern_request') DEFAULT 'text',
  `keyword` varchar(200) DEFAULT NULL,
  `keyword_type` enum('startwith','equals') DEFAULT 'equals',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` (`id`,`title`,`description`,`picurl`,`url`,`type`,`keyword`,`keyword_type`)
VALUES
	(1,'welcome','欢迎大家访问hxknows 我们致力打造最好的服务。',NULL,NULL,'news','who','equals'),
	(2,'help','您可以输入以下信息来获取我们的帮助：\nhelp  获取帮助\n知乎 当前知乎日报最热5条信息\n#write#记事内容 可以用来记录你当前想法\n #list# 列举出你的当前笔记记录\n#delete# 删除你的当前笔记记录\n #跟踪 进城or返乡 公交车名 所在站点 可以查看当前公交信息','','','text','?','equals'),
  (3,'zhihu','no use',NULL,'http://news-at.zhihu.com/api/3/news/latest','extern_request','知乎','equals'),
	(4,'help','您可以输入以下信息来获取我们的帮助：\nhelp  获取帮助\n知乎 当前知乎日报最热5条信息\n#write#记事内容 可以用来记录你当前想法\n #list# 列举出你的当前笔记记录\n#delete# 删除你的当前笔记记录',NULL,NULL,'text','help','equals'),
  (5,'write_notes','记录笔记成功!','','','text','#记录','startwith'),
  (6,'list_notes','您的笔记如下：','','','text','#列表','startwith'),
  (7,'remove_notes','您的笔记已经删除!','','','text','#删除','startwith'),
  (8,'trace_bus','no use','','','text','#跟踪','startwith');

/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(32) DEFAULT NULL,
  `content` text,
  `time_created` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump of table notes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `notes`;

CREATE TABLE `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(32) DEFAULT NULL,
  `content` text,
  `time_created` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# Dump of table sj
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sj`;

CREATE TABLE `sj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `wxid` varchar(50) DEFAULT NULL,
  `x` varchar(50) DEFAULT NULL,
  `y` varchar(50) DEFAULT NULL,
  `status` int(11) unsigned DEFAULT '1',
  `sf` int(11) DEFAULT '0',
  `dq` int(11) DEFAULT NULL,
  `telphone` varchar(13) DEFAULT NULL,
  `dz` varchar(200) DEFAULT NULL,
  `last_update` int(11) DEFAULT '0',
  `cphm` varchar(11) DEFAULT NULL,
  `bz` varchar(500) DEFAULT NULL,
  `sq` int(11) DEFAULT '0',
  `createtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;


/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
