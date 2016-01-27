@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<?php

use App\Helpers\SettingsHelper;
use App\Models\Company;
?>
<section class="content-header">
    <h1>
        Ajustes del sistema
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Ajustes</a></li>
        <li class="active">generales</li>
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
                <div class="box-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs pull-right">
                            <li class="active"><a href="#tab_1" data-toggle="tab">Multi-empresa</a></li>
                            <li><a href="#tab_2" data-toggle="tab">Licencia</a></li>

                            <li class="pull-left header"><i class="fa fa-cogs"></i> Ajustes</li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">

                                <div class="btn-group">
                                    @if(SettingsHelper::fetchSetting('multi-company') == '' || SettingsHelper::fetchSetting('multi-company') == 0)
                                    <button type="button" class="btn btn-success" disabled="disabled">I</button>
                                    <button type="button" class="btn btn-default">O</button>
                                    @endif
                                </div>
                                Estado del sistema multi-empresa
                                <hr/>
                                <h4>Empresas del grupo</h4>
                                <table class='table table-bordered'>
                                    <thead>
                                        <tr>
                                            <td>Nombre</td>
                                            <td>Description</td>
                                            <td>DNI</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(Company::fetchCompanies() as $company)
                                        <tr>
                                            <td>{{$company->name}}</td>
                                            <td>{{$company->description}}</td>
                                            <td>{{$company->cif}}</td>
                                            <td></td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td><input class='form-control' id="company_name" placeholder="Nombre de la empresa"/></td>
                                            <td><input class='form-control' id="company_desc" placeholder="Descripción"/></td>
                                            <td><input class='form-control' id="company_cif" placeholder="CIF"/></td>
                                            <td><button id="createCompanyButton" class="btn btn-xs btn-success" onclick='createCompany(jQuery("#company_name").val(), jQuery("#company_desc").val(), jQuery("#company_cif").val())'><i class='fa fa-plus'></i> Crear nueva empresa</button></td>
                                        </tr>   
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_2">
                                Su licencia es de tipo
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success" disabled="disabled">Basic</button>
                                    <button type="button" class="btn btn-success" disabled="disabled">Advanced</button>
                                    <button type="button" class="btn btn-success">Premium</button>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function createCompany(name, description, cif) {
        //Change the button create
        jQuery("#createCompanyButton").html("Espere...");
        jQuery.ajax({
            url: "{{URL::to('/settings/create_company')}}",
            method: "POST",
            data: {name: name, description: description, cif: cif, _token: "{{csrf_token()}}"}
        }).done(function (data) {
            if (data == 'ok') {
                alert("Recuerde crear un usuario administrador para la nueva empresa, sino no podrá acceder a ella");
                location.reload();
            } else {
                alert("Ha ocurrido un error al crear la compañía, verifique que todos los datos son correctos");
                jQuery("#createCompanyButton").html("<i class='fa fa-plus'></i> Crear nueva empresa");
            }
        }).fail(function () {
            alert("Ha ocurrido un error al crear la compañía, verifique que todos los datos son correctos");
            jQuery("#createCompanyButton").html("<i class='fa fa-plus'></i> Crear nueva empresa");
        });
    }
</script>

@stop
