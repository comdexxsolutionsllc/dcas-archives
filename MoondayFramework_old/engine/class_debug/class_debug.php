<?php

/**
* @package DEBUG
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc Debugger Class
* @uses
* @example
* ERROR REFERENCE
*     1 E_ERROR
*     2 E_WARNING
*     4 E_PARSE
*     8 E_NOTICE
*     16 E_CORE_ERROR
*     32 E_CORE_WARNING
*     64 E_COMPILE_ERROR
*     128 E_COMPILE_WARNING
*     256 E_USER_ERROR
*     512 E_USER_WARNING
*     1024 E_USER_NOTICE
* @files
*/


// Define DEBUG option
define("DEBUG_TEXT" , 1);       // plain text output
define("DEBUG_HTML" , 2);       // html output with NL converted to <BR>
define("DEBUG_JS" , 4);         // javascript output
define("DEBUG_FILE" , 8);       // log file output

class DEBUG
{
    var $level=0;          // default debug-level
    var $output=0;         // debug output type
    var $logfile="debug.log"; // default log file
    var $oldhandler="";      // existing error handler
    var $mode=TRUE;              // debug mode on or off

    var $format;            // printf format to be used on message
    var $style="";           // HTML OUTPUT STYLE
    var $prefix="*****\n\t";       // text prefix
    var $postfix="\n*****\n";    // post fix

    function DEBUG( $debug_level=0,  $output=DEBUG_HTML)
    {   $this->SetLevel($debug_level);
        $this->SetOutput($output);
    }

    function SetLevel($debug_level)
    {   $this->level = $debug_level;
    }

    function SetOutput($output)
    {   $this->output = $output;
    }

    function SetLogFile($filename)
    {   $this->logfile = "debug.log";
    }

    function SetHTML($style)
    {   $this->style= $style;
    }

    function SetText($prefix, $postfix)
    {   $this->prefix= $prefix;
        $this->postfix= $postfix;
    }

    function SetDebugOn( $mode)
    {   $this->mode=$mode;
    }
    
    function SetFormat($format)
    {   $this->format = $format;
    }

    function ErrorHandler($errno, $errstr, $errfile, $errline)
    {   $msg = "FILE: ".basename($errfile)." LINE: $errline MSG: [$errstr]";
        // determine debug level:
        //      *ERROR: level 1
        //      *WARNING: level 2
        //      *NOTICE:  level 3
        switch($errno)
        {
            case E_ERROR: $level=1; break;
            case E_WARNING: $level=2; break;
            case E_NOTICE: $level=3; break;
            case E_CORE_ERROR: $level=1; break;
            case E_CORE_WARNING: $level=2; break;
            case E_COMPILE_ERROR: $level=1; break;
            case E_COMPILE_WARNING: $level=2; break;
            case E_USER_ERROR: $level=1; break;
            case E_USER_WARNING: $level=2; break;
            case E_USER_NOTICE: $level=3; break;
        }
        $this->Output($msg, $level);
    }

    function Output($msg, $level=0)
    {   // check debug mode
        if ( ! $this->mode )
            return;
        // output only if the msg level is greater or equal than debug level
        if ($level > $this->level)
            return;
        // Check format
        if ($this->format)
            $msg = sprintf($this->format, $msg);
        // Text format
        if ( $this->output & DEBUG_TEXT)
        {   echo $this->prefix."$msg".$this->postfix;
        }
        // HTML format
        if ( $this->output & DEBUG_HTML)
        {   $out = nl2br($msg);
            echo ( $this->style ?
                   sprintf($this->style,$out):
                   $out);
        }
        // Javascript format
        if ( $this->output &  DEBUG_JS)
        {   $out = addcslashes($msg, "/'");
            echo "<script>alert('$out');</script>";
        }
        // Log file
        if ( $this->output &  DEBUG_FILE)
        {   // logfile name
            $logfile = $this->logfile;
            // check log file status
            if ( file_exists($logfile) && ! is_writable($logfile) )
            {   echo "DEBUG: FILE $logfile IS NOT WRITABLE";
            }
            // attempt to open file
            $fp = fopen($this->logfile, "a");
            if ( ! $fp )
            {   echo "DEBUG: Cannot create logfile $logfile";
            }
            // Write message
            $out=strftime("%d %b %y %H:%m")." [$level] $msg\n";
            fwrite($fp, $out);
            // close file
            fclose($fp);
        }
    } // end function DEBUG

} // END CLASS DEBUG

?>

