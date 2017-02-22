# Structure of table for SForum class
#

CREATE TABLE sforum (
  id int(10) unsigned NOT NULL auto_increment primary key,
  wid int(10) unsigned NOT NULL default '0',
  for_ptitle varchar(255) NOT NULL default '',
  for_text text NOT NULL,
  for_mail varchar(255) NOT NULL default '',
  for_data datetime NOT NULL default '0000-00-00 00:00:00',
  for_dataw datetime NOT NULL default '0000-00-00 00:00:00',
  for_ip varchar(15) NOT NULL default '000.000.000.000',
  for_name varchar(255) NOT NULL default '',
  KEY wid(wid)
) TYPE=MyISAM;