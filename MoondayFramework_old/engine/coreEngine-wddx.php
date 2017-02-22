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


//*** Starts wddxObject class.
class wddxObject
{
        var $stringObject,
        $errorObject;
        
        public function add_vars($packet_id, $var_names)
        {
            return wddx_add_vars($packet_id, $var_names);
        }
        
        public function deserialize($packet)
        {
            return $this->unserialize($packet);
        }
        
        public function packet_end($packet_id)
        {
            return wddx_packet_end($packet_id);
        }
        
        public function packet_start($comment=NULL)
        {
            return wddx_packet_start($comment);
        }
        
        public function serialize_value($var, $comment=NULL)
        {
            return wddx_serialize_value($var, $comment);
        }
        
        public function serialize_vars($var_name)
        {
            return wddx_serialize_vars($var_name);
        }
        
        public function unserialize($packet)
        {
            return wddx_deserialize($packet);
        }
        
        
        public function __get($var)
        {
            print "Attempted to retrieve $var and failed...\n";
        }

        public function __call($function, $args)
        {
            $args = implode(', ', $args);
            print "Call to $function() with args '$args' failed!\n";
        }

        function __destruct() { }
        
}
?>