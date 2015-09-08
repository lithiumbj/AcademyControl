@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<?php
use App\User;
use App\Models\Provider;
?>
<section class="content-header">
  <h1>
    Proveedores
    <small>Listado</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Proveedores</a></li>
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
        <table class="table table-bordered" id="providersTable">
          <thead>
          <tr>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Ciudad</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>Empleado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($providers as $provider)
          <tr>
            <td>{{$provider->name}}</td>
            <td>{{$provider->lastname_1}} {{$provider->lastname_2}}</td>
            <td>{{$provider->city}}</td>
            <td>{{$provider->phone_client}}</td>
            <td>{{$provider->address}}</td>
            <td class="center">
              {{Provider::getProviderName($provider->fk_user)}}
            </td>
            <td class="center">
              <!-- Actions -->
              <a class="btn btn-xs btn-success" href="{{URL::to('/provider/view/'.$provider->id)}}"><i class="fa fa-eye"></i></a>
              <a class="btn btn-xs btn-success" href="{{URL::to('/provider/update/'.$provider->id)}}"><i class="fa fa-pencil"></i></a>
              <a class="btn btn-xs btn-danger" href="{{URL::to('/provider/delete/'.$provider->id)}}"><i class="fa fa-trash"></i></a>
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
  jQuery("#providersTable").dataTable({
    "iDisplayLength": 100
  });
}
</script>
@stop
