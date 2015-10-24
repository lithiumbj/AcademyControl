<!-- Modal -->
<div class="modal fade" id="smsReport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Revisar y mandar por SMS</h4>
            </div>
            <div class="modal-body">
                <textarea class='form-control' style='height: 250px;' id='reportContent'></textarea>
            </div>
            <div class="modal-footer">
                <!-- alerts -->
                <div class="alert alert-danger alert-dismissible" id='errorDesconocido' style="display:none">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Error al enviar el SMS</h4>
                    Ha ocurrido un error desconocido al enviar el SMS, contacte con soporte
                </div>

                <div class="alert alert-danger alert-dismissible" id='errorTelefono' style="display:none">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Error al enviar el SMS</h4>
                    No se ha encontrado un número de teléfono al que enviar el SMS o el que hay no es un teléfono móvil o este, es incorrecto
                </div>

                <div class="alert alert-success alert-dismissible" id='sendOk' style="display:none">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> !Envio correcto!</h4>
                    El SMS se ha enviado y pronto llegará a su destinatario<br/>Puede cerrar esta ventana ya
                </div>

                <div class="progress progress-sm active" style='display:none;' id='smsWorkingOn'>
                    <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                        <span class="sr-only">Enviando...</span>
                    </div>
                </div>
                <!-- //alerts -->
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="sendSms()">Mandar</button>
            </div>
        </div>
    </div>
</div>

<script>
    //Boot's up the app
    var fk_client;
    function launchSmsApp(text, clientId)
    {
        fk_client = clientId;
        jQuery("#reportContent").html(text);
        /*tinymce.init({
         selector: "#reportContent"
         });*/
    }
    /*
     * This function will send the SMS via post to the server
     */
    function sendSms()
    {
        //Show the working on progress bar
        jQuery("#smsWorkingOn").show();
        //Send the POST request
        jQuery.ajax({
            url: "{{URL::to('/sms/sendReport')}}",
            method: "POST",
            data: {_token: "{{csrf_token()}}", message: jQuery("#reportContent").val(), fk_client: fk_client}
        }).done(function (data) {
            if (data == 'ok')
                jQuery("#sendOk").show(450);
            if (data == 'badPhone')
                jQuery("#errorTelefono").show(450);
            if (data != 'ok' && data != 'badPhone')
                jQuery("#errorDesconocido").show(450);
            //Hide the spinner
            jQuery("#smsWorkingOn").hide();
        }).fail(function () {
            jQuery("#smsWorkingOn").hide();
            alert("Error desconocido al mandar el mensaje");
        });
    }
</script>