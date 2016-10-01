<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{Settings::get('app_name')}} | @yield('page-title')</title>

    <meta name="application-name" content="app"/>
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="" />

    <!-- Bootstrap CSS -->    
    {!! HTML::style("assets/css/bootstrap.min.css") !!}
     <!-- bootstrap theme -->
    {!! HTML::style("assets/css/bootstrap-theme.css") !!}

    <!--external css-->
    <!-- font icon -->
    {!! HTML::style("assets/css/elegant-icons-style.css") !!}
    {!! HTML::style("assets/css/font-awesome.css") !!}
    <!-- alert style -->
    {!! HTML::style("assets/css/sweetalert.min.css") !!}
    <!-- Custom styles -->
    {!! HTML::style("assets/css/style.css") !!}
    {!! HTML::style("assets/css/style-responsive.css") !!}

</head>
<body>

    @yield('content')

</body>
</html>
