@extends('layouts.app')

@section('page-title', trans('app.events'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="icon_genius"></i> 
            @if($edit)
              @lang('app.edit_event')
            @else
              @lang('app.add_event')
            @endif
            </h3>
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
                    @if($edit)
                      {!! Form::model($event, ['route' => ['event.update', $event->id], 'method' => 'PUT', 'id' => 'event-form','class'=>'form-validate form-horizontal']) !!}
                    @else
                      {!! Form::open(['route' => ['event.store'], 'autocomplete' => 'off', 'id' => 'event-form','class'=>'form-validate form-horizontal']) !!}
                    @endif
                    <div class="form">
                          <div class="form-group">
                              <label class="control-label col-lg-2">@lang('app.name') <span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('app.name'), 'required' => 'required' ]) !!}
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-lg-2">@lang('app.description') <span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'placeholder' => trans('app.description'), 'required' => 'required' ]) !!}
                              </div>
                          </div>

                          @if($edit)
                           <div class="form-group">
                              <label class="control-label col-lg-2">Estatus</label>
                              <div class="col-lg-6">
                                   {!! Form::select('status', $status, old('status'), ['class' => 'form-control col-md-7 col-xs-12']) !!}
                              </div>
                          </div>
                          @endif

                          <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-primary" type="submit">
                                @if($edit)
                                  @lang('app.update')
                                @else
                                  @lang('app.create')
                                @endif
                                </button>
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

