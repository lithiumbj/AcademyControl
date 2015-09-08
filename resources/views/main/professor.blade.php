@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<?php
use App\Models\Client;
use App\Models\Invoice;
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
      <!-- Custom Tabs -->
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          @foreach(TeacherController::getServicesForTeacher() as $service)
            <li class="@if($counterA == 0) active @endif"><a href="#tab_{{$service->id}}" data-toggle="tab">{{$service->name}}</a></li>
            <?php $counterA++; ?>
          @endforeach
        </ul>
        <div class="tab-content">
        @foreach(TeacherController::getServicesForTeacher() as $service)
          <div class="tab-pane @if($counterB == 0) active @endif" id="tab_{{$service->id}}">
            <?php $counterB++; ?>
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
                      @if(count(TeacherController::getServicesForHourAndDay($service->id, $i, $a))>0)
                        @foreach(TeacherController::getServicesForHourAndDay($service->id, $i, $a) as $reserve)
                          <a class="btn btn-primary" href="{{URL::to('/teacher/teach')}}?day={{$a}}&hour={{$i}}&service={{$reserve->id}}">Seleccionar esta hora</a>
                        @endforeach
                      @endif
                    </td>
                  @endfor
                </tr>
                @endfor
              </tbody>
            </table>
          </div><!-- /.tab-pane -->
        @endforeach
        </div><!-- /.tab-content -->
      </div><!-- nav-tabs-custom -->
    </div>
  </div>
</section>
@stop
