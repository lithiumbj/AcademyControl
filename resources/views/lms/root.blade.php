@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<section class="content-header">
    <h1>
        Gestor de contenidos
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Gestor de contenidos</a></li>
        <li class="active">Raíz</li>
    </ol>
</section>
<?php

use App\User;
?>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3>Ficheros</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#newFolderModal"><i class="fa fa-folder"></i> Nueva carpeta</button>
                        <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#uploadFileModal"><i class="fa fa-file-code-o"></i> Subir archivo</button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="col-md-4 col-md-offset-4" id="loadingBar">
                        <div class="progress progress-sm active">
                            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                        <p class="center">Un momento...</p>
                    </div>

                    <!-- White zone -->
                    <div class="col-md-12" id="whiteZone">

                    </div>
                    <!-- //White zone -->

                </div><!-- /.box-body -->
            </div>
        </div>
    </div>

</section>

<script>
    var currentPath = null;

    /*
     * Fires a AJAX GET request to get the content of a folder
     */
    function fetchContent(path)
    {
        jQuery("#loadingBar").show();
        //Do the query request
        jQuery.ajax({
            url: "{{URL::to('/lms/fetch')}}/" + path,
            method: "GET",
        }).done(function (data) {
            drawContent(JSON.parse(data));
            jQuery("#loadingBar").hide();
        }).fail(function () {
            alert("Error al establecer contacto con el servidor de LMS, contacte con soporte");
            jQuery("#loadingBar").hide();
        });
    }

    /*
     * Draw's the content into the white space
     */
    function drawContent(data) {
        jQuery("#whiteZone").html("");
        //First the folders
        for (var i = 0; i < data.folders.length; i++) {
            jQuery("#whiteZone").append('<a class="btn btn-app"><i class="fa fa-folder"></i> '+data.folders[i].name+' </a>');
        }
        //After, the files
    }

    /*
     * Creates a new folder in the current path
     * */
    function createFolder(name) {
        jQuery.ajax({
            url: "{{URL::to('/lms/new_folder')}}",
            method: "POST",
            data: {path: currentPath, name: name, _token: "{{csrf_token()}}"}
        }).done(function (data) {
            if (data == 'ok')
                fetchContent(currentPath);
            else
                alert("Error al crear una carpeta, contacte con soporte");
            jQuery("#closeModalCreateFolder").trigger("click");
        }).fail(function () {
            alert("Error al crear una carpeta, contacte con soporte");
            jQuery("#loadingBar").hide();
        });
    }
    /*
     * On-load script
     */
    window.onload = function () {
        fetchContent(null);
    };
</script>

<!-- Modals zone -->

<!-- Modal -->
<div class="modal fade" id="newFolderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Nueva carpeta</h4>
            </div>
            <div class="modal-body">
                Nombre de la carpeta<br>
                <input type="text" class="form-control" id="folderName"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="closeModalCreateFolder">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="createFolder(jQuery('#folderName').val())">Crear</button>
            </div>
        </div>
    </div>
</div>

@stop
