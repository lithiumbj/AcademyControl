<!DOCTYPE html>
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
    <link rel="stylesheet" href="{{URL::to('/')}}/plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="{{URL::to('/')}}/plugins/datatables/jquery.dataTables.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-lg"><b>Inforfenix</b> ERP</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="{{URL::to('/img/'.Auth::user()->id.'.png')}}" class="user-image" alt="User Image">
                  <span class="hidden-xs">{{Auth::user()->name}}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="{{URL::to('/img/'.Auth::user()->id.'.png')}}" class="img-circle" alt="User Image">
                    <p>
                      {{Auth::user()->name}}
                      <small>{{Auth::user()->created_at}}</small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="{{URL::to('/settings')}}" class="btn btn-default btn-flat">Ajustes</a>
                    </div>
                    <div class="pull-right">
                      <a href="{{URL::to('/auth/logout')}}" class="btn btn-default btn-flat">Cerrar sesión</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>

        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="{{URL::to('/images')}}/{{Auth::user()->id}}.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>{{Auth::user()->name}}</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>

          <!-- Role checking -->
          @if(Auth::user()->fk_role == 1 || Auth::user()->fk_role == 2 || Auth::user()->fk_role == 3)
          <!-- search form -->
          <form action="{{URL::to('/client/search')}}" method="post" class="sidebar-form">
            {!! csrf_field() !!}
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Buscar alumnos">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          @endif
          <!-- //Role checking -->

          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>

            <!-- Role checking -->
            @if(Auth::user()->fk_role == 1 || Auth::user()->fk_role == 2)
            <!-- Element -->
            <li class="treeview">
              <a href="{{URL::to('/')}}">
                <i class="fa fa-tachometer"></i>
                <span>Inicio</span>
              </a>
            </li>
            <!-- //Element -->
            @endif

            <!-- Role checking -->
            @if(Auth::user()->fk_role == 1 || Auth::user()->fk_role == 2 || Auth::user()->fk_role == 3)
            <!-- Element -->
            <li class="treeview">
              <a href="{{URL::to('/teacher/view')}}">
                <i class="fa fa-tachometer"></i>
                <span>Vista profesor</span>
              </a>
            </li>
            <!-- //Element -->
            @endif
            <!-- Role checking -->
            @if(Auth::user()->fk_role == 1 || Auth::user()->fk_role == 2 || Auth::user()->fk_role == 3)
            <!-- Element -->
            <li class="treeview">
              <a href="#">
                <i class="fa fa-users"></i>
                <span>Clientes</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{URL::to('/client/create')}}"><i class="fa fa-circle-o"></i> Crear cliente</a></li>
                <li><a href="{{URL::to('/client/list/1')}}"><i class="fa fa-circle-o"></i> Listar clientes</a></li>
                <li><a href="{{URL::to('/client/list/0')}}"><i class="fa fa-circle-o"></i> Listar informaciones</a></li>
                <li><a href="{{URL::to('/client/list/2')}}"><i class="fa fa-circle-o"></i> Listar ex-clientes</a></li>
                <!-- Role checking -->
                @if(Auth::user()->fk_role == 1 || Auth::user()->fk_role == 2)
                <li><a href=""><i class="fa fa-circle-o"></i> Control de bajas</a></li>
                <li><a href=""><i class="fa fa-circle-o"></i> Control de altas</a></li>
                <li><a href="{{URL::to('/invoice/generate')}}"><i class="fa fa-plus"></i> Generar recibos</a></li>
                @endif
              </ul>
            </li>
            <!-- //Element -->
            @endif

            <!-- Role checking -->
            @if(Auth::user()->fk_role == 1 || Auth::user()->fk_role == 2)
            <!-- Element -->
            <li class="treeview">
              <a href="#">
                <i class="fa fa-cart-plus"></i>
                <span>Proveedores</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{URL::to('/provider/create')}}"><i class="fa fa-circle-o"></i> Crear proveedor</a></li>
                <li><a href="{{URL::to('/provider/')}}"><i class="fa fa-circle-o"></i> Listado de proveedores</a></li>
                <li><a href="{{URL::to('/provider_invoice')}}"><i class="fa fa-circle-o"></i> Facturas de proveedor</a></li>
              </ul>
            </li>
            <!-- //Element -->
            @endif

            <!-- Role checking -->
            @if(Auth::user()->fk_role == 1 || Auth::user()->fk_role == 2 || Auth::user()->fk_role == 3)
            <!-- Element -->
            <li class="treeview">
              <a href="#">
                <i class="fa fa-money"></i>
                <span>Control de caja</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              <!-- Role checking -->
              @if(Auth::user()->fk_role == 1 || Auth::user()->fk_role == 2 || Auth::user()->fk_role == 3)
                <li><a href="{{URL::to('/cashflow/open')}}"><i class="fa fa-circle-o"></i> Apertura de caja</a></li>
                <li><a href="{{URL::to('/cashflow/close')}}"><i class="fa fa-circle-o"></i> Cierre de caja</a></li>
                <li><a href="{{URL::to('/cashflow')}}"><i class="fa fa-circle-o"></i> Ver estado de caja</a></li>
              @endif
                <li><a href="{{URL::to('/cashflow/exit')}}"><i class="fa fa-circle-o"></i> Salida de caja</a></li>
              </ul>
            </li>
            <!-- //Element -->
            @endif

            <!-- Role checking -->
            @if(Auth::user()->fk_role == 1 || Auth::user()->fk_role == 2 || Auth::user()->fk_role == 3)
            <li class="treeview">
              <a href="#">
                <i class="fa fa-money"></i>
                <span>Recibos</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{URL::to('/invoice')}}"><i class="fa fa-circle-o"></i> Listado</a></li>
                <!-- Role checking -->
                @if(Auth::user()->fk_role == 1 || Auth::user()->fk_role == 2)
                <li><a href="{{URL::to('/invoice/generate')}}"><i class="fa fa-plus"></i> Generar recibos</a></li>
                @endif
              </ul>
            </li>
            @endif

            <!-- Role checking -->
            @if(Auth::user()->fk_role == 1 || Auth::user()->fk_role == 2)
            <!-- Element -->
            <li class="treeview">
              <a href="#">
                <i class="fa fa-briefcase"></i>
                <span>Empleados</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href=""><i class="fa fa-circle-o"></i> Dar de alta</a></li>
                <li><a href=""><i class="fa fa-circle-o"></i> Ver costes</a></li>
              </ul>
            </li>
            <!-- //Element -->
            @endif

            <!-- Role checking -->
            @if(Auth::user()->fk_role == 1 || Auth::user()->fk_role == 2 || Auth::user()->fk_role == 3)
            <!-- Element -->
            <li class="treeview">
              <a href="{{URL::to('/rooms')}}">
                <i class="fa fa-object-group"></i>
                <span>Aulas / Horarios</span>
              </a>
            </li>
            <!-- //Element -->
            @endif

            <!-- Role checking -->
            @if(Auth::user()->fk_role == 1 || Auth::user()->fk_role == 2)
            <!-- Element -->
            <li class="treeview">
              <a href="{{URL::to('/services/')}}">
                <i class="fa fa-server"></i>
                <span>Servicios</span>
              </a>
            </li>
            <!-- //Element -->
            @endif

            </li>
            <!-- //Element -->

            <!-- Role checking -->
            @if(Auth::user()->fk_role == 1 || Auth::user()->fk_role == 2)
            <!-- Element -->
            <li class="treeview">
              <a href="#">
                <i class="fa fa-bar-chart"></i>
                <span>Estadísticas</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{URL::to('/stats/new_clients')}}"><i class="fa fa-circle-o"></i> Nuevos clientes</a></li>
                <li><a href="{{URL::to('/stats/new_infos')}}"><i class="fa fa-circle-o"></i> Informaciones</a></li>
              </ul>
            </li>
            <!-- //Element -->
            @endif


            <!-- Role checking -->
            @if(Auth::user()->fk_role == 1 || Auth::user()->fk_role == 2)
            <!-- Element -->
            <li class="treeview">
              <a href="#">
                <i class="fa fa-exclamation"></i>
                <span>Incidencias</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{URL::to('/incidence/client')}}"><i class="fa fa-circle-o"></i> Incidencias (Alumnos)</a></li>
                <li><a href="{{URL::to('/assistance/list')}}"><i class="fa fa-circle-o"></i> Faltas de asistencia</a></li>
              </ul>
            </li>
            <!-- //Element -->
            @endif

          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        @yield('content')
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 3.0.0
        </div>
        <strong>Copyright &copy; 2015 <a href="http://inforfenix.com">Inforfenix</a>.</strong> Centro de formación
      </footer>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
          <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                    <p>Will be 23 on April 24th</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-user bg-yellow"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
                    <p>New phone +1(800)555-1234</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
                    <p>nora@example.com</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-file-code-o bg-green"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
                    <p>Execution time 5 seconds</p>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Custom Template Design
                    <span class="label label-danger pull-right">70%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Update Resume
                    <span class="label label-success pull-right">95%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Laravel Integration
                    <span class="label label-warning pull-right">50%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Back End Framework
                    <span class="label label-primary pull-right">68%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

          </div><!-- /.tab-pane -->
          <!-- Stats tab content -->
          <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
              <h3 class="control-sidebar-heading">General Settings</h3>
              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Report panel usage
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Some information about this general settings option
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Allow mail redirect
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Other sets of options are available
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Expose author name in posts
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Allow the user to show his name in blog posts
                </p>
              </div><!-- /.form-group -->

              <h3 class="control-sidebar-heading">Chat Settings</h3>

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Show me as online
                  <input type="checkbox" class="pull-right" checked>
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Turn off notifications
                  <input type="checkbox" class="pull-right">
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Delete chat history
                  <a href="javascript::;" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                </label>
              </div><!-- /.form-group -->
            </form>
          </div><!-- /.tab-pane -->
        </div>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- Datatables -->
    <script></script>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="{{URL::to('/')}}/plugins/datatables/jquery.dataTables.js"></script>
    <script src="{{URL::to('/')}}/plugins/datatables/dataTables.bootstrap.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{URL::to('/')}}/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{URL::to('/')}}/js/angular.js"></script>
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
  </body>
</html>
