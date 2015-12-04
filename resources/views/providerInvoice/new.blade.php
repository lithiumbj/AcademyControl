@extends('template')
<!-- Content Header (Page header) -->
<?php
use App\Models\Client;
?>
@section('content')
<section class="content-header">
  <h1>
    Factura de proveedor
    <small>Registrar</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Factura de proveedor</a></li>
    <li class="active">Registrar</li>
  </ol>
</section>

<!-- Main content -->
<section class="content" id="invoice-container" ng-controller="InvoiceController as invoice">
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Crear nuevo </h3>
      <div class="box-tools pull-right">
        <button class="btn btn-success btn-xs" ng-click="invoice.createInvoice()"><i class="fa fa-floppy-o"></i> Guardar</button>
        <a class="btn btn-danger btn-xs" href="{{URL::to('/provider_invoice')}}"><i class="fa fa-minus"></i> Descartar</a>
      </div>
    </div><!-- /.box-header -->
    <div class="box-body">
      <div class="row">

        <div class="col-md-3">
          <table class="table table-bordered">
            <tr>
              <td style="width:175px;">Base imponible</td>
              <td><% invoice.bi %> <b>€</b></td>
            </tr>
            <tr>
              <td>IVA</td>
              <td><% invoice.iva %> <b>€</b></td>
            </tr>
            <tr>
              <td>Total</td>
              <td><% invoice.total %> <b>€</b></td>
            </tr>
            <tr>
              <td>Nota pública</td>
              <td><input type="text" class="form-control" ng-model="invoice.note_public"/></td>
            </tr>
            <tr>
              <td>Fecha de la factura</td>
              <td><input type="text" id="facDate" value="{{date('Y-m-d')}}" class="form-control" ng-model="invoice.currDate"/></td>
            </tr>
          </table>
        </div>

        <div class="col-md-9">
          <table class="table table-bordered">
            <tr>
              <td style="width:300px;"></td>
              <td><b>Datos del proveedor</b></td>
            </tr>
            <tr>
                <td style="width:300px;">Nombre </td>
                <td>{{$provider->name}}</td>
              </tr>
            <tr>
              <td>Apellidos</td>
              <td>{{$provider->lastname_1}} {{$provider->lastname_2}}</td>
            </tr>
            <tr>
              <td>DNI / NIF</td>
              <td>{{$provider->nif}}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>

    <!-- Lines -->
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Lineas del recibo / factura </h3>
        <div class="box-tools pull-right">
        </div>
      </div><!-- /.box-header -->
      <div class="box-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <td>Referencia</td>
              <td>Descripción</td>
              <td style="width: 130px;">Base imponible</td>
              <td style="width: 80px;">IVA</td>
              <td style="width: 80px;">Total</td>
              <td style="width: 115px;"></td>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="(keyLine, line) in invoice.lines">
              <td><% line.prod_name %></td>
              <td><% line.prod_description %></td>
              <td><% line.tax_base %> <b>€</b></td>
              <td><% line.tax %> <b>%</b></td>
              <td><% line.tax_base + (line.tax_base * (line.tax/100)) %> <b>€</b></td>
              <!-- actions -->
              <td>
                  <button class="btn btn-danger btn-xs" ng-click="invoice.deleteLine(keyLine)"><i class="fa fa-trash"></i></button>
              </td>
              <!-- //actions -->
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Lines adder -->
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Añadir nuevas lineas </h3>
        <div class="box-tools pull-right">
        </div>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="row">

          <!-- Product selector -->
          <div class="col-md-9">
            Producto / Servicio <br/>
            <input type="text" class="form-control" ng-model="invoice.concept"/>
          </div>
          <!-- //Product selector -->

          <!-- Product price changer -->
          <div class="col-md-1">
            Base imponible <br/>
            <input class="form-control" ng-model="invoice.tmpPrice" type="text"/>
          </div>
          <!-- //Product price changer -->

          <!-- Product price changer -->
          <div class="col-md-1">
            IVA (%) <br/>
            <input class="form-control" ng-model="invoice.tmpIVA" type="text"/>
          </div>
          <!-- //Product price changer -->

          <!-- Product buttons -->
          <div class="col-md-1">
            <br/>
            <button class="btn btn-success pull-right" ng-click="invoice.addLine()"><i class="fa fa-plus"></i> Agregar</button>
          </div>
          <!-- //Product buttons -->

          <!-- Product info -->
          <div class="col-md-12">
            Descripción / Nota que aparecerá en el recibo <br/>
            <textarea class="form-control" ng-model="invoice.tmpDescription"></textarea>
          </div>
          <!-- //Product info -->
        </div>
      </div>
    </div>
    <!-- init zone -->
    <!-- //init zone -->
</section>
<style>
.select2{
  margin-top: 3px;
}
</style>
<script>
  var _csrf = "{{csrf_token()}}";
  var _getProductDetails = "{{URL::to('/services/ajaxGetProductInfo')}}";
  var _createInvoice = "{{URL::to('/provider_invoice/create')}}";
  var _fk_client = "{{$provider->id}}";
  var _invoice_detail = "{{URL::to('/provider_invoice/')}}";
</script>
<script src="{{URL::to('/angular/invoiceProvider.js')}}"></script>
@stop
