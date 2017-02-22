var arrRecords = new Array();
var arrCookie = new Array();
var recCount = 0;
var strRecord="";
expireDate = new Date;
expireDate.setDate(expireDate.getDate()+365);
function cookieVal(cookieName) {
thisCookie = document.cookie.split("; ")
for (i = 0; i < thisCookie.length; i++) {
if (cookieName == thisCookie[i].split("=")[0]) {
return thisCookie[i].split("=")[1];
   }
}
return 0;
}
function loadCookie() {
if(document.cookie != "") {
arrRecords = cookieVal("Records").split(",");
currentRecord();
   }
}
function setRec() {
strRecord = "";
for(i = 0; i < document.frm1.elements.length; i++) {
strRecord = strRecord + document.frm1.elements[i].value + ":";
}
arrRecords[recCount] = strRecord;
document.frm2.add.value = "  NEW  ";
document.cookie = "Records="+arrRecords+";expires=" + expireDate.toGMTString();
}
function newRec() {
switch (document.frm2.add.value) {
case "  NEW  " :
   varTemp = recCount;
   for(i = 0; i < document.frm1.elements.length; i++) {
   document.frm1.elements[i].value = ""
   }
   recCount = arrRecords.length;
   document.frm2.add.value = "CANCEL";
   break;
case "CANCEL" :
   recCount = varTemp;
   document.frm2.add.value = "  NEW  ";
   currentRecord();
   break;
   }
}
function countRecords() {
document.frm2.actual.value = "Record " + (recCount+1)+";  "+arrRecords.length+" saved records";
}
function delRec() {
arrRecords.splice(recCount,1);
navigate("previous");
setRec();
}
function currentRecord() {
if (arrRecords.length != "") {
strRecord = arrRecords[recCount];
currRecord = strRecord.split(":");
for(i = 0; i < document.frm1.elements.length; i++) {
document.frm1.elements[i].value = currRecord[i];
      }
   }
}
function navigate(control) {
switch (control) {
case "first" :
   recCount = 0;
   currentRecord();
   document.frm2.add.value = "  NEW  ";
   break;
case "last" :
   recCount = arrRecords.length - 1;
   currentRecord();
   document.frm2.add.value = "  NEW  ";
   break;
case "next" :
   if (recCount < arrRecords.length - 1) {
   recCount = recCount + 1;
   currentRecord();
   document.frm2.add.value = "  NEW  ";
   }
   break;
case "previous" :
   if (recCount > 0) {
   recCount = recCount - 1;
   currentRecord();
   }
   document.frm2.add.value = "  NEW  ";
   break;
   default:
   }
}

// Splice method Protype Function
// Peter Belesis, Internet.com
// http://www.dhtmlab.com/

if (!Array.prototype.splice) {
function array_splice(ind,cnt) {
if (arguments.length == 0) return ind;
if (typeof ind != "number") ind = 0;
if (ind < 0) ind = Math.max(0,this.length + ind);
if (ind > this.length) {
if (arguments.length > 2) ind = this.length;
else return [];
}
if (arguments.length < 2) cnt = this.length-ind;
cnt = (typeof cnt == "number") ? Math.max(0,cnt) : 0;
removeArray = this.slice(ind,ind+cnt);
endArray = this.slice(ind+cnt);
this.length = ind;
for (var i = 2; i < arguments.length; i++) {
this[this.length] = arguments[i];
}
for(var i = 0; i < endArray.length; i++) {
this[this.length] = endArray[i];
}
return removeArray;
}
Array.prototype.splice = array_splice;
}
recCount = 0;
loadCookie();
countRecords();




// BODY:
//<form name="frm1">
//<table align="center" resize="none" border="0">
//<tr>
//<td align="right">Name:</td>
//<td colspan="5"><input type="box" name="name" size="49"></td>
//</tr>
//<tr>
//<td align="right">Address:</td><td colspan="5"><input type="box" name="address" size="49"></td></tr>
//<td align="right">Address 2:</td><td colspan="5" align="left"><input type="box" name="address2" size="49"></td></tr>
//<tr>
//<td align="right">City:</td>
//<td><input type="box" name="city" size="15"></td>
//<td>State:</td><td><input type="box" name="state" size="15"></td>
//<td>Zip:</td><td><input type="box" size="6" name="zip"></td>
//</tr>
//<td align="right">Phone:</td>
//<td align="left"><input type="box" name="phone" size="15"></td>
//<td align="right">Fax:</td><td align="left"><input type="box" name="fax" size="15"></td>
//</tr>
//<tr>
//<td align="right">Web Page:<td colspan="5" align="left"><input type="box" name="address" size="49"></td></tr>
//<td align="right">E-Mail:<td colspan="5" align="left"><input type="box" name="email" size="49"></td></tr>
//<tr><td align="right" valign="top">Comments:</td>
//<td colspan="5" align="left"><input type="box" name="comment1" size="49"><br>
//<input type="box" name="comment2" size="49"><br>
//<input type="box" name="comment3" size="49"><br>
//<input type="box" name="comment4" size="49"><br>
//<input type="box" name="comment5" size="49">
//</td></tr></table>
//</form>
//<form name="frm2">
//<table align="center" border="1" resize="none"><tr><td align="center">
//<input type="button" name="first" value="|<<  " onClick="navigate('first');countRecords()">
//<input type="button" name="previous" value="  <  " onClick="navigate('previous');countRecords()">
//<input type="button" name="next" value="  >  " onClick="navigate('next');countRecords()">
//<input type="button" name="last" value="  >>|" onClick="navigate('last');countRecords()">
//<input type="box" name="actual" size=30></td></tr>
//<tr><td align="center"><input type="button" name="add" value="  NEW  " onClick="newRec();countRecords()">
//<input type="button" name="set" value="SAVE RECORD" onClick="setRec();countRecords()">
//<input type="button" name="del" value="Delete" onClick="delRec();countRecords()"></td></tr></table>
//</form>
//