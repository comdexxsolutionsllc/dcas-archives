<?php

/**
* @package shadow
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc manage linux user and group accounts on shadow-based systems
* @uses
* @example
* @files
*/

class shadow {


  // This is the structure of the files, which we use :
  // /etc/passwd ->        Username:x:UID:GID:GCOS:Home:Shell
  // /etc/shadow ->        Username:Password:DOC:MindD:MaxD:Warn:Exp:Dis:Res
  // /etc/group  ->        Groupname:Password:GID:Member
  // /etc/gshadow->        Groupname:Password:Groupmanager:Member

  // To prevent, that two jobs are using the user and Group Files we
  // create a simple lock file, and if it the file exists at startup
  // we do nothing.

  // All functions in this class return TRUE on success and FALSE on error,
  // so you can easily catch all errors. All errors of this function are
  // stored in the variable $ERROR_MSG. You can then read it and provide
  // a custom error message.

  // You can use the following functions in your applications :
  // int user_add (username,userid,primary_group,name,shell,homedir,password);
  // int user_del (username);
  // int user_mod (username,new_name,new_shell,new_password);
  // int group_add (groupname,member,password,manager);
  // int group_del (groupname);
  // int group_mod(groupname,new_name);
  // int add_to_group(groupname,username);
  // int del_from_group(groupname,username);
  // int del_from_all_groups(username);

  // There are 2 more functions, which provide some simple constructor and
  // destructor functions for the class. So you had to call the constructor
  // first, then use the functions and then call the destructor to write all
  // data back into the files and remove the lock file.

  // int shadow(passwd_path,shadow_path,group_path,gshadow_path,enable_logging);      ->         The pseudo constructor
  // int stop_shadow();                     ->         The pseudo destructor

  // If you like, you can activate the logging into your syslog, so all actions
  // somebody makes, will be reported to it. To do this call the pseudo constructor
  // with a 1 as first parameter.

  // We use the following arrays to manage the user and group Accounts in memory
  // $user["username"] = Username;
  // $user["password"] = Password;
  // $user["uid"] = UserID;
  // $user["gid"] = GroupID;
  // $user["gcos"] = Real Name;
  // $user["home"] = Homedir;
  // $user["shell"] = Shell;
  // $user["doc"] = Date of last password change in days from the 1.1.1970
  // $user["mind"] = Minimal days the password is valid
  // $user["maxd"] = Maximum days the password is valid
  // $user["warn"] = Number of days before the user recives a message that he should change his password
  // $user["exp"] = After maxd, how many days is the password still valid
  // $user["dis"] = Up to this day (counted from 1.1.1970) the account is locked

  // $group["groupname"] = Groupname;
  // $group["password"] = Password;
  // $group["gid"] = GroupID;
  // $group["member"] = Comma seperated list of members;
  // $group["manager"] = Comma seperated list of group managers;

  // $homed["dir"] = Homedirectory;
  // $homed["user"] = User which this directory belongs to;
  // $homed["group"] = The group which this directory belongs to;
  // All homedirectorys are chmoded 755;

  VAR $ERROR_MSG;
  VAR $LOGGING;          //    Tells us if syslog logging is enabled or not
  VAR $STARTED;          //    Keeps track if the constructor was called
  VAR $USERDATA;         //    Here are all arrays of the type $user are stored in
  VAR $GROUPDATA;        //    Here are all arrays of the type $group are stored in
  VAR $FASTSEEK;         //    Little Array which contains number to name assignments for usernames
  VAR $GFASTSEEK;        //    Little Array which contains number to name assignments for groupnames
  VAR $HOMEDIRS;         //    The homedirectorys which have to be created;
  VAR $STARTUID;         //    The first UserID a user can have
  VAR $STARTGID;         //    The first GroupID a group can have
  VAR $SHADOWFILE;	//    The location of the shadow file
  VAR $PASSWDFILE;	//    The location of the passwd file
  VAR $GROUPFILE;	//    The location of the group file
  VAR $GSHADOWFILE;	//    The location of the gshadow file
  VAR $LOCKFILE;		//    The name of the lock file

