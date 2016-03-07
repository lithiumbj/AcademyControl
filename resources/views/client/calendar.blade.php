<?php

use App\Helpers\DateHelper;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\IncidenceController;
use App\Http\Controllers\ServicesController;
use App\Models\Client;
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Academy Control | Inforfenix</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="{{URL::to('/')}}/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{URL::to('/')}}/css/AdminLTE.min.css">
        <link rel="stylesheet" href="{{URL::to('/')}}/css/custom.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{URL::to('/')}}/css/skins/_all-skins.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{URL::to('/')}}/plugins/iCheck/flat/blue.css">
        <!-- Morris chart -->
        <link rel="stylesheet" href="{{URL::to('/')}}/plugins/morris/morris.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="{{URL::to('/')}}/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
        <!-- Date Picker -->
        <link rel="stylesheet" href="{{URL::to('/')}}/plugins/datepicker/datepicker3.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{URL::to('/')}}/plugins/daterangepicker/daterangepicker-bs3.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="{{URL::to('/')}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        <!-- datatables css -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/s/bs/pdfmake-0.1.18,dt-1.10.10,af-2.1.0,b-1.1.0,b-colvis-1.1.0,b-html5-1.1.0,b-print-1.1.0,cr-1.3.0,fh-3.1.0,r-2.0.0,sc-1.4.0,se-1.1.0/datatables.min.css"/>
        <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <div class="tab-pane" id="tab_{{$service->id}}">
        <!-- Horario -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td style="width:54px;"></td>
                    <td style="width: 16%;">Lunes</td>
                    <td style="width: 16%;">Martes</td>
                    <td style="width: 16%;">Miércoles</td>
                    <td style="width: 16%;">Jueves</td>
                    <td style="width: 16%;">Viernes</td>
                    <td style="width: 16%;">Sábado</td>
                </tr>
            </thead>
            <tbody>
                @for($i=10;$i < 22; $i++)
                <tr>
                    <td>
                        @if($i<17)
                        <b>{{$i}}:00</b>
                        @endif
                        @if($i >= 17 && $i < 18)
                        <b>{{$i}}:15</b>
                        @endif
                        @if($i > 17)
                        <b>{{$i}}:30</b>
                        @endif
                    </td>
                    @for($a = 1; $a < 7; $a++)
                    <td class="center">
                        @if(count(RoomController::getRoomsForService($service->id, $i, $a))>0)
                        @foreach(RoomController::getRoomsForService($service->id, $i, $a) as $roomService)
                        @if(count(RoomController::isClientEnroled($roomService->id, $model->id))>0)
                        <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#delinkRoom" onclick="delinkModal({{$model->id}}, {{$roomService->id}}, {{$a}}, {{$i}})">Alumno en este grupo ({{RoomController::getRoomOcupance($roomService->id, $a, $i)}} / {{(RoomController::getCapacity($roomService->id))}})</button>
                        @else
                        <!-- Free occupance -->
                        @if(($roomService->capacity - RoomController::getRoomOcupance($roomService->id, $a, $i)) > 2)
                        <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#enrolRoomModal" onclick="enrolModal({{$model->id}}, {{$roomService->id}}, {{$a}}, {{$i}})">Grupo Libre ({{RoomController::getRoomOcupance($roomService->id, $a, $i)}} / {{(RoomController::getCapacity($roomService->id))}})</button>
                        @else
                        <!-- Mid occupance -->
                        @if(($roomService->capacity - RoomController::getRoomOcupance($roomService->id, $a, $i)) <= 2 && ($roomService->capacity - RoomController::getRoomOcupance($roomService->id, $a, $i)) > 0)
                        <button class="btn btn-xs btn-warning"data-toggle="modal" data-target="#enrolRoomModal" onclick="enrolModal({{$model->id}}, {{$roomService->id}}, {{$a}}, {{$i}})">Grupo casi lleno ({{RoomController::getRoomOcupance($roomService->id, $a, $i)}} / {{(RoomController::getCapacity($roomService->id))}})</button>
                        @else
                        <!-- Full! -->
                        @if(($roomService->capacity - RoomController::getRoomOcupance($roomService->id, $a, $i)) == 0)
                        <button class="btn btn-xs btn-danger" onclick="alert('Este grupo está leno, tendrá que escoger otro')">Grupo lleno</button>
                        @endif
                        <!-- //Full! -->
                        @endif
                        <!-- //Mid occupance -->
                        @endif
                        @endif
                        @endforeach
                        @endif
                    </td>
                    @endfor
                </tr>
                @endfor
            </tbody>
        </table>
        <!-- //Horario -->
    </div>
    <!-- Datatables -->
    <script></script>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://cdn.datatables.net/s/bs/pdfmake-0.1.18,dt-1.10.10,af-2.1.0,b-1.1.0,b-colvis-1.1.0,b-html5-1.1.0,b-print-1.1.0,cr-1.3.0,fh-3.1.0,r-2.0.0,sc-1.4.0,se-1.1.0/datatables.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
                                $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{URL::to('/')}}/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{URL::to('/')}}/js/angular.js"></script>
    <script src="{{URL::to('/')}}/js/jszip.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="{{URL::to('/')}}/plugins/morris/morris.min.js"></script>
    <!-- Chart js -->
    <script src="{{URL::to('/')}}/js/chartjs/Chart.Core.js"></script>
    <script src="{{URL::to('/')}}/js/chartjs/Chart.Bar.js"></script>
    <script src="{{URL::to('/')}}/js/chartjs/Chart.Line.js"></script>
    <!-- Sparkline -->
    <script src="{{URL::to('/')}}/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="{{URL::to('/')}}/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="{{URL::to('/')}}/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{URL::to('/')}}/plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="{{URL::to('/')}}/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="{{URL::to('/')}}/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{URL::to('/')}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="{{URL::to('/')}}/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="{{URL::to('/')}}/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{URL::to('/')}}/js/app.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{URL::to('/')}}/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{URL::to('/')}}/js/demo.js"></script>
    <!-- Extra libs -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
