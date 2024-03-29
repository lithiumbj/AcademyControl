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
      <link rel="stylesheet" href="{{URL::to('/')}}/plugins/iCheck/square/blue.css">

      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>
    <body class="hold-transition login-page">
      <div class="login-box">
        <div class="login-logo">
          <img style="width: 220px;" src="{{URL::to('/img/logo.png')}}"/>
        </div><!-- /.login-logo -->
        <div class="login-box-body">
          <p class="login-box-msg">Debe iniciar sesión para continuar</p>
          <form action="{{URL::to('/auth/login')}}" method="post">
            {!! csrf_field() !!}
            <div class="form-group has-feedback">
              <input class="form-control" name="email" placeholder="Email" type="email">
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              <input class="form-control" placeholder="Password" name="password" type="password">
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
              <div class="col-xs-8">
                
              </div><!-- /.col -->
              <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
              </div><!-- /.col -->
            </div>
          </form>

          <a href="#" onclick="alert('Debe ponerse en contacto con soporte para reestablecer su contraseña')">Olvidé mi contraseña</a><br>

        </div><!-- /.login-box-body -->
      </div><!-- /.login-box -->

      <!-- jQuery 2.1.4 -->
      <script src="{{URL::to('/')}}/plugins/jQuery/jQuery-2.1.4.min.js"></script>
      <!-- Bootstrap 3.3.5 -->
      <script src="{{URL::to('/')}}/bootstrap/js/bootstrap.min.js"></script>
      <!-- iCheck -->
      <script src="{{URL::to('/')}}/plugins/iCheck/icheck.min.js"></script>
      <script>
        $(function () {
          $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
          });
        });
      </script>
      <style>
          body{
              background-image: url('{{URL::to("/img/lbg.png")}}') !important;
              background-size: cover;
          }
      </style>
  </body>
</html>
