<div class="modal fade" id="massivePrintModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{URL::to('/invoice/massiveprint')}}" method="post">
        {!! csrf_field() !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Impresión masiva de recibos</h4>
      </div>
      <div class="modal-body">
        Este procedimiento generará un pdf con todos los recibos, un recibo por página, en formato A5 para imprimirlos rápidamente
        <div class="row" style="margin-top: 20px;">
          <div class="col-md-12">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Fecha de inicio</label>
              <div class="col-sm-8">
                <input class="form-control" id="date_start" name="date_start" placeholder="Fecha de inicio" type="text">
              </div>
            </div>
        </div>

        <div class="col-md-12" style="margin-top: 20px;">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Fecha de final</label>
            <div class="col-sm-8">
              <input class="form-control" id="date_end" name="date_end" placeholder="Fecha de fin" type="text">
            </div>
          </div>
        </div>
<!--
        <div class="col-md-12" style="margin-top: 20px;">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Nota pública</label>
            <div class="col-sm-8">
              <input class="form-control" id="note_public" name="note_public" placeholder="Nota..." type="text">
            </div>
          </div>
        </div>
-->
      </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" style="float:left;" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-print"></i> Imprimir</button>
      </div>
    </form>
    </div>
  </div>
</div>
<script>
function startDatePickerListeners()
{
  jQuery("#date_start").datepicker();
  jQuery("#date_end").datepicker();
}
</script>
