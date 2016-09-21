<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title') | App</title>

    <meta name="application-name" content="app"/>
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="" />

    {{-- For production, it is recommended to combine following styles into one. --}}
    {!! HTML::style('assets/bootstrap/css/bootstrap.min.css') !!}
    {!! HTML::style('assets/bootstrap/fonts/font-awesome.min.css') !!}
    {!! HTML::style('assets/css/sweetalert.min.css') !!}
    {!! HTML::style('assets/css/bootstrap-social.css') !!}

    @yield('styles')
</head>
<body>

    @yield('content')

    {{-- For production, it is recommended to combine following scripts into one. --}}

    {!! HTML::script('assets/js/jquery-2.1.4.min.js') !!}
    {!! HTML::script('assets/bootstrap/js/bootstrap.min.js') !!}
    {!! HTML::script('assets/plugins/js-cookie/js.cookie.js') !!}
    <script type="text/javascript">
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
    </script>

    {!! HTML::script('assets/js/jsvalidation/jsvalidation.js') !!}

    {!! HTML::script('assets/js/sweetalert.min.js') !!}

    {!! HTML::script('assets/js/delete.handler.js') !!}

    @include('sweet::alert')

    @yield('scripts')
</body>
</html>
