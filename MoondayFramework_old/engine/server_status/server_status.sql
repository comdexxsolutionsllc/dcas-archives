# phpMyAdmin MySQL-Dump
# version 2.5.1
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Sep 15, 2003 at 06:47 PM
# Server version: 4.0.14
# PHP Version: 4.3.2
# Database : `server_status`
# --------------------------------------------------------

#
# Table structure for table `server_status`
#
# Creation: Sep 15, 2003 at 02:39 PM
# Last update: Sep 15, 2003 at 02:40 PM
#

DROP TABLE IF EXISTS `server_status`;
CREATE TABLE `server_status` (
  `status_id` int(10) unsigned NOT NULL auto_increment,
  `status_ip` varchar(15) NOT NULL default '',
  `status_port` varchar(5) NOT NULL default '',
  `status_service` varchar(128) NOT NULL default '',
  `status_type` char(3) NOT NULL default '',
  `status_status` enum('TRUE','FALSE') NOT NULL default 'FALSE',
  `date_added` timestamp(14) NOT NULL,
  PRIMARY KEY  (`status_id`)
) TYPE=MyISAM AUTO_INCREMENT=12 ;

