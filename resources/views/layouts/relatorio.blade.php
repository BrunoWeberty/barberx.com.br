<?php
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <base href="<?= "https://".$_SERVER['HTTP_HOST']."/" ?>"/>
        <meta name="description" content="MR Barber - O controle de sua Barbearia">
        <meta property="og:title" content="MR Barber - O controle de sua Barbearia" />
        <meta property="og:site_name" content="MR Barber - O controle de sua Barbearia" />
        <meta property="og:type" content="system" />
        <meta property="og:description" content="MR Barber - O controle de sua Barbearia" />
        <meta property="og:url" content="{{$_SERVER['HTTP_HOST']}}" />
        <meta property="og:image" content="{{ asset('img/logo.png') }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Bruno W.">
        <!------------------------>
        <!-- | Begin CSS | -->
        <link rel="apple-touch-icon" href="{{ asset('img/icon-logo.png') }}">
        <link rel="shortcut icon" href="{{ asset('img/icon-logo.png') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/normalize.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/scss/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/materialdesignicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
        <!-- | End CSS | -->
        <!-- | Begin JS  |-->
        <script src="{{ asset('assets/js/vendor/jquery-2.1.4.min.js') }}"></script>
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script> --}}
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script> 
        <link rel="stylesheet" href="{{ asset('/assets/css/dataTables.bootstrap4.css') }}">
        <link rel="stylesheet" href="{{ asset('/assets/css/responsive.bootstrap4.css') }}">
        <script src="{{ asset('/assets/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/assets/js/dataTables.bootstrap4.js') }}"></script>
        <script src="{{ asset('/assets/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('/assets/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
        <!-- | End JS | -->
        <!------------------------>
        <script>
        $(function () {
            $(window).load(function () {
                $('#loader').fadeOut('fast');
            });
        });
        </script>
    </head>
    <body>
        @yield("conteudo")
    </body>
</html>