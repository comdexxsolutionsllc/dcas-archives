/* This script and many more are available free online at
The JavaScript Source!! http://javascript.internet.com
Created by: Don Demrow | http://www.euro-innova.com */

/* Note that we are setting all the dates and date parts to strings to do our comparisons. */

function autoExpire() {
  var goLiveMonth = "07"  // Month you want your content to start displaying. Two digits.
  var goLiveDay = "11"      // Day you want your content to start displaying. Two digits.
  var goLiveYear = "2010"     // Year you want your content to start displaying. Four digits.

  var expireMonth = "07"   // Month you want your content to stop displaying. Two digits.
  var expireDay = "13"     // Day you want your content to stop displaying. Two digits.
  var expireYear = "2010"  // Year you want your content to stop displaying. Four digits.

  /* This is where you put your content. Make sure you escape any quotation marks with a backslash. Make sure you do not delete the opening and closing quotes. */
  var myContent = "<center>You have until <strong>TOMORROW</strong> to add all of the Client/JS Scripts.</center>"

  /* Don't edit below this line. Don */

  var goLiveDate = goLiveYear + goLiveMonth + goLiveDay;  // puts START year, month, and day together.
  var expireDate = expireYear + expireMonth + expireDay;  // puts EXPIRE year, month, and day together.

  var nowDate = new Date();
  var day = nowDate.getUTCDate();
  var month = nowDate.getUTCMonth();
  var correctedMonth = month + 1;  //month - JavaScript starts at "0" for January, so we add "1"

  if (correctedMonth < 10) {  /* if less than "10", put a "0" in front of the number. */
    correctedMonth = "0" + correctedMonth;
  }
   
  if (day < 10) {  /* if less than "10", put a "0" in front of the number. */
    day = "0" + day;
  }

  var year = nowDate.getYear();  /* Get the year. Firefox and Netscape might use century bit, and two-digit year. */
  if (year < 1900) {
    year = year + 1900;  /*This is to make sure Netscape AND FireFox doesn't show the year as "107" for "2007." */
  }

  var GMTdate = year + "" + correctedMonth + "" + day;  //corrected month GMT date.

  if ((GMTdate <= expireDate) && (GMTdate >= goLiveDate)) {
    document.write(myContent)
  }
}


