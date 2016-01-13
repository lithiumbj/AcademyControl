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
        <small>Clientes por servicio</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Estadísticas</a></li>
        <li class="active">Clientes por servicio</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Selector de datos</h3>
                    <div class="box-tools pull-right">
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body center">
                    <div class="col-md-9" id="selectors">

                    </div>
                    <div class="col-md-2">
                        <select class="form-control" id="serviceSelector">
                            @foreach($services as $service)
                            <option value="{{$service->id}}">{{$service->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-success" onclick="setService()"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                                <th>Ciudad</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Tipo</th>
                                <th>Fecha</th>
                                <th>Empleado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                    En desarrollo...
                </div>
            </div>
        </div>
    </div>
</section>

<script>

    window.onload = function ()
    {

    };
    var services = [];
    /*
     * Adds the service to the services array and reload's the view
     * 
     * @param {type} id
     * @param {type} name
     */
    function addService(id, name)
    {
        var srv = {id: id, name: name};
        services.push(srv);
        //refresh the gui
        refreshGUI();
    }

    /*
     * Reloads the top-level gui
     */
    function refreshGUI()
    {
        jQuery("#selectors").html("");
        for (var i = 0; i < services.length; i++) {
            jQuery("#selectors").append('<a class="btn btn-app" onclick="deleteService(' + i + ')"><span class="badge bg-red">X</span><i class="fa fa-bullhorn"></i>' + services[i].name + '</a>');
        }
    }

    /*
     * De-link's a service 
     */
    function deleteService(id)
    {
        var backup = services;
        services = [];
        for (var i = 0; i < backup.length; i++) {
            if (i != id)
                services.push(backup[i]);
        }
        //Reload the top-level gui
        refreshGUI();
    }

    /*
     * Goes to the GUI to set the service
     */
    function setService()
    {
        var id = jQuery("#serviceSelector").val();
        var name = jQuery("#serviceSelector option:selected").text();
        //add to the array
        addService(id, name);
    }
</script>

@stop
