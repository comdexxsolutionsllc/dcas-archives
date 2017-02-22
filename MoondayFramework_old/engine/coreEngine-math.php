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

//*** Starts mathObject class.
class mathObject
{

    
    public function __get($var) {
        print "Attempted to retrieve $var and failed...\n";
    }
    
    public function __call($function, $args) {
        $args = implode(', ', $args);
        print "Call to $function() with args '$args' failed!\n";
    }

    public function tanh($number)
    {
        return tanh((float) $number);
    }
    
    public function tan($number)
    {
        return tan((float) $number);
    }
    
    public function srand($number)
    {
        return srand((int) $number=null);
    }
    
    public function sqrt($number)
    {
        return sqrt((float) $number);
    }
    
    public function sinh($number)
    {
        return sinh((float) $number);
    }
    
    public function sin($number)
    {
        return sin((float) $number);
    }
    
    public function round($number)
    {
        return round((float) $number);
    }
    
    public function rand($min, $max)
    {
        return rand((int) $min, (int) $max);
    }
    
    public function rad2deg($number)
    {
        return rad2deg((float) $number);
    }
    
    public function pow($base, $exponent)
    {
        return pow($base, $exponent);
    }
    
    public function pi()
    {
        return (float) pi();
    }
    
    public function octdec()
    {
        return ;
    }
    
    public function mt_srand()
    {
        return ;
    }
    
    public function mt_rand()
    {
        return ;
    }
    
    public function mt_getrandmax()
    {
        return ;
    }
    
    public function min()
    {
        return ;
    }
    
    public function max()
    {
        return ;
    }
    
    public function log()
    {
        return ;
    }
    
    public function log1p()
    {
        return ;
    }
    
    public function log10()
    {
        return ;
    }
    
    public function lcg_value()
    {
        return ;
    }
    
    public function is_nan()
    {
        return ;
    }
    
    public function is_infinite()
    {
        return ;
    }
    
    public function is_finite()
    {
        return ;
    }
    
    public function hypot()
    {
        return ;
    }
    
    public function hexdec()
    {
        return ;
    }
    
    public function getrandmax()
    {
        return ;
    }
    
    public function fmod()
    {
        return ;
    }
    
    public function floor()
    {
        return ;
    }
    
    public function expm1()
    {
        return ;
    }
    
    public function exp()
    {
        return ;
    }
    
    public function deg2rad()
    {
        return ;
    }
    
    public function decoct()
    {
        return ;
    }
    
    public function dechex()
    {
        return ;
    }
    
    public function decbin()
    {
        return ;
    }
    
    public function cosh()
    {
        return ;
    }
    
    public function cos()
    {
        return ;
    }
    
    public function ceil()
    {
        return ;
    }
    
    public function bindec()
    {
        return ;
    }
    
    public function base_convert()
    {
        return ;
    }
    
    public function atanh()
    {
        return ;
    }
    
    public function atan()
    {
        return ;
    }
    
    public function atan2()
    {
        return ;
    }
    
    public function asinh()
    {
        return ;
    }
    
    public function asin()
    {
        return ;
    }
    
    public function acosh()
    {
        return ;
    }
    
    public function acos()
    {
        return ;
    }
    
    public function abs()
    {
        return ;
    }
    
    
    function __destruct()
    {
        
    }
}
?>