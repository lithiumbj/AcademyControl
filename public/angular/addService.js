function startAddServiceApp()
{
  var services = angular.module('services', []);

  services.controller('ServiceController', function ($scope, $http, $timeout, $interval) {
      //PHP Headers fix
      $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
      this.step = 1;
      this.currService = 0;
      this.workingOn = false;

      /*
       * Fetch's the session's history and loads into the array
       */

  });
  //Bootstrap the controller
  angular.bootstrap(angular.element("#addService")[0], ['services']);
}
