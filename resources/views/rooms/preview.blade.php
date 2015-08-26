@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<?php
use App\Helpers\DateHelper;
use App\Http\Controllers\RoomController;
?>
<section class="content-header">
  <h1>
    Horarios
    <small>Clases</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Horarios</a></li>
    <li class="active">Clases</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        @if(count($rooms)>0)
          @foreach($rooms as $room)
            <!-- AulaTag -->
            <li class="@if($fk_room == $room->id) active @endif">
              <a href="#tab_{{$room->id}}" data-toggle="tab">{{$room->name}} <span class="label label-success label-room pull-right">{{$room->capacity}}</span></a>
            </li>
            <!-- //AulaTag -->
          @endforeach
        @else
        <!-- There's no aula -->
        <li class="active">
          <a href="#" data-toggle="tab">No hay aulas, cree una con el botón de la derecha</a>
        </li>
        <!-- //There's no aula -->
        @endif
        <li class="pull-right"><a href="#" data-toggle="modal" data-target="#newRoomModal" class="text-muted"><i class="fa fa-plus"></i> Agregar aula</a></li>
      </ul>
      <div class="tab-content">
        @if(count($rooms)>0)
          @foreach($rooms as $room)
          <div class="tab-pane @if($fk_room == $room->id) active @endif" id="tab_{{$room->id}}">
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
                      <b>{{$i}}:00</b>
                    </td>
                  @for($a = 1; $a < 7; $a++)
                    <td>
                      <!-- services -->
                      @foreach(RoomController::getServicesForRoom($room->id, $a, $i) as $service)
                      <button class="btn bg-yellow" style="margin-bottom: 10px;">{{$service->name}}
                        <a href="{{URL::to('/room/delink/'.$service->id)}}">
                          <i class="fa fa-trash" style="color:red;"></i>
                        </a>
                      </button><br/>
                      @endforeach
                      <!-- //services -->

                      <!-- Add btn -->
                      <button style="float:right;" class="btn btn-xs btn-success" data-target="#linkServiceModal" data-toggle="modal" onclick="openAssignModal({{$room->id}},{{$a}},{{$i}})">
                        <i class="fa fa-plus"></i>
                      </button>
                      <!-- //Add btn -->
                    </td>
                  @endfor
                </tr>
                @endfor
              </tbody>
            </table>
          </div><!-- /.tab-pane -->
          @endforeach
        @endif
      </div><!-- /.tab-content -->
    </div>
  </div>
</div>

<!-- Modals zone -->
@include('rooms.modals.newRoom')
@include('rooms.modals.linkService')
<!-- //Modals zone -->

</section>
@stop
