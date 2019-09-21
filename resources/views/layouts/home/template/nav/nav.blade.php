@guest
@else
    @php
        if (starts_with(Auth::user()->avatar, 'http://') || starts_with(Auth::user()->avatar, 'https://')) {
            $user_avatar = Auth::user()->avatar;
        } else {
            $user_avatar = Voyager::image(Auth::user()->avatar);
        }
        $current_page = 'current_page_'.Auth::user()->id;
        Session::forget($current_page);
        Session::put($current_page,'/home');
    @endphp
@endguest
<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a href="@guest{{ url('/') }}@else{{ url('/home') }}@endguest" class="navbar-brand"><b class="logo-font"><img src="{{ Voyager::image(setting('site.logo')) }}" class="logo-size grayscale" alt="{{ setting('site.title') }}"> DB</b></a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <div id="navbar-collapse" class="collapse navbar-collapse pull-right">
            </div>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Authentication Links -->
                    @guest
                        <li><a href="{{ route('login') }}" class="animated swing"><span class="glyphicon glyphicon-log-in"></span><b>{{ __(' Login') }}</b><div class="ripple-container"></div></a></li>
                    @else

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
                    @endguest
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
                </ul>
            </div>
        </div>
        <!-- /.container-fluid -->

    </nav>
</header>
<!-- Full Width Column -->
