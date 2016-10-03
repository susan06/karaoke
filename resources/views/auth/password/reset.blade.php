@extends('layouts.auth')

@section('page-title', trans('app.login'))

@section('styles')
<style type="text/css">
.login-img-body{
background: url('{{asset('upload/login/'.Settings::get("background-admin"))}}') no-repeat center center fixed;
-webkit-background-size: cover;
-moz-background-size: cover;
-o-background-size: cover;
background-size: cover;
}
</style>
@endsection

@section('content')
 
  <form role="form" action="{{ url('password/reset') }}" method="POST" id="reset-password-form" class="login-form" autocomplete="off">  
    {{ csrf_field() }}
    <input type="hidden" name="token" value="{{ $token }}">
        <div class="login-wrap">
            <p>@lang('app.reset_your_password')</p>
            <div class="form-group">
              <input type="email" name="email" id="email" class="form-control" placeholder="@lang('app.your_email')">
            </div>
            <div class="input-group form-group">
                <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="@lang('app.new_password')">
            </div>
            <div class="input-group form-group">
                <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="@lang('app.confirm_new_password')">
            </div>
            <button class="btn btn-primary btn-lg btn-block" type="submit">@lang('app.update_password')</button>
        </div>
  </form>

</div>
@stop

@section('scripts')

{!! HTML::script('assets/js/jquery.validate.min.js') !!}

   <script>
    $("#reset-password-form").validate({
        // Rules for form validation
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6,
            },
            password_confirmation: {
                required: true,
                minlength: 6,
                equalTo: '#password'
            },
        },
        // Messages for form validation
        messages: {
            email: {
              required: '{{ trans("validation.filled", ["attribute" => trans("validation.attributes.email")]) }}',
            },
            password: {
                required: '{{ trans("validation.filled", ["attribute" => trans("validation.attributes.password")]) }}',
            },
            password_confirmation: {
                required: '{{ trans("validation.filled", ["attribute" => trans("validation.attributes.password_confirmation")]) }}',
            }
        },

        errorPlacement: function (error, element) {
            error.insertAfter(element.parent());
        }
    });
   </script>
@stop