  function shadow($passwd = "/etc/passwd", $shadow = "/etc/shadow", $groupf = "/etc/group", $gshadow = "/etc/gshadow", $enable_logging = 0)
  {
   // Set logging state
   $this->LOGGING = $enable_logging;

   // Set the minimum UserID
   $this->STARTUID = 100;

   // Set the minimum GroupID
   $this->STARTGID = 100;

   // Set the passwd file
   $this->PASSWDFILE = $passwd;

   // Set the shadow file
   $this->SHADOWFILE = $shadow;

   // Set the group file
   $this->GROUPFILE = $groupf;

   // Set the gshadow file
   $this->GSHADOWFILE = $gshadow;

   // Set the lockfile name
   $this->LOCKFILE = "C:\\temp\\shadow.lock";

   // Initalize an array
   $this->HOMEDIRS = array();

   // Check if a log file exists, if not create one
   if (file_exists($this->LOCKFILE))
   {
     $this->ERROR_MSG = "Lockfile exists";
     $this->STARTED = 0;
     if ($this->LOGGING == 1)
     {
      syslog(LOG_NOTICE,"Could not start shadow class. Lockfile exists.");
     }
     return FALSE;
   }
   else
   {
     $fp = fopen($this->LOCKFILE,"w");
     fputs($fp," ");
     fclose($fp);
   }

   // Read the shadow user file into the array
   $sp = fopen($this->SHADOWFILE,"r");
   $i = 0;

   while(!feof($sp))
   {
    $temp = fgets($sp,8069);
    $temp = rtrim(ereg_replace("\n"," ",$temp));
    $temp = explode(":",$temp);
    $user["username"] = $temp[0];
    $user["password"] = $temp[1];
    $user["doc"] = $temp[2];
    $user["mind"] = $temp[3];
    $user["maxd"] = $temp[4];
    $user["warn"] = $temp[5];
    $user["exp"] = $temp[6];
    $user["dis"] = $temp[7];
    $temp = $user["username"];

    $this->USERDATA[$i] = $user;
    $this->FASTSEEK[$temp] = $i;
    $i++;
   }

   fclose($sp);

   $pp = fopen($this->PASSWDFILE,"r");
   while(!feof($pp))
   {
    $temp = fgets($pp,8096);
    $temp = rtrim(ereg_replace("\n"," ",$temp));
    $temp = explode(":",$temp);
    $username = $temp[0];
    $i = -1;
    $i = $this->FASTSEEK[$username];

    if ( $i != -1 )
    {
     $this->USERDATA[$i]["uid"] = $temp[2];
     $this->USERDATA[$i]["gid"] = $temp[3];
     $this->USERDATA[$i]["gcos"] = $temp[4];
     $this->USERDATA[$i]["home"] = $temp[5];
     $this->USERDATA[$i]["shell"] = $temp[6];
    }
   }

  fclose($pp);

  // Now we read all groups into another array

  $gp = fopen($this->GROUPFILE,"r");
  $i = 0;
  while(!feof($gp))
  {
   $temp = fgets($gp,8096);
   $temp = rtrim(ereg_replace("\n"," ",$temp));
   $temp = explode(":",$temp);

   $group["groupname"] = $temp[0];
   $group["gid"] = $temp[2];
   $group["member"] = $temp[3];
   $temp = $temp[0];

   $this->GROUPDATA[$i] = $group;
   $this->GFASTSEEK[$temp] = $i;
   $i++;
  }

  fclose($gp);

  $gs = fopen($this->GSHADOWFILE,"r");
  $i = -1;
  while(!feof($gs))
  {
   $temp = fgets($gs,8096);
   $temp = rtrim(ereg_replace("\n"," ",$temp));
   $temp = explode(":",$temp);
   $groupname = $temp[0];
   $i = $this->GFASTSEEK[$groupname];

   if ( $i != -1 )
   {
    $this->GROUPDATA[$i]["password"] = $temp[1];
    $this->GROUPDATA[$i]["manager"] = $temp[2];
   }
  }
  fclose($gs);

  if ($this->LOGGING == 1)
  {
    syslog(LOG_NOTICE,"Shadow Class initalized.");
  }

  return TRUE;
  //      End of pseudo constructor
  }

