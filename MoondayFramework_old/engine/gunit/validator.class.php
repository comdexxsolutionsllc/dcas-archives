<?php
/**
* @package Validator 
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc Validator class from the GiMb framework
* @uses Alerter
* @example
* @files
*/

 
/**
* Validator class
*
* Validates whether user entered input is valid.<br />
* Example:
* <code>
* include_once('alerter.php');
* include_once('validator.php');
* $validator = new Validator;
* $validator->setEmail( $_POST['email'] ); 
* $validator->setUsername( $_POST['username'] ); 
* $validator->setPasswords( $_POST['password'], $_POST['conf_password'] );
* $validator->setSilentMode( true );
* $valid = $validator->Validate();
*</code>
*/
	
class Validator {
 	/**
 	* @var array $error
 	*/
  	$error = array();
  	
  	/**
 	* @var bool $silentmode
 	*/
	$silentmode = false;
	 /**
 	* @var bool $validated
 	*/
	$validated = true;
	/**
 	* @var string $email
 	*/
	$email = false;
  	/**
 	* @var string $password
 	*/
	$password = false;
  	/**
 	* @var string $confpassword
 	*/
	$confpassword = false;	
  	/**
 	* @var string $username
 	*/
	$username = false;
	
	/**
 	* @var bool $v_email Flag to check email
 	*/
	$v_email = false;
	/**
 	* @var bool $v_password Flag to check passwords
 	*/
	$v_password = false;
	/**
 	* @var bool $v_username Flag to check username
 	*/
	$v_username = false;
	
	/**
 	* Set silent mode on or off - throw errors or stay quiet
 	*
 	* @param bool $flag On / off
 	* @return void
 	*/
	function setSilentMode( $flag ){
		if( is_bool( $flag ) )
			$this->silentmode = $flag;
	}
	
	/**
	* Set email and turn the flag to check it later
	*
 	* @param string $email
 	* @return void
 	*/
	function setEmail( $email ){
		$this->email = $email;
		$this->v_email = true;
	}
	
	/**
	* Set username and turn the flag to check it later
	*
 	* @param string $username
 	* @return void
 	*/
	function setUsername( $username ){
		$this->username = $username;
		$this->v_username = true;
	}

	/**
	* Set passwords and turn the flag to check them later
	*
 	* @param string $pass
 	* @param string $confpass
 	* @return void
 	*/
	function setPasswords( $pass, $confpass ){
		$this->password = $pass;
		$this->confpassword = $confpass;
		$this->v_password = true;
	}
	
	/**
	* Validate all the user input set in the object properties
	*
 	* @return bool
 	*/	
	function Validate(){
		if( $this->v_email )
			$this->ValidateEmail();
		if( $this->v_username )
			$this->ValidateUsername();
		if( $this->v_password )
			$this->ValidatePasswords();
			
		return $this->validated;
	}
	
	/**
	* Handle errors
	*
 	* @param string $msg
 	* @return void
 	*/
	function setError( $msg ) {
	  	$this->error[] = $msg;
  		//alerter::Alert( $msg, $this->silentmode );
	}
	
	/**
	* Validate e-mail
	*
 	* @return bool
 	*/
	function ValidateEmail(){
		if( !eregi('^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$', $this->email ) ) {
		  	$this->setError('Invalid e-mail address');
		  	$this->validated = false;
			return false;
		}
		return true;
	}
	
	/**
	* Validate username
	*
 	* @return bool
 	*/
	function ValidateUsername(){
	  	$len = strlen( $this->username );
		if( $len < 6 || $len > 20 || !eregi('^[a-z0-9_]+$', $this->username ) ) {
			$this->setError('Invalid username. Only alpha-numeric entries more than 5 chars are accepted');
		  	$this->validated = false;
			return false;
		}
		return true;
	}   
	
	/**
	* Validate passwords
	*
 	* @return bool
 	*/
	function ValidatePasswords(){
		if( strlen( $this->password ) < 5 || $this->password <> $this->confpassword || !eregi('^[a-z0-9]+$', $this->password ) ){
			$this->setError('Invalid password (only alpha-numeric strings longer than 5 chars are accepted) or passwords don\'t match');
		  	$this->validated = false;
			return false;
		}
		return true;
	}   
}
?>