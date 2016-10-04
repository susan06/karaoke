<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{Settings::get('app_name')}} | @yield('page-title')</title>

    <!-- Bootstrap CSS -->    
    {!! HTML::style("assets/css/bootstrap.min.css") !!}
     <!-- bootstrap theme -->
    {!! HTML::style("assets/css/bootstrap-theme.css") !!}

     <!--external css-->
    <!-- font icon -->
    {!! HTML::style("assets/css/elegant-icons-style.css") !!}
    {!! HTML::style("assets/css/font-awesome.css") !!}
    <!-- Custom styles -->
    {!! HTML::style("assets/css/style.css") !!}
    <!-- alert style -->
    {!! HTML::style("assets/css/sweetalert.min.css") !!}
    {!! HTML::style("assets/css/style-responsive.css") !!}

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    @yield('styles')

    @yield('header-scripts')
</head>
<body class="login-img-body">

    <div class="container">

        @yield('content')

        <footer id="footer">
            <div class="container">
                <div class="row">
                    <div class="copyrights">
                        <p>@lang('app.copyright') © - App {{ date('Y') }}</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    {!! HTML::script('assets/js/jquery-2.1.4.min.js') !!}

    {!! HTML::script('assets/bootstrap/js/bootstrap.min.js') !!}

    {!! HTML::script('assets/js/sweetalert.min.js') !!}

    @include('sweet::alert')

    @yield('scripts')
</body>
</html>
