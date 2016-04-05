@extends('template')
<!-- Content Header (Page header) -->
<?php
use App\Models\Client;
?>
@section('content')
<section class="content-header">
  <h1>
    Factura
    <small>Crear nuevo</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Factura</a></li>
    <li class="active">Crear nuevo</li>
  </ol>
</section>

<!-- Main content -->
<section class="content" id="invoice-container" ng-controller="InvoiceController as invoice">
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Crear nuevo --> {{$client->name}} {{$client->lastname_1}} </h3>
      <div class="box-tools pull-right">
        <button class="btn btn-success btn-xs" ng-click="invoice.createInvoice()"><i class="fa fa-floppy-o"></i> Crear factura</button>
        <button class="btn btn-danger btn-xs"><i class="fa fa-minus"></i> Descartar</button>
      </div>
    </div><!-- /.box-header -->
    <div class="box-body">
      <div class="row">

        <div class="col-md-5">
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
                <td>Fecha de factura</td>
                <td><input type="text" name="date" class="form-control" id="invoice_date" ng-model="invoice.date" value="{{date('Y-m-d')}}"/></td>
            </tr>
          </table>
        </div>

        <div class="col-md-7">
          <table class="table table-bordered">
            <tr>
              <td style="width:300px;"></td>
              <td><b>Datos del padre / madre a facturar</b></td>
            </tr>  <tr>
                <td style="width:300px;">Nombre de padre / madre</td>
                <td>{{$client->parent_name}}</td>
              </tr>
            <tr>
              <td>Apellidos de padre / madre</td>
              <td>{{$client->parent_lastname_1}} {{$client->parent_lastname_2}}</td>
            </tr>
            <tr>
              <td>DNI de padre / madre</td>
              <td>{{$client->parent_nif}}</td>
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
              <td><% line.name %></td>
              <td><% line.description %></td>
              <td><% line.tax_base %> <b>€</b></td>
              <td><% line.tax %> <b>€</b></td>
              <td><% line.tax_base + line.tax %> <b>€</b></td>
              <!-- actions -->
              <td>
                  <button class="btn btn-xs btn-danger" ng-click="invoice.deleteLine(keyLine)"><i class="fa fa-trash"></i></button>
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
            <select ng-model="invoice.tmpProduct" id="serviceSelector" class="form-control" ng-change="invoice.getProductDetails()">
              @foreach($services as $service)
                <option value="{{$service->id}}">{{$service->name}}</option>
              @endforeach
            </select>
          </div>
          <!-- //Product selector -->

          <!-- Product price changer -->
          <div class="col-md-2">
            Precio del servicio <br/>
            <input class="form-control" ng-model="invoice.tmpPrice" type="text"/>
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
  var _createInvoice = "{{URL::to('/invoice/ajaxFactureCreate')}}";
  var _fk_client = "{{$client->id}}";
  var _invoice_detail = "{{URL::to('/invoice/')}}";
  var _curr_date = "{{date('Y-m-d')}}";
</script>
<script src="{{URL::to('/angular/invoice.js')}}"></script>
<script src="{{URL::to('/angular/facture.js')}}"></script>
@stop
