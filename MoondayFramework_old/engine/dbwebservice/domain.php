<?php
class DBRecord {
	var $id;
	var $values;
	function getClass() {
		return "DBRecord";
	}
	function DBRecord($id,$values) {
		$this->id=$id;
		$this->values=$values;
	}
	function toSoap() {
?><soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" 
	xmlns:xsd="http://www.w3.org/2001/XMLSchema" 
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
 <soapenv:Body>
  <ns1:getRecordResponse soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xmlns:ns1="<?php echo SCRIPT_URL ?>">
   <ns1:getRecordReturn href="#id0"/>
  </ns1:getRecordResponse>
  <multiRef id="id0" soapenc:root="0" soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xsi:type="ns2:DBRecord" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/" xmlns:ns2="<?php echo SCRIPT_URL ?>">
   <id xsi:type="xsd:int"><?php echo $this->id ?></id>
   <values xsi:type="soapenc:Array" soapenc:arrayType="xsd:string[<?php echo sizeof($this->values) ?>]">
<?php
	foreach ($this->values as $value) {
		echo "    <item>".htmlspecialchars($value, ENT_QUOTES)."</item>\n";
	}
?>
   </values>
  </multiRef>
 </soapenv:Body>
</soapenv:Envelope><?php
	}
}
class DBTable {
	var $name;
	var $columns;
	var $columnTypes;
	var $records;
	function getClass() {
		return "DBTable";
	}
	function DBTable($name,$columns,$columnTypes,$records) {
		$this->name=$name;
		$this->columns=$columns;
		$this->records=$records;	
		$this->columnTypes=$columnTypes;
	}
	function toSoap() {
?><soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" 
		xmlns:xsd="http://www.w3.org/2001/XMLSchema" 
		xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
 <soapenv:Body>
  <ns1:getTableResponse soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xmlns:ns1="<?php echo SCRIPT_URL ?>">
   <ns1:getTableReturn href="#id0"/>
  </ns1:getTableResponse>
  <multiRef id="id0" soapenc:root="0" soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xsi:type="ns2:DBTable" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/" xmlns:ns2="<?php echo SCRIPT_URL ?>">
   <columns xsi:type="soapenc:Array" soapenc:arrayType="xsd:string[<?php echo sizeof($this->columns) ?>]">
<?php
	foreach ($this->columns as $col) echo "    <item>".htmlspecialchars($col, ENT_QUOTES)."</item>\n";
?>
   </columns>
   <columnTypes xsi:type="soapenc:Array" soapenc:arrayType="xsd:int[<?php echo sizeof($this->columns) ?>]">
<?php
	foreach ($this->columnTypes as $colType) echo "    <item>$colType</item>\n";
?>
   </columnTypes>
   <name xsi:type="xsd:string"><?php echo $this->name?></name>
   <records xsi:type="soapenc:Array" soapenc:arrayType="ns2:DBRecord[<?php echo sizeof($this->records) ?>]">
<?php
	$i=1;
	foreach ($this->records as $record) echo "    <item href=\"#id".($i++)."\"/>\n";
?>
   </records>
  </multiRef>
<?php
	$i=1;
	foreach ($this->records as $record) {
?>  <multiRef id="id<?php echo $i ?>" soapenc:root="0" soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xsi:type="ns<? echo 5+$i ?>:DBRecord" xmlns:ns<? echo 5+$i ?>="<? echo SCRIPT_URL ?>" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">
   <id xsi:type="xsd:int"><?php echo $record->id ?></id>
   <values xsi:type="soapenc:Array" soapenc:arrayType="xsd:string[<?php echo sizeof ($this->columns) ?>]">
<?php
	foreach ($record->values as $value) echo "    <item>".htmlspecialchars($value, ENT_QUOTES)."</item>\n";
?>
   </values>
  </multiRef>
<?php
		$i++;
	}

?> </soapenv:Body>
</soapenv:Envelope><?php
	}
}
?>
