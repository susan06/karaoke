@extends('layouts.auth')

@section('page-title', trans('app.two_factor_authentication'))

@section('content')
<div class="center-block">
    <div class="login-block">
    {!! Form::open(['route' =>'auth.token.validate', 'class'=>'orb-form', 'id' => 'login-form']) !!}
        <header>
          <div class="image-block"><img src="{{asset('assets/images/logo.png')}}" alt="{{ settings('app_name') }}" /></div>
          @lang('app.two_factor_authentication')
        </header>
        <fieldset>
         <section>
            <div class="row">
              <label class="label col col-4">@lang('app.token')</label>
              <div class="col col-8 form-group">
                <label class="input"> <i class="icon-append fa fa-lock"></i>
                  <input type="text" name="token" id="token" class="form-control" placeholder="@lang('app.authy_2fa_token')">
                </label>
              </div>
            </div>
          </section>
        </fieldset>
        <footer>
            {!! Form::submit(trans('app.validate'), ['class' => 'btn btn-default', 'id' => 'btn-reset-password']) !!}
        </footer>
      {!! Form::close() !!}
    </div>
    @include('copyrights')
</div>
@stop
