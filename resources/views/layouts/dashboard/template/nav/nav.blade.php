<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>B</b>DB</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg-cm"><b class="logo-dashboard-font"><img src="{{ Voyager::image(setting('site.logo')) }}" class="logo-dashboard-size grayscale" alt="{{ setting('site.title') }}">DB</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                        <!-- The user image in the navbar-->
                        <img src="{{ $user_avatar }}" class="user-image" alt="User Image">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-sm hidden-xs text-bold">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="{{ $user_avatar }}" class="img-circle" alt="User Image">

                            <p class="text-bold">
                                {{ Auth::user()->title }}{{ Auth::user()->name }} - {{ Auth::user()->occupation }}
                                <small>Member since {{Auth::user()->registration_date()}}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#myModal">{{ __('Profile') }}</a>
                            </div>

                            <div class="pull-right">
                                <a href="{{ route('login.locked') }}" class="btn btn-default btn-flat"><i class="fa fa-lock"></i></a>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"
                                   class="btn btn-danger btn-flat"><i class="fa fa-power-off"></i></a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle animated swing" data-toggle="dropdown"><span class="glyphicon glyphicon-globe"></span><div class="ripple-container"></div></a>
                    <ul class="dropdown-menu" role="menu">
                        @if( __('Arabic') == 'Arabic')
                            <li class="{{ __('text-left') }}"><a href="{{ url('lang/ar') }}"><i class="fa fa-language" aria-hidden="true"></i> {{ __('Arabic') }}</a></li>
                        @else
                            <li class="{{ __('text-left') }}"><a href="{{ url('lang/en') }}"><i class="fa fa-language" aria-hidden="true"></i> {{ __('English') }}</a></li>
                        @endif
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<!-- =============================================== -->
