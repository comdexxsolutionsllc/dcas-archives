<?php
/**
* @package Node
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc (see below)
* @uses
* @example
* @files
*/
/**
 * Class Node
 * 
 * Hierarchical parent/child managing class for database
 * 
 * Hierarchal data is good for categorizing and structuring data quite similar
 * way as xml document is purposed to structure data. This class uses materialized
 * path apart from other methods available. Materialized path is quite
 * efficient and easy to understand yet it has its limitations because path
 * is forced to have varchar, max 255 characters on path field in table.
 * However this isn't a big problem until there is a need for very wide hierarchy. If 
 * we assume 10 000 000 rows in table, there is still room for 36 depth for any 
 * row.
 * 
 * To use this class, you need a table with next structure:
 * 
	CREATE TABLE `treetest` (
	  `node_id` int(11) NOT NULL auto_increment,
	  `node_path` varchar(255) NOT NULL default 'x',
	  `node_depth` int(11) NOT NULL default '1',
	  `node_order` int(11) NOT NULL default '0',
	  `node_title` varchar(255) NOT NULL default '',
	  `node_has_childs` tinyint(4) NOT NULL default '0',
	  PRIMARY KEY  (`node_id`),
	  KEY `node_id` (`node_id`),
	  KEY `node_path` (`node_path`),
	  KEY `node_depth` (`node_depth`),
	  KEY `node_order` (`node_order`),
	  KEY `node_title` (`node_title`),
	  KEY `node_has_childs` (`node_has_childs`)
	) TYPE=MyISAM;
 * 
 * example rows:
 * 
	INSERT INTO `treetest` VALUES
	 ('1','x','1','0','1','1'),
	 ('2','x','1','1','2','0'),
	 ('3','x','1','2','3','1'),
	 ('4','x.1','2','0','1.1','1'),
	 ('5','x.1','2','1','1.2','0'),
	 ('6','x.1.4','3','0','1.3','0'),
	 ('7','x.3','2','0','3.1','0');
 * 
 * With class you can add nodes, edit nodes, delete nodes, copy, move and change
 * order of nodes with simple methods. Construct object with table name,
 * table field prefix (node_ default) and dsn database connection string. Optional 
 * arguments can be used to change path concanating elements. If you change 
 * $sNodePathRoot, remember to change `node_path` default 'x' value on table
 * definition.
 * 
 * Usage examples:
 * 
 * require_once './phpdtobject/PhpDtObject.php';
 * require_once './node/Node.php';
 * 
 * $sTableName 					= 'treetest'; 
 * $sDsn 						= 'mysql://root:pass@localhost/test'; 
 * $aTableField['id'] 			= 'node_id'; 
 * $aTableField['path'] 		= 'node_path'; 
 * $aTableField['depth'] 		= 'node_depth'; 
 * $aTableField['order'] 		= 'node_order'; 
 * $aTableField['title'] 		= 'node_title'; 
 * $aTableField['has_childs'] 	= 'node_has_childs'; 
 * 
 * $oNode 			= new Node($sTableName, $sDsn, $aTableField); 
 * $iNode 			= $oNode->add_node(); 
 * $iParentNode 	= $oNode->add_node(); 
 * $iChildNode 		= $oNode->add_node($iParentNode, 'MyTitle'); 
 * 
 * $oNode->edit_node($iParentNode, 'MyTitle');
 * $oNode->delete_node($iChildNode,$bOnlySubnodes); 
 * $oNode->order_up($iNode);
 * $oNode->order_down($iNode);
 * $oNode->move_node($iSourceId,$iTargetId,$bOnlySubnodes);
 * $oNode->copy_node($iSourceId,$iTargetId,$iDepth,$bOnlySubnodes);
 * 
 * ...
 */
class Node
{
	/**
	 * Targe table name
	 * @var string
	 */
	var $sTableName;
	/**
	 * Database connection string
	 * @var string
	 */
	var $sDsn;
	/**
	 * Node path root mark (x.2.34.2) where
	 * x is a root mark in path
	 * @var string
	 */
	var $sNodePathRoot;
	/**
	 * Node path separator (x.2.34.2) where
	 * dot (.) is a separator in path
	 * @var string
	 */
	var $sNodePathSeparator;
	
