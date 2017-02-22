<?php
/**
* @package userQuota
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc 
* This is a class to allow a graphical or text display of a user's quota.
* The quota and how much has been used is passed to the class and the output
* is display as either a graphic or as text.  The graphic is a pie chart and
* can be displayed in a few different ways
* @uses
* @example
* @files
*/

// Example of use
//
//	 require("class.userquota.php");
//	 $uq = new userQuota(24000000, 5087643);
//	 $uq->setOutputImage();
//	 $uq->setImageProperties(130, TRUE, TRUE, FALSE, 'DDDDDD', 'ED1C24', 'FFFFFF', '555555');
//	 $uq->displayQuota();
//


class userQuota
{
	// quota variables

	var $qType;        // output type
	var $qQuota;       // quota value
	var $qUsed;        // used value
	var $qUser;        // input user name

	// image variables

	var $gWidth;       // width of pie chart
	var $gHeight;      // height of pie chart (determined by width)
	var $g3DHeight;    // do we want a 3D look or not
	var $gLegend;      // display the legend or not
	var $gQuotaColour; // colour of quota
	var $gUsedColour;  // colour of used space
	var $gBackColour;  // colour of the background
	var $gTextColour;  // colour of the legend text
	var $gCentreUsed;  // centre the 'used' wedge to bottom of pie


	//
	// class functions - user called
	//
	

	//
	// $quota is the total quota the user has supplied as just a number
	// $used is how much the user has taken up supplied as just a number
	// $username, if supplied, will be displayed on the image legend or in the text output
	//
	function userQuota($quota, $used, $username = '')
	{
		$this->qUser = $username;
		$this->setOutputImage();
		$this->setImageProperties();

		$this->qQuota   = $quota;
		$this->qUsed    = $used;
		$this->oPercent = ($this->qUsed / (!$this->qQuota ? 1 : $this->qQuota)) * 100;
		$this->qUser    = $username;
	}
	
	//
	// set the class to output only in text mode
	//
	function setOutputText()
	{
		$this->qType = 0;
	}
	
	//
	// set the class to output in graphical mode
	//
	function setOutputImage()
	{
		$this->qType = 1;
	}
	
	//
	// determine the image properties for the class
	//
	// $width is the width of the graph in pixels, supplied as an int
	// $threeD is a boolean value.  TRUE shows graph in faux 3D and FALSE shows graph flat
	// $legend is a boolean value.  TRUE shows legend and FALSE does not
	// $centre is a boolean value.  TRUE shows used wedge centered in chart and FALSE defaults to the right
	//
	// all colours are supplied as HTML hex values
	//
	// $qc is the quota colour
	// $uc is the used colour
	// $bc is the background colour
	// $tc is the legend text colour
	//
	function setImageProperties($width = 150, $threeD = TRUE, $legend = TRUE, $centre = TRUE, $qc = 'DDDDDD', $uc = 'ED1C24', $bc = 'FFFFFF', $tc = '000000')
	{
		$this->gWidth = (!$width ? 150 : $width);
		if ($threeD)
		{
			$this->gHeight   = $width/2;
			$this->g3DHeight = $width/10;
		}
		else
		{
			$this->gHeight   = $width;
			$this->g3DHeight = 0;
		}
		$this->gLegend      = ($legend == TRUE ? TRUE : FALSE);
		$this->gCentreUsed  = ($centre == TRUE ? TRUE : FALSE);
		$this->gQuotaColour = $this->_htmlHexToBinArray($qc);
		$this->gUsedColour  = $this->_htmlHexToBinArray($uc);
		$this->gBackColour  = $this->_htmlHexToBinArray($bc);
		$this->gTextColour  = $this->_htmlHexToBinArray($tc);
	}

	//
	// show the quota output
	//
	function displayQuota()
	{
		($this->qType == 0) ? $this->_displayText() : $this->_displayImage();
	}
	
	//
	// internal functions
	//

	//
	// convert HTML hex value into integer array
	//
	function _htmlHexToBinArray($hex)
	{
		for ($i=0; $i<3; $i++)
		{
			$foo = substr($hex, 2*$i, 2); 
			$rgb[$i] = 16 * hexdec(substr($foo, 0, 1)) + hexdec(substr($foo, 1, 1)); 
		}
		return $rgb;
	}

