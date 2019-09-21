@php
    if(Auth::guest()){
       header("Location: /");
       die();
    }
        $user_avatar = asset('images/circle_lock.png');
        if (starts_with(Auth::user()->avatar, 'http://') || starts_with(Auth::user()->avatar, 'https://')) {
            $user_avatar = Auth::user()->avatar;
        } else {
            $user_avatar = Voyager::image(Auth::user()->avatar);
        }
@endphp
<!DOCTYPE html>
<html>
<head>
    @include('layouts.home.assets.meta.meta')
    @include('layouts.home.assets.css.css')
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
@yield('content')
@include('layouts.home.assets.script.script')
</body>
</html>
