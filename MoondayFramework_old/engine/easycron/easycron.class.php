<?php

/**
* @package MyEasyCron
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc Open/close Website Easily
* @uses
* @example
* @files
*/


class MyEasyCron
{
    # Public #
    // path to EasyCron.cron
    var $cron_path = "./";
    // Difference to Greenwich time (GMT) in hours
    var $greenwich = "+3"; // 3 for ksa
    // time now
    var $TimeNow;
    // Name's The Day's Weeks , week start with sunday
    var $days_of_names = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
    // print my copyright with message close , default ( 1 : yes )
    var $print_copyright = 1;

    # Private #
    // day name
    var $day_name;
    // hour start
    var $start_time = 1;
    // day number , default error number for day
    var $day_number = -1;
    //table setup
    var $TableHtml;
    // for view a 12 culomn
    var $Tid = 0;
    // table width
    var $w_table = 90;
    // rows
    var $rows = 12;
    // <td> width
    var $w_td;


    function MyEasyCron()
    {
       $this->cron_path = getcwd();
       $this->NowTime   = gmdate("G",mktime(date("G") + $this->greenwich,date("i"),date("s"),date("m"),date("d"),date("Y")));
       $this->day_name  = date("l");
       $this->w_td      = ceil($this->w_table / $this->rows - 1);
    }

    # To Show All Times , Convert Time and Author :)
    function CronTable()
    {
         // header
         $this->TableHtml  = "<html dir=\"ltr\">\r\n\r\n<title> EasyCron 1.0 beta - naifphp </title>\n\r\n";
         $this->TableHtml .= "<head>\r\n<script language=\"javascript\" src=\"./EasyCron.js\" type=\"text/javascript\"></script>\r\n</head>\r\n";
         $this->TableHtml .= "\r\n<center>\r\n<h2> Please Select time Started Close and Started open site , Of Table :<BR></h2>\r\n</center>\r\n";

         $this->TableHtml .= "<table align='center' border='1' width='".$this->w_table."%'>\n<tr><td width='10%'>&nbsp; <b>AM :</b></td>";

          for ($i = 1; $i < 25; $i++ )
           {

             $color = ($i % 2) ? 'EaEaEa' : 'dfdfam';

             if ($this->Tid == $this->rows):

                    $this->TableHtml .= "</tr><tr>\n<td></td>\n</tr><tr>\n<td> &nbsp;<b> PM :</b></td>\n";
                    $this->Tid = 0;

             endif;

          $st = $this->start_time++;

          $ts_show = (($ts_show >= 12) ? "1" : ($ts_show+1));
          $n_m = ($st >= 13) ? 'PM' : 'AM';
          $st = ($st > 23) ? "0" : $st;
          $ts_view = ($st == $this->NowTime) ? "<font color=\"red\">". $ts_show ."</font>" : $ts_show;

          $this->TableHtml .= "\r\n<td title='hour : ".$ts_show." ".$n_m."' onclick='InsertTime(\"".$st."\")' style='cursor:hand' bgcolor='#".$color."' width='".$this->w_td."%'>\r\n<center>";
          $this->TableHtml .= "<b>".$ts_view."</b> &nbsp; </center></td>\r\n";

          $this->Tid++;

           }

         $this->TableHtml .= ("</table></center>");


         # The Form
         $this->TableHtml .= $this->OutPutForm();
         # My Copy Rights :)
         $this->TableHtml .= $this->ShowMyCopyRight();

      return $this->TableHtml;

    }

    # KSA Time
    function convertTime($gmtime)
    {

      if ($gmtime > 12)
      {
         $ar = 1;

        for ($gm = 13; $gm <= 24; $gm++)
        {
           if ($gm == $gmtime)
           {
             $resultTime  = $ar;
             $resultTime .= ($ar == 12) ? " AM" : " PM";
             break;
           }
              $ar++;
        }
       }
       else
       {
         $resultTime  = $gmtime;
         $resultTime .= ($gmtime == 12) ? " PM" : " AM";
       }

      return $resultTime;
    }

