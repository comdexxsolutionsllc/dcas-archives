<?php
/* NOTE: You must have the FirePHPCore library in your include path */

//set_include_path('../engine/FirePHPCore/lib/'.PATH_SEPARATOR.get_include_path());
 

require('FirePHPCore/fb.php');

/* NOTE: You must have Output Buffering enabled via
         ob_start() or output_buffering ini directive. */

fb('Hello World'); /* Defaults to FirePHP::LOG */

fb('Log message'  ,FirePHP::LOG);
fb('Info message' ,FirePHP::INFO);
fb('Warn message' ,FirePHP::WARN);
fb('Error message',FirePHP::ERROR);

fb('Message with label','Label',FirePHP::LOG);

fb(array('key1'=>'val1',
         'key2'=>array(array('v1','v2'),'v3')),
   'TestArray',FirePHP::LOG);

function test($Arg1) {
  throw new Exception('Test Exception');
}
try {
  test(array('Hello'=>'World'));
} catch(Exception $e) {
  /* Log exception including stack trace & variables */
  fb($e);
}

fb('Backtrace to here',FirePHP::TRACE);

fb(array('2 SQL queries took 0.06 seconds',array(
   array('SQL Statement','Time','Result'),
   array('SELECT * FROM Foo','0.02',array('row1','row2')),
   array('SELECT * FROM Bar','0.04',array('row1','row2'))
  )),FirePHP::TABLE);

/* Will show only in "Server" tab for the request */
fb(apache_request_headers(),'RequestHeaders',FirePHP::DUMP);


//print 'Hello World';
?>

<?php
//namespace MoondayFramework;
//	function identifyNode() {
//		echo 'identifyNode';
//		return (bool) true;
//	}
//	
//use MoondayFramework;
//
//// getContents:test.php
//// base64_encode to prep to store in dBase
//// Store in dbase once serialized
//$a = serialize(base64_encode(file_get_contents('http://localhost/MoondayFramework/test.php')));
//var_dump($a);
?>
<?php
//namespace Foo;
//class Bar {
//    public function Bar() {
//        // treated as constructor in PHP 5.3.0-5.3.2
//        // treated as regular method in PHP 5.3.3
//    }
//}
//
//$BarClass = new Bar;
//
//var_dump($BarClass->Bar());
//var_dump(is_nan((double) 'e'));
//echo ((double) '1.10000055455E12521') . (html_entity_decode('&#8734;'));
?>
<?php
//define("DOCROOT", 'C:/XAMPP/xampp/htdocs/MoondayFramework/');
//define("ENGINELOC", DOCROOT.'engine/');
//
//	function __autoload($className)
//	{
//		echo 'PHP Version: ' . phpversion() . '</br>';
//	    echo 'Loading class: ' . $classname . '</br>';
//	    
//		require_once ENGINELOC.'coreEngine-'.$className.'.php';
//	    
//		throw new Exception("Unable to load $className.");
//	}
?>