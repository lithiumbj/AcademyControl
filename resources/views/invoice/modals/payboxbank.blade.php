<?php
//{{URL::to('/invoice/pay/'.$invoice->id)}}
?>
<!-- Modal -->
<div class="modal fade" id="payboxbank" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{URL::to('/invoice/paybank')}}" method="post">
            {!! csrf_field() !!}
            <input type="hidden" name="fk_invoice" value="{{$invoice->id}}"/>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Pagar un recibo por punteo bancario</h4>
            </div>
            <div class="modal-body">
                Está a punto de pagar un recibo mediante punteo de domiciliación bancaria. <br><i> Estos pagos no figurarán como movimientos de caja</i><br/><br/>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-md-4">
                        <b>Importe: </b>
                    </div>
                    <div class="col-md-8">
                        <!-- Get the payments -->
                        <?php
                        $total = 0;
                        foreach($payments as $payment){
                            $total += $payment->total;
                        }
                        ?>
                        <input type="text" disabled="disabled" class="form-control" value="{{$invoice->total - $total}}" />
                    </div>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-md-4">
                        <b>Entrada bancaria: </b>
                    </div>
                    <div class="col-md-8">
                        <input type="text" value="0" class="form-control" id="toPay" onkeyup="recalculateTotals()" name="toPay"/>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" style="float:left;" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success">Pagar</button>
        </div>
    </form>
    </div>
</div>
</div>