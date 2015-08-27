-- MySQL dump 10.13  Distrib 5.6.19, for osx10.7 (i386)
--
-- Host: 127.0.0.1    Database: ezstory
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
-- Table structure for table `ez_post_twitter`
--

DROP TABLE IF EXISTS `ez_post_twitter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ez_post_twitter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `post_twitter_uid_idx` (`uid`),
  CONSTRAINT `post_twitter_uid` FOREIGN KEY (`uid`) REFERENCES `ez_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ez_post_twitter`
--

LOCK TABLES `ez_post_twitter` WRITE;
/*!40000 ALTER TABLE `ez_post_twitter` DISABLE KEYS */;
INSERT INTO `ez_post_twitter` VALUES (2,1,'as dsa da','2015-08-26 23:13:04','2015-08-26 23:13:04',0),(3,1,'hehehe','2015-08-26 23:41:34','2015-08-26 23:41:34',0),(4,1,'This is test1','2015-08-26 23:45:45','2015-08-26 23:45:45',0),(5,1,'This is test2','2015-08-26 23:47:52','2015-08-26 23:47:52',0),(6,1,'this is test 3','2015-08-26 23:51:36','2015-08-26 23:51:36',0),(7,1,'this is test 3','2015-08-26 23:52:16','2015-08-26 23:52:16',0);
/*!40000 ALTER TABLE `ez_post_twitter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ez_post_wordpress`
--

DROP TABLE IF EXISTS `ez_post_wordpress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ez_post_wordpress` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `post_blog_uid_idx` (`uid`),
  CONSTRAINT `post_blog_uid` FOREIGN KEY (`uid`) REFERENCES `ez_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ez_post_wordpress`
--

LOCK TABLES `ez_post_wordpress` WRITE;
/*!40000 ALTER TABLE `ez_post_wordpress` DISABLE KEYS */;
INSERT INTO `ez_post_wordpress` VALUES (1,1,'This is test2',NULL,'2015-08-26 23:47:51','2015-08-26 23:47:51',0),(2,1,'this is test 3',NULL,'2015-08-26 23:51:36','2015-08-26 23:51:36',0),(3,1,'this is test 3','<p>this is test 3 content</p>','2015-08-26 23:52:16','2015-08-26 23:52:16',0);
/*!40000 ALTER TABLE `ez_post_wordpress` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ez_twitter`
--

LOCK TABLES `ez_twitter` WRITE;
/*!40000 ALTER TABLE `ez_twitter` DISABLE KEYS */;
INSERT INTO `ez_twitter` VALUES (5,1,'2872411641','zoclezhe123','http://pbs.twimg.com/profile_images/532201283004813314/lwDmr-rD_normal.jpeg','2872411641-kvIVSn0I5Tp6wIspvAzx7o7RFr2prEgZmn1gI4k','YJd0tlAYyuFwkyTBqyd8tx4VbjpPvpKFj1WWqV8Qi18Re','2015-06-02 22:30:30','2015-06-02 22:31:30',0),(6,1,'438198895','zhexiao27','http://pbs.twimg.com/profile_images/549956842181246977/TvHZE9_c_normal.jpeg','438198895-ZZC6lY6car7OOp2V05ScyaGEOazKMrtcJzucJTWv','Js5gIU6y9POPdvKxowAJe7IENN4vHKbTIOggsNNC4njsz','2015-08-14 00:39:02','2015-08-14 00:39:02',0);
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

--
-- Table structure for table `ez_wordpress`
--

DROP TABLE IF EXISTS `ez_wordpress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ez_wordpress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `delete` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `wordpress_uid_idx` (`uid`),
  CONSTRAINT `wordpress_uid` FOREIGN KEY (`uid`) REFERENCES `ez_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ez_wordpress`
--

LOCK TABLES `ez_wordpress` WRITE;
/*!40000 ALTER TABLE `ez_wordpress` DISABLE KEYS */;
INSERT INTO `ez_wordpress` VALUES (3,1,'zocle','aW50ZXJ0ZWNoMDE=','zocle itm','http://zocle.itmwpb.com/','2015-08-03 22:40:22','2015-08-03 22:40:22',0),(4,1,'zocle','aW50ZXJ0ZWNoMDE=','zocle itm 1','http://zocle.itmwpb.com/','2015-08-03 22:41:39','2015-08-03 22:41:39',0),(5,1,'zocle','aW50ZXJ0ZWNoMDE=','zocle itm 2','http://zocle.itmwpb.com/','2015-08-03 22:43:00','2015-08-03 22:43:00',0),(6,1,'zocle','aW50ZXJ0ZWNoMDE=','zocle itm 3','http://zocle.itmwpb.com/','2015-08-03 22:43:32','2015-08-03 22:43:32',0);
/*!40000 ALTER TABLE `ez_wordpress` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-08-26 23:53:04