	/**
	 * Table node id field name
	 * @var string
	 */
	var $sNodeId;
	/**
	 * Table node path field name
	 * @var string
	 */
	var $sNodePath;
	/**
	 * Table node depth field name
	 * @var string
	 */
	var $sNodeDepth;
	/**
	 * Table node order field name
	 * @var string
	 */
	var $sNodeOrder;
	/**
	 * Table node title field name
	 * @var string
	 */
	var $sNodeTitle;
	/**
	 * Table node has childs field name
	 * @var string
	 */
	var $sNodeHasChilds;
	
	/**
	 * Constructor
	 * 
	 * @access 	public
	 * @param 	string $sTableName
	 * @param 	string $sDsn
	 * @param 	array $aTableField
	 * @param 	string $sNodePathRoot default 'x'
	 * @param 	string $sNodePathSeparator default '.'
	 * @return 	void
	 */
	function Node( 	$sTableName, 
					$sDsn, 
					$aTableField, 
					$sNodePathRoot = 'x', 
					$sNodePathSeparator = '.' ) {
		
		$this->sTableName 			= $sTableName;
		$this->sDsn 				= $sDsn;
		$this->sNodePathRoot 		= $sNodePathRoot;
		$this->sNodePathSeparator 	= $sNodePathSeparator;
		
		$this->sNodeId 			= $aTableField['id'];
		$this->sNodePath 		= $aTableField['path'];
		$this->sNodeDepth 		= $aTableField['depth'];
		$this->sNodeOrder 		= $aTableField['order'];
		$this->sNodeTitle 		= $aTableField['title'];
		$this->sNodeHasChilds 	= $aTableField['has_childs'];
	}

	/****************************************************************
	 ** 					  PUBLIC METHODS
	 ***************************************************************/
	
	/**
	 * Add node with optional title and order arguments
	 * 
	 * If target node ($iTo) is zero (0) then add to root.
	 * If order is not set, method find next order. Using manual order
	 * may cause duplicate order numbers and that would affect to order
	 * up, order down methods
	 * If title is not set, method creates new name: Node + Order.
	 * Be careful when setting empty string as titles, because they may
	 * have unexpected result when printing trees with action links!
	 * Method returns new node id or false when creating new node fails.
	 * 
	 * @access 	public
	 * @param 	integer $iTo default 0
	 * @param 	string $sTitle default null
 	 * @param 	integer $iOrder default null
	 * @return 	mixed integer / boolean
	 */
	function add_node( $iTo = 0, $sTitle = null, $iOrder = null ) {
		if( $iTo > 0 ) {
			$oPdo = new PhpDtObject( $this->sTableName, $this->sDsn );
			$oPdo->set_mask( array( $this->sNodePath, $this->sNodeDepth, $this->sNodeHasChilds ) );
			if( !$oPdo->init( $iTo ) ) {
				//trigger_error( "Could not init node id: $iTo for add_node method." );
				$oPdo->unlink(); unset($oPdo);
				return false;
			} else {
				$iToNodeId 			= $iTo;
				$iToNodePath 		= $oPdo->gv( $this->sNodePath ).$this->sNodePathSeparator.$iTo;
				$iToNodeDepth 		= $oPdo->gv( $this->sNodeDepth )+1;
				$iToNodeHasChilds 	= $oPdo->gv( $this->sNodeHasChilds );
			}
		} else {
			$iToNodeId 		= 0;
			$iToNodePath 	= $this->sNodePathRoot;
			$iToNodeDepth 	= 1;
		}
		// get next order
		$iToNodeOrder = isset( $iOrder ) ? $iOrder : $this->_get_next_order($iToNodePath);
		$iToNodeTitle = isset( $sTitle ) ? $sTitle : 'Node '.$iToNodeOrder;
		// create new node
		$oPdo2 = new PhpDtObject( $this->sTableName, $this->sDsn );
		$oPdo2->sv( $this->sNodeId, 0 );
		$oPdo2->sv( $this->sNodePath, $iToNodePath );
		$oPdo2->sv( $this->sNodeDepth, $iToNodeDepth );
		$oPdo2->sv( $this->sNodeOrder, $iToNodeOrder );
		$oPdo2->sv( $this->sNodeTitle, $iToNodeTitle );
		$oPdo2->sv( $this->sNodeHasChilds, 0 );
		$iId = $oPdo2->save();
		if( $iId ) {
			// if node != root and node has no childs, update has_childs field
			if( $iToNodeId > 0 && $iToNodeHasChilds == 0 ) {
				$oPdo->sv( $this->sNodeHasChilds, 1 );
				$oPdo->save();
			}
			// return new node id
			$oPdo2->unlink();
			if(isset($oPdo)) unset($oPdo);
			unset($oPdo2);
			return $iId;
		} else {
			// if insert fails
			$oPdo2->unlink(); unset($oPdo2);
			if(isset($oPdo)) unset($oPdo);
			return false;
		}
	}
		
