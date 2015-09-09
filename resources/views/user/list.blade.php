@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<section class="content-header">
    <h1>
        Empleados
        <small>Listado</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> ></a></li>
        <li class="active">Listado</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">

        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Usuarios / Empleados</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th style="width:30px;">Rol</th>
                                <th style="width:30px;"> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @if($user->fk_role == 0)
                                    <small class="label pull-right">Sin rol</small>
                                    @endif
                                    @if($user->fk_role == 1)
                                    <small class="label pull-right bg-green">Administrador</small>
                                    @endif
                                    @if($user->fk_role == 2)
                                    <small class="label pull-right bg-blue">Administración</small>
                                    @endif
                                    @if($user->fk_role == 3)
                                    <small class="label pull-right bg-yellow">Recepción</small>
                                    @endif
                                    @if($user->fk_role == 4)
                                    <small class="label pull-right bg-red">Profesor</small>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{URL::to('/user/view/'.$user->id)}}" class="btn btn-success btn-xs"><i class="fa fa-eye"></i>/<i class="fa fa-pencil"></i></a>
                                </td>
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