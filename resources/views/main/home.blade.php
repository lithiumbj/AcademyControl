@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<?php
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceProvider;
use App\Models\InvoicePayment;
use App\Models\ClientIncidence;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\StatsController;
?>
<section class="content-header">
  <h1>
    Inicio
    <small>KPI's</small>
  </h1>
</section>

<!-- Main content -->
<section class="content">
@if(count(InvoiceController::getUnDueClientsForMonth()) > 4)
<div class="row animated flash">
    <div class="col-md-12 col-lg-12 col-xs-12">
        <div class="alert alert-info alert-dismissible">
          <h4><i class="icon fa fa-warning"></i> ¡Atención!</h4>
          Existen {{count(InvoiceController::getUnDueClientsForMonth())}} clientes sin factura en este periodo de facturación, ¿Esto es correcto? <a href="{{URL::to('/client/undue')}}"><i class="fa fa-eye"></i> <b>Ver</b></a>
        </div>
    </div>
</div>
@endif
@if(ClientIncidence::getIncidencesCount() > 0)
<div class="row animated flash">
    <div class="col-md-12 col-lg-12 col-xs-12">
        <div class="alert alert-warning alert-dismissible">
          <h4><i class="icon fa fa-warning"></i> ¡Atención!</h4>
          Existen {{ClientIncidence::getIncidencesCount()}} incidencias sobre alumnos abiertas en estos momentos <a href="{{URL::to('/incidence/client')}}"><i class="fa fa-eye"></i> <b>Ver</b></a>
        </div>
    </div>
</div>
@endif
@if(count(StatsController::fetchIncompleteClients())>0)

<div class="row animated flash">
    <div class="col-md-12 col-lg-12 col-xs-12">
        <div class="alert alert-danger alert-dismissible">
          <h4><i class="icon fa fa-users"></i> ¡Atención!</h4>
          Existen {{count(StatsController::fetchIncompleteClients())}} fichas de alumnos sin completar <a href="{{URL::to('/stats/incomplete_clients')}}"><i class="fa fa-eye"></i> <b>Ver</b></a>
        </div>
    </div>
</div>
@endif

@if(count(ClientController::getClientsWithoutServices()) > 4)
<div class="row animated flash">
    <div class="col-md-12 col-lg-12 col-xs-12">
        <div class="alert alert-info alert-dismissible">
          <h4><i class="icon fa fa-warning"></i> ¡Atención!</h4>
          Existen {{count(ClientController::getClientsWithoutServices())}} o más clientes sin servicios asignados en estos momentos, ¿Esto es correcto? <a href="{{URL::to('/client/noService')}}"><i class="fa fa-eye"></i> <b>Ver</b></a>
        </div>
    </div>
</div>
@endif

@if(count(Invoice::get60DaysInvoices())>0)

<div class="row animated flash">
    <div class="col-md-12 col-lg-12 col-xs-12">
        <div class="alert alert-danger alert-dismissible">
          <h4><i class="icon fa fa-money"></i> ¡Atención!</h4>
          Existen {{count(Invoice::get60DaysInvoices())}} Factura/as impagadas con más de dos meses de retraso en estos momentos <a href="{{URL::to('/invoice')}}"><i class="fa fa-eye"></i> <b>Ver</b></a>
        </div>
    </div>
</div>
@endif
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
      <div class="box-body scrollable-box">
        <table class="table table-bordered" id="clientsTable">
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
              <td><a href="{{URL::to('/client/view/'.$client->id)}}">{{$client->name}}</a></td>
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
      <div class="box-body scrollable-box">
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
                <td><a href="{{URL::to('/invoice/'.$invoice->id)}}">{{$invoice->facnumber}}</a></td>
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

  <div class="col-md-7">
    <!-- Box -->
    <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">Facturas vencidas (10 días)</h3>
        <div class="box-settings pull-right">
          <small class="label pull-right bg-green">{{count(Invoice::get10DaysInvoices())}}</small>
        </div>
      </div><!-- /.box-header -->
      <div class="box scrollable-box">
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
                @foreach(Invoice::get10DaysInvoices() as $invoice)
                <tr>
                  <td><a href="{{URL::to('/invoice/'.$invoice->id)}}">{{$invoice->facnumber}}</a></td>
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

    <div class="col-md-5">
      <!-- Box -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title" style="width:100%;">Flujo de dinero
              <br/>
              <i style="font-size: 12px;color:gray">Leyenda de colores: </i>
              <small class="btn btn-xs" style="background-color:#e74c3c;color:white;float:right;margin-left:5px;">Gastos</small>
              <small class="btn btn-xs" style="background-color:#e67e22;color:white;float:right;margin-left:5px;">Deuda</small>
              <small class="btn btn-xs" style="background-color:#2ecc71;color:white;float:right;margin-left:5px;">Ingresos</small>
              <small class="btn btn-xs" style="background-color:#3498db;color:white;float:right;margin-left:5px;">Facturado</small>
          </h3>
        </div><!-- /.box-header -->
        <div class="box-body" id="graphBoxBody">
          <canvas id="monthlyMoney" width="100%" height="250"></canvas>
        </div><!-- /.box-body -->
      </div>
      <!-- //Box -->
    </div>

