@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<section class="content-header">
  <h1>
    Proveedores
    <small>Crear</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Proveedores</a></li>
    <li class="active">Crear</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">

    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Datos del proveedor</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{URL::to('/provider/create')}}">
          {!! csrf_field() !!}
          <div class="box-body">

            <!-- Error zone -->
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- Error zone end -->

            <p class="text-right"><i>Los elementos marcados con un <b>*</b> son de carácter obligatorio</i></p>

            <div class="form-group col-md-4">
              <label >Nombre *</label>
              <input class="form-control" name="name" type="text">
            </div>

            <div class="form-group col-md-4">
              <label >Primer apellido *</label>
              <input class="form-control"  name="lastname_1"  type="text">
            </div>

            <div class="form-group col-md-4">
              <label >Segundo apellido</label>
              <input class="form-control"  name="lastname_2"  type="text">
            </div>

            <div class="form-group col-md-4">
              <label >DNI / NIF / Pasaporte</label>
              <input class="form-control"  name="nif"  type="text">
            </div>


            <div class="form-group col-md-4">
              <label >Dirección postal *</label>
              <input class="form-control" value="C/"  name="address"  type="text">
            </div>

            <div class="form-group col-md-4">
              <label >Población</label>
              <input class="form-control" value="Benetússer"  name="poblation"  type="text">
            </div>

            <div class="form-group col-md-4">
              <label >Ciudad</label>
              <input class="form-control" value="Valencia"  name="city" type="text">
            </div>

            <div class="form-group col-md-4">
              <label >Código postal</label>
              <input class="form-control" value="46910"  name="cp"  type="text">
            </div>

            <div class="form-group col-md-4">
              <label >Teléfono</label>
              <input class="form-control"  name="phone_parents"  type="phone">
            </div>

            <div class="form-group col-md-4">
              <label >Correo electrónico</label>
              <input class="form-control"  name="email"  type="email">
            </div>

            <div class="form-group col-md-12">
              <label >Más información de contacto</label>
              <textarea class="form-control"  name="other_address_info"></textarea>
            </div>
          </div>
          <div class="row">
            <div class="center"><button type="submit" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Crear</button></div>
          </div>
          </div><!-- /.box-body -->

        </form>
      </div>
    </div>

  </div>
</section>
@stop
