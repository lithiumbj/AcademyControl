@extends('template')
<!-- Content Header (Page header) -->
<?php
use App\Models\Provider;
?>
@section('content')
<section class="content-header">
  <h1>
    Facturas de proveedor
    <small>Listado</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Facturas de proveedor</a></li>
    <li class="active">Listado</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          Listado de facturas / recibos
          <div class="box-tools pull-right">
            <button href="{{URL::to('/invoice/massiveprint')}}" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#massivePrintModal"><i class="fa fa-print"></i> Impresión masiva</button>
          </div>
        </div><!-- /.box-header -->
        <!-- form start -->
          <div class="box-body">
      <table class="table table-bordered" id="invoiceList">
        <thead>
          <tr>
            <td>Nota / Ref</td>
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
            <td>{{$invoice->text_private}}</td>
            <td><a href="{{URL::to('/provider/view/'.$invoice->fk_provider)}}">{{Provider::getProviderName($invoice->fk_provider)}}</a></td>
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
            <td class="center" style="width: 250px;">
              <a href="{{URL::to('/provider_invoice/'.$invoice->id)}}" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
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
  jQuery("#invoiceList").dataTable({
    "iDisplayLength": 100
  });
  startDatePickerListeners();
}
</script>
@include('invoice.modals.massiveprint')
@stop
