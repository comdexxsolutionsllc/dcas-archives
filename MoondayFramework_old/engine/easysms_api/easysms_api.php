<?php

/**
* @package EasySMS
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc Simple EasySMS API w/o cURL
* @uses
* @example
* @files
*/

class EasySMS {

	// User Authentication
	var $login = "YOUR_EASYSMS_USERNAME";
	var $password = "YOUR_EASYSMS_PASSWORD";

    // Class initialization
    function EasySMS ( $user = null, $pass = null) {
		if ( $user ) {
			$this->login = $user;
		}else{
			die('no username specified!');
		}
		if ( $pass ) {
			$this->password = $pass;
		}else{
			die('no password specified!');
		}
    }

    // Query SMS balance 
    function getbalance() {
		$request = 'https://' . $this->login . ':' . $this->password . '@' . 'www.net2sms.gr/srvauth/'
					.	'index?cmd=easysms&action=get_balance&balance=true'	;

		return $this->navigate( $request );
    }


    // Get delivery reports
    function getDeliveryReports() {
		$request = 'https://' . $this->login . ':' . $this->password . '@' . 'www.net2sms.gr/srvauth/'
					. 'index?cmd=easysms&action=get_status&get_status=true'	;

		return $this->navigate( $request );
    }


    // Send SMS
    function sendSMS( $mobile_number = null,	//	The target mobile phone number (including country code)
					$text = null,				//	The SMS body
					$delivery = false,			//	Request delivery report on this SMS
					$flash = false,				//	Send it as flash SMS
					$originator = ''			//	The originator of the SMS
				) {

		$request = 'https://' . $this->login . ':' . $this->password . '@' . 'www.net2sms.gr/srvauth/'
					. 'index?cmd=easysms&action=send_sms'
					. '&originator=' . urlencode($originator)
					. '&mobile_number=' . urlencode($mobile_number)
					. '&text=' . urlencode($text)
					. ( $delivery ? '&request_delivery=true' : '')
					. ( $flash ? '&flash=true' : '');

		return $this->navigate( $request );
    }




		// Send the request and return the result
		function  navigate( $request ){

			//Open URL for reading
			$handle = fopen ($request, 'r');
			if ( $handle ){
				//Get the response from the server
				$response = '';
				while ( $line = @fgets($handle,1024) ) { $response .= $line; }
				//Release the handle
				fclose ($handle);

				return $response;
			} else {
				return false;
			}
		}


}

	// Example
//	$mySMS = new EasySMS('alex', '11815');

	//get the account balance
//	echo $mySMS->getbalance();

	//get the delivery reports
//	echo $mySMS->getDeliveryReports();

	//send sms
//	echo $mySMS->sendSMS('44123451234',		//the target mobile number
				//'hi mom!',			//the message
				//true,						//request delivery report
				//false,					//not as flash sms
				//'Jim'						//set the originator
				//	);
?>
