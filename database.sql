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
-- Table structure for table `ez_twitter`
--

DROP TABLE IF EXISTS `ez_twitter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ez_twitter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned DEFAULT NULL,
  `screen_name` varchar(100) DEFAULT NULL,
  `profile_image_url` varchar(200) DEFAULT NULL,
  `auth_token` text,
  `auth_secret` text,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ez_twitter`
--

LOCK TABLES `ez_twitter` WRITE;
/*!40000 ALTER TABLE `ez_twitter` DISABLE KEYS */;
INSERT INTO `ez_twitter` VALUES (1,1,'zhexiao27','http://pbs.twimg.com/profile_images/549956842181246977/TvHZE9_c_normal.jpeg','CeCu5PWzBCU29evEmuR5CkokdduRjvxZ','su0PY3ODFZMoDbgKEvQxjfQbW1hHlqnR','0000-00-00 00:00:00','2015-05-28 00:00:00'),(2,1,'zhexiao27','http://pbs.twimg.com/profile_images/549956842181246977/TvHZE9_c_normal.jpeg','s42WLFbMVHwKaYbGNYxNmJSBVqDuMQzj','KpBqpMKvifO5AQH15dp2sYPKQ2bEgcHo','0000-00-00 00:00:00','2015-05-28 00:00:00'),(3,1,'zhexiao27','http://pbs.twimg.com/profile_images/549956842181246977/TvHZE9_c_normal.jpeg','hU0ocT8cueDDrAXbF1J6QIsYqAYc6KZj','vuLFSKTyMUzu3hItBIWIuco7jzIMXZGc','0000-00-00 00:00:00','2015-05-28 00:00:00'),(4,1,'zhexiao27','http://pbs.twimg.com/profile_images/549956842181246977/TvHZE9_c_normal.jpeg','KEep2IjTQdDdFy2HRuZKH9j63yBflu8K','SGtBFjLmN2LPltHe6FOHRKSSYoT44f8h','0000-00-00 00:00:00','2015-05-28 00:00:00'),(5,1,'zhexiao27','http://pbs.twimg.com/profile_images/549956842181246977/TvHZE9_c_normal.jpeg','7VNgoWQLefTzSXLNV9r0NIZNYcEwCKj5','U7gy22TKiEiQqZQYiq1Vj7o1wxGyiek7','0000-00-00 00:00:00','2015-05-28 00:00:00'),(6,1,'zhexiao27','http://pbs.twimg.com/profile_images/549956842181246977/TvHZE9_c_normal.jpeg','FWviXgBnQiqGkBg4CJnEmwzPQ41Px5Sd','4EcZDQczjnvdG76MVQtYxzAuba0f818X','0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,1,'zhexiao27','http://pbs.twimg.com/profile_images/549956842181246977/TvHZE9_c_normal.jpeg','qfnUYLLtnyqsZ03XZDS6dtNBFXnAcFwa','tukTPmj2N4g70nc2wIqn5iXFzdmhLeLt','2015-05-28 00:18:00','2015-05-28 00:18:00'),(8,1,'zhexiao27','http://pbs.twimg.com/profile_images/549956842181246977/TvHZE9_c_normal.jpeg','qfnUYLLtnyqsZ03XZDS6dtNBFXnAcFwa','tukTPmj2N4g70nc2wIqn5iXFzdmhLeLt','2015-05-28 00:20:38','2015-05-28 00:20:38'),(9,1,'zhexiao27','http://pbs.twimg.com/profile_images/549956842181246977/TvHZE9_c_normal.jpeg','VUNPGZTvsZhU4hIH0EUSBKa7VVpqadv3','iowklLl6nhyxILmiQEGf1zhrkw2ebfm6','2015-05-28 00:20:46','2015-05-28 00:20:46'),(10,1,'zhexiao27','http://pbs.twimg.com/profile_images/549956842181246977/TvHZE9_c_normal.jpeg','gf3vyGbswd893ovMHzv2Ss4ZQy89laMa','j4LWtriGKtopS6aHW4LkJLnUNUR8iO1W','2015-05-28 11:04:12','2015-05-28 11:04:12');
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
  `ip` varchar(45) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ez_user`
--

LOCK TABLES `ez_user` WRITE;
/*!40000 ALTER TABLE `ez_user` DISABLE KEYS */;
INSERT INTO `ez_user` VALUES (1,'zhexiao','31efe5c727df3e9f116cd46fbb5b2626','zhexiao@163.com','127.0.0.1',NULL,NULL);
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

-- Dump completed on 2015-05-28 11:05:05
