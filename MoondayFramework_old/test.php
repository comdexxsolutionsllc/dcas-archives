<!DOCTYPE HTML>
<html lang="en">


<head>
	<meta charset="utf-8">
	<title>Demo:  Dojo Button Tutorial</title>

	<style type="text/css">
	@import "./lib/js/dojo/dojo/resources/dojo.css";
	@import "./lib/js/dojo/dijit/themes/tundra/tundra.css";
	</style>

	<!-- load dojo and provide config via data attribute -->
	<script type="text/javascript">
        var dojoConfig = {
        	baseRelativePath: "lib/js/dojo/dojo/",
            parseOnLoad: true,
            parseWidgets: true,
            isDebug: (window.location.search.indexOf("debug")>-1),
            debugAtAllCosts: true,
            locale: 'en-us'
        };
	</script>
	<script src="lib/js/dojo/dojo/dojo.js"></script>

	<script type="text/javascript">
	  // Load Dojo's code relating to widget managing functions
	  dojo.require("dojox.widget.*");

	  // Load Dojo's code relating to the Button widget
	  dojo.require("dojox.widget.Button");

	  // Load Dojo's code relating to form
	  dojo.require("dijit.form.*");
	  dojo.require("dijit.form.CheckBox");

	  // Load Dojo's code relating to form autocomplete
	  dojo.require("dijit.form.FilteringSelect");

	  // Load Dojo's code relating to event handler functions
	  dojo.require("dojo.event.*");

	  // Load Dojo's code for Parsing backtracks
	  dojo.require("dojo.parser");



	  function helloPressed()
	  {
	  	alert('"Hello World" Button CLICKED');
	  }

	  function checkboxSelected()
	  {
	    alert('Checkbox SELECTED');
	  }


	  function init()
	  {
	    var helloButton = dojo.widget.byId('helloButton');
	    dojo.event.connect(helloButton, 'onClick', 'helloPressed')

	    var cbCheckbox = dojo.widget.byId('cb');
	    dojo.event.connect(cb, 'onClick', 'checkboxSelected')
	  }

	  dojo.addOnLoad(init);
	</script>
</head>

<body class="tundra">
	<h2>Checkboxes</h2>
	<input id="cb" dojotype="dijit.form.CheckBox" name="developer"
	   checked="checked" value="on" type="checkbox" onClick="checkboxSelected();" />
	<label for="cb"> Are you a Developer </label>

	<h2>Buttons</h2>
	<button dojoType="Button" widgetId="helloButton"
 onClick="helloPressed();">Hello World!</button>

	<h2>Radio Buttons</h2>
	<input dojoType="dijit.form.RadioButton" id="val1" name="group1"
	 checked="checked" value="Programmer" type="radio" />
	<label for="val1"> Programmer </label>
	<input dojotype="dijit.form.RadioButton" id="val2"  name="group1"
	  value="Designer" type="radio" />
	<label for="val2"> Designer </label>
	<input dojotype="dijit.form.RadioButton" id="val3"  name="group1"
	   value="Developer" type="radio" />
	<label for="val3"> Developer </label>

	<h2>Auto Completer Combo box</h2>
	<select dojoType="dijit.form.FilteringSelect" name="sname"
	  autocomplete="false" value="Vinod">
	<option value="Vinod">Vinod</option>
	<option value="Vikash" >Vikash</option>
	<option value="Deepak" >Deepak</option>
	<option value="DeepakSir" >Deepak Sir</option>
	<option value="Arun" >Arun</option>
	<option value="Amar" >Amar</option>
	<option value="Aman" >Aman</option>
	</select>
</body>

</html>