-- MySQL dump 10.13  Distrib 5.6.23, for Win64 (x86_64)
--
-- Host: localhost    Database: ezstory
-- ------------------------------------------------------
-- Server version	5.6.21

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
-- Table structure for table `ez_instagram`
--

DROP TABLE IF EXISTS `ez_instagram`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ez_instagram` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned DEFAULT NULL,
  `instagram_id` int(10) unsigned DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `access_token` text,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uid_idx` (`uid`),
  CONSTRAINT `instagram_uid` FOREIGN KEY (`uid`) REFERENCES `ez_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ez_instagram`
--

LOCK TABLES `ez_instagram` WRITE;
/*!40000 ALTER TABLE `ez_instagram` DISABLE KEYS */;
INSERT INTO `ez_instagram` VALUES (1,1,305096535,'zhexiao27','Zhe Xiao','https://igcdn-photos-e-a.akamaihd.net/hphotos-ak-xap1/t51.2885-19/10903566_326384917568780_109872916_a.jpg','305096535.3bd4a77.7e1ce8cf204446b98d38aa2d7c4cd75f','2015-06-05 13:34:12','2015-06-05 13:35:19',NULL);
/*!40000 ALTER TABLE `ez_instagram` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ez_twitter`
--

DROP TABLE IF EXISTS `ez_twitter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ez_twitter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned DEFAULT NULL,
  `id_str` varchar(30) DEFAULT NULL,
  `screen_name` varchar(100) DEFAULT NULL,
  `profile_image_url` varchar(200) DEFAULT NULL,
  `auth_token` text,
  `auth_secret` text,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uid_idx` (`uid`),
  CONSTRAINT `twitter_uid` FOREIGN KEY (`uid`) REFERENCES `ez_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ez_twitter`
--

LOCK TABLES `ez_twitter` WRITE;
/*!40000 ALTER TABLE `ez_twitter` DISABLE KEYS */;
INSERT INTO `ez_twitter` VALUES (5,1,'2872411641','zoclezhe123','http://pbs.twimg.com/profile_images/532201283004813314/lwDmr-rD_normal.jpeg','2872411641-kvIVSn0I5Tp6wIspvAzx7o7RFr2prEgZmn1gI4k','YJd0tlAYyuFwkyTBqyd8tx4VbjpPvpKFj1WWqV8Qi18Re','2015-06-02 22:30:30','2015-06-02 22:31:30',0);
/*!40000 ALTER TABLE `ez_twitter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ez_user`
--

DROP TABLE IF EXISTS `ez_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ez_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ez_user`
--

LOCK TABLES `ez_user` WRITE;
/*!40000 ALTER TABLE `ez_user` DISABLE KEYS */;
INSERT INTO `ez_user` VALUES (1,'zhexiao','31efe5c727df3e9f116cd46fbb5b2626','zhexiao@163.com',NULL,NULL,0);
/*!40000 ALTER TABLE `ez_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-06-05 15:37:44
