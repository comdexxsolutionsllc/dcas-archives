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

//*** Unlocks include files.
define("IN_ENGINE", true);
#define("DOCROOT", 'C:/wamp/www/projects/STATUS/current/RAAJ022308-01/');
define("DOCROOT", 'C:/xampp/htdocs/MoondayFramework/');
define("ENGINELOC", DOCROOT.'engine/');
define("APPENDDIR", "_append_files/");

//*** Include APPEND files
ini_set('auto_prepend_file', DOCROOT.APPENDDIR.'prepend.inc.php');
ini_set('auto_append_file', DOCROOT.APPENDDIR.'append.inc.php');

//*** Turn ON Profiling::XDebug if XDebug is Loaded
$xd = extension_loaded('xdebug');
if ($xd) {
	xdebug_stop_code_coverage(); // Stop X-Debug Code Coverage
	ini_set('xdebug.collect_vars', 'on');
	ini_set('xdebug.collect_params', '4');
	ini_set('xdebug.dump_globals', 'on');
	ini_set('xdebug.dump.SERVER', 'REQUEST_URI');
	ini_set('xdebug.show_local_vars', 'on');
	ini_set('xdebug.profiler_enable_trigger', '1');
} else {
	// Include CDS::MoondayFramework->Profiling
}


//*** Includes coreEngine Files
require_once "ezc/Base/ezc_bootstrap.php";  // Include EzComponents - see ~/ezComponents.txt
require_once(ENGINELOC."coreEngine-config.php");
require_once(ENGINELOC."coreEngine-database.php");
require_once(ENGINELOC."coreEngine-filesystem.php");
require_once(ENGINELOC."coreEngine-users.php");
require_once(ENGINELOC."coreEngine-errors.php");
require_once(ENGINELOC."coreEngine-strings.php");
require_once(ENGINELOC."coreEngine-serialize.php");
require_once(ENGINELOC."coreEngine-time.php");
require_once(ENGINELOC."coreEngine-tickets.php");
require_once(ENGINELOC."coreEngine-retrievepassword.php");
require_once(ENGINELOC."coreEngine-logging.php");
require_once(ENGINELOC."errorHandler/Error.php");
require_once(ENGINELOC.'rssbuilder/class.RSSBuilder.inc.php');
require('FirePHPCore/fb.php'); // PEAR Include
//require_once(ENGINELOC."FirePHPCore/lib/FirePHPCore/FirePHP.class.php"); // STATIC Include
//require_once(ENGINELOC."FirePHPCore/lib/FirePHPCore/fb.php"); // STATIC Include

require_once(ENGINELOC."coreEngine-exception.php");

