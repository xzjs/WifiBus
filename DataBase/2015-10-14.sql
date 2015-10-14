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
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bus_wifidb` /*!40100 DEFAULT CHARACTER SET utf8 */;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `think_ad` */

insert  into `think_ad`(`id`,`click_num`,`text`,`type`) values (1,10,'是的范德萨发给',1),(2,0,'视频',3),(3,0,'图片',2),(4,0,'',0);

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
  `position_x` float DEFAULT NULL,
  `position_y` float DEFAULT NULL,
  `no` varchar(45) DEFAULT NULL,
  `line_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_think_bus_think_line_idx` (`line_id`),
  CONSTRAINT `fk_think_bus_think_line` FOREIGN KEY (`line_id`) REFERENCES `think_line` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

/*Data for the table `think_bus` */

insert  into `think_bus`(`id`,`position_x`,`position_y`,`no`,`line_id`) values (1,16,23,'鲁B0004',1),(2,16,66,'鲁B0005',1),(3,0,0,'鲁B0001',2),(4,0,0,'鲁B0002',3),(27,NULL,NULL,'鲁B0007',29),(28,NULL,NULL,'鲁B0008',29),(29,NULL,NULL,'鲁B0009',30),(30,NULL,NULL,'鲁B00010',31),(31,NULL,NULL,'鲁B00011',31),(32,NULL,NULL,'鲁B00012',33),(33,NULL,NULL,'鲁B00013',34);

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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

/*Data for the table `think_device` */

insert  into `think_device`(`id`,`mac`,`useage`,`time`,`ssid`,`firmware`,`content`,`status`,`bus_id`) values (5,'1','','','test1','','',0,1),(6,'2','','','qaii','','',0,2),(30,'555555555555',NULL,NULL,NULL,NULL,NULL,NULL,27),(31,'555555555554',NULL,NULL,NULL,NULL,NULL,NULL,28),(32,'555555555553',NULL,NULL,NULL,NULL,NULL,NULL,29),(33,'555555555556',NULL,NULL,NULL,NULL,NULL,NULL,31),(34,'555555555557',NULL,NULL,NULL,NULL,NULL,NULL,30),(35,'10',NULL,NULL,NULL,NULL,NULL,NULL,32),(36,'11',NULL,NULL,NULL,NULL,NULL,NULL,33);

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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

/*Data for the table `think_line` */

insert  into `think_line`(`id`,`name`) values (1,'1路'),(2,'2路'),(3,'3路'),(29,'4路'),(30,'5路'),(31,'6路'),(32,'7路'),(33,'8路'),(34,'9路');

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
