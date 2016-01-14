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
                    <div class="col-md-8" id="selectors">

                    </div>
                    <div class="col-md-1">
                        <select class="form-control" id="serviceCondition" onchange="getAjax()">
                            <option value="AND">Y</option>
                            <option value="OR">O</option>
                        </select>
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
                                <th>Fecha</th>
                                <th>Empleado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">

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

    };
    var datatable;
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
        //Download the info
        getAjax();
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
        //Download the info
        getAjax();
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

    /*
     * Download the info to put into the table
     */
    function getAjax()
    {
        if (services.length > 0) {
            jQuery.ajax({
                method: "POST",
                url: "{{URL::to('/stats/clients_by_service')}}",
                data: {data: services, _token: "{{csrf_token()}}", condition: jQuery("#serviceCondition").val()}
            }).done(function (data) {
                //reload the grid
                reloadGrid(JSON.parse(data));
            }).fail(function () {
                alert("Error al obtener los datos");
            }).always(function () {
            });
        } else {
            reloadGrid([]);
        }
    }
    /*
     * Reloads the grid (table) with the new data 
     */
    function reloadGrid(data)
    {
        //Destroy table
        if (datatable != null) {
            datatable.destroy();
        }
        jQuery("#tbody").html("");
        for (var i = 0; i < data.length; i++) {
            console.log(data[i]);
            jQuery("#tbody").append("<tr><td>" + data[i].name + "</td><td>" + data[i].lastname_1 + " " + data[i].lastname_2 + "</td><td>" + data[i].city + "</td><td>" + data[i].phone_parents + "</td><td>" + data[i].address + "</td><td>" + data[i].created_at + "</td><td>" + data[i].username + "</td><td>--</td></tr>");
        }
        //Set the datatable
        datatable = jQuery("#clientsTable").DataTable({
            dom: 'Bfrtip',
            retrieve: true,
            buttons: [
                'excel', 'pdf'
            ]
        });
    }
</script>

@stop
