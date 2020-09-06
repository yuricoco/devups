-- mysqldump-php https://github.com/ifsnop/mysqldump-php
--
-- Host: localhost	Database: loik_food_bd
-- ------------------------------------------------------
-- Server version 	5.5.5-10.4.11-MariaDB
-- Date: Mon, 15 Jun 2020 18:02:48 +0200

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
-- Table structure for table `cart`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creationdate` datetime NOT NULL,
  `status` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `totalprice` int(11) NOT NULL,
  `discount` int(11) DEFAULT NULL,
  `dvups_admin_id` int(11) DEFAULT NULL,
  `table_room_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BA388B7AD8C93FE` (`dvups_admin_id`),
  KEY `IDX_BA388B75624319C` (`table_room_id`),
  CONSTRAINT `FK_BA388B75624319C` FOREIGN KEY (`table_room_id`) REFERENCES `table_room` (`id`),
  CONSTRAINT `FK_BA388B7AD8C93FE` FOREIGN KEY (`dvups_admin_id`) REFERENCES `dvups_admin` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `cart` VALUES (1,'2020-06-11 19:21:25','ordered',4000,NULL,15,1),(2,'2020-06-11 19:24:31','ordered',5000,NULL,15,44),(3,'2020-06-11 19:25:57','ordered',1000,NULL,15,45),(4,'2020-06-11 19:29:39','ordered',1900,NULL,15,46),(5,'2020-06-11 19:40:28','ordered',6800,NULL,15,51),(6,'2020-06-11 19:56:39','ordered',9500,NULL,15,49),(7,'2020-06-11 20:01:04','ordered',4250,NULL,15,51),(8,'2020-06-11 20:20:48','ordered',19300,NULL,15,9),(9,'2020-06-11 20:23:28','ordered',6800,NULL,15,1),(10,'2020-06-11 20:27:16','ordered',9500,NULL,15,49),(11,'2020-06-11 20:34:31','ordered',7800,NULL,15,45),(12,'2020-06-11 20:51:39','ordered',4000,NULL,15,53),(13,'2020-06-11 20:55:15','ordered',3500,NULL,15,49),(14,'2020-06-11 20:56:56','ordered',5500,NULL,15,45),(15,'2020-06-11 20:59:46','ordered',9000,NULL,15,44),(16,'2020-06-11 21:01:17','ordered',9000,NULL,15,1),(17,'2020-06-11 21:20:56','ordered',1200,NULL,15,1),(18,'2020-06-12 14:37:38','ordered',14200,NULL,15,1),(19,'2020-06-12 16:18:17','ordered',3000,NULL,15,1),(20,'2020-06-12 16:22:16','ordered',8600,NULL,15,47),(21,'2020-06-12 16:32:24','ordered',8000,NULL,15,51),(22,'2020-06-12 16:33:59','ordered',5800,NULL,15,49),(23,'2020-06-13 23:33:59','ordered',2500,NULL,1,1),(24,'2020-06-13 23:49:06','ordered',4500,NULL,1,44),(25,'2020-06-14 00:32:48','ordered',3500,NULL,1,10),(26,'2020-06-14 00:47:51','ordered',3500,NULL,1,12),(27,'2020-06-14 00:48:17','ordered',3000,NULL,1,12),(28,'2020-06-14 01:17:28','ordered',4900,NULL,1,11),(29,'2020-06-14 10:06:39','ordered',13600,NULL,1,16);
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `cart` with 29 row(s)
--

--
-- Table structure for table `cart_item`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `weight` int(11) DEFAULT NULL,
  `menu` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `support` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantityrule` double DEFAULT NULL,
  `description` varchar(125) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F0FE25274584665A` (`product_id`),
  KEY `IDX_F0FE25271AD5CDBF` (`cart_id`),
  CONSTRAINT `FK_F0FE25271AD5CDBF` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`),
  CONSTRAINT `FK_F0FE25274584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_item`
--

