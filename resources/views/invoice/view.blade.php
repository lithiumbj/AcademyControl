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
            <a href="{{URL::to('/invoice/print/'.$invoice->id)}}" class="btn btn-xs btn-primary"><i class="fa fa-print"></i> Imprimir</a>
            @if($invoice->status != 2)
            <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#paybox"><i class="fa fa-money"></i> Pagar</button>
            @else
              <a href="{{URL::to('/invoice/unpay/'.$invoice->id)}}" class="btn btn-xs btn-warning"><i class="fa fa-trash"></i> Eliminar pago</a>
            @endif
            <a href="{{URL::to('/invoice/delete/'.$invoice->id)}}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Eliminar factura</a>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="col-md-6">
            <table class="table table-bordered">
              <tr>
                <td style="width:300px;">Referencia</td>
                <td>{{$invoice->facnumber}}</td>
              </tr>
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
                <td id="notePrivateTxt">{{$invoice->text_private}} <button onclick="jQuery('#notePrivateTxt').hide();jQuery('#notePrivateTd').show();" class="btn btn-xs btn-default pull-right"><i class="fa fa-pencil"></i></button></td>
                <td id="notePrivateTd" style="display:none;">
                    <form action="{{URL::to('/invoice/update_private_note')}}" method="post">
                       {!! csrf_field() !!}
                       <input type="hidden" name="id" value="{{$invoice->id}}"/>
                       <input type="text" class="form-control tdFormControl" value="{{$invoice->text_private}}" name="txt"/> <button class="btn btn-xs btn-success" type="submit"><i class="fa fa-save"></i></button>
                   </form>
                </td>
              </tr>
              <tr>
                <td>Nota publica</td>
                <td id="notePublicTxt">{{$invoice->text_public}} <button onclick="jQuery('#notePublicTxt').hide();jQuery('#notePublicTd').show();" class="btn btn-xs btn-default pull-right"><i class="fa fa-pencil"></i></button></td>
                <td id="notePublicTd" style="display:none">
                    <form action="{{URL::to('/invoice/update_public_note')}}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" value="{{$invoice->id}}"/>
                        <input type="text" class="form-control tdFormControl" value="{{$invoice->text_public}}" name="txt"/> <button class="btn btn-xs btn-success" type="submit"><i class="fa fa-save"></i></button>
                    </form>
                </td>
              </tr>
              <tr>
                <td>Fecha de creación</td>
                <td>{{date('d/m/Y',strtotime($invoice->date_creation))}}</td>
              </tr>
              <tr>
                <td>Fecha de pago</td>
                @if(count($payments)>0)
                  <td>{{date('d/m/Y H:i:s',strtotime($payments[count($payments)-1]->created_at))}}</td>
                @else
                  <td>Sin pagos registrados</td>
                @endif
              </tr>
              @if($invoice->status == 1)
              <tr>
                <td>Falta por pagar</td>
                <?php
                $totalToPay = 0;
                foreach($payments as $payment){
                    $totalToPay += $payment->total;
                }
                ?>
                <td>{{$invoice->total - $totalToPay}}€</td>
              </tr>
              @endif
              <tr>
                <td>Importe total</td>
                <td>{{$invoice->total}}€</td>
              </tr>
            </table>
          </div>
          <!-- Client details -->
          <div class="col-md-6">
            <table class="table table-bordered">
              <tr>
                <td style="width:300px;">Nombre de padre / madre</td>
                <td>{{$client->parent_name}}</td>
              </tr>
              <tr>
                <td>Apellidos de padre / madre</td>
                <td>{{$client->parent_lastname_1}} {{$client->parent_lastname_2}}</td>
              </tr>
              <tr>
                <td>DNI de padre / madre</td>
                <td>{{$client->parent_nif}}</td>
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
@include('invoice.modals.paybox')
@stop
