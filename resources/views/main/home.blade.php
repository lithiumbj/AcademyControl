@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<?php
use App\Models\Client;
use App\Models\Invoice;
?>
<section class="content-header">
  <h1>
    Dashboard
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

<div class="row">

  <div class="col-md-8">
    <!-- Box -->
    <div class="box box-success ">
      <div class="box-header with-border">
        <h3 class="box-title">Alumnos actuales</h3>
        <div class="box-settings pull-right">
          <small class="label pull-right bg-green">{{count(Client::getClients())}}</small>
        </div>
      </div><!-- /.box-header -->
      <div class="box-body no-padding scrollable-box">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Apellidos</th>
              <th>Teléfono</th>
            </tr>
          </thead>
          <tbody>
            @foreach(Client::getClients() as $client)
            <tr>
              <td>{{$client->name}}</td>
              <td>{{$client->lastname_1 .' '.$client->lastname_2}}</td>
              <td>{{$client->phone_parents}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div><!-- /.box-body -->
    </div>
    <!-- //Box -->
  </div>

  <div class="col-md-4">
    <!-- Box -->
    <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">Facturas vencidas (5 días)</h3>
        <div class="box-settings pull-right">
          <small class="label pull-right bg-green">{{count(Invoice::get5DaysInvoices())}}</small>
        </div>
      </div><!-- /.box-header -->
      <div class="box-body no-padding scrollable-box">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Referencia</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Importe</th>
              </tr>
            </thead>
            <tbody>
              @foreach(Invoice::get5DaysInvoices() as $invoice)
              <tr>
                <td>{{$invoice->facnumber}}</td>
                <td>{{Client::getClientName($invoice->fk_client)}}</td>
                <td>{{date('Y/m/d', strtotime($invoice->date_creation))}}</td>
                <td>{{$invoice->total}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
      </div><!-- /.box-body -->
    </div>
    <!-- //Box -->
  </div>

</div>

<div class="row">

  <div class="col-md-4">
    <!-- Box -->
    <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">Facturas vencidas (10 días)</h3>
        <div class="box-settings pull-right">
          <small class="label pull-right bg-green">{{count(Invoice::get5DaysInvoices())}}</small>
        </div>
      </div><!-- /.box-header -->
      <div class="box-body no-padding scrollable-box">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Referencia</th>
                  <th>Cliente</th>
                  <th>Fecha</th>
                  <th>Importe</th>
                </tr>
              </thead>
              <tbody>
                @foreach(Invoice::get5DaysInvoices() as $invoice)
                <tr>
                  <td>{{$invoice->facnumber}}</td>
                  <td>{{Client::getClientName($invoice->fk_client)}}</td>
                  <td>{{date('Y/m/d', strtotime($invoice->date_creation))}}</td>
                  <td>{{$invoice->total}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
      </div><!-- /.box-body -->
    </div>
    <!-- //Box -->
  </div>

  <div class="col-md-4">
    <!-- Box -->
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Ingresos mensuales</h3>
      </div><!-- /.box-header -->
      <div class="box-body no-padding">

      </div><!-- /.box-body -->
    </div>
    <!-- //Box -->
  </div>

  <div class="col-md-4">
    <!-- Box -->
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Deuda actual</h3>
      </div><!-- /.box-header -->
      <div class="box-body no-padding">

      </div><!-- /.box-body -->
    </div>
    <!-- //Box -->
  </div>

</div>
</section>
@stop
