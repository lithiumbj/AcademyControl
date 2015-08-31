@extends('template')
<!-- Content Header (Page header) -->
<?php
use App\Models\Client;
?>
@section('content')
<section class="content-header">
  <h1>
    Caja
    <small>Estado</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Caja</a></li>
    <li class="active">Estado</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          Estado de la caja
          <div class="box-tools pull-right">
          </div>
        </div><!-- /.box-header -->
        <!-- form start -->
          <div class="box-body">
            @if(count($cashflows)>0)
              <table class="table table-bordered" id="cashflowTable">
                <thead>
                  <tr>
                    <th style="width: 120px;">Nº movimiento</th>
                    <th>Concepto</th>
                    <th>Usuario</th>
                    <th>Importe</th>
                    <th>Tipo</th>
                    <th style="width: 120px;">Fecha</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($cashflows as $cashflow)
                    <tr>
                      <td>{{$cashflow->id}}</td>
                      <td>{{$cashflow->concept}}</td>
                      <td>{{Client::getClientName($cashflow->fk_user)}}</td>
                      <td>{{$cashflow->value}} €</td>
                      <td class="center">
                        @if($cashflow->is_open == 1)
                          <small class="label bg-green">Apertura</small>
                        @endif
                        @if($cashflow->is_closed == 1)
                          <small class="label bg-blue">Cierre</small>
                        @endif
                        @if($cashflow->is_closed == 0 && $cashflow->is_open == 0)
                          <small class="label bg-yellow">Movimiento</small>
                        @endif
                      </td>
                      <td>{{date('Y/m/d',strtotime($cashflow->created_at))}}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            @else
            <div class="alert alert-warning alert-dismissable">
              <h4><i class="icon fa fa-warning"></i> No hay movimientos de caja</h4>
                No se muestran resultados por que no se han detectado movimientos de caja desde el ultimo cierre
            </div>
            @endif
          </div>
        </div>
        </div>
        </div>
      </section>
<script>
  window.onload = function()
  {
    jQuery("#cashflowTable").dataTable();
  }
</script>
@stop
