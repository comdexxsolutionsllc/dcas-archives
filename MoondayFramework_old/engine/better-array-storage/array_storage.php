<?php

/**
* @package array_storage
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc Array Compression/Storage
* @uses
* @example
* @files
*/

class array_storage
{
    function compress($array)
    {
        return(gzcompress(var_export($array,true),9));
    }
    
    function decompress($content)
    {
        eval('$array='.(empty($content)?"array()":gzuncompress($content)).';');
        return($array); 
    }
}
?>