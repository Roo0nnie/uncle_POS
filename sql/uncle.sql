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
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (63,'Customer 1',NULL,NULL,NULL,'2025-03-18',NULL,NULL,NULL,'Cash',164.00,'Done','2025-03-18 08:11:51','3084849497436',200.00),(64,'John Doe',NULL,NULL,NULL,'2025-03-27',NULL,NULL,NULL,'Cash',509.20,'Done','2025-03-27 22:20:25','8317442918900',600.02),(65,'John Smith',NULL,NULL,NULL,'2025-03-27',NULL,NULL,NULL,'Cash',144.00,'Done','2025-03-27 22:35:14','1043666532158',250.00),(66,'Mike Flores',NULL,NULL,NULL,'2025-03-27',NULL,NULL,20.00,'Cash',471.20,'Done','2025-03-27 23:07:53','8270470198739',500.00),(67,'Michael Bon',NULL,NULL,NULL,'2025-03-27',NULL,NULL,0.00,'Cash',144.00,'Done','2025-03-27 23:25:15','3115412776340',200.00),(68,'Mike Tyson',NULL,NULL,NULL,'2025-03-27',NULL,NULL,20.00,'Cash',23.28,'Done','2025-03-27 23:53:40','4552190771138',30.00),(69,'Joenillo',NULL,NULL,NULL,'2025-03-27',NULL,NULL,30.00,'Cash',359.94,'Done','2025-03-28 00:15:34','1770483246917',400.00);
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
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (96,64,48,1,17.10),(97,64,49,1,226.10),(98,64,50,1,38.00),(99,64,51,1,228.00),(100,65,58,1,144.00),(101,66,48,1,17.10),(102,66,49,1,226.10),(103,66,51,1,228.00),(104,67,58,1,144.00),(105,68,48,1,17.10),(106,68,47,1,12.00),(107,69,46,1,38.00),(108,69,53,1,224.20),(109,69,52,1,228.00),(110,69,47,2,12.00);
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
  PRIMARY KEY (`id`),
  KEY `prod_category_idx` (`prod_category`),
  CONSTRAINT `prod_category` FOREIGN KEY (`prod_category`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (46,'Chicken Breast',9,38.00,17,1,'2025-03-26 00:26:30','2025-03-26 00:41:09','kg',90.00,20.00),(47,'Coke',117,12.00,19,1,'2025-03-27 21:57:40',NULL,'pcs',20.00,10.00),(48,'Banana',7,17.10,21,1,'2025-03-27 22:06:14',NULL,'kg',90.00,9.00),(49,'Papaya',18,226.10,21,1,'2025-03-27 22:06:37',NULL,'kg',90.00,119.00),(50,'Potatoes',9,38.00,21,1,'2025-03-27 22:09:17',NULL,'kg',90.00,20.00),(51,'Santol',8,228.00,21,1,'2025-03-27 22:10:08',NULL,'kg',90.00,120.00),(52,'Tigh',9,228.00,17,1,'2025-03-27 22:10:33',NULL,'kg',90.00,120.00),(53,'Drum Stick',9,224.20,17,1,'2025-03-27 22:11:10',NULL,'kg',90.00,118.00),(54,'Carrot',10,228.00,18,1,'2025-03-27 22:25:20',NULL,'kg',90.00,120.00),(55,'Bear Brand',8,144.00,20,1,'2025-03-27 22:25:43',NULL,'pcs',20.00,120.00),(56,'Alaska',10,144.00,20,1,'2025-03-27 22:26:09',NULL,'pcs',20.00,120.00),(58,'Barako',6,144.00,23,1,'2025-03-27 22:28:00',NULL,'pcs',20.00,120.00);
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
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier`
--

LOCK TABLES `supplier` WRITE;
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;
INSERT INTO `supplier` VALUES (2,'Supplier 1','0987654321','This is just a sample supplier.This is just a sample supplier.This is just a sample supplier.This is just a sample supplier.','Active','2025-03-15 15:12:58','2025-03-23 13:59:29');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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

-- Dump completed on 2025-03-28 18:58:17
