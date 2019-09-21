<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.home.assets.meta.meta')
    @include('layouts.home.assets.css.css')
    @if(!Auth::guest())
        <script>window.location = "/home";</script>
    @endif
    <style>
        html, body {
            position: relative;
            /*background: linear-gradient(255deg, rgb(245, 176, 38) 20%, rgb(255, 255, 255) 65%) !important;*/
            margin: 0;
            border: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
        body {
            overflow: auto;
        }
        .parent {
            height: 1000px;
            margin: 0;
            border: 0;
            padding: 0;
            overflow: hidden;
            position: relative;
        }
        .dot {
            display: inline-block;
            background: linear-gradient(55deg, rgb(245, 176, 38) 20%, rgba(249,200,98,1) 70%) !important;
            position: fixed;
            left: 50%;
            height: 150%;
            width: 70%;
            border: 0;
            border-radius: 100%;
            bottom:-25%;
            -webkit-box-shadow: -5px 6px 48px -18px rgba(0,0,0,0.75);
            -moz-box-shadow: -5px 6px 48px -18px rgba(0,0,0,0.75);
            box-shadow: -5px 6px 48px -18px rgba(0,0,0,0.75);
        }
        .dot2 {
            display: inline-block;
            background: linear-gradient(225deg, rgb(1, 3, 94) 8%, rgb(1, 3, 134) 65%) !important;
            position: fixed;
            right: 85%;
            height: 50%;
            width: 25%;
            border-radius: 100%;
            bottom:-25%;
            -webkit-box-shadow: 17px -12px 110px -56px rgba(0,0,0,0.75);
            -moz-box-shadow: 17px -12px 110px -56px rgba(0,0,0,0.75);
            box-shadow: 17px -12px 110px -56px rgba(0,0,0,0.75);
        }
        .blurred-box{
            position: fixed;
            height: 85%;
            width: 95%;
            margin-top: 3.9%;
            margin-right: 2.5%;
            margin-left: 2.5%;
            border: 0;
            overflow: hidden;
            background: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.2));
            /*opacity: 0.9;*/
            /*filter: alpha(opacity=90); !* For IE8 and earlier *!*/
        }

        .card {
            /*min-height: 100%;*/
            /*min-width: 10%;*/
        }

        .card-body-custom {
            margin-top: 2%;
            margin-right: 4%;
            margin-left: 4%;
        }

        .card-header-custom {
            border: 0;
            margin-top: 2%;
            margin-right: 4%;
            margin-left: 4%;
            background: linear-gradient(rgba(0,0,0,0.0), rgba(0,0,0,0.0));
        }

        .card-footer-custom {
            position: relative;
            border: 0;
            margin-top: 2%;
            margin-right: 4%;
            margin-left: 4%;
            top: -50%;
            z-index: 9999;
            background: linear-gradient(rgba(0,0,0,0.0), rgba(0,0,0,0.0));
        }

        .font-size-header {
            font-size: 1.9vw;
        }

        .font-size-body {
            overflow: hidden;
            text-overflow: ellipsis;
            -webkit-line-clamp: 8;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            font-size: 1.0vw;
            width: 60%;
            height: 50%;
        }

        .btn-rounded {
            border-radius: 40px;
        }

        .btn-brave {
            border: solid 1px rgb(245, 176, 38);
            background: linear-gradient(254deg, rgba(245,169,50,1) 8%, rgba(249,200,98,1) 65%) !important;
            color: black;
            height: 3vw;
            width: 8vw;
        }

        .btn-brave-font {
            position: absolute;
            font-weight: bold;
            font-size: 1.0vw;
            top: 50%;
            left: 5.5%;
            transform: translate(-50%, -50%);
        }

        .img-responsive {
            width: 8%;
        }

        .home-isomatric {
            position: relative !important;
            margin-top: -25% !important;
            /*top: 10% !important;*/
            right: 40% !important;
            height: 100% !important;
            width: 150% !important;
            -webkit-transform: scaleX(-1);
            transform: scaleX(-1);
        }
    </style>
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="home-background">
<div class="card blurred-box shadow-lg" style="z-index: 999;">
    <div class="card-header card-header-custom">
        <img class="img-responsive" src="{{ asset('storage/img/Brave-black.png') }}" width="100" height="100">
    </div>
    <div class="card-body card-body-custom">
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                <h3 class="card-title text-black text-bold font-size-header" style="line-height: 20%;">WELCOME TO</h3>
                <h3 class="card-title text-black text-bold font-size-header">BRAVE DASHBOARD</h3><br>
                <p class="card-text font-size-body">Here we will find some statistics showing BRAVE projects progress
                </p>
            </div>

            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 animated fadeInRight slow">
                <img src="{{ asset('images/home/home-dashboard-min.png') }}" class="home-isomatric">
            </div>
        </div>
    </div>
    <div class="card-footer card-footer-custom animated fadeIn slow">
	@if(! Auth::check())
        <a href="{{ route('login') }}" class="btn btn-primary btn-brave btn-rounded shadow"><span class="btn-brave-font">{{ __('Login Here') }}</span></a>
	@else
		<a href="{{ route('home') }}" class="btn btn-primary btn-brave btn-rounded shadow"><span class="btn-brave-font">{{ __('Home Here') }}</span></a>
	@endif
    </div>
</div>
<div class="parent"><span class="dot animated fadeInRight slow"></span></div>
<div class="parent"><span class="dot2 animated fadeInUp slow"></span></div>
</body>
</html>
