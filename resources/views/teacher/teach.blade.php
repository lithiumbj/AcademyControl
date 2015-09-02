@extends('template')
<!-- Content Header (Page header) -->
<?php
use App\Models\Client;
?>
@section('content')
<section class="content-header">
  <h1>
    Profesor - Su clase
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-7">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Usuarios </h3>
          <div class="box-tools pull-right">
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th style="width: 229px;">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($clients as $client)
              <tr>
                <td>{{$client->name}}</td>
                <td>{{$client->lastname_1}} {{$client->lastname_2}}</td>
                <td class="center">
                  <button class="btn btn-xs btn-success"><i class="fa fa-briefcase"></i> Abrir informe</button>
                  <button class="btn btn-xs btn-warning"><i class="fa fa-bullseye"></i> Emitir incidencia</button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Control de asistencia </h3>
          <div class="box-tools pull-right">
          </div>
        <div class="box-body">
        </div><!-- /.box-header -->
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th style="width: 65px;">¿Asiste?</th>
              </tr>
            </thead>
            <tbody>
              @foreach($clients as $client)
                <tr>
                  <td>{{$client->name}}</td>
                  <td>{{$client->lastname_1}} {{$client->lastname_2}}</td>
                  <td>
                    <a href="" class="btn btn-xs btn-success"><i class="fa fa-thumbs-up"></i></a>
                    <a href="" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
@stop
