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
      this.concept = '';
      this.tmpPrice = 0;
      this.tmpDescription = '';
      this.tmpIVA = 0.0;
      this.note_public = '';
      this.currDate;
      //total Variables
      this.iva = 0.0;
      this.bi = 0.0;
      this.total = 0.0;

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
       * This function adds a new line to the invoice
       */
      this.addLine = function()
      {
        var line = {
          "tax_base" : parseInt(this.tmpPrice),
          "prod_name" : this.concept,
          "prod_description" : this.tmpDescription,
          "tax" : parseInt(this.tmpIVA)
        };
        this.lines.push(line);
        //recalculate the totals
        this.recalculateTotals();
      };
      
      /*
       * Deletes the line
       */
      this.deleteLine = function(fk_line)
      {
          var backup = this.lines;
          this.lines = [];
          for(var i=0; i < backup.length; i++){
              if(i != fk_line)
                  this.lines.push(backup[i]);
          }
      };

      /*
       * This function creates a new invoice and sends to the server
       */
       this.createInvoice = function()
       {
         $http.post(_createInvoice, {fk_provider : _fk_client, lines : this.lines, note: this.note_public, date : this.currDate}).
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
  jQuery("#facDate").datepicker({
      format : 'yyyy-mm-dd'
  });
}
