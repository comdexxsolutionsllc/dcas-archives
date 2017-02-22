<?php
/**
* @package NodeTree
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc (see below)
* @uses
* @example
* @files
*/
/**
 * Class NodeTree
 * 
 * Requires PhpDtObject class
 * Node Tree class creates multidimensional associative array from database
 * table that is defined as explained in Node class. Then class is used to
 * create standard hierachically structured html list. With additional javascript
 * class finally creates all necessary codes for manipulating tree visually.
 * 
 * Usage example:
 * $oNT = new NodeTree(...);
 * $oNT->build_tree($aParam);
 * echo $oNT->get_js_contextual_menu(...);
 * echo $oNT->geT_ul_tree(...);
 */
class NodeTree extends Node
{
	var $sUniqueTreeKey;
	var $sLiIdPrefix;
	var $sUlIdPrefix;
	var $aTree;
	/**
	 * Constructor
	 * 
	 * @access 	public
	 * @param 	string $sTableName
	 * @param 	string $sDsn
	 * @param 	array $aTableField
	 * @param 	string $sNodePathRoot default 'x'
	 * @param 	string $sNodePathSeparator default '.'
	 * @param 	string $sUniqueTreeKey default 'xyz'
	 * @param 	string $sLiIdPrefix default 'l_'
	 * @param 	string $sUlIdPrefix default 'u_'
	 * @return 	void
	 */
	function NodeTree( 	$sTableName, 
						$sDsn, 
						$aTableField, 
						$sNodePathRoot = 'x', 
						$sNodePathSeparator = '.',
						$sUniqueTreeKey = 'xyz',
						$sLiIdPrefix = 'l_',
						$sUlIdPrefix = 'u_' ) {
		$this->Node($sTableName, $sDsn, $aTableField, $sNodePathRoot, $sNodePathSeparator);
		$this->sUniqueTreeKey = $sUniqueTreeKey;
		$this->sLiIdPrefix = $sLiIdPrefix;
		$this->sUlIdPrefix = $sUlIdPrefix;
	}
	
	/****************************************************************
	 ** 					  PUBLIC METHODS
	 ***************************************************************/
		
	/**
	 * Build associative array with one sql query
	 * Example tree:
	 *
		$aTree = array();
		$aTree[1][UNIQUE_TREE_KEY] = 'Node 1';
		$aTree[1][1.1] = 'Node 1.1';
		$aTree[1][1.2] = 'Node 1.2';
		$aTree[2] = 'Node 2';
		$aTree[3][UNIQUE_TREE_KEY] = 'Node 3';
		$aTree[3][3.1] = 'Node 3.1';
		$aTree[3][3.2][UNIQUE_TREE_KEY] = 'Node 3.2';
		$aTree[3][3.2][3.2.1] = 'Node 3.2.1';
		$aTree[3][3.2][3.2.2] = 'Node 3.2.2';
	 *
	 *
	 * @param array $aParam
	 * @return void
	 * @access public
	 */
	function build_tree($aParam) {
		$oPdo = new PhpDtObject( $this->sTableName, $this->sDsn );
		$oPdo->get_many($aParam); 
		$aTree = array();
		while( $oPdo->iterate() ) {
			$x = '';
			$sPath = $oPdo->gv($this->sNodePath);
			if( $sPath != $this->sNodePathRoot ) {
				$aPathParts = explode($this->sNodePathSeparator,$sPath);
				unset($aPathParts[0]);
				foreach( $aPathParts as $k ) {
					$x .= "[$k]";
				}
			}
			$x .= '['.$oPdo->gv($this->sNodeId).']';
			if( $oPdo->gv($this->sNodeHasChilds) ) {
				$sEval = '$aTree'.$x."['".$this->sUniqueTreeKey."'] = '".$oPdo->gv($this->sNodeTitle)."'; ";
			} else {
				$sEval = '$aTree'.$x." = '".$oPdo->gv($this->sNodeTitle)."'; ";
			}
			eval( $sEval );
		}
		$oPdo->unlink(); unset($oPdo);
		$this->aTree = $aTree;
	}
	
	/**
	 *
	 * @param string $sRootName
	 * @param string $sRootId
	 * @param string $sGlobalTreeId
	 * @return string
	 * @access public
	 */
	function get_ul_tree($sRootName, $sRootId, $sGlobalTreeId) { 
		$sContent = '<ul id="'.$sGlobalTreeId.'">';
		$sContent .= '<li id="'.$this->sLiIdPrefix.$sRootId.'" onclick="swapNode(this.id)">';
		$sContent .= '<a href="#" onclick="showContextualMenu(this.id)" id="'.$sRootId.'">'.$sRootName.'</a>';
		$sContent .= '</li><ul id="'.$this->sUlIdPrefix.$sRootId.'">';
		$sContent .= $this->_get_ul_tree_nodes( $this->aTree );
		$sContent .= '</ul></ul>';
		return $sContent;
	}
	
	/**
	 * Build and return javascript part for contextual menu
	 * 
	 * When you want to make new menu items, 1) create new cell in config.php
	 * then 2) create action to script.js and finally 3) action to actions.php files 
	 *
	 * @param array $aMenuActions
	 * @return string
	 * @access public
	 */
	function get_js_contextual_menu($aMenuActions) {
		$sContent = '<script language="JavaScript">'."\n";
		$sContent .= "<!--\n";
		$sContent .= "var sLiPrefix = '{$this->sLiIdPrefix}'\n";
		$sContent .= "var sUlPrefix = '{$this->sUlIdPrefix}'\n";
		$sContent .= "var aMenu = new Array()\n";
		
		foreach( $aMenuActions as $sMode=>$aAction ) {
			$sContent .= "aMenu['$sMode'] = new Array()\n";
			foreach($aAction as $k=>$v) {
				$sContent .= "aMenu['$sMode']['$k'] = '$v'\n";
			}
		}
		foreach( $aMenuActions as $sMode=>$aAction ) {
			$sContent .= "printContextualMenu('$sMode')\n";
		}
		$sContent .= "var sMenuMode = 'full' // or transfer";
		$sContent .= "\n-->\n</script>";
		return $sContent;
	}


	/****************************************************************
	 ** 					  PRIVATE METHODS
	 ***************************************************************/
		
	/**
	 * @param array $aNodes
	 * @return string
	 * @access private
	 */
	function _get_ul_tree_nodes($aNodes) {
		static $sTreeContent = '';
		foreach( $aNodes as $k=>$v ) {
			if(is_array($v)) {
				$sTreeContent .= '<li title="id: '.$k.'" id="'.$this->sLiIdPrefix.$k.'" onclick="swapNode(this.id)">';
				$sTreeContent .= '<a href="#" onclick="showContextualMenu(this.id)" id="'.$k.'">'.$v[$this->sUniqueTreeKey].'</a>';
				$sTreeContent .= '</li><ul id="'.$this->sUlIdPrefix.$k.'">';
				$this->_get_ul_tree_nodes($v);
				$sTreeContent .= '</ul>';
			} else if($k!=$this->sUniqueTreeKey) {
				$sTreeContent .= '<li title="id: '.$k.'" id="'.$this->sLiIdPrefix.$k.'" onclick="swapNode(this.id)"><a href="#" onclick="showContextualMenu(this.id)" id="'.$k.'">'.$v.'</a></li>';
			}
		}
		return $sTreeContent;
	}
}
?>