<?php

/**
* @package MegaSpider
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc Retrieve any data from a website
* @uses
* @example
* @files
*/

class MegaSpider
{
	/**
	* Global address of retriving website
	* @var string url
	**/
	var $_url = null;

	/**
	* Domain address of $_url
	* @var string domain name
	**/
	var $_domain = null;
	
	/**
	* Actualy parsed and retrived address
	* @var string url
	* @depracted
	**/
	var $_actual = null;
	
	/** CURL OPTIONS **/
	
	/**
	* CURL RESOURCE
	* @var string resource
	**/
	var $_CURL_RESOURCE = null;
	
	/**
	* CURL setting
	* @var boolean
	**/
	var $_CURLOPT_FAILONERROR = false;
	
	/**
	* CURL setting
	* @var boolean
	**/
	var $_CURLOPT_FOLLOWLOCATION = true;
	
	/**
	* CURL setting
	* @var boolean
	**/
	var $_CURLOPT_RETURNTRANSFER = true;
	
	/**
	* CURL setting
	* @var integer
	**/
	var $_CURLOPT_TIMEOUT = 3;
	
	/**
	* CURL setting
	* @var boolean
	**/
	var $_CURLOPT_POST = true;
	
	/**
	* CURL setting
	* @var boolean
	**/
	var $_CURLOPT_POSTFIELDS = null;
	
