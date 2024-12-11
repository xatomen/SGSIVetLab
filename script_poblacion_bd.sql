-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: sgsi_vetlab
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Dumping data for table `administrador`
--

LOCK TABLES `administrador` WRITE;
/*!40000 ALTER TABLE `administrador` DISABLE KEYS */;
INSERT INTO `administrador` VALUES (1,'Jorge Gallardo',1);
/*!40000 ALTER TABLE `administrador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `area`
--

LOCK TABLES `area` WRITE;
/*!40000 ALTER TABLE `area` DISABLE KEYS */;
INSERT INTO `area` VALUES (1,'HEMATO'),(2,'COAGULACION'),(3,'SEROLOGIA'),(4,'ORINAS'),(5,'MATERIALES'),(6,'QUIM'),(7,'ELECTROLITOS'),(8,'HORM'),(9,'MICRO'),(10,'COPRO'),(11,'DERIVADOS'),(12,'GENETICA'),(13,'OTROS'),(14,'MUES');
/*!40000 ALTER TABLE `area` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `componentes_perfil_muestra`
--

LOCK TABLES `componentes_perfil_muestra` WRITE;
/*!40000 ALTER TABLE `componentes_perfil_muestra` DISABLE KEYS */;
INSERT INTO `componentes_perfil_muestra` VALUES (1,3,1,3),(2,1,1,4);
/*!40000 ALTER TABLE `componentes_perfil_muestra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `credenciales`
--

LOCK TABLES `credenciales` WRITE;
/*!40000 ALTER TABLE `credenciales` DISABLE KEYS */;
INSERT INTO `credenciales` VALUES (1,'Jorge','123','Administrador'),(2,'Pedro','123','Usuario'),(3,'Juan','123','Usuario');
/*!40000 ALTER TABLE `credenciales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `empleado`
--

LOCK TABLES `empleado` WRITE;
/*!40000 ALTER TABLE `empleado` DISABLE KEYS */;
INSERT INTO `empleado` VALUES (1,'Pedro Alvarez',2,1),(2,'Juan Pérez',3,6);
/*!40000 ALTER TABLE `empleado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `insumo`
--

LOCK TABLES `insumo` WRITE;
/*!40000 ALTER TABLE `insumo` DISABLE KEYS */;
INSERT INTO `insumo` VALUES (1,'LISANTE',0,1,1),(2,'CONTROL HEMATOLOGIA',15,3,1),(3,'GLUCOSA',82,15,1),(4,'MICROALBIMINURIA',50,10,6),(5,'INSULINA',0,5,11),(6,'AGAR',0,30,9),(7,'TOXOPLASMA GONDII',0,30,12);
/*!40000 ALTER TABLE `insumo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `insumo_usado_empleado`
--

LOCK TABLES `insumo_usado_empleado` WRITE;
/*!40000 ALTER TABLE `insumo_usado_empleado` DISABLE KEYS */;
INSERT INTO `insumo_usado_empleado` VALUES (0,'VL000001',1,'2024-12-09',1,3),(1,'VL000002',1,'2024-12-09',2,4),(2,'VL000001',3,'2024-12-09',1,3),(3,'VL000001',5,'2024-12-10',1,3),(4,'VL000001',3,'2024-12-10',1,3);
/*!40000 ALTER TABLE `insumo_usado_empleado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `mantiene_empleado`
--

LOCK TABLES `mantiene_empleado` WRITE;
/*!40000 ALTER TABLE `mantiene_empleado` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantiene_empleado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `mantiene_insumo`
--

LOCK TABLES `mantiene_insumo` WRITE;
/*!40000 ALTER TABLE `mantiene_insumo` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantiene_insumo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `mantiene_perfil_muestra`
--

LOCK TABLES `mantiene_perfil_muestra` WRITE;
/*!40000 ALTER TABLE `mantiene_perfil_muestra` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantiene_perfil_muestra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `mantiene_provee`
--

LOCK TABLES `mantiene_provee` WRITE;
/*!40000 ALTER TABLE `mantiene_provee` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantiene_provee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `mantiene_proveedor`
--

LOCK TABLES `mantiene_proveedor` WRITE;
/*!40000 ALTER TABLE `mantiene_proveedor` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantiene_proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `orden_de_compra`
--

LOCK TABLES `orden_de_compra` WRITE;
/*!40000 ALTER TABLE `orden_de_compra` DISABLE KEYS */;
INSERT INTO `orden_de_compra` VALUES (1,'2024-12-09',1,1);
/*!40000 ALTER TABLE `orden_de_compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `perfil_muestra`
--

LOCK TABLES `perfil_muestra` WRITE;
/*!40000 ALTER TABLE `perfil_muestra` DISABLE KEYS */;
INSERT INTO `perfil_muestra` VALUES (1,'Hemograma',1);
/*!40000 ALTER TABLE `perfil_muestra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `provee`
--

LOCK TABLES `provee` WRITE;
/*!40000 ALTER TABLE `provee` DISABLE KEYS */;
INSERT INTO `provee` VALUES (1,'240-154',169675,'LISANTE M-30 (CLF LYSE)','500ML',0,1,1,1),(2,'BC-3DG',120660,'CONTROL HEMATOLOGIA 3DG','3 X 3 ML',15,1,1,2),(3,'300150',24342,'GLUCOSA','5x40 ML',72,1,1,3),(4,'300170',279024,'MICROALBIMINURIA','2x40ML/2X10ML',50,6,1,4),(5,'285-110',16165,'AGAR CROMO ORIENTATION','x 10',0,9,1,6),(6,'BFV005',159050,'DETECTION KIT','8 TEST',0,12,13,7),(7,'300160',34565,'Glucosa','10x40 ML',10,1,1,3);
/*!40000 ALTER TABLE `provee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
INSERT INTO `proveedor` VALUES (1,'76.092.658-2','Valtek S.A','-','-','-','Ñuñoa','Santiago','-'),(2,'-','FARMALATINA','-','-','-','-','-','-'),(3,'-','DATAMEDICA','-','-','-','-','-','-'),(4,'-','ANDES IMPORT','-','-','-','-','-','-'),(5,'-','GLASS LAB','-','-','-','-','-','-'),(6,'-','GALENICA','-','-','-','-','-','-'),(7,'-','CLINITEST','-','-','-','-','-','-'),(8,'-','EMARIN','-','-','-','-','-','-'),(9,'-','SRA PATY','-','-','-','-','-','-'),(10,'-','AGROVET','-','-','-','-','-','-'),(11,'-','INSUVETS','-','-','-','-','-','-'),(12,'-','BIOLINE','-','-','-','-','-','-'),(13,'-','BIODIAGNOSTIC','-','-','-','-','-','-'),(14,'-','VITASISTEM','-','-','-','-','-','-');
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `registro_insumo`
--

LOCK TABLES `registro_insumo` WRITE;
/*!40000 ALTER TABLE `registro_insumo` DISABLE KEYS */;
INSERT INTO `registro_insumo` VALUES (1,'VL000001','23512','2024-12-09','2024-12-16',30,12,1,3),(2,'VL000002','4537456','2024-12-09','2024-12-31',3,0,1,4),(3,'VL000003','1532421','2024-12-10','2025-01-12',50,50,1,4),(4,'VL000004','345346','2024-12-10','2025-01-31',15,15,1,2),(5,'VL000005','523145','2024-12-10','2025-04-19',10,10,1,7),(6,'VL000006','52346','2024-12-10','2024-12-13',10,10,1,3),(7,'VL000007','563246','2024-12-10','2025-03-29',50,50,1,3);
/*!40000 ALTER TABLE `registro_insumo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `registro_orden_de_compra`
--

LOCK TABLES `registro_orden_de_compra` WRITE;
/*!40000 ALTER TABLE `registro_orden_de_compra` DISABLE KEYS */;
INSERT INTO `registro_orden_de_compra` VALUES (1,10,24342,1,3),(2,5,120660,1,2);
/*!40000 ALTER TABLE `registro_orden_de_compra` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-10 23:05:34
