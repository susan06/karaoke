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
            <label class="pin-text col-md-12 col-xs-12">
                El pin será enviado al correo indicado
            </label>
            <div class="input-group col-md-12 col-xs-12">
              <button class="btn btn-primary btn-lg btn-block" type="submit">@lang('app.register')</button>
            </div>
            <label class="checkbox">
                <span class=""> <a href="{{url('login-pin')}}" onclick="showLoading();">Regresar a Login</a></span>
            </label>
        </div>
  {!! Form::close() !!}

@stop

@section('scripts')
   <script> 
    (function ($, document) {
        $(document).ready(function () {
            $("#login-form").on("submit", function () {
                showLoading();
                if($('#email').val() && $('#last_name').val() && $('#username').val()) {
                    hideLoading();
                    $("#login-form").submit();
                } 
            });
        });
    })(jQuery, document);

   </script>
@stop