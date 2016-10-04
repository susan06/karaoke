@extends('layouts.app')

@section('page-title', trans('app.add_user'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-user"></i> @lang('app.add_user')</h3>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                   @lang('app.form')
                </header>
                <div class="panel-body">
                 {!! Form::open(['route' => ['user.store'], 'autocomplete' => 'off', 'id' => 'user-form','class'=>'form-horizontal']) !!}
                    <div class="form">
                          <div class="form-group">
                              <label for="cname" class="control-label col-lg-2">@lang('app.role') <span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::select('role', $roles, old('role'),
                                  ['class' => 'form-control', 'id' => 'role']) !!}
                              </div>
                          </div>
                           <div class="form-group">
                              <label for="cname" class="control-label col-lg-2">@lang('app.password') <span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::password('password', ['class' => 'form-control','placeholder' => trans('app.password')]) !!}
                              </div>
                          </div>
                         <div class="form-group">
                              <label for="cname" class="control-label col-lg-2">@lang('app.password_confirmation') <span class="required">*</span></label>
                              <div class="col-lg-6">
                                 {!! Form::password('password_confirmation', ['class' => 'form-control','placeholder' => trans('app.password_confirmation')]) !!}
                              </div>
                          </div>
                        <div class="form-group">
                              <label for="cname" class="control-label col-lg-2">@lang('app.email') <span class="required">*</span></label>
                              <div class="col-lg-6">
                                {!! Form::text('email', old('email'), ['class' => 'form-control','placeholder' => trans('app.email')]) !!}
                              </div>
                          </div>
                           <div class="form-group">
                              <label for="cname" class="control-label col-lg-2">@lang('app.first_name') <span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::text('first_name', old('first_name'), ['class' => 'form-control','placeholder' => trans('app.first_name')]) !!}
                              </div>
                          </div>
                           <div class="form-group">
                              <label for="cname" class="control-label col-lg-2">@lang('app.last_name') <span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::text('last_name', old('last_name'), ['class' => 'form-control','placeholder' => trans('app.last_name')]) !!}
                              </div>
                          </div>
                         <div class="form-group">
                          <div class="col-lg-offset-2 col-lg-10">
                              <button class="btn btn-primary" type="submit">@lang('app.create_user')</button>
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

@section('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\User\CreateUserRequest', '#user-form') !!}
@stop

