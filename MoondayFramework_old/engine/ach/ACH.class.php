<?php

/**
* @package ACH
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc	        Extension of ACH_core.class.php
* @uses
* @example
* @files
*/

class ACH extends ACH_core {
	
	//////////////////   EDIT BELOW
	
	var $debug		= TRUE; 	// set to TRUE to print out the error email instead of sending it
	var $errorEmail 	= 'you@yourdomain.com'; 	// address to send errors.
								// separate multiples by commas
	var $adminEmail		= 'paymentsupport@yourdomain.com'; // email for end user mailto for payment 'help'
	var $live		= FALSE; 	// change to TRUE to go live
	var $liveurl 		= ''; 	// 'LIVE' url - contact ACH Direct
	var $testurl 		= ''; 	// 'TEST' url - contact ACH Direct
	var $numRetries 	= '2'; 	// Number of times to retry the connection upon 
					   		// curl_exec() failure (just in case).  Set to '0' for only one attempt
		
	var $error_codes = array( 
		'U01', 		'U02', 	// pg_reponse_code 's that will trigger an email to $errorEmail above
		'U03', 		'U04', 	// most of these will probably never occur but it doesn't hurt.
		'U08', 		'U09', 
		'U11', 		'U12', 
		'U13', 		'U14', 
		'U18', 		
		'U21', 		'U22', 
		'U23', 		'U51', 
		'U52', 		'U53', 
		'U54', 		'U83', 
		'U84', 		'U85', 
		'U86',		'F01',
		'F03',		'F04',
		'F05',		'F07',
		'E10',		'E20',
		'E90',		'E99'
	);
	
	//////////////////   END EDITING
	
	var $displayText	= "";
	var $trans 		= "";
	
	// $msg (assoc array) = $HTTP_POST_VARS or $_POST for 4.1+ or $_GET if you're so inclined or any associative array
	// $exceptions (array) = variable names to remove from $msg
	function ACH($user,$pass,$msg='',$exceptions=''){
		($this->live) ? $this->posturl=$this->liveurl : $this->posturl=$this->testurl;

		$this->ACH_core($user,$pass);
		
		if (!empty($msg)){
			if (is_array($msg)){
				if ($this->setFields($msg,$exceptions)){
					if ($this->setMessage()){
						do {
							$response = $this->runTransaction();
							$this->numRetries--;
						} while (!$response && $this->numRetries >= 0);
						if ($response){
							if ($this->parseResponse($response)){
								if ($this->setTransactionDescription()){
									$this->chkError(0); // NO SCRIPT ERROR BUT MAY BE ACH ERROR
								} else { $this->chkError(5); } // ERROR IN setTransactionDescription()
							} else { $this->chkError(4); } // ERROR IN parseResponse()
						} else { $this->chkError(3); } // ERROR IN runTransaction()
					} else { $this->chkError(2); } // ERROR IN setMessage()
				} else { $this->chkError(1); } // ERROR IN setFields()
			} else { $this->chkError(7); } // $msg exists but is not an array
		}
	}
	
