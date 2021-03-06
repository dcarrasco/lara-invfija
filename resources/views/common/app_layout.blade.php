<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('invfija.app_nombre') }}</title>

    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/png" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ asset('img/favicon-152.png') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker3.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/fix_bootstrap.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.jqplot.min.css') }}" />

    <script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/locales/bootstrap-datepicker.es.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.jqplot.min.js') }}"></script>

    <script type="text/javascript">
        var js_base_url = "{{ asset('') }}";
    </script>

    @if (auth()->guest())
    <style type="text/css">body {margin-top: 40px; background-image: url("{{ asset('img/tch-background.jpg') }}"); background-size: cover;}</style>    @endif

</head>


<body>

@if (auth()->check())
    @include('common.app_navbar')
@endif
<div class="container-fluid" id="container">

@include('common.app_menu_modulo')

@include('common.alert')

<!-- ============================== MODULOS APP ============================== -->
@yield('modulo')
<!-- ============================== /MODULOS APP ============================== -->

<footer class="footer my-md-4">
    <div class="text-center text-black-40">
        <small><i class="fa fa-creative-commons"></i> 2013 &ndash; <?= date('Y'); ?></small>
    </div>
</footer>

@if (isset($menuModulo))
    </div> <!-- DIV   class="col-md-10" -->
    </div> <!-- DIV   class="row"    -->
@endif

</div> <!-- DIV principal de la aplicacion   class="container"-->

</body>
</html>
