<!doctype html>
<html lang="en">
<head>
    <!-- @autor susangmedina@gmail.com -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

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

    {!! HTML::style("assets/css/jquery.auto-complete.css") !!}

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
    @if (Auth::user() && Auth::user()->hasRole('dj'))
        <style type="text/css">
            #main-content {
                margin-left: 0px;
            }
        </style>
    @endif
    @if(Request::is('search-songs*')) 
        <style type="text/css">
            #main-content {
                margin-left: 0px;
            }
        </style>
    @endif
    @if(Auth::user() && Agent::isMobile() && Auth::user()->hasRole('user'))
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

    <div class="loader loader-default" id="loading"></div>

    @include('partials.header')

    @if (Auth::user() && !Auth::user()->hasRole('dj'))
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

    @include('partials.sucursales')

    @include('partials.modals')

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

        function onlyNumber(order){
            var tecla_final = document.getElementById("pin-"+order).value;
            if(tecla_final.length == 1 && tecla_final >= 0 && tecla_final <= 9) {
                $('#pin-'+order).addClass('input-success');
                var next = order + 1;
                $('#pin-'+next).prop('disabled', false);
                $('#pin-'+next).focus();
                return true;
            }
            document.getElementById("pin-"+order).value = '';
            return false;
        }

        $(document).on('keyup touchend', '.input-pin', function(evt){ 
            var order = $(this).data('order');
            onlyNumber(order);  
            var username = document.getElementById("username").value;
            var p1 = document.getElementById("pin-1").value;
            var p2 = document.getElementById("pin-2").value;
            var p3 = document.getElementById("pin-3").value;
            var p4 = document.getElementById("pin-4").value;
            if(username.length > 1 && p1.length == 1 && p2.length == 1 && p3.length == 1 && p4.length == 1) {
                $(".btn-pin-login").removeClass('disabled');
            } else {
                $(".btn-pin-login").addClass('disabled');
            }  
        });    
    </script>

    {!! HTML::script('assets/bootstrap/js/bootstrap.min.js') !!}


    @if (Auth::user() && Auth::user()->hasRole('user') && !session('branch_office'))
        <script type="text/javascript">
            $('#modal_branch_offices').modal('show');
        </script>
    @endif

    <script type="text/javascript">
        function change_branch_office(){
            $('#modal_branch_offices').modal('show');
        }
    </script>

    {!! HTML::script('assets/plugins/js-cookie/js.cookie.js') !!}

    <script type="text/javascript">
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
    </script>

    {!! HTML::script('assets/js/sweetalert.min.js') !!}

    {!! HTML::script('assets/js/jquery.auto-complete.min.js') !!}

    <!-- nice scroll -->
    {!! HTML::script('assets/js/jquery.scrollTo.min.js') !!}

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
