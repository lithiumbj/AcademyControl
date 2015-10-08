window.onload = function()
{
  var invoice = angular.module('invoice', [], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    });

  invoice.controller('InvoiceController', function ($scope, $http, $timeout, $interval) {
      //PHP Headers fix
      $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
      $http.defaults.headers.post['X-CSRF-Token'] = _csrf;
      //Variables
      this.lines = [];
      this.tmpProduct = 0;
      this.tmpName = '';
      this.tmpPrice = 0;
      this.tmpDescription = '';
      this.tmpIVA = 0.0;
      this.note_public = '';
      this.date = _curr_date;
      //total Variables
      this.iva = 0.0;
      this.bi = 0.0;
      this.total = 0.0;

      /*
       * This function is called when the user select's an product / service in the
       * combobox, it get the details of the product using a webservice
       */
      this.getProductDetails = function()
      {
        $http.post(_getProductDetails, {id: this.tmpProduct}).
        then(angular.bind(this, function(response) {
          //Ok
          this.tmpPrice = response.data.price;
          this.tmpDescription = response.data.description;
          this.tmpName = response.data.name;
          this.tmpIVA = response.data.iva;
        }), function(response) {
          // Ko.
        });
      };

      /*
       * This function recalculate the invoice totals
       */
      this.recalculateTotals = function()
      {
        this.iva = 0.0;
        this.bi = 0.0;
        this.total = 0.0;
        //Iterate all the lines and
        for(var i=0; i < this.lines.length; i++){
          this.iva += this.lines[i].tax;
          this.bi += this.lines[i].tax_base;
          this.total += this.lines[i].tax + this.lines[i].tax_base;
        }
      };
      /*
       * This function deletes the line
       */
      this.deleteLine = function(fk_line)
      {
          var lines = this.lines;
          this.lines = [];
          for(var i=0; i<lines.length; i++){
              if(i!=fk_line)
                  this.lines.push(lines[i]);
          }
      };
      /*
       * This function adds a new line to the invoice
       */
      this.addLine = function()
      {
        var line = {
          "fk_service" : this.tmpProduct,
          "tax_base" : parseInt(this.tmpPrice),
          "prod_name" : this.tmpName,
          "prod_description" : this.tmpDescription,
          "name" : this.tmpName,
          "tax" : parseInt(this.tmpIVA)
        };
        this.lines.push(line);
        //recalculate the totals
        this.recalculateTotals();
      };

      /*
       * This function creates a new invoice and sends to the server
       */
       this.createInvoice = function()
       {
         $http.post(_createInvoice, {fk_client : _fk_client, lines : this.lines, note: this.note_public, date: this.date}).
         then(angular.bind(this, function(response) {
           //Ok
           if(response.data.status != 'ko'){
             window.location = _invoice_detail + "/" + response.data.id;
           }else{
             alert("No se pudo crear la factura, póngase en contacto con administración");
           }
         }), function(response) {
           // Ko.
           alert("No se pudo crear la factura, póngase en contacto con administración");
         });
       };

  });
  //Bootstrap the controller
  angular.bootstrap(angular.element("#invoice-container")[0], ['invoice']);
  //Other jQuery stuff
  jQuery("#serviceSelector").select2();
  jQuery("#invoice_date").datepicker({
      format : 'yyyy-mm-dd'
  });
}