	// $tagleft and $tagright are associative arrays of links or whatever.  See ach_test.php
	function getDisplayText($tagleft="",$tagright=""){
		$hdr = '<table class=ACH_table>';
		$bdy = '<tr><td class=ACH_label>Date:</td><td class=ACH_val>'.date('m/d/Y H:i:s T').'</td></tr>';
		$ftr = "";
		$bdy .= '<tr><td class=ACH_label>First Name:</td><td class=ACH_val>'.$this->r_properties['ecom_billto_postal_name_first'].'</td></tr>';
		$bdy .= '<tr><td class=ACH_label>Last Name:</td><td class=ACH_val>'.$this->r_properties['ecom_billto_postal_name_last'].'</td></tr>';
		$bdy .= '<tr><td class=ACH_label>Amount:</td><td class=ACH_val>'.$this->r_properties['pg_total_amount'].'</td></tr>';
		$bdy .= '<tr><td class=ACH_label>Transaction Type:</td><td class=ACH_val>'.$this->r_properties['pg_transaction_type'].'</td></tr>';
		$bdy .= '<tr><td class=ACH_label>Payment ID:</td><td class=ACH_val>'.$this->r_properties['ecom_consumerorderid'].'</td></tr>';
		//$bdy .= '<tr><td class=ACH_label>RID:</td><td class=ACH_val>'.$this->r_properties['pg_consumer_id'].'</td></tr>';
		$bdy .= '<tr><td class=ACH_label>Trace Number:</td><td class=ACH_val>'.$this->r_properties['pg_trace_number'].'</td></tr>';
		switch ($this->r_properties['pg_response_type']){
			case 'A':
				$hdr .= '<tr><td colspan=2 class=ACH_hdr>Transaction Approved</td></tr>';
				$hdr .= '<tr><td colspan=2 class=ACH_spc></td></tr>';
				switch ($this->r_properties['pg_response_code']){
					case 'A01':					
						$bdy .= '<tr><td class=ACH_label>NOTES:</td><td class=ACH_val>Your payment has been submitted and pre-authorized for approval.  However, the transaction may require up to 4 business days to process and could end in declined status.  What this means is if your account does not contain sufficient funds when the EFT transaction occurs, this payment will be declined and NSF and late fees may apply.</td></tr>';
						break;
					default:
						$bdy .= '<tr><td class=ACH_label>NOTES:</td><td class=ACH_val>Unrecognized response code (A01)</td></tr>';
				}
				break;
			case 'D':
				$hdr .= '<tr><td colspan=2 class=ACH_hdr>Transaction DECLINED</td></tr>';
				$hdr .= '<tr><td colspan=2 class=ACH_spc></td></tr>';
				switch ($this->r_properties['pg_response_code']){
					case 'U01': case 'U03': case 'U04': case 'U08': case 'U09': case 'U11': case 'U12': case 'U13': case 'U14': case 'U18': case 'U20': case 'U21': case 'U22': case 'U23': case 'U51': case 'U52': case 'U53': case 'U54':					
						$bdy .= '<tr><td class=ACH_label>NOTES:</td><td class=ACH_val>Your transaction has been declined due to unusual circumstances.  Your account has not been charged.  Technical support has been contacted automatically as a result of this error.  The problem may be fixed shortly but please allow up to 24 hours to resolve the issue.  We\'re sorry for the inconvenience.  Please attempt your transaction again soon or contact your community manager to arrange for another payment option.  Thank you.</td></tr>';
						break;
					case 'U02':					
						$bdy .= '<tr><td class=ACH_label>NOTES:</td><td class=ACH_val>Your payment has been declined because your account has been flagged as a \'known bad\' account by the ACH processor.  Your account has not been charged.  If you believe this is an error please contact <a href=mailto:\''.$this->adminEmail.'\'>technical support</a>.</td></tr>';
						break;
					case 'U05': case 'U06': case 'U07':					
						$bdy .= '<tr><td class=ACH_label>NOTES:</td><td class=ACH_val>Your payment has been declined due to an AVS check failure.  Your account has not been charged.  AVS is a service that checks your account number against other information about your account like your zip code or area code.</td></tr>';
						break;
					case 'U10':					
						$bdy .= '<tr><td class=ACH_label>NOTES:</td><td class=ACH_val>Your payment has been declined because it has been determined to be a duplicate transaction.  Your account has not been charged for this transaction.  This probably means that you submitted a transaction a few moments ago using the same account information or you simply double-clicked the process payment button.  Please click here to view your <a href=history.php>payment history</a>.</td></tr>';
						break;
					case 'U19':
						$bdy .= '<tr><td class=ACH_label>NOTES:</td><td class=ACH_val>Your payment has been declined because the bank routing code you have entered is invalid.  Your account has not been charged for this transaction.</td></tr>';
						break;
					case 'U80': case 'U83': case 'U86':					
						$bdy .= '<tr><td class=ACH_label>NOTES:</td><td class=ACH_val>Your payment has been declined due to an authorization failure.  This means that either the routing code you have entered doesn\'t exist or the account you have entered doesn\'t exist, isn\'t debitable or is not in good standing (e.g. in a NSF state).</td></tr>';
						break;
					case 'U84': case 'U85':					
						$bdy .= '<tr><td class=ACH_label>NOTES:</td><td class=ACH_val>Your payment has been declined due to an authorization system failure.  This may mean that the authorizer or preauthorizer is currently down or is too busy to process the request.  Technical support has been contacted automatically as a result of this error in case this failure is not temporary.  However, this problem is most likely temporary so it is recommended that you attempt to processes this payment again in a few minutes.  If you continue to experience problems, please contact your community manager to arrange for another payment option.  Thank you.</td></tr>';
						break;
					default:
						$bdy .= '<tr><td class=ACH_label>NOTES:</td><td class=ACH_val>Unrecognized response code ()</td></tr>';
				}
				break;
			case 'E':
				$hdr .= '<tr><td colspan=2 class=ACH_hdr>Transaction ERROR</td></tr>';
				$hdr .= '<tr><td colspan=2 class=ACH_spc></td></tr>';
				if ($histnum){$ftr.="<a href=javascript:history.go(-$histnum)>&lt;&lt; Try Again</a></td>";}
				switch ($this->r_properties['pg_response_code']){
					case 'F01': case 'F03': case 'F04': case 'F05': case 'F07':
						$bdy .= '<tr><td class=ACH_label>NOTES:</td><td class=ACH_val>Your payment has failed due to a formatting error.  Technical support has been contacted automatically as a result of this error.  If you continue to experience problems, please contact your community manager to arrange for another payment option.  Thank you.</td></tr>';
						break;
					case 'E10': case 'E20': case 'E90': case 'E99':
						$bdy .= '<tr><td class=ACH_label>NOTES:</td><td class=ACH_val>Your payment has failed due to an unspecified error.  Technical support has been contacted automatically as a result of this error.  If you continue to experience problems, please contact your community manager to arrange for another payment option.  Thank you.</td></tr>';
						break;
				}
				break;
			default:
				$hdr .= '<tr><td colspan=2 class=ACH_hdr>Transaction ERROR</td></tr>';
				$hdr .= '<tr><td colspan=2 class=ACH_spc></td></tr>';
				$bdy .= '<tr><td class=ACH_label>NOTES:</td><td class=ACH_val>Unrecognized Response Type.'.$this->r_properties['pg_response_description'].' Tech support has been notified</td></tr>';
				$this->chkError(6);
		}
		$bdy .= '<tr><td class=ACH_label>&nbsp;</td><td class=ACH_val>Please <a href=javascript:print()>print</a> this page for your records</td></tr>';
		$ftr.="<tr><td colspan=2>";
		$ftr.="<table class=ACH_ftr_table><tr>";
		$ftr.="<td class=ACH_ftr_left>".$tagleft[$this->r_properties['pg_response_type']]."</td>";
		$ftr.="<td class=ACH_ftr_right>".$tagright[$this->r_properties['pg_response_type']]."</td>";
		$ftr.="</tr></table></td></tr></table>";
		$this->displayText=$hdr.$bdy.$ftr;
		return $this->displayText;
	}
	
