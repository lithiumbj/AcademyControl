@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<?php

use App\Helpers\DateHelper;
use App\Http\Controllers\RoomController;
?>
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Factura</a></li>
        <li class="active">{{$invoice->facnumber}}</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-body">
                    <div class="box-header with-border">
                        <h3 class="box-title">Datos del emisor de la factura</h3>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <tr>
                                <td style="width:300px;"><b>Emisor</b></td>
                                <td><i>{{$company->name}}</i></td>
                            </tr>
                            <tr>
                                <td style="width:300px;"><b>CIF/NIF</b></td>
                                <td><i>{{$company->cif}} </i></td>
                            </tr>
                            <tr>
                                <td>Dirección</td>
                                <td>Carrer del palleter, 28, bajo, 46910. Benetusser</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Factura #{{$invoice->facnumber}}</h3>
                    <div class="box-tools pull-right">
                        @if($invoice->status == 0)
                        <small class="label bg-default">Borrador</small>
                        @endif
                        @if($invoice->status == 1)
                        <small class="label bg-yellow">Impagada</small>
                        @endif
                        @if($invoice->status == 2)
                        <small class="label bg-green">Pagada</small>
                        @endif
                        @if($invoice->status == 3)
                        <small class="label bg-red">Abandonada / Adeudada</small>
                        @endif
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">

                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <tr>
                                <td style="width:300px;"><b>Nombre completo</b></td>
                                <td><i>{{$client->name}} {{$client->lastname_1}} {{$client->lastname_2}}</i></td>
                            </tr>
                            <tr>
                                <td style="width:300px;"><b>CIF/NIF</b></td>
                                <td><i>{{$client->nif}} </i></td>
                            </tr>
                            <tr>
                                <td>Fecha de creación</td>
                                <td>{{date('d/m/Y',strtotime($invoice->date_creation))}}</td>
                            </tr>
                            <tr>
                                <td>Fecha de pago</td>
                                @if(count($payments)>0)
                                <td>{{date('d/m/Y H:i:s',strtotime($payments[count($payments)-1]->created_at))}}</td>
                                @else
                                <td>Sin pagos registrados</td>
                                @endif
                            </tr>
                            <tr>
                                <td>Base imponible</td>
                                <td><b>{{$invoice->tax_base}}€</b></td>
                            </tr>
                            <tr>
                                <td>IVA</td>
                                <td><b>{{$invoice->tax}}€</b></td>
                            </tr>
                            <tr>
                                <td>Importe total</td>
                                <td><b>{{$invoice->total}}€</b></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lines -->
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Conceptos de la factura</h3>
                    <div class="box-tools pull-right">
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>Producto / Servicio</td>
                                <td>Descripción</td>
                                <td>Base Imponible</td>
                                <td>IVA</td>                                
                                <td>Total</td>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lines as $line)
                            <tr>
                                <td>{{$line->prod_name}}</td>
                                <td>{{$line->prod_description}}</td>
                                <td>{{$line->tax_base}} €</td>
                                <td>{{$line->tax}} €</td>
                                <td>{{$line->tax_base + $line->tax}} €</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .main-header, .main-sidebar, .breadcrumb, .btn, .main-footer{
        display: none;
    }
    .content-wrapper{
        margin-left: 0px !important;
    }
</style>
@stop
