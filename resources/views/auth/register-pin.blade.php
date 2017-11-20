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
    width: 22.2%; 
    display: inline-block;  
    margin-right: 9px; 
    padding: 10px 22px;
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

  {!! Form::open(['class' => 'login-form', 'id' => 'login-form']) !!}    
        <div class="login-wrap">
            <div class="input-group col-md-12">
              <input type="text" name="first_name" id="first_name" class="form-control" placeholder="@lang('app.first_name')" value="{{ old('first_name') }}">
            </div>
            <div class="input-group col-md-12">
              <input type="text" name="last_name" id="last_name" class="form-control" placeholder="@lang('app.last_name')" value="{{ old('last_name') }}">
            </div>
            <div class="input-group col-md-12">
              <input type="text" name="username" id="username" class="form-control" placeholder="@lang('app.username')" value="{{ old('username') }}">
            </div>
            <div class="input-group col-md-12">
              <input type="text" name="email" id="email" class="form-control" placeholder="@lang('app.email')" value="{{ old('email') }}">
            </div>
            <div class="input-group col-md-12">
                <input type="password" name="pin-1" id="pin-1" maxlength="1" onkeypress="return onlyNumber(event, 1);" class="input-pin input-first">
                <input type="password" name="pin-2" id="pin-2" maxlength="1" onkeypress="return onlyNumber(event, 2);" class="input-pin">
                <input type="password" name="pin-3" id="pin-3" maxlength="1" onkeypress="return onlyNumber(event, 3);" class="input-pin">
                <input type="password" name="pin-4" id="pin-4" maxlength="1" onkeypress="return onlyNumber(event, 4);" class="input-pin input-last">
            </div>
            <div class="input-group col-md-12">
              <button class="btn btn-primary btn-lg btn-block" type="submit">@lang('app.register')</button>
            </div>
        </div>
  {!! Form::close() !!}

@stop

@section('scripts')
   <script>
        function onlyNumber(e, order){
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8){
                return true;
            }
            patron =/[0-9]/;
            tecla_final = String.fromCharCode(tecla);
            if(patron.test(tecla_final)) {
                $('#pin-'+order).addClass('input-success');
                var next = order + 1;
                $('#pin-'+next).focus();
                return true;
            }
            $('#pin-'+order).removeClass('input-success');
            return false;
        }

        (function ($, document) {
            $(document).ready(function () {
                $("#login-form").on("submit", function () {
                    if($('#pin-1').val() && 
                      $('#pin-2').val() 
                      && $('#pin-3').val() 
                      && $('#pin-4').val()
                      && $('#email').val()
                      && $('#username').val()
                      && $('#first_name').val()
                      && $('#last_name').val() 
                    ) {
                        $("#login-form").submit();
                    }
                });
            });
        })(jQuery, document);

   </script>
@stop