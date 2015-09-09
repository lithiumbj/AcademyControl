@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<?php
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceProvider;
use App\Models\InvoicePayment;
use App\Http\Controllers\ServicesController;
?>
<section class="content-header">
  <h1>
    Inicio
    <small>KPI's</small>
  </h1>
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

  <div class="col-md-4">
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
        <h3 class="box-title">Ingresos mensuales / Gastos mensuales</h3>
      </div><!-- /.box-header -->
      <div class="box-body" id="graphBoxBody">
        <canvas id="monthlyMoney" width="100%" height="250"></canvas>
      </div><!-- /.box-body -->
    </div>
    <!-- //Box -->
  </div>

  <div class="col-md-3">
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

</div>
<div class="row">
  <div class="col-md-3">
    <!-- Box -->
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Matriculas activas</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="fa fa-certificate"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Servicios contratados en este momento</span>
            <span class="info-box-number">{{ServicesController::getTotalLinkedServices()}} Servicios</span>
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
   var options = {
        ///Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines : true,
        //String - Colour of the grid lines
        scaleGridLineColor : "rgba(0,0,0,.05)",
        //Number - Width of the grid lines
        scaleGridLineWidth : 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,
        //Boolean - Whether the line is curved between points
        bezierCurve : true,
        //Number - Tension of the bezier curve between points
        bezierCurveTension : 0.4,
        //Boolean - Whether to show a dot for each point
        pointDot : true,
        //Number - Radius of each point dot in pixels
        pointDotRadius : 4,
        //Number - Pixel width of point dot stroke
        pointDotStrokeWidth : 1,
        //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
        pointHitDetectionRadius : 20,
        //Boolean - Whether to show a stroke for datasets
        datasetStroke : true,
        //Number - Pixel width of dataset stroke
        datasetStrokeWidth : 2,
        //Boolean - Whether to fill the dataset with a colour
        datasetFill : true,
        //String - A legend template
        legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
    };
    //Options array
   var data = {
      labels: [
        @foreach(InvoicePayment::getMonthlyMoney() as $month)
          "{{$month->month}}",
        @endforeach
      ],
      datasets: [
          {
              label: "Ingresos",
              fillColor: "rgba(46, 204, 113,0.3)",
              strokeColor: "rgba(46, 204, 113,1.0)",
              pointColor: "rgba(46, 204, 113,1.0)",
              pointStrokeColor: "#fff",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(220,220,220,1)",
              data: [
                  @foreach(InvoicePayment::getMonthlyMoney() as $money)
                    "{{$money->total}}",
                  @endforeach
              ]
          },
          {
              label: "Gastos",
              fillColor: "rgba(231, 76, 60,0.3)",
              strokeColor: "rgba(231, 76, 60,1.0)",
              pointColor: "rgba(231, 76, 60,1.0)",
              pointStrokeColor: "#fff",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(220,220,220,1)",
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
    jQuery("#monthlyMoney").height("200px");
    var ctx = document.getElementById("monthlyMoney").getContext("2d");
    var myLineChart = new Chart(ctx).Line(data, options);
    }
</script>
@stop
