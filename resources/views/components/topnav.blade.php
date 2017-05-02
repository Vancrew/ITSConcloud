<header class="main-header">
  <!-- Logo -->
  <a href="#" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>ITS</b>C</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>ITS</b>Concloud</span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
        @if (Auth::check())
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            {{-- <img src="../../dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> --}}
            <i class="fa fa-user visible-xs"></i>
            <span class="hidden-xs">{{Auth::user()->nama}}</span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              {{-- <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"> --}}
              <p>
                {{Auth::user()->nama}} - {{Auth::user()->jabatan}}
                <small>Member since {{date('M. Y', strtotime(Auth::user()->created_at))}}</small>
              </p>
            </li>
            <!-- Menu Body -->
            <li class="user-body">
              <div class="row">
                <div class="col-xs-4 text-center">
                  <a href="#">Followers</a>
                </div>
                <div class="col-xs-4 text-center">
                  <a href="#">Sales</a>
                </div>
                <div class="col-xs-4 text-center">
                  <a href="#">Friends</a>
                </div>
              </div>
              <!-- /.row -->
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="#" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="pull-right">
                <a href="{{url('logout')}}" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
        @else
        <li>
          <a href="{{url('login')}}">Login</a>
        </li>
        @endif
      </ul>
    </div>
  </nav>
</header>