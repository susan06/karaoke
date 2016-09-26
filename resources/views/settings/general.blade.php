@extends('layouts.app')

@section('page-title', trans('app.settings'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-list"></i> @lang('app.settings')</h3>
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="{{route('dashboard')}}">Home</a></li>
                <li><i class="fa fa-cogs"></i><a href="{{route('profile.sessions')}}">  @lang('app.settings')</a></li>
                <li><i class="fa fa-bars"></i> @lang('app.general')</li>
            </ol>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                   @lang('app.general_settings')
                </header>
                <div class="panel-body">
                {!! Form::open(['route' => 'settings.update', 'class' => 'form-validate form-horizontal', 'id' => 'settings-form']) !!}
                    <div class="form">
                         <div class="form-group">
                              <label for="cname" class="control-label col-lg-2">@lang('app.name_site') <span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::text('app_name', Settings::get('app_name'), ['class' => 'form-control', 'placeholder' => trans('app.name_site'), 'required' => 'required' ]) !!}
                              </div>
                          </div>
                           <div class="form-group">
                              <label for="cname" class="control-label col-lg-2">@lang('app.email_request_song') <span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::text('email_song', Settings::get('email_song'), ['class' => 'form-control', 'placeholder' => trans('app.email_request_song'), 'required' => 'required' ]) !!}
                              </div>
                          </div>
                           <div class="form-group">
                              <label for="cname" class="control-label col-lg-2">@lang('app.email_request_reservations') <span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::text('email_reservations', Settings::get('email_reservations'), ['class' => 'form-control', 'placeholder' => trans('app.email_request_reservations'), 'required' => 'required' ]) !!}
                              </div>
                          </div>
                         <div class="form-group">
                          <div class="col-lg-offset-2 col-lg-10">
                              <button class="btn btn-primary" type="submit">@lang('app.update')</button>
                          </div>
                        </div>
                    </div>
                 {!! Form::close() !!}
                </div>
            </section>
        </div>
    </div>
  <!-- page end-->
@stop
