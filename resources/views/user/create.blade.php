@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<?php
use App\Models\Company;
?>
<section class="content-header">
    <h1>
        Empleados
        <small>Crear</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> ></a></li>
        <li class="active">Crear</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">

        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Formulario de creación</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{URL::to('/user/create')}}">
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

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nombre y apellidos</label>
                                    <input class="form-control" placeholder="" type="text" name="name">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" placeholder="" type="text" name="email">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Contraseña (plano)</label>
                                    <input class="form-control" placeholder="" type="text" name="password">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Rol que desempeñará</label>
                                    <select name="fk_role" class="form-control">
                                        <option value="1">Administrador</option>
                                        <option value="2">Administración</option>
                                        <option value="3">Recepción</option>
                                        <option value="4">Profesor</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Dirección postal</label>
                                    <input class="form-control" placeholder="" type="text" name="address">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Código postal</label>
                                    <input class="form-control" placeholder="" type="text" name="cp">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Población</label>
                                    <input class="form-control" placeholder="" type="text" name="poblation">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>DNI</label>
                                    <input class="form-control" placeholder="" type="text" name="nif">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Empresa</label>
                                    <select name="fk_company" class="form-control">
                                        @foreach(Company::fetchCompanies() as $company)
                                        <option value="{{$company->id}}">{{$company->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 center">
                                <hr/>
                                <button type="submit" class="btn btn-xs btn-success center"><i class="fa fa-plus"></i> Crear</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@stop