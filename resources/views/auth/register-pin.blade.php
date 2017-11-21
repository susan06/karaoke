@extends('layouts.auth')

@section('page-title', trans('app.sign_up'))

@section('styles')
<style type="text/css">
.login-img-body{
background: url('{{asset('upload/login/'.Settings::get("background-login"))}}') no-repeat center center fixed;
-webkit-background-size: cover;
-moz-background-size: cover;
-o-background-size: cover;
background-size: cover;
height: auto;
width: 100%;
}
.input-pin {
    width: 21.8%; 
    display: inline-block;  
    margin-right: 9px; 
    padding: 5px 18px;
}
.input-first {
   margin-left: 0px; 
}
.input-last {
   margin-right: 0px; 
}
</style>
@endsection

@section('content')

  {!! Form::open(['class' => 'login-form login-register', 'id' => 'login-form']) !!}    
        <div class="login-wrap">
            <div class="input-group col-md-12 col-xs-12">
              <input type="text" name="first_name" id="first_name" class="form-control" placeholder="@lang('app.first_name')" value="{{ old('first_name') }}">
            </div>
            <div class="input-group col-md-12 col-xs-12">
              <input type="text" name="last_name" id="last_name" class="form-control" placeholder="@lang('app.last_name')" value="{{ old('last_name') }}">
            </div>
            <div class="input-group col-md-12 col-xs-12">
              <input type="text" name="username" id="username" class="form-control" placeholder="@lang('app.username')" value="{{ old('username') }}">
            </div>
            <div class="input-group col-md-12 col-xs-12">
              <input type="text" name="email" id="email" class="form-control" placeholder="@lang('app.email')" value="{{ old('email') }}">
            </div>
            <label class="checkbox">
                <span class="pull-left">Pin de 4 dígitos </span>
            </label>
            <div class="input-group col-md-12">
                <input type="password" name="pin-1" id="pin-1" maxlength="1" data-order="1" class="input-pin input-first">
                <input type="password" name="pin-2" id="pin-2" maxlength="1" data-order="2" class="input-pin">
                <input type="password" name="pin-3" id="pin-3" maxlength="1" data-order="3" class="input-pin">
                <input type="password" name="pin-4" id="pin-4" maxlength="1" data-order="4" class="input-pin input-last">
            </div>
            <div class="input-group col-md-12 col-xs-12">
              <button class="btn btn-primary btn-lg btn-block" type="submit">@lang('app.register')</button>
            </div>
        </div>
  {!! Form::close() !!}

@stop

@section('scripts')
   <script>
        function onlyNumber(order){
            var tecla_final = document.getElementById("pin-"+order).value;
            if(tecla_final >= 1 && tecla_final <= 9) {
                $('#pin-'+order).addClass('input-success');
                var next = order + 1;
                $('#pin-'+next).focus();
                return true;
            }
            document.getElementById("pin-"+order).value = '';
            return false;
        }

        $(document).on('keyup touchend', '.input-pin', function(evt){ 
            var order = $(this).data('order');
            onlyNumber(order);    
        });  

        (function ($, document) {
            $(document).ready(function () {
                $("#login-form").on("submit", function () {
                    var p1 = document.getElementById("pin-1").value;
                    var p2 = document.getElementById("pin-2").value;
                    var p3 = document.getElementById("pin-3").value;
                    var p4 = document.getElementById("pin-4").value;
                    if($('#email').val() && $('#last_name').val() && $('#username').val() && p1.length == 1 && p2.length == 1 && p3.length == 1 && p4.length == 1) {
                        $("#login-form").submit();
                    } 
                });
            });
        })(jQuery, document);

   </script>
@stop