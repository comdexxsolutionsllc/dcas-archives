<?php 
/**
* @package 
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc Database tree node application
* @uses
* @example
* @files
*/
/**
 * Database tree node application
 * 
 * JavaScripts and stylesheets are tested succesfully on 
 * - mac safari 2.0.3, firefox 1.5.0.1, netscape 7.2 and omniweb 5.1.1
 * - pc firefox 1.0.1
 * Php scripts and classes are tested succesfully on:
 * - Apache 1.3.33, PHP 5.0.4, MySql 4.1.3 
 * - Apache 1.3.34, PHP 4.4.2, MySql 4.1.14
 */
// include configuration file
include_once 'config.php'; 
// construct nodetree
$oNT = new NodeTree($sTableName, 
					$sDsn, 
					$aTableField, 
					$sNodePathRoot, 
					$sNodePathSeparator, 
					$sUniqueTreeKey, 
					$sLiIdPrefix, 
					$sUlIdPrefix
					); 
// include actions
include_once 'actions.php';

// build tree with parameters
$sNodeDepth 		= $iNodeDepth ? " AND {$aTableField['depth']} < $iNodeDepth" : '';
$aParam['select']	= "{$aTableField['id']}, {$aTableField['path']}, {$aTableField['order']}, {$aTableField['title']}, {$aTableField['has_childs']}";
$aParam['from']		= $sTableName;
$aParam['where'] 	= $iNodeId ? "( {$aTableField['path']} LIKE 'x.$iNodeId.%' OR {$aTableField['id']} = $iNodeId )$sNodeDepth" : "1 $sNodeDepth";
$aParam['order by'] = $sOrder;
if( $iLimit ) { $aParam['limit'] = $iLimit; }

$oNT->build_tree($aParam);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
		<title>Hierarchical tree editor for php/mysql</title>
		<link rel="stylesheet" href="./media/style.css" type="text/css" />
		<script src="./media/script.js" type="text/javascript" language="JavaScript"></script>
	</head>
	<body>
		
<?php echo $oNT->get_js_contextual_menu($aMenuActions); ?> 
		
		<div>
			<h4><a href="#" onclick="swap('tree')">Tree</a></h4>
			<?php 
				// message from actions...
				echo $sMsg; 
			?>
			
			<fieldset id="tree">
			
				<?php echo $oNT->get_ul_tree($sRootName, $sRootId, $sGlobalTreeId); ?>
			
			</fieldset>
		</div>
		
		<div>
			<hr /><pre><b>Debug:</b>
			<?php //echo '<br />tree array: '; print_r($oNT->aTree); ?> 
			<br />total_script_time: <?php echo (array_sum(explode(" ", microtime()))-$iStartTime); ?>
			<br />total_query_time: <?php echo $GLOBALS['total_query_time']; ?>
			<br />total_queries: <?php print_r( $GLOBALS['total_queries'] ); ?>
		</div>
		
	</body>
</html>