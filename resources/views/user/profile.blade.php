@extends('layouts.app')

@section('page-title', trans('app.my_profile'))

@section('content')

    <div class="row">
    <!-- profile-widget -->
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="profile-widget profile-widget-info">
              <div class="panel-body">
                <div class="row">
                    <div class="col-lg-2 col-sm-4 col-xm-4 follow-avat">
                      <h4>{{$user->first_name.' '.$user->last_name }}</h4>               
                      <div class="follow-ava">
                          <img src="{{$user->present()->avatar}}" alt="avatar">
                      </div>
                      <h6>{{$user->roles->first()->display_name}}</h6>
                    </div>
                    <div class="col-lg-10 col-sm-6 col-xm-8 follow-info">
                        <p><i class="icon_mail_alt"></i> {{$user->email}}</p>
                        @if ($socialNetworks)
                          @if ($socialNetworks->facebook)
                          <p><a href="{{ $socialNetworks->facebook }}" target="_blank" class="white">
                              <i class="fa fa-facebook"></i> Facebook
                          </a></p>
                          @endif
                        @endif
                        <p><a href="{{ route('send.pin') }}" onclick="showLoading();" class="white">
                              <i class="icon_mail_alt"></i> Enviar Pin
                          </a></p>
                         @if ($user->birthday)
                        <p><i class="icon_calendar"></i> {{$user->birthday}}</p>
                        @endif
                         @if ($user->phone)
                        <p><i class="icon_phone"></i> {{$user->phone}}</p>
                        @endif
                    </div>
                </div>
              </div>
        </div>
    </div>
    </div>
    <!-- page start-->
    <div class="row">
     <div class="col-lg-12">
        <section class="panel">
              @if (! Auth::user()->hasRole('user'))
              <header class="panel-heading tab-bg-info">
                  <ul class="nav nav-tabs">               
                      <li class="active">
                          <a data-toggle="tab" href="#edit-profile">
                              @lang('app.edit_user_details')
                          </a>
                      </li>       
                      <li class="">
                          <a data-toggle="tab" href="#authentication">
                              @lang('app.authentication')
                          </a>
                      </li>
                  </ul>
              </header>
              @endif
              <div class="panel-body">
                  <div class="tab-content">
                      <!-- edit-profile -->
                      <div id="edit-profile" class="tab-pane active">
                        <section class="panel">                                          
                              <div class="panel-body bio-graph-info">
                                  <h1>@lang('app.profile_info')</h1>

                                  @if(Session::get('profile'))
                                  <div class="alert alert-warning fade in">
                                      <button data-dismiss="alert" class="close close-sm" type="button">
                                          <i class="fa fa-times-circle"></i>
                                      </button>
                                      @lang('app.profile_fail')
                                  </div>
                                  @endif

                                  {!! Form::open(['route' => ['user.update.details', $user->id], 'method' => 'PUT', 'id' => 'details-form', 'class' => 'form-horizontal']) !!}    
                                      <div class="form-group">
                                          <label class="col-lg-2 col-xm-2 control-label">@lang('app.first_name')</label>
                                          <div class="col-lg-6 col-xm-6">
                                              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="@lang('app.first_name')" value="{{$user->first_name}}">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 col-xm-2 control-label">@lang('app.last_name')</label>
                                          <div class="col-lg-6 col-xm-6">
                                              <input type="text" class="form-control" id="last_name"      name="last_name" placeholder="@lang('app.last_name')" value="{{$user->last_name}}">
                                          </div>
                                      </div>
                                        <div class="form-group @if(Session::get('profile')) has-error @endif">
                                          <label class="col-lg-2 col-xm-2 control-label">@lang('app.email')</label>
                                          <div class="col-lg-6 col-xm-6">
                                              <input type="text" class="form-control" id="email"      name="email" placeholder="@lang('app.email')" value="{{$user->email}}">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 col-xm-2 control-label">@lang('app.date_of_birth')</label>
                                          <div class="col-lg-2 col-xm-2">
                                             <input type='text' name="birthday" id="birthday" value="{{$user->birthday}}" class="form-control" />
                                          </div>
                                      </div>
                                      <div class="form-group @if(Session::get('profile')) has-error @endif">
                                          <label class="col-lg-2 col-xm-2 control-label">@lang('app.phone')</label>
                                          <div class="col-lg-2 col-xm-2">
                                              <input type="text" class="form-control" id="phone" name="phone" placeholder="@lang('app.phone')" value="{{ $user->phone }}">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <div class="col-lg-offset-2 col-lg-10 col-xm-10">
                                              <button type="submit" class="btn btn-success">@lang('app.update')</button>
                                          </div>
                                      </div>
                                   {!! Form::close() !!}
                              </div>
                          </section>
                      </div>
                      @if (! Auth::user()->hasRole('user'))  
                       <!-- authentication -->
                      <div id="authentication" class="tab-pane">
                        <section class="panel">                                          
                              <div class="panel-body bio-graph-info">
                                  <h1>@lang('app.authentication')</h1>

                                    {!! Form::open(['route' => ['user.update.login-details', $user->id], 'method' => 'PUT', 'id' => 'login-details-form', 'class' => 'form-horizontal']) !!} 
                                      <div class="form-group">
                                          <label class="col-lg-2 col-xm-2 control-label">@lang('app.username')</label>
                                          <div class="col-lg-6 col-xm-6">
                                              <input type="text" class="form-control" id="username" placeholder="@lang('app.username')"  name="username" value="{{ $user->username }}">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 col-xm-2 control-label">@lang('app.new_password')</label>
                                          <div class="col-lg-6 col-xm-6">
                                             <input type="password" class="form-control" id="password" name="password" placeholder="@lang('app.leave_blank_if_you_dont_want_to_change')">
                                          </div>
                                      </div>
                                        <div class="form-group">
                                          <label class="col-lg-2 col-xm-2 control-label">@lang('app.confirm_password')</label>
                                          <div class="col-lg-6 col-xm-6">
                                               <input type="password" class="form-control" id="password_confirmation"   name="password_confirmation" placeholder="@lang('app.leave_blank_if_you_dont_want_to_change')">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <div class="col-lg-offset-2 col-lg-10 col-xm-10">
                                              <button type="submit" class="btn btn-success">@lang('app.update')</button>
                                          </div>
                                      </div>
                                   {!! Form::close() !!}
                              </div>
                          </section>
                      </div>
                      @endif
                  </div>
              </div>
          </section>
     </div>
    </div>

    <!-- page end-->
@stop

@section('styles')
    {!! HTML::style('assets/css/bootstrap-datetimepicker.min.css') !!}
@stop

@section('scripts')

{!! HTML::script('vendor/jsvalidation/js/jsvalidation.min.js') !!}

{!! JsValidator::formRequest('App\Http\Requests\User\UpdateProfileDetailsRequest', '#details-form') !!}
{!! JsValidator::formRequest('App\Http\Requests\User\UpdateProfileLoginDetailsRequest', '#login-details-form') !!}
{!! HTML::script('assets/js/bootstrap-datetimepicker.min.js') !!}

<script type="text/javascript">
  if ($('#phone').length) {
      $("#phone").mask('9999-9999', {
          placeholder: 'X'
      });
  }

  if ($('#birthday').length) {
      $('#birthday').datetimepicker({
          viewMode: 'years',
          format: 'DD-MM-YYYY'
      });
  }
</script>
@stop