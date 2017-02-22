<?php 
/**
* @package sun
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc class to calculate sunrise/sunset
* @uses
* @example
* @files
*/
require_once("math.php");


/* 
the algorithm used is at http://williams.best.vwh.net/sunrise_sunset_algorithm.htm 
note that the algorithm is not mine, it's just something i found on the net.
*/

class sun {

	function rise($date,$timezone,$latitude,$longitude,$zenith) {
		//1. calculate day of year
		$n=(int)date("z",$date);
		
		//2. convert longitude to hour value and calculate an approximate time
		$lnghour=$longitude/15;
		$t=$n+((6-$lnghour)/24);
		
		//3. calculate the sun's mean anomaly
		$m=(0.9856*$t)-3.289;
		
		//4. calculate the sun's true longitude
		$l=$m+(1.916*sind($m))+(0.020*sind(2*$m))+282.634;
		$l=fmod($l,360);
		
		//5a. calculate the sun's right ascension
		$ra=atand(0.91764*tand($l));
		$ra=fmod($ra,360);
		
		//5b. right ascension needs to be in the same quadrant as $l (sun's true longitude)
		$lquadrant=floor($l/90)*90;
		$raquadrant=floor($ra/90)*90;
		$ra=$ra+($lquadrant-$raquadrant);
		unset($lquadrant); //temporary variable, not needed anymore
		unset($raquadrant); //temporary variable, not needed anymore
		
		//5c. right ascension value needs to be converted into hours
		$ra=$ra/15;
		
		//6. calculate sun's declination
		$sindec=0.39782 * sind($l);
		$cosdec=cosd(asind($sindec));
		
		//7a. calculate the sun's local hour angle
		$cosh=(cosd($zenith)-($sindec*sind($latitude))) / ($cosdec*cosd($latitude));
		if ($cosh>1) {
			return NULL; //sun does not rise at this location on the specified date
		}
		
		//7b. finish calculating H and convert into hours
		$h=360-acosd($cosh);
		$h=$h/15;
		
		//8. calculate local mean time of rising
		$t=$h+$ra-(0.06571*$t)-6.622;
		
		//9. adjust back to UTC
		$ut=$t-$lnghour;
		$ut=fmod($ut,24);
		
		//10. convert UTC to local time zone of latitude/longitude
		$localt=$ut+$timezone;
		
		//calculation finished, return result as a unix date
		return $date+$localt*60*60;
	}
	
	function set($date,$timezone,$latitude,$longitude,$zenith) {
		//1. calculate day of year
		$n=(int)date("z",$date);
		
		//2. convert longitude to hour value and calculate an approximate time
		$lnghour=$longitude/15;
		$t=$n+((18-$lnghour)/24);
		
		//3. calculate the sun's mean anomaly
		$m=(0.9856*$t)-3.289;
		
		//4. calculate the sun's true longitude
		$l=$m+(1.916*sind($m))+(0.020*sind(2*$m))+282.634;
		$l=fmod($l,360);
		
		//5a. calculate the sun's right ascension
		$ra=atand(0.91764*tand($l));
		$ra=fmod($ra,360);
		
		//5b. right ascension needs to be in the same quadrant as $l (sun's true longitude)
		$lquadrant=floor($l/90)*90;
		$raquadrant=floor($ra/90)*90;
		$ra=$ra+($lquadrant-$raquadrant);
		unset($lquadrant); //temporary variable, not needed anymore
		unset($raquadrant); //temporary variable, not needed anymore
		
		//5c. right ascension value needs to be converted into hours
		$ra=$ra/15;
		
		//6. calculate sun's declination
		$sindec=0.39782 * sind($l);
		$cosdec=cosd(asind($sindec));
		
		//7a. calculate the sun's local hour angle
		$cosh=(cosd($zenith)-($sindec*sind($latitude))) / ($cosdec*cosd($latitude));
		if ($cosh < -1) {
			return NULL; //sun does not set at this location on the specified date
		}
		
		//7b. finish calculating H and convert into hours
		$h=acosd($cosh);
		$h=$h/15;
		
		//8. calculate local mean time of rising
		$t=$h+$ra-(0.06571*$t)-6.622;
		
		//9. adjust back to UTC
		$ut=$t-$lnghour;
		$ut=fmod($ut,24);
		
		//10. convert UTC to local time zone of latitude/longitude
		$localt=$ut+$timezone;
		
		//calculation finished, return result as a unix date
		return $date+$localt*60*60;
	}

}
?>