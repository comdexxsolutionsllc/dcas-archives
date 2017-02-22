<?php

/****************************************************************************************************
 *
 *    _____   _____       ___  ___   _____   _____  __    __ __    __  _____   _____   _____   _____
 *   /  ___| /  _  \     /   |/   | |  _  \ | ____| \ \  / / \ \  / / /  ___/ /  _  \ |  ___| |_   _|
 *   | |     | | | |    / /|   /| | | | | | | |__    \ \/ /   \ \/ /  | |___  | | | | | |__     | |
 *   | |     | | | |   / / |__/ | | | | | | |  __|    }  {     }  {   \___  \ | | | | |  __|    | |
 *   | |___  | |_| |  / /       | | | |_| | | |___   / /\ \   / /\ \   ___| | | |_| | | |       | |
 *   \_____| \_____/ /_/        |_| |_____/ |_____| /_/  \_\ /_/  \_\ /_____/ \_____/ |_|       |_|
 *
 * Copyright (c) Comdexx Software, LLC                                                  Version : 1.0
 ****************************************************************************************************/


//*** Stops all unauthorized access to this file.
if(!defined("IN_ENGINE")) {
    die(include_once('../error_docs/contextInEngine.html'));
}


//*** Starts ticketObject class.
class ticketObject //  extends coreEngine
{
		var $dbObject;

		public function __construct() {

		}

        public function __get($var) {
            print "Attempted to retrieve $var and failed...\n";
        }

        public function showUserQueueTickets() {
        	 echo (string) "SQL:1"; // Don't RETURN
        }

		public function showAssignedTicketsCOUNT() {
			// SELECT `type_id`,COUNT(`ticket_id`) FROM `support` WHERE `type_id`='1' ORDER BY `type_id`;
			$SQLq = $this->dbObject->query_count("SELECT `type_id`,COUNT(ticket_id) FROM `support` WHERE `type_id`='1' ORDER BY `type_id`;", 'ticket_id');
			if (function_exists('number_format')) {
				return number_format($SQLq);
			} else {
				return preg_replace('/(?<=\d)(?=(\d\d\d)+$)/', ',', $SQLq);
			}
		}

		public function showYellowTicketsCOUNT() {
			// SELECT `type_id`,COUNT(`ticket_id`) FROM `support` WHERE `type_id`='2' ORDER BY `type_id`;
			$SQLq = $this->dbObject->query_count("SELECT `type_id`,COUNT(ticket_id) FROM `support` WHERE `type_id`='2' ORDER BY `type_id`;", 'ticket_id');
			if (function_exists('number_format')) {
				return number_format($SQLq);
			} else {
				return preg_replace('/(?<=\d)(?=(\d\d\d)+$)/', ',', $SQLq);
			}
		}

        public function __call($function, $args) {
            $args = implode(', ', $args);
            print "Call to $function() with args '$args' failed!\n";
        }

        function __destruct() { }

}
?>