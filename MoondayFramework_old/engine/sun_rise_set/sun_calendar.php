<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Sunrise/Sunset Table</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>

<body>
<?php 

require_once("include/sun.php");

$sun=new sun;

function pad($howmany) {
	for ($c=0; $c<$howmany; $c++) {
		echo("<td>&nbsp;</td>\n");
	}
}

if (!isset($_GET["view"]) or $_GET["view"]=="month") {
	if (isset($_GET["year"])) $year=(int)$_GET["year"]; else $year=(int)date("Y");
	if (isset($_GET["month"])) $month=(int)$_GET["month"]; else $month=(int)date("m");
	if (isset($_GET["zenith"])) $zenith=$_GET["zenith"]; else $zenith=90+50/60;
	if (isset($_GET["longitude"])) $longitude=$_GET["longitude"]; else $longitude=55.2;
	if (isset($_GET["latitude"])) $latitude=$_GET["latitude"]; else $latitude=25.15;
	if (isset($_GET["timezone"])) $timezone=$_GET["timezone"]; else $timezone=0;
	echo("<h1>Sunrise and Sunset - " . date("F Y",mktime(0,0,0,$month,1,$year)) . "</h1>");
	?>
	
<table border="1">
		<thead>
			<tr>
				<th>Sat</th><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th>
			</tr>
		</thead>
		<tbody>
			<tr>
			<?php 
			$date=mktime(0,0,0,$month,1,$year);
			$w=(date("w",$date)+8)%7;
			pad($w);

			for ($d=1; $d<=32; $d++) {
				if (!checkdate($month,$d,$year)) {
					pad(7-($w+1));
					break;
				}
				$date=mktime(0,0,0,$month,$d,$year);
				$w=(date("w",$date)+8)%7;
				if ($w==0 and $d!=1) {
					echo("</tr><tr>");
				}
				echo("<td>");
				echo('<table>');
				echo("<tr>");
				echo('<td rowspan="2"><strong>' . $d . "</strong></td>");
				echo("<td>");
				$sunrise=$sun->rise(mktime(0,0,0,$month,$d,$year),$timezone,$latitude,$longitude,$zenith);
				echo(is_null($sunrise)?"&nbsp;":date("H:i",$sunrise));
				echo("</td></tr><tr><td>");
				$sunset=$sun->set(mktime(0,0,0,$month,$d,$year),$timezone,$latitude,$longitude,$zenith);
				echo(is_null($sunset)?"&nbsp;":date("H:i",$sunset));
				echo("</td></tr>");
				echo("</table>");
				echo("</td>\n");
			}
			?>
			</tr>
		</tbody>
	</table>
	<?php
}
?>
<div style="position:absolute; top:0%; width:auto; left:75%; height:auto; z-index:1">
<form>
    <p>Month: 
      <select name="month">
        <?php 
		for ($c=1; $c<=12; $c++) {
			$f=date("F",mktime(0,0,0,$c,1,$year));
			echo('<option value="' . $c . '"' . ($f==date("F",mktime(0,0,0,$month,1,$year))?" selected":"") . '>' . $f . "</option>");
		}
		?>
      </select>
      <br />
      Year: 
      <input name="year" type="text" value="<?php echo($year);?>" size="6" maxlength="6" />
      <br />
      Longitude: 
      <input name="longitude" type="text" value="<?php echo($longitude);?>" size="7" maxlength="7" />
      <br />
      Latitude: 
      <input name="latitude" type="text" value="<?php echo($latitude);?>" size="7" maxlength="7" />
      <br />
      Timezone:
      <input name="timezone" type="text" value="<?php echo($timezone);?>" size="8" maxlength="8" />
		<br />
    Zenith: 
      <select name="zenith">
        <option value="90.83333333333"<?php echo(($zenith==90.83333333333)?" selected":"");?>>90&deg;50' 
        Official</option>
        <option value="96"<?php echo(($zenith==96)?" selected":"");?>>96&deg; 
        Civil</option>
        <option value="102"<?php echo(($zenith==102)?" selected":"");?>>102&deg; 
        Nautical</option>
        <option value="108"<?php echo(($zenith==108)?" selected":"");?>>108&deg; 
        Astronomical</option>
      </select>
      <br />
      <input type="hidden" name="view" value="month" />
      <input type="submit" />
	  </p>
    </form>
</div>
</body>
</html>
