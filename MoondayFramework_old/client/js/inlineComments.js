

function showhide(s){
  while(s.nodeType!=1 && s.nodeName.toLowerCase()!='span'){s=s.nextSibling};
  s.className=(s.className=='show2')?'hide':'show2';
  return false;
}

// Borrowed from Jeremy Keith | http://www.domscripting.com/
window.onload=getReady;
function getReady() {
  var links = document.getElementsByTagName("a");
  for (var i=0; i<links.length; i++) {
    if (links[i].className == "show") {
      links[i].onclick = function() {
      return showhide(this.nextSibling);
     }
    }
  }
}