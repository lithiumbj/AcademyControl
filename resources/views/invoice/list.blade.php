@extends('template')
<!-- Content Header (Page header) -->
<?php
use App\Models\Client;
?>
@section('content')
<section class="content-header">
  <h1>
    Recibos
    <small>Listado</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Recibos</a></li>
    <li class="active">Listado</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3>Listado de facturas / recibos</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
          <div class="box-body">
      <table class="table table-bordered">
        <thead>
          <tr>
            <td>Referencia</td>
            <td>Cliente</td>
            <td>Fecha</td>
            <td>Importe</td>
            <td>Estado</td>
            <td>Acciones</td>
          </tr>
        </thead>
        <tbody>
          @foreach($invoices as $invoice)
          <tr>
            <td>{{$invoice->facnumber}}</td>
            <td><a href="{{URL::to('/client/view/'.$invoice->fk_client)}}">{{Client::getClientName($invoice->fk_client)}}</a></td>
            <td>{{date('Y/m/d',strtotime($invoice->date_creation))}}</td>
            <td>{{$invoice->total}}</td>
            <td class="center">
              @if($invoice->status == 0)
                <small class="label bg-default">Borrador</small>
              @endif
              @if($invoice->status == 1)
                <small class="label bg-yellow">Impagada</small>
              @endif
              @if($invoice->status == 2)
                <small class="label bg-green">Pagada</small>
              @endif
              @if($invoice->status == 3)
                <small class="label bg-red">Abandonada / Adeudada</small>
              @endif
            </td>
            <td class="center">
              <button class="btn btn-xs btn-success">Pagar</button><br/>
              <button class="btn btn-xs btn-danger">Abandonar</button><br/>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  </div>

</section>
@stop
