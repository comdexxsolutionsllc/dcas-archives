<?php
/**
* @package ACH_core
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc	        PHP class / curl for raw_post method
* @uses PHP 4.0.2+ & cURL
* @example 	//edit default vars in the ACH.class.php
*           //modify getDisplayText() method in ACH.class.php (not necessary for testing but do it before you go live)
*           //include both classes in your script:
* 
*           require ('path/to/class/ACH_core.class.php');
*           require ('path/to/class/ACH.class.php');
*           
*           $payment = new ACH('your_merchant_id','your_password','assoc array of fields','array of keys to not send');
* 
*           echo $payment->getDisplayText('assoc array of links for footer left','assoc array of links for footer right');
* 
*           // also see ach_test.php
* @files 
*       ACH_core.class.php (core transaction processor)
*       ACH.class.php (extends core)
*/
	
class ACH_core {
	
	var $t_properties = array (
		'pg_merchant_id' 				=> "",		'pg_password' 					=> "",
		'pg_transaction_type'			=> "",		'pg_total_amount' 				=> "",
		'pg_sales_tax_amount'			=> "",
		// MERCHANT DATA
		'pg_merchant_data_1'			=> "",		'pg_merchant_data_2'			=> "",
		'pg_merchant_data_3'			=> "",		'pg_merchant_data_4'			=> "",
		'pg_merchant_data_5'			=> "",		'pg_merchant_data_6'			=> "",
		'pg_merchant_data_7'			=> "",		'pg_merchant_data_8'			=> "",
		'pg_merchant_data_9'			=> "",
		// EFT
		'ecom_payment_check_trn'			=> "",		'ecom_payment_check_account'		=> "",
		'ecom_payment_check_account_type'	=> "",		'ecom_payment_check_checkno'		=> "",
		// CREDIT
		'ecom_payment_card_type'			=> "",		'ecom_payment_card_name'			=> "",
		'ecom_payment_card_number'		=> "",		'ecom_payment_card_expdate_month'	=> "",
		'ecom_payment_card_expdate_year'	=> "",		'ecom_payment_card_verification'	=> "",
		'ecom_procurement_card'			=> "",		'ecom_customer_acct_code'		=> "",
		'pg_cc_swipe_data'				=> "",		'pg_mail_or_phone_order'			=> "",
		// IDs
		'pg_consumer_id'				=> "",		'ecom_consumerorderid'			=> "",
		// BILLING INFO
		'ecom_walletid'				=> "",		'pg_billto_postal_name_company'	=> "",
		'ecom_billto_postal_name_first'	=> "",		'ecom_billto_postal_name_last'	=> "",
		'ecom_billto_postal_street_line1'	=> "",		'ecom_billto_postal_street_line2'	=> "",
		'ecom_billto_postal_city'		=> "",		'ecom_billto_postal_stateprov'	=> "",
		'ecom_billto_postal_postalcode'	=> "",		'ecom_billto_postal_countrycode'	=> "",
		'ecom_billto_telecom_phone_number'	=> "",		'ecom_billto_online_email'		=> "",
		'pg_billto_ssn'				=> "",		'pg_billto_dl_number'			=> "",
		'pg_billto_dl_state'			=> "",		
		// RECURRING FIELDS
		'pg_schedule_quantity'			=> "",		'pg_schedule_frequency'			=> "",
		'pg_schedule_recurring_amount'	=> "",		'pg_schedule_start_date'			=> "",
		//MISC FIELDS
		'pg_customer_ip_address'			=> "",		'pg_preauth_no_decline_on_fail'	=> "FALSE",
		'pg_preauth_decline_on_noanswer'	=> "FALSE",	'pg_avs_method'				=> "",
		//ADMIN FIELDS
		'pg_original_trace_number'		=> "",		'pg_original_authorization_code'	=> ""
	);
	
	var $r_properties = array (
		'pg_response_type' 				=> "",	'pg_response_code' 				=> "",
		'pg_response_description'		=> "",	'pg_trace_number' 				=> "",
		'pg_merchant_id'				=> "",	'pg_transaction_type'			=> "",
		'pg_consumer_id'				=> "",	'ecom_consumerorderid'			=> "",
		'ecom_billto_postal_name_first'	=> "",	'ecom_billto_postal_name_last'	=> "",
		'ecom_billto_online_email'		=> ""
	);
	
