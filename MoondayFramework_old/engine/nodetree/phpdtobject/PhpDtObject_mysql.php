<?php
/**
* @package PhpDtObject_Mysql
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc 
* @uses
* @example
* @files
*/
//PHP 4 does not support interfaces on this class!
//include_once( 'PhpDtObject_db.php' );
include_once( 'MysqlQueryBuilder.php' );

class PhpDtObject_Mysql
{
	/**
	 * @var string
	 */
	var $sTargetTable;
	/**
	 * @var array
	 */
	var $aDbPrefs;
	/**
	 * @var object mysql link
	 */
	var $oLink;
	/**
	 * @var object mysql result
	 */
	var $oResult;
	/**
	 * @var array
	 */
	var $aTableIndex;
	/**
	 * @var integer
	 */
	var $iAffectedRowsNum;
	/**
	 * @var integer
	 */
	var $iLastInsertId;
	/**
	 * @var integer
	 */
	var $iLastSelectNumRows;
	/**
	 * @var integer
	 */
	var $sPrimaryKey;
	/**
	 * @var integer
	 */
	var $iTotalQueryTime;
	/**
	 * @var integer
	 */
	var $bIsConnected;
	/**
	 * Constructor
	 * @param string $sTargetTable
	 * @param array $aDbPrefs
	 * @access public
	 */
	function PhpDtObject_Mysql( $sTargetTable, $aDbPrefs ) {
		$this->sTargetTable 		= $sTargetTable;
		$this->aDbPrefs 			= $aDbPrefs;
	 	$this->iAffectedRowsNum		= 0;
		$this->iLastInsertId		= 0;
		$this->iLastSelectNumRows 	= 0;
		$this->iTotalQueryTime 		= 0;
		$this->aTableIndex 			= array();
		$this->sPrimaryKey 			= '';
		$this->bIsConnected 		= false;
		// make database connection link
		$this->oLink = mysql_connect( $aDbPrefs['hostspec'], $aDbPrefs['username'], $aDbPrefs['password'] ) 
			or trigger_error( 'Could not connect to database'.mysql_error(), E_USER_ERROR );
			
		$this->bIsConnected = mysql_select_db( $aDbPrefs['database'], $this->oLink ) 
			or trigger_error( 'Could not select database: '.$aDbPrefs['database'].' '.mysql_error(), E_USER_ERROR );
		// check, that target table exists on selected database
		if( !$this->_check_table() ) {
			trigger_error( 'Target table ('.$sTargetTable.') not found from the database ('.$aDbPrefs['database'].')', E_USER_WARNING );
			$this->bIsConnected = false;
		} else {
			$this->bIsConnected = true;
		}
		// populate index variable with target table column names 
		// -> index as an associated array
		$this->_populate_index();
		$this->_set_primary_key();
	}

	/************************************************
	 **                PUBLIC METHODS
	 ***********************************************/
	/**
	 * Fetch associative array
	 * @return mixed array / boolean
	 * @access public
	 */
	function fetch_assoc() {
		return $this->_is_valid_result() ? mysql_fetch_assoc( $this->oResult ) : false;
	}
	/**
	 * Fetch array
	 * @return mixed array / boolean
	 * @access public
	 */
	function fetch_row() {
		return $this->_is_valid_result() ? mysql_fetch_row( $this->oResult ) : false;
	}
	/**
	 * Fetch object
	 * @return mixed object / boolean
	 * @access public
	 */
	function fetch_object() {
		return $this->_is_valid_result() ? mysql_fetch_object( $this->oResult ) : false;
	}

	/**
	 * Makes select query and feeds up result set for further activity
	 * return number of selected rows
	 * @return mixed
	 * @param array $aParams
	 * @access public
	 */
	function select( $aParams, $aFields ) {
		$oMqb = new MysqlQueryBuilder( $this->sTargetTable );
		$sQuery = $oMqb->select_query( $aParams, $aFields );
		unset( $oMqb );

        if( $this->query( $sQuery ) ) {
			$this->iLastSelectNumRows = mysql_num_rows( $this->oResult );
			// Dont free result here!!! $this->free_result();
			return $this->iLastSelectNumRows;
        } else {
			return false;
		}
    }
	
	/**
	 * @return resultset
	 * @param string $sQuery
	 * @access public
	 */
	function query( $sQuery ) {
		static $iCount = 0; $iCount++;
		
		$this->_check_debug( 's_query '.$iCount, $sQuery );
		
		$iStartTime = array_sum( explode( " ", microtime() ) );
		$this->oResult = mysql_query( $sQuery, $this->oLink );
		$this->iTotalQueryTime += array_sum( explode( " ", microtime() ) ) - $iStartTime;
		$GLOBALS['total_query_time'] += array_sum( explode( " ", microtime() ) ) - $iStartTime;
		
		$this->_check_debug( 'e_query '.$iCount );
		
		if( !$this->oResult ) {
			trigger_error( 'Error on query: '.$sQuery.' '.mysql_error( $this->oLink ) );
		}
		return $this->oResult;
	}

	/**
	 * Free resultset
	 * @return void
	 * @access public
	 */
	function free_result() {
		if( $this->_is_valid_result() ) mysql_free_result( $this->oResult );
	}
	
	/**
	 * Get last insert id
	 * @return mixed
	 * @access public
	 */
	function get_last_insert_id() { return mysql_insert_id(); }
	
