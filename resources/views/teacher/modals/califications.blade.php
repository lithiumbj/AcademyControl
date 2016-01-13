<!-- Modal -->
<div class="modal fade" id="modalCalifications" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Notas del alumno -- <b id="cliName"></b></h4>
      </div>
      <div class="modal-body">
        <p>Mostrando Asignaturas del alumno</p>
        <table class="table table-bordered">
          <thead>
            <tr>
              <td style="width:93px;">Fecha</td>
              <td>Asignatura</td>
              <td>Nota</td>
              <td style="width:65px;text-align:center;"></td>
            </tr>
          </thead>
          <tbody id="calificationsBody">

          </tbody>
          <tfoot>
            <tr>
              <td>Nuevo registro</td>
              <td><input type="text" class="form-control" id="calification_concept" placeholder="Materia, concepto, resumen"/></td>
              <td>
                <input type="text" class="form-control" id="calification_observations" placeholder="Observaciones" style="width:75%; display:inline;"/>
                <select class="form-control" style="width: 19%;display: inline-block;" id="calification_color" onchange="switchColorCalification()">
                    <option value="#ffffff">Blanco</option>
                    <option value="#e74c3c">Rojo</option>
                    <option value="#e67e22">Naranja</option>
                    <option value="#2ecc71">Verde</option>
                    <option value="#3498db">Azul</option>
                    <option value="#9b59b6">Rosa</option>
                </select>
              </td>
              <td>
                <button class="btn btn-success" onclick="sendCalification()" id="createBtnCalifications"><i class="fa fa-paper-plane-o"></i></button>
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" id="close_califications" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<script>
var client, room_reserve, name;

/*
 * Get's the report
 */
function prepareCalifications(fk_client, fk_room_reserve, name)
{
  jQuery("#cliName").html(name);

  jQuery("#calificationsBody").html("");
  client = fk_client;
  name = name;
  room_reserve = fk_room_reserve;
  //Get actual report
  jQuery.ajax({
    url: "{{URL::to('/califications/client/get')}}",
    method : "POST",
    data : {fk_client: client, fk_service: room_reserve, _token : "{{csrf_token()}}"}
  }).done(function(data) {
      var jData = JSON.parse(data);
      if(jData.length > 0){
        for(var i = 0; i < jData.length; i++){
            if(jData[i].color == "#ffffff"){
                if(jData[i].fk_user != {{\Auth::user()->id}})
                    jQuery("#calificationsBody").append("<tr style='background-color:#f39c12;'><td>"+jData[i].created_at+"</td><td>"+jData[i].concept+"</td><td><i id='originalObservations"+jData[i].id+"'>"+jData[i].observations+"</i><input type='text' class='form-control' value='"+jData[i].observations+"' id='observationsEdit"+jData[i].id+"' style='display:none'/></td><td><button onclick='editReport("+jData[i].id+")' id='editBtn"+jData[i].id+"' class='btn btn-xs btn-warning'><i class='fa fa-pencil'></i></button> <button id='deleteBtn"+jData[i].id+"' onclick='deleteCalification("+jData[i].id+")' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button> <button id='saveEditBtn"+jData[i].id+"' style='display:none;' class='btn btn-xs btn-success pull-right' onclick='goEditCalification()'><i class='fa fa-floppy-o'></i></button> </td></tr>");
                else
                    jQuery("#calificationsBody").append("<tr><td>"+jData[i].created_at+"</td><td>"+jData[i].concept+"</td><td><i id='originalObservations"+jData[i].id+"'>"+jData[i].observations+"</i><input type='text' class='form-control' value='"+jData[i].observations+"' id='observationsEdit"+jData[i].id+"' style='display:none'/></td><td><button onclick='editReport("+jData[i].id+")' id='editBtn"+jData[i].id+"' class='btn btn-xs btn-warning'><i class='fa fa-pencil'></i></button> <button id='deleteBtn"+jData[i].id+"' onclick='deleteCalification("+jData[i].id+")' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button> <button id='saveEditBtn"+jData[i].id+"' style='display:none;' class='btn btn-xs btn-success pull-right' onclick='goEditCalification()'><i class='fa fa-floppy-o'></i></button> </td></tr>");
            }else{
                    jQuery("#calificationsBody").append("<tr style='background-color:"+jData[i].color+";'><td>"+jData[i].created_at+"</td><td>"+jData[i].concept+"</td><td><i id='originalObservations"+jData[i].id+"'>"+jData[i].observations+"</i><input type='text' class='form-control' value='"+jData[i].observations+"' id='observationsEdit"+jData[i].id+"' style='display:none'/></td><td><button onclick='editReport("+jData[i].id+")' id='editBtn"+jData[i].id+"' class='btn btn-xs btn-warning'><i class='fa fa-pencil'></i></button> <button id='deleteBtn"+jData[i].id+"' onclick='deleteCalification("+jData[i].id+")' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button> <button id='saveEditBtn"+jData[i].id+"' style='display:none;' class='btn btn-xs btn-success pull-right' onclick='goEditCalification()'><i class='fa fa-floppy-o'></i></button> </td></tr>");
            }
        }
        //Scroll to the last position
         $('#modalCalifications').animate({
             scrollTop: $("#close_califications").offset().top
         }, 750);
      }else{
        jQuery("#calificationsBody").append("<tr><td colspan='3'>Sin registros</td></tr>");
      }
  }).fail(function(){
      alert("Error al obtener el reporte del alumno");
  });
}
/*
 * Sends the report
 */
function sendCalification()
{
  jQuery("#createBtnCalifications").html("Espere....");
  jQuery.ajax({
    url: "{{URL::to('/report/client/create')}}",
    method : "POST",
    data : {fk_client: client, fk_service: room_reserve, _token : "{{csrf_token()}}", concept: jQuery("#calification_concept").val(), observations: jQuery("#calification_observations").val(), color: jQuery("#calification_color").val(), is_calification: 1}
  }).done(function(data) {
      if(data == 'ok'){
        //jQuery("#close_califications").trigger("click");
        jQuery("#calification_concept").val("");
        jQuery("#calification_observations").val("");
        jQuery("#calification_color").val("#ffffff");
        jQuery("#createBtnCalifications").html('<i class="fa fa-paper-plane-o"></i>');
        //reload report view
        prepareCalifications(client, room_reserve, name);
        switchColorCalification();
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
function deleteCalification(id)
{
    if (confirm('¿Seguro que desea eliminar el registro?')) {
        jQuery.ajax({
            url: "{{URL::to('/report/client/delete')}}",
            method : "POST",
            data : {id : id, _token : "{{csrf_token()}}"}
          }).done(function(data) {
              if(data == 'ok'){
                prepareCalifications(client, room_reserve, name);
                jQuery("#calification_concept").val("");
                jQuery("#calification_observations").val("");
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
function editCalification(id)
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
function goEditCalification()
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
                prepareCalifications(client, room_reserve, name);
                jQuery("#calification_concept").val("");
                jQuery("#calification_observations").val("");
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
function switchColorCalification()
{
    if(jQuery("#calification_color").val() == "#ffffff"){
        jQuery("#calification_observations").css({
          "background-color": jQuery("#calification_color").val(),
          "color":"#000000"
        });
    }else{
        jQuery("#calification_observations").css({
          "background-color": jQuery("#calification_color").val(),
          "color":"#ffffff"
        });
    }
}
</script>
