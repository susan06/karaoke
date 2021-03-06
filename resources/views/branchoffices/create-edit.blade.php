@extends('layouts.app')

@section('page-title', trans('app.branch_offices'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="icon_genius"></i> 
            @if($edit)
              @lang('app.edit_branch_office')
            @else
              @lang('app.add_branch_office')
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
                      {!! Form::model($branch_office, ['route' => ['branch-office.update', $branch_office->id], 'method' => 'PUT', 'id' => 'branch-office-form','class'=>'form-validate form-horizontal']) !!}
                    @else
                      {!! Form::open(['route' => ['branch-office.store'], 'autocomplete' => 'off', 'id' => 'branch-office-form','class'=>'form-validate form-horizontal']) !!}
                    @endif
                    <div class="form">
                          <div class="form-group">
                              <label class="control-label col-lg-2">@lang('app.name') <span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('app.name'), 'required' => 'required' ]) !!}
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-lg-2">@lang('app.email_request_song') <span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::text('email_song', old('email_song'), ['class' => 'form-control', 'placeholder' => trans('app.email_request_song'), 'required' => 'required' ]) !!}
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-lg-2">Notificar solicitudes de canciones por email</label>
                              <div class="col-lg-6">
                                  <input type="hidden" name="notification_email_song" value="0">
                                  <input type="checkbox" name="notification_email_song" class="switch" value="1"
                               data-on-text="@lang('app.yes')" data-off-text="@lang('app.no')" {{ (isset($branch_office->notification_email_song) && $branch_office->notification_email_song == true ) ? 'checked' : '' }}>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-lg-2">@lang('app.email_request_reservations') <span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::text('email_reservations', old('email_reservations'), ['class' => 'form-control', 'placeholder' => trans('app.email_request_reservations'), 'required' => 'required' ]) !!}
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-lg-2">Notificar solicitudes de reservaciones por email</label>
                              <div class="col-lg-6">
                                  <input type="hidden" name="notification_email_reservation" value="0">
                                  <input type="checkbox" name="notification_email_reservation" class="switch" value="1"
                               data-on-text="@lang('app.yes')" data-off-text="@lang('app.no')"  {{ (isset($branch_office->notification_email_reservation) && $branch_office->notification_email_reservation == true ) ? 'checked' : '' }}>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-lg-2">Hora comienzo Reservas<span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::text('reservation_time_min', old('reservation_time_min'), ['class' => 'form-control', 'id' => 'reservation_time_min', 'required' => 'required', 'readOnly' => 'readOnly' ]) !!}
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-lg-2">Hora limite Reservas<span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::text('reservation_time_max', old('reservation_time_max'), ['class' => 'form-control', 'id' => 'reservation_time_max', 'required' => 'required', 'readOnly' => 'readOnly' ]) !!}
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-lg-2">Latitud <span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::text('lat', old('lat'), ['class' => 'form-control', 'placeholder' => 'Latitud', 'required' => 'required' ]) !!}
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-lg-2">Logintud <span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::text('lng', old('lng'), ['class' => 'form-control', 'placeholder' => 'Longitud', 'required' => 'required' ]) !!}
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-lg-2">Radio <span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::text('radio', old('radio'), ['class' => 'form-control', 'placeholder' => 'Radio', 'required' => 'required' ]) !!}
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-lg-2">Activar geolocalización de clientes</label>
                              <div class="col-lg-6">
                                  <input type="hidden" name="geolocation" value="0">
                                  <input type="checkbox" name="geolocation" class="switch" value="1"
                               data-on-text="@lang('app.yes')" data-off-text="@lang('app.no')" {{ (isset($branch_office->geolocation) && $branch_office->geolocation == true ) ? 'checked' : '' }}>
                              </div>
                          </div>

                          @if($edit && $branch_office->id > 1)
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

@section('styles')
    {!! HTML::style('assets/plugins/bootstrap-switch/bootstrap-switch.css') !!}
@stop

@section('scripts')
    
    {!! HTML::script('assets/plugins/bootstrap-switch/bootstrap-switch.min.js') !!}
    {!! HTML::script('vendor/jsvalidation/js/jsvalidation.min.js') !!}
    {!! HTML::script('assets/js/bootstrap-datetimepicker.min.js') !!}
    
    <script type="text/javascript">
      $(document).ready(function () {
        $(".switch").bootstrapSwitch({size: 'small'});
      });

      $('#reservation_time_min').datetimepicker({
        format: 'LT',
        ignoreReadonly: true
      });

      $('#reservation_time_max').datetimepicker({
        format: 'LT',
        ignoreReadonly: true
      });
    </script>
    @if($edit)
      {!! JsValidator::formRequest('App\Http\Requests\BranchOffice\UpdateBranchOffice', '#branch-office-form') !!}
    @else
      {!! JsValidator::formRequest('App\Http\Requests\BranchOffice\CreateBranchOffice', '#branch-office-form') !!}
    @endif
    
@stop

