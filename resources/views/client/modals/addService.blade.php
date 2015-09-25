<?php
  use App\Models\Service;
?>
<div class="modal fade" id="addService" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" ng-controller="ServiceController as service">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar / Contratar servicio</h4>
      </div>

      <!-- Step 1 -->
      <div class="modal-body" id="step1" ng-show="service.step == 1">
        <p>
            Agregar un servicio a un cliente le permite facturarle servicios, para continuar, debe elegir un servicio de la lista y pulsar en siguiente
        </p>

        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Servicio</th>
              <th>Mensualidad (€) (sin IVA)</th>
              <th>Matrícula (€)</th>
            </tr>
          </thead>
          <tbody>
            @foreach(Service::fetchCompanyServices() as $service)
            <tr>
              <td>
                <input type="radio" name="serviceId" value="{{$service->id}}" ng-change="service.setData('{{$service->name}}',{{$service->price}},{{$service->iva}},{{$service->matricula}},{{$service->id}})" ng-model="service.currService">
                {{$service->name}}
              </td>
              <td>{{$service->price}}</td>
              <td>{{$service->matricula}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- //Step 1 -->

      <!-- Step 2 -->

      <div class="modal-body" id="step1" ng-show="service.step == 2">
        <h4>Resumen</h4>
        <hr/>

        Concepto a contratar: <b><% service.concept %></b> </br>
        Precio mensual (sin IVA): <b><% service.price %> €</b> </br>
        Precio mensual: <b><% service.price + (service.price * (service.iva/100)) %> €</b> </br>
        Precio matrícula (sin IVA): <b><% service.matricula %> €</b> </br>
        Precio matrícula: <b><% service.matricula + (service.matricula * (service.iva/100)) %> €</b> </br>
        </br>
        <i>Verifique que todos los datos son correctos antes de continuar</i>

        <div class="center" style="margin-top: 25px;">
          <button type="button" class="btn btn-warning" ng-click="service.addService(true)" ng-show="service.step == 2">Generar recibo de matricula y continuar</button>&nbsp;
          <button type="button" class="btn btn-warning" ng-click="service.addService(false)" ng-show="service.step == 2">No generar recibo de matricula y continuar</button>
        </div>
      </div>
      <!-- //Step 2 -->

      <div class="modal-footer">
        <!-- Progress -->
        <div class="progress progress-sm active" ng-show="service.workingOn">
          <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
            <span class="sr-only">wait</span>
          </div>
        </div>
        <!-- //Progress -->
        <button type="button" class="btn btn-default" data-dismiss="modal" style="float:left;">Cerrar</button>
        <button type="button" class="btn btn-default" ng-click="service.goToStep2()" ng-show="service.step == 1" ng-hide="!service.selected">Siguiente</button>
      </div>
    </div>
  </div>
</div>
<!-- Scripts zone -->
<script>
  var _csrf = "{{csrf_token()}}";
  var _addServiceUrl = "{{URL::to('/client/addService')}}";
</script>
<script src="{{URL::to('/angular/addService.js')}}"></script>

<!-- //Scripts zone -->

<!-- Transfer Service modal -->

<div class="modal fade" id="transferService" tabindex="-1" role="dialog" aria-labelledby="transferService" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form action="{{URL::to('/service/switch')}}" method="post">
        {!! csrf_field() !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Transferir un servicio</h4>
      </div>

      <!-- Step 1 -->
      <div class="modal-body">
        <p>
            Puede transferir un servicio de un cliente a otro servicio, esto permite hacer un cambio rápido entre servicios sin por ello perder las faltas registradas o la didáctica acumulada para el cliente
        </p>
        <div class="form-group">
            <label>Servicio a transferir <b><i>(Solo figuran los activos)</i></b></label>
            <select name="fk_origin" class="form-control">
                @foreach($services as $service)
                    @if($service->active != 0)
                    <option value="{{$service->id}}">{{$service->name}}</option>
                    @endif
                @endforeach
            </select>
            
        </div>
        <div class="form-group">
            <label>Servicio de destino </label>
            <select name="fk_destiny" class="form-control">
                @foreach(Service::fetchCompanyServices() as $srv)
                  <option value="{{$srv->id}}">{{$srv->name}}</option>
                @endforeach
            </select>
            
        </div>
      </div>
      <!-- //Step 1 -->

      <!-- //Step 2 -->

      <div class="modal-footer">
          <p style="text-align: left;">Esta acción solo se puede revertir realizando otra transferencia, si duda, póngase en contacto con el servicio de atención técnica</p>
        <button type="button" class="btn btn-default" data-dismiss="modal" style="float:left;">Cerrar</button>
        <button type="submit" class="btn btn-success">Transferir</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Transfer Service modal //-->