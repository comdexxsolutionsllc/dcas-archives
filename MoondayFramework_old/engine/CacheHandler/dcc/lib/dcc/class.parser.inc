<?php
/////////////////////////////////////////////////////////////
//  DCC::QuickSite URI Parser
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

class parser extends root {

 function parser () {
	$this->_args = explode("/", $_GET['path']);
	$this->_root($this->_ROOT_);
 }

 function &args() { return $this->_args; }

 function _root (&$r) {
	$q = array_shift($this->_args);
	$p = isset($r[$q]) ? $q : '*';

	if (isset($r[$p])) {
		if (is_array($r[$p])) $this->_root($r[$p]);
		elseif (count($this->_args) == 0) define(ME, $r[$p]);
		else $this->error_404($q);
		array_unshift($this->_args, $q);
	} else $this->error_404($q);
 }

}

$ROOT = new parser();

?>