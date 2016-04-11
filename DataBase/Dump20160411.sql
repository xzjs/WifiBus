-- MySQL dump 10.13  Distrib 5.6.24, for osx10.8 (x86_64)
--
-- Host: 192.168.4.97    Database: bus_wifidb
-- ------------------------------------------------------
-- Server version	5.1.73

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `think_ footmark`
--

DROP TABLE IF EXISTS `think_ footmark`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_ footmark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_mac` varchar(45) DEFAULT NULL COMMENT '设置mac',
  `user_mac` varchar(45) DEFAULT NULL COMMENT '用户mac',
  `domain_name` varchar(45) DEFAULT NULL COMMENT '域名',
  `url` varchar(45) DEFAULT NULL COMMENT '网址',
  `time` int(11) DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `think_activity`
--

DROP TABLE IF EXISTS `think_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `line_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_activity_think_line1_idx` (`line_id`),
  CONSTRAINT `fk_activity_think_line1` FOREIGN KEY (`line_id`) REFERENCES `think_line` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `think_admin`
--

DROP TABLE IF EXISTS `think_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `think_bus`
--

DROP TABLE IF EXISTS `think_bus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_bus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position_x` double DEFAULT NULL,
  `position_y` double DEFAULT NULL,
  `no` varchar(45) DEFAULT NULL,
  `line_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_think_bus_think_line_idx` (`line_id`),
  CONSTRAINT `fk_think_bus_think_line` FOREIGN KEY (`line_id`) REFERENCES `think_line` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `think_command`
--

DROP TABLE IF EXISTS `think_command`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_command` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cmd` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `device_id` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `arg` text COMMENT '参数',
  `return_arg` text COMMENT '返回参数',
  PRIMARY KEY (`id`),
  KEY `fk_think_command_think_device1_idx` (`device_id`),
  CONSTRAINT `fk_think_command_think_device1` FOREIGN KEY (`device_id`) REFERENCES `think_device` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=59775 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `think_device`
--

DROP TABLE IF EXISTS `think_device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_device` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mac` varchar(45) DEFAULT NULL COMMENT '设备mac',
  `useage` varchar(45) DEFAULT NULL COMMENT '磁盘使用率',
  `time` int(11) DEFAULT NULL COMMENT '心跳时间',
  `ssid` varchar(45) DEFAULT NULL COMMENT '设备ssid',
  `firmware` varchar(45) DEFAULT NULL COMMENT '设备固件版本',
  `content` varchar(45) DEFAULT NULL COMMENT '设备内容版本',
  `status` int(11) DEFAULT NULL COMMENT '设备状态',
  `bus_id` int(11) DEFAULT NULL COMMENT '车辆id',
  `online_num` int(11) DEFAULT NULL COMMENT '在线人数',
  `flow_num` double DEFAULT NULL COMMENT '已使用的流量',
  `network_limit` int(11) DEFAULT NULL COMMENT '网速上限',
  `debug` tinyint(1) DEFAULT '0' COMMENT '是否需要调试（1是，0否）（0才需要重启）',
  PRIMARY KEY (`id`),
  KEY `fk_think_device_think_bus1_idx` (`bus_id`),
  CONSTRAINT `fk_think_device_think_bus1` FOREIGN KEY (`bus_id`) REFERENCES `think_bus` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `think_device_media`
--

DROP TABLE IF EXISTS `think_device_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_device_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) DEFAULT NULL COMMENT '设备id',
  `media_id` int(11) DEFAULT NULL COMMENT '媒体id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `think_flow`
--

DROP TABLE IF EXISTS `think_flow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_flow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` double DEFAULT NULL COMMENT '使用流量',
  `device_id` int(11) DEFAULT NULL COMMENT '设备id',
  `time` int(11) DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2287 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `think_line`
--

DROP TABLE IF EXISTS `think_line`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL COMMENT '线路名称',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `think_log`
--

DROP TABLE IF EXISTS `think_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `mac` varchar(45) DEFAULT NULL COMMENT '设备mac',
  `lon` double DEFAULT NULL COMMENT '经度',
  `lat` double DEFAULT NULL COMMENT '纬度',
  `online_num` int(11) DEFAULT NULL COMMENT '在线人数',
  `usage` double DEFAULT NULL COMMENT '磁盘使用率',
  `flow_num` double DEFAULT NULL COMMENT '流量',
  `cmd` int(11) DEFAULT NULL COMMENT '执行命令号',
  `arg` varchar(45) DEFAULT NULL COMMENT '回传参数',
  `heartbeat` int(11) DEFAULT NULL COMMENT '心跳版本号',
  `time` int(11) DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=452 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `think_manage`
--

DROP TABLE IF EXISTS `think_manage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_manage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(1) DEFAULT NULL,
  `keywords` char(1) DEFAULT NULL,
  `description` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `think_media`
--

DROP TABLE IF EXISTS `think_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(45) DEFAULT NULL COMMENT '文件地址',
  `img` varchar(45) DEFAULT NULL COMMENT '图片地址',
  `text` varchar(45) DEFAULT NULL COMMENT '文字简介',
  `type` int(11) DEFAULT NULL COMMENT '1广告\n2电影\n3电子书\n4APP',
  `position` varchar(45) DEFAULT NULL COMMENT '位置\n广告ad1，ad2,ad3,ad4,ad5,ad6\n电影movie1,movie2,movie3,……movie8\n电子书txt1，……txt4\nAPP app1……app4\n',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `think_mediaclick`
--

DROP TABLE IF EXISTS `think_mediaclick`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_mediaclick` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `media_id` int(11) DEFAULT NULL COMMENT '媒体id',
  `click_num` int(11) DEFAULT NULL COMMENT '点击数',
  `time` int(11) DEFAULT NULL COMMENT '时间',
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `think_message`
--

DROP TABLE IF EXISTS `think_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` varchar(45) DEFAULT NULL,
  `text` varchar(45) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_think_message_think_user1_idx` (`user_id`),
  CONSTRAINT `fk_think_message_think_user1` FOREIGN KEY (`user_id`) REFERENCES `think_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `think_property`
--

DROP TABLE IF EXISTS `think_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` float DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `line_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_property_think_line1_idx` (`line_id`),
  CONSTRAINT `fk_property_think_line1` FOREIGN KEY (`line_id`) REFERENCES `think_line` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `think_user`
--

DROP TABLE IF EXISTS `think_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tel` varchar(45) DEFAULT NULL,
  `pwd` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `think_wifidoglog`
--

DROP TABLE IF EXISTS `think_wifidoglog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_wifidoglog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mac` varchar(45) DEFAULT NULL COMMENT '手机mac',
  `time` int(11) DEFAULT NULL COMMENT '认证时间',
  `date` date DEFAULT NULL COMMENT 'test',
  `is_back` int(2) DEFAULT '0' COMMENT '1是0否',
  `device_mac` varchar(45) DEFAULT NULL COMMENT '设备mac',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=120980 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-11  9:57:43
