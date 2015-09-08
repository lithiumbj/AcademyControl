@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<?php

use App\Helpers\DateHelper;
use App\Http\Controllers\RoomController;
use App\Models\Provider;
use App\Models\InvoiceProvider;
?>
<section class="content-header">
    <h1>
        Cliente
        <small>{{$model->name}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Proveedor</a></li>
        <li class="active">{{$model->name}}</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">

        <div class="col-md-12">
            <div class="box box-primary collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{$model->name .' '.$model->lastname_1.' '.$model->lastname_2}}</h3>

                    <div class="box-tools pull-right">
                        <a class="btn btn-box-tool" href="{{URL::to('/provider_invoice/create/'.$model->id)}}"><i class="fa fa-money"></i> Registrar factura</a>
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i> Mas detalles</button>
                    </div>

                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{URL::to('/provider/update')}}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="{{$model->id}}"/>
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

                        <div class="form-group col-md-4">
                            <label >Nombre *</label>
                            <br/>
                            <i>{{$model->name}}</i>
                        </div>

                        <div class="form-group col-md-4">
                            <label >Primer apellido *</label>
                            <br/>
                            <i>{{$model->lastname_1}}</i>
                        </div>

                        <div class="form-group col-md-4">
                            <label >Segundo apellido</label>
                            <br/>
                            <i>{{$model->lastname_2}}</i>
                        </div>

                        <div class="form-group col-md-4">
                            <label >DNI / NIF / Pasaporte</label>
                            <br/>
                            <i>{{$model->nif}}</i>
                        </div>

                        <div class="form-group col-md-4">
                            <label >Dirección postal *</label>
                            <br/>
                            <i>{{$model->address}}</i>
                        </div>

                        <div class="form-group col-md-4">
                            <label >Población</label>
                            <br/>
                            <i>{{$model->poblation}}</i>
                        </div>

                        <div class="form-group col-md-4">
                            <label >Ciudad</label>
                            <br/>
                            <i>{{$model->city}}</i>
                        </div>

                        <div class="form-group col-md-4">
                            <label >Código postal</label>
                            <br/>
                            <i>{{$model->cp}}</i>
                        </div>

                        <div class="form-group col-md-4">
                            <label >Teléfono</label>
                            <br/>
                            <i>{{$model->phone}}</i>
                        </div>

                        <div class="form-group col-md-4">
                            <label >Correo electrónico</label>
                            <br/>
                            <i>{{$model->email}}</i>
                        </div>

                        <div class="form-group col-md-12">
                            <label >Más información de contacto</label>
                            <br/>
                            <i>{{$model->other_address_info}}</i>
                        </div>
                        <div class="center form-group col-md-12" >
                            <a type="submit" class="btn btn-warning btn-xs" href="{{URL::to('/provider/update/'.$model->id)}}"><i class="fa fa-pencil"></i> Modificar estos datos</a>
                        </div>
                    </div><!-- /.box-body -->

                </form>
            </div>
        </div>

    </div>


    <!-- 2nd row -->
    <div class="row">

        <!-- Abonos box -->
        <div class="col-md-6 col-md-offset-3">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Facturas de proveedor</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Ref</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(InvoiceProvider::getInvoices($model->id) as $invoice)
                            <tr>
                                <td><a href="{{URL::to('/provider_invoice/'.$invoice->id)}}">{{$invoice->facnumber}}</a></td>
                                <td>{{DateHelper::getDate($invoice->date_creation)}}</td>
                                <td>{{$invoice->total}}</td>
                                <td class="center">
                                    <!-- Not validated yet -->
                                    @if($invoice->status == 0)
                                    <small class="label bg-gray">Borrador</small>
                                    @endif
                                    <!-- Unpaid -->
                                    @if($invoice->status == 1)
                                    <small class="label bg-yellow">Impagada</small>
                                    @endif
                                    <!-- payed -->
                                    @if($invoice->status == 2)
                                    <small class="label bg-green">Pagada</small>
                                    @endif
                                    <!-- Abandoned -->
                                    @if($invoice->status == 3)
                                    <small class="label bg-red">Adeudada / Abandonada</small>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- //Abonos box -->
    </div>

    <!--- Modals zone -->
    @include('client.modals.addService')
    @include('client.modals.enrolRoom')
    <!--- //Modals zone -->
</section>
@stop