/*
require_once(ENGINELOC."abstractdb/abstractdb.class.php");
require_once(ENGINELOC."accesscontrol/accessControl.class.php");
require_once(ENGINELOC."ach/ACH_core.class.php");
require_once(ENGINELOC."ach/ACH.class.php");
require_once(ENGINELOC."aim/AIM.php");
require_once(ENGINELOC."aim_status/aim_status.class.php");
require_once(ENGINELOC."autokeyword/class.autokeyword.php");
require_once(ENGINELOC."autoresponse/autoresponse.class.php");
require_once(ENGINELOC."bargraph/class.bargraph.php");
require_once(ENGINELOC."bbiptocountry/bbIPtoCountry.class.php");
require_once(ENGINELOC."better-array-storage/array_storage.php");
require_once(ENGINELOC."bouncehandler/bounce_driver.class.php");
require_once(ENGINELOC."bst_spell_check/SpellCheck.class.php");
require_once(ENGINELOC."cicqstatus/CICQStatus.php");
require_once(ENGINELOC."class_debug/class_debug.php");
require_once(ENGINELOC."cls_creditcard/cls_CreditCard.php");
require_once(ENGINELOC."clssessionhandler/clsSessionHandler.php");
require_once(ENGINELOC."code_timer/class_code_timer.php");
require_once(ENGINELOC."cpuload/class_CPULoad.php");
require_once(ENGINELOC."crontab/crontab.php");
require_once(ENGINELOC."currencyconverter/currency_converter.inc.php");
require_once(ENGINELOC."cyahoostatus/CYahooStatus.php");
require_once(ENGINELOC."databug/databug.class.php");
require_once(ENGINELOC."dbwebservice/DBWebService.php");
require_once(ENGINELOC."dbwebservice/domain.php");
//require_once(ENGINELOC."dbwebservice/handle_request.php");
require_once(ENGINELOC."domain/domain.class.php");
require_once(ENGINELOC."dunzip2/dUnzip2.inc.php");
require_once(ENGINELOC."dunzip2/dZip.inc.php");
require_once(ENGINELOC."dyn_php/dyn_php.class.php");
require_once(ENGINELOC."easycron/easycron.class.php");
require_once(ENGINELOC."easysms_api/easysms_api.php");
require_once(ENGINELOC."enom/class.EnomInterface.php");
require_once(ENGINELOC."enom/class.EnomService.php");
require_once(ENGINELOC."fpdf/fpdf.php");
require_once(ENGINELOC."gantt/gantt.class.php");
require_once(ENGINELOC."getbrowsertype/GetBrowserType.php");
require_once(ENGINELOC."gzip/gzip.php");
require_once(ENGINELOC."iam_backup/iam_backup.php");
require_once(ENGINELOC."iam_backup/iam_restore.php");
//require_once(ENGINELOC."megaspider/spider.class.php");
require_once(ENGINELOC."mlswap/mlswap.php");
//require_once(ENGINELOC."mobile_func/mobile_func/chkisdn.inc.php");
//require_once(ENGINELOC."ocities/*"); //
require_once(ENGINELOC."password/class.password.php");
//require_once(ENGINELOC."/paypal_ipn/i_paypal.php");
//require_once(ENGINELOC."php_print_lpr/PrintSendLPR.php");
//require_once(ENGINELOC."php_print_lpr/PrintSend.php");
//require_once(ENGINELOC."phpresolver/DNS.php");
//require_once(ENGINELOC."phpresolver/rrcompat.php");
//require_once(ENGINELOC."portscanner/portscanner.php");
//require_once(ENGINELOC."progbar/cprogbar.php");
require_once(ENGINELOC."progbar/ctable.php");
require_once(ENGINELOC."queue_class/class_queue.php");
require_once(ENGINELOC."rssbuilder/class.RSSBuilder.inc.php");
//require_once(ENGINELOC."search"); //
require_once(ENGINELOC."server_status/status.php");
require_once(ENGINELOC."shadow/shadow.class.php");
//require_once(ENGINELOC."simpleforum/SForum_class.php"); //couldn't connect
require_once(ENGINELOC."site_search/class.search.php");
//require_once(ENGINELOC."sqlcache/sqlcache.lib.php");
require_once(ENGINELOC."ssh_in_php/ssh_in_php.php");
//require_once(ENGINELOC."sun_rise_set/include/sun.php");
require_once(ENGINELOC."sun_rise_set/math.php");
require_once(ENGINELOC."swish/swish.php");
require_once(ENGINELOC."threesscpanel/threesscpanel.class.php");
require_once(ENGINELOC."threessftp/threessftp.class.php");
require_once(ENGINELOC."transparentwatermark/transparentWatermark.class.php");
require_once(ENGINELOC."user-quota/class.userquota.php");
require_once(ENGINELOC."vnc_floodrecorder/class.floodrecorder.php");
//require_once(ENGINELOC."weather/rssweather.inc.php");
//require_once(ENGINELOC."zipcodesrange/ZipCodesRange.class.php");
*/



interface coreEngineAbstract
{
	public function init();
	public function terminate();
}


//*** Starts coreEngine class.
//final class coreEngine
class coreEngine implements coreEngineAbstract
{
	var $sRU;

    var $time,
    	$configObject,
        $userObject,
        $dbObject,
        $errorObject,
        $stringObject,
        $fileObject,
        $serializeObject,
        $clientObject,
        $timeObject,
        $ticketObject,
        $retrievePasswordObject,
        $errorHandler,
		$loggingObject,
        $firePHPObject,
        $LinkedExceptionObject,
        $rssBuilderObject;


//	function __autoload($className)
//	{
//		echo 'PHP Version: ' . phpversion() . '</br>';
//	    echo 'Loading class: ' . $classname . '</br>';
//
//		require_once ENGINELOC.'coreEngine-'.$className.'.php';
//	}