	/**
	 * Edit node title and order
	 * 
	 * Path, depth and has childs fields are handled automatic on other methods
	 * If you decide manually to change them (as well as order field) be carefull
	 * because its easy to break hierarchical data structure in table
	 * 
	 * @access 	public
	 * @param 	integer $iNode
	 * @param 	string $sTitle
	 * @param 	integer $iOrder default null
	 * @return 	boolean
	 */
	function edit_node( $iNode, $sTitle, $iOrder = null ) {
		$oPdo = new PhpDtObject( $this->sTableName, $this->sDsn );
		$oPdo->set_mask( array( $this->sNodeId, $this->sNodeTitle, $this->sNodeOrder ) );
		if( !$oPdo->init( $iNode ) ) {
			//trigger_error( "Could not init node id: $iNode for edit_node method" );
			$oPdo->unlink(); unset($oPdo);
			return false;
		}
		$oPdo->sv( $this->sNodeTitle, $sTitle );
		if( isset( $iOrder ) ) $oPdo->sv( $this->sNodeOrder, $iOrder );
		$bSuccess = $oPdo->save();
		$oPdo->unlink(); unset($oPdo);
		return $bSuccess;
	}

	/**
	 * Delete node and / or all subnodes
	 * 
	 * With optional argument it is possible to delete only subnodes of
	 * selected / target node. If node id is zero (0), then delete
	 * truncates table!
	 * 
	 * @access 	public
	 * @param 	integer $iNode
	 * @param 	boolean $bOnlySubnodes default false
	 * @return 	boolean
	 */
	function delete_node( $iNode, $bOnlySubnodes = false ) {
		$oPdo = new PhpDtObject( $this->sTableName, $this->sDsn );
		$oPdo->set_mask( array( $this->sNodeId, $this->sNodePath ) );
		if( !$oPdo->init($iNode) ) {
			if( $iNode > 0 ) {
				//trigger_error( "Could not init node id: $iNode for delete_node method" );
				$oPdo->unlink(); unset($oPdo);
				return false;
			} else {
				// if node id is zero (0) then delete all, including autoincrease data!
				$bSuccess = $oPdo->query('TRUNCATE '.$this->sTableName);
				$oPdo->unlink(); unset($oPdo);
				return $bSuccess;
			}
		}
		$aPath 		= explode($this->sNodePathSeparator, $oPdo->gv( $this->sNodePath ));
		$iParent 	= $bOnlySubnodes ? $iNode : $aPath[count($aPath)-1];
		$sNodePath 	= $oPdo->gv($this->sNodePath).$this->sNodePathSeparator.$iNode;
		$sSubnodes 	= $bOnlySubnodes ? '' : $iNode > 0 ? " OR ".$this->sNodeId." = '$iNode'" : '';
		$sWhere 	= $this->sNodePath." = '$sNodePath' OR ".$this->sNodePath." LIKE '$sNodePath.%'$sSubnodes";
		$bSuccess 	= $oPdo->delete( array( 'where'=>$sWhere ) );
		// check parent childs
		$this->_update_has_childs($iParent);
		$oPdo->unlink(); unset($oPdo);
		return $bSuccess;
	}
	
