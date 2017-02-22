<?php
// Start the output buffer so we dont create any errors with headers
ob_start();
error_reporting(E_ALL);

// Start Session if Session isn't started
if ( (isset($_SESSION)) )
{
  return true;
} else {
  header('Content-Type: text/html; charset=UTF-8');
  session_start();
}

// Start Meta Header
header("meta:1");

// +
//$file = file('../other-classes-to-add.txt');
$file = file('../test.txt');

$classTemplateFile = 'class-creation.tmplt';

//#foreach( $file as $f)
//#{
// Variable Declaration
//#$className = $f;
if (isset($_POST) && !(empty($_POST))) { $className = $_POST['classnametxt']; } else { $className = ''; }
//echo $className.'<br\> ';
$classNameFile = 'coreEngine-'.trim(strtolower($className)).'.php';
echo $classNameFile.'<br\> ';

$fgc = file_get_contents($classTemplateFile);

if ($classNameFile != 'coreEngine-.php')
{
    $search1 = str_replace('CLASSNAME', $className, $fgc);

    if ('True' == $_POST['database']) {
        $search2 = str_replace('CLASS1', '$db', $search1);
    } else {
        $search2 = str_replace('CLASS1Object', '', $search1);
    }

    if ('True' == $_POST['filesystem']) {
        $search3 = str_replace('CLASS2', '$file', $search2);
    } else {
        $search3 = str_replace('CLASS2Object', '', $search2);
    }

    if ('True' == $_POST['users']) {
        $search4 = str_replace('CLASS3', '$user', $search3);
    } else {
        $search4 = str_replace('CLASS3Object', '', $search3);
    }

    if ('True' == $_POST['errors']) {
        $search5 = str_replace('CLASS4', '$error', $search4);
    } else {
        $search5 = str_replace('CLASS4Object', '', $search4);
    }

    if ('True' == $_POST['strings']) {
        $search6 = str_replace('CLASS5', '$string', $search5);
    } else {
        $search6 = str_replace('CLASS5Object', '', $search5);
    }

    $return = &$search6;

// File Creation & File Open
if (!$fopenFile = fopen($classNameFile, 'w')) {
	trigger_error("Cannot open file ($classNameFile)", E_USER_ERROR);
	exit;
}

// File Write
if (fwrite($fopenFile, $return) === FALSE) {
	trigger_error("Cannot write to file ($classNameFile)", E_USER_ERROR);
	exit;
}

// File Close
fclose($fopenFile);

echo "Success, wrote (content) to file ($classNameFile)";
}
//#}
// +

#// Variable Declaration
#$className = $_POST['classnametxt'];
#$classNameFile = 'coreEngine-'.strtolower($className).'.php';
#$classTemplateFile = 'class-creation.tmplt';
#
#$fgc = file_get_contents($classTemplateFile);
#
#if ( !(empty($_POST['submit']) && isset($_POST['submit'])) && ($classNameFile != 'coreEngine-.php') )
#{
#    $search1 = str_replace('CLASSNAME', $className, $fgc);
#
#    if ('True' == $_POST['database']) {
#        $search2 = str_replace('CLASS1', '$db', $search1);
#    } else {
#        $search2 = str_replace('CLASS1Object', '', $search1);
#    }
#
#    if ('True' == $_POST['filesystem']) {
#        $search3 = str_replace('CLASS2', '$file', $search2);
#    } else {
#        $search3 = str_replace('CLASS2Object', '', $search2);
#    }
#
#    if ('True' == $_POST['users']) {
#        $search4 = str_replace('CLASS3', '$user', $search3);
#    } else {
#        $search4 = str_replace('CLASS3Object', '', $search3);
#    }
#
#    if ('True' == $_POST['errors']) {
#        $search5 = str_replace('CLASS4', '$error', $search4);
#    } else {
#        $search5 = str_replace('CLASS4Object', '', $search4);
#    }
#
#    if ('True' == $_POST['strings']) {
#        $search6 = str_replace('CLASS5', '$string', $search5);
#    } else {
#        $search6 = str_replace('CLASS5Object', '', $search5);
#    }
#
#    $return = &$search6;
#
#// File Creation & File Open
#if (!$fopenFile = fopen($classNameFile, 'w')) {
#	echo "Cannot open file ($classNameFile)";
#	exit;
#}
#
#// File Write
#if (fwrite($fopenFile, $return) === FALSE) {
#	echo "Cannot write to file ($classNameFile)";
#	exit;
#}
#
#// File Close
#fclose($fopenFile);
#
#echo "Success, wrote (content) to file ($classNameFile)";
#}
#
#if ( empty($_POST['submit']) || ! (isset($_POST['submit'])))
#{
?>

<html>
 <title>::Class Creation Wizard::</title>

<body><pre>
 <form action="<?php # echo $_SERVER['PHP_SELF']; ?>" id="ClassCreationFrm" name="ClassCreationFrm" method="POST">
    <classname>
    Class Name:  <input type="text" name="classnametxt"><br />
    </classname>

    <classtypes>
     Database:   TRUE <input type="radio" name="database" value="True">  FALSE <input type="radio" name="database" value="False"> <br />
     Filesystem: TRUE <input type="radio" name="filesystem" value="True">  FALSE <input type="radio" name="filesystem" value="False"> <br />
     Users:      TRUE <input type="radio" name="users" value="True">  FALSE <input type="radio" name="users" value="False"> <br />
     Errors:     TRUE <input type="radio" name="errors" value="True">  FALSE <input type="radio" name="errors" value="False"> <br />
     Strings:    TRUE <input type="radio" name="strings" value="True">  FALSE <input type="radio" name="strings" value="False"> <br />
    </classtypes>

    <submitbutton>
    <input type="submit" name="submit" value="Create Class">
    </submitbutton>
 </form>
</pre></body>
</html>

<?php # } ?>