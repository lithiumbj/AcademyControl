<div class="modal fade" id="enrolRoomModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <form action="{{URL::to('/room/assign_client')}}" method="POST">
      {!! csrf_field() !!}
      <input type="hidden" name="fk_client" id="fk_client_2"/>
      <input type="hidden" name="fk_room_service" id="fk_room_service_2"/>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Asignar grupo al alumno</h4>
        </div>
        <div class="modal-body">
          ¿Desea asignar al alumno a este grupo?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Asignar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="delinkRoom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <form action="{{URL::to('/room/delink_client')}}" method="POST">
      {!! csrf_field() !!}
      <input type="hidden" name="fk_client" id="fk_client_3"/>
      <input type="hidden" name="fk_room_service" id="fk_room_service_3"/>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Eliminar grupo del usuario</h4>
        </div>
        <div class="modal-body">
          Desea sacar al alumno del grupo?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-danger">Sacar del grupo</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
function enrolModal(fk_client, fk_room_service)
{
  jQuery("#fk_client_2").val(fk_client);
  jQuery("#fk_room_service_2").val(fk_room_service);
}
function delinkModal(fk_client, fk_room_service)
{
  jQuery("#fk_client_3").val(fk_client);
  jQuery("#fk_room_service_3").val(fk_room_service);
}
</script>