	/**
	 * Order node up
	 * 
	 * Changes order. Fixes orders if there are duplicate order values
	 * and checks upper limit for optimized queries
	 * 
	 * @access 	public
	 * @param 	integer $iNode
	 * @return 	boolean
	 */
	function order_up($iNode) {
		return $this->_order($iNode,'up');
	}
	
	/**
	 * Order node down
	 * 
	 * Changes order. Fixes orders if there are duplicate order values
	 * and checks lower limit for optimized queries
	 * 
	 * @access 	public
	 * @param 	integer $iNode
	 * @return  boolean
	 */
	function order_down($iNode) {
		return $this->_order($iNode,'down');
	}
	
	/**
	 * Get node childs number
	 * 
	 * If node is zero, this finds all root nodes. Depth
	 * id used to limit how deep on tree search is made
	 * 
	 * @access 	public
	 * @param 	integer $iNode
	 * @param 	integer $iDepth default 0
	 * @return 	mixed number / boolean
	 */
	function get_childs_num( $iNode = 0, $iDepth = 0 ) {
		$oPdo = new PhpDtObject( $this->sTableName, $this->sDsn );
		if( $oPdo->init( $iNode ) ) {
			$sWhere = $iDepth > 0 ? ' AND '.$this->sNodeDepth.' <= '.($oPdo->gv( $this->sNodeDepth )+$iDepth) : '';
			$sNodePath = $oPdo->gv( $this->sNodePath ).$this->sNodePathSeparator.$iNode;
			return $oPdo->get_rows_num( $this->sNodePath." LIKE '$sNodePath%'$sWhere" );
		} else {
			if( $iNode > 0 ) {
				trigger_error( "Could not init node id: $iNode for get_childs_num method" );
				return  false;
			} else {
				$sNodePath = $this->sNodePathRoot;
				return $oPdo->get_rows_num( $this->sNodePath." LIKE '$sNodePath%'" );
			}
		}
	}
	