	/**
	* CURL setting
	* @var string Curl browser identification
	**/
	var $_CURLOPT_USERAGENT = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)";
	
	/**
	* CURL setting
	* @var string
	**/
	var $_CURLOPT_USERPWD = null;
	
	/**
	* CURL setting
	* @var string cookie save path
	**/
	var $_CURLOPT_COOKIEJAR = '/cookies/';

	/**
	* CURL setting
	* @var string cookie save path
	**/
	var $_CURLOPT_COOKIEFILE = '/cookies/';
		
	/** DEBUG MODE **/
	
	/**
	* Debug mode true or false
	* @var boolean mode
	**/
	var $_debug = true;
		
	/** SETTINGS **/
	
	/**
	* Sleep time after reciving the page
	* @var integer time
	**/
	var $_sleep = 3;
		
	/** DATA **/
	
	/**
	* Class array of unique www addresses that found in whole site
	* @var array adressess
	* @access private
	**/
	var $_unique_addreses = array( );
	
	/**
	* Class array of unique links that found in whole site
	* @var array links
	* @access private
	**/
	var $_unique_hrefs = array( );
	
	/**
	* Class array of unique emails that found in whole site
	* @var array emails
	* @access private
	**/
	var $_unique_emails = array( );
		
		
	/**
	* __Construct of MegaSpider Class don't 
	* need any params, starts automaticly and
	* automaticly runs bulit in timer, after
	* that try to run CURL_INIT and makes the
	* CURL resource.
	*
	* @return void
	* @access public
	**/
	function MegaSpider( )
	{
		error_reporting( E_ALL );
		ini_set( 'display_errors' , true );
		set_time_limit( 3600 * 24 );
			
		$body = '<html>';
		$body = '<head><title>MegSpider</title></head>';
		$body = '<body style="background:#000000;font-family:sans-serif;font-size:11px;color:#ffffff">';
			
		if( $this -> _debug == true )
		{
			print( $body );
		}
		
		//debug construct run
		if( $this -> _debug == true ) 
		{
			print( '<h4>MegaSpider __Construct start running application</h4><br>' );
			$this -> _scrollDown( );
		}
		
		$this -> _run_time( );
	
		$this -> _CURLOPT_COOKIEJAR = realpath( dirname( __FILE__ ) ).'/'.$this -> _CURLOPT_COOKIEJAR;
		$this -> _CURLOPT_COOKIEFILE = realpath( dirname( __FILE__ ) ).'/'.$this -> _CURLOPT_COOKIEFILE;
		
		$this -> _CURL_RESOURCE = curl_init( );
			
		//debug init curl
		if( is_resource( $this -> _CURL_RESOURCE ) && $this -> _debug )
		{
			print( __LINE__.' <b>_CURL init()</b> executed sucesfully <br>' );
			$this -> _scrollDown( );
		}
		
	}
		
		
	/**
	* Method alows You to assign some
	* page that will be parsed by the
	* Mega Spider Class. Method need only
	* one param - address of www page.
	*
	* @param string address
	* @return void
	* @access public
	**/
	function assign( $url = 'http://www.msn.com' )
	{
		$this -> _url = $url;
		
		if( $this -> _debug == true ) 
		{
			print( __LINE__.' Assign method started : address -> '.$url.'<br>' );
			$this -> _scrollDown( );
		}
			
		$this -> getPage( $url );
			
		$this -> _stats( );
		$this -> _end_time( );
	}
	
	/**
	* Reciving and parsing the page,
	* that method runs all the others 
	* methods as _unique_href, _unique_emails
	* _unique_address. Needs one param - the
	* web page address.
	*
	* @param string address
	* @return void
	* @access private
	**/
	function getPage( $page )
	{
		if( isset( $this -> _unique_hrefs[$page] ) )
		{
			if( $this -> _debug == true ) 
			{
				print( __LINE__.' Found address in _unique_hrefs : '.htmlentities( strip_tags( $page ) ).' <br>' );
				$this -> _scrollDown( );
			}
				
			$this -> _unique_hrefs[$page]['visit'] = $this -> _unique_hrefs[$page]['visit'] + 1; 
				
			if( $this -> _debug == true ) 
			{
				print( __LINE__.' Change visit number : '.$this -> _unique_hrefs[$page]['visit'].' <br>' );
				$this -> _scrollDown( );
			}
			
			$page = $this -> _url.$this -> _unique_hrefs[$page]['href'];
			
			if( $this -> _debug == true ) 
			{
				print( __LINE__.' Parse address : '.htmlentities( strip_tags( $page ) ).' <br>' );
				$this -> _scrollDown( );
			}
				
			$this -> _actual = $page;
		} 
		
		$content = $this -> getContent( $page );
			
		if( $this -> _debug == true )
		{
			print( __LINE__.' Parse content <b>date : '.date('h:i:s').'</b><br>');
			$this -> _scrollDown( );
		}

		if( $this -> _debug == true )
		{
			print( __LINE__.' Sleep time : '.($this -> _sleep).' seconds<br>' );
			$this -> _scrollDown( );
		}
			
		sleep( $this -> _sleep );
			
		if( $this -> _debug == true )
		{
			print( __LINE__.' Parsing content date : '.date('h:i:s').'<br>');
			$this -> _scrollDown( );
		}
			
		if( $content['error'] == 0 )
		{
		
			$content = $content['pages'];
			
		} else {
		
			$content = $content['ermsg'];
			
		}
		
		$this -> _unique_addresses( &$content );
		$this -> _unique_hrefs( &$content );
		$this -> _unique_emails( &$content );

		
		$this -> getUniqueHref( );
	}
	
	/**
	* If one page was parsed by class,
	* system trys to know what is the
	* next page that shoud be parsed.
	* All found addresses are in array
	* _unique_hrefs. This Method runs
	* the spider to recive next www page
	* from array. Don't need any param.
	*
	* @return void
	* @access private
	**/
	function getUniqueHref( )
	{
		if( !empty( $this -> _unique_hrefs ) )
		{
			foreach( $this -> _unique_hrefs AS $key => $value )
			{

				if( $value['visit'] == 0 )
				{
					
					if( $this -> _debug == true ) 
					{
						print( '<br><br><h4>Parse page :: '.htmlentities( strip_tags( $value['name'] ) ).'</h4> <br>' );
						$this -> _scrollDown( );
					}
					
					$this -> getPage( $key );
					
					break;
				}
			}
		}
	}
	
	/**
	* Method get as param address of 
	* web page and download full html
	* content of page. If this operation
	* was not sucesfully method try do
	* run method getUniqueHref that will
	* try to download next page from
	* array _unique_hrefs
	*
	* @param string address
	* @return void
	* @access private
	**/
	function getContent( $address )
	{
		curl_setopt( $this -> _CURL_RESOURCE , CURLOPT_URL , $address ); // set url to post to
		curl_setopt( $this -> _CURL_RESOURCE , CURLOPT_FAILONERROR , $this -> _CURLOPT_FAILONERROR );
		curl_setopt( $this -> _CURL_RESOURCE , CURLOPT_FOLLOWLOCATION , $this -> _CURLOPT_FOLLOWLOCATION );
		curl_setopt( $this -> _CURL_RESOURCE , CURLOPT_RETURNTRANSFER , $this -> _CURLOPT_RETURNTRANSFER );
		curl_setopt( $this -> _CURL_RESOURCE , CURLOPT_TIMEOUT , $this -> _CURLOPT_TIMEOUT );
		curl_setopt( $this -> _CURL_RESOURCE , CURLOPT_COOKIEJAR , $this -> _CURLOPT_COOKIEJAR );
		curl_setopt( $this -> _CURL_RESOURCE , CURLOPT_COOKIEFILE , $this -> _CURLOPT_COOKIEFILE );

		if( strlen( $this -> _CURLOPT_POSTFIELDS ) > 1 )
		{
			curl_setopt( $this -> _CURL_RESOURCE , CURLOPT_POST , $this -> _CURLOPT_POST );
			curl_setopt( $this -> _CURL_RESOURCE , CURLOPT_POSTFIELDS , $this -> _CURLOPT_POSTFIELDS );
		}

		if( strlen( $this -> _CURLOPT_USERAGENT ) > 0 ) 
		{
			curl_setopt( $this -> _CURL_RESOURCE , CURLOPT_USERAGENT, $this -> _CURLOPT_USERAGENT );
		}

		if( strlen( $this -> _CURLOPT_USERPWD ) > 2 ) 
		{
			curl_setopt( $this -> _CURL_RESOURCE , CURLOPT_USERPWD, $this -> _CURLOPT_USERPWD );
		}
			
		$ret['pages'] = curl_exec( $this -> _CURL_RESOURCE ); // go get the page
		$ret['error'] = curl_errno( $this -> _CURL_RESOURCE );
		$ret['ermsg'] = curl_error( $this -> _CURL_RESOURCE );

		if( $ret['error'] == 0 )
		{
	
			return $ret;	
	
		} else {
		
			$this -> getUniqueHref( );
		
		}
	}
	
	/**
	* Method parse html codes of web
	* page and retriving from html code
	* all existing email addressess.
	*
	* @param string html codes
	* @return void
	* @access private
	**/
	function _unique_emails( &$content )
	{
		if( $this -> _debug == true )
		{
			print( __LINE__.' Parse unique emails <br>' );
			$this -> _scrollDown( );
		}
		
		if( empty( $content ) == false )
		{
			
			if( $this -> _debug == true )
			{
				print( __LINE__.' Parse Parsing content <br>' );
				$this -> _scrollDown( );
			}
			
			preg_match_all("/[mM][aA][iI][lL][tT][oO]:([^\"]*)/", $content , $arrEmails );
			
			if( empty( $arrEmails[1] ) == false ) 
			{
				
				if( $this -> _debug == true )
				{
					print( __LINE__.' <b>Found not identified emails</b> <br>' );
					$this -> _scrollDown( );
					print( '---------------------------<br>' );
					$this -> _scrollDown( );
				}
					
				foreach( $arrEmails[1] AS $key => $value )
				{
					
					if( !isset( $this -> _unique_emails[$value] ) )
					{
						$this -> _unique_emails[$value]= $value;
							
						if( $this -> _debug == true )
						{
							print( __LINE__.' Parse: Editing _unique_emails, making : '.htmlentities( strip_tags( $value ) ).' <br>' );
							$this -> _scrollDown( );
						}
					
					} else {
						
						if( $this -> _debug == true )
						{
							print( __LINE__.' Parse: Address exits at _unique_emails, breaking : '.htmlentities( strip_tags( $value ) ).' <br>' );
							$this -> _scrollDown( );
						}
							
					}
				
				}
					
				if( $this -> _debug == true )
				{
					print( '---------------------------<br>' );
					$this -> _scrollDown( );
				}
				
			}
			
		} else {
		
			if( $this -> _debug == true )
			{
				print( __LINE__.' Content is empty! <br>' );
				$this -> _scrollDown( );
			}
			
		}
	}
		
	/**
	* Method parse html codes of web
	* page and retriving from html code
	* all existing www addressess.
	*
	* @param string html codes
	* @return void
	* @access private
	**/
	function _unique_addresses( &$content )
	{
		if( $this -> _debug == true )
		{
			print( __LINE__.' Parse unique adressess <br>' );
			$this -> _scrollDown( );
		}
		
		$addr = null;
		$port = null;
		
		if( empty( $content ) == false )
		{
			if( $this -> _debug == true )
			{
				print( __LINE__.' Parse: Parsing content <br>' );
				$this -> _scrollDown( );
			}
		
			preg_match_all("/(http|https)?:\/\/?([a-zA-Z0-9\-\.]*\.[a-zA-Z]{2,5})(:[a-zA-Z0-9]*)?\/?([a-zA-Z0-9.-_]*\/)?([a-zA-Z0-9.-_?&=%+$]+)?/", $content , $arrAddress );
				
			if( empty( $arrAddress[2] ) == false )
			{
				$prot =& $arrAddress[1];
				$addr =& $arrAddress[2];
				$port =& $arrAddress[3];
				$fold =& $arrAddress[4];
				$phps =& $arrAddress[4];
					
				if( $this -> _debug == true )
				{
					print( __LINE__.' <b>Found not identified addresses</b> <br>' );
					$this -> _scrollDown( );
					print( '---------------------------<br>' );
					$this -> _scrollDown( );
				}
			}
				
				
			//print_r( $arrAddress );
				
			//uniquie addressess
			if( empty( $addr ) == false )
			{
				foreach( $addr AS $key => $value ) 
				{
					$value = eregi_replace( 'www.' , '' , $value );
					if( !isset( $this -> _unique_addreses[$value] ) )
					{
						if( $this -> _debug == true )
						{
							print( __LINE__.' Parse: Editing _unique_addreses, making : '.htmlentities( strip_tags( $value ) ).' <br>' );
							$this -> _scrollDown( );
						}
						
						$this -> _unique_addreses[$value]['www'] = $value;
						//protocol
						if( !empty( $prot[$key] ) )
						{
							$this -> _unique_addreses[$value]['protocol'] = $prot[$key];
						} else {
							$this -> _unique_addreses[$value]['protocol'] = null;
						}
						//port
						if( !empty( $port[$key] ) )
						{
							$this -> _unique_addreses[$value]['port'] = $port[$key];
						} else {
							$this -> _unique_addreses[$value]['port'] = $port[$key];
						}
							 
					} else {
						
						if( $this -> _debug == true )
						{
							print( __LINE__.' Parse: Address exits at _unique_addresses : '.htmlentities( strip_tags( $value ) ).' <br>' );
							$this -> _scrollDown( );
						}
							
					}
				}
	
				if( $this -> _debug == true )
				{				
					print( '---------------------------<br>' );
					$this -> _scrollDown( );
				}
			}
		}
	}
		
	/**
	* Method parse html codes of web
	* page and retriving from html code
	* all existing href links.
	*
	* @param string html codes
	* @return void
	* @access private
	**/
	function _unique_hrefs( &$content )
	{
		if( $this -> _debug == true )
		{
			print( __LINE__.' Parse unique hrefs <br>' );
			$this -> _scrollDown( );
		}
		
		$addr = null;
		$port = null;
		
		if( empty( $content ) == false )
		{
			if( $this -> _debug == true )
			{
				print( __LINE__.' Parse: Parsing content <br>' );
				$this -> _scrollDown( );
			}
			
			preg_match_all("/<[aA][[:space:]][hH][rR][eE][fF]=\"([^\"]+)\"[^>]+>(.*)<\/[aA]>/", $content , $arrAddress );
				
			if( empty( $arrAddress[1] ) == false )
			{
				
				if( $this -> _debug == true )
				{
					print( __LINE__.' <b>Found not identified hrefs</b> <br>' );
					$this -> _scrollDown( );
					print( '---------------------------<br>' );
					$this -> _scrollDown( );
				}
					
					
				foreach( $arrAddress[1] AS $id => $href )
				{
					$href = eregi_replace( $this -> _url , '' , $href );
					
					if( !eregi( 'http|www|mailto', $href ) && $href!="#" && !eregi( 'javascript|;', $href ) )
					{
						
						if( $this -> _debug == true )
						{
							if( !isset( $this -> _unique_hrefs[$href] ) )
							{
								$this -> _unique_hrefs[$href]['href'] = $href;
								$this -> _unique_hrefs[$href]['name'] = $arrAddress[2][$id];
								$this -> _unique_hrefs[$href]['visit'] = 0;

								if( $this -> _debug == true )
								{
									print( __LINE__.' Parse: Editing _unique_hrefs, making : '.htmlentities( strip_tags( $href ) ).' <br>' );						
									$this -> _scrollDown( );
								}
							} else {
								
								if( $this -> _debug == true )
								{
									print( __LINE__.' Parse: Href exitst at _unique_hrefs, breaking : '.htmlentities( strip_tags( $href ) ).' <br>' );
									$this -> _scrollDown( );
								}
							
							}
						}
					} else {
						
						if( $this -> _debug == true )
						{
							print( __LINE__.' Parse: bad href expresion, breaking : '.htmlentities( strip_tags( $href ) ).' <br>' );
							$this -> _scrollDown( );
						}

					}
				}
					
				if( $this -> _debug == true )
				{
					print( '---------------------------<br>' );
					$this -> _scrollDown( );
				}
					
			}

		}
	}
		
	/**
	* Method prints in debug mode
	* statistics of found adresses
	* and emails.
	*
	* @return void
	* @access private
	**/
	function _stats( )
	{
		if( $this -> _debug == true )
		{
			
			print( '<br><br><h4>Total Statistic </h4>' );
			print( '---------------------------<br>' );
			print( 'Unique WWW addresses : '. sizeof( $this -> _unique_addreses ).' <br>' );
			$this -> _scrollDown( );
			
			print( 'Unique EMAIL addresses : '. sizeof( $this -> _unique_emails ).' <br>' );
			$this -> _scrollDown( );

			print( 'Total Pages parsed : '. sizeof( $this -> _unique_hrefs ).' <br>' );
			$this -> _scrollDown( );
			print( '---------------------------<br>' );
		}
	}
		
		
	/**
	* Method prints in debug mode
	* javascript thtat scroll down
	* the page.
	*
	* @return void
	* @access private
	**/
	function _scrollDown( )
	{
		if( $this -> _debug == true )
		{
			print( '<script> window.scrollBy(0,1000000); </script> ' );
		}
	}		

	/**
	* Runs microtime of run time
	* of aplication.
	*
	* @return void
	* @access private
	**/
	function _run_time( ){
		$micro_time = microtime( );
		$micro_time = explode(" ",$micro_time);
		
		$this -> _run_time = $micro_time[1] + $micro_time[0];
	}
	
	
	/**
	* In debug mode prints out 
	* full time of application work.
	*
	* @return integer run time
	* @access public
	**/
	function _end_time( )
	{
		$micro_time = microtime( );
		$micro_time = explode(" ",$micro_time);
		$this -> _end_time = $micro_time[1] + $micro_time[0];

		$total = ($this -> _end_time - $this -> _run_time);

		$total = round($total, 3);
		
		if( $this -> _debug == true )
		{
			print( '<h4>Total Time : '.$total.' </h4>' );
		}
		
		return $total;
	}

/* EOF */
}
?>
