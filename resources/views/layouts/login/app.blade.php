<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('img/icons/2023-05-01/m.png')}}" type="image/x-icon">
    <title>@yield('title')</title>

    <link href="{{asset('plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('plugins/fontawesome/css/all.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/themify-icons/themify-icons.css')}}" rel="stylesheet">
    <link href="{{asset('dist/css/login.css')}}" rel="stylesheet" type="text/css" />
</head>

<body class="bg-white body-bg">
    <main class="register-content">
        @yield('content')
    </main>

    <script data-cfasync="false" src="http://localhost/fleet/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="{{asset('plugins/jQuery/jquery-3.4.1.min.js')}}"></script>

    <script src="{{asset('dist/js/popper.min.js')}}"></script>
    <script src="{{asset('plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('dist/js/classie.js')}}" type="text/javascript"></script>
    <!-- <script src="{{asset('dist/js/login.js')}}" type="text/javascript"></script> -->
    <script src="{{asset('dist/js/password.js')}}" type="text/javascript"></script>

    @yield('js-content')
</body>

</html>