(function(){
    "use strict";

    angular.module('app.config').config( function($interpolateProvider) {
        $interpolateProvider.startSymbol('%%');
        $interpolateProvider.endSymbol('%%');
    });

})();
