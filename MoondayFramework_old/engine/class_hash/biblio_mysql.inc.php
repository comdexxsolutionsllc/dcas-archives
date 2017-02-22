<?php
/**
* @package 
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc 
* @uses
* @example
* @files
*/



////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Declaration                                                                                            //
// -----------                                                                                            //
// mysql_select($db_base,$fields,$tables,$where="",$order_by="",$group_by="",$having="",$limit="")        //
// mysql_rawquery($db_base,$query)                                                                        //
// mysql_insert($db_base,$table,$liste_champs,$liste_valeur)                                              //
// mysql_update($db_base,$table,$liste_champs,$liste_valeur,$where)                                       //
// mysql_delete($db_base,$table,$where)                                                                   //
// mysql_next_index($db_base,$index,$table)                                                               //
// mysql_select_diff($db_base,$query_plus,$query_moins)                                                   //
// mysql_select_value($db_base,$query,default="")                                                         //
////////////////////////////////////////////////////////////////////////////////////////////////////////////

// save of the last db connected
$db_last="";
	
	/**
	 * mysql_rawquery()   : make a mysql query
	 * 
	 * @param $db_base		: database to access
	 * @param $query			: query to launch
	 * @return 
	 */
	function mysql_rawquery($db_base,$query) {
		global $db_host,$db_user,$db_password,$db_last;
		if ($db_base!=$db_last) {
			mysql_connect($db_host[$db_base],$db_user[$db_base],$db_password[$db_base]) or die(mysql_error()." ".mysql_errno());
			mysql_select_db($db_base);
			$db_last=$db_base;
		}		
			  
		$db_result=@mysql_query($query) or die("Erreur n�".mysql_errno().": \""/*.mysql_error()*/."\" dans la requete: [".$query."]");
		if (strtoupper(substr($query,0,6))=="SELECT") { // have to process data to return because SELECT query
			$num_row=mysql_num_rows($db_result);
			for ($res=array(),$i=0;$i<$num_row;$i++)
					$res[$i]=mysql_fetch_assoc($db_result);
			return $res;
		}
	}
	
	/**
	 * mysql_select()     : make a mysql select
	 * 
	 * @param $db_base    : database to access
	 * @param $fields     : list of field to select
	 * @param $tables     : list names of the tables
	 * @param $where      : where condition
	 * @param $order_by   : fields to be ordered by
	 * @param $group_by   : fields to be groupered by
	 * @param $having     : having condition
	 * @param $limit      : limit clause
	 * @return 
	 */
	function mysql_select($db_base,$fields,$tables,$where="",$order_by="",$group_by="",$having="",$limit="") {
		$sql="SELECT $fields FROM $tables ";
		if (!empty($where)) $sql.="WHERE $where ";  
		if (!empty($group_by)) $sql.="GROUP BY $group_by ";  
		if (!empty($order_by)) $sql.="ORDER BY $order_by ";  
		if (!empty($having)) $sql.="HAVING $having ";  
		if (!empty($limit)) $sql.="LIMIT $limit ";
		return msyql_rawquery($db_base,$sql);
	}
	
	/**
	 * mysql_insert()				: make a mysql insert
	 * 
	 * @param $table				: name of the table
	 * @param $liste_champs : array of the field to insert
	 * @param $liste_valeur	: array of the valued of the field to insert
	 * @return 
	 */
	function mysql_insert($db_base,$table,$liste_champs,$liste_valeur) {
		$sql="INSERT INTO `$table` ";
		if (count($liste_champs)==count($liste_valeur)+1) // have to find next_id and insert in $liste_valeur
			array_unshift($liste_valeur,mysql_next_index($db_base,$liste_champs[0],$table));
		$temp1=implode("`,`",$liste_champs);
		$temp2=implode("','",$liste_valeur);
		$sql.="(`$temp1`) VALUES ('$temp2')";
		mysql_rawquery($db_base,$sql);
	}

	/**
	 * mysql_update()				: make a mysql update
	 * 
	 * @param $table				: name of the table
	 * @param $liste_champs	: array of the field to update
	 * @param $liste_valeur	: array of the valued of the field to update
	 * @param $where				: where condition
	 * @return 
	 */
	function mysql_update($db_base,$table,$liste_champs,$liste_valeur,$where) {
		if ($where!="") {
			$sql="UPDATE `$table` SET ";
			for ($i=0;$i<count($liste_champs);$i++)
				$sql.="`".$liste_champs[$i]."`='".$liste_valeur[$i]."'".(($i==count($liste_champs)-1)?"":" , ");
			$sql.=" WHERE ($where)";
			mysql_rawquery($db_base,$sql);
		}
	}
		
	/**
	 * mysql_delete()			: make a mysql delete
	 * 
	 * @param $db_base		: database to access
	 * @param $table			: name of the table
	 * @param $where			: where condition
	 * @return 
	 */
	function mysql_delete($db_base,$table,$where) {
		if ($where!="") {
			$sql="DELETE FROM `$table` WHERE ($where)";
			mysql_rawquery($db_base,$sql);
		}
	}
	
	
	/**
	 * mysql_next_index()	: find the most free little index of the table
	 * 
	 * @param $db_base		: database to access
	 * @param $index			: the name of the index column
	 * @param $table			: name of the table
	 * @return 
	 */
	function mysql_next_index($db_base,$index,$table) {
		$tab=mysql_rawquery($db_base,"SELECT $index FROM $table ORDER BY $index DESC LIMIT 0,1");
		//print_r($tab);
		if (count($tab)==0)
			return 0;
		else
			return $tab[0][$index]+1;
/*			if (count($tab)==$tab[count($tab)-1][$index]+1)
				return count($tab);
			else // pour l'instant recherche lineaire, ensuite voir une recherche dichotomique
				for ($i=0;true;$i++)
					if (($i!=$tab[$i][$index])&&($tab[$i][$index]!=-1))
						return $i;*/
	}
	
	/**
	 * mysql_select_diff()	: make a select a,b,c,d from table1 where (a not in select a from table2 where ())and/or()
	 * 
	 * @param $db_base			: database to access
	 * @param $query_plus		: select of the lines we want
	 * @param $query_moins: !! select of the lines we don't want (!! 1 column only)
	 * @return
	 * 
	 */
	function mysql_select_diff($db_base,$query_plus,$query_moins) {
		//echo $query_plus,"<br>",$query_moins,"<br>\n";
		$tab_plus=mysql_rawquery($db_base,$query_plus);
		if ($query_moins!="") {
			$tab_moins=mysql_rawquery($db_base,$query_moins);
			if (count($tab_moins)>0) {	
				$keys1=array_keys($tab_plus[0]);
				$keys2=array_keys($tab_moins[0]);
				for ($i=0,$res=array();$i<count($tab_plus);$i++) {
					for ($j=0,$find=false;$j<count($tab_moins);$j++)
						if ($tab_moins[$j][$keys2[0]]==$tab_plus[$i][$keys1[0]])
							$find=true;
					if (!$find)
						$res[]=$tab_plus[$i];
				}
				return $res;
			}
			else
				return $tab_plus;
		}
		else
			return $tab_plus;
	}
	
	/**
	 * mysql_select_value()
	 * 
	 * @param $db_base		: database to access
	 * @param $query: la requete avec seuleument 1 colonne selectionn�e!!
	 * @param $default: default value to return if query return null result
	 * @return la valeur retourn�e en ligne 0 de la requete.
	 */
	function mysql_select_value($db_base,$query,$default="") {
		$tab=mysql_rawquery($db_base,$query." LIMIT 0,1");
		if (count($tab)==1) {
			$keys=array_keys($tab[0]);	
			return $tab[0][$keys[0]];
		}
		else
			return $default;
	}

?>