	/**
	 * Close connection
	 * @return void
	 * @access public
	 */
	function unlink() {
		mysql_close( $this->oLink );
	}
	/**
	 * Insert clause
	 *
	 * @param array $aParams
	 * @param array $aFields
	 * @return mixed
	 * @access public
	 */
	function insert( $aParams, $aFields ) {
		$oMqb = new MysqlQueryBuilder( $this->sTargetTable );
		$sQuery = $oMqb->insert_query( $aParams, $aFields );
		unset( $oMqb );
		
		if( $this->query( $sQuery ) ) {
			$this->iAffectedRowsNum = mysql_affected_rows( $this->oLink );
			$this->free_result();
			return mysql_insert_id( $this->oLink );
		} else {
			return false;
		}
	}

	/**
	 * Update clause
	 *
	 * @param array $aParams
	 * @param array $aFields
	 * @return mixed number of affected rows or false on invalid result
	 * @access public
	 */
	function update( $aParams, $aFields ) {
		$oMqb = new MysqlQueryBuilder( $this->sTargetTable );
		$sQuery = $oMqb->update_query( $aParams, $aFields );
		unset( $oMqb );
		
		if( $this->query( $sQuery ) ) {
			$this->iAffectedRowsNum = mysql_affected_rows( $this->oLink );
			return $this->iAffectedRowsNum;
		} else {
			return false;
		}
	}
	
	/**
	 * @return mixed number of affected rows or false
	 * @param array $aParams
	 * @access public
	 * @see http://dev.mysql.com/doc/mysql/en/delete.html
	 */ 
	function delete( $aParams ) {
		$oMqb = new MysqlQueryBuilder( $this->sTargetTable );
		$sQuery = $oMqb->delete_query( $aParams );
		unset( $oMqb );
		
		if( $this->query( $sQuery ) ) {
			$this->iAffectedRowsNum = mysql_affected_rows( $this->oLink );
			return $this->iAffectedRowsNum;
		}
		return false;
	}
	
	/************************************************
	 **                PRIVATE METHODS
	 ***********************************************/
	/**
	 * Checks that given table exists on selected database
	 *
	 * @return boolean
	 * @access private
	 */
	function _check_table() {
		$oMqb = new MysqlQueryBuilder( $this->sTargetTable );
		$sQuery = $oMqb->show_tables_query( $this->aDbPrefs['database'], $this->sTargetTable );
		unset( $oMqb );
		
		$this->query( $sQuery );
   		$bHasTable = $this->_is_valid_result() && mysql_num_rows( $this->oResult ) > 0 ? true : false;
		$this->free_result();
		return $bHasTable;
	}
	
	/**
	 * Populates table index array with table field / column names
	 * 
	 * @return void
	 * @access private
	 */
	function _populate_index() {
		// get fields from target table and set them as keys to the index array
		$aFields = mysql_list_fields( $this->aDbPrefs['database'], $this->sTargetTable, $this->oLink );
		$aColumns = mysql_num_fields( $aFields );
		for ( $i = 0; $i < $aColumns; $i++ ) {
			$sField = mysql_field_name( $aFields, $i );
			$this->aTableIndex[$sField] = '';
		}
	}
	
	/**
	 * Returns primary key of initialized table
	 * @return void
	 * @access private
	 */
	function _set_primary_key() {
		$aKeys = $this->_get_primary_keys();
		if( count( $aKeys ) > 1 ) {
			trigger_error( 'Could not initialize phpdtobject. Multiple primary keys are not supported on init method.' );
			$this->bIsConnected = false;
		} else if( count( $aKeys ) < 1 ) {
			trigger_error(  'Could not initialize phpdtobject. One primary key is mandatory on init method.' );
			$this->bIsConnected = false;
		} else {
			$this->sPrimaryKey = $aKeys[0];
			$this->bIsConnected = true;
		}
	}	

	/**
	 * Returns primary keys of initialized table
	 * @return array
	 * @access private
	 */
    function _get_primary_keys() {
		$oMqb = new MysqlQueryBuilder( $this->sTargetTable );
		$sQuery = $oMqb->show_keys_query( $this->sTargetTable );
		unset( $oMqb );

		$aKeys = array();
		if( $this->query( $sQuery ) ) {
			while ( $row = $this->fetch_assoc() ) {
				if ( $row['Key_name'] == 'PRIMARY' ) {
					$aKeys[$row['Seq_in_index'] - 1] = $row['Column_name'];
				}
			}
			$this->free_result();
		}
		return $aKeys;
    }
   
    /**
     * Debug queries private handler
     *
     * @param string $sParam1
     * @param string $sParam2
   	 * @return void
	 * @access private
     */
   	function _check_debug( $sParam1, $sParam2 = '' ) {
		if( isset($GLOBALS['debug_queries']) && $GLOBALS['debug_queries'] ) {
			// use debugger class if available
			if( class_exists( 'Debugger' ) ) {
				$instance =& Singleton::get_instance( 'Debugger' );
				$instance->set( $sParam1, $sParam2 );
			} else if(!preg_match('/e_query/', $sParam1)) {
				if( isset($GLOBALS['debug_queries_only_relevant']) && $GLOBALS['debug_queries_only_relevant'] ) {
					if( !preg_match( '/SHOW TABLES FROM/', $sParam2 ) && !preg_match( '/SHOW KEYS FROM/', $sParam2 ) && !preg_match( '/e_query/', $sParam1 ) && $sParam2 != '' ) {
						$GLOBALS['total_queries'][] = $sParam2;
					}
				} else {
					$GLOBALS['total_queries'][] = $sParam2;
				}
			}
		}
	}
	
	/**
	 * Is valid result
	 * @return boolean
	 * @access private
	 */
	function _is_valid_result() {
		if( gettype( $this->oResult ) == 'resource' ) {
			return true;
		} else {
			//trigger_error( 'Result set, mysql resource is not valid.', E_USER_NOTICE );
			return false;
		}
	}
}
?>