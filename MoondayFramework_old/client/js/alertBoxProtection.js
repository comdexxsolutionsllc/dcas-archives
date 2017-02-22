
<!-- Add this snippet to the beginning of your code for testing purposes.  -->

/* This script and many more are available free online at
The JavaScript Source :: http://javascript.internet.com
Created by: Benjamin Joffe :: http://www.abrahamjoffe.com.au/ */

(function(){
  var a=window.alert, c=0;
  window.alert=function(q){
    // Change the number below to the number of alert boxes to display before the warning is given.
    if (++c%5==0) {
      if (!confirm(q+'\nThere have been '+c+' alert boxes, continue displaying them?')) window.alert=function(){};
    } else a(q);
  }
})();

// This is only a test case. You can removed it.
//for (var i=1; i<50; i++) {
//  alert('This is an annoying loop of 50 alerts.\nEvery 5th alert you will have an option to exit.\n\n'+i);
//}
//

