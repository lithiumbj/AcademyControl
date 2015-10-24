<!-- Modal -->
<div class="modal fade" id="modalReport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Informe / seguimiento del alumno -- <b id="cliName"></b></h4>
      </div>
      <div class="modal-body">
        <p>Mostrando todos los registros del alumno</p>
        <table class="table table-bordered">
          <thead>
            <tr>
              <td style="width:93px;">Fecha</td>
              <td>Concepto</td>
              <td>Notas</td>
              <td style="width:65px;text-align:center;"></td>
            </tr>
          </thead>
          <tbody id="reportBody">

          </tbody>
          <tfoot>
            <tr>
              <td>Nuevo registro</td>
              <td><input type="text" class="form-control" id="report_concept" placeholder="Materia, concepto, resumen"/></td>
              <td>
                <input type="text" class="form-control" id="report_observations" placeholder="Observaciones" style="width:75%; display:inline;"/>
                <select class="form-control" style="width: 19%;display: inline-block;" id="report_color" onchange="switchColor()">
                    <option value="#ffffff">Blanco</option>
                    <option value="#e74c3c">Rojo</option>
                    <option value="#e67e22">Naranja</option>
                    <option value="#2ecc71">Verde</option>
                    <option value="#3498db">Azul</option>
                    <option value="#9b59b6">Rosa</option>
                </select>
              </td>
              <td>
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
function prepareReport(fk_client, fk_room_reserve, name)
{
  jQuery("#cliName").html(name);

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
            if(jData[i].color == "#ffffff"){
                if(jData[i].fk_user != {{\Auth::user()->id}})
                    jQuery("#reportBody").append("<tr style='background-color:#f39c12;'><td>"+jData[i].created_at+"</td><td>"+jData[i].concept+"</td><td><i id='originalObservations"+jData[i].id+"'>"+jData[i].observations+"</i><input type='text' class='form-control' value='"+jData[i].observations+"' id='observationsEdit"+jData[i].id+"' style='display:none'/></td><td><button onclick='editReport("+jData[i].id+")' id='editBtn"+jData[i].id+"' class='btn btn-xs btn-warning'><i class='fa fa-pencil'></i></button> <button id='deleteBtn"+jData[i].id+"' onclick='deleteReport("+jData[i].id+")' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button> <button id='saveEditBtn"+jData[i].id+"' style='display:none;' class='btn btn-xs btn-success pull-right' onclick='goEditReport()'><i class='fa fa-floppy-o'></i></button> </td></tr>");
                else
                    jQuery("#reportBody").append("<tr><td>"+jData[i].created_at+"</td><td>"+jData[i].concept+"</td><td><i id='originalObservations"+jData[i].id+"'>"+jData[i].observations+"</i><input type='text' class='form-control' value='"+jData[i].observations+"' id='observationsEdit"+jData[i].id+"' style='display:none'/></td><td><button onclick='editReport("+jData[i].id+")' id='editBtn"+jData[i].id+"' class='btn btn-xs btn-warning'><i class='fa fa-pencil'></i></button> <button id='deleteBtn"+jData[i].id+"' onclick='deleteReport("+jData[i].id+")' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button> <button id='saveEditBtn"+jData[i].id+"' style='display:none;' class='btn btn-xs btn-success pull-right' onclick='goEditReport()'><i class='fa fa-floppy-o'></i></button> </td></tr>");
            }else{
                    jQuery("#reportBody").append("<tr style='background-color:"+jData[i].color+";'><td>"+jData[i].created_at+"</td><td>"+jData[i].concept+"</td><td><i id='originalObservations"+jData[i].id+"'>"+jData[i].observations+"</i><input type='text' class='form-control' value='"+jData[i].observations+"' id='observationsEdit"+jData[i].id+"' style='display:none'/></td><td><button onclick='editReport("+jData[i].id+")' id='editBtn"+jData[i].id+"' class='btn btn-xs btn-warning'><i class='fa fa-pencil'></i></button> <button id='deleteBtn"+jData[i].id+"' onclick='deleteReport("+jData[i].id+")' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button> <button id='saveEditBtn"+jData[i].id+"' style='display:none;' class='btn btn-xs btn-success pull-right' onclick='goEditReport()'><i class='fa fa-floppy-o'></i></button> </td></tr>");
            }
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
    data : {fk_client: client, fk_service: room_reserve, _token : "{{csrf_token()}}", concept: jQuery("#report_concept").val(), observations: jQuery("#report_observations").val(), color: jQuery("#report_color").val()}
  }).done(function(data) {
      if(data == 'ok'){
        alert("Reporte creado correctamente");
        jQuery("#close_report").trigger("click");
        jQuery("#report_concept").val("");
        jQuery("#report_observations").val("");
        jQuery("#report_color").val("#ffffff");
        switchColor();
      }else{
        alert("Error al crear el reporte del alumno");
      }
  }).fail(function(){
      alert("Error al crear el reporte del alumno");
  });
}
/*
 * This function deletes the report via AJAX request (POST) 
 */
function deleteReport(id)
{
    if (confirm('¿Seguro que desea eliminar el registro?')) {
        jQuery.ajax({
            url: "{{URL::to('/report/client/delete')}}",
            method : "POST",
            data : {id : id, _token : "{{csrf_token()}}"}
          }).done(function(data) {
              if(data == 'ok'){
                alert("Reporte eliminado correctamente");
                jQuery("#close_report").trigger("click");
                jQuery("#report_concept").val("");
                jQuery("#report_observations").val("");
              }else{
                alert("Error al eliminar el reporte del alumno");
              }
          }).fail(function(){
              alert("Error al eliminar el reporte del alumno");
          });
    } else {
        
    }
}
/*
 * This function (and variable) sets the gui to edit a report, stores the
 * id in a safe temp variable and hide/shows the correct buttons to inter-operate
 * with the new form
 */
var tmpId;
function editReport(id)
{
    tmpId = id;
    //Hide the delete/edit buttons
    jQuery("#editBtn"+id).hide();
    jQuery("#deleteBtn"+id).hide();
    jQuery("#originalObservations"+id).hide();
    //Show edit gui elements
    jQuery("#saveEditBtn"+id).show();
    jQuery("#observationsEdit"+id).show();
}
/*
 * This function sends the new info (report data) to the server 
 */
function goEditReport()
{
    jQuery("#saveEditBtn"+tmpId).html('Un momento');
    var text = jQuery("#observationsEdit"+tmpId).val();
    //Send the request
    jQuery.ajax({
            url: "{{URL::to('/report/client/edit')}}",
            method : "POST",
            data : {id : tmpId, _token : "{{csrf_token()}}", observations : text}
          }).done(function(data) {
              if(data == 'ok'){
                alert("Reporte modificado correctamente");
                jQuery("#close_report").trigger("click");
                jQuery("#report_concept").val("");
                jQuery("#report_observations").val("");
              }else{
                alert("Error al modificar el reporte del alumno");
              }
          }).fail(function(){
              alert("Error al modificar el reporte del alumno");
          });
}
/*
 * This function changes the color of the observations field to "simulate"
 * the final result
 */
function switchColor()
{
    if(jQuery("#report_color").val() == "#ffffff"){
        jQuery("#report_observations").css({
          "background-color": jQuery("#report_color").val(),
          "color":"#000000"
        });
    }else{
        jQuery("#report_observations").css({
          "background-color": jQuery("#report_color").val(),
          "color":"#ffffff"
        });
    }
}
</script>
