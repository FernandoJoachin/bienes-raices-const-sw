-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: localhost    Database: bienesraices_crud
-- ------------------------------------------------------
-- Server version	8.0.31

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
-- Table structure for table `articulos`
--

DROP TABLE IF EXISTS `articulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `articulos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `autor` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `titulo` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `contenido` text COLLATE utf8mb4_unicode_ci,
  `imagen` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulos`
--

LOCK TABLES `articulos` WRITE;
/*!40000 ALTER TABLE `articulos` DISABLE KEYS */;
INSERT INTO `articulos` VALUES (1,'Aitor Cardoné','2023-12-03','Compra tu primer departamento','Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum et ex, explicabo, recusandae possimus accusamus ab architecto reiciendis suscipit inventore rerum \r\n          ','            Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum et ex, explicabo, recusandae possimus accusamus ab architecto reiciendis suscipit inventore rerum necessitatibus alias minus perferendis unde, minima nemo laborum natus.\r\n            Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum et ex, explicabo, recusandae possimus accusamus ab architecto reiciendis suscipit inventore rerum necessitatibus alias minus perferendis unde, minima nemo laborum natus.\r\n','f16b019482d32272aa8626b10343a959.jpg'),(2,'Carlos May','2023-12-03','Sé el más aesthetic de tus amigos','Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum et ex, explicabo, recusandae possimus accusamus ab architecto reiciendis suscipit inventore rerum ','Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum et ex, explicabo, recusandae possimus accusamus ab architecto reiciendis suscipit inventore rerum necessitatibus alias minus perferendis unde, minima nemo laborum natus.\r\n','bc35da967e77ff1bfd31a1f4f9a07035.jpg'),(3,'Albertano Santa Cruz','2023-12-04','Top 10 razones para invertir en propiedades','Lorem ipsum dolor sit amet consectetur \r\n','Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum et ex, explicabo, recusandae possimus accusamus ab architecto reiciendis suscipit inventore rerum \r\n','e4d1d23c20e911d07cbd43237e8746a9.jpg');
/*!40000 ALTER TABLE `articulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `propiedades`
--

DROP TABLE IF EXISTS `propiedades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `propiedades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(45) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `imagen` varchar(200) DEFAULT NULL,
  `descripcion` longtext,
  `habitaciones` int DEFAULT NULL,
  `wc` int DEFAULT NULL,
  `estacionamiento` int DEFAULT NULL,
  `creado` date DEFAULT NULL,
  `vendedores_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_propiedades_vendedores_idx` (`vendedores_id`),
  CONSTRAINT `fk_propiedades_vendedores` FOREIGN KEY (`vendedores_id`) REFERENCES `vendedores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `propiedades`
--

LOCK TABLES `propiedades` WRITE;
/*!40000 ALTER TABLE `propiedades` DISABLE KEYS */;
INSERT INTO `propiedades` VALUES (9,'Cabaña en el bosque',120000.00,'daa34c399151cff5e7a6af3919415691.jpg','Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum et ex, explicabo, recusandae possimus accusamus ab architecto reiciendis suscipit inventore rerum \r\n',3,3,3,'2023-05-06',1),(10,'Casa Normal',450000.00,'4fefdaa8f7bae99a0cf5aab35e1634b1.jpg','Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum et ex, explicabo, recusandae possimus accusamus ab architecto reiciendis suscipit inventore rerum \r\n',3,3,3,'2023-05-06',2),(11,'Casa Aesthetic',500000.00,'6baffd5db1f899d1f8823ee4c6bf48f8.jpg','Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum et ex, explicabo, recusandae possimus accusamus ab architecto reiciendis suscipit inventore rerum \r\n',3,3,3,'2023-05-06',2),(22,'Hermosa casa en la playa',10000.00,'394dea992411ef90d2c6286b3bad83e3.jpg','Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum et ex, explicabo, recusandae possimus accusamus ab architecto reiciendis suscipit inventore rerum \r\n',2,2,5,'2023-05-10',2),(29,'Casa de la montaña',20000.00,'c4532ce997ff29ebc10e49c617a3464a.jpg','Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum et ex, explicabo, recusandae possimus accusamus ab architecto reiciendis suscipit inventore rerum \r\n',1,1,1,'2023-05-13',1),(31,'Departmento Preciose',77777.00,'92a97e804ba5825bee964b88e312b128.jpg','Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum et ex, explicabo, recusandae possimus accusamus ab architecto reiciendis suscipit inventore rerum \r\n',4,2,1,'2023-12-04',1);
/*!40000 ALTER TABLE `propiedades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(45) DEFAULT NULL,
  `password` char(60) DEFAULT NULL,
  `token` varchar(13) DEFAULT NULL,
  `esAdmin` tinyint DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'correo@correo.com','$2y$10$x4Co4gL.hJCcViVxtup7LOIa0D.gGrCJlO9.iAf691fLvoWRtW2uG','',1),(5,'usuario@correo.com','$2y$10$YdYQbEvBPU5Yr6/U8hILHODT4QMOyjQzc2Ke32YjhrLVXQJMawZf.','',0);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendedores`
--

DROP TABLE IF EXISTS `vendedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vendedores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendedores`
--

LOCK TABLES `vendedores` WRITE;
/*!40000 ALTER TABLE `vendedores` DISABLE KEYS */;
INSERT INTO `vendedores` VALUES (1,'Fernando','Joachin','9995683452'),(2,'Roberto','Castillo','9993459761'),(4,'Franco','Gonzalez','9998697542');
/*!40000 ALTER TABLE `vendedores` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-03 20:32:04
