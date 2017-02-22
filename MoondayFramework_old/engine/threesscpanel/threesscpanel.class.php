<?php
/**
* @package threessCPANEL
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc C-Panel Interface class
* @uses
* @example
* @files
*/
class threessCPANEL
{
    
    var $set_host;
    var $set_user;
    var $set_hash;
    var $set_ssl=1;
    var $set_incFile="/usr/local/cpanel/Cpanel/Accounting.php.inc";
    
    function threessCPANEL($user,$hash,$host="localhost")
    {
        $this->set_user = $user;
        $this->set_host = $host;
        $this->set_hash = $hash;
        
        if (!file_exists($this->set_incFile))
        {
            echo "[$this->set_incFile] Does not exist.";
            exit;
        }
        
        if (!@require($this->set_incFile))
        {
            echo "[$this->set_incFile] Exists but could not be accessed.";
            exit;
        }
        
        $this->version = $this->showVersion();
        $this->accounts = $this->listAccounts();
        $this->packages = $this->listPackages();
        $this->domains = $this->listDomains();
    }
    
    function showVersion()
    {
        return showversion($this->set_host,$this->set_user,$this->set_hash,$this->set_ssl);
    }
    
    function listAccounts($acct="")
    {
        if ($acct != "")
        {
            $accounts = listaccts($this->set_host,$this->set_user,$this->set_hash,$this->set_ssl);
            return $accounts[$acct];
        }
        else return listaccts($this->set_host,$this->set_user,$this->set_hash,$this->set_ssl);
    }
    
    function listDomains()
    {
        $accounts = $this->listAccounts();
        if (count($accounts) > 0)
        {
            foreach($accounts as $acct => $data)
            {
                $domains[] = $data[0];
            }
            
            return $domains;
        }
        else return false;
    }
    
    function listPackages()
    {
        return listpkgs($this->set_host,$this->set_user,$this->set_hash,$this->set_ssl);
    }    

    function createAccount($accountDomain,$accountUser,$accountPassword,$accountPlan)
    {
        return createacct($this->set_host,$this->set_user,$this->set_hash,$this->set_ssl,$accountDomain,$accountUser,$accountPassword,$accountPlan);
    }
    
    function killAccount($accountUser)
    {
        return killacct($this->set_host,$this->set_user,$this->set_hash,$this->set_ssl,$accountUser);
    }
    
    function suspendAccount($accountUser)
    {
        return suspend($this->set_host,$this->set_user,$this->set_hash,$this->set_ssl,$accountUser);
    }
    
    function unsuspendAccount($accountUser)
    {
        return unsuspend($this->set_host,$this->set_user,$this->set_hash,$this->set_ssl,$accountUser);
    }

}
?>