    # Cron handling
    function CheckCron($startClose,$startRun)
    {
      if( $startClose >= 13 && $startRun <= 12)
      {
        if($this->NowTime < $startClose )
        {
         if ( ($startClose >= $this->NowTime) && ($startRun > $this->NowTime) )
         {
          return true;
         }
        }
        else
        { 
         if ( ($this->NowTime >= $startClose) && ($this->NowTime > $startRun) )
         {
          return true;
         }
        }
      }
      elseif( $startClose <= 12 && $startRun >= 13)
      {
       if ( ($this->NowTime >= $startClose) && ($this->NowTime < $startRun) )
       {
         return true;
       }
      }
      elseif( ($startClose <= 12 && $startRun <= 12) or ( $startClose >= 13 && $startRun >= 13) )
      {
       if ( ($this->NowTime >= $startClose) && ($startRun > $this->NowTime) )
       {
         return true;
       }
      }
      else
      {
         return false;
      }
    }

    # day name from the day number
    function GetDays($day_number="-1")
    {
       $this->day_number = $day_number;

       switch($this->day_number)
       {

          case 0;
                 $day_name = $this->days_of_names[0];
          break;

          case 1;
                 $day_name = $this->days_of_names[1];
          break;

          case 2;
                 $day_name = $this->days_of_names[2];
          break;

          case 3;
                 $day_name = $this->days_of_names[3];
          break;

          case 4;
                 $day_name = $this->days_of_names[4];
          break;

          case 5;
                 $day_name = $this->days_of_names[5];
          break;

          case 6;
                 $day_name = $this->days_of_names[6];
          break;

          default:
                  $day_name = "Please Enter Number Of The Day";
          break;

       }

       return $day_name;

     }

    # Interface
    function OutPutForm()
    {
       $output  = "<br><center><form name='fm' method='GET' OnSubmit=\"return checker(this)\">\n";
       $output .= "<input type='radio' id='whereadd1' name='whereadd'>";
       $output .= "Started Close :\n";
       $output .= "<input type='text' id='s' name='start' disabled='true'>\n";
       $output .= "<input type='button' id='r1' value='reset' onclick='resrt(1)'>";
       $output .= "&nbsp; &nbsp;";
       $output .= "<input type='radio' id='whereadd2' name='whereadd'>";
       $output .= "Started Open :  \n";
       $output .= "<input type='text' id='e' name='end' disabled='true'>\n";
       $output .= "<input type='button' id='r2' value='reset' onclick='resrt(2)'>";
       $output .= "<br><br> Iteration Of In : <select name='loop'>\n";
       $output .= "<option>Every Days</option>\n";
       for($d=0; $d < 7; $d++)
       {
       $output .= "<option>". $this->GetDays($d) ."</option>\n";
       }
       $output .= "</select>";
       $output .= "<br>\n<input type='checkbox' id='check' name='ViewStartRun' value='yes' checked='true'>\n";
       $output .= "<label for='check'> Write return time the site to open  : </label>\n";
       $output .= "<br><br><label for='msg'>The Closing Message : </label><br>\n";
       $output .= "<textarea rows='10' id='msg' cols='75' name='MsgClose'></textarea>\n";
       $output .= "<br>( if you don't write message the closing then we putting default message )(don't use HTML tag)<br>\n";
       $output .= "<input type='hidden' id='Cstart' name='StartClose'>\n";
       $output .= "<input type='hidden' id='Rstart' name='StartRun'>\n";
       $output .= "<input type='hidden' name='EasyCron' value='CreateCode'>\n";
       $output .= "<input type='hidden' name='ss' value='".md5(time())."'>\n";
       $output .= "<br><input type='submit' value='Create : EasyCron File'>\n";
       $output .= "</form>\n";

     return  ($output);

    }

