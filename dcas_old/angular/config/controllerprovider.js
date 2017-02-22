(function(){
    "use strict";

    angular.module('app.config').config(['$controllerProvider', function ($controllerProvider) {
            $controllerProvider.allowGlobals();
        }]);
})();