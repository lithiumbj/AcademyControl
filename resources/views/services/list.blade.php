@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<section class="content-header">
  <h1>
    Servicios
    <small>Listado</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Servicios</a></li>
    <li class="active">Listado</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
      <div class="box-header with-border">
        <h3>Listado de servicios</h3>
        <div class="box-tools pull-right">
          <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i> Crear nuevo servicio</button>
        </div>
      </div><!-- /.box-header -->
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
        <table class="table table-bordered" id="clientsTable">
          <thead>
          <tr>
            <th>Referencia</th>
            <th>Descripción larga</th>
            <th>Base Imponible</th>
            <th>IVA</th>
            <th>Precio</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($services as $service)
          <tr>
            <td>{{$service->name}}</td>
            <td>{{$service->description}}</td>
            <td>{{$service->price}} €</td>
            <td>{{$service->iva}} €</td>
            <td>{{($service->iva * $service->price) + $service->price}} €</td>
            <td class="center white-text">
              {{$service->is_active}}
              @if($service->is_active == 1)
                <small class="label bg-green">A la venta</small>
              @else
                <small class="label bg-red">Fuera de la venta</small>
              @endif
            </td>
            <td class="center">
              <!-- Actions -->
              <a class="btn btn-xs btn-success" onclick="alert('¡Atención!\n\nEsta operación alterará todas las futuras facturas / recibos de sus clientes que tengan contratado este servicio\n\nContacte con administración de sistemas antes de continuar')" href="{{URL::to('/client/update/'.$service->id)}}"><i class="fa fa-pencil"></i></a>
              <a class="btn btn-xs btn-danger" onclick="deleteClient({{$service->id}})"><i class="fa fa-trash"></i></a>
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
  jQuery("#clientsTable").dataTable();
}
</script>

<!-- Create modal zone -->

<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{URL::to('/services/create')}}" method="post">
        {!! csrf_field() !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Crear nuevo servicio</h4>
        </div>
        <div class="modal-body">

          <div class="form-group col-md-12">
            <label>Referencia</label>
            <input class="form-control" name="name" type="text">
          </div>

          <div class="form-group col-md-12">
            <label>Descripción</label>
            <input class="form-control" name="description" type="text">
          </div>

          <div class="form-group col-md-12">
            <label>Base imponible</label>
            <input class="form-control" name="price" type="number">
          </div>

          <div class="form-group col-md-12">
            <label>Matricula (Base imponible)</label>
            <input class="form-control" name="matricula" type="number">
          </div>

          <div class="form-group col-md-12">
            <label>% de IVA</label>
            <input class="form-control" name="iva" type="number">
          </div>

          <div class="form-group col-md-12">
            <label>¿A la venta?</label>
            <select class="form-control" name="is_active">
              <option value="1">Sí</option>
              <option value="0">No</option>
            </select>
          </div>

        </div>
        <div class="modal-footer">
          <hr/>
          <button type="button" class="btn btn-default" data-dismiss="modal" style="float:left;">Cancelar</button>
          <button type="submit" class="btn btn-success">Crear</button>
        </div>
    </form>
    </div>
  </div>
</div>

<!-- //Create modal zone -->

@stop
