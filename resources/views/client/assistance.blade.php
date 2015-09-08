@extends('template')
<!-- Content Header (Page header) -->
<?php
use App\Models\Client;
use App\Http\Controllers\ServicesController;
?>
@section('content')
<section class="content-header">
  <h1>
    Incidencias
    <small>Faltas de alumnos</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Incidencias</a></li>
    <li class="active">Faltas de alumnos</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Listado </h3>
      <div class="box-tools pull-right">
      </div>
    </div><!-- /.box-header -->
    <div class="box-body">
      <table class="table table-bordered" id="assistanceTable">
        <thead>
          <tr>
            <td style="width: 100px;">Nº incidencia</td>
            <td>Alumno</td>
            <td>Fecha</td>
            <td>Clase</td>
          </tr>
        </thead>
        <tbody>
          @foreach($incidences as $incidence)
          <tr>
            <td>{{$incidence->id}}</td>
            <td><a href="{{URL::to('/client/view/'.$incidence->fk_client)}}">{{Client::getClientName($incidence->fk_client)}}</a></td>
            <td>{{date('d/m/Y', strtotime($incidence->created_at))}}</td>
            <td><i class="fa fa-circle-o text-red"></i> {{ServicesController::fetchServiceFromFkRoomReserve($incidence->fk_room_reserve)->name}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>
<script>

/*
 * At load, set the datatable
 */
window.onload = function()
{
  jQuery("#assistanceTable").dataTable({
    "iDisplayLength": 100
  });
}
</script>
@stop