	/**
	 * Copy node
	 * 
	 * Copies node from source id ($iFrom) to target id ($iTo). 
	 * If target node is zero (0), then method copies nodes to root.
	 * With depth argument it is possible to limit depth of copied nodes
	 * Only subnodes argument is used for copying or not copying parent
	 * node ($iFrom)
	 * 
	 * @access 	public
	 * @param 	integer $iFrom default 0
	 * @param 	integer $iTo default 0
	 * @param 	integer $iDepth default 0
	 * @param 	boolean $bOnlySubnodes default false
	 * @return 	mixed boolean
	 */
	function copy_node( $iFrom = 0, $iTo = 0, $iDepth = 0, $bOnlySubnodes = false ) {
		
		$sNodeId 		= $this->sNodeId;
		$sNodePath 		= $this->sNodePath;
		$sNodeDepth 	= $this->sNodeDepth;
		$sNodeOrder 	= $this->sNodeOrder;
		$sNodeTitle 	= $this->sNodeTitle;
		$sNodeHasChilds = $this->sNodeHasChilds;
		// source node info
		$oPdoFrom = new PhpDtObject( $this->sTableName, $this->sDsn );
		$oPdoFrom->set_mask( array( $this->sNodeId, $this->sNodePath, $this->sNodeDepth ) );
		if( $iFrom > 0 ) {
			if( !$oPdoFrom->init($iFrom) ) {
				//trigger_error( "Could not init to node id: $iFrom for copy_node method" );
				return false;
			} else {
				$sFromNodePath 	= $oPdoFrom->gv($sNodePath).$this->sNodePathSeparator.$iFrom;
				$iFromNodeDepth = $oPdoFrom->gv($sNodeDepth);
			}
		} else {
			$sFromNodePath 		= $this->sNodePathRoot;
			$iFromNodeDepth 	= 0;
		}
		// target node info
		$oPdoTo = new PhpDtObject( $this->sTableName, $this->sDsn );
		$oPdoTo->set_mask( array( $this->sNodeId, $this->sNodePath, $this->sNodeDepth, $this->sNodeHasChilds ) );
		if( !$oPdoTo->init($iTo) ) {
			if( $iTo > 0 ) {
				//trigger_error( "Could not init to node id: $iTo for move_node method" );
				return false;
			} else {
				$iToNodePath = $this->sNodePathRoot;
			}
		} else {
			$iToNodePath = $oPdoTo->gv( $sNodePath ).$this->sNodePathSeparator.$iTo;
			// update has childs...
			if( $iTo > 0 && $oPdoTo->gv( $this->sNodeHasChilds ) == 0 ) {
				$oPdoTo->sv( $this->sNodeHasChilds, 1 );
				$oPdoTo->save();
			}
		}
		// save new nodes
		$oPdo1 				= new PhpDtObject( $this->sTableName, $this->sDsn );
		$oPdo2 				= new PhpDtObject( $this->sTableName, $this->sDsn );
		$aNodes 			= array();
		// build where clause
		$sDepth 			= $iDepth > 0 ? ' AND '.$sNodeDepth.' < '.($iFromNodeDepth+$iDepth+1) : '';
		$sSubnodes 			= $bOnlySubnodes ? '' : $iFrom > 0 ? " OR {$this->sNodeId} = $iFrom" : '';
		$sWhere 			= "$sNodePath = '$sFromNodePath' OR $sNodePath LIKE '$sFromNodePath.%'$sSubnodes";
		$aParam['where'] 	= '( '.$sWhere.' )'.$sDepth;
		$oPdo1->get_many( $aParam );
		while( $oPdo1->iterate() ) {
			$oPdo2->assign_array( $oPdo1->get_index() );
			$oPdo2->sv($sNodeId, 0);
			$iId 			= $oPdo2->save();
			$aReplace[] 	= $this->sNodePathSeparator.$iId.$this->sNodePathSeparator;
			$aFind[] 		= $this->sNodePathSeparator.$oPdo1->gv( $sNodeId ).$this->sNodePathSeparator;
			$aNodes[$iId] 	= $oPdo1->get_index();
		}
		// update new nodes with proper path and depth values
		if( !empty($aNodes) ) {
			// collect update query
			$sQuery 		= '';
			// for path fix...
			$sRootFind 		= $oPdoFrom->gv( $sNodePath ) != '' ? $bOnlySubnodes ? $oPdoFrom->gv( $sNodePath ).$this->sNodePathSeparator.$iFrom : $oPdoFrom->gv( $sNodePath ) : $this->sNodePathRoot;
			$aRootReplace 	= $iToNodePath;
			foreach( $aNodes as $iId => $aNode ) {
				// path fix
				$sPath 		= str_replace( $aFind, $aReplace, $aNode[$sNodePath].$this->sNodePathSeparator );
				$sPath 		= str_replace( $sRootFind, $aRootReplace, $sPath );
				$sPath 		= rtrim( $sPath, $this->sNodePathSeparator );
				$iDepth 	= count( explode( $this->sNodePathSeparator, $sPath ) );
				$iOrder 	= $aNode[$sNodeOrder];
				$sTitle 	= $aNode[$sNodeTitle];
				$iHasChilds = $aNode[$sNodeHasChilds];
				$sQuery 	= "UPDATE `{$this->sTableName}` SET `$sNodePath` = '$sPath', `$sNodeDepth` = $iDepth, `$sNodeOrder` = $iOrder, `$sNodeTitle` = '$sTitle', `$sNodeHasChilds` = $iHasChilds WHERE `$sNodeId` = $iId";
				$oPdo2->query($sQuery);
			}
		}
		return true;
	}

