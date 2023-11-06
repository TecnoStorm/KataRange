-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: cuk
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.28-MariaDB

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
-- Table structure for table `compite`
--

DROP TABLE IF EXISTS `compite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compite` (
  `ciP` int(11) NOT NULL,
  `idTorneo` int(11) NOT NULL,
  `puesto` enum('1ro','2do','3ro','Descalificado') DEFAULT NULL,
  `cinturon` enum('Aka','Ao') DEFAULT NULL,
  PRIMARY KEY (`ciP`,`idTorneo`),
  KEY `idTorneo` (`idTorneo`),
  CONSTRAINT `compite_ibfk_1` FOREIGN KEY (`ciP`) REFERENCES `participante` (`ciP`),
  CONSTRAINT `compite_ibfk_2` FOREIGN KEY (`idTorneo`) REFERENCES `torneo` (`idTorneo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compite`
--

LOCK TABLES `compite` WRITE;
/*!40000 ALTER TABLE `compite` DISABLE KEYS */;
INSERT INTO `compite` VALUES (1,9,'','Aka'),(1,13,'','Aka'),(2,9,'','Aka'),(2,20,'','Aka'),(2,27,'','Aka'),(3,9,'','Aka'),(3,20,'','Aka'),(4,9,'','Ao'),(5,9,NULL,'Ao'),(5,27,'','Ao'),(6,9,NULL,'Aka'),(6,27,NULL,'Aka'),(7,9,NULL,'Ao'),(8,9,NULL,'Aka'),(9,9,NULL,'Aka'),(10,9,NULL,'Ao'),(11,9,NULL,'Ao'),(12,9,NULL,'Aka'),(13,9,NULL,'Ao'),(14,9,NULL,'Ao'),(15,9,NULL,'Ao'),(16,9,NULL,'Aka'),(17,9,NULL,'Ao'),(18,9,NULL,'Aka'),(19,9,NULL,'Ao'),(20,9,NULL,'Ao'),(21,9,NULL,'Ao'),(22,9,NULL,'Ao'),(23,9,NULL,'Ao'),(24,9,NULL,'Ao'),(25,9,NULL,'Aka'),(26,9,NULL,'Aka'),(27,9,NULL,'Aka'),(28,9,NULL,'Aka'),(29,9,NULL,'Aka'),(30,9,NULL,'Aka'),(31,9,NULL,'Ao'),(32,9,NULL,'Ao'),(33,9,NULL,'Ao'),(34,9,NULL,'Ao'),(35,9,NULL,'Aka'),(36,9,NULL,'Ao'),(37,9,NULL,'Ao'),(38,9,NULL,'Aka'),(39,9,NULL,'Aka'),(40,9,NULL,'Aka'),(41,9,NULL,'Aka'),(42,9,NULL,'Ao'),(43,9,NULL,'Aka'),(44,9,NULL,'Aka'),(45,9,NULL,'Aka'),(46,9,NULL,'Aka'),(47,9,NULL,'Ao'),(48,9,NULL,'Ao'),(49,9,NULL,'Aka'),(50,9,NULL,'Aka'),(12344328,5,'',''),(54545454,27,'','Aka'),(54800352,13,'','Ao'),(54800353,13,'','Ao'),(54800354,13,'','Aka'),(55555555,13,'3ro','Aka');
/*!40000 ALTER TABLE `compite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contiene`
--

DROP TABLE IF EXISTS `contiene`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contiene` (
  `idEvento` int(11) NOT NULL,
  `idTorneo` int(11) NOT NULL,
  PRIMARY KEY (`idEvento`,`idTorneo`),
  KEY `idTorneo` (`idTorneo`),
  CONSTRAINT `contiene_ibfk_1` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`idEvento`),
  CONSTRAINT `contiene_ibfk_2` FOREIGN KEY (`idTorneo`) REFERENCES `torneo` (`idTorneo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contiene`
--

LOCK TABLES `contiene` WRITE;
/*!40000 ALTER TABLE `contiene` DISABLE KEYS */;
INSERT INTO `contiene` VALUES (1,26),(4,9),(4,13),(4,27);
/*!40000 ALTER TABLE `contiene` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `escuela`
--

DROP TABLE IF EXISTS `escuela`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `escuela` (
  `idEscuela` int(11) NOT NULL AUTO_INCREMENT,
  `Tecnica` varchar(30) DEFAULT NULL,
  `nombre_Escuela` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idEscuela`),
  UNIQUE KEY `nombre_Escuela` (`nombre_Escuela`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `escuela`
--

LOCK TABLES `escuela` WRITE;
/*!40000 ALTER TABLE `escuela` DISABLE KEYS */;
INSERT INTO `escuela` VALUES (1,'karate','escuela1'),(3,'karate','escuela4'),(4,'yumiko','escuela3'),(5,'yumiko','escuela5'),(6,'oden','escuela2'),(7,'Vista','PruebaModelo'),(9,'karate','NO ');
/*!40000 ALTER TABLE `escuela` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estan`
--

DROP TABLE IF EXISTS `estan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estan` (
  `ciP` int(11) NOT NULL,
  `idP` int(11) NOT NULL,
  `notaFinal` float DEFAULT NULL,
  `Clasificados` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`ciP`,`idP`),
  KEY `idP` (`idP`),
  CONSTRAINT `estan_ibfk_1` FOREIGN KEY (`ciP`) REFERENCES `participante` (`ciP`),
  CONSTRAINT `estan_ibfk_2` FOREIGN KEY (`idP`) REFERENCES `pool` (`idP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estan`
--

LOCK TABLES `estan` WRITE;
/*!40000 ALTER TABLE `estan` DISABLE KEYS */;
INSERT INTO `estan` VALUES (1,746,9,'null'),(2,776,NULL,NULL),(3,774,NULL,NULL),(4,773,NULL,NULL),(5,775,NULL,NULL),(6,774,NULL,NULL),(8,776,NULL,NULL),(12,776,NULL,NULL),(14,775,NULL,NULL),(15,773,NULL,NULL),(16,776,NULL,NULL),(17,775,NULL,NULL),(18,774,NULL,NULL),(19,773,NULL,NULL),(21,775,NULL,NULL),(22,775,NULL,NULL),(23,775,NULL,NULL),(24,773,NULL,NULL),(26,774,NULL,NULL),(27,776,NULL,NULL),(30,776,NULL,NULL),(33,773,NULL,NULL),(34,775,NULL,NULL),(35,774,NULL,NULL),(36,775,NULL,NULL),(37,773,NULL,NULL),(38,776,NULL,NULL),(39,774,NULL,NULL),(42,773,NULL,NULL),(44,774,NULL,NULL),(46,776,NULL,NULL),(47,773,NULL,NULL),(50,774,NULL,NULL),(54800352,745,8.2,'null'),(54800353,746,0,'null'),(54800354,745,0,'null');
/*!40000 ALTER TABLE `estan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estudia`
--

DROP TABLE IF EXISTS `estudia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estudia` (
  `idEscuela` int(11) NOT NULL,
  `ciP` int(11) NOT NULL,
  PRIMARY KEY (`idEscuela`,`ciP`),
  KEY `ciP` (`ciP`),
  CONSTRAINT `estudia_ibfk_1` FOREIGN KEY (`idEscuela`) REFERENCES `escuela` (`idEscuela`),
  CONSTRAINT `estudia_ibfk_2` FOREIGN KEY (`ciP`) REFERENCES `participante` (`ciP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudia`
--

LOCK TABLES `estudia` WRITE;
/*!40000 ALTER TABLE `estudia` DISABLE KEYS */;
INSERT INTO `estudia` VALUES (1,1),(1,11),(1,12),(1,13),(1,14),(1,15),(1,16),(1,17),(1,18),(1,26),(1,27),(1,28),(1,29),(1,30),(1,31),(1,32),(1,33),(1,48),(1,49),(1,50),(1,12344328),(1,15151515),(1,54800324),(1,54800325),(1,54800326),(1,54800350),(1,54800351),(1,54800352),(1,54800353),(1,54800354),(1,55555555),(3,2),(3,3),(3,6),(3,19),(3,20),(3,21),(3,22),(3,23),(3,24),(3,25),(3,34),(3,35),(3,36),(3,37),(3,38),(3,39),(3,40),(3,41),(3,12345671),(3,21344214),(3,21344215),(3,36363636),(3,54545454),(4,5),(4,7),(4,8),(4,9),(4,10),(4,42),(4,43),(4,44),(4,45),(4,46),(4,47),(4,12345678),(4,54800323),(4,56756723),(4,65675786),(5,4),(6,54800323);
/*!40000 ALTER TABLE `estudia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evento`
--

DROP TABLE IF EXISTS `evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evento` (
  `nombreEvento` varchar(30) DEFAULT NULL,
  `idEvento` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idEvento`),
  UNIQUE KEY `nombreEvento` (`nombreEvento`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evento`
--

LOCK TABLES `evento` WRITE;
/*!40000 ALTER TABLE `evento` DISABLE KEYS */;
INSERT INTO `evento` VALUES ('PrimerEvento',1),('segundo evento',4),('sin evento',0);
/*!40000 ALTER TABLE `evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `ganadores`
--

DROP TABLE IF EXISTS `ganadores`;
/*!50001 DROP VIEW IF EXISTS `ganadores`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `ganadores` AS SELECT 
 1 AS `ciP`,
 1 AS `idTorneo`,
 1 AS `puesto`,
 1 AS `cinturon`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `juez`
--

DROP TABLE IF EXISTS `juez`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `juez` (
  `nombre` varchar(20) NOT NULL,
  `Apellido` varchar(20) NOT NULL,
  `usuario` varchar(40) DEFAULT NULL,
  `ciJ` int(11) NOT NULL,
  `contraseña` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ciJ`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `juez`
--

LOCK TABLES `juez` WRITE;
/*!40000 ALTER TABLE `juez` DISABLE KEYS */;
INSERT INTO `juez` VALUES ('Hernan','Moreno','Hernan',1,'6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b'),('pepito','Tecnico','pablo',2,'3'),('Brandon ','Calimares','Brandon',3,'ef2d127de37b942baad06145e54b0c619a1f22327b2ebbcfbec78f5564afe39d'),('Ezequiel','papa','nelson',555,'4'),('EMINEM','EL REAL ','TE JURO ',667,'1'),('Frozen','Elsa','Libre',777,'soy'),('Prueba','Juzga','anda',1234,'1'),('Hernancin','Calimares','Tortomano',7778,'12'),('oscar','Calimares','Oscar45',10000000,'354cbfc814262a7a81d343f7d6ebc4adfb4266e5081a78f6a19ff16802dce8b2'),('Hernan','Moreno','Brandon533',10000003,'06194b258a25e89660b4db90da51b77d8053164cc84c20e03252138b3d9e7c89'),('ayuda','Fernandez','HernanM',10000008,'2b3bb672b47ec1025fb6ad6a7343b5b56122137bb95b0ad318c73c6e52f79fed'),('pepito','Calimares','prueba3',11111111,'03ac674216f3e15c761e'),('pepito','tortomano','Juez91',12332167,'354cbfc814262a7a81d343f7d6ebc4adfb4266e5081a78f6a19ff16802dce8b2'),('Juez5','Moreno','Juez5',12345666,'1'),('Pepe','Hernandez','pHernandez',12345678,'6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b'),('Hernan','Moreno','ahora',22222222,'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3'),('ayuda','Lucia','porfa',23232323,'6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b'),('Hernan','Tecnico','OscarAyuda',33333333,'8527a891e224136950ff32ca212b45bc93f69fbb801c3b1ebedac52775f99e61'),('Giuliana','Moreno','posta2',34212222,'6b86b273ff34fce19d6b'),('oscar','LLanibelli','judge2',34433443,'86e50149658661312a9e0b35558d84f6c6d3da797f552a9657fe0558ca40cdef'),('Hernan','Calimares','Juez534',34554334,'354cbfc814262a7a81d343f7d6ebc4adfb4266e5081a78f6a19ff16802dce8b2'),('Enzo','Benson','Matoox',42488713,'123'),('Brandon ','tortomano','Juez535',45665434,'354cbfc814262a7a81d343f7d6ebc4adfb4266e5081a78f6a19ff16802dce8b2'),('Oscar','prueba','posta',54800323,'6b51d431df5d7f141cbe'),('ayuda','Fernandez','mohamed',56565656,'9dfed00982a596640ace66662bdeca9e4c9dcac0a6f14f6729db159cf35bf79a'),('pablo ','tortomano','juezPrueba6',65434567,'354cbfc814262a7a81d343f7d6ebc4adfb4266e5081a78f6a19ff16802dce8b2'),('pablo ','Lucia','pablo345',76876890,'354cbfc814262a7a81d343f7d6ebc4adfb4266e5081a78f6a19ff16802dce8b2'),('Hernan','Moreno','Marco',77777777,'3e78784344c1fe5602471582ade6469b68417e6e4bd451da51c41a618ec216d0'),('ayuda','tortomano','Juez90',78998765,'354cbfc814262a7a81d343f7d6ebc4adfb4266e5081a78f6a19ff16802dce8b2'),('pablo ','Lucia','pedro',99999999,'2702cb34ee041711b9df0c67a8d5c9de02110c80e3fc966ba8341456dbc9ef2b');
/*!40000 ALTER TABLE `juez` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `juzga`
--

DROP TABLE IF EXISTS `juzga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `juzga` (
  `ciJ` int(11) NOT NULL,
  `idTorneo` int(11) NOT NULL,
  PRIMARY KEY (`ciJ`,`idTorneo`),
  KEY `idTorneo` (`idTorneo`),
  CONSTRAINT `juzga_ibfk_1` FOREIGN KEY (`ciJ`) REFERENCES `juez` (`ciJ`),
  CONSTRAINT `juzga_ibfk_2` FOREIGN KEY (`idTorneo`) REFERENCES `torneo` (`idTorneo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `juzga`
--

LOCK TABLES `juzga` WRITE;
/*!40000 ALTER TABLE `juzga` DISABLE KEYS */;
INSERT INTO `juzga` VALUES (1,9),(3,13),(1234,9),(10000000,9),(10000003,13),(10000008,15),(11111111,9),(12332167,9),(12345666,20),(12345678,13),(22222222,9),(23232323,9),(33333333,9),(34212222,9),(34433443,9),(34554334,12),(45665434,13),(54800323,9),(56565656,9),(65434567,13),(76876890,13),(77777777,9),(78998765,13),(99999999,9);
/*!40000 ALTER TABLE `juzga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kata`
--

DROP TABLE IF EXISTS `kata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kata` (
  `idKata` int(11) NOT NULL,
  `nombre` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idKata`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kata`
--

LOCK TABLES `kata` WRITE;
/*!40000 ALTER TABLE `kata` DISABLE KEYS */;
INSERT INTO `kata` VALUES (0,'sin asignar'),(1,'Anan'),(2,'Anan Dai'),(3,'Ananko'),(4,'Aoyagi'),(5,'Bassai'),(6,'Bassai Dai'),(7,'Bassai Sho'),(8,'Chatanyara Kusanku'),(9,'Chibana No Kushanku'),(10,'Chinte'),(11,'Chinto'),(12,'Enpi'),(13,'Fukyugata Ichi'),(14,'Fukyugata Ni'),(15,'Gankaku'),(16,'Garyu'),(17,'Gekisai (Geksai) 1'),(18,'Gekisai (Geksai) 2'),(19,'Gojushiho'),(20,'Gojushiho Dai'),(21,'Gojushiho Sho'),(22,'Hakusho'),(23,'Hangetsu'),(24,'Haufa (Haffa)'),(25,'Heian Shodan'),(26,'Heian Nidan'),(27,'Heian Sandan'),(28,'Heian Yondan'),(29,'Heian Godan'),(30,'Heiku'),(31,'Ishimine Bassai'),(32,'Itosu Rohai Shodan'),(33,'Itosu Rohai Nidan'),(34,'Itosu Rohai Sandan'),(35,'Jiin'),(36,'Jion'),(37,'Jitte'),(38,'Juroku'),(39,'Kanchin'),(40,'Kanku Dai'),(41,'Kanku Sho'),(42,'Kanshu'),(43,'Kishimono No Kushank'),(44,'Kousoukun'),(45,'Kousoukun Dai'),(46,'Kousoukun Sho'),(47,'Kururunfa'),(48,'Kusanku'),(49,'Kyan No Chinto'),(50,'Kyan No Wanshu'),(51,'Matsukaze'),(52,'Matsumura Bassai'),(53,'Matsumura Rohai'),(54,'Meikyo'),(55,'Myojo'),(56,'Naifanchin Shodan'),(57,'Naifanchin Nidan'),(58,'Naifanchin Sandan'),(59,'Naihanchi'),(60,'Nijushiho'),(61,'Nipaipo'),(62,'Niseishi'),(63,'Ohan'),(64,'Ohan Dai'),(65,'Oyadomari No Passai'),(66,'Pachu'),(67,'Paiku'),(68,'Papuren'),(69,'Passai'),(70,'Pinan Shodan'),(71,'Pinan Nidan'),(72,'Pinan Sandan'),(73,'Pinan Yondan'),(74,'Pinan Godan'),(75,'Rohai'),(76,'Saifa'),(77,'Sanchin'),(78,'Sansai'),(79,'Sanseiru'),(80,'Sanseru'),(81,'Seichin'),(82,'Seienchin (Seiyunchi'),(83,'Seipai'),(84,'Seiryu'),(85,'Seishan'),(86,'Seisan (Sesan)'),(87,'Shiho Kousoukun'),(88,'Shinpa'),(89,'Shinsei'),(90,'Shisochin'),(91,'Sochin'),(92,'Suparinpei'),(93,'Tekki Shodan'),(94,'Tekki Nidan'),(95,'Tekki Sandan'),(96,'Tensho'),(97,'Tomari Bassai'),(98,'Unshu'),(99,'Unsu'),(100,'Useishi'),(101,'Wankan'),(102,'Wanshu');
/*!40000 ALTER TABLE `kata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participante`
--

DROP TABLE IF EXISTS `participante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `participante` (
  `nombreP` varchar(20) NOT NULL,
  `apellidoP` varchar(20) NOT NULL,
  `ciP` int(11) NOT NULL,
  `sexo` enum('Masculino','Femenino') NOT NULL,
  `condicion` enum('Ninguna','K21','k22','K10','K30','K11','K12','K23','K20','K40') DEFAULT NULL,
  `categoriaP` enum('12/13','14/15','16/17','mayores') DEFAULT NULL,
  PRIMARY KEY (`ciP`),
  CONSTRAINT `participante_ibfk_1` FOREIGN KEY (`ciP`) REFERENCES `persona` (`ci`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participante`
--

LOCK TABLES `participante` WRITE;
/*!40000 ALTER TABLE `participante` DISABLE KEYS */;
INSERT INTO `participante` VALUES ('Juan','González',1,'Masculino','K21','mayores'),('María','López',2,'Masculino','K10','mayores'),('Carlos','Martínez',3,'Masculino','K11','mayores'),('Ana','Pérez',4,'Masculino','K40','mayores'),('Luis','Rodríguez',5,'Masculino','k22','14/15'),('Laura','Gómez',6,'Masculino','K30','mayores'),('Pedro','Sánchez',7,'Masculino','K12','mayores'),('Sofía','Torres',8,'Masculino','K20','mayores'),('Miguel','Fernández',9,'Masculino','K21','mayores'),('Isabel','Díaz',10,'Masculino','K10','mayores'),('Pablo','Ramírez',11,'Masculino','K11','mayores'),('Carmen','García',12,'Masculino','K40','mayores'),('Alejandro','López',13,'Masculino','k22','mayores'),('Elena','Martínez',14,'Masculino','K30','mayores'),('Javier','Pérez',15,'Masculino','K12','mayores'),('Raquel','González',16,'Masculino','K20','mayores'),('Diego','Sánchez',17,'Masculino','K21','mayores'),('Paula','Torres',18,'Masculino','K10','mayores'),('Roberto','Fernández',19,'Masculino','K11','mayores'),('Valentina','Díaz',20,'Masculino','K40','mayores'),('Andrés','Ramírez',21,'Masculino','k22','mayores'),('Lucía','García',22,'Masculino','K30','mayores'),('Martín','López',23,'Masculino','K12','mayores'),('Sara','Martínez',24,'Masculino','K20','mayores'),('Fernando','Pérez',25,'Masculino','K21','mayores'),('Mónica','González',26,'Masculino','K10','mayores'),('Daniel','Sánchez',27,'Masculino','K11','mayores'),('Adriana','Fernández',28,'Masculino','K40','mayores'),('Hugo','Díaz',29,'Masculino','k22','mayores'),('Camila','Ramírez',30,'Masculino','K30','mayores'),('Joaquín','García',31,'Masculino','K12','mayores'),('Natalia','López',32,'Masculino','K20','mayores'),('Eduardo','Martínez',33,'Masculino','K21','mayores'),('Alicia','Pérez',34,'Masculino','K10','mayores'),('Gustavo','González',35,'Masculino','K11','mayores'),('Silvia','Sánchez',36,'Masculino','K40','mayores'),('Ricardo','Fernández',37,'Masculino','k22','mayores'),('Inés','Díaz',38,'Masculino','K30','mayores'),('Antonio','Ramírez',39,'Masculino','K12','mayores'),('Beatriz','García',40,'Masculino','K20','mayores'),('Roberto','López',41,'Masculino','K21','mayores'),('Juan','Pérez',42,'Masculino','K10','mayores'),('Carlos','Gómez',43,'Masculino','K11','mayores'),('Luis','Rodríguez',44,'Masculino','K40','mayores'),('Miguel','Sánchez',45,'Masculino','k22','mayores'),('Pablo','González',46,'Masculino','K30','mayores'),('Alejandro','Martínez',47,'Masculino','K12','mayores'),('Javier','Fernández',48,'Masculino','K20','mayores'),('Diego','Gómez',49,'Masculino','K21','mayores'),('Roberto','Ramírez',50,'Masculino','k22','mayores'),('123','123',12344328,'Masculino','K11','mayores'),('prueba2','dos',12345671,'Femenino','Ninguna','mayores'),('prueba3','tres',12345672,'Femenino','Ninguna','mayores'),('prueba','uno',12345678,'Femenino','Ninguna','mayores'),('pablo ','Fernandez',15151515,'Masculino','K21','mayores'),('Brandon ','Tecnico',21344213,'Femenino','Ninguna','mayores'),('Brandon2','Tecnico',21344214,'Femenino','Ninguna','mayores'),('Brandon3','Tecnico',21344215,'Femenino','Ninguna','mayores'),('Hernan','Moreno',36363636,'Masculino','K12','mayores'),('Hernan','Moreno',44444444,'Femenino','Ninguna','mayores'),('ayuda','Lucia',54545454,'Femenino','K10','14/15'),('Hernan','Moreno',54800323,'Femenino','Ninguna','mayores'),('Giuliana','tortomano',54800324,'Femenino','Ninguna','mayores'),('pablo ','Perez',54800325,'Femenino','Ninguna','mayores'),('Ana','Matias',54800326,'Femenino','Ninguna','mayores'),('Prueba5','te juro4',54800350,'Femenino','Ninguna','mayores'),('Prueba6','te juro5',54800351,'Femenino','Ninguna','mayores'),('Prueba7','te juro6',54800352,'Femenino','Ninguna','mayores'),('Prueba8','te juro7',54800353,'Femenino','Ninguna','mayores'),('Prueba9','te juro8',54800354,'Femenino','Ninguna','mayores'),('ayuda2','Moreno',55555555,'Femenino','Ninguna','mayores'),('Brandon ','Calimares',56756723,'Masculino','K21','mayores'),('PruebaFunca','funcion',65675786,'Masculino','K20','mayores');
/*!40000 ALTER TABLE `participante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persona`
--

DROP TABLE IF EXISTS `persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `persona` (
  `ci` int(11) NOT NULL,
  `nombre` varchar(20) DEFAULT NULL,
  `apellido` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ci`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
INSERT INTO `persona` VALUES (1,'Juan','González'),(2,'María','López'),(3,'Carlos','Martínez'),(4,'Ana','Pérez'),(5,'Luis','Rodríguez'),(6,'Laura','Gómez'),(7,'Pedro','Sánchez'),(8,'Sofía','Torres'),(9,'Miguel','Fernández'),(10,'Isabel','Díaz'),(11,'Pablo','Ramírez'),(12,'Carmen','García'),(13,'Alejandro','López'),(14,'Elena','Martínez'),(15,'Javier','Pérez'),(16,'Raquel','González'),(17,'Diego','Sánchez'),(18,'Paula','Torres'),(19,'Roberto','Fernández'),(20,'Valentina','Díaz'),(21,'Andrés','Ramírez'),(22,'Lucía','García'),(23,'Martín','López'),(24,'Sara','Martínez'),(25,'Fernando','Pérez'),(26,'Mónica','González'),(27,'Daniel','Sánchez'),(28,'Adriana','Fernández'),(29,'Hugo','Díaz'),(30,'Camila','Ramírez'),(31,'Joaquín','García'),(32,'Natalia','López'),(33,'Eduardo','Martínez'),(34,'Alicia','Pérez'),(35,'Gustavo','González'),(36,'Silvia','Sánchez'),(37,'Ricardo','Fernández'),(38,'Inés','Díaz'),(39,'Antonio','Ramírez'),(40,'Beatriz','García'),(41,'Roberto','López'),(42,'Juan','Pérez'),(43,'Carlos','Gómez'),(44,'Luis','Rodríguez'),(45,'Miguel','Sánchez'),(46,'Pablo','González'),(47,'Alejandro','Martínez'),(48,'Javier','Fernández'),(49,'Diego','Gómez'),(50,'Roberto','Ramírez'),(10000000,'oscar','Calimares'),(10000003,'Hernan','Moreno'),(10000008,'ayuda','Fernandez'),(11111111,'pepito','Calimares'),(12332167,'pepito','tortomano'),(12344328,'123','123'),(12345666,'Juez5','Fernandez'),(12345671,'prueba2','dos'),(12345672,'prueba3','tres'),(12345678,'prueba','uno'),(15151515,'pablo ','Fernandez'),(21344213,'Brandon ','Tecnico'),(21344214,'Brandon ','Tecnico'),(21344215,'Brandon ','Tecnico'),(22222222,'Hernan','Moreno'),(23232323,'ayuda','Lucia'),(33333333,'Hernan','Tecnico'),(34212222,'Giuliana','Moreno'),(34433443,'oscar','LLanibelli'),(34554334,'Hernan','Calimares'),(36363636,'Hernan','Moreno'),(44444444,'Hernan','Moreno'),(45665434,'Brandon ','tortomano'),(54545454,'ayuda','Lucia'),(54800323,'Hernan','Moreno'),(54800324,'Giuliana','tortomano'),(54800325,'pablo ','Perez'),(54800326,'Ana','Matias'),(54800350,'Prueba5','te juro4'),(54800351,'Prueba6','te juro5'),(54800352,'Prueba7','te juro6'),(54800353,'Prueba8','te juro7'),(54800354,'Prueba9','te juro8'),(55555555,'ayuda2','Moreno'),(56565656,'ayuda','Fernandez'),(56756723,'Brandon ','Calimares'),(65434567,'pablo ','tortomano'),(65675786,'PruebaFunca','funcion'),(76876890,'pablo ','Lucia'),(77777777,'Hernan','Moreno'),(78998765,'ayuda','tortomano'),(99999999,'pablo ','Lucia');
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pool`
--

DROP TABLE IF EXISTS `pool`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pool` (
  `estado` enum('abierto','cerrado') DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `idP` int(11) NOT NULL AUTO_INCREMENT,
  `hora_final` time DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  PRIMARY KEY (`idP`)
) ENGINE=InnoDB AUTO_INCREMENT=784 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pool`
--

LOCK TABLES `pool` WRITE;
/*!40000 ALTER TABLE `pool` DISABLE KEYS */;
INSERT INTO `pool` VALUES ('cerrado','00:00:00',736,'00:00:00',1),('cerrado','00:00:00',737,'00:00:00',2),('cerrado','00:00:00',738,'00:00:00',3),('cerrado','00:00:00',739,'00:00:00',4),('cerrado','00:00:00',744,'00:00:00',1),('cerrado','00:00:00',745,'00:00:00',2),('cerrado','00:00:00',746,'00:00:00',3),('cerrado','00:00:00',765,'00:00:00',1),('cerrado','00:00:00',766,'00:00:00',2),('cerrado','00:00:00',767,'00:00:00',3),('cerrado','00:00:00',768,'00:00:00',4),('cerrado','00:00:00',769,'00:00:00',5),('cerrado','00:00:00',770,'00:00:00',6),('cerrado','00:00:00',771,'00:00:00',7),('cerrado','00:00:00',772,'00:00:00',8),('cerrado','00:00:00',773,'00:00:00',9),('cerrado','00:00:00',774,'00:00:00',10),('cerrado','00:00:00',775,'00:00:00',11),('cerrado','00:00:00',776,'00:00:00',12),('cerrado','00:00:00',777,'00:00:00',13),('cerrado','00:00:00',778,'00:00:00',14),('cerrado','00:00:00',779,'00:00:00',15),('cerrado','00:00:00',780,'00:00:00',16),('cerrado','00:00:00',781,'00:00:00',17),('cerrado','00:00:00',782,'00:00:00',18),('cerrado','00:00:00',783,'00:00:00',19);
/*!40000 ALTER TABLE `pool` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `puntua`
--

DROP TABLE IF EXISTS `puntua`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `puntua` (
  `ciJ` int(11) NOT NULL,
  `ciP` int(11) NOT NULL,
  `idP` int(11) NOT NULL,
  `Nota_Final` float DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  PRIMARY KEY (`ciJ`,`ciP`,`idP`),
  KEY `ciP` (`ciP`),
  KEY `idP` (`idP`),
  CONSTRAINT `puntua_ibfk_1` FOREIGN KEY (`ciJ`) REFERENCES `juez` (`ciJ`),
  CONSTRAINT `puntua_ibfk_2` FOREIGN KEY (`ciP`) REFERENCES `participante` (`ciP`),
  CONSTRAINT `puntua_ibfk_3` FOREIGN KEY (`idP`) REFERENCES `pool` (`idP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `puntua`
--

LOCK TABLES `puntua` WRITE;
/*!40000 ALTER TABLE `puntua` DISABLE KEYS */;
INSERT INTO `puntua` VALUES (12345678,55555555,745,6,'2023-11-05','16:27:16');
/*!40000 ALTER TABLE `puntua` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tecnico`
--

DROP TABLE IF EXISTS `tecnico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tecnico` (
  `nombreTecnico` varchar(30) DEFAULT NULL,
  `apellido` varchar(30) DEFAULT NULL,
  `ciT` int(11) NOT NULL,
  `usuario` varchar(30) DEFAULT NULL,
  `contraseña` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ciT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tecnico`
--

LOCK TABLES `tecnico` WRITE;
/*!40000 ALTER TABLE `tecnico` DISABLE KEYS */;
INSERT INTO `tecnico` VALUES ('Hernan','Moreno',54800323,'HernanM','b221d9dbb083a7f33428d7c2a3c3198ae925614d70210e28716ccaa7cd4ddb79'),('Hernan','Moreno',54800324,'1','hola'),('Hernan','Moreno',54800325,'2','hola');
/*!40000 ALTER TABLE `tecnico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tiene`
--

DROP TABLE IF EXISTS `tiene`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tiene` (
  `idP` int(11) NOT NULL,
  `idT` int(11) NOT NULL,
  PRIMARY KEY (`idP`,`idT`),
  KEY `idT` (`idT`),
  CONSTRAINT `tiene_ibfk_1` FOREIGN KEY (`idP`) REFERENCES `pool` (`idP`),
  CONSTRAINT `tiene_ibfk_2` FOREIGN KEY (`idT`) REFERENCES `torneo` (`idTorneo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tiene`
--

LOCK TABLES `tiene` WRITE;
/*!40000 ALTER TABLE `tiene` DISABLE KEYS */;
INSERT INTO `tiene` VALUES (744,13),(745,13),(746,13),(765,9),(766,9),(767,9),(768,9),(769,9),(770,9),(771,9),(772,9),(773,9),(774,9),(775,9),(776,9),(777,9),(778,9),(779,9),(780,9),(781,9),(782,9),(783,9);
/*!40000 ALTER TABLE `tiene` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `torneo`
--

DROP TABLE IF EXISTS `torneo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `torneo` (
  `idTorneo` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `Categoria` enum('12/13','14/15','16/17','mayores') DEFAULT NULL,
  `cantParticipantes` int(11) DEFAULT NULL,
  `estado` enum('abierto','cerrado') DEFAULT NULL,
  `ParaKarate` enum('si','no') DEFAULT NULL,
  `sexo` enum('Masculino','Femenino') DEFAULT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `direccion` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idTorneo`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `torneo`
--

LOCK TABLES `torneo` WRITE;
/*!40000 ALTER TABLE `torneo` DISABLE KEYS */;
INSERT INTO `torneo` VALUES (5,'2023-09-01','mayores',6,'cerrado','si','Masculino','cambio2',NULL),(6,'1970-01-01','12/13',5,'cerrado','no','Femenino',NULL,NULL),(7,'2023-09-10','12/13',9,'abierto','si','Femenino',NULL,NULL),(8,'2023-08-26','mayores',17,'abierto','si','Masculino',NULL,NULL),(9,'2023-08-27','mayores',85,'cerrado','si','Masculino','cambio',NULL),(10,'2023-08-30','16/17',22,'cerrado','no','',NULL,NULL),(11,'2023-08-31','16/17',22,'cerrado','no','',NULL,NULL),(12,'2023-08-31','mayores',33,'abierto','no','Masculino','Hernan','ayuda'),(13,'2023-10-12','mayores',33,'cerrado','no','Femenino','Tortomano','ayuda'),(14,'2023-09-28','mayores',45,'cerrado','si','Femenino','git no ','ayuda'),(15,'2023-09-28','mayores',44,'cerrado','si','Masculino','Tortomano2','ayuda'),(16,'2023-09-27','mayores',23,'cerrado','si','Masculino','prueba','fetch'),(17,'2023-09-29','',44,'cerrado','no','Masculino','pepito',''),(20,'2023-10-13','mayores',3,'abierto','si','Masculino','torneo3','ayuda'),(21,'2023-10-26','16/17',45,'cerrado','si','Masculino','pruebaContiene','ayuda'),(22,'2023-10-12','16/17',23,'cerrado','si','Femenino','HernanContiene','ayuda'),(24,'2023-10-19','16/17',23,'cerrado','si','Masculino','oscarContiene','ayuda'),(25,'2023-10-19','16/17',23,'cerrado','si','Femenino','pablo ','ayuda'),(26,'2023-10-26','mayores',76,'cerrado','no','Femenino','Hernan123123','ayuda'),(27,'2023-10-13','14/15',87,'cerrado','si','Femenino','pablo pj','54');
/*!40000 ALTER TABLE `torneo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utiliza2`
--

DROP TABLE IF EXISTS `utiliza2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utiliza2` (
  `ciP` int(11) NOT NULL,
  `idkata` int(11) DEFAULT NULL,
  `ronda` int(11) DEFAULT NULL,
  `idP` int(11) NOT NULL,
  `NotaFinal` float DEFAULT NULL,
  PRIMARY KEY (`ciP`,`idP`),
  KEY `idP` (`idP`),
  CONSTRAINT `utiliza2_ibfk_1` FOREIGN KEY (`ciP`) REFERENCES `participante` (`ciP`),
  CONSTRAINT `utiliza2_ibfk_2` FOREIGN KEY (`idP`) REFERENCES `pool` (`idP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utiliza2`
--

LOCK TABLES `utiliza2` WRITE;
/*!40000 ALTER TABLE `utiliza2` DISABLE KEYS */;
INSERT INTO `utiliza2` VALUES (1,1,1,745,NULL),(1,0,2,746,NULL),(54800352,1,1,745,NULL),(54800353,1,1,744,NULL),(54800353,0,2,746,NULL),(54800354,1,1,744,NULL),(54800354,0,2,745,NULL),(55555555,1,1,744,NULL);
/*!40000 ALTER TABLE `utiliza2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `ganadores`
--

/*!50001 DROP VIEW IF EXISTS `ganadores`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ganadores` AS select `compite`.`ciP` AS `ciP`,`compite`.`idTorneo` AS `idTorneo`,`compite`.`puesto` AS `puesto`,`compite`.`cinturon` AS `cinturon` from (`compite` join `torneo` on(`compite`.`idTorneo` = `torneo`.`idTorneo`)) where `compite`.`puesto` = '1ro' and year(`torneo`.`fecha`) = year(curdate()) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-05 19:43:57
