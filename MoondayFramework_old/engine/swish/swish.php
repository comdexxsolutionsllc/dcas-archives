<?php

/**
* @package swishSearch
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc Search website
* @uses
* @example
* @files
*/

class swishSearch
{
	var $swish;
	var $search_index;
	var $search_query;
	
	/**
	 * Description this will be used for highlighting text.  
	 * // ATVAR was here       $highlight_element
	 * @since     1.0
	 * @access    private
	 */
	var $highlight_element=array();
	/**
	 * Description this will hold command to execute swish-e
	 * // ATVAR was here       $cmd
	 * @since     1.0
	 * @access    private
	 */
	var $cmd;
	
	/**
	 * Description this will tell from which record swish-e should return results.
	 * // ATVAR was here       $startat
	 * @since     1.0
	 * @access    private
	 */
	var $startat;
	
	/**
	 * Description :this tells how many results should be returned.
	 * // ATVAR was here       $no_of_results
	 * @since     1.0
	 * @access    private
	 */
	var $no_of_results;

	/**
	 * Description :this will have total no of results returned by swish-e
	 * // ATVAR was here       $num_results
	 * @since     1.0
	 * @access    private
	 */
	var $num_results;
	
	/**
	 * Description : this array will have relavance of each result.
	 * // ATVAR was here       $relevance
	 * @since     1.0
	 * @access    private
	 */
	var $relevance=array();
	
	/**
	 * Description :
	 * // ATVAR was here       $result_url
	 * @since     1.0
	 * @access    private
	 */
	var $result_url=array();
	
	/**
	 * Description
	 * // ATVAR was here       $result_title
	 * @since     1.0
	 * @access    private
	 */
	var $result_title=array();
	
	/**
	 * Description
	 * // ATVAR was here       
	 * @since     1.0
	 * @access    private
	 */
	var $file_size=array();
	
	/**
	 * Description
	 * // ATVAR was here       
	 * @since     1.0
	 * @access    private
	 */
	var $link=array();
	
	/**
	 * Description
	 * // ATVAR was here       
	 * @since     1.0
	 * @access    private
	 */
	var $description=array();
	var $errorMessage;
	
	/**
	 * Description
	 * // ATVAR was here       
	 * @since     1.0
	 * @access    private
	 */
	var $search_element=array();
	
	/**
	 * Short description. constructor
	 *
	 * Detail description
	 * @param      none
	 * @global     none
	 * @since      1.0
	 * @access     private
	 * @return     void
	 * @update     date time
	*/
	function swishSearch($start=0)
	{
		/*if (!file_exists($swish)) {
		    $this->errorMessage="Executable file not found!!!";
		}else
		if (!file_exists($search_index)) {
		    $this->errorMessage="Index file not found!!!";
		}else {*/
			$this->swish="";
			$this->search_index="";
		    $this->search_query="";
			$this->cmd="";
			$this->num_results=0;
			//$this->relevance=0;
			$this->result_url=array();
			$this->result_title=array();
			$this->file_size=array();
			$this->link=array();
			$this->description=array();
			$this->errorMessage="";
			$this->search_element=array();
			$this->highlight_element=array();
			$this->startat=$start;
			$this->no_of_results=10;
			
		//}   
	} // end func

	
	/**
	 * Short description. 
	 *
	 * Detail description
	 * @param      none
	 * @global     none
	 * @since      1.0
	 * @access     private
	 * @return     void
	 * @update     date time
	*/

	function setSearchQuery($query)
	{
	    $this->search_query=$query;
	} // end func
	
	
	/**

	 * Short description. 
	 *
	 * Detail description tells where swish-e executable is stored
	 * @param      none
	 * @global     none
	 * @since      1.0
	 * @access     private
	 * @return     void
	 * @update     date time
	*/
	function setSwish($swish)
	{
	    $this->swish=$swish;
	} // end func

	
	/**
	 * Short description. 
	 *
	 * Detail description sets the path of the index file
	 * @param      none
	 * @global     none
	 * @since      1.0
	 * @access     private
	 * @return     void
	 * @update     date time
	*/
	function setIndex($index)
	{
	    $this->search_index=$index;
	} // end func
	/**
	 * Short description. processes input query string
	 *
	 * Detail description this will filter out any shell command, backslashes, quotes
	 * @param      none
	 * @global     none
	 * @since      1.0
	 * @access     private
	 * @return     void
	 * @update     date time
	*/
	function preProcess()
	{
		$this->search_query=EscapeShellCmd($this->search_query);/* escape potentially malicious shell commands */
		$this->search_query=stripslashes($this->search_query);/* remove backslashes from search query */
		$this->search_query=ereg_replace('("|\')','',$this->search_query);/* remove quotes from search query */
		
	} // end func
	
	/**
	 * Short description. this will splitup each word out
	 *
	 * Detail description
	 * @param      none
	 * @global     none
	 * @since      1.0
	 * @access     private
	 * @return     void
	 * @update     date time
	*/
	function getWordsOut()
	{
	    $formated_query=str_replace("*"," ",$this->search_query); /*replace wildcard caracter by space*/
		$this->search_element=explode(" ",trim($formated_query)); /*separate words in search query */
		
		for($i=0;$i<count($this->search_element);$i++){
			$this->highlight_element[$i]=$this->search_element[$i]."[^ ]* ";
			//echo "(".$search_element1[$i].")";
			$this->search_element[$i]=ereg_replace("\*.*","",$this->search_element[$i]);
			//echo $search_element[$i];
		}
	} // end func
	
