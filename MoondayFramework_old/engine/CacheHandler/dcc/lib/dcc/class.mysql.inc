<?php
/////////////////////////////////////////////////////////////
//  MySQL interface class.
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

class db extends root {

var $DBHandle, $DBError, $DBErrno;

function connect() {
 $this->DBHandle = @mysql_connect($this->DBHost, $this->DBUser, $this->DBPass);
 @mysql_select_db($this->DBName, $this->DBHandle);
 $this->DBError = @mysql_error();
 $this->DBErrno = @mysql_errno();
}

function query($q) {
 $q = stripslashes($q);
 $res = @mysql_query($q, $this->DBHandle);
 $this->DBError = @mysql_error();
 $this->DBErrno = @mysql_errno();
 return $res;
}

function num_rows($res) {
 return @mysql_num_rows($res);
}

function num_fields($res) {
 return @mysql_num_fields($res);
}

function fetch_row($res) {
 return @mysql_fetch_row($res);
}

function fetch_array($res) {
 return @mysql_fetch_array($res);
}

function fetch_object($res) {
 return @mysql_fetch_object($res);
}

function last_id() {
 return mysql_insert_id($this->DBHandle);
}

function close() {
 @mysql_close($this->DBHandle);
 $this->DBError = @mysql_error();
 $this->DBErrno = @mysql_errno();
}

function do_error() {
 return $this->DBErrno ? "<b>&raquo; ERROR #".$this->DBErrno.":</b> <i>".$this->DBError."</i>\n" : "<b>&raquo; OK!</b>\n";
}

}

?>