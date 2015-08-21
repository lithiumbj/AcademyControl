@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<section class="content-header">
  <h1>
    Dashboard
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

<div class="row">

  <div class="col-md-8">
    <!-- Box -->
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Alumnos actuales</h3>
      </div><!-- /.box-header -->
      <div class="box-body no-padding">

      </div><!-- /.box-body -->
    </div>
    <!-- //Box -->
  </div>

  <div class="col-md-4">
    <!-- Box -->
    <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">Facturas vencidas (5 días)</h3>
      </div><!-- /.box-header -->
      <div class="box-body no-padding">

      </div><!-- /.box-body -->
    </div>
    <!-- //Box -->
  </div>

  <div class="col-md-4">
    <!-- Box -->
    <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">Facturas vencidas (10 días)</h3>
      </div><!-- /.box-header -->
      <div class="box-body no-padding">

      </div><!-- /.box-body -->
    </div>
    <!-- //Box -->
  </div>

  <div class="col-md-4">
    <!-- Box -->
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Ingresos mensuales</h3>
      </div><!-- /.box-header -->
      <div class="box-body no-padding">

      </div><!-- /.box-body -->
    </div>
    <!-- //Box -->
  </div>

  <div class="col-md-4">
    <!-- Box -->
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Deuda actual</h3>
      </div><!-- /.box-header -->
      <div class="box-body no-padding">

      </div><!-- /.box-body -->
    </div>
    <!-- //Box -->
  </div>

</div>
</section>
@stop
