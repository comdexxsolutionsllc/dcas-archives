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

class errorObject
{
    var $currentErrors;


    public function __get($var) {
        print "Attempted to retrieve $var and failed...\n";
    }

    public function __call($function, $args) {
        $args = implode(', ', $args);
        print "Call to $function() with args '$args' failed!\n";
    }

    /**
     * Displays a error box.
     *
     * @param $title string - Error title name.
     * @param $error string - Error description.
     * @return string
     */
    public function displayError($title, $error)
    {
        print "<table cellpadding=\"2\" cellspacing=\"0\" border=\"1\" bordercolor=\"#ff0000\"\">";
        print    "<tr>";
        print        "<th color=\"#ffffff\" bgcolor=\"#ffffff\">{$title}</td>";
        print    "</tr>";
        print    "<tr>";
        print        "<td bgcolor=\"#ffffff\">{$error}</td>";
        print    "</tr>";
        print "</table>";
        $this->logError($title, $error);
        return @$currentErrors;
    }

    protected function logError($title, $error)
    {
        $date_time = date ('Y-m-d H:i:s');
        $fd = fopen('C:/xampp/htdocs/MoondayFramework/error.log.php', 'a');
        fwrite($fd, '['.$date_time.'] '.$title.' '.$error.'<br \>');
        fclose($fd);
        return(0);
    }

    function __destruct() { }

}

?>
