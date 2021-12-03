<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?= "https://".$_SERVER['HTTP_HOST']."/" ?>"/>
    <meta name="description" content="Barber X - O controle de sua Barbearia">
    <meta property="og:title" content="Barber X - O controle de sua Barbearia" />
    <meta property="og:site_name" content="Barber X - O controle de sua Barbearia" />
    <meta property="og:type" content="system" />
    <meta property="og:description" content="Barber X - O controle de sua Barbearia" />
    <meta property="og:url" content="{{$_SERVER['HTTP_HOST']}}" />
    <meta property="og:image" content="{{ asset('img/logo.png') }}" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/styleLogin.css') }}">
    <!-- Styles -->
    <link rel="apple-touch-icon" href="{{ asset('img/icon-logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('img/icon-logo.png') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/materialdesignicons.min.css') }}">
    <!-- Scripts -->
    <script src="{{ asset('assets/js/vendor/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-Y0M2ZHMSM9"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-Y0M2ZHMSM9');
    </script>
</head>
<body>
    @yield('content')
</body>
</html>
