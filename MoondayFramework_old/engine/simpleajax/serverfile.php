<?php
	/**
	 * You can query database in this file, get required text/string and print/echo it.
	 * That text will be displayed by javascript on the main page(example.php)
	 * 
	 */
	if(isset($_GET) && count($_GET) > 0) {
		echo "You can process your parameters and return result accordingly <br />";
		echo "Hi ! My name is Rochak and i am testing AJAX.";
	}
	else {
		echo "Hi ! My name is Rochak and i am testing AJAX.";
	}
?>