    /**
     * Initliazes the coreEngine components.
     *
     * @return bool
     */
    public function init()
    {
    	#xdebug_start_trace('c:/xampp/tmp/managedNOC.xt.htm', XDEBUG_TRACE_HTML);

		$this->sRU = explode('/', $_SERVER['REQUEST_URI']);
    	$this->sRU = '/'.$this->sRU['1'].'/';
    	$this->time = microtime(true);
    	$this->configObject    = new configObject();
        $this->userObject      = new userObject();
        $this->dbObject        = new dbObject();
        $this->errorObject     = new errorObject();
        $this->stringObject    = new stringObject();
        $this->fileObject      = new fileObject();
        $this->serializeObject = new serializeObject();
        $this->clientObject    = new userObject(); // ?
        $this->timeObject      = new timeObject();
        $this->ticketObject    = new ticketObject();
    	$this->retrievePasswordObject = new retrievePasswordObject();
    	$this->loggingObject   = new loggingObject();
    	$this->errorHandler    = new Inter_Error();
    	$this->rssBuilderObject = new rssBaseObject();
        $this->firePHPObject   = new FirePHP();

        $this->LinkedExceptionObject = new LinkedExceptionObject();
        //$this->clientObject  = new clientObject();
        //$this->billingObject = new billingObject();
        /*$this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();
        $this->fileObject    = new fileObject();*/

        $this->fileObject->errorObject  = $this->errorObject;
        $this->fileObject->stringObject = $this->stringObject;

        $this->userObject->dbObject      = $this->dbObject;
        $this->userObject->errorObject   = $this->errorObject;

        $this->dbObject->errorObject     = $this->errorObject;
        $this->dbObject->configObject    = $this->configObject;

    	$this->loggingObject->dbObject     = $this->dbObject;
    	$this->loggingObject->fileObject   = $this->fileObject;
    	$this->loggingObject->userObject   = $this->userObject;
    	$this->loggingObject->errorObject  = $this->errorObject;
    	$this->loggingObject->stringObject = $this->stringObject;

    	$this->ticketObject->dbObject      = $this->dbObject;


        //$this->clientObject->dbObject   = $this->dbObject;
        //$this->clientObject->errorObject    = $this->errorObject;
        //$this->clientObject->stringObject   = $this->stringObject;

        //$this->billingObject->dbObject   = $this->dbObject;
        //$this->billingObject->errorObject    = $this->errorObject;
        //$this->billingObject->stringObject   = $this->stringObject;
/*
        $this->babesObject->dbObject     = $this->dbObject;
        $this->babesObject->stringObject = $this->stringObject;
        $this->babesObject->fileObject     = $this->fileObject;

        $this->gamesObject->dbObject       = $this->dbObject;
        $this->gamesObject->stringObject   = $this->stringObject;
        $this->gamesObject->fileObject     = $this->fileObject;

        $this->carsObject->dbObject       = $this->dbObject;
        $this->carsObject->stringObject   = $this->stringObject;
        $this->carsObject->fileObject     = $this->fileObject;

        $this->musicObject->dbObject       = $this->dbObject;
        $this->musicObject->stringObject   = $this->stringObject;
        $this->musicObject->fileObject     = $this->fileObject;

        $this->moviesObject->dbObject       = $this->dbObject;
        $this->moviesObject->stringObject   = $this->stringObject;
        $this->moviesObject->fileObject     = $this->fileObject;

        $this->dvdObject->dbObject       = $this->dbObject;
        $this->dvdObject->stringObject   = $this->stringObject;
        $this->dvdObject->fileObject     = $this->fileObject;

        $this->rolesObject->dbObject       = $this->dbObject;
        $this->rolesObject->stringObject   = $this->stringObject;
        $this->rolesObject->fileObject     = $this->fileObject;

		$this->personalitiesObject->dbObject       = $this->dbObject;
        $this->personalitiesObject->stringObject   = $this->stringObject;
        $this->personalitiesObject->fileObject     = $this->fileObject;
*/

    	/* Set errorHandler Object */
    	set_exception_handler(array('Inter_Error', 'exception_handler'));
    	set_error_handler(array('Inter_Error', 'error_handler'), E_ALL);

		if(version_compare(PHP_VERSION, '5.2', '>=')){
			register_shutdown_function(array('Inter_Error', 'detect_fatal_error'));
		}
    	// End: errorHandler declaration

        return true;
    }


    public function terminate()
    {
		echo "<p>Time elapsed: ",microtime(true) - $this->time, " seconds";
    	#xdebug_stop_trace();
    	#echo "<br \><br \><a href='file:///C:/xampp/tmp/managedNOC.xt.xt.htm' target='_blank'>managedNOC.xt.xt Trace</a>";
    	return;
    }
}

?>
