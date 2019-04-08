-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: localhost    Database: horserace_db
-- ------------------------------------------------------
-- Server version	5.7.25-0ubuntu0.18.04.2

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
-- Table structure for table `horse_races`
--

DROP TABLE IF EXISTS `horse_races`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `horse_races` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `race_id` int(10) unsigned NOT NULL,
  `horse_id` int(10) unsigned NOT NULL,
  `distance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `running_time` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('pending','running','finished') COLLATE utf8_persian_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `race_id_2` (`race_id`,`horse_id`),
  KEY `race_id` (`race_id`),
  KEY `horse_id` (`horse_id`),
  CONSTRAINT `horse_races_ibfk_1` FOREIGN KEY (`race_id`) REFERENCES `races` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `horse_races_ibfk_2` FOREIGN KEY (`horse_id`) REFERENCES `horses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horse_races`
--

LOCK TABLES `horse_races` WRITE;
/*!40000 ALTER TABLE `horse_races` DISABLE KEYS */;
/*!40000 ALTER TABLE `horse_races` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horses`
--

DROP TABLE IF EXISTS `horses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `horses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_persian_ci NOT NULL,
  `speed` decimal(10,1) NOT NULL,
  `strength` decimal(10,1) NOT NULL,
  `endurance` decimal(10,1) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horses`
--

LOCK TABLES `horses` WRITE;
/*!40000 ALTER TABLE `horses` DISABLE KEYS */;
/*!40000 ALTER TABLE `horses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `races`
--

DROP TABLE IF EXISTS `races`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `races` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` enum('pending','running','finished') COLLATE utf8_persian_ci NOT NULL DEFAULT 'pending',
  `running_time` decimal(10,2) DEFAULT '0.00',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `races`
--

LOCK TABLES `races` WRITE;
/*!40000 ALTER TABLE `races` DISABLE KEYS */;
/*!40000 ALTER TABLE `races` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-08 16:40:38
