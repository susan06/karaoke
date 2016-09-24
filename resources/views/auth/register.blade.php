@extends('layouts.auth')

@section('page-title', trans('app.sign_up'))

@if (settings('registration.captcha.enabled'))
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endif

@section('content')
<div class="center-block">
    <div class="login-block">
    {!! Form::open(['class'=>'orb-form', 'id' => 'registration-form']) !!}  
        <header>
          <div class="image-block"><img src="{{ url('assets/images/logo.png') }}" alt="{{ settings('app_name') }}" /></div>
          @lang('app.registration') 
          <small><a href="{{ url('/') }}">@lang('app.back')</a></small>
        </header>
        <fieldset>
          <section>
            <div class="row">
              <label class="label col col-4">@lang('app.email')</label>
              <div class="col col-8 form-group">
                <label class="input">
                  <input type="email" name="email" id="email" class="form-control" placeholder="@lang('app.email')" value="{{ old('email') }}">
                </label>
              </div>
            </div>
          </section>
           <section>
            <div class="row">
              <label class="label col col-4">@lang('app.username')</label>
              <div class="col col-8 form-group">
                <label class="input">
                  <input type="text" name="username" id="username" class="form-control" placeholder="@lang('app.username')"  value="{{ old('username') }}">
                </label>
              </div>
            </div>
          </section>
          <section>
            <div class="row">
              <label class="label col col-4">@lang('app.password')</label>
              <div class="col col-8 form-group">
                <label class="input">
                   <input type="password" name="password" id="password" class="form-control" placeholder="@lang('app.password')">
                </label>
              </div>
            </div>
          </section>
          <section>
            <div class="row">
              <label class="label col col-4">@lang('app.confirm_password')</label>
              <div class="col col-8 form-group">
                <label class="input">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="@lang('app.confirm_password')">
                </label>
              </div>
            </div>
          </section>
           @if (settings('tos'))
          <section>
            <div class="row">
              <div class="col col-4"></div>
              <div class="col col-8">
                <label class="checkbox">
                   <input type="checkbox" name="tos" id="tos" value="1"/>
                  <i></i>@lang('app.i_accept') <a href="#tos-modal" data-toggle="modal">@lang('app.terms_of_service')</a></label>
              </div>
            </div>
          </section>
          @endif

            {{-- Only display captcha if it is enabled --}}
            @if (settings('registration.captcha.enabled'))
             <section>
                 <div class="row">
                    <div class="col col-12">
                        {!! app('captcha')->display() !!}
                    </div>
                 </div>
            </section>
            @endif
            {{-- end captcha --}}

        </fieldset>
        <footer>
            {!! Form::submit(trans('app.register'), ['class' => 'btn btn-default', 'id' => 'btn-submit']) !!}
        </footer>
      {!! Form::close() !!}
    </div>
    @include('auth.social.buttons')
    @include('copyrights')
</div>

@if (settings('tos'))
    <div class="modal fade" id="tos-modal" tabindex="-1" role="dialog" aria-labelledby="tos-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="@lang('app.terms_of_service')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" id="tos-label">@lang('app.terms_of_service')</h3>
                </div>
                <div class="modal-body">
                    <h4>1. Terms</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Donec quis lacus porttitor, dignissim nibh sit amet, fermentum felis.
                        Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere
                        cubilia Curae; In ultricies consectetur viverra. Nullam velit neque,
                        placerat condimentum tempus tincidunt, placerat eu lectus. Nam molestie
                        porta purus, et pretium risus vehicula in. Cras sem ipsum, varius sagittis
                        rhoncus nec, dictum maximus diam. Duis ac laoreet est. In turpis velit, placerat
                        eget nisi vitae, dignissim tristique nisl. Curabitur sollicitudin, nunc ut
                        viverra interdum, lacus...
                    </p>
                    <h4>2. Use License</h4>
                    <ol type="a">
                        <li>
                            Aenean vehicula erat eu nisi scelerisque, a mattis purus blandit. Curabitur congue
                            ollis nisl malesuada egestas. Lorem ipsum dolor sit amet, consectetur adipiscing elit:
                        </li>
                    </ol>
                    <p>...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.close')</button>
                </div>
            </div>
        </div>
    </div>
@endif

@stop

@section('scripts')
   <script>
    // registration Form Validation
    if ($('#registration-form').length) {

        $("#registration-form").validate({
            // Rules for form validation
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true
                }
            },

            // Messages for form validation
            messages: {
                username: {
                    required: '{{ trans("validation.filled", ["attribute" => trans("validation.attributes.username")]) }}',
                },
                password: {
                    required: '{{ trans("validation.filled", ["attribute" => trans("validation.attributes.password")]) }}'
                }
            },

            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            }
        });

    }

   </script>
@stop