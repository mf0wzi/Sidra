<footer dir="{{ __('ltr') }}" class="main-footer brave-border">
    <div class="{{ __('pull-right') }} hidden-xs">
        <b> <a href="{{ url('https://smeps.org.ye/') }}"><img src="{{ asset('images/Smeps.png') }}" alt="{{ __('SMEPS') }}" height="25" width="25" data-toggle="popovers" data-trigger="hover" data-container="body" data-placement="left" data-html="true" title="Hello!!" data-content="We are <code>SMEPS</code>"></a></b>
    </div>
    <strong>{{ __('Copyright © 2017-') }}{{ date('Y') }} <a href="{{ url('/') }}" class="text-brave">{{ config('app.name', 'Dashboard') }}{{ __(' - V2.0') }}</a>.</strong> {{ __('All rights reserved.') }}
</footer>
