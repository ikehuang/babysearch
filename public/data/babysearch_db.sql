-- MySQL dump 10.13  Distrib 5.6.16, for Win32 (x86)
--
-- Host: localhost    Database: babysearch_db
-- ------------------------------------------------------
-- Server version	5.6.16

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
-- Table structure for table `bulletin`
--

DROP TABLE IF EXISTS `bulletin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bulletin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bulletin`
--

LOCK TABLES `bulletin` WRITE;
/*!40000 ALTER TABLE `bulletin` DISABLE KEYS */;
INSERT INTO `bulletin` VALUES (1,'The english version of Baby Search will be coming at the end of 2015.');
/*!40000 ALTER TABLE `bulletin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `zh_tw_display_name` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Pets','寵物',0),(2,'Human','人',0),(3,'Valuables','物品',0),(4,'Dogs','犬種',1),(5,'Cats','貓種',1),(6,'Large Dogs','大型犬',4),(7,'Medium Dogs','中型犬',4),(8,'Small Dogs','小型犬',4),(9,'Longhair','長毛貓',5),(10,'Shorthair','短毛貓',5),(11,'Labrador Retriever','拉布拉多犬',6),(12,'Dalmatian','大麥町犬',6),(13,'Chow Chow','鬆獅犬',6),(14,'Irish Water Spaniel','愛爾蘭水獵鷸犬',6),(15,'Puli','波利犬',6),(16,'Bull Terrier','牛頭梗',6),(17,'Leonberger','蘭伯格犬',6),(18,'Borzoi','蘇俄牧羊犬',6),(19,'Deerhound','獵鹿犬',6),(20,'Foxhound','獵狐犬',6),(21,'Otter Hound','獵水獺犬',6),(22,'Dobermann','篤賓犬',6),(23,'St.Bernard','聖伯納狗',6),(24,'Eskimo Dog','愛斯基摩犬',6),(25,'Bloodhound','尋血獵犬',6),(26,'Hovawart','荷花瓦特犬	',6),(27,'Curly - Coated Retriever','捲毛獵犬',6),(28,'Rottweiler','洛威拿犬',6),(29,'Old English Sheepdog','英國老式牧羊犬',6),(30,'Afghan Hound','阿富汗獵犬',6),(31,'Bouvier Des Flandres','法蘭德斯畜牧犬',6),(32,'Pharaoh Hound','法老王獵犬',6),(33,'Briard','伯瑞犬',6),(34,'Giany Schnauzer','巨型雪納瑞犬',6),(35,'Great Dane','大丹犬',6),(36,'Bedlington Terrier','貝林登挭',7),(37,'Basenji','貝生吉犬',7),(38,'Sussex Speniel','蘇士塞獵犬',7),(39,'Irish Terrier','愛爾蘭梗',7),(40,'Jura Hound','腓尼基獵犬',7),(41,'Whippet','惠比特犬',7),(42,'English Springer Spaniel','英國小獵鷸犬',7),(43,'American Cocker Spaniel','美國可卡獵犬',7),(44,'Harrier','哈尼耳獵犬',7),(45,'Posavac Hound','保沙瓦獵犬',7),(46,'Finnish Hound','芬蘭獵犬',7),(47,'French Bulldog','法國鬥牛犬',7),(48,'Cirneco dell’Etna','西西里獵犬',7),(49,'Brittany Spaniel','布烈塔尼獵犬',7),(50,'Basset Hound','巴吉度獵犬',7),(51,'Scottish Terrier','蘇格蘭挭',7),(52,'Samoyed','薩摩耶犬',7),(53,'Boxer','拳獅犬',7),(54,'Finnish Spitz','芬蘭狐狸犬',7),(55,'Pomeranian','博美犬',8),(56,'Maltese','瑪爾濟斯犬',8),(57,'Shiba Inu','柴犬',8),(58,'Border Terrier','邊境挭',8),(59,'Spaniel : Papillon','西班牙獵犬：蝴蝶犬',8),(60,'Miniature Duchshund Wirehair','剛毛迷你臘腸狗',8),(61,'Standard Poodle','標準型貴賓犬',8),(62,'Miniature Duchshund Shorthair','短毛迷你臘腸狗',8),(63,'Chihuahua Shorthair','短毛型吉娃娃犬',8),(64,'Miniature Poodle','迷你型貴賓狗',8),(65,'Yorkshire Terrier','約克夏挭',8),(66,'King Charles Spaniel','查理王小獵犬',8),(67,'Miniature Duchshund Longhair','長毛迷你臘腸狗',8),(68,'Chihuahua Longhair','長毛型吉娃娃犬',8),(69,'West Highland White Terrier','西高地白挭',8),(70,'Shih Tzu','西施犬',8),(71,'Schipperke','史奇派克犬',8),(72,'Pekingese','北京狗',8),(73,'Japanese Chin','日本狆',8),(74,'Pug','巴哥犬',8),(75,'Dandie Dinmont Terrier','丹第丁蒙挭',8),(76,'Staffordshire Bull Terrier','斯塔福郡鬥牛梗',8),(77,'English Bulldog','英國鬥牛犬',8),(78,'Artesian Basset','阿特西獵犬',8),(79,'Boston Terrier','波士頓梗',8),(80,'Beagle','米格魯獵犬',8),(81,'Norwich Terrier','諾威奇梗',8),(82,'Manchester Terrier','曼徹斯特梗',8),(83,'Lhasa Apso','拉薩犬',8),(84,'Himalayan','喜馬拉雅貓',9),(85,'Somali','索馬利貓',9),(86,'Cymric','威爾斯貓',9),(87,'Oriental Longhair','東方長毛貓',9),(88,'Japanese Bobtail Longhair','日本短尾長毛貓',9),(89,'Scottish Fold Longhair','蘇格蘭摺耳長毛貓',9),(90,'Maine Coon','緬因貓',9),(91,'Norwegian Forest Cat','挪威森林貓',9),(92,'American Curl Longhair','美國捲耳貓',9),(93,'Balinese','巴里貓',9),(94,'Ragdoll','布偶貓',9),(95,'Persian Longhair','波斯貓',9),(96,'Birman','伯曼貓',9),(97,'Brown Spotted','西伯利亞貓',9),(98,'Angora','安哥拉貓',9),(99,'Scottish Fold','蘇格蘭摺耳貓',10),(100,'European Shorthair','歐洲短毛貓',10),(101,'Ocicat','歐西貓',10),(102,'Devon','得文捲毛貓',10),(103,'Munchkin','曼基康貓',10),(104,'Chartreux','夏爾特流貓',10),(105,'British Shorthair','英國短毛貓',10),(106,'American Bobtail','美國短尾貓',10),(107,'American Curl Shorthair','美國捲耳貓',10),(108,'Bombay','孟買貓',10),(109,'Bengal','孟加拉貓',10),(110,'Sphynx','加拿大無毛貓',10),(111,'Siamese','暹邏貓',10),(112,'Burmese','緬甸貓',10),(113,'Singapura','新加坡貓',10),(114,'Manx','曼島貓',10),(115,'Egyptian Mau','埃及貓',10),(116,'American Shorthair','美國短毛貓',10),(117,'Korat','科拉特貓',10),(118,'Cornigh Rex','柯尼斯捲毛貓',10),(119,'Russian Blue','俄國短毛貓',10),(120,'Abyssinian','阿比西尼亞貓',10),(121,'Tonkinese','東奇尼貓',10),(122,'Oriental Shorthair','東方短毛貓',10),(123,'Japanese Bobtail','日本短尾貓',10),(124,'Havana','哈瓦那貓',10);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devices`
--

DROP TABLE IF EXISTS `devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devices` (
  `did` int(11) NOT NULL AUTO_INCREMENT,
  `serial_number` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `message` text,
  `expiry_date` date DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `battery_status` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `open` char(1) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `lost_message` text,
  `lost_date` text,
  `lost_time` text,
  `lost_location` text,
  `lost_spec` text,
  `lost_contact_id` int(11) DEFAULT NULL,
  `sso_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`did`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devices`
--

LOCK TABLES `devices` WRITE;
/*!40000 ALTER TABLE `devices` DISABLE KEYS */;
INSERT INTO `devices` VALUES (6,'KB2A56XFKMX',NULL,NULL,NULL,'upload/b3d8e99f0ed30c84a20d6e6b197803ca-pic-01.png',NULL,'2015-12-31',120.574,211.32,'low',NULL,'n','franky@ink.net.tw',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'3e8a54fd43234d0ba1304aaf499c4c95'),(15,'BD1B46XFKMX','','Pets','birdie',NULL,NULL,'2016-05-31',NULL,NULL,NULL,'dogs',NULL,'franky@ink.net.tw',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'3e8a54fd43234d0ba1304aaf499c4c95'),(17,'AB4B46XFKMX',NULL,'All',NULL,'http://babysearchapi.franky.com/upload/85fd689f093e8282bffe45533d804060-201162813412527.jpg',NULL,'2016-05-31',NULL,NULL,NULL,NULL,'N','franky@ink.net.tw',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'3e8a54fd43234d0ba1304aaf499c4c95'),(18,'DB4D46XFKMX','normal','valuable','iphone','asdfda123374.png','Please contact my owner at 62387654','2016-05-31',NULL,NULL,NULL,'cell phone','N','terry@ink.net.tw',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(21,'INK46XFKMX','normal','pet',NULL,NULL,NULL,'2016-05-31',NULL,NULL,NULL,'cats','N','ike@ink.net.tw',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(22,'P1B2F6XFKMX','normal','Pets',NULL,NULL,NULL,'2016-05-31',NULL,NULL,NULL,NULL,'N','watson@ink.net.tw',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(23,'M1N2F6XFKMX','normal','Human',NULL,NULL,NULL,'2016-05-31',NULL,NULL,NULL,NULL,'N','watson@ink.net.tw',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(24,'T1Q2F6XFKMX','normal','Valuables',NULL,NULL,NULL,'2016-05-31',NULL,NULL,NULL,NULL,'N','watson@ink.net.tw',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(25,'A1B2F6XFKMX','normal','All',NULL,NULL,NULL,'2016-05-31',NULL,NULL,NULL,NULL,'N','watson@ink.net.tw',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(34,'T1A2F6XFKMX',NULL,'Valuables','iphone',NULL,NULL,'2016-05-31',NULL,NULL,NULL,NULL,'N','franky@ink.net.tw',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'3e8a54fd43234d0ba1304aaf499c4c95'),(35,'T1B1C1XFKMX','normal','Valuables','necklace',NULL,NULL,'2016-05-31',NULL,NULL,NULL,NULL,'N','franky@ink.net.tw',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'3e8a54fd43234d0ba1304aaf499c4c95'),(36,'P1B1C1XFKMX','normal','Pets','jimmy',NULL,NULL,'2016-05-31',NULL,NULL,NULL,NULL,'N','franky@ink.net.tw',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'3e8a54fd43234d0ba1304aaf499c4c95'),(37,'T1B1A6XFKMX','normal','Valuables','xbox one',NULL,NULL,'2016-05-31',NULL,NULL,NULL,NULL,'N','franky@ink.net.tw',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'3e8a54fd43234d0ba1304aaf499c4c95'),(39,'P1Q000000000001','normal','Pets','babyG',NULL,NULL,'2016-05-31',NULL,NULL,NULL,'dogs','y','franky@ink.net.tw',NULL,'2015-06-04 16:39:32',NULL,NULL,NULL,NULL,NULL,NULL,'3e8a54fd43234d0ba1304aaf499c4c95'),(40,'P1Q000000000002','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(41,'P1Q000000000003','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(42,'P1Q000000000004','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(43,'P1Q000000000005','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(44,'P1Q000000000006','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(45,'P1Q000000000007','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(46,'P1Q000000000008',NULL,'Pets','witchhunter','upload/f7ac121436f78e30a23b3de3e37fbb94-pic-01.png',NULL,'2016-05-31',NULL,NULL,NULL,'cats','N','franky@ink.net.tw',NULL,'2015-06-09 12:21:46',NULL,NULL,NULL,NULL,NULL,NULL,'3e8a54fd43234d0ba1304aaf499c4c95'),(47,'P1Q000000000009','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(48,'P1Q00000000000A','normal','Pets','orange',NULL,NULL,'2016-05-31',NULL,NULL,NULL,'','N','franky@ink.net.tw',NULL,'2015-06-10 15:37:16',NULL,NULL,NULL,NULL,NULL,NULL,'3e8a54fd43234d0ba1304aaf499c4c95'),(49,'P1Q00000000000B','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(50,'P1Q00000000000C','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(51,'P1Q00000000000D','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(52,'P1Q00000000000E','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(53,'P1Q00000000000F','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(54,'P1Q00000000000G','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(55,'P1Q00000000000H','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(56,'P1Q00000000000I','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(57,'P1Q00000000000J','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(58,'P1Q00000000000K','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(61,'M1N000000000001','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(62,'M1N000000000002','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(63,'M1N000000000003','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(64,'M1N000000000004','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(65,'M1N000000000005','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(66,'M1N000000000006','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(67,'M1N000000000007','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(68,'M1N000000000008','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(69,'M1N000000000009','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(70,'M1N00000000000A','normal','Human','j','upload/2f6281623020988daa0d0e7c0c0b0c3f-icon-01.png',NULL,'2016-05-31',NULL,NULL,NULL,NULL,'n','franky@ink.net.tw',NULL,'2015-06-09 11:51:48',NULL,NULL,NULL,NULL,NULL,NULL,'3e8a54fd43234d0ba1304aaf499c4c95'),(71,'M1N00000000000B','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(72,'M1N00000000000C','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(73,'M1N00000000000D','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(74,'M1N00000000000E','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(75,'M1N00000000000F','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(76,'M1N00000000000G','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(77,'M1N00000000000H','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(78,'M1N00000000000I','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(79,'M1N00000000000J','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(80,'M1N00000000000K','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(84,'P1B000000000001','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(85,'P1B000000000002','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(86,'P1B000000000003','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(87,'P1B000000000004','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(88,'P1B000000000005','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(89,'P1B000000000006','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(90,'P1B000000000007','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(91,'P1B000000000008','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(92,'P1B000000000009','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(93,'P1B00000000000A','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(94,'P1B00000000000B','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(95,'P1B00000000000C','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(96,'P1B00000000000D','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(97,'P1B00000000000E','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(98,'P1B00000000000F','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(99,'P1B00000000000G','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(100,'P1B00000000000H','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(101,'P1B00000000000I','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(102,'P1B00000000000J','new',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(103,'P1B00000000000K','normal','Pets',NULL,NULL,NULL,'2016-05-31',NULL,NULL,NULL,NULL,'N','ike@ink.net.tw',NULL,'2015-06-08 04:36:45',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guestbook`
--

DROP TABLE IF EXISTS `guestbook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `guestbook` (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `message` text,
  `email` varchar(255) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `did` int(11) NOT NULL,
  `checked` char(1) DEFAULT 'N',
  PRIMARY KEY (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guestbook`
--

LOCK TABLES `guestbook` WRITE;
/*!40000 ALTER TABLE `guestbook` DISABLE KEYS */;
/*!40000 ALTER TABLE `guestbook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `human_info`
--

DROP TABLE IF EXISTS `human_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `human_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `height` double DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `bloodtype` varchar(255) DEFAULT NULL,
  `disease` varchar(255) DEFAULT NULL,
  `disability` varchar(255) DEFAULT NULL,
  `medications` text,
  `hospital_name` varchar(255) DEFAULT NULL,
  `hospital_phone` int(11) DEFAULT NULL,
  `hospital_address` varchar(255) DEFAULT NULL,
  `hospital_city` varchar(255) DEFAULT NULL,
  `hospital_district` varchar(255) DEFAULT NULL,
  `hospital_postal` varchar(255) DEFAULT NULL,
  `hospital_country` varchar(255) DEFAULT NULL,
  `did` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `human_info`
--

LOCK TABLES `human_info` WRITE;
/*!40000 ALTER TABLE `human_info` DISABLE KEYS */;
INSERT INTO `human_info` VALUES (1,'david',NULL,'db7','male','1981-10-10',180,75,'O','flu','','sleeping pills','UK general hospital',1177777777,'big ben tower, united kingdom.',NULL,NULL,NULL,NULL,16),(2,'george',NULL,'gwbaby','male','2001-10-10',20,35,'O','','','','US general hospital',72017777,'statue of freedom, america.',NULL,NULL,NULL,NULL,19),(3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,23),(4,'jaye',NULL,'j',NULL,'2014-04-05',103,35,'o','Array','Array','vitamins','baptist hospital hk',2147483647,'kowloon tong',NULL,NULL,NULL,NULL,70);
/*!40000 ALTER TABLE `human_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lost_contacts`
--

DROP TABLE IF EXISTS `lost_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lost_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `sso_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lost_contacts`
--

LOCK TABLES `lost_contacts` WRITE;
/*!40000 ALTER TABLE `lost_contacts` DISABLE KEYS */;
INSERT INTO `lost_contacts` VALUES (25,'anita','mui',456948123,'franky@ink.net.tw','3e8a54fd43234d0ba1304aaf499c4c95'),(26,'peter','pan',21348123,'franky@ink.net.tw','3e8a54fd43234d0ba1304aaf499c4c95'),(27,'bill','gates',987948123,'franky@ink.net.tw','3e8a54fd43234d0ba1304aaf499c4c95');
/*!40000 ALTER TABLE `lost_contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mobiles`
--

DROP TABLE IF EXISTS `mobiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mobiles` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `sso_id` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `imei` bigint(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mobiles`
--

LOCK TABLES `mobiles` WRITE;
/*!40000 ALTER TABLE `mobiles` DISABLE KEYS */;
INSERT INTO `mobiles` VALUES (6,'3e8a54fd43234d0ba1304aaf499c4c95','211842940015970|tcOoRAAQrWcDm_84h3O7NN7Z9DM',353328054557408,'franky@ink.net.tw'),(7,'','288942940015970|tcOoRAAQrWcDm_84h3O7NN7Z9DM',394857392038576,'franky@ink.net.tw'),(8,'','288942940015970|tcOoRAAQrWcDm_84h3O7NN7Z9DM',288857392038576,'franky@ink.net.tw'),(13,'123457392038576','123442940015970|tcOoRAAQrWcDm_84h3O7NN7Z9DM',NULL,'watson@ink.net.tw'),(14,'432157392038576','432142940015970|tcOoRAAQrWcDm_84h3O7NN7Z9DM',NULL,'ike@ink.net.tw'),(15,'678957392038576','678942940015970|tcOoRAAQrWcDm_84h3O7NN7Z9DM',NULL,'terry@ink.net.tw'),(16,'110015553140980403131','3416295cce88135274dc5a20d884d2ad373d84223cb8af38043e1f640cb4d401',NULL,'sanyouwang@gmail.com'),(17,'110015553140980403131','1234295cce88135274dc5a20d884d2ad373d84223cb8af38043e1f640cb4d401',NULL,'sanyouwang@gmail.com');
/*!40000 ALTER TABLE `mobiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pet_info`
--

DROP TABLE IF EXISTS `pet_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pet_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `height` double DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `temperament` varchar(255) DEFAULT NULL,
  `talents` varchar(255) DEFAULT NULL,
  `description` text,
  `chip_number` varchar(255) DEFAULT NULL,
  `desex` varchar(255) DEFAULT NULL,
  `vaccine_type` varchar(255) DEFAULT NULL,
  `bloodtype` varchar(255) DEFAULT NULL,
  `bloodbank` varchar(255) DEFAULT NULL,
  `disability` varchar(255) DEFAULT NULL,
  `insurance` varchar(255) DEFAULT NULL,
  `hospital_name` varchar(255) DEFAULT NULL,
  `hospital_phone` int(11) DEFAULT NULL,
  `hospital_address` varchar(255) DEFAULT NULL,
  `did` int(11) NOT NULL,
  `hospital_city` varchar(255) DEFAULT NULL,
  `hospital_district` varchar(255) DEFAULT NULL,
  `hospital_postal` varchar(255) DEFAULT NULL,
  `hospital_country` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pet_info`
--

LOCK TABLES `pet_info` WRITE;
/*!40000 ALTER TABLE `pet_info` DISABLE KEYS */;
INSERT INTO `pet_info` VALUES (10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,31,NULL,NULL,NULL,NULL),(11,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,32,NULL,NULL,NULL,NULL),(12,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,33,NULL,NULL,NULL,NULL),(13,'jimmy',NULL,'2015-06-01',0,0,'pet_otherTemperament','pet_otherTalents','','123456',NULL,'','',NULL,'pet_otherDisability','','',0,'',36,NULL,NULL,NULL,NULL),(16,'babyG','CHECKED','2015-06-01',35,15,'Array','Array','babyG is my new pet and she\'s a very nice dog','3214214asd','CHECKED','general vaccine','B',NULL,'Array','fd12314a','general hospital taipei',632480912,'101 building',39,'taipei','big on district','102-302','taiwan'),(17,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,103,NULL,NULL,NULL,NULL),(18,'witchhunter','m','2015-06-01',23,12,'????,????,','??,??,','witchhunter is fun!','48395jasdhf','','flu vaccine','ab','','??,??,','21343532','first class hospital',3456789,'west door gate',46,'new york','','','united states'),(19,'orange',NULL,'0000-00-00',0,0,'','','','ak219389341',NULL,'','',NULL,'','','',0,'',48,'','','','');
/*!40000 ALTER TABLE `pet_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photos`
--

DROP TABLE IF EXISTS `photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo` varchar(255) DEFAULT NULL,
  `did` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photos`
--

LOCK TABLES `photos` WRITE;
/*!40000 ALTER TABLE `photos` DISABLE KEYS */;
INSERT INTO `photos` VALUES (1,NULL,22),(2,NULL,23),(3,NULL,24),(4,NULL,25),(5,NULL,103),(6,'upload/9a67bcec1f47ab536434670e048e10e2-icon-04.png',39),(7,'upload/406a5315749925c94b40e10c871f03c6-bu-01.png',39);
/*!40000 ALTER TABLE `photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `sex` char(1) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `sso_id` varchar(255) NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `postal` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (19,'franky','li','frankyli','franky@ink.net.tw',30624700,'the peak','franky','2009-01-01','m','/upload/2532a1a6fe3c83ab4adbed3e66a4275a-bu-02.png','3e8a54fd43234d0ba1304aaf499c4c95','hong kong','shatin','001-002','China'),(22,NULL,NULL,'watson','watson@ink.net.tw',0,'','wt','0000-00-00',NULL,NULL,'',NULL,NULL,NULL,NULL),(23,NULL,NULL,'ike','ike@ink.net.tw',612333456,'101 bdlg., taipei.','keyman','1990-02-02','M','whatthedklf.png','',NULL,NULL,NULL,NULL),(24,NULL,NULL,'terry','terry@ink.net.tw',91233456,'the peak, hong kong.','sausage','1990-01-01','M','ajsdklf.png','',NULL,NULL,NULL,NULL),(25,NULL,NULL,NULL,'sanyouwang@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL),(26,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,'456957392038576',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valuable_info`
--

DROP TABLE IF EXISTS `valuable_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `valuable_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `did` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valuable_info`
--

LOCK TABLES `valuable_info` WRITE;
/*!40000 ALTER TABLE `valuable_info` DISABLE KEYS */;
INSERT INTO `valuable_info` VALUES (1,'iphone 6','moms birthday present',17),(2,NULL,NULL,18),(3,NULL,NULL,24),(4,NULL,NULL,34),(5,'necklace','',35),(6,'xbox one','present from last christmas',37);
/*!40000 ALTER TABLE `valuable_info` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-06-11 10:40:26
