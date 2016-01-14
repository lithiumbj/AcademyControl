@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<?php

use App\Helpers\DateHelper;
use App\Http\Controllers\RoomController;
?>
<section class="content-header">
    <h1>
        Estadísticas
        <small>Clientes con ficha incompleta</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Estadísticas</a></li>
        <li class="active">Clientes con ficha incompleta</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Resultados</h3>
                    <div class="box-tools pull-right">
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body center">
                    <table class="table table-bordered" id="clientsTable">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Población</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Fecha</th>
                                <th>Empleado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @foreach($clients as $client)
                            <tr>
                                <td>{{$client->name}}</td>
                                <td>{{$client->lastname_1}} {{$client->lastname_2}}</td>
                                <td>{{$client->poblation}}</td>
                                <td>{{$client->phone_parents}}</td>
                                <td>{{$client->address}}</td>
                                <td>{{date('Y-m-d', strtotime($client->created_at))}}</td>
                                <td>{{$client->username}}</td>
                                <td>
                                    <a class="btn btn-xs btn-success" href="{{URL::to('/client/view/'.$client->id)}}"><i class="fa fa-eye"></i></a>
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

<script>

    window.onload = function ()
    {
        //Set the datatable
        datatable = jQuery("#clientsTable").DataTable({
            dom: 'Bfrtip',
            paging: false,
            retrieve: true,
            buttons: [
                'excel', 'pdf'
            ]
        });
    };
</script>

@stop
