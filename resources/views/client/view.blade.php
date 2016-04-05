@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<?php

use App\Helpers\DateHelper;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\IncidenceController;
use App\Http\Controllers\ServicesController;
use App\Models\Client;
?>
<section class="content-header">
    <h1>
        Cliente
        <small>{{$model->name}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Cliente</a></li>
        <li class="active">{{$model->name}}</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">

        <div class="col-md-12">
            <div class="box box-primary @if($model->status == 1) collapsed-box @endif">
                <div class="box-header with-border">
                    <h3 class="box-title">{{$model->name .' '.$model->lastname_1.' '.$model->lastname_2}}</h3>

                    @if($model->status == 1)
                    <div class="box-tools pull-right">
                        <a class="btn btn-box-tool" href="{{URL::to('/invoice/create/'.$model->id)}}"><i class="fa fa-money"></i> Crear recibo</a>
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i> Mas detalles</button>
                        <button class="btn btn-box-tool" data-toggle="modal" data-target="#modalIncidence" onclick="prepareIncidence({{$model->id}})"><i class="fa fa-exclamation-triangle"></i> Emitir incidencia</button>
                    </div>
                    @endif

                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{URL::to('/client/update')}}">
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

                        <p class="text-right"><i>Los elementos marcados con un <b>*</b> son de carácter obligatorio</i></p>

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
                            <label >Nombre del padre / madre</label>
                            <br/>
                            <i>{{$model->parent_name}}</i>
                        </div>

                        <div class="form-group col-md-4">
                            <label >1º Apellido de padre / madre</label>
                            <br/>
                            <i>{{$model->parent_lastname_1}}</i>
                        </div>

                        <div class="form-group col-md-4">
                            <label >2º Apellido de padre / madre</label>
                            <br/>
                            <i>{{$model->parent_lastname_2}}</i>
                        </div>

                        <div class="form-group col-md-4">
                            <label >DNI / NIF / Pasaporte del padre / madre</label>
                            <br/>
                            <i>{{$model->parent_nif}}</i>
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
                            <label >¿Que ha ocurrido con el cliente? *</label>
                            <select class="form-control" name="status" disabled="disabled">
                                <option value="0" @if($model->status == 0) selected="selected" @endif>Ha solicitado información</option>
                                <option value="1" @if($model->status == 1) selected="selected" @endif>Nueva matricula</option>
                                <option value="2" @if($model->status == 2) selected="selected" @endif>Ex-alumno / Abandonado</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label >¿Como nos ha conocido? *</label>
                            <select class="form-control" name="fk_contact_way" disabled="disabled">
                                @foreach($contactWays as $contactWay)
                                <option value="{{$contactWay->id}}" @if($model->fk_contact_way == $contactWay->id) selected="selected" @endif>{{$contactWay->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label >Teléfono (Padres / Tutores) (Envío de SMS)</label>
                            <br/>
                            <i>{{$model->phone_parents}}</i>
                        </div>

                        <div class="form-group col-md-4">
                            <label >Teléfono del alumno</label>
                            <br/>
                            <i>{{$model->phone_client}}</i>
                        </div>

                        <div class="form-group col-md-4">
                            <label >Teléfono de contacto esencial</label>
                            <br/>
                            <i>{{$model->phone_whatsapp}}</i>
                        </div>

                        <div class="form-group col-md-4">
                            <label >Correo electrónico (Padres / Tutores)</label>
                            <br/>
                            <i>{{$model->email_parents}}</i>
                        </div>

                        <div class="form-group col-md-4">
                            <label >Correo electrónico del alumno</label>
                            <br/>
                            <i>{{$model->email_client}}</i>
                        </div>


                        <div class="form-group col-md-4">
                            <label>Cliente de pago único <i>Esto significa que no se generan recibos cada mes</i></label>
                            <select class="form-control" name="is_subscription" disabled="disabled">
                                <option value="0" @if($model->is_subscription == 0) selected="selected" @endif>No</option>
                                <option value="1" @if($model->is_subscription == 1) selected="selected" @endif>Si</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label >Más información de contacto</label>
                            <br/>
                            <i>{{$model->other_address_info}}</i>
                        </div>
                        <div class="center form-group col-md-12" >
                            <a type="submit" class="btn btn-warning btn-xs" href="{{URL::to('/client/update/'.$model->id)}}"><i class="fa fa-pencil"></i> Modificar estos datos</a>
                        </div>
                    </div><!-- /.box-body -->

                </form>
            </div>
        </div>

    </div>

    @if($model->status == 1)

    <!-- 2nd row -->
    <div class="row">

        <!-- Abonos box -->
        <div class="col-md-4">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Últimos 5 recibos</h3>
                </div>
                <div class="box-body scrollable-box">
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
                            @foreach($invoices as $invoice)
                            <tr>
                                <td><a href="{{URL::to('/invoice/'.$invoice->id)}}">{{$invoice->facnumber}}</a></td>
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
        <!-- Servicios box -->
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Servicios</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-success btn-xs" onclick="startAddServiceApp()" data-toggle="modal" data-target="#addService"><i class="fa fa-plus"></i> Agregar servicio</button>
                        <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#transferService"><i class="fa fa-undo"></i> Transferir servicio</button>
                    </div>
                </div>
                <div class="box-body scrollable-box">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Servicio</th>
                                <th>Desde</th>
                                <th>Hasta</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                            <tr>
                                @if($service->active == 0)
                                <td class="disaledService">{{$service->name}}</td>
                                @else
                                <td>{{$service->name}}</td>
                                @endif
                                <td>{{DateHelper::getDate($service->created_at)}}</td>
                                <td>
                                @if(strlen($service->date_to)>4)
                                    {{DateHelper::getDate($service->date_to)}}
                                @else
                                    Aún activo
                                @endif
                                </td>
                                <td style="width:10px;">
                                @if($service->active == 0)
                                    <a href="{{URL::to('/service/enable/'.$service->id)}}" class="btn btn-xs btn-success pull-right"><i class="fa fa-check-square-o"> Reactivar</i></a>
                                    <br/>
                                    <a style="margin-top:3px;" href="{{URL::to('/service/unlink/'.$service->id)}}" class="btn btn-xs btn-danger pull-right"><i class="fa fa-trash"></i> Eliminar</a>
                                @else
                                    <a onclick="alert('¡¡ATENCIÓN!!\n\nRecuerde que al desactivar el servicio no se borran las asignaciones de horarios, debe liberar los grupos de forma manual')" href="{{URL::to('/service/disable/'.$service->id)}}" class="btn btn-xs btn-default pull-right"><i class="fa fa-ban"></i> Desactivar</a>
                                @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- //Servicios box -->

    </div>
    <!-- //2nd row -->

    <!-- 3rd row -->
    <div class="row">
        
        <!-- Horario box -->
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Horario</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#calendarCheckModal">Consultar disponibilidad</button>
                        <i>Leyenda:</i> &nbsp;
                        <small class="label pull-right bg-red" style="margin-right: 5px;">Grupo lleno</small>&nbsp;
                        <small class="label pull-right bg-yellow" style="margin-right: 5px;">Grupo casi lleno</small>&nbsp;
                        <small class="label pull-right bg-green" style="margin-right: 5px;">Grupo libre</small>&nbsp;
                        <small class="label pull-right bg-blue" style="margin-right: 5px;">Alumno en este grupo</small>
                    </div>
                </div>
                <div class="box-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            @foreach($services as $service)
                            <li><a href="#tab_{{$service->id}}" data-toggle="tab">{{$service->name}}</a></li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach($services as $service)
                            <div class="tab-pane" id="tab_{{$service->id}}">
                                <!-- Horario -->
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td style="width:54px;"></td>
                                            <td style="width: 16%;">Lunes</td>
                                            <td style="width: 16%;">Martes</td>
                                            <td style="width: 16%;">Miércoles</td>
                                            <td style="width: 16%;">Jueves</td>
                                            <td style="width: 16%;">Viernes</td>
                                            <td style="width: 16%;">Sábado</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for($i=10;$i < 22; $i++)
                                        <tr>
                                            <td>
                                                @if($i<17)
                                                <b>{{$i}}:00</b>
                                                @endif
                                                @if($i >= 17 && $i < 18)
                                                <b>{{$i}}:15</b>
                                                @endif
                                                @if($i > 17)
                                                <b>{{$i}}:30</b>
                                                @endif
                                            </td>
                                            @for($a = 1; $a < 7; $a++)
                                            <td class="center">
                                                @if(count(RoomController::getRoomsForService($service->serviceId, $i, $a))>0)
                                                @foreach(RoomController::getRoomsForService($service->serviceId, $i, $a) as $roomService)
                                                @if(count(RoomController::isClientEnroled($roomService->id, $model->id))>0)
                                                <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#delinkRoom" onclick="delinkModal({{$model->id}}, {{$roomService->id}}, {{$a}}, {{$i}})">Alumno en este grupo ({{RoomController::getRoomOcupance($roomService->id, $a, $i)}} / {{(RoomController::getCapacity($roomService->id))}})</button>
                                                @else
                                                <!-- Free occupance -->
                                                @if(($roomService->capacity - RoomController::getRoomOcupance($roomService->id, $a, $i)) > 2)
                                                <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#enrolRoomModal" onclick="enrolModal({{$model->id}}, {{$roomService->id}}, {{$a}}, {{$i}})">Grupo Libre ({{RoomController::getRoomOcupance($roomService->id, $a, $i)}} / {{(RoomController::getCapacity($roomService->id))}})</button>
                                                @else
                                                <!-- Mid occupance -->
                                                @if(($roomService->capacity - RoomController::getRoomOcupance($roomService->id, $a, $i)) <= 2 && ($roomService->capacity - RoomController::getRoomOcupance($roomService->id, $a, $i)) > 0)
                                                <button class="btn btn-xs btn-warning"data-toggle="modal" data-target="#enrolRoomModal" onclick="enrolModal({{$model->id}}, {{$roomService->id}}, {{$a}}, {{$i}})">Grupo casi lleno ({{RoomController::getRoomOcupance($roomService->id, $a, $i)}} / {{(RoomController::getCapacity($roomService->id))}})</button>
                                                @else
                                                <!-- Full! -->
                                                @if(($roomService->capacity - RoomController::getRoomOcupance($roomService->id, $a, $i)) == 0)
                                                <button class="btn btn-xs btn-danger" onclick="alert('Este grupo está leno, tendrá que escoger otro')">Grupo lleno</button>
                                                @endif
                                                <!-- //Full! -->
                                                @endif
                                                <!-- //Mid occupance -->
                                                @endif
                                                @endif
                                                @endforeach
                                                @endif
                                            </td>
                                            @endfor
                                        </tr>
                                        @endfor
                                    </tbody>
                                </table>
                                <!-- //Horario -->
                            </div><!-- /.tab-pane -->
                            @endforeach
                        </div><!-- /.tab-content -->
                    </div>
                </div>
            </div>
        </div>
        <!-- //Horario box -->
        
        <!-- Faltas box -->
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Faltas / incidencias</h3>
                </div>
                <div class="box-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab">Faltas</a></li>
                            <li><a href="#tab_2" data-toggle="tab">Incidencias</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                @if(count(IncidenceController::fetchAssitanceList($model->id))>0)
                                <table class="table table-bordered" id="assistanceTable">
                                    <thead>
                                        <tr>
                                            <td>Fecha</td>
                                            <td>Clase</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(IncidenceController::fetchAssitanceList($model->id) as $assistence)
                                        <tr>
                                            <td>{{date('d/m/Y', strtotime($assistence->created_at))}}</td>
                                            <td><i class="fa fa-circle-o text-red"></i> {{ServicesController::fetchServiceFromFkRoomReserve($assistence->fk_room_reserve)->name}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <div class="info-box bg-green">
                                    <span class="info-box-icon"><i class="ion ion-ios-heart-outline"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">¡Sin ninguna falta de asistencia!</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                    </div><!-- /.info-box-content -->
                                </div>
                                @endif
                            </div><!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_2">
                                @if(count(IncidenceController::fetchClientIncidences($model->id))>0)
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Resumen</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(IncidenceController::fetchClientIncidences($model->id) as $incidence)
                                        <tr>
                                            <td>{{$incidence->concept}}</td>
                                            <td>{{date('d/m/Y', strtotime($incidence->created_at))}}</td>
                                            <td class="center">
                                                @if($incidence->seen == 1)
                                                <small class="label bg-green">Resuelto</small>
                                                @else
                                                <small class="label bg-red">Pendiente</small>
                                                @endif
                                            </td>
                                            <td style="width:70px;">
                                                <button class="btn btn-success btn-xs" onclick="alert('Incidencia completa: \n\n{{$incidence->observations}}')"><i class="fa fa-eye"></i></button>
                                                <a class="btn btn-warning btn-xs" href="{{URL::to('/incidence/client/complete/'.$incidence->id)}}"><i class="fa fa-mail-reply-all"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <div class="info-box bg-green">
                                    <span class="info-box-icon"><i class="ion ion-ios-heart-outline"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">¡Sin ninguna incidencia!</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                    </div><!-- /.info-box-content -->
                                </div>
                                @endif
                            </div><!-- /.tab-pane -->
                        </div><!-- /.tab-content -->
                    </div>
                </div>
            </div>
        </div>
        <!-- //Faltas box -->
    </div>
    <!-- //3rd row -->
    <script>
                var _client = {{$model->id}};
    </script>
    @else
    <div class="callout callout-warning">
        <h4>¿Más datos?</h4>
        <p>No se pueden asignar ni consultar horarios, incidencias o recibos pendientes para clientes que no son alumnos</p>
    </div>
    <button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#calendarCheckModal">Consultar disponibilidad de horarios</button>
    @endif
    <!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="calendarCheckModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Disponibilidad de horarios</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default color-palette-box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-tag"></i> Consultar horarios</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                Seleccione un servicio para consultar el horario:
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" onchange="reloadServicesOffer(jQuery('#serviceCalendarSelector').val())" id="serviceCalendarSelector">
                                    <option value="--">N/A</option>
                                    @foreach($servicesOffer as $srv)
                                    <option value="{{$srv->id}}">{{$srv->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12 col-lg-12">
                                <iframe id="frameCalendar" style="width: 100%;min-height: 450px;">

                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
        </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
    <!--- Modals zone -->
    @include('client.modals.addService')
    @include('client.modals.enrolRoom')
    @include('teacher.modals.incidence')
    <!--- //Modals zone -->
</section>
<script>
    function reloadServicesOffer(fk_service){
        jQuery("#frameCalendar").attr('src', 'about:blank');
        jQuery("#frameCalendar").attr('src', '{{URL::to("/client/calendar")}}/'+fk_service);
    }
</script>
@stop
