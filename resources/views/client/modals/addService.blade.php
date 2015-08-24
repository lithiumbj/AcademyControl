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
        <button type="button" class="btn btn-default" data-dismiss="modal" style="float:left;">Cerrar</button>
        <button type="button" class="btn btn-default" ng-click="service.goToStep2()" ng-show="service.step == 1" ng-hide="!service.selected">Siguiente</button>
      </div>
    </div>
  </div>
</div>
<!-- Scripts zone -->
<script>
  var _csrf = "{{csrf_token()}}";
</script>
<script src="{{URL::to('/angular/addService.js')}}"></script>

<!-- //Scripts zone -->
