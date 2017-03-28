@extends('layouts.auth')

@section('page-title', trans('app.login'))

@section('styles')
<style type="text/css">
.login-img-body{
background: url('{{asset('upload/login/'.Settings::get("background-login"))}}') no-repeat;
/*background: url('{{asset('upload/login/'.Settings::get("background-login"))}}') no-repeat center center fixed;*/
-webkit-background-size: cover;
-moz-background-size: cover;
-o-background-size: cover;
background-size: cover;
height: auto;
width: 100%;
}
</style>
@endsection

@section('content')

	{!! Form::open(['class' => 'login-form', 'id' => 'login-form']) !!}  
	<input type="hidden" name="access_token" value="{{ csrf_token() }}">  
        <div class="login-wrap">
            <p class="login-img"><i class="social_facebook_circle blue"></i></p>
            <a href="{{ url('auth/facebook/login') }}" class="btn btn-default btn-lg btn-block">Sign in with facebook</a>
        </div>
	{!! Form::close() !!}	
</div>
@stop
