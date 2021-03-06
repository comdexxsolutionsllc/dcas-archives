<?php

/**
* @package PrintSend
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc (Abstract) PrintSendLPR
* @uses
* @example
* @files
*/
 
abstract class PrintSend{

    protected $data;    
    protected $debug;

    abstract protected function printJob($queue);
    
    abstract protected function interpret();
    
    public function __construct() {}

    public function setData($data){ 
        //This can be a filename or some ASCII.  A file check should be made in derived classes.
        $this->data = $data;
        $this->debug .= "Data set\n";
    }
    
    //Future functionality (?) Could create filters with this for different languages like PCL or ESC/P
    public static function printerFactory($type){ 
        //Return a new instance of a printer driver of type $type.
        if (include_once 'Drivers/' . $type . '.php') {
            return new $type;
        } else {
            throw new Exception ('Driver not found: $type');
        }        
    }

    public function getDebug(){
	return $this->debug;
    }

}

?>
