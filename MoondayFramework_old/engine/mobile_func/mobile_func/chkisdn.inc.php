<?php

/**
* @package MegaSpider
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc Retrieve mobile number for WAP and validate
* @uses
* @example
* @files
*/

class check_isdn()
{
   //Non standard class
   function _get_mobile_number()
   {
    global $_SERVER;
    if(isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID']))
    {
      //Mostly this Server Vars Attribute all mobile phones
      $hpnum = trim($_SERVER['HTTP_X_UP_CALLING_LINE_ID']);
    } 
    else if(isset($_SERVER['HTTP_X_HTS_CLID'])) 
    {
      //Mostly this Server Vars Attribute is for Nokia and SonyEricsson
      $hpnum = trim($_SERVER['HTTP_X_HTS_CLID']);
    } 
    else if(isset($_SERVER['HTTP_MSISDN']))
    {
      //Mostly this Server Vars Attribute is for Motorola and Siemens
     $hpnum = trim($_SERVER['HTTP_MSISDN']);
    }
    return $hpnum;
   }

   function _validate_isdn($hp=NULL)
   {
      $blnvalid = false;
      //Set your preferences here
      if(preg_match("/6738/i",$hp)) 
      {
       $blnvalid = true;
      } 
      return $blnvalid;
   }
}
?>