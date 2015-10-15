/*
SQLyog 企业版 - MySQL GUI v8.14 
MySQL - 5.6.24 : Database - bus_wifidb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bus_wifidb` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `bus_wifidb`;

/*Table structure for table `think_activity` */

DROP TABLE IF EXISTS `think_activity`;

CREATE TABLE `think_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `line_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_activity_think_line1_idx` (`line_id`),
  CONSTRAINT `fk_activity_think_line1` FOREIGN KEY (`line_id`) REFERENCES `think_line` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `think_activity` */

/*Table structure for table `think_ad` */

DROP TABLE IF EXISTS `think_ad`;

CREATE TABLE `think_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `click_num` int(11) DEFAULT NULL,
  `text` varchar(45) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `line_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Data for the table `think_ad` */

insert  into `think_ad`(`id`,`click_num`,`text`,`type`,`line_id`) values (1,125,'青岛啤酒',38,38),(2,354,'可口可乐',38,38),(3,657,'肯德基',38,38),(4,619,'麦当劳',38,38),(5,543,'汉丽轩',38,38),(6,863,'极地海洋世界',38,38),(7,325,'大家乐KTV',35,35),(8,256,'金逸电影',35,35),(9,156,'桌球吧',35,35),(10,432,'如家酒店',35,35),(11,351,'王姐烧烤',35,35),(12,258,'粥全粥到',35,35),(13,156,'郑庄脂渣',36,36),(14,86,'星巴克',36,36),(15,153,'丹香',36,36),(16,254,'船歌鱼水饺',36,36),(17,178,'有家烤吧',36,36),(18,345,'沙宣美发',36,36),(19,578,'大润发',37,37),(20,97,'新华药房',37,37),(21,610,'嘉年华',37,37),(22,254,'圣瓦伦丁',37,37),(23,420,'芳子美容',37,37),(24,245,'巴西烤肉',37,37);

/*Table structure for table `think_admin` */

DROP TABLE IF EXISTS `think_admin`;

CREATE TABLE `think_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `pwd` varchar(45) DEFAULT NULL,
  `title` varchar(45) DEFAULT NULL,
  `tel` varchar(45) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `content` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `url` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `think_admin` */

insert  into `think_admin`(`id`,`name`,`pwd`,`title`,`tel`,`time`,`content`,`email`,`url`,`status`,`type`) values (1,'admin','c4ca4238a0b923820dcc509a6f75849b',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Super'),(2,'test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Low');

/*Table structure for table `think_bus` */

DROP TABLE IF EXISTS `think_bus`;

CREATE TABLE `think_bus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position_x` double DEFAULT NULL,
  `position_y` double DEFAULT NULL,
  `no` varchar(45) DEFAULT NULL,
  `line_id` int(11) NOT NULL,
  `online_num` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_think_bus_think_line_idx` (`line_id`),
  CONSTRAINT `fk_think_bus_think_line` FOREIGN KEY (`line_id`) REFERENCES `think_line` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

/*Data for the table `think_bus` */

insert  into `think_bus`(`id`,`position_x`,`position_y`,`no`,`line_id`,`online_num`) values (41,120.24031066894531,36.05568313598633,'鲁B2156',35,NULL),(42,120.00491333007812,35.877262115478516,'鲁B2534',35,NULL),(43,120.17896270751953,36.01848602294922,'鲁B8965',35,NULL),(44,120.17222595214844,35.98093795776367,'鲁B3254',35,NULL),(45,120.19880676269531,35.96189498901367,'鲁B5875',35,NULL),(46,120.2171401977539,35.96574783325195,'鲁B9862',35,NULL),(47,120.23513793945312,35.97136306762695,'鲁B1254',35,NULL),(48,120.24031066894531,36.05568313598633,'鲁B2523',36,NULL),(49,120.17222595214844,35.98093795776367,'鲁B6641',36,NULL),(50,120.2171401977539,35.96574783325195,'鲁B6354',36,NULL),(51,120.19880676269531,35.96189498901367,'鲁B8756',36,NULL),(52,120.17924499511719,35.970550537109375,'鲁B9862',36,NULL),(53,120.25094604492188,35.9661865234375,'鲁B3574',36,NULL),(54,120.2171401977539,35.96574783325195,'鲁B5241',37,NULL),(55,120.198808,35.966188,'鲁B3568',37,NULL),(56,120.191441,35.958657,'鲁B5486',37,NULL),(57,120.295569,35.995049,'鲁B6587',37,NULL),(58,120.132005,35.923543,'鲁B2154',37,NULL),(59,120.093147,36.098653,'鲁B5847',38,NULL),(60,120.198808,35.961895,'鲁B6241',38,NULL),(61,120.178963,36.018485,'鲁B5487',38,NULL);

/*Table structure for table `think_command` */

DROP TABLE IF EXISTS `think_command`;

CREATE TABLE `think_command` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cmd` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `device_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_think_command_think_device1_idx` (`device_id`),
  CONSTRAINT `fk_think_command_think_device1` FOREIGN KEY (`device_id`) REFERENCES `think_device` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `think_command` */

/*Table structure for table `think_device` */

DROP TABLE IF EXISTS `think_device`;

CREATE TABLE `think_device` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mac` varchar(45) DEFAULT NULL,
  `useage` varchar(45) DEFAULT NULL,
  `time` varchar(45) DEFAULT NULL,
  `ssid` varchar(45) DEFAULT NULL,
  `firmware` varchar(45) DEFAULT NULL,
  `content` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `bus_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_think_device_think_bus1_idx` (`bus_id`),
  CONSTRAINT `fk_think_device_think_bus1` FOREIGN KEY (`bus_id`) REFERENCES `think_bus` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

/*Data for the table `think_device` */

insert  into `think_device`(`id`,`mac`,`useage`,`time`,`ssid`,`firmware`,`content`,`status`,`bus_id`) values (37,'0e:60:55:f3:3d:0a',NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `think_device_ad` */

DROP TABLE IF EXISTS `think_device_ad`;

CREATE TABLE `think_device_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) DEFAULT NULL,
  `ad_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_think_device_has_think_ad_think_ad1_idx` (`ad_id`),
  KEY `fk_think_device_has_think_ad_think_device1_idx` (`device_id`),
  CONSTRAINT `fk_think_device_has_think_ad_think_ad1` FOREIGN KEY (`ad_id`) REFERENCES `think_ad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_think_device_has_think_ad_think_device1` FOREIGN KEY (`device_id`) REFERENCES `think_device` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `think_device_ad` */

