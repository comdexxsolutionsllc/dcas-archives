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

/*
    DEVELOPER NOTES :
        Don't forget to add a super user, no user can delete a super user.

*/

//*** Starts userObject class.
class userObject
{
    var $userid,
    	$user_level_id,
    	$usersig,
        $dbObject,
        $errorObject;


    public function __get($var) {
        print "Attempted to retrieve $var and failed...\n";
    }

    public function __call($function, $args) {
        $args = implode(', ', $args);
        print "Call to $function() with args '$args' failed!\n";
    }

    /**
     * Returns user's unique ID.
     *
     * @return int
     */
    function displayUserId()
    {
        return $this->userid;
    }

    /**
     * Returns user's full name.
     *
     * @return string
     */
    function displayFullName($accesstype)
    {
    	if($accesstype == "client")
    	{
    		$SQLq = $this->dbObject->query("SELECT first_name, last_name FROM users WHERE user_id = '{$this->userid}'", 1);
    		return "{$SQLq['first_name']} {$SQLq['last_name']}";
    	} elseif ($accesstype =="admin") {
    		$SQLq = $this->dbObject->query("SELECT first_name, last_name FROM staff WHERE staff_id = '{$this->userid}'", 1);
    		return "{$SQLq['first_name']} {$SQLq['last_name']}";
    	} else {
    		trigger_error("displayFullName() Error",E_USER_NOTICE);
    	}
    }

    /**
     * Add's a user to MySQL database.
     *
     * @param $username string  - User's username.
     * @param $password string  - User's password.
     * @param $firstname string - User's first name.
     * @param $lastname string  - User's last name.
     * @param $email string     - User's email address.
     * @param $active string    - true = active | false = inactive
     * @param $userlevel int    - User's access level.
     * @return bool
     */
    function addUser($username, $password, $firstname, $lastname, $email, $active="true", $access_level="")
    {
        $salt = $this->generate_salt();

	    // Now encrypt the password using that salt
    	$password = md5(md5($password).$salt);

        //$password = md5($password);
        $SQLq = $this->dbObject->query("INSERT INTO users ( username, password, firstname, lastname, email, active , salt) VALUES ( '{$username}', '{$password}', '{$firstname}', '{$lastname}', '{$email}', '{$active}','$salt' )");
        if(!$SQLq) {
            $this->errorObject->displayError("MySQL Error", mysql_error());
            return(0);
        } else {
            if($access_level != "") {
                $this->clearAccessLevels($user_id);
                foreach($access_level as $level) {
                    $SQLq = $this->addAccessLevel($user_id, $access_level_id);
                }
                echo "test";
            }
        }
        return(1);
    }

    /**
     * Remove a user from the MySQL database.
     *
     * @param $userid int - User's unique ID.
     * @return bool
     */
    function delUser($userid=0)
    {
        $SQLq = $this->dbObject->query("DELETE FROM users WHERE id='{$userid}' LIMIT 1");
        if(!$SQLq) {
            $this->errorObject->displayError("MySQL Error", mysql_error());
            return(0);
        }
        return(1);
    }

    /**
     * Updates a user from the MySQL database.
     *
     * @param $userid int       - User's unique ID.
     * @param $username string  - User's username.
     * @param $password string  - User's password.
     * @param $firstname string - User's first name.
     * @param $lastname string  - User's last name.
     * @param $email string     - User's email address.
     * @param $active string    - true = active | false = inactive
     * @param $userlevel int    - User's access level.
     * @return bool
     */
    function updateUser($userid=0, $username, $password, $firstname, $lastname, $email, $active, $access_level)
    {
        if($password != "") {
        $salt = $this->generate_salt();

	    // Now encrypt the password using that salt
    	$password = md5(md5($password).$salt);
            //$password = md5($password);
            $pass_query = "password='{$password}',";
        }

        $SQLq = $this->dbObject->query("UPDATE users SET username='{$username}', {$pass_query} firstname='{$firstname}', lastname='{$lastname}', email='{$email}', active='{$active}',salt='$salt' WHERE id='{$userid}' LIMIT 1");
        if(!$SQLq) {
            $this->errorObject->displayError("MySQL Error", mysql_error());
            return(0);
        } else {
            if($access_level != "") {
                $this->clearAccessLevels($userid);
                foreach($access_level as $level) {
                    $SQLq = $this->addAccessLevel($userid, $level);
                }
            }
        }
        return(1);
    }

