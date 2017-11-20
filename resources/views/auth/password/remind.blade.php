@extends('layouts.auth')

@section('page-title', trans('app.reset_password'))

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

  {!! Form::open(['class' => 'login-form', 'id' => 'remind-password-form']) !!}    
        <input type="hidden" name="pin" value="{{ $pin }}">
        <div class="login-wrap">
            <p>@lang('app.forgot_your_password')</p>
            <div class="form-group">
              <input type="email" name="email" id="email" class="form-control" placeholder="@lang('app.email')" autofocus>
            </div>
            <label class="checkbox">
                <span class="pull-right"> <a href="{{url('panel')}}"> @lang('app.back')</a></span>
            </label>
            <button class="btn btn-primary btn-lg btn-block" type="submit">@lang('app.reset_password')</button>
        </div>
  {!! Form::close() !!}

</div>
@stop

@section('scripts')

{!! HTML::script('assets/js/jquery.validate.min.js') !!}

   <script>
    // Login Form Validation

    $("#remind-password-form").validate({
        // Rules for form validation
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        // Messages for form validation
        messages: {
            email: {
              required: '{{ trans("validation.filled", ["attribute" => trans("validation.attributes.email")]) }}',
            }
        },

        errorPlacement: function (error, element) {
            error.insertAfter(element.parent());
        }
    });

   </script>
@stop
