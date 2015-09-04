@extends('template')
<!-- Content Header (Page header) -->
<?php
use App\Models\Client;
?>
@section('content')
<section class="content-header">
  <h1>
    Incidencias
    <small>Incidencias de alumno</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Incidencias</a></li>
    <li class="active">Incidencias de alumno</li>
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
      <table class="table table-bordered">
        <thead>
          <tr>
            <td style="width: 100px;">Nº incidencia</td>
            <td>Alumno</td>
            <td>Resumen</td>
            <td>Fecha</td>
            <td style="width: 75px;"></td>
          </tr>
        </thead>
        <tbody>
          @foreach($incidences as $incidence)
          <tr>
            <td>{{$incidence->id}}</td>
            <td><a href="{{URL::to('/client/view/'.$incidence->fk_client)}}">{{Client::getClientName($incidence->fk_client)}}</a></td>
            <td>{{$incidence->concept}}</td>
            <td>{{date('d/m/Y', strtotime($incidence->created_at))}}</td>
            <td>
              <button class="btn btn-default btn-xs" onclick="alert('Incidencia completa: \n\n{{$incidence->observations}}')"><i class="fa fa-eye"></i></button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>

@stop
