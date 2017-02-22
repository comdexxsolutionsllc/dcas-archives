<?php
# Description: This footer is included via /usr/local/lib/php.ini
#              via the auto_append_file variable
# Purpose:     The Purpose of this file is to automagically have a way to view
#              a page's source code without creating softlinks (ln -s)

if ($_SERVER['PHP_SELF'] != '/MoondayFramework/showsource.php')
{
    if (getcwd() != 'C:\program~2\EasyPHP5.2.10\www\MoondayFramework\changelogger') {
        echo '<br /> <a target="_blank"  href="http://localhost/projects/STATUS/current/RAAJ022308-01/showsource.php?page=C:\wamp\www\">View Source Code</a>'; //'.$_SERVER['PHP_SELF'].'
    } else { die(); }
} else {
    die();
}
?>
