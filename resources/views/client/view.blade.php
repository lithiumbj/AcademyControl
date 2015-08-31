@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<?php
use App\Helpers\DateHelper;
use App\Http\Controllers\RoomController;
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
              <label >1º Apellido de padre / madre</label>
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
              <label >Teléfono (Padres / Tutores)</label>
              <br/>
              <i>{{$model->phone_parents}}</i>
            </div>

            <div class="form-group col-md-4">
              <label >Teléfono del alumno</label>
              <br/>
              <i>{{$model->phone_client}}</i>
            </div>

            <div class="form-group col-md-4">
              <label >Teléfono de contacto esencial (whatsapp / sms)</label>
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

      <!-- Faltas box -->
      <div class="col-md-4">
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">Faltas / incidencias</h3>
            <small style="margin-left: 25px;"><i>(Últimas 5)</i></small>
          </div>
            <div class="box-body">

            </div>
          </div>
        </div>
        <!-- //Faltas box -->

        <!-- Servicios box -->
        <div class="col-md-4">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Servicios</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-success btn-xs" onclick="startAddServiceApp()" data-toggle="modal" data-target="#addService"><i class="fa fa-plus"></i> Agregar servicio</button>
              </div>
            </div>
              <div class="box-body scrollable-box">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Servicio</th>
                      <th>Contratado desde</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($services as $service)
                    <tr>
                      <td>{{$service->name}}</td>
                      <td>{{DateHelper::getDate($service->created_at)}}</td>
                      <td>
                        <a href="{{URL::to('/service/unlink/'.$service->id)}}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
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
                                      <button class="btn btn btn-primary" data-toggle="modal" data-target="#delinkRoom" onclick="delinkModal({{$model->id}}, {{$roomService->id}}, {{$a}}, {{$i}})">Alumno en este grupo ({{RoomController::getRoomOcupance($roomService->id, $a, $i)}} / {{(RoomController::getCapacity($roomService->id))}})</button>
                                  @else
                                    <!-- Free occupance -->
                                    @if(($roomService->capacity - RoomController::getRoomOcupance($roomService->id, $a, $i)) > 6)
                                    <button class="btn btn btn-success" data-toggle="modal" data-target="#enrolRoomModal" onclick="enrolModal({{$model->id}}, {{$roomService->id}}, {{$a}}, {{$i}})">Grupo Libre ({{RoomController::getRoomOcupance($roomService->id, $a, $i)}} / {{(RoomController::getCapacity($roomService->id))}})</button>
                                    @else
                                    <!-- Mid occupance -->
                                      @if(($roomService->capacity - RoomController::getRoomOcupance($roomService->id, $a, $i)) < 2 && ($roomService->capacity - RoomController::getRoomOcupance($roomService->id, $a, $i)) > 0)
                                        <button class="btn btn btn-warning"data-toggle="modal" data-target="#enrolRoomModal" onclick="enrolModal({{$model->id}}, {{$roomService->id}}, {{$a}}, {{$i}})">Grupo casi lleno ({{RoomController::getRoomOcupance($roomService->id, $a, $i)}} / {{(RoomController::getCapacity($roomService->id))}})</button>
                                      @else
                                        <!-- Full! -->
                                        @if(($roomService->capacity - RoomController::getRoomOcupance($roomService->id, $a, $i)) == 0)
                                          <button class="btn btn btn-danger" onclick="alert('Este grupo está leno, tendrá que escoger otro')">Grupo lleno</button>
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
  @endif
  <!--- Modals zone -->
    @include('client.modals.addService')
    @include('client.modals.enrolRoom')
  <!--- //Modals zone -->
</section>
@stop
