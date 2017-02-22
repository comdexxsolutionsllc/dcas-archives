<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://javascript.internet.com -->

<!-- Begin
var key = new Array();  // Define key launcher pages here
key['h'] = "http://javascript.internet.com/index.html";
key['f'] = "http://javascript.internet.com/feedback.html";
key['n'] = "http://javascript.internet.com/new.html";
key['s'] = "http://javascript.internet.com/toc.html";

function getKey(keyStroke) {
isNetscape=(document.layers);
// Cross-browser key capture routine couresty
// of Randy Bennett (rbennett@thezone.net)
eventChooser = (isNetscape) ? keyStroke.which : event.keyCode;
which = String.fromCharCode(eventChooser).toLowerCase();
for (var i in key) if (which == i) window.location = key[i];
}
document.onkeypress = getKey;
//  End -->

<!-- STEP TWO: Copy this code into the BODY of your HTML document  -->

//<BODY>
//
//<center>
//<table border=0><tr><td>
//<pre>
//This site equipped with Key Launcher!
//
//The following launcher keys are available:
//
//Press the letter 'h' for: Home Page
//Press the letter 'f' for: Feedback Page
//Press the letter 'n' for: What's New Page
//Press the letter 's' for: Site Contents
//</pre>
//</td></tr></table>
//</center>
//
//<p><center>
//<font face="arial, helvetica" size="-2">Free JavaScripts provided<br>
//by <a href="http://javascriptsource.com">The JavaScript Source</a></font>
//</center><p>
//
<!-- Script Size:  1.52 KB -->