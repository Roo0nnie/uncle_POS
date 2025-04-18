-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: inventory_system
-- ------------------------------------------------------
-- Server version	8.0.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (17,'Meat','This is just a sample meat.','2024-11-21 22:34:12','2024-11-25 09:18:48'),(18,'Vegetable','This is a sample vegetable.','2024-11-22 00:48:47','2024-11-25 09:18:48'),(19,'Softdrink','This is just a sample description','2024-11-24 14:12:46','2024-11-25 09:18:48'),(20,'Milk','This is just a sample milk category.','2024-11-24 14:29:56','2024-11-25 09:18:48'),(21,'Fruit','This is just a simple category po.','2024-11-25 09:18:33','2024-11-25 09:18:48'),(22,'Noddles','This is a noddles','2025-03-27 22:27:05',NULL),(23,'Coffee','This is a coffee','2025-03-27 22:27:17',NULL);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(45) DEFAULT NULL,
  `middlename` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `dis_apply` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `pay_method` varchar(45) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `trans_id` varchar(45) NOT NULL,
  `cus_payment` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `trans_id_UNIQUE` (`trans_id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (63,'Customer 1',NULL,NULL,NULL,'2025-03-18',NULL,NULL,NULL,'Cash',164.00,'Done','2025-03-18 08:11:51','3084849497436',200.00),(64,'John Doe',NULL,NULL,NULL,'2025-03-27',NULL,NULL,NULL,'Cash',509.20,'Done','2025-03-27 22:20:25','8317442918900',600.02),(65,'John Smith',NULL,NULL,NULL,'2025-03-27',NULL,NULL,NULL,'Cash',144.00,'Done','2025-03-27 22:35:14','1043666532158',250.00),(66,'Mike Flores',NULL,NULL,NULL,'2025-03-27',NULL,NULL,20.00,'Cash',471.20,'Done','2025-03-27 23:07:53','8270470198739',500.00),(67,'Michael Bon',NULL,NULL,NULL,'2025-03-27',NULL,NULL,0.00,'Cash',144.00,'Done','2025-03-27 23:25:15','3115412776340',200.00),(68,'Mike Tyson',NULL,NULL,NULL,'2025-03-27',NULL,NULL,20.00,'Cash',23.28,'Done','2025-03-27 23:53:40','4552190771138',30.00),(69,'Joenillo',NULL,NULL,NULL,'2025-03-27',NULL,NULL,30.00,'Cash',359.94,'Done','2025-03-28 00:15:34','1770483246917',400.00),(70,'Mike Smith',NULL,NULL,NULL,'2025-04-10',NULL,NULL,20.00,'Cash',115.20,'Done','2025-04-10 22:06:20','439919100236',120.00),(71,'Mich',NULL,NULL,NULL,'2025-04-12',NULL,NULL,0.00,'Cash',1140.00,'Done','2025-04-12 22:18:57','358928266427',1200.00),(72,'Mike',NULL,NULL,NULL,'2025-04-12',NULL,NULL,0.00,'Cash',334.00,'Done','2025-04-13 00:43:27','8706991282074',350.00);
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discount`
--

DROP TABLE IF EXISTS `discount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `discount` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `description` text,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discount`
--

LOCK TABLES `discount` WRITE;
/*!40000 ALTER TABLE `discount` DISABLE KEYS */;
INSERT INTO `discount` VALUES (3,'Student',20.00,'This is for student','2025-03-23',NULL),(5,'Senior Citizen',30.00,'This is for the senior citizen This is for the senior citizen This is for the senior citizen This is for the senior citizen This is for the senior citizen','2025-03-23','2025-03-23');
/*!40000 ALTER TABLE `discount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `cost_price` decimal(10,2) DEFAULT NULL,
  `selling_price` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `exp_date` tinyint DEFAULT '0',
  `unit` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory`
--

LOCK TABLES `inventory` WRITE;
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
INSERT INTO `inventory` VALUES (1,46,17,100.00,12.00,12.00,'2025-04-11 20:51:14','2025-04-11 20:51:14',0,NULL);
/*!40000 ALTER TABLE `inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cust_id` int DEFAULT NULL,
  `prod_id` int DEFAULT NULL,
  `order_quantity` int DEFAULT NULL,
  `order_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cust_id_idx` (`cust_id`),
  KEY `prod_id_idx` (`prod_id`),
  CONSTRAINT `cust_id` FOREIGN KEY (`cust_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `prod_id` FOREIGN KEY (`prod_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (113,72,66,1,98.00),(114,72,63,2,118.00);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `prod_name` varchar(45) DEFAULT NULL,
  `prod_quantity` int DEFAULT NULL,
  `prod_price` decimal(10,2) DEFAULT NULL,
  `prod_category` int DEFAULT NULL,
  `prod_expiry` tinyint DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `unit` varchar(45) DEFAULT NULL,
  `vat_percent` decimal(10,2) DEFAULT NULL,
  `orig_price` decimal(10,2) DEFAULT NULL,
  `barcode` varchar(45) DEFAULT NULL,
  `description` text,
  `reason` text,
  `sup_id` int DEFAULT NULL,
  `del_date` datetime DEFAULT NULL,
  `trans_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prod_category_idx` (`prod_category`),
  KEY `sup_id_idx` (`sup_id`),
  CONSTRAINT `prod_category` FOREIGN KEY (`prod_category`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (62,'Sampe',100,11.00,18,1,'2025-04-13 00:13:54','2025-04-13 00:24:09','pcs',0.00,11.00,'','','',NULL,NULL,NULL),(63,'Wings',8,118.00,17,1,'2025-04-13 00:40:34','2025-04-13 14:52:17','kg',0.00,118.00,'','',NULL,NULL,NULL,NULL),(64,'Beans',100,100.00,18,1,'2025-04-13 00:40:52','2025-04-13 15:13:42','pcs',0.00,100.00,'','','',2,'2025-04-16 00:00:00','TXN-67FB60FDDC88E'),(65,'Alaska',130,65.00,20,1,'2025-04-13 00:41:17','2025-04-13 14:44:56','pcs',0.00,65.00,'','','',NULL,NULL,NULL),(66,'Mango',100,200.00,21,0,'2025-04-13 00:41:39','2025-04-13 15:13:56','kg',0.00,108.00,'','','',3,'2025-04-16 00:00:00','TXN-67FB62FC87D1B'),(67,'Carrot',100,18.00,18,1,'2025-04-13 00:42:05',NULL,'pcs',0.00,18.00,'','',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supplier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sup_name` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `remark` text,
  `status` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier`
--

LOCK TABLES `supplier` WRITE;
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;
INSERT INTO `supplier` VALUES (1,'Supplier 2','0912312312','This is just a sample supplier.This is just a sample supplier.This is just a sample supplier.This is just a sample supplier.','Active','2025-03-15 15:12:58','2025-03-15 15:12:58'),(2,'Supplier 1','0987654321','This is just a sample supplier.This is just a sample supplier.This is just a sample supplier.This is just a sample supplier.','Active','2025-03-15 15:12:58','2025-03-23 13:59:29'),(3,'JB','123123123','Jollibee','active','2025-04-11 03:42:40',NULL);
/*!40000 ALTER TABLE `supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `role` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT 'Inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Ronnie','Estiller','admin','admin123','admin','2025-03-15 15:12:58','2025-03-15 15:20:45','admin@gmail.com','Inactive'),(2,'Mark','Estillero','cashier','cashier123','cashier','2025-03-15 15:12:58','2025-03-23 11:20:55','cashier@gmail.com','Active');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vat`
--

DROP TABLE IF EXISTS `vat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `vat` decimal(10,2) DEFAULT NULL,
  `description` text,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vat`
--

LOCK TABLES `vat` WRITE;
/*!40000 ALTER TABLE `vat` DISABLE KEYS */;
INSERT INTO `vat` VALUES (3,'Vat 2',90.00,'This is a sample vat  2','2025-03-23','2025-03-25'),(4,'Vat 1',20.00,'This is just a sample vat 1 description','2025-03-25',NULL);
/*!40000 ALTER TABLE `vat` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-13 15:16:59
