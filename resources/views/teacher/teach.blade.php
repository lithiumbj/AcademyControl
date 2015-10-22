@extends('template')
<!-- Content Header (Page header) -->
<?php
use App\Models\Client;
use App\Http\Controllers\IncidenceController;
?>
@section('content')
<section class="content-header">
  <h1>
    Profesor - Su clase
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-7">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Alumnos </h3>
          <div class="box-tools pull-right">
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th style="width: 229px;">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($clients as $client)
              <tr>
                <td>{{$client[0]->name}}</td>
                <td>{{$client[0]->lastname_1}} {{$client[0]->lastname_2}}</td>
                <td class="center">
                  <button class="btn btn-xs btn-success" onclick="prepareReport({{$client[0]->id}},{{$client[1]}}, '{{$client[0]->name}} {{$client[0]->last_name_1}}')" data-toggle="modal" data-target="#modalReport"><i class="fa fa-briefcase"></i> Abrir informe</button>
                  <button class="btn btn-xs btn-warning" onclick="prepareIncidence({{$client[0]->id}})" data-toggle="modal" data-target="#modalIncidence"><i class="fa fa-bullseye"></i> Emitir incidencia</button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Control de asistencia </h3>
          <div class="box-tools pull-right">
          </div>
        <div class="box-body">
        </div><!-- /.box-header -->
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th style="width: 65px;">¿Asiste?</th>
              </tr>
            </thead>
            <tbody>
              @foreach($clients as $client)
                <tr>
                  <td>{{$client[0]->name}}</td>
                  <td>{{$client[0]->lastname_1}} {{$client[0]->lastname_2}}</td>
                  <td class="center">
                    @if(!is_null(IncidenceController::isChekedIn($client[0]->id, $client[1])))
                      @if(IncidenceController::isChekedIn($client[0]->id, $client[1]) == 1)
                        <button onclick="clientIsIn({{$client[0]->id}}, {{$client[1]}}, 0)" class="btn btn-xs btn-success"><i class="fa fa-thumbs-up"></i> Si, cambiar</button>
                      @else
                        <button onclick="clientIsIn({{$client[0]->id}}, {{$client[1]}}, 1)" class="btn btn-xs btn-danger"><i class="fa fa-times"></i> No, cambiar</button>
                      @endif
                    @else
                    <button onclick="clientIsIn({{$client[0]->id}}, {{$client[1]}}, 1)" class="btn btn-xs btn-success"><i class="fa fa-thumbs-up"></i></button>
                    <button onclick="clientIsIn({{$client[0]->id}}, {{$client[1]}}, 0)" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
@include('teacher.modals.incidence')
@include('teacher.modals.report')
<script>
/*
 * This function sets the assitance to true or false
 */
function clientIsIn(fk_client, fk_room_reserve, assist)
{
  jQuery.ajax({
    url: "{{URL::to('/assistance/checkin')}}",
    method : "POST",
    data : {fk_client: fk_client, fk_room_reserve: fk_room_reserve, assist: assist, _token : "{{csrf_token()}}"}
  }).done(function(data) {
    if(data == 'ok'){
      location.reload();
  }else{
      //No only ok, maybe ok and sended SMS?
      if(data == 'okWithSMS'){
          alert("Se ha notificado vía SMS");
          location.reload();
      }else{
        alert("Error al establecer el estado de la falta del alumno");
      }
  }
  }).fail(function(){
        alert("Error al establecer el estado de la falta del alumno");
  });
}
</script>
@stop
