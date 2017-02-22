(function () {
    "use strict";

    var app = angular.module('app',
            [
                'ngRoute',
                'app.controllers',
                'app.filters',
                'app.services',
                'app.directives',
                'app.routes',
                'app.config'
            ]);

    angular.module('app.routes', ['ui.router']);
    angular.module('app.controllers', ['ngMaterial', 'ui.router', 'restangular']);
    angular.module('app.filters', []);
    angular.module('app.services', []);
    angular.module('app.directives', []);
    angular.module('app.config', ['ngMaterial']);
})();
(function(){
    "use strict";

    angular.module('app.routes').config( ["$stateProvider", "$urlRouterProvider", function($stateProvider, $urlRouterProvider ) {

        var getView = function( viewName ){
            return '/views/app/' + viewName + '/' + viewName + '.html';
        };

        $urlRouterProvider.otherwise('/');

        $stateProvider
        .state('landing', {
            url: '/',
            views: {
                main: {
                    templateUrl: getView('landing')
                }
            }
        }).state('login', {
            url: '/login',
            views: {
                main: {
                    templateUrl: getView('login')
                },
                footer: {
                    templateUrl: getView('footer')
                }
            }
        });

    }] );
})();

(function(){
    "use strict";

    angular.module('app.config').config(['$controllerProvider', function ($controllerProvider) {
            $controllerProvider.allowGlobals();
        }]);
})();
(function(){
    "use strict";

    angular.module('app.config').config( ["$interpolateProvider", function($interpolateProvider) {
        $interpolateProvider.startSymbol('%%');
        $interpolateProvider.endSymbol('%%');
    }]);

})();

(function(){
    "use strict";

    angular.module('app.config').config( ["$mdThemingProvider", function($mdThemingProvider) {
        /* For more info, visit https://material.angularjs.org/#/Theming/01_introduction */
        $mdThemingProvider.theme('default')
        .primaryPalette('teal')
        .accentPalette('cyan')
        .warnPalette('red');
    }]);

})();
(function (){
    "use strict";

    angular.module('app.controllers').controller('DialogTestController', ["$scope", "DialogService", function ($scope, DialogService){


            $scope.addUser = function(){
                return DialogService.fromTemplate('add_user', $scope);
            };

            $scope.success = function(){
                return DialogService.alert('Success', 'User created successfully!');
            };


        }]);

})();
(function(){
    "use strict";
    
    angular.module('app.controllers').controller('TestController', ["$scope", function ($scope) {
        $scope.names = [
            {name: 'Jani', country: 'Norway'},
            {name: 'Hege', country: 'Sweden'},
            {name: 'Kai', country: 'Denmark'}
        ];
    }]);
  })();
  
(function () {
    angular.module("app.controllers", ["restangular"]).config(["RestangularProvider", function (RestangularProvider) {
        //set the base url for api calls on our RESTful services
        var newBaseUrl = "";
        if (window.location.hostname === "localhost") {
            newBaseUrl = "http://localhost:8080/data";
        } else {
            var deployedAt = window.location.href.substring(0, window.location.href);
            newBaseUrl = deployedAt + "/data";
        }
        RestangularProvider.setBaseUrl(newBaseUrl);
    }]);
}());

