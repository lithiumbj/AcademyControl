<!-- Modal -->
<div class="modal fade" id="modalReport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Informe / seguimiento del alumno</h4>
      </div>
      <div class="modal-body">
        <p>Mostrando todos los registros del alumno</p>
        <table class="table table-bordered">
          <thead>
            <tr>
              <td>Fecha</td>
              <td>Concepto</td>
              <td>Notas</td>
            </tr>
          </thead>
          <tbody id="reportBody">

          </tbody>
          <tfoot>
            <tr>
              <td>Nuevo registro</td>
              <td><input type="text" class="form-control" id="report_concept" placeholder="Materia, concepto, resumen"/></td>
              <td>
                <input type="text" class="form-control" id="report_observations" placeholder="Observaciones" style="width:85%; display:inline;"/>
                <button class="btn btn-success" onclick="sendReport()"><i class="fa fa-paper-plane-o"></i></button>
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" id="close_report" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<script>
var client, room_reserve;

/*
 * Get's the report
 */
function prepareReport(fk_client, fk_room_reserve)
{
  jQuery("#reportBody").html("");
  client = fk_client;
  room_reserve = fk_room_reserve;
  //Get actual report
  jQuery.ajax({
    url: "{{URL::to('/report/client/get')}}",
    method : "POST",
    data : {fk_client: client, fk_service: room_reserve, _token : "{{csrf_token()}}"}
  }).done(function(data) {
      var jData = JSON.parse(data);
      if(jData.length > 0){
        for(var i = 0; i < jData.length; i++){
          jQuery("#reportBody").append("<tr><td>"+jData[i].created_at+"</td><td>"+jData[i].concept+"</td><td>"+jData[i].observations+"</td></tr>");
        }
      }else{
        jQuery("#reportBody").append("<tr><td colspan='3'>Sin registros</td></tr>");
      }
  }).fail(function(){
      alert("Error al obtener el reporte del alumno");
  });
}
/*
 * Sends the report
 */
function sendReport()
{
  jQuery.ajax({
    url: "{{URL::to('/report/client/create')}}",
    method : "POST",
    data : {fk_client: client, fk_service: room_reserve, _token : "{{csrf_token()}}", concept: jQuery("#report_concept").val(), observations: jQuery("#report_observations").val()}
  }).done(function(data) {
      if(data == 'ok'){
        alert("Reporte creado correctamente");
        jQuery("#close_report").trigger("click");
        jQuery("#report_concept").val("");
        jQuery("#report_observations").val("");
      }else{
        alert("Error al crear el reporte del alumno");
      }
  }).fail(function(){
      alert("Error al crear el reporte del alumno");
  });
}
</script>
