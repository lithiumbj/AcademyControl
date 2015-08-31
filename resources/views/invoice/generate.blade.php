@extends('template')
<!-- Content Header (Page header) -->
<?php
use App\Models\Client;
?>
@section('content')
<section class="content-header">
  <h1>
    Recibos
    <small>Generar recibos mensuales</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Recibos</a></li>
    <li class="active">Generar recibox mensuales</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h4>Revise la siguiente información</h4>
        </div><!-- /.box-header -->
        <!-- form start -->
          <div class="box-body">
            <p>Este procedimiento va a generar todos los recibos de todos los servicios asociados a todos los clientes activos en el programa a fecha de hoy. <br/>Esto incluye a todos los clientes que se acaben de matricular y ya se les haya cobrado la mensualidad, Academy Control buscará los clientes con recibos emitidos del mes en curso para evitar los duplicados</p>
          </div>
  </div>
  </div>
    <div class="col-md-12">
      <div class="box box-danger">
        <div class="box-header with-border">
          <h4>Clientes con recibos en el mes en curso</h4>
        </div><!-- /.box-header -->
        <!-- form start -->
          <div class="box-body">
            <form action="{{URL::to('/invoice/generate')}}" method="POST">
            {!! csrf_field() !!}
            <p><i>¡ATENCIÓN! estos clientes tienen recibos emitidos este mes, verifique que no se van a duplicar sus recibos</i></p>
            <hr/>
            <div class="row">
      
              <div class="col-md-12" style="margin-top: 20px;">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nota pública</label>
                  <div class="col-sm-8">
                    <input class="form-control" id="note_public" name="note_public" placeholder="Nota..." type="text">
                  </div>
                </div>
              </div>

              <div class="col-md-8 col-md-offset-2">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 32px"></th>
                      <th>Nombre</th>
                      <th>Apellidos</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($clientsWithInvoices as $client)
                    <tr>
                      <td><input type="checkbox" name="client[]" value="{{$client->id}}"></td>
                      <td>{{$client->name}}</td>
                      <td>{{$client->lastname_1}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <p class="center">Seleccione los clientes a ignorar por el generador de recibo, tenga en cuenta de que los recibos para estos clientes no se generarán y deberán ser creados o ajustados de forma manual</p>
            <hr/>
          <a href="{{URL::to('/invoice')}}" class="btn btn-default">Volver a recibos</a>
          <button type="submit" class="pull-right btn btn-warning">Generar recibos</a>
          </form>
        </div>
  </div>
  </div>

</section>
<script>

/*
 * At load, set the datatable
 */
window.onload = function()
{
  jQuery("#invoiceList").dataTable();
}
</script>
@stop
