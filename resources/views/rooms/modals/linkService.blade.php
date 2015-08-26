<?php
use App\Models\Service;
?>
<!-- Modal -->
<div class="modal fade" id="linkServiceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{URL::to('/rooms/create')}}" method="post">
        {!! csrf_field() !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Asignar una hora a un servicio</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Seleccione servicio a asignar a esta hora</label>
          <select name="fk_service" class="form-control">
            @foreach(Service::fetchCompanyServices() as $service)
              <option value="{{$service->id}}">{{$service->name}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="float:left;">Cerrar</button>
        <button type="submit" class="btn btn-primary">Asignar</button>
      </div>
    </form>
    </div>
  </div>
</div>
