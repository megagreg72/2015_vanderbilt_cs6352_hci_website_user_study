-- MySQL dump 10.13  Distrib 5.5.45, for Linux (x86_64)
--
-- Host: localhost    Database: lol
-- ------------------------------------------------------
-- Server version	5.5.45

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `applications`
--

DROP TABLE IF EXISTS `applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `summoner_id` int(11) NOT NULL,
  `opening_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `summoner_id` (`summoner_id`),
  KEY `opening_id` (`opening_id`),
  CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`summoner_id`) REFERENCES `summoners` (`id`) ON DELETE CASCADE,
  CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`opening_id`) REFERENCES `teamOpenings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applications`
--

LOCK TABLES `applications` WRITE;
/*!40000 ALTER TABLE `applications` DISABLE KEYS */;
INSERT INTO `applications` VALUES (1,50998729,5),(7,65989134,3),(8,52630184,3),(16,29267672,3),(20,46035528,4),(23,22508597,4),(30,22712049,5),(31,37757005,5);
/*!40000 ALTER TABLE `applications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `days`
--

DROP TABLE IF EXISTS `days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `days` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `days`
--

LOCK TABLES `days` WRITE;
/*!40000 ALTER TABLE `days` DISABLE KEYS */;
INSERT INTO `days` VALUES (0,'Sunday'),(1,'Monday'),(2,'Tuesday'),(3,'Wednesday'),(4,'Thursday'),(5,'Friday'),(6,'Saturday');
/*!40000 ALTER TABLE `days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hours`
--

DROP TABLE IF EXISTS `hours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hours` (
  `id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hours`
--

LOCK TABLES `hours` WRITE;
/*!40000 ALTER TABLE `hours` DISABLE KEYS */;
INSERT INTO `hours` VALUES (0),(1),(2),(3),(4),(5),(6),(7),(8),(9),(10),(11),(12),(13),(14),(15),(16),(17),(18),(19),(20),(21),(22),(23);
/*!40000 ALTER TABLE `hours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leagues`
--

DROP TABLE IF EXISTS `leagues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leagues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tierNum` int(11) NOT NULL,
  `tierName` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leagues`
--

LOCK TABLES `leagues` WRITE;
/*!40000 ALTER TABLE `leagues` DISABLE KEYS */;
INSERT INTO `leagues` VALUES (1,0,'challenger'),(2,1,'master'),(3,2,'diamond'),(4,3,'platinum'),(5,4,'gold'),(6,5,'silver'),(7,6,'bronze'),(8,7,'unranked');
/*!40000 ALTER TABLE `leagues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'adc'),(2,'sup'),(3,'mid'),(4,'top'),(5,'jng'),(6,'any');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `summonerLeagues`
--

DROP TABLE IF EXISTS `summonerLeagues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `summonerLeagues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `summoner_id` int(11) NOT NULL,
  `league_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `summoner_id` (`summoner_id`),
  KEY `league_id` (`league_id`),
  CONSTRAINT `summonerLeagues_ibfk_1` FOREIGN KEY (`summoner_id`) REFERENCES `summoners` (`id`) ON DELETE CASCADE,
  CONSTRAINT `summonerLeagues_ibfk_2` FOREIGN KEY (`league_id`) REFERENCES `leagues` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `summonerLeagues`
--

LOCK TABLES `summonerLeagues` WRITE;
/*!40000 ALTER TABLE `summonerLeagues` DISABLE KEYS */;
INSERT INTO `summonerLeagues` VALUES (4,20024446,7),(5,22098261,5),(6,21964000,5),(7,22527115,4),(8,22663315,6),(9,23945116,3),(10,23584560,6),(11,24408101,6),(12,26319453,3),(13,26348138,5),(14,27771751,3),(15,20420483,2),(16,29267672,7),(17,29762147,3),(18,31108507,6),(19,32016393,4),(20,34833408,6),(21,34922783,5),(22,35201873,7),(23,35337835,3),(24,35603746,3),(25,36700303,6),(26,37736023,7),(27,39005723,5),(28,34049381,4),(29,39492860,3),(30,41975899,6),(31,42025800,7),(32,42080684,7),(33,43681902,6),(34,43879933,5),(35,43927813,6),(36,44026383,7),(37,44826008,6),(38,45448215,5),(39,46609786,5),(40,47694230,5),(41,47874517,4),(42,49195201,6),(43,50998729,7),(44,52630184,5),(45,53086558,5),(46,53349415,6),(47,54840916,6),(48,55430077,7),(49,55828678,6),(50,57424940,6),(51,59665316,6),(52,60208658,5),(53,60285304,7),(54,63531530,8),(55,45662483,8),(56,63538689,8),(57,64270504,6),(58,64540248,7),(59,65989134,4),(60,66323868,8),(61,68389476,8),(62,69420148,8),(63,69531049,8),(64,69612037,6),(65,69749474,8),(66,70580186,8),(69,46035528,4),(70,52099507,6),(71,35415366,7),(72,22508597,7),(73,59634189,5),(74,47159820,5),(76,46393761,5),(77,58983010,5),(78,25140967,5),(79,22712049,5),(80,37757005,4);
/*!40000 ALTER TABLE `summonerLeagues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `summonerPlayDays`
--

DROP TABLE IF EXISTS `summonerPlayDays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `summonerPlayDays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `summoner_id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `num_games` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `summoner_id` (`summoner_id`),
  KEY `day_id` (`day_id`),
  CONSTRAINT `summonerPlayDays_ibfk_1` FOREIGN KEY (`summoner_id`) REFERENCES `summoners` (`id`) ON DELETE CASCADE,
  CONSTRAINT `summonerPlayDays_ibfk_2` FOREIGN KEY (`day_id`) REFERENCES `days` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=505 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `summonerPlayDays`
--

LOCK TABLES `summonerPlayDays` WRITE;
/*!40000 ALTER TABLE `summonerPlayDays` DISABLE KEYS */;
INSERT INTO `summonerPlayDays` VALUES (1,45448215,0,166),(2,45448215,1,134),(3,45448215,2,113),(4,45448215,3,119),(5,45448215,4,118),(6,45448215,5,137),(7,45448215,6,147),(15,47874517,0,145),(16,47874517,1,96),(17,47874517,2,70),(18,47874517,3,113),(19,47874517,4,101),(20,47874517,5,142),(21,47874517,6,242),(22,23584560,0,150),(23,23584560,1,98),(24,23584560,2,76),(25,23584560,3,104),(26,23584560,4,88),(27,23584560,5,138),(28,23584560,6,237),(29,47694230,0,162),(30,47694230,1,89),(31,47694230,2,57),(32,47694230,3,74),(33,47694230,4,72),(34,47694230,5,129),(35,47694230,6,211),(36,46609786,0,333),(37,46609786,1,248),(38,46609786,2,293),(39,46609786,3,272),(40,46609786,4,274),(41,46609786,5,377),(42,46609786,6,334),(43,50998729,0,96),(44,50998729,1,40),(45,50998729,2,30),(46,50998729,3,26),(47,50998729,4,38),(48,50998729,5,37),(49,50998729,6,95),(50,22098261,0,56),(51,22098261,1,53),(52,22098261,2,69),(53,22098261,3,65),(54,22098261,4,47),(55,22098261,5,66),(56,22098261,6,50),(64,34922783,0,0),(65,34922783,1,0),(66,34922783,2,0),(67,34922783,3,0),(68,34922783,4,0),(69,34922783,5,0),(70,34922783,6,0),(71,24408101,0,0),(72,24408101,1,0),(73,24408101,2,0),(74,24408101,3,0),(75,24408101,4,0),(76,24408101,5,0),(77,24408101,6,0),(78,35337835,0,0),(79,35337835,1,0),(80,35337835,2,0),(81,35337835,3,0),(82,35337835,4,0),(83,35337835,5,0),(84,35337835,6,0),(85,64540248,0,20),(86,64540248,1,8),(87,64540248,2,16),(88,64540248,3,20),(89,64540248,4,20),(90,64540248,5,5),(91,64540248,6,3),(92,42080684,0,25),(93,42080684,1,22),(94,42080684,2,14),(95,42080684,3,17),(96,42080684,4,16),(97,42080684,5,22),(98,42080684,6,30),(99,55430077,0,0),(100,55430077,1,0),(101,55430077,2,0),(102,55430077,3,0),(103,55430077,4,0),(104,55430077,5,0),(105,55430077,6,0),(106,35201873,0,220),(107,35201873,1,213),(108,35201873,2,221),(109,35201873,3,170),(110,35201873,4,207),(111,35201873,5,165),(112,35201873,6,172),(113,57424940,0,0),(114,57424940,1,0),(115,57424940,2,0),(116,57424940,3,0),(117,57424940,4,0),(118,57424940,5,0),(119,57424940,6,0),(120,59665316,0,0),(121,59665316,1,0),(122,59665316,2,0),(123,59665316,3,0),(124,59665316,4,0),(125,59665316,5,0),(126,59665316,6,0),(127,39005723,0,0),(128,39005723,1,0),(129,39005723,2,0),(130,39005723,3,0),(131,39005723,4,0),(132,39005723,5,0),(133,39005723,6,0),(134,43927813,0,0),(135,43927813,1,0),(136,43927813,2,0),(137,43927813,3,0),(138,43927813,4,0),(139,43927813,5,0),(140,43927813,6,0),(141,53349415,0,2),(142,53349415,1,8),(143,53349415,2,3),(144,53349415,3,4),(145,53349415,4,4),(146,53349415,5,14),(147,53349415,6,3),(148,44826008,0,0),(149,44826008,1,0),(150,44826008,2,0),(151,44826008,3,0),(152,44826008,4,0),(153,44826008,5,0),(154,44826008,6,0),(155,26348138,0,0),(156,26348138,1,0),(157,26348138,2,0),(158,26348138,3,0),(159,26348138,4,0),(160,26348138,5,0),(161,26348138,6,0),(162,21964000,0,261),(163,21964000,1,189),(164,21964000,2,189),(165,21964000,3,201),(166,21964000,4,206),(167,21964000,5,176),(168,21964000,6,284),(169,68389476,0,0),(170,68389476,1,0),(171,68389476,2,0),(172,68389476,3,0),(173,68389476,4,0),(174,68389476,5,0),(175,68389476,6,0),(176,69749474,0,0),(177,69749474,1,0),(178,69749474,2,0),(179,69749474,3,0),(180,69749474,4,0),(181,69749474,5,0),(182,69749474,6,0),(183,69612037,0,4),(184,69612037,1,3),(185,69612037,2,1),(186,69612037,3,4),(187,69612037,4,3),(188,69612037,5,0),(189,69612037,6,3),(190,69420148,0,0),(191,69420148,1,0),(192,69420148,2,0),(193,69420148,3,0),(194,69420148,4,0),(195,69420148,5,0),(196,69420148,6,0),(197,69531049,0,0),(198,69531049,1,0),(199,69531049,2,0),(200,69531049,3,0),(201,69531049,4,0),(202,69531049,5,0),(203,69531049,6,0),(204,55828678,0,57),(205,55828678,1,40),(206,55828678,2,50),(207,55828678,3,39),(208,55828678,4,57),(209,55828678,5,65),(210,55828678,6,39),(211,41975899,0,68),(212,41975899,1,80),(213,41975899,2,69),(214,41975899,3,69),(215,41975899,4,65),(216,41975899,5,45),(217,41975899,6,65),(218,31108507,0,125),(219,31108507,1,133),(220,31108507,2,97),(221,31108507,3,105),(222,31108507,4,116),(223,31108507,5,104),(224,31108507,6,114),(225,63538689,0,0),(226,63538689,1,0),(227,63538689,2,0),(228,63538689,3,0),(229,63538689,4,0),(230,63538689,5,0),(231,63538689,6,0),(232,45662483,0,0),(233,45662483,1,0),(234,45662483,2,0),(235,45662483,3,0),(236,45662483,4,0),(237,45662483,5,0),(238,45662483,6,0),(239,66323868,0,0),(240,66323868,1,0),(241,66323868,2,0),(242,66323868,3,0),(243,66323868,4,0),(244,66323868,5,0),(245,66323868,6,0),(246,63531530,0,0),(247,63531530,1,0),(248,63531530,2,0),(249,63531530,3,0),(250,63531530,4,0),(251,63531530,5,0),(252,63531530,6,0),(253,70580186,0,0),(254,70580186,1,0),(255,70580186,2,0),(256,70580186,3,0),(257,70580186,4,0),(258,70580186,5,0),(259,70580186,6,0),(260,49195201,0,344),(261,49195201,1,264),(262,49195201,2,267),(263,49195201,3,248),(264,49195201,4,209),(265,49195201,5,266),(266,49195201,6,315),(267,42025800,0,40),(268,42025800,1,17),(269,42025800,2,6),(270,42025800,3,7),(271,42025800,4,9),(272,42025800,5,8),(273,42025800,6,24),(274,60208658,0,14),(275,60208658,1,20),(276,60208658,2,22),(277,60208658,3,44),(278,60208658,4,24),(279,60208658,5,25),(280,60208658,6,18),(281,60285304,0,51),(282,60285304,1,28),(283,60285304,2,34),(284,60285304,3,50),(285,60285304,4,42),(286,60285304,5,70),(287,60285304,6,50),(288,44026383,0,4),(289,44026383,1,13),(290,44026383,2,3),(291,44026383,3,3),(292,44026383,4,2),(293,44026383,5,9),(294,44026383,6,6),(295,64270504,0,18),(296,64270504,1,35),(297,64270504,2,19),(298,64270504,3,20),(299,64270504,4,29),(300,64270504,5,26),(301,64270504,6,26),(302,53086558,0,2),(303,53086558,1,5),(304,53086558,2,8),(305,53086558,3,8),(306,53086558,4,13),(307,53086558,5,7),(308,53086558,6,1),(309,22527115,0,245),(310,22527115,1,215),(311,22527115,2,157),(312,22527115,3,179),(313,22527115,4,179),(314,22527115,5,221),(315,22527115,6,247),(316,34833408,0,48),(317,34833408,1,19),(318,34833408,2,26),(319,34833408,3,26),(320,34833408,4,30),(321,34833408,5,49),(322,34833408,6,44),(323,65989134,0,163),(324,65989134,1,53),(325,65989134,2,31),(326,65989134,3,55),(327,65989134,4,60),(328,65989134,5,80),(329,65989134,6,206),(330,52630184,0,50),(331,52630184,1,172),(332,52630184,2,194),(333,52630184,3,167),(334,52630184,4,212),(335,52630184,5,143),(336,52630184,6,60),(337,20024446,0,5),(338,20024446,1,2),(339,20024446,2,4),(340,20024446,3,5),(341,20024446,4,6),(342,20024446,5,2),(343,20024446,6,9),(344,43879933,0,114),(345,43879933,1,124),(346,43879933,2,129),(347,43879933,3,128),(348,43879933,4,113),(349,43879933,5,153),(350,43879933,6,153),(351,37736023,0,49),(352,37736023,1,25),(353,37736023,2,17),(354,37736023,3,18),(355,37736023,4,25),(356,37736023,5,24),(357,37736023,6,63),(358,28886622,0,177),(359,28886622,1,182),(360,28886622,2,190),(361,28886622,3,154),(362,28886622,4,151),(363,28886622,5,97),(364,28886622,6,148),(365,22663315,0,1),(366,22663315,1,6),(367,22663315,2,0),(368,22663315,3,3),(369,22663315,4,0),(370,22663315,5,0),(371,22663315,6,2),(372,32016393,0,314),(373,32016393,1,269),(374,32016393,2,280),(375,32016393,3,215),(376,32016393,4,277),(377,32016393,5,295),(378,32016393,6,374),(379,54840916,0,54),(380,54840916,1,26),(381,54840916,2,15),(382,54840916,3,13),(383,54840916,4,14),(384,54840916,5,19),(385,54840916,6,44),(386,29267672,0,23),(387,29267672,1,13),(388,29267672,2,18),(389,29267672,3,12),(390,29267672,4,12),(391,29267672,5,15),(392,29267672,6,11),(393,43681902,0,128),(394,43681902,1,143),(395,43681902,2,126),(396,43681902,3,142),(397,43681902,4,134),(398,43681902,5,123),(399,43681902,6,108),(400,36700303,0,97),(401,36700303,1,159),(402,36700303,2,146),(403,36700303,3,158),(404,36700303,4,97),(405,36700303,5,95),(406,36700303,6,117),(421,46035528,0,244),(422,46035528,1,201),(423,46035528,2,198),(424,46035528,3,216),(425,46035528,4,186),(426,46035528,5,177),(427,46035528,6,243),(428,52099507,0,139),(429,52099507,1,141),(430,52099507,2,82),(431,52099507,3,114),(432,52099507,4,103),(433,52099507,5,88),(434,52099507,6,99),(435,35415366,0,44),(436,35415366,1,33),(437,35415366,2,18),(438,35415366,3,25),(439,35415366,4,33),(440,35415366,5,13),(441,35415366,6,34),(442,22508597,0,17),(443,22508597,1,10),(444,22508597,2,13),(445,22508597,3,7),(446,22508597,4,11),(447,22508597,5,6),(448,22508597,6,5),(449,59634189,0,163),(450,59634189,1,118),(451,59634189,2,89),(452,59634189,3,88),(453,59634189,4,73),(454,59634189,5,95),(455,59634189,6,196),(456,47159820,0,93),(457,47159820,1,30),(458,47159820,2,46),(459,47159820,3,37),(460,47159820,4,49),(461,47159820,5,59),(462,47159820,6,108),(470,46393761,0,222),(471,46393761,1,119),(472,46393761,2,125),(473,46393761,3,106),(474,46393761,4,136),(475,46393761,5,188),(476,46393761,6,191),(477,58983010,0,83),(478,58983010,1,83),(479,58983010,2,80),(480,58983010,3,70),(481,58983010,4,57),(482,58983010,5,61),(483,58983010,6,95),(484,25140967,0,6),(485,25140967,1,13),(486,25140967,2,10),(487,25140967,3,9),(488,25140967,4,5),(489,25140967,5,9),(490,25140967,6,17),(491,22712049,0,104),(492,22712049,1,98),(493,22712049,2,102),(494,22712049,3,71),(495,22712049,4,61),(496,22712049,5,76),(497,22712049,6,80),(498,37757005,0,24),(499,37757005,1,36),(500,37757005,2,42),(501,37757005,3,38),(502,37757005,4,57),(503,37757005,5,24),(504,37757005,6,34);
/*!40000 ALTER TABLE `summonerPlayDays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `summonerPlayHours`
--

DROP TABLE IF EXISTS `summonerPlayHours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `summonerPlayHours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `summoner_id` int(11) NOT NULL,
  `hour_id` int(11) NOT NULL,
  `num_games` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `summoner_id` (`summoner_id`),
  KEY `hour_id` (`hour_id`),
  CONSTRAINT `summonerPlayHours_ibfk_1` FOREIGN KEY (`summoner_id`) REFERENCES `summoners` (`id`) ON DELETE CASCADE,
  CONSTRAINT `summonerPlayHours_ibfk_2` FOREIGN KEY (`hour_id`) REFERENCES `hours` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=337 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `summonerPlayHours`
--

LOCK TABLES `summonerPlayHours` WRITE;
/*!40000 ALTER TABLE `summonerPlayHours` DISABLE KEYS */;
INSERT INTO `summonerPlayHours` VALUES (49,46035528,0,125),(50,46035528,1,55),(51,46035528,2,24),(52,46035528,3,5),(53,46035528,4,2),(54,46035528,5,2),(55,46035528,6,1),(56,46035528,7,1),(57,46035528,8,3),(58,46035528,9,9),(59,46035528,10,22),(60,46035528,11,30),(61,46035528,12,48),(62,46035528,13,68),(63,46035528,14,63),(64,46035528,15,67),(65,46035528,16,118),(66,46035528,17,145),(67,46035528,18,95),(68,46035528,19,110),(69,46035528,20,142),(70,46035528,21,89),(71,46035528,22,87),(72,46035528,23,154),(73,52099507,0,40),(74,52099507,1,34),(75,52099507,2,18),(76,52099507,3,12),(77,52099507,4,8),(78,52099507,5,4),(79,52099507,6,4),(80,52099507,7,10),(81,52099507,8,5),(82,52099507,9,9),(83,52099507,10,13),(84,52099507,11,25),(85,52099507,12,24),(86,52099507,13,34),(87,52099507,14,33),(88,52099507,15,61),(89,52099507,16,50),(90,52099507,17,47),(91,52099507,18,54),(92,52099507,19,43),(93,52099507,20,62),(94,52099507,21,63),(95,52099507,22,55),(96,52099507,23,58),(97,35415366,0,11),(98,35415366,1,5),(99,35415366,2,1),(100,35415366,3,0),(101,35415366,4,0),(102,35415366,5,0),(103,35415366,6,0),(104,35415366,7,1),(105,35415366,8,2),(106,35415366,9,4),(107,35415366,10,4),(108,35415366,11,7),(109,35415366,12,10),(110,35415366,13,8),(111,35415366,14,6),(112,35415366,15,7),(113,35415366,16,2),(114,35415366,17,7),(115,35415366,18,8),(116,35415366,19,18),(117,35415366,20,16),(118,35415366,21,24),(119,35415366,22,29),(120,35415366,23,30),(121,22508597,0,1),(122,22508597,1,0),(123,22508597,2,0),(124,22508597,3,0),(125,22508597,4,0),(126,22508597,5,0),(127,22508597,6,0),(128,22508597,7,1),(129,22508597,8,2),(130,22508597,9,0),(131,22508597,10,2),(132,22508597,11,4),(133,22508597,12,5),(134,22508597,13,4),(135,22508597,14,8),(136,22508597,15,4),(137,22508597,16,3),(138,22508597,17,4),(139,22508597,18,5),(140,22508597,19,1),(141,22508597,20,7),(142,22508597,21,7),(143,22508597,22,9),(144,22508597,23,2),(145,59634189,0,6),(146,59634189,1,3),(147,59634189,2,2),(148,59634189,3,3),(149,59634189,4,0),(150,59634189,5,0),(151,59634189,6,0),(152,59634189,7,2),(153,59634189,8,3),(154,59634189,9,4),(155,59634189,10,10),(156,59634189,11,28),(157,59634189,12,36),(158,59634189,13,46),(159,59634189,14,69),(160,59634189,15,88),(161,59634189,16,81),(162,59634189,17,75),(163,59634189,18,91),(164,59634189,19,85),(165,59634189,20,67),(166,59634189,21,59),(167,59634189,22,47),(168,59634189,23,17),(169,47159820,0,1),(170,47159820,1,0),(171,47159820,2,0),(172,47159820,3,0),(173,47159820,4,0),(174,47159820,5,0),(175,47159820,6,0),(176,47159820,7,2),(177,47159820,8,3),(178,47159820,9,14),(179,47159820,10,22),(180,47159820,11,30),(181,47159820,12,35),(182,47159820,13,28),(183,47159820,14,35),(184,47159820,15,41),(185,47159820,16,49),(186,47159820,17,49),(187,47159820,18,31),(188,47159820,19,20),(189,47159820,20,16),(190,47159820,21,20),(191,47159820,22,17),(192,47159820,23,9),(217,46393761,0,28),(218,46393761,1,17),(219,46393761,2,12),(220,46393761,3,11),(221,46393761,4,7),(222,46393761,5,12),(223,46393761,6,15),(224,46393761,7,17),(225,46393761,8,30),(226,46393761,9,35),(227,46393761,10,27),(228,46393761,11,25),(229,46393761,12,43),(230,46393761,13,60),(231,46393761,14,86),(232,46393761,15,88),(233,46393761,16,60),(234,46393761,17,70),(235,46393761,18,87),(236,46393761,19,79),(237,46393761,20,83),(238,46393761,21,89),(239,46393761,22,68),(240,46393761,23,38),(241,58983010,0,4),(242,58983010,1,3),(243,58983010,2,1),(244,58983010,3,2),(245,58983010,4,2),(246,58983010,5,0),(247,58983010,6,3),(248,58983010,7,27),(249,58983010,8,28),(250,58983010,9,34),(251,58983010,10,19),(252,58983010,11,27),(253,58983010,12,31),(254,58983010,13,45),(255,58983010,14,38),(256,58983010,15,31),(257,58983010,16,9),(258,58983010,17,20),(259,58983010,18,40),(260,58983010,19,58),(261,58983010,20,56),(262,58983010,21,31),(263,58983010,22,13),(264,58983010,23,7),(265,25140967,0,7),(266,25140967,1,2),(267,25140967,2,1),(268,25140967,3,5),(269,25140967,4,5),(270,25140967,5,2),(271,25140967,6,2),(272,25140967,7,2),(273,25140967,8,0),(274,25140967,9,2),(275,25140967,10,0),(276,25140967,11,2),(277,25140967,12,3),(278,25140967,13,2),(279,25140967,14,3),(280,25140967,15,2),(281,25140967,16,4),(282,25140967,17,3),(283,25140967,18,5),(284,25140967,19,3),(285,25140967,20,1),(286,25140967,21,3),(287,25140967,22,4),(288,25140967,23,6),(289,22712049,0,92),(290,22712049,1,93),(291,22712049,2,80),(292,22712049,3,36),(293,22712049,4,8),(294,22712049,5,1),(295,22712049,6,1),(296,22712049,7,1),(297,22712049,8,0),(298,22712049,9,1),(299,22712049,10,1),(300,22712049,11,4),(301,22712049,12,10),(302,22712049,13,12),(303,22712049,14,8),(304,22712049,15,18),(305,22712049,16,15),(306,22712049,17,16),(307,22712049,18,13),(308,22712049,19,8),(309,22712049,20,32),(310,22712049,21,33),(311,22712049,22,44),(312,22712049,23,65),(313,37757005,0,9),(314,37757005,1,8),(315,37757005,2,2),(316,37757005,3,0),(317,37757005,4,1),(318,37757005,5,0),(319,37757005,6,0),(320,37757005,7,2),(321,37757005,8,5),(322,37757005,9,9),(323,37757005,10,10),(324,37757005,11,14),(325,37757005,12,18),(326,37757005,13,16),(327,37757005,14,15),(328,37757005,15,24),(329,37757005,16,18),(330,37757005,17,17),(331,37757005,18,13),(332,37757005,19,17),(333,37757005,20,20),(334,37757005,21,13),(335,37757005,22,14),(336,37757005,23,10);
/*!40000 ALTER TABLE `summonerPlayHours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `summonerRoles`
--

DROP TABLE IF EXISTS `summonerRoles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `summonerRoles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `summoner_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `num_games` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `summoner_id` (`summoner_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `summonerRoles_ibfk_1` FOREIGN KEY (`summoner_id`) REFERENCES `summoners` (`id`) ON DELETE CASCADE,
  CONSTRAINT `summonerRoles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `summonerRoles`
--

LOCK TABLES `summonerRoles` WRITE;
/*!40000 ALTER TABLE `summonerRoles` DISABLE KEYS */;
/*!40000 ALTER TABLE `summonerRoles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `summoners`
--

DROP TABLE IF EXISTS `summoners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `summoners` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `num_matches` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `summoners_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `summoners`
--

LOCK TABLES `summoners` WRITE;
/*!40000 ALTER TABLE `summoners` DISABLE KEYS */;
INSERT INTO `summoners` VALUES (20024446,'YOUTOOTH',33,3),(21964000,'Offkeyanthem',1506,1),(22098261,'Steel and style',406,4),(22508597,'BBRPGrinner',69,5),(22527115,'cpt showstopper',1443,2),(22663315,'Queezee',12,1),(22712049,'Cbusta',592,3),(23584560,'tpx imagine',891,1),(24408101,'Whyudievoid',0,6),(25140967,'Dankrupt',69,1),(26348138,'Evilgeniusnajm',0,6),(28886622,'eccco',1099,4),(29267672,'RedFox91',104,3),(31108507,'Unit167',794,5),(32016393,'Cloud Haru',2024,1),(34833408,'Cutwarrior',242,4),(34922783,'Alomagicat',0,6),(35201873,'Arkeusultor',1368,4),(35337835,'Narkon',0,6),(35415366,' logouttnow',200,3),(36700303,'Babyfuzz',869,5),(37736023,'Valourd',221,2),(37757005,' Grandma Died',255,2),(39005723,'Scootypuffjunior',0,6),(41975899,'Eternal torch007',461,4),(42025800,'Phresh 2 deff',111,3),(42080684,'Phoenixfiree3',146,2),(43681902,'Aldohl',904,4),(43879933,'takemymoneypls',914,1),(43927813,'Bit freq',0,6),(44026383,'TheLastOverlord',40,5),(44826008,'Castuhden',0,6),(45448215,'Skylurker',934,4),(45662483,'Ser seandogiford',0,6),(46035528,'G9 Essence',1465,1),(46393761,'FunkySammy7',1087,5),(46609786,'Arkanex',2131,2),(47159820,'Duckstep',422,4),(47694230,'tpx volition',794,4),(47874517,'tpx spectre',909,3),(49195201,'Jshook',1913,4),(50998729,'IBBroken',362,3),(52099507,'I Support My ADC',766,1),(52630184,'Purdyleet',998,5),(53086558,'DubMcScrub',44,3),(53349415,'Rawinfection',38,5),(54840916,'Wabajesus',185,1),(55430077,'West blue',0,6),(55828678,'Racistcoffe',347,5),(57424940,'Jayce logic',0,6),(58983010,'peopledie2013',529,5),(59634189,'NeatDarkNess',822,5),(59665316,'Snakehead365',0,6),(60208658,'Whippinit',167,5),(60285304,'Psrum101',325,2),(63531530,'Gandhithepunk',0,6),(63538689,'Kidnester',0,6),(64270504,'Vashta',173,4),(64540248,'Thaus18',92,2),(65989134,'Akis',648,1),(66323868,'Tesszhang',0,6),(68389476,'Teenycactus8',0,6),(69420148,'Snowva',0,6),(69531049,'Ironflamegaming',0,6),(69612037,'Bronzetucan',18,3),(69749474,'Dr tripod',0,6),(70580186,'Wwaarreenn17',0,6);
/*!40000 ALTER TABLE `summoners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teamMembers`
--

DROP TABLE IF EXISTS `teamMembers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teamMembers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `summoner_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `team_id` (`team_id`),
  KEY `summoner_id` (`summoner_id`),
  CONSTRAINT `teamMembers_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `teamMembers_ibfk_2` FOREIGN KEY (`summoner_id`) REFERENCES `summoners` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teamMembers`
--

LOCK TABLES `teamMembers` WRITE;
/*!40000 ALTER TABLE `teamMembers` DISABLE KEYS */;
INSERT INTO `teamMembers` VALUES (3,3,23584560),(4,3,47874517),(5,3,47694230),(6,4,46609786),(7,5,22098261),(9,6,42080684),(10,6,35201873),(11,6,24408101),(12,6,34922783),(13,6,35337835),(14,6,64540248),(15,6,55430077),(16,7,21964000),(17,7,59665316),(18,7,53349415),(19,7,57424940),(20,7,39005723),(21,7,43927813),(22,7,26348138),(23,7,44826008),(24,8,69420148),(25,8,69749474),(26,8,68389476),(27,8,69531049),(28,8,69612037),(29,9,31108507),(30,9,55828678),(31,9,41975899),(32,10,63538689),(33,10,63531530),(34,10,45662483),(35,10,66323868),(36,10,70580186),(37,11,49195201),(38,12,60285304),(39,12,42025800),(40,12,60208658);
/*!40000 ALTER TABLE `teamMembers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teamOpenings`
--

DROP TABLE IF EXISTS `teamOpenings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teamOpenings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `team_id` (`team_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `teamOpenings_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `teamOpenings_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teamOpenings`
--

LOCK TABLES `teamOpenings` WRITE;
/*!40000 ALTER TABLE `teamOpenings` DISABLE KEYS */;
INSERT INTO `teamOpenings` VALUES (3,3,3),(4,4,1),(5,4,3),(6,4,4),(7,5,3),(8,5,6),(9,5,6),(10,6,6),(11,6,6),(12,7,6),(13,8,1),(14,8,3),(15,8,4),(16,9,6),(17,9,6),(18,10,1),(19,10,3),(20,10,4),(21,11,6),(22,12,4),(23,12,3),(24,12,1);
/*!40000 ALTER TABLE `teamOpenings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` char(128) NOT NULL,
  `salt` char(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (3,'Paradox Titans','We are recruiting a dedicated Mid main to try and finish the season in Silver. Next season&#39;s goals will be determined by how well this season goes and how well the preseason ends. Must be active on weekends (Fri-Sun). You must understand how League of Legends works, we are not here to teach you the basics, however we will learn to work together and improve as a team-together.','ParadoxTitans@gmail.com','e105efd6acc1f90dc44e2b28139d718fa73d84555b14b29989c8c9d0d26d0f61555eaa4b44d4c6e9cc6deae74c6d8fc3c9d90c520497db6ffe1cafed223be205','fdf5e8657394b3e01694356ea6fcf6e7c77bb6e6f442c1a3a3c860e0ac5c2b9f102cd95a09a81512168aadcf27694cdb23baa059339486a31b4e11143d0d5273'),(4,'Team Supremacy','Hi, I&#39;m looking for really good players to play ranked 5s with. Need to be active. I won&#39;t accept people who aren&#39;t sure about wich role they want to play, if you don&#39;t main a single role I&#39;m not interested. I main support and I&#39;m almost always on. Add ArkaneX on LoL or just answer on the post. Thank you!','TeamSupremacy@gmail.com','ac8237c5287c00dde93daef701edf79b846d982ab87f3c6ee3b2f9b02d5b2053d63248c8d2bde3b61122c1b29b2fa3c9104772b46a9320c661964d37e32ca3ec','9fa737bb606879a7f3b711c8a96d41b00f0eb19d8d81527b13d52045d93e37b5fcd13a88e844c2f97c25cfdb832839e2c9868ba5583892135fbf5c6463fe78f6'),(5,'Limited Expectations','We&#39;re looking for a casual play, where we play towards becoming better players but understand that it&#39;s just for fun.','LimitedExpectations@gmail.com','f12b1168d8db104adfd41ce9482bdfd8e5fd888ad0a3784dbb09ec32e01592b3f40887c4ee347699622f713a0a25a3eb6c668ea6d11504e278bda0d4b278cbf7','9d886c5b21f1d10831a6976d3710706ba8ec1af60017117101d011e1ade57dbed7033f882bae7523c9b7aa07b5d97bcd73b4a072bdb603946b1f388eab8381ec'),(6,'Light em Up Gamin','Looking for competitive Silver/Gold elo players who want to climb the Ranked 5&#39;s ladder','LightemUpGamin@gmail.com','e786aa0e16c2fd220b34366d0cf6204e0cb05c9002901232fc78d7a12d9060e63ea0e4a12ca8813600c8cb3e84485b7c332aceba1ce2125ff8170a3173460079','cb609c11a1e410d2c7f9ef05d7c7fdf24feadff0b2b915932adc12777bc53bad3e7a83574f32d7d714678615d3538755a8552201a312129f9a8895ce1a4c9f6f'),(7,'OffKeyAnthem&#39;s team','Please note this is for a team for Season 6. Looking for serious competitors who are willing to get better. Must frequently play Solo Q be able to contribute to the team on the rift and off when we have review and gameplans. No ragers or flamers. Looking for subs in all roles, be flexible and open to criticism. We play Monday and Wednesday starting at 9pm EST. Feel free to apply all applications will be reviewed. Curse voice is a must.','Offkeyanthem@gmail.com','00526731de1c9d9044a93291752eb8fd881078337561428856f747480e713f59b41f518b50018e5c4c7c2e2dad653602e110db628765bd1153ba463d5ace1b26','9f3a4c9b3c9d19421a48e1ff14eb434bc34ddc320a71b48967001c1e3ad5d67d4718a8c400d98c5c36fadca7eeca9c3a7596d44b4af07aa13c0aafcfefdaf4ed'),(8,'NEW TO LEAGUE','We&#39;re new players to league of legends who want to use communication, unity, and strategy in all of our games.We&#39;re out to find out what we are best at on individual level, and we&#39;re also here to have fun. Join us, we&#39;re friendly and play frequently!','NewToLeague@gmail.com','c36e1c5439d1b0994aa3b8fe6e2f51d6a9d7c2dcef21fc521b2091cb2bce26c83077b651e31b8f441615d4a181a9af554145765ffe7e3b6d4d7ec11176c7b95b','bf1f36c47348eec8e055a30a34745ddd1bd8cc14e5eedb8e6a2116e2c51e694994b6441b2d1ba4fb7c91333c58c4fc2f8562b30de7c40046f33a613610f373e0'),(9,'Crash Override','Me and some friends have decided to start a team and need other very active players that will dedicate most of their league time to this team. I myself hope to be able to teach anyone that joins us in trying to become better at this game and hit higher leagues with us. Now I plan to try and have daily games for us, weekly ranked games, and if we feel like we could attempt and try tournaments.','crashOverride@gmail.com','48c239c0bc71d29aaecf178d1fc7c2a0a78e5947f31a5bdc6a6f686812d6af518c57c64dbd97fbd08eeb2dc30572b91d8e2b9b7ab92de785280331a2a0286138','32d404367761598b9f0a28b14c2ee79ceb8387bf0e99b200a19cbbe5d3d3d186d43e7f04099515c72eff32c6ec3e3a9968ba9c5cb4340257bef904de44ec431d'),(10,'Nester&#39;s Nubs','New to league? This team is build solely for new players! Looking for casual gaming, no ranked etc. Bots and Normals OK! No lvl 30 plz','nester@gmail.com','781dbb8356fd8d7b5483d64c7b6c9bf69fc8f2ab27b2d877200120b0fe065c235457bc0eb12c80876b2a7d21245737eda79c9f0546c7bb6aea21fbac6286a889','acff56446c681531da66187b5687bdd7eb520be65547bb48b0666b20ea02675fa7176001a6f34ed9ce56fa5b0d1999bf3179ca9a41a4cc39f36a3bffe49f7849'),(11,'JShooK&#39;s team','Looking for active duo partner. I am currently s2 and looking to climb to Gold or higher, I main top but can play any role and looking for a partner that can do the same.','JShook@gmail.com','02394c26b39695dc9498865cff5cb20f99ce06b9f02dbc0fd503352e952237bfaae9892a6e2d11efac62031db24d80a4d07358a3e3e1e3cae615c0e5e4d4bbf3','1d202407b13f39fb6e885be78cbe1f4f8ea11e9b94dba6f386d2a72e156f4ed185a262cc6be7d1baf9865711e8c5f5ea4992c1d4c89217522066bbd0df86fd35'),(12,'tbd','looking to create a team of people who are looking to get good practice in before next season so we can climb (must be willing to play atleast 2 games a night and be able to take constructive critisism','tbd@gmail.com','ebe0dabac9701e142b816ebe5f735bfbecc25cac562393e2b80d683784beebf746aa8fad98fc09e963691f942a8c3d906449c9e30b469837d427eceabe5a99e9','6640366ba932dbee0b2300a6901994e1ff40f35fd058c35c8f6e731c47fade7206876f10fec6a8af69e1f17ef01c799c78734c71715d66f34c7ed78d3cadc756');
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-11-08 20:58:45
