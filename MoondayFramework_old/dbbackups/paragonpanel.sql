-- MySQL dump 10.10
--
-- Host: localhost    Database: wisegene
-- ------------------------------------------------------
-- Server version	5.0.21-standard

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
-- Table structure for table `account_addons`
--

DROP TABLE IF EXISTS `account_addons`;
CREATE TABLE `account_addons` (
  `aa_id` int(15) NOT NULL auto_increment,
  `addon_id` bigint(255) NOT NULL default '0',
  `account_id` bigint(255) NOT NULL default '0',
  `date` date NOT NULL default '0000-00-00',
  `price_override` enum('0','1') NOT NULL default '0',
  `price_override_amount` decimal(10,2) NOT NULL default '0.00',
  PRIMARY KEY  (`aa_id`),
  KEY `account_id` (`addon_id`,`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_addons`
--


/*!40000 ALTER TABLE `account_addons` DISABLE KEYS */;
LOCK TABLES `account_addons` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `account_addons` ENABLE KEYS */;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts` (
  `account_id` int(8) unsigned NOT NULL auto_increment,
  `client_id` int(8) unsigned NOT NULL default '0',
  `package_id` int(8) unsigned NOT NULL default '0',
  `device_id` int(8) unsigned NOT NULL default '0',
  `timestamp` int(25) NOT NULL default '0',
  `start_date` date NOT NULL default '0000-00-00',
  `due_date` date NOT NULL default '0000-00-00',
  `price_override` enum('0','1') NOT NULL default '0',
  `price_override_amount` decimal(10,2) NOT NULL default '0.00',
  `status` enum('A','P','S','C','F') NOT NULL default 'P',
  `domain` varchar(100) NOT NULL default '',
  `user` varchar(12) NOT NULL default '',
  PRIMARY KEY  (`account_id`),
  KEY `client_id` (`client_id`),
  KEY `package_id` (`package_id`),
  KEY `device_id` (`device_id`),
  KEY `domain` (`domain`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--


/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
LOCK TABLES `accounts` WRITE;
INSERT INTO `accounts` VALUES (20031545,1,394,0,1153611623,'2006-07-22','2006-08-22','0','0.00','P','testdomain.tld','');
UNLOCK TABLES;
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;

--
-- Table structure for table `accounts_log`
--

DROP TABLE IF EXISTS `accounts_log`;
CREATE TABLE `accounts_log` (
  `log_id` int(8) unsigned NOT NULL auto_increment,
  `staff_id` int(8) unsigned NOT NULL default '0',
  `account_id` int(8) NOT NULL default '0',
  `action` enum('add','cancel','edit','suspend','unsuspend','move','restore','syslog') NOT NULL default 'add',
  `comments` text NOT NULL,
  `date` date NOT NULL default '0000-00-00',
  `time` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`log_id`),
  KEY `tech_id` (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts_log`
--


/*!40000 ALTER TABLE `accounts_log` DISABLE KEYS */;
LOCK TABLES `accounts_log` WRITE;
INSERT INTO `accounts_log` VALUES (2719,1,20031545,'add','Joshua Abbott created testdomain.tld and has invoiced the account. including the setup fee.','2006-07-22','18:40:23');
UNLOCK TABLES;
/*!40000 ALTER TABLE `accounts_log` ENABLE KEYS */;

--
-- Table structure for table `affiliates`
--

DROP TABLE IF EXISTS `affiliates`;
CREATE TABLE `affiliates` (
  `campaign_id` int(8) unsigned NOT NULL auto_increment,
  `client_id` int(8) unsigned NOT NULL default '0',
  `name` varchar(100) default NULL,
  `status` enum('1','0') default '1',
  `notes` mediumtext,
  `date` date NOT NULL default '0000-00-00',
  `timestamp` int(50) NOT NULL default '0',
  `key` varchar(50) NOT NULL default '',
  `clicks` int(25) NOT NULL default '0',
  KEY `campaign_id` (`campaign_id`),
  KEY `client_id` (`client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `affiliates`
--


/*!40000 ALTER TABLE `affiliates` DISABLE KEYS */;
LOCK TABLES `affiliates` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `affiliates` ENABLE KEYS */;

--
-- Table structure for table `backup`
--

DROP TABLE IF EXISTS `backup`;
CREATE TABLE `backup` (
  `device_id` int(8) unsigned NOT NULL default '0',
  `location_id` int(8) unsigned NOT NULL default '0',
  `hour` tinyint(2) unsigned NOT NULL default '0',
  `minute` tinyint(2) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `backup`
--


/*!40000 ALTER TABLE `backup` DISABLE KEYS */;
LOCK TABLES `backup` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `backup` ENABLE KEYS */;

--
-- Table structure for table `backup_location`
--

DROP TABLE IF EXISTS `backup_location`;
CREATE TABLE `backup_location` (
  `backup_location_id` int(8) unsigned NOT NULL default '0',
  `device_id` int(8) unsigned NOT NULL default '0',
  `backup_filesystem` varchar(128) NOT NULL default '',
  `location_id` int(8) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `backup_location`
--


/*!40000 ALTER TABLE `backup_location` DISABLE KEYS */;
LOCK TABLES `backup_location` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `backup_location` ENABLE KEYS */;

--
-- Table structure for table `calendar_events`
--

DROP TABLE IF EXISTS `calendar_events`;
CREATE TABLE `calendar_events` (
  `event_id` int(5) unsigned NOT NULL auto_increment,
  `event_day` int(2) NOT NULL default '0',
  `event_month` int(2) NOT NULL default '0',
  `event_year` int(4) NOT NULL default '0',
  `event_time` varchar(5) NOT NULL default '',
  `event_title` varchar(100) NOT NULL default '',
  `event_desc` text NOT NULL,
  PRIMARY KEY  (`event_id`),
  KEY `event_year` (`event_year`),
  KEY `event_month` (`event_month`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `calendar_events`
--


/*!40000 ALTER TABLE `calendar_events` DISABLE KEYS */;
LOCK TABLES `calendar_events` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `calendar_events` ENABLE KEYS */;

--
-- Table structure for table `calendar_msg`
--

DROP TABLE IF EXISTS `calendar_msg`;
CREATE TABLE `calendar_msg` (
  `msg_id` int(8) unsigned NOT NULL auto_increment,
  `user_id` int(8) unsigned NOT NULL default '0',
  `m` tinyint(2) NOT NULL default '0',
  `d` tinyint(2) NOT NULL default '0',
  `y` int(4) NOT NULL default '0',
  `start_time` time NOT NULL default '00:00:00',
  `end_time` time NOT NULL default '00:00:00',
  `title` varchar(50) NOT NULL default '',
  `text` text NOT NULL,
  PRIMARY KEY  (`msg_id`),
  KEY `id` (`msg_id`),
  KEY `m` (`m`),
  KEY `y` (`y`),
  KEY `uid` (`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `calendar_msg`
--


/*!40000 ALTER TABLE `calendar_msg` DISABLE KEYS */;
LOCK TABLES `calendar_msg` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `calendar_msg` ENABLE KEYS */;

--
-- Table structure for table `cc_authnet_codes`
--

DROP TABLE IF EXISTS `cc_authnet_codes`;
CREATE TABLE `cc_authnet_codes` (
  `response` int(1) NOT NULL default '0',
  `reason` int(3) NOT NULL default '0',
  `res_rea_text` varchar(255) NOT NULL default '',
  `notes` varchar(255) NOT NULL default '',
  KEY `reason` (`reason`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cc_authnet_codes`
--


/*!40000 ALTER TABLE `cc_authnet_codes` DISABLE KEYS */;
LOCK TABLES `cc_authnet_codes` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `cc_authnet_codes` ENABLE KEYS */;

--
-- Table structure for table `client_notes`
--

DROP TABLE IF EXISTS `client_notes`;
CREATE TABLE `client_notes` (
  `note_id` int(8) unsigned NOT NULL auto_increment,
  `client_id` int(8) unsigned NOT NULL default '0',
  `staff_id` int(8) NOT NULL default '0',
  `type` enum('staff','system','user') NOT NULL default 'staff',
  `comments` text NOT NULL,
  `date` date NOT NULL default '0000-00-00',
  `time` varchar(20) NOT NULL default '',
  `stick` enum('1','0') NOT NULL default '0',
  PRIMARY KEY  (`note_id`),
  KEY `client_id` (`client_id`),
  KEY `type` (`type`),
  FULLTEXT KEY `comments` (`comments`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_notes`
--


/*!40000 ALTER TABLE `client_notes` DISABLE KEYS */;
LOCK TABLES `client_notes` WRITE;
INSERT INTO `client_notes` VALUES (10640,1,1,'staff','Joshua Abbott has updated this user information for userid 1 - : active changed from  to 1 :','2006-07-22','17:59:26','0'),(10641,1,1,'staff','Joshua Abbott has updated this Clients information - : country changed from Demo Country  to  :: billingtype changed from   to 31 :: cc_number changed from   to 1000000000000001 :: cc_year changed from   to 20 :','2006-07-22','18:00:14','0'),(10642,1,1,'staff','Joshua Abbott has updated this Clients information - : cc_number changed from 1000000000000001  to {(.„(âïm±”k­%f :','2006-07-23','19:09:49','0');
UNLOCK TABLES;
/*!40000 ALTER TABLE `client_notes` ENABLE KEYS */;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `client_id` int(8) unsigned NOT NULL auto_increment,
  `company` varchar(100) default NULL,
  `address` varchar(125) default NULL,
  `city` varchar(75) default NULL,
  `state` varchar(50) default NULL,
  `zip` varchar(20) default NULL,
  `country` varchar(100) default NULL,
  `phone` varchar(35) default NULL,
  `alt_phone` varchar(35) NOT NULL default '',
  `fax` varchar(25) default NULL,
  `email1` varchar(75) NOT NULL default '',
  `email2` varchar(75) NOT NULL default '',
  `email1_updates` enum('0','1') NOT NULL default '1',
  `email2_updates` enum('0','1') NOT NULL default '1',
  `billingtype` varchar(20) NOT NULL default '',
  `cc_name` varchar(100) NOT NULL default '',
  `cc_number` varchar(255) default NULL,
  `cc_month` enum('01','02','03','04','05','06','07','08','09','10','11','12') default '01',
  `cc_year` char(2) default NULL,
  `cc_bank` varchar(75) NOT NULL default '',
  `cc_bank_phone` varchar(25) NOT NULL default '',
  `funds` decimal(10,2) NOT NULL default '0.00',
  `discount` varchar(4) NOT NULL default '',
  `due_date_override` enum('0','1') NOT NULL default '0',
  `due_date` enum('01','02','03','04','05','10','15','20','25','26','27','28') NOT NULL default '01',
  `start_date` date NOT NULL default '0000-00-00',
  `timestamp` int(20) NOT NULL default '0',
  `status` enum('A','P','S','C','F') NOT NULL default 'A',
  PRIMARY KEY  (`client_id`),
  KEY `email` (`email1`,`email2`),
  KEY `company` (`company`),
  KEY `status` (`status`),
  FULLTEXT KEY `address` (`address`,`city`,`state`,`country`,`zip`),
  FULLTEXT KEY `phone` (`phone`,`alt_phone`),
  FULLTEXT KEY `mail` (`email1`,`email2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--


/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
LOCK TABLES `clients` WRITE;
INSERT INTO `clients` VALUES (1,'Demo Company','Demo Address','Demo City','Demo State','Demo Zip','','5555555555','4444444444','3333333333','email@domain.tld','email2@domain2.tld','1','1','31','','{(.„(âïm±”k­%f','01','20','','','0.00','','0','01','0000-00-00',0,'A');
UNLOCK TABLES;
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;

--
-- Table structure for table `clients_cclog`
--

DROP TABLE IF EXISTS `clients_cclog`;
CREATE TABLE `clients_cclog` (
  `cclog_id` int(8) NOT NULL auto_increment,
  `client_id` int(8) NOT NULL default '0',
  `cc_name` varchar(100) NOT NULL default '',
  `cc_number` varchar(255) NOT NULL default '',
  `cc_month` enum('01','02','03','04','05','06','07','08','09','10','11','12') NOT NULL default '01',
  `cc_year` char(2) NOT NULL default '',
  `cc_bank` varchar(75) NOT NULL default '',
  `cc_bank_phone` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`cclog_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients_cclog`
--


/*!40000 ALTER TABLE `clients_cclog` DISABLE KEYS */;
LOCK TABLES `clients_cclog` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `clients_cclog` ENABLE KEYS */;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
CREATE TABLE `coupons` (
  `coupon_id` int(15) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `percent_off` decimal(10,2) NOT NULL default '0.00',
  `amount_off` decimal(10,2) NOT NULL default '0.00',
  `setprice` decimal(10,2) NOT NULL default '0.00',
  `quantity` int(15) NOT NULL default '0',
  `redeemed` int(15) NOT NULL default '0',
  `start_date` date NOT NULL default '0000-00-00',
  `end_date` date NOT NULL default '0000-00-00',
  `new_only` enum('Y','N') NOT NULL default 'Y',
  `suspended` enum('Y','N') NOT NULL default 'N',
  `order_type` int(4) NOT NULL default '0',
  PRIMARY KEY  (`coupon_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupons`
--


/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
LOCK TABLES `coupons` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;

--
-- Table structure for table `faq`
--

DROP TABLE IF EXISTS `faq`;
CREATE TABLE `faq` (
  `faq_id` int(10) NOT NULL auto_increment,
  `cat_id` tinyint(10) NOT NULL default '0',
  `question` tinytext NOT NULL,
  `answer` mediumtext NOT NULL,
  `anon` char(1) NOT NULL default 'Y',
  `on` enum('0','1') NOT NULL default '0',
  `time` varchar(20) default NULL,
  `date` date NOT NULL default '0000-00-00',
  `updated` date NOT NULL default '0000-00-00',
  `views` varchar(15) NOT NULL default '0',
  PRIMARY KEY  (`faq_id`),
  KEY `category` (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faq`
--


/*!40000 ALTER TABLE `faq` DISABLE KEYS */;
LOCK TABLES `faq` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `faq` ENABLE KEYS */;

--
-- Table structure for table `faq_cat`
--

DROP TABLE IF EXISTS `faq_cat`;
CREATE TABLE `faq_cat` (
  `faq_cat_id` int(15) NOT NULL auto_increment,
  `category` varchar(100) NOT NULL default '',
  `order` char(3) NOT NULL default '',
  PRIMARY KEY  (`faq_cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faq_cat`
--


/*!40000 ALTER TABLE `faq_cat` DISABLE KEYS */;
LOCK TABLES `faq_cat` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `faq_cat` ENABLE KEYS */;

--
-- Table structure for table `faq_guides`
--

DROP TABLE IF EXISTS `faq_guides`;
CREATE TABLE `faq_guides` (
  `faq_guide_id` int(8) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `file` varchar(100) NOT NULL default '',
  `order` char(3) NOT NULL default '',
  PRIMARY KEY  (`faq_guide_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faq_guides`
--


/*!40000 ALTER TABLE `faq_guides` DISABLE KEYS */;
LOCK TABLES `faq_guides` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `faq_guides` ENABLE KEYS */;

--
-- Table structure for table `geolocation`
--

DROP TABLE IF EXISTS `geolocation`;
CREATE TABLE `geolocation` (
  `geoloc_id` int(8) unsigned NOT NULL auto_increment,
  `nickname` varchar(100) default NULL,
  `address` varchar(255) default NULL,
  `country` varchar(100) default NULL,
  `contact` varchar(50) default NULL,
  `alt_contact` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`geoloc_id`),
  KEY `company` (`nickname`),
  FULLTEXT KEY `address` (`address`,`country`),
  FULLTEXT KEY `phone` (`contact`,`alt_contact`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `geolocation`
--


/*!40000 ALTER TABLE `geolocation` DISABLE KEYS */;
LOCK TABLES `geolocation` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `geolocation` ENABLE KEYS */;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE `invoices` (
  `invoice_id` int(8) unsigned NOT NULL auto_increment,
  `client_id` int(8) unsigned NOT NULL default '0',
  `account_id` int(8) unsigned NOT NULL default '0',
  `description` varchar(255) NOT NULL default '',
  `details` mediumtext NOT NULL,
  `amount` decimal(10,2) NOT NULL default '0.00',
  `billingtype` varchar(20) NOT NULL default '',
  `date_created` date NOT NULL default '0000-00-00',
  `date_paid` date default NULL,
  `time_created` varchar(20) NOT NULL default '0',
  `time_paid` varchar(20) default NULL,
  `status` enum('due','paid','fail','ref','void') NOT NULL default 'due',
  `deleted` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`invoice_id`),
  KEY `client_id` (`client_id`),
  KEY `account_id` (`account_id`),
  KEY `status` (`status`),
  FULLTEXT KEY `description` (`description`,`details`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoices`
--


/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
LOCK TABLES `invoices` WRITE;
INSERT INTO `invoices` VALUES (20172782,1,20031545,'Test - testdomain.tld','Test Package','0.00','31','2006-07-22',NULL,'18:40:23',NULL,'due','0'),(20172781,1,20031545,'na','0na','0.00','31','2006-07-21',NULL,'18:40:23',NULL,'fail','0'),(20172783,0,0,'','','0.00','','0000-00-00',NULL,'0',NULL,'due','0'),(20172780,1,20031545,'na','na','0.00','31','2006-07-21',NULL,'18:40:23',NULL,'ref','0');
UNLOCK TABLES;
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;

--
-- Table structure for table `invoices_log`
--

DROP TABLE IF EXISTS `invoices_log`;
CREATE TABLE `invoices_log` (
  `log_id` int(8) unsigned NOT NULL auto_increment,
  `staff_id` int(8) unsigned NOT NULL default '0',
  `invoice_id` int(8) NOT NULL default '0',
  `action` enum('add','delete','edit','process','restore') NOT NULL default 'add',
  `comments` text NOT NULL,
  `date` date NOT NULL default '0000-00-00',
  `time` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`log_id`),
  KEY `tech_id` (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoices_log`
--


/*!40000 ALTER TABLE `invoices_log` DISABLE KEYS */;
LOCK TABLES `invoices_log` WRITE;
INSERT INTO `invoices_log` VALUES (22552,1,20172782,'edit','Joshua Abbott has updated this account - : amount changed from 10.00 to 0.00 :','2006-07-23','20:37:23');
UNLOCK TABLES;
/*!40000 ALTER TABLE `invoices_log` ENABLE KEYS */;

--
-- Table structure for table `ip_deny`
--

DROP TABLE IF EXISTS `ip_deny`;
CREATE TABLE `ip_deny` (
  `denyid` int(8) unsigned NOT NULL auto_increment,
  `ip_oct1` smallint(3) unsigned NOT NULL default '0',
  `ip_oct2` smallint(3) unsigned NOT NULL default '0',
  `ip_oct3` smallint(3) unsigned NOT NULL default '0',
  `ip_oct4` smallint(3) unsigned NOT NULL default '0',
  `note` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`denyid`),
  KEY `ip_oct1` (`ip_oct1`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ip_deny`
--


/*!40000 ALTER TABLE `ip_deny` DISABLE KEYS */;
LOCK TABLES `ip_deny` WRITE;
INSERT INTO `ip_deny` VALUES (366,127,0,0,1,'');
UNLOCK TABLES;
/*!40000 ALTER TABLE `ip_deny` ENABLE KEYS */;

--
-- Table structure for table `ips`
--

DROP TABLE IF EXISTS `ips`;
CREATE TABLE `ips` (
  `ipid` int(10) NOT NULL auto_increment,
  `ip_oct1` smallint(3) NOT NULL default '0',
  `ip_oct2` smallint(3) NOT NULL default '0',
  `ip_oct3` smallint(3) NOT NULL default '0',
  `ip_oct4` smallint(3) NOT NULL default '0',
  `device_id` int(15) NOT NULL default '0',
  `vlan` varchar(25) NOT NULL default '',
  `gateway` varchar(20) NOT NULL default '',
  `broadcast` varchar(20) NOT NULL default '',
  `netmask` varchar(20) NOT NULL default '255.255.255.0',
  `usable` enum('Y','N') NOT NULL default 'Y',
  `nameserver` enum('Y','N') NOT NULL default 'N',
  `main` enum('Y','N') NOT NULL default 'N',
  `justification` varchar(255) NOT NULL default '',
  `comments` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`ipid`),
  KEY `device_id` (`device_id`),
  KEY `vlan` (`vlan`),
  KEY `justification` (`justification`),
  KEY `ip_oct3` (`ip_oct3`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ips`
--


/*!40000 ALTER TABLE `ips` DISABLE KEYS */;
LOCK TABLES `ips` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `ips` ENABLE KEYS */;

--
-- Table structure for table `lookup`
--

DROP TABLE IF EXISTS `lookup`;
CREATE TABLE `lookup` (
  `ipfrom` int(15) NOT NULL default '0',
  `ipto` int(15) NOT NULL default '0',
  `code` char(2) NOT NULL default '',
  `3code` char(3) NOT NULL default '',
  `name` varchar(75) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lookup`
--


/*!40000 ALTER TABLE `lookup` DISABLE KEYS */;
LOCK TABLES `lookup` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `lookup` ENABLE KEYS */;

--
-- Table structure for table `mass_mailings`
--

DROP TABLE IF EXISTS `mass_mailings`;
CREATE TABLE `mass_mailings` (
  `mail_id` int(8) NOT NULL auto_increment,
  `staff_id` int(8) NOT NULL default '0',
  `type` enum('letter','maint') NOT NULL default 'letter',
  `sender` int(8) NOT NULL default '0',
  `date_created` date NOT NULL default '0000-00-00',
  `subject` varchar(255) NOT NULL default '',
  `body` text NOT NULL,
  PRIMARY KEY  (`mail_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mass_mailings`
--


/*!40000 ALTER TABLE `mass_mailings` DISABLE KEYS */;
LOCK TABLES `mass_mailings` WRITE;
INSERT INTO `mass_mailings` VALUES (66,1,'maint',0,'2006-07-23','Maintenance Notice - Sunday 23rd 2006f July 2006','Test Notice');
UNLOCK TABLES;
/*!40000 ALTER TABLE `mass_mailings` ENABLE KEYS */;

--
-- Table structure for table `mass_mailings_log`
--

DROP TABLE IF EXISTS `mass_mailings_log`;
CREATE TABLE `mass_mailings_log` (
  `id` int(8) NOT NULL auto_increment,
  `mail_id` int(8) NOT NULL default '0',
  `staff_id` int(8) NOT NULL default '0',
  `date` date NOT NULL default '0000-00-00',
  `time` varchar(20) NOT NULL default '',
  `count` int(8) NOT NULL default '0',
  `target` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mass_mailings_log`
--


/*!40000 ALTER TABLE `mass_mailings_log` DISABLE KEYS */;
LOCK TABLES `mass_mailings_log` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `mass_mailings_log` ENABLE KEYS */;

--
-- Table structure for table `monitor_groups`
--

DROP TABLE IF EXISTS `monitor_groups`;
CREATE TABLE `monitor_groups` (
  `id` int(8) NOT NULL auto_increment,
  `description` varchar(255) NOT NULL default '',
  `port_ids` varchar(100) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `monitor_groups`
--


/*!40000 ALTER TABLE `monitor_groups` DISABLE KEYS */;
LOCK TABLES `monitor_groups` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `monitor_groups` ENABLE KEYS */;

--
-- Table structure for table `monitor_log`
--

DROP TABLE IF EXISTS `monitor_log`;
CREATE TABLE `monitor_log` (
  `inv_id` int(8) NOT NULL default '0',
  `mgroup_id` int(8) NOT NULL default '0',
  `response` varchar(100) NOT NULL default '',
  `timestamp` varchar(20) default NULL,
  `uptime` varchar(100) NOT NULL default '',
  `load` varchar(100) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `monitor_log`
--


/*!40000 ALTER TABLE `monitor_log` DISABLE KEYS */;
LOCK TABLES `monitor_log` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `monitor_log` ENABLE KEYS */;

--
-- Table structure for table `monitor_service`
--

DROP TABLE IF EXISTS `monitor_service`;
CREATE TABLE `monitor_service` (
  `id` int(8) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `port` int(6) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `monitor_service`
--


/*!40000 ALTER TABLE `monitor_service` DISABLE KEYS */;
LOCK TABLES `monitor_service` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `monitor_service` ENABLE KEYS */;

--
-- Table structure for table `mrtg_log`
--

DROP TABLE IF EXISTS `mrtg_log`;
CREATE TABLE `mrtg_log` (
  `id` int(255) unsigned NOT NULL auto_increment,
  `item` bigint(255) unsigned NOT NULL default '0',
  `date` int(255) unsigned NOT NULL default '0',
  `avgin` int(255) unsigned NOT NULL default '0',
  `avgout` int(255) unsigned NOT NULL default '0',
  `peakin` int(255) unsigned NOT NULL default '0',
  `peakout` int(255) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `limiter` (`date`,`item`),
  KEY `date` (`date`),
  KEY `item` (`item`),
  KEY `avgout` (`avgout`),
  KEY `avgin` (`avgin`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mrtg_log`
--


/*!40000 ALTER TABLE `mrtg_log` DISABLE KEYS */;
LOCK TABLES `mrtg_log` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `mrtg_log` ENABLE KEYS */;

--
-- Table structure for table `mrtg_targets`
--

DROP TABLE IF EXISTS `mrtg_targets`;
CREATE TABLE `mrtg_targets` (
  `itemid` bigint(8) unsigned NOT NULL auto_increment,
  `accountid` int(15) NOT NULL default '0',
  `description` varchar(60) default NULL,
  `object` varchar(60) default NULL,
  `active` enum('Y','N') NOT NULL default 'Y',
  `serverid` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`itemid`),
  UNIQUE KEY `object` (`object`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mrtg_targets`
--


/*!40000 ALTER TABLE `mrtg_targets` DISABLE KEYS */;
LOCK TABLES `mrtg_targets` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `mrtg_targets` ENABLE KEYS */;

--
-- Table structure for table `network_device_log`
--

DROP TABLE IF EXISTS `network_device_log`;
CREATE TABLE `network_device_log` (
  `log_id` int(8) unsigned NOT NULL auto_increment,
  `staff_id` int(8) unsigned NOT NULL default '0',
  `device_id` int(8) NOT NULL default '0',
  `action` enum('add','delete','edit') NOT NULL default 'add',
  `comments` text NOT NULL,
  `date` date NOT NULL default '0000-00-00',
  `time` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`log_id`),
  KEY `tech_id` (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `network_device_log`
--


/*!40000 ALTER TABLE `network_device_log` DISABLE KEYS */;
LOCK TABLES `network_device_log` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `network_device_log` ENABLE KEYS */;

--
-- Table structure for table `network_devices`
--

DROP TABLE IF EXISTS `network_devices`;
CREATE TABLE `network_devices` (
  `device_id` int(8) unsigned NOT NULL auto_increment,
  `inventory_id` int(8) unsigned NOT NULL default '0',
  `account_id` int(8) unsigned NOT NULL default '0',
  `type` smallint(10) NOT NULL default '0',
  `monitor` int(8) NOT NULL default '0',
  `community` varchar(25) NOT NULL default '0',
  `mrtg_offset` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`device_id`),
  UNIQUE KEY `inventory_id` (`inventory_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `network_devices`
--


/*!40000 ALTER TABLE `network_devices` DISABLE KEYS */;
LOCK TABLES `network_devices` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `network_devices` ENABLE KEYS */;

--
-- Table structure for table `network_inventory`
--

DROP TABLE IF EXISTS `network_inventory`;
CREATE TABLE `network_inventory` (
  `inventory_id` int(8) unsigned NOT NULL auto_increment,
  `type` int(8) unsigned NOT NULL default '0',
  `location_id` int(8) unsigned NOT NULL default '0',
  `serialnum` varchar(100) NOT NULL default '',
  `inventorylabel` varchar(150) NOT NULL default '',
  `model` varchar(255) NOT NULL default '',
  `description` tinytext NOT NULL,
  `specs` text NOT NULL,
  `size` enum('1U','2U','3U','4U','tower','other') NOT NULL default '1U',
  PRIMARY KEY  (`inventory_id`),
  KEY `type` (`type`),
  KEY `inventorylabel` (`inventorylabel`),
  KEY `location_id` (`location_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `network_inventory`
--


/*!40000 ALTER TABLE `network_inventory` DISABLE KEYS */;
LOCK TABLES `network_inventory` WRITE;
INSERT INTO `network_inventory` VALUES (1,0,1,'NONE','NONE','NONE','NONE','NONE','');
UNLOCK TABLES;
/*!40000 ALTER TABLE `network_inventory` ENABLE KEYS */;

--
-- Table structure for table `network_locations`
--

DROP TABLE IF EXISTS `network_locations`;
CREATE TABLE `network_locations` (
  `location_id` int(8) unsigned NOT NULL auto_increment,
  `capacity` char(3) NOT NULL default '',
  `location` varchar(50) NOT NULL default '',
  `name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`location_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `network_locations`
--


/*!40000 ALTER TABLE `network_locations` DISABLE KEYS */;
LOCK TABLES `network_locations` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `network_locations` ENABLE KEYS */;

--
-- Table structure for table `network_servers`
--

DROP TABLE IF EXISTS `network_servers`;
CREATE TABLE `network_servers` (
  `device_id` int(8) unsigned NOT NULL auto_increment,
  `inventory_id` int(8) unsigned NOT NULL default '0',
  `account_id` int(8) unsigned NOT NULL default '0',
  `type` smallint(10) NOT NULL default '0',
  `new_setup` varchar(5) NOT NULL default '0',
  `os` varchar(20) NOT NULL default '',
  `cp` varchar(20) NOT NULL default '',
  `managed` enum('Y','N') NOT NULL default 'N',
  `monitor` int(8) NOT NULL default '0',
  `monitor_public` enum('Y','N') NOT NULL default 'N',
  `ssl` varchar(100) NOT NULL default '',
  `remote_key` mediumtext NOT NULL,
  `backups` varchar(100) NOT NULL default '',
  `backup_files` varchar(25) NOT NULL default '',
  `backup_hour` char(3) NOT NULL default '',
  `backup_minute` char(3) NOT NULL default '',
  `switch_id` int(15) NOT NULL default '0',
  `switch_port` char(3) NOT NULL default '0',
  `community` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`device_id`),
  KEY `inventory_id` (`inventory_id`),
  KEY `type` (`type`),
  KEY `switch_id` (`switch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `network_servers`
--


/*!40000 ALTER TABLE `network_servers` DISABLE KEYS */;
LOCK TABLES `network_servers` WRITE;
INSERT INTO `network_servers` VALUES (1,1,1,1,'1','CentOS 4.3','NONE','Y',1,'Y','','','','','','',0,'0','');
UNLOCK TABLES;
/*!40000 ALTER TABLE `network_servers` ENABLE KEYS */;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `news_id` int(10) unsigned NOT NULL auto_increment,
  `date` date NOT NULL default '0000-00-00',
  `subject` varchar(30) NOT NULL default '',
  `news` mediumtext NOT NULL,
  `type` enum('site','support') NOT NULL default 'site',
  `ref` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`news_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--


/*!40000 ALTER TABLE `news` DISABLE KEYS */;
LOCK TABLES `news` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `order_id` int(8) unsigned NOT NULL auto_increment,
  `client_id` int(8) unsigned NOT NULL default '0',
  `account_id` int(8) NOT NULL default '0',
  `package_id` int(8) unsigned NOT NULL default '0',
  `order_num` varchar(100) NOT NULL default '',
  `description` varchar(75) NOT NULL default '',
  `referer_ip` varchar(25) NOT NULL default '',
  `hostname` varchar(100) NOT NULL default '',
  `server` varchar(100) default NULL,
  `username` varchar(25) default NULL,
  `password` varchar(100) default NULL,
  `register` varchar(10) default NULL,
  `first_name` varchar(35) NOT NULL default '',
  `last_name` varchar(35) NOT NULL default '',
  `company` varchar(100) default NULL,
  `address` varchar(125) NOT NULL default '',
  `city` varchar(75) NOT NULL default '',
  `state` varchar(100) NOT NULL default '',
  `zip` varchar(20) NOT NULL default '',
  `country` varchar(150) NOT NULL default '',
  `email1` varchar(75) NOT NULL default '',
  `email2` varchar(75) NOT NULL default '',
  `phone` varchar(35) NOT NULL default '',
  `fax` varchar(35) NOT NULL default '',
  `billingtype` varchar(25) NOT NULL default '',
  `cc_name` varchar(100) NOT NULL default '',
  `cc_bank` varchar(100) NOT NULL default '',
  `cc_bank_phone` varchar(50) NOT NULL default '',
  `cc_number` varchar(150) NOT NULL default '',
  `cc_month` enum('01','02','03','04','05','06','07','08','09','10','11','12') NOT NULL default '01',
  `cc_year` char(2) NOT NULL default '',
  `status` enum('pending','pending-due','pending-failed','approved','completed','cancelled','fraud') NOT NULL default 'pending',
  `campaign_id` int(15) NOT NULL default '0',
  `commission` varchar(10) NOT NULL default '',
  `commission_status` enum('n/a','pending','paid') NOT NULL default 'n/a',
  `referer` varchar(255) NOT NULL default '',
  `comments` varchar(255) NOT NULL default '',
  `date` date NOT NULL default '0000-00-00',
  `timestamp` varchar(20) NOT NULL default '',
  `addons` varchar(64) NOT NULL default '',
  `coupon` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`order_id`),
  KEY `order_num` (`order_num`),
  KEY `hostname` (`hostname`),
  KEY `name` (`first_name`,`last_name`),
  KEY `status` (`status`),
  FULLTEXT KEY `order_num_2` (`order_num`,`description`,`hostname`,`username`),
  FULLTEXT KEY `first_name` (`first_name`,`last_name`,`company`),
  FULLTEXT KEY `email1` (`email1`,`email2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--


/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
LOCK TABLES `orders` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

--
-- Table structure for table `packages`
--

DROP TABLE IF EXISTS `packages`;
CREATE TABLE `packages` (
  `package_id` int(8) unsigned NOT NULL auto_increment,
  `name` varchar(150) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `price` decimal(10,2) NOT NULL default '0.00',
  `setupfee` decimal(10,2) NOT NULL default '0.00',
  `upgradefee` decimal(10,2) NOT NULL default '0.00',
  `qty` int(8) NOT NULL default '0',
  `term` int(5) NOT NULL default '0',
  `quota` int(10) NOT NULL default '0',
  `ip` enum('Y','N') NOT NULL default 'N',
  `cgi` enum('Y','N') NOT NULL default 'Y',
  `shell` enum('Y','N') NOT NULL default 'N',
  `frontpage` varchar(5) NOT NULL default '',
  `max_ftp` varchar(5) NOT NULL default '0',
  `max_email` varchar(5) NOT NULL default '0',
  `max_lists` varchar(5) NOT NULL default '0',
  `max_sql` varchar(5) NOT NULL default '0',
  `max_subs` varchar(5) NOT NULL default '0',
  `max_parked` varchar(5) NOT NULL default '0',
  `max_pointed` varchar(5) NOT NULL default '0',
  `bwlimit` varchar(10) NOT NULL default '',
  `theme` varchar(100) NOT NULL default '',
  `cp` varchar(100) NOT NULL default '',
  `cp_pkgname` varchar(100) NOT NULL default '',
  `active` enum('0','1') NOT NULL default '0',
  `type` int(8) NOT NULL default '0',
  PRIMARY KEY  (`package_id`),
  KEY `name` (`name`),
  FULLTEXT KEY `description` (`description`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `packages`
--


/*!40000 ALTER TABLE `packages` DISABLE KEYS */;
LOCK TABLES `packages` WRITE;
INSERT INTO `packages` VALUES (394,'Test','Test Package','0.00','10.00','0.00',0,1,0,'N','N','N','N','0','1','0','0','0','0','0','0','x','39','Test','0',3);
UNLOCK TABLES;
/*!40000 ALTER TABLE `packages` ENABLE KEYS */;

--
-- Table structure for table `packages_addons`
--

DROP TABLE IF EXISTS `packages_addons`;
CREATE TABLE `packages_addons` (
  `id` mediumint(255) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `price` varchar(255) NOT NULL default '',
  `setup_fee` varchar(128) NOT NULL default '0.00',
  `category` enum('Bandwidth','RAM','CPU','IP','ControlPanel','DiskSpace','RackSpace','BackupSpace','Other') NOT NULL default 'Bandwidth',
  `type` enum('general','shared','vps','dedicated','colocation') NOT NULL default 'general',
  `active` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `packages_addons`
--


/*!40000 ALTER TABLE `packages_addons` DISABLE KEYS */;
LOCK TABLES `packages_addons` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `packages_addons` ENABLE KEYS */;

--
-- Table structure for table `projects_assignments`
--

DROP TABLE IF EXISTS `projects_assignments`;
CREATE TABLE `projects_assignments` (
  `project_id` int(8) NOT NULL default '0',
  `staff_id` int(8) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects_assignments`
--


/*!40000 ALTER TABLE `projects_assignments` DISABLE KEYS */;
LOCK TABLES `projects_assignments` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `projects_assignments` ENABLE KEYS */;

--
-- Table structure for table `projects_cat`
--

DROP TABLE IF EXISTS `projects_cat`;
CREATE TABLE `projects_cat` (
  `cat_id` int(8) NOT NULL auto_increment,
  `project_id` int(8) NOT NULL default '1',
  `name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects_cat`
--


/*!40000 ALTER TABLE `projects_cat` DISABLE KEYS */;
LOCK TABLES `projects_cat` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `projects_cat` ENABLE KEYS */;

--
-- Table structure for table `projects_files`
--

DROP TABLE IF EXISTS `projects_files`;
CREATE TABLE `projects_files` (
  `file_id` int(10) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `type` varchar(30) NOT NULL default '',
  `size` int(11) NOT NULL default '0',
  `file` mediumblob NOT NULL,
  PRIMARY KEY  (`file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects_files`
--


/*!40000 ALTER TABLE `projects_files` DISABLE KEYS */;
LOCK TABLES `projects_files` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `projects_files` ENABLE KEYS */;

--
-- Table structure for table `projects_list`
--

DROP TABLE IF EXISTS `projects_list`;
CREATE TABLE `projects_list` (
  `project_id` int(8) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `desc` varchar(255) NOT NULL default '',
  `createdby` int(8) NOT NULL default '0',
  `date` date NOT NULL default '0000-00-00',
  `time` varchar(50) NOT NULL default '',
  `active` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`project_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects_list`
--


/*!40000 ALTER TABLE `projects_list` DISABLE KEYS */;
LOCK TABLES `projects_list` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `projects_list` ENABLE KEYS */;

--
-- Table structure for table `projects_log`
--

DROP TABLE IF EXISTS `projects_log`;
CREATE TABLE `projects_log` (
  `log_id` int(8) unsigned NOT NULL auto_increment,
  `staff_id` int(8) unsigned NOT NULL default '0',
  `task_id` int(10) NOT NULL default '0',
  `action` varchar(255) NOT NULL default '',
  `date` date NOT NULL default '0000-00-00',
  `time` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`log_id`),
  KEY `tech_id` (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects_log`
--


/*!40000 ALTER TABLE `projects_log` DISABLE KEYS */;
LOCK TABLES `projects_log` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `projects_log` ENABLE KEYS */;

--
-- Table structure for table `projects_notes`
--

DROP TABLE IF EXISTS `projects_notes`;
CREATE TABLE `projects_notes` (
  `note_id` int(8) unsigned NOT NULL auto_increment,
  `task_id` int(8) unsigned NOT NULL default '0',
  `staff_id` int(8) NOT NULL default '0',
  `comments` text NOT NULL,
  `file_id` int(10) NOT NULL default '0',
  `date` date NOT NULL default '0000-00-00',
  `time` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`note_id`),
  KEY `client_id` (`task_id`),
  FULLTEXT KEY `comments` (`comments`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects_notes`
--


/*!40000 ALTER TABLE `projects_notes` DISABLE KEYS */;
LOCK TABLES `projects_notes` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `projects_notes` ENABLE KEYS */;

--
-- Table structure for table `projects_notices`
--

DROP TABLE IF EXISTS `projects_notices`;
CREATE TABLE `projects_notices` (
  `id` int(8) NOT NULL auto_increment,
  `task_id` int(10) NOT NULL default '0',
  `staff_id` int(8) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects_notices`
--


/*!40000 ALTER TABLE `projects_notices` DISABLE KEYS */;
LOCK TABLES `projects_notices` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `projects_notices` ENABLE KEYS */;

--
-- Table structure for table `projects_progresslog`
--

DROP TABLE IF EXISTS `projects_progresslog`;
CREATE TABLE `projects_progresslog` (
  `log_id` int(8) unsigned NOT NULL auto_increment,
  `project_id` int(8) unsigned NOT NULL default '0',
  `ver_id` int(8) NOT NULL default '0',
  `closed_tasks` int(5) NOT NULL default '0',
  `total_tasks` int(5) NOT NULL default '0',
  `date` date NOT NULL default '0000-00-00',
  `time` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`log_id`),
  KEY `tech_id` (`project_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects_progresslog`
--


/*!40000 ALTER TABLE `projects_progresslog` DISABLE KEYS */;
LOCK TABLES `projects_progresslog` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `projects_progresslog` ENABLE KEYS */;

--
-- Table structure for table `projects_tasks`
--

DROP TABLE IF EXISTS `projects_tasks`;
CREATE TABLE `projects_tasks` (
  `task_id` int(10) NOT NULL auto_increment,
  `project_id` int(8) NOT NULL default '1',
  `category` int(8) NOT NULL default '0',
  `subject` varchar(255) NOT NULL default '',
  `description` mediumtext NOT NULL,
  `status` enum('new','assigned','unconfirmed','requires_testing','closed') NOT NULL default 'unconfirmed',
  `type` enum('bug','feature','todo') NOT NULL default 'todo',
  `severity` enum('low','moderate','high','critical') NOT NULL default 'low',
  `assigned` varchar(100) NOT NULL default '',
  `progress` decimal(10,2) NOT NULL default '0.00',
  `date_due` date NOT NULL default '0000-00-00',
  `version_due` int(8) NOT NULL default '0',
  `enteredby` varchar(255) NOT NULL default '',
  `date_entered` date NOT NULL default '0000-00-00',
  `time_entered` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`task_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects_tasks`
--


/*!40000 ALTER TABLE `projects_tasks` DISABLE KEYS */;
LOCK TABLES `projects_tasks` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `projects_tasks` ENABLE KEYS */;

--
-- Table structure for table `projects_ver`
--

DROP TABLE IF EXISTS `projects_ver`;
CREATE TABLE `projects_ver` (
  `ver_id` int(8) NOT NULL auto_increment,
  `project_id` int(8) NOT NULL default '1',
  `version` varchar(50) NOT NULL default '',
  `duedate` date NOT NULL default '0000-00-00',
  `active` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`ver_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects_ver`
--


/*!40000 ALTER TABLE `projects_ver` DISABLE KEYS */;
LOCK TABLES `projects_ver` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `projects_ver` ENABLE KEYS */;

--
-- Table structure for table `revenue_check`
--

DROP TABLE IF EXISTS `revenue_check`;
CREATE TABLE `revenue_check` (
  `check_id` smallint(15) NOT NULL auto_increment,
  `date` date NOT NULL default '0000-00-00',
  `package_id` int(15) NOT NULL default '0',
  `package_term` char(3) NOT NULL default '',
  `package_rate` varchar(10) NOT NULL default '',
  `total` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`check_id`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `revenue_check`
--


/*!40000 ALTER TABLE `revenue_check` DISABLE KEYS */;
LOCK TABLES `revenue_check` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `revenue_check` ENABLE KEYS */;

--
-- Table structure for table `revenue_check_2`
--

DROP TABLE IF EXISTS `revenue_check_2`;
CREATE TABLE `revenue_check_2` (
  `check3_id` smallint(15) NOT NULL auto_increment,
  `date` date NOT NULL default '0000-00-00',
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `package_id` int(15) NOT NULL default '0',
  `date_start` date NOT NULL default '0000-00-00',
  `date_stop` date NOT NULL default '0000-00-00',
  `change` enum('none','loss','gain') NOT NULL default 'loss',
  `quantity` int(15) NOT NULL default '0',
  `revenue` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`check3_id`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `revenue_check_2`
--


/*!40000 ALTER TABLE `revenue_check_2` DISABLE KEYS */;
LOCK TABLES `revenue_check_2` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `revenue_check_2` ENABLE KEYS */;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `sess_id` varchar(32) NOT NULL default '',
  `sess_expire` int(11) NOT NULL default '0',
  `sess_data` text NOT NULL,
  `type` varchar(10) NOT NULL default '',
  `id` int(10) NOT NULL default '0',
  `lasttime` int(11) NOT NULL default '0',
  PRIMARY KEY  (`sess_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sessions`
--


/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
LOCK TABLES `sessions` WRITE;
INSERT INTO `sessions` VALUES ('stitql22thpb1jhltjquimofi0',1754547270,'attempt|i:1;','',0,1154547270);
UNLOCK TABLES;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `setting_id` smallint(5) unsigned NOT NULL auto_increment,
  `group` varchar(25) NOT NULL default '',
  `order` tinyint(3) unsigned NOT NULL default '1',
  `title` varchar(75) NOT NULL default '',
  `name` varchar(50) NOT NULL default '',
  `description` text NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY  (`setting_id`),
  KEY `group` (`group`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--


/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
LOCK TABLES `settings` WRITE;
INSERT INTO `settings` VALUES (87,'',1,'','session_life','','10000000');
UNLOCK TABLES;
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

--
-- Table structure for table `settings_types`
--

DROP TABLE IF EXISTS `settings_types`;
CREATE TABLE `settings_types` (
  `type_id` int(8) unsigned NOT NULL auto_increment,
  `table` varchar(50) NOT NULL default '',
  `name` varchar(50) NOT NULL default '0',
  `description` text NOT NULL,
  `order` tinyint(3) unsigned NOT NULL default '1',
  PRIMARY KEY  (`type_id`),
  KEY `table` (`table`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings_types`
--


/*!40000 ALTER TABLE `settings_types` DISABLE KEYS */;
LOCK TABLES `settings_types` WRITE;
INSERT INTO `settings_types` VALUES (63,'network_devices','semi-dedicated','Semi-dedicated shared hosting',1),(3,'packages','shared','Virtual Shared Hosting',1),(4,'packages','reseller','Managed Reseller',1),(5,'packages','vps','Virtual Private Server',1),(6,'packages','dedicated','Dedicated Server',1),(7,'packages','colo','Colocation',1),(8,'inventory','server','',1),(9,'inventory','switch','',1),(10,'inventory','router','',1),(11,'inventory','firewall','',1),(12,'inventory','ids','',1),(13,'inventory','nas','',1),(14,'inventory','rebootswitch','',1),(15,'inventory','terminal','',1),(16,'inventory','kvm','',1),(17,'inventory','parts','',1),(18,'inventory','workstation','',1),(19,'inventory','other','',1),(20,'network_devices','shared','shared hosting',1),(21,'network_devices','dedicated','Dedicated Server',2),(22,'network_devices','colocation','colocation',3),(23,'transactions','credit_card','Credit Card',1),(24,'transactions','paypal','PayPal',1),(25,'transactions','check','check',1),(26,'transactions','money_order','Money Order',1),(27,'billingtype','credit_card','MasterCard',1),(28,'billingtype','credit_card','Visa',2),(29,'billingtype','credit_card','American Express',3),(30,'billingtype','credit_card','Discover',4),(31,'billingtype','paypal','PayPal',5),(32,'billingtype','check','Check',6),(33,'billingtype','money_order','Money Order',7),(34,'staff','1','Admin',1),(35,'users','1','Client Admin',1),(36,'users','2','Account Admin',2),(38,'packages','resold','resold account of a reseller',1),(39,'control_panel','cpanel','Cpanel',1),(40,'control_panel','interworx','Interworx',2),(41,'staff','2','Management',2),(42,'staff','3','Member',3),(43,'staff','4','Level 3 Admin',4),(44,'staff','5','Tech',5),(64,'packages','semi-dedicated','Semi-Dedicated Server',1),(62,'network_devices','reseller_bulk','bulk reseller node',3),(60,'packages','other','misc - addons',1),(61,'network_devices','vps','virtual private server node',1),(51,'network_devices','other','',5),(52,'control_panel','servergui','ServerGUI',3),(53,'control_panel','plesk','Plesk',4),(54,'control_panel','ensim','Ensim',5),(55,'control_panel','da','DirectAdmin',6),(56,'control_panel','cpplus','CPplus',7),(57,'control_panel','none','NONE - N/A',8),(58,'packages','reseller_bulk','Bulk Reseller',1),(59,'network_devices','backup','Backup storage (NAS)',4);
UNLOCK TABLES;
/*!40000 ALTER TABLE `settings_types` ENABLE KEYS */;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `staff_id` int(8) unsigned NOT NULL auto_increment,
  `level_id` int(8) unsigned NOT NULL default '1',
  `first_name` varchar(35) NOT NULL default '',
  `last_name` varchar(35) NOT NULL default '',
  `theme` varchar(50) NOT NULL default 'default',
  `lang` varchar(25) NOT NULL default '',
  `title` varchar(100) NOT NULL default '',
  `sig` text NOT NULL,
  `email1` varchar(75) NOT NULL default '',
  `email2` varchar(75) NOT NULL default '',
  `nickname` varchar(150) NOT NULL default '',
  `password` varchar(75) NOT NULL default '',
  `prefs` varchar(15) NOT NULL default '0,0,0,0,0,0',
  `limit_ip_login` enum('Y','N') NOT NULL default 'N',
  `limit_ip_data` varchar(20) NOT NULL default '',
  `aim` varchar(50) NOT NULL default '',
  `phone` varchar(35) NOT NULL default '',
  `alt_phone` varchar(35) NOT NULL default '',
  `date` date NOT NULL default '0000-00-00',
  `avatar` int(3) NOT NULL default '0',
  `bio` mediumtext NOT NULL,
  `default_dept` int(11) NOT NULL default '0',
  `active` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`staff_id`),
  KEY `level_id` (`level_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--


/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
LOCK TABLES `staff` WRITE;
INSERT INTO `staff` VALUES (2,1,'Joshua','Abbott','default','english','Customer Service Representative (CSR)','','jabbott@wisegene.com','joshua@test.jaguarpc.com','joshua@test.jaguarpc.com','e7498f989b2fd8a2f44177f8108549bd','0,0,0,0,0,0','N','','strdrftr','7142804861','3149710415','0000-00-00',0,'0',0,'1'),(1,1,'Admin','','default','english','Admin','','Admin','','Admin','5f4dcc3b5aa765d61d8327deb882cf99','0,0,0,0,0,0','N','','','','','0000-00-00',0,'0',0,'1');
UNLOCK TABLES;
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;

--
-- Table structure for table `staff_avatars`
--

DROP TABLE IF EXISTS `staff_avatars`;
CREATE TABLE `staff_avatars` (
  `id` int(11) NOT NULL auto_increment,
  `file` mediumblob NOT NULL,
  `mime` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_avatars`
--


/*!40000 ALTER TABLE `staff_avatars` DISABLE KEYS */;
LOCK TABLES `staff_avatars` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `staff_avatars` ENABLE KEYS */;

--
-- Table structure for table `staff_guide`
--

DROP TABLE IF EXISTS `staff_guide`;
CREATE TABLE `staff_guide` (
  `faq_id` int(10) NOT NULL auto_increment,
  `cat_id` tinyint(10) NOT NULL default '0',
  `question` tinytext NOT NULL,
  `answer` mediumtext NOT NULL,
  `anon` char(1) NOT NULL default 'Y',
  `on` enum('0','1') NOT NULL default '0',
  `time` varchar(20) default NULL,
  `date` date NOT NULL default '0000-00-00',
  `updated` date NOT NULL default '0000-00-00',
  `views` varchar(15) NOT NULL default '0',
  PRIMARY KEY  (`faq_id`),
  KEY `category` (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_guide`
--


/*!40000 ALTER TABLE `staff_guide` DISABLE KEYS */;
LOCK TABLES `staff_guide` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `staff_guide` ENABLE KEYS */;

--
-- Table structure for table `staff_guide_cat`
--

DROP TABLE IF EXISTS `staff_guide_cat`;
CREATE TABLE `staff_guide_cat` (
  `faq_cat_id` int(15) NOT NULL auto_increment,
  `category` varchar(100) NOT NULL default '',
  `order` char(3) NOT NULL default '',
  PRIMARY KEY  (`faq_cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_guide_cat`
--


/*!40000 ALTER TABLE `staff_guide_cat` DISABLE KEYS */;
LOCK TABLES `staff_guide_cat` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `staff_guide_cat` ENABLE KEYS */;

--
-- Table structure for table `staff_notes`
--

DROP TABLE IF EXISTS `staff_notes`;
CREATE TABLE `staff_notes` (
  `note_id` int(8) unsigned NOT NULL auto_increment,
  `staff_id` int(8) unsigned NOT NULL default '0',
  `subject` varchar(100) NOT NULL default '',
  `comments` mediumtext NOT NULL,
  `date` date NOT NULL default '0000-00-00',
  `time` varchar(20) NOT NULL default '',
  `public` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`note_id`),
  KEY `staff_id` (`staff_id`),
  FULLTEXT KEY `subject` (`subject`,`comments`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_notes`
--


/*!40000 ALTER TABLE `staff_notes` DISABLE KEYS */;
LOCK TABLES `staff_notes` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `staff_notes` ENABLE KEYS */;

--
-- Table structure for table `support`
--

DROP TABLE IF EXISTS `support`;
CREATE TABLE `support` (
  `ticket_id` int(12) unsigned NOT NULL auto_increment,
  `client_id` int(8) unsigned NOT NULL default '0',
  `user_id` int(8) unsigned NOT NULL default '0',
  `dept_id` int(8) unsigned NOT NULL default '0',
  `cat_id` int(8) unsigned NOT NULL default '0',
  `client_notify` enum('0','1') NOT NULL default '1',
  `priority` enum('1','2','3') NOT NULL default '3',
  `subject` varchar(255) NOT NULL default 'help',
  `domain` varchar(100) NOT NULL default '',
  `altemail` varchar(75) NOT NULL default '',
  `status` enum('N','O','C') NOT NULL default 'N',
  `date` date NOT NULL default '0000-00-00',
  `time` varchar(20) NOT NULL default '',
  `udate` date NOT NULL default '0000-00-00',
  `utime` varchar(20) NOT NULL default '',
  `comments` mediumtext NOT NULL,
  `r_pass` varchar(35) NOT NULL default '',
  `spam_check` enum('0','1') NOT NULL default '0',
  `owner` int(8) NOT NULL default '0',
  `verify_key` int(25) NOT NULL default '0',
  PRIMARY KEY  (`ticket_id`),
  KEY `client_id` (`client_id`),
  KEY `user_id` (`user_id`),
  KEY `status` (`status`),
  KEY `cat_id` (`cat_id`),
  FULLTEXT KEY `subject` (`subject`,`comments`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `support`
--


/*!40000 ALTER TABLE `support` DISABLE KEYS */;
LOCK TABLES `support` WRITE;
INSERT INTO `support` VALUES (2331699,1,0,1,1,'1','1','First Ticket','','','C','2006-07-22','18:01:11','2006-07-23','17:57:37','','','0',0,0),(2331700,0,0,0,0,'0','','0','','','C','2006-01-01','24:00:01','2006-01-01','24:00:02','','','0',0,0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `support` ENABLE KEYS */;

--
-- Table structure for table `support_category`
--

DROP TABLE IF EXISTS `support_category`;
CREATE TABLE `support_category` (
  `cat_id` int(8) unsigned NOT NULL auto_increment,
  `default_dept` int(8) NOT NULL default '1',
  `name` varchar(50) NOT NULL default '',
  `public` enum('1','0') NOT NULL default '1',
  `order` smallint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `support_category`
--


/*!40000 ALTER TABLE `support_category` DISABLE KEYS */;
LOCK TABLES `support_category` WRITE;
INSERT INTO `support_category` VALUES (1,1,'Emergency Category','1',0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `support_category` ENABLE KEYS */;

--
-- Table structure for table `support_center`
--

DROP TABLE IF EXISTS `support_center`;
CREATE TABLE `support_center` (
  `id` int(10) NOT NULL auto_increment,
  `image` varchar(50) NOT NULL default '',
  `page` varchar(50) NOT NULL default '',
  `title` varchar(50) NOT NULL default '',
  `desc` mediumtext NOT NULL,
  `order` tinyint(2) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `support_center`
--


/*!40000 ALTER TABLE `support_center` DISABLE KEYS */;
LOCK TABLES `support_center` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `support_center` ENABLE KEYS */;

--
-- Table structure for table `support_dept`
--

DROP TABLE IF EXISTS `support_dept`;
CREATE TABLE `support_dept` (
  `dept_id` int(8) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `dept_mail` varchar(50) NOT NULL default '',
  `order` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`dept_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `support_dept`
--


/*!40000 ALTER TABLE `support_dept` DISABLE KEYS */;
LOCK TABLES `support_dept` WRITE;
INSERT INTO `support_dept` VALUES (1,'Support','support@comdexxsoft.com',1);
UNLOCK TABLES;
/*!40000 ALTER TABLE `support_dept` ENABLE KEYS */;

--
-- Table structure for table `support_msg`
--

DROP TABLE IF EXISTS `support_msg`;
CREATE TABLE `support_msg` (
  `msg_id` int(15) unsigned NOT NULL auto_increment,
  `ticket_id` int(12) unsigned NOT NULL default '0',
  `responder` int(8) unsigned NOT NULL default '0',
  `type` enum('sys','users','staff') NOT NULL default 'sys',
  `message` mediumtext NOT NULL,
  `date` date NOT NULL default '0000-00-00',
  `time` varchar(20) default NULL,
  PRIMARY KEY  (`msg_id`),
  KEY `ticket_id` (`ticket_id`),
  KEY `responder` (`responder`),
  FULLTEXT KEY `message` (`message`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `support_msg`
--


/*!40000 ALTER TABLE `support_msg` DISABLE KEYS */;
LOCK TABLES `support_msg` WRITE;
INSERT INTO `support_msg` VALUES (1015676,2331699,1,'staff','Test\n','2006-07-22','18:01:11'),(1015677,2331699,2331699,'sys','A customer service representative has begun working on this issue.','2006-07-23','17:57:31'),(1015678,2331699,1,'staff','\r\n','2006-07-23','17:57:37');
UNLOCK TABLES;
/*!40000 ALTER TABLE `support_msg` ENABLE KEYS */;

--
-- Table structure for table `testimony`
--

DROP TABLE IF EXISTS `testimony`;
CREATE TABLE `testimony` (
  `test_id` int(8) unsigned NOT NULL auto_increment,
  `date` date NOT NULL default '0000-00-00',
  `name` varchar(50) NOT NULL default '',
  `subject` varchar(100) NOT NULL default '',
  `statement` mediumtext NOT NULL,
  `ref` varchar(255) NOT NULL default '',
  `approved` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`test_id`),
  KEY `approved` (`approved`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testimony`
--


/*!40000 ALTER TABLE `testimony` DISABLE KEYS */;
LOCK TABLES `testimony` WRITE;
INSERT INTO `testimony` VALUES (1,'2006-07-23','Test Name','Test Subject','Test Statement','','0');
UNLOCK TABLES;
/*!40000 ALTER TABLE `testimony` ENABLE KEYS */;

--
-- Table structure for table `tracker`
--

DROP TABLE IF EXISTS `tracker`;
CREATE TABLE `tracker` (
  `track_id` int(10) unsigned NOT NULL auto_increment,
  `unique_key` tinyint(2) NOT NULL default '0',
  `start_date` date NOT NULL default '0000-00-00',
  `color` varchar(7) NOT NULL default '',
  `name` varchar(50) NOT NULL default '',
  `landing_url` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`track_id`),
  KEY `unique_key` (`unique_key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tracker`
--


/*!40000 ALTER TABLE `tracker` DISABLE KEYS */;
LOCK TABLES `tracker` WRITE;
INSERT INTO `tracker` VALUES (18,77,'2006-07-23','#DDFFEE','Test','http://www.yahoo.com/');
UNLOCK TABLES;
/*!40000 ALTER TABLE `tracker` ENABLE KEYS */;

--
-- Table structure for table `tracker_clicks`
--

DROP TABLE IF EXISTS `tracker_clicks`;
CREATE TABLE `tracker_clicks` (
  `track_id` int(10) unsigned NOT NULL default '0',
  `date` date NOT NULL default '0000-00-00',
  `clicks` int(10) unsigned NOT NULL default '0',
  KEY `trackID` (`track_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tracker_clicks`
--


/*!40000 ALTER TABLE `tracker_clicks` DISABLE KEYS */;
LOCK TABLES `tracker_clicks` WRITE;
INSERT INTO `tracker_clicks` VALUES (18,'2006-07-23',1);
UNLOCK TABLES;
/*!40000 ALTER TABLE `tracker_clicks` ENABLE KEYS */;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `trans_num` varchar(32) NOT NULL default '',
  `client_id` int(8) unsigned default NULL,
  `invoice_id` int(8) unsigned default NULL,
  `amount` varchar(12) default NULL,
  `description` tinytext,
  `time` datetime default NULL,
  `card_name` varchar(100) default NULL,
  `card_address` varchar(125) default NULL,
  `card_city` varchar(75) default NULL,
  `card_state` varchar(100) default NULL,
  `card_zip` varchar(10) default NULL,
  `card_country` varchar(150) default NULL,
  `card_num` int(6) NOT NULL default '0',
  `status` enum('success','failure','error') default 'error',
  `err_code` varchar(10) default NULL,
  `err_msg` tinytext,
  `merchtxn` varchar(50) default NULL,
  `ref_code` varchar(20) default NULL,
  `action` enum('charge','refund','credit') NOT NULL default 'charge',
  `avs_response` varchar(5) default NULL,
  `note` varchar(255) NOT NULL default '',
  KEY `trans_num` (`trans_num`),
  KEY `client_id` (`client_id`),
  KEY `invoice_id` (`invoice_id`),
  FULLTEXT KEY `trans_num_2` (`trans_num`,`description`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--


/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
LOCK TABLES `transactions` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(8) unsigned NOT NULL auto_increment,
  `client_id` int(8) unsigned NOT NULL default '1',
  `level_id` int(8) unsigned NOT NULL default '1',
  `first_name` varchar(35) NOT NULL default 'Update Name Please',
  `last_name` varchar(35) NOT NULL default 'Update Name Please',
  `start_date` date NOT NULL default '0000-00-00',
  `timestamp` int(20) NOT NULL default '0',
  `theme` varchar(50) NOT NULL default 'default',
  `lang` varchar(25) NOT NULL default '',
  `title` varchar(50) NOT NULL default '',
  `sig` text NOT NULL,
  `email1` varchar(75) NOT NULL default '',
  `email2` varchar(75) NOT NULL default '',
  `email1_updates` enum('0','1') NOT NULL default '1',
  `email2_updates` enum('0','1') NOT NULL default '1',
  `nickname` varchar(150) NOT NULL default '',
  `password` varchar(75) NOT NULL default '',
  `prefs` varchar(15) NOT NULL default '0,0,0',
  `limit_ip_login` enum('0','1') NOT NULL default '0',
  `limit_ip_data` varchar(20) NOT NULL default '',
  `aim` varchar(50) NOT NULL default '',
  `phone` varchar(35) NOT NULL default '',
  `alt_phone` varchar(35) NOT NULL default '',
  `active` enum('0','1') NOT NULL default '1',
  `comments` mediumtext NOT NULL,
  `salt` varchar(255) default NULL,
  PRIMARY KEY  (`user_id`),
  KEY `client_id` (`client_id`),
  KEY `first_name` (`first_name`,`last_name`),
  KEY `user` (`email1`,`email2`,`nickname`),
  FULLTEXT KEY `phone` (`phone`,`alt_phone`),
  FULLTEXT KEY `email` (`email1`,`email2`),
  FULLTEXT KEY `name` (`first_name`,`last_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--


/*!40000 ALTER TABLE `users` DISABLE KEYS */;
LOCK TABLES `users` WRITE;
INSERT INTO `users` VALUES (1,1,1,'Demo','User','0000-00-00',0,'default','english','','','email@email.tld','email2@domain.tld','1','1','','146c3e042458b422e8e0226566fc81ad','0,0,0','0','','strdrftr','5555555555','4444444444','1','','+rz');
UNLOCK TABLES;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

