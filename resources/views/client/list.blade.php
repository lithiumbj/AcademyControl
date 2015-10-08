@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<?php
use App\User;
?>
<section class="content-header">
  <h1>
    Clientes
    <small>Listado</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Clientes</a></li>
    <li class="active">Listado</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
      <div class="box-header with-border">
      </div><!-- /.box-header -->
      <div class="box-body">
        <table class="table table-bordered" id="clientsTable">
          <thead>
          <tr>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Ciudad</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>Tipo</th>
            <th>Fecha</th>
            <th>Empleado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($clients as $client)
          <tr>
            <td>{{$client->name}}</td>
            <td>{{$client->lastname_1}} {{$client->lastname_2}}</td>
            <td>{{$client->city}}</td>
            <td>{{$client->phone_client}}</td>
            <td>{{$client->address}}</td>
            <td class="center white-text">
              {{$client->status}}
              @if($client->status == 0)
                <small class="label bg-yellow">Cliente potencial</small>
              @endif
              @if($client->status == 1)
                <small class="label bg-green">Cliente</small>
              @endif
              @if($client->status == 2)
                <small class="label bg-red">Ex-cliente</small>
              @endif
            </td>
            <td>
                {{date('Y-m-d',strtotime($client->created_at))}}
            </td>
            <td class="center">
              {{User::getUserName($client->fk_user)}}
            </td>
            <td class="center">
              <!-- Actions -->
              <a class="btn btn-xs btn-success" href="{{URL::to('/client/view/'.$client->id)}}"><i class="fa fa-eye"></i></a>
              <a class="btn btn-xs btn-success" href="{{URL::to('/client/update/'.$client->id)}}"><i class="fa fa-pencil"></i></a>
              <a class="btn btn-xs btn-danger" href="{{URL::to('/client/delete/'.$client->id)}}"><i class="fa fa-trash"></i></a>
              <!-- //Actions -->
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      </div><!-- /.box-body -->
    </div>
    </div>
  </div>

</section>

<script>
/*
 * This function sends the delete ajax request to the client controller
 */
function deleteClient(client_id)
{

}
/*
 * At load, set the datatable
 */
window.onload = function()
{
  jQuery("#clientsTable").dataTable({
    "iDisplayLength": 100
  });
}
</script>
@stop
