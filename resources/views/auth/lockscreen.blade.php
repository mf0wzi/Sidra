@extends('layouts.master.lockscreen')

@section('content')
    <div class="lockscreen-wrapper">
        <div class="lockscreen-logo">
            <img src="{{ asset('images/brave_black.png') }}" class="logo-dashboard-size grayscale" alt="{{ setting('site.title') }}">
        </div>

        <!-- User name -->
        <div class="lockscreen-name text-bold">{{ Auth::user()->name }}</div>

        <!-- START LOCK SCREEN ITEM -->
        <div class="lockscreen-item">
            <!-- lockscreen image -->
            <div class="lockscreen-image-away">
                <img src="{{ Voyager::image(Auth::user()->avatar) }}" alt="User Image">
            </div>
            <!-- /.lockscreen-image -->

            <!-- lockscreen credentials (contains the form) -->
            <form method="POST" class="lockscreen-credentials" action="{{ route('login.unlock') }}" aria-label="{{ __('Locked') }}">
                @csrf                        <div class="input-group">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password Here" required>@if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                    <div class="input-group-btn">
                        <button type="submit" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.lockscreen-item -->
        <div class="help-block text-center">
            Enter your password to retrieve your session
        </div>
        <div class="text-center">
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"
                >{{ __('Or sign in as a different user') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
        </div>
        <div class="lockscreen-footer text-center">
            <b> <a href="{{ url('https://smeps.org.ye/') }}"><img src="{{ asset('images/Smeps.png') }}" alt="{{ __('SMEPS') }}" height="25" width="25" data-toggle="popovers" data-trigger="hover" data-container="body" data-placement="left" data-html="true" title="Hello!!" data-content="We are <code>SMEPS</code>"></a></b>
            {{ __('Copyright © 2017-') }}{{ date('Y') }} <a href="{{ url('/') }}" class="text-brave">{{ config('app.name', 'Dashboard') }}{{ __(' - V2.0') }}</a>.</strong> {{ __('All rights reserved.') }}
        </div>
    </div>
    <!-- /.center -->
@endsection