LOCK TABLES `cart_item` WRITE;
/*!40000 ALTER TABLE `cart_item` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `cart_item` VALUES (1,87,1,1,1000,NULL,'drink','','ordered',0,' Djino / BOISSON GAZEUSE  / '),(2,55,1,1,3000,NULL,'food','','ordered',1,'1/4Poulet / '),(3,152,2,1,1000,NULL,'drink','','ordered',1,'Thé / '),(4,152,2,1,1000,NULL,'drink','','ordered',1,'Thé / '),(5,37,2,1,1500,NULL,'food','','ordered',1,'Hamburger / '),(6,4,2,1,1500,NULL,'food','','ordered',1,'Salade de Crudités / '),(7,87,3,1,1000,NULL,'drink','','ordered',0,' Djino / BOISSON GAZEUSE  / '),(8,161,4,1,400,NULL,'food','','ordered',1,'Brochette de Boeuf / '),(9,43,4,1,500,NULL,'food','','ordered',0,' Frites / Portion Supplémentaire / '),(10,109,4,1,1000,NULL,'drink','','ordered',1,'  Guinness p.m / '),(11,23,5,1,3300,NULL,'food','Riz Blanc','ordered',1,'Ndolè Viande / Riz Blanc'),(12,87,5,2,1000,NULL,'drink','','ordered',0,' Djino / BOISSON GAZEUSE  / '),(13,37,5,1,1500,NULL,'food','','ordered',1,'Hamburger / '),(14,113,6,1,1500,NULL,'drink','','ordered',1,' Booster / '),(15,118,6,1,1000,NULL,'drink','','ordered',1,'Smirnoff / '),(16,226,6,1,4000,NULL,'food',' Plantains Frits','ordered',1,'Ndole porc /  Plantains Frits'),(17,10,6,1,3000,NULL,'food',' Miondo','ordered',1,'Poulet Sauce Basquaise /  Miondo'),(18,25,7,1,4000,NULL,'food',' Miondo','ordered',1,'Ndolè Poulet /  Miondo'),(19,225,7,1,250,NULL,'food','','ordered',1,'Barquette / '),(20,226,8,1,4000,NULL,'food',' Frites','ordered',1,'Ndole porc /  Frites'),(21,226,8,1,4000,NULL,'food',' Plantains Frits','ordered',1,'Ndole porc /  Plantains Frits'),(22,23,8,1,3300,NULL,'food',' Miondo','ordered',1,'Ndolè Viande /  Miondo'),(23,61,8,1,3500,NULL,'food',' Miondo','ordered',1,' porc grille /  Miondo'),(24,225,8,1,250,NULL,'food','','ordered',1,'Barquette / '),(25,225,8,5,250,NULL,'food','','ordered',1,'Barquette / '),(26,49,8,1,3000,375,'food','','ordered',1,' Bars / '),(27,23,9,1,3300,NULL,'food',' Miondo','ordered',1,'Ndolè Viande /  Miondo'),(28,87,9,2,1000,NULL,'drink','','ordered',0,' Djino / BOISSON GAZEUSE  / '),(29,37,9,1,1500,NULL,'food','','ordered',1,'Hamburger / '),(30,113,10,1,1500,NULL,'drink','','ordered',1,' Booster / '),(31,118,10,1,1000,NULL,'drink','','ordered',1,'Smirnoff Ice / '),(32,226,10,1,4000,NULL,'food',' Plantains Frits','ordered',1,'Ndole porc /  Plantains Frits'),(33,10,10,1,3000,NULL,'food','','ordered',1,'Poulet Sauce Basquaise / '),(34,118,11,1,1000,NULL,'drink','','ordered',1,'Smirnoff Ice / '),(35,23,11,1,3300,NULL,'food',' Plantains Frits','ordered',1,'Ndolè Viande /  Plantains Frits'),(36,15,11,1,2500,NULL,'food','','ordered',1,'Spaghetti Bolognaise / '),(37,118,11,1,1000,NULL,'drink','','ordered',1,'Smirnoff Ice / '),(38,55,12,1,3000,NULL,'food','Riz Blanc','ordered',1,'1/4Poulet / Riz Blanc'),(39,89,12,1,1000,NULL,'drink','','ordered',0,' Coca-Cola / BOISSON GAZEUSE  / '),(40,160,13,4,500,NULL,'food','','ordered',1,'Brochette de Rognon / '),(41,43,13,1,500,NULL,'food','','ordered',0,' Frites / Portion Supplémentaire / '),(42,94,13,1,1000,NULL,'drink','','ordered',1,'jus naturel / '),(43,14,14,1,3500,NULL,'food',' Miondo','ordered',1,'Rognons de Bœuf à la Provençale /  Miondo'),(44,89,14,1,1000,NULL,'drink','','ordered',0,' Coca-Cola / BOISSON GAZEUSE  / '),(45,118,14,1,1000,NULL,'drink','','ordered',1,'Smirnoff Ice / '),(46,206,15,1,4000,NULL,'food','','ordered',1,'poisson frais / '),(47,55,15,1,3000,NULL,'food','','ordered',1,'1/4Poulet / '),(48,94,15,1,1000,NULL,'drink','','ordered',1,'jus naturel / '),(49,94,15,1,1000,NULL,'drink','','ordered',1,'jus naturel / '),(50,228,16,1,3000,NULL,'food',' Frites','ordered',1,'ndole poisson fume /  Frites'),(51,206,16,1,4000,NULL,'food','','ordered',1,'poisson frais / '),(52,170,16,1,1000,NULL,'drink','','ordered',1,'beaufort ordinaire / '),(53,79,16,1,1000,NULL,'drink','','ordered',1,'Eau Minérale Plate 1 / '),(54,161,17,3,400,NULL,'food','','ordered',1,'Brochette de Boeuf / '),(55,108,18,1,1000,NULL,'drink','','ordered',1,' Beaufort tango / '),(56,79,18,1,1000,NULL,'drink','','ordered',1,'Eau Minérale Plate 1 / '),(57,33,18,1,9000,NULL,'food','','ordered',1,'Poulet D.G ( entier) / '),(58,4,18,1,1500,NULL,'food','','ordered',1,'Salade de Crudités / '),(59,43,18,1,500,NULL,'food','','ordered',0,' Frites / Portion Supplémentaire / '),(60,159,18,6,200,NULL,'food','','ordered',1,'Boulette de viande / '),(61,160,19,2,500,NULL,'food','','ordered',1,'Brochette de Rognon / '),(62,107,19,1,1000,NULL,'drink','','ordered',1,' Mützig / '),(63,107,19,1,1000,NULL,'drink','','ordered',1,' Mützig / '),(64,23,20,2,3300,NULL,'food',' Plantains Frits, Miondo','ordered',1,'Ndolè Viande /  Plantains Frits, Miondo'),(65,89,20,1,1000,NULL,'drink','','ordered',0,' Coca-Cola / BOISSON GAZEUSE  / '),(66,86,20,1,1000,NULL,'drink','','ordered',0,' Fanta / BOISSON GAZEUSE  / '),(67,165,21,1,3000,NULL,'food','Riz Blanc','ordered',1,'Tripe / Riz Blanc'),(68,165,21,1,3000,NULL,'food',' Plantains Frits','ordered',1,'Tripe /  Plantains Frits'),(69,88,21,1,1000,NULL,'drink','','ordered',0,' Vimto / BOISSON GAZEUSE  / '),(70,89,21,1,1000,NULL,'drink','','ordered',0,' Coca-Cola / BOISSON GAZEUSE  / '),(71,4,22,1,1500,NULL,'food','','ordered',1,'Salade de Crudités / '),(72,23,22,1,3300,NULL,'food',' Plantains Frits','ordered',1,'Ndolè Viande /  Plantains Frits'),(73,79,22,1,1000,NULL,'drink','','ordered',1,'Eau Minérale Plate 1 / '),(74,15,23,1,2500,NULL,'food',' Frites','ordered',1,'Spaghetti Bolognaise /  Frites'),(75,15,24,1,2500,NULL,'food',' Frites','ordered',1,'Spaghetti Bolognaise /  Frites'),(76,109,24,1,1000,NULL,'drink','','ordered',1,'  Guinness p.m / '),(77,176,24,1,1000,NULL,'drink','','ordered',1,'top ananas / '),(78,15,25,1,2500,NULL,'food',' Frites','ordered',1,'Spaghetti Bolognaise /  Frites'),(79,109,25,1,1000,NULL,'drink','','ordered',1,'  Guinness p.m / '),(80,15,26,1,2500,NULL,'food',' Plantains Frits','ordered',1,'Spaghetti Bolognaise /  Plantains Frits'),(81,89,26,1,1000,NULL,'drink','','ordered',0,' Coca-Cola / BOISSON GAZEUSE  / '),(82,156,27,1,3000,NULL,'chicha','','ordered',1,'Chicha / '),(83,57,28,3,300,NULL,'food',' Plantains Frits','ordered',1,'Saucisse Chipolatas /  Plantains Frits'),(84,36,28,1,3000,NULL,'food',' Miondo','ordered',1,'Poulet Sauce d Arachide /  Miondo'),(85,85,28,1,1000,NULL,'drink','','ordered',1,'Top grenadine / '),(86,109,29,4,1000,NULL,'drink','','ordered',1,'  Guinness p.m / '),(87,123,29,2,1300,NULL,'drink','','ordered',0.05,' Martini / Conso / '),(88,123,29,1,6000,NULL,'drink','','ordered',0.25,' Martini / 1/4 bouteille / '),(89,92,29,1,1000,NULL,'drink','','ordered',0,' Malta Guinness / BOISSON GAZEUSE  / ');
/*!40000 ALTER TABLE `cart_item` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `cart_item` with 89 row(s)
--

--
-- Table structure for table `cart_item_canceled`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart_item_canceled` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_item_id` int(11) DEFAULT NULL,
  `order_purchase_id` int(11) DEFAULT NULL,
  `dvups_admin_id` int(11) DEFAULT NULL,
  `status` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `creationdate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BD9ECDA4E9B59A59` (`cart_item_id`),
  KEY `IDX_BD9ECDA44E3DC13F` (`order_purchase_id`),
  KEY `IDX_BD9ECDA4AD8C93FE` (`dvups_admin_id`),
  CONSTRAINT `FK_BD9ECDA44E3DC13F` FOREIGN KEY (`order_purchase_id`) REFERENCES `order_purchase` (`id`),
  CONSTRAINT `FK_BD9ECDA4AD8C93FE` FOREIGN KEY (`dvups_admin_id`) REFERENCES `dvups_admin` (`id`),
  CONSTRAINT `FK_BD9ECDA4E9B59A59` FOREIGN KEY (`cart_item_id`) REFERENCES `cart_item` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_item_canceled`
--

LOCK TABLES `cart_item_canceled` WRITE;
/*!40000 ALTER TABLE `cart_item_canceled` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `cart_item_canceled` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `cart_item_canceled` with 0 row(s)
--

--
-- Table structure for table `cashing`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cashing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dvups_admin_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `creationdate` datetime NOT NULL,
  `_date` date NOT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CBD45277AD8C93FE` (`dvups_admin_id`),
  KEY `IDX_CBD452778D9F6D38` (`order_id`),
  CONSTRAINT `FK_CBD452778D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  CONSTRAINT `FK_CBD45277AD8C93FE` FOREIGN KEY (`dvups_admin_id`) REFERENCES `dvups_admin` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cashing`
--

LOCK TABLES `cashing` WRITE;
/*!40000 ALTER TABLE `cashing` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `cashing` VALUES (1,15,1,'2020-06-11 21:11:11','2020-06-11',4000),(2,15,2,'2020-06-11 21:11:03','2020-06-11',5000),(3,15,3,'2020-06-11 21:10:53','2020-06-11',1000),(4,15,4,'2020-06-11 21:10:44','2020-06-11',1900),(5,15,5,'2020-06-11 21:10:33','2020-06-11',9500),(6,15,6,'2020-06-11 21:10:25','2020-06-11',6800),(7,15,7,'2020-06-11 21:10:18','2020-06-11',4250),(8,15,8,'2020-06-11 21:10:11','2020-06-11',19300),(9,15,9,'2020-06-11 21:10:03','2020-06-11',6800),(10,15,10,'2020-06-11 21:09:49','2020-06-11',9500),(11,15,11,'2020-06-11 21:09:41','2020-06-11',7800),(12,15,12,'2020-06-11 21:09:33','2020-06-11',5500),(13,15,13,'2020-06-11 21:09:25','2020-06-11',3500),(17,15,17,'2020-06-11 21:09:08','2020-06-11',4000),(18,15,18,'2020-06-11 21:08:58','2020-06-11',9000),(19,15,19,'2020-06-11 21:08:45','2020-06-11',9000),(20,15,20,'2020-06-11 21:21:27','2020-06-11',0),(21,15,21,'2020-06-12 16:30:29','2020-06-12',14200),(22,15,22,'2020-06-12 16:30:20','2020-06-12',3000),(23,15,23,'2020-06-12 16:30:08','2020-06-12',8600),(24,15,24,'2020-06-12 16:46:54','2020-06-12',8000),(25,15,25,'2020-06-12 16:46:44','2020-06-12',5800),(27,1,27,'2020-06-13 23:50:16','2020-06-13',4500),(31,1,31,'2020-06-14 02:08:58','2020-06-14',4900),(32,1,32,'2020-06-14 11:37:17','2020-06-14',12800);
/*!40000 ALTER TABLE `cashing` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `cashing` with 25 row(s)
--

--
-- Table structure for table `category`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `favicon` varchar(55) COLLATE utf8_unicode_ci DEFAULT NULL,
  `main` int(11) DEFAULT NULL,
  `name` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) DEFAULT NULL,
  `parentid` int(11) DEFAULT NULL,
  `withsomething` int(11) DEFAULT NULL,
  `quantityrule` double DEFAULT NULL,
  `supportprice` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `category` VALUES (1,'food',NULL,1,'SALADES et ENTRÉES',0,NULL,NULL,NULL,NULL),(2,'food',NULL,1,'PLATS CHAUDS',0,NULL,1,NULL,NULL),(3,NULL,NULL,NULL,'VIANDES',0,2,NULL,NULL,NULL),(4,NULL,NULL,NULL,'PÂTES',NULL,2,NULL,NULL,NULL),(5,'food',NULL,1,'POISSONS ET FRUITS DE MER',0,NULL,1,NULL,NULL),(6,'food',NULL,1,'TERROIR',0,NULL,1,NULL,NULL),(7,'food',NULL,1,'SANDWICHES ET SNACKS',NULL,NULL,NULL,NULL,NULL),(8,'food',NULL,1,'GARNITURES D\'ACCOMPAGNEMENT',NULL,NULL,NULL,NULL,NULL),(9,NULL,NULL,NULL,'Portion Supplémentaire',500,8,NULL,NULL,NULL),(10,NULL,NULL,NULL,'Portion Supplémentaire',1000,8,NULL,NULL,NULL),(11,'food',NULL,1,'GRILLADES À LA BRAISE ARDENTE',0,NULL,1,NULL,NULL),(12,NULL,NULL,NULL,'POISSON',NULL,11,NULL,NULL,NULL),(13,NULL,NULL,NULL,'VIANDES',0,11,NULL,NULL,NULL),(14,NULL,NULL,NULL,'Mixed Grilled',NULL,11,NULL,NULL,NULL),(15,'food',NULL,1,'FROMAGE',NULL,NULL,NULL,NULL,NULL),(16,'food',NULL,1,'CHARCUTERIE',NULL,NULL,NULL,NULL,NULL),(17,'food',NULL,1,'PETIT DÉJEUNER',NULL,NULL,NULL,NULL,NULL),(18,NULL,NULL,NULL,'TOAST',NULL,17,NULL,NULL,NULL),(19,NULL,NULL,NULL,'LIGHT',NULL,17,NULL,NULL,NULL),(20,'drink',NULL,1,' EAUX',0,NULL,NULL,NULL,NULL),(21,'drink',NULL,1,'SOFT DRINK',NULL,NULL,NULL,NULL,NULL),(22,NULL,NULL,NULL,'BOISSON GAZEUSE ',1000,21,NULL,NULL,NULL),(23,'drink',NULL,1,'JUS DE FRUIT',0,NULL,NULL,NULL,NULL),(24,'drink',NULL,1,'JUS DE FRUIT MAISON',0,NULL,NULL,NULL,NULL),(25,NULL,NULL,NULL,'Le verre',1000,24,NULL,NULL,NULL),(26,NULL,NULL,NULL,'La bouteille 1L',2500,24,NULL,NULL,NULL),(27,'drink',NULL,1,'SMOOTHIE',1500,NULL,NULL,NULL,NULL),(28,'drink',NULL,1,'BIÈRES',NULL,NULL,NULL,NULL,NULL),(29,'drink',NULL,1,'BIÈRES ÉTRANGÈRES',0,NULL,NULL,NULL,NULL),(30,NULL,NULL,NULL,'Bouteille p.m',1500,29,NULL,NULL,NULL),(31,NULL,NULL,NULL,'Bouteille G.M',2000,29,NULL,NULL,NULL),(32,NULL,NULL,NULL,'Cannette',2000,29,NULL,NULL,NULL),(33,'drink',NULL,1,'LIMONADE ALCOOLISÉE',0,NULL,NULL,NULL,NULL),(34,'drink',NULL,1,'APÉRITIFS',NULL,NULL,NULL,NULL,NULL),(35,'drink',NULL,NULL,'Conso',1300,34,0,0.05,NULL),(36,'drink',NULL,NULL,'1/4 bouteille',6000,34,0,0.25,NULL),(37,'drink',NULL,NULL,'1/2 bouteille',8500,34,0,0.5,NULL),(38,'drink',NULL,NULL,'01  bouteille',17000,34,0,1,NULL),(39,'drink',NULL,1,'LIQUEURS',NULL,NULL,NULL,NULL,NULL),(40,NULL,NULL,NULL,' Conso',2000,39,NULL,NULL,NULL),(41,NULL,NULL,NULL,' 1/4 bouteille',8000,39,NULL,NULL,NULL),(42,NULL,NULL,NULL,' 1/2 bouteille',16000,39,NULL,NULL,NULL),(43,NULL,NULL,NULL,' 01 bouteille',30000,39,NULL,NULL,NULL),(44,'drink',NULL,1,'VODKA',0,NULL,NULL,NULL,500),(45,NULL,NULL,NULL,'Conso',1300,44,NULL,NULL,NULL),(46,NULL,NULL,NULL,' 01 bouteille',17000,44,NULL,NULL,NULL),(47,'drink',NULL,1,'Ciroc',NULL,NULL,NULL,NULL,NULL),(48,'drink',NULL,1,'WHISKIES 06ANS',NULL,NULL,NULL,NULL,NULL),(49,NULL,NULL,NULL,'Conso',1300,48,NULL,NULL,NULL),(50,NULL,NULL,NULL,'1/4 bouteille',5000,48,NULL,NULL,NULL),(51,NULL,NULL,NULL,'1/2 bouteille',8500,48,NULL,NULL,NULL),(52,'drink',NULL,NULL,'01 bouteille',17000,48,NULL,NULL,NULL),(53,'drink',NULL,1,'WHISKIES 12 ANS CLASSIQUE',0,NULL,NULL,NULL,NULL),(54,NULL,NULL,NULL,'Conso',2000,53,NULL,NULL,NULL),(55,'',NULL,NULL,'1/4 bouteille',8000,53,NULL,NULL,NULL),(56,'',NULL,NULL,'1/2 bouteille',16000,53,NULL,NULL,NULL),(57,'',NULL,NULL,'01 bouteille',30000,53,NULL,NULL,NULL),(58,'drink',NULL,1,'WHISKIES 12 ANS PREMIUM',NULL,NULL,NULL,NULL,NULL),(59,NULL,NULL,NULL,'01 bouteille',40000,58,NULL,NULL,NULL),(60,'drink',NULL,1,'WHISKIES 15 ANS',NULL,NULL,NULL,NULL,NULL),(61,NULL,NULL,NULL,'01 bouteille',50000,60,NULL,NULL,NULL),(62,'drink',NULL,1,'WHISKIES 18 ANS',NULL,NULL,NULL,NULL,NULL),(63,NULL,NULL,NULL,'01 bouteille',70000,62,NULL,NULL,NULL),(64,'drink',NULL,1,'BOISSONS CHAUDES',0,NULL,NULL,NULL,NULL),(65,'chicha',NULL,1,' CHICHA',NULL,NULL,NULL,NULL,NULL),(66,'drink',NULL,1,'Cognac',0,NULL,0,NULL,NULL),(67,'drink',NULL,1,'Champagne',0,NULL,0,NULL,NULL),(68,'drink',NULL,1,'Vin mousseux',0,NULL,0,NULL,NULL),(69,'drink',NULL,1,'Vin rouge',0,NULL,0,NULL,NULL),(70,'drink',NULL,1,'Vin blanc',0,NULL,0,NULL,0),(71,'food',NULL,1,'PRODUIT DE  BASE',NULL,NULL,NULL,1,NULL);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `category` with 71 row(s)
--

--
-- Table structure for table `damage_product`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `damage_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `inventory_id` int(11) DEFAULT NULL,
  `quantity` double NOT NULL,
  `creationdate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_57E7BF6B4584665A` (`product_id`),
  KEY `IDX_57E7BF6B9EEA759` (`inventory_id`),
  CONSTRAINT `FK_57E7BF6B4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_57E7BF6B9EEA759` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `damage_product`
--

LOCK TABLES `damage_product` WRITE;
/*!40000 ALTER TABLE `damage_product` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `damage_product` VALUES (1,109,5,5,'2020-06-14 09:13:24'),(2,109,5,3,'2020-06-14 09:33:34');
/*!40000 ALTER TABLE `damage_product` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `damage_product` with 2 row(s)
--

--
-- Table structure for table `dvups_admin`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dvups_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dvups_role_id` int(11) DEFAULT NULL,
  `lastlogin_at` datetime DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8CD3C7C7D324ADF` (`dvups_role_id`),
  CONSTRAINT `FK_8CD3C7C7D324ADF` FOREIGN KEY (`dvups_role_id`) REFERENCES `dvups_role` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dvups_admin`
--

LOCK TABLES `dvups_admin` WRITE;
/*!40000 ALTER TABLE `dvups_admin` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `dvups_admin` VALUES (1,1,'2020-06-13 23:24:07','admin','dv_admin','d033e22ae348aeb5660fc2140aec35850c4da997'),(2,3,'2020-03-01 21:55:52','loik food','loik_f0469','f921ef85983239f78d986bd1f83cbae3689cf3f1'),(3,4,'2020-03-01 22:32:09','vendeur','vendeu4398','d475a580746255f6963d330208b403a8f110d758'),(4,6,'2020-06-11 21:03:53','Martine','Martin9127','9a3e86e7ab1171703fffaada65f206b2eaed93b9'),(5,6,'2020-06-12 16:37:45','Odile','Odile3044','0645fe6db08e2ca161a17a297953173fdf4e9a75'),(6,2,'2020-06-09 20:07:31','Stephanie','stepha1248','8b09c280860489d0e3cce69e4df7380bb7ed5a78'),(7,4,'2020-05-02 18:28:54','Cedric','Cedric0859','23eeb622e6dc6832e32f7d41f08e5a6bbd2feb49'),(8,4,'2020-03-06 17:54:08','Alphoncine','alphon5974','c6f83ed9468f334342f5222aaccd494174e6060b'),(9,4,'2020-05-02 19:07:13','Brenda','Brenda0512','0136391408892fc004baeecdb019f41d2af8c8f1'),(10,4,'2020-03-09 17:49:46','Falonne','falonn4083','c423b59be3618176a85fb961ecf5d12edb3306b6'),(11,3,'2020-06-11 16:48:02','Nadege','Nadege3956','ace0fb6156f13880942a51dd79fa02f96864dcb9'),(12,5,'2020-03-09 18:25:41','Wandji','wandji8770','cdfb225b0e275648746f9fc8385e86dd629e43c9'),(13,6,'2020-05-22 16:58:21','Christine','Christ8374','14451b8856a29cf337aaea9e6716f98d70affa9d'),(14,4,'2020-06-09 19:33:44','Viviane ','Vivian6331','e5792a86cb0f8da03b17a95e891bb09109c19557'),(15,6,'2020-06-12 16:15:00','Manuela','manuel7332','f0fe41caec4e6a9e3835b5f0f384cdf72a1193d5'),(16,4,'2020-06-09 19:59:54','Nathalie ','nathal7789','a93cf93db3ae6d491e1b4fc8c4e1d869daa36a33');
/*!40000 ALTER TABLE `dvups_admin` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `dvups_admin` with 16 row(s)
--

--
-- Table structure for table `dvups_contentlang`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dvups_contentlang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dvups_lang_id` int(11) DEFAULT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_719E2355A01057D7` (`dvups_lang_id`),
  CONSTRAINT `FK_719E2355A01057D7` FOREIGN KEY (`dvups_lang_id`) REFERENCES `dvups_lang` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dvups_contentlang`
--

LOCK TABLES `dvups_contentlang` WRITE;
/*!40000 ALTER TABLE `dvups_contentlang` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `dvups_contentlang` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `dvups_contentlang` with 0 row(s)
--

--
-- Table structure for table `dvups_entity`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dvups_entity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dvups_module_id` int(11) DEFAULT NULL,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(125) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EE7D6E47E8B9DDFF` (`dvups_module_id`),
  CONSTRAINT `FK_EE7D6E47E8B9DDFF` FOREIGN KEY (`dvups_module_id`) REFERENCES `dvups_module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dvups_entity`
--

LOCK TABLES `dvups_entity` WRITE;
/*!40000 ALTER TABLE `dvups_entity` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `dvups_entity` VALUES (1,1,'dvups_admin',NULL,'Compte Utilisateur'),(2,1,'dvups_role',NULL,NULL),(3,1,'dvups_entity','dvups-entity',NULL),(4,1,'dvups_module','dvups-module',NULL),(5,1,'dvups_right','dvups-right',NULL),(6,2,'dvups_lang','dvups-lang',NULL),(7,2,'dvups_contentlang','dvups-contentlang',NULL),(8,2,'generalinfo','generalinfo',NULL),(9,3,'category','category','Catégorie'),(10,3,'ingrediant','ingrediant',NULL),(11,3,'product','product','Produits'),(12,3,'product_ingrediant','product-ingrediant',NULL),(13,3,'promotion','promotion',NULL),(14,4,'table_room','table-room','Table de salle'),(15,5,'notification','notification',NULL),(16,6,'order','order','Commande Validée'),(17,6,'order_item','order-item',NULL),(18,8,'inventory','inventory','inventory'),(19,6,'cart','cart','Commande'),(20,6,'cart_item','cart-item',NULL),(21,6,'order_purchase','order-purchase','Bon de Commande'),(22,8,'productinventory','productinventory',NULL),(23,7,'stockexchange','stockexchange','mouvement de stock'),(24,7,'storage','storage',NULL),(25,9,'provision','provision','Approvisionnement'),(26,9,'provider','provider',NULL),(27,9,'providerproduct','providerproduct',NULL),(28,6,'cashing','cashing',NULL),(29,6,'cart_item_canceled','cart-item-canceled',NULL);
/*!40000 ALTER TABLE `dvups_entity` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `dvups_entity` with 29 row(s)
--

--
-- Table structure for table `dvups_lang`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dvups_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `_table` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `_row` int(11) NOT NULL,
  `_column` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dvups_lang`
--

LOCK TABLES `dvups_lang` WRITE;
/*!40000 ALTER TABLE `dvups_lang` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `dvups_lang` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `dvups_lang` with 0 row(s)
--

--
-- Table structure for table `dvups_module`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dvups_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `favicon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(125) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dvups_module`
--

LOCK TABLES `dvups_module` WRITE;
/*!40000 ALTER TABLE `dvups_module` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `dvups_module` VALUES (1,'ModuleAdmin','fas fa-user','Gestion Des Comptes','devups'),(2,'ModuleTranslate','fas fa-fw fa-cog',NULL,'devups'),(3,'ModuleCatalog','fas fa-archive','Catalogue Produit','loikfood'),(4,'ModuleClient','fas fa-table','Gestion Des Tables','loikfood'),(5,'ModuleNotification','fas fa-fw fa-cog',NULL,'loikfood'),(6,'ModuleSeller','fas fa-shopping-cart','Gestion des Commandes','loikfood'),(7,'ModuleStock','fas fa-exchange-alt','Stock','cashdesk'),(8,'ModuleInventory','fas fa-check','Inventaire','cashdesk'),(9,'ModuleProvider','fas fa-arrow-down','Approvisionnement','cashdesk');
/*!40000 ALTER TABLE `dvups_module` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `dvups_module` with 9 row(s)
--

--
-- Table structure for table `dvups_right`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dvups_right` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dvups_right`
--

LOCK TABLES `dvups_right` WRITE;
/*!40000 ALTER TABLE `dvups_right` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `dvups_right` VALUES (1,'create'),(2,'read'),(3,'update'),(4,'delete');
/*!40000 ALTER TABLE `dvups_right` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `dvups_right` with 4 row(s)
--

--
-- Table structure for table `dvups_right_dvups_entity`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dvups_right_dvups_entity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dvups_entity_id` int(11) DEFAULT NULL,
  `dvups_right_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D3F736CCC65E1533` (`dvups_entity_id`),
  KEY `IDX_D3F736CC9D3079DB` (`dvups_right_id`),
  CONSTRAINT `FK_D3F736CC9D3079DB` FOREIGN KEY (`dvups_right_id`) REFERENCES `dvups_right` (`id`),
  CONSTRAINT `FK_D3F736CCC65E1533` FOREIGN KEY (`dvups_entity_id`) REFERENCES `dvups_entity` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dvups_right_dvups_entity`
--

LOCK TABLES `dvups_right_dvups_entity` WRITE;
/*!40000 ALTER TABLE `dvups_right_dvups_entity` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `dvups_right_dvups_entity` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `dvups_right_dvups_entity` with 0 row(s)
--

--
-- Table structure for table `dvups_right_dvups_role`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dvups_right_dvups_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dvups_role_id` int(11) DEFAULT NULL,
  `dvups_right_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5481184C7D324ADF` (`dvups_role_id`),
  KEY `IDX_5481184C9D3079DB` (`dvups_right_id`),
  CONSTRAINT `FK_5481184C7D324ADF` FOREIGN KEY (`dvups_role_id`) REFERENCES `dvups_role` (`id`),
  CONSTRAINT `FK_5481184C9D3079DB` FOREIGN KEY (`dvups_right_id`) REFERENCES `dvups_right` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dvups_right_dvups_role`
--

LOCK TABLES `dvups_right_dvups_role` WRITE;
/*!40000 ALTER TABLE `dvups_right_dvups_role` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `dvups_right_dvups_role` VALUES (1,1,1),(2,1,2),(3,1,3),(4,1,4),(5,2,1),(6,2,2),(7,2,3),(8,2,4),(9,3,1),(10,3,2),(11,3,3),(12,3,4),(13,4,1),(14,4,2),(15,4,3),(16,5,1),(17,5,2),(18,5,3),(19,5,4),(20,6,1),(21,6,2),(22,6,3);
/*!40000 ALTER TABLE `dvups_right_dvups_role` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `dvups_right_dvups_role` with 22 row(s)
--

--
-- Table structure for table `dvups_role`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dvups_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dvups_role`
--

LOCK TABLES `dvups_role` WRITE;
/*!40000 ALTER TABLE `dvups_role` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `dvups_role` VALUES (1,'admin','admin'),(2,'manager','Manageur'),(3,'administrator','Administrateur'),(4,'service','Service'),(5,'chicha','Admin Chicha'),(6,'caisse','caisse');
/*!40000 ALTER TABLE `dvups_role` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `dvups_role` with 6 row(s)
--

--
-- Table structure for table `dvups_role_dvups_admin`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dvups_role_dvups_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dvups_admin_id` int(11) DEFAULT NULL,
  `dvups_role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8D756F20AD8C93FE` (`dvups_admin_id`),
  KEY `IDX_8D756F207D324ADF` (`dvups_role_id`),
  CONSTRAINT `FK_8D756F207D324ADF` FOREIGN KEY (`dvups_role_id`) REFERENCES `dvups_role` (`id`),
  CONSTRAINT `FK_8D756F20AD8C93FE` FOREIGN KEY (`dvups_admin_id`) REFERENCES `dvups_admin` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dvups_role_dvups_admin`
--

LOCK TABLES `dvups_role_dvups_admin` WRITE;
/*!40000 ALTER TABLE `dvups_role_dvups_admin` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `dvups_role_dvups_admin` VALUES (1,1,1);
/*!40000 ALTER TABLE `dvups_role_dvups_admin` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `dvups_role_dvups_admin` with 1 row(s)
--

--
-- Table structure for table `dvups_role_dvups_entity`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dvups_role_dvups_entity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dvups_entity_id` int(11) DEFAULT NULL,
  `dvups_role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8C25CBCBC65E1533` (`dvups_entity_id`),
  KEY `IDX_8C25CBCB7D324ADF` (`dvups_role_id`),
  CONSTRAINT `FK_8C25CBCB7D324ADF` FOREIGN KEY (`dvups_role_id`) REFERENCES `dvups_role` (`id`),
  CONSTRAINT `FK_8C25CBCBC65E1533` FOREIGN KEY (`dvups_entity_id`) REFERENCES `dvups_entity` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dvups_role_dvups_entity`
--

LOCK TABLES `dvups_role_dvups_entity` WRITE;
/*!40000 ALTER TABLE `dvups_role_dvups_entity` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `dvups_role_dvups_entity` VALUES (1,1,1),(2,2,1),(3,3,1),(4,4,1),(5,5,1),(6,6,1),(7,7,1),(8,8,1),(9,9,1),(10,10,1),(11,11,1),(12,12,1),(13,13,1),(14,14,1),(15,15,1),(16,16,1),(17,17,1),(18,18,1),(20,9,2),(22,11,2),(24,14,2),(26,16,2),(28,1,3),(29,9,3),(31,11,3),(34,14,3),(35,16,3),(38,19,1),(39,20,1),(40,19,4),(41,19,2),(42,19,3),(43,9,5),(44,11,5),(45,16,5),(46,19,5),(47,21,1),(48,14,5),(49,21,5),(50,1,5),(51,21,3),(52,21,2),(53,21,4),(54,22,1),(55,23,1),(56,24,1),(57,25,1),(58,26,1),(59,27,1),(60,18,3),(61,23,3),(62,25,3),(63,16,6),(64,19,6),(65,21,6),(66,28,1),(67,29,1),(68,28,3),(69,29,3),(70,28,2),(71,29,2),(72,28,6),(73,29,6),(74,28,5),(75,29,5);
/*!40000 ALTER TABLE `dvups_role_dvups_entity` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `dvups_role_dvups_entity` with 65 row(s)
--

--
-- Table structure for table `dvups_role_dvups_module`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dvups_role_dvups_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dvups_module_id` int(11) DEFAULT NULL,
  `dvups_role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8E29A98BE8B9DDFF` (`dvups_module_id`),
  KEY `IDX_8E29A98B7D324ADF` (`dvups_role_id`),
  CONSTRAINT `FK_8E29A98B7D324ADF` FOREIGN KEY (`dvups_role_id`) REFERENCES `dvups_role` (`id`),
  CONSTRAINT `FK_8E29A98BE8B9DDFF` FOREIGN KEY (`dvups_module_id`) REFERENCES `dvups_module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dvups_role_dvups_module`
--

LOCK TABLES `dvups_role_dvups_module` WRITE;
/*!40000 ALTER TABLE `dvups_role_dvups_module` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `dvups_role_dvups_module` VALUES (1,1,1),(2,2,1),(3,3,1),(4,4,1),(5,5,1),(6,6,1),(7,7,1),(9,3,2),(10,4,2),(11,6,2),(13,1,3),(14,6,4),(15,3,3),(16,4,3),(17,6,3),(19,3,5),(20,6,5),(22,4,5),(23,1,5),(24,8,1),(25,9,1),(26,7,3),(27,8,3),(28,9,3),(29,6,6);
/*!40000 ALTER TABLE `dvups_role_dvups_module` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `dvups_role_dvups_module` with 25 row(s)
--

--
-- Table structure for table `ingrediant`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingrediant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `productparent` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6CA6D0AC4584665A` (`product_id`),
  CONSTRAINT `FK_6CA6D0AC4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingrediant`
--

LOCK TABLES `ingrediant` WRITE;
/*!40000 ALTER TABLE `ingrediant` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `ingrediant` VALUES (1,NULL,1,208,38),(2,NULL,1,212,38),(3,NULL,1,211,38),(4,NULL,1,208,37),(5,NULL,1,212,37),(6,NULL,1,211,213),(7,NULL,2,201,34),(8,NULL,1,201,35),(9,NULL,1,207,29),(10,NULL,1,204,27),(11,NULL,1,214,29),(12,NULL,1,214,27),(13,NULL,1,214,28),(14,NULL,1,209,28),(15,NULL,1,206,210),(16,NULL,1,203,24),(17,NULL,1,201,25),(18,NULL,1,209,23),(19,NULL,1,209,26),(20,NULL,1,203,26),(21,NULL,4,201,33),(22,NULL,1,201,36),(24,NULL,1,205,159),(25,NULL,6,205,12),(26,NULL,1,200,7),(27,NULL,1,200,5),(28,NULL,1,204,8),(30,NULL,1,204,9),(31,NULL,1,201,162),(32,NULL,1,201,11),(33,NULL,1,201,10),(34,NULL,3,202,14),(35,NULL,1,203,13),(36,NULL,4,205,13),(37,NULL,2,203,16),(38,NULL,5,59,222),(39,NULL,1,59,57),(40,NULL,1,206,49),(41,NULL,1,200,62),(42,NULL,1,206,50),(43,NULL,1,206,51),(44,NULL,1,204,61),(45,NULL,4,201,60),(46,NULL,1,201,55),(47,NULL,1,202,160),(48,NULL,1,204,54),(49,NULL,1,215,15),(50,NULL,1,216,15),(51,NULL,1,200,6),(52,NULL,1,214,223),(53,NULL,1,206,223),(54,NULL,3,205,41),(55,NULL,1,203,2),(56,NULL,2,220,3),(57,NULL,1,206,19),(58,NULL,2,203,21),(59,NULL,3,220,67),(60,NULL,3,220,224),(61,NULL,1,204,226),(62,NULL,1,221,226),(63,NULL,1,221,228),(64,NULL,1,207,228);
/*!40000 ALTER TABLE `ingrediant` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `ingrediant` with 62 row(s)
--

--
-- Table structure for table `inventory`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `storage_id` int(11) DEFAULT NULL,
  `allproduct` int(11) NOT NULL,
  `creationdate` datetime NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `dvups_admin_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B12D4A365CC5DB90` (`storage_id`),
  KEY `IDX_B12D4A36AD8C93FE` (`dvups_admin_id`),
  CONSTRAINT `FK_B12D4A365CC5DB90` FOREIGN KEY (`storage_id`) REFERENCES `storage` (`id`),
  CONSTRAINT `FK_B12D4A36AD8C93FE` FOREIGN KEY (`dvups_admin_id`) REFERENCES `dvups_admin` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory`
--

LOCK TABLES `inventory` WRITE;
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `inventory` VALUES (1,4,0,'2020-05-21 15:05:39','ended',11),(5,4,0,'2020-06-11 16:49:59','ended',11),(7,1,0,'2020-06-11 19:57:49','ended',11),(12,4,0,'2020-06-14 13:35:41','in_process',1);
/*!40000 ALTER TABLE `inventory` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `inventory` with 4 row(s)
--

--
-- Table structure for table `notification`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `entity` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `entityid` int(11) NOT NULL,
  `creationdate` datetime NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seen` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `notification` with 0 row(s)
--

--
-- Table structure for table `order`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creationdate` datetime NOT NULL,
  `status` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `totalprice` int(11) NOT NULL,
  `dvups_admin_id` int(11) DEFAULT NULL,
  `discountprice` int(11) DEFAULT NULL,
  `num_facture` varchar(55) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_mode` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `e_payment_code` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `table_room_id` int(11) DEFAULT NULL,
  `printed_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `notified` int(11) NOT NULL,
  `seen` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F5299398AD8C93FE` (`dvups_admin_id`),
  KEY `IDX_F52993985624319C` (`table_room_id`),
  CONSTRAINT `FK_F52993985624319C` FOREIGN KEY (`table_room_id`) REFERENCES `table_room` (`id`),
  CONSTRAINT `FK_F5299398AD8C93FE` FOREIGN KEY (`dvups_admin_id`) REFERENCES `dvups_admin` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `order` VALUES (1,'2020-06-11 19:20:33','paid',4000,15,NULL,'00001','Cash',NULL,1,'2020-06-11 19:21:57','2020-06-11 19:21:57',1,1),(2,'2020-06-11 19:23:06','paid',5000,15,NULL,'00002','Cash',NULL,44,'2020-06-11 19:24:54','2020-06-11 19:24:54',1,1),(3,'2020-06-11 19:25:38','paid',1000,15,NULL,'00003','Cash',NULL,45,'2020-06-11 19:26:46','2020-06-11 19:26:46',1,1),(4,'2020-06-11 19:27:12','paid',1900,15,NULL,'00004','Cash',NULL,46,'2020-06-11 19:30:08','2020-06-11 19:30:08',1,1),(5,'2020-06-11 19:30:34','paid',9500,15,NULL,'00005','Cash',NULL,49,'2020-06-11 19:57:05','2020-06-11 19:57:05',1,1),(6,'2020-06-11 19:38:58','paid',6800,15,NULL,'00006','Cash',NULL,51,'2020-06-11 19:41:20','2020-06-11 19:41:20',1,1),(7,'2020-06-11 19:42:33','paid',4250,15,NULL,'00007','Cash',NULL,51,'2020-06-11 20:01:17','2020-06-11 20:01:17',1,1),(8,'2020-06-11 20:01:37','paid',19300,15,NULL,'00008','Cash',NULL,9,'2020-06-11 20:20:57','2020-06-11 20:20:57',1,1),(9,'2020-06-11 20:21:17','canceled',6800,15,NULL,'00009','Cash',NULL,1,'2020-06-11 20:23:41','2020-06-11 20:23:41',1,1),(10,'2020-06-11 20:26:14','canceled',9500,15,NULL,'00010','Cash',NULL,49,'2020-06-11 20:27:39','2020-06-11 20:27:39',1,1),(11,'2020-06-11 20:28:24','paid',7800,15,NULL,'00011','Cash',NULL,45,'2020-06-11 20:35:18','2020-06-11 20:35:18',1,1),(12,'2020-06-11 20:35:26','paid',5500,15,NULL,'00012','Cash',NULL,45,'2020-06-11 20:57:12','2020-06-11 20:57:12',1,1),(13,'2020-06-11 20:45:12','paid',3500,15,NULL,'00013','Cash',NULL,49,'2020-06-11 20:55:32','2020-06-11 20:55:32',1,1),(17,'2020-06-11 20:50:36','paid',4000,15,NULL,'00017','Cash',NULL,53,'2020-06-11 20:52:30','2020-06-11 20:52:30',1,1),(18,'2020-06-11 20:57:33','paid',9000,15,NULL,'00018','Cash',NULL,1,'2020-06-11 21:05:34','2020-06-11 21:05:34',1,1),(19,'2020-06-11 20:58:29','paid',9000,15,NULL,'00019','Cash',NULL,44,'2020-06-11 21:00:06','2020-06-11 21:00:06',1,1),(20,'2020-06-11 21:20:02','paid',1200,15,NULL,'00020','Cash',NULL,1,'2020-06-11 21:21:07','2020-06-11 21:21:07',1,1),(21,'2020-06-12 14:33:03','paid',14200,15,NULL,'00021','Cash',NULL,1,'2020-06-12 16:16:09','2020-06-12 16:16:09',1,1),(22,'2020-06-12 16:16:28','paid',3000,15,NULL,'00022','Cash',NULL,1,'2020-06-12 16:20:17','2020-06-12 16:20:17',1,1),(23,'2020-06-12 16:20:42','paid',8600,15,NULL,'00023','Cash',NULL,47,'2020-06-12 16:22:34','2020-06-12 16:22:34',1,1),(24,'2020-06-12 16:23:54','paid',8000,15,NULL,'00024','Cash',NULL,51,'2020-06-12 16:46:00','2020-06-12 16:46:00',1,1),(25,'2020-06-12 16:32:56','paid',5800,15,NULL,'00025','Cash',NULL,49,'2020-06-12 16:39:15','2020-06-12 16:39:15',1,1),(26,'2020-06-13 23:27:58','paid',2500,1,NULL,'00026','Orange Money','',1,'2020-06-13 23:35:07','2020-06-13 23:35:07',1,1),(27,'2020-06-13 23:48:10','paid',4500,1,NULL,'00027','Cash',NULL,44,'2020-06-13 23:49:51','2020-06-13 23:49:51',1,1),(29,'2020-06-14 00:32:18','paid',3500,1,NULL,'00029','Orange Money','3500',10,'2020-06-14 00:33:16','2020-06-14 00:33:16',1,1),(30,'2020-06-14 00:44:31','paid',6500,1,NULL,'00030','MTN Money','',12,'2020-06-14 00:48:26','2020-06-14 00:48:26',1,1),(31,'2020-06-14 01:16:27','paid',4900,1,NULL,'00031','Cash',NULL,11,'2020-06-14 01:50:00','2020-06-14 01:50:00',1,1),(32,'2020-06-14 09:42:00','paid',13600,1,800,'00032','Credit',NULL,16,'2020-06-14 10:44:30','2020-06-14 10:44:30',0,1);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `order` with 28 row(s)
--

--
-- Table structure for table `order_item`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `weight` int(11) DEFAULT NULL,
  `menu` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `support` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `cart_item_ids` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `quantityrule` double DEFAULT NULL,
  `status` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(125) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_52EA1F094584665A` (`product_id`),
  KEY `IDX_52EA1F098D9F6D38` (`order_id`),
  CONSTRAINT `FK_52EA1F094584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_52EA1F098D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_item`
--

LOCK TABLES `order_item` WRITE;
/*!40000 ALTER TABLE `order_item` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `order_item` VALUES (1,87,1,1,1000,' Djino',NULL,'drink','','1',0,NULL,NULL),(2,55,1,1,3000,'1/4Poulet',NULL,'food','','2',1,NULL,NULL),(3,152,2,1,1000,'Thé',NULL,'drink','','3',1,NULL,NULL),(4,152,2,1,1000,'Thé',NULL,'drink','','4',1,NULL,NULL),(5,37,2,1,1500,'Hamburger',NULL,'food','','5',1,NULL,NULL),(6,4,2,1,1500,'Salade de Crudités',NULL,'food','','6',1,NULL,NULL),(7,87,3,1,1000,' Djino',NULL,'drink','','7',0,NULL,NULL),(8,161,4,1,400,'Brochette de Boeuf',NULL,'food','','8',1,NULL,NULL),(9,43,4,1,500,' Frites',NULL,'food','','9',0,NULL,NULL),(10,109,4,1,1000,'  Guinness p.m',NULL,'drink','','10',1,NULL,NULL),(11,23,6,1,3300,'Ndolè Viande',NULL,'food','Riz Blanc','11',1,NULL,NULL),(12,87,6,2,1000,' Djino',NULL,'drink','','12',0,NULL,NULL),(13,37,6,1,1500,'Hamburger',NULL,'food','','13',1,NULL,NULL),(14,113,5,1,1500,' Booster',NULL,'drink','','14',1,NULL,NULL),(15,118,5,1,1000,'Smirnoff Ice',NULL,'drink','','15',1,NULL,NULL),(16,226,5,1,4000,'Ndole porc',NULL,'food',' Plantains Frits','16',1,NULL,NULL),(17,10,5,1,3000,'Poulet Sauce Basquaise',NULL,'food',' Miondo','17',1,NULL,NULL),(18,25,7,1,4000,'Ndolè Poulet',NULL,'food',' Miondo','18',1,NULL,NULL),(19,225,7,1,250,'Barquette',NULL,'food','','19',1,NULL,NULL),(20,226,8,1,4000,'Ndole porc',NULL,'food',' Frites','20',1,NULL,NULL),(21,226,8,1,4000,'Ndole porc',NULL,'food',' Plantains Frits','21',1,NULL,NULL),(22,23,8,1,3300,'Ndolè Viande',NULL,'food',' Miondo','22',1,NULL,NULL),(23,61,8,1,3500,' porc grille',NULL,'food',' Miondo','23',1,NULL,NULL),(24,225,8,1,250,'Barquette',NULL,'food','','24',1,NULL,NULL),(25,225,8,5,250,'Barquette',NULL,'food','','25',1,NULL,NULL),(26,49,8,1,3000,' Bars',375,'food','','26',1,NULL,NULL),(27,23,9,1,3300,'Ndolè Viande',NULL,'food',' Miondo','27',1,'canceled',NULL),(28,87,9,2,1000,' Djino',NULL,'drink','','28',0,'canceled',NULL),(29,37,9,1,1500,'Hamburger',NULL,'food','','29',1,'canceled',NULL),(30,113,10,1,1500,' Booster',NULL,'drink','','30',1,NULL,NULL),(31,118,10,1,1000,'Smirnoff Ice',NULL,'drink','','31',1,NULL,NULL),(32,226,10,1,4000,'Ndole porc',NULL,'food',' Plantains Frits','32',1,NULL,NULL),(33,10,10,1,3000,'Poulet Sauce Basquaise',NULL,'food','','33',1,NULL,NULL),(34,118,11,1,1000,'Smirnoff Ice',NULL,'drink','','34',1,NULL,NULL),(35,23,11,1,3300,'Ndolè Viande',NULL,'food',' Plantains Frits','35',1,NULL,NULL),(36,15,11,1,2500,'Spaghetti Bolognaise',NULL,'food','','36',1,NULL,NULL),(37,118,11,1,1000,'Smirnoff Ice',NULL,'drink','','37',1,NULL,NULL),(38,55,17,1,3000,'1/4Poulet',NULL,'food','Riz Blanc','38',1,NULL,NULL),(39,89,17,1,1000,' Coca-Cola',NULL,'drink','','39',0,NULL,NULL),(40,160,13,4,500,'Brochette de Rognon',NULL,'food','','40',1,NULL,NULL),(41,43,13,1,500,' Frites',NULL,'food','','41',0,NULL,NULL),(42,94,13,1,1000,'jus naturel',NULL,'drink','','42',1,NULL,NULL),(43,14,12,1,3500,'Rognons de Bœuf à la Provençale',NULL,'food',' Miondo','43',1,NULL,NULL),(44,89,12,1,1000,' Coca-Cola',NULL,'drink','','44',0,NULL,NULL),(45,118,12,1,1000,'Smirnoff Ice',NULL,'drink','','45',1,NULL,NULL),(46,206,19,1,4000,'poisson frais',NULL,'food','','46',1,NULL,NULL),(47,55,19,1,3000,'1/4Poulet',NULL,'food','','47',1,NULL,NULL),(48,94,19,1,1000,'jus naturel',NULL,'drink','','48',1,NULL,NULL),(49,94,19,1,1000,'jus naturel',NULL,'drink','','49',1,NULL,NULL),(50,228,18,1,3000,'ndole poisson fume',NULL,'food',' Frites','50',1,NULL,NULL),(51,206,18,1,4000,'poisson frais',NULL,'food','','51',1,NULL,NULL),(52,170,18,1,1000,'beaufort ordinaire',NULL,'drink','','52',1,NULL,NULL),(53,79,18,1,1000,'Eau Minérale Plate 1',NULL,'drink','','53',1,NULL,NULL),(54,161,20,3,400,'Brochette de Boeuf',NULL,'food','','54',1,NULL,NULL),(55,108,21,1,1000,' Beaufort tango',NULL,'drink','','55',1,NULL,NULL),(56,79,21,1,1000,'Eau Minérale Plate 1',NULL,'drink','','56',1,NULL,NULL),(57,33,21,1,9000,'Poulet D.G ( entier)',NULL,'food','','57',1,NULL,NULL),(58,4,21,1,1500,'Salade de Crudités',NULL,'food','','58',1,NULL,NULL),(59,43,21,1,500,' Frites',NULL,'food','','59',0,NULL,NULL),(60,159,21,6,200,'Boulette de viande',NULL,'food','','60',1,NULL,NULL),(61,160,22,2,500,'Brochette de Rognon',NULL,'food','','61',1,NULL,NULL),(62,107,22,1,1000,' Mützig',NULL,'drink','','62',1,NULL,NULL),(63,107,22,1,1000,' Mützig',NULL,'drink','','63',1,NULL,NULL),(64,23,23,2,3300,'Ndolè Viande',NULL,'food',' Plantains Frits, Miondo','64',1,NULL,NULL),(65,89,23,1,1000,' Coca-Cola',NULL,'drink','','65',0,NULL,NULL),(66,86,23,1,1000,' Fanta',NULL,'drink','','66',0,NULL,NULL),(67,165,24,1,3000,'Tripe',NULL,'','Riz Blanc','67',1,NULL,NULL),(68,165,24,1,3000,'Tripe',NULL,'',' Plantains Frits','68',1,NULL,NULL),(69,88,24,1,1000,' Vimto',NULL,'drink','','69',0,NULL,NULL),(70,89,24,1,1000,' Coca-Cola',NULL,'drink','','70',0,NULL,NULL),(71,4,25,1,1500,'Salade de Crudités',NULL,'food','','71',1,NULL,NULL),(72,23,25,1,3300,'Ndolè Viande',NULL,'food',' Plantains Frits','72',1,NULL,NULL),(73,79,25,1,1000,'Eau Minérale Plate 1',NULL,'drink','','73',1,NULL,NULL),(74,15,26,1,2500,'Spaghetti Bolognaise',NULL,'food',' Frites','74',1,NULL,NULL),(75,15,27,2,2500,'Spaghetti Bolognaise',NULL,'food',' Frites','75,75',1,NULL,NULL),(76,109,27,1,1000,'  Guinness p.m',NULL,'drink','','76',1,NULL,NULL),(77,176,27,1,1000,'top ananas',NULL,'drink','','77',1,NULL,NULL),(78,109,27,1,1000,'  Guinness p.m',NULL,'drink','','76',1,NULL,NULL),(79,176,27,1,1000,'top ananas',NULL,'drink','','77',1,NULL,NULL),(80,15,29,2,2500,'Spaghetti Bolognaise',NULL,'food',' Frites','78,78',1,NULL,NULL),(81,109,29,1,1000,'  Guinness p.m',NULL,'drink','','79',1,NULL,NULL),(82,109,29,1,1000,'  Guinness p.m',NULL,'drink','','79',1,NULL,NULL),(83,15,30,2,2500,'Spaghetti Bolognaise',NULL,'food',' Plantains Frits','80,80',1,NULL,NULL),(84,89,30,1,1000,' Coca-Cola',NULL,'drink','','81',0,NULL,NULL),(85,89,30,1,1000,' Coca-Cola',NULL,'drink','','81',0,NULL,NULL),(86,156,30,1,3000,'Chicha',NULL,'chicha','','82',1,NULL,NULL),(87,57,31,6,300,'Saucisse Chipolatas',NULL,'food',' Plantains Frits','83,83',1,NULL,NULL),(88,36,31,2,3000,'Poulet Sauce d Arachide',NULL,'food',' Miondo','84,84',1,NULL,NULL),(89,85,31,1,1000,'Top grenadine',NULL,'drink','','85',1,NULL,NULL),(90,85,31,1,1000,'Top grenadine',NULL,'drink','','85',1,NULL,NULL),(91,109,32,4,1000,'  Guinness p.m',NULL,'drink','','86',1,NULL,NULL),(92,123,32,2,1300,' Martini',NULL,'drink','','87',0.05,NULL,NULL),(93,123,32,1,6000,' Martini',NULL,'drink','','88',0.25,NULL,NULL),(94,92,32,1,1000,' Malta Guinness',NULL,'drink','','89',0,NULL,NULL);
/*!40000 ALTER TABLE `order_item` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `order_item` with 94 row(s)
--

--
-- Table structure for table `order_purchase`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `creationdate` datetime NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `totalprice` int(11) NOT NULL,
  `menu` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_80EF338A8D9F6D38` (`order_id`),
  KEY `IDX_80EF338A1AD5CDBF` (`cart_id`),
  CONSTRAINT `FK_80EF338A1AD5CDBF` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`),
  CONSTRAINT `FK_80EF338A8D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_purchase`
--

LOCK TABLES `order_purchase` WRITE;
/*!40000 ALTER TABLE `order_purchase` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `order_purchase` VALUES (1,1,1,'2020-06-11 19:21:26','printed',1000,'drink'),(2,1,1,'2020-06-11 19:21:27','printed',3000,'food'),(3,2,2,'2020-06-11 19:24:32','printed',2000,'drink'),(4,2,2,'2020-06-11 19:24:33','printed',3000,'food'),(5,3,3,'2020-06-11 19:25:58','printed',1000,'drink'),(6,4,4,'2020-06-11 19:29:41','printed',1000,'drink'),(7,4,4,'2020-06-11 19:29:41','printed',900,'food'),(8,6,5,'2020-06-11 19:40:29','printed',2000,'drink'),(9,6,5,'2020-06-11 19:40:30','printed',4800,'food'),(10,5,6,'2020-06-11 19:56:40','printed',2500,'drink'),(11,5,6,'2020-06-11 19:56:41','printed',7000,'food'),(12,7,7,'2020-06-11 20:01:05','printed',4250,'food'),(13,8,8,'2020-06-11 20:20:51','printed',19300,'food'),(14,9,9,'2020-06-11 20:23:30','canceled',2000,'drink'),(15,9,9,'2020-06-11 20:23:30','canceled',4800,'food'),(16,10,10,'2020-06-11 20:27:18','printed',2500,'drink'),(17,10,10,'2020-06-11 20:27:18','printed',7000,'food'),(18,11,11,'2020-06-11 20:34:33','printed',2000,'drink'),(19,11,11,'2020-06-11 20:34:33','printed',5800,'food'),(20,17,12,'2020-06-11 20:51:40','printed',1000,'drink'),(21,17,12,'2020-06-11 20:51:40','printed',3000,'food'),(22,13,13,'2020-06-11 20:55:16','printed',1000,'drink'),(23,13,13,'2020-06-11 20:55:17','printed',2500,'food'),(24,12,14,'2020-06-11 20:56:57','printed',2000,'drink'),(25,12,14,'2020-06-11 20:56:57','printed',3500,'food'),(26,19,15,'2020-06-11 20:59:48','printed',2000,'drink'),(27,19,15,'2020-06-11 20:59:48','printed',7000,'food'),(28,18,16,'2020-06-11 21:01:19','printed',2000,'drink'),(29,18,16,'2020-06-11 21:01:19','printed',7000,'food'),(30,20,17,'2020-06-11 21:20:56','printed',1200,'food'),(31,21,18,'2020-06-12 14:37:40','printed',2000,'drink'),(32,21,18,'2020-06-12 14:37:41','printed',12200,'food'),(33,22,19,'2020-06-12 16:18:18','printed',2000,'drink'),(34,22,19,'2020-06-12 16:18:18','printed',1000,'food'),(35,23,20,'2020-06-12 16:22:17','printed',2000,'drink'),(36,23,20,'2020-06-12 16:22:17','printed',6600,'food'),(37,24,21,'2020-06-12 16:32:25','printed',2000,'drink'),(38,24,21,'2020-06-12 16:32:25','printed',6000,'food'),(39,25,22,'2020-06-12 16:34:00','printed',1000,'drink'),(40,25,22,'2020-06-12 16:34:00','printed',4800,'food'),(41,26,23,'2020-06-13 23:34:00','printed',2500,'food'),(42,27,24,'2020-06-13 23:49:07','printed',2000,'drink'),(43,27,24,'2020-06-13 23:49:07','printed',2500,'food'),(44,29,25,'2020-06-14 00:32:49','printed',1000,'drink'),(45,29,25,'2020-06-14 00:32:49','printed',2500,'food'),(46,30,26,'2020-06-14 00:47:52','printed',1000,'drink'),(47,30,26,'2020-06-14 00:47:52','printed',2500,'food'),(48,30,27,'2020-06-14 00:48:18','printed',3000,'chicha'),(49,31,28,'2020-06-14 01:17:28','printed',1000,'drink'),(50,31,28,'2020-06-14 01:17:29','printed',3900,'food'),(51,32,29,'2020-06-14 10:06:40','printed',13600,'drink');
/*!40000 ALTER TABLE `order_purchase` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `order_purchase` with 51 row(s)
--

--
-- Table structure for table `product`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `imagedir` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit` int(11) DEFAULT NULL,
  `subcategoryid` int(11) DEFAULT NULL,
  `menu` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) DEFAULT NULL,
  `base` int(11) DEFAULT NULL,
  `quantityrule` double DEFAULT NULL,
  `withsomething` int(11) DEFAULT NULL,
  `baseid` int(11) DEFAULT NULL,
  `baseproductassupport` int(11) DEFAULT NULL,
  `namesanitize` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `consorule` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D34A04AD12469DE2` (`category_id`),
  CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=230 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `product` VALUES (1,1,'Salade d avocat',NULL,' 1500',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Salade d avocat',NULL),(2,1,'Cocktail d\'Avocat aux Crevettes',NULL,'2300',NULL,NULL,0,NULL,'food',NULL,0,1,NULL,203,NULL,'Cocktail d Avocat aux Crevettes',NULL),(3,1,'Salade de Tomate aux oeufs durs',NULL,'1800',NULL,NULL,0,NULL,'food',NULL,0,0,NULL,0,NULL,'Salade de Tomate aux oeufs durs',NULL),(4,1,'Salade de Crudités',NULL,' 1500',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Salade de Crudites',NULL),(5,2,'Filet de Bœuf Grillé',NULL,'4500',NULL,NULL,0,3,'food',NULL,0,1,NULL,200,NULL,'Filet de Boeuf Grille',NULL),(6,2,'Steak à la Crème Fraîche',NULL,'6000',NULL,NULL,0,3,'food',NULL,0,1,NULL,200,NULL,'Steak a la Creme Fraiche',NULL),(7,2,'Émincés de Bœuf aux Légumes',NULL,'3500',NULL,NULL,0,3,'food',NULL,0,1,NULL,200,NULL,'Eminces de Boeuf aux Legumes',NULL),(8,2,'Petite Marmite de Porc',NULL,'3500',NULL,NULL,0,3,'food',NULL,0,1,NULL,204,NULL,'Petite Marmite de Porc',NULL),(9,2,'Porc Grillé aux Oignons',NULL,'3500',NULL,NULL,0,3,'food',NULL,0,1,NULL,204,NULL,'Porc Grille aux Oignons',NULL),(10,2,'Poulet Sauce Basquaise',NULL,'3000',NULL,NULL,0,3,'food',NULL,0,1,NULL,201,NULL,'Poulet Sauce Basquaise',NULL),(11,2,'Poulet Mijoté dans son Jus',NULL,'3000',NULL,NULL,0,3,'food',NULL,0,1,NULL,201,NULL,'Poulet Mijote dans son Jus',NULL),(12,2,'Boulettes de Viande Hachée en Sauce',NULL,'3000',NULL,NULL,0,3,'food',NULL,0,6,NULL,205,NULL,'Boulettes de Viande Hachee en Sauce',NULL),(13,2,'Royal Rice ( riz-boulettes-crevettes)',NULL,'3800',NULL,NULL,0,3,'food',NULL,0,0,NULL,0,NULL,'Royal Rice ( riz-boulettes-crevettes)',NULL),(14,2,'Rognons de Bœuf à la Provençale',NULL,'3500',NULL,NULL,0,3,'food',NULL,0,3,NULL,202,NULL,'Rognons de Boeuf a la Provencale',NULL),(15,2,'Spaghetti Bolognaise',NULL,'2500',NULL,NULL,0,4,'food',NULL,0,0,NULL,0,NULL,'Spaghetti Bolognaise',NULL),(16,2,'Spaghetti aux Crevettes et Légumes',NULL,'3800',NULL,NULL,0,4,'food',NULL,0,2,NULL,203,NULL,'Spaghetti aux Crevettes et Legumes',NULL),(17,2,'Tagliatelles à la Carbonara',NULL,'5000',NULL,NULL,0,4,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Tagliatelles a la Carbonara',NULL),(18,2,'Penne au Blanc de Poulet',NULL,' 3800',NULL,NULL,0,4,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Penne au Blanc de Poulet',NULL),(19,5,'Bouillon de Poisson et Pomme de Terre',NULL,'3800',NULL,NULL,0,NULL,'food',NULL,0,1,NULL,206,NULL,'Bouillon de Poisson et Pomme de Terre',NULL),(20,5,'Darnes de Poisson Printanière',NULL,' 3800',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Darnes de Poisson Printaniere',NULL),(21,5,'Crevettes Grises à la Tomate Concassée',NULL,'4000',NULL,NULL,0,NULL,'food',NULL,0,2,NULL,203,NULL,'Crevettes Grises a la Tomate Concassee',NULL),(22,5,'Gambas Marinée dans son Jus d\'Aïl',NULL,' 6500',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Gambas Marinee dans son Jus d Ail',NULL),(23,6,'Ndolè Viande',NULL,'3300',NULL,NULL,0,NULL,'food',NULL,0,1,NULL,209,NULL,'Ndole Viande',NULL),(24,6,'Ndolè Crevettes',NULL,'4500',NULL,NULL,0,NULL,'food',NULL,0,1,NULL,203,NULL,'Ndole Crevettes',NULL),(25,6,'Ndolè Poulet',NULL,'4000',NULL,NULL,0,NULL,'food',NULL,0,1,NULL,201,NULL,'Ndole Poulet',NULL),(26,6,'Ndolè Viande et Crevettes',NULL,'5000',NULL,NULL,0,NULL,'food',NULL,0,0,NULL,0,NULL,'Ndole Viande et Crevettes',NULL),(27,6,'Folong Porc',NULL,'3500',NULL,NULL,0,NULL,'food',NULL,0,1,NULL,204,NULL,'Folong Porc',NULL),(28,6,'Folong Viande',NULL,'2800',NULL,NULL,0,NULL,'food',NULL,0,1,NULL,209,NULL,'Folong Viande',NULL),(29,6,'Folong Poisson Fumé',NULL,'2800',NULL,NULL,0,NULL,'food',NULL,0,1,NULL,207,NULL,'Folong Poisson Fume',NULL),(30,6,'Légume Vert Sauce Pistache',NULL,' 3000',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Legume Vert Sauce Pistache',NULL),(31,6,'Kongo Meat Sauce Piquante',NULL,' 2800',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Kongo Meat Sauce Piquante',NULL),(32,6,'Escargot d\'Elevage  à la Crème',NULL,' 3500',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Escargot d Elevage  a la Creme',NULL),(33,6,'Poulet D.G ( entier)',NULL,'9000',NULL,NULL,0,NULL,'food',NULL,0,4,NULL,201,NULL,'Poulet D.G ( entier)',NULL),(34,6,'1/2 Poulet D.G',NULL,'5000',NULL,NULL,0,NULL,'food',NULL,0,2,NULL,201,NULL,'1/2 Poulet D.G',NULL),(35,6,'1/4 Poulet D.G',NULL,'3000',NULL,NULL,0,NULL,'food',NULL,0,1,NULL,201,NULL,'1/4 Poulet D.G',NULL),(36,6,'Poulet Sauce d Arachide',NULL,'3000',NULL,NULL,0,NULL,'food',NULL,0,1,NULL,201,NULL,'Poulet Sauce d Arachide',NULL),(37,7,'Hamburger',NULL,'1500',NULL,NULL,0,NULL,'food',NULL,0,1,NULL,208,NULL,'Hamburger',NULL),(38,7,'Cheese Burger',NULL,'2300',NULL,NULL,0,NULL,'food',NULL,0,1,NULL,208,NULL,'Cheese Burger',NULL),(39,7,'Croque Monsieur',NULL,'1800',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Croque Monsieur',NULL),(40,7,'Club Sandwich',NULL,' 2000',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Club Sandwich',NULL),(41,7,'Sandwich Viande Hachée',NULL,'1800',NULL,NULL,0,NULL,'food',NULL,0,3,NULL,205,NULL,'Sandwich Viande Hachee',NULL),(42,8,'Riz Blanc',NULL,'',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Riz Blanc',NULL),(43,8,' Frites',NULL,'',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,' Frites',NULL),(44,8,' Plantains Frits',NULL,'',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,' Plantains Frits',NULL),(45,8,' Miondo',NULL,'',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,' Miondo',NULL),(46,8,' Spaghetti',NULL,'',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,' Spaghetti',NULL),(47,8,' Pommes Sautées',NULL,'',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,' Pommes Sautees',NULL),(48,11,'Sole',NULL,'800',NULL,NULL,100,12,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Sole',NULL),(49,11,' Bars',NULL,'800',NULL,NULL,100,12,'food',NULL,0,1,NULL,206,NULL,' Bars',NULL),(50,11,' Bossus',NULL,'800',NULL,NULL,100,12,'food',NULL,0,1,NULL,206,NULL,' Bossus',NULL),(51,11,' Carpe',NULL,'800',NULL,NULL,100,12,'food',NULL,0,1,NULL,206,NULL,' Carpe',NULL),(52,11,'Maquereaux',NULL,' 300',NULL,NULL,100,12,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Maquereaux',NULL),(53,11,'Grosses Crevettes',NULL,' 1200',NULL,NULL,100,12,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Grosses Crevettes',NULL),(54,11,'Porc',NULL,'3500',NULL,NULL,0,13,'food',NULL,0,0,NULL,0,NULL,'Porc',NULL),(55,11,'1/4Poulet',NULL,'3000',NULL,NULL,0,13,'food',NULL,0,1,NULL,201,NULL,'1/4Poulet',NULL),(56,11,'Saucisse Toulouse',NULL,'  700',NULL,NULL,0,13,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Saucisse Toulouse',NULL),(57,11,'Saucisse Chipolatas',NULL,'300',NULL,NULL,0,13,'food',NULL,0,0,NULL,0,NULL,'Saucisse Chipolatas',NULL),(58,11,'Brochette de Boeuf géante',NULL,' 1000',NULL,NULL,0,13,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Brochette de Boeuf geante',NULL),(59,71,'saucisse',NULL,'0',NULL,NULL,0,14,'food',NULL,1,0,NULL,0,NULL,'saucisse',NULL),(60,11,'1 poulet',NULL,'9000',NULL,NULL,0,14,'food',NULL,0,4,NULL,201,NULL,'1 poulet',NULL),(61,11,' porc grille',NULL,'3500',NULL,NULL,0,14,'food',NULL,0,1,NULL,204,NULL,' porc grille',NULL),(62,11,' bœuf',NULL,'4000',NULL,NULL,0,14,'food',NULL,0,1,NULL,200,NULL,' boeuf',NULL),(63,15,'Le Petit Plateau de Variétés',NULL,'   4000',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Le Petit Plateau de Varietes',NULL),(64,16,'Assiette de Cochonaille   ',NULL,'  4000',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Assiette de Cochonaille   ',NULL),(65,17,'Boissons Chaudes',NULL,' 500',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Boissons Chaudes',NULL),(66,17,'Expresso',NULL,' 1000',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Expresso',NULL),(67,17,'Omelette Nature',NULL,'700',NULL,NULL,0,NULL,'food',NULL,0,0,NULL,0,NULL,'Omelette Nature',NULL),(68,17,'Sardine',NULL,' 200',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Sardine',NULL),(69,17,'Spaghetti (garniture pour omelette)',NULL,'200',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Spaghetti (garniture pour omelette)',NULL),(70,17,'pain',NULL,' 700',NULL,NULL,0,18,'food',NULL,NULL,NULL,NULL,NULL,NULL,'pain',NULL),(71,17,' beurre',NULL,' 700',NULL,NULL,0,18,'food',NULL,NULL,NULL,NULL,NULL,NULL,' beurre',NULL),(72,17,' boisson chaude ',NULL,' 700',NULL,NULL,0,18,'food',NULL,NULL,NULL,NULL,NULL,NULL,' boisson chaude ',NULL),(73,17,'crudités',NULL,' 1500',NULL,NULL,0,19,'food',NULL,NULL,NULL,NULL,NULL,NULL,'crudites',NULL),(74,17,' boisson chaude',NULL,' 1500',NULL,NULL,0,19,'food',NULL,NULL,NULL,NULL,NULL,NULL,' boisson chaude',NULL),(75,17,' fruit ',NULL,' 1500',NULL,NULL,0,19,'food',NULL,NULL,NULL,NULL,NULL,NULL,' fruit ',NULL),(76,17,'Bouillon de Bœuf',NULL,' 1500',NULL,NULL,0,19,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Bouillon de Boeuf',NULL),(77,17,'Bouillon de Poisson',NULL,' 1500.',NULL,NULL,0,19,'food',NULL,0,1,NULL,206,NULL,'Bouillon de Poisson',NULL),(78,17,'Ebanjéa',NULL,' 1500',NULL,NULL,0,19,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Ebanjea',NULL),(79,20,'Eau Minérale Plate 1',NULL,' 1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Eau Minerale Plate 1',NULL),(80,20,'0.5l',NULL,' 500',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'0.5l',NULL),(81,20,'Eau Minérale Plate 0,5',NULL,' 500',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Eau Minerale Plate 0,5',NULL),(82,20,'1,5L',NULL,'1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'1,5L',NULL),(83,20,'Eau Pétillante locale',NULL,' 1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Eau Petillante locale',NULL),(84,20,'Eau Pétillante ( Perrier)',NULL,' 2000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Eau Petillante ( Perrier)',NULL),(85,21,'Top grenadine',NULL,'1000',NULL,NULL,0,22,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Top grenadine',NULL),(86,21,' Fanta',NULL,'',NULL,NULL,0,22,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Fanta',NULL),(87,21,' Djino',NULL,'',NULL,NULL,0,22,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Djino',NULL),(88,21,' Vimto',NULL,'',NULL,NULL,0,22,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Vimto',NULL),(89,21,' Coca-Cola',NULL,'',NULL,NULL,0,22,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Coca-Cola',NULL),(90,21,'tonic',NULL,'0',NULL,NULL,0,22,'drink',NULL,0,0,NULL,0,NULL,' Schweppes',0),(91,21,' Sprïte',NULL,'',NULL,NULL,0,22,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Sprite',NULL),(92,21,' Malta Guinness',NULL,'',NULL,NULL,0,22,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Malta Guinness',NULL),(93,23,'Goyave',NULL,' 1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Goyave',NULL),(94,23,'jus naturel',NULL,'1000',NULL,NULL,0,NULL,'drink',NULL,0,0,NULL,0,NULL,' Corrosol',0),(95,24,'Ananas',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Ananas',NULL),(96,24,' Orange',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Orange',NULL),(97,24,' Pamplemousse',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Pamplemousse',NULL),(98,24,' Mangue',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Mangue',NULL),(99,24,' Papaye',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Papaye',NULL),(100,24,' Pastèque',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Pasteque',NULL),(101,27,'Lait de Tigre',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Lait de Tigre',NULL),(102,27,'Starter',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Starter',NULL),(103,27,'Volupté',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Volupte',NULL),(104,27,'Milk Shake',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Milk Shake',NULL),(105,28,'Castel',NULL,' 1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Castel',NULL),(106,28,' 33 Export',NULL,' 1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' 33 Export',NULL),(107,28,' Mützig',NULL,' 1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Mutzig',NULL),(108,28,' Beaufort tango',NULL,' 1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Beaufort tango',NULL),(109,28,'  Guinness p.m',NULL,'1000',NULL,NULL,0,NULL,'drink',NULL,0,0,NULL,0,NULL,'  Guinness p.m',0),(110,28,'Origin',NULL,' 1500',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Origin',NULL),(111,28,' Harp',NULL,' 1500',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Harp',NULL),(112,28,' Isenbeck',NULL,' 1500',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Isenbeck',NULL),(113,28,' Booster',NULL,' 1500',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Booster',NULL),(114,28,'Guinness GM',NULL,' 2000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Guinness GM',NULL),(115,29,'Heineken bouteille pm',NULL,'1500',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Heineken bouteille pm',NULL),(116,29,' 1664',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' 1664',NULL),(117,29,' Kronenbourg',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Kronenbourg',NULL),(118,33,'Smirnoff Ice',NULL,'1000',NULL,NULL,0,NULL,'drink',NULL,0,0,NULL,0,NULL,'Smirnoff',NULL),(119,33,' Xcite cider',NULL,' 1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Xcite cider',NULL),(120,33,'Red Bull',NULL,' 1500',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Red Bull',NULL),(121,34,'Ricard',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Ricard',NULL),(122,34,' Campari',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Campari',NULL),(123,34,' Martini',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Martini',NULL),(124,34,' Gordon\'s Gin',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Gordon s Gin',NULL),(125,39,'Bailey\'s',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Bailey s',NULL),(126,39,' Amarula',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Amarula',NULL),(127,39,' Malibu',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Malibu',NULL),(128,44,'Smirnoff Black',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Smirnoff Black',NULL),(129,47,'01 bouteille      25000',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'01 bouteille      25000',NULL),(130,48,'J&B',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'JB',NULL),(131,48,' Clan Campbell',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Clan Campbell',NULL),(132,48,' Johnny Red',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Johnny Red',NULL),(133,48,' Grant\'s',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Grant s',NULL),(134,48,' Ballantine\'s',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Ballantine s',NULL),(135,48,' Black & white',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Black  white',NULL),(136,53,'Chivas',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Chivas',NULL),(137,53,' Johnny Black Label',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Johnny Black Label',NULL),(138,53,' Grant\'s',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Grant s',NULL),(139,53,' Jack Daniel bande noire 75cl',NULL,'30000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Jack Daniel bande noire 75cl',NULL),(140,53,' Ballantine\'s',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Ballantine s',NULL),(141,58,'Singleton',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Singleton',NULL),(142,58,' Dimple',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Dimple',NULL),(143,58,' Abelour',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Abelour',NULL),(144,58,' Cardhu',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Cardhu',NULL),(145,58,' The Glenlivet',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' The Glenlivet',NULL),(146,60,'Johnny Gold Label',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Johnny Gold Label',NULL),(147,60,' Glendfidich',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Glendfidich',NULL),(148,60,' Ballantine\'s',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Ballantine s',NULL),(149,62,'Chivas',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Chivas',NULL),(150,62,' Glendfidich',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Glendfidich',NULL),(151,62,' Johnny Platinum',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Johnny Platinum',NULL),(152,64,'Thé',NULL,' 1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'The',NULL),(153,64,' Infusion',NULL,' 1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Infusion',NULL),(154,64,' Café ',NULL,' 1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,' Cafe ',NULL),(155,64,'Expresso',NULL,' 1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Expresso',NULL),(156,65,'Chicha',NULL,' 3000',NULL,NULL,0,NULL,'chicha',NULL,NULL,NULL,NULL,NULL,NULL,'Chicha',NULL),(157,65,'Charbon ',NULL,' 1000',NULL,NULL,0,NULL,'chicha',NULL,NULL,NULL,NULL,NULL,NULL,'Charbon ',NULL),(158,1,'Salade de mais doux',NULL,'1700',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Salade de mais doux',NULL),(159,2,'Boulette de viande',NULL,'200',NULL,NULL,0,NULL,'food',NULL,0,6,NULL,205,NULL,'Boulette de viande',NULL),(160,11,'Brochette de Rognon',NULL,'500',NULL,NULL,0,NULL,'food',NULL,0,0,NULL,0,NULL,'Brochette de Rognon',NULL),(161,11,'Brochette de Boeuf',NULL,'400',NULL,NULL,0,NULL,'food',NULL,NULL,NULL,NULL,NULL,NULL,'Brochette de Boeuf',NULL),(162,2,'Poulet 1/4 crousti',NULL,'3300',NULL,NULL,0,NULL,'food',NULL,0,1,NULL,201,NULL,'Poulet 1/4 crousti',NULL),(163,62,'Deward S',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Deward S',NULL),(164,39,'Suze',NULL,'',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Suze',NULL),(165,2,'Tripe',NULL,'3000',NULL,NULL,0,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,'Tripe',NULL),(166,53,'Singleton',NULL,'40000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Singleton',NULL),(167,53,'glenmorangie',NULL,'35000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'glenmorangie',NULL),(168,53,'glenfiddich',NULL,'40000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'glenfiddich',NULL),(169,28,'beaufort ligth',NULL,'1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'beaufort ligth',NULL),(170,28,'beaufort ordinaire',NULL,'1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'beaufort ordinaire',NULL),(171,28,'kadji beer',NULL,'1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'kadji beer',NULL),(172,28,'smooth',NULL,'1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'smooth',NULL),(173,29,'bavaria 0',NULL,'2000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'bavaria 0',NULL),(174,21,'orangina',NULL,'1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'orangina',NULL),(175,21,'soda',NULL,'1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'soda',NULL),(176,21,'top ananas',NULL,'1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'top ananas',NULL),(177,21,'top pamplemousse',NULL,'1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'top pamplemousse',NULL),(178,21,'top cola',NULL,'1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'top cola',NULL),(179,66,'janneau',NULL,'6000',NULL,NULL,0,NULL,'drink',NULL,0,0,NULL,0,NULL,'janneau',NULL),(180,66,'vodrey xo',NULL,'60000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'vodrey xo',NULL),(181,67,'Moet et Chamdon',NULL,'40000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Moet et Chamdon',NULL),(182,67,'Ruinart',NULL,'60000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Ruinart',NULL),(183,67,'Veuve Durand',NULL,'30000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Veuve Durand',NULL),(184,68,'J.P Chenet mousseux GM',NULL,'7000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'J.P Chenet mousseux GM',NULL),(185,68,'J.P Chenet mousseux pm',NULL,'3500',NULL,NULL,0,NULL,'drink',NULL,0,0,NULL,0,NULL,'J.P Chenet mousseux pm',NULL),(186,53,'Jack danie,sl honey 75cl',NULL,'35000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Jack danie,sl honey 75cl',NULL),(187,53,'Jack danie,sl honey 35cl',NULL,'15000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Jack danie,sl honey 35cl',NULL),(188,53,'Jack daniel.s bande noire 35cl',NULL,'15000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Jack daniel.s bande noire 35cl',NULL),(189,70,'Tour cantelou',NULL,'5000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Tour cantelou',NULL),(190,70,'baron d.arignac',NULL,'8000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'baron d.arignac',NULL),(191,69,'Bordeaux',NULL,'8000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Bordeaux',NULL),(192,69,'Bordeaux superieur',NULL,'12000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Bordeaux superieur',NULL),(193,69,'Haut Medoc',NULL,'20000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Haut Medoc',NULL),(194,69,'Saint Emilion',NULL,'15000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Saint Emilion',NULL),(195,69,'Margaux',NULL,'25000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Margaux',NULL),(196,69,'Graves',NULL,'20000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Graves',NULL),(197,69,'Medoc ',NULL,'15000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'Medoc ',NULL),(198,29,'heineken cannette',NULL,'2000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'heineken cannette',NULL),(199,33,'VK',NULL,'1000',NULL,NULL,0,NULL,'drink',NULL,NULL,NULL,NULL,NULL,NULL,'VK',NULL),(200,71,'steak',NULL,NULL,NULL,NULL,NULL,NULL,'food',NULL,1,1,0,0,NULL,'steak',NULL),(201,71,'poulet',NULL,NULL,NULL,NULL,0,NULL,'food',NULL,1,1,0,0,NULL,'poulet',NULL),(202,71,'rognons',NULL,NULL,NULL,NULL,NULL,NULL,'food',NULL,1,1,NULL,0,NULL,'rognons',NULL),(203,71,'crevettes',NULL,NULL,NULL,NULL,NULL,NULL,'food',NULL,1,1,NULL,0,NULL,'crevettes',NULL),(204,71,'porc',NULL,NULL,NULL,NULL,NULL,NULL,'food',NULL,1,1,NULL,0,NULL,'porc',NULL),(205,71,'boulettes de viande',NULL,NULL,NULL,NULL,NULL,NULL,'food',NULL,1,1,NULL,0,NULL,'boulettes de viande',NULL),(206,71,'poisson frais',NULL,'4000',NULL,NULL,0,NULL,'food',NULL,1,1,NULL,0,NULL,'poisson frais',NULL),(207,71,'poisson fume',NULL,'',NULL,NULL,0,NULL,'food',NULL,1,1,NULL,0,NULL,'poisson fume',NULL),(208,71,'hamburger',NULL,NULL,NULL,NULL,NULL,NULL,'food',NULL,1,1,NULL,0,NULL,'hamburger',NULL),(209,71,'viande de boeuf',NULL,NULL,NULL,NULL,NULL,NULL,'food',NULL,1,1,NULL,0,NULL,'viande de boeuf',NULL),(210,6,'ndole bar',NULL,'4800',NULL,NULL,0,NULL,'food',NULL,0,1,NULL,206,NULL,'ndole bar',NULL),(211,71,'cheese',NULL,NULL,NULL,NULL,NULL,NULL,'food',NULL,1,1,NULL,0,NULL,'cheese',NULL),(212,71,'pain hamburger',NULL,NULL,NULL,NULL,NULL,NULL,'food',NULL,1,1,NULL,0,NULL,'pain hamburger',NULL),(213,15,'cheese',NULL,'700',NULL,NULL,0,NULL,'food',NULL,0,1,NULL,0,NULL,'cheese',NULL),(214,71,'follong',NULL,NULL,NULL,NULL,NULL,NULL,'food',NULL,1,1,NULL,0,NULL,'follong',NULL),(215,71,'bolognaise',NULL,NULL,NULL,NULL,NULL,NULL,'food',NULL,1,1,NULL,0,NULL,'bolognaise',NULL),(216,71,'spaghetti',NULL,NULL,NULL,NULL,NULL,NULL,'food',NULL,1,1,NULL,0,NULL,'spaghetti',NULL),(217,71,'riz',NULL,NULL,NULL,NULL,NULL,NULL,'food',NULL,1,1,NULL,0,NULL,'riz',NULL),(218,71,'miondo',NULL,NULL,NULL,NULL,NULL,NULL,'food',NULL,1,1,NULL,0,NULL,'miondo',NULL),(219,71,'trippes',NULL,NULL,NULL,NULL,NULL,NULL,'food',NULL,1,1,NULL,0,NULL,'trippes',NULL),(220,71,'oeufs',NULL,NULL,NULL,NULL,NULL,NULL,'food',NULL,1,1,NULL,0,NULL,'oeufs',NULL),(221,71,'ndole',NULL,NULL,NULL,NULL,NULL,NULL,'food',NULL,1,1,NULL,0,NULL,'ndole',NULL),(222,2,' Saucisses et ses frites',NULL,'2500',NULL,NULL,0,NULL,'food',NULL,0,1,NULL,0,NULL,' Saucisses et ses frites',NULL),(223,6,'folong bar',NULL,'4800',NULL,NULL,0,NULL,'food',NULL,0,1,NULL,0,NULL,'folong bar',NULL),(224,2,'omelettes et ses frites',NULL,'1500',NULL,NULL,0,NULL,'food',NULL,0,1,NULL,0,NULL,'omelettes et ses frites',NULL),(225,16,'Barquette',NULL,'250',NULL,NULL,NULL,NULL,'food',NULL,0,1,NULL,0,NULL,'Barquette',1),(226,6,'Ndole porc',NULL,'4000',NULL,NULL,0,NULL,'food',NULL,0,1,NULL,0,NULL,'Ndole porc',1),(227,21,'shweppes',NULL,NULL,NULL,NULL,NULL,NULL,'drink',NULL,NULL,1,NULL,0,NULL,'shweppes',1),(228,6,'ndole poisson fume',NULL,'3000',NULL,NULL,0,NULL,'food',NULL,0,1,NULL,0,NULL,'ndole poisson fume',1),(229,71,'poisson fume',NULL,NULL,NULL,NULL,NULL,NULL,'food',NULL,1,1,NULL,0,NULL,'poisson fume',1);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `product` with 229 row(s)
--

--
-- Table structure for table `productinventory`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productinventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `initialstock` double DEFAULT NULL,
  `enterstock` double NOT NULL,
  `outerstock` double NOT NULL,
  `theoricstock` double DEFAULT NULL,
  `physicalstock` double DEFAULT NULL,
  `ecart` double DEFAULT NULL,
  `damagestock` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_545D65C19EEA759` (`inventory_id`),
  KEY `IDX_545D65C14584665A` (`product_id`),
  CONSTRAINT `FK_545D65C14584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_545D65C19EEA759` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1109 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productinventory`
--

LOCK TABLES `productinventory` WRITE;
/*!40000 ALTER TABLE `productinventory` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `productinventory` VALUES (1,1,109,NULL,0,0,0,176,-176,0),(2,1,116,NULL,0,0,0,6,-6,0),(3,1,106,NULL,0,0,0,36,-36,0),(4,1,143,NULL,0,0,0,NULL,NULL,0),(5,1,126,NULL,0,0,0,15,-15,0),(6,1,134,NULL,0,0,0,0,0,0),(7,1,140,NULL,0,0,0,30,-30,0),(8,1,148,NULL,0,0,0,NULL,NULL,0),(9,1,108,NULL,0,0,0,NULL,NULL,0),(10,1,135,NULL,0,0,0,13,-13,0),(11,1,113,NULL,0,0,0,28,-28,0),(12,1,154,NULL,0,0,0,8,-8,0),(13,1,122,NULL,0,0,0,27,-27,0),(14,1,144,NULL,0,0,0,NULL,NULL,0),(15,1,131,NULL,0,0,0,33,-33,0),(16,1,89,NULL,0,0,0,30,-30,0),(17,1,94,NULL,0,0,0,NULL,NULL,0),(18,1,142,NULL,0,0,0,15,-15,0),(19,1,87,NULL,0,0,0,24,-24,0),(20,1,86,NULL,0,0,0,13,-13,0),(21,1,147,NULL,0,0,0,NULL,NULL,0),(22,1,150,NULL,0,0,0,15,-15,0),(23,1,124,NULL,0,0,0,7,-7,0),(24,1,133,NULL,0,0,0,60.5,-60.5,0),(25,1,138,NULL,0,0,0,0,0,0),(26,1,111,NULL,0,0,0,59,-59,0),(27,1,153,NULL,0,0,0,0,0,0),(28,1,112,NULL,0,0,0,13,-13,0),(29,1,139,NULL,0,0,0,30,-30,0),(30,1,137,NULL,0,0,0,71.5,-71.5,0),(31,1,151,NULL,0,0,0,15,-15,0),(32,1,132,NULL,0,0,0,30,-30,0),(33,1,117,NULL,0,0,0,NULL,NULL,0),(34,1,127,NULL,0,0,0,12,-12,0),(35,1,92,NULL,0,0,0,168,-168,0),(36,1,98,NULL,0,0,0,NULL,NULL,0),(37,1,123,NULL,0,0,0,157.5,-157.5,0),(38,1,107,NULL,0,0,0,27,-27,0),(39,1,96,NULL,0,0,0,NULL,NULL,0),(40,1,97,NULL,0,0,0,NULL,NULL,0),(41,1,99,NULL,0,0,0,NULL,NULL,0),(42,1,100,NULL,0,0,0,NULL,NULL,0),(43,1,90,NULL,0,0,0,37,-37,0),(44,1,91,NULL,0,0,0,0,0,0),(45,1,145,NULL,0,0,0,NULL,NULL,0),(46,1,88,NULL,0,0,0,44,-44,0),(47,1,119,NULL,0,0,0,13,-13,0),(48,1,129,NULL,0,0,0,NULL,NULL,0),(49,1,82,NULL,0,0,0,4,-4,0),(50,1,80,NULL,0,0,0,NULL,NULL,0),(51,1,95,NULL,0,0,0,NULL,NULL,0),(52,1,125,NULL,0,0,0,55,-55,0),(53,1,105,NULL,0,0,0,8,-8,0),(54,1,136,NULL,0,0,0,45,-45,0),(55,1,149,NULL,0,0,0,30,-30,0),(56,1,163,NULL,0,0,0,20,-20,0),(57,1,81,NULL,0,0,0,NULL,NULL,0),(58,1,79,NULL,0,0,0,NULL,NULL,0),(59,1,79,NULL,0,0,0,NULL,NULL,0),(60,1,84,NULL,0,0,0,9,-9,0),(61,1,83,NULL,0,0,0,NULL,NULL,0),(62,1,155,NULL,0,0,0,0,0,0),(63,1,168,NULL,0,0,0,3,-3,0),(64,1,167,NULL,0,0,0,15,-15,0),(65,1,93,NULL,0,0,0,NULL,NULL,0),(66,1,114,NULL,0,0,0,31,-31,0),(67,1,115,NULL,0,0,0,NULL,NULL,0),(68,1,130,NULL,0,0,0,13.5,-13.5,0),(69,1,146,NULL,0,0,0,30,-30,0),(70,1,101,NULL,0,0,0,NULL,NULL,0),(71,1,104,NULL,0,0,0,NULL,NULL,0),(72,1,110,NULL,0,0,0,0,0,0),(73,1,120,NULL,0,0,0,1,-1,0),(74,1,121,NULL,0,0,0,NULL,NULL,0),(75,1,141,NULL,0,0,0,NULL,NULL,0),(76,1,166,NULL,0,0,0,40,-40,0),(77,1,118,NULL,0,0,0,142,-142,0),(78,1,128,NULL,0,0,0,20,-20,0),(79,1,102,NULL,0,0,0,NULL,NULL,0),(80,1,164,NULL,0,0,0,20,-20,0),(81,1,152,NULL,0,0,0,4,-4,0),(82,1,85,NULL,0,0,0,NULL,NULL,0),(83,1,103,NULL,0,0,0,NULL,NULL,0),(426,5,109,NULL,0,0,0,137,-137,0),(427,5,116,NULL,0,0,0,8,-8,0),(428,5,106,NULL,0,0,0,44,-44,0),(429,5,143,NULL,0,0,0,NULL,NULL,0),(430,5,126,NULL,0,0,0,1,-1,0),(431,5,134,NULL,0,0,0,NULL,NULL,0),(432,5,140,NULL,0,0,0,2,-2,0),(433,5,148,NULL,0,0,0,NULL,NULL,0),(434,5,108,NULL,0,0,0,12,-12,0),(435,5,135,NULL,0,0,0,0.8,-0.8,0),(436,5,113,NULL,0,0,0,44,-44,0),(437,5,154,NULL,0,0,0,12,-12,0),(438,5,122,NULL,0,0,0,1.2,-1.2,0),(439,5,144,NULL,0,0,0,NULL,NULL,0),(440,5,131,NULL,0,0,0,2.01,-2.01,0),(441,5,89,NULL,0,0,0,53,-53,0),(442,5,94,NULL,0,0,0,3,-3,0),(443,5,142,NULL,0,0,0,1,-1,0),(444,5,87,NULL,0,0,0,31,-31,0),(445,5,86,NULL,0,0,0,14,-14,0),(446,5,147,NULL,0,0,0,NULL,NULL,0),(447,5,150,NULL,0,0,0,1,-1,0),(448,5,124,NULL,0,0,0,0.5,-0.5,0),(449,5,133,NULL,0,0,0,4.01,-4.01,0),(450,5,138,NULL,0,0,0,NULL,NULL,0),(451,5,111,NULL,0,0,0,45,-45,0),(452,5,153,NULL,0,0,0,NULL,NULL,0),(453,5,112,NULL,0,0,0,26,-26,0),(454,5,139,NULL,0,0,0,1.09,-1.09,0),(455,5,137,NULL,0,0,0,4.006,-4.006,0),(456,5,151,NULL,0,0,0,1,-1,0),(457,5,132,NULL,0,0,0,2.09,-2.09,0),(458,5,117,NULL,0,0,0,NULL,NULL,0),(459,5,127,NULL,0,0,0,0.8,-0.8,0),(460,5,92,NULL,0,1,-1,112,-112,0),(461,5,98,NULL,0,0,0,NULL,NULL,0),(462,5,123,NULL,0,0,0,6.95,-6.95,0),(463,5,107,NULL,0,0,0,38,-38,0),(464,5,96,NULL,0,0,0,NULL,NULL,0),(465,5,97,NULL,0,0,0,NULL,NULL,0),(466,5,99,NULL,0,0,0,NULL,NULL,0),(467,5,100,NULL,0,0,0,NULL,NULL,0),(468,5,90,NULL,0,0,0,NULL,NULL,0),(469,5,91,NULL,0,0,0,NULL,NULL,0),(470,5,145,NULL,0,0,0,NULL,NULL,0),(471,5,88,NULL,0,0,0,26,-26,0),(472,5,119,NULL,0,0,0,35,-35,0),(473,5,80,NULL,0,0,0,0,0,0),(474,5,129,NULL,0,0,0,NULL,NULL,0),(475,5,82,NULL,0,0,0,NULL,NULL,0),(476,5,95,NULL,0,0,0,NULL,NULL,0),(477,5,125,NULL,0,1,-1,4,-5,0),(478,5,190,NULL,0,0,0,15,-15,0),(479,5,173,NULL,0,0,0,11,-11,0),(480,5,169,NULL,0,0,0,24,-24,0),(481,5,170,NULL,0,0,0,17,-17,0),(482,5,191,NULL,0,0,0,4,-4,0),(483,5,192,NULL,0,0,0,8,-8,0),(484,5,105,NULL,0,0,0,17,-17,0),(485,5,136,NULL,0,0,0,13.05,-13.05,0),(486,5,149,NULL,0,0,0,2,-2,0),(487,5,163,NULL,0,0,0,1,-1,0),(488,5,81,NULL,0,0,0,13,-13,0),(489,5,79,NULL,0,0,0,19,-19,0),(490,5,79,NULL,0,0,0,NULL,NULL,0),(491,5,84,NULL,0,0,0,9,-9,0),(492,5,83,NULL,0,0,0,NULL,NULL,0),(493,5,155,NULL,0,0,0,NULL,NULL,0),(494,5,168,NULL,0,0,0,0.1,-0.1,0),(495,5,167,NULL,0,0,0,1,-1,0),(496,5,93,NULL,0,0,0,NULL,NULL,0),(497,5,196,NULL,0,0,0,0,0,0),(498,5,114,NULL,0,0,0,53,-53,0),(499,5,193,NULL,0,0,0,8,-8,0),(500,5,115,NULL,0,0,0,86,-86,0),(501,5,198,NULL,0,0,0,6,-6,0),(502,5,184,NULL,0,0,0,7,-7,0),(503,5,185,NULL,0,0,0,5,-5,0),(504,5,130,NULL,0,0,0,3.01,-3.01,0),(505,5,187,NULL,0,0,0,1,-1,0),(506,5,186,NULL,0,0,0,3,-3,0),(507,5,188,NULL,0,0,0,NULL,NULL,0),(508,5,179,NULL,0,0,0,0.2,-0.2,0),(509,5,146,NULL,0,0,0,2,-2,0),(510,5,171,NULL,0,0,0,0,0,0),(511,5,101,NULL,0,0,0,NULL,NULL,0),(512,5,195,NULL,0,0,0,2,-2,0),(513,5,197,NULL,0,0,0,NULL,NULL,0),(514,5,104,NULL,0,0,0,NULL,NULL,0),(515,5,181,NULL,0,0,0,2,-2,0),(516,5,174,NULL,0,0,0,46,-46,0),(517,5,110,NULL,0,1,-1,45,-45,0),(518,5,120,NULL,0,0,0,5,-5,0),(519,5,121,NULL,0,0,0,NULL,NULL,0),(520,5,182,NULL,0,0,0,2,-2,0),(521,5,194,NULL,0,0,0,3,-3,0),(522,5,141,NULL,0,0,0,NULL,NULL,0),(523,5,166,NULL,0,0,0,2.06,-2.06,0),(524,5,118,NULL,0,0,0,157,-157,0),(525,5,128,NULL,0,0,0,1,-1,0),(526,5,172,NULL,0,0,0,38,-38,0),(527,5,175,NULL,0,0,0,24,-24,0),(528,5,102,NULL,0,0,0,NULL,NULL,0),(529,5,164,NULL,0,0,0,1,-1,0),(530,5,152,NULL,0,0,0,18,-18,0),(531,5,176,NULL,0,0,0,14,-14,0),(532,5,178,NULL,0,0,0,4,-4,0),(533,5,85,NULL,0,0,0,18,-18,0),(534,5,177,NULL,0,0,0,16,-16,0),(535,5,189,NULL,0,0,0,25,-25,0),(536,5,183,NULL,0,0,0,2,-2,0),(537,5,199,NULL,0,0,0,9,-9,0),(538,5,180,NULL,0,0,0,1,-1,0),(539,5,103,NULL,0,0,0,NULL,NULL,0),(654,7,49,NULL,0,0,0,6,-6,0),(655,7,71,NULL,0,0,0,NULL,NULL,0),(656,7,62,NULL,0,0,0,NULL,NULL,0),(657,7,72,NULL,0,0,0,NULL,NULL,0),(658,7,74,NULL,0,0,0,NULL,NULL,0),(659,7,50,NULL,0,0,0,NULL,NULL,0),(660,7,51,NULL,0,0,0,NULL,NULL,0),(661,7,43,NULL,0,1,-1,NULL,NULL,0),(662,7,75,NULL,0,0,0,NULL,NULL,0),(663,7,45,NULL,0,0,0,NULL,NULL,0),(664,7,44,NULL,0,0,0,NULL,NULL,0),(665,7,47,NULL,0,0,0,NULL,NULL,0),(666,7,61,NULL,0,0,0,20,-20,0),(667,7,222,NULL,0,0,0,NULL,NULL,0),(668,7,46,NULL,0,0,0,NULL,NULL,0),(669,7,60,NULL,0,0,0,NULL,NULL,0),(670,7,34,NULL,0,0,0,NULL,NULL,0),(671,7,35,NULL,0,0,0,NULL,NULL,0),(672,7,55,NULL,0,1,-1,NULL,NULL,0),(673,7,64,NULL,0,0,0,NULL,NULL,0),(674,7,225,NULL,0,0,0,NULL,NULL,0),(675,7,65,NULL,0,0,0,NULL,NULL,0),(676,7,215,NULL,0,0,0,16,-16,0),(677,7,76,NULL,0,0,0,NULL,NULL,0),(678,7,77,NULL,0,0,0,NULL,NULL,0),(679,7,19,NULL,0,0,0,NULL,NULL,0),(680,7,159,NULL,0,0,0,NULL,NULL,0),(681,7,205,NULL,0,0,0,156,-156,0),(682,7,12,NULL,0,0,0,NULL,NULL,0),(683,7,161,NULL,0,1,-1,NULL,NULL,0),(684,7,58,NULL,0,0,0,NULL,NULL,0),(685,7,160,NULL,0,0,0,NULL,NULL,0),(686,7,211,NULL,0,0,0,6,-6,0),(687,7,213,NULL,0,0,0,NULL,NULL,0),(688,7,38,NULL,0,0,0,NULL,NULL,0),(689,7,40,NULL,0,0,0,NULL,NULL,0),(690,7,2,NULL,0,0,0,NULL,NULL,0),(691,7,203,NULL,0,0,0,1,-1,0),(692,7,21,NULL,0,0,0,NULL,NULL,0),(693,7,39,NULL,0,0,0,NULL,NULL,0),(694,7,73,NULL,0,0,0,NULL,NULL,0),(695,7,20,NULL,0,0,0,NULL,NULL,0),(696,7,78,NULL,0,0,0,NULL,NULL,0),(697,7,7,NULL,0,0,0,NULL,NULL,0),(698,7,32,NULL,0,0,0,NULL,NULL,0),(699,7,66,NULL,0,0,0,NULL,NULL,0),(700,7,5,NULL,0,0,0,NULL,NULL,0),(701,7,214,NULL,0,0,0,4,-4,0),(702,7,223,NULL,0,0,0,NULL,NULL,0),(703,7,29,NULL,0,0,0,NULL,NULL,0),(704,7,27,NULL,0,0,0,NULL,NULL,0),(705,7,28,NULL,0,0,0,NULL,NULL,0),(706,7,22,NULL,0,0,0,NULL,NULL,0),(707,7,53,NULL,0,0,0,NULL,NULL,0),(708,7,37,NULL,0,2,-2,NULL,NULL,0),(709,7,208,NULL,0,0,0,49,-49,0),(710,7,31,NULL,0,0,0,NULL,NULL,0),(711,7,63,NULL,0,0,0,NULL,NULL,0),(712,7,30,NULL,0,0,0,NULL,NULL,0),(713,7,52,NULL,0,0,0,NULL,NULL,0),(714,7,218,NULL,0,0,0,15,-15,0),(715,7,221,NULL,0,0,0,21,-21,0),(716,7,210,NULL,0,0,0,NULL,NULL,0),(717,7,24,NULL,0,0,0,NULL,NULL,0),(718,7,226,NULL,0,1,-1,NULL,NULL,0),(719,7,25,NULL,0,0,0,NULL,NULL,0),(720,7,23,NULL,0,1,-1,NULL,NULL,0),(721,7,26,NULL,0,0,0,NULL,NULL,0),(722,7,220,NULL,0,0,0,13,-13,0),(723,7,67,NULL,0,0,0,NULL,NULL,0),(724,7,224,NULL,0,0,0,NULL,NULL,0),(725,7,70,NULL,0,0,0,NULL,NULL,0),(726,7,212,NULL,0,0,0,25,-25,0),(727,7,18,NULL,0,0,0,NULL,NULL,0),(728,7,8,NULL,0,0,0,NULL,NULL,0),(729,7,206,NULL,0,0,0,6,-6,0),(730,7,207,NULL,0,0,0,4,-4,0),(731,7,54,NULL,0,0,0,NULL,NULL,0),(732,7,204,NULL,0,0,0,20,-20,0),(733,7,9,NULL,0,0,0,NULL,NULL,0),(734,7,201,NULL,80,0,80,54,26,0),(735,7,162,NULL,0,0,0,NULL,NULL,0),(736,7,33,NULL,0,0,0,NULL,NULL,0),(737,7,11,NULL,0,0,0,NULL,NULL,0),(738,7,10,NULL,0,1,-1,NULL,NULL,0),(739,7,36,NULL,0,0,0,NULL,NULL,0),(740,7,217,NULL,0,0,0,NULL,NULL,0),(741,7,42,NULL,0,0,0,NULL,NULL,0),(742,7,202,NULL,0,0,0,58,-58,0),(743,7,14,NULL,0,0,0,NULL,NULL,0),(744,7,13,NULL,0,0,0,NULL,NULL,0),(745,7,1,NULL,0,0,0,NULL,NULL,0),(746,7,4,NULL,0,1,-1,NULL,NULL,0),(747,7,158,NULL,0,0,0,NULL,NULL,0),(748,7,3,NULL,0,0,0,NULL,NULL,0),(749,7,41,NULL,0,0,0,NULL,NULL,0),(750,7,68,NULL,0,0,0,NULL,NULL,0),(751,7,59,NULL,0,0,0,NULL,NULL,0),(752,7,57,NULL,0,0,0,NULL,NULL,0),(753,7,56,NULL,0,0,0,NULL,NULL,0),(754,7,48,NULL,0,0,0,NULL,NULL,0),(755,7,216,NULL,0,0,0,6,-6,0),(756,7,69,NULL,0,0,0,NULL,NULL,0),(757,7,16,NULL,0,0,0,NULL,NULL,0),(758,7,15,NULL,0,0,0,NULL,NULL,0),(759,7,200,NULL,10,0,10,5,5,0),(760,7,6,NULL,0,0,0,NULL,NULL,0),(761,7,17,NULL,0,0,0,NULL,NULL,0),(762,7,219,NULL,0,0,0,15,-15,0),(763,7,209,NULL,0,0,0,19,-19,0),(994,12,109,137,0,9,120,NULL,NULL,8),(995,12,116,8,0,0,8,NULL,NULL,0),(996,12,106,44,0,0,44,NULL,NULL,0),(997,12,143,NULL,0,0,0,NULL,NULL,0),(998,12,126,1,0,0,1,NULL,NULL,0),(999,12,134,NULL,0,0,0,NULL,NULL,0),(1000,12,140,2,0,0,2,NULL,NULL,0),(1001,12,148,NULL,0,0,0,NULL,NULL,0),(1002,12,108,12,0,1,11,NULL,NULL,0),(1003,12,135,0.8,0,0,0.8,NULL,NULL,0),(1004,12,113,44,0,2,42,NULL,NULL,0),(1005,12,154,12,0,0,12,NULL,NULL,0),(1006,12,122,1.2,0,0,1.2,NULL,NULL,0),(1007,12,144,NULL,0,0,0,NULL,NULL,0),(1008,12,131,2.01,0,0,2.01,NULL,NULL,0),(1009,12,89,53,0,6,47,NULL,NULL,0),(1010,12,142,1,0,0,1,NULL,NULL,0),(1011,12,87,31,0,6,25,NULL,NULL,0),(1012,12,86,14,0,1,13,NULL,NULL,0),(1013,12,147,NULL,0,0,0,NULL,NULL,0),(1014,12,150,1,0,0,1,NULL,NULL,0),(1015,12,124,0.5,0,0,0.5,NULL,NULL,0),(1016,12,133,4.01,0,0,4.01,NULL,NULL,0),(1017,12,138,NULL,0,0,0,NULL,NULL,0),(1018,12,111,45,0,0,45,NULL,NULL,0),(1019,12,153,NULL,0,0,0,NULL,NULL,0),(1020,12,112,26,0,0,26,NULL,NULL,0),(1021,12,139,1.09,0,0,1.09,NULL,NULL,0),(1022,12,137,4.006,0,0,4.006,NULL,NULL,0),(1023,12,151,1,0,0,1,NULL,NULL,0),(1024,12,132,2.09,0,0,2.09,NULL,NULL,0),(1025,12,117,NULL,0,0,0,NULL,NULL,0),(1026,12,127,0.8,0,0,0.8,NULL,NULL,0),(1027,12,92,112,0,1,111,NULL,NULL,0),(1028,12,98,NULL,0,0,0,NULL,NULL,0),(1029,12,123,6.95,0,3,3.95,NULL,NULL,0),(1030,12,107,38,0,2,36,NULL,NULL,0),(1031,12,96,NULL,0,0,0,NULL,NULL,0),(1032,12,97,NULL,0,0,0,NULL,NULL,0),(1033,12,99,NULL,0,0,0,NULL,NULL,0),(1034,12,100,NULL,0,0,0,NULL,NULL,0),(1035,12,91,NULL,0,0,0,NULL,NULL,0),(1036,12,145,NULL,0,0,0,NULL,NULL,0),(1037,12,88,26,0,1,25,NULL,NULL,0),(1038,12,119,35,0,0,35,NULL,NULL,0),(1039,12,80,0,0,0,0,NULL,NULL,0),(1040,12,129,NULL,0,0,0,NULL,NULL,0),(1041,12,82,NULL,0,0,0,NULL,NULL,0),(1042,12,95,NULL,0,0,0,NULL,NULL,0),(1043,12,125,4,0,0,4,NULL,NULL,0),(1044,12,190,15,0,0,15,NULL,NULL,0),(1045,12,173,11,0,0,11,NULL,NULL,0),(1046,12,169,24,0,0,24,NULL,NULL,0),(1047,12,170,17,0,1,16,NULL,NULL,0),(1048,12,191,4,0,0,4,NULL,NULL,0),(1049,12,192,8,0,0,8,NULL,NULL,0),(1050,12,105,17,0,0,17,NULL,NULL,0),(1051,12,136,13.05,0,0,13.05,NULL,NULL,0),(1052,12,149,2,0,0,2,NULL,NULL,0),(1053,12,163,1,0,0,1,NULL,NULL,0),(1054,12,81,13,0,0,13,NULL,NULL,0),(1055,12,79,NULL,0,3,-3,NULL,NULL,0),(1056,12,79,NULL,0,3,-3,NULL,NULL,0),(1057,12,84,9,0,0,9,NULL,NULL,0),(1058,12,83,NULL,0,0,0,NULL,NULL,0),(1059,12,155,NULL,0,0,0,NULL,NULL,0),(1060,12,168,0.1,0,0,0.1,NULL,NULL,0),(1061,12,167,1,0,0,1,NULL,NULL,0),(1062,12,93,NULL,0,0,0,NULL,NULL,0),(1063,12,196,0,0,0,0,NULL,NULL,0),(1064,12,114,53,0,0,53,NULL,NULL,0),(1065,12,193,8,0,0,8,NULL,NULL,0),(1066,12,115,86,0,0,86,NULL,NULL,0),(1067,12,198,6,0,0,6,NULL,NULL,0),(1068,12,184,7,0,0,7,NULL,NULL,0),(1069,12,185,5,0,0,5,NULL,NULL,0),(1070,12,130,3.01,0,0,3.01,NULL,NULL,0),(1071,12,187,1,0,0,1,NULL,NULL,0),(1072,12,186,3,0,0,3,NULL,NULL,0),(1073,12,188,NULL,0,0,0,NULL,NULL,0),(1074,12,179,0.2,0,0,0.2,NULL,NULL,0),(1075,12,146,2,0,0,2,NULL,NULL,0),(1076,12,94,3,24,3,24,NULL,NULL,0),(1077,12,171,0,0,0,0,NULL,NULL,0),(1078,12,101,NULL,0,0,0,NULL,NULL,0),(1079,12,195,2,0,0,2,NULL,NULL,0),(1080,12,197,NULL,0,0,0,NULL,NULL,0),(1081,12,104,NULL,0,0,0,NULL,NULL,0),(1082,12,181,2,0,0,2,NULL,NULL,0),(1083,12,174,46,0,0,46,NULL,NULL,0),(1084,12,110,45,0,0,45,NULL,NULL,0),(1085,12,120,5,0,0,5,NULL,NULL,0),(1086,12,121,NULL,0,0,0,NULL,NULL,0),(1087,12,182,2,0,0,2,NULL,NULL,0),(1088,12,194,3,0,0,3,NULL,NULL,0),(1089,12,227,NULL,0,0,0,NULL,NULL,0),(1090,12,141,NULL,0,0,0,NULL,NULL,0),(1091,12,166,2.06,0,0,2.06,NULL,NULL,0),(1092,12,128,1,0,0,1,NULL,NULL,0),(1093,12,118,157,0,5,152,NULL,NULL,0),(1094,12,172,38,0,0,38,NULL,NULL,0),(1095,12,175,24,0,0,24,NULL,NULL,0),(1096,12,102,NULL,0,0,0,NULL,NULL,0),(1097,12,164,1,0,0,1,NULL,NULL,0),(1098,12,152,18,0,2,16,NULL,NULL,0),(1099,12,90,NULL,0,0,0,NULL,NULL,0),(1100,12,176,14,0,2,12,NULL,NULL,0),(1101,12,178,4,0,0,4,NULL,NULL,0),(1102,12,85,18,0,2,16,NULL,NULL,0),(1103,12,177,16,0,0,16,NULL,NULL,0),(1104,12,189,25,0,0,25,NULL,NULL,0),(1105,12,183,2,0,0,2,NULL,NULL,0),(1106,12,199,9,0,0,9,NULL,NULL,0),(1107,12,180,1,0,0,1,NULL,NULL,0),(1108,12,103,NULL,0,0,0,NULL,NULL,0);
/*!40000 ALTER TABLE `productinventory` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `productinventory` with 422 row(s)
--

--
-- Table structure for table `product_ingrediant`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_ingrediant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `ingrediant_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FFC18F874584665A` (`product_id`),
  KEY `IDX_FFC18F878AEA29A` (`ingrediant_id`),
  CONSTRAINT `FK_FFC18F874584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_FFC18F878AEA29A` FOREIGN KEY (`ingrediant_id`) REFERENCES `ingrediant` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_ingrediant`
--

LOCK TABLES `product_ingrediant` WRITE;
/*!40000 ALTER TABLE `product_ingrediant` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `product_ingrediant` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `product_ingrediant` with 0 row(s)
--

--
-- Table structure for table `product_storage`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_storage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `storage_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantitymin` double NOT NULL,
  `quantity` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_85A300845CC5DB90` (`storage_id`),
  KEY `IDX_85A300844584665A` (`product_id`),
  CONSTRAINT `FK_85A300844584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_85A300845CC5DB90` FOREIGN KEY (`storage_id`) REFERENCES `storage` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=232 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_storage`
--

LOCK TABLES `product_storage` WRITE;
/*!40000 ALTER TABLE `product_storage` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `product_storage` VALUES (1,4,79,0,-3),(2,4,80,0,0),(3,4,81,0,13),(4,4,83,0,0),(5,4,86,0,14),(6,1,79,0,-19),(7,4,129,0,0),(8,4,109,0,123),(9,4,116,0,8),(10,4,106,0,44),(11,4,144,0,0),(12,4,126,0,1),(13,4,135,0,0.8),(14,4,141,0,0),(15,4,149,0,2),(16,4,108,0,11),(17,4,136,0,13.05),(18,4,113,0,42),(19,4,155,0,0),(20,4,122,0,1.2),(21,4,145,0,0),(22,4,132,0,2.09),(23,4,89,0,53),(24,4,94,0,24),(25,4,143,0,0),(26,4,87,0,31),(27,4,148,0,0),(28,4,151,0,1),(29,4,124,0,0.5),(30,4,134,0,0),(31,4,139,0,1.09),(32,4,111,0,45),(33,4,154,0,12),(34,4,112,0,26),(35,4,140,0,2),(36,4,138,0,0),(37,4,152,0,18),(38,4,133,0,4.01),(39,4,117,0,0),(40,4,127,0,0.8),(41,4,92,0,112),(42,4,98,0,0),(43,4,123,0,6.6),(44,4,107,0,36),(45,4,96,0,0),(46,4,97,0,0),(47,4,99,0,0),(48,4,100,0,0),(49,4,90,0,0),(50,4,91,0,0),(51,4,146,0,2),(52,4,88,0,26),(53,4,119,0,35),(54,4,130,0,3.01),(55,4,82,0,0),(56,4,95,0,0),(57,4,125,0,4),(58,4,105,0,17),(59,4,137,0,4.006),(60,4,150,0,1),(61,4,84,0,9),(62,4,156,0,6),(63,4,93,0,0),(64,4,114,0,53),(65,4,115,0,86),(66,4,131,0,2.01),(67,4,147,0,0),(68,4,101,0,0),(69,4,104,0,0),(70,4,110,0,45),(71,4,120,0,5),(72,4,121,0,0),(73,4,142,0,1),(74,4,118,0,152),(75,4,128,0,1),(76,4,102,0,0),(77,4,153,0,0),(78,4,85,0,16),(79,4,103,0,0),(80,1,7,0,0),(81,1,8,0,0),(82,1,14,0,0),(83,1,47,0,0),(84,1,71,0,0),(85,1,72,0,0),(86,1,75,0,0),(87,1,70,0,0),(88,1,32,0,0),(89,1,20,0,0),(90,1,12,0,0),(91,1,10,0,0),(92,1,13,0,0),(93,1,16,0,0),(94,1,15,0,0),(95,1,49,0,6),(96,1,51,0,0),(97,1,57,0,0),(98,1,48,0,0),(99,NULL,156,0,-7),(100,NULL,157,0,-9),(101,1,1,0,0),(102,1,9,0,0),(103,1,45,0,0),(104,1,42,0,0),(105,1,11,0,0),(106,1,43,0,0),(107,1,64,0,0),(108,1,44,0,0),(109,1,61,0,20),(110,1,4,0,-2),(111,1,2,0,0),(112,1,18,0,0),(113,1,34,0,0),(114,1,24,0,0),(115,1,33,0,0),(116,1,27,0,0),(117,1,62,0,0),(118,1,74,0,0),(119,1,50,0,0),(120,1,60,0,0),(121,1,46,0,0),(122,1,35,0,0),(123,1,55,0,0),(124,1,65,0,0),(125,1,76,0,0),(126,1,77,0,0),(127,1,19,0,0),(128,1,58,0,0),(129,1,38,0,0),(130,1,40,0,0),(131,1,21,0,0),(132,1,39,0,0),(133,1,73,0,0),(134,1,78,0,0),(135,1,66,0,0),(136,1,5,0,0),(137,1,29,0,0),(138,1,28,0,0),(139,1,22,0,0),(140,1,53,0,0),(141,1,37,0,0),(142,1,31,0,0),(143,1,63,0,0),(144,1,30,0,0),(145,1,52,0,0),(146,1,25,0,0),(147,1,23,0,0),(148,1,26,0,0),(149,1,67,0,0),(150,1,54,0,0),(151,1,36,0,0),(152,1,3,0,0),(153,1,41,0,0),(154,1,68,0,0),(155,1,59,0,-6),(156,1,56,0,0),(157,1,69,0,0),(158,1,6,0,0),(159,1,17,0,0),(160,1,161,0,50),(161,1,159,0,0),(162,NULL,165,0,-5),(163,4,163,0,1),(164,4,168,0,0.1),(165,4,167,0,1),(166,4,166,0,2.06),(167,4,164,0,1),(168,4,169,0,24),(169,4,170,0,16),(170,4,171,0,0),(171,4,172,0,38),(172,4,173,0,11),(173,4,174,0,46),(174,4,175,0,24),(175,4,176,0,12),(176,4,177,0,16),(177,4,178,0,4),(178,4,179,0,0.2),(179,4,180,0,1),(180,4,181,0,2),(181,4,182,0,2),(182,4,183,0,2),(183,4,184,0,7),(184,4,185,0,5),(185,4,186,0,3),(186,4,187,0,1),(187,4,188,0,0),(188,4,189,0,25),(189,4,190,0,15),(190,4,191,0,4),(191,4,192,0,8),(192,4,193,0,8),(193,4,194,0,3),(194,4,195,0,2),(195,4,196,0,0),(196,4,197,0,0),(197,4,198,0,6),(198,4,199,0,9),(199,1,200,0,5),(200,1,201,0,45),(201,1,202,0,94),(202,1,203,0,1),(203,1,204,0,19),(204,1,205,0,150),(205,1,206,0,4),(206,1,207,0,3),(207,1,208,0,48),(208,1,209,0,14),(209,1,210,0,0),(210,1,211,0,6),(211,1,212,0,24),(212,1,213,0,0),(213,1,214,0,4),(214,1,215,0,13),(215,1,216,0,3),(216,1,217,0,0),(217,1,218,0,15),(218,1,219,0,15),(219,1,220,0,13),(220,1,221,0,19),(221,1,222,0,0),(222,1,223,0,0),(223,1,224,0,0),(224,1,225,0,0),(225,1,226,0,0),(226,4,227,0,0),(227,1,160,0,0),(228,1,162,0,0),(229,1,158,0,0),(230,1,228,0,0),(231,1,229,0,0);
/*!40000 ALTER TABLE `product_storage` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `product_storage` with 231 row(s)
--

--
-- Table structure for table `promotion`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promotion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `price` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `time_interval` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C11D7DD14584665A` (`product_id`),
  CONSTRAINT `FK_C11D7DD14584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotion`
--

LOCK TABLES `promotion` WRITE;
/*!40000 ALTER TABLE `promotion` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `promotion` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `promotion` with 0 row(s)
--

--
-- Table structure for table `provider`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provider`
--

LOCK TABLES `provider` WRITE;
/*!40000 ALTER TABLE `provider` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `provider` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `provider` with 0 row(s)
--

--
-- Table structure for table `provision`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `storage_id` int(11) DEFAULT NULL,
  `dvups_admin_id` int(11) DEFAULT NULL,
  `status` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `numbord` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `creationdate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BA9B42905CC5DB90` (`storage_id`),
  KEY `IDX_BA9B4290AD8C93FE` (`dvups_admin_id`),
  CONSTRAINT `FK_BA9B42905CC5DB90` FOREIGN KEY (`storage_id`) REFERENCES `storage` (`id`),
  CONSTRAINT `FK_BA9B4290AD8C93FE` FOREIGN KEY (`dvups_admin_id`) REFERENCES `dvups_admin` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provision`
--

LOCK TABLES `provision` WRITE;
/*!40000 ALTER TABLE `provision` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `provision` VALUES (1,4,11,'provided',NULL,'2020-05-21 17:03:05'),(2,4,11,'provided',NULL,'2020-05-22 16:41:01'),(3,1,11,'provided',NULL,'2020-05-26 18:57:24'),(4,4,11,'provided',NULL,'2020-06-11 19:54:02'),(5,1,11,'instance',NULL,'2020-06-11 20:36:03');
/*!40000 ALTER TABLE `provision` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `provision` with 5 row(s)
--

--
-- Table structure for table `provisionproduct`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provisionproduct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `provision_id` int(11) DEFAULT NULL,
  `price` double NOT NULL,
  `quantity` double NOT NULL,
  `tostorage` int(11) NOT NULL,
  `creationdate` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AA0B61094584665A` (`product_id`),
  KEY `IDX_AA0B61093EC01A31` (`provision_id`),
  CONSTRAINT `FK_AA0B61093EC01A31` FOREIGN KEY (`provision_id`) REFERENCES `provision` (`id`),
  CONSTRAINT `FK_AA0B61094584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provisionproduct`
--

LOCK TABLES `provisionproduct` WRITE;
/*!40000 ALTER TABLE `provisionproduct` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `provisionproduct` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `provisionproduct` with 0 row(s)
--

--
-- Table structure for table `provision_item`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provision_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `provision_id` int(11) DEFAULT NULL,
  `quantity` double NOT NULL,
  `tostorage` int(11) NOT NULL,
  `creationdate` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4D49F3804584665A` (`product_id`),
  KEY `IDX_4D49F3803EC01A31` (`provision_id`),
  CONSTRAINT `FK_4D49F3803EC01A31` FOREIGN KEY (`provision_id`) REFERENCES `provision` (`id`),
  CONSTRAINT `FK_4D49F3804584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provision_item`
--

LOCK TABLES `provision_item` WRITE;
/*!40000 ALTER TABLE `provision_item` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `provision_item` VALUES (1,195,1,2,4,'2020-05-21'),(2,194,1,3,4,'2020-05-21'),(3,193,1,6,4,'2020-05-21'),(4,192,1,3,4,'2020-05-21'),(5,191,1,13,4,'2020-05-21'),(6,185,1,5,4,'2020-05-21'),(7,181,1,1,4,'2020-05-21'),(8,182,1,2,4,'2020-05-21'),(9,183,1,3,4,'2020-05-21'),(10,180,1,15,4,'2020-05-21'),(11,179,1,10,4,'2020-05-21'),(12,188,1,2,4,'2020-05-21'),(13,85,1,7,4,'2020-05-21'),(14,175,1,5,4,'2020-05-21'),(15,174,1,30,4,'2020-05-21'),(16,176,1,13,4,'2020-05-21'),(17,177,1,8,4,'2020-05-21'),(18,178,1,7,4,'2020-05-21'),(19,171,1,15,4,'2020-05-21'),(20,172,1,54,4,'2020-05-21'),(21,115,1,16,4,'2020-05-21'),(22,173,1,11,4,'2020-05-21'),(23,198,1,13,4,'2020-05-21'),(24,130,1,45,4,'2020-05-21'),(25,139,1,30,4,'2020-05-21'),(26,186,1,45,4,'2020-05-21'),(27,187,1,2,4,'2020-05-21'),(28,189,1,34,4,'2020-05-21'),(29,190,1,1,4,'2020-05-21'),(30,82,1,12,4,'2020-05-21'),(31,120,2,24,4,'2020-05-22'),(32,200,3,10,1,'2020-05-26'),(33,201,3,80,1,'2020-05-26'),(34,94,4,24,4,'2020-06-11'),(35,202,5,45,1,'2020-06-11'),(36,161,5,53,1,'2020-06-11');
/*!40000 ALTER TABLE `provision_item` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `provision_item` with 36 row(s)
--

--
-- Table structure for table `stockexchange`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stockexchange` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `creationdate` datetime NOT NULL,
  `from_storage` int(11) DEFAULT NULL,
  `to_storage` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dvups_admin_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BED541A74584665A` (`product_id`),
  KEY `IDX_BED541A7AD8C93FE` (`dvups_admin_id`),
  CONSTRAINT `FK_BED541A74584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_BED541A7AD8C93FE` FOREIGN KEY (`dvups_admin_id`) REFERENCES `dvups_admin` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=476 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stockexchange`
--

LOCK TABLES `stockexchange` WRITE;
/*!40000 ALTER TABLE `stockexchange` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `stockexchange` VALUES (1,109,'2020-05-21 15:47:47',4,0,176,' inventaire ','init',NULL),(2,116,'2020-05-21 15:47:47',4,0,6,' inventaire ','init',NULL),(3,106,'2020-05-21 15:47:47',4,0,36,' inventaire ','init',NULL),(4,143,'2020-05-21 15:47:47',4,0,0,' inventaire ','init',NULL),(5,126,'2020-05-21 15:47:47',4,0,15,' inventaire ','init',NULL),(6,134,'2020-05-21 15:47:48',4,0,0,' inventaire ','init',NULL),(7,140,'2020-05-21 15:47:48',4,0,30,' inventaire ','init',NULL),(8,148,'2020-05-21 15:47:48',4,0,0,' inventaire ','init',NULL),(9,108,'2020-05-21 15:47:48',4,0,0,' inventaire ','init',NULL),(10,135,'2020-05-21 15:47:48',4,0,13,' inventaire ','init',NULL),(11,113,'2020-05-21 15:47:48',4,0,28,' inventaire ','init',NULL),(12,154,'2020-05-21 15:47:48',4,0,8,' inventaire ','init',NULL),(13,122,'2020-05-21 15:47:48',4,0,27,' inventaire ','init',NULL),(14,144,'2020-05-21 15:47:48',4,0,0,' inventaire ','init',NULL),(15,131,'2020-05-21 15:47:48',4,0,33,' inventaire ','init',NULL),(16,89,'2020-05-21 15:47:49',4,0,30,' inventaire ','init',NULL),(17,94,'2020-05-21 15:47:49',4,0,0,' inventaire ','init',NULL),(18,142,'2020-05-21 15:47:49',4,0,15,' inventaire ','init',NULL),(19,87,'2020-05-21 15:47:49',4,0,24,' inventaire ','init',NULL),(20,86,'2020-05-21 15:47:49',4,0,13,' inventaire ','init',NULL),(21,147,'2020-05-21 15:47:49',4,0,0,' inventaire ','init',NULL),(22,150,'2020-05-21 15:47:49',4,0,15,' inventaire ','init',NULL),(23,124,'2020-05-21 15:47:49',4,0,7,' inventaire ','init',NULL),(24,133,'2020-05-21 15:47:49',4,0,61,' inventaire ','init',NULL),(25,138,'2020-05-21 15:47:49',4,0,0,' inventaire ','init',NULL),(26,111,'2020-05-21 15:47:49',4,0,59,' inventaire ','init',NULL),(27,153,'2020-05-21 15:47:49',4,0,0,' inventaire ','init',NULL),(28,112,'2020-05-21 15:47:50',4,0,13,' inventaire ','init',NULL),(29,139,'2020-05-21 15:47:50',4,0,30,' inventaire ','init',NULL),(30,137,'2020-05-21 15:47:50',4,0,72,' inventaire ','init',NULL),(31,151,'2020-05-21 15:47:50',4,0,15,' inventaire ','init',NULL),(32,132,'2020-05-21 15:47:50',4,0,30,' inventaire ','init',NULL),(33,117,'2020-05-21 15:47:50',4,0,0,' inventaire ','init',NULL),(34,127,'2020-05-21 15:47:50',4,0,12,' inventaire ','init',NULL),(35,92,'2020-05-21 15:47:50',4,0,168,' inventaire ','init',NULL),(36,98,'2020-05-21 15:47:50',4,0,0,' inventaire ','init',NULL),(37,123,'2020-05-21 15:47:50',4,0,158,' inventaire ','init',NULL),(38,107,'2020-05-21 15:47:50',4,0,27,' inventaire ','init',NULL),(39,96,'2020-05-21 15:47:50',4,0,0,' inventaire ','init',NULL),(40,97,'2020-05-21 15:47:51',4,0,0,' inventaire ','init',NULL),(41,99,'2020-05-21 15:47:51',4,0,0,' inventaire ','init',NULL),(42,100,'2020-05-21 15:47:51',4,0,0,' inventaire ','init',NULL),(43,90,'2020-05-21 15:47:51',4,0,37,' inventaire ','init',NULL),(44,91,'2020-05-21 15:47:51',4,0,0,' inventaire ','init',NULL),(45,145,'2020-05-21 15:47:51',4,0,0,' inventaire ','init',NULL),(46,88,'2020-05-21 15:47:51',4,0,44,' inventaire ','init',NULL),(47,119,'2020-05-21 15:47:51',4,0,13,' inventaire ','init',NULL),(48,129,'2020-05-21 15:47:51',4,0,0,' inventaire ','init',NULL),(49,82,'2020-05-21 15:47:51',4,0,4,' inventaire ','init',NULL),(50,80,'2020-05-21 15:47:51',4,0,0,' inventaire ','init',NULL),(51,95,'2020-05-21 15:47:52',4,0,0,' inventaire ','init',NULL),(52,125,'2020-05-21 15:47:52',4,0,55,' inventaire ','init',NULL),(53,105,'2020-05-21 15:47:52',4,0,8,' inventaire ','init',NULL),(54,136,'2020-05-21 15:47:52',4,0,45,' inventaire ','init',NULL),(55,149,'2020-05-21 15:47:52',4,0,30,' inventaire ','init',NULL),(56,163,'2020-05-21 15:47:52',4,0,20,' inventaire ','init',NULL),(57,81,'2020-05-21 15:47:52',4,0,0,' inventaire ','init',NULL),(58,79,'2020-05-21 15:47:52',4,0,0,' inventaire ','init',NULL),(59,79,'2020-05-21 15:47:52',4,0,0,' inventaire ','init',NULL),(60,84,'2020-05-21 15:47:52',4,0,9,' inventaire ','init',NULL),(61,83,'2020-05-21 15:47:52',4,0,0,' inventaire ','init',NULL),(62,155,'2020-05-21 15:47:53',4,0,0,' inventaire ','init',NULL),(63,168,'2020-05-21 15:47:53',4,0,3,' inventaire ','init',NULL),(64,167,'2020-05-21 15:47:53',4,0,15,' inventaire ','init',NULL),(65,93,'2020-05-21 15:47:53',4,0,0,' inventaire ','init',NULL),(66,114,'2020-05-21 15:47:53',4,0,31,' inventaire ','init',NULL),(67,115,'2020-05-21 15:47:53',4,0,0,' inventaire ','init',NULL),(68,130,'2020-05-21 15:47:53',4,0,14,' inventaire ','init',NULL),(69,146,'2020-05-21 15:47:53',4,0,30,' inventaire ','init',NULL),(70,101,'2020-05-21 15:47:53',4,0,0,' inventaire ','init',NULL),(71,104,'2020-05-21 15:47:53',4,0,0,' inventaire ','init',NULL),(72,110,'2020-05-21 15:47:54',4,0,0,' inventaire ','init',NULL),(73,120,'2020-05-21 15:47:54',4,0,1,' inventaire ','init',NULL),(74,121,'2020-05-21 15:47:54',4,0,0,' inventaire ','init',NULL),(75,141,'2020-05-21 15:47:54',4,0,0,' inventaire ','init',NULL),(76,166,'2020-05-21 15:47:54',4,0,40,' inventaire ','init',NULL),(77,118,'2020-05-21 15:47:54',4,0,142,' inventaire ','init',NULL),(78,128,'2020-05-21 15:47:54',4,0,20,' inventaire ','init',NULL),(79,102,'2020-05-21 15:47:54',4,0,0,' inventaire ','init',NULL),(80,164,'2020-05-21 15:47:54',4,0,20,' inventaire ','init',NULL),(81,152,'2020-05-21 15:47:55',4,0,4,' inventaire ','init',NULL),(82,85,'2020-05-21 15:47:55',4,0,0,' inventaire ','init',NULL),(83,103,'2020-05-21 15:47:55',4,0,0,' inventaire ','init',NULL),(84,195,'2020-05-21 17:03:05',NULL,4,2,'ajout de produit ',NULL,NULL),(85,194,'2020-05-21 17:06:17',NULL,4,3,'ajout de produit ',NULL,NULL),(86,193,'2020-05-21 17:06:47',NULL,4,6,'ajout de produit ',NULL,NULL),(87,192,'2020-05-21 17:07:01',NULL,4,3,'ajout de produit ',NULL,NULL),(88,191,'2020-05-21 17:07:20',NULL,4,13,'ajout de produit ',NULL,NULL),(89,185,'2020-05-21 17:08:53',NULL,4,5,'ajout de produit ',NULL,NULL),(90,181,'2020-05-21 17:10:03',NULL,4,1,'ajout de produit ',NULL,NULL),(91,182,'2020-05-21 17:10:14',NULL,4,2,'ajout de produit ',NULL,NULL),(92,183,'2020-05-21 17:10:28',NULL,4,3,'ajout de produit ',NULL,NULL),(93,180,'2020-05-21 17:11:34',NULL,4,15,'ajout de produit ',NULL,NULL),(94,179,'2020-05-21 17:12:58',NULL,4,10,'ajout de produit ',NULL,NULL),(95,188,'2020-05-21 17:15:22',NULL,4,2,'ajout de produit ',NULL,NULL),(96,85,'2020-05-21 17:18:10',NULL,4,7,'ajout de produit ',NULL,NULL),(97,175,'2020-05-21 17:18:25',NULL,4,5,'ajout de produit ',NULL,NULL),(98,174,'2020-05-21 17:18:39',NULL,4,30,'ajout de produit ',NULL,NULL),(99,176,'2020-05-21 17:19:24',NULL,4,13,'ajout de produit ',NULL,NULL),(100,177,'2020-05-21 17:19:39',NULL,4,8,'ajout de produit ',NULL,NULL),(101,178,'2020-05-21 17:19:52',NULL,4,7,'ajout de produit ',NULL,NULL),(102,171,'2020-05-21 17:24:07',NULL,4,15,'ajout de produit ',NULL,NULL),(103,172,'2020-05-21 17:24:22',NULL,4,54,'ajout de produit ',NULL,NULL),(104,115,'2020-05-21 17:24:48',NULL,4,11,'ajout de produit ',NULL,NULL),(105,173,'2020-05-21 17:25:41',NULL,4,11,'ajout de produit ',NULL,NULL),(106,115,'2020-05-21 17:26:16',NULL,4,0,'ajout de produit ',NULL,NULL),(107,115,'2020-05-21 17:36:19',NULL,4,16,'ajout de produit ',NULL,NULL),(108,198,'2020-05-21 17:39:09',NULL,4,13,'ajout de produit ',NULL,NULL),(109,130,'2020-05-21 17:49:01',NULL,4,45,'ajout de produit ',NULL,NULL),(110,139,'2020-05-21 18:02:03',NULL,4,30,'ajout de produit ',NULL,NULL),(111,186,'2020-05-21 18:05:04',NULL,4,45,'ajout de produit ',NULL,NULL),(112,187,'2020-05-21 18:06:35',NULL,4,2,'ajout de produit ',NULL,NULL),(113,189,'2020-05-21 18:08:31',NULL,4,4,'ajout de produit ',NULL,NULL),(114,189,'2020-05-21 18:09:32',NULL,4,34,'ajout de produit ',NULL,NULL),(115,190,'2020-05-21 18:09:48',NULL,4,1,'ajout de produit ',NULL,NULL),(116,82,'2020-05-21 18:35:44',NULL,4,12,'ajout de produit ',NULL,NULL),(117,120,'2020-05-22 16:41:01',NULL,4,24,'ajout de produit ',NULL,NULL),(118,177,'2020-05-22 16:41:53',4,0,1,'commande de produit','init',NULL),(119,177,'2020-05-22 16:50:18',4,0,1,'commande de produit','init',NULL),(120,79,'2020-05-22 16:50:18',4,0,1,'commande de produit','init',NULL),(121,34,'2020-05-22 16:50:18',1,0,1,'commande de produit','init',NULL),(122,33,'2020-05-22 17:13:45',1,0,2,'commande de produit','init',NULL),(123,89,'2020-05-22 17:13:45',4,0,2,'commande de produit','init',NULL),(124,200,'2020-05-26 18:57:24',NULL,1,10,'ajout de produit ',NULL,NULL),(125,201,'2020-05-26 19:07:21',NULL,1,80,'ajout de produit ',NULL,NULL),(126,201,'2020-05-26 19:22:10',1,0,0,'commande de produit Poulet 1/4 crousti','init',1),(127,122,'2020-05-26 19:22:10',4,0,0,'commande de produit','init',1),(128,201,'2020-05-26 19:33:32',1,0,3,'commande de produit Poulet 1/4 crousti','init',1),(129,122,'2020-05-26 19:33:33',4,0,2,'commande de produit','init',1),(130,122,'2020-05-26 19:39:14',4,0,0,'commande de produit','init',1),(131,122,'2020-05-26 19:40:17',4,0,0,'commande de produit','init',1),(132,201,'2020-05-30 16:19:14',1,0,1,'commande de produit Poulet 1/4 crousti /  Frites Poulet 1/4 crousti','init',1),(133,201,'2020-05-30 16:21:47',1,0,1,'commande de produit Poulet Sauce Basquaise /  Plantains Frits, Miondo Poulet Sauce Basquaise','init',1),(134,122,'2020-05-30 16:21:47',4,0,1,'commande de produit  Campari / 1/2 bouteille / ','init',1),(135,215,'2020-06-09 18:36:20',1,0,1,' commande de produit Spaghetti Bolognaise / ','init',15),(136,216,'2020-06-09 18:36:20',1,0,1,' commande de produit Spaghetti Bolognaise / ','init',15),(137,203,'2020-06-09 18:37:33',1,0,2,' commande de produit Spaghetti aux Crevettes et Légumes / ','init',15),(138,200,'2020-06-09 19:25:08',1,0,1,' commande de produit Émincés de Bœuf aux Légumes /  Pommes Sautées,Riz Blanc','init',6),(139,125,'2020-06-09 19:25:08',4,0,0,'commande de produit Bailey\'s /  Conso / ','init',6),(140,204,'2020-06-09 19:32:53',1,0,1,' commande de produit  porc grille /  Frites','init',15),(141,201,'2020-06-09 19:32:54',1,0,1,' commande de produit 1/4Poulet / ','init',15),(142,201,'2020-06-09 19:34:40',1,0,4,' commande de produit 1 poulet / ','init',15),(143,110,'2020-06-09 19:34:40',4,0,1,'commande de produit Origin / ','init',15),(144,92,'2020-06-09 19:34:40',4,0,0,'commande de produit  Malta Guinness / BOISSON GAZEUSE  / ','init',15),(145,201,'2020-06-09 20:03:45',1,0,4,' commande de produit 1 poulet / ','init',16),(146,203,'2020-06-09 20:05:31',1,0,1,' commande de produit Ndolè Crevettes /  Miondo','init',16),(147,215,'2020-06-09 20:13:42',1,0,1,' commande de produit Spaghetti Bolognaise /  Spaghetti','init',16),(148,216,'2020-06-09 20:13:42',1,0,1,' commande de produit Spaghetti Bolognaise /  Spaghetti','init',16),(149,215,'2020-06-09 20:13:42',1,0,1,' commande de produit Spaghetti Bolognaise / ','init',16),(150,216,'2020-06-09 20:13:43',1,0,1,' commande de produit Spaghetti Bolognaise / ','init',16),(151,87,'2020-06-11 19:21:26',4,0,0,'commande de produit  Djino / BOISSON GAZEUSE  / ','init',15),(152,201,'2020-06-11 19:21:26',1,0,1,' commande de produit 1/4Poulet / ','init',15),(153,152,'2020-06-11 19:24:31',4,0,1,'commande de produit Thé / ','init',15),(154,152,'2020-06-11 19:24:31',4,0,1,'commande de produit Thé / ','init',15),(155,208,'2020-06-11 19:24:32',1,0,1,' commande de produit Hamburger / ','init',15),(156,212,'2020-06-11 19:24:32',1,0,1,' commande de produit Hamburger / ','init',15),(157,4,'2020-06-11 19:24:32',1,0,1,'commande de produit Salade de Crudités / ','init',15),(158,87,'2020-06-11 19:25:57',4,0,0,'commande de produit  Djino / BOISSON GAZEUSE  / ','init',15),(159,161,'2020-06-11 19:29:40',1,0,1,'commande de produit Brochette de Boeuf / ','init',15),(160,43,'2020-06-11 19:29:40',1,0,0,'commande de produit  Frites / Portion Supplémentaire / ','init',15),(161,109,'2020-06-11 19:29:40',4,0,1,'commande de produit   Guinness p.m / ','init',15),(162,209,'2020-06-11 19:40:28',1,0,1,' commande de produit Ndolè Viande / Riz Blanc','init',15),(163,87,'2020-06-11 19:40:29',4,0,0,'commande de produit  Djino / BOISSON GAZEUSE  / ','init',15),(164,208,'2020-06-11 19:40:29',1,0,1,' commande de produit Hamburger / ','init',15),(165,212,'2020-06-11 19:40:29',1,0,1,' commande de produit Hamburger / ','init',15),(166,109,'2020-06-11 19:48:38',4,0,137,' inventaire ','init',11),(167,116,'2020-06-11 19:48:38',4,0,8,' inventaire ','init',11),(168,106,'2020-06-11 19:48:39',4,0,44,' inventaire ','init',11),(169,143,'2020-06-11 19:48:39',4,0,0,' inventaire ','init',11),(170,126,'2020-06-11 19:48:39',4,0,1,' inventaire ','init',11),(171,134,'2020-06-11 19:48:39',4,0,0,' inventaire ','init',11),(172,140,'2020-06-11 19:48:39',4,0,2,' inventaire ','init',11),(173,148,'2020-06-11 19:48:39',4,0,0,' inventaire ','init',11),(174,108,'2020-06-11 19:48:39',4,0,12,' inventaire ','init',11),(175,135,'2020-06-11 19:48:39',4,0,1,' inventaire ','init',11),(176,113,'2020-06-11 19:48:39',4,0,44,' inventaire ','init',11),(177,154,'2020-06-11 19:48:39',4,0,12,' inventaire ','init',11),(178,122,'2020-06-11 19:48:39',4,0,1,' inventaire ','init',11),(179,144,'2020-06-11 19:48:40',4,0,0,' inventaire ','init',11),(180,131,'2020-06-11 19:48:40',4,0,2,' inventaire ','init',11),(181,89,'2020-06-11 19:48:40',4,0,53,' inventaire ','init',11),(182,94,'2020-06-11 19:48:40',4,0,3,' inventaire ','init',11),(183,142,'2020-06-11 19:48:40',4,0,1,' inventaire ','init',11),(184,87,'2020-06-11 19:48:40',4,0,31,' inventaire ','init',11),(185,86,'2020-06-11 19:48:40',4,0,14,' inventaire ','init',11),(186,147,'2020-06-11 19:48:40',4,0,0,' inventaire ','init',11),(187,150,'2020-06-11 19:48:41',4,0,1,' inventaire ','init',11),(188,124,'2020-06-11 19:48:41',4,0,1,' inventaire ','init',11),(189,133,'2020-06-11 19:48:41',4,0,4,' inventaire ','init',11),(190,138,'2020-06-11 19:48:41',4,0,0,' inventaire ','init',11),(191,111,'2020-06-11 19:48:41',4,0,45,' inventaire ','init',11),(192,153,'2020-06-11 19:48:41',4,0,0,' inventaire ','init',11),(193,112,'2020-06-11 19:48:41',4,0,26,' inventaire ','init',11),(194,139,'2020-06-11 19:48:41',4,0,1,' inventaire ','init',11),(195,137,'2020-06-11 19:48:41',4,0,4,' inventaire ','init',11),(196,151,'2020-06-11 19:48:41',4,0,1,' inventaire ','init',11),(197,132,'2020-06-11 19:48:41',4,0,2,' inventaire ','init',11),(198,117,'2020-06-11 19:48:42',4,0,0,' inventaire ','init',11),(199,127,'2020-06-11 19:48:42',4,0,1,' inventaire ','init',11),(200,92,'2020-06-11 19:48:42',4,0,112,' inventaire ','init',11),(201,98,'2020-06-11 19:48:42',4,0,0,' inventaire ','init',11),(202,123,'2020-06-11 19:48:42',4,0,7,' inventaire ','init',11),(203,107,'2020-06-11 19:48:42',4,0,38,' inventaire ','init',11),(204,96,'2020-06-11 19:48:42',4,0,0,' inventaire ','init',11),(205,97,'2020-06-11 19:48:42',4,0,0,' inventaire ','init',11),(206,99,'2020-06-11 19:48:42',4,0,0,' inventaire ','init',11),(207,100,'2020-06-11 19:48:42',4,0,0,' inventaire ','init',11),(208,90,'2020-06-11 19:48:42',4,0,0,' inventaire ','init',11),(209,91,'2020-06-11 19:48:42',4,0,0,' inventaire ','init',11),(210,145,'2020-06-11 19:48:43',4,0,0,' inventaire ','init',11),(211,88,'2020-06-11 19:48:43',4,0,26,' inventaire ','init',11),(212,119,'2020-06-11 19:48:43',4,0,35,' inventaire ','init',11),(213,80,'2020-06-11 19:48:43',4,0,0,' inventaire ','init',11),(214,129,'2020-06-11 19:48:43',4,0,0,' inventaire ','init',11),(215,82,'2020-06-11 19:48:43',4,0,0,' inventaire ','init',11),(216,95,'2020-06-11 19:48:43',4,0,0,' inventaire ','init',11),(217,125,'2020-06-11 19:48:43',4,0,4,' inventaire ','init',11),(218,190,'2020-06-11 19:48:43',4,0,15,' inventaire ','init',11),(219,173,'2020-06-11 19:48:43',4,0,11,' inventaire ','init',11),(220,169,'2020-06-11 19:48:43',4,0,24,' inventaire ','init',11),(221,170,'2020-06-11 19:48:43',4,0,17,' inventaire ','init',11),(222,191,'2020-06-11 19:48:44',4,0,4,' inventaire ','init',11),(223,192,'2020-06-11 19:48:44',4,0,8,' inventaire ','init',11),(224,105,'2020-06-11 19:48:44',4,0,17,' inventaire ','init',11),(225,136,'2020-06-11 19:48:44',4,0,13,' inventaire ','init',11),(226,149,'2020-06-11 19:48:44',4,0,2,' inventaire ','init',11),(227,163,'2020-06-11 19:48:44',4,0,1,' inventaire ','init',11),(228,81,'2020-06-11 19:48:44',4,0,13,' inventaire ','init',11),(229,79,'2020-06-11 19:48:44',4,0,19,' inventaire ','init',11),(230,79,'2020-06-11 19:48:44',4,0,0,' inventaire ','init',11),(231,84,'2020-06-11 19:48:45',4,0,9,' inventaire ','init',11),(232,83,'2020-06-11 19:48:45',4,0,0,' inventaire ','init',11),(233,155,'2020-06-11 19:48:45',4,0,0,' inventaire ','init',11),(234,168,'2020-06-11 19:48:45',4,0,0,' inventaire ','init',11),(235,167,'2020-06-11 19:48:45',4,0,1,' inventaire ','init',11),(236,93,'2020-06-11 19:48:45',4,0,0,' inventaire ','init',11),(237,196,'2020-06-11 19:48:45',4,0,0,' inventaire ','init',11),(238,114,'2020-06-11 19:48:45',4,0,53,' inventaire ','init',11),(239,193,'2020-06-11 19:48:45',4,0,8,' inventaire ','init',11),(240,115,'2020-06-11 19:48:45',4,0,86,' inventaire ','init',11),(241,198,'2020-06-11 19:48:45',4,0,6,' inventaire ','init',11),(242,184,'2020-06-11 19:48:46',4,0,7,' inventaire ','init',11),(243,185,'2020-06-11 19:48:46',4,0,5,' inventaire ','init',11),(244,130,'2020-06-11 19:48:46',4,0,3,' inventaire ','init',11),(245,187,'2020-06-11 19:48:46',4,0,1,' inventaire ','init',11),(246,186,'2020-06-11 19:48:46',4,0,3,' inventaire ','init',11),(247,188,'2020-06-11 19:48:46',4,0,0,' inventaire ','init',11),(248,179,'2020-06-11 19:48:46',4,0,0,' inventaire ','init',11),(249,146,'2020-06-11 19:48:46',4,0,2,' inventaire ','init',11),(250,171,'2020-06-11 19:48:46',4,0,0,' inventaire ','init',11),(251,101,'2020-06-11 19:48:46',4,0,0,' inventaire ','init',11),(252,195,'2020-06-11 19:48:46',4,0,2,' inventaire ','init',11),(253,197,'2020-06-11 19:48:47',4,0,0,' inventaire ','init',11),(254,104,'2020-06-11 19:48:47',4,0,0,' inventaire ','init',11),(255,181,'2020-06-11 19:48:47',4,0,2,' inventaire ','init',11),(256,174,'2020-06-11 19:48:47',4,0,46,' inventaire ','init',11),(257,110,'2020-06-11 19:48:47',4,0,45,' inventaire ','init',11),(258,120,'2020-06-11 19:48:47',4,0,5,' inventaire ','init',11),(259,121,'2020-06-11 19:48:47',4,0,0,' inventaire ','init',11),(260,182,'2020-06-11 19:48:47',4,0,2,' inventaire ','init',11),(261,194,'2020-06-11 19:48:47',4,0,3,' inventaire ','init',11),(262,141,'2020-06-11 19:48:47',4,0,0,' inventaire ','init',11),(263,166,'2020-06-11 19:48:47',4,0,2,' inventaire ','init',11),(264,118,'2020-06-11 19:48:47',4,0,157,' inventaire ','init',11),(265,128,'2020-06-11 19:48:48',4,0,1,' inventaire ','init',11),(266,172,'2020-06-11 19:48:48',4,0,38,' inventaire ','init',11),(267,175,'2020-06-11 19:48:48',4,0,24,' inventaire ','init',11),(268,102,'2020-06-11 19:48:48',4,0,0,' inventaire ','init',11),(269,164,'2020-06-11 19:48:48',4,0,1,' inventaire ','init',11),(270,152,'2020-06-11 19:48:48',4,0,18,' inventaire ','init',11),(271,176,'2020-06-11 19:48:48',4,0,14,' inventaire ','init',11),(272,178,'2020-06-11 19:48:48',4,0,4,' inventaire ','init',11),(273,85,'2020-06-11 19:48:48',4,0,18,' inventaire ','init',11),(274,177,'2020-06-11 19:48:48',4,0,16,' inventaire ','init',11),(275,189,'2020-06-11 19:48:49',4,0,25,' inventaire ','init',11),(276,183,'2020-06-11 19:48:49',4,0,2,' inventaire ','init',11),(277,199,'2020-06-11 19:48:49',4,0,9,' inventaire ','init',11),(278,180,'2020-06-11 19:48:49',4,0,1,' inventaire ','init',11),(279,103,'2020-06-11 19:48:49',4,0,0,' inventaire ','init',11),(280,94,'2020-06-11 19:54:02',NULL,4,24,'ajout de produit ',NULL,NULL),(281,113,'2020-06-11 19:56:39',4,0,1,'commande de produit  Booster / ','init',15),(282,118,'2020-06-11 19:56:39',4,0,1,'commande de produit Smirnoff / ','init',15),(283,204,'2020-06-11 19:56:40',1,0,1,' commande de produit Ndole porc /  Plantains Frits','init',15),(284,221,'2020-06-11 19:56:40',1,0,1,' commande de produit Ndole porc /  Plantains Frits','init',15),(285,201,'2020-06-11 19:56:40',1,0,1,' commande de produit Poulet Sauce Basquaise /  Miondo','init',15),(286,201,'2020-06-11 20:01:04',1,0,1,' commande de produit Ndolè Poulet /  Miondo','init',15),(287,225,'2020-06-11 20:01:04',1,0,1,'commande de produit Barquette / ','init',15),(288,204,'2020-06-11 20:20:49',1,0,1,' commande de produit Ndole porc /  Frites','init',15),(289,221,'2020-06-11 20:20:49',1,0,1,' commande de produit Ndole porc /  Frites','init',15),(290,204,'2020-06-11 20:20:49',1,0,1,' commande de produit Ndole porc /  Plantains Frits','init',15),(291,221,'2020-06-11 20:20:49',1,0,1,' commande de produit Ndole porc /  Plantains Frits','init',15),(292,209,'2020-06-11 20:20:50',1,0,1,' commande de produit Ndolè Viande /  Miondo','init',15),(293,204,'2020-06-11 20:20:50',1,0,1,' commande de produit  porc grille /  Miondo','init',15),(294,225,'2020-06-11 20:20:50',1,0,1,'commande de produit Barquette / ','init',15),(295,225,'2020-06-11 20:20:50',1,0,5,'commande de produit Barquette / ','init',15),(296,206,'2020-06-11 20:20:50',1,0,1,' commande de produit  Bars / ','init',15),(297,49,'2020-06-11 20:22:18',1,0,6,' inventaire ','init',11),(298,71,'2020-06-11 20:22:18',1,0,0,' inventaire ','init',11),(299,62,'2020-06-11 20:22:19',1,0,0,' inventaire ','init',11),(300,72,'2020-06-11 20:22:19',1,0,0,' inventaire ','init',11),(301,74,'2020-06-11 20:22:19',1,0,0,' inventaire ','init',11),(302,50,'2020-06-11 20:22:19',1,0,0,' inventaire ','init',11),(303,51,'2020-06-11 20:22:19',1,0,0,' inventaire ','init',11),(304,43,'2020-06-11 20:22:19',1,0,0,' inventaire ','init',11),(305,75,'2020-06-11 20:22:19',1,0,0,' inventaire ','init',11),(306,45,'2020-06-11 20:22:19',1,0,0,' inventaire ','init',11),(307,44,'2020-06-11 20:22:19',1,0,0,' inventaire ','init',11),(308,47,'2020-06-11 20:22:19',1,0,0,' inventaire ','init',11),(309,61,'2020-06-11 20:22:20',1,0,20,' inventaire ','init',11),(310,222,'2020-06-11 20:22:20',1,0,0,' inventaire ','init',11),(311,46,'2020-06-11 20:22:20',1,0,0,' inventaire ','init',11),(312,60,'2020-06-11 20:22:20',1,0,0,' inventaire ','init',11),(313,34,'2020-06-11 20:22:20',1,0,0,' inventaire ','init',11),(314,35,'2020-06-11 20:22:20',1,0,0,' inventaire ','init',11),(315,55,'2020-06-11 20:22:20',1,0,0,' inventaire ','init',11),(316,64,'2020-06-11 20:22:20',1,0,0,' inventaire ','init',11),(317,225,'2020-06-11 20:22:20',1,0,0,' inventaire ','init',11),(318,65,'2020-06-11 20:22:20',1,0,0,' inventaire ','init',11),(319,215,'2020-06-11 20:22:21',1,0,16,' inventaire ','init',11),(320,76,'2020-06-11 20:22:21',1,0,0,' inventaire ','init',11),(321,77,'2020-06-11 20:22:21',1,0,0,' inventaire ','init',11),(322,19,'2020-06-11 20:22:21',1,0,0,' inventaire ','init',11),(323,159,'2020-06-11 20:22:21',1,0,0,' inventaire ','init',11),(324,205,'2020-06-11 20:22:21',1,0,156,' inventaire ','init',11),(325,12,'2020-06-11 20:22:21',1,0,0,' inventaire ','init',11),(326,161,'2020-06-11 20:22:21',1,0,0,' inventaire ','init',11),(327,58,'2020-06-11 20:22:21',1,0,0,' inventaire ','init',11),(328,160,'2020-06-11 20:22:22',1,0,0,' inventaire ','init',11),(329,211,'2020-06-11 20:22:22',1,0,6,' inventaire ','init',11),(330,213,'2020-06-11 20:22:22',1,0,0,' inventaire ','init',11),(331,38,'2020-06-11 20:22:22',1,0,0,' inventaire ','init',11),(332,40,'2020-06-11 20:22:22',1,0,0,' inventaire ','init',11),(333,2,'2020-06-11 20:22:22',1,0,0,' inventaire ','init',11),(334,203,'2020-06-11 20:22:22',1,0,1,' inventaire ','init',11),(335,21,'2020-06-11 20:22:22',1,0,0,' inventaire ','init',11),(336,39,'2020-06-11 20:22:22',1,0,0,' inventaire ','init',11),(337,73,'2020-06-11 20:22:22',1,0,0,' inventaire ','init',11),(338,20,'2020-06-11 20:22:22',1,0,0,' inventaire ','init',11),(339,78,'2020-06-11 20:22:22',1,0,0,' inventaire ','init',11),(340,7,'2020-06-11 20:22:23',1,0,0,' inventaire ','init',11),(341,32,'2020-06-11 20:22:23',1,0,0,' inventaire ','init',11),(342,66,'2020-06-11 20:22:23',1,0,0,' inventaire ','init',11),(343,5,'2020-06-11 20:22:23',1,0,0,' inventaire ','init',11),(344,214,'2020-06-11 20:22:23',1,0,4,' inventaire ','init',11),(345,223,'2020-06-11 20:22:23',1,0,0,' inventaire ','init',11),(346,29,'2020-06-11 20:22:23',1,0,0,' inventaire ','init',11),(347,27,'2020-06-11 20:22:23',1,0,0,' inventaire ','init',11),(348,28,'2020-06-11 20:22:23',1,0,0,' inventaire ','init',11),(349,22,'2020-06-11 20:22:23',1,0,0,' inventaire ','init',11),(350,53,'2020-06-11 20:22:23',1,0,0,' inventaire ','init',11),(351,37,'2020-06-11 20:22:24',1,0,0,' inventaire ','init',11),(352,208,'2020-06-11 20:22:24',1,0,49,' inventaire ','init',11),(353,31,'2020-06-11 20:22:24',1,0,0,' inventaire ','init',11),(354,63,'2020-06-11 20:22:24',1,0,0,' inventaire ','init',11),(355,30,'2020-06-11 20:22:24',1,0,0,' inventaire ','init',11),(356,52,'2020-06-11 20:22:24',1,0,0,' inventaire ','init',11),(357,218,'2020-06-11 20:22:24',1,0,15,' inventaire ','init',11),(358,221,'2020-06-11 20:22:24',1,0,21,' inventaire ','init',11),(359,210,'2020-06-11 20:22:24',1,0,0,' inventaire ','init',11),(360,24,'2020-06-11 20:22:24',1,0,0,' inventaire ','init',11),(361,226,'2020-06-11 20:22:25',1,0,0,' inventaire ','init',11),(362,25,'2020-06-11 20:22:25',1,0,0,' inventaire ','init',11),(363,23,'2020-06-11 20:22:25',1,0,0,' inventaire ','init',11),(364,26,'2020-06-11 20:22:25',1,0,0,' inventaire ','init',11),(365,220,'2020-06-11 20:22:25',1,0,13,' inventaire ','init',11),(366,67,'2020-06-11 20:22:25',1,0,0,' inventaire ','init',11),(367,224,'2020-06-11 20:22:25',1,0,0,' inventaire ','init',11),(368,70,'2020-06-11 20:22:25',1,0,0,' inventaire ','init',11),(369,212,'2020-06-11 20:22:25',1,0,25,' inventaire ','init',11),(370,18,'2020-06-11 20:22:25',1,0,0,' inventaire ','init',11),(371,8,'2020-06-11 20:22:25',1,0,0,' inventaire ','init',11),(372,206,'2020-06-11 20:22:26',1,0,6,' inventaire ','init',11),(373,207,'2020-06-11 20:22:26',1,0,4,' inventaire ','init',11),(374,54,'2020-06-11 20:22:26',1,0,0,' inventaire ','init',11),(375,204,'2020-06-11 20:22:26',1,0,20,' inventaire ','init',11),(376,9,'2020-06-11 20:22:26',1,0,0,' inventaire ','init',11),(377,201,'2020-06-11 20:22:26',1,0,54,' inventaire ','init',11),(378,162,'2020-06-11 20:22:26',1,0,0,' inventaire ','init',11),(379,33,'2020-06-11 20:22:26',1,0,0,' inventaire ','init',11),(380,11,'2020-06-11 20:22:26',1,0,0,' inventaire ','init',11),(381,10,'2020-06-11 20:22:26',1,0,0,' inventaire ','init',11),(382,36,'2020-06-11 20:22:26',1,0,0,' inventaire ','init',11),(383,217,'2020-06-11 20:22:27',1,0,0,' inventaire ','init',11),(384,42,'2020-06-11 20:22:27',1,0,0,' inventaire ','init',11),(385,202,'2020-06-11 20:22:27',1,0,58,' inventaire ','init',11),(386,14,'2020-06-11 20:22:27',1,0,0,' inventaire ','init',11),(387,13,'2020-06-11 20:22:27',1,0,0,' inventaire ','init',11),(388,1,'2020-06-11 20:22:27',1,0,0,' inventaire ','init',11),(389,4,'2020-06-11 20:22:27',1,0,0,' inventaire ','init',11),(390,158,'2020-06-11 20:22:27',1,0,0,' inventaire ','init',11),(391,3,'2020-06-11 20:22:27',1,0,0,' inventaire ','init',11),(392,41,'2020-06-11 20:22:27',1,0,0,' inventaire ','init',11),(393,68,'2020-06-11 20:22:27',1,0,0,' inventaire ','init',11),(394,59,'2020-06-11 20:22:27',1,0,0,' inventaire ','init',11),(395,57,'2020-06-11 20:22:28',1,0,0,' inventaire ','init',11),(396,56,'2020-06-11 20:22:28',1,0,0,' inventaire ','init',11),(397,48,'2020-06-11 20:22:28',1,0,0,' inventaire ','init',11),(398,216,'2020-06-11 20:22:28',1,0,6,' inventaire ','init',11),(399,69,'2020-06-11 20:22:28',1,0,0,' inventaire ','init',11),(400,16,'2020-06-11 20:22:28',1,0,0,' inventaire ','init',11),(401,15,'2020-06-11 20:22:28',1,0,0,' inventaire ','init',11),(402,200,'2020-06-11 20:22:28',1,0,5,' inventaire ','init',11),(403,6,'2020-06-11 20:22:28',1,0,0,' inventaire ','init',11),(404,17,'2020-06-11 20:22:28',1,0,0,' inventaire ','init',11),(405,219,'2020-06-11 20:22:28',1,0,15,' inventaire ','init',11),(406,209,'2020-06-11 20:22:28',1,0,19,' inventaire ','init',11),(407,209,'2020-06-11 20:23:28',1,0,1,' commande de produit Ndolè Viande /  Miondo','init',15),(408,87,'2020-06-11 20:23:28',4,0,0,'commande de produit  Djino / BOISSON GAZEUSE  / ','init',15),(409,208,'2020-06-11 20:23:28',1,0,1,' commande de produit Hamburger / ','init',15),(410,212,'2020-06-11 20:23:28',1,0,1,' commande de produit Hamburger / ','init',15),(411,113,'2020-06-11 20:27:17',4,0,1,'commande de produit  Booster / ','init',15),(412,118,'2020-06-11 20:27:17',4,0,1,'commande de produit Smirnoff Ice / ','init',15),(413,204,'2020-06-11 20:27:17',1,0,1,' commande de produit Ndole porc /  Plantains Frits','init',15),(414,221,'2020-06-11 20:27:17',1,0,1,' commande de produit Ndole porc /  Plantains Frits','init',15),(415,201,'2020-06-11 20:27:17',1,0,1,' commande de produit Poulet Sauce Basquaise / ','init',15),(416,118,'2020-06-11 20:34:32',4,0,1,'commande de produit Smirnoff Ice / ','init',15),(417,209,'2020-06-11 20:34:32',1,0,1,' commande de produit Ndolè Viande /  Plantains Frits','init',15),(418,215,'2020-06-11 20:34:32',1,0,1,' commande de produit Spaghetti Bolognaise / ','init',15),(419,216,'2020-06-11 20:34:32',1,0,1,' commande de produit Spaghetti Bolognaise / ','init',15),(420,118,'2020-06-11 20:34:32',4,0,1,'commande de produit Smirnoff Ice / ','init',15),(421,202,'2020-06-11 20:36:03',NULL,1,45,'ajout de produit ',NULL,NULL),(422,161,'2020-06-11 20:36:38',NULL,1,53,'ajout de produit ',NULL,NULL),(423,201,'2020-06-11 20:51:39',1,0,1,' commande de produit 1/4Poulet / Riz Blanc','init',15),(424,89,'2020-06-11 20:51:39',4,0,0,'commande de produit  Coca-Cola / BOISSON GAZEUSE  / ','init',15),(425,202,'2020-06-11 20:55:15',1,0,4,' commande de produit Brochette de Rognon / ','init',15),(426,43,'2020-06-11 20:55:15',1,0,0,'commande de produit  Frites / Portion Supplémentaire / ','init',15),(427,94,'2020-06-11 20:55:16',4,0,1,'commande de produit jus naturel / ','init',15),(428,202,'2020-06-11 20:56:56',1,0,3,' commande de produit Rognons de Bœuf à la Provençale /  Miondo','init',15),(429,89,'2020-06-11 20:56:56',4,0,0,'commande de produit  Coca-Cola / BOISSON GAZEUSE  / ','init',15),(430,118,'2020-06-11 20:56:56',4,0,1,'commande de produit Smirnoff Ice / ','init',15),(431,206,'2020-06-11 20:59:47',1,0,1,'commande de produit poisson frais / ','init',15),(432,201,'2020-06-11 20:59:47',1,0,1,' commande de produit 1/4Poulet / ','init',15),(433,94,'2020-06-11 20:59:47',4,0,1,'commande de produit jus naturel / ','init',15),(434,94,'2020-06-11 20:59:47',4,0,1,'commande de produit jus naturel / ','init',15),(435,221,'2020-06-11 21:01:18',1,0,1,' commande de produit ndole poisson fume /  Frites','init',15),(436,207,'2020-06-11 21:01:18',1,0,1,' commande de produit ndole poisson fume /  Frites','init',15),(437,206,'2020-06-11 21:01:18',1,0,1,'commande de produit poisson frais / ','init',15),(438,170,'2020-06-11 21:01:18',4,0,1,'commande de produit beaufort ordinaire / ','init',15),(439,79,'2020-06-11 21:01:18',4,0,1,'commande de produit Eau Minérale Plate 1 / ','init',15),(440,161,'2020-06-11 21:20:56',1,0,3,'commande de produit Brochette de Boeuf / ','init',15),(441,108,'2020-06-12 14:37:39',4,0,1,'commande de produit  Beaufort tango / ','init',15),(442,79,'2020-06-12 14:37:39',4,0,1,'commande de produit Eau Minérale Plate 1 / ','init',15),(443,201,'2020-06-12 14:37:39',1,0,4,' commande de produit Poulet D.G ( entier) / ','init',15),(444,4,'2020-06-12 14:37:39',1,0,1,'commande de produit Salade de Crudités / ','init',15),(445,43,'2020-06-12 14:37:40',1,0,0,'commande de produit  Frites / Portion Supplémentaire / ','init',15),(446,205,'2020-06-12 14:37:40',1,0,6,' commande de produit Boulette de viande / ','init',15),(447,202,'2020-06-12 16:18:17',1,0,2,' commande de produit Brochette de Rognon / ','init',15),(448,107,'2020-06-12 16:18:18',4,0,1,'commande de produit  Mützig / ','init',15),(449,107,'2020-06-12 16:18:18',4,0,1,'commande de produit  Mützig / ','init',15),(450,209,'2020-06-12 16:22:16',1,0,2,' commande de produit Ndolè Viande /  Plantains Frits, Miondo','init',15),(451,89,'2020-06-12 16:22:16',4,0,0,'commande de produit  Coca-Cola / BOISSON GAZEUSE  / ','init',15),(452,86,'2020-06-12 16:22:16',4,0,0,'commande de produit  Fanta / BOISSON GAZEUSE  / ','init',15),(453,165,'2020-06-12 16:32:24',NULL,0,1,'commande de produit Tripe / Riz Blanc','init',15),(454,165,'2020-06-12 16:32:24',NULL,0,1,'commande de produit Tripe /  Plantains Frits','init',15),(455,88,'2020-06-12 16:32:24',4,0,0,'commande de produit  Vimto / BOISSON GAZEUSE  / ','init',15),(456,89,'2020-06-12 16:32:25',4,0,0,'commande de produit  Coca-Cola / BOISSON GAZEUSE  / ','init',15),(457,4,'2020-06-12 16:33:59',1,0,1,'commande de produit Salade de Crudités / ','init',15),(458,209,'2020-06-12 16:33:59',1,0,1,' commande de produit Ndolè Viande /  Plantains Frits','init',15),(459,79,'2020-06-12 16:33:59',4,0,1,'commande de produit Eau Minérale Plate 1 / ','init',15),(460,215,'2020-06-13 23:50:16',1,0,2,' commande de produit Spaghetti Bolognaise','init',1),(461,216,'2020-06-13 23:50:16',1,0,2,' commande de produit Spaghetti Bolognaise','init',1),(462,109,'2020-06-13 23:50:16',4,0,1,'commande de produit   Guinness p.m','init',1),(463,176,'2020-06-13 23:50:16',4,0,1,'commande de produit top ananas','init',1),(464,109,'2020-06-13 23:50:16',4,0,1,'commande de produit   Guinness p.m','init',1),(465,176,'2020-06-13 23:50:16',4,0,1,'commande de produit top ananas','init',1),(466,59,'2020-06-14 02:08:58',1,0,6,' commande de produit Saucisse Chipolatas','init',1),(467,201,'2020-06-14 02:08:59',1,0,2,' commande de produit Poulet Sauce d Arachide','init',1),(468,85,'2020-06-14 02:08:59',4,0,1,'commande de produit Top grenadine','init',1),(469,85,'2020-06-14 02:08:59',4,0,1,'commande de produit Top grenadine','init',1),(470,109,'2020-06-14 09:13:24',4,0,5,' avarie de produit   Guinness p.m','init',1),(471,109,'2020-06-14 09:33:34',4,0,3,' avarie de produit   Guinness p.m','init',1),(472,109,'2020-06-14 11:37:17',4,0,4,'commande de produit   Guinness p.m','init',1),(473,123,'2020-06-14 11:37:17',4,0,0,'commande de produit  Martini','init',1),(474,123,'2020-06-14 11:37:17',4,0,0,'commande de produit  Martini','init',1),(475,92,'2020-06-14 11:37:17',4,0,0,'commande de produit  Malta Guinness','init',1);
/*!40000 ALTER TABLE `stockexchange` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `stockexchange` with 475 row(s)
--

--
-- Table structure for table `storage`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `storage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `main` int(11) NOT NULL,
  `name` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `storage`
--

LOCK TABLES `storage` WRITE;
/*!40000 ALTER TABLE `storage` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `storage` VALUES (1,1,'food'),(4,0,'drink');
/*!40000 ALTER TABLE `storage` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `storage` with 2 row(s)
--

--
-- Table structure for table `table_room`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `table_room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `adminid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `table_room`
--

LOCK TABLES `table_room` WRITE;
/*!40000 ALTER TABLE `table_room` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `table_room` VALUES (1,'A1',0),(2,'A2',0),(3,'A3',0),(4,'A4',0),(5,'A5',0),(6,'A6',0),(7,'A7',0),(8,'A8',0),(9,'A9',0),(10,'B1',0),(11,'B2',0),(12,'B3',0),(13,'B4',0),(14,'B5',0),(15,'B6',0),(16,'C1',0),(17,'C2',0),(18,'C3',0),(19,'C4',0),(20,'C5',0),(21,'C6',0),(22,'C7',0),(23,'C8',0),(24,'C9',0),(25,'C10',0),(26,'C11',0),(27,'C12',0),(28,'C13',0),(29,'E5',0),(30,'D1',0),(31,'D2',0),(32,'D3',0),(33,'D4',0),(34,'D5',0),(35,'D6',0),(36,'D7',0),(37,'D8',0),(38,'D9',0),(39,'D10',0),(40,'D11',0),(41,'E1',0),(42,'E2',0),(43,'E3',0),(44,'A10',0),(45,'A11',0),(46,'A12',0),(47,'A13',0),(48,'A14',0),(49,'A15',0),(50,'A16',0),(51,'A17',0),(52,'A18',0),(53,'A19',0),(54,'D12',0),(55,'D13',0),(56,'D14',0),(57,'D15',0),(58,'E4',0);
/*!40000 ALTER TABLE `table_room` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `table_room` with 58 row(s)
--

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on: Mon, 15 Jun 2020 18:02:52 +0200
