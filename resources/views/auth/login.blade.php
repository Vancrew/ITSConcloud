<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>
    ITS Concloud
  </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap -->
  <link href="{{url('bower_components/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{url('bower_components/gentelella/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
  <!-- AdminLTE -->
  <link href="{{url('bower_components/AdminLTE/dist/css/AdminLTE.min.css')}}" rel="stylesheet">
</head>
<body class="hold-transition skin-green login-page" style="background-color: #1a2226">
<div class="login-box">
  <br><br>
  <div class="login-logo">
    <a href="#" style="color:#ddd"><b>ITS</b>Concloud</a>
  </div>
  <!-- /.login-logo -->
  <div class="box box-primary">
  <div class="login-box-body">
    <div class="alert alert-danger hidden" role="alert">
      <button type="button" class="close close-alert"><span aria-hidden="true">&times;</span></button>
      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
      <span class="sr-only">Error:</span> Username atau password salah!
    </div>
    <div class="alert alert-info hidden" role="alert">
      <button type="button" class="close close-alert"><span aria-hidden="true">&times;</span></button>
      <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
      <span class="sr-only">Success:</span> Berhasil login, mohon tunggu.
    </div>
    <form id="form-login">
      <div class="form-group has-feedback">
        <input type="text" id="username" class="form-control" placeholder="Username" required="required">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" id="password" class="form-control" placeholder="Password" required="required">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
        <a href="#" class="text-primary">Lupa Password ?</a><br>
        </div>
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
        </div>
      </div>
    </form>
  </div>
  <div class="overlay dark hidden">
    <i class="fa fa-refresh fa-spin"></i>
  </div>
  </div>
</div>
</body>

<!-- jQuery -->
<script src="{{url('bower_components/gentelella/vendors/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{url('bower_components/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE -->
<script src="{{url('bower_components/AdminLTE/dist/js/app.min.js')}}"></script>

<script>
  $(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    /* Kasih close untuk alert */
    $(".close-alert").click(function() {
      $(this).parent().addClass('hidden');
    })

    /* logging in */
    $("#form-login").submit(function(e) {
      e.preventDefault();
      $(".overlay").removeClass("hidden");
      $.ajax({
        url: "{{url('login')}}",
        type: 'post',
        dataType: 'json',
        data: {
          username: $("#username").val(),
          password: $("#password").val()
        },
      })
      .always(function(response) {
        $(".overlay").addClass("hidden");
      })
      .done(function(response) {
        $(".alert").addClass("hidden");
        if (response.status) {
          $(".alert-info").removeClass("hidden");
          window.location = '{{url('/')}}';
        } else {
          $(".alert-danger").removeClass("hidden");
        }
      })
      .fail(function(response) {
        $(".alert").addClass("hidden");
        if (response.status == 401) {
          $(".alert-danger").removeClass("hidden");
        }
      });
    });
  });
</script>
</html>
