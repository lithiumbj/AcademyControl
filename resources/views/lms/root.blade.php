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
        <div class="col-md-12" id="filesContainer">
            <div class="box">
                <div class="box-header with-border">
                    <h3><a href="#" style="color:back;margin-right: 10px;" onclick="goBack()"><i class="fa fa-backward"></i></a>Ficheros</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#newFolderModal"><i class="fa fa-folder"></i> Nueva carpeta</button>
                        <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#newFileModal"><i class="fa fa-file-code-o"></i> Subir archivo</button>
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
        <div class="col-md-4" id="filesDetails" style="display: none;">
            <div class="box">
                <div class="box-header with-border">
                    <h3 id="detailsTitle"></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <hr/>
                    <button class="btn btn-success"><i class="fa fa-cloud-download"></i> Descargar</button>
                    <button class="btn btn-danger"><i class="fa fa-trash"></i> Borrar</button>
                    <button class="btn btn-primary"><i class="fa fa-share"></i> Compartir</button>

                </div><!-- /.box-body -->
            </div>
        </div>
    </div>

</section>

<script>
    var currentPath = null;
    var file = null;
    var tmpData = null;
    var tmpFile = null;
    var navigation = [0];

    /*
     * This function returns to the previous position
     */
    function goBack()
    {
        var backup = navigation;
        //check's to avoid the outOfBoundsException
        if (navigation.length > 1)
            fetchContent(navigation[navigation.length - 1]);
        else
            fetchContent(0);
        //re-generate the navigation array
        navigation = [];
        for (i = 0; i < backup.length - 1; i++) {
            navigation.push(backup[i]);
        }
        //Final check
        if (navigation.length == 0) {
            navigation.push(0);
        }
    }

    /*
     * Fires a AJAX GET request to get the content of a folder
     */
    function fetchContent(path)
    {
        currentPath = path;
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
        tmpData = data;
        jQuery("#whiteZone").html("");
        //First the folders
        for (var i = 0; i < data.folders.length; i++) {
            jQuery("#whiteZone").append('<a class="btn btn-app" onclick="navigateTo(' + data.folders[i].id + ')"><i class="fa fa-folder"></i> ' + data.folders[i].name + ' </a>');
        }
        //After, the files
        for (var i = 0; i < data.files.length; i++) {
            jQuery("#whiteZone").append('<a class="btn btn-app" onclick="showDetails(' + data.files[i].id + ')"><i class="fa fa-file-code-o"></i> ' + data.files[i].name + ' </a>');
        }
    }

    /*
     * Allows to enter into a sub-folder
     * */
    function navigateTo(path)
    {
        fetchContent(path);
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
     * Prepares the file to upload 
     */
    function prepareUpload(event)
    {
        file = event.target.files;
    }
    /*
     * Uploads the file to the server
     * */
    function uploadFile()
    {
        //Show spinner
        jQuery("#uploadProgressBar").show();
        jQuery("#uploadButonMdl").html("Un momento...");
        console.log(currentPath);
        // Create a formdata object and add the files
        var data = new FormData();
        $.each(file, function (key, value)
        {
            data.append(key, value);
        });
        //Add the token and path to the data array
        data.append('_token', "{{csrf_token()}}");
        data.append('parent', currentPath);
        //Send data to the server
        $.ajax({
            url: '{{URL::to("/lms/upload_file")}}',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function (data, textStatus, jqXHR)
            {
                jQuery("#closeModalUploadFile").trigger('click');
                fetchContent(currentPath);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert("Error: "+errorThrown);
            }
        });
        //Hide spinner
        jQuery("#uploadProgressBar").hide();
        jQuery("#uploadButonMdl").html("Subir");
    }
    /*
     * Shows the deails panel
     */
    function showDetails(fileId)
    {
        //Stores the file in a temporal variable for future pourposes
        tmpFile = fileId;
        //Changue the classes to show the sidebar
        jQuery("#filesContainer").removeClass("col-md-12");
        jQuery("#filesContainer").addClass("col-md-8");
        jQuery("#filesDetails").show();
        //set the name to the sidebar
        for (var i = 0; i < tmpData.files.length; i++) {
            if (tmpData.files[i].id = fileId) {
                jQuery("#detailsTitle").html(tmpData.files[i].name);
            }
        }
    }
    /*
     * On-load script
     */
    window.onload = function () {
        fetchContent(null);
        //Upload file input trigger
        jQuery("#fileChooser").on('change', prepareUpload);
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
<!-- Modal -->
<div class="modal fade" id="newFileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Nueva carpeta</h4>
            </div>
            <div class="modal-body">
                <input type="file" id="fileChooser"/>
            </div>
            <div class="modal-footer">
                <!-- Progress bar -->
                <div class="progress progress-sm active" id="uploadProgressBar" style="display:none;">
                    <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                        <span class="sr-only"></span>
                    </div>
                </div>
                <!-- //Progress bar -->
                <button type="button" class="btn btn-default" data-dismiss="modal" id="closeModalUploadFile">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="uploadFile()" id="uploadButonMdl">Subir</button>
            </div>
        </div>
    </div>
</div>

@stop
