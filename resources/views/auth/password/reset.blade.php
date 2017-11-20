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
 @if($pin == 0)
  <form role="form" action="{{ url('password/reset') }}" method="POST" id="reset-password-form" class="login-form" autocomplete="off">  
@else 
 <form role="form" action="{{ url('password/reset/client') }}" method="POST" id="reset-password-form" class="login-form" autocomplete="off">
@endif
    {{ csrf_field() }}
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="pin" value="{{ $pin }}">
        <div class="login-wrap">
            <p>@lang('app.reset_your_password')</p>
            <div class="form-group">
              <input type="email" name="email" id="email" class="form-control" placeholder="@lang('app.your_email')" value="{{ old('email') }}">
            </div>
            @if($pin == 0)
            <div class="input-group form-group">
                <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="@lang('app.new_password')">
            </div>
            <div class="input-group form-group">
                <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="@lang('app.confirm_new_password')">
            </div>
            @else 
             <div class="input-group">
                <input type="password" name="pin-1" id="pin-1" maxlength="1" onkeypress="return onlyNumber(event, 1);" class="input-pin input-first" autocomplete="off">
                <input type="password" name="pin-2" id="pin-2" maxlength="1" disabled="disabled" onkeypress="return onlyNumber(event, 2);" class="input-pin" autocomplete="off">
                <input type="password" name="pin-3" id="pin-3" maxlength="1" disabled="disabled" onkeypress="return onlyNumber(event, 3);" class="input-pin" autocomplete="off">
                <input type="password" name="pin-4" id="pin-4" maxlength="1" disabled="disabled" onkeypress="return onlyNumber(event, 4);" class="input-pin input-last" autocomplete="off">
            </div>
            @endif
            <button class="btn btn-primary btn-lg btn-block" type="submit">@lang('app.update_password')</button>
        </div>
  </form>

</div>
@stop

@section('scripts')

    {!! HTML::script('assets/js/jquery.validate.min.js') !!}
   <script>
    @if($pin == 0)
    $(".reset-password-form").validate({
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
    @endif

    var count = 0;
    function onlyNumber(e, order){
        tecla = (document.all) ? e.keyCode : e.which;
        if (tecla==8){
            count = count - 1;
            if(count < 0) {
                count = 0;
            }
            return true;
        }
        patron =/[1-9]/;
        tecla_final = String.fromCharCode(tecla);
        if(patron.test(tecla_final)) {
            count = count + 1;
            if(count == 4) {
                $(".btn-pin-login").removeClass('disabled');
            }
            $('#pin-'+order).addClass('input-success');
            var next = order + 1;
            $('#pin-'+next).prop('disabled', false);
            $('#pin-'+next).focus();
            return true;
        }
        count = count - 1;
        return false;
    }
   </script>
@stop