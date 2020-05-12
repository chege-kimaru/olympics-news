-- MySQL dump 10.13  Distrib 5.7.21, for Win64 (x86_64)
--
-- Host: localhost    Database: dawson_olympics
-- ------------------------------------------------------
-- Server version	5.7.21

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES UTF8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `dawson_olympics`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `dawson_olympics` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `dawson_olympics`;

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES (2,'Boxing','api/public/1589271489-boxing1.jpg','2020-05-12 11:18:09'),(3,'Tennis','api/public/1589271517-tennis1.webp','2020-05-12 11:18:37'),(4,'Volleyball','api/public/1589271555-volleyball1.jpg','2020-05-12 11:19:15'),(5,'Handball','api/public/1589271611-handball1.jpg','2020-05-12 11:19:39');
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mclasses`
--

DROP TABLE IF EXISTS `mclasses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mclasses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game_id` int(11) DEFAULT NULL,
  `stadium_id` int(11) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `about` text,
  `mfrom` date DEFAULT NULL,
  `mto` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `game_id` (`game_id`),
  CONSTRAINT `mclasses_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mclasses`
--

LOCK TABLES `mclasses` WRITE;
/*!40000 ALTER TABLE `mclasses` DISABLE KEYS */;
INSERT INTO `mclasses` VALUES (2,2,1,'','Ultimate boxing games championships','Boxing','2020-05-01','2020-05-31',NULL,'2020-05-12 12:36:29'),(3,3,2,'','From beginner to pro. Join us today','Tennis','2020-05-02','2020-05-29',NULL,'2020-05-12 12:38:24'),(4,4,4,'','Reign in the field','Volleyball','2020-05-09','2020-05-31',NULL,'2020-05-12 12:39:48'),(5,5,4,'','Handball Training','Handball','2020-05-02','2020-05-31',NULL,'2020-05-12 12:40:38');
/*!40000 ALTER TABLE `mclasses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `about` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'general',
  `event_date` datetime DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `stadium_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `game_id` (`game_id`),
  KEY `created_by` (`created_by`),
  KEY `stadium_id` (`stadium_id`),
  CONSTRAINT `news_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`),
  CONSTRAINT `news_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `news_ibfk_3` FOREIGN KEY (`stadium_id`) REFERENCES `stadiums` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (5,2,'Kevin Tyler knocks down Martin King','In line with the primary mandate of delivering the Olympic Boxing Qualifying Events and the boxing tournament for the Olympic Games Tokyo 2020, and considering the importance of focusing on the athletes, the IOC Boxing Task Force has complemented existing International Boxing Association (AIBA) regulations with specific amendments to deliver its commitment to transparency while minimising the impact on boxers.After receiving the support of the&amp;nbsp;Athlete Ambassadors, the IOC Boxing Task Force has emphasised transparency and confirmed that the judges’ scores of all rounds will now be displayed at the end of each round.In the critical area of integrity of the referees and judges, all officials will be selected from the IOC Boxing Task Force pool of eligible officials, which will consist of qualified AIBA-certified individuals who have been reviewed to ensure they meet the selection criteria (see the linked document for selection criteria). The IOC Boxing Task Force will then randomly select every official for each competition from the pool of eligible individuals.The full referee and judge selection process will be conducted under the independent supervision of PricewaterhouseCoopers (PwC) and include extensive independent background checks of each individual. No referees or judges involved in the Olympic Games Rio 2016 will be eligible to participate in the Tokyo 2020 Olympic boxing qualifiers or Olympic competition.&amp;nbsp;Download a summary version of the Boxing Technical Officials Selection Process here.Other amendments to existing AIBA regulations reflect previous IOC and IOC Boxing Task Force decisions regarding the selection of participating athletes, with the National Federations (NFs) and their respective National Olympic Committees (NOCs) having the joint responsibility for ensuring that boxers meet the technical requirements to compete.The Chair of the IOC Boxing Task Force, Mr Morinari Watanabe, said:&amp;nbsp;“The main objective of the IOC Boxing Task Force is to ensure the completion of the mission of delivering events, while putting the boxers first, and with transparent and credible sporting results and fair play.”',1,'result','2020-05-14 09:00:00','api/public/1589288559-boxing2.jpg',2,'2020-05-12 16:02:39'),(6,2,'Big Match Native rawlins vs Kelly Jackson','In line with the primary mandate of delivering the Olympic Boxing Qualifying Events and the boxing tournament for the Olympic Games Tokyo 2020, and considering the importance of focusing on the athletes, the IOC Boxing Task Force has complemented existing International Boxing Association (AIBA) regulations with specific amendments to deliver its commitment to transparency while minimising the impact on boxers.After receiving the support of the&amp;nbsp;Athlete Ambassadors, the IOC Boxing Task Force has emphasised transparency and confirmed that the judges’ scores of all rounds will now be displayed at the end of each round.In the critical area of integrity of the referees and judges, all officials will be selected from the IOC Boxing Task Force pool of eligible officials, which will consist of qualified AIBA-certified individuals who have been reviewed to ensure they meet the selection criteria (see the linked document for selection criteria). The IOC Boxing Task Force will then randomly select every official for each competition from the pool of eligible individuals.The full referee and judge selection process will be conducted under the independent supervision of PricewaterhouseCoopers (PwC) and include extensive independent background checks of each individual. No referees or judges involved in the Olympic Games Rio 2016 will be eligible to participate in the Tokyo 2020 Olympic boxing qualifiers or Olympic competition.&amp;nbsp;Download a summary version of the Boxing Technical Officials Selection Process here.Other amendments to existing AIBA regulations reflect previous IOC and IOC Boxing Task Force decisions regarding the selection of participating athletes, with the National Federations (NFs) and their respective National Olympic Committees (NOCs) having the joint responsibility for ensuring that boxers meet the technical requirements to compete.The Chair of the IOC Boxing Task Force, Mr Morinari Watanabe, said:&amp;nbsp;“The main objective of the IOC Boxing Task Force is to ensure the completion of the mission of delivering events, while putting the boxers first, and with transparent and credible sporting results and fair play.”',1,'schedule','2020-05-31 18:00:00','api/public/1589288648-boxing3.jpg',1,'2020-05-12 16:04:08'),(7,3,'Big game ahead, Cynthia Marks to take Ellie Map','In line with the primary mandate of delivering the Olympic Boxing Qualifying Events and the boxing tournament for the Olympic Games Tokyo 2020, and considering the importance of focusing on the athletes, the IOC Boxing Task Force has complemented existing International Boxing Association (AIBA) regulations with specific amendments to deliver its commitment to transparency while minimising the impact on boxers.After receiving the support of the&amp;nbsp;Athlete Ambassadors, the IOC Boxing Task Force has emphasised transparency and confirmed that the judges’ scores of all rounds will now be displayed at the end of each round.In the critical area of integrity of the referees and judges, all officials will be selected from the IOC Boxing Task Force pool of eligible officials, which will consist of qualified AIBA-certified individuals who have been reviewed to ensure they meet the selection criteria (see the linked document for selection criteria). The IOC Boxing Task Force will then randomly select every official for each competition from the pool of eligible individuals.The full referee and judge selection process will be conducted under the independent supervision of PricewaterhouseCoopers (PwC) and include extensive independent background checks of each individual. No referees or judges involved in the Olympic Games Rio 2016 will be eligible to participate in the Tokyo 2020 Olympic boxing qualifiers or Olympic competition.&amp;nbsp;Download a summary version of the Boxing Technical Officials Selection Process here.Other amendments to existing AIBA regulations reflect previous IOC and IOC Boxing Task Force decisions regarding the selection of participating athletes, with the National Federations (NFs) and their respective National Olympic Committees (NOCs) having the joint responsibility for ensuring that boxers meet the technical requirements to compete.The Chair of the IOC Boxing Task Force, Mr Morinari Watanabe, said:&amp;nbsp;“The main objective of the IOC Boxing Task Force is to ensure the completion of the mission of delivering events, while putting the boxers first, and with transparent and credible sporting results and fair play.”',1,'schedule','2020-05-21 12:00:00','api/public/1589288750-tennis2.jpg',4,'2020-05-12 16:05:51'),(8,4,'Lake Manias to take East High','In line with the primary mandate of delivering the Olympic Boxing Qualifying Events and the boxing tournament for the Olympic Games Tokyo 2020, and considering the importance of focusing on the athletes, the IOC Boxing Task Force has complemented existing International Boxing Association (AIBA) regulations with specific amendments to deliver its commitment to transparency while minimising the impact on boxers.After receiving the support of the&amp;nbsp;Athlete Ambassadors, the IOC Boxing Task Force has emphasised transparency and confirmed that the judges’ scores of all rounds will now be displayed at the end of each round.In the critical area of integrity of the referees and judges, all officials will be selected from the IOC Boxing Task Force pool of eligible officials, which will consist of qualified AIBA-certified individuals who have been reviewed to ensure they meet the selection criteria (see the linked document for selection criteria). The IOC Boxing Task Force will then randomly select every official for each competition from the pool of eligible individuals.The full referee and judge selection process will be conducted under the independent supervision of PricewaterhouseCoopers (PwC) and include extensive independent background checks of each individual. No referees or judges involved in the Olympic Games Rio 2016 will be eligible to participate in the Tokyo 2020 Olympic boxing qualifiers or Olympic competition.&amp;nbsp;Download a summary version of the Boxing Technical Officials Selection Process here.Other amendments to existing AIBA regulations reflect previous IOC and IOC Boxing Task Force decisions regarding the selection of participating athletes, with the National Federations (NFs) and their respective National Olympic Committees (NOCs) having the joint responsibility for ensuring that boxers meet the technical requirements to compete.The Chair of the IOC Boxing Task Force, Mr Morinari Watanabe, said:&amp;nbsp;“The main objective of the IOC Boxing Task Force is to ensure the completion of the mission of delivering events, while putting the boxers first, and with transparent and credible sporting results and fair play.”',1,'schedule','2020-05-21 09:22:00','api/public/1589288926-volleyball2.jpg',4,'2020-05-12 16:08:46'),(9,5,'Drakups take the cup against XRivals','In line with the primary mandate of delivering the Olympic Boxing Qualifying Events and the boxing tournament for the Olympic Games Tokyo 2020, and considering the importance of focusing on the athletes, the IOC Boxing Task Force has complemented existing International Boxing Association (AIBA) regulations with specific amendments to deliver its commitment to transparency while minimising the impact on boxers.After receiving the support of the&amp;nbsp;Athlete Ambassadors, the IOC Boxing Task Force has emphasised transparency and confirmed that the judges’ scores of all rounds will now be displayed at the end of each round.In the critical area of integrity of the referees and judges, all officials will be selected from the IOC Boxing Task Force pool of eligible officials, which will consist of qualified AIBA-certified individuals who have been reviewed to ensure they meet the selection criteria (see the linked document for selection criteria). The IOC Boxing Task Force will then randomly select every official for each competition from the pool of eligible individuals.The full referee and judge selection process will be conducted under the independent supervision of PricewaterhouseCoopers (PwC) and include extensive independent background checks of each individual. No referees or judges involved in the Olympic Games Rio 2016 will be eligible to participate in the Tokyo 2020 Olympic boxing qualifiers or Olympic competition.&amp;nbsp;Download a summary version of the Boxing Technical Officials Selection Process here.Other amendments to existing AIBA regulations reflect previous IOC and IOC Boxing Task Force decisions regarding the selection of participating athletes, with the National Federations (NFs) and their respective National Olympic Committees (NOCs) having the joint responsibility for ensuring that boxers meet the technical requirements to compete.The Chair of the IOC Boxing Task Force, Mr Morinari Watanabe, said:&amp;nbsp;“The main objective of the IOC Boxing Task Force is to ensure the completion of the mission of delivering events, while putting the boxers first, and with transparent and credible sporting results and fair play.”',1,'result','2020-05-29 11:00:00','api/public/1589289025-handball2.webp',1,'2020-05-12 16:10:25'),(10,3,'Serena wins again against Eliza Matt','In line with the primary mandate of delivering the Olympic Boxing Qualifying Events and the boxing tournament for the Olympic Games Tokyo 2020, and considering the importance of focusing on the athletes, the IOC Boxing Task Force has complemented existing International Boxing Association (AIBA) regulations with specific amendments to deliver its commitment to transparency while minimising the impact on boxers.After receiving the support of the&amp;nbsp;Athlete Ambassadors, the IOC Boxing Task Force has emphasised transparency and confirmed that the judges’ scores of all rounds will now be displayed at the end of each round.In the critical area of integrity of the referees and judges, all officials will be selected from the IOC Boxing Task Force pool of eligible officials, which will consist of qualified AIBA-certified individuals who have been reviewed to ensure they meet the selection criteria (see the linked document for selection criteria). The IOC Boxing Task Force will then randomly select every official for each competition from the pool of eligible individuals.The full referee and judge selection process will be conducted under the independent supervision of PricewaterhouseCoopers (PwC) and include extensive independent background checks of each individual. No referees or judges involved in the Olympic Games Rio 2016 will be eligible to participate in the Tokyo 2020 Olympic boxing qualifiers or Olympic competition.&amp;nbsp;Download a summary version of the Boxing Technical Officials Selection Process here.Other amendments to existing AIBA regulations reflect previous IOC and IOC Boxing Task Force decisions regarding the selection of participating athletes, with the National Federations (NFs) and their respective National Olympic Committees (NOCs) having the joint responsibility for ensuring that boxers meet the technical requirements to compete.The Chair of the IOC Boxing Task Force, Mr Morinari Watanabe, said:&amp;nbsp;“The main objective of the IOC Boxing Task Force is to ensure the completion of the mission of delivering events, while putting the boxers first, and with transparent and credible sporting results and fair play.”',1,'result','2020-05-20 09:00:00','api/public/1589289528-tennis4.jpg',1,'2020-05-12 16:18:48'),(11,4,'Kelly Martin transfers to Kings Team','In line with the primary mandate of delivering the Olympic Boxing Qualifying Events and the boxing tournament for the Olympic Games Tokyo 2020, and considering the importance of focusing on the athletes, the IOC Boxing Task Force has complemented existing International Boxing Association (AIBA) regulations with specific amendments to deliver its commitment to transparency while minimising the impact on boxers.After receiving the support of the&amp;nbsp;Athlete Ambassadors, the IOC Boxing Task Force has emphasised transparency and confirmed that the judges’ scores of all rounds will now be displayed at the end of each round.In the critical area of integrity of the referees and judges, all officials will be selected from the IOC Boxing Task Force pool of eligible officials, which will consist of qualified AIBA-certified individuals who have been reviewed to ensure they meet the selection criteria (see the linked document for selection criteria). The IOC Boxing Task Force will then randomly select every official for each competition from the pool of eligible individuals.The full referee and judge selection process will be conducted under the independent supervision of PricewaterhouseCoopers (PwC) and include extensive independent background checks of each individual. No referees or judges involved in the Olympic Games Rio 2016 will be eligible to participate in the Tokyo 2020 Olympic boxing qualifiers or Olympic competition.&amp;nbsp;Download a summary version of the Boxing Technical Officials Selection Process here.Other amendments to existing AIBA regulations reflect previous IOC and IOC Boxing Task Force decisions regarding the selection of participating athletes, with the National Federations (NFs) and their respective National Olympic Committees (NOCs) having the joint responsibility for ensuring that boxers meet the technical requirements to compete.The Chair of the IOC Boxing Task Force, Mr Morinari Watanabe, said:&amp;nbsp;“The main objective of the IOC Boxing Task Force is to ensure the completion of the mission of delivering events, while putting the boxers first, and with transparent and credible sporting results and fair play.”',1,'general','2020-05-27 20:00:00','api/public/1589289626-volleyball2.jpg',4,'2020-05-12 16:20:26'),(12,2,'Ken Fanta becomes new Manager of Blocks Boxing ','In line with the primary mandate of delivering the Olympic Boxing Qualifying Events and the boxing tournament for the Olympic Games Tokyo 2020, and considering the importance of focusing on the athletes, the IOC Boxing Task Force has complemented existing International Boxing Association (AIBA) regulations with specific amendments to deliver its commitment to transparency while minimising the impact on boxers.After receiving the support of the&amp;nbsp;Athlete Ambassadors, the IOC Boxing Task Force has emphasised transparency and confirmed that the judges’ scores of all rounds will now be displayed at the end of each round.In the critical area of integrity of the referees and judges, all officials will be selected from the IOC Boxing Task Force pool of eligible officials, which will consist of qualified AIBA-certified individuals who have been reviewed to ensure they meet the selection criteria (see the linked document for selection criteria). The IOC Boxing Task Force will then randomly select every official for each competition from the pool of eligible individuals.The full referee and judge selection process will be conducted under the independent supervision of PricewaterhouseCoopers (PwC) and include extensive independent background checks of each individual. No referees or judges involved in the Olympic Games Rio 2016 will be eligible to participate in the Tokyo 2020 Olympic boxing qualifiers or Olympic competition.&amp;nbsp;Download a summary version of the Boxing Technical Officials Selection Process here.Other amendments to existing AIBA regulations reflect previous IOC and IOC Boxing Task Force decisions regarding the selection of participating athletes, with the National Federations (NFs) and their respective National Olympic Committees (NOCs) having the joint responsibility for ensuring that boxers meet the technical requirements to compete.The Chair of the IOC Boxing Task Force, Mr Morinari Watanabe, said:&amp;nbsp;“The main objective of the IOC Boxing Task Force is to ensure the completion of the mission of delivering events, while putting the boxers first, and with transparent and credible sporting results and fair play.”',1,'general','2020-05-22 11:00:00','api/public/1589289781-boxing4.jpg',4,'2020-05-12 16:23:01');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_images`
--

DROP TABLE IF EXISTS `news_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`),
  CONSTRAINT `news_images_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_images`
--

LOCK TABLES `news_images` WRITE;
/*!40000 ALTER TABLE `news_images` DISABLE KEYS */;
INSERT INTO `news_images` VALUES (6,5,'api/public/1589288559-boxing4.jpg','2020-05-12 16:02:39'),(7,5,'api/public/1589288559-boxing3.jpg','2020-05-12 16:02:39'),(8,5,'api/public/1589288559-boxing2.jpg','2020-05-12 16:02:39'),(9,5,'api/public/1589288559-boxing1.jpg','2020-05-12 16:02:39'),(10,6,'api/public/1589288648-boxing4.jpg','2020-05-12 16:04:08'),(11,6,'api/public/1589288648-boxing3.jpg','2020-05-12 16:04:08'),(12,6,'api/public/1589288648-boxing2.jpg','2020-05-12 16:04:09'),(13,6,'api/public/1589288648-boxing1.jpg','2020-05-12 16:04:09'),(14,7,'api/public/1589288751-tennis4.jpg','2020-05-12 16:05:51'),(15,7,'api/public/1589288751-tennis3.png','2020-05-12 16:05:51'),(16,7,'api/public/1589288751-tennis2.jpg','2020-05-12 16:05:51'),(17,7,'api/public/1589288751-tennis1.webp','2020-05-12 16:05:51'),(18,8,'api/public/1589288926-volleyball4.jpg','2020-05-12 16:08:46'),(19,8,'api/public/1589288926-volleyball3.jpg','2020-05-12 16:08:46'),(20,8,'api/public/1589288926-volleyball2.jpg','2020-05-12 16:08:46'),(21,8,'api/public/1589288926-volleyball1.jpg','2020-05-12 16:08:46'),(22,9,'api/public/1589289025-handball4.jpg','2020-05-12 16:10:25'),(23,9,'api/public/1589289025-handball3.jpg','2020-05-12 16:10:25'),(24,9,'api/public/1589289025-handball2.webp','2020-05-12 16:10:25'),(25,9,'api/public/1589289025-handball1.jpg','2020-05-12 16:10:25'),(26,10,'api/public/1589289528-tennis4.jpg','2020-05-12 16:18:48'),(27,10,'api/public/1589289528-tennis3.png','2020-05-12 16:18:48'),(28,10,'api/public/1589289528-tennis2.jpg','2020-05-12 16:18:48'),(29,10,'api/public/1589289528-tennis1.webp','2020-05-12 16:18:48'),(30,11,'api/public/1589289626-volleyball4.jpg','2020-05-12 16:20:26'),(31,11,'api/public/1589289626-volleyball3.jpg','2020-05-12 16:20:26'),(32,11,'api/public/1589289626-volleyball2.jpg','2020-05-12 16:20:26'),(33,11,'api/public/1589289626-volleyball1.jpg','2020-05-12 16:20:26'),(34,12,'api/public/1589289781-boxing4.jpg','2020-05-12 16:23:01'),(35,12,'api/public/1589289781-boxing3.jpg','2020-05-12 16:23:01'),(36,12,'api/public/1589289781-boxing2.jpg','2020-05-12 16:23:01'),(37,12,'api/public/1589289781-boxing1.jpg','2020-05-12 16:23:01');
/*!40000 ALTER TABLE `news_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stadiums`
--

DROP TABLE IF EXISTS `stadiums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stadiums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stadiums`
--

LOCK TABLES `stadiums` WRITE;
/*!40000 ALTER TABLE `stadiums` DISABLE KEYS */;
INSERT INTO `stadiums` VALUES (1,'Brokas','Nairobi','api/public/1589268783-stadium1.jpg','2020-05-12 10:33:03'),(2,'Vegas','York','api/public/1589268974-stadium4.jpg','2020-05-12 10:36:14'),(4,'Rings','Monava','api/public/1589269039-stadium3.jpg','2020-05-12 10:37:19');
/*!40000 ALTER TABLE `stadiums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_mclasses`
--

DROP TABLE IF EXISTS `user_mclasses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_mclasses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `class_id` (`class_id`),
  CONSTRAINT `user_mclasses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `user_mclasses_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `mclasses` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_mclasses`
--

LOCK TABLES `user_mclasses` WRITE;
/*!40000 ALTER TABLE `user_mclasses` DISABLE KEYS */;
INSERT INTO `user_mclasses` VALUES (1,4,2,'2020-05-12 23:05:26'),(2,4,3,'2020-05-12 23:14:25'),(3,4,5,'2020-05-12 23:16:41');
/*!40000 ALTER TABLE `user_mclasses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `role` int(11) NOT NULL DEFAULT '1',
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'kevin@gmail.com','$2y$10$3ahyJnTTiKE16CGI5dnN1ObJzkznTqJr.Wzssde9xHoInE6YpApry','','Nairobi',3,NULL,'2020-05-12 09:52:40'),(4,'dawson@gmail.com','$2y$10$QWB8g6rT6jd9Mf29U4SaQeheecoOmtj5NVe22ycMLXh/nbNFOstx2','Dawson ','Nairobi',1,NULL,'2020-05-12 22:55:44');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-13  0:17:05
