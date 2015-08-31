@extends('template')
<!-- Content Header (Page header) -->
<?php
use App\Models\Client;
$total = 0;
?>
@section('content')
<section class="content-header">
  <h1>
    Caja
    <small>Cierre de caja</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Caja</a></li>
    <li class="active">Cierre de caja</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          Cierre de caja
          <div class="box-tools pull-right">
          </div>
        </div><!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              @if(count($cashflows)>0)
              <p>Revise todos los movimientos antes de cerrar la caja</p>
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
                        <?php $total+=$cashflow->value;?>
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
                        <td>{{date('d/m/Y h:i:s',strtotime($cashflow->created_at))}}</td>
                      </tr>
                    @endforeach
                      <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align:right;">Balance de caja</td>
                        <td style="text-align:right;"><b>{{$total}} €</b></td>
                        <td></td>
                        <td></td>
                      </tr>
                  </tbody>
                </table>
                <hr/>
                <form action="{{URL::to('/cashflow/close')}}" method="post">
                  {!! csrf_field() !!}

                  <div class="form-group" style="height: 55px;">
                    <label class="col-sm-4 control-label">Concepto</label>
                    <div class="col-sm-8">
                      <input class="form-control" placeholder="Concepto" value="Cierre de caja del día {{date('d/m/Y')}}" name="concept" type="text">
                    </div>
                  </div>
                  <div class="form-group" style="height: 55px;">
                    <label class="col-sm-4 control-label">Importe (+/-)</label>
                    <div class="col-sm-8">
                      <input class="form-control" placeholder="Cantidad" value="{{$total * -1}}" name="value" type="text">
                    </div>
                  </div>
                  <p class="center">Saque el dinero que desee de la caja antes de cerrar</p>
                  <div class="center">
                    <button type="submit" class="btn btn-xs btn-warning"><i class="fa fa-save"></i> Efectuar salida de caja</button>
                  </div>

                </form>
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
        </div>
        </div>
      </section>
@stop
