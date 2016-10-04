@extends('layouts.app')

@section('page-title', trans('app.edit_user'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-user"></i> @lang('app.edit_user')</h3>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                   {{ $user->present()->nameOrEmail }}
                </header>
                <div class="panel-body">
                 {!! Form::open(['route' => ['user.admin.update.details', $user->id], 'method' => 'PUT', 'id' => 'details-form','class'=>'form-horizontal']) !!}
                    <div class="form">
                          <div class="form-group">
                              <label for="cname" class="control-label col-lg-2">@lang('app.role') <span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::select('role', $roles, $user->roles->first()->id,
                                  ['class' => 'form-control', 'id' => 'role']) !!}
                              </div>
                          </div>
                         <div class="form-group">
                              <label for="cname" class="control-label col-lg-2">@lang('app.status') <span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::select('status', $statuses, $user->status,
                        ['class' => 'form-control', 'id' => 'status']) !!}
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

