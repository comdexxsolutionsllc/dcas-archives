<?php
/*
 * Configuration file for Database tree node application
 * */
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );
$iStartTime = array_sum(explode(" ", microtime())); # script time

// user_id 	client_id 	level_id 	first_name 	last_name 	start_date 	timestamp 	theme 	lang 	title 	sig 	email1
// email2 	email1_updates 	email2_updates 	nickname 	password 	prefs 	limit_ip_login 	limit_ip_data 	aim 	phone
// alt_phone 	active 	comments 	salt

// for nodetree constructor
$sTableName					= 'users'; # target table name
$sDsn						= 'mysql://framework:TUWsNeb3yS6nc7hZ@localhost/paragonpanel'; # target database connection parameters
$aTableField['id'] 			= 'user_id'; # node table field names...
$aTableField['client_id'] 		= 'client_id';
$aTableField['depth'] 		= 'node_depth';
$aTableField['order'] 		= 'node_order';
$aTableField['title'] 		= 'node_title';
$aTableField['has_childs'] 	= 'node_has_childs';
$sNodePathRoot				= 'x'; # node root character
$sNodePathSeparator			= '.'; # path separator
$sUniqueTreeKey				= md5(time()); # unique key for internal use in treenode class
$sLiIdPrefix				= 'l_'; # <li id=""> tag id prefix
$sUlIdPrefix				= 'u_'; # <ul id=""> tag id prefix
// for building tree array
$iNodeId 					= 0; # where to start
$iNodeDepth 				= 0; # how deep to dig
#$sOrder 					= 'node_path ASC, node_order ASC'; # ordering tree nodes
$sOrder = 'NULL';
$iLimit 					= 0; # limiting node amounts. not very usable...
// for getting ul tree
$sRootName 					= '[root]';
$sRootId 					= 'root';
$sGlobalTreeId 				= 'global_tree'; # global div layer wherein tree is printed

// for get_js_contextual_menu method
// if you want to add new and working menu items, you need to add action to
// script.js file and actions.php file...
$aMenuActions['full']['add'] 			= 'Add';
$aMenuActions['full']['edit'] 			= 'Edit';
$aMenuActions['full']['delete'] 		= 'Delete';
$aMenuActions['full']['delete_subnodes']= '&lfloor; only subnodes';
$aMenuActions['full']['copy'] 			= 'Copy';
$aMenuActions['full']['copy_subnodes'] 	= '&lfloor; only subnodes';
$aMenuActions['full']['move'] 			= 'Move';
$aMenuActions['full']['move_subnodes'] 	= '&lfloor; only subnodes';
$aMenuActions['full']['order_up'] 		= 'Order up';
$aMenuActions['full']['order_down'] 	= 'Order down';
//$aMenuActions['full']['custom'] 		= 'Custom';
$aMenuActions['full']['cancel'] 		= 'Cancel';
$aMenuActions['transfer']['here'] 	 	= 'To here';
//$aMenuActions['transfer']['customx'] 	= 'Custom';
$aMenuActions['transfer']['cancel']  	= 'Cancel';

// for phpdtobject debugging
$GLOBALS['total_query_time'] 			= 0;
$GLOBALS['total_queries'] 				= array();
$GLOBALS['debug_queries'] 				= true;
$GLOBALS['debug_queries_only_relevant'] = true;

// include classes and action script
include_once 'phpdtobject/PhpDtObject.php';
include_once 'node/Node.php';
include_once 'node/NodeTree.php';

?>