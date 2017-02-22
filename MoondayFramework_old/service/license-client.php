<?php session_start(); error_reporting(E_ALL);

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

#  ******************************************  #
#          Start License Client                #
#  ******************************************  #

// 01. Validate In-Session Variables
// 02. Validate Secure Connection
// 03. Validate NNTP Stable Time-Sync
// 04. Connect to License Server(s) using Local List
// 05. Download new-license-serv.txt List
// 06. Re-Connect to Different License Server(s)
// 07. Validate Time Sync between Current Server and Previous Server
// 08. Send Admin and Client Versions
// 09. If Admin/Client Versions != CURRENT, Recommend Update
// 10. If Admin/Client Versions == CURRENT, continue to next step
// 11. Send License File and Instruct License Server to return bool-VALID
// 12. If TRUE == CONTINUE
// 13. If FALSE == DISPLAY_MESSAGE
// 14. exit;;

class licclient {

    var $rtn_vldtvrs;               // var: return_value:in-session variables
    var $rtn_vldsconn;              // var: return_value:valid secure connection
    var $rtn_vldnntpsts;            // var: return_value:valid nntp stable time sync
    var $rtn_rtncode_c2ls;          // var: return_value:return code connecting to license serv
    var $rtn_rtncode_dllsl;         // var: return_value:return code downloading lic file
    var $rtn_vldpnsts;              // var: return_value:valid prev-new time sync
    var $rtn_acversion;             // var: return_value:admin/client versions
    var $rtn_recmdupdate;           // var: return_value:did we recommend update
    var $rtn_successsndlf;          // var: return_value:successful dl lic file
    var $rtn_successcloseconn;      // var: return_value:successful closed connection
    var $rtn_cleanup;               // var: return_value:successful cleanup
    
    public function __construct()
    {
        $this->validate_vars();
        $this->validate_sconn();
        $this->validate_nntp_stimesync();
        $this->conn2licserv();
        $this->download_licservlist();
        $this->validate_sconn('RECONNECT');
        $this->validate_prevnew_stimesync();
        $this->send_adminclient_version();
        $this->recommend_update();
        $this->send_licfile();
        $this->close_conn();
     // $this->cleanup();
    }
    
    
    private function validate_vars()
    {
        if ( !( isset($_SESSION['CLIENT_ID']) && isset($_SESSION['CLIENT_HASH']) && isset($_SESSION['UTS']) ) )
        {
            return (int) FALSE;
        } elseif ( ( isset($_SESSION['CLIENT_ID']) && isset($_SESSION['CLIENT_HASH']) && isset($_SESSION['UTS']) ) ) {
            return (int) TRUE;
        } else {
            return (int) 2;
        }
    }
    
    
    private function validate_sconn($increment=NULL)
    {
        if ($this->validate_vars() == (int) TRUE)
        {
            if ($increment != 'RECONNECT')
            { echo 'NOT_RECONNECT';
                ob_start();
                phpinfo(INFO_GENERAL);
                $test=strstr(ob_get_contents(),'https');
                ob_end_clean();
                if ($test)
                { echo $test;
                    return (int) TRUE;
                } else {
                    return (int) FALSE;
                }
            } else { echo 'RECONNECT';
                ob_start();
                phpinfo(INFO_GENERAL);
                $test=strstr(ob_get_contents(),'https');
                ob_end_clean();
                if ($test)
                { echo $test;
                    return (int) TRUE;
                } else {
                    return (int) FALSE;
                }
            }
        } else {
            return (int) 2;
        }
    }
    
    
    private function _get_home_time()
    {
        $syscall = passthru('date', $this->rtn_vldnntpsts);
        if ($syscall) { return $this->rtn_vldnntpsts; }
        else { return (int) 2; }
    }
    
    private function _get_remote_time($timeserver='time-C.timefreq.bldrdoc.gov', $socket)
    {
		$fp = fsockopen($timeserver,$socket,$err,$errstr,5);
		      # parameters: server, socket, error code, error text, timeout
		if ($fp) {
		  fputs($fp,"\n");
		  $timevalue = fread($fp,49);
		  fclose($fp); # close the connection
		}
		else {
		  $timevalue = " ";
		}
		
		$ret = array();
		$ret[] = $timevalue;
		$ret[] = $err;     # error code
		$ret[] = $errstr;  # error text
		return($ret);

	//		How to Implement _get_remote_time call
	//		$timeserver = "time-C.timefreq.bldrdoc.gov";
	//		$timercvd = query_time_server($timeserver,13);
	//		if (!$timercvd[1]) { # if no error from query_time_server
	//		  $timevalue = $timercvd[0];
	//		  echo "Time check from time server ",$timeserver," : [<font color=\"red\">",$timevalue,"</font>].<br>\n";
	//		} #if (!$timercvd)
	//		else {
	//		  echo "Unfortunately, the time server $timeserver could not be reached at this time. ";
	//		  echo "$timercvd[1] $timercvd[2].<br>\n";
	//		}
    }
    
    private function validate_nntp_stimesync()
    {
        if ($this->_get_home_time() != $this->_get_remote_time())
        {
            return (int) FALSE;
        } else {
            return (int) TRUE;
        }
    }
    
    
    private function conn2licserv()
    {
       
    }
    
    
    private function download_licservlist()
    {
        
    }
    
    
    private function validate_prevnew_stimesync()
    {
        
    }
    
    
    private function send_adminclient_version()
    {
        
    }
    
    
    private function recommend_update()
    {
        
    }
    
    
    private function send_licfile()
    {
        
    }
    
    
    private function close_conn()
    {
        
    }
    
    
    private function cleanup()
    {
        self::__destruct();
    }
    
}
?>