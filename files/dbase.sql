-- MySQL dump 10.13  Distrib 5.7.34, for osx10.15 (x86_64)
--
-- Host: localhost    Database: mortiold
-- ------------------------------------------------------
-- Server version	5.7.34

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
-- Table structure for table `chapter`
--

DROP TABLE IF EXISTS `chapter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chapter` (
  `id` int(11) NOT NULL,
  `author` varchar(40) DEFAULT NULL,
  `visible_title` varchar(40) DEFAULT NULL,
  `text_file` varchar(40) DEFAULT NULL,
  `additional_text_file` varchar(40) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_comment` datetime DEFAULT NULL,
  `reviewed` tinyint(1) NOT NULL,
  `next_id` int(11) DEFAULT NULL,
  `ingame` tinyint(1) NOT NULL,
  `additional_format` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `visible_title` (`visible_title`),
  UNIQUE KEY `text_file` (`text_file`),
  UNIQUE KEY `additional_text_file` (`additional_text_file`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chapter`
--

LOCK TABLES `chapter` WRITE;
/*!40000 ALTER TABLE `chapter` DISABLE KEYS */;
INSERT INTO `chapter` VALUES (1,'Pepe','Test 1','chapter1.txt','chapter1.txt',NULL,'2016-07-25 00:36:45',0,2,1,0),(2,'Pepe','Test 2','chapter2.txt',NULL,NULL,'2016-07-24 22:48:37',0,NULL,1,0),(3,NULL,'Test 3','chapter3.txt','chapter3.txt',NULL,NULL,0,NULL,0,1),(4,NULL,'Test 4','chapter4.txt','chapter4.txt',NULL,NULL,0,NULL,1,2);
/*!40000 ALTER TABLE `chapter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(40) NOT NULL,
  `chapter_id` int(11) NOT NULL,
  `text` varchar(1500) NOT NULL,
  `date` datetime DEFAULT NULL,
  `paragraph` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (2,'test@test.com',1,'Ta to pagao','2014-10-29 21:35:33',NULL),(3,'test@test.com',1,'Teh test','2014-10-30 17:57:27',NULL),(4,'test@test.com',1,'Teh tesh','2014-10-30 17:57:46',NULL),(5,'test@test.com',1,'Some more test magic.\n\nSpecial chars?','2014-10-30 18:00:48',NULL),(6,'test@test.com',1,'\")','2014-10-30 18:01:45',NULL),(7,'test@test.com',1,'<br>Lalala<br>','2014-10-30 18:02:00',NULL),(8,'test@test.com',1,'Big-ass text with a repeating contentBig-ass text with a repeating contentBig-ass text with a repeating contentBig-ass text with a repeating contentBig-ass text with a repeating contentBig-ass text with a repeating contentBig-ass text with a repeating contentBig-ass text with a repeating contentBig-ass text with a repeating contentBig-ass text with a repeating contentBig-ass text with a repeating contentBig-ass text with a repeating contentBig-ass text with a repeating contentBig-ass text with a repeating content','2014-10-30 18:05:42',NULL),(9,'test@test.com',2,'Hey','2014-10-30 18:12:35',NULL),(10,'test@test.com',1,'Caca','2014-11-15 16:44:44',NULL),(12,'test@test.com',1,'Con referencia','2014-12-11 16:24:43',3),(13,'test@test.com',1,'Sin referencia','2014-12-11 16:24:51',NULL),(14,'test@test.com',1,'Sin referencia ya','2014-12-11 16:25:33',NULL),(15,'test@test.com',2,'Lalalala!','2015-01-25 10:29:52',1),(16,'cutre@terra.es',2,'Ñañaña','2015-03-02 23:58:34',NULL),(17,'trolo@lolo.lol',2,'Hehe','2015-03-03 00:01:18',NULL),(18,'test@test.com',1984,'Testing','2015-03-03 18:33:01',NULL),(19,'trolo@lolo.lol',1984,'Testing too','2015-03-03 18:33:22',NULL),(20,'test@test.com',2,'Tetete\n\nTototo','2015-03-06 00:53:23',NULL),(21,'test@test.com',2,'Testin errorz','2015-03-25 01:27:50',NULL),(22,'test@test.com',2,'Testin errorrrsd','2015-03-25 01:28:11',NULL),(23,'test@test.com',2,'anoda test','2015-03-25 01:29:16',NULL),(24,'test@test.com',1984,'anoda test?','2015-03-25 01:38:59',NULL),(25,'test@test.com',1984,'moar test!','2015-03-25 01:44:16',NULL),(26,'test@test.com',2,'twerks?','2015-03-25 01:56:33',NULL),(27,'test@test.com',2,'Lalala','2015-03-31 01:49:38',NULL),(28,'test@test.com',1,'\'\'\'\'','2015-05-26 23:19:38',NULL),(29,'test@test.com',1,'hey?','2016-07-22 19:49:20',4),(30,'test@test.com',2,'hhhhhhhh','2016-07-24 22:47:58',NULL),(31,'test@test.com',2,'hhhhhhhhhhhggggghhh','2016-07-24 22:48:37',1),(32,'test@test.com',1,'Testit - 1','2016-07-24 23:30:39',NULL),(33,'test@test.com',1,'testit - 2','2016-07-24 23:30:57',6),(34,'test@test.com',1,'jhkjfdhkjhfjd khfkjdf','2016-07-25 00:36:27',NULL),(35,'test@test.com',1,'HHHHH!!!','2016-07-25 00:36:45',3),(36,'test@test.com',1984,'HHH','2016-07-25 00:37:49',NULL);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `email` varchar(40) NOT NULL,
  `password` varchar(32) NOT NULL,
  `username` varchar(40) DEFAULT NULL,
  `permissions` int(11) NOT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `marker_chapter` int(11) DEFAULT NULL,
  `marker_paragraph` int(11) DEFAULT NULL,
  `show_email` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('cutre@terra.es','098f6bcd4621d373cade4e832627b4f6','Cutre',2,'http://www.frikipedia.es/images/1/1f/Pringao.jpg',NULL,NULL,0),('test@test.com','098f6bcd4621d373cade4e832627b4f6','Testman',0,'http://i2.kym-cdn.com/photos/images/newsfeed/000/133/612/509_4a082effd5b3d.gif',1,1,0),('trolo@lolo.lol','098f6bcd4621d373cade4e832627b4f6','Trololo',1,'http://i.ytimg.com/vi/NgLq6d_w4e4/hqdefault.jpg',NULL,NULL,0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-17 16:24:35