(function(){
    "use strict";

    angular.module("app.services").factory('DialogService', ["$mdDialog", function( $mdDialog ){

        return {
            fromTemplate: function( template, $scope ) {

                var options = {
                    templateUrl: '/views/dialogs/' + template + '/' + template + '.html'
                };

                if ( $scope ){
                    options.scope = $scope.$new();
                }

                return $mdDialog.show(options);
            },

            hide: function(){
                return $mdDialog.hide();
            },

            alert: function(title, content){
                $mdDialog.show(
                    $mdDialog.alert()
                    .title(title)
                    .content(content)
                    .ok('Ok')
                    );
            }
        };
    }]);
})();
(function(){
    "use strict";

    angular.module("app.services").factory('ToastService', ["$mdToast", function( $mdToast ){

        var delay = 6000,
        position = 'top right',
        action = 'OK';

        return {
            show: function(content) {
                return $mdToast.show(
                    $mdToast.simple()
                    .content(content)
                    .position(position)
                    .action(action)
                    .hideDelay(delay)
                    );
            }
        };
    }]);
})();
//# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm1haW4uanMiLCJyb3V0ZXMuanMiLCJjb25maWcvY29udHJvbGxlcnByb3ZpZGVyLmpzIiwiY29uZmlnL2ludGVycG9sYXRpb24uanMiLCJjb25maWcvdGhlbWUuanMiLCJjb250cm9sbGVycy9EaWFsb2dUZXN0Q29udHJvbGxlci5qcyIsImNvbnRyb2xsZXJzL1Rlc3RDb250cm9sbGVyLmpzIiwic2VydmljZXMvZGlhbG9nLmpzIiwic2VydmljZXMvdG9hc3QuanMiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBQUEsQ0FBQSxZQUFBO0lBQ0E7O0lBRUEsSUFBQSxNQUFBLFFBQUEsT0FBQTtZQUNBO2dCQUNBO2dCQUNBO2dCQUNBO2dCQUNBO2dCQUNBO2dCQUNBO2dCQUNBOzs7SUFHQSxRQUFBLE9BQUEsY0FBQSxDQUFBO0lBQ0EsUUFBQSxPQUFBLG1CQUFBLENBQUEsY0FBQSxhQUFBO0lBQ0EsUUFBQSxPQUFBLGVBQUE7SUFDQSxRQUFBLE9BQUEsZ0JBQUE7SUFDQSxRQUFBLE9BQUEsa0JBQUE7SUFDQSxRQUFBLE9BQUEsY0FBQSxDQUFBOztBQ25CQSxDQUFBLFVBQUE7SUFDQTs7SUFFQSxRQUFBLE9BQUEsY0FBQSxpREFBQSxTQUFBLGdCQUFBLHFCQUFBOztRQUVBLElBQUEsVUFBQSxVQUFBLFVBQUE7WUFDQSxPQUFBLGdCQUFBLFdBQUEsTUFBQSxXQUFBOzs7UUFHQSxtQkFBQSxVQUFBOztRQUVBO1NBQ0EsTUFBQSxXQUFBO1lBQ0EsS0FBQTtZQUNBLE9BQUE7Z0JBQ0EsTUFBQTtvQkFDQSxhQUFBLFFBQUE7OztXQUdBLE1BQUEsU0FBQTtZQUNBLEtBQUE7WUFDQSxPQUFBO2dCQUNBLE1BQUE7b0JBQ0EsYUFBQSxRQUFBOztnQkFFQSxRQUFBO29CQUNBLGFBQUEsUUFBQTs7Ozs7Ozs7QUMxQkEsQ0FBQSxVQUFBO0lBQ0E7O0lBRUEsUUFBQSxPQUFBLGNBQUEsT0FBQSxDQUFBLHVCQUFBLFVBQUEscUJBQUE7WUFDQSxvQkFBQTs7O0FDSkEsQ0FBQSxVQUFBO0lBQ0E7O0lBRUEsUUFBQSxPQUFBLGNBQUEsaUNBQUEsU0FBQSxzQkFBQTtRQUNBLHFCQUFBLFlBQUE7UUFDQSxxQkFBQSxVQUFBOzs7OztBQ0xBLENBQUEsVUFBQTtJQUNBOztJQUVBLFFBQUEsT0FBQSxjQUFBLCtCQUFBLFNBQUEsb0JBQUE7O1FBRUEsbUJBQUEsTUFBQTtTQUNBLGVBQUE7U0FDQSxjQUFBO1NBQ0EsWUFBQTs7OztBQ1JBLENBQUEsV0FBQTtJQUNBOztJQUVBLFFBQUEsT0FBQSxtQkFBQSxXQUFBLG9EQUFBLFVBQUEsUUFBQSxjQUFBOzs7WUFHQSxPQUFBLFVBQUEsVUFBQTtnQkFDQSxPQUFBLGNBQUEsYUFBQSxZQUFBOzs7WUFHQSxPQUFBLFVBQUEsVUFBQTtnQkFDQSxPQUFBLGNBQUEsTUFBQSxXQUFBOzs7Ozs7O0FDWEEsQ0FBQSxVQUFBO0lBQ0E7O0lBRUEsUUFBQSxPQUFBLG1CQUFBLFdBQUEsNkJBQUEsVUFBQSxRQUFBO1FBQ0EsT0FBQSxRQUFBO1lBQ0EsQ0FBQSxNQUFBLFFBQUEsU0FBQTtZQUNBLENBQUEsTUFBQSxRQUFBLFNBQUE7WUFDQSxDQUFBLE1BQUEsT0FBQSxTQUFBOzs7OztBQUtBLENBQUEsWUFBQTtJQUNBLFFBQUEsT0FBQSxtQkFBQSxDQUFBLGdCQUFBLCtCQUFBLFVBQUEscUJBQUE7O1FBRUEsSUFBQSxhQUFBO1FBQ0EsSUFBQSxPQUFBLFNBQUEsYUFBQSxhQUFBO1lBQ0EsYUFBQTtlQUNBO1lBQ0EsSUFBQSxhQUFBLE9BQUEsU0FBQSxLQUFBLFVBQUEsR0FBQSxPQUFBLFNBQUE7WUFDQSxhQUFBLGFBQUE7O1FBRUEsb0JBQUEsV0FBQTs7OztBQ3RCQSxDQUFBLFVBQUE7SUFDQTs7SUFFQSxRQUFBLE9BQUEsZ0JBQUEsUUFBQSwrQkFBQSxVQUFBLFdBQUE7O1FBRUEsT0FBQTtZQUNBLGNBQUEsVUFBQSxVQUFBLFNBQUE7O2dCQUVBLElBQUEsVUFBQTtvQkFDQSxhQUFBLG9CQUFBLFdBQUEsTUFBQSxXQUFBOzs7Z0JBR0EsS0FBQSxRQUFBO29CQUNBLFFBQUEsUUFBQSxPQUFBOzs7Z0JBR0EsT0FBQSxVQUFBLEtBQUE7OztZQUdBLE1BQUEsVUFBQTtnQkFDQSxPQUFBLFVBQUE7OztZQUdBLE9BQUEsU0FBQSxPQUFBLFFBQUE7Z0JBQ0EsVUFBQTtvQkFDQSxVQUFBO3FCQUNBLE1BQUE7cUJBQ0EsUUFBQTtxQkFDQSxHQUFBOzs7Ozs7QUM1QkEsQ0FBQSxVQUFBO0lBQ0E7O0lBRUEsUUFBQSxPQUFBLGdCQUFBLFFBQUEsNkJBQUEsVUFBQSxVQUFBOztRQUVBLElBQUEsUUFBQTtRQUNBLFdBQUE7UUFDQSxTQUFBOztRQUVBLE9BQUE7WUFDQSxNQUFBLFNBQUEsU0FBQTtnQkFDQSxPQUFBLFNBQUE7b0JBQ0EsU0FBQTtxQkFDQSxRQUFBO3FCQUNBLFNBQUE7cUJBQ0EsT0FBQTtxQkFDQSxVQUFBOzs7OztLQUtBIiwiZmlsZSI6ImFwcC5qcyIsInNvdXJjZXNDb250ZW50IjpbIihmdW5jdGlvbiAoKSB7XG4gICAgXCJ1c2Ugc3RyaWN0XCI7XG5cbiAgICB2YXIgYXBwID0gYW5ndWxhci5tb2R1bGUoJ2FwcCcsXG4gICAgICAgICAgICBbXG4gICAgICAgICAgICAgICAgJ25nUm91dGUnLFxuICAgICAgICAgICAgICAgICdhcHAuY29udHJvbGxlcnMnLFxuICAgICAgICAgICAgICAgICdhcHAuZmlsdGVycycsXG4gICAgICAgICAgICAgICAgJ2FwcC5zZXJ2aWNlcycsXG4gICAgICAgICAgICAgICAgJ2FwcC5kaXJlY3RpdmVzJyxcbiAgICAgICAgICAgICAgICAnYXBwLnJvdXRlcycsXG4gICAgICAgICAgICAgICAgJ2FwcC5jb25maWcnXG4gICAgICAgICAgICBdKTtcblxuICAgIGFuZ3VsYXIubW9kdWxlKCdhcHAucm91dGVzJywgWyd1aS5yb3V0ZXInXSk7XG4gICAgYW5ndWxhci5tb2R1bGUoJ2FwcC5jb250cm9sbGVycycsIFsnbmdNYXRlcmlhbCcsICd1aS5yb3V0ZXInLCAncmVzdGFuZ3VsYXInXSk7XG4gICAgYW5ndWxhci5tb2R1bGUoJ2FwcC5maWx0ZXJzJywgW10pO1xuICAgIGFuZ3VsYXIubW9kdWxlKCdhcHAuc2VydmljZXMnLCBbXSk7XG4gICAgYW5ndWxhci5tb2R1bGUoJ2FwcC5kaXJlY3RpdmVzJywgW10pO1xuICAgIGFuZ3VsYXIubW9kdWxlKCdhcHAuY29uZmlnJywgWyduZ01hdGVyaWFsJ10pO1xufSkoKTsiLCIoZnVuY3Rpb24oKXtcbiAgICBcInVzZSBzdHJpY3RcIjtcblxuICAgIGFuZ3VsYXIubW9kdWxlKCdhcHAucm91dGVzJykuY29uZmlnKCBmdW5jdGlvbigkc3RhdGVQcm92aWRlciwgJHVybFJvdXRlclByb3ZpZGVyICkge1xuXG4gICAgICAgIHZhciBnZXRWaWV3ID0gZnVuY3Rpb24oIHZpZXdOYW1lICl7XG4gICAgICAgICAgICByZXR1cm4gJy92aWV3cy9hcHAvJyArIHZpZXdOYW1lICsgJy8nICsgdmlld05hbWUgKyAnLmh0bWwnO1xuICAgICAgICB9O1xuXG4gICAgICAgICR1cmxSb3V0ZXJQcm92aWRlci5vdGhlcndpc2UoJy8nKTtcblxuICAgICAgICAkc3RhdGVQcm92aWRlclxuICAgICAgICAuc3RhdGUoJ2xhbmRpbmcnLCB7XG4gICAgICAgICAgICB1cmw6ICcvJyxcbiAgICAgICAgICAgIHZpZXdzOiB7XG4gICAgICAgICAgICAgICAgbWFpbjoge1xuICAgICAgICAgICAgICAgICAgICB0ZW1wbGF0ZVVybDogZ2V0VmlldygnbGFuZGluZycpXG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuICAgICAgICB9KS5zdGF0ZSgnbG9naW4nLCB7XG4gICAgICAgICAgICB1cmw6ICcvbG9naW4nLFxuICAgICAgICAgICAgdmlld3M6IHtcbiAgICAgICAgICAgICAgICBtYWluOiB7XG4gICAgICAgICAgICAgICAgICAgIHRlbXBsYXRlVXJsOiBnZXRWaWV3KCdsb2dpbicpXG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICBmb290ZXI6IHtcbiAgICAgICAgICAgICAgICAgICAgdGVtcGxhdGVVcmw6IGdldFZpZXcoJ2Zvb3RlcicpXG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcblxuICAgIH0gKTtcbn0pKCk7XG4iLCIoZnVuY3Rpb24oKXtcbiAgICBcInVzZSBzdHJpY3RcIjtcblxuICAgIGFuZ3VsYXIubW9kdWxlKCdhcHAuY29uZmlnJykuY29uZmlnKFsnJGNvbnRyb2xsZXJQcm92aWRlcicsIGZ1bmN0aW9uICgkY29udHJvbGxlclByb3ZpZGVyKSB7XG4gICAgICAgICAgICAkY29udHJvbGxlclByb3ZpZGVyLmFsbG93R2xvYmFscygpO1xuICAgICAgICB9XSk7XG59KSgpOyIsIihmdW5jdGlvbigpe1xuICAgIFwidXNlIHN0cmljdFwiO1xuXG4gICAgYW5ndWxhci5tb2R1bGUoJ2FwcC5jb25maWcnKS5jb25maWcoIGZ1bmN0aW9uKCRpbnRlcnBvbGF0ZVByb3ZpZGVyKSB7XG4gICAgICAgICRpbnRlcnBvbGF0ZVByb3ZpZGVyLnN0YXJ0U3ltYm9sKCclJScpO1xuICAgICAgICAkaW50ZXJwb2xhdGVQcm92aWRlci5lbmRTeW1ib2woJyUlJyk7XG4gICAgfSk7XG5cbn0pKCk7XG4iLCIoZnVuY3Rpb24oKXtcbiAgICBcInVzZSBzdHJpY3RcIjtcblxuICAgIGFuZ3VsYXIubW9kdWxlKCdhcHAuY29uZmlnJykuY29uZmlnKCBmdW5jdGlvbigkbWRUaGVtaW5nUHJvdmlkZXIpIHtcbiAgICAgICAgLyogRm9yIG1vcmUgaW5mbywgdmlzaXQgaHR0cHM6Ly9tYXRlcmlhbC5hbmd1bGFyanMub3JnLyMvVGhlbWluZy8wMV9pbnRyb2R1Y3Rpb24gKi9cbiAgICAgICAgJG1kVGhlbWluZ1Byb3ZpZGVyLnRoZW1lKCdkZWZhdWx0JylcbiAgICAgICAgLnByaW1hcnlQYWxldHRlKCd0ZWFsJylcbiAgICAgICAgLmFjY2VudFBhbGV0dGUoJ2N5YW4nKVxuICAgICAgICAud2FyblBhbGV0dGUoJ3JlZCcpO1xuICAgIH0pO1xuXG59KSgpOyIsIihmdW5jdGlvbiAoKXtcbiAgICBcInVzZSBzdHJpY3RcIjtcblxuICAgIGFuZ3VsYXIubW9kdWxlKCdhcHAuY29udHJvbGxlcnMnKS5jb250cm9sbGVyKCdEaWFsb2dUZXN0Q29udHJvbGxlcicsIGZ1bmN0aW9uICgkc2NvcGUsIERpYWxvZ1NlcnZpY2Upe1xuXG5cbiAgICAgICAgICAgICRzY29wZS5hZGRVc2VyID0gZnVuY3Rpb24oKXtcbiAgICAgICAgICAgICAgICByZXR1cm4gRGlhbG9nU2VydmljZS5mcm9tVGVtcGxhdGUoJ2FkZF91c2VyJywgJHNjb3BlKTtcbiAgICAgICAgICAgIH07XG5cbiAgICAgICAgICAgICRzY29wZS5zdWNjZXNzID0gZnVuY3Rpb24oKXtcbiAgICAgICAgICAgICAgICByZXR1cm4gRGlhbG9nU2VydmljZS5hbGVydCgnU3VjY2VzcycsICdVc2VyIGNyZWF0ZWQgc3VjY2Vzc2Z1bGx5IScpO1xuICAgICAgICAgICAgfTtcblxuXG4gICAgICAgIH0pO1xuXG59KSgpOyIsIihmdW5jdGlvbigpe1xuICAgIFwidXNlIHN0cmljdFwiO1xuICAgIFxuICAgIGFuZ3VsYXIubW9kdWxlKCdhcHAuY29udHJvbGxlcnMnKS5jb250cm9sbGVyKCdUZXN0Q29udHJvbGxlcicsIGZ1bmN0aW9uICgkc2NvcGUpIHtcbiAgICAgICAgJHNjb3BlLm5hbWVzID0gW1xuICAgICAgICAgICAge25hbWU6ICdKYW5pJywgY291bnRyeTogJ05vcndheSd9LFxuICAgICAgICAgICAge25hbWU6ICdIZWdlJywgY291bnRyeTogJ1N3ZWRlbid9LFxuICAgICAgICAgICAge25hbWU6ICdLYWknLCBjb3VudHJ5OiAnRGVubWFyayd9XG4gICAgICAgIF07XG4gICAgfSk7XG4gIH0pKCk7XG4gIFxuKGZ1bmN0aW9uICgpIHtcbiAgICBhbmd1bGFyLm1vZHVsZShcImFwcC5jb250cm9sbGVyc1wiLCBbXCJyZXN0YW5ndWxhclwiXSkuY29uZmlnKGZ1bmN0aW9uIChSZXN0YW5ndWxhclByb3ZpZGVyKSB7XG4gICAgICAgIC8vc2V0IHRoZSBiYXNlIHVybCBmb3IgYXBpIGNhbGxzIG9uIG91ciBSRVNUZnVsIHNlcnZpY2VzXG4gICAgICAgIHZhciBuZXdCYXNlVXJsID0gXCJcIjtcbiAgICAgICAgaWYgKHdpbmRvdy5sb2NhdGlvbi5ob3N0bmFtZSA9PT0gXCJsb2NhbGhvc3RcIikge1xuICAgICAgICAgICAgbmV3QmFzZVVybCA9IFwiaHR0cDovL2xvY2FsaG9zdDo4MDgwL2RhdGFcIjtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIHZhciBkZXBsb3llZEF0ID0gd2luZG93LmxvY2F0aW9uLmhyZWYuc3Vic3RyaW5nKDAsIHdpbmRvdy5sb2NhdGlvbi5ocmVmKTtcbiAgICAgICAgICAgIG5ld0Jhc2VVcmwgPSBkZXBsb3llZEF0ICsgXCIvZGF0YVwiO1xuICAgICAgICB9XG4gICAgICAgIFJlc3Rhbmd1bGFyUHJvdmlkZXIuc2V0QmFzZVVybChuZXdCYXNlVXJsKTtcbiAgICB9KTtcbn0oKSk7XG4iLCIoZnVuY3Rpb24oKXtcbiAgICBcInVzZSBzdHJpY3RcIjtcblxuICAgIGFuZ3VsYXIubW9kdWxlKFwiYXBwLnNlcnZpY2VzXCIpLmZhY3RvcnkoJ0RpYWxvZ1NlcnZpY2UnLCBmdW5jdGlvbiggJG1kRGlhbG9nICl7XG5cbiAgICAgICAgcmV0dXJuIHtcbiAgICAgICAgICAgIGZyb21UZW1wbGF0ZTogZnVuY3Rpb24oIHRlbXBsYXRlLCAkc2NvcGUgKSB7XG5cbiAgICAgICAgICAgICAgICB2YXIgb3B0aW9ucyA9IHtcbiAgICAgICAgICAgICAgICAgICAgdGVtcGxhdGVVcmw6ICcvdmlld3MvZGlhbG9ncy8nICsgdGVtcGxhdGUgKyAnLycgKyB0ZW1wbGF0ZSArICcuaHRtbCdcbiAgICAgICAgICAgICAgICB9O1xuXG4gICAgICAgICAgICAgICAgaWYgKCAkc2NvcGUgKXtcbiAgICAgICAgICAgICAgICAgICAgb3B0aW9ucy5zY29wZSA9ICRzY29wZS4kbmV3KCk7XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgcmV0dXJuICRtZERpYWxvZy5zaG93KG9wdGlvbnMpO1xuICAgICAgICAgICAgfSxcblxuICAgICAgICAgICAgaGlkZTogZnVuY3Rpb24oKXtcbiAgICAgICAgICAgICAgICByZXR1cm4gJG1kRGlhbG9nLmhpZGUoKTtcbiAgICAgICAgICAgIH0sXG5cbiAgICAgICAgICAgIGFsZXJ0OiBmdW5jdGlvbih0aXRsZSwgY29udGVudCl7XG4gICAgICAgICAgICAgICAgJG1kRGlhbG9nLnNob3coXG4gICAgICAgICAgICAgICAgICAgICRtZERpYWxvZy5hbGVydCgpXG4gICAgICAgICAgICAgICAgICAgIC50aXRsZSh0aXRsZSlcbiAgICAgICAgICAgICAgICAgICAgLmNvbnRlbnQoY29udGVudClcbiAgICAgICAgICAgICAgICAgICAgLm9rKCdPaycpXG4gICAgICAgICAgICAgICAgICAgICk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH07XG4gICAgfSk7XG59KSgpOyIsIihmdW5jdGlvbigpe1xuICAgIFwidXNlIHN0cmljdFwiO1xuXG4gICAgYW5ndWxhci5tb2R1bGUoXCJhcHAuc2VydmljZXNcIikuZmFjdG9yeSgnVG9hc3RTZXJ2aWNlJywgZnVuY3Rpb24oICRtZFRvYXN0ICl7XG5cbiAgICAgICAgdmFyIGRlbGF5ID0gNjAwMCxcbiAgICAgICAgcG9zaXRpb24gPSAndG9wIHJpZ2h0JyxcbiAgICAgICAgYWN0aW9uID0gJ09LJztcblxuICAgICAgICByZXR1cm4ge1xuICAgICAgICAgICAgc2hvdzogZnVuY3Rpb24oY29udGVudCkge1xuICAgICAgICAgICAgICAgIHJldHVybiAkbWRUb2FzdC5zaG93KFxuICAgICAgICAgICAgICAgICAgICAkbWRUb2FzdC5zaW1wbGUoKVxuICAgICAgICAgICAgICAgICAgICAuY29udGVudChjb250ZW50KVxuICAgICAgICAgICAgICAgICAgICAucG9zaXRpb24ocG9zaXRpb24pXG4gICAgICAgICAgICAgICAgICAgIC5hY3Rpb24oYWN0aW9uKVxuICAgICAgICAgICAgICAgICAgICAuaGlkZURlbGF5KGRlbGF5KVxuICAgICAgICAgICAgICAgICAgICApO1xuICAgICAgICAgICAgfVxuICAgICAgICB9O1xuICAgIH0pO1xufSkoKTsiXSwic291cmNlUm9vdCI6Ii9zb3VyY2UvIn0=
