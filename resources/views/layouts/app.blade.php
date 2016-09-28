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

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->


    @yield('styles')
</head>
<body>

 <!-- container section start -->
  <section id="container">
      <!--header start-->

    @include('partials.header')

    @include('partials.menu')

    <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
                @yield('content')
          </section>
      </section>
    <!--main content end-->                

  </section>
  <!-- container section end -->

    <script language="JavaScript" src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript"></script>

    {!! HTML::script('assets/bootstrap/js/bootstrap.min.js') !!}

    {!! HTML::script('assets/plugins/js-cookie/js.cookie.js') !!}

    <script type="text/javascript">
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
    </script>

    {!! HTML::script('vendor/jsvalidation/js/jsvalidation.min.js') !!}

    {!! HTML::script('assets/js/sweetalert.min.js') !!}

    {!! HTML::script('assets/js/jquery.auto-complete.min.js') !!}

    <!-- nice scroll -->
    {!! HTML::script('assets/js/jquery.scrollTo.min.js') !!}
    {!! HTML::script('assets/js/jquery.nicescroll.js') !!}
    {!! HTML::script('assets/js/scripts.js') !!}

    @include('sweet::alert')

    @yield('scripts')
</body>
</html>
