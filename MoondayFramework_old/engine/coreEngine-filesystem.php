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

//*** Starts fileObject class.
class fileObject
{
        var $stringObject,
        $dbObject;

        
    public function __get($var) {
        print "Attempted to retrieve $var and failed...\n";
    }
    
    public function __call($function, $args) {
        $args = implode(', ', $args);
        print "Call to $function() with args '$args' failed!\n";
    }
    
    /**
     * Uploads a image and moves it to the folder defined.
     * 
     * @param $filename array - Image filename.
     * @param $tmp_name array - Image temporary filename.
     * @return bool
     */
    function uploadImage($filename, $tmp_name, $uploaddir, $allowed_extentions) {
        $ext = strtolower(strrchr($filename, "."));
        if(in_array($ext, $allowed_extentions)) {
            $file_array = explode(".", $filename);
            $file = strtolower(time()."_".rand(111,999).$ext);
            if(is_uploaded_file($tmp_name)) {
				print "Uploaded";
				umask(0);
                $newfile = str_replace(" ", "_", $file);
                if(move_uploaded_file($tmp_name, $uploaddir.$newfile)) {
                    @system("chmod 0755 ".$newfile);
                    return $uploaddir.$newfile;
                } 
				else 
				{ 
					print "1"; 
				}
            } 
			else 
			{ 
				print "2"; 
			}
        } 
		else 
		{ 
			print "3"; 
		}
    }

	function checkformatdate($year,$month,$day)
	{
		$validdate=checkdate($month,$day,$year);
		if($validdate)
		{
			if(strlen($month)==1)
			{
				$month="0".$month;
			}
			if(strlen($day)==1)
			{
				$day="0".$day;
			}
			return 	$year."-".$month."-".$day;
			
		}
		else
		{
			return '0000-00-00';
		}
	}
	

	function convertdate($year,$month,$day)
	{
		$validdate=checkdate($month,$day,$year);
		if($validdate)
		{
			if(strlen($month)==1)
			{
				$month="0".$month;
			}
			if(strlen($day)==1)
			{
				$day="0".$day;
			}
			return 	$month."/".$day."/".$year;
			
		}
		else
		{
			return '00/00/0000';
		}
	}
	
	function loadCSS($file, $usertype, $approot='')
	{
        return '<link href="'.$approot.$usertype.'/css/'.$file.'" rel="stylesheet" type="text/css" />';
	}
	
    function __destruct() { }
	
}


?>