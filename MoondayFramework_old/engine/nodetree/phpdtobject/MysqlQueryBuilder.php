<?php 
/**
* @package MysqlQueryBuilder
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc 
* @uses
* @example
* @files
*/
/**
 * MysqlQueryBuilder
 * Mysql database query builder handles all query building for 
 * PhpDtObject_Db implementations
 */
class MysqlQueryBuilder
{
	/**
	 * @var string $sTargetTable
	 */
	var $sTargetTable;
	
	/**
	 * Constructor
	 * @param string $sTargetTable 
	 */ 	
	function MysqlQueryBuilder( $sTargetTable ) {
		$this->sTargetTable = $sTargetTable;
	}
	
	/*
	SELECT
    [ALL | DISTINCT | DISTINCTROW ]
      [HIGH_PRIORITY]
      [STRAIGHT_JOIN]
      [SQL_SMALL_RESULT] [SQL_BIG_RESULT] [SQL_BUFFER_RESULT]
      [SQL_CACHE | SQL_NO_CACHE] [SQL_CALC_FOUND_ROWS]
    select_expr, ...
    [INTO OUTFILE 'file_name' export_options
      | INTO DUMPFILE 'file_name']
    [FROM table_references
      [WHERE where_definition]
      [GROUP BY {col_name | expr | position}
        [ASC | DESC], ... [WITH ROLLUP]]
      [HAVING where_definition]
      [ORDER BY {col_name | expr | position}
        [ASC | DESC] , ...]
      [LIMIT {[offset,] row_count | row_count OFFSET offset}]
      [PROCEDURE procedure_name(argument_list)]
      [FOR UPDATE | LOCK IN SHARE MODE]]
	 */
	/**
	 * @return string
	 * @param array $aParams
	 * @param array $aFields
	 * @see http://dev.mysql.com/doc/mysql/en/select.html
	 */ 
	function select_query( $aParams, $aFields ) {
		$aParams 	= $this->_keystoupper( $aParams );
		$sAction 	= 'SELECT';
		$sFields 	= isset( $aParams['SELECT'] ) ? $aParams['SELECT'] : implode( ", ", $aFields );
		$sFrom 		= isset( $aParams['FROM'] ) ? 'FROM `'.$aParams['FROM'].'`' : 'FROM `'.$this->sTargetTable.'`';
		$sWhere 	= isset( $aParams['WHERE'] ) ? 'WHERE '.$aParams['WHERE'] : 'WHERE 1';
		$sGroupBy 	= isset( $aParams['GROUP BY'] ) ? 'GROUP BY '.$aParams['GROUP BY'] : '';
		$sHaving 	= isset( $aParams['HAVING'] ) ? 'HAVING '.$aParams['HAVING'] : '';
		$sOrderBy 	= isset( $aParams['ORDER BY'] ) ? 'ORDER BY '.$aParams['ORDER BY'] : '';
		$sLimit 	= isset( $aParams['LIMIT'] ) ? 'LIMIT '.$aParams['LIMIT'] : '';
		$sOffset 	= isset( $aParams['OFFSET'] ) ? 'OFFSET '.$aParams['OFFSET'] : '';
		$sProcedure = isset( $aParams['PROCEDURE'] ) ? 'PROCEDURE '.$aParams['PROCEDURE'] : '';
		
		$sQuery 	= "$sAction $sFields $sFrom $sWhere $sGroupBy $sHaving $sOrderBy $sLimit $sOffset $sProcedure";
		return $sQuery;
	}

	/*
	UPDATE [LOW_PRIORITY] [IGNORE] tbl_name
		SET col_name1=expr1 [, col_name2=expr2 ...]
		[WHERE where_definition]
		[ORDER BY ...]
		[LIMIT row_count]
		
	!!! Multiple-table syntax is not supported !!!
	
	UPDATE [LOW_PRIORITY] [IGNORE] table_references
		SET col_name1=expr1 [, col_name2=expr2 ...]
		[WHERE where_definition]
	*/
	/**
	 * @return string
	 * @param array $aParams
	 * @param array $aFields
	 * @see http://dev.mysql.com/doc/mysql/en/update.html
	 */ 
	function update_query( $aParams, $aFields ) {
		$aParams 	= $this->_keystoupper( $aParams );
		$sAction 	= 'UPDATE';
		$sTable 	= isset( $aParams['TABLE'] ) ? '`'.$aParams['TABLE'].'`' : '`'.$this->sTargetTable.'`';
		$sWhere 	= isset( $aParams['WHERE'] ) ? 'WHERE '.$aParams['WHERE'] : '';
		$sOrderBy 	= isset( $aParams['ORDER BY'] ) ? 'ORDER BY '.$aParams['ORDER BY'] : '';
		$sLimit 	= isset( $aParams['LIMIT'] ) ? 'LIMIT '.$aParams['LIMIT'] : '';
		$sLowPrior 	= isset( $aParams['LOW_PRIORITY'] ) ? $aParams['LOW_PRIORITY'] : '';
		$sIgnore	= isset( $aParams['IGNORE'] ) ? $aParams['IGNORE'] : '';
		
		$sQuery 	= '';
		$sKeyValues = $this->_get_set_clause( $aFields );
		$sQuery 	= "$sAction $sLowPrior $sIgnore $sTable SET $sKeyValues $sWhere $sOrderBy $sLimit";
		return $sQuery;
	}

