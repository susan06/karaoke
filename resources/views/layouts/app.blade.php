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
    <!--[if !IE]><!-->
    <style>
       /* table-related media query stuff only */
    </style>
    <!--<![endif]-->
    
    @if (Auth::user()->hasRole('dj'))
    <style type="text/css">
        #main-content {
            margin-left: 0px;
        }
    </style>
    @endif
    @if(Agent::isMobile() && Auth::user()->hasRole('user'))
    <style type="text/css">
        #sidebar {
            display: none;
        }
        #sidebar > ul {
            display: none;
        }
        #main-content {
            margin-left: 0px;
        }
    </style>
    @endif
    @yield('styles')
</head>
<body>

 <!-- container section start -->
  <section id="container">
      <!--header start-->

    @include('partials.header')

    @if (!Auth::user()->hasRole('dj'))
    @include('partials.menu')
    @endif

    <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
                @yield('content')
          </section>
      </section>
    <!--main content end-->                

  </section>
  <!-- container section end -->

    {!! HTML::script('assets/js/jquery-1.11.1.min.js') !!}

    {!! HTML::script('assets/js/jquery.js') !!}

    <script type="text/javascript">
        // sidebar menu toggle
        jQuery(function() {
            function responsiveView() {
                var wSize = jQuery(window).width();
                if (wSize <= 768) {
                    jQuery('#container').addClass('sidebar-close');
                    jQuery('#sidebar > ul').hide();
                }

                if (wSize > 768) {
                    jQuery('#container').removeClass('sidebar-close');
                    jQuery('#sidebar > ul').show();
                }
            }
            jQuery(window).on('load', responsiveView);
            jQuery(window).on('resize', responsiveView);
        });
    </script>

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
    <!--{!! HTML::script('assets/js/jquery.nicescroll.js') !!}-->

    <!--Forms--> 
    {!! HTML::script('assets/js/jquery.maskedinput.min.js') !!}

    <!--Moments--> 
    {!! HTML::script('assets/js/moment.min.js') !!}
    
    @include('sweet::alert')

    <!--confirm delete--> 
    {!! HTML::script('assets/js/delete.handler.js') !!}
    
    {!! HTML::script('assets/js/scripts.js') !!}

    @yield('scripts')
</body>
</html>
