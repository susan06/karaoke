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
    padding: 10px 20px;
    text-align: center;
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
                <input type="tel" name="pin-1" id="pin-1" maxlength="1" pattern="[0-9]" data-order="1" class="input-pin input-first" autocomplete="off">
                <input type="tel" name="pin-2" id="pin-2" maxlength="1" pattern="[0-9]" disabled="disabled" data-order="2" class="input-pin" autocomplete="off">
                <input type="tel" name="pin-3" id="pin-3" maxlength="1" pattern="[0-9]" disabled="disabled" data-order="3" class="input-pin" autocomplete="off">
                <input type="tel" name="pin-4" id="pin-4" maxlength="1" pattern="[0-9]" disabled="disabled" data-order="4" class="input-pin input-last" autocomplete="off">
            </div>
            <input class="btn btn-primary btn-lg btn-block btn-pin-login disabled" type="submit" value="@lang('app.log_in')">
            <label class="checkbox" style="padding-left: 0px;">
                <span class="pull-left"> <a href="{{url('register')}}" onclick="showLoading();"> @lang('app.register')</a></span>
                <span class="pull-right"> <a href="{{url('/')}}"> Buscar Canciones</a></span>
                <!--
                <span class="pull-right"> <a href="{{url('login')}}" onclick="showLoading();"> Entrar por Facebook</a></span>
                -->
            </label>
        </div>
	{!! Form::close() !!}

</div>
@stop

@section('scripts')
    <script type="text/javascript">
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