/*Table structure for table `think_device_media` */

DROP TABLE IF EXISTS `think_device_media`;

CREATE TABLE `think_device_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) DEFAULT NULL,
  `media_id` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `think_device_media` */

/*Table structure for table `think_line` */

DROP TABLE IF EXISTS `think_line`;

CREATE TABLE `think_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

/*Data for the table `think_line` */

insert  into `think_line`(`id`,`name`) values (36,'开发区18路'),(35,'开发区1路'),(38,'开发区26路'),(37,'开发区4路');

/*Table structure for table `think_manage` */

DROP TABLE IF EXISTS `think_manage`;

CREATE TABLE `think_manage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(1) DEFAULT NULL,
  `keywords` char(1) DEFAULT NULL,
  `description` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `think_manage` */

insert  into `think_manage`(`id`,`title`,`keywords`,`description`) values (1,'a','q','z');

/*Table structure for table `think_media` */

DROP TABLE IF EXISTS `think_media`;

CREATE TABLE `think_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(45) DEFAULT NULL,
  `describle` varchar(45) DEFAULT NULL,
  `click_num` int(10) unsigned zerofill DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT '1:图片\n2:文字\n3:视频',
  `admin_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_think_media_think_admin1_idx` (`admin_id`),
  CONSTRAINT `fk_think_media_think_admin1` FOREIGN KEY (`admin_id`) REFERENCES `think_admin` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `think_media` */

insert  into `think_media`(`id`,`url`,`describle`,`click_num`,`type`,`admin_id`) values (2,'2015091811185147293.jpg','图片文件',0000000000,NULL,1),(3,'2015091815041366159.jpg','',0000000000,1,1),(4,'2015091815425658709.','',0000000000,3,1),(5,'2015091815453552658.rmvb','',0000000000,3,1),(6,'2015091815585413073.txt','',0000000000,2,1),(7,'D:\\xampp\\htdocs\\WifiBus\\ThinkPHP/upload/image','',0000000010,1,1),(8,'./Application/upload/text/2015091820015438858','',0000000000,2,1),(9,'./upload/video/2015091820024990386.mp4','',0000000000,3,1);

/*Table structure for table `think_message` */

DROP TABLE IF EXISTS `think_message`;

CREATE TABLE `think_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` varchar(45) DEFAULT NULL,
  `text` varchar(45) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_think_message_think_user1_idx` (`user_id`),
  CONSTRAINT `fk_think_message_think_user1` FOREIGN KEY (`user_id`) REFERENCES `think_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `think_message` */

/*Table structure for table `think_property` */

DROP TABLE IF EXISTS `think_property`;

CREATE TABLE `think_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` float DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `line_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_property_think_line1_idx` (`line_id`),
  CONSTRAINT `fk_property_think_line1` FOREIGN KEY (`line_id`) REFERENCES `think_line` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `think_property` */

/*Table structure for table `think_user` */

DROP TABLE IF EXISTS `think_user`;

CREATE TABLE `think_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tel` varchar(45) DEFAULT NULL,
  `pwd` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `think_user` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