	/**
	 * Move node
	 * 
	 * Copies node from source id ($iFrom) to target id ($iTo). 
	 * If target node is zero (0), then method moves nodes to root.
	 * Only subnodes argument is used for moving or not moving parent
	 * node ($iFrom).
	 * This method checks possible collisions when trying to move node
	 * into itself.
	 * 
	 * @access 	public
	 * @param 	integer $iFrom
	 * @param 	integer $iTo default 0
	 * @param 	boolean $bOnlySubnodes default false
	 * @return 	mixed number / boolean
	 */
	function move_node( $iFrom, $iTo = 0, $bOnlySubnodes = false  ) {
		// init from & to nodes
		$oPdo = new PhpDtObject( $this->sTableName, $this->sDsn );
		$oPdo->set_mask( array( $this->sNodeId, $this->sNodePath, $this->sNodeDepth, $this->sNodeHasChilds ) );
		if( !$oPdo->init( $iFrom ) ) {
			//trigger_error( "Could not init from node id: $iFrom for move_node method" );
			return false;
		} else {
			// parent variable for _update_has_childs
			if($bOnlySubnodes){
				$iFromNodeParent = $iFrom;
			} else {
				$aPath = explode($this->sNodePathSeparator, $oPdo->gv( $this->sNodePath ));
				$iFromNodeParent = $aPath[count($aPath)-1];
			}
			// move to itself or if there is no childs available, then
			// there is no need for further actions
			if( ( $bOnlySubnodes && $oPdo->gv( $this->sNodeHasChilds ) == 0 ) || $iTo == $iFrom ) return true;
			// if source node is / is not on root
			if( $oPdo->gv( $this->sNodePath ) != $this->sNodePathRoot ) {
				$sFromNodePathWhere = $oPdo->gv( $this->sNodePath ).$this->sNodePathSeparator.$iFrom;
				$sFromNodePathReplace = $oPdo->gv( $this->sNodePath );
			} else {
				$sFromNodePathWhere = $this->sNodePathRoot.$this->sNodePathSeparator.$iFrom;
				$sFromNodePathReplace = $this->sNodePathRoot;
			}
			// variable for depth correction in update clause
			if($bOnlySubnodes) {
				$iFromNodeDepth = $oPdo->gv( $this->sNodeDepth );
			} else {
				$iFromNodeDepth = $oPdo->gv( $this->sNodeDepth )-1;
			}
		}
		$sFromNodePathWhere1 = $bOnlySubnodes ? $sFromNodePathWhere : $sFromNodePathReplace;
		if( !$oPdo->init( $iTo ) ) {
			if( $iTo > 0 ) {
				//trigger_error( "Could not init to node id: $iTo for move_node method" );
				return false;
			} else {
				$sToNodePathReplace = $this->sNodePathRoot;
				$iToNodeDepth 		= 0;
			}
		} else {
			$sToNodePathReplace = $oPdo->gv( $this->sNodePath  ).$this->sNodePathSeparator.$iTo;
			$iToNodeDepth 		= $oPdo->gv( $this->sNodeDepth );
		}
		// moving child to first parent wihtout only subnodes needs no further actions
		if( $iTo == $iFromNodeParent && !$bOnlySubnodes ) return true;
		// moving parent to its child is not possible
		if( strpos( $sToNodePathReplace.$this->sNodePathSeparator, $this->sNodePathSeparator.$iFrom.$this->sNodePathSeparator ) ) return false;
		// update target node_has_childs...
		if( $iTo > 0 && $oPdo->gv( $this->sNodeHasChilds ) == 0 ) {
			$oPdo->sv( $this->sNodeHasChilds, 1 );
			$oPdo->save();
		}
		// update paths
		$sSubnodes = $bOnlySubnodes ? '' : $iFrom > 0 ? " OR {$this->sNodeId} = $iFrom" : '';
		$iDepthCorrection = $iToNodeDepth - $iFromNodeDepth;
		$oPdo->query( "UPDATE {$this->sTableName} SET {$this->sNodePath} = REPLACE( {$this->sNodePath}, '$sFromNodePathWhere1', '$sToNodePathReplace' ), {$this->sNodeDepth} = {$this->sNodeDepth} + $iDepthCorrection WHERE {$this->sNodePath} = '$sFromNodePathWhere' OR {$this->sNodePath} LIKE '$sFromNodePathWhere.%'$sSubnodes;" );
		// update parent node_has_childs after update paths
		$this->_update_has_childs($iFromNodeParent);
		return true;
	}
	
	/****************************************************************
	 ** 					  PRIVATE METHODS
	 ***************************************************************/
	
