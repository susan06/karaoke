@extends('layouts.auth')

@section('page-title', trans('app.login'))

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

	{!! Form::open(['class' => 'login-form', 'id' => 'login-form', 'autocomplete' => 'off']) !!}    
        <div class="login-wrap">
            <p class="login-img"><i class="icon_lock_alt blue"></i></p>
            <div class="input-group">
              <span class="input-group-addon"><i class="icon_profile"></i></span>
              <input type="text" name="username" id="username" class="form-control" placeholder="@lang('app.email_or_username')" value="{{ (session('username')) ? session('username') : old('username') }}" autofocus>
            </div>
            <div class="input-group">
                <input type="password" name="pin-1" id="pin-1" maxlength="1" data-order="1" class="input-pin input-first" autocomplete="off">
                <input type="password" name="pin-2" id="pin-2" maxlength="1" disabled="disabled" data-order="2" class="input-pin" autocomplete="off">
                <input type="password" name="pin-3" id="pin-3" maxlength="1" disabled="disabled" data-order="3" class="input-pin" autocomplete="off">
                <input type="password" name="pin-4" id="pin-4" maxlength="1" disabled="disabled" data-order="4" class="input-pin input-last" autocomplete="off">
            </div>
            <label class="checkbox" style="padding-left: 0px;">
                <span class="pull-left"> <a href="{{url('register')}}"> @lang('app.register')</a></span>
                <span class="pull-right"> <a href="{{url('password/remind?pin=1')}}"> @lang('app.i_forgot_my_pin')</a></span>
            </label>
            <input class="btn btn-primary btn-lg btn-block btn-pin-login disabled" type="submit" value="@lang('app.log_in')">
        </div>
	{!! Form::close() !!}

</div>
@stop

@section('scripts')
    <script type="text/javascript">
        function onlyNumber(tecla, order){
            if (tecla==8){
                return true;
            }
            patron =/[1-9]/;
            tecla_final = String.fromCharCode(tecla);
            if(patron.test(tecla_final) && tecla_final >= 1 && tecla_final <= 9) {
                alert(order);
                $('#pin-'+order).addClass('input-success');
                var next = order + 1;
                $('#pin-'+next).prop('disabled', false);
                $('#pin-'+next).focus();
                return true;
            }
            return false;
        }

        $(document).on('keyup touchend', '.input-pin', function(evt){ 
            var keyPressed = evt.which || evt.keyCode;
            var order = $(this).data('order');
            onlyNumber(keyPressed, order);  
            var p1 = document.getElementById("pin-1").value;
            var p2 = document.getElementById("pin-2").value;
            var p3 = document.getElementById("pin-3").value;
            var p4 = document.getElementById("pin-4").value;
            if(p1.length == 1 && p2.length == 1 && p3.length == 1 && p4.length == 1) {
                $(".btn-pin-login").removeClass('disabled');
            } else {
                $(".btn-pin-login").addClass('disabled');
            }  
        });    
    </script>
@stop