	//
	// output the quota text
	//
	function _displayText()
	{
		if ($this->qUser) echo 'The quota for ', $this->qUser;
		else echo 'Your quota';
		echo ' is ', $this->_formatSize($this->qQuota), ' and ', 
			($this->qUser ? 'they' : 'you'), ' have used ',
			$this->_formatSize($this->qUsed), ' (',
			number_format($this->oPercent, 2), '%) of it.';
	}

	//
	// output the quota graph
	//
	function _displayImage()
	{
		// the graph variables
		$sStart = $this->g3DHeight * 2;
		$wStart = $this->gWidth * 2;
		$hStart = $this->gHeight * 2;
		if ($this->qUsed >= $this->qQuota) $usedPercent = 360;
		else $usedPercent = $this->oPercent * 3.6;

		// work out where the 'used' wedge will be located
		if ($this->gCentreUsed)
		{
			$sWedge = (int)(90 - ($usedPercent / 2));
			if ($sWedge < 0) $sWedge += 360;
			$mWedge = (int)(90 + ($usedPercent / 2));
			$mWedge = ($mWedge == 90 ? 91 : $mWedge);
			$eWedge = (int)$sWedge;
		}
		else
		{
			$sWedge = 0;
			$mWedge = (int)($usedPercent ? $usedPercent : 1);
			$eWedge = 360;
		}

		// setup image and main colours
		$im = @ImageCreateTrueColor($wStart, $hStart + $sStart);
		if ($im)
		{
			$cBg = ImageColorAllocate($im, $this->gBackColour[0], $this->gBackColour[1], $this->gBackColour[2]);
			$cUsed = ImageColorAllocate($im, $this->gUsedColour[0], $this->gUsedColour[1], $this->gUsedColour[2]);
			$cQuota = ImageColorAllocate($im, $this->gQuotaColour[0], $this->gQuotaColour[1], $this->gQuotaColour[2]);
			ImageFill($im, 0, 0, $cBg);

			// work out 3D look if needs be
			if ($this->g3DHeight)
			{
				// process colours
				$qDarkArray = $this->gQuotaColour;
				for ($i=0; $i<3; $i++)
				{
					($qDarkArray[$i] > 99) ? $qDarkArray[$i] -= 100 : $qDarkArray[$i] = 0;
				}
				$uDarkArray = $this->gUsedColour;
				for ($i=0; $i<3; $i++)
				{
					($uDarkArray[$i] > 99) ? $uDarkArray[$i] -= 100 : $uDarkArray[$i] = 0;
				}
				$cQuotaDark = ImageColorAllocate($im, $qDarkArray[0], $qDarkArray[1], $qDarkArray[2]);
				$cUsedDark = ImageColorAllocate($im, $uDarkArray[0], $uDarkArray[1], $uDarkArray[2]);

				// add 3D look
				$shadow_start = ($hStart/2) + $sStart;
				$shadow_end = $hStart/2;
				for ($i=$shadow_start; $i>$shadow_end; $i--)
				{
					ImageFilledArc($im, ($wStart/2), $i, $wStart, $hStart,  $sWedge, $mWedge, $cUsedDark, IMG_ARC_PIE);
					ImageFilledArc($im, ($wStart/2), $i, $wStart, $hStart, $mWedge, $eWedge, $cQuotaDark, IMG_ARC_PIE);
				}
			}

			// now do the top of the graph
			ImageFilledArc($im, ($wStart/2), ($hStart/2), $wStart, $hStart, $sWedge, $mWedge, $cUsed, IMG_ARC_PIE);
			ImageFilledArc($im, ($wStart/2), ($hStart/2), $wStart, $hStart, $mWedge, $eWedge, $cQuota, IMG_ARC_PIE);

			// now create a legend image if needs be
			if ($this->gLegend)
			{
				// the legend variables
				$lHeight = $lWidth = 0;
				$spacer = 10;

				// build quota strings
				$qText[0] = 'Quota: ' . $this->_formatSize($this->qQuota);
				if ($this->qUser) $qText[1] = '       (' . $this->qUser . ')';
				else $qText[1] = '';
				$uText[0] = 'Used : ' . $this->_formatSize($this->qUsed);
				$uText[1] = '       (' . number_format($this->oPercent,2) . '%)';

				// space + line + spacer + line
				$lHeight = (ImageFontHeight(2) * ($qText[1] == '' ? 3 : 4)) + $spacer;

				// get biggest string length and add spacer to it - legend block is size of font height (square)
				$qMax = (strlen($qText[0]) > strlen($qText[1])) ? strlen($qText[0]) : strlen($qText[1]);
				$uMax = (strlen($uText[0]) > strlen($uText[1])) ? strlen($uText[0]) : strlen($uText[1]);
				$tMax = ($qMax > $uMax ? $qMax : $uMax);
				$lWidth = ($tMax * ImageFontWidth(2)) + $spacer + ImageFontHeight(2);

				// now create the image
				$lim = ImageCreateTrueColor($lWidth, $lHeight);
				ImageFill($lim, 0, 0, $cBg);
				$cText = ImageColorAllocate($lim, $this->gTextColour[0], $this->gTextColour[1], $this->gTextColour[2]);
				$lx = 0;
				$ly = 0;

				// write out the 'quota' legend
				ImageFilledRectangle($lim, $lx, $ly, ($lx + ImageFontHeight(2)), ($ly + ImageFontHeight(2)), $cQuota);
				ImageString($lim, 2, ($lx + ImageFontHeight(2) + $spacer), $ly, $qText[0], $cText);
				if ($qText[1] != '')
				{
					$ly += ImageFontHeight(2);
					ImageString($lim, 2, ($lx + ImageFontHeight(2) + $spacer), $ly, $qText[1], $cText);
				}

				$ly += ($spacer + ImageFontHeight(2));

				// write out the 'used' legend
				ImageFilledRectangle($lim, $lx, $ly, ($lx + ImageFontHeight(2)), ($ly + ImageFontHeight(2)), $cUsed);
				ImageString($lim, 2, ($lx + ImageFontHeight(2) + $spacer), $ly, $uText[0], $cText);
				$ly += ImageFontHeight(2);
				ImageString($lim, 2, ($lx + ImageFontHeight(2) + $spacer), $ly, $uText[1], $cText);

				// now merge the two images into the final one

				// anti-aliasing look
				$gsx = ImageSX($im);
				$gsy = ImageSY($im);
				$lsx = ImageSX($lim);
				$lsy = ImageSY($lim);
				$gnx = ($gsx >> 1);
				$gny = ($gsy >> 1);
				$fx = ($gnx > $lsx) ? $gnx : $lsx;
				$fy = $gny + $lsy + ($spacer * 2);
				$final = ImageCreateTrueColor($fx, $fy);
				ImageFill($final, 0, 0, $cBg);
				ImageCopyResampled($final, $im, (($fx/2)-($gnx/2)), 0, 0, 0, $gnx, $gny, $gsx, $gsy);
				ImageCopyResampled($final, $lim, (($fx/2)-($lsx/2)), $gny + ($spacer * 2), 0, 0, $lsx, $lsy, $lsx, $lsy);
				ImageDestroy($lim);
			}
			else
			{
				// we do not have a legend, so just reample graph
				$sx = ImageSX($im); 
				$sy = ImageSY($im); 
				$nx = ($sx>>1); 
				$ny = ($sy>>1);
				$final = ImageCreateTrueColor($nx, $ny);
				ImageCopyResampled($final, $im, 0, 0, 0, 0, $nx, $ny, $sx, $sy);
			}

			// flush image
			header("Content-type: image/jpeg");
			ImageJPEG($final, NULL, 100);
			ImageDestroy($im);
			ImageDestroy($final);
		}
	}

	//
	// make the size of the quota values more human readable
	//
	function _formatSize($size = 0)
	{
		if ($size >= 1073741824) $size = round($size/1073741824*100)/100 . " Gb";
		else if ($size >= 1048576) $size = round($size/1048576*100)/100 . " Mb";
		else if ($size >= 1024) $size = round($size/1024*100)/100 . " kb";
		else $size = $size . " bytes";
		return $size;
	}

}

?>