<?php
class oajax {

	function setHeader () {
		$sString = <<<HTML
	<script type="text/javascript">
HTML;
		return $sString;
	}

	function setFooter () {
		$sString = <<<HTML
	</script>
HTML;
		return $sString;
	}

	function buildAjax () {
		$sString =<<<HTML

		if (window.XMLHttpRequest) {
			oXmlhttp = new XMLHttpRequest();
		} else if (window.ActiveXObject) {
			oXmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

HTML;
		return $sString;
		}

	function search () {
		$sString =<<<HTML
function search (sS, bSort, iType) {
	if (sS != '') {
		oXmlhttp.open('POST','{$_SERVER['PHP_SELF']}');
		oXmlhttp.onreadystatechange=function() {
			if (oXmlhttp.readyState==4 && oXmlhttp.status == 200) {
				//document.body.innerHTML = oXmlhttp.responseText;
				document.getElementById ('divContent').innerHTML = oXmlhttp.responseText;
			}
		}
		oXmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		var data = 'data='+sS+'&sort='+bSort+'&type='+iType;
		oXmlhttp.send (data);
	}
}

HTML;
	return $sString;
	}
}
?>