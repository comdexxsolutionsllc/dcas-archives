function copyDate() {
  var cpyrt = document.getElementById("copyright")
  if (cpyrt) {
     cpyrt.firstChild.nodeValue = (new Date()).getFullYear();
  }
}

window.onload = copyDate;

