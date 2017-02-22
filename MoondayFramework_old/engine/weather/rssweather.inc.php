<?php

/**
* @package WEATHER
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc Retrieve RSS Feeds from http://www.rssweather.com
* @uses
* @example
* @files
*/	

	define( 'DEFAULT_URL', 'http://www.rssweather.com/dir/weather.opml' );

	define( 'CURL_ERROR_OFFSET', 1000 );
	define( 'XML_ERROR_OFFSET',  0 );
	
	class WEATHER
	{
		
		var $_parser;
	    var $xmlData;
	    var $xmlAttr;
		var $currentTag;
		var $currentAttr;
		var $_error="";
		var $_url;
		var $_result="";
		var $_depth=0;
		var $_prevdepth=0;
		var $_incr;


		/***********************************************************************
		*** Construnction						                             ***
		***********************************************************************/
		
		function WEATHER($url=DEFAULT_URL)
		{
			$this->setURL($url);
			$this->_depth=0;
			$this->_prevdepth=0;
			$this->_error="";
		}
		 
		/***********************************************************************
		*** XML Parser - Callback functions                                 ***
		***********************************************************************/
		function epXmlElementStart ($parser, $tag, $attributes) {
			$this->currentTag = $tag;
			if(is_array($attributes) && !empty($attributes))
			{
				if(array_key_exists("TEXT",$attributes))
				{
					 $this->currentAttr=$attributes["TEXT"];
				}
				elseif(array_key_exists("TYPE",$attributes))
				{
					$this->xmlAttr[$this->currentAttr][$attributes["TITLE"]]=$attributes["XMLURL"];
				}
			}
			$this->_depth++;
			if($this->_depth!=$this->_prevdepth)
				$this->_incr[$this->_depth]++;
		}
		
		function epXmlElementEnd ($parser, $tag) {
			$this->currentTag = "";
			$this->_prevdepth=$this->_depth;
			$this->_depth--;
		}
		
		function epXmlData ($parser, $cdata) {
	       $this->xmlData[$this->_incr[$this->_depth]][$this->currentTag] .=$cdata;
		}
		
		/***********************************************************************
		*** Public functions												***
		***********************************************************************/

		function error()
		{
			return $this->_error;
		}
		
		function setURL($url)
		{
			if(!preg_match("/^http/i",$url))
				$this->_url="http://".$url;
			else
				$this->_url=$url;
		}

		function getWeather()
		{
			$this->_url;
			$this->_result=@file_get_contents($this->_url);
			if($this->_result==false || empty($this->_result))
			{
				$this->_error="Can not take input from given url:".$this->_url;
				return false;
			}
			if($this->_parseXML()==false)
				return false;
			if(is_array($this->xmlAttr))
			{
				$return =new stdClass;
				$return->head=$this->xmlData;
				$return->body=$this->xmlAttr;
				return $return;
			}
			return $this->xmlData;
		}
		
		function printList()
		{
			if(is_array($this->xmlAttr))
			{
				foreach($this->xmlAttr as $key=>$value)
				{
					echo "<br><b>".$key."</b><br>";
					foreach($value as $title=>$link)
						echo "&nbsp;&nbsp;&nbsp;<a href='".$_SERVER['PHP_SELF']."?url=".urlencode($link)."'>$title</a><br>";
				}
			}
			elseif(is_array($this->xmlData))
			{
				foreach($this->xmlData as $key=>$data)
				{
					echo "<b>".$data["TITLE"]."</b><br>";
					if($key==1)
						echo $data["CONTENT:ENCODED"]."<br>";
					else
						echo $data["DESCRIPTION"]."<br>";
					echo $data["PUBDATE"]."<br><br>";
				}
			}
		}
		/***********************************************************************
		*** Private functions												***
		***********************************************************************/

		function _parseXML()
		{
            $this->_parser = xml_parser_create();
            
            // Disable XML tag capitalisation (Case Folding)
            xml_parser_set_option ($this->_parser, XML_OPTION_CASE_FOLDING, true);
            
            // Define Callback functions for XML Parsing
            xml_set_object($this->_parser, &$this);
            xml_set_element_handler ($this->_parser, "epXmlElementStart", "epXmlElementEnd");
            xml_set_character_data_handler ($this->_parser, "epXmlData");
            
            // Parse the XML response
            xml_parse($this->_parser, $this->_result, TRUE);
            if( xml_get_error_code( $this->_parser ) == XML_ERROR_NONE ) {
                // Get the result into local variables.
				if(!empty($this->xmlData["CODE"][0]) && $this->xmlData["CODE"][0]>0)
				{
	                $myError = $this->xmlData["CODE"][0];
		            $myErrorMessage = $this->xmlData["MESSAGE"][0];
					$this->_error="Error($myError):".$myErrorMessage ;
					return false;
				}
	            return true;
            } else {
                // An XML error occured. Return the error message and number.
                $myError = xml_get_error_code( $this->_parser ) + XML_ERROR_OFFSET;
                $myErrorMessage = xml_error_string( $myError );
				$this->_error="Error($myError):".$myErrorMessage ;
				return false;
            }
            // Clean up our XML parser
            xml_parser_free( $this->_parser );

		}

	}
	
?>
