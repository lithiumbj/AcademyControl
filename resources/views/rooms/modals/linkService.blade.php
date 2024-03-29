<?php
use App\Models\Service;
?>
<!-- Modal -->
<div class="modal fade" id="linkServiceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{URL::to('/rooms/assign')}}" method="post">
        {!! csrf_field() !!}
        <input type="hidden" name="fk_room" id="hidden_fk_room">
        <input type="hidden" name="day" id="hidden_day">
        <input type="hidden" name="hour" id="hidden_hour">
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
<script>
/*
 * This function set's inputs with the neccessary data
 *
 * @param {Integer} room - The room id
 * @param {Integer} day - Day in number 1-6
 * @param {Integer} Hour - The hour in 24 format (10-21)
 */
  function openAssignModal(room, day, hour)
  {
    jQuery("#hidden_hour").val(hour);
    jQuery("#hidden_day").val(day);
    jQuery("#hidden_fk_room").val(room);
  }
</script>
