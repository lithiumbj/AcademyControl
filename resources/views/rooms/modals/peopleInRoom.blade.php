<!-- Modal -->
<div class="modal fade" id="showPeopleInRoom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Mostrando los alumnos en este grupo</h4>
      </div>
      <div class="modal-body" id="modal-people-in-room">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<script>
function getClientsForRoom(roomServiceId)
{
  //Download the users
  jQuery.ajax({
    url: "{{URL::to('/rooms/getReserveClients/')}}" + "/" + roomServiceId,
  }).done(function(data) {
    var jsonArray = JSON.parse(data);
    //Empty the gui
    jQuery("#modal-people-in-room").html("");
    for(var i = 0; i < jsonArray.length; i++){
      jQuery("#modal-people-in-room").append('<span style="padding: 5px;border-radius: 6px;" class="bg-red">'+jsonArray[i].name+'</span><br/><br/>');
    }
  });
}
</script>
