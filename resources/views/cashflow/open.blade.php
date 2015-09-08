@extends('template')
<!-- Content Header (Page header) -->
<?php
use App\Models\Client;
use App\Http\Controllers\CashflowController;
?>
@section('content')
<section class="content-header">
  <h1>
    Caja
    <small>Apertura de caja</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Caja</a></li>
    <li class="active">Apertura de caja</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          Apertura de caja
          <div class="box-tools pull-right">
          </div>
        </div><!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6 col-md-offset-3">
              <form action="{{URL::to('/cashflow/open')}}" method="post">
                {!! csrf_field() !!}

                <div class="form-group" style="height: 55px;">
                  <label class="col-sm-4 control-label">Importe (+/-)</label>
                  <div class="col-sm-8">
                    <input class="form-control" placeholder="Cantidad" name="value" value="{{CashflowController::getArrastre()}}" type="text">
                    <p>Se calcula automáticamente el arrastre con respecto a los días anteriores</p>
                  </div>
                </div>

                <div class="center">
                  <button type="submit" class="btn btn-xs btn-warning"><i class="fa fa-save"></i> Abrir caja</button>
                </div>

              </form>
            </div>
          </div>
        </div>
        </div>
        </div>
        </div>
      </section>
@stop