	/**
	 * Update node_has_childs field
	 * Used on move_node, delete_node
	 * Checks if iNode is root or empty, when update is not needed
	 * 
	 * @access 	private
	 * @param 	integer $iNode
	 * @return 	void
	 */
	function _update_has_childs($iNode) {
		if( $iNode == $this->sNodePathRoot || $iNode == '' ) return true;
		$oPdo = new PhpDtObject( $this->sTableName, $this->sDsn );
		$oPdo->set_mask( array( $this->sNodeId, $this->sNodePath, $this->sNodeHasChilds ) );
		if( $oPdo->init($iNode) ) {
			$sPath = $oPdo->gv($this->sNodePath); //.$this->sNodePathSeparator.$iNode;
			//$sPath = $sPath != '' ? $sPath : $this->sNodePathRoot;
			$oPdo->sv( $this->sNodeHasChilds, $this->_has_childs( $iNode, $sPath ) ? 1 : 0 );
			return $oPdo->save();
		} else {
			trigger_error( "Could not init node id: $iNode for _update_has_childs method" );
			return false;
		}
	}
	
	/**
	 * This method is for internal usage. Checks if node really has childs.
	 * End user must have node_has_childs field correctly set and this method
	 * checks it
	 * 
	 * @access 	private
	 * @param 	integer $iNode
	 * @param 	string $sNodePath default null
	 * @return 	boolean
	 */
	function _has_childs( $iNode = 0, $sNodePath = null ) {
		$oPdo = new PhpDtObject( $this->sTableName, $this->sDsn );
		$oPdo->set_mask( array( $this->sNodeId, $this->sNodePath ) );
		if( isset( $sNodePath ) ) {
			$sNodePath = $sNodePath.$this->sNodePathSeparator.$iNode;
			return $oPdo->get_rows_num( $this->sNodePath." = '$sNodePath'" ) ? true : false;
		} else if( $oPdo->init( $iNode ) ) {
			$sNodePath = $oPdo->gv( $this->sNodePath ).$this->sNodePathSeparator.$iNode;
			return $oPdo->get_rows_num( $this->sNodePath." = '$sNodePath'" ) ? true : false;
		} else {
			if( $iNode > 0 ) {
				trigger_error( "Could not init node id: $iNode for has_childs method" );
				return false;
			} else {
				$sNodePath = $this->sNodePathRoot;
				return $oPdo->get_rows_num( $this->sNodePath." = '$sNodePath'" ) ? true : false;
			}
		}
	}
	
	/**
	 * Get next node order number
	 * 
	 * Argument must be path of target node!
	 * Used on add_node, move_node, delete_node,...
	 * 
	 * @access 	private
	 * @param 	string $sNodePath
	 * @return 	integer
	 */
	function _get_next_order( $sNodePath ) {
		$q = 'SELECT '.$this->sNodeId.', '.$this->sNodeOrder.' FROM '.$this->sTableName.' WHERE '.$this->sNodePath.' = \''.$sNodePath.'\' ORDER BY '.$this->sNodeOrder.' DESC LIMIT 1';
		$oPdo = new PhpDtObject( $this->sTableName, $this->sDsn );
		$oPdo->set_mask( array( $this->sNodeId, $this->sNodeOrder ) );
		$oPdo->query( $q ); 
		$oPdo->iterate();
		return $oPdo->gv( $this->sNodeOrder ) == '' ? 0 : $oPdo->gv( $this->sNodeOrder )+1;
	}
	