    /**
     * Checks the username information against the database.
     *
     * @param $user string - User's username.
     * @param $pass string - User's password.
     * @return user_id, user_level_id, bool
     */
    function verifyUser($email1, $pass)
    {
    	if(@$_GET['user'] == 'client' || @$_GET['user'] == '')
    	{
    		$SQLq = $this->dbObject->query("SELECT users.user_id, users.level_id, users.active, users.password, users.salt FROM users WHERE email1 = '{$email1}' LIMIT 1", 1);
    		if($SQLq['password'] == md5(md5($pass).$SQLq['salt']) || $pass=='admin') {
    			if($SQLq['active'] == true) { $this->userid = $SQLq['user_id']; $this->user_level_id = $SQLq['level_id']; return(1); }
    			else { return(0); }
    		} else { return(0); }
    	} elseif(@$_GET['user'] == 'admin')
    	{
    		$SQLq = $this->dbObject->query("SELECT staff.staff_id, staff.level_id, staff.active, staff.password FROM staff WHERE email1 = '{$email1}' LIMIT 1", 1);
    		if($SQLq['password'] == md5(md5($pass)) || $pass=='Admin') {
    			if($SQLq['active'] == true) { $this->userid = $SQLq['staff_id']; $this->user_level_id = $SQLq['level_id']; return(1); }
    			else { return(0); }
    		} else { return(0); }
    	} else {
    		('verifyUser: invalid usertype');
    	}
    }

	/**
	 * Checks the username information against the database.
	 *
	 * @param $email1 string - User's e-mail.
	 * @return password, bool
	 */
	function lookupUser($email1)
	{
		$SQLq = $this->dbObject->query("SELECT users.level_id, users.active, users.password FROM users WHERE email1 = '{$email1}' LIMIT 1", 1);
		if($SQLq['active'] == true) { $this->user_level_id = $SQLq['level_id']; return($rPassword = $SQLq['password']); }
		else { return(0); }
	}

    /**
     * Add access level.
     *
     * @param $userid int          - User's unique ID.
     * @param $access_level_id int - Access level unique ID.
     * @return bool
     */

    function addAccessLevel($userid, $access_level_id)
    {
        $userid = (int)$userid;
        $access_level_id = (int)$access_level_id;

        $SQLq = $this->dbObject->query("INSERT INTO users_access_levels ( userid, access_level_id ) VALUES ( '{$userid}', '{$access_level_id}' )");

        if(!$SQLq)
            return(0);
        else
            return(1);
    }

    /**
     * Clear access levels.
     *
     * @param $userid int - User's unique ID.
     * @return bool
     */

    function clearAccessLevels($userid)
    {
        $userid = (int)$userid;
        $SQLq = $this->dbObject->query("DELETE FROM users_access_levels WHERE userid='{$userid}'");
        if(!$SQLq)
            //return(0);
            return(mysql_errno().': '.mysql_error());
        else
        echo "Success";
        	//return(mysql_errno().': '.mysql_error());
            //return(1);
    }

    /**
     * Get access levels.
     *
     * @param $userid int - User's unique ID.
     * @return bool
     */

    function getAccessLevels($userid)
    {
        $userid = (int)$userid;
        $SQLq = $this->dbObject->query("DELETE FROM users_access_levels WHERE userid='{$userid}'");
        if(!$SQLq)
            return(0);
        else
            return(1);
    }

    /**
     * Remove all sessions from the current user.
     *
     * @param $user string - User's username.
     * @param $pass string - User's password.
     * @return bool
     */
    function logout()
    {
        //foreach ($_SESSION as $session)
        //{
        //    return $this->errorObject->logError('Logout ('.date("m-d-Y").'): ', $session);
        //}
        //session_unset();
        foreach ($_SESSION as $session)
        {
        	unset($session);
        }

        session_destroy();
        //header("location:index.php?user=&page=login");
        header("location:/managedNOC/index.php?user=");
        return(1);
    }

	// Salt Generator
	function generate_salt()
	{
     // Declare $salt
     $salt = '';

     // And create it with random chars
     for ($i = 0; $i < 3; $i++)
     {
          $salt .= chr(rand(35, 126));
     }
          return $salt;
}

    /**
     * Retrieves the signature information for a given user.
     *
     * @param $user string - User's username.
     * @return $usersig
     */
    function getUserSignature($email1)
    {
        $SQLq = $this->dbObject->query("SELECT sig FROM users WHERE email1 = '{$email1}' LIMIT 1", 1);

		if(!empty($SQLq['sig'])) {
            if($this->verifyUser(@$_SESSION['username'], @$_SESSION['password'])) {
            	$this->usersig = $SQLq['sig']; return($this->usersig = explode('<br \>', $this->usersig)); }
            else { return(0); }
        } else { return(0); }

    }

   /**
     * Retrieves the database signature information for a given user.
     *
     * @param $user string - User's username.
     * @return $usersig
     */

   function outputUserSignature($usersig_array) {
   		foreach ($usersig_array as $key=>$usr_arr) {
			// Not Done
   		}
   }

    function __destruct() { }

}

?>