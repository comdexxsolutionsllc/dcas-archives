<?php
// Example (several) backup


    #####################################################################################################################
    #                      Include the class                                                                            #
    #####################################################################################################################
    require_once("iam_backup.php");

    /**
     * Creates a Database dump for all the DBs listed in the Array
     * @param Array Contains Strings identifying the DBs to dump
    */
    function toAllDB($dbs)
    {
        $now = gmdate('Y.m.d.H.i.s');

        if (!file_exists("./$now"))
        {
            mkdir("./$now");
        }

        while (list ($key, $val) = each ($dbs) )
        {
            echo "$key => $val<br>";
            $backup = new iam_backup("localhost", $val, "root", "", false, false, true, "./$now./$val.$now.sql.gz");
            $backup->perform_backup();
        }
    }
  #####################################################################################################################
  #  Set the DBnamos to backup and call the function                                                                  #
  #####################################################################################################################
    $fruits[0] = "intranetsk";
    $fruits[1] = "mysql";
    $fruits[2] = "law";

    toAllDB($fruits);

?>
