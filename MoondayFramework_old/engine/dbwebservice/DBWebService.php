<?php
function getTable($name, $parameters) {
	
	/* custom code */
	
	/* mysql types to java translation */
	$java_field_types=array(
		"string"=>12,		// java.sql.Types.VARCHAR
		"int"=>4,			// java.sql.Types.INTEGER
		"blob"=>2004,		// java.sql.Types.BLOB
		"date"=>91,			// java.sql.Types.DATE
		"real"=>7,			// java.sql.Types.REAL
		"datetime"=>91,		// java.sql.Types.DATE
		"timestamp"=>93,	// java.sql.Types.TIMESTAMP
		"time"=>92,			// java.sql.Types.TIME
		"year"=>91,			// java.sql.Types.DATE
	);
	
	$where = "";
	foreach ($parameters as $field=>$value) $where.= (strlen($where)>0?" and ":" where ").$field." ".($value?"= '$value'":" is null");
	$sql = "select * from $name".$where;
	echo "<!-- $sql -->";
	$dataset=executeTableSql($sql);
	global $db_error;
	if (!$dataset) return fault($db_error);
	$columnNames = array();
	$columnTypes = array();
	while ($meta = mysql_fetch_field($dataset)) { 
   		$columnNames[] = $meta->name;
   		$columnTypes[] = $java_field_types[$meta->type];
   	}

	$records = array();
	while ($line=mysql_fetch_assoc($dataset)) {
		$records[] = new DBRecord(@$line["id"],$line);
	}
	/* end of custom code */
	
    $table = new DBTable(
    	$name,
    	$columnNames,
    	$columnTypes,
    	$records
    );
    return $table->toSoap();
}

function getRecord($table,$id) {
	/* custom code */
	$sql = "select * from $table where ID=$id";
	echo "<!-- $sql -->";
	$row = getOneRow($sql);
	if (!@$row) return fault("record not found","id=$id"); 
	/* end of custom code */
	
	$record = new DBRecord($id,$row);
	return $record->toSoap();
}

function getRecordValue($table,$id,$column) {
	$value = getOneValue("select $column from $table where ID=$id");
	if (!@$value) return fault("value not found","id=$id column=$column"); 
	return soapResult("getRecordValue","string",$value);
}
function synchronizeRecordsById($table,$ids,$data) {
	/* custom code */
	$trans = array();
	foreach ($ids as $i=>$id) {
		if ($id) {
			$sql = "";
			foreach ($data[$i] as $field=>$value) {
				$sql .= (strlen($sql)>0?",":"") . $field." = '".str_replace("'","\'",$value)."'";
			}
			$sql = "update $table set $sql where id=$id";
		} else {
			$fields = "";
			$values = "";
			foreach ($data[$i] as $field=>$value) {
				$fields.= (strlen($fields)>0?",":"") . $field;
				$values.= (strlen($values)>0?",":"") . "'".str_replace("'","\'",$value)."'";
			}
			$sql = "insert into $table ($fields) values ($values)";
		}
		echo "<!-- $sql -->\n";
		$trans[] = $sql;
	}
	$result = executeTransSql($trans);
	global $db_error;
	if ($db_error) return fault($db_error);
	/* end of custom code */

	return soapResult("synchronizeRecordsById","int",$result);
}
function synchronizeRecordById($table,$id,$data) {
	/* custom code */
	if ($id) {
		$sql = "";
		foreach ($data as $field=>$value) {
			$sql .= (strlen($sql)>0?",":"") . $field." = '".str_replace("'","\'",$value)."'";
		}
		$sql = "update $table set $sql where id=$id";
	} else {
		$fields = "";
		$values = "";
		foreach ($data as $field=>$value) {
			$fields.= (strlen($fields)>0?",":"") . $field;
			$values.= (strlen($values)>0?",":"") . "'".str_replace("'","\'",$value)."'";
		}
		$sql = "insert into $table ($fields) values ($values)";
	}
	echo "<!-- $sql -->\n";
	$result = executeSql($sql);
	global $db_error;
	if ($result==-1) return fault($db_error);
	/* end of custom code */
	
	return soapResult("synchronizeRecordById","int",$result);
}
function synchronizeRecordsByMatch($table,$match,$data) {
	/* custom code */
	$where = "";
	foreach ($match as $field=>$value) $where.= (strlen($where)>0?" and ":" where ").$field." ".($value?"= '$value'":" is null");
	$sql = "";
	foreach ($data as $field=>$value) {
		$sql .= (strlen($sql)>0?",":"") . $field." = '".str_replace("'","\'",$value)."'";
	}
	$sql = "update $table set $sql $where";
	echo "<!-- $sql -->\n";
	$result = executeSql($sql);
	global $db_error;
	if ($result==-1) return fault($db_error);
	/* end of custom code */
	
	return soapResult("synchronizeRecordsByMatch","int",$result);
}
function deleteRecordsById($table,$ids) {
	/* custom code */
	$sql = "";
	foreach ($ids as $id) {
		$sql .= (strlen($sql)>0?",":"") . $id;
	}
	$sql = "delete from $table where id in ($sql)";
	echo "<!-- $sql -->\n";
	$result = executeSql($sql);
	global $db_error;
	if ($result==-1) return fault($db_error);
	/* end of custom code */

	return soapResult("deleteRecordsById","int",$result);
}
function deleteRecordById($table,$id) {
	/* custom code */
	$sql = "delete from $table where id = $id";
	echo "<!-- $sql -->\n";
	$result = executeSql($sql);
	global $db_error;
	if ($result==-1) return fault($db_error);
	/* end of custom code */
	
	return soapResult("deleteRecordById","int",$result);
}
function deleteRecordsByMatch($table,$match) {
	/* custom code */
	$where = "";
	foreach ($match as $field=>$value) $where.= (strlen($where)>0?" and ":" where ").$field." ".($value?"= '$value'":" is null");
	$sql = "delete from $table $where";
	echo "<!-- $sql -->\n";
	$result = executeSql($sql);
	global $db_error;
	if ($result==-1) return fault($db_error);
	/* end of custom code */
	
	return soapResult("deleteRecordsByMatch","int",$result);
}

?>
