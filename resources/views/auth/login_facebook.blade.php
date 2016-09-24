@extends('layouts.auth')

@section('page-title', trans('app.login'))

@section('class-bg', 'class="login-img-body"')

@section('content')

	{!! Form::open(['class' => 'login-form', 'id' => 'login-form']) !!}     
        <div class="login-wrap">
            <p class="login-img"><i class="social_facebook_circle blue"></i></p>
             <button class="btn btn-primary btn-lg btn-block" type="submit">Sign in with facebook</button>
        </div>
	{!! Form::close() !!}	
</div>
@stop