  function stop_shadow()
  {
    // To avoide damages to production files, we make backup copies
    // of the original files. We delete them at the next run.

    if(file_exists($this->PASSWDFILE."-backup"))
    {
      unlink($this->PASSWDFILE."-backup");
    }
    copy($this->PASSWDFILE,$this->PASSWDFILE."-backup");
    if(file_exists($this->SHADOWFILE."-backup"))
    {
      unlink($this->SHADOWFILE."-backup");
    }
    copy($this->SHADOWFILE,$this->SHADOWFILE."-backup");
    if(file_exists($this->GROUPFILE."-backup"))
    {
      unlink($this->GROUPFILE."-backup");
    }
    copy($this->GROUPFILE,$this->GROUPFILE."-backup");
    if(file_exists($this->GSHADOWFILE."-backup"))
    {
      unlink($this->GSHADOWFILE."-backup");
    }
    copy($this->GSHADOWFILE,$this->GSHADOWFILE."-backup");

    if ($this->LOGGING == 1)
    {
      syslog(LOG_NOTICE,"Backup files created");
    }

    // Write back all user informations into the correct files;

    $pf = fopen($this->PASSWDFILE,"w");
    $sf = fopen($this->SHADOWFILE,"w");
    for ( $i = 0 ; $i < count($this->USERDATA) ; $i++ )
    {
      if ($this->USERDATA[$i]["username"] != "")
      {
       if ($i == count($this->USERDATA)-1 )
       {
         $passwd = $this->USERDATA[$i]["username"].":x:".$this->USERDATA[$i]["uid"].":".$this->USERDATA[$i]["gid"].":".$this->USERDATA[$i]["gcos"].":".$this->USERDATA[$i]["home"].":".$this->USERDATA[$i]["shell"];
         $shadow = $this->USERDATA[$i]["username"].":".$this->USERDATA[$i]["password"].":".$this->USERDATA[$i]["doc"].":".$this->USERDATA[$i]["mind"].":".$this->USERDATA[$i]["maxd"].":".$this->USERDATA[$i]["warn"].":".$this->USERDATA[$i]["exp"].":".$this->USERDATA[$i]["dis"].":";
       }
       else
       {
         $passwd = $this->USERDATA[$i]["username"].":x:".$this->USERDATA[$i]["uid"].":".$this->USERDATA[$i]["gid"].":".$this->USERDATA[$i]["gcos"].":".$this->USERDATA[$i]["home"].":".$this->USERDATA[$i]["shell"]."\n";
         $shadow = $this->USERDATA[$i]["username"].":".$this->USERDATA[$i]["password"].":".$this->USERDATA[$i]["doc"].":".$this->USERDATA[$i]["mind"].":".$this->USERDATA[$i]["maxd"].":".$this->USERDATA[$i]["warn"].":".$this->USERDATA[$i]["exp"].":".$this->USERDATA[$i]["dis"].":\n";
       }
       fputs($pf,$passwd);
       fputs($sf,$shadow);
      }
    }
    fclose($pf);
    fclose($sf);

    // Write all group informations into the correct files;

    $gf = fopen($this->GROUPFILE,"w");
    $sg = fopen($this->GSHADOWFILE,"w");
    for ( $i = 0 ; $i < count ($this->GROUPDATA) ; $i++ )
    {
      if ($this->GROUPDATA[$i]["groupname"] != "")
      {
       if ($i == count($this->GROUPDATA)-1 )
       {
         $group = $this->GROUPDATA[$i]["groupname"].":x:".$this->GROUPDATA[$i]["gid"].":".$this->GROUPDATA[$i]["member"];
         $gshadow = $this->GROUPDATA[$i]["groupname"].":".$this->GROUPDATA[$i]["password"].":".$this->GROUPDATA[$i]["manager"].":".$this->GROUPDATA[$i]["member"];
       }
       else
       {
         $group = $this->GROUPDATA[$i]["groupname"].":x:".$this->GROUPDATA[$i]["gid"].":".$this->GROUPDATA[$i]["member"]."\n";
         $gshadow = $this->GROUPDATA[$i]["groupname"].":".$this->GROUPDATA[$i]["password"].":".$this->GROUPDATA[$i]["manager"].":".$this->GROUPDATA[$i]["member"]."\n";
       }
       fputs($gf,$group);
       fputs($sg,$gshadow);
      }
    }
    fclose($gf);
    fclose($sg);

    if ($this->LOGGING == 1)
    {
      syslog(LOG_NOTICE,"User and Group Database generated");
    }

    // Create or delete homedirectorys and set permissions;

    for ( $i = 0 ; $i < count($this->HOMEDIRS) ; $i++ )
    {
      if ($this->HOMEDIRS[$i]["action"] == "create")
      {
       mkdir($this->HOMEDIRS[$i]["dir"],0755);
       chown($this->HOMEDIRS[$i]["dir"],$this->HOMEDIRS[$i]["user"]);
       chgrp($this->HOMEDIRS[$i]["dir"],$this->HOMEDIRS[$i]["group"]);
       if ($this->LOGGING == 1)
       {
        syslog(LOG_NOTICE,"User : ".$this->HOMEDIRS[$i]["user"]." created");
       }
      }
      else
      {
       $cmd = "/bin/rm -R ".$this->HOMEDIRS[$i]["dir"];
       $res = exec($cmd);
       if ($this->LOGGING == 1)
       {
        syslog(LOG_NOTICE,"User : ".$this->HOMEDIRS[$i]["user"]." deleted");
       }
      }
    }

    if ($this->LOGGING == 1)
    {
      syslog(LOG_NOTICE,"Homedirectorys created and deleted");
    }

    unlink($this->LOCKFILE);

    if ($this->LOGGING == 1)
    {
      syslog(LOG_NOTICE,"Shadow class ended");
    }

  RETURN TRUE;
  // End of pseudo destructor
  }