	var $posturl 		= "";
	var $message 		= "";
	var $responseText 	= "";
	var $trans 		= "";
	
	function ACH_core($usr,$ps){
		$this->t_properties['pg_merchant_id']=$usr;
		$this->t_properties['pg_password']=$ps;
	}
	
	// $props (assoc array) = $HTTP_POST_VARS or $_POST for 4.1+ or $_GET if you're so inclined or any associative array
	// $exceptions (array) = variable names to remove from $props
	function setFields ($props, $exceptions="") {
		if (is_array($props)){
			if (!empty($props)){
				foreach($props as $k=>$v){
					if (is_array($exceptions)){
						if (!in_array($k,$exceptions)){
							$this->t_properties[$k]=$v;
						}
					} else {
						$this->t_properties[$k]=$v;
					}
				}
				return 1;
			} else {
				echo "<b>AHH!  I NEED DATA TO SEND!</b>";
				return 0;	
			}
		} else {
			echo "<b>AHH!  I NEED DATA TO SEND!</b>";
			return 0;	
		}
	}
	
	// SET TRANSACTION MESSAGE PROPERTIES
	function setTProperty ($prop,$val) {
		if ($prop && $val){
			$this->t_properties[$prop]=$val;
			return 1;
		} else {
			return 0;
		}
	}
	
	// SET RESPONSE MESSAGE PROPERTIES
	function setRProperty ($prop,$val) {
		if ($prop && $val){
			$this->r_properties[$prop]=$val;
			return 1;
		} else {
			return 0;
		}
	}
	
	// BUILD THE MESSAGE USING TRANSACTION PROPERTIES
	function setMessage (){
		if (!empty($this->t_properties)){
			if (is_array($this->t_properties)){
				foreach($this->t_properties as $k=>$v){
					if ($v){
						$this->message.=$k."=".urlencode($v)."&";
					}
				}
				$this->message.="endofdata&";
				return 1;
			} else { return 0; }
		} else { return 0; }
	}
	
	//  UMM... RUN THE TRANSACTION
	function runTransaction(){
		ob_start();
	
		// setup curl
			$ch = curl_init ($this->posturl);
		// set curl to use verbose output
			curl_setopt ($ch, CURLOPT_VERBOSE, 1);
		// set curl to use HTTP POST
			curl_setopt ($ch, CURLOPT_POST, 1);
		// set POST output
			curl_setopt ($ch, CURLOPT_POSTFIELDS, $this->message);
		//execute curl and return result to STDOUT
			$suc = curl_exec ($ch);
		//close curl connection
			curl_close ($ch);
	
		// set variable eq to output buffer
		$result = ob_get_contents();
		ob_end_clean();
		if ($suc){
			return $result;
		} else {
			return 0; //return '0' on curl_exec failure (arbitrary connection error)
		}
	}
	
	// PARSE RESPONSE
	function parseResponse($rsps){
		// clean response data of whitespace, convert newline to ampersand for parse_str function and trim off endofdata
		if ($rsps){
			$this->responseText = str_replace("\n","&",trim(str_replace("endofdata", "", trim($rsps))));
			parse_str($this->responseText,$arr);
			if (!empty($arr)){
				foreach($arr as $k=>$v){
					$this->r_properties[$k]=$v;
				}
				return 1;
			} else {
				return 0;
			}
		} else {
			return 0;	
		}
	}
	
	function getResponseField($field){
		return $this->r_properties[$field];
	}
	
	function setTransactionDescription(){
		if ($this->r_properties['pg_transaction_type']){
			switch($this->r_properties['pg_transaction_type']){
				case '10': case '20': $this->trans='SALE'; break;	
				case '11': case '21': $this->trans='AUTH ONLY'; break; 
				case '12': case '22': $this->trans='CAPTURE'; break;
				case '13': case '23': $this->trans='CREDIT'; break;
				case '14': case '24': $this->trans='VOID'; break;
				case '15': $this->trans='PRE-AUTH'; break;
				case '20': $this->trans='SALE'; break;	
				case '25': $this->trans='FORCE'; break;
				case '26': $this->trans='VERIFY ONLY'; break;
				case '40': $this->trans='SUSPEND'; break;
				case '41': $this->trans='ACTIVATE'; break;
				case '42': $this->trans='DELETE'; break;
				default :
					$this->trans='UNKNOWN TRANSACTION TYPE';
			}
			return 1;
		} else {
			return 0;
		}
	}
}
?>