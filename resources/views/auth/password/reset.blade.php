@extends('layouts.auth')

@section('page-title', trans('app.reset_password'))

@section('content')
<div class="center-block">
    <div class="login-block">
    <form role="form" action="{{ url('password/reset') }}" method="POST" id="reset-password-form" class="orb-form" autocomplete="off">  
    {{ csrf_field() }}
    <input type="hidden" name="token" value="{{ $token }}">
        <header>
          <div class="image-block"><img src="{{asset('assets/images/logo.png')}}" alt="User" /></div>
          @lang('app.reset_your_password')
        </header>
        <fieldset>
          <section>
            <div class="row">
              <label class="label col col-4">@lang('app.email')</label>
              <div class="col col-8 form-group">
                <label class="input">
                  <input type="email" name="email" id="email" class="form-control" placeholder="@lang('app.your_email')">
                </label>
              </div>
            </div>
          </section>
           <section>
            <div class="row">
              <label class="label col col-4">@lang('app.new_password')</label>
              <div class="col col-8 form-group">
                <label class="input">
                  <input type="password" name="password" id="password" class="form-control" placeholder="@lang('app.new_password')">
                </label>
              </div>
            </div>
          </section>
          <section>
            <div class="row">
              <label class="label col col-4">@lang('app.confirm_new_password')</label>
              <div class="col col-8 form-group">
                <label class="input">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="@lang('app.confirm_new_password')">
                </label>
              </div>
            </div>
          </section>
        </fieldset>
        <footer>
            <button type="submit" class="btn btn-default" id="btn-reset-password">
                @lang('app.update_password')
            </button>
        </footer>
      </form>
    </div>
    @include('copyrights')
</div>
@stop
@section('scripts')
   <script>
    // Login Form Validation
    if ($('#reset-password-form').length) {

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

    }

   </script>
@stop