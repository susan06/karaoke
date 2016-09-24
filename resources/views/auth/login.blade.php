@extends('layouts.auth')

@section('page-title', trans('app.login'))

@section('class-bg', 'class="login-img2-body"')

@section('content')

	{!! Form::open(['url' => 'panel', 'class' => 'login-form', 'id' => 'login-form']) !!}  
        <input type="hidden" value="{{ Input::get('to') }}" name="to">   
        <div class="login-wrap">
            <p class="login-img"><i class="icon_lock_alt"></i></p>
            <div class="input-group">
              <span class="input-group-addon"><i class="icon_profile"></i></span>
              <input type="text" name="username" id="username" class="form-control" placeholder="@lang('app.email_or_username')" autofocus>
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="@lang('app.password')">
            </div>
            <label class="checkbox">
                <input type="checkbox" name="remember" id="remember" value="1" checked> @lang('app.remember_me')
                <span class="pull-right"> <a href="{{url('password/remind')}}"> @lang('app.i_forgot_my_password')</a></span>
            </label>
            <button class="btn btn-primary btn-lg btn-block" type="submit">@lang('app.log_in')</button>
        </div>
	{!! Form::close() !!}

</div>
@stop
