(function (){
    "use strict";

    angular.module('app.controllers').controller('DialogTestController', function ($scope, DialogService){


            $scope.addUser = function(){
                return DialogService.fromTemplate('add_user', $scope);
            };

            $scope.success = function(){
                return DialogService.alert('Success', 'User created successfully!');
            };


        });

})();