@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<?php
use App\Helpers\DateHelper;
use App\Http\Controllers\RoomController;
?>

@foreach($rawData as $data)
<section class="content-header invoice-unit">
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Factura</a></li>
    <li class="active">{{$data['invoice']->facnumber}}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Recibo</h3>
        </div><!-- /.box-header -->
        <div class="box-body">

            <div class="col-md-6">
              <table class="table table-bordered">
                <tr>
                  <td>Estado</td>
                  <td>
                    @if($data['invoice']->status == 0)
                      <small class="label bg-default">Borrador</small>
                    @endif
                    @if($data['invoice']->status == 1)
                      <small class="label bg-yellow">Impagada</small>
                    @endif
                    @if($data['invoice']->status == 2)
                      <small class="label bg-green">Pagada</small>
                    @endif
                    @if($data['invoice']->status == 3)
                      <small class="label bg-red">Abandonada / Adeudada</small>
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>Nota</td>
                  <td>{{$data['invoice']->text_public}}</td>
                </tr>
                <tr>
                  <td>Fecha de pago</td>
                  @if(count($data['payments'])>0)
                    <td>{{date('d/m/Y H:i:s',strtotime($data['payments'][count($data['payments'])-1]->created_at))}}</td>
                  @else
                    <td>Sin pagos registrados</td>
                  @endif
                </tr>
                <tr>
                  <td>Importe total</td>
                  <td><b>{{$data['invoice']->total}}€</b></td>
                </tr>
              </table>
            </div>
            <!-- Client details -->
            <div class="col-md-6">
              <table class="table table-bordered">
                <tr>
                  <td style="width:300px;">Nombre</td>
                  <td>{{$data['client']->name}}</td>
                </tr>
                <tr>
                  <td>Apellidos</td>
                  <td>{{$data['client']->lastname_1}} {{$data['client']->lastname_2}}</td>
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
          <h3 class="box-title">Conceptos del recibo</h3>
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
              @foreach($data['lines'] as $line)
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
<hr class="hr-break"/>
@endforeach
<style>
.main-header, .main-sidebar, .breadcrumb, .btn, .main-footer{
  display: none;
}
.content-wrapper{
  margin-left: 0px !important;
}
.hr-break{
  page-break-before: always !important;
  clear :both !important
}
</style>
@stop