	/*
	INSERT [LOW_PRIORITY | DELAYED | HIGH_PRIORITY] [IGNORE]
		[INTO] tbl_name [(col_name,...)]
		VALUES ({expr | DEFAULT},...),(...),...
		[ ON DUPLICATE KEY UPDATE col_name=expr, ... ]
	Or:
	
	INSERT [LOW_PRIORITY | DELAYED | HIGH_PRIORITY] [IGNORE]
		[INTO] tbl_name
		SET col_name={expr | DEFAULT}, ...
		[ ON DUPLICATE KEY UPDATE col_name=expr, ... ]
	Or:
	
	INSERT [LOW_PRIORITY | HIGH_PRIORITY] [IGNORE]
		[INTO] tbl_name [(col_name,...)]
		SELECT ...
		[ ON DUPLICATE KEY UPDATE col_name=expr, ... ]
	*/
	/**
	 * @return string
	 * @param array $aParams
	 * @param array $aFields
	 * @see http://dev.mysql.com/doc/mysql/en/insert.html
	 */ 
	function insert_query( $aParams, $aFields ) {
		$aParams 	= $this->_keystoupper( $aParams );
		$sAction 	= 'INSERT';
		$sTable 	= isset( $aParams['INTO'] ) ? 'INTO `'.$aParams['INTO'].'`' : 'INTO `'.$this->sTargetTable.'`';
		$sDuplicate = isset( $aParams['ON DUPLICATE KEY UPDATE'] ) ? 'ON DUPLICATE KEY UPDATE '.$aParams['ON DUPLICATE KEY UPDATE'] : '';
		$sSelect 	= isset( $aParams['SELECT'] ) ? 'SELECT '.$aParams['SELECT'] : '';
		
		$sQuery = '';
		if( $sSelect == '' ) {
			$sKeyValues = $this->_get_set_clause( $aFields );
			$sQuery = "$sAction $sTable SET $sKeyValues $sDuplicate";
		} else {
			$sQuery = "$sAction $sTable $sSelect $sDuplicate";
		}
		return $sQuery;
	}

	/**
	 * Creates set clause for update and insert
	 * @return string
	 * @param array $aFields
	 * @see http://dev.mysql.com/doc/mysql/en/insert.html
	 */ 
	function _get_set_clause( $aFields ) {
		$sSetClause = '';
		foreach( $aFields as $key => $val ) {
			switch( gettype( $val ) ) {
				case 'boolean':
					$val = $val ? 1 : 0;
					break;
				case 'NULL':
					$val = 'NULL';
					break;
				case 'string':
					$val = "'$val'";
					break;
				case 'integer':
					$val = $val;
					break;
				case 'double':
					$val = $val;
					break;
				case 'array':
					$val = "'".implode( ',', $val )."'";
					break;
				case 'object':
					$val = "'".addslashes( serialize( $val ) )."'";
					break;
				default:
					$val = "'$val'";
					break;
			}
			$sSetClause .= "`".$key."` = $val, ";
		}
		return substr( $sSetClause, 0, strlen( $sSetClause ) - 2 );
	}
	 
	/*
	Single-table syntax:
	
	DELETE [LOW_PRIORITY] [QUICK] [IGNORE] FROM tbl_name
		   [WHERE where_definition]
		   [ORDER BY ...]
		   [LIMIT row_count]
		   
	Multiple-table syntax:
	
	!!! this is not supported !!!
	DELETE [LOW_PRIORITY] [QUICK] [IGNORE]
		   tbl_name[.*] [, tbl_name[.*] ...]
		   FROM table_references
		   [WHERE where_definition]
	Or:
	
	DELETE [LOW_PRIORITY] [QUICK] [IGNORE]
		   FROM tbl_name[.*] [, tbl_name[.*] ...]
		   USING table_references
		   [WHERE where_definition]
	*/
	/**
	 * @return string
	 * @param array $aParams
	 * @see http://dev.mysql.com/doc/mysql/en/delete.html
	 */ 
	function delete_query( $aParams ) {
		$aParams 	= $this->_keystoupper( $aParams );
		$sAction 	= 'DELETE';
		$sFrom 		= isset( $aParams['FROM'] ) ? 'FROM `'.$aParams['FROM'].'`' : 'FROM `'.$this->sTargetTable.'`';
		$sWhere 	= isset( $aParams['WHERE'] ) ? 'WHERE '.$aParams['WHERE'] : '';
		$sOrderBy 	= isset( $aParams['ORDER BY'] ) ? 'ORDER BY '.$aParams['ORDER BY'] : '';
		$sLimit 	= isset( $aParams['LIMIT'] ) ? 'LIMIT '.$aParams['LIMIT'] : '';
		$sUsing 	= isset( $aParams['USING'] ) ? 'USING '.$aParams['USING'] : '';
		
		$sQuery = '';
		if( $sUsing == '' ) {
			$sQuery = "$sAction $sFrom $sWhere $sOrderBy $sLimit";
		} else {
			$sQuery = "$sAction $sFrom $sUsing $sWhere";
		}
		return $sQuery;
	}
	
	/**
	 * @param string $sDbName
	 * @param string $sTableName
	 * @return string
	 */
	function show_tables_query( $sDbName, $sTableName ) {
		return "SHOW TABLES FROM `$sDbName` LIKE '$sTableName'";
	}

	/**
	 * @param string $sTableName
	 * @return string
	 */
	function show_keys_query( $sTableName ) {
		return "SHOW KEYS FROM `$sTableName`";
	}

	/**
	 * Changes array keys to upper case
	 * @param array $aItems
	 * @return aItems
	 * @access private
	 */
	function _keystoupper( $aItems ) {
		return array_change_key_case( $aItems, CASE_UPPER );
		/*
		foreach( $aItems as $k=>$v ) {
			unset( $aItems[$k] );
			$aItems[strtoupper($k)] = $v;
		}
		return $aItems;
		*/
	}
}
?>