    # read Cron
    function ReadCron()
    {
      if(!file_exists($this->cron_path ."/EasyCron.cron"))
      {
        die(" error <b>". $this->cron_path ."/EasyCron.cron </b> don't exists ");
      }
      else
      {
        $CronFile = @file($this->cron_path ."/EasyCron.cron");
        $CronGet = explode ("#", $CronFile[0]);

       $sc = $this->GetValue("C",trim($CronGet[0]));
       $so = $this->GetValue("O",trim($CronGet[1]));
       $lr = $this->GetValue("L",trim($CronGet[2]));
       $ms = $this->GetValue("M",trim($CronGet[3]));
       $bt = $this->GetValue("V",trim($CronGet[4]));

       if(is_array($sc))
       {
        foreach($sc as $k=>$v)
        {
         while( $this->CheckCron($sc[$k],$so[$k]) == true )
         {
          $backTime = $this->convertTime($so[$k]);
          $this->E_Cron($lr,$ms,$bt,$backTime);
         }
        }
       }
       else
       {
         if( $this->CheckCron($sc,$so) == true )
         {
          $backTime = $this->convertTime($so);
          $this->E_Cron($lr,$ms,$bt,$backTime);
         }
       }
      }
     }

    # open/close
    function E_Cron($Iteration,$message,$show_back_time,$backtime)
    {
      if (($Iteration == "Every Days") or ($Iteration == $this->day_name))
      {
        $message = str_replace('[br]',"<br />\n",$message);
        $CronMsg  = "<html>\n\n <head>\n<title> Closed ! </title> \n</head>\n ";
        $CronMsg .= "<body>\n\n <center>\n<h1>". $message ."</h1>\n\n\n";
        if ($show_back_time == "Yes")
        {
          $CronMsg .= "<br>\n<h3> it's back to the state opening in : ". $backtime ."</h2>\n</center>";
        }
        if($this->print_copyright == 1)
        {
          $CronMsg .= "<br><br>\n\n\n ". $this->ShowMyCopyRight();
        }
        $CronMsg .= "\n\n </body>\n\n</html>";

       die($CronMsg);

      }
    }

    # print the value
    function GetValue($element,$InCron)
    {
      $pattern = "/". $element ."\s*{(.+)}\s*/i";

      $Value = preg_replace($pattern, "\${1}", $InCron);

      if (stristr($Value, "~") == true)
      {
         $ExtractValue = explode("~", $Value);
         return $ExtractValue;
      }
      else
      {
           return $Value;
      }
    }

    # to save copy of file created
    function SaveCron($startClose,$startRun,$run_in="Every Days",$msgclose,$ViewStartRun,$yes=0)
    {
      $ShowStartRun = ($ViewStartRun) ? "Yes" : "No";
      $msgclose = (empty($msgclose)) ? "sorry , but this site it's closed now ! " : $msgclose;

      $msgclose = strip_tags($msgclose);
      $msgclose = str_replace("\n",'[br]',$msgclose);
      $msgclose = str_replace("\'","'",$msgclose);

      $cron = "C {".$startClose."} # O {".$startRun."} # L {".$run_in."} # M {".$msgclose."} # V {".$ShowStartRun."}";
      $open_new_cron = @fopen($this->cron_path ."/EasyCron.cron",'w+');
      $write_cron = @fwrite($open_new_cron,$cron);
      @fclose($open_new_cron);

      if($yes != 0)
      {
         Header("Pragma: public");
         Header("Expires: 0");
         Header('Content-Description: File Transfer');
         Header('Content-Type: application/force-download');
         Header("Content-Disposition: attachment; filename=EasyCron.cron");
         Header("Content-Type: application/x-ms-download ");

         ECHO $cron;
         exit;

      }

      if($write_cron)
      {
         ECHO " The <b> EasyCron.cron </b> has created successfuly .";
         return true;
      }
      else
      {
         ECHO "Sorry , But The File don't Create , please try again later . ";
         return false;
      }

   }


   #  copy right
   function ShowMyCopyRight()
   {
      $CopyRight .= "<hr><center><b><font face='Tahoma' size='2'>";
      $CopyRight .= " EasyCron version: 1.0 beta , All rights reserved for : ";
      $CopyRight .= " <a href='http://www.naifphp.net'>naifphp</a>";
      $CopyRight .= "</font></b></center>\r\n\r\n</html>";

    return ($CopyRight);

   }

}


?>