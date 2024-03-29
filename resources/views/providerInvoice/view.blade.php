@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<?php
use App\Helpers\DateHelper;
use App\Http\Controllers\RoomController;
?>
<section class="content-header">
  <h1>
    Factura
    <small>{{$invoice->facnumber}}</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Factura</a></li>
    <li class="active">{{$invoice->facnumber}}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Factura -- {{$invoice->facnumber}}</h3>
          <div class="box-tools pull-right">
            @if($invoice->status != 2)
            <a href="{{URL::to('/provider_invoice/pay/'.$invoice->id)}}" class="btn btn-xs btn-success"><i class="fa fa-money"></i> Pagar</a>
            @else
              <a href="{{URL::to('/provider_invoice/unpay/'.$invoice->id)}}" class="btn btn-xs btn-warning"><i class="fa fa-trash"></i> Eliminar pago</a>
            @endif
            <a href="{{URL::to('/provider_invoice/delete/'.$invoice->id)}}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Eliminar factura</a>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="col-md-6">
            <table class="table table-bordered">
              <tr>
                <td>Estado</td>
                <td>
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
              </tr>
              <tr>
                <td>Nota interna</td>
                <td>{{$invoice->text_private}}</td>
              </tr>
              <tr>
                <td>Nota publica</td>
                <td>{{$invoice->text_public}}</td>
              </tr>
              <tr>
                <td>Fecha de creación</td>
                <td>{{date('d/m/Y',strtotime($invoice->date_creation))}}</td>
              </tr>
              <tr>
                <td>Importe total</td>
                <td>{{$invoice->total + $invoice->tax}}€</td>
              </tr>
            </table>
          </div>
          <!-- Client details -->
          <div class="col-md-6">
            <table class="table table-bordered">
              <tr>
                <td style="width:300px;">Nombre </td>
                <td>{{$client->name}}</td>
              </tr>
              <tr>
                <td>Apellidos / Denominación social</td>
                <td>{{$client->lastname_1}} {{$client->lastname_2}}</td>
              </tr>
              <tr>
                <td>DNI </td>
                <td>{{$client->nif}}</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Lines -->
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Conceptos -- {{$invoice->facnumber}}</h3>
          <div class="box-tools pull-right">
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <td>#</td>
                <td>Producto / Servicio</td>
                <td>Descripción</td>
                <td>Base imponible</td>
                <td>IVA</td>
                <td>Total</td>
              </tr>
            </thead>
            <tbody>
              @foreach($lines as $line)
                <tr>
                  <td>{{$line->fk_service}}</td>
                  <td>{{$line->prod_name}}</td>
                  <td>{{$line->prod_description}}</td>
                  <td>{{$line->tax_base}} €</td>
                  <td>{{$line->tax}} €</td>
                  <td>{{$line->tax_base + $line->tax}} €</td>
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
