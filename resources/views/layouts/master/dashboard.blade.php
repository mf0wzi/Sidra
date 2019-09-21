@php
    if(Auth::guest()){
       header("Location: /");
       die();
    }
        if (starts_with(Auth::user()->avatar, 'http://') || starts_with(Auth::user()->avatar, 'https://')) {
            $user_avatar = Auth::user()->avatar;
        } else {
            $user_avatar = Voyager::image(Auth::user()->avatar);
        }

        $home = 'Home';
        $dashboard = Request::segment(1);
        $project_name = Request::segment(2);
        $page_name = Request::segment(3);
        $url = '/'.$dashboard.'/'.$project_name.'/'.$page_name;
        $current_page = 'current_page_'.Auth::user()->id;
        Session::forget($current_page);
        Session::put($current_page,$url);
@endphp
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.dashboard.assets.meta.meta')
    <title>{{ config('app.name', 'Laravel') }}</title>
    @include('layouts.dashboard.assets.css.css')
</head>
<body class="hold-transition @if($project_name == 'bravewomen' || $project_name == 'brave-women' || $project_name == 'brave_women') skin-brave-women @else skin-brave @endif fixed sidebar-mini">
<div id="app" class="wrapper">
@include('layouts.dashboard.template.nav.nav')

<!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ $user_avatar }}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    @if(Auth::user()->isOnline())
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    @else
                        <a href="#"><i class="fa fa-circle text-gray"></i> Offline</a>
                    @Endif
                </div>
            </div>
            <!-- Sidebar user panel -->
            {{--@include('layouts.dashboard.sidebar')--}}
            {!! menu($project_name, 'layouts.dashboard.template.sidebar.sidebar') !!}
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Welcome to <a class="alert alert-brave alert-brave-small text-black text-bold">{{ strtoupper(str_replace("_"," ",$project_name)) }}</a>
                <small>Dashboard {{ $page_name }}</small>
            </h1>
            @include('layouts.dashboard.template.breadcrumb.breadcrumb')

        </section>

        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
        <!-- /.content -->
    </div>

@include('layouts.dashboard.template.footer.footer')
<!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
@include('layouts.dashboard.assets.script.script')
@yield('chartjs')
@yield('datatables')
@yield('leafletFunction')
@yield('leaflet')
</body>
</html>
