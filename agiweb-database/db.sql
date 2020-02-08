-- MySQL dump 10.16  Distrib 10.1.25-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: agiweb
-- ------------------------------------------------------
-- Server version	10.1.25-MariaDB

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
-- Table structure for table `allowed_ips`
--

DROP TABLE IF EXISTS `allowed_ips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `allowed_ips` (
  `ip_address` varchar(15) NOT NULL,
  `active` enum('0','1') DEFAULT '1',
  PRIMARY KEY (`ip_address`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `allowed_ips`
--

LOCK TABLES `allowed_ips` WRITE;
/*!40000 ALTER TABLE `allowed_ips` DISABLE KEYS */;
INSERT INTO `allowed_ips` VALUES ('192.168.1.12','1'),('127.0.0.1','1');
/*!40000 ALTER TABLE `allowed_ips` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `campaigns`
--

DROP TABLE IF EXISTS `campaigns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campaigns` (
  `campaign_id` varchar(5) NOT NULL,
  `campaign_name` varchar(255) DEFAULT NULL,
  `caller_id` varchar(255) DEFAULT NULL,
  `call_record` enum('0','1') DEFAULT '1',
  `rec_path` varchar(255) DEFAULT '/var/spool/asterisk/monitorDONE/GSM/',
  `dnc_check_federal` enum('1','0') DEFAULT '1',
  `dnc_check_custom` enum('1','0') DEFAULT '1',
  `dnc_groups` varchar(255) DEFAULT NULL,
  `notes` text,
  `active` enum('1','0') DEFAULT '0',
  PRIMARY KEY (`campaign_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campaigns`
--

LOCK TABLES `campaigns` WRITE;
/*!40000 ALTER TABLE `campaigns` DISABLE KEYS */;
INSERT INTO `campaigns` VALUES ('97','97-HANGUP','0000000000','0','/var/spool/asterisk/monitorDONE/GSM/','0','0','ALL','Remote Hangup',''),('99','99-SPY','0000000000','0','/var/spool/asterisk/monitorDONE/GSM/','0','0','ALL','','1'),('98','98-BARGE','0000000000','0','/var/spool/asterisk/monitorDONE/GSM/','0','0','ALL','',''),('5522','5522','0000000000','0','/var/spool/asterisk/monitorDONE/GSM/','0','0','ALL',NULL,'1');
/*!40000 ALTER TABLE `campaigns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `layout_grid`
--

