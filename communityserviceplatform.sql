-- MySQL dump 10.13  Distrib 5.6.26, for osx10.10 (x86_64)
--
-- Host: localhost    Database: communityserviceplatform
-- ------------------------------------------------------
-- Server version	5.6.26

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
-- Current Database: `communityserviceplatform`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `communityserviceplatform` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `communityserviceplatform`;

--
-- Table structure for table `auth_group`
--

DROP TABLE IF EXISTS `auth_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_group`
--

LOCK TABLES `auth_group` WRITE;
/*!40000 ALTER TABLE `auth_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_group_permissions`
--

DROP TABLE IF EXISTS `auth_group_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_group_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `auth_group_permissions_group_id_permission_id_0cd325b0_uniq` (`group_id`,`permission_id`),
  KEY `auth_group_permissio_permission_id_84c5c92e_fk_auth_perm` (`permission_id`),
  CONSTRAINT `auth_group_permissio_permission_id_84c5c92e_fk_auth_perm` FOREIGN KEY (`permission_id`) REFERENCES `auth_permission` (`id`),
  CONSTRAINT `auth_group_permissions_group_id_b120cbf9_fk_auth_group_id` FOREIGN KEY (`group_id`) REFERENCES `auth_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_group_permissions`
--

LOCK TABLES `auth_group_permissions` WRITE;
/*!40000 ALTER TABLE `auth_group_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_group_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_permission`
--

DROP TABLE IF EXISTS `auth_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content_type_id` int(11) NOT NULL,
  `codename` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `auth_permission_content_type_id_codename_01ab375a_uniq` (`content_type_id`,`codename`),
  CONSTRAINT `auth_permission_content_type_id_2f476e4b_fk_django_co` FOREIGN KEY (`content_type_id`) REFERENCES `django_content_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_permission`
--

LOCK TABLES `auth_permission` WRITE;
/*!40000 ALTER TABLE `auth_permission` DISABLE KEYS */;
INSERT INTO `auth_permission` VALUES (1,'Can add 社区信息',1,'add_community'),(2,'Can change 社区信息',1,'change_community'),(3,'Can delete 社区信息',1,'delete_community'),(4,'Can view 社区信息',1,'view_community'),(5,'Can add 房号信息',2,'add_room'),(6,'Can change 房号信息',2,'change_room'),(7,'Can delete 房号信息',2,'delete_room'),(8,'Can view 房号信息',2,'view_room'),(9,'Can add 车位信息',3,'add_parking'),(10,'Can change 车位信息',3,'change_parking'),(11,'Can delete 车位信息',3,'delete_parking'),(12,'Can view 车位信息',3,'view_parking'),(13,'Can add 住户信息',4,'add_resident'),(14,'Can change 住户信息',4,'change_resident'),(15,'Can delete 住户信息',4,'delete_resident'),(16,'Can view 住户信息',4,'view_resident'),(17,'Can add 缴费项目',5,'add_feeitem'),(18,'Can change 缴费项目',5,'change_feeitem'),(19,'Can delete 缴费项目',5,'delete_feeitem'),(20,'Can view 缴费项目',5,'view_feeitem'),(21,'Can add 缴费记录',6,'add_fee'),(22,'Can change 缴费记录',6,'change_fee'),(23,'Can delete 缴费记录',6,'delete_fee'),(24,'Can view 缴费记录',6,'view_fee'),(25,'Can add 维修类别',7,'add_repairtype'),(26,'Can change 维修类别',7,'change_repairtype'),(27,'Can delete 维修类别',7,'delete_repairtype'),(28,'Can view 维修类别',7,'view_repairtype'),(29,'Can add 报修工单',8,'add_repair'),(30,'Can change 报修工单',8,'change_repair'),(31,'Can delete 报修工单',8,'delete_repair'),(32,'Can view 报修工单',8,'view_repair'),(33,'Can add 图片',9,'add_image'),(34,'Can change 图片',9,'change_image'),(35,'Can delete 图片',9,'delete_image'),(36,'Can view 图片',9,'view_image'),(37,'Can add 通知类型',10,'add_noticetype'),(38,'Can change 通知类型',10,'change_noticetype'),(39,'Can delete 通知类型',10,'delete_noticetype'),(40,'Can view 通知类型',10,'view_noticetype'),(41,'Can add 通知',11,'add_notice'),(42,'Can change 通知',11,'change_notice'),(43,'Can delete 通知',11,'delete_notice'),(44,'Can view 通知',11,'view_notice'),(45,'Can add log entry',12,'add_logentry'),(46,'Can change log entry',12,'change_logentry'),(47,'Can delete log entry',12,'delete_logentry'),(48,'Can view log entry',12,'view_logentry'),(49,'Can add permission',13,'add_permission'),(50,'Can change permission',13,'change_permission'),(51,'Can delete permission',13,'delete_permission'),(52,'Can view permission',13,'view_permission'),(53,'Can add group',14,'add_group'),(54,'Can change group',14,'change_group'),(55,'Can delete group',14,'delete_group'),(56,'Can view group',14,'view_group'),(57,'Can add user',15,'add_user'),(58,'Can change user',15,'change_user'),(59,'Can delete user',15,'delete_user'),(60,'Can view user',15,'view_user'),(61,'Can add content type',16,'add_contenttype'),(62,'Can change content type',16,'change_contenttype'),(63,'Can delete content type',16,'delete_contenttype'),(64,'Can view content type',16,'view_contenttype'),(65,'Can add session',17,'add_session'),(66,'Can change session',17,'change_session'),(67,'Can delete session',17,'delete_session'),(68,'Can view session',17,'view_session'),(69,'Can add Bookmark',18,'add_bookmark'),(70,'Can change Bookmark',18,'change_bookmark'),(71,'Can delete Bookmark',18,'delete_bookmark'),(72,'Can view Bookmark',18,'view_bookmark'),(73,'Can add User Setting',19,'add_usersettings'),(74,'Can change User Setting',19,'change_usersettings'),(75,'Can delete User Setting',19,'delete_usersettings'),(76,'Can view User Setting',19,'view_usersettings'),(77,'Can add User Widget',20,'add_userwidget'),(78,'Can change User Widget',20,'change_userwidget'),(79,'Can delete User Widget',20,'delete_userwidget'),(80,'Can view User Widget',20,'view_userwidget'),(81,'Can add log entry',21,'add_log'),(82,'Can change log entry',21,'change_log'),(83,'Can delete log entry',21,'delete_log'),(84,'Can view log entry',21,'view_log'),(85,'Can add revision',22,'add_revision'),(86,'Can change revision',22,'change_revision'),(87,'Can delete revision',22,'delete_revision'),(88,'Can view revision',22,'view_revision'),(89,'Can add version',23,'add_version'),(90,'Can change version',23,'change_version'),(91,'Can delete version',23,'delete_version'),(92,'Can view version',23,'view_version');
/*!40000 ALTER TABLE `auth_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_user`
--

DROP TABLE IF EXISTS `auth_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(128) NOT NULL,
  `last_login` datetime(6) DEFAULT NULL,
  `is_superuser` tinyint(1) NOT NULL,
  `username` varchar(150) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `email` varchar(254) NOT NULL,
  `is_staff` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `date_joined` datetime(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_user`
--

LOCK TABLES `auth_user` WRITE;
/*!40000 ALTER TABLE `auth_user` DISABLE KEYS */;
INSERT INTO `auth_user` VALUES (1,'pbkdf2_sha256$120000$dCDTqShRSoUk$3lNhmSQ6BK6BWJwKydzblbuf8W3PlRFot773jVX2St0=',NULL,1,'huwk','','','68066497@qq.com',1,1,'2018-11-15 06:25:22.287773');
/*!40000 ALTER TABLE `auth_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_user_groups`
--

DROP TABLE IF EXISTS `auth_user_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `auth_user_groups_user_id_group_id_94350c0c_uniq` (`user_id`,`group_id`),
  KEY `auth_user_groups_group_id_97559544_fk_auth_group_id` (`group_id`),
  CONSTRAINT `auth_user_groups_group_id_97559544_fk_auth_group_id` FOREIGN KEY (`group_id`) REFERENCES `auth_group` (`id`),
  CONSTRAINT `auth_user_groups_user_id_6a12ed8b_fk_auth_user_id` FOREIGN KEY (`user_id`) REFERENCES `auth_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_user_groups`
--

LOCK TABLES `auth_user_groups` WRITE;
/*!40000 ALTER TABLE `auth_user_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_user_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_user_user_permissions`
--

DROP TABLE IF EXISTS `auth_user_user_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_user_user_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `auth_user_user_permissions_user_id_permission_id_14a6b632_uniq` (`user_id`,`permission_id`),
  KEY `auth_user_user_permi_permission_id_1fbb5f2c_fk_auth_perm` (`permission_id`),
  CONSTRAINT `auth_user_user_permi_permission_id_1fbb5f2c_fk_auth_perm` FOREIGN KEY (`permission_id`) REFERENCES `auth_permission` (`id`),
  CONSTRAINT `auth_user_user_permissions_user_id_a95ead1b_fk_auth_user_id` FOREIGN KEY (`user_id`) REFERENCES `auth_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_user_user_permissions`
--

LOCK TABLES `auth_user_user_permissions` WRITE;
/*!40000 ALTER TABLE `auth_user_user_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_user_user_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmp_banner`
--

DROP TABLE IF EXISTS `cmp_banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmp_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titles` varchar(65) NOT NULL DEFAULT '' COMMENT '标题',
  `pics` varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址',
  `link_url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `show_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '显示类型1=手机移动web',
  `show_time` int(11) NOT NULL DEFAULT '2' COMMENT '显示时间长短比如2秒显示时间',
  `order_sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序号用于排序',
  `banner_state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态0=关闭1=启用',
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmp_banner`
--

LOCK TABLES `cmp_banner` WRITE;
/*!40000 ALTER TABLE `cmp_banner` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmp_banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmp_community`
--

DROP TABLE IF EXISTS `cmp_community`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmp_community` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL DEFAULT '' COMMENT '社区名',
  `description` longtext NOT NULL COMMENT '社区简介',
  `address` varchar(300) NOT NULL DEFAULT '' COMMENT '地址',
  `main_contact` varchar(45) NOT NULL DEFAULT '' COMMENT '主要联系人',
  `phone` varchar(45) NOT NULL DEFAULT '' COMMENT '联系电话',
  `welcome_message` longtext NOT NULL COMMENT '微信欢迎信息',
  `lat` double NOT NULL DEFAULT '0' COMMENT '纬度',
  `lng` double NOT NULL DEFAULT '0' COMMENT '经度',
  `coord_type` varchar(10) NOT NULL DEFAULT '' COMMENT '坐标系',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='社区信息';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmp_community`
--

LOCK TABLES `cmp_community` WRITE;
/*!40000 ALTER TABLE `cmp_community` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmp_community` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmp_fee`
--

DROP TABLE IF EXISTS `cmp_fee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmp_fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fee_description` varchar(100) NOT NULL DEFAULT '' COMMENT '费用描述',
  `fee_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `start_date` date NOT NULL COMMENT '费用起始日期',
  `end_date` date NOT NULL COMMENT '费用结束日期',
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_status` smallint(6) NOT NULL DEFAULT '0' COMMENT '付款状态0=未付款1=已付款',
  `is_online_payment` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否线上支付 0=否1=是',
  `payment_method` smallint(6) NOT NULL DEFAULT '0' COMMENT '支付方式0=现金1=微信2=支付宝3=POS4=其它',
  `transaction_number` varchar(50) NOT NULL DEFAULT '' COMMENT '交易号',
  `payment_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '付款时间',
  `actual_payment_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际付款金额',
  `notes` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `fee_item_id_id` int(11) NOT NULL COMMENT '缴费项目',
  `resident_id_id` int(11) NOT NULL DEFAULT '0' COMMENT '缴费人',
  `room_id` int(11) DEFAULT '0' COMMENT '房号room表id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT 'auth_user表id维护人',
  PRIMARY KEY (`id`),
  KEY `cmp_fee_fee_item_id_id_0cac0b4c_fk_cmp_fee_item_id` (`fee_item_id_id`),
  KEY `payment_status` (`payment_status`) USING BTREE,
  KEY `room_id` (`room_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `resident_id` (`resident_id_id`) USING BTREE,
  KEY `payment_date` (`payment_date`) USING BTREE,
  KEY `create_date` (`create_date`) USING BTREE,
  KEY `is_online_payment` (`is_online_payment`) USING BTREE,
  KEY `payment_method` (`payment_method`) USING BTREE,
  KEY `transaction_number` (`transaction_number`) USING BTREE,
  CONSTRAINT `cmp_fee_fee_item_id_id_0cac0b4c_fk_cmp_fee_item_id` FOREIGN KEY (`fee_item_id_id`) REFERENCES `cmp_fee_item` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='缴费记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmp_fee`
--

LOCK TABLES `cmp_fee` WRITE;
/*!40000 ALTER TABLE `cmp_fee` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmp_fee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmp_fee_item`
--

DROP TABLE IF EXISTS `cmp_fee_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmp_fee_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL DEFAULT '' COMMENT '缴费项目',
  `description` varchar(300) NOT NULL DEFAULT '' COMMENT '缴费项目描述',
  `cycle` varchar(45) NOT NULL DEFAULT '' COMMENT '缴费周期',
  `active_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否激活0=否1=是',
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='缴费项目';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmp_fee_item`
--

LOCK TABLES `cmp_fee_item` WRITE;
/*!40000 ALTER TABLE `cmp_fee_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmp_fee_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmp_generat_no`
--

DROP TABLE IF EXISTS `cmp_generat_no`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmp_generat_no` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `add_date` int(11) NOT NULL DEFAULT '0' COMMENT '添加日期',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `add_date` (`add_date`) USING BTREE,
  KEY `add_time` (`add_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmp_generat_no`
--

LOCK TABLES `cmp_generat_no` WRITE;
/*!40000 ALTER TABLE `cmp_generat_no` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmp_generat_no` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmp_image`
--

DROP TABLE IF EXISTS `cmp_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmp_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_location` varchar(100) NOT NULL DEFAULT '' COMMENT '存放位置',
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后更新时间',
  `repair_id` int(11) NOT NULL COMMENT '报修工单表id',
  PRIMARY KEY (`id`),
  KEY `cmp_image_repair_id_8e8de9b0_fk_cmp_repair_id` (`repair_id`),
  CONSTRAINT `cmp_image_repair_id_8e8de9b0_fk_cmp_repair_id` FOREIGN KEY (`repair_id`) REFERENCES `cmp_repair` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='图片';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmp_image`
--

LOCK TABLES `cmp_image` WRITE;
/*!40000 ALTER TABLE `cmp_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmp_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmp_notice`
--

DROP TABLE IF EXISTS `cmp_notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmp_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `content` longtext NOT NULL COMMENT '内容',
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `effective_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '开始时间',
  `expire_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '结束时间',
  `create_user_id` int(11) NOT NULL COMMENT '创建者auth_user表id',
  `notice_type_id` int(11) NOT NULL COMMENT '类型id',
  PRIMARY KEY (`id`),
  KEY `cmp_notice_create_user_id_0cf2bc54_fk_auth_user_id` (`create_user_id`),
  KEY `cmp_notice_notice_type_id_dcbcef29_fk_cmp_notice_type_id` (`notice_type_id`),
  KEY `effective_date` (`effective_date`) USING BTREE,
  KEY `create_date` (`create_date`) USING BTREE,
  KEY `expire_date` (`expire_date`) USING BTREE,
  CONSTRAINT `cmp_notice_create_user_id_0cf2bc54_fk_auth_user_id` FOREIGN KEY (`create_user_id`) REFERENCES `auth_user` (`id`),
  CONSTRAINT `cmp_notice_notice_type_id_dcbcef29_fk_cmp_notice_type_id` FOREIGN KEY (`notice_type_id`) REFERENCES `cmp_notice_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='通知';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmp_notice`
--

LOCK TABLES `cmp_notice` WRITE;
/*!40000 ALTER TABLE `cmp_notice` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmp_notice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmp_notice_type`
--

DROP TABLE IF EXISTS `cmp_notice_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmp_notice_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(100) NOT NULL DEFAULT '' COMMENT '通知类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='通知类型';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmp_notice_type`
--

LOCK TABLES `cmp_notice_type` WRITE;
/*!40000 ALTER TABLE `cmp_notice_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmp_notice_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmp_parking`
--

DROP TABLE IF EXISTS `cmp_parking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmp_parking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parking_code` varchar(45) NOT NULL DEFAULT '' COMMENT '车位号',
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后更新日期',
  `room_id` int(11) NOT NULL DEFAULT '0' COMMENT '房号id',
  PRIMARY KEY (`id`),
  KEY `cmp_parking_room_id_7e57ee17_fk_cmp_room_id` (`room_id`),
  KEY `parking_code` (`parking_code`) USING BTREE,
  KEY `create_date` (`create_date`) USING BTREE,
  CONSTRAINT `cmp_parking_room_id_7e57ee17_fk_cmp_room_id` FOREIGN KEY (`room_id`) REFERENCES `cmp_room` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='车位信息';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmp_parking`
--

LOCK TABLES `cmp_parking` WRITE;
/*!40000 ALTER TABLE `cmp_parking` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmp_parking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmp_pay_order`
--

DROP TABLE IF EXISTS `cmp_pay_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmp_pay_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pay_sn` varchar(15) NOT NULL DEFAULT '' COMMENT '支付编号',
  `fee_id` int(11) NOT NULL DEFAULT '0' COMMENT '缴费记录cmp_fee表id',
  `resident_id` int(11) NOT NULL DEFAULT '0' COMMENT 'cmp_resident表id',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '应收金额',
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠金额',
  `trade_type` varchar(20) NOT NULL DEFAULT '' COMMENT '交易类型返回',
  `transaction_id` varchar(32) NOT NULL DEFAULT '' COMMENT '支付平台订单号',
  `pay_mod_id` int(11) NOT NULL DEFAULT '0' COMMENT '支付方式 1=微信',
  `pay_state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '支付状态0=待支付1=支付成功-1=支付失败',
  `pay_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '支付时间',
  `pay_time` int(11) NOT NULL DEFAULT '0' COMMENT '支付时间',
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pay_sn_UNIQUE` (`pay_sn`),
  KEY `fee_id` (`fee_id`),
  KEY `pay_state` (`pay_state`) USING BTREE,
  KEY `pay_date` (`pay_date`) USING BTREE,
  KEY `pay_time` (`pay_time`) USING BTREE,
  KEY `create_date` (`create_date`) USING BTREE,
  KEY `resident_id` (`resident_id`) USING BTREE,
  CONSTRAINT `fk_fee_id` FOREIGN KEY (`fee_id`) REFERENCES `cmp_fee` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmp_pay_order`
--

LOCK TABLES `cmp_pay_order` WRITE;
/*!40000 ALTER TABLE `cmp_pay_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmp_pay_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmp_repair`
--

DROP TABLE IF EXISTS `cmp_repair`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmp_repair` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL DEFAULT '' COMMENT '标题',
  `content` longtext NOT NULL COMMENT '内容',
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后更新时间',
  `status` smallint(6) NOT NULL DEFAULT '0' COMMENT '处理状态0=待提交1=已提交2=已处理',
  `result` longtext COMMENT '处理结果',
  `repair_type_id` int(11) DEFAULT NULL COMMENT '维修类别id',
  `resident_id` int(11) DEFAULT NULL COMMENT '报告人cmp_resident表id',
  PRIMARY KEY (`id`),
  KEY `status` (`status`) USING BTREE,
  KEY `create_date` (`create_date`) USING BTREE,
  KEY `cmp_repair_repair_type_id_4707a3f6_fk_cmp_repair_type_id` (`repair_type_id`),
  KEY `cmp_repair_resident_id_fda8c570_fk_cmp_resident_id` (`resident_id`),
  CONSTRAINT `cmp_repair_repair_type_id_4707a3f6_fk_cmp_repair_type_id` FOREIGN KEY (`repair_type_id`) REFERENCES `cmp_repair_type` (`id`),
  CONSTRAINT `cmp_repair_resident_id_fda8c570_fk_cmp_resident_id` FOREIGN KEY (`resident_id`) REFERENCES `cmp_resident` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COMMENT='报修工单';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmp_repair`
--

LOCK TABLES `cmp_repair` WRITE;
/*!40000 ALTER TABLE `cmp_repair` DISABLE KEYS */;
INSERT INTO `cmp_repair` VALUES (4,'','22','2018-11-18 15:19:12','2018-11-18 15:19:12',0,NULL,1,25);
/*!40000 ALTER TABLE `cmp_repair` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmp_repair_type`
--

DROP TABLE IF EXISTS `cmp_repair_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmp_repair_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(45) NOT NULL COMMENT '维修类别',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='维修类别';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmp_repair_type`
--

LOCK TABLES `cmp_repair_type` WRITE;
/*!40000 ALTER TABLE `cmp_repair_type` DISABLE KEYS */;
INSERT INTO `cmp_repair_type` VALUES (1,'卫生间');
/*!40000 ALTER TABLE `cmp_repair_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmp_resident`
--

DROP TABLE IF EXISTS `cmp_resident`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmp_resident` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(45) NOT NULL DEFAULT '' COMMENT '账号',
  `password` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '密码',
  `name` varchar(45) NOT NULL DEFAULT '' COMMENT '姓名',
  `identification` varchar(18) NOT NULL DEFAULT '' COMMENT '身份证号',
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号',
  `receive_notification` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否接收微信消息0=否1=是',
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后更新日期',
  `uphone` varchar(25) NOT NULL DEFAULT '' COMMENT '预留电话',
  `face_img` varchar(355) NOT NULL DEFAULT '' COMMENT '头像',
  `login_time` int(11) NOT NULL DEFAULT '0' COMMENT '登录时间',
  `login_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '登录ip',
  `last_time` int(11) NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `last_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '上次登录ip',
  `login_num` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `is_maintenance_staff` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是维修人员0=否1=是',
  `is_black` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否黑名单0=否1=是',
  `audit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核绑定0=待审核1=审核进行中2=审核通过-1=审核不通过',
  `atoken` varchar(500) NOT NULL DEFAULT '' COMMENT '令牌',
  PRIMARY KEY (`id`),
  KEY `account` (`account`) USING BTREE,
  KEY `password` (`password`) USING BTREE,
  KEY `phone` (`phone`) USING BTREE,
  KEY `is_maintenance_staff` (`is_maintenance_staff`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmp_resident`
--

LOCK TABLES `cmp_resident` WRITE;
/*!40000 ALTER TABLE `cmp_resident` DISABLE KEYS */;
INSERT INTO `cmp_resident` VALUES (25,'huhu','ec5083f7bab7cd2abd79731fcc8804f1','1','','13634175905',0,'2018-11-17 15:18:33','2018-11-18 20:56:22','','',1542545673,'127.0.0.1',1542524984,'127.0.0.1',7,0,0,0,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC93d3cuc3hjbXAubmV0IiwiYXVkIjoiaHR0cDpcL1wvd3d3LnN4Y21wLm5ldCIsImlhdCI6MTU0MjU0NTY3MywibmJmIjoxNTQyNTQ1NjczLCJleHAiOjE1NDI1NTI4NzMsImRhdGEiOnsidG9rZW5fcmVzaWRlbnRfaWQiOiIyNSIsInRva2VuX2NyZWF0ZWRfYXQiOjE1NDI1NDU2NzMsInRva2VuX2V4cGlyZXNfYXQiOjE1NDI1NTI4NzMsInRva2VuX2lwIjoyMTMwNzA2NDMzfX0.2wiV-iclWiUEBlIMMUyKHVrYJaW1d3PUQS8tn8Am94k');
/*!40000 ALTER TABLE `cmp_resident` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmp_resident_room`
--

DROP TABLE IF EXISTS `cmp_resident_room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmp_resident_room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resident_id` int(11) NOT NULL DEFAULT '0' COMMENT 'cmp_resident表id',
  `room_id` int(11) NOT NULL DEFAULT '0' COMMENT 'cmp_room表id',
  `resident_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '住户类型1=房屋所有者2=房屋所有者家人3=租客',
  `is_verified` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已校验0=否1=是',
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `resident_id` (`resident_id`) USING BTREE,
  KEY `room_id` (`room_id`) USING BTREE,
  KEY `is_verified` (`is_verified`) USING BTREE,
  KEY `resident_type` (`resident_type`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmp_resident_room`
--

LOCK TABLES `cmp_resident_room` WRITE;
/*!40000 ALTER TABLE `cmp_resident_room` DISABLE KEYS */;
INSERT INTO `cmp_resident_room` VALUES (1,0,1,2,0,'2018-11-18 16:48:53');
/*!40000 ALTER TABLE `cmp_resident_room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmp_resident_sns`
--

DROP TABLE IF EXISTS `cmp_resident_sns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmp_resident_sns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sns_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '第三方编号',
  `unionid` varchar(35) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '微信串联用户帐号',
  `sns_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型1=微信公众号',
  `resident_id` int(11) NOT NULL DEFAULT '0' COMMENT 'cmp_resident的id',
  `access_token` varchar(355) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '令牌',
  `refresh_token` varchar(355) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '刷新令牌',
  `expires_in` int(11) NOT NULL DEFAULT '0' COMMENT '令牌过期时间',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `sns_id` (`sns_id`),
  KEY `sns_type` (`sns_type`),
  KEY `resident_id` (`resident_id`),
  CONSTRAINT `fk_resident_id_id` FOREIGN KEY (`resident_id`) REFERENCES `cmp_resident` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8 COMMENT='第三方登录对应表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmp_resident_sns`
--

LOCK TABLES `cmp_resident_sns` WRITE;
/*!40000 ALTER TABLE `cmp_resident_sns` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmp_resident_sns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmp_room`
--

DROP TABLE IF EXISTS `cmp_room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmp_room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region` varchar(45) NOT NULL DEFAULT '' COMMENT '区',
  `building` varchar(10) NOT NULL DEFAULT '' COMMENT '栋',
  `unit` varchar(10) NOT NULL DEFAULT '' COMMENT '单元',
  `room_no` varchar(10) NOT NULL DEFAULT '' COMMENT '房间号',
  `order_sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序号用来排序',
  `room_state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '房号状态 1=开启0=关闭-1=删除',
  `lat` double NOT NULL DEFAULT '0' COMMENT '纬度',
  `lng` double NOT NULL DEFAULT '0' COMMENT '经度',
  `coord_type` varchar(10) NOT NULL DEFAULT '' COMMENT '坐标系',
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后更新日期',
  PRIMARY KEY (`id`),
  KEY `room_no` (`room_no`) USING BTREE,
  KEY `region` (`region`) USING BTREE,
  KEY `create_date` (`create_date`) USING BTREE,
  KEY `room_state` (`room_state`) USING BTREE,
  KEY `order_sort` (`order_sort`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='房号';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmp_room`
--

LOCK TABLES `cmp_room` WRITE;
/*!40000 ALTER TABLE `cmp_room` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmp_room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmp_verify`
--

DROP TABLE IF EXISTS `cmp_verify`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmp_verify` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号',
  `verify` varchar(6) NOT NULL DEFAULT '' COMMENT '验证码',
  `period` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '有效期',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=注册2=找回密码',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '1=成功2=失败',
  `error_msg` varchar(500) NOT NULL DEFAULT '' COMMENT '错误信息',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '生成时间',
  `is_use` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已使用，1是0否',
  PRIMARY KEY (`id`),
  KEY `phone` (`phone`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `type` (`type`) USING BTREE,
  KEY `is_use` (`is_use`) USING BTREE,
  KEY `add_time` (`add_time`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=COMPACT COMMENT='验证码表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmp_verify`
--

LOCK TABLES `cmp_verify` WRITE;
/*!40000 ALTER TABLE `cmp_verify` DISABLE KEYS */;
INSERT INTO `cmp_verify` VALUES (1,'13634175905','526349',1542432321,1,0,'',1542431721,1),(2,'13634175905','526349',1542437457,1,0,'',1542436857,1),(3,'13634175905','526349',1542441529,2,0,'',1542440929,1),(4,'13634175905','615500',1542442442,2,0,'',1542441842,0);
/*!40000 ALTER TABLE `cmp_verify` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `django_admin_log`
--

DROP TABLE IF EXISTS `django_admin_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `django_admin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_time` datetime(6) NOT NULL,
  `object_id` longtext,
  `object_repr` varchar(200) NOT NULL,
  `action_flag` smallint(5) unsigned NOT NULL,
  `change_message` longtext NOT NULL,
  `content_type_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `django_admin_log_content_type_id_c4bce8eb_fk_django_co` (`content_type_id`),
  KEY `django_admin_log_user_id_c564eba6_fk_auth_user_id` (`user_id`),
  CONSTRAINT `django_admin_log_content_type_id_c4bce8eb_fk_django_co` FOREIGN KEY (`content_type_id`) REFERENCES `django_content_type` (`id`),
  CONSTRAINT `django_admin_log_user_id_c564eba6_fk_auth_user_id` FOREIGN KEY (`user_id`) REFERENCES `auth_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `django_admin_log`
--

LOCK TABLES `django_admin_log` WRITE;
/*!40000 ALTER TABLE `django_admin_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `django_admin_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `django_content_type`
--

DROP TABLE IF EXISTS `django_content_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `django_content_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_label` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `django_content_type_app_label_model_76bd3d3b_uniq` (`app_label`,`model`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `django_content_type`
--

LOCK TABLES `django_content_type` WRITE;
/*!40000 ALTER TABLE `django_content_type` DISABLE KEYS */;
INSERT INTO `django_content_type` VALUES (12,'admin','logentry'),(14,'auth','group'),(13,'auth','permission'),(15,'auth','user'),(1,'community','community'),(3,'community','parking'),(4,'community','resident'),(2,'community','room'),(16,'contenttypes','contenttype'),(6,'fee','fee'),(5,'fee','feeitem'),(11,'notice','notice'),(10,'notice','noticetype'),(9,'repair','image'),(8,'repair','repair'),(7,'repair','repairtype'),(22,'reversion','revision'),(23,'reversion','version'),(17,'sessions','session'),(18,'xadmin','bookmark'),(21,'xadmin','log'),(19,'xadmin','usersettings'),(20,'xadmin','userwidget');
/*!40000 ALTER TABLE `django_content_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `django_migrations`
--

DROP TABLE IF EXISTS `django_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `django_migrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `applied` datetime(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `django_migrations`
--

LOCK TABLES `django_migrations` WRITE;
/*!40000 ALTER TABLE `django_migrations` DISABLE KEYS */;
INSERT INTO `django_migrations` VALUES (1,'contenttypes','0001_initial','2018-11-15 06:18:31.033625'),(2,'auth','0001_initial','2018-11-15 06:18:31.399181'),(3,'admin','0001_initial','2018-11-15 06:18:31.464506'),(4,'admin','0002_logentry_remove_auto_add','2018-11-15 06:18:31.473618'),(5,'admin','0003_logentry_add_action_flag_choices','2018-11-15 06:18:31.481818'),(6,'contenttypes','0002_remove_content_type_name','2018-11-15 06:18:31.548891'),(7,'auth','0002_alter_permission_name_max_length','2018-11-15 06:18:31.577641'),(8,'auth','0003_alter_user_email_max_length','2018-11-15 06:18:31.608602'),(9,'auth','0004_alter_user_username_opts','2018-11-15 06:18:31.617722'),(10,'auth','0005_alter_user_last_login_null','2018-11-15 06:18:31.649691'),(11,'auth','0006_require_contenttypes_0002','2018-11-15 06:18:31.652135'),(12,'auth','0007_alter_validators_add_error_messages','2018-11-15 06:18:31.661534'),(13,'auth','0008_alter_user_username_max_length','2018-11-15 06:18:31.691400'),(14,'auth','0009_alter_user_last_name_max_length','2018-11-15 06:18:31.721938'),(15,'reversion','0001_squashed_0004_auto_20160611_1202','2018-11-15 06:21:20.722255'),(16,'sessions','0001_initial','2018-11-15 06:21:20.763607'),(17,'xadmin','0001_initial','2018-11-15 06:21:20.938034'),(18,'xadmin','0002_log','2018-11-15 06:21:21.011190'),(19,'xadmin','0003_auto_20160715_0100','2018-11-15 06:21:21.047036'),(20,'community','0001_initial','2018-11-16 02:30:02.295597'),(21,'notice','0001_initial','2018-11-16 02:30:02.439803'),(22,'repair','0001_initial','2018-11-16 02:30:02.648647');
/*!40000 ALTER TABLE `django_migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `django_session`
--

DROP TABLE IF EXISTS `django_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `django_session` (
  `session_key` varchar(40) NOT NULL,
  `session_data` longtext NOT NULL,
  `expire_date` datetime(6) NOT NULL,
  PRIMARY KEY (`session_key`),
  KEY `django_session_expire_date_a5c62663` (`expire_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `django_session`
--

LOCK TABLES `django_session` WRITE;
/*!40000 ALTER TABLE `django_session` DISABLE KEYS */;
/*!40000 ALTER TABLE `django_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reversion_revision`
--

DROP TABLE IF EXISTS `reversion_revision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reversion_revision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_created` datetime(6) NOT NULL,
  `comment` longtext NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reversion_revision_user_id_17095f45_fk_auth_user_id` (`user_id`),
  KEY `reversion_revision_date_created_96f7c20c` (`date_created`),
  CONSTRAINT `reversion_revision_user_id_17095f45_fk_auth_user_id` FOREIGN KEY (`user_id`) REFERENCES `auth_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reversion_revision`
--

LOCK TABLES `reversion_revision` WRITE;
/*!40000 ALTER TABLE `reversion_revision` DISABLE KEYS */;
/*!40000 ALTER TABLE `reversion_revision` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reversion_version`
--

DROP TABLE IF EXISTS `reversion_version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reversion_version` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` varchar(191) NOT NULL,
  `format` varchar(255) NOT NULL,
  `serialized_data` longtext NOT NULL,
  `object_repr` longtext NOT NULL,
  `content_type_id` int(11) NOT NULL,
  `revision_id` int(11) NOT NULL,
  `db` varchar(191) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reversion_version_db_content_type_id_objec_b2c54f65_uniq` (`db`,`content_type_id`,`object_id`,`revision_id`),
  KEY `reversion_version_content_type_id_7d0ff25c_fk_django_co` (`content_type_id`),
  KEY `reversion_version_revision_id_af9f6a9d_fk_reversion_revision_id` (`revision_id`),
  CONSTRAINT `reversion_version_content_type_id_7d0ff25c_fk_django_co` FOREIGN KEY (`content_type_id`) REFERENCES `django_content_type` (`id`),
  CONSTRAINT `reversion_version_revision_id_af9f6a9d_fk_reversion_revision_id` FOREIGN KEY (`revision_id`) REFERENCES `reversion_revision` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reversion_version`
--

LOCK TABLES `reversion_version` WRITE;
/*!40000 ALTER TABLE `reversion_version` DISABLE KEYS */;
/*!40000 ALTER TABLE `reversion_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `xadmin_bookmark`
--

DROP TABLE IF EXISTS `xadmin_bookmark`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xadmin_bookmark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `url_name` varchar(64) NOT NULL,
  `query` varchar(1000) NOT NULL,
  `is_share` tinyint(1) NOT NULL,
  `content_type_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `xadmin_bookmark_content_type_id_60941679_fk_django_co` (`content_type_id`),
  KEY `xadmin_bookmark_user_id_42d307fc_fk_auth_user_id` (`user_id`),
  CONSTRAINT `xadmin_bookmark_content_type_id_60941679_fk_django_co` FOREIGN KEY (`content_type_id`) REFERENCES `django_content_type` (`id`),
  CONSTRAINT `xadmin_bookmark_user_id_42d307fc_fk_auth_user_id` FOREIGN KEY (`user_id`) REFERENCES `auth_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xadmin_bookmark`
--

LOCK TABLES `xadmin_bookmark` WRITE;
/*!40000 ALTER TABLE `xadmin_bookmark` DISABLE KEYS */;
/*!40000 ALTER TABLE `xadmin_bookmark` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `xadmin_log`
--

DROP TABLE IF EXISTS `xadmin_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xadmin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_time` datetime(6) NOT NULL,
  `ip_addr` char(39) DEFAULT NULL,
  `object_id` longtext,
  `object_repr` varchar(200) NOT NULL,
  `action_flag` varchar(32) NOT NULL,
  `message` longtext NOT NULL,
  `content_type_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `xadmin_log_content_type_id_2a6cb852_fk_django_content_type_id` (`content_type_id`),
  KEY `xadmin_log_user_id_bb16a176_fk_auth_user_id` (`user_id`),
  CONSTRAINT `xadmin_log_content_type_id_2a6cb852_fk_django_content_type_id` FOREIGN KEY (`content_type_id`) REFERENCES `django_content_type` (`id`),
  CONSTRAINT `xadmin_log_user_id_bb16a176_fk_auth_user_id` FOREIGN KEY (`user_id`) REFERENCES `auth_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xadmin_log`
--

LOCK TABLES `xadmin_log` WRITE;
/*!40000 ALTER TABLE `xadmin_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `xadmin_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `xadmin_usersettings`
--

DROP TABLE IF EXISTS `xadmin_usersettings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xadmin_usersettings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(256) NOT NULL,
  `value` longtext NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `xadmin_usersettings_user_id_edeabe4a_fk_auth_user_id` (`user_id`),
  CONSTRAINT `xadmin_usersettings_user_id_edeabe4a_fk_auth_user_id` FOREIGN KEY (`user_id`) REFERENCES `auth_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xadmin_usersettings`
--

LOCK TABLES `xadmin_usersettings` WRITE;
/*!40000 ALTER TABLE `xadmin_usersettings` DISABLE KEYS */;
/*!40000 ALTER TABLE `xadmin_usersettings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `xadmin_userwidget`
--

DROP TABLE IF EXISTS `xadmin_userwidget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xadmin_userwidget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` varchar(256) NOT NULL,
  `widget_type` varchar(50) NOT NULL,
  `value` longtext NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `xadmin_userwidget_user_id_c159233a_fk_auth_user_id` (`user_id`),
  CONSTRAINT `xadmin_userwidget_user_id_c159233a_fk_auth_user_id` FOREIGN KEY (`user_id`) REFERENCES `auth_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xadmin_userwidget`
--

LOCK TABLES `xadmin_userwidget` WRITE;
/*!40000 ALTER TABLE `xadmin_userwidget` DISABLE KEYS */;
/*!40000 ALTER TABLE `xadmin_userwidget` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-19 21:07:44
