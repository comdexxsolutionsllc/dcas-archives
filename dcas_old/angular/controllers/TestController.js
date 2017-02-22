(function(){
    "use strict";
    
    angular.module('app.controllers').controller('TestController', function ($scope) {
        $scope.names = [
            {name: 'Jani', country: 'Norway'},
            {name: 'Hege', country: 'Sweden'},
            {name: 'Kai', country: 'Denmark'}
        ];
    });
  })();
  
(function () {
    angular.module("app.controllers", ["restangular"]).config(function (RestangularProvider) {
        //set the base url for api calls on our RESTful services
        var newBaseUrl = "";
        if (window.location.hostname === "localhost") {
            newBaseUrl = "http://localhost:8080/data";
        } else {
            var deployedAt = window.location.href.substring(0, window.location.href);
            newBaseUrl = deployedAt + "/data";
        }
        RestangularProvider.setBaseUrl(newBaseUrl);
    });
}());
