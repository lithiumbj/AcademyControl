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
                <input type="radio" name="serviceId" value="{{$service->id}}" ng-model="service.currService">
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

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="float:left;">Cerrar</button>
        <button type="button" class="btn btn-default">Siguiente</button>
      </div>
    </div>
  </div>
</div>
<!-- Scripts zone -->
<script src="{{URL::to('/angular/addService.js')}}"
<!-- //Scripts zone -->
