<?php
// Example Backup


  #####################################################################################################################
  #                      Include the class                                                                            #
  #####################################################################################################################
  require_once("iam_backup.php");



  #####################################################################################################################
  #  Set the parameters: hostname, databasename, dbuser and password(must have SELECT permission to the mysql DB)     #
  #  Note that this produces a GZip compressed file. You should set the $compress parameter to false to get SQL file  #
  #  This will dump the database and prompt the user to download it. No compression is applied here.                  #
  #####################################################################################################################
  $backup = new iam_backup("localhost", "mysql", "root", "", true, false, false);

  #####################################################################################################################
  #  Call the perform backup function  and that's it!!!                                                               #
  #####################################################################################################################
  $backup->perform_backup();

  #####################################################################################################################
  #  Set the parameters: We only set the Database connection. The connection procedure could be in an include file    #                                                     #
  #  This will dump the database and prompt the user to download it. No compression is applied here.                  #
  #####################################################################################################################

  $conn = @mysql_pconnect("localhost","root","");
  if(!$result)     // If no connection, return 0
  {
    echo "An error has occured. Could not connect to the server";
  }
  if(!@mysql_select_db("mysql"))  // If db not set, return 0
  {
    echo "An error has occured. Could not select the MySQL Database";
  }

  $backup = new iam_backup($conn);

  #####################################################################################################################
  #  Call the perform backup function  and that's it!!!                                                               #
  #####################################################################################################################
  $backup->perform_backup();

  #####################################################################################################################
  #  Set the parameters: hostname, databasename, dbuser and password(must have SELECT permission to the mysql DB)     #
  #  Note that this produces a GZip compressed file. You should set the third parameter to false to get an SQL file   #
  #  This will dump the database into the file located in "./file.sql.gz"                                             #
  #####################################################################################################################
  $backup = new iam_backup("localhost", "mysql", "root", "", true, false, true, "./file.sql.gz");

  #####################################################################################################################
  #  Call the perform backup function  and that's it!!!                                                               #
  #####################################################################################################################
  $backup->perform_backup();

?>