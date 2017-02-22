<?php

/****************************************************************************************************
 *
 *    _____   _____       ___  ___   _____   _____  __    __ __    __  _____   _____   _____   _____  
 *   /  ___| /  _  \     /   |/   | |  _  \ | ____| \ \  / / \ \  / / /  ___/ /  _  \ |  ___| |_   _| 
 *   | |     | | | |    / /|   /| | | | | | | |__    \ \/ /   \ \/ /  | |___  | | | | | |__     | |   
 *   | |     | | | |   / / |__/ | | | | | | |  __|    }  {     }  {   \___  \ | | | | |  __|    | |   
 *   | |___  | |_| |  / /       | | | |_| | | |___   / /\ \   / /\ \   ___| | | |_| | | |       | |   
 *   \_____| \_____/ /_/        |_| |_____/ |_____| /_/  \_\ /_/  \_\ /_____/ \_____/ |_|       |_|   
 *
 * Copyright (c) Comdexx Software, LLC                                                  Version : 1.0
 ****************************************************************************************************/

//*** Stops all unauthorized access to this file.
if(!defined("IN_ENGINE")) {
    die(include_once('../error_docs/contextInEngine.html'));
}

//*** Starts stringObject class.
class serializeObject
{

    
    public function __get($var) {
        print "Attempted to retrieve $var and failed...\n";
    }
    
    public function __call($function, $args) {
        $args = implode(', ', $args);
        print "Call to $function() with args '$args' failed!\n";
    }
    
 	public function serialize($obj2Serialize, $IsBase64Encode=false) {
 		if (isset($IsBase64Encode) && $IsBase64Encode == true) {
 			$this->SerializedObject = serialize(base64_encode(serialize($obj2Serialize)));
 		} else {
 			$this->SerializedObject = serialize($obj2Serialize);
 		}
 		return $this->SerializedObject;
 	}
 	
 	public function unserialize($obj2Deserialize, $IsBase64Decode=false) {
 		if (isset($IsBase64Decode) && $IsBase64Decode == true) {
 			$this->SerializedObject = unserialize(base64_decode($obj2Deserialize));
 		} else {
 			$this->SerializedObject = unserialize($obj2Deserialize);
 		}
 		return $this->SerializedObject;
 	}

    function __destruct() { }
    
}
?>