	/**
	 * Short description. this will buildup command to be executed for search 
	 *
	 * Detail description
	 * @param      none
	 * @global     none
	 * @since      1.0
	 * @access     private
	 * @return     void
	 * @update     date time
	*/
	function getCommand()
	{
	    $this->cmd=$this->swish." -w ".$this->search_query." -f ".$this->search_index." -b ".$this->startat." -m ".$this->no_of_results;
	} // end func

	
	/**
	 * Short description. this will return no of results 
	 *
	 * Detail description
	 * @param      none
	 * @global     none
	 * @since      1.0
	 * @access     private
	 * @return     void
	 * @update     date time
	*/
	function getNoofResults($pp)
	{
	    $line_cnt=1;

		while($nline=@fgets($pp,1024)){/* loop through each line of the pipe result (i.e. swish-e output) to find hit number */
			if($line_cnt==22){
				$num_line=$nline;
				break;/* grab the 22nd line, which contains the number of hits returned */
			}
			$line_cnt++;
		}
		$this->num_results=ereg_replace('# Number of hits:.','',$num_line);/* strip out all but the number of hits */

	} // end func

	
	/**
	 * Short description. sets array of description of each hit.
	 *
	 * Detail description
	 * @param      none
	 * @global     none
	 * @since      1.0
	 * @access     private
	 * @return     void
	 * @update     date time
	*/
	function getDescription($page_requested)
	{
	    $fd = fopen ($page_requested, "r");
		$contents = fread ($fd, filesize ($page_requested));
		fclose ($fd);
		$contents=strip_tags($contents);
		$temp=strtolower($contents);
		$needle=strtolower($this->search_element[0]);
		$ind=strpos($temp,$needle);
		if ($ind<25) {
			$description=substr($contents,0,200);    
		}else {
			$description=substr($contents,$ind-25,200);    
		}
		//$search_string="";
		for($i=0;$i<count($this->highlight_element);$i++){
			//$search_string.=$search_element1[$i];
			$this->description[]=eregi_replace("(".$this->highlight_element[$i].")"," <b>\\1</b> ",$description);
		}
		//echo $search_string;
		//$description=eregi_replace("(".$search_string.")"," <b>\\1</b> ",$description);

	} // end func

	
	/**
	 * Short description. sets array of attributes like file size, relevance, title and link  
	 *
	 * Detail description
	 * @param      none
	 * @global     none
	 * @since      1.0
	 * @access     private
	 * @return     void
	 * @update     date time
	*/
	function getAttributes($line)
	{
	    list($rel,$res_url,$res_title,$fl_size)=explode("\t",$line); /* split the line into an array by tabs; assign variable names to each column */

		$this->relevance[]=$rel/10;/* format relevance as a percentage for search results */

		$res_title=ereg_replace('%%',' ',$res_title);/* replace every %% with a space */

		$this->result_title[]=ereg_replace('"','',$res_title);/* strip out the quotation marks */

		$url=parse_url($res_url);/* split the URL into an array of its components */

		$link=$url["path"];/* assign the web link to the path component to return a relative URL */

		$page_requested=$link;   /* return the full path of the file on the web server */

		$this->getDescription($page_requested);
				
		if($url["query"]){
			$this->link[]=$link."?".$url["query"];
		}else {
		    $this->link[]=$link;
		}/* if the URL contains a query string, append the URL with that query string */	
	} // end func

	/**
	 * Short description. this will create new process where command in $cmd will be executed
	 *
	 * Detail description
	 * @param      none
	 * @global     none
	 * @since      1.0
	 * @access     private
	 * @return     void
	 * @update     date time
	*/
	function executeCommand()
	{
	    $pp=popen($this->cmd,"r") or die ("The search request generated an error.Please try again.");

		$this->getNoofResults($pp);

		while($line=@fgets($pp,4096)){/* loop through each line of the pipe result (i.e. swish-e output) */
			if(preg_match("/^(\d+)\s+(\S+)\s+\"(.+)\"\s+(\d+)/",$line)){/* Skip commented-out lines and the last line */
				$line=explode('"',$line);/* split the string into an array by quotation marks */

				$line[1]=ereg_replace("[[:blank:]]","%%",$line[1]);/* replace every space with %% for the phrase in quotation marks */

				$line=implode('"',$line);/* collapse the array into a string */

				$line=ereg_replace("[[:blank:]]","\t",$line);/* replace every space with a tab */
				
				$this->getAttributes($line);
			}//end of if
		}//end of while
		pclose($pp);/* close the shell pipe */
	} // end func

	
	/**
	 * Short description. this will sequence all the functions. 
	 *
	 * Detail description
	 * @param      none
	 * @global     none
	 * @since      1.0
	 * @access     public
	 * @return     void
	 * @update     date time
	*/
	function execute()
	{
	    $this->preProcess();
		$this->getWordsOut();
		$this->getCommand();
		$this->executeCommand();
	} // end func
}
?>