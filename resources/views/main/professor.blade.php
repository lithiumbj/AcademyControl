@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<?php

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Room;
use App\Models\InvoicePayment;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\TeacherController;

$counterA = 0;
$counterB = 0;
?>
<section class="content-header">
    <h1>
        Inicio
        <small>Vista de profesor</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @foreach(Room::getRooms() as $room)
                        <li><a href="#tab_{{$room->id}}" data-toggle="tab">{{$room->name}}</a></li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach(Room::getRooms() as $room)
                    <div class="tab-pane" id="tab_{{$room->id}}">
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
                                    @if(TeacherController::getClientsForHour($room->id, $i, $a)>0)
                                        <a href="{{URL::to('/teacher/teach?hour='.$i.'&day='.$a.'&room='.$room->id)}}" class="btn btn-primary btn-xs">Seleccionar</a>
                                    @else
                                        <a href="#" class="btn btn-disabled btn-xs">Sin alumnos</a>
                                    @endif
                                </td>
                                @endfor
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                    </div>
                    @endforeach
                </div><!-- /.tab-content -->
            </div>
        </div>
    </div>
</section>
@stop
