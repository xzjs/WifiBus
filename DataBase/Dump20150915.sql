-- MySQL dump 10.13  Distrib 5.6.24, for osx10.8 (x86_64)
--
-- Host: localhost    Database: bus_wifidb
-- ------------------------------------------------------
-- Server version	5.5.42

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
-- Dumping data for table `think_activity`
--

LOCK TABLES `think_activity` WRITE;
/*!40000 ALTER TABLE `think_activity` DISABLE KEYS */;
/*!40000 ALTER TABLE `think_activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `think_ad`
--

DROP TABLE IF EXISTS `think_ad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `click_num` int(11) DEFAULT NULL,
  `text` varchar(45) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `think_ad`
--

LOCK TABLES `think_ad` WRITE;
/*!40000 ALTER TABLE `think_ad` DISABLE KEYS */;
/*!40000 ALTER TABLE `think_ad` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `think_admin`
--

LOCK TABLES `think_admin` WRITE;
/*!40000 ALTER TABLE `think_admin` DISABLE KEYS */;
INSERT INTO `think_admin` VALUES (1,'admin','c4ca4238a0b923820dcc509a6f75849b',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Super');
/*!40000 ALTER TABLE `think_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `think_bus`
--

DROP TABLE IF EXISTS `think_bus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_bus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position_x` float DEFAULT NULL,
  `position_y` float DEFAULT NULL,
  `no` varchar(45) DEFAULT NULL,
  `line_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_think_bus_think_line_idx` (`line_id`),
  CONSTRAINT `fk_think_bus_think_line` FOREIGN KEY (`line_id`) REFERENCES `think_line` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `think_bus`
--

LOCK TABLES `think_bus` WRITE;
/*!40000 ALTER TABLE `think_bus` DISABLE KEYS */;
/*!40000 ALTER TABLE `think_bus` ENABLE KEYS */;
UNLOCK TABLES;

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
  `device_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_think_command_think_device1_idx` (`device_id`),
  CONSTRAINT `fk_think_command_think_device1` FOREIGN KEY (`device_id`) REFERENCES `think_device` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `think_command`
--

LOCK TABLES `think_command` WRITE;
/*!40000 ALTER TABLE `think_command` DISABLE KEYS */;
/*!40000 ALTER TABLE `think_command` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `think_device`
--

DROP TABLE IF EXISTS `think_device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `think_device`
--

LOCK TABLES `think_device` WRITE;
/*!40000 ALTER TABLE `think_device` DISABLE KEYS */;
/*!40000 ALTER TABLE `think_device` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `think_device_ad`
--

DROP TABLE IF EXISTS `think_device_ad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `think_device_ad`
--

LOCK TABLES `think_device_ad` WRITE;
/*!40000 ALTER TABLE `think_device_ad` DISABLE KEYS */;
/*!40000 ALTER TABLE `think_device_ad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `think_line`
--

DROP TABLE IF EXISTS `think_line`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `think_line`
--

LOCK TABLES `think_line` WRITE;
/*!40000 ALTER TABLE `think_line` DISABLE KEYS */;
/*!40000 ALTER TABLE `think_line` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `think_media`
--

DROP TABLE IF EXISTS `think_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `think_media`
--

LOCK TABLES `think_media` WRITE;
/*!40000 ALTER TABLE `think_media` DISABLE KEYS */;
/*!40000 ALTER TABLE `think_media` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `think_message`
--

LOCK TABLES `think_message` WRITE;
/*!40000 ALTER TABLE `think_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `think_message` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `think_property`
--

LOCK TABLES `think_property` WRITE;
/*!40000 ALTER TABLE `think_property` DISABLE KEYS */;
/*!40000 ALTER TABLE `think_property` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `think_user`
--

LOCK TABLES `think_user` WRITE;
/*!40000 ALTER TABLE `think_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `think_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-09-15 19:00:00
