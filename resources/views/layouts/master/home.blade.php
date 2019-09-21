<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.home.assets.meta.meta')
    @include('layouts.home.assets.css.css')
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-brave layout-top-nav">
<div class="wrapper">
    @include('layouts.home.template.nav.nav')
    <div id="app" class="content-wrapper">
        <div class="container">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    @yield('page_title')
                </h1>
                @include('layouts.home.template.breadcrumb.breadcrumb')
            </section>
            <!-- Main content -->
            <section dir="{{ __('ltr') }}" class="content">
                @yield('content')
            </section>
        </div>
    @guest

    @else
        <!-- Modal -->
            <div id="myModal" class="modal modal-info fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Modal Header</h4>
                        </div>
                        <div class="modal-body">
                            <p>Some text in the modal.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
        @endguest
    </div>
    @include('layouts.home.template.footer.footer')
</div>
<!-- ./wrapper -->

@include('layouts.home.assets.script.script')


</body>
</html>
