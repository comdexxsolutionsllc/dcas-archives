//	
//	

function checkCheckBox(f) {
  if (f.agree.checked == false) {
    alert('Please check the box to continue.');
    return false;
  } else
    return true;
}

function move_box(an, box) {
  var cleft = 0;
  var ctop = 0;
  var obj = an;
  while (obj.offsetParent) {
    cleft += obj.offsetLeft;
    ctop += obj.offsetTop;
    obj = obj.offsetParent;
  }
  box.style.left = cleft + 'px';
  ctop += an.offsetHeight + 8;
  if (document.body.currentStyle &&
    document.body.currentStyle['marginTop']) {
    ctop += parseInt(
      document.body.currentStyle['marginTop']);
  }
  box.style.top = ctop + 'px';
}

function show_hide_box(an, width, height, borderStyle) {
  var href = an.href;
  var boxdiv = document.getElementById(href);

  if (boxdiv != null) {
    if (boxdiv.style.display=='none') {
      move_box(an, boxdiv);
      boxdiv.style.display='block';
    } else
      boxdiv.style.display='none';
    return false;
  }

  boxdiv = document.createElement('div');
  boxdiv.setAttribute('id', href);
  boxdiv.style.display = 'block';
  boxdiv.style.position = 'absolute';
  boxdiv.style.width = width + 'px';
  boxdiv.style.height = height + 'px';
  boxdiv.style.border = borderStyle;
  boxdiv.style.backgroundColor = '#fff';

  var contents = document.createElement('iframe');
  contents.scrolling = 'no';
  contents.frameBorder = '0';
  contents.style.width = width + 'px';
  contents.style.height = height + 'px';
  contents.src = href;

  boxdiv.appendChild(contents);
  document.body.appendChild(boxdiv);
  move_box(an, boxdiv);

  return false;
}


// For HTML body

<!-- Body -->
<!--  Add an onClick handler to the hyperlinks you want to display in the boxes. -->
<!-- The handler should call the show_hide_box function with four parameters. The first should always be 'this'. -->
<!-- The second is the width of the box in pixels, the third is the height in pixels, and the last one is the border style. -->

<!-- Be sure and read <a href="aboutJSS.html" onClick="return show_hide_box(this,200,270,'2px dotted')">this one</a>. -->
<!-- Body : End -->

<!-- Body -->
<!-- <form action="yourFormScript.php" method="POST" onsubmit="return checkCheckBox(this)">	-->
<!-- I accept: <input type="checkbox" value="0" name="agree">								-->
<!-- <input type="submit" value="Continue Order">											-->
<!-- <input type="button" value="Exit" onclick="document.location.href='/index.html';">		-->
<!-- </form>																				-->
<!-- Body : End -->