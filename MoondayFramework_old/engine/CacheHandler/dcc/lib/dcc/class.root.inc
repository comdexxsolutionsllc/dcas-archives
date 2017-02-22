<?php
/////////////////////////////////////////////////////////////
//  DCC::QuickSite ROOT class
//  Copiright (C) 2003, 2004, Gregory A. Rozanoff
//
//  This library is free software; you can redistribute it and/or
//  modify it under the terms of the GNU Lesser General Public
//  License as published by the Free Software Foundation; either
//  version 2.1 of the License, or (at your option) any later version.
//  This library is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
//  Lesser General Public License for more details.
//  You should have received a copy of the GNU Lesser General Public
//  License along with this library; if not, write to the Free Software
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//
/////////////////////////////////////////////////////////////

class root {

// Global settings

var
	$expireTime	= 86400,		// Page lifetime
	$depth		= 1,			// Prepare recursion depth limitation. Default 1.
	$SITE		= "site",		// Root name

	$DBName		= "database",		// MySQL database
	$DBHost		= "host:port",		// MySQL host
	$DBPass		= "password",		// MySQL password
	$DBUser		= "user",		// MySQL user

	$_ROOT_		= array (		// URI structure pattern
				""	=> "index",
				"*"	=> "index",
				"doc"	=> array (
					""	=> "doc",
					"*"	=> "doc",
					),
				);

 // User-defined functions

 function error_404($page) {			// Error 404 wrapper
	header("HTTP/1.0 404 Not Found");
	header("Status: 404 Not Found");
	die ("<b>DCC Error:</b> [404] Page <b>".$page."</b> was not found on the server");
 }

}

?>