DROP TABLE IF EXISTS `layout_grid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `layout_grid` (
  `layout_id` varchar(5) NOT NULL,
  `item_id` varchar(5) DEFAULT NULL,
  `row` varchar(3) DEFAULT NULL,
  `col` varchar(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `layout_grid`
--

LOCK TABLES `layout_grid` WRITE;
/*!40000 ALTER TABLE `layout_grid` DISABLE KEYS */;
INSERT INTO `layout_grid` VALUES ('10000','','15','15'),('10000','','15','14'),('10000','','15','13'),('10000','','15','12'),('10000','','15','11'),('10000','','15','10'),('10000','','15','9'),('10000','','15','8'),('10000','','15','7'),('10000','','15','6'),('10000','','15','5'),('10000','','15','4'),('10000','','15','3'),('10000','','15','2'),('10000','','15','1'),('10000','','14','15'),('10000','','14','14'),('10000','','14','13'),('10000','','14','12'),('10000','','14','11'),('10000','','14','10'),('10000','','14','9'),('10000','','14','8'),('10000','','14','7'),('10000','','14','6'),('10000','','14','5'),('10000','','14','4'),('10000','','14','3'),('10000','','14','2'),('10000','','14','1'),('10000','','13','15'),('10000','','13','14'),('10000','','13','13'),('10000','','13','12'),('10000','','13','11'),('10000','','13','10'),('10000','','13','9'),('10000','','13','8'),('10000','','13','7'),('10000','','13','6'),('10000','','13','5'),('10000','','13','4'),('10000','','13','3'),('10000','','13','2'),('10000','','13','1'),('10000','','12','15'),('10000','','12','14'),('10000','','12','13'),('10000','','12','12'),('10000','','12','11'),('10000','','12','10'),('10000','','12','9'),('10000','','12','8'),('10000','','12','7'),('10000','','12','6'),('10000','','12','5'),('10000','','12','4'),('10000','','12','3'),('10000','','12','2'),('10000','','12','1'),('10000','','11','15'),('10000','','11','14'),('10000','','11','13'),('10000','','11','12'),('10000','','11','11'),('10000','','11','10'),('10000','','11','9'),('10000','','11','8'),('10000','','11','7'),('10000','','11','6'),('10000','','11','5'),('10000','','11','4'),('10000','','11','3'),('10000','','11','2'),('10000','','11','1'),('10000','','10','15'),('10000','','10','14'),('10000','','10','13'),('10000','','10','12'),('10000','','10','11'),('10000','','10','10'),('10000','','10','9'),('10000','','10','8'),('10000','','10','7'),('10000','','10','6'),('10000','','10','5'),('10000','','10','4'),('10000','','10','3'),('10000','','10','2'),('10000','','10','1'),('10000','','9','15'),('10000','','9','14'),('10000','','9','13'),('10000','','9','12'),('10000','','9','11'),('10000','','9','10'),('10000','','9','9'),('10000','','9','8'),('10000','','9','7'),('10000','','9','6'),('10000','','9','5'),('10000','','9','4'),('10000','','9','3'),('10000','','9','2'),('10000','','9','1'),('10000','','8','15'),('10000','','8','14'),('10000','','8','13'),('10000','','8','12'),('10000','','8','11'),('10000','','8','10'),('10000','','8','9'),('10000','','8','8'),('10000','','8','7'),('10000','','8','6'),('10000','','8','5'),('10000','','8','4'),('10000','','8','3'),('10000','','8','2'),('10000','','8','1'),('10000','','7','15'),('10000','','7','14'),('10000','','7','13'),('10000','','7','12'),('10000','','7','11'),('10000','','7','10'),('10000','','7','9'),('10000','','7','8'),('10000','','7','7'),('10000','','7','6'),('10000','','7','5'),('10000','','7','4'),('10000','','7','3'),('10000','','7','2'),('10000','','7','1'),('10000','','6','15'),('10000','','6','14'),('10000','','6','13'),('10000','','6','12'),('10000','','6','11'),('10000','','6','10'),('10000','','6','9'),('10000','','6','8'),('10000','','6','7'),('10000','','6','6'),('10000','','6','5'),('10000','','6','4'),('10000','','6','3'),('10000','','6','2'),('10000','','6','1'),('10000','','5','15'),('10000','','5','14'),('10000','','5','13'),('10000','','5','12'),('10000','','5','11'),('10000','','5','10'),('10000','','5','9'),('10000','','5','8'),('10000','','5','7'),('10000','','5','6'),('10000','','5','5'),('10000','','5','4'),('10000','','5','3'),('10000','','5','2'),('10000','','5','1'),('10000','','4','15'),('10000','','4','14'),('10000','','4','13'),('10000','','4','12'),('10000','','4','11'),('10000','','4','10'),('10000','','4','9'),('10000','','4','8'),('10000','','4','7'),('10000','','4','6'),('10000','','4','5'),('10000','','4','4'),('10000','','4','3'),('10000','','4','2'),('10000','','4','1'),('10000','','3','15'),('10000','','3','14'),('10000','','3','13'),('10000','','3','12'),('10000','','3','11'),('10000','','3','10'),('10000','','3','9'),('10000','','3','8'),('10000','','3','7'),('10000','','3','6'),('10000','','3','5'),('10000','','3','4'),('10000','','3','3'),('10000','','3','2'),('10000','','3','1'),('10000','','2','15'),('10000','','2','14'),('10000','','2','13'),('10000','','2','12'),('10000','','2','11'),('10000','','2','10'),('10000','','2','9'),('10000','','2','8'),('10000','','2','7'),('10000','','2','6'),('10000','','2','5'),('10000','','2','4'),('10000','','2','3'),('10000','','2','2'),('10000','','2','1'),('10000','','1','15'),('10000','','1','14'),('10000','','1','13'),('10000','','1','12'),('10000','','1','11'),('10000','','1','10'),('10000','','1','9'),('10000','','1','8'),('10000','','1','7'),('10000','','1','6'),('10000','','1','5'),('10000','','1','4'),('10000','','1','3'),('10000','','1','2'),('10000','','1','1'),('10002','5014','9','6'),('10002','5013','9','5'),('10002','5012','9','4'),('10002','5011','9','3'),('10002','4900','9','2'),('10002','4900','9','1'),('10002','4900','8','6'),('10002','4900','8','5'),('10002','4900','8','4'),('10002','4900','8','3'),('10001','','15','15'),('10001','','15','14'),('10001','','15','13'),('10001','','15','12'),('10001','','15','11'),('10001','','15','10'),('10001','','15','9'),('10001','','15','8'),('10001','','15','7'),('10001','','15','6'),('10001','','15','5'),('10001','','15','4'),('10001','','15','3'),('10001','','15','2'),('10001','','15','1'),('10001','','14','15'),('10001','','14','14'),('10001','','14','13'),('10001','','14','12'),('10001','','14','11'),('10001','','14','10'),('10001','','14','9'),('10001','','14','8'),('10001','','14','7'),('10001','','14','6'),('10001','','14','5'),('10001','','14','4'),('10001','','14','3'),('10001','','14','2'),('10001','','14','1'),('10001','','13','15'),('10001','','13','14'),('10001','','13','13'),('10001','','13','12'),('10001','','13','11'),('10001','','13','10'),('10001','','13','9'),('10001','','13','8'),('10001','','13','7'),('10001','','13','6'),('10001','','13','5'),('10001','','13','4'),('10001','','13','3'),('10001','','13','2'),('10001','','13','1'),('10001','','12','15'),('10001','','12','14'),('10001','','12','13'),('10001','','12','12'),('10001','','12','11'),('10001','','12','10'),('10001','','12','9'),('10001','','12','8'),('10001','','12','7'),('10001','','12','6'),('10001','','12','5'),('10001','','12','4'),('10001','','12','3'),('10001','','12','2'),('10001','','12','1'),('10001','','11','15'),('10001','','11','14'),('10001','','11','13'),('10001','','11','12'),('10001','','11','11'),('10001','','11','10'),('10001','','11','9'),('10001','','11','8'),('10001','','11','7'),('10001','','11','6'),('10001','','11','5'),('10001','','11','4'),('10001','','11','3'),('10001','','11','2'),('10001','','11','1'),('10001','','10','15'),('10001','','10','14'),('10001','','10','13'),('10001','','10','12'),('10001','','10','11'),('10001','','10','10'),('10001','','10','9'),('10001','','10','8'),('10001','','10','7'),('10001','','10','6'),('10001','','10','5'),('10001','','10','4'),('10001','','10','3'),('10001','','10','2'),('10001','','10','1'),('10001','','9','15'),('10001','','9','14'),('10001','','9','13'),('10001','','9','12'),('10001','','9','11'),('10001','','9','10'),('10001','','9','9'),('10001','','9','8'),('10001','','9','7'),('10001','','9','6'),('10001','','9','5'),('10001','','9','4'),('10001','','9','3'),('10001','','9','2'),('10001','','9','1'),('10001','','8','15'),('10001','','8','14'),('10001','','8','13'),('10001','','8','12'),('10001','5031','8','11'),('10001','5032','8','10'),('10001','5033','8','9'),('10001','','8','8'),('10001','','8','7'),('10001','5034','8','6'),('10001','5035','8','5'),('10001','5036','8','4'),('10001','','8','3'),('10001','','8','2'),('10001','','8','1'),('10001','','7','15'),('10001','','7','14'),('10001','','7','13'),('10001','','7','12'),('10001','','7','11'),('10001','','7','10'),('10001','','7','9'),('10001','','7','8'),('10001','','7','7'),('10001','','7','6'),('10001','','7','5'),('10001','','7','4'),('10001','','7','3'),('10001','','7','2'),('10001','','7','1'),('10001','','6','15'),('10001','','6','14'),('10001','','6','13'),('10001','','6','12'),('10001','','6','11'),('10001','','6','10'),('10001','','6','9'),('10001','','6','8'),('10001','','6','7'),('10001','','6','6'),('10001','','6','5'),('10001','','6','4'),('10001','','6','3'),('10001','','6','2'),('10001','','6','1'),('10001','','5','15'),('10001','','5','14'),('10001','','5','13'),('10001','','5','12'),('10001','5030','5','11'),('10001','5029','5','10'),('10001','5028','5','9'),('10001','5027','5','8'),('10001','','5','7'),('10001','5026','5','6'),('10001','5025','5','5'),('10001','5024','5','4'),('10001','5023','5','3'),('10001','5022','5','2'),('10001','5021','5','1'),('10001','','4','15'),('10001','','4','14'),('10001','','4','13'),('10001','','4','12'),('10001','5011','4','11'),('10001','5012','4','10'),('10001','5013','4','9'),('10001','5014','4','8'),('10001','','4','7'),('10001','5015','4','6'),('10001','5016','4','5'),('10001','5017','4','4'),('10001','5018','4','3'),('10001','5019','4','2'),('10001','5020','4','1'),('10001','','3','15'),('10001','','3','14'),('10001','','3','13'),('10001','','3','12'),('10001','','3','11'),('10001','','3','10'),('10001','','3','9'),('10001','','3','8'),('10001','','3','7'),('10001','','3','6'),('10001','','3','5'),('10001','','3','4'),('10001','','3','3'),('10001','','3','2'),('10001','','3','1'),('10001','','2','15'),('10001','','2','14'),('10001','','2','13'),('10001','','2','12'),('10001','','2','11'),('10001','','2','10'),('10001','','2','9'),('10001','','2','8'),('10001','','2','7'),('10001','','2','6'),('10001','','2','5'),('10001','','2','4'),('10001','','2','3'),('10001','','2','2'),('10001','','2','1'),('10001','','1','15'),('10001','','1','14'),('10001','','1','13'),('10001','','1','12'),('10001','5010','1','11'),('10001','5009','1','10'),('10001','5008','1','9'),('10001','5007','1','8'),('10001','','1','7'),('10001','5006','1','6'),('10001','5005','1','5'),('10001','5004','1','4'),('10001','5003','1','3'),('10001','5002','1','2'),('10001','5001','1','1'),('10002','4900','8','2'),('10002','4900','8','1'),('10002','5015','7','6'),('10002','5016','7','5'),('10002','5017','7','4'),('10002','5018','7','3'),('10002','4900','7','2'),('10002','4900','7','1'),('10002','5022','6','6'),('10002','5021','6','5'),('10002','5020','6','4'),('10002','5019','6','3'),('10002','4900','6','2'),('10002','4900','6','1'),('10002','4900','5','6'),('10002','4900','5','5'),('10002','4900','5','4'),('10002','4900','5','3'),('10002','4900','5','2'),('10002','4900','5','1'),('10002','5023','4','6'),('10002','5024','4','5'),('10002','5025','4','4'),('10002','5026','4','3'),('10002','4900','4','2'),('10002','4900','4','1'),('10002','4900','3','6'),('10002','4900','3','5'),('10002','4900','3','4'),('10002','4900','3','3'),('10002','4900','3','2'),('10002','4900','3','1'),('10002','4900','2','6'),('10002','4900','2','5'),('10002','4900','2','4'),('10002','4900','2','3'),('10002','4900','2','2'),('10002','4900','2','1'),('10002','4900','1','6'),('10002','4900','1','5'),('10002','4900','1','4'),('10002','4900','1','3'),('10002','4900','1','2'),('10002','4900','1','1'),('10003','4900','17','11'),('10003','4900','17','10'),('10003','4900','17','9'),('10003','5105','17','8'),('10003','5106','17','7'),('10003','5107','17','6'),('10003','5108','17','5'),('10003','4900','17','4'),('10003','4900','17','3'),('10003','5109','17','2'),('10003','5110','17','1'),('10003','4900','16','11'),('10003','4900','16','10'),('10003','4900','16','9'),('10003','4900','16','8'),('10003','4900','16','7'),('10003','4900','16','6'),('10003','4900','16','5'),('10003','4900','16','4'),('10003','4900','16','3'),('10003','4900','16','2'),('10003','4900','16','1'),('10003','4900','15','11'),('10003','4900','15','10'),('10003','4900','15','9'),('10003','4900','15','8'),('10003','4900','15','7'),('10003','4900','15','6'),('10003','4900','15','5'),('10003','4900','15','4'),('10003','4900','15','3'),('10003','4900','15','2'),('10003','4900','15','1'),('10003','4900','14','11'),('10003','4900','14','10'),('10003','4900','14','9'),('10003','5104','14','8'),('10003','5103','14','7'),('10003','5102','14','6'),('10003','5101','14','5'),('10003','5001','14','4'),('10003','5099','14','3'),('10003','5098','14','2'),('10003','5097','14','1'),('10003','4900','13','11'),('10003','4900','13','10'),('10003','4900','13','9'),('10003','5089','13','8'),('10003','5090','13','7'),('10003','5091','13','6'),('10003','5092','13','5'),('10003','5093','13','4'),('10003','5094','13','3'),('10003','5095','13','2'),('10003','5096','13','1'),('10003','4900','12','11'),('10003','4900','12','10'),('10003','4900','12','9'),('10003','4900','12','8'),('10003','4900','12','7'),('10003','4900','12','6'),('10003','4900','12','5'),('10003','4900','12','4'),('10003','4900','12','3'),('10003','4900','12','2'),('10003','4900','12','1'),('10003','4900','11','11'),('10003','4900','11','10'),('10003','4900','11','9'),('10003','4900','11','8'),('10003','4900','11','7'),('10003','4900','11','6'),('10003','4900','11','5'),('10003','4900','11','4'),('10003','4900','11','3'),('10003','4900','11','2'),('10003','4900','11','1'),('10003','4900','10','11'),('10003','4900','10','10'),('10003','4900','10','9'),('10003','5088','10','8'),('10003','5087','10','7'),('10003','5086','10','6'),('10003','5085','10','5'),('10003','5084','10','4'),('10003','5083','10','3'),('10003','5082','10','2'),('10003','5081','10','1'),('10003','4900','9','11'),('10003','4900','9','10'),('10003','4900','9','9'),('10003','5073','9','8'),('10003','5074','9','7'),('10003','5075','9','6'),('10003','5076','9','5'),('10003','5077','9','4'),('10003','5078','9','3'),('10003','5079','9','2'),('10003','5080','9','1'),('10003','4900','8','11'),('10003','4900','8','10'),('10003','4900','8','9'),('10003','4900','8','8'),('10003','4900','8','7'),('10003','4900','8','6'),('10003','4900','8','5'),('10003','4900','8','4'),('10003','4900','8','3'),('10003','4900','8','2'),('10003','4900','8','1'),('10003','4900','7','11'),('10003','4900','7','10'),('10003','4900','7','9'),('10003','4900','7','8'),('10003','4900','7','7'),('10003','4900','7','6'),('10003','4900','7','5'),('10003','4900','7','4'),('10003','4900','7','3'),('10003','4900','7','2'),('10003','4900','7','1'),('10003','5045','6','11'),('10003','4900','6','10'),('10003','4900','6','9'),('10003','5072','6','8'),('10003','5071','6','7'),('10003','5070','6','6'),('10003','5069','6','5'),('10003','5068','6','4'),('10003','5067','6','3'),('10003','5066','6','2'),('10003','5065','6','1'),('10003','5044','5','11'),('10003','4900','5','10'),('10003','4900','5','9'),('10003','5057','5','8'),('10003','5058','5','7'),('10003','5059','5','6'),('10003','5060','5','5'),('10003','5061','5','4'),('10003','5062','5','3'),('10003','5063','5','2'),('10003','5064','5','1'),('10003','4900','4','11'),('10003','4900','4','10'),('10003','4900','4','9'),('10003','4900','4','8'),('10003','4900','4','7'),('10003','4900','4','6'),('10003','4900','4','5'),('10003','4900','4','4'),('10003','4900','4','3'),('10003','4900','4','2'),('10003','4900','4','1'),('10003','4900','3','11'),('10003','4900','3','10'),('10003','4900','3','9'),('10003','4900','3','8'),('10003','4900','3','7'),('10003','4900','3','6'),('10003','4900','3','5'),('10003','4900','3','4'),('10003','4900','3','3'),('10003','4900','3','2'),('10003','4900','3','1'),('10003','4900','2','11'),('10003','5046','2','10'),('10003','4900','2','9'),('10003','4900','2','8'),('10003','4900','2','7'),('10003','5056','2','6'),('10003','5055','2','5'),('10003','5054','2','4'),('10003','4900','2','3'),('10003','4900','2','2'),('10003','5052','2','1'),('10003','4900','1','11'),('10003','4900','1','10'),('10003','4900','1','9'),('10003','4900','1','8'),('10003','4900','1','7'),('10003','5047','1','6'),('10003','5048','1','5'),('10003','5049','1','4'),('10003','4900','1','3'),('10003','4900','1','2'),('10003','5051','1','1'),('10003','5050','1','2'),('10003','5053','2','2');
/*!40000 ALTER TABLE `layout_grid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `layout_info`
--

