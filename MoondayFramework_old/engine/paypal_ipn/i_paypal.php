<?php
/**
* @package paypal_ipn
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc Class to process Paypal Instant Payment Notification information
* @uses cURL
* @example
* @files
*/

define ("PAYPAL_SECURED_URL", "https://www.paypal.com/cgi-bin/webscr");

class paypal_ipn
{
	/** The name of the function that will pre-process the IPN Notification
	  * function_name ($ipn_notification_obj)
	  */
	var $function_preprocess;

	/** The name of the function that will post-process the IPN Notification
	  * function_name ($ipn_notification_obj, $status)
	  */
	var $function_postprocess;

	var $proxy_url;
	var $proxy_user_and_pwd;
	
	function paypal_ipn ()
	{
		$this->function_preprocess = null;
		$this->function_postprocess = null;

		$this->proxy_url = null;
		$this->proxy_user_and_pwd = null;
	}

	function process_notification ($post_from_paypal_server, $traces=false)
	{
		// 1. Create the IPN Notification Object
		$ipn_notification = new paypal_ipn_notification ();
		$ipn_notification->set_traces ($traces);

		// 2. Retrieve its variables
		$ipn_notification_vars = get_object_vars ($ipn_notification);

		// 3. Fill them with the variables posted by Paypal server
		foreach ($post_from_paypal_server as $current_info=>$value)
		{
			if(array_key_exists ($current_info, $ipn_notification_vars))
			{
				$ipn_notification->$current_info = $value;
			}
		}

		$ipn_notification->add_log ("Notification received - Invoice #".$ipn_notification->invoice);

		// 4. Call the pre-process function if it exists
		if(!is_null($this->function_preprocess))
		{
			$func = $this->function_preprocess;
			$func ($ipn_notification);
		}

		// 5. Post the object back to Paypal
		$return_code = $this->http_post (PAYPAL_SECURED_URL, &$ipn_notification);

		if($return_code)
			$ipn_notification->add_log ("Code returned by server: ".$return_code);
		else
			$ipn_notification->add_log ("The server returned an unknown status code: $return_code");

		// 6. Call the post-process function if it exists
		if(!is_null($this->function_postprocess))
		{
			$func = $this->function_postprocess;
			$func ($ipn_notification, $return_code);
		}		
	}

	function set_proxy_options ($proxy_url, $proxy_user_and_pwd)
	{
		$this->proxy_url = $proxy_url;
		$this->proxy_user_and_pwd = $proxy_user_and_pwd;
	}

	function set_process_functions ($function_name1, $function_name2)
	{
		// The name of the function to be called when we receive notification
		$this->function_preprocess = $function_name1;

		// The name of the function to be called after the connection to the server
		$this->function_postprocess = $function_name2;
	}

	function http_post ($url, $ipn_notification)
	{
		// Notification if transfered into a urlencoded string
		$post_string = $ipn_notification->to_post_string ()."cmd=_notify-validate";

		if ($connection = curl_init())
		{
			curl_setopt($connection, CURLOPT_URL, PAYPAL_SECURED_URL);
			curl_setopt($connection, CURLOPT_RETURNTRANSFER,1);

			curl_setopt($connection, CURLOPT_POST, 1);
			curl_setopt($connection, CURLOPT_POSTFIELDS, $post_string);
			
			// If you need to go through a proxy server, see set_proxy_options
			if(!is_null($this->proxy_url) and !is_null($this->proxy_user_and_pwd))
			{
				if(preg_match("/[^:]+:[0-9]+/", $this->proxy_url)
						and preg_match("/([^:]+):.*/", $this->proxy_user_and_pwd, $matches))
				{
					$ipn_notification->add_log ("Proxy settings: user $matches[1] on ".$this->proxy_url);
					curl_setopt($connection, CURLOPT_PROXY, $this->proxy_url);
					curl_setopt($connection, CURLOPT_PROXYUSERPWD, $this->proxy_user_and_pwd);
				}
				else
				{
					$ipn_notification->add_log ("Can't set proxy settings");
				}
			}

			$ipn_notification->add_log ("Connection to $url");
			$ipn_notification->add_log ("Post string = $post_string");
			
			$paypal_server_response = curl_exec($connection);
			
			curl_close($connection);
		} 
		else
		{
			$ipn_notification->add_log ("Failed to connect to $url");
			return false;
		}

		$response = false;
		if(preg_match("/(VERIFIED|INVALID)/", $paypal_server_response, $matches))
		{
			$response = $matches[1];
		}

		return $response;
	}
}

class paypal_ipn_notification
{
	// Variables for all IPNs
	var $receiver_email;
	var $item_name;
	var $item_number;
	var $quantity;
	var $invoice;
	var $custom;
	var $option_name1;
	var $option_selection1;
	var $option_name2;
	var $option_selection2;
	var $num_cart_items;
	var $payment_status;
	var $pending_reason;
	var $payment_date;		// 18:30:30 Jan 1, 2000 PST
	var $payment_gross;
	var $payment_fee;
	var $txn_id;
	var $txn_type;
	var $first_name;
	var $last_name;
	var $address_street;
	var $address_city;
	var $address_state;
	var $address_country;
	var $address_status;		// confirmed | unconfirmed
	var $payer_email;
	var $payer_id;
	var $payer_status;
	var $payment_type;		// echeck | instant
	var $notify_version;		// 1.3
	var $verify_sign;
	var $mc_gross;
	var $mc_fee;
	var $mc_currency;

	// Variables with subscriptions
	// var $txn_type		// For a subscription : subscr_signup | subscr_cancel | subscr_failed | subscr_payment | subscr_eot
	var $subscr_date;
	var $period1;
	var $period2;
	var $period3;
	var $amount1;
	var $amount2;
	var $amount3;
	var $recurring;
	var $reattempt;
	var $retry_at;
	var $recur_times;
	var $username;
	var $password;
	var $subscr_id;

	var $log_info;
	var $traces;
	
	function paypal_ipn_notification ()
	{
		$this->log_info = array();
		$this->traces = false;
	}

	function set_traces ($traces)
	{
		if(is_bool($traces))
		{
			$this->traces = $traces;
		}
	}

	function to_post_string ()
	{
		$post_string = "";

		$vars = get_object_vars ($this);

		foreach($vars as $var=>$value)
		{
			if($var!="log_info" and $var!="traces" and !is_null($value))
			{
				$post_string.="$var=".urlencode($this->$var)."&";
			}
		}

		return $post_string;
	}

	function add_log ($string)
	{
		if($this->traces)
		{
			$this->log_info[] = date("[Y/m/d H:i:s]")." ".$string;
		}
	}
}

?>
