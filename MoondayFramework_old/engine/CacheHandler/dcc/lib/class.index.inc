<?php
/////////////////////////////////////////////////////////////
//  DCC::QuickSite Example: Default static content wrapper
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
 	$lvl = 0,
 	$CACHE = TRUE;

// Obligatory functions

 function _init() {			// Initialize module
	$this->SELF = $this->DataDir."/".($this->ARGS[$this->lvl] ? $this->ARGS[$this->lvl] : 'index').".htm";
	return file_exists($this->SELF) ? filemtime($this->SELF) : FALSE;
 }

 function _execute() {			// Execute module
	$this->assign("title", "DCC::QuickSite Pro | ". ($this->ARGS[$this->lvl] ? $this->ARGS[$this->lvl] : "index"));
	$this->assign("content", $this->summon($this->SELF));
 }

// User-defined functions

}
?>