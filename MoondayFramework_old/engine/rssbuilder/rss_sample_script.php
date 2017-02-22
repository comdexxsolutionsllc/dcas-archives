<?php
/**
* @package RSSBuilder
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc RSS builder class test
* @uses
* @example
* @files

/**
* @package RSSBuilder
* @category FLP
* @filesource
*/
error_reporting(E_ALL & ~E_NOTICE);
ob_start();
session_start();
include_once('class.RSSBuilder.inc.php');

/* create the object - remember, not all attibutes are supported by every rss version. just hand over an empty string if you don't need a specific attribute */
$encoding =(string) 'ISO-8859-1';
$about = (string) 'http://localhost/';
$title = (string) 'Localhost RSS News Feed';
$description = (string) 'localhost.localdomain RSS description line';
$image_link = (string) 'http://flaimo.com/small_logo.png';
$category = (string) 'Datacenter / Hosting Automation'; // (only rss 2.0)
$cache = (string) 60; // in minutes (only rss 2.0)
$rssfile = new RSSBuilder($encoding, $about, $title, $description, $image_link, $category, $cache);

/* if you want you can add additional Dublic Core data to the basic rss file (if rss version supports it) */
$publisher = (string) 'Moonday Framework Inc'; // person, an organization, or a service
$creator = (string) 'Comdexx Solutions LLC'; // person, an organization, or a service
$date = (string) date('Y-m-d\TH:i:sO');
$language = (string) 'en';
$rights = (string) 'Copyright � 2010 comdexxsolutionsllc.net';
$coverage = (string) ''; // spatial location , temporal period or jurisdiction
$contributor = (string) 'CSLLC.Net Developers'; // person, an organization, or a service
$rssfile->addDCdata($publisher,	$creator, $date, $language,	$rights, $coverage, $contributor);

/* if you want you can add additional Syndication data to the basic rss file (if rss version supports it) */
$period = (string) 'daily'; // hourly / daily / weekly / ...
$frequency = (int) 1; // every X hours/days/...
$base = (string) date('Y-m-d\TH:i:sO');
$rssfile->addSYdata($period, $frequency, $base);

/* data for a single RSS item */
$about = $link = 'http://flaimo.com/sometext.php?somevariable=somevalue';
$title = (string) 'A fake news headline';
$description = (string) 'some abstract text about the fake news';
$subject = (string) 'technology'; // optional DC value
$date = (string) date('Y-m-d\TH:i:sO'); // optional DC value
$author = (string) 'Flaimo'; // author of item
$comments = (string) 'http://flaimo.com/sometext.php?somevariable=somevalue&comments=1'; // url to comment page rss 2.0 value
$rssfile->addItem($about, $title, $link, $description, $subject, $date,	$author, $comments);

// add as much items as you want ...

$version = '1.0'; // 0.91 / 1.0 / 2.0
$rssfile->outputRSS($version);
// if you don't want to directly output the content, but instead work with the string (for example write it to a cache file) use
// $rssfile->getRSSOutput($version);
ob_end_flush();
?>