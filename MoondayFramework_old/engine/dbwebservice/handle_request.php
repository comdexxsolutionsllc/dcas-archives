<?php
	class XmlNode {
		var $name;
		var $attrs;
		var $parent;
		var $cdata;
		var $children;
		function XmlNode($name,$attrs,$parent) {
			$this->name=$name;
			$this->attrs=$attrs;
			$this->parent=&$parent;
			$this->children=array();
			$this->cdata="";
		}
	}
	
	class SaxParser {
		var $root=false;
		var $node;
		function _startElement($parser, $name, $attrs) {
			if (!$this->root) {
				$newnode = new XmlNode($name,$attrs,false);
				$newnode->parent=&$newnode;
				$this->root=&$newnode;
			} else {
				$newnode = new XmlNode($name,$attrs,&$this->node);
			}
			$this->node->children[]=&$newnode;
			$this->node=&$newnode;
		}

		function _endElement($parser, $name) {
			$this->node=&$this->node->parent;
		}
		
		function _characterdata($parser, $data){
		 	$this->node->cdata .= $data;
		}

	    function SaxParser() {
	        $this->xml_parser = xml_parser_create();
	        xml_set_object( $this->xml_parser, $this );
	        xml_set_element_handler($this->xml_parser, "_startElement", "_endElement");
	        xml_set_character_data_handler($this->xml_parser, "_characterdata");
		}

		function parse($data) {
			if (!xml_parse($this->xml_parser, $data, true)) {
		        sprintf("XML error: %s on line %d",
		                    xml_error_string(xml_get_error_code($this->xml_parser)),
		                    xml_get_current_line_number($this->xml_parser));
		    }
			xml_parser_free($this->xml_parser);
		}
	}
	
	function soapResult($functionName,$type,$result) {
?><soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
 <soapenv:Body>
  <ns1:<?php echo $functionName ?>Response soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xmlns:ns1="<? echo SCRIPT_URL ?>">
   <ns1:<?php echo $functionName ?>Return xsi:type="xsd:<? echo $type ?>"><? echo htmlspecialchars ($result, ENT_QUOTES) ?></ns1:<? echo $functionName ?>Return>
  </ns1:<?php echo $functionName ?>Response>
 </soapenv:Body>
</soapenv:Envelope><?php
	}
	
	function fault($message,$detail="",$code="Client",$actor="") {
?><SOAP-ENV:Envelope SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"
  xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
  xmlns:xsd="http://www.w3.org/2001/XMLSchema"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
  xmlns:si="http://soapinterop.org/xsd">
<SOAP-ENV:Body><SOAP-ENV:Fault>
	<faultcode><?php echo $code ?></faultcode>
	<faultactor><?php echo $actor ?></faultactor>
	<faultstring><?php echo $message ?></faultstring>
	<detail><soapVal xsi:type="xsd:string"><?php echo $detail ?></soapVal></detail>
</SOAP-ENV:Fault>
</SOAP-ENV:Body>
</SOAP-ENV:Envelope><?php
	}
	
	function getExplodedElement($sep,$target,$i) {
		$e = explode($sep,$target);
		return @$e[$i];
	}
	
	function extractParam($node) {
		$type=getExplodedElement(":",$node->attrs["XSI:TYPE"],1);
		if (strcasecmp($type,"Array")==0) {
			$arr = array();
			foreach ($node->children as $element) $arr[]=extractParam($element);
			return $arr;
		} else if (strcasecmp($type,"Map")==0) {
			$arr = array();
			foreach ($node->children as $item) {
				$key=false;
				$value=false;
				foreach ($item->children as $itempart) {
					if (strcasecmp($itempart->name,"key")==0) $key=extractParam($itempart);
					if (strcasecmp($itempart->name,"value")==0) $value=extractParam($itempart);
				}
				if ($key && $value) $arr[$key]=$value;
			}
			return $arr;
		} else {
			return $node->cdata;
		}
	}
	
	function extractParams($node,$result) {
		foreach ($node->children as $child) {
			$l=sizeof($result);
			$result[$l] = extractParam($child);
		}
	}
	
	function service($request) {
		$p=new SaxParser();
		$p->parse($request);
		$node = &$p->root;
		if (!$node) return fault("XML structure error (no root found)");
		if (strcasecmp($node->name,"SOAP-ENV:Envelope")!=0) return fault("XML structure error ($node->name)");
		$node = &$node->children[0];
		if (strcasecmp($node->name,"SOAP-ENV:Body")!=0) return fault("XML structure error ($node->name)");
		$node = &$node->children[0];
		$functionName = getExplodedElement(":",$node->name,1);
		if (!function_exists($functionName)) return fault("not implemented yet");
		$params = array();
		extractParams($node,&$params);
		echo @call_user_func_array($functionName, $params);
	}
	
	function getWSDL() {
		$data = implode("",file("wsdl.xml"));
		$data = str_replace("%%sourceNamespace%%",SOURCENAMESPACE,$data);
		$data = str_replace("%%targetNamespace%%",TARGETNAMESPACE,$data);
		$data = str_replace("%%serviceName%%",SERVICE_NAME,$data);
		$data = str_replace("%%serviceLocation%%",SERVICE_NAME,$data);
		echo $data;
	}
?>
