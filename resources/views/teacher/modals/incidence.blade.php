<!-- Modal -->
<div class="modal modal-warning fade" id="modalIncidence" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Emitir una incidencia</h4>
      </div>
      <div class="modal-body">
        <p>Este diálogo permite enviar una incidencia negativa sobre el alumno; Bajo rendimiento, problemas, mal comportamiento... etc.</p>
        <p>Esta será revisada por dirección lo antes posible</p>
        <hr/>
        <!-- Form -->
        <div class="form-group">
          <label>Motivo (corto)</label>
          <input class="form-control" id="incidence_concept" placeholder="Breve descripción del problema" type="text">
        </div>

        <div class="form-group">
          <label>Descripción del problema</label>
          <textarea class="form-control" id="incidence_description"></textarea>
        </div>
        <!-- //Form -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" id="incidence_close" data-dismiss="modal" style="float:left;">Cerrar</button>
        <button type="button" class="btn btn-outline" id="sendIncidence">Emitir incidencia</button>
      </div>
    </div>
  </div>
</div>

<script>
var client;
function prepareIncidence(fk_client)
{
  client = fk_client;
}
window.onload = function()
{
  jQuery("#sendIncidence").click(function(){
      jQuery.ajax({
        url: "{{URL::to('/incidence/client/create')}}",
        method : "POST",
        data : {fk_client: client, concept: jQuery("#incidence_concept").val(), description: jQuery("#incidence_description").val(), _token : "{{csrf_token()}}"}
      }).done(function(data) {
        if(data == 'ok'){
          alert("Incidencia enviada correctamente, dirección la revisará pronto");
          jQuery("#incidence_close").trigger('click');
        }else{
          alert("Error al emitir el reporte del alumno");
        }
      }).fail(function(){
          alert("Error al emitir el reporte del alumno");
      });
  });
};

</script>