DROP TABLE IF EXISTS `layout_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `layout_info` (
  `layout_id` varchar(5) DEFAULT NULL,
  `layout_name` varchar(255) DEFAULT NULL,
  `num_rows` varchar(3) DEFAULT NULL,
  `num_cols` varchar(3) DEFAULT NULL,
  `active` enum('0','1') DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `layout_info`
--

LOCK TABLES `layout_info` WRITE;
/*!40000 ALTER TABLE `layout_info` DISABLE KEYS */;
INSERT INTO `layout_info` VALUES ('10001','Main','8','11','1'),('10000','ALL','15','15','1');
/*!40000 ALTER TABLE `layout_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_monitoring_access`
--

DROP TABLE IF EXISTS `log_monitoring_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_monitoring_access` (
  `ip_address` varchar(15) DEFAULT NULL,
  `timestamp` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_monitoring_access`
--

LOCK TABLES `log_monitoring_access` WRITE;
/*!40000 ALTER TABLE `log_monitoring_access` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_monitoring_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phones`
--

DROP TABLE IF EXISTS `phones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phones` (
  `phone_id` varchar(5) NOT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `ip_address` varchar(15) DEFAULT NULL,
  `server_id` varbinary(5) DEFAULT NULL,
  `dnc_check` enum('0','1') DEFAULT '1',
  `call_limit` varchar(2) DEFAULT '1',
  `online` enum('0','1') DEFAULT '0',
  `active` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`phone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phones`
--

LOCK TABLES `phones` WRITE;
/*!40000 ALTER TABLE `phones` DISABLE KEYS */;
INSERT INTO `phones` VALUES ('5000','Agent','192.168.1.100','10002','1','3','1','1'),('9901','Agent','192.168.1.101','10002','1','3','1','1'),('5002','Agent','192.168.1.102','10002','1','3','1','1'),('5003','Agent','192.168.1.103','10002','1','3','1','1'),('5004','Agent','192.168.1.104','10002','1','3','1','1'),('5005','Agent','192.168.1.105','10002','1','3','1','1'),('5006','Agent','192.168.1.106','10002','1','3','1','1'),('5007','Agent','192.168.1.107','10002','1','3','1','1'),('5008','Agent','192.168.1.108','10002','1','3','1','1'),('5009','Agent','192.168.1.109','10002','1','3','1','1'),('5010','Agent','192.168.1.110','10002','1','3','1','1'),('5011','Agent','192.168.1.111','10002','1','3','1','1'),('5012','Agent','192.168.1.112','10002','1','3','1','1'),('5013','Agent','192.168.1.113','10002','1','3','1','1'),('5014','Agent','192.168.1.114','10002','1','3','1','1'),('5015','Agent','192.168.1.115','10002','1','3','1','1'),('5016','Agent','192.168.1.116','10002','1','3','1','1'),('5017','Agent','192.168.1.117','10002','1','3','1','1'),('5018','Agent','192.168.1.118','10002','1','3','1','1'),('5019','Agent','192.168.1.119','10002','1','3','1','1'),('5020','Agent','192.168.1.120','10002','1','3','1','1'),('5021','Agent','192.168.1.121','10002','1','3','1','1'),('5022','Agent','192.168.1.122','10002','1','3','1','1'),('5023','Agent','192.168.1.123','10002','1','3','1','1'),('5024','Agent','192.168.1.124','10002','1','3','1','1'),('5025','Agent','192.168.1.125','10002','1','3','1','1'),('5026','Agent','192.168.1.126','10002','1','3','1','1'),('5027','Agent','192.168.1.127','10002','1','3','1','1'),('5028','Agent','192.168.1.128','10002','1','3','1','1'),('5029','Agent','192.168.1.129','10002','1','3','1','1'),('5030','Agent','192.168.1.130','10002','1','3','1','1'),('5031','Agent','192.168.1.131','10002','1','3','1','1'),('5032','Agent','192.168.1.132','10002','1','3','1','1'),('5033','Agent','192.168.1.133','10002','1','3','1','1'),('5034','Agent','192.168.1.134','10002','1','3','1','1'),('5035','Agent','192.168.1.135','10002','1','3','1','1'),('5036','Agent','192.168.1.136','10002','1','3','1','1'),('5037','Agent','192.168.1.137','10002','1','3','1','1'),('5039','Agent','192.168.1.139','10002','1','3','1','1'),('5040','Agent','192.168.1.140','10002','1','3','1','1'),('5041','Agent','192.168.1.141','10002','1','3','1','1'),('5042','Agent','192.168.1.142','10002','1','3','1','1'),('5043','Agent','192.168.1.143','10002','1','3','1','1'),('5044','Agent','192.168.1.144','10002','1','3','1','1'),('5045','Agent','192.168.1.145','10002','1','3','1','1'),('5046','Agent','192.168.1.146','10002','1','3','1','1'),('5047','Agent','192.168.1.147','10002','1','3','1','1'),('5048','Agent','192.168.1.148','10002','1','3','1','1'),('5049','Agent','192.168.1.149','10002','1','3','1','1'),('5050','Agent','192.168.1.150','10002','1','3','1','1'),('5051','Agent','192.168.1.151','10002','1','3','1','1'),('5052','Agent','192.168.1.152','10002','1','3','1','1'),('5053','Agent','192.168.1.153','10002','1','3','1','1'),('5054','Agent','192.168.1.154','10002','1','3','1','1'),('5055','Agent','192.168.1.155','10002','1','3','1','1'),('5056','Agent','192.168.1.156','10002','1','3','1','1'),('5057','Agent','192.168.1.157','10002','1','3','1','1'),('5058','Agent','192.168.1.158','10002','1','3','1','1'),('5059','Agent','192.168.1.159','10002','1','3','1','1'),('5060','Agent','192.168.1.160','10002','1','3','1','1'),('5061','Agent','192.168.1.161','10002','1','3','1','1'),('5062','Agent','192.168.1.162','10002','1','3','1','1'),('5063','Agent','192.168.1.163','10002','1','3','1','1'),('5064','Agent','192.168.1.164','10002','1','3','1','1'),('5038','Agent','192.168.1.138','10002','1','3','1','1'),('5065','Agent','192.168.1.165','10002','1','3','1','1'),('5066','Agent','192.168.1.166','10002','1','3','1','1'),('5067','Agent','192.168.1.167','10002','1','3','1','1'),('5068','Agent','192.168.1.168','10002','1','3','1','1'),('5069','Agent','192.168.1.169','10002','1','3','1','1'),('5070','Agent','192.168.1.170','10002','1','3','1','1'),('5071','Agent','192.168.1.171','10002','1','3','1','1'),('5072','Agent','192.168.1.172','10002','1','3','1','1'),('5073','Agent','192.168.1.173','10002','1','3','1','1'),('5074','Agent','192.168.1.174','10002','1','3','1','1'),('5075','Agent','192.168.1.175','10002','1','3','1','1'),('5076','Agent','192.168.1.176','10002','1','3','1','1'),('5077','Agent','192.168.1.177','10002','1','3','1','1'),('5078','Agent','192.168.1.178','10002','1','3','1','1'),('5079','Agent','192.168.1.179','10002','1','3','1','1'),('5080','Agent','192.168.1.180','10002','1','3','1','1'),('5081','Agent','192.168.1.181','10003','1','3','1','1'),('5082','Agent','192.168.1.182','10003','1','3','1','1'),('5083','Agent','192.168.1.183','10003','1','3','1','1'),('5084','Agent','192.168.1.184','10003','1','3','1','1'),('5085','Agent','192.168.1.185','10003','1','3','1','1'),('5086','Agent','192.168.1.186','10003','1','3','1','1'),('5087','Agent','192.168.1.187','10003','1','3','1','1'),('5088','Agent','192.168.1.188','10003','1','3','1','1'),('5089','Agent','192.168.1.189','10003','1','3','1','1'),('5090','Agent','192.168.1.190','10003','1','3','1','1'),('5091','Agent','192.168.1.191','10003','1','3','1','1'),('5092','Agent','192.168.1.192','10003','1','3','1','1'),('5093','Agent','192.168.1.193','10003','1','3','1','1'),('5094','Agent','192.168.1.194','10003','1','3','1','1'),('5095','Agent','192.168.1.195','10003','1','3','1','1'),('5096','Agent','192.168.1.196','10003','1','3','1','1'),('5097','Agent','192.168.1.197','10003','1','3','1','1'),('5098','Agent','192.168.1.198','10003','1','3','1','1'),('5099','Agent','192.168.1.199','10003','1','3','1','1'),('5001','Agent','192.168.1.200','10003','1','3','1','1'),('5101','Agent','192.168.1.201','10003','1','3','1','1'),('5102','Agent','192.168.1.202','10003','1','3','1','1'),('5103','Agent','192.168.1.203','10003','1','3','1','1'),('5104','Agent','192.168.1.204','10003','1','3','1','1'),('5105','Agent','192.168.1.205','10003','1','3','1','1'),('5106','Agent','192.168.1.206','10003','1','3','1','1'),('5107','Agent','192.168.1.207','10003','1','3','1','1'),('5108','Agent','192.168.1.208','10003','1','3','1','1'),('5109','Agent','192.168.1.209','10003','1','3','1','1'),('5110','Agent','192.168.1.210','10003','1','3','1','1'),('5111','Agent','192.168.1.211','10003','1','3','1','1'),('5112','Agent','192.168.1.212','10003','1','3','1','1'),('5113','Agent','192.168.1.213','10003','1','3','1','1'),('5114','Agent','192.168.1.214','10003','1','3','1','1'),('5115','Agent','192.168.1.215','10003','1','3','1','1'),('5116','Agent','192.168.1.216','10003','1','3','1','1'),('5117','Agent','192.168.1.217','10003','1','3','1','1');
/*!40000 ALTER TABLE `phones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `routes`
--

DROP TABLE IF EXISTS `routes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `routes` (
  `route_id` varchar(5) NOT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `protocol` varchar(5) DEFAULT 'SIP',
  `prefix` varchar(255) DEFAULT '1',
  `route` varchar(255) DEFAULT NULL,
  `dial_options` varchar(255) DEFAULT 'o',
  `prefix_dial` enum('0','1') DEFAULT '0',
  `active` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`route_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `routes`
--

LOCK TABLES `routes` WRITE;
/*!40000 ALTER TABLE `routes` DISABLE KEYS */;
INSERT INTO `routes` VALUES ('10000','NOT ALLOWED','local','01000555','default','','1',''),('90001','5522','SIP','5522000',NULL,'tTo','1','1'),('10001','APN','SIP','1','AsiaPacific_1','tTo','','1'),('90007','Remote Hangup','local','97000555','default','tTo','',''),('90008','Barge','local','98000555','default','tTo','',''),('90006','Spy','local','99000555','default','tTo','','1');
/*!40000 ALTER TABLE `routes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `routing_failover`
--

DROP TABLE IF EXISTS `routing_failover`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `routing_failover` (
  `campaign_id` varchar(5) DEFAULT NULL,
  `route_id` varchar(5) DEFAULT NULL,
  `priority` varchar(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `routing_failover`
--

LOCK TABLES `routing_failover` WRITE;
/*!40000 ALTER TABLE `routing_failover` DISABLE KEYS */;
/*!40000 ALTER TABLE `routing_failover` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `routing_rules`
--

DROP TABLE IF EXISTS `routing_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `routing_rules` (
  `campaign_id` varchar(5) DEFAULT NULL,
  `phone_id` varchar(5) DEFAULT NULL,
  `server_id` varchar(5) DEFAULT NULL,
  `route_id` varchar(5) DEFAULT NULL,
  `match_value` varchar(10) DEFAULT NULL,
  `failover` enum('0','1') DEFAULT '0',
  `priority` varchar(2) DEFAULT '99',
  `active` enum('0','1') DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `routing_rules`
--

LOCK TABLES `routing_rules` WRITE;
/*!40000 ALTER TABLE `routing_rules` DISABLE KEYS */;
INSERT INTO `routing_rules` VALUES ('22','120','ALL','10038','ALL','','99','1'),('22','119','ALL','10038','ALL','','99','1'),('22','118','ALL','10038','ALL','','99','1'),('22','117','ALL','10038','ALL','','99','1'),('5581','ALL','ALL','10039','ALL','0','99','1'),('98','122','ALL','90008','ALL','','99','1'),('98','121','ALL','90008','ALL','','99','1'),('98','120','ALL','90008','ALL','','99','1'),('98','115','ALL','90008','ALL','','99','1'),('55','117','ALL','10034','ALL','','99','1'),('22','116','ALL','10038','ALL','','99','1'),('22','102','ALL','10038','ALL','','99','1'),('31','213','ALL','10028','ALL','0','99','1'),('21','186','ALL','10028','ALL','0','99','1'),('21','214','ALL','10028','ALL','','99','1'),('21','213','ALL','10028','ALL','','99','1'),('21','212','ALL','10028','ALL','','99','1'),('22','101','ALL','10038','ALL','','99','1'),('99','214','ALL','90006','ALL','','99','1'),('93','ALL','ALL','10002','ALL','','99','1'),('92','ALL','ALL','10002','ALL','','99','1'),('99','213','ALL','90006','ALL','','99','1'),('33','ALL','ALL','10001','ALL','','99','1'),('61','ALL','ALL','10035','ALL','','99','1'),('81','ALL','ALL','10028','ALL','','99','1'),('32','ALL','ALL','10001','ALL','','99','1'),('31','214','ALL','10028','ALL','','99','1'),('99','212','ALL','90006','ALL','','99','1'),('21','210','ALL','10028','ALL','','99','1'),('5522','ALL','ALL','10021','ALL','','99','1'),('99','144','ALL','90006','ALL','','99','1'),('51','ALL','ALL','10037','ALL','','99','1'),('21','204','ALL','10028','ALL','','99','1'),('41','ALL','ALL','10037','ALL','','99','1'),('91','ALL','ALL','10002','ALL','','99','1'),('21','189','ALL','10028','ALL','','99','1'),('99','100','ALL','90006','ALL','','99','1'),('21','138','ALL','10028','ALL','','99','1'),('71','ALL','ALL','10028','ALL','','99','1');
/*!40000 ALTER TABLE `routing_rules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scheduler`
--

DROP TABLE IF EXISTS `scheduler`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scheduler` (
  `campaign_id` varchar(5) DEFAULT NULL,
  `sked_week_day` varchar(10) DEFAULT NULL,
  `sked_hour` varchar(2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scheduler`
--

LOCK TABLES `scheduler` WRITE;
/*!40000 ALTER TABLE `scheduler` DISABLE KEYS */;
/*!40000 ALTER TABLE `scheduler` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servers`
--

DROP TABLE IF EXISTS `servers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servers` (
  `server_id` varchar(5) NOT NULL,
  `server_ip` varchar(15) DEFAULT NULL,
  `server_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`server_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servers`
--

LOCK TABLES `servers` WRITE;
/*!40000 ALTER TABLE `servers` DISABLE KEYS */;
INSERT INTO `servers` VALUES ('10002','192.168.1.2','MAIN');
/*!40000 ALTER TABLE `servers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session_calls`
--

DROP TABLE IF EXISTS `session_calls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session_calls` (
  `phone_id` varchar(20) DEFAULT NULL,
  `call_type` enum('OUT','IN','SPY','QA','IT','QUEUE') DEFAULT 'OUT',
  `channel` varchar(50) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `call_start` varchar(20) DEFAULT NULL,
  `campaign_id` varchar(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session_calls`
--

LOCK TABLES `session_calls` WRITE;
/*!40000 ALTER TABLE `session_calls` DISABLE KEYS */;
/*!40000 ALTER TABLE `session_calls` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-09-23 20:35:46
