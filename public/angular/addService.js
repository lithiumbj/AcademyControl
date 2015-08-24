function startAddServiceApp()
{
  var services = angular.module('services', [], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    });

  services.controller('ServiceController', function ($scope, $http, $timeout, $interval) {
      //PHP Headers fix
      $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
      $http.defaults.headers.post['X-CSRF-Token'] = _csrf;
      //PHP Headers fix END//

      this.step = 1;
      this.currService = 0;
      this.workingOn = false;
      this.selected = false;
      //Tmp variables
      this.concept;
      this.price;
      this.iva;
      this.martricula;
      this.fk;

      /*
       * This function sets the step to 2
       */
      this.goToStep2 = function()
      {
        this.step = 2;
      };

      /*
       * This function sets the service basic data into a temporary variable
       *
       * @param {String} concept - The concept (word) to invoice
       * @param {Float} price - The monthly price
       * @param {Float} iva - The VAT
       * @param {Float} matricula - The first payment price
       * @param {Integer} fk - The service's id
       */
      this.setData = function(concept, price, iva, matricula, fk)
      {
        this.selected = true;
        this.concept = concept;
        this.iva = iva;
        this.price = price;
        this.matricula = matricula;
        this.fk = fk;
      };

      /*
       * (Final step) Writes the service into the service-user tupla
       *
       * @param {Boolean} payMatricula - If true the system will generate a invoice and a due for the matricula
       */
      this.addService = function(payMatricula)
      {
        //Show spinner
        this.workingOn = true;
        //Do the quest
        $http.post(_addServiceUrl, {fk_client : _client, fk_service : this.fk, matricula : payMatricula}).
          then(angular.bind(this, function(response) {
            //Ok
            this.workingOn = false;
            if(response.data.result == 'ok'){
              //Reload the page to load the new data
              location.reload();
            }else{
              alert("Error al registrar el servicio al cliente, se ha guardado inormación sobre el fallo en el log, póngase en contacto con atención técnica");
            }
          })), angular.bind(this, function(response) {
            //Error
              alert("Error al registrar el servicio al cliente, se ha guardado inormación sobre el fallo en el log, póngase en contacto con atención técnica");
              this.workingOn = false;
          });
      }
  });
  //Bootstrap the controller
  angular.bootstrap(angular.element("#addService")[0], ['services']);
}