	// ERROR HANDLER - prints to screen in debug mode (even if there isn't an error).  
	// With debug off - sends email upon script error or based on if pg_response_code is in $errorCodes array
	function chkError($err){
		$send=0;
		
		if ($err){
			$sub="ACH CLASS ERROR: ";
			$send=1;
			switch ($err){
				case '1':
					$msg.="\n\nCLASS ERROR: setFields()\n\n";
					break;
				case '2':
					$msg.="\n\nCLASS ERROR: setMessage()\n\n";
					break;
				case '3':
					$msg.="\n\nCLASS ERROR: runTransaction() May be curl connection problem or no posturl supplied\n\n";
					break;
				case '4':
					$msg.="\n\nCLASS ERROR: parseResponse()\n\n";
					break;
				case '5':
					$msg.="\n\nCLASS ERROR: setTransactionDescription()\n\n";
					break;
				case '6':
					$msg.="\n\nCLASS ERROR: getDisplayText()\n\n";
					break;
				case '7':
					$msg.="\n\nCLASS ERROR: $msg is not an array in ACH()\n\n";
					break;
				default:
					$msg.="\n\nCLASS ERROR: Unspecified\n\n";
			}
		} else {
			$sub="ACH ERROR: ".$this->r_properties['pg_response_code']."-".$this->r_properties['pg_response_description'];
		}
		
		if (is_array($this->error_codes) || $this->debug){
			if (!empty($this->error_codes) || $this->debug){
				if (in_array($this->r_properties['pg_response_code'],$this->error_codes) || $this->debug){
					$msg.="TRANSACTION TYPE: ".$this->trans."\n\n";
					$msg.="TRANSACTION MESSAGE:\n";
					if (is_array($this->t_properties)){
						if (!empty($this->t_properties)){
							foreach($this->t_properties AS $k=>$v){
								if ($k != 'ecom_payment_check_account' && $k != 'ecom_payment_check_trn' && $k != 'pg_password'){
									$msg .= $k;
									for($i=strlen($k); $i<34; $i++){ $msg.=" "; }
									$msg .= "= ".$v."\n";
								}
							}
							$msg.="\n";
						}
					}
					$msg.="RESPONSE MESSAGE:\n";
					if (is_array($this->r_properties)){
						if (!empty($this->r_properties)){
							foreach($this->r_properties AS $k=>$v){
								$msg .= $k;
								for($i=strlen($k); $i<30; $i++){ $msg.=" "; }
								$msg .= "= ".$v."\n";
							}
							$msg.="\n";
						}
					}
					$send=1;
				}
			}
		}
		if ($this->debug){
			echo str_replace("\t","",str_replace("\n","<br>",str_replace("\n\n","<P>",$sub."<P>".$msg)));
		} elseif ($send) {
			mail($this->errorEmail,$sub,$msg,"FROM: marc@wvmt.com");
		}
	}
}
?>