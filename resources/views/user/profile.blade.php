@extends('layouts.app')

@section('page-title', trans('app.my_profile'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-user"></i> @lang('app.my_profile')</h3>
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="{{route('dashboard')}}">Home</a></li>
                <li><i class="fa fa-user"></i><a href="{{route('profile')}}">  @lang('app.my_profile')</a></li>
                <li><a href="{{ route('user.show', $user->id) }}"><i class="fa fa-user-md"></i> {{ $user->present()->name }}</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
    <!-- profile-widget -->
    <div class="col-lg-12">
        <div class="profile-widget profile-widget-info">
              <div class="panel-body">
                <div class="col-lg-2 col-sm-2">
                  <h4>{{$user->first_name.' '.$user->last_name }}</h4>               
                  <div class="follow-ava">
                      <img src="{{$user->present()->avatar}}" alt="avatar">
                  </div>
                  <h6>{{$user->roles->first()->display_name}}</h6>
                </div>
                <div class="row col-lg-4 col-sm-4 follow-info">
                    <p><i class="icon_mail_alt"></i> {{$user->email}}</p>
                    @if ($socialNetworks && $socialNetworks->facebook)
                    <a href="{{ $socialNetworks->facebook }}">
                        <i class="icon_facebook"></i> Facebook
                    </a>
                    @endif
                    <p><i class="icon_calendar"></i> {{$user->birthday}}</p>
                    <p><i class="icon_phone"></i> {{$user->phone}}</p>
                </div>
              </div>
        </div>
    </div>
    </div>
    <!-- page start-->
    <div class="row">
     <div class="col-lg-12">
        <section class="panel">
              <header class="panel-heading tab-bg-info">
                  <ul class="nav nav-tabs">
                      <li class="active">
                          <a data-toggle="tab" href="#recent-activity">
                              <i class="icon-home"></i>
                             @lang('app.latest_activity')
                          </a>
                      </li>
                      <li class="">
                          <a data-toggle="tab" href="#edit-profile">
                              <i class="icon-envelope"></i>
                              @lang('app.edit_user_details')
                          </a>
                      </li>
                  </ul>
              </header>
              <div class="panel-body">
                  <div class="tab-content">
                      <div id="recent-activity" class="tab-pane active">
                          <div class="profile-activity">   
                              @foreach($userActivities as $activity)                            
                              <div class="act-time">                                      
                                  <div class="activity-body act-in">
                                      <span class="arrow"></span>
                                      <div class="text">
                                          <p class="attribution">{{ $activity->created_at }}</p>
                                          <p>{{ $activity->description }}</p>
                                      </div>
                                  </div>
                              </div>
                              @endforeach
                          </div>
                      </div>
                      <!-- edit-profile -->
                      <div id="edit-profile" class="tab-pane">
                        <section class="panel">                                          
                              <div class="panel-body bio-graph-info">
                                  <h1> Información de perfil</h1>
                                  {!! Form::open(['route' => ['user.update.details', $user->id], 'method' => 'PUT', 'id' => 'details-form', 'class' => 'form-horizontal']) !!}    

                                        @if(Auth::user()->hasRole('admin'))
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">@lang('app.role')</label>
                                            <div class="col-lg-2">
                                            {!! Form::select('role', $roles, $user->roles->first()->id,
                                                ['class' => 'form-control', 'id' => 'role']) !!}
                                            </div>
                                        </div>
                                        @endif
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">@lang('app.first_name')</label>
                                          <div class="col-lg-6">
                                              <input type="text" class="form-control" id="first_name"
                           name="first_name" placeholder="@lang('app.first_name')" value="{{$user->first_name}}">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">@lang('app.last_name')</label>
                                          <div class="col-lg-6">
                                              <input type="text" class="form-control" id="last_name"
                           name="last_name" placeholder="@lang('app.last_name')" value="{{$user->last_name}}">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">@lang('app.date_of_birth')</label>
                                          <div class="col-lg-2">
                                             <input type='text' name="birthday" id='birthday' value="{{$user->birthday}}" class="form-control" />
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">@lang('app.address')</label>
                                          <div class="col-lg-6">
                                              <input type="text" class="form-control" id="address"
                           name="address" placeholder="@lang('app.address')" value="{{ $user->address }}">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">@lang('app.phone')</label>
                                          <div class="col-lg-2">
                                              <input type="text" class="form-control" id="phone"
                           name="phone" placeholder="@lang('app.phone')" value="{{ $user->phone }}">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <div class="col-lg-offset-2 col-lg-10">
                                              <button type="submit" class="btn btn-primary">Actualizar</button>
                                          </div>
                                      </div>
                                   {!! Form::close() !!}
                              </div>
                          </section>
                      </div>
                  </div>
              </div>
          </section>
     </div>
    </div>

    <!-- page end-->
@stop