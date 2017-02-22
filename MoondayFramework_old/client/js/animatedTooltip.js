
<!-- TWO STEPS TO INSTALL ANIMATED TOOLTIP:  -->

<!--   1.  Copy the coding into the HEAD of your HTML document  -->
<!--   2.  Add the last code into the BODY of your HTML document  -->

<!-- STEP ONE: Paste this code into the HEAD of your HTML document  -->

<HEAD>

<script language="JavaScript">

<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://javascript.internet.com -->

<!-- Begin
function showtip2(current,e,text){
  if (document.all&&document.readyState=="complete"){
    document.all.tooltip2.innerHTML='<marquee style="border:1px solid black">'+text+'</marquee>'
    document.all.tooltip2.style.pixelLeft=event.clientX+document.body.scrollLeft+10
    document.all.tooltip2.style.pixelTop=event.clientY+document.body.scrollTop+10
    document.all.tooltip2.style.visibility="visible"
}
  else if (document.layers){
    document.tooltip2.document.nstip.document.write('<b>'+text+'</b>')
    document.tooltip2.document.nstip.document.close()
    document.tooltip2.document.nstip.left=0
    currentscroll=setInterval("scrolltip()",100)
    document.tooltip2.left=e.pageX+10
    document.tooltip2.top=e.pageY+10
    document.tooltip2.visibility="show"
}
}
function hidetip2(){
  if (document.all)
    document.all.tooltip2.style.visibility="hidden"
    else if (document.layers){
    clearInterval(currentscroll)
    document.tooltip2.visibility="hidden"
}
}
//  End -->
</script>

</HEAD>

<!-- STEP TWO: Copy this code into the BODY of your HTML document  -->

<!-- //<BODY>  -->
<!-- //  -->
<!-- //<div id="tooltip2" style="position:absolute;visibility:hidden;clip:rect(0 150 50 0);width:150px;background-color:gold;z-index:10"></div>  -->
<!-- //<div align="CENTER" name="divTest" onMouseover="showtip2(this,event,'Be sure to check out our other JavaScripts!');" onMouseout="hidetip2();" STYLE="cursor: hand">  -->
<!-- //<TABLE border="0" cellpadding="0" cellspacing="0"><TR><TD COLSPAN="7">  -->
<!-- //<IMG SRC="/img/animated-tooltip/1.gif" WIDTH="100" HEIGHT="39" BORDER="0"><p>  -->
<!-- //</TABLE>  -->
<!-- //<p></div>  -->
<!-- //  -->
<!-- //<p><center>  -->
<!-- //<font face="arial, helvetica" size"-2">Free JavaScripts provided<br>  -->
<!-- //by <a href="http://javascriptsource.com">The JavaScript Source</a></font>  -->
<!-- //</center><p>  -->