@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<?php
use App\Helpers\DateHelper;
use App\Http\Controllers\RoomController;
?>
<section class="content-header">
  <h1>
    Estadísticas
    <small>Informaciones a clientes</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Estadísticas</a></li>
    <li class="active">Informaciones a clientes</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Gráfica por meses</h3>
          <div class="box-tools pull-right">
          </div>
        </div><!-- /.box-header -->
        <div class="box-body center">
          <canvas id="myChart" width="800" height="500"></canvas>
        </div>
      </div>
    </div>
  </div>
</section>

<script>

window.onload = function()
{
  var options = {
    scaleShowGridLines : true,
    scaleGridLineColor : "rgba(0,0,0,.05)",
    scaleGridLineWidth : 1,
    scaleShowHorizontalLines: true,
    scaleShowVerticalLines: true,
    bezierCurve : true,
    bezierCurveTension : 0.4,
    pointDot : true,
    pointDotRadius : 4,
    pointDotStrokeWidth : 1,
    pointHitDetectionRadius : 20,
    datasetStroke : true,
    datasetStrokeWidth : 2,
    datasetFill : true,
};

  var data = {
      labels: [
        @foreach($data as $month)
          "{{$month->year}} - {{$month->month}}",
        @endforeach
      ],
      datasets: [
          {
              label: "Nuevos clientes por meses",
              fillColor: "rgba(220,220,220,0.2)",
              strokeColor: "rgba(220,220,220,1)",
              pointColor: "rgba(220,220,220,1)",
              pointStrokeColor: "#fff",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(220,220,220,1)",
              data: [
                @foreach($data as $month)
                  "{{$month->count}}",
                @endforeach
              ]
          }
      ]
  };
  // Get context with jQuery - using jQuery's .get() method.
  var ctx = $("#myChart").get(0).getContext("2d");
  var myLineChart = new Chart(ctx).Line(data, options);
};
</script>

@stop