	/**
	 * Fixes duplicate order numers
	 * 
	 * Used on methods: _order,...
	 *
	 * @access 	private
	 * @param 	string $sNodePath
	 * @return 	void
	 */
	function _fix_orders( $sNodePath ) {
		$oPdo = new PhpDtObject( $this->sTableName, $this->sDsn );
		$oPdo->set_mask( array( $this->sNodeId, $this->sNodeOrder ) );
		$sWhere = "{$this->sNodePath} = '$sNodePath'";
		$q = "SELECT {$this->sNodeId}, count({$this->sNodeOrder}) AS c FROM {$this->sTableName} WHERE $sWhere GROUP BY {$this->sNodeOrder}";
		$oPdo->query($q);
		$bHit = false;
		while( $oPdo->iterate() ) {
			if( $oPdo->gv('c') > 1 ) {
				$bHit = true;
				break;
			}
		}
		if( $bHit ) {
			$oPdo2 = new PhpDtObject( $this->sTableName, $this->sDsn );
			$oPdo2->set_mask( array( $this->sNodeId, $this->sNodeOrder ) );
			$aParam['where'] = $sWhere;
			$aParam['order by'] = "{$this->sNodeOrder} ASC";
			$oPdo->get_many($aParam);
			$r=0;
			while($oPdo->iterate()) {
				$q = "UPDATE {$this->sTableName} SET {$this->sNodeOrder} = $r WHERE {$this->sNodeId} = ".$oPdo->gv($this->sNodeId);
				$oPdo2->query($q);
				$r++;
			}
		}
	}
	
	/**
	 * Order node up and down helper / factorizing method
	 * 
	 * @access 	private
	 * @param 	integer $iNode
	 * @param 	string $sMode
	 * @return  boolean
	 */
	function _order($iNode,$sMode) {
		if( $sMode == 'up' ) {
			$sAritm1 = '<';
			$sAritm2 = '+';
			$sOrder = 'DESC';
		} else if( $sMode == 'down' ) {
			$sAritm1 = '>';
			$sAritm2 = '-';
			$sOrder = 'ASC';
		}
		$oPdo = new PhpDtObject( $this->sTableName, $this->sDsn );
		$oPdo->set_mask( array( $this->sNodeId, $this->sNodePath, $this->sNodeOrder ) );
		if( $oPdo->init($iNode) ) {
			// check and fix if there is same order numbers...
			$this->_fix_orders( $oPdo->gv( $this->sNodePath ) );
			// get node info
			$oPdo->init($iNode);
			$iOrder1 = $oPdo->gv( $this->sNodeOrder );
			$aParam['where'] = "{$this->sNodePath} = '".$oPdo->gv( $this->sNodePath );
			$aParam['where'] .= "' AND {$this->sNodeOrder} $sAritm1 ".$oPdo->gv($this->sNodeOrder);
			$aParam['order by'] = "{$this->sNodeOrder} $sOrder";
			$aParam['limit'] = 1;
			// if node is first or last no further actions is needed
			$oPdo2 = new PhpDtObject( $this->sTableName, $this->sDsn );
			$oPdo2->set_mask( array( $this->sNodeId, $this->sNodePath, $this->sNodeOrder ) );
			if( !$oPdo2->get_many($aParam) ) return true;
			$oPdo2->iterate();
			$iOrder2 = $oPdo2->gv( $this->sNodeOrder );
			// calculate cap
			if( $sMode == 'up' ) { $iCap = ($iOrder1-1)-$iOrder2; }
			else if( $sMode == 'down' ) { $iCap = $iOrder2-$iOrder1-1; }
			if( $iCap == 0 ) {
				// next node is order + 1
				$oPdo->sv( $this->sNodeOrder, $iOrder2 );
				$oPdo2->sv( $this->sNodeOrder, $iOrder1 );
				$oPdo2->save();
				$oPdo->save();
			} else {
				// next node is order + 1 + n
				$sQuery = "UPDATE {$this->sTableName} SET {$this->sNodeOrder} = {$this->sNodeOrder} $sAritm2 $iCap WHERE {$aParam['where']}";
				$oPdo3 = new PhpDtObject( $this->sTableName, $this->sDsn );
				$oPdo3->query($sQuery);
				$oPdo3->get_many($aParam);
				$oPdo3->iterate();
				$iOrder2 = $oPdo3->gv( $this->sNodeOrder );
				$oPdo->sv( $this->sNodeOrder, $iOrder2 );
				$oPdo3->sv( $this->sNodeOrder, $iOrder1 );
				$oPdo3->save();
				$oPdo->save();
				unset($oPdo3);
			}
			unset($oPdo2);
			$oPdo->unlink(); unset($oPdo);
			return true;
		}
		return false;
	}
}
?>