  function user_add($username,$uid,$group,$gcos,$shell,$home,$password)
  {
   if ($username == "")
   {
     $this->ERROR_MSG = "NO Username specified";
     RETURN FALSE;
   }

   if ($uid < 0 || $uid > 64999)
   {
     $this->ERROR_MSG = "Incorrect UserID";
     RETURN FALSE;
   }

   if ($home == "")
   {
     $this->ERROR_MSG = "Please provide a home directory !";
     RETURN FALSE;
   }

   for ( $i = 0 ; $i < count($this->USERDATA) ; $i++ )
   {
     if ( $this->USERDATA[$i]["uid"] == $uid )
     {
       $this->ERROR_MSG = "Userid already exists";
       RETURN FALSE;
     }
   }

   for ( $i = 0 ; $i < count($this->USERDATA) ; $i++ )
   {
     if ( $this->USERDATA[$i]["username"] == $username )
     {
       $this->ERROR_MSG = "Username already exists";
       RETURN FALSE;
     }
   }

   $i = count($this->USERDATA);
   $this->USERDATA[$i]["username"] = $username;
   $this->USERDATA[$i]["password"] = crypt($password);
   $this->USERDATA[$i]["uid"] = $uid;
   $this->USERDATA[$i]["gid"] = $this->group_to_gid($group);
   $this->USERDATA[$i]["gcos"] = $gcos;
   $this->USERDATA[$i]["home"] = $home;
   $this->USERDATA[$i]["shell"] = $shell;
   $doc = time() / 86400;
   $doc = explode(".",$doc);
   $this->USERDATA[$i]["doc"] = $doc[0];
   $this->USERDATA[$i]["mind"] = "";
   $this->USERDATA[$i]["maxd"] = "";
   $this->USERDATA[$i]["warn"] = "";
   $this->USERDATA[$i]["exp"] = "";
   $this->USERDATA[$i]["dis"] = "";

   $i = count($this->HOMEDIRS);
   $this->HOMEDIRS[$i]["action"] = "create";
   $this->HOMEDIRS[$i]["dir"] = $home;
   $this->HOMEDIRS[$i]["user"] = $username;
   $this->HOMEDIRS[$i]["group"] = $group;

   $this->FASTSEEK[$username] = $i;

   if (!$this->add_to_group($group,$username))
   {
      $this->ERROR_MSG = "Could not add user ".$username." to group ".$group;
      unset($this->USERDATA[count($this->USERDATA)]);
      RETURN FALSE;
   }

   RETURN TRUE;
   // End of user_add
  }