</div>
<div class="row">

  <div class="col-md-4">
    <!-- Box -->
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Deuda actual</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="info-box">
          @if(InvoicePayment::getDue()>0)
            <span class="info-box-icon bg-red"><i class="fa fa-thumbs-o-down"></i></span>
          @else
            <span class="info-box-icon bg-green"><i class="fa fa-thumbs-o-up"></i></span>
          @endif
          <div class="info-box-content">
            <span class="info-box-text">A dia de hoy se adeuda</span>
            <span class="info-box-number">{{InvoicePayment::getDue()}}€</span>
          </div><!-- /.info-box-content -->
        </div>
      </div><!-- /.box-body -->
    </div>
    <!-- //Box -->
  </div>

  <div class="col-md-4">
    <!-- Box -->
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Matriculas activas</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="fa fa-certificate"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Servicios contratados hoy</span>
            <span class="info-box-number">{{ServicesController::getTotalLinkedServices()}} Servicios</span>
          </div><!-- /.info-box-content -->
        </div>
      </div><!-- /.box-body -->
    </div>
    <!-- //Box -->
  </div>

  <div class="col-md-4">
    <!-- Box -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Alumnos sin facturas
          <a href="{{URL::to('/client/undue')}}" class="btn btn-xs btn-success" style="float:rigth;"><i class="fa fa-eye"></i> Ver</a>
        </h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="info-box">
          <span class="info-box-icon bg-blue"><i class="fa fa-odnoklassniki"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Alumnos sin factura</span>
            <span class="info-box-number">{{count(InvoiceController::getUnDueClientsForMonth())}} Alumnos</span>
          </div><!-- /.info-box-content -->
        </div>
      </div><!-- /.box-body -->
    </div>
    <!-- //Box -->
  </div>

</div>
</section>
<script>
window.onload = function()
{
  jQuery("#clientsTable").dataTable({
    "iDisplayLength": 100
  });

  /*
   * Chartjs
   */
   var options = {//Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero : true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines : true,
        //String - Colour of the grid lines
        scaleGridLineColor : "rgba(0,0,0,.05)",
        //Number - Width of the grid lines
        scaleGridLineWidth : 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,
        //Boolean - If there is a stroke on each bar
        barShowStroke : true,
        //Number - Pixel width of the bar stroke
        barStrokeWidth : 2,
        //Number - Spacing between each of the X value sets
        barValueSpacing : 5,
        //Number - Spacing between data sets within X values
        barDatasetSpacing : 1,
    };
    //Options array
   var data = {
      labels: [
        @foreach(InvoicePayment::getMonthlyMoney() as $month)
        <?php
            switch($month->month){
              case 1:
                  echo '"Enero",';
                  break;
              case 2:
                  echo '"Febrero",';
                  break;
              case 3:
                  echo '"Marzo",';
                  break;
              case 4:
                  echo '"Abril",';
                  break;
              case 5:
                  echo '"Mayo",';
                  break;
              case 6:
                  echo '"Junio",';
                  break;
              case 7:
                  echo '"Julio",';
                  break;
              case 8:
                  echo '"Agosto",';
                  break;
              case 9:
                  echo '"Septiembre",';
                  break;
              case 10:
                  echo '"Octubre",';
                  break;
              case 11:
                  echo '"Noviembre",';
                  break;
              case 12:
                  echo '"Diciembre",';
                  break;
            }
        ?>
        @endforeach
      ],
      datasets: [

          {
              label: "Facturado",
              fillColor: "rgba(52, 152, 219,0.3)",
              strokeColor: "rgba(52, 152, 219,1.0)",
              highlightFill: "rgba(52, 152, 219,1.0)",
              highlightStroke: "rgba(41, 128, 185,1.0)",
              data: [
                  @foreach(Invoice::getMonthlyInvoiced() as $money)
                    "{{$money->total}}",
                  @endforeach
              ]
          },
          {
              label: "Ingresos",
              fillColor: "rgba(46, 204, 113,0.3)",
              strokeColor: "rgba(46, 204, 113,1.0)",
              highlightFill: "rgba(46, 204, 113,1.0)",
              highlightStroke: "rgba(220,220,220,1)",
              data: [
                  @foreach(InvoicePayment::getMonthlyMoney() as $money)
                    "{{$money->total}}",
                  @endforeach
              ]
          },
          {
              label: "Deuda",
              fillColor: "rgba(230, 126, 34, 0.3)",
              strokeColor: "rgba(211, 84, 0,1.0)",
              highlightFill: "rgba(211, 84, 0,1.0)",
              highlightStroke: "rgba(230, 126, 34,1.0)",
              data: [
                  @foreach(Invoice::getMonthlyInvoiced() as $money)
                    @foreach(InvoicePayment::getMonthlyMoney() as $due)
                        @if($money->year == $due->year)
                            @if($money->month == $due->month)
                                "{{$money->total - $due->total}}",
                            @endif
                        @endif
                    @endforeach
                  @endforeach
              ]
          },
          {
              label: "Gastos",
              fillColor: "rgba(231, 76, 60, 0.3)",
              strokeColor: "rgba(231, 76, 60,1.0)",
              highlightFill: "rgba(231, 76, 60,1.0)",
              highlightStroke: "rgba(220,220,220,1)",
              data: [
                  @foreach(InvoiceProvider::getMonthlyMoney() as $money)
                    "{{$money->total}}",
                  @endforeach
              ]
          }
      ]
    };
    //Start the chart
    jQuery("#monthlyMoney").width(jQuery("#graphBoxBody").width());
    jQuery("#monthlyMoney").height("250px");
    var ctx = document.getElementById("monthlyMoney").getContext("2d");
    var myLineChart = new Chart(ctx).Bar(data, options);
    }
</script>
@stop
