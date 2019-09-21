<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="{{ __('voyager::generic.is_rtl') == 'true' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="none" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="admin login">
    <title>Admin - {{ Voyager::setting("admin.title") }}</title>
    <link rel="shortcut icon" href="{{ asset('storage/favi.png') }}">
    <link rel="stylesheet" href="{{ voyager_asset('css/app.css') }}">
    @if (__('voyager::generic.is_rtl') == 'true')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.css">
        <link rel="stylesheet" href="{{ voyager_asset('css/rtl.css') }}">
    @endif
    @php
        $background = array("images/brave/bg01.jpg", "images/brave/bg02.jpg", "images/brave/bg03.jpg", "images/brave/bg04.jpg", "images/brave/bg05.jpg", "images/brave/bg06.jpg","images/brave/bg07.jpg","images/brave/bg08.jpg","images/brave/bg09.jpg","images/brave/bg10.jpg","images/brave/bg11.jpg","images/brave/bg12.jpg","images/brave/bg13.jpg","images/brave/bg14.jpg");
        $index = rand(0, count($background) - 1); // This variable declaration generates a random number that's within the size of the array
        $randomBackground = $background[$index]; // This sets the variable equal to a random filename chosen from the background array
    @endphp
    <style>
        body {
            background-image:url('{{ Voyager::image( Voyager::setting("admin.bg_image"), asset($randomBackground) ) }}');
            background-color: {{ Voyager::setting("admin.bg_color", "#FFFFFF" ) }};
        }
        body.login .login-sidebar {
            /*border-top:5px solid #F9C862;*/
            border-top:5px solid;
            border-image-source: linear-gradient(254deg, rgba(245,169,50,1) 8%, rgba(249,200,98,1) 65%);
            border-image-slice: 1;
        {{--border-top:5px solid {{ config('voyager.primary_color','#F9C862') }};--}}
}
        @media (max-width: 767px) {
            body.login .login-sidebar {
                border-top:0px !important;
                border-left:5px solid;
                border-image-source: linear-gradient(254deg, rgba(245,169,50,1) 8%, rgba(249,200,98,1) 65%);
                border-image-slice: 1;
                /*border-left:5px solid #F9C862;*/
            {{--border-left:5px solid {{ config('voyager.primary_color','#F9C862') }};--}}
}
        }
        body.login .form-group-default.focused{
            {{--border-color:{{ config('voyager.primary_color','#F9C862') }};--}}
            border-color: #F9C862;
        }
        .login-button, .bar:before, .bar:after{
            {{--background:{{ config('voyager.primary_color','#22A7F0') }};--}}
            background: linear-gradient(254deg, rgba(245,169,50,1) 8%, rgba(249,200,98,1) 65%) !important;
        }
        .btn-rounded {
            border-radius: 40px;
        }
        .remember-me-text{
            padding:0 5px;
        }
    </style>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
</head>
<body class="login">
<div class="container-fluid">
    <div class="row">
        <div class="faded-bg animated"></div>
        <div class="hidden-xs col-sm-7 col-md-8">
            <div class="clearfix">
                <div class="col-sm-12 col-md-10 col-md-offset-2">
                    <div class="logo-title-container">
                        <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>
                        @if($admin_logo_img == '')
                            <img class="img-responsive pull-left flip logo hidden-xs animated fadeIn" src="{{ voyager_asset('images/logo-icon-light.png') }}" alt="Logo Icon">
                        @else
                            <img class="img-responsive pull-left flip logo hidden-xs animated fadeIn" src="{{ Voyager::image($admin_logo_img) }}" alt="Logo Icon">
                        @endif
                        <div class="copy animated fadeIn">
                            <h1>{{ Voyager::setting('admin.title', 'BRAVE') }}</h1>
                            <p>{{ Voyager::setting('admin.description', __('voyager::login.welcome')) }}</p>
                        </div>
                    </div> <!-- .logo-title-container -->
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-5 col-md-4 login-sidebar">

            <div class="login-container">

                <p>{{ __('voyager::login.signin_below') }}</p>

                <form action="{{ route('login') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group form-group-default" id="emailGroup">
                        <label>{{ __('voyager::generic.email') }}</label>
                        <div class="controls">
                            <input type="text" name="email" id="email" value="{{ old('email') }}" placeholder="{{ __('voyager::generic.email') }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group form-group-default" id="passwordGroup">
                        <label>{{ __('voyager::generic.password') }}</label>
                        <div class="controls">
                            <input type="password" name="password" placeholder="{{ __('voyager::generic.password') }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group" id="rememberMeGroup">
                        <div class="controls">
                            <input type="checkbox" name="remember" value="1"><span class="remember-me-text">{{ __('voyager::generic.remember_me') }}</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-block btn-rounded login-button" style="border-radius: 40px;font-weight: bold;color: black;">
                        <span class="signingin text-bold text-black hidden"><span class="voyager-refresh"></span> {{ __('voyager::login.loggingin') }}...</span>
                        <span class="signin text-bold text-black">{{ __('voyager::generic.login') }}</span>
                    </button>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>


                </form>

                <div style="clear:both"></div>

                @if(!$errors->isEmpty())
                    <div class="alert alert-red">
                        <ul class="list-unstyled">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div> <!-- .login-container -->

        </div> <!-- .login-sidebar -->
    </div> <!-- .row -->
</div> <!-- .container-fluid -->
<script>
    var btn = document.querySelector('button[type="submit"]');
    var form = document.forms[0];
    var email = document.querySelector('[name="email"]');
    var password = document.querySelector('[name="password"]');
    btn.addEventListener('click', function(ev){
        if (form.checkValidity()) {
            btn.querySelector('.signingin').className = 'signingin';
            btn.querySelector('.signin').className = 'signin hidden';
        } else {
            ev.preventDefault();
        }
    });
    email.focus();
    document.getElementById('emailGroup').classList.add("focused");

    // Focus events for email and password fields
    email.addEventListener('focusin', function(e){
        document.getElementById('emailGroup').classList.add("focused");
    });
    email.addEventListener('focusout', function(e){
        document.getElementById('emailGroup').classList.remove("focused");
    });

    password.addEventListener('focusin', function(e){
        document.getElementById('passwordGroup').classList.add("focused");
    });
    password.addEventListener('focusout', function(e){
        document.getElementById('passwordGroup').classList.remove("focused");
    });

</script>
</body>
</html>