  function user_del($username)
  {
    if ( $username == "" )
    {
      $this->ERROR_MSG = "No Username specified !";
      RETURN FALSE;
    }

    for ( $i = 0 ; $i < count($this->USERDATA) ; $i++ )
    {
      if ( $this->USERDATA[$i]["username"] == $username )
      break;
    }

    $this->del_from_all_groups($username);
    $j = count($this->HOMEDIRS);
    $this->HOMEDIRS[$j]["action"] = "delete";
    $this->HOMEDIRS[$j]["dir"] = $this->USERDATA[$i]["home"];
    $this->HOMEDIRS[$j]["user"] = $username;
    unset($this->USERDATA[$i]);
    RETURN TRUE;
    // End of user_del

    unset($this->FASTSEEK[$username]);
  }

  function user_mod($username,$new_gcos,$new_shell,$new_password)
  {
    if ( $username == "" )
    {
      $this->ERROR_MSG = "No Username specified !";
      RETURN FALSE;
    }
    else
    {
      for ( $i = 0 ; $i < count($this->USERDATA) ; $i++ )
      {
        if ( $this->USERDATA[$i]["username"] == $username )
          break;
      }

      if ( $new_gcos != "" )
      {
        $this->USERDATA[$i]["gcos"] = $new_gcos;
      }

      if ( $new_shell != "" )
      {
        $this->USERDATA[$i]["shell"] = $new_shell;
      }

      if ( $new_password != "" )
      {
        $this->USERDATA[$i]["password"] = crypt($new_password);
      }
    }

    RETURN TRUE;
    // End of user_mod
  }

  function group_add($groupname,$member = "",$password = "",$manager = "")
  {
    if ($groupname == "")
    {
      $this->ERROR_MSG = "No groupname specified";
      RETURN FALSE;
    }

    $i = count($this->GROUPDATA);

    $this->GROUPDATA[$i]["groupname"] = $groupname;
    if ($password != "")
    {
      $this->GROUPDATA[$i]["password"] = crypt($password);
    }
    else
    {
      $this->GROUPDATA[$i]["password"] = "";
    }
    $this->GROUPDATA[$i]["gid"] = $this->get_next_gid();
    $this->GROUPDATA[$i]["member"] = $member;
    $this->GROUPDATA[$i]["manager"] = $manager;

    $this->GFASTSEEK[$groupname] = $i;
    RETURN TRUE;
  }

  function group_del($groupname)
  {
    $i = $this->GFASTSEEK[$groupname];
    unset($this->GROUPDATA[$i]);
    unset($this->GFASTSEEK[$groupname]);
    RETURN TRUE;
  }

  function group_mod($groupname,$new_name)
  {
   if ($groupname == "")
   {
     $this->ERROR_MSG = "No Groupname specified";
     RETURN FALSE;
   }

   if ($new_name == "")
   {
     $this->ERROR_MSG = "No new Groupname specified";
     RETURN FALSE;
   }

   $i = $this->GFASTSEEK[$groupname];
   if (!isset($i))
   {
     $this->ERROR_MSG = "Group does not exist";
     return FALSE;
   }

   $this->GROUPDATA[$i]["groupname"] = $new_name;
   RETURN TRUE;
  }

