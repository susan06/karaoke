@extends('layouts.app')

@section('page-title', trans('app.settings'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="icon_cog"></i> @lang('app.settings')</h3>
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
                              <label for="cname" class="control-label col-lg-2">Notificar solicitudes de canciones por email</label>
                              <div class="col-lg-6">
                                  <input type="hidden" name="notification_email_song" value="0">
                                  <input type="checkbox" name="notification_email_song" class="switch" value="1"
                               data-on-text="@lang('app.yes')" data-off-text="@lang('app.no')" {{ settings::get('notification_email_song') ? 'checked' : '' }}>
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="cname" class="control-label col-lg-2">@lang('app.email_request_reservations') <span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::text('email_reservations', Settings::get('email_reservations'), ['class' => 'form-control', 'placeholder' => trans('app.email_request_reservations'), 'required' => 'required' ]) !!}
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="cname" class="control-label col-lg-2">Notificar solicitudes de reservaciones por email</label>
                              <div class="col-lg-6">
                                  <input type="hidden" name="notification_email_reservation" value="0">
                                  <input type="checkbox" name="notification_email_reservation" class="switch" value="1"
                               data-on-text="@lang('app.yes')" data-off-text="@lang('app.no')" {{ settings::get('notification_email_reservation') ? 'checked' : '' }}>
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="cname" class="control-label col-lg-2">Latitud <span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::text('lat', Settings::get('lat'), ['class' => 'form-control', 'placeholder' => 'Latitud', 'required' => 'required' ]) !!}
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="cname" class="control-label col-lg-2">Logintud <span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::text('lng', Settings::get('lng'), ['class' => 'form-control', 'placeholder' => 'Longitud', 'required' => 'required' ]) !!}
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="cname" class="control-label col-lg-2">Activar geolocalización de clientes</label>
                              <div class="col-lg-6">
                                  <input type="hidden" name="geolocation" value="0">
                                  <input type="checkbox" name="geolocation" class="switch" value="1"
                               data-on-text="@lang('app.yes')" data-off-text="@lang('app.no')" {{ settings::get('geolocation') ? 'checked' : '' }}>
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

@section('styles')
    {!! HTML::style('assets/plugins/bootstrap-switch/bootstrap-switch.css') !!}
@stop

@section('scripts')

{!! HTML::script('assets/js/jquery.validate.min.js') !!}
{!! HTML::script('assets/plugins/bootstrap-switch/bootstrap-switch.min.js') !!}

<script type="text/javascript">
$(document).ready(function () {
        $(".switch").bootstrapSwitch({size: 'small'});
 
        $("#settings-form").validate({
            rules: {
                app_name: {
                    required: true
                },
                email_song: {
                    required: true,
                    email: true
                },
                email_reservations: {
                    required: true,
                    email: true
                }
            },
            messages: {                
                app_name: {
                    required: "Campo obligatorio",
                },
                email_song:{
                  required: "Campo obligatorio",
                  email: "Introduzca un email valido"
                },
                email_reservations:{
                  required: "Campo obligatorio",
                  email: "Introduzca un email valido"
                }  
            }
        });
})
</script>
@stop
