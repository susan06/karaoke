@extends('layouts.auth')

@section('page-title', trans('app.reset_password'))

@section('content')
<div class="center-block">
    <div class="login-block">
    {!! Form::open(['class'=>'orb-form']) !!}  
        <header>
          <div class="image-block"><img src="{{asset('assets/images/logo.png')}}" alt="User" /></div>
          @lang('app.forgot_your_password')
          <small><a href="{{url('/')}}">@lang('app.log_in')</a></small>
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
        </fieldset>
        <footer>
            {!! Form::submit(trans('app.reset_password'), ['class' => 'btn btn-default', 'id' => 'btn-submit']) !!}
        </footer>
      {!! Form::close() !!}
    </div>
    @include('copyrights')
</div>
@stop
@section('scripts')
   <script>
    // Login Form Validation
    if ($('#remind-password-form').length) {

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

    }

   </script>
@stop