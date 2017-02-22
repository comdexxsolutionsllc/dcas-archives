<?php

/**
* @package GetBrowserType
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc Get the browser type and version
* @uses
* @example
*             $brtype = new GetBrowserType();
*             print "<h1> the browser version is : $brtype->browser_version</br>";
*             print "<h1> the browser type is : $brtype->browser_type</br>";
* @files
*/


class GetBrowserType
{
	// Public variables
	var $browser_version;
	var $browser_type;  // 1 = Microsoft IE, 2 = Netscape

	// Private variable - starts with underscore
	// var $_sample;
	var $_debug = 'Y';  // yes 'Y', no 'N'

	// Protected variable - starts with underscore T
	// var $_Tsample;

function GetBrowserType()  // class constructor
{
	$this->_getDetails();

	//global $HTTP_USER_AGENT;
	//echo "$HTTP_USER_AGENT<hr>\n";
	//$browser = get_browser();
	//echo $this->list_array ((array) $browser);
}

// function someSample()  // public function (does not start with underscore)
// {
// }

function _listArray ($array) // private function (stars with underscore)
{
    while (list ($key, $value) = each ($array))
	{
		$str .= "<b>$key:</b> $value<br>\n";
    }
	print "<h1> the $str</br>";
    return $str;
}

function _getDetails()  // private function (starts with underscore)
{
	global $HTTP_USER_AGENT;

	if ($this->_debug == 'Y')
		print "<h1> the $HTTP_USER_AGENT</br>";

	$this->browser_version = intval(trim(substr($HTTP_USER_AGENT, 4 + strpos($HTTP_USER_AGENT, "MSIE"), 2)));

	if ($this->browser_version > 0) // this is MS IE
	{
		if (eregi("MSIE", $HTTP_USER_AGENT))
			$this->browser_type = 1;
	}
	else // check if it is netscape browser
	{
		$this->browser_version = intval(trim(substr($HTTP_USER_AGENT, 8 + strpos($HTTP_USER_AGENT, "Mozilla/"))));
		if (eregi("Mozilla", $HTTP_USER_AGENT))
			$this->browser_type = 2;
	}

	if ($this->_debug == 'Y')
	{
		if ($this->browser_version > 0) // found the browser type
		{
			print "<h1> the browser version is : $this->browser_version</br>";
			print "<h1> the browser type is : $this->browser_type</br>";
		}
		else  // it is not IE or Netscape, it is something else
		{
			print "<h1> the browser version is : $this->browser_version</br>";
			print "<h1> the browser type is : $this->browser_type</br>";
		}
	}
}
}

?>

<?php $GetBrowserType = new GetBrowserType(); echo $GetBrowserType->GetBrowserType(); ?>