  function add_to_group($groupname,$user)
  {
    $new_member = "";

    $i = $this->GFASTSEEK[$groupname];
    if (!isset($i))
    {
      $this->ERROR_MSG = "Group does not exist";
      return FALSE;
    }

    $member = $this->GROUPDATA[$i]["member"];
    $member = explode(",",$member);
    $memcount = count($member);
    $member[$memcount] = $user;

    for ( $j = 0; $j <= $memcount; $j++ )
    {
      if ( $j == 0 || $new_member == "")
      {
        $new_member = $member[$j];
      }
      else
      {
        $new_member = $new_member.",".$member[$j];
      }
      echo $j."=>".$new_member."<br>\n";
    }

    $this->GROUPDATA[$i]["member"] = $new_member;

    RETURN TRUE;
  }

  function del_from_group($groupname,$user)
  {
    $i = $this->GFASTSEEK[$groupname];
    if (!isset($i))
    {
      $this->ERROR_MSG = "Group does not exist";
      return FALSE;
    }

    $member = $this->GROUPDATA[$i]["member"];
    $member = explode(",",$member);
    $memcount = count($member);

    for ( $j = 0; $j < $memcount; $j++)
    {
      if ($member[$j] != $user)
      {
        if ( $j == 0 )
        {
          $new_member = $member[$j];
        }
        else
        {
          $new_member = $new_member.",".$member[$j];
        }
      }
    }

    $this->GROUPDATA[$i]["member"] = $new_member;

    RETURN TRUE;
  }

  function del_from_all_groups($user)
  {
    for ($i = 0; $i < count($this->GROUPDATA); $i++)
    {
      $this->del_from_group($this->GROUPDATA[$i]["groupname"],$user);
    }

    RETURN TRUE;
  }

  function get_next_uid()
  {
    $uid = $this->STARTUID;

    do {
      $used = 0;
      for ( $i = 0; $i < count($this->USERDATA); $i++ )
      {
        if ( $uid == $this->USERDATA[$i]["uid"] )
        {
          $used = 1;
          $uid++;
          break;
        }
      }
    } while($used == 1 && $uid <= 64999);

    if ( $uid <= 64999 )
    {
      return $uid;
    }
    else
    {
      $this->ERROR_MSG = "UserID greater than 65000";
      return FALSE;
    }
  }

  function get_next_gid()
  {
    $gid = $this->STARTGID;

    do {
      $used = 0;
      for ( $i = 0; $i < count($this->GROUPDATA); $i++ )
      {
        if ( $gid == $this->GROUPDATA[$i]["gid"] && $gid <= 64999)
        {
          $used = 1;
          $gid++;
          break;
        }
      }
    } while($used == 1 && $gid <= 64999);

    if ( $gid <= 64999 )
    {
      return $gid;
    }
    else
    {
      $this->ERROR_MSG = "GroupID greater than 65000";
      return FALSE;
    }
  }

  function uid_to_user($uid)
  {
    for ( $i = 0; $i < count($this->USERDATA); $i++ )
    {
      if ( $uid == $this->USERDATA[$i]["uid"] )
      {
        return $this->USERDATA[$i]["username"];
      }
    }
  }

  function gid_to_group($gid)
  {
    for ( $i = 0; $i < count($this->GROUPDATA); $i++ )
    {
      if ( $gid == $this->GROUPDATA[$i]["gid"] )
      {
        return $this->GROUPDATA[$i]["groupname"];
      }
    }
  }

  function group_to_gid($group)
  {
    for ( $i = 0; $i < count($this->GROUPDATA); $i++ )
    {
      if ( $group == $this->GROUPDATA[$i]["groupname"] )
      {
        return $this->GROUPDATA[$i]["gid"];
      }
    }
  }

  function user_to_uid($user)
  {
    for ( $i = 0; $i < count($this->USERDATA); $i++ )
    {
      if ( $user == $this->USERDATA[$i]["username"] )
      {
        return $this->USERDATA[$i]["uid"];
      }
    }
  }

  function show_all()
  {
    for ( $i = 0; $i < count($this->USERDATA); $i++)
    {
     while (list($key, $val) = each($this->USERDATA[$i]))
     {
       echo "$key => $val\n";
     }
    }
    for ( $i = 0; $i < count($this->GROUPDATA); $i++)
    {
     while (list($key, $val) = each($this->GROUPDATA[$i]))
     {
       echo "$key => $val\n";
     }
    }
  }

// End of class
}
?>