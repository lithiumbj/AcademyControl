<!-- Modal -->
<div class="modal fade" id="newRoomModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{URL::to('/rooms/create')}}" method="post">
        {!! csrf_field() !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Crear una nueva aula</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Nombre / identificativo del aula</label>
          <input type="text" class="form-control" placeholder="Nombre" name="name">
        </div>
          <div class="form-group">
            <label>Capacidad (número)</label>
            <input type="number" class="form-control" placeholder="Nombre" name="capacity">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="float:left;">Cerrar</button>
        <button type="submit" class="btn btn-primary">Crear</button>
      </div>
    </form>
    </div>
  </div>
</div>
