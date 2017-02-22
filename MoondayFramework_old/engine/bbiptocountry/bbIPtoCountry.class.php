<?php

/**
* @package bbIPtoCountry
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc IP to Country Class
* @uses
*         CREATE TABLE `$tbl_ips` (
*            `ip_from` int(10) unsigned NOT NULL default '0',
*            `ip_to` int(10) unsigned NOT NULL default '0',
*            `countryid` int(10) unsigned NOT NULL default '0'
*        ) TYPE=MyISAM;
*
*        CREATE TABLE `$tbl_countries` (
*            `id` int(10) unsigned NOT NULL auto_increment,
*            `code2` char(2) NOT NULL default '',
*            `code3` char(3) NOT NULL default '',
*            `country` varchar(64) NOT NULL default '',
*            PRIMARY KEY  (`id`),
*            UNIQUE KEY `unqAll` (`code2`,`code3`,`country`)
*        ) TYPE=MyISAM;
* @example
* @files
*/

    class bbIPtoCountry {

        var $_classname     = 'bbIPtoCountry';
        var $_classversion  = '1.2';
        var $_classdate     = '2004-04-25 12:56';

        var $server         = 'localhost';          // Database Server Name/IP address
        var $dbname         = '';                   // Database Name
        var $username       = '';                   // Database User Name 
        var $password       = '';                   // Database Password
        var $tbl_countries  = 'ipcountries';
        var $tbl_ips        = 'ip2country';

        var $datafile       = 'ip-to-country.csv';  // IP to Country base filename, need for updates

        var $ip             = '';
        var $ip_from        = '';
        var $ip_to          = '';
        var $code2          = '';
        var $code3          = '';
        var $country        = '';
        
        var $error          = '';
        var $_db            = false;



        function bbIPtoCountry($ip='') {
        
            if ( !empty($ip) )
                $this->GetCountryCode($ip);
        }


        function GetCountryCode($ip='') {

            if ( !empty($ip) ) {
                $this->ip = $ip;
                return $this->GetInfo();
            }
        }
        
        
        function GetInfo($field='code2') {

            if ( !$this->_connectdb() ) return false;
            
            $this->error = '';

            $qry = 'SELECT INET_NTOA(IP.ip_from) AS ip_from, INET_NTOA(IP.ip_to) AS ip_to, C.code2, C.code3, C.country'.
                   ' FROM '.$this->tbl_ips.' IP INNER JOIN '.$this->tbl_countries.' C ON IP.countryid=C.id'.
                   " WHERE ip_from<=INET_ATON('".$this->ip."') AND ip_to>=INET_ATON('".$this->ip."') ORDER BY ip_from, ip_to";

            $res = @mysql_query($qry, $this->_db);
            if ( !$res ) {
                $this->error = 'Database Error #'.__LINE__.': '.mysql_error();
                return false;
            }

            $info = mysql_fetch_array($res);
            /*if ( !$this->magic_quotes )
                $info['country'] = stripslashes($info['country']);*/

            $this->ip_from   = $info['ip_from'];
            $this->ip_to     = $info['ip_to'];
            $this->code2     = $info['code2'];
            $this->code3     = $info['code3'];
            $this->country   = $info['country'];
            
            
            if ( isset($info[$field]) )
                $info = $info[$field];

            return $info;
        }
        
        
        function updateDatas($filename='') {
        
            $this->error = '';
            if ( empty($filename) || !file_exists($filename) )
                $filename = $this->datafile;
                
            if ( !file_exists($filename) || !is_readable($filename) ) {
                $this->error = 'Could not read file';
                return false;
            }

            set_time_limit(180);
            
            if ( !$this->_connectdb() ) return false;
            
            $hFile = fopen($filename, 'r');
            if ( !$hFile ) {
                $this->error = 'Could not open data file';
                return false;
            }
            
            @mysql_query("TRUNCATE TABLE `$this->tbl_countries`", $this->_db);
            @mysql_query("TRUNCATE TABLE `$this->tbl_ips`", $this->_db);
    
            $count = 0;
    
            while ( list($from, $to, $code2, $code3, $country) = fgetcsv($hFile, 1024, ',', '"') ) {
    
                $country = ucwords(strtolower($country));
                $country = mysql_escape_string($country);
                    
                // Check Country
                $sql = "SELECT id FROM $this->tbl_countries WHERE (code2='$code2') AND (code3='$code3') AND (country='$country')";
                $ct = @mysql_query($sql, $this->_db);
                if ( !$ct ) {
                    $this->error = 'Database Error #'.__LINE__.': '.$sql.' => '.mysql_error();
                    continue;
                }
        
                if ( mysql_num_rows($ct)>0 ) {
                    // Country Exists, get id
                    $id = mysql_result($ct, 0);
                } else {
                    // Country Not exists, add it
                    $ct = @mysql_query("INSERT INTO $this->tbl_countries (code2, code3, country) VALUES ('$code2', '$code3', '$country')", $this->_db);
                    if ( !$ct ) {
                        $this->error = 'Database Error #'.__LINE__.': '.mysql_error();
                        continue;
                    }
            
                    // Added, get id
                    $id = mysql_insert_id($this->_db);
                }
                @mysql_free_result($ct);
        
                // Add IP Ranges for country
                $ip = mysql_query("INSERT INTO $this->tbl_ips (ip_from, ip_to, countryid) VALUES ($from, $to, $id)", $this->_db);
                if ( !$ip ) {
                    $this->error = 'Database Error #'.__LINE__.': '.mysql_error();
                    continue;
                }

                @mysql_free_result($ip);
        
                $count++;
            }
    
            fclose($hFile);
    
            return $count;
        }


        function _connectdb() {
        
            if ( $this->_db ) return $this->_db;
            
            $this->_db = @mysql_connect($this->server, $this->username, $this->password); 
            if ( !$this->_db ) {
                $this->error = 'Database Error #'.__LINE__.': '.mysql_error();
                return false;
            }
            
            if ( !mysql_select_db($this->dbname, $this->_db) ) {
                $this->error = 'Database Error #'.__LINE__.': '.mysql_error();
                return false;
            }

            return $this->_db;
        }
    }
?>
