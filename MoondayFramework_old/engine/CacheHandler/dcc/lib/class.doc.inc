<?php
/////////////////////////////////////////////////////////////
//  DCC::QuickSite Example: documentation wrapper
//  Copiright (C) 2003, 2004, Gregory A. Rozanoff
//
//  This library is free software; you can redistribute it and/or
//  modify it under the terms of the GNU Lesser General Public
//  License as published by the Free Software Foundation; either
//  version 2.1 of the License, or (at your option) any later version.
//  This library is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
//  Lesser General Public License for more details.
//  You should have received a copy of the GNU Lesser General Public
//  License along with this library; if not, write to the Free Software
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//
/////////////////////////////////////////////////////////////

class module extends engine {

 var
	 $CACHE = TRUE,
	 $lvl = 1,
	 $TEMPL = 'documentation';

// Obligatory functions

 function _init() {			// Initialize module
	$this->SELF = $this->ARGS[$this->lvl] ? $this->DataDir."/doc/".$this->ARGS[$this->lvl].".htm" : $this->DataDir."/doc/index.htm";
	return file_exists($this->SELF) ? filemtime($this->SELF) : FALSE;
 }

 function _execute() {			// Execute module
	$this->assign("title", "DCC::QuickSite Pro | ". ($this->ARGS[$this->lvl] == 'license' ? 'License' : 'Documentation'));
	$data = $this->summon($this->SELF);
	if ($this->ARGS[$this->lvl] == 'license')
		$data = "<textarea rows=24 cols=80>".$data."</textarea>";
	else {
		$this->assign("toc", $this->generate_toc($data));
		$this->pre_charge($data);
		$data = ereg_replace("\n\n", "<br /><br />\n", $data);
	}
	$this->assign("content", $data);
 }

// User-defined functions

 function pre_charge(&$text) {
	 $res = preg_match_all ("#<pre>(((?!</?pre(?:[^>]*)>).)*)<\/pre>#is", $text, $matches);
	 for ($i = 0; $i < $res; $i++) {
		 $text = preg_replace("#".preg_quote($matches[0][$i])."#is", "<pre>".htmlspecialchars($matches[1][$i])."</pre>", $text);
	 }
 }

 function generate_toc (&$text) {
	$res = preg_match_all ("/<h(\d)>([^<>]*)<\/h\\1>/is", $text, $matches);
	$lvl = 0;
	for ($i = 0; $i < $res; $i++) {
		if ($matches[1][$i] > $lvl) {
			for ($j = 0; $j < $matches[1][$i] - $lvl; $j++) $result .= "<ul>\n";
			$lvl = $matches[1][$i];
		}

		if ($matches[1][$i] < $lvl) {
			for ($j = 0; $j < $lvl - $matches[1][$i]; $j++) $result .= "</ul>\n";
			$lvl = $matches[1][$i];
		}

		$result .= "<li><a href=\"#toc_$i\">{$matches[2][$i]}</a></li>\n";
		$back = $lvl > 1 ? "<a name=\"toc_$i\"></a>" : "<hr noshade size=1 />\n<a href=\"#top\" name=\"toc_$i\"><img src=\"/dcc/img/up.gif\" border=0></a>&nbsp;";
		$text = preg_replace("#".preg_quote($matches[0][$i])."#is", $back."<span class=\"big{$matches[1][$i]}\">{$matches[2][$i]}</span>", $text);
	}
	for (;$lvl>0;$lvl--) $result .= "</ul>\n";
	return $result;
 }

}
?>