<!DOCTYPE html>
<html lang="en" ng-app="itsconloud">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base_url" content="{{url('/')}}">

    <title>ITS Concloud @yield('title')</title>

    <!-- Bootstrap -->
    <link href="{{url('bower_components/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{url('bower_components/gentelella/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- AdminLTE -->
    <link href="{{url('bower_components/AdminLTE/dist/css/AdminLTE.min.css')}}" rel="stylesheet">
    <link href="{{url('bower_components/AdminLTE/dist/css/skins/_all-skins.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{url('bower_components/gentelella/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{url('bower_components/gentelella/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="{{url('bower_components/gentelella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">
    <!-- jVectorMap -->
    <link href="{{url('bower_components/gentelella/production/css/maps/jquery-jvectormap-2.0.3.css')}}" rel="stylesheet">
    <!-- sweetalert -->
    <link href="{{url('bower_components/sweetalert/dist/sweetalert.css')}}" rel="stylesheet">

    <!-- MY CSS -->
    <link href="{{url('css/style.css')}}" rel="stylesheet">
    @yield('css')

  </head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  @include('components.topnav')
  @include('components.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        @yield('content-title')
      </h1>
      @yield('content-breadcrumb')
    </section>
    <section class="content">
      @yield('content')
    </section>
  </div>

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.3.7
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
    reserved.
  </footer>
</div>

<!-- moment -->
<script src="{{url('bower_components/gentelella/vendors/moment/moment.js')}}"></script>
<!-- jQuery -->
<script src="{{url('bower_components/gentelella/vendors/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{url('bower_components/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- NProgress -->
<script src="{{url('bower_components/gentelella/vendors/nprogress/nprogress.js')}}"></script>
<!-- iCheck -->
<script src="{{url('bower_components/gentelella/vendors/iCheck/icheck.min.js')}}"></script>
<!-- AdminLTE -->
<script src="{{url('bower_components/AdminLTE/dist/js/app.min.js')}}"></script>
<!-- sweetalert -->
<script src="{{url('bower_components/sweetalert/dist/sweetalert.min.js')}}"></script>
<!-- Angular -->
<script src="{{url('bower_components/angular/angular.min.js')}}"></script>

<script src="{{url('js/app.js')}}"></script>

@yield('js')
</body>
</html>