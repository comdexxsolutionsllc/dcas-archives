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