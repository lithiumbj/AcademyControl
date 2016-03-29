@extends('template')
<!-- Content Header (Page header) -->
@section('content')
<?php

use App\Helpers\DateHelper;
use App\Http\Controllers\RoomController;
?>
<section class="content-header">
    <h1>
        Estadísticas
        <small>Informe de ocupación</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Estadísticas</a></li>
        <li class="active">Informe de ocupación</li>
    </ol>
</section>

<!-- Main content -->
<section class="content" id="occupationInfoBoxes">

    @foreach($data as $roomName => $room)
    <div class="row">
        <div class="col-md-12 col-xs-12 col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{$roomName}}</h3>
                    <div class="pull-right">
                        Exporte cada aula por separado en Excel o PDF para imprimir
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered tablaDatos" id="table_{{$roomName}}">
                        <thead>    
                            <tr>
                                <th style="width: 52px;"><i>Hora</i></th>
                                <th>Lunes</th>
                                <th>Martes</th>
                                <th>Miercoles</th>
                                <th>Jueves</th>
                                <th>Viernes</th>
                                <th>Sábado</th>
                            </tr>
                        </thead>    
                        <tbody>
                            <!-- Items -->
                            <tr>
                                <td><b>10:00</b></td>
                                @for($i=1;$i<7;$i++)
                                <td>
                                    @if(isset($room[$i][10]))
                                    @foreach($room[$i][10] as $client)
                                    <label class="btn bg-yellow btn-xs" style="display:block;margin:0 auto;margin-bottom: 10px;" >{{$client}}</label>
                                    @endforeach
                                    @endif
                                </td>
                                @endfor
                            </tr>
                            <!-- -->
                            <tr>
                                <td><b>11:00</b></td>
                                @for($i=1;$i<7;$i++)
                                <td>
                                    @if(isset($room[$i][11]))
                                    @foreach($room[$i][11] as $client)
                                    <label class="btn bg-yellow btn-xs" style="display:block;margin:0 auto;margin-bottom: 10px;" >{{$client}}</label>
                                    @endforeach
                                    @endif
                                </td>
                                @endfor
                            </tr>
                            <!-- -->
                            <tr>
                                <td><b>12:00</b></td>
                                @for($i=1;$i<7;$i++)
                                <td>
                                    @if(isset($room[$i][12]))
                                    @foreach($room[$i][12] as $client)
                                    <label class="btn bg-yellow btn-xs" style="display:block;margin:0 auto;margin-bottom: 10px;" >{{$client}}</label>
                                    @endforeach
                                    @endif
                                </td>
                                @endfor
                            </tr>
                            <!-- -->
                            <tr>
                                <td><b>13:00</b></td>
                                @for($i=1;$i<7;$i++)
                                <td>
                                    @if(isset($room[$i][13]))
                                    @foreach($room[$i][13] as $client)
                                    <label class="btn bg-yellow btn-xs" style="display:block;margin:0 auto;margin-bottom: 10px;" >{{$client}}</label>
                                    @endforeach
                                    @endif
                                </td>
                                @endfor
                            </tr>
                            <!-- -->
                            <tr>
                                <td><b>14:00</b></td>
                                @for($i=1;$i<7;$i++)
                                <td>
                                    @if(isset($room[$i][14]))
                                    @foreach($room[$i][14] as $client)
                                    <label class="btn bg-yellow btn-xs" style="display:block;margin:0 auto;margin-bottom: 10px;" >{{$client}}</label>
                                    @endforeach
                                    @endif
                                </td>
                                @endfor
                            </tr>
                            <!-- -->
                            <tr>
                                <td><b>15:00</b></td>
                                @for($i=1;$i<7;$i++)
                                <td>
                                    @if(isset($room[$i][15]))
                                    @foreach($room[$i][15] as $client)
                                    <label class="btn bg-yellow btn-xs" style="display:block;margin:0 auto;margin-bottom: 10px;" >{{$client}}</label>
                                    @endforeach
                                    @endif
                                </td>
                                @endfor
                            </tr>
                            <!-- -->
                            <tr>
                                <td><b>17:15</b></td>
                                @for($i=1;$i<7;$i++)
                                <td>
                                    @if(isset($room[$i][17]))
                                    @foreach($room[$i][17] as $client)
                                    <label class="btn bg-yellow btn-xs" style="display:block;margin:0 auto;margin-bottom: 10px;" >{{$client}}</label>
                                    @endforeach
                                    @endif
                                </td>
                                @endfor
                            </tr>
                            <!-- -->
                            <tr>
                                <td><b>18:30</b></td>
                                @for($i=1;$i<7;$i++)
                                <td>
                                    @if(isset($room[$i][18]))
                                    @foreach($room[$i][18] as $client)
                                    <label class="btn bg-yellow btn-xs" style="display:block;margin:0 auto;margin-bottom: 10px;" >{{$client}}</label>
                                    @endforeach
                                    @endif
                                </td>
                                @endfor
                            </tr>
                            <!-- -->
                            <tr>
                                <td><b>19:30</b></td>
                                @for($i=1;$i<7;$i++)
                                <td>
                                    @if(isset($room[$i][19]))
                                    @foreach($room[$i][19] as $client)
                                    <label class="btn bg-yellow btn-xs" style="display:block;margin:0 auto;margin-bottom: 10px;" >{{$client}}</label>
                                    @endforeach
                                    @endif
                                </td>
                                @endfor
                            </tr>
                            <!-- -->
                            <tr>
                                <td><b>20:30</b></td>
                                @for($i=1;$i<7;$i++)
                                <td>
                                    @if(isset($room[$i][20]))
                                    @foreach($room[$i][20] as $client)
                                    <label class="btn bg-yellow btn-xs" style="display:block;margin:0 auto;margin-bottom: 10px;" >{{$client}}</label>
                                    @endforeach
                                    @endif
                                </td>
                                @endfor
                            </tr>
                            <!-- //Items -->
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
    @endforeach
</section>
<script>
    window.onload = function ()
    {
        jQuery(".sidebar-toggle").trigger("click");
        //convert every table into a datatable
        jQuery.each(jQuery(".tablaDatos"), function (index, obj) {
            jQuery("#" + obj.id).DataTable({
                dom: 'Bfrtip',
                paging: false,
                retrieve: true,
                buttons: [
                    'excel', 'pdf'
                ]
            });
        });
    };
</script> 
<style>
    .btn-group{
        left: 50%;
        margin-left: -30px;
    }
</style>
@stop
