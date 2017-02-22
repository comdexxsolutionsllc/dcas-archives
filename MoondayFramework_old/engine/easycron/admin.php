<?php


include "easycron.class.php";

$EC = new MyEasyCron;

if(isset($_GET["EasyCron"]))
{
  $start_close    = $_GET["StartClose"];
  $start_open     = $_GET["StartRun"];
  $iteration      = $_GET["loop"];
  $msg_close      = $_GET["MsgClose"];
  $show_back_time = $_GET["ViewStartRun"];

  $EC->SaveCron($start_close, $start_open, $iteration, $msg_close, $show_back_time);

}
else
{

  echo $EC->CronTable();

}

?>