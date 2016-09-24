@extends('layouts.auth')

@section('page-title', trans('app.login'))

@section('class-bg', 'class="login-img-body"')

@section('content')

	{!! Form::open(['class' => 'login-form', 'id' => 'login-form']) !!}     
        <div class="login-wrap">
            <p class="login-img"><i class="social_facebook_circle blue"></i></p>
            <a href="{{ url('auth/facebook/login') }}" class="btn btn-primary btn-lg btn-block white">Sign in with facebook</a>
        </div>
	{!! Form::close() !!}